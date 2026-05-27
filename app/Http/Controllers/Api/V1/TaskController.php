<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

class TaskController extends Controller {
    
    //Display a listing of the resource
    public function index(Request $request) {

        $query = Task::query();

        if ($request->title) {
            $query->where('title', 'LIKE', "%{$request->title}%");
        }
        if ($request->description) {
            $query->where('description', 'LIKE', "%{$request->description}%");
        }
        if ($request->status) {
            $query->where('status', 'LIKE', "%{$request->status}%");
        }

        return response()->json(
            $query->paginate(4)
        );

        //Utilizando apiResource e ProductCollection
        //return new TaskCollection(Task::all());
    }

    //Store a newly created resource in storage
    public function store(Request $request) {

        //Utilizando TaskResource
        $task = Task::create($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,done'
        ]));
        return new TaskResource($task);
    }

    //Display the specified resource
    public function show($id) {

        //Utilizando TaskResource
        return new TaskResource(Task::findOrFail($id));
    }

    //Update the specified resource in storage
    public function update(Request $request, $id) {

        //Utilizando TaskResource
        $task = Task::findOrFail($id);
        $task->update($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,done'
        ]));
        return new TaskResource($task);
    }

    //Remove the specified resource from storage
    public function destroy($id) {

        //Utilizando TaskResource
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json([
            'message' => 'Tarefa removida'
        ]);
    }
}