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
        try {
            return Todo::get();
        } catch(\Exception $e) {
            return response(["message" => $e->getMessage()], 400);
        }        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Todo::create($request->all());
            return response(["message" => "Successfully Created"], 200);
        } catch(\Exception $e) {
            return response(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            Todo::findOrFail($id)->fill($request->all())->save();
            return response(["message" => "Successfully Updated"], 200);
        } catch(\Exception $e) {
            return response(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Todo::findOrFail($id)->delete();
            return response(["message" => "Successfully Deleted"], 200);
        } catch(\Exception $e) {
            return response(["message" => $e->getMessage()], 400);
        }
    }
}
