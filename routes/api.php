<?php

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

Route::get('/photos', [App\Http\Controllers\PhotosController::class, 'getPhotos']);
Route::post('/photos', [App\Http\Controllers\PhotosController::class, 'uploadPhotos']);
Route::get('/photos/{id}', [App\Http\Controllers\PhotosController::class, 'getPhoto']);
Route::post('/photos/{id}/tags', [App\Http\Controllers\TagsController::class, 'createTagForPhoto']);
Route::put('/tags/{id}', [App\Http\Controllers\TagsController::class, 'updateTag']);

