<?php

use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\AuthController;
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
//Authentication
Route::get('/',[AuthController::class, 'checkLoginUser'])->name('users.login');
Route::get('/login',[AuthController::class, 'checkLoginUser'])->name('users.login');
Route::post('/postLogin',[AuthController::class, 'loginUser'])->name('users.checkLogin');

// Admin section
Route::prefix('admin')->middleware(['auth', 'preventBackHistory'])->group(function () {
    Route::get('/',[\App\Http\Controllers\Admin\DasboardController::class, 'index'])->name('admin.dasboard');

    // Manage users
    Route::prefix('users')->group(function(){
        Route::get('/export', [UserController::class, 'export'])->name('users.export');
        Route::post('/import', [UserController::class, 'import'])->name('users.import');
        Route::get('/logout', [AuthController::class, 'logoutUser'])->name('users.logout');
        Route::get('/viewImport', [UserController::class, 'viewImport'])->name('users.viewImport');
    });
    Route::resource('users', UserController::class);

    // Manage teachers
    Route::prefix('teachers')->group(function(){
        Route::get('/export', [TeacherController::class, 'export'])->name('teachers.export');
        Route::post('/import', [TeacherController::class, 'import'])->name('teachers.import');
        Route::get('/viewImport', [TeacherController::class, 'viewImport'])->name('teachers.viewImport');
    });
    Route::resource('teachers', TeacherController::class);

    // Manage students
    Route::prefix('students')->group(function(){
        Route::post('/import',[StudentController::class,'import'])->name('students.import');
        Route::get('/export',[StudentController::class,'export'])->name('students.export');
    });
    Route::resource('students', StudentController::class);

    // Manage groups
    Route::resource('groups', GroupController::class);
    
    // Manage events
    Route::resource('events', EventController::class);

    // Manage calendars
    Route::get('calendars', [CalendarController::class,'index'])->name('systemCalendar');
    Route::delete('deleteCalendarEvent/{id}', [CalendarController::class,'deleteCalendarEvent'])->name('deleteCalendarEvent');
    Route::put('editCalendarEvent/{id}', [CalendarController::class,'editCalendarEvent'])->name('editCalendarEvent');
});

// Teacher section
Route::get('/login-teacher',[AuthController::class, 'checkLoginTeacher'])->name('teachers.login');
Route::post('/postLoginTeacher',[AuthController::class, 'loginTeacher'])->name('teachers.checkLogin');
Route::prefix('teachers')->middleware('auth.teacher')->group(function () {
    Route::get('/',[\App\Http\Controllers\Teacher\DasboardController::class, 'index'])->name('teachers.dasboard');
    Route::get('/profile',[\App\Http\Controllers\Teacher\ProfileController::class, 'index'])->name('teachers.profile.index');
    Route::get('/postProfile',[\App\Http\Controllers\Teacher\ProfileController::class, 'postProfile'])->name('teachers.profile.postProfile');
    Route::get('/logout',[\App\Http\Controllers\Teacher\ProfileController::class, 'logout'])->name('teachers.profile.logout');
    Route::get('/calendar',[\App\Http\Controllers\Teacher\CalendarController::class, 'calendar'])->name('teachers.calendar.index');
    Route::delete('/calendar/{id}',[\App\Http\Controllers\Teacher\CalendarController::class, 'destroy'])->name('teachers.calendar.destroy');
    Route::get('/students',[\App\Http\Controllers\Teacher\StudentController::class, 'index'])->name('teachers.students.index');
    Route::get('/students/{id}',[\App\Http\Controllers\Teacher\StudentController::class, 'show'])->name('teachers.students.show');
    Route::get('/histories',[\App\Http\Controllers\Teacher\HistoryController::class, 'index'])->name('teachers.histories.index');
    Route::get('/histories/{id}',[\App\Http\Controllers\Teacher\HistoryController::class, 'show'])->name('teachers.histories.show');
    Route::resource('tasks', \App\Http\Controllers\Teacher\TaskController::class);
});

// Student section
Route::get('/login-student',[AuthController::class, 'checkLoginStudent'])->name('students.login');
Route::post('/postLoginStudent',[AuthController::class, 'loginStudent'])->name('students.checkLogin');
Route::prefix('students')->middleware(['auth.student','preventBackHistory'])->group(function () {
    Route::get('/',[\App\Http\Controllers\Student\DasboardController::class, 'index'])->name('students.dasboard');
    Route::get('/profile',[\App\Http\Controllers\Student\ProfileController::class, 'index'])->name('students.profile.index');
    Route::get('/postProfile',[\App\Http\Controllers\Student\ProfileController::class, 'postProfile'])->name('students.profile.postProfile');
    Route::get('/logout',[\App\Http\Controllers\Student\ProfileController::class, 'logout'])->name('students.profile.logout');
    Route::get('/calendar',[\App\Http\Controllers\Student\CalendarController::class, 'calendar'])->name('students.calendar.index');
    Route::delete('/calendar/{id}',[\App\Http\Controllers\Student\CalendarController::class, 'destroy'])->name('students.calendar.destroy');
    Route::get('/teachers',[\App\Http\Controllers\Student\TeacherController::class, 'index'])->name('students.teachers.index');
    Route::get('/teachers/{id}',[\App\Http\Controllers\Student\TeacherController::class, 'show'])->name('students.teachers.show');
    Route::get('/histories',[\App\Http\Controllers\Student\HistoryController::class, 'index'])->name('students.histories.index');
    Route::get('/histories/{id}',[\App\Http\Controllers\Student\HistoryController::class, 'show'])->name('students.histories.show');
    Route::get('/logout', [AuthController::class, 'logoutStudent'])->name('students.logout');
});
