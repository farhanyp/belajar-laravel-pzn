<?php

use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
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


// Menerima input melalui route parameter
Route::get('/input/hello', [InputController::class, 'hello']);
// Menerima input melalui body
Route::post('/input/hello', [InputController::class, 'hello']);
Route::post('/input/hello/first', [InputController::class, 'helloFirst']);
Route::post('/input/hello/input', [InputController::class, 'helloInput']);
Route::post('/input/hello/array', [InputController::class, 'arrayInput']);
Route::post('/input/type', [InputController::class, 'inputType']);
Route::post('/input/filter/only', [InputController::class, 'filterOnly']);
Route::post('/input/filter/except', [InputController::class, 'filterExcept']);
Route::post('/input/filter/merge', [InputController::class, 'filterMerge']);

Route::post('/file/upload', [FileController::class, 'upload']);

Route::prefix("/response")->group(function (){
    Route::get('/hello', [ResponseController::class, 'response']);
    Route::get('/header', [ResponseController::class, 'header']);
    Route::get('/view', [ResponseController::class, 'responseView']);
    Route::get('/json', [ResponseController::class, 'responseJson']);
    Route::get('/file', [ResponseController::class, 'responseFile']);
    Route::get('/download', [ResponseController::class, 'responseDownload']);
});

Route::controller(CookieController::class)->group(function (){
    Route::get('/cookie/set', 'createCookie');
    Route::get('/cookie/get', 'getCookie');
    Route::get('/cookie/clear', 'clearCookie');
});

Route::get('/redirect/from',[RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to',[RedirectController::class, 'redirectTo']);
Route::get('/redirect/name',[RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}',[RedirectController::class, 'redirectHello'])->name('redirect-hello');
Route::get('/redirect/action',[RedirectController::class, 'redirectAction']);
Route::get('/redirect/laravel',[RedirectController::class, 'redirectAway']);

Route::get('/form',[FormController::class, 'form']);
Route::post('/form',[FormController::class, 'submitForm']);

// Menggunakan Group Middleware
// Route::middleware(['sample:PZN, 401'])->group(function (){
//     Route::get('/middleware/api', function(){
//         return "OK";
//     });

//     Route::get('/middleware/group',function(){
//         return "GROUP";
//     });

// });

Route::get('/middleware/api',function(){
    return "OK";
})->middleware('contoh:Yp, 401');

Route::get('/middleware/group',function(){
    return "GROUP";
})->middleware(['yp']);

Route::get('/yp', function(){
    return "Farhan Yudha Pratama";
});
Route::redirect('/farhan', '/yp');
