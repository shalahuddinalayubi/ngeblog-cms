<?php

use Illuminate\Support\Facades\Route;
use Ngeblog\File\Http\Controller\Api\FileController;

Route::post('/files', [FileController::class, 'store'])->name('api.files.store');
Route::get('/files', [FileController::class, 'index'])->name('api.files.index');
