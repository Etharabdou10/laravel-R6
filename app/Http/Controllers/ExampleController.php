<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    function task3(Request $request){
        $data = $request->input('data');
        return view('task3');
    }

    
    
    // function data(){

    //     return view('task3');
    // }
    
//     public function store(Request $request, $id) //Adding the query parameter for id passed in Route.
// {
//     $location = new Reservation;
//     $location->name = $request->get('name');
//     $location->type = $request->get('type');
//     $location->location()->associate($id);

//     $location->save();

//     return redirect('/location');
// }

}
