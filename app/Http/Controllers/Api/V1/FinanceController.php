<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Http\Resources\FinanceResource;
use App\Http\Resources\FinanceCollection;
use Illuminate\Http\Request;

class FinanceController extends Controller {
    //Display a listing of the resource
    public function index() {

        //Utilizando apiResource e FinanceCollection
        return new FinanceCollection(Finance::all());
    }

    //Store a newly created resource in storage
    public function store(Request $request) {

        //Utilizando FinanceResource
        $finance = Finance::create($request->validate([
            'type' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string|max:255'
        ]));
        return new FinanceResource($finance);
    }

    //Display the specified resource
    public function show($id) {

        //Utilizando FinanceResource
        return new FinanceResource(Finance::findOrFail($id));
    }

    //Update the specified resource in storage
    public function update(Request $request, $id) {

        //Utilizando FinanceResource
        $finance = Finance::findOrFail($id);
        $finance->update($request->validate([
            'type' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string|max:255'
        ]));
        return new FinanceResource($finance);
    }

    //Remove the specified resource from storage
    public function destroy($id) {

        //Utilizando FinanceResource
        $finance = Finance::findOrFail($id);
        $finance->delete();
        return response()->json([
            'message' => 'Finança removida'
        ]);
    }
}