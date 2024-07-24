<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClassController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('e', function () {
    return "Hi athora";
});

// Route::get('car/{id?}', function ($id=0) {
//     return "id is : ". $id;
// })->where([
//     'id' => '[0-9]+'
// ])
// ;

Route::get('car/{id?}', function ($id=0) {
    return "id is : ". $id;
})->whereNumber('id');

// Route::get('user/{name}/{age}', function ($name,$age) {
//     return "Name is  ". $name . "     and age is ". $age;
// })->whereAlpha('name')->whereNumber('age');

Route::get('user/{name}/{age}', function ($name,$age) {
    return "Name is  ". $name . "     and age is ". $age;
})->where([
'name'=>'[a-zA-Z]+',
'age'=>'[0-9]+'
]);

// Route::get('task3', [ExampleController::class,'task3']);

// Route::post('data', function () {
//     return 'data inserted sucesseful';
//     // return route('data');
// })->name('data');

Route::post('task3', 'ExampleController@task3')->name('data.name');



Route::get('link', function () {
    $url=route('w');
    return "<a href='$url'>go to welcome</a>";
});

Route::get('welcome', function () {
    return 'welcome to laravel';
})->name('w');


Route::get('cars', [CarController::class,'index'])->name('cars.index');
Route::get('cars/create', [CarController::class,'create'])->name('cars.create');
Route::post('cars', [CarController::class,'store'])->name('cars.store');
Route::get('cars/{id}/edit', [CarController::class,'edit'])->name('cars.edit');
Route::put('cars/{id}', [CarController::class,'update'])->name('cars.update');
Route::get('cars/{id}/show', [CarController::class,'show'])->name('cars.show');
Route::get('cars/{id}/delete', [CarController::class,'destroy'])->name('cars.destroy');
Route::get('cars/trashed', [CarController::class,'showDeleted'])->name('cars.showDeleted');







Route::get('class_create', [ClassController::class,'create'])->name('class.create');
Route::post('class_store', [ClassController::class,'store'])->name('class.store');
Route::get('classes', [ClassController::class,'index'])->name('classes.index');
Route::get('classes/{id}', [ClassController::class,'edit'])->name('class.edit');




// Route::fallback(function () {
//         return redirect('/');
//     });
