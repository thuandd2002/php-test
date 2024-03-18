<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', [MainController::class, 'index']);
Route::post('/form-submit', [MainController::class, 'store']);