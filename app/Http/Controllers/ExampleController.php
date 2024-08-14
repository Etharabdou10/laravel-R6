<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Student;
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
    function test(){
    //    dd(Student::find(1)->phone->phone_number);

    //    dd(Student::find(3)?->phone);
       dd(Car::find(7)?->category);

    }
}
