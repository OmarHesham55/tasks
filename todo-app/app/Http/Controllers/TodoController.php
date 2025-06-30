<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::all();
        return view('todos.index',compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
                'title' => 'required',
                'description' => 'required'
            ]);

            $todo = Todo::create([
                'title' => $request->title,
                'description' => $request->description
            ]);

            if($todo)
            {
                return response()->json(['status' => 'success','message'=>'Todo created successfully','todo'=>$todo]);
            }

            return response()->json(['status' => 'error','message'=>'Todo is failed to create']);

    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        if($todo)
        {
            return response()->json(['status'=>'success','todo'=>$todo]);
        }

        return response()->json(['status'=>'error']);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {

       $request->validate([
           'title' => 'required',
           'description' => 'required'
        ]);

        if($todo)
        {
            $todo['title'] = $request->title;
            $todo['description'] = $request->description;
            $todo->save();
            return response()->json(['status'=>'success','message'=>'updated Successfully','todo'=>$todo]);
        }

        return response()->json(['status' => 'error','message'=>'failed to update']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        if($todo)
        {
            $todo->delete();
            return response()->json(['status'=>'success','message'=>'deleted successfully','todo'=>$todo]);
        }
        return response()->json(['status'=>'error','message'=>'failed to delete']);
    }

    public function toggleCompleted(Todo $todo)
    {
        $todo->is_completed = !$todo->is_completed;
        $todo->save();
        return response()->json(['status'=>'success','message'=>'Todo Completed','todo'=>$todo]);
    }

}
