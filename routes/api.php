<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    // -----------   Authentication Route ------------- //

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

});
    
Route::group([
    'middleware' => 'api',
], function ($router) {

    // -----------   Category Route ------------- //

    Route::post('/add-category', [CategoryController::class, 'createCategory']);
    Route::post('/category-list', [CategoryController::class, 'listCategory']);

    // -----------   Expenses Route ------------- //

    Route::post('/create-expense', [ExpenseController::class, 'createExpense']);
    Route::get('/get-expense/{id}', [ExpenseController::class, 'getExpense']);
    Route::post('/update-expense/{id}', [ExpenseController::class, 'updateExpense']);
    Route::post('/delete-expense/{id}', [ExpenseController::class, 'delete']);

});
