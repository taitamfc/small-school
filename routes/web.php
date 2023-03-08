<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/checkLoginUser',[AuthController::class, 'checkLoginUser'])->name('login');
Route::post('/loginUser',[AuthController::class, 'loginUser'])->name('userLogin');

Route::prefix('/')->middleware(['auth', 'preventBackHistory'])->group(function () {
Route::get('/logoutUser', [AuthController::class, 'logoutUser'])->name('logoutUser');
Route::get('/',[AuthController::class, 'index'])->name('home');
Route::get('users/export/', [UserController::class, 'export'])->name('exportUser');
Route::post('users/import/', [UserController::class, 'import'])->name('importUser');
Route::resource('users', UserController::class);
Route::resource('groups', GroupController::class);
Route::get('teachers/export/', [TeacherController::class, 'export'])->name('exportTeacher');
Route::post('teachers/import/', [TeacherController::class, 'import'])->name('importTeacher');
Route::resource('teachers', TeacherController::class);
Route::resource('events', EventController::class);
Route::get('calendar', [CalendarController::class,'index'])->name('systemCalendar');
});

