<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;

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
    Route::get('subject_levels/{sub}', [SubjectController::class, 'subject_levels']);
    
    Route::get('show_levels', [SubjectController::class, 'show_levels'])->name('show_levels');

    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


Auth::routes();