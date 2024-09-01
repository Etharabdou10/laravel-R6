<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ProductsController;
use App\Models\Products;
use phpDocumentor\Reflection\DocBlock\Tags\Example;

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



// Route::prefix('cars')->group(function(){

// })->middleware('verified');




Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 
Route::get('cars', [CarController::class,'index'])->name('cars.index')->middleware('verified');
Route::get('cars/create', [CarController::class,'create'])->name('cars.create');
Route::post('cars', [CarController::class,'store'])->name('cars.store');
Route::get('cars/{id}/edit', [CarController::class,'edit'])->name('cars.edit');
Route::put('cars/{id}/update', [CarController::class,'update'])->name('cars.update');
Route::get('cars/{id}/show', [CarController::class,'show'])->name('cars.show');
Route::get('cars/{id}/delete', [CarController::class,'destroy'])->name('cars.destroy');
Route::get('cars/trashed', [CarController::class,'showDeleted'])->name('cars.showDeleted');
Route::patch('cars/{id}', [CarController::class,'restore'])->name('cars.restore');
Route::delete('cars/{id}', [CarController::class,'forceDelete'])->name('cars.forceDelete');
    });

// Route::get('cars', [CarController::class,'index'])->name('cars.index')->middleware('verified');
// Route::get('cars/create', [CarController::class,'create'])->name('cars.create');
// Route::post('cars', [CarController::class,'store'])->name('cars.store');
// Route::get('cars/{id}/edit', [CarController::class,'edit'])->name('cars.edit');
// Route::put('cars/{id}/update', [CarController::class,'update'])->name('cars.update');
// Route::get('cars/{id}/show', [CarController::class,'show'])->name('cars.show');
// Route::get('cars/{id}/delete', [CarController::class,'destroy'])->name('cars.destroy');
// Route::get('cars/trashed', [CarController::class,'showDeleted'])->name('cars.showDeleted');
// Route::patch('cars/{id}', [CarController::class,'restore'])->name('cars.restore');
// Route::delete('cars/{id}', [CarController::class,'forceDelete'])->name('cars.forceDelete');









Route::get('class_create', [ClassController::class,'create'])->name('class.create');
Route::post('class_store', [ClassController::class,'store'])->name('class.store');
Route::get('classes', [ClassController::class,'index'])->name('classes.index');
Route::get('classes/{id}', [ClassController::class,'edit'])->name('class.edit');
Route::put('classes/{id}', [ClassController::class,'update'])->name('class.update');
Route::get('classes/{id}/show', [ClassController::class,'show'])->name('class.show');
Route::delete('classes/{id}/delete', [ClassController::class,'destroy'])->name('class.destroy');
Route::get('classes_trashed', [ClassController::class,'showDeleted'])->name('class.showDeleted');
Route::patch('classes/{id}', [ClassController::class,'restore'])->name('class.restore');
Route::delete('classes/{id}', [ClassController::class,'forceDelete'])->name('class.forceDelete');


Route::get('uploadForm', [ExampleController::class,'uploadForm']);
Route::post('upload', [ExampleController::class,'upload'])->name('upload');
// Route::fallback(function () {
//         return redirect('/');
//     });

// Route::get('index', [ExampleController::class,'index']);






Route::get('products', [ProductsController::class,'index'])->name('products.index');;
Route::get('products/create', [ProductsController::class,'create'])->name('products.create');
Route::post('products', [ProductsController::class,'store'])->name('products.store');
Route::get('products/{id}/show', [ProductsController::class,'show'])->name('products.show');
Route::get('about', [ProductsController::class,'about']);
Route::get('products/{id}/edit', [ProductsController::class,'edit'])->name('products.edit');
Route::put('products/{id}/update', [ProductsController::class,'update'])->name('products.update');




Route::get('testRel', [ExampleController::class,'test']);



Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('auth/github/redirect', [SocialController::class, 'redirect'])->name('socialLogin');
Route::get('auth/github/callback', [SocialController::class, 'callback']);
