<?php

namespace App\Http\Controllers;

use App\Models\Automaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AutomakerController extends Controller
{

    protected $automaker;

    public function __construct(Automaker $automaker)
    {

        $this->automaker = $automaker;

    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('attributes')) {

            return response()
                ->json(
                    $this->automaker->selectRaw($request->get('attributes'))->with('carModels')->get(),
                    200
                );

        }

        return response()
            ->json(
                $this->automaker->with('carModels')->get(),
                200
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->automaker->rules(), $this->automaker->feedback());

        $image = $request->file('image');
        $image_urn = $image->store('images', 'public');

        $automaker = $this->automaker->create([
            'name' => $request->name,
            'image' => $image_urn,
        ]);

        return response()->json($automaker, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $automaker = $this->automaker->find($id);

        if (empty($automaker)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        return $automaker;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Automaker  $automaker
     * @return \Illuminate\Http\Response
     */
    public function edit(Automaker $automaker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $automaker = $this->automaker->find($id);

        if (empty($automaker)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        if ($request->method() === 'PATCH') {

            $rules = [];

            // PEGO OS CAMPOS QUE ESTÃO SENDO INSERIDOS
            $inputKeys = array_keys($request->all());

            // PERCORRO O ARRAY DOS CAMPOS INFORMADOS E CRIO UM ARRAY COM AS REGRAS EXISTENTES PARA OS CAMPOS INFORMADOS
            foreach($inputKeys as $key){
                $rules[$key] = $automaker->rules()[$key];
            }

            $request->validate($rules, $automaker->feedback());
        } else {
            $request->validate($automaker->rules(), $automaker->feedback());
        }

        //apago a imagem antiga caso o request contenha uma nova imagem
        if ($request->file('image')) {
            Storage::disk('public')->delete($automaker->image);
        }

        $image = $request->file('image');
        $image_urn = $image->store('images', 'public');

        $automaker->fill($request->all());
        $automaker->image = $image_urn;

        $automaker->save();

        return $automaker;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $automaker = $this->automaker->find($id);

        if (empty($automaker)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        //apago a imagem antiga caso o request contenha uma nova imagem
        if ($automaker->image) {
            Storage::disk('public')->delete($automaker->image);
        }

        $automaker->delete();

        return ['message' => 'Automaker deleted with successfully'];
    }
}
