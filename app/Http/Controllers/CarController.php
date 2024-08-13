<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Traits\Common;
use Carbon\Traits\Cast;

class CarController extends Controller
{   use Common;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars=Car::get();
        $categories=Category::select('id','category_name')->get();
        return view('cars',compact('cars','categories'));
       

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $categories=Category::select('id','category_name')->get();
        return view('add_car',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
               
          'carTitle'=>'required|string',
           'description'=>'required|string|max:1000',
           'price'=>'required|decimal:0,1',
           'image'=> 'required|mimes:png,jpg,jpeg|max:2048',
           'category_id' => 'required|exists:categories,id',
           
        ]);
        $data['published']=isset($request->published);
        $data['image']=$this->uploadFile($request->image,'assets/images');

        
        // dd($data);
    

        Car::create ($data);
    return redirect()->route('cars.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $car = Car::findOrFail($id);
        return view('car_details', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $car=Car::findOrFail($id);
        $categories=Category::select('id','category_name')->get();
        return view('edit_car',compact('car','categories'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    $data=$request->validate([
               
        'carTitle'=>'required|string',
         'description'=>'required|string|max:1000',
         'price'=>'required|decimal:0,1',
         'image'=> 'sometimes|mimes:png,jpg,jpeg|max:2048',
         'category_id' => 'required|exists:categories,id',
         

      ]);
      $data['published']=isset($request->published);

      if($request->hasFile('image')) {

          $data['image']=$this->uploadFile($request->image,'assets/images');
      }
      Car::where('id',$id)->update($data);
    //   return "data updated successfully";
    
    $categories=Category::select('id','category_name')->get();
    return redirect()->route('cars.index',compact('categories'));
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        Car::where('id',$id)->delete();

        return redirect()->route('cars.index');
    }



    public function showDeleted()
    {
          $cars = Car::onlyTrashed()->get();
          return view('trashedCars',compact('cars'));
    }

    public function restore(string $id)
         {  
            Car::where('id',$id)->restore();

            return redirect()->route('cars.showDeleted');
         }

         public function forceDelete(string $id)
         {
             
            
             Car::where('id',$id)->forceDelete($id);
             return redirect()->route('cars.index');
         }


}
