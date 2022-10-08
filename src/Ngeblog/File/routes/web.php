<?php

use Illuminate\Support\Facades\Route;
use Ngeblog\File\Http\Controller\FileController;

Route::get('/files', [FileController::class, 'index'])->name('files.index');
Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('files.destroy');
