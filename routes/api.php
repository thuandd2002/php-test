<?php

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/get/data', [MainController::class, 'getData']);
Route::get('/get/data/dish', [MainController::class, 'getDataDish']);
Route::get('/get/data/review', [MainController::class, 'getDataReview']);