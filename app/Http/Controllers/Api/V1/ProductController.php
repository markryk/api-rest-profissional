<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller {
    //Display a listing of the resource
    public function index(Request $request) {
        
        $query = Product::query();

        if ($request->name) {
            $query->where('name', 'LIKE', "%{$request->name}%");
        }
        if ($request->price) {
            $query->where('price', '=', $request->price);
        }
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->stock) {
            $query->where('stock', '=', $request->stock);
        }
        if ($request->min_stock) {
            $query->where('stock', '>=', $request->min_stock);
        }
        if ($request->max_stock) {
            $query->where('stock', '<=', $request->max_stock);
        }

        return response()->json(
            $query->paginate(4)
        );

        //Utilizando apiResource e ProductCollection
        //return new ProductCollection(Product::all());
    }

    //Store a newly created resource in storage
    public function store(Request $request) {

        //Utilizando ProductResource
        $product = Product::create($request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ]));
        return new ProductResource($product);
    }

    //Display the specified resource
    public function show($id) {

        //Utilizando ProductResource
        return new ProductResource(Product::findOrFail($id));
    }

    //Update the specified resource in storage
    public function update(Request $request, $id) {
        
        //Utilizando ProductResource
        $product = Product::findOrFail($id);
        $product->update($request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ]));
        return new ProductResource($product);
    }

    //Remove the specified resource from storage
    public function destroy($id) {

        //Utilizando ProductResource
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message' => 'Produto removido'
        ]);
    }
}