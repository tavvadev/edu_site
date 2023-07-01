<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any('/createOrder', [ApiController::class, 'createOrder']);
Route::any('/updateorder', [ApiController::class, 'updateorder']);
Route::any('/login', [ApiController::class, 'login']);
Route::any('/orders', [ApiController::class, 'orders']);
Route::any('/categories', [ApiController::class, 'categories']);
Route::any('/getproducts/{id}', [ApiController::class, 'getproducts']);
Route::any('/vieworder/{id}', [ApiController::class, 'viewOrder']);
Route::any('/district', [ApiController::class, 'district']);
Route::post('/mandals', [ApiController::class, 'mandals']);
Route::post('/villages', [ApiController::class, 'villages']);
Route::post('/schools', [ApiController::class, 'schools']);





