<?php

use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Organization\ActivityController;
use App\Http\Controllers\Organization\AddressController;
use App\Http\Controllers\Organization\AwardAchievementController;
use App\Http\Controllers\Organization\BankController;
use App\Http\Controllers\Organization\ChallanController;
use App\Http\Controllers\Organization\GrantsAidsController;
use App\Http\Controllers\Organization\NotificationController;
use App\Http\Controllers\Organization\ProfileController;
use App\Http\Controllers\Organization\DashboardController;
use App\Http\Controllers\Organization\DocumentController;
use App\Http\Controllers\Organization\DomainOfWorkController;
use App\Http\Controllers\Organization\MemberController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Organization\SupportTicketController;

// Upload
Route::group(['prefix' => 'organization', 'middleware' => ['organization', 'verified', 'user', 'prevent-back-history'], 'as' => 'organization.'], function () {
    Route::controller(AizUploadController::class)->group(function () {
        Route::any('/uploads', 'index')->name('uploaded-files.index');
        Route::any('/uploads/create', 'create')->name('uploads.create');
        Route::any('/uploads/file-info', 'file_info')->name('my_uploads.info');
        Route::get('/uploads/destroy/{id}', 'destroy')->name('my_uploads.destroy');
        Route::post('/bulk-uploaded-files-delete', 'bulk_uploaded_files_delete')->name('bulk-uploaded-files-delete');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Organization', 'prefix' => 'organization', 'middleware' => ['organization', 'verified', 'user', 'prevent-back-history'], 'as' => 'organization.'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/change/status', 'change_status')->name('change_status');
        Route::post('/register/selection', 'process')->name('register.selection');
    });

    // Profile Settings
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::post('/profile/update/{id}', 'update')->name('profile.update');
    });

    // Address
    Route::resource('addresses', AddressController::class);
    Route::controller(AddressController::class)->group(function () {
        Route::post('/get-states', 'getStates')->name('get-state');
        Route::post('/get-cities', 'getCities')->name('get-city');
        Route::post('/address/update/{id}', 'update')->name('addresses.update');
        Route::get('/addresses/destroy/{id}', 'destroy')->name('addresses.destroy');
        Route::get('/addresses/set_default/{id}', 'set_default')->name('addresses.set_default');
    });

    // Support Ticket
    Route::controller(SupportTicketController::class)->group(function () {
        Route::get('/support_ticket', 'index')->name('support_ticket.index');
        Route::post('/support_ticket/store', 'store')->name('support_ticket.store');
        Route::get('/support_ticket/show/{id}', 'show')->name('support_ticket.show');
        Route::post('/support_ticket/reply', 'ticket_reply_store')->name('support_ticket.reply_store');
    });

    // Notifications
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/all-notification', 'index')->name('all-notification');
        Route::post('/notifications/bulk-delete', 'bulkDelete')->name('notifications.bulk_delete');
        Route::get('/notification/read-and-redirect/{id}', 'readAndRedirect')->name('notification.read-and-redirect');
    });

    // Organization Register
    //    ROUTE::POST('details',[OrganizationController::class,'store_org_details']);
    Route::controller(OrganizationController::class)->group(function () {

        // Organization Details
        Route::get('/details/create', 'create')->name('details.create');
        Route::post('/details/store', 'store')->name('details.store');

        // Organization Address
        // Route::get('/address/create', 'create_address')->name('address');
        // Route::post('/address', 'store_address')->name('address.store');

        // Organization Members
        // Route::get('/members/create', 'create_members')->name('members');
        // Route::post('/members', 'store_members')->name('members.store');

        // Organization Bank
        // Route::get('/bank/create', 'create_bank')->name('bank');
        // Route::post('/bank', 'store_bank')->name('bank_store');

        // Organization Activity
        // Route::get('/activity/create', 'create_activity')->name('activity');
        // Route::post('/activity', 'store_activity')->name('activity_store');

        // Organization domains
        // Route::get('/domain/create', 'create_domain')->name('domain');
        // Route::post('/domain', 'domains_store')->name('domains_store');

        // Organization challan
        // Route::get('/challan', 'create_challan')->name('challan');
        // Route::post('/challan_upload', 'challan_store')->name('challan_store');

        // Organization document upload
        // Route::get('/document', 'create_document')->name('documents');
        // Route::post('/document_upload', 'document_store')->name('document_store');

        // Organization submit
        Route::get('/show', 'show')->name('show');
        Route::get('/submit-for-verification', 'submit_for_verification')->name('submit_for_verification');
    });

    Route::controller(AddressController::class)->group(function () {
        Route::get('/address/create', 'create')->name('address.create');
        Route::post('/address/store', 'store')->name('address.store');
    });

    Route::controller(MemberController::class)->group(function () {
        Route::get('/members/create', 'create')->name('members.create');
        Route::post('/members/store', 'store')->name('members.store');
    });

    Route::controller(BankController::class)->group(function () {
        Route::get('/banks/create', 'create')->name('banks.create');
        Route::post('/banks/store', 'store')->name('banks.store');
    });

    Route::controller(ActivityController::class)->group(function () {
        Route::get('/activity/create', 'create')->name('activity.create');
        Route::post('/activity/store', 'store')->name('activity.store');
    });

    Route::controller(AwardAchievementController::class)->group(function () {
        Route::get('/awards/create', 'create')->name('awards.create');
        Route::post('/awards/store', 'store')->name('awards.store');
    });

    Route::controller(GrantsAidsController::class)->group(function () {
        Route::get('/grants/create', 'create')->name('grants.create');
        Route::post('/grants/store', 'store')->name('grants.store');
    });

    Route::controller(DomainOfWorkController::class)->group(function () {
        Route::get('/domain_of_works/create', 'create')->name('domains.create');
        Route::post('/domain_of_works/store', 'store')->name('domains.store');
    });

    Route::controller(ChallanController::class)->group(function () {
        Route::get('/challan/create', 'create')->name('challan.create');
        Route::post('/challan/store', 'store')->name('challan.store');
    });

    Route::controller(DocumentController::class)->group(function () {
        Route::get('/documents/create', 'create')->name('documents.create');
        Route::post('/documents/store', 'store')->name('document.store');
    });
});
