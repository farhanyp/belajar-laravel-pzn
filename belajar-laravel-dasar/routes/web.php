<?php

use App\Http\Controllers\HelloController;
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

Route::get('/products/{id}', function($productId){
    return "Products: {$productId}" ;
})->name('product.detail');

Route::get('/product/{productId}/items/{itemId}', function($productId, $itemId){
    return "Products: {$productId}, items: {$itemId}" ;
})->name('product.item.detail');

Route::get('/categories/{id}', function($categoryId){
    return "Category: {$categoryId}" ;
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id}', function($userId){
    return "user: {$userId}" ;
})->where('id', '[0-9]+')->name('user.detail');

Route::get('/produk/{id}', function($productId){
    $link = route('product.detail',[
        'id' => $productId
    ]);
    return $link;
});

Route::get('/product-redirect/{id}', function($productId){
    return redirect()->route('product.detail',[
        'id' => $productId
    ]);
});

Route::get('/controller/hello/request', [HelloController::class, 'request']);

Route::get('/controller/hello/{name}', [HelloController::class, 'hello']);

Route::get('/yp', function(){
    return "Farhan Yudha Pratama";
});

Route::redirect('/farhan', '/yp');
