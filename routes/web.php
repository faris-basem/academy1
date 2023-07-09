<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\LessonQuizController;
use App\Http\Controllers\LessonAttachmentController;

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

Route::get('/home', function () {
    return view('home');
});



Route::group(['middleware' => ['auth']], function () {

    Route::get('show_subjects', [SubjectController::class, 'show_subjects'])->name('show_subjects');
    Route::get('get_subjects_data', [SubjectController::class, 'get_subjects_data'])->name('get_subjects_data');
    Route::post('store_subject', [SubjectController::class , 'store_subject' ])->name('store_subject' );
    Route::post('edit_subject',  [SubjectController::class , 'edit_subject'  ])->name('edit_subject'  );
    Route::post('delete_subject',[SubjectController::class , 'delete_subject'])->name('delete_subject');
    
    Route::get('show_levels/{subject_id?}',    [LevelController::class, 'show_levels'])->name('show_levels');
    Route::get('get_levels_data/{subject_id?}',[LevelController::class, 'get_levels_data'])->name('get_levels_data');
    Route::post('store_level',   [LevelController::class , 'store_level' ])->name('store_level' );
    Route::post('edit_level',    [LevelController::class , 'edit_level'  ])->name('edit_level'  );
    Route::post('delete_level',  [LevelController::class , 'delete_level'])->name('delete_level');

    Route::get('show_courses/{level_id?}',    [CourseController::class, 'show_courses'])->name('show_courses');
    Route::get('get_courses_data/{level_id?}',[CourseController::class, 'get_courses_data'])->name('get_courses_data');
    Route::post('store_course',   [CourseController::class , 'store_course' ])->name('store_course' );
    Route::post('edit_course',    [CourseController::class , 'edit_course'  ])->name('edit_course'  );
    Route::post('delete_course',  [CourseController::class , 'delete_course'])->name('delete_course');

    Route::get('show_sections/{course_id?}',    [SectionController::class, 'show_sections'])->name('show_sections');
    Route::get('get_sections_data/{course_id?}',[SectionController::class, 'get_sections_data'])->name('get_sections_data');
    Route::post('store_section',   [SectionController::class , 'store_section' ])->name('store_section' );
    Route::post('edit_section',    [SectionController::class , 'edit_section'  ])->name('edit_section'  );
    Route::post('delete_section',  [SectionController::class , 'delete_section'])->name('delete_section');

    Route::get('show_lessons/{section_id?}',    [LessonController::class, 'show_lessons'])->name('show_lessons');
    Route::get('get_lessons_data/{section_id?}',[LessonController::class, 'get_lessons_data'])->name('get_lessons_data');
    Route::post('store_lesson',   [LessonController::class , 'store_lesson' ])->name('store_lesson' );
    Route::post('edit_lesson',    [LessonController::class , 'edit_lesson'  ])->name('edit_lesson'  );
    Route::post('delete_lesson',  [LessonController::class , 'delete_lesson'])->name('delete_lesson');

    Route::get('show_attachments/{lesson_id?}',    [LessonAttachmentController::class, 'show_attachments'])->name('show_attachments');
    Route::get('get_attachments_data/{lesson_id?}',[LessonAttachmentController::class, 'get_attachments_data'])->name('get_attachments_data');
    Route::post('store_attachment',   [LessonAttachmentController::class , 'store_attachment' ])->name('store_attachment' );
    Route::post('edit_attachment',    [LessonAttachmentController::class , 'edit_attachment'  ])->name('edit_attachment'  );
    Route::post('delete_attachment',  [LessonAttachmentController::class , 'delete_attachment'])->name('delete_attachment');
    
    Route::get('show_quizzes/{lesson_id?}',    [LessonQuizController::class, 'show_quizzes'])->name('show_quizzes');
    Route::get('get_quizzes_data/{lesson_id?}',[LessonQuizController::class, 'get_quizzes_data'])->name('get_quizzes_data');
    Route::post('store_quiz',   [LessonQuizController::class , 'store_quiz' ])->name('store_quiz' );
    Route::post('edit_quiz',    [LessonQuizController::class , 'edit_quiz'  ])->name('edit_quiz'  );
    Route::post('delete_quiz',  [LessonQuizController::class , 'delete_quiz'])->name('delete_quiz');

    Route::get('show_questions/{quiz_id}',    [QuestionController::class, 'show_questions'])->name('show_questions');
    Route::get('get_questions_data/{quiz_id}',[QuestionController::class, 'get_questions_data'])->name('get_questions_data');
    Route::post('store_question/{quiz_id}',   [QuestionController::class , 'store_question' ])->name('store_question' );
    Route::post('edit_question',    [QuestionController::class , 'edit_question'  ])->name('edit_question'  );
    Route::post('delete_question',  [QuestionController::class , 'delete_question'])->name('delete_question');
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


Auth::routes();