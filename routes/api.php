<?php

use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PermissionUserController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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

Route::post('/me', [AuthApiController::class, 'me'])->name('auth.me')->middleware('auth:sanctum');
Route::post('/logout', [AuthApiController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
Route::post('/auth', [AuthApiController::class, 'auth'])->name('auth.login');

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::apiResource('/permissions', PermissionController::class);
    
    Route::post('/users/{user}/permissions-sync', [PermissionUserController::class, 'syncPermissionOfUser'])->name('users.permissions.sync');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});


Route::get('/', fn () => response()->json(['message' => 'ok']));
