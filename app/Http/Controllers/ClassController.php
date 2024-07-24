<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Classes;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class= Classes::get();
        return view('classes',compact('class'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('add_class');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data=[
            'class_name'=>$request->class_name,
            'capacity'=>$request->capacity,
            'price'=>$request->price,
            'timeFrom'=>$request->timeFrom,
            'timeTo'=>$request->timeTo,
            'is_fulled'=>isset($request->is_fulled),
  
      ];

      Classes::create
      ($data
      
  
  );
      return "data added successfully";
  }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $class=Classes::findOrFail($id);
        return view('edit_class',compact('class'));
        //
    
        // return "hi";
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
