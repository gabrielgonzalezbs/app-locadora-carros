<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    protected $location;

    public function __construct(Location $location)
    {

        $this->$location = $location;

    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $location = new LocationRepository($this->location);

        $location->filters($request->all());

        return response()
            ->json(
                $location->getResult(),
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
     * @param  \App\Http\Requests request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->location->rules(), $this->location->feedback());

        $location = $this->location->create($request->all());

        return response()->json($location, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = $this->location->find($id);

        if (empty($location)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        return $location;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
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

        $location = $this->location->find($id);

        if (empty($location)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        if ($request->method() === 'PATCH') {

            $rules = [];

            // PEGO OS CAMPOS QUE ESTÃO SENDO INSERIDOS
            $inputKeys = array_keys($request->all());

            // PERCORRO O ARRAY DOS CAMPOS INFORMADOS E CRIO UM ARRAY COM AS REGRAS EXISTENTES PARA OS CAMPOS INFORMADOS
            foreach($inputKeys as $key){
                $rules[$key] = $location->rules()[$key];
            }

            $request->validate($rules, $location->feedback());
        } else {
            $request->validate($location->rules(), $location->feedback());
        }

        $location->fill($request->all());

        $location->save();

        return $location;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = $this->location->find($id);

        if (empty($location)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        $location->delete();

        return ['message' => 'location deleted with successfully'];
    }
}
