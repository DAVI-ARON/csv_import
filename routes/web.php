<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::Class, 'index'])->name('user.index');
