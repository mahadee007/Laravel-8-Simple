<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//user
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/Edit/{id}', [UserController::class, 'Edit']);
Route::post('Save', [UserController::class, 'Save'])->name('users.Save');
Route::post('/Del', [UserController::class, 'Del'])->name('users.Del');


//department
Route::get('/department/all', [DepartmentController::class, 'index'])->name('department');
Route::get('/department/all/edit/{id}', [DepartmentController::class, 'Edit']);
Route::post('Savedepartment', [DepartmentController::class, 'Savedepartment'])->name('department.Save');
Route::post('/Deldepartment', [DepartmentController::class, 'Deldepartment'])->name('department.Del');
Route::post('/Adddepartment', [DepartmentController::class, 'Adddepartment'])->name('department.adddepartment');
