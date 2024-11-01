<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::Class, 'index'])->name('user.index');
Route::post('/users', [UserController::Class, 'import'])->name('user.import');
