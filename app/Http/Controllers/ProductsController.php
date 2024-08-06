<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Traits\Common;
use Carbon\Traits\Cast;

class ProductsController extends Controller
{    use Common;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products=Products::get();
        // return view('products',compact('products'));
        $products = Products::latest()->take(3)->get();
        return view('products', compact('products'));
    }
     
    public function show(string $id)
    {
        //
        $product = Products::findOrFail($id);
        return view('products', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('add_product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
               
             'title'=>'required|string',
             'shortDescription'=>'required|string|max:1000',
             'price'=>'required|decimal:0,1',
             'image'=> 'required|mimes:png,jpg,jpeg|max:2048',
             
          ]);
          $data['image']=$this->uploadFile($request->image,'assets/images');
          Products::create ($data);
          return redirect()->route('products.index');
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
