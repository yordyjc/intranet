<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    phpinfo();
    return view('welcome');
});
Route::get('user', [App\Http\Controllers\admin\ConfigController::class, 'index']);
