<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

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

// Route::get('/login', function () {
//     return view('login');
// });
//Route::get('/login',[RegistrationController::class,'login_check']);
Route::get('/registration',[RegistrationController::class,'registration']);
Route::get('/login',[RegistrationController::class,'login'])->middleware('alreadyLoggedIn');


Route::post('/createuser',[RegistrationController::class,"createuser"])->name('createuser');
Route::post('/login-user',[RegistrationController::class,"loginUser"])->name('login-user');
//Route::get('/dashboard',[RegistrationController::class,"dashboard"]);
Route::get('/dashboard',[RegistrationController::class,"dashboard"])->middleware('isLoggedIn');
Route::get('/logout',[RegistrationController::class,"logout"]);


