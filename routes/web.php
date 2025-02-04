<?php

use App\Models\Contract;
use App\Models\University;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\UniversityController;
use App\Models\Group;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', UserController::class);
Route::resource('groups', GroupController::class);
Route::resource('contracts', ContractController::class);
Route::resource('roles', RoleController::class);
Route::resource('universities', UserController::class);