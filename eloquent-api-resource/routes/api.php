<?php

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryCollectionWithNested;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories-custom', function () {
    $category = Category::all();
    return new CategoryCollection($category);
});

Route::get('/categories', function () {
    $category = Category::all();
    return CategoryResource::collection($category);
});

Route::get('/categories/{id}', function ($id) {
    $category = Category::query()->findOrFail($id);
    return new CategoryResource($category);
});

Route::get('/categories-nested', function () {
    $category = Category::all();
    return new CategoryCollectionWithNested($category);
});

Route::get('/products/{id}', function ($id) {
    $category = Product::find($id);
    return new ProductResource($category);
});
