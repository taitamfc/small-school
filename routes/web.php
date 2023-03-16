<?php

use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\TaskController;
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
    Route::get('/',[\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

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
        Route::get('/dataTable',[StudentController::class,'dataTable'])->name('students.dataTable');
        Route::post('/import',[StudentController::class,'import'])->name('students.import');
        Route::get('/export',[StudentController::class,'export'])->name('students.export');
        Route::get('/viewImport', [StudentController::class, 'viewImport'])->name('students.viewImport');
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

    // Manage tasks
    Route::resource('tasks', TaskController::class);

    // Manage rooms
    Route::resource('rooms', RoomController::class);

});

// Teacher section
Route::get('/login-teacher',[\App\Http\Controllers\Teacher\ProfileController::class, 'login'])->name('teachers.login');
Route::post('/post-login-teacher',[\App\Http\Controllers\Teacher\ProfileController::class, 'postLogin'])->name('teachers.checkLogin');
Route::prefix('teachers')->middleware('auth.teacher')->group(function () {
    Route::get('/',[\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('teachers.dashboard');
    Route::get('/profile',[\App\Http\Controllers\Teacher\ProfileController::class, 'index'])->name('teachers.profile');
    Route::put('/postProfile',[\App\Http\Controllers\Teacher\ProfileController::class, 'postProfile'])->name('teachers.postProfile');
    Route::get('/logout',[\App\Http\Controllers\Teacher\ProfileController::class, 'logout'])->name('teachers.logout');
    
    Route::get('/events/calendar',[\App\Http\Controllers\Teacher\EventController::class, 'calendar'])->name('teachers.events.calendar');
    Route::get('/events/histories',[\App\Http\Controllers\Teacher\EventController::class, 'histories'])->name('teachers.events.histories');
    Route::get('/events/salary',[\App\Http\Controllers\Teacher\EventController::class, 'salary'])->name('teachers.events.salary');
    Route::get('/events/{id}',[\App\Http\Controllers\Teacher\EventController::class, 'show'])->name('teachers.events.show');
    Route::put('/events/{id}',[\App\Http\Controllers\Teacher\EventController::class, 'update'])->name('teachers.events.update');
    Route::get('/events',[\App\Http\Controllers\Teacher\EventController::class, 'index'])->name('teachers.events.index');
    
    
    Route::get('/students',[\App\Http\Controllers\Teacher\StudentController::class, 'index'])->name('teachers.students.index');
    Route::get('/students/{id}',[\App\Http\Controllers\Teacher\StudentController::class, 'show'])->name('teachers.students.show');
    
    Route::get('/histories',[\App\Http\Controllers\Teacher\HistoryController::class, 'index'])->name('teachers.histories.index');
    Route::get('/histories/{id}',[\App\Http\Controllers\Teacher\HistoryController::class, 'show'])->name('teachers.histories.show');
    
    Route::name('teachers.')->group(function () {
        Route::resource('tasks', \App\Http\Controllers\Teacher\TaskController::class);
    });
});

// Student section
Route::get('/login-student',[\App\Http\Controllers\Student\ProfileController::class, 'login'])->name('students.login');
Route::post('/postLoginStudent',[\App\Http\Controllers\Student\ProfileController::class, 'postLogin'])->name('students.checkLogin');
Route::prefix('students')->middleware(['auth.student','preventBackHistory'])->group(function () {
    Route::get('/',[\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('students.dashboard');
    Route::get('/profile',[\App\Http\Controllers\Student\ProfileController::class, 'index'])->name('students.profile');
    Route::put('/postProfile',[\App\Http\Controllers\Student\ProfileController::class, 'postProfile'])->name('students.postProfile');
    Route::get('/logout',[\App\Http\Controllers\Student\ProfileController::class, 'logout'])->name('students.logout');
    
    Route::get('/events/calendar',[\App\Http\Controllers\Student\EventController::class, 'calendar'])->name('students.events.calendar');
    Route::delete('/events/calendar/{id}',[\App\Http\Controllers\Student\EventController::class, 'calendar_detail'])->name('students.events.calendar_detail');
    Route::get('/events',[\App\Http\Controllers\Student\EventController::class, 'index'])->name('students.events.index');

    Route::get('/teachers',[\App\Http\Controllers\Student\TeacherController::class, 'index'])->name('students.teachers.index');
    Route::get('/teachers/{id}',[\App\Http\Controllers\Student\TeacherController::class, 'show'])->name('students.teachers.show');
    
    Route::get('/histories',[\App\Http\Controllers\Student\HistoryController::class, 'index'])->name('students.histories.index');
    Route::get('/histories/{id}',[\App\Http\Controllers\Student\HistoryController::class, 'show'])->name('students.histories.show');
    
});
