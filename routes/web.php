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


Route::get('/customers', function () {
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

Route::get('/reports', function () {
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
Route::get('users/{type?}', [UsersController::class, 'index']);

Route::get('add-customer', [UsersController::class, 'addcustomer']);
Route::get('add/{branch}', [UsersController::class, 'addemployer']);
Route::post('save/{branch}', [UsersController::class, 'saveemployer']);
Route::get('add-partner', [UsersController::class, 'addPartner']);
Route::post('savepartner', [UsersController::class, 'savePartner']);
Route::post('saveclient', [UsersController::class, 'saveClient']);
Route::get('clients/{type?}/{id?}', [UsersController::class, 'clients']);
Route::get('client/{uuid}/view', [UsersController::class, 'client']);

Route::get('partners/{id?}', [UsersController::class, 'partners']);
Route::get('branches/{id?}', [UsersController::class, 'branches']);
Route::get('delete/{type}/{id}', [UsersController::class, 'deleteemployer']);

Route::get('contacts', [UsersController::class, 'address']);
Route::get('groups', [UsersController::class, 'address']);
Route::get('invoices', [UsersController::class, 'address']);
Route::get('week', [UsersController::class, 'address']);
Route::get('month', [UsersController::class, 'address']);
Route::get('year', [UsersController::class, 'address']);
Route::get('last', [UsersController::class, 'address']);
Route::post('savePayment', [UsersController::class, 'savePayment']);
Route::post('saveTask', [UsersController::class, 'saveTask']);
Route::post('sendMessage', [UsersController::class, 'sendMessage']);

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
