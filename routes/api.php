<?php

namespace App\Http\Controllers\Api\V2;
use App\Http\Middleware\EnsureSystemKey;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v2/auth', 'middleware' => ['app_language']], function () {
    
    Route::post('info', [AuthController::class, 'getUserInfoByAccessToken']);
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('signup', 'signup');
        Route::post('social-login', 'socialLogin');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('logout', 'logout');
            Route::get('user', 'user');
            Route::get('account-deletion', 'account_deletion');
            Route::post('/verification_confirmation/{id}', 'verification_confirmation');
        });
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('confirm_code', 'confirmCode');
    });

    Route::controller(PasswordResetController::class)->group(function () {
        Route::post('resend_code', 'resendCode');
        Route::post('password/forget_request', 'forgetRequest');
        Route::post('password/confirm_reset', 'confirmReset');
        Route::post('password/resend_code', 'resendCode');
        Route::post('password/change_password/{id}', 'changePassword');
    });
});

Route::group(['prefix' => 'v2', 'middleware' => ['app_language']], function () {

    Route::apiResource('schedules', 'App\Http\Controllers\Api\V2\ScheduleController')->only('index');
    
    //auth controller
    Route::post('guest-user-account-create', [AuthController::class, 'guestUserAccountCreate']);

    Route::controller(AddressController::class)->group(function () {
        Route::post('update-address-in-cart', 'updateAddressInCart');
        Route::post('update-shipping-type-in-cart', 'updateShippingTypeInCart');
    });
    
    Route::get('payment-types', [PaymentTypesController::class, 'getList']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::controller(SchoolController::class)->group(function () {
            Route::get('/enrolled_school_list', 'enrolled_school_list');
            Route::get('/enrolled_school_wise_class_list/{id}', 'enrolled_school_wise_class_list');
            Route::post('/enrolled_school_class_wise_section_list', 'enrolled_school_class_wise_section_list');
        });

        Route::controller(TicketController::class)->group(function () {
            Route::post('/sent_ticket', 'store');
        });

        Route::controller(TicketController::class)->group(function () {
            Route::post('/sent_ticket', 'store');
        });
    });

    // un banned users
    Route::group(['middleware' => ['app_user_unbanned']], function () {
        Route::controller(ChatController::class)->group(function () {
            Route::get('chat/conversations', 'conversations')->middleware('auth:sanctum');
            Route::get('chat/messages/{id}', 'messages')->middleware('auth:sanctum');
            Route::post('chat/insert-message', 'insert_message')->middleware('auth:sanctum');
            Route::get('chat/get-new-messages/{conversation_id}/{last_message_id}', 'get_new_messages')->middleware('auth:sanctum');
            Route::post('chat/create-conversation', 'create_conversation')->middleware('auth:sanctum');
        });

        Route::get('get-home-delivery-address', [AddressController::class, 'getShippingInCart'])->middleware('auth:sanctum');

        // addresses
        Route::controller(AddressController::class)->middleware('auth:sanctum')->group(function () {
            Route::get('user/shipping/address', 'addresses');
            Route::post('user/shipping/create', 'createShippingAddress');
            Route::post('user/shipping/update', 'updateShippingAddress');
            Route::post('user/shipping/update-location', 'updateShippingAddressLocation');
            Route::post('user/shipping/make_default', 'makeShippingAddressDefault');
            Route::get('user/shipping/delete/{address_id}', 'deleteShippingAddress');
        });

        Route::get('bkash/begin', 'App\Http\Controllers\Api\V2\BkashController@begin')->middleware('auth:sanctum');
        Route::get('nagad/begin', 'App\Http\Controllers\Api\V2\NagadController@begin')->middleware('auth:sanctum');

        Route::post('payments/pay/cod', 'App\Http\Controllers\Api\V2\PaymentController@cashOnDelivery')->middleware('auth:sanctum');
        Route::post('payments/pay/manual', 'App\Http\Controllers\Api\V2\PaymentController@manualPayment')->middleware('auth:sanctum');

        Route::get('profile/counters', 'App\Http\Controllers\Api\V2\ProfileController@counters')->middleware('auth:sanctum');

        Route::post('profile/update', 'App\Http\Controllers\Api\V2\ProfileController@update')->middleware('auth:sanctum');

        Route::post('profile/update-device-token', 'App\Http\Controllers\Api\V2\ProfileController@update_device_token')->middleware('auth:sanctum');
        Route::post('profile/update-image', 'App\Http\Controllers\Api\V2\ProfileController@updateImage')->middleware('auth:sanctum');
        Route::post('profile/image-upload', 'App\Http\Controllers\Api\V2\ProfileController@imageUpload')->middleware('auth:sanctum');
        Route::post('profile/check-phone-and-email', 'App\Http\Controllers\Api\V2\ProfileController@checkIfPhoneAndEmailAvailable')->middleware('auth:sanctum');

        Route::post('file/image-upload', 'App\Http\Controllers\Api\V2\FileController@imageUpload')->middleware('auth:sanctum');
        Route::get('file-all', 'App\Http\Controllers\Api\V2\FileController@index')->middleware('auth:sanctum');
        Route::post('file/upload', 'App\Http\Controllers\Api\V2\AizUploadController@upload')->middleware('auth:sanctum');

        // Notification
        Route::controller(NotificationController::class)->group(function () {
            Route::get('all-notification', 'allNotification')->middleware('auth:sanctum');
            Route::get('unread-notifications', 'unreadNotifications')->middleware('auth:sanctum');
            Route::post('notifications/bulk-delete', 'bulkDelete')->middleware('auth:sanctum');
            Route::get('notifications/mark-as-read', 'notificationMarkAsRead')->middleware('auth:sanctum');
        });
    });

    Route::get('get-search-suggestions',[SearchSuggestionController::class, 'getList'] );
    Route::get('languages',[LanguageController::class, 'getList']);


    Route::apiResource('banners', 'App\Http\Controllers\Api\V2\BannerController')->only('index');

    Route::apiResource('business-settings', 'App\Http\Controllers\Api\V2\BusinessSettingController')->only('index');

    Route::apiResource('colors', 'App\Http\Controllers\Api\V2\ColorController')->only('index');

    Route::apiResource('currencies', 'App\Http\Controllers\Api\V2\CurrencyController')->only('index');


    Route::apiResource('general-settings', 'App\Http\Controllers\Api\V2\GeneralSettingController')->only('index');




    //Use this route outside of auth because initialy we created outside of auth we do not need auth initialy
    //We can't change it now because we didn't send token in header from mobile app.
    //We need the upload update Flutter app then we will write it in auth middleware.

    Route::get('sliders', 'App\Http\Controllers\Api\V2\SliderController@sliders');
    Route::get('banners-one', 'App\Http\Controllers\Api\V2\SliderController@bannerOne');
    Route::get('banners-two', 'App\Http\Controllers\Api\V2\SliderController@bannerTwo');
    Route::get('banners-three', 'App\Http\Controllers\Api\V2\SliderController@bannerThree');

    Route::get('policies/seller', 'App\Http\Controllers\Api\V2\PolicyController@sellerPolicy')->name('policies.seller');
    Route::get('policies/support', 'App\Http\Controllers\Api\V2\PolicyController@supportPolicy')->name('policies.support');
    Route::get('policies/return', 'App\Http\Controllers\Api\V2\PolicyController@returnPolicy')->name('policies.return');

    Route::post('get-user-by-access_token', 'App\Http\Controllers\Api\V2\UserController@getUserInfoByAccessToken');

    Route::get('cities', 'App\Http\Controllers\Api\V2\AddressController@getCities');
    Route::get('states', 'App\Http\Controllers\Api\V2\AddressController@getStates');
    Route::get('countries', 'App\Http\Controllers\Api\V2\AddressController@getCountries');

    Route::get('cities-by-state/{state_id}', 'App\Http\Controllers\Api\V2\AddressController@getCitiesByState');
    Route::get('states-by-country/{country_id}', 'App\Http\Controllers\Api\V2\AddressController@getStatesByCountry');

    Route::any('amarpay', [AamarpayController::class, 'pay'])->name('api.amarpay.url');

    Route::get('bkash/api/webpage/{token}/{amount}', 'App\Http\Controllers\Api\V2\BkashController@webpage')->name('api.bkash.webpage');

    Route::any('bkash/api/execute/{token}', 'App\Http\Controllers\Api\V2\BkashController@execute')->name('api.bkash.execute');
    Route::any('bkash/api/fail', 'App\Http\Controllers\Api\V2\BkashController@fail')->name('api.bkash.fail');
    Route::post('bkash/api/process', 'App\Http\Controllers\Api\V2\BkashController@process')->name('api.bkash.process');


    Route::any('nagad/verify/{payment_type}', 'App\Http\Controllers\Api\V2\NagadController@verify')->name('app.nagad.callback_url');
    Route::post('nagad/process', 'App\Http\Controllers\Api\V2\NagadController@process');

    Route::get('sslcommerz/begin', 'App\Http\Controllers\Api\V2\SslCommerzController@begin');

    Route::post('offline/payment/submit', 'App\Http\Controllers\Api\V2\OfflinePaymentController@submit')->name('api.offline.payment.submit');

    //Addon list
    Route::get('addon-list', 'App\Http\Controllers\Api\V2\ConfigController@addon_list');
    //Activated social login list
    Route::get('activated-social-login', 'App\Http\Controllers\Api\V2\ConfigController@activated_social_login');

    //Business Sttings list
    Route::post('business-settings', 'App\Http\Controllers\Api\V2\ConfigController@business_settings');

    Route::withoutMiddleware([EnsureSystemKey::class])->group(function () {
        Route::get('google-recaptcha', function () {
            return view("frontend.google_recaptcha.app_recaptcha");
        });
        Route::any('amarpay/success', [AamarpayController::class, 'success'])->name('api.amarpay.success');
        Route::any('amarpay/cancel', [AamarpayController::class, 'fail'])->name('api.amarpay.cancel');

        Route::any('bkash/api/callback', 'App\Http\Controllers\Api\V2\BkashController@callback')->name('api.bkash.callback');
        Route::post('bkash/api/success', 'App\Http\Controllers\Api\V2\BkashController@payment_success')->name('api.bkash.success');
        Route::any('bkash/api/checkout/{token}/{amount}', 'App\Http\Controllers\Api\V2\BkashController@checkout')->name('api.bkash.checkout');

        Route::any('sslcommerz/success', 'App\Http\Controllers\Api\V2\SslCommerzController@payment_success');
        Route::any('sslcommerz/fail', 'App\Http\Controllers\Api\V2\SslCommerzController@payment_fail');
        Route::any('sslcommerz/cancel', 'App\Http\Controllers\Api\V2\SslCommerzController@payment_cancel');
    });

    // customer file upload
    Route::controller(CustomerFileUploadController::class)->middleware('auth:sanctum')->group(function () {
        Route::post('file/upload', 'upload');
        Route::get('file/all', 'index');
        Route::get('file/delete/{id}', 'destroy');
    });
});

Route::fallback(function () {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});