<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccessControlController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\QueueSessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Enum\UserRole;

Route::post('/login', [AuthController::class, 'login']);

Route::prefix('public')->group(function () {
    Route::get('/get-que-status', [AccessControlController::class, 'getQueStatus']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('role.check:' . implode(',', [
        UserRole::SuperAdmin->value,
    ]))->group(function () {
        Route::prefix('companies')->group(function () {
            Route::get('/', [CompanyController::class, 'index']);
            Route::get('/{id}', [CompanyController::class, 'show']);
            Route::post('/', [CompanyController::class, 'store']);
            Route::put('/{id}', [CompanyController::class, 'update']);
            Route::delete('/{id}', [CompanyController::class, 'destroy']);
        });
    });

    Route::middleware('role.check:' . implode(',', [
        UserRole::SuperAdmin->value,
        UserRole::CompanyAdmin->value
    ]))->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::post('/', [UserController::class, 'store']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });
    });

    Route::middleware('role.check:' . implode(',', [
        UserRole::CompanyAdmin->value,
        UserRole::QueAdmin->value
    ]))->group(function () {

        Route::prefix('queue-sessions')->group(function () {
            Route::get('/', [QueueSessionController::class, 'index']);
            Route::get('/{id}', [QueueSessionController::class, 'show']);
            Route::post('/', [QueueSessionController::class, 'store']);
            Route::put('/{id}', [QueueSessionController::class, 'update']);
            Route::delete('/{id}', [QueueSessionController::class, 'destroy']);
            Route::post('/add-queue-users', [QueueSessionController::class, 'addQueueUser']);
            Route::delete('/remove-queue-user', [QueueSessionController::class, 'removeQueueUser']);
        });

    });

    Route::middleware('role.check:' . implode(',', [
        UserRole::CompanyAdmin->value,
        UserRole::QueAdmin->value,
        UserRole::QueEncoder->value
    ]))->group(function () {
        Route::prefix('customers')->group(function () {
            Route::get('/', [CustomerController::class, 'index']);
            Route::get('/{id}', [CustomerController::class, 'show']);
            Route::post('/', [CustomerController::class, 'store']);
            Route::put('/{id}', [CustomerController::class, 'update']);
            Route::delete('/{id}', [CustomerController::class, 'destroy']);
        });
    });

    Route::prefix('access-control')->group(function () {
        Route::get('/app-menu', [AccessControlController::class, 'getAppMenu']);
    });

});