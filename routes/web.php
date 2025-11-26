<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Payment\AamarpayController;
use App\Http\Controllers\Payment\AuthorizenetController;
use App\Http\Controllers\Payment\BkashController;
use App\Http\Controllers\Payment\InstamojoController;
use App\Http\Controllers\Payment\IyzicoController;
use App\Http\Controllers\Payment\MercadopagoController;
use App\Http\Controllers\Payment\NagadController;
use App\Http\Controllers\Payment\NgeniusController;
use App\Http\Controllers\Payment\PayhereController;
use App\Http\Controllers\Payment\PaykuController;
use App\Http\Controllers\Payment\PaymobController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Payment\RazorpayController;
use App\Http\Controllers\Payment\SslcommerzController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\TapController;
use App\Http\Controllers\Payment\VoguepayController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SupportTicketController;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/refresh-csrf', function () {
    return csrf_token();
});

// AIZ Uploader
Route::controller(AizUploadController::class)->group(function () {
    Route::post('/aiz-uploader', 'show_uploader');
    Route::post('/aiz-uploader/upload', 'upload');
    Route::get('/aiz-uploader/get-uploaded-files', 'get_uploaded_files');
    Route::post('/aiz-uploader/get_file_by_ids', 'get_preview_files');
    Route::get('/aiz-uploader/download/{id}', 'attachment_download')->name('download_attachment');
});

Route::group(['middleware' => ['prevent-back-history']], function () {
    Auth::routes(['verify' => true]);
});

// Login
Route::controller(LoginController::class)->group(function () {
    Route::get('/logout', 'logout');
    Route::get('/social-login/redirect/{provider}', 'redirectToProvider')->name('social.login');
    Route::get('/social-login/{provider}/callback', 'handleProviderCallback')->name('social.callback');
    //Apple Callback
    Route::post('/apple-callback', 'handleAppleCallback');
    Route::get('/account-deletion', 'account_deletion')->name('account_delete');
    Route::get('/handle-demo-login', 'handle_demo_login')->name('handleDemoLogin');
});

Route::controller(VerificationController::class)->group(function () {
    Route::get('/email/resend', 'resend')->name('verification.resend');
    Route::get('/verification-confirmation/{code}', 'verification_confirmation')->name('email.verification.confirmation');
});

Route::controller(DirectorController::class)->group(function () {
    Route::post('/directors/register', 'register')->name('directors.register');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/email-change/callback', 'email_change_callback')->name('email_change.callback');
    Route::post('/password/reset/email/submit', 'reset_password_with_code')->name('password.update');

    Route::get('/users/login', 'login')->name('user.login');
    Route::get('/users/registration', 'registration')->name('user.registration');
    Route::get('/users/verify', 'verify')->name('user.verify');

    Route::post('/director/registration', 'director_registration')->name('director_registration');

    Route::post('/import-data', 'import_data');

    //Home Page
    Route::get('/', 'registration')->name('home');

    Route::post('/home/section/featured', 'load_featured_section')->name('home.section.featured');
    Route::post('/home/section/todays-deal', 'load_todays_deal_section')->name('home.section.todays_deal');
    Route::post('/home/section/best-selling', 'load_best_selling_section')->name('home.section.best_selling');
    Route::post('/home/section/newest-products', 'load_newest_product_section')->name('home.section.newest_products');
    Route::post('/home/section/home-categories', 'load_home_categories_section')->name('home.section.home_categories');
    Route::post('/home/section/best-sellers', 'load_best_sellers_section')->name('home.section.best_sellers');

    //category dropdown menu ajax call
    Route::post('/category/nav-element-list', 'get_category_items')->name('category.elements');

    //Flash Deal Details Page
    Route::get('/flash-deals', 'all_flash_deals')->name('flash-deals');
    Route::get('/flash-deal/{slug}', 'flash_deal_details')->name('flash-deal-details');

    //Todays Deal Details Page
    Route::get('/todays-deal', 'todays_deal')->name('todays-deal');

    Route::get('/product/{slug}', 'product')->name('product');
    Route::post('/product/variant-price', 'variant_price')->name('products.variant_price');
    Route::get('/shop/{slug}', 'shop')->name('shop.visit');
    Route::get('/shop/{slug}/{type}', 'filter_shop')->name('shop.visit.type');

    Route::get('/customer-packages', 'premium_package_index')->name('customer_packages_list_show');

    Route::get('/brands', 'all_brands')->name('brands.all');
    Route::get('/categories', 'all_categories')->name('categories.all');
    Route::get('/sellers', 'all_seller')->name('sellers');
    Route::get('/coupons', 'all_coupons')->name('coupons.all');
    Route::get('/inhouse', 'inhouse_products')->name('inhouse.all');


    // Policies
    Route::get('/seller-policy', 'sellerpolicy')->name('sellerpolicy');
    Route::get('/return-policy', 'returnpolicy')->name('returnpolicy');
    Route::get('/support-policy', 'supportpolicy')->name('supportpolicy');
    Route::get('/terms', 'terms')->name('terms');
    Route::get('/privacy-policy', 'privacypolicy')->name('privacypolicy');

    Route::get('/track-your-order', 'trackOrder')->name('orders.track');
});

// Language Switch
Route::post('/language', [LanguageController::class, 'changeLanguage'])->name('language.change');

// Currency Switch
Route::post('/currency', [CurrencyController::class, 'changeCurrency'])->name('currency.change');

Route::get('/sitemap.xml', function () {
    return base_path('sitemap.xml');
});

// Search
Route::controller(SearchController::class)->group(function () {
    Route::get('/search', 'index')->name('search');
    Route::get('/search?keyword={search}', 'index')->name('suggestion.search');
    Route::post('/ajax-search', 'ajax_search')->name('search.ajax');
    Route::get('/category/{category_slug}', 'listingByCategory')->name('products.category');
    Route::get('/brand/{brand_slug}', 'listingByBrand')->name('products.brand');
});

//Paypal START
Route::controller(PaypalController::class)->group(function () {
    Route::get('/paypal/payment/done', 'getDone')->name('payment.done');
    Route::get('/paypal/payment/cancel', 'getCancel')->name('payment.cancel');
});
//Mercadopago START
Route::controller(MercadopagoController::class)->group(function () {
    Route::any('/mercadopago/payment/done', 'paymentstatus')->name('mercadopago.done');
    Route::any('/mercadopago/payment/cancel', 'callback')->name('mercadopago.cancel');
});
//Mercadopago

// SSLCOMMERZ Start
Route::controller(SslcommerzController::class)->group(function () {
    Route::get('/sslcommerz/pay', 'index');
    Route::POST('/sslcommerz/success', 'success');
    Route::POST('/sslcommerz/fail', 'fail');
    Route::POST('/sslcommerz/cancel', 'cancel');
    Route::POST('/sslcommerz/ipn', 'ipn');
});
//SSLCOMMERZ END

//Stipe Start
Route::controller(StripeController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('/stripe/create-checkout-session', 'create_checkout_session')->name('stripe.get_token');
    Route::any('/stripe/payment/callback', 'callback')->name('stripe.callback');
    Route::get('/stripe/success', 'success')->name('stripe.success');
    Route::get('/stripe/cancel', 'cancel')->name('stripe.cancel');
});
//Stripe END

// Subscribe
Route::resource('subscribers', SubscriberController::class);

Route::group(['middleware' => ['user', 'verified', 'unbanned']], function () {

    Route::controller(HomeController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware(['prevent-back-history']);
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/new-user-verification', 'new_verify')->name('user.new.verify');
        Route::post('/new-user-email', 'update_email')->name('user.change.email');
        Route::post('/user/update-profile', 'userProfileUpdate')->name('user.profile.update');
    });

    Route::controller(NotificationController::class)->group(function () {
        Route::get('/all-notifications', 'customerIndex')->name('customer.all-notifications');
        Route::post('/notifications/bulk-delete', 'bulkDeleteCustomer')->name('notifications.bulk_delete');
        Route::get('/notification/read-and-redirect/{id}', 'readAndRedirect')->name('notification.read-and-redirect');
        Route::get('/non-linkable-notification-read', 'nonLinkableNotificationRead')->name('non-linkable-notification-read');
    });
});

Route::group(['middleware' => ['customer', 'verified', 'unbanned']], function () {

    // Support Ticket
    Route::resource('support_ticket', SupportTicketController::class);
    Route::post('support_ticket/reply', [SupportTicketController::class, 'seller_store'])->name('support_ticket.seller_store');
});


Route::get('translation-check/{check}', [LanguageController::class, 'get_translation']);

Route::controller(AddressController::class)->group(function () {
    Route::post('/get-states', 'getStates')->name('get-state');
    Route::post('/get-cities', 'getCities')->name('get-city');
});

Route::group(['middleware' => ['auth']], function () {


    // Product Conversation
    Route::resource('conversations', ConversationController::class);
    Route::controller(ConversationController::class)->group(function () {
        Route::get('/conversations/destroy/{id}', 'destroy')->name('conversations.destroy');
        Route::post('conversations/refresh', 'refresh')->name('conversations.refresh');
    });


    Route::resource('messages', MessageController::class);

    //Address
    Route::resource('addresses', AddressController::class);
    Route::controller(AddressController::class)->group(function () {
        // Route::post('/get-states', 'getStates')->name('get-state');
        // Route::post('/get-cities', 'getCities')->name('get-city');
        Route::post('/addresses/update/{id}', 'update')->name('addresses.update');
        Route::get('/addresses/destroy/{id}', 'destroy')->name('addresses.destroy');
        Route::get('/addresses/set-default/{id}', 'set_default')->name('addresses.set_default');
    });
});

Route::get('/instamojo/payment/pay-success', [InstamojoController::class, 'success'])->name('instamojo.success');

Route::post('rozer/payment/pay-success', [RazorpayController::class, 'payment'])->name('payment.rozer');

Route::get('/paystack/payment/callback', [PaystackController::class, 'handleGatewayCallback']);
Route::get('/paystack/new-callback', [PaystackController::class, 'paystackNewCallback']);

Route::controller(VoguepayController::class)->group(function () {
    Route::get('/vogue-pay', 'showForm');
    Route::get('/vogue-pay/success/{id}', 'paymentSuccess');
    Route::get('/vogue-pay/callback', 'handleCallback');
    Route::get('/vogue-pay/failure/{id}', 'paymentFailure');
});


//Iyzico
Route::any('/iyzico/payment/callback/{payment_type}/{amount?}/{payment_method?}/{combined_order_id?}/{customer_package_id?}/{seller_package_id?}', [IyzicoController::class, 'callback'])->name('iyzico.callback');

Route::get('/customer-products/admin', [IyzicoController::class, 'initPayment'])->name('profile.edit');

//payhere below
Route::controller(PayhereController::class)->group(function () {
    Route::get('/payhere/checkout/testing', 'checkout_testing')->name('payhere.checkout.testing');
    Route::get('/payhere/wallet/testing', 'wallet_testing')->name('payhere.checkout.testing');
    Route::get('/payhere/customer_package/testing', 'customer_package_testing')->name('payhere.customer_package.testing');

    Route::any('/payhere/checkout/notify', 'checkout_notify')->name('payhere.checkout.notify');
    Route::any('/payhere/checkout/return', 'checkout_return')->name('payhere.checkout.return');
    Route::any('/payhere/checkout/cancel', 'chekout_cancel')->name('payhere.checkout.cancel');

    Route::any('/payhere/order-re-payment/notify', 'orderRepaymentNotify')->name('payhere.order_re_payment.notify');
    Route::any('/payhere/order-re-payment/return', 'orderRepaymentReturn')->name('payhere.order_re_payment.return');
    Route::any('/payhere/order-re-payment/cancel', 'orderRepaymentCancel')->name('payhere.order_re_payment.cancel');

    Route::any('/payhere/wallet/notify', 'wallet_notify')->name('payhere.wallet.notify');
    Route::any('/payhere/wallet/return', 'wallet_return')->name('payhere.wallet.return');
    Route::any('/payhere/wallet/cancel', 'wallet_cancel')->name('payhere.wallet.cancel');

    Route::any('/payhere/seller_package_payment/notify', 'sellerPackageNotify')->name('payhere.seller_package_payment.notify');
    Route::any('/payhere/seller_package_payment/return', 'sellerPackageReturn')->name('payhere.seller_package_payment.return');
    Route::any('/payhere/seller_package_payment/cancel', 'sellerPackageCancel')->name('payhere.seller_package_payment.cancel');

    Route::any('/payhere/customer_package_payment/notify', 'customer_package_notify')->name('payhere.customer_package_payment.notify');
    Route::any('/payhere/customer_package_payment/return', 'customer_package_return')->name('payhere.customer_package_payment.return');
    Route::any('/payhere/customer_package_payment/cancel', 'customer_package_cancel')->name('payhere.customer_package_payment.cancel');
});

//N-genius
Route::controller(NgeniusController::class)->group(function () {
    Route::any('ngenius/cart_payment_callback', 'cart_payment_callback')->name('ngenius.cart_payment_callback');
    Route::any('ngenius/order_re_payment_callback', 'order_re_payment_callback')->name('ngenius.order_re_payment_callback');
    Route::any('ngenius/wallet_payment_callback', 'wallet_payment_callback')->name('ngenius.wallet_payment_callback');
    Route::any('ngenius/customer_package_payment_callback', 'customer_package_payment_callback')->name('ngenius.customer_package_payment_callback');
    Route::any('ngenius/seller_package_payment_callback', 'seller_package_payment_callback')->name('ngenius.seller_package_payment_callback');
});

Route::controller(BkashController::class)->group(function () {
    Route::get('/bkash/create-payment', 'create_payment')->name('bkash.create_payment');
    Route::get('/bkash/callback', 'callback')->name('bkash.callback');
    Route::get('/bkash/success', 'success')->name('bkash.success');
});

Route::get('/checkout-payment-detail', [StripeController::class, 'checkout_payment_detail']);

//Nagad
Route::get('/nagad/callback', [NagadController::class, 'verify'])->name('nagad.callback');

//aamarpay
Route::controller(AamarpayController::class)->group(function () {
    Route::post('/aamarpay/success', 'success')->name('aamarpay.success');
    Route::post('/aamarpay/fail', 'fail')->name('aamarpay.fail');
});

//Authorize-Net-Payment
Route::post('/dopay/online', [AuthorizenetController::class, 'handleonlinepay'])->name('dopay.online');
Route::get('/authorizenet/cardtype', [AuthorizenetController::class, 'cardType'])->name('authorizenet.cardtype');

//payku
Route::get('/payku/callback/{id}', [PaykuController::class, 'callback'])->name('payku.result');

// Paymob
Route::any('/paymob/callback', [PaymobController::class, 'callback']);

// tap
Route::any('/tap/callback', [TapController::class, 'callback'])->name('tap.callback');

//Blog Section
Route::controller(BlogController::class)->group(function () {
    Route::get('/blog', 'all_blog')->name('blog');
    Route::get('/blog/{slug}', 'blog_details')->name('blog.details');
});

Route::controller(PageController::class)->group(function () {
    //mobile app balnk page for webview
    Route::get('/mobile-page/{slug}', 'mobile_custom_page')->name('mobile.custom-pages');

    //Custom page
    Route::get('/{slug}', 'show_custom_page')->name('custom-pages.show_custom_page');
});
Route::controller(ContactController::class)->group(function () {
    Route::post('/contact', 'contact')->name('contact');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/country-wise-division/{id}', 'countryWiseDivision')->name('country-wise-division');
    Route::get('/division-wise-district/{id}', 'divisionWiseDistrict')->name('division-wise-district');
    Route::get('/district-wise-upazila/{id}', 'districtWiseUpazila')->name('district-wise-upazila');
});
