<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;



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

Route::get('createOrder', [OrderController::class, 'createOrder']);


Route::get('/', function () {
    return view('welcome');
});
  
// Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::any('/orders/addorder/{{id}}', [OrderController::class, 'addorder']);
Route::get('orders/category', [OrderController::class, 'category']);
Route::any('order/create', [OrderController::class, 'createOrder']);
Route::post('order/updateorder', [OrderController::class, 'updateorder']);
Route::any('order/view/{id}', [OrderController::class, 'view'])->name('orders.view');
Route::any('schoolprofile', [UserController::class, 'schoolprofile'])->name('users.schoolprofile');
Route::get('/payments', [OrderController::class, 'payments'])->name('orders.payments');

Route::any('trackorder', [OrderController::class, 'trackorder'])->name('orders.trackorder');


Route::post('/generatebill', [OrderController::class, 'generatebill'])->name('orders.generatebill');

Route::get('profile', [UserController::class, 'profile'])->name('users.profile');
Route::post('updateprofile', [UserController::class, 'updateprofile'])->name('users.updateprofile');


Route::post('updateSchoolprofile', [UserController::class, 'updateSchoolprofile'])->name('users.updateSchoolprofile');
Route::get('change-password', [UserController::class, 'changepassword'])->name('users.changepassword');
Route::post('updateChangePassword', [UserController::class, 'updateChangePassword'])->name('users.updateChangePassword');

Route::get('suppilerprofile', [UserController::class, 'suppilerprofile'])->name('users.suppilerprofile');
Route::post('updatesuppilerprofile', [UserController::class, 'updatesuppilerprofile'])->name('users.updatesuppilerprofile');



Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);

});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\indexController::class, 'index'])->name('index');
