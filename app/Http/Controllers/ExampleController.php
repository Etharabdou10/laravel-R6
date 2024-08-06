<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    function task3(Request $request){
        $data = $request->input('data');
        return view('task3');
    }

    function uploadForm(){
        return view('upload');

    }
    public function upload(Request $request){
        $file_extension = $request->image->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = 'assets/images';
        $request->image->move($path, $file_name);
        return 'Uploaded';
    }
    function index(){
        return view('index');

    }

}
