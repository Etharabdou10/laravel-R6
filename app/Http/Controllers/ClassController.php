<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Classes;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

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
        $class = Classes::findOrFail($id);
        return view('class_details', compact('class'));
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
        $data=[
            'class_name'=>$request->class_name,
            'capacity'=>$request->capacity,
            'price'=>$request->price,
            'timeFrom'=>$request->timeFrom,
            'timeTo'=>$request->timeTo,
            'is_fulled'=>isset($request->is_fulled),
        
    
      ];
      Classes::where('id',$id)->update($data);
    //   return "data updated successfully";
    return redirect()->route('classes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Classes::where('id',$id)->delete();

        return redirect()->route('classes.index');
    }
    // public function showDeleted()
    // {
    //       $class = Classes::onlyTrashed()->get();
    //       return view('trashedClass',compact('class'));
    // }


    public function restore(Request $request): RedirectResponse
         {  
         $id = $request->id;
         Classes::where('id', $id)->restore();
         return redirect('class');
         }

}
