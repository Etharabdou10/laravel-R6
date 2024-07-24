<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Str;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars=Car::get();
        return view('cars',compact('cars'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add_car');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

     $data=[
           'carTitle'=>$request->carTitle,
           'description'=>$request->description,
           'price'=>$request->price,
           'published'=>isset($request->published),
           
           
     ];


        //
        //  $carTitle="BMW";
        //  $price=12;
        //  $description="test";
        //  $published=true;

        // dd($request);
        Car::create
        ($data
            
        //     [
        //     'carTitle'=> $carTitle,
        //     'price'=> $price,
        //     'description'=> $description,
        //     'published'=> $published

        // ]
    
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
        $car=Car::findOrFail($id);
        return view('edit_car',compact('car'));
        //
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
