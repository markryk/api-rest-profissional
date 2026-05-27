<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Http\Resources\FinanceResource;
use App\Http\Resources\FinanceCollection;
use Illuminate\Http\Request;

class FinanceController extends Controller {
    //Display a listing of the resource
    public function index(Request $request) {

        $query = Finance::query();

        if ($request->type) {
            $query->where('type', 'LIKE', "%{$request->type}%");
        }
        if ($request->amount) {
            $query->where('amount', '=', $request->amount);
        }
        if ($request->min_amount) {
            $query->where('amount', '>=', $request->min_amount);
        }
        if ($request->max_amount) {
            $query->where('amount', '<=', $request->max_amount);
        }
        if ($request->description) {
            $query->where('description', 'LIKE', "%{$request->description}%");
        }

        return response()->json(
            $query->paginate(4)
        );

        //Utilizando apiResource e FinanceCollection
        //return new FinanceCollection(Finance::all());
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