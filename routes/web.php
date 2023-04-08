<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\HomeController;
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


Auth::routes();


Route::get('departments', [HomeController::class, 'departments']);
Route::get('add-dept', [HomeController::class, 'addDept']);
Route::post('saveDept', [HomeController::class, 'saveDept']);


Route::get('/tasks', [HomeController::class, 'tasks'])->name('tasks');
Route::get('/mytasks/{id?}', [HomeController::class, 'profile'])->name('mytasks');
Route::get('/calendar/{id?}', [HomeController::class, 'calendar'])->name('calendar');
Route::get('/calendar_data/{id?}', [HomeController::class, 'calendar_data'])->name('calendar_data');

Route::post('saveTask', [HomeController::class, 'saveTask']);
Route::get('taskstatus/{id}/{type}', [HomeController::class, 'updateTask']);
Route::get('deletetask/{id}/delete', [HomeController::class, 'deleteTask']);
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

Route::get('/home', [HomeController::class, 'index'])->name('indexpage');

Route::post('/callTasks', [HomeController::class, 'callTasks'])->name('callTasks');
Route::post('/callGroup', [HomeController::class, 'callGroup'])->name('callGroup');
Route::post('/getCode', [HomeController::class, 'getCode'])->name('getCode');
Route::post('/searchs', [HomeController::class, 'search'])->name('searchs');
Route::get('/drag', [HomeController::class, 'dragTask'])->name('dragTask');

