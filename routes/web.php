<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\UsersController;
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
    return inertia('Dashboard');
});

Route::get('/dashboard', function () {
    return inertia('Dashboard');
});

Route::get('/crm', function () {
    return inertia('Crm');
});

Route::get('/permission', function () {
    return inertia('Permission');
});

Route::get('/datatable', function () {
    return inertia('Datatable');
});


Route::get('/partners', function () {
    return inertia('Partners');
});

Route::get('/account', function () {
    return inertia('Setting');
});

Route::get('/tasks', function () {
    return Inertia('Task');
});

Route::get('/reports', function () {
    return Inertia('Report');
});


Route::get('/profile', function () {
    return Inertia('Profile');
});

Route::get('/customers', function () {
    return Inertia('Report');
});

Route::get('/tables', function () {
    return Inertia('Tables');
});

Route::get('/billing', function () {
    return Inertia('Billing');
});


Route::get('/notifications', function () {
    return Inertia('Notification');
});
Route::get('/messages', function () {
    return Inertia('Message');
});

Route::get('user/{contact}/edit', [UsersController::class, 'edit_customer']);
Route::get('add-user', [UsersController::class, 'create']);
Route::post('saveuser', [UsersController::class, 'saveuser']);
Route::get('users', [UsersController::class, 'index']);

Route::get('add-customer', [UsersController::class, 'addcustomer']);
Route::post('saveclient', [UsersController::class, 'saveclient']);
Route::get('clients', [UsersController::class, 'clients']);

Route::get('contacts', [UsersController::class, 'address']);
Route::get('groups', [UsersController::class, 'address']);
Route::get('invoices', [UsersController::class, 'address']);
Route::get('week', [UsersController::class, 'address']);
Route::get('month', [UsersController::class, 'address']);
Route::get('year', [UsersController::class, 'address']);
Route::get('last', [UsersController::class, 'address']);
Route::get('integretions', [UsersController::class, 'address']);

Route::post('/logouts', function () {
    dd('Logout page visited');
});

Route::get('/web', function () {
    return Inertia::render('Home',[
        'name' => "Albogast Dionis",
        'phone' => '0744158016',
        'email' => 'albogast@darsms.co.tz',
        'companies' => [
            'Laravel', 'Vue', 'Django', 'Postgres', 'Boostrap', 'MySQL'
        ]
    ]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
