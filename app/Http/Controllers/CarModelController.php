<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use App\Repositories\CarModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarModelController extends Controller
{

    protected $carModel;

    public function __construct(CarModel $carModel)
    {

        $this->carModel = $carModel;

    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $carModelRepository = new CarModelRepository($this->carModel);

        $carModelRepository->filters($request->all());

        // if ($request->has('attributes')) {
        //     $this->carModel->selectRaw($request->get('attributes'))->with('automaker');
        // }

        // $this->carModel->with('automaker');

        return response()
            ->json(
                $carModelRepository->getResultPaginate(),
                200
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->carModel->rules(), $this->carModel->feedback());

        $image = $request->file('image');
        $image_urn = $image->store('images/carModels', 'public');

        $carModel = $this->carModel->create([
            'name' => $request->name,
            'image' => $image_urn,
            'automaker_id' => $request->automaker_id,
            'number_ports' => $request->number_ports,
            'places' => $request->places,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);

        return response()->json($carModel, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $carModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carModel = $this->carModel->with('automaker')->find($id);

        if (empty($carModel)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        return $carModel;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarModel  $carModel
     * @return \Illuminate\Http\Response
     */
    public function edit(CarModel $carModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carModel = $this->carModel->find($id);

        if (empty($carModel)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        if ($request->method() === 'PATCH') {

            $rules = [];

            // PEGO OS CAMPOS QUE ESTÃO SENDO INSERIDOS
            $inputKeys = array_keys($request->all());

            // PERCORRO O ARRAY DOS CAMPOS INFORMADOS E CRIO UM ARRAY COM AS REGRAS EXISTENTES PARA OS CAMPOS INFORMADOS
            foreach($inputKeys as $key){
                $rules[$key] = $carModel->rules()[$key];
            }

            $request->validate($rules, $carModel->feedback());
        } else {
            $request->validate($carModel->rules(), $carModel->feedback());
        }

        //apago a imagem antiga caso o request contenha uma nova imagem
        if ($request->file('image')) {
            Storage::disk('public')->delete($carModel->image);
        }

        $image = $request->file('image');
        $image_urn = $image->store('images/carModels', 'public');

        $carModel->fill($request->all());
        $carModel->image = $image_urn;
        $carModel->save();

        return $carModel;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $carModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carModel = $this->carModel->find($id);

        if (empty($carModel)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        //apago a imagem antiga caso o request contenha uma nova imagem
        if ($carModel->image) {
            Storage::disk('public')->delete($carModel->image);
        }

        $carModel->delete();

        return ['message' => 'car model deleted with successfully'];
    }
}
