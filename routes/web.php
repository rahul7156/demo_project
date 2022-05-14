<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/manage-forms', [App\Http\Controllers\FormController::class, 'index'])->name('manage-forms');
Route::get('/create-form', [App\Http\Controllers\FormController::class, 'create'])->name('create-form');
Route::post('/save-form', [App\Http\Controllers\FormController::class, 'save'])->name('save-form');
Route::get('/delete-form/{id}', [App\Http\Controllers\FormController::class, 'delete'])->name('delete-form');

Route::get('/submit-forms-list', [App\Http\Controllers\FormController::class, 'submit_forms_list'])->name('submit-forms-list');
Route::get('/submit-form/{id}', [App\Http\Controllers\FormController::class, 'submit_form'])->name('submit-form');
Route::post('/store-form', [App\Http\Controllers\FormController::class, 'store_form'])->name('store-form');
Route::get('/submitter-form/{id}', [App\Http\Controllers\FormController::class, 'submitter_form'])->name('submitter-form');
Route::get('/answer-form/{id}/{user_id}', [App\Http\Controllers\FormController::class, 'answer_form'])->name('answer-form');

