<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\UserAllDataController;

Route::group(['middleware' => ['client', 'current-module', 'actch:client_panel']], function () {
    Route::get('/', [ClientDashboardController::class, 'dashboard'])->name('client.dashboard');

    Route::group(['prefix' => 'client', 'as' => 'all_user.'], function () {
        Route::get('user', [UserAllDataController::class, 'index'])->name('user_data');
        Route::get('notification', [UserAllDataController::class, 'notification_show'])->name('notification');
    });
});
