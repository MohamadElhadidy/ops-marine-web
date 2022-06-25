<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;


Route::middleware(['auth'])->group(function () {

Route::get('/', function () {return view('reports.live');})->name('/');
Route::get('home', function () {return view('reports.live');})->name('home');
Route::get('/RLive', [ReportController::class, 'live'])->name('RLive');


Route::get('/logout', LogoutController::class);
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');

// Route::get('/', function () {
//     //return view('reports.live');
//    // Redis::set('company', 'Webkul');

//     dd(Redis::get('shit'));
// });
