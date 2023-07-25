<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
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

    Route::get('show_students', [StudentController::class, 'show_students'])->name('show_students')->middleware('permission:عرض المواد');
    Route::get('get_students_data', [StudentController::class, 'get_students_data'])->name('get_students_data')->middleware('permission:عرض المواد');
    Route::post('delete_student',[StudentController::class , 'delete_student'])->name('delete_student')->middleware('permission:حذف المواد');
    Route::get('student_courses/{user_id}', [StudentController::class, 'student_courses'])->name('student_courses')->middleware('permission:عرض المواد');
    Route::get('student_courses_data/{user_id}',[StudentController::class, 'student_courses_data'])->name('student_courses_data')->middleware('permission:عرض المراحل');

    Route::get('show_subjects', [SubjectController::class, 'show_subjects'])->name('show_subjects')->middleware('permission:عرض المواد');
    Route::get('get_subjects_data', [SubjectController::class, 'get_subjects_data'])->name('get_subjects_data')->middleware('permission:عرض المواد');
    Route::post('store_subject', [SubjectController::class , 'store_subject' ])->name('store_subject' )->middleware('permission:اضافة المواد');
    Route::post('edit_subject',  [SubjectController::class , 'edit_subject'  ])->name('edit_subject'  )->middleware('permission:تعديل المواد');
    Route::post('delete_subject',[SubjectController::class , 'delete_subject'])->name('delete_subject')->middleware('permission:حذف المواد');
    
    Route::get('show_levels/{subject_id?}',    [LevelController::class, 'show_levels'])->name('show_levels')->middleware('permission:عرض المراحل');
    Route::get('get_levels_data/{subject_id?}',[LevelController::class, 'get_levels_data'])->name('get_levels_data')->middleware('permission:عرض المراحل');
    Route::post('store_level',   [LevelController::class , 'store_level' ])->name('store_level' )->middleware('permission:اضافة المراحل');
    Route::post('edit_level',    [LevelController::class , 'edit_level'  ])->name('edit_level'  )->middleware('permission:تعديل المراحل');
    Route::post('delete_level',  [LevelController::class , 'delete_level'])->name('delete_level')->middleware('permission:حذف المراحل');

    Route::get('show_courses/{level_id?}',    [CourseController::class, 'show_courses'])->name('show_courses')->middleware('permission:عرض الدورات');
    Route::get('get_courses_data/{level_id?}',[CourseController::class, 'get_courses_data'])->name('get_courses_data')->middleware('permission:عرض الدورات');
    Route::post('store_course',   [CourseController::class , 'store_course' ])->name('store_course' )->middleware('permission:اضافة الدورات');
    Route::post('edit_course',    [CourseController::class , 'edit_course'  ])->name('edit_course'  )->middleware('permission:تعديل الدورات');
    Route::post('delete_course',  [CourseController::class , 'delete_course'])->name('delete_course')->middleware('permission:حذف الدورات');

    Route::get('show_sections/{course_id?}',    [SectionController::class, 'show_sections'])->name('show_sections')->middleware('permission:عرض الاقسام');
    Route::get('get_sections_data/{course_id?}',[SectionController::class, 'get_sections_data'])->name('get_sections_data')->middleware('permission:عرض الاقسام');
    Route::post('store_section',   [SectionController::class , 'store_section' ])->name('store_section' )->middleware('permission:اضافة الاقسام');
    Route::post('edit_section',    [SectionController::class , 'edit_section'  ])->name('edit_section'  )->middleware('permission:تعديل الاقسام');
    Route::post('delete_section',  [SectionController::class , 'delete_section'])->name('delete_section')->middleware('permission:حذف الاقسام');

    Route::get('show_lessons/{section_id?}',    [LessonController::class, 'show_lessons'])->name('show_lessons')->middleware('permission:عرض الدروس');
    Route::get('get_lessons_data/{section_id?}',[LessonController::class, 'get_lessons_data'])->name('get_lessons_data')->middleware('permission:عرض الدروس');
    Route::post('store_lesson',   [LessonController::class , 'store_lesson' ])->name('store_lesson' )->middleware('permission:اضافة الدروس');
    Route::post('edit_lesson',    [LessonController::class , 'edit_lesson'  ])->name('edit_lesson'  )->middleware('permission:تعديل الدروس');
    Route::post('delete_lesson',  [LessonController::class , 'delete_lesson'])->name('delete_lesson')->middleware('permission:حذف الدروس');

    Route::get('show_attachments/{lesson_id?}',    [LessonAttachmentController::class, 'show_attachments'])->name('show_attachments')->middleware('permission:عرض المرفقات');
    Route::get('get_attachments_data/{lesson_id?}',[LessonAttachmentController::class, 'get_attachments_data'])->name('get_attachments_data')->middleware('permission:عرض المرفقات');
    Route::post('store_attachment',   [LessonAttachmentController::class , 'store_attachment' ])->name('store_attachment' )->middleware('permission:اضافة المرفقات');
    Route::post('edit_attachment',    [LessonAttachmentController::class , 'edit_attachment'  ])->name('edit_attachment'  )->middleware('permission:تعديل المرفقات');
    Route::post('delete_attachment',  [LessonAttachmentController::class , 'delete_attachment'])->name('delete_attachment')->middleware('permission:حذف المرفقات');
    
    Route::get('show_quizzes/{lesson_id?}',    [LessonQuizController::class, 'show_quizzes'])->name('show_quizzes')->middleware('permission:عرض الاختبارات');
    Route::get('get_quizzes_data/{lesson_id?}',[LessonQuizController::class, 'get_quizzes_data'])->name('get_quizzes_data')->middleware('permission:عرض الاختبارات');
    Route::post('store_quiz',   [LessonQuizController::class , 'store_quiz' ])->name('store_quiz' )->middleware('permission:اضافة الاختبارات');
    Route::post('edit_quiz',    [LessonQuizController::class , 'edit_quiz'  ])->name('edit_quiz'  )->middleware('permission:تعديل الاختبارات');
    Route::post('delete_quiz',  [LessonQuizController::class , 'delete_quiz'])->name('delete_quiz')->middleware('permission:حذف الاختبارات');

    Route::get('show_questions/{quiz_id}',    [QuestionController::class, 'show_questions'])->name('show_questions')->middleware('permission:عرض اسئلة الاختبارات');
    Route::get('get_questions_data/{quiz_id}',[QuestionController::class, 'get_questions_data'])->name('get_questions_data')->middleware('permission:عرض اسئلة الاختبارات');
    Route::post('store_question/{quiz_id}',   [QuestionController::class , 'store_question' ])->name('store_question' )->middleware('permission:اضافة اسئلة الاختبارات');
    Route::post('edit_question',    [QuestionController::class , 'edit_question'  ])->name('edit_question'  )->middleware('permission:تعديل اسئلة الاختبارات');
    Route::post('delete_question',  [QuestionController::class , 'delete_question'])->name('delete_question')->middleware('permission:حذف اسئلة الاختبارات');

    Route::get('show_answers/{question_id}',    [AnswerController::class, 'show_answers'])->name('show_answers')->middleware('permission:عرض اجابات الاسئلة');
    Route::get('get_answers_data/{question_id}',[AnswerController::class, 'get_answers_data'])->name('get_answers_data')->middleware('permission:عرض اجابات الاسئلة');
    Route::post('store_answer/{question_id}',   [AnswerController::class , 'store_answer' ])->name('store_answer' )->middleware('permission:اضافة اجابات الاسئلة');
    Route::post('edit_answer',    [AnswerController::class , 'edit_answer'  ])->name('edit_answer'  )->middleware('permission:تعديل اجابات الاسئلة');
    Route::post('delete_answer',  [AnswerController::class , 'delete_answer'])->name('delete_answer')->middleware('permission:حذف اجابات الاسئلة');

    Route::get('show_users',    [AdminController::class, 'show_users'])->name('show_users')->middleware('permission:عرض المساعدين');
    Route::get('add_user',   [AdminController::class , 'add_user' ])->name('add_user' )->middleware('permission:اضافة المساعدين');
    Route::post('store_user',   [AdminController::class , 'store_user' ])->name('store_user' )->middleware('permission:اضافة المساعدين');
    Route::get('edit_user/{id}',    [AdminController::class , 'edit_user'  ])->name('edit_user'  )->middleware('permission:تعديل المساعدين');
    Route::post('update_user',    [AdminController::class , 'update'  ])->name('update_user'  )->middleware('permission:تعديل المساعدين');
    Route::post('delete_user',  [AdminController::class , 'delete_user'])->name('delete_user')->middleware('permission:حذف المساعدين');

    Route::get('show_roles',    [RoleController::class, 'show_roles'])->name('show_roles')->middleware('permission:عرض الصلاحيات');
    Route::get('show/{id}',    [RoleController::class, 'show'])->name('show')->middleware('permission:عرض الصلاحيات');
    Route::get('add_role',   [RoleController::class , 'add_role' ])->name('add_role' )->middleware('permission:اضافة الصلاحيات');
    Route::post('store_role',   [RoleController::class , 'store_role' ])->name('store_role' )->middleware('permission:اضافة الصلاحيات');
    Route::get('edit_role/{id}',    [RoleController::class , 'edit_role'  ])->name('edit_role'  )->middleware('permission:تعديل الصلاحيات');
    Route::post('update_role',    [RoleController::class , 'update_role'  ])->name('update_role'  )->middleware('permission:تعديل الصلاحيات');
    Route::post('delete_role/{id}',  [RoleController::class , 'delete_role'])->name('delete_role')->middleware('permission:حذف الصلاحيات');
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


Auth::routes();