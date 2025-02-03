<?php

use App\Models\Contract;
use App\Models\University;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\UniversityController;

Route::get('/', function () {
    return view('welcome');
});

//simple get
Route::get('/users', [UserController::class, 'index']);
Route::get('/groups', [GroupController::class, 'index']);
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/contracts', [ContractController::class, 'index']);
Route::get('/universities', [UniversityController::class, 'index']);