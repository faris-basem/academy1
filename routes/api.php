<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubjectController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout']);
Route::post('forgot',[UserController::class,'forgot']);
Route::post('change_pass',[UserController::class,'chang_pass']);

Route::get('wellcome',[BannerController::class, 'wellcom']);
Route::get('banner', [BannerController::class, 'banner']);
Route::get('privacy', [BannerController::class, 'privacy']);
Route::get('about_us', [BannerController::class, 'about_us']);

Route::get('subjects', [SubjectController::class, 'subjects']);
Route::post('levels', [LevelController::class, 'levels']);
Route::post('get_courses_from_levels', [CourseController::class, 'get_courses_from_levels']);
Route::post('course_by_id', [CourseController::class, 'course_by_id']);
