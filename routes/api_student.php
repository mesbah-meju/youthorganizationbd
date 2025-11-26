<?php

namespace App\Http\Controllers\Api\V2\Student;


use App\Http\Controllers\Api\V2\Student\ProfileController;

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v2/student', 'middleware' => ['app_language']], function () {

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile/edit/{id}', 'edit');
            Route::post('profile/update/{id}', 'update');
            Route::get('profile/qr_code_scanned/{id}', 'qr_code_scanned');
        });
    });
});



