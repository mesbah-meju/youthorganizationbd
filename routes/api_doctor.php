<?php

namespace App\Http\Controllers\Api\V2\Doctor;

use App\Http\Controllers\Api\V2\Doctor\ConversationController;
use App\Http\Controllers\Api\V2\Doctor\ProfileController;
use App\Http\Controllers\Api\V2\Doctor\ScheduleController;
use App\Http\Controllers\Api\V2\Doctor\SurveyQuestionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v2/doctor', 'middleware' => ['app_language']], function () {

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

        Route::controller(SurveyQuestionController::class)->group(function () {
            Route::post('survey/start_survey', 'StartSurvey');
            Route::get('survey_quetions', 'getAllSectionsWithQuestions');
            Route::post('survey_quetions_answers', 'StoreSurveyAnswers');
            Route::post('bulk_survey_quetions_answers', 'storeMultipleSurveyAnswers');
            Route::get('survey_quetions_answers_edit/{id}', 'editSurveyAnswers');
            Route::post('survey_quetions_answers_update', 'UpdateSurveyAnswers');
        });
    });
});
