<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout']);
Route::post('forgot',[UserController::class,'forgot']);
Route::post('change_pass',[UserController::class,'chang_pass']);
