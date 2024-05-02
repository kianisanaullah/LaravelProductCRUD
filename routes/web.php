<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('product', ProductController::class);
Route::resource('staff', StaffController::class);
