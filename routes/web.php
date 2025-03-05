<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAssignmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('download/assignment/{assignment}', [ApiAssignmentController::class, 'downloadPublic'])
    ->name('download.assignment.file')
    ->middleware('signed');
