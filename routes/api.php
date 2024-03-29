<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\Parent1Controller;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout']);
Route::post('forgot',[UserController::class,'forgot']);
Route::post('change_pass',[UserController::class,'chang_pass']);
Route::post('verify',[UserController::class,'verify']);
Route::post('change_pfp',[UserController::class,'change_pfp']);

Route::post('parent_login',[Parent1Controller::class,'parent_login']);
Route::post('parent_logout',[Parent1Controller::class,'parent_logout']);

Route::get('wellcome',[BannerController::class, 'wellcom']);
Route::get('banner', [BannerController::class, 'banner']);
Route::get('privacy', [BannerController::class, 'privacy']);
Route::get('about_us', [BannerController::class, 'about_us']);

Route::get('subjects', [SubjectController::class, 'subjects']);

Route::post('levels', [LevelController::class, 'levels']);

Route::post('get_courses_from_levels', [CourseController::class, 'get_courses_from_levels']);
Route::post('course_by_id', [CourseController::class, 'course_by_id']);
Route::get('my_courses', [CourseController::class, 'my_courses']);
Route::get('latest_courses', [CourseController::class, 'latest_courses']);
Route::post('leaderboard', [CourseController::class, 'leaderboard']);

Route::get('my_group', [StudentController::class, 'my_group']);
Route::get('my_exams', [StudentController::class, 'my_exams']);
Route::get('my_lectures', [StudentController::class, 'my_lectures']);
Route::get('installments', [StudentController::class, 'installments']);
Route::get('std_performance', [StudentController::class, 'std_performance']);

Route::post('section_by_id', [SectionController::class, 'section_by_id']);

Route::get('articles', [BannerController::class, 'articles']);
Route::post('article_by_id', [BannerController::class, 'article_by_id']);

Route::get('videoes_may_you_like', [BannerController::class, 'videoes_may_you_like']);

Route::post('lesson_by_id', [LessonController::class, 'lesson_by_id']);
Route::post('add_lesson_attachment', [LessonController::class, 'add_lesson_attachment']);

Route::post('quiz_details', [QuizController::class, 'quiz_details']);
Route::post('start_quiz', [QuizController::class, 'start_quiz']);
Route::post('end_quiz', [QuizController::class, 'end_quiz']);

Route::post('replies', [CommentController::class, 'replies']);
Route::post('add_comment', [CommentController::class, 'add_comment']);
Route::post('add_replie', [CommentController::class, 'add_replie']);
Route::post('add_like_comment', [CommentController::class, 'add_like_comment']);
Route::post('add_like_replie', [CommentController::class, 'add_like_replie']);

Route::post('genarate', [CodeController::class, 'genarate']);
Route::post('subscribe', [CodeController::class, 'subscribe']);