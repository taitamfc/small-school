<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
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
Route::get('/checkLoginUser',[AuthController::class, 'checkLoginUser'])->name('login');
Route::post('/loginUser',[AuthController::class, 'loginUser'])->name('userLogin');

Route::prefix('/')->middleware(['auth', 'preventBackHistory'])->group(function () {
Route::get('/logoutUser', [AuthController::class, 'logoutUser'])->name('logoutUser');
Route::get('/',[AuthController::class, 'index'])->name('home');
Route::get('users/export/', [UserController::class, 'export'])->name('exportUser');
Route::post('users/import/', [UserController::class, 'import'])->name('importUser');
Route::resource('users', UserController::class);
Route::resource('groups', GroupController::class);
});
Route::prefix('students')->group(function(){
    Route::get('/',[StudentController::class,'index'])->name('student.index');
    Route::get('/create',[StudentController::class,'create'])->name('student.create');
    Route::post('/store',[StudentController::class,'store'])->name('student.store');
    Route::post('/import',[StudentController::class,'import'])->name('student.import');
    Route::get('/edit/{id}',[StudentController::class,'edit'])->name('student.edit');
    Route::put('/update/{id}',[StudentController::class,'update'])->name('student.update');
    Route::delete('/destroy/{id}',[StudentController::class,'destroy'])->name('student.destroy');
});
