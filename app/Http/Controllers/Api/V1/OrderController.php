<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
    //Display a listing of the resource
    public function index(Request $request) {

        $query = Order::query();

        /*if ($request->client_id) {
            $query->where('client_id', 'LIKE', "%{$request->client_id}%");
        }*/
        if ($request->total) {
            $query->where('total', '=', $request->total);
        }
        if ($request->min_total) {
            $query->where('total', '>=', $request->min_total);
        }
        if ($request->max_total) {
            $query->where('total', '<=', $request->max_total);
        }

        return response()->json(
            $query->paginate(4)
        );

        //Utilizando apiResource e OrderCollection
        //return new OrderCollection(Order::all());
    }

    //Store a newly created resource in storage
    public function store(Request $request) {

        //Utilizando OrderResource
        $order = Order::create($request->validate([
            'client_id' => 'required|numeric',
            'total' => 'required|numeric'
        ]));
        return new OrderResource($order);
    }

    //Display the specified resource
    public function show($id) {
        
        //Utilizando OrderResource
        return new OrderResource(Order::findOrFail($id));
    }

    //Update the specified resource in storage
    public function update(Request $request, $id) {

        //Utilizando OrderResource
        $order = Order::findOrFail($id);
        $order->update($request->validate([
            'client_id' => 'required|numeric',
            'total' => 'required|numeric'
        ]));
        return new OrderResource($order);
    }

    //Remove the specified resource from storage
    public function destroy($id) {
        
        //Utilizando OrderResource
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json([
            'message' => 'Pedido removido'
        ]);
    }
}