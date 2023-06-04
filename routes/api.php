<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
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
Route::post('course_by_id_paid', [CourseController::class, 'course_by_id_paid']);
Route::get('my_courses', [CourseController::class, 'my_courses']);
Route::get('latest_courses', [CourseController::class, 'latest_courses']);

Route::post('lesson_by_id', [LessonController::class, 'lesson_by_id']);
Route::post('add_lesson_attachment', [LessonController::class, 'add_lesson_attachment']);

Route::post('replies', [LessonController::class, 'replies']);
Route::post('add_comment', [LessonController::class, 'add_comment']);
Route::post('add_replie', [LessonController::class, 'add_replie']);
Route::post('add_like_comment', [LessonController::class, 'add_like_comment']);
Route::post('add_like_replie', [LessonController::class, 'add_like_replie']);

Route::post('genarate', [CodeController::class, 'genarate']);
Route::post('subscribe', [CodeController::class, 'subscribe']);