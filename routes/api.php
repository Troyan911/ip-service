<?php

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IpAddressController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ips', [IpAddressController::class, 'index']);
    Route::get('/ips/{ipAddress}', [IpAddressController::class, 'show']);
    Route::get('/ips-export', [IpAddressController::class, 'export']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware(RoleEnum::ADMIN->value)->group(function () {
        Route::post('/ips', [IpAddressController::class, 'store']);
        Route::put('/ips/{ipAddress}', [IpAddressController::class, 'update']);
        Route::delete('/ips/{ipAddress}', [IpAddressController::class, 'destroy']);
    });
});
