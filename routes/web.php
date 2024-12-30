<?php

use App\Http\Controllers\UsersFormController;
use App\Http\Middleware\CheckStep1RequiredFields;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsersFormController::class, 'index'])->name('index');
Route::get('step1', [UsersFormController::class, 'step1'])->name('step1');
Route::post('step1-data', [UsersFormController::class, 'step1_data'])->name('step1-data');
Route::get('step2', [UsersFormController::class, 'step2'])->name('step2');
Route::post('step2-data', [UsersFormController::class, 'step2_data'])->name('step2-data');
Route::get('form-submitted-successfully', [UsersFormController::class, 'form_submitted_successfully'])->name('form-submitted-successfully');
