<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientCollection;

class ClientController extends Controller {

    //Display a listing of the resource
    public function index() {

        //Utilizando apiResource e ClientCollection
        return new ClientCollection(Client::all());
    }

    //Store a newly created resource in storage
    public function store(Request $request) {
        
        //Utilizando ProductResource
        $client = Client::create($request->validate([
            'name' => 'required|string|max:255',
            'email' => '',
            'phone' => ''
        ]));
        return new ClientResource($client);
    }

    //Display the specified resource
    public function show($id) {
        
        //Utilizando ProductResource
        return new ClientResource(Client::findOrFail($id));
    }

    //Update the specified resource in storage
    public function update(Request $request, $id) {
        
        //Utilizando ClientResource
        $client = Client::findOrFail($id);
        $client->update($request->validate([
            'name' => 'required|string|max:255',
            'email' => '',
            'phone' => ''
        ]));
        return new ClientResource($client);
    }

    //Remove the specified resource from storage
    public function destroy($id) {
        
        //Utilizando ClientResource
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json([
            'message' => 'Cliente removido'
        ]);
    }
}