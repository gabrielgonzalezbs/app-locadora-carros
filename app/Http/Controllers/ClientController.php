<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\UpdateClientRequest;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected $client;

    public function __construct(Client $client)
    {

        $this->client = $client;

    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $client = new ClientRepository($this->client);


        $client->filters($request->all());


        return response()
            ->json(
                $client->getResult(),
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
        $request->validate($this->cliente->rules(), $this->cliente->feedback());

        $cliente = $this->cliente->create($request->all());

        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->cliente->find($id);

        if (empty($cliente)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        return $cliente;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests  $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $client = $this->client->find($id);

        if (empty($client)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        if ($request->method() === 'PATCH') {

            $rules = [];

            // PEGO OS CAMPOS QUE ESTÃO SENDO INSERIDOS
            $inputKeys = array_keys($request->all());

            // PERCORRO O ARRAY DOS CAMPOS INFORMADOS E CRIO UM ARRAY COM AS REGRAS EXISTENTES PARA OS CAMPOS INFORMADOS
            foreach($inputKeys as $key){
                $rules[$key] = $client->rules()[$key];
            }

            $request->validate($rules, $client->feedback());
        } else {
            $request->validate($client->rules(), $client->feedback());
        }

        $client->fill($request->all());

        $client->save();

        return $client;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = $this->client->find($id);

        if (empty($client)) {
            return response()->json(['message' => 'No record found with the given ID'], 404);
        }

        $client->delete();

        return ['message' => 'client deleted with successfully'];
    }
}
