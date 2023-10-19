<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home',function(){
    return view('home',[
        "name" => "Farhan Yudha Pratama"
    ]);
});

Route::get('/about',function(){
    return view('about.about',[
        "name" => "Farhan Yudha Pratama"
    ]);
});

Route::get('/product/{id}', function($productId){
    return "Products: {$productId}" ;
});

Route::get('/product/{id}/items/{id}', function($productId, $itemId){
    return "Products: {$productId}, items: {$itemId}" ;
});

Route::get('/categories/{id}', function($categoryId){
    return "Products: {$categoryId}" ;
})->where('id', '[0-9]+');


Route::get('/yp', function(){
    return "Farhan Yudha Pratama";
});

Route::redirect('/farhan', '/yp');
