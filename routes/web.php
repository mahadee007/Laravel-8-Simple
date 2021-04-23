<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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


Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/Edit/{id}', [UserController::class, 'Edit']);
Route::post('Save', [UserController::class, 'Save'])->name('users.Save');

Route::post('/Del', [UserController::class, 'Del'])->name('users.Del');