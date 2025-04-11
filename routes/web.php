<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiTaskController;
use App\Http\Controllers\Api\ApiAssignmentController;
use App\Http\Controllers\Api\ApiKodeTransaksiController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('download/assignment/{assignment}', [ApiAssignmentController::class, 'downloadPublic'])
    ->name('download.assignment.file')
    ->middleware('signed');

Route::get('download/task/{task}', [ApiTaskController::class, 'downloadPublic'])
    ->name('download.task.file')
    ->middleware('signed');
