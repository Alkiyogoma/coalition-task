<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\UsersController;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\AccountController;
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



Route::get('/reports', function () {
    return Inertia('Report');
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

Route::get('/calendar', function () {
    return Inertia('Calendar');
});
Auth::routes();

Route::get('user/{contact}/edit', [UsersController::class, 'edit_customer']);
Route::get('add-user', [UsersController::class, 'create']);
Route::post('saveuser', [UsersController::class, 'saveuser']);
Route::get('users/{type?}', [UsersController::class, 'index']);
Route::get('/profile/{id?}', [UsersController::class, 'profile']);

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

Route::get('departments', [UsersController::class, 'departments']);
Route::get('add-dept', [UsersController::class, 'addDept']);
Route::post('saveDept', [UsersController::class, 'saveDept']);
Route::get('groups', [UsersController::class, 'address']);
Route::get('invoices', [UsersController::class, 'address']);
Route::post('savePayment', [UsersController::class, 'savePayment']);
Route::post('saveTask', [UsersController::class, 'saveTask']);
Route::post('sendMessage', [UsersController::class, 'sendMessage']);

// Contacts

Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create')->middleware('auth');
Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store')->middleware('auth');
Route::get('accounts/{contact}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
Route::put('accounts/{contact}', [AccountController::class, 'update'])->name('accounts.update');
Route::delete('accounts/{contact}', [AccountController::class, 'destroy'])->name('accounts.destroy');
Route::put('accounts/{contact}/restore', [AccountController::class, 'restore'])->name('accounts.restore')->middleware('auth');

Route::get('accounts', [AccountController::class, 'index'])->name('accounts')->middleware('auth');
Route::get('/addgroup', [AccountController::class, 'addGroup'])->name('addgroup');
Route::post('/savegroup', [AccountController::class, 'saveGroup'])->name('saveGroup');
Route::get('accounts/{contact}/delete', [AccountController::class, 'deleteGroup'])->name('accounts.deleteGroup');

Route::get('/groups', [AccountController::class, 'groups'])->name('groups');
Route::get('/addaccount', [AccountController::class, 'addChart'])->name('addAccount');
Route::post('/savechart', [AccountController::class, 'saveChart'])->name('saveAccount');
Route::get('groups/{contact}/delete', [AccountController::class, 'deleteAccount'])->name('deleteAccount.edit');


Route::get('/revenues/{id?}', [AccountController::class, 'revenues'])->name('revenues');
Route::get('/revenueadd', [AccountController::class, 'revenueAdd'])->name('revenueadd');
Route::post('/revenueadd', [AccountController::class, 'revenueAdd'])->name('revenueaddw');
Route::get('/revenueedit/{id}/edit', [AccountController::class, 'revenueEdit'])->name('revenueEditw');
Route::post('/revenueedit/{id}/edit', [AccountController::class, 'revenueEdit'])->name('revenueEdit');
Route::get('/revenuedelete/{id}/delete', [AccountController::class, 'revenueDelete'])->name('revenueDelete');
Route::get('/receipt/{id}/view', [AccountController::class, 'receipt'])->name('receipt');

Route::get('/expenses/{id?}', [AccountController::class, 'expenses'])->name('expenses');
Route::get('/expenseadd', [AccountController::class, 'expenseAdd'])->name('expenseadd');
Route::post('/expenseadd', [AccountController::class, 'expenseAdd'])->name('expenseaddw');
Route::get('/expenseedit/{id}/edit', [AccountController::class, 'expenseEdit'])->name('expenseEdit');
Route::post('/expenseedit/{id}/edit', [AccountController::class, 'expenseEdit'])->name('expenseEditw');
Route::get('/expensedelete/{id}/delete', [AccountController::class, 'expenseDelete'])->name('expenseDelete');
Route::get('/voucher/{id}/view', [AccountController::class, 'voucher'])->name('voucher');

Route::get('/tasks', [HomeController::class, 'tasks'])->name('tasks');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/payments', [HomeController::class, 'payments'])->name('homeview');
Route::get('/payments/{staff}/view', [HomeController::class, 'payments'])->name('homeview');
Route::get('/payments/{client}/client', [HomeController::class, 'payments'])->name('homeclient');
Route::get('/payments/{partner}/partner', [HomeController::class, 'payments'])->name('homepartner');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
Route::get('/receipt/{id}/payment', [HomeController::class, 'receipt'])->name('receipt');
Route::get('/collections/{client?}/{partner?}', [HomeController::class, 'collections'])->name('collections');

Route::get('/home', [HomeController::class, 'index'])->name('indexpage');
Route::get('/paymentadd', [HomeController::class, 'AddPayment'])->name('paymentAdd');
Route::post('/savepayment', [HomeController::class, 'savePayment'])->name('savePayment');
Route::post('/uploadPayment', [HomeController::class, 'uploadPayment'])->name('uploadPayment');
Route::get('/uploadPayments', [HomeController::class, 'uploadPayments'])->name('savePayment');

Route::post('/clientUpload', [HomeController::class, 'clientUpload'])->name('clientUpload');
Route::get('/clientUploads', [HomeController::class, 'clientUploads'])->name('clientUploads');

Route::any('/sendmessage', [HomeController::class, 'send'])->name('sendmessage');
Route::get('/inbox', [HomeController::class, 'inbox'])->name('inbox');
Route::get('/sent/{status?}', [HomeController::class, 'sent'])->name('sent');
Route::get('/templates', [HomeController::class, 'templates'])->name('templates');
Route::any('/addtemplate', [HomeController::class, 'addtemplate'])->name('addtemplate');
Route::get('/deletetemplate/{status?}', [HomeController::class, 'deletetemplate'])->name('deletetemplate');

Route::get('/messages', [HomeController::class, 'messages'])->name('messages');
Route::get('/message/setting', [HomeController::class, 'setting'])->name('messages');
Route::post('/sendSingle', [HomeController::class, 'sendSingle'])->name('sendSingle');
Route::post('/buySMS', [HomeController::class, 'buySMS'])->name('buySMS');
Route::post('/send_to_numbers', [HomeController::class, 'send_to_numbers'])->name('send_to_numbers');
Route::post('/buySMS', [HomeController::class, 'buySMS'])->name('buySMS');
