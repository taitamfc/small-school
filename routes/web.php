<?php

use App\Http\Controllers\StudentController;
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
Route::get('/',[AuthController::class, 'checkLoginUser'])->name('users.login');
Route::post('/checkLoginUser',[AuthController::class, 'loginUser'])->name('users.checkLogin');

Route::get('/loginTeacher',[AuthController::class, 'checkLoginTeacher'])->name('teachers.login');
Route::post('/checkLoginTeacher',[AuthController::class, 'loginTeacher'])->name('teachers.checkLogin');

Route::get('/loginStudent',[AuthController::class, 'checkLoginStudent'])->name('students.login');
Route::post('/checkLoginStudent',[AuthController::class, 'loginStudent'])->name('students.checkLogin');

Route::get('/home',[AuthController::class, 'index'])->name('home');
Route::prefix('/')->middleware(['auth', 'preventBackHistory'])->group(function () {
    Route::prefix('users')->group(function(){
        Route::get('/export', [UserController::class, 'export'])->name('users.export');
        Route::post('/import', [UserController::class, 'import'])->name('users.import');
        Route::get('/logout', [AuthController::class, 'logoutUser'])->name('users.logout');
        Route::get('/viewImport', [UserController::class, 'viewImport'])->name('users.viewImport');
    });
    Route::prefix('students')->group(function(){
        Route::get('/',[StudentController::class,'index'])->name('student.index');
        Route::get('/create',[StudentController::class,'create'])->name('student.create');
        Route::post('/store',[StudentController::class,'store'])->name('student.store');
        Route::post('/import',[StudentController::class,'import'])->name('student.import');
        Route::get('/export',[StudentController::class,'export'])->name('student.export');
        Route::get('/edit/{id}',[StudentController::class,'edit'])->name('student.edit');
        Route::put('/update/{id}',[StudentController::class,'update'])->name('student.update');
        Route::delete('/destroy/{id}',[StudentController::class,'destroy'])->name('student.destroy');
    });
    Route::prefix('teachers')->group(function(){
        Route::get('/export', [TeacherController::class, 'export'])->name('teachers.export');
        Route::post('/import', [TeacherController::class, 'import'])->name('teachers.import');
        Route::get('/viewImport', [TeacherController::class, 'viewImport'])->name('teachers.viewImport');
    });
    Route::resource('users', UserController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('events', EventController::class);
    Route::get('calendar', [CalendarController::class,'index'])->name('systemCalendar');
    Route::delete('deleteCalendarEvent/{id}', [CalendarController::class,'deleteCalendarEvent'])->name('deleteCalendarEvent');
    Route::put('editCalendarEvent/{id}', [CalendarController::class,'editCalendarEvent'])->name('editCalendarEvent');
});
Route::prefix('teacher')->middleware(['auth.teacher', 'preventBackHistory'])->group(function () {
    Route::get('/profile', [TeacherController::class,'profile'])->name('teacher.profile');
    Route::put('/updateProfile/{id}', [TeacherController::class,'updateProfile'])->name('teacher.updateProfile');
    Route::get('calendar', [CalendarController::class,'index'])->name('teacher.calendar');
    Route::get('/logout', [AuthController::class, 'logoutTeacher'])->name('teachers.logout');
});
Route::prefix('student')->middleware(['auth.student', 'preventBackHistory'])->group(function () {
    Route::get('/profile', [StudentController::class,'profile'])->name('student.profile');
    Route::put('/updateProfile/{id}', [StudentController::class,'updateProfile'])->name('student.updateProfile');
    Route::get('calendar', [CalendarController::class,'index'])->name('student.calendar');
    Route::get('/logout', [AuthController::class, 'logoutStudent'])->name('students.logout');
});
