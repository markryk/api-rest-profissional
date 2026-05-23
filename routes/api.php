<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\V1\AuthController;
    use App\Http\Controllers\Api\V1\TaskController;
    use App\Http\Controllers\Api\V1\ClientController;
    use App\Http\Controllers\Api\V1\ProductController;
    use App\Http\Controllers\Api\V1\OrderController;
    use App\Http\Controllers\Api\V1\FinanceController;

    Route::prefix('v1')->group(function () {

        Route::post('/register', [AuthController::class, 'register']);

        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {

            Route::post('/logout', [AuthController::class, 'logout']);

            Route::apiResource('tasks', TaskController::class);
            Route::apiResource('clients', ClientController::class);
            Route::apiResource('products', ProductController::class);
            Route::apiResource('orders', OrderController::class);
            Route::apiResource('finances', FinanceController::class);
        });
    });
?>