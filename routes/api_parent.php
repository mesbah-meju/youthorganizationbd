<?php

namespace App\Http\Controllers\Api\V2\Doctor;

use App\Http\Controllers\Api\V2\Parent\ChildController;
use App\Http\Controllers\Api\V2\Parent\ConversationController;
use App\Http\Controllers\Api\V2\Parent\PrimaryScreeningController;
use App\Http\Controllers\Api\V2\Parent\ProfileController;
use App\Http\Controllers\Api\V2\Parent\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v2/parent', 'middleware' => ['app_language']], function () {

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile/edit/{id}', 'edit');
            Route::post('profile/update/{id}', 'update');
        });

        //Conversations 
        Route::controller(ConversationController::class)->group(function () {
            Route::get('conversations', 'index');
            Route::get('conversations/show/{id}', 'showMessages');
            Route::post('conversations/message/store', 'send_message_to_customer');
        });

        Route::controller(ScheduleController::class)->group(function () {
            Route::get('schedules', 'index');
            Route::get('schedules/show/{id}', 'show');
        });

        Route::controller(ChildController::class)->group(function () {
            Route::get('children', 'index');
            Route::get('children/show/{id}', 'show');
            Route::get('children/screening/list/{id}', 'screeningList');
            Route::get('children/survey_answers/{id}/{survey_id}', 'surveyAnswers');
        });

        Route::controller(PrimaryScreeningController::class)->group(function () {
            Route::get('questions', 'index');
            Route::post('answer/store', 'store');
        });
    });
});
