<?php

use App\Http\Controllers\MidtransController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\XenditPaymentController;
use App\Http\Controllers\YooKassaController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentDeatailController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PaymentWallPaymentController;
use App\Http\Controllers\MercadoPaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PaystackPaymentController;
use App\Http\Controllers\FlutterwavePaymentController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\PaytmPaymentController;
use App\Http\Controllers\MolliePaymentController;
use App\Http\Controllers\SkrillPaymentController;
use App\Http\Controllers\CoingatePaymentController;
use App\Http\Controllers\PlanRequestController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\ToyyibpayPaymentController;
use App\Http\Controllers\PayfastController;
use App\Http\Controllers\UserlogController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\bankTransferController;
use App\Http\Controllers\AiTemplateController;
use App\Http\Controllers\SspayController;
use App\Http\Controllers\IyziPayController;
use App\Http\Controllers\PaytabController;
use App\Http\Controllers\BenefitPaymentController;
use App\Http\Controllers\CashfreeController;
use App\Http\Controllers\AamarpayController;
use App\Http\Controllers\PaytrController;



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


require __DIR__ . '/auth.php';


Route::get('/', [HomeController::class, 'landingPage'])->middleware('XSS')->name('home');
Route::any('cookie_consent', [SystemController::class, 'CookieConsent'])->name('cookie-consent');
Route::any('card_cookie_consent', [BusinessController::class, 'cardCookieConsent'])->name('card-cookie-consent');

Route::group(['middleware' => ['verified']], function () {
    
    Route::get('/home', [HomeController::class, 'index'])->middleware('XSS', 'auth', 'CheckPlan')->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->middleware('XSS', 'auth', 'CheckPlan')->name('dashboard');
    Route::get('/dashboard/{id}', [HomeController::class, 'changeCurrantBusiness'])->name('business.change');
    Route::get('/appointment-calendar/{id?}', [AppointmentDeatailController::class, 'getCalenderAllData'])->middleware('XSS', 'auth')->name('appointment.calendar');

    Route::get('/appointment-note/{id?}', [AppointmentDeatailController::class, 'add_note'])->middleware('XSS', 'auth')->name('appointment.add-note');
    Route::post('/appointment-note-store/{id?}', [AppointmentDeatailController::class, 'note_store'])->middleware('XSS', 'auth')->name('appointment.note.store');
    Route::get('get-appointment-detail/{id}', [AppointmentDeatailController::class, 'getAppointmentDetails'])->middleware('XSS', 'auth')->name('appointment.details');

    Route::any('/get_appointment_data', [AppointmentDeatailController::class, 'get_appointment_data'])->middleware('XSS', 'auth')->name('get_appointment_data');

    Route::resource('business', BusinessController::class)->middleware('XSS', 'auth', 'CheckPlan');

    Route::middleware(['auth', 'XSS', 'CheckPlan'])->group(function () {
        Route::get('business/edit/{id}', [BusinessController::class,'edit'])->name('business.edit');
        //Route::get('business/edit', [BusinessController::class, 'edit'])->name('business.edit');
        Route::get('business/theme-edit/{id}', [BusinessController::class, 'edit2'])->name('business.edit2');
        Route::get('business/analytics/{id}', [BusinessController::class, 'analytics'])->name('business.analytics');
        Route::post('business/edit-theme/{id}', [BusinessController::class, 'editTheme'])->name('business.edit-theme');
        Route::post('business/domain-setting/{id}', [BusinessController::class, 'domainsetting'])->name('business.domain-setting');

        Route::resource('appointments', AppointmentDeatailController::class);
        Route::get('appoinments', [AppointmentDeatailController::class, 'index'])->name('appointments.index');


        Route::resource('users', UserController::class);
        Route::get('user/{id}/plan', [UserController::class, 'upgradePlan'])->name('plan.upgrade')->middleware('XSS');
        Route::get('user/{id}/plan/{pid}', [UserController::class, 'activePlan'])->name('plan.active');

        Route::get('business/preview/card/{slug}', [BusinessController::class, 'getcard'])->name('business.template');
        Route::delete('business/destroy/{id}', [BusinessController::class, 'destroy'])->name('business.destroy');

        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::post('edit-profile', [UserController::class, 'editprofile'])->name('update.account');

        Route::resource('systems', SystemController::class);
        Route::post('email-settings', [SystemController::class, 'saveEmailSettings'])->name('email.settings');
        Route::post('company-settings-store', [SystemController::class, 'storeCompanySetting'])->name('company.settings.store');
        Route::post('test-mail', [SystemController::class, 'testMail'])->name('test.mail')->middleware(['auth', 'XSS']);
        Route::post('test-mail/send', [SystemController::class, 'testSendMail'])->name('test.send.mail')->middleware(['auth', 'XSS']);

        Route::get('change-language/{lang}', [UserController::class, 'changeLanquage'])->name('change.language');
        Route::get('manage-language/{lang}', [LanguageController::class, 'manageLanguage'])->name('manage.language');
        Route::post('store-language-data/{lang}', [LanguageController::class, 'storeLanguageData'])->name('store.language.data');
        Route::get('create-language', [LanguageController::class, 'createLanguage'])->name('create.language');
        Route::post('store-language', [LanguageController::class, 'storeLanguage'])->name('store.language');
        Route::delete('/lang/{lang}', [LanguageController::class, 'destroyLang'])->name('lang.destroy');

        Route::get('applycoupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon')->middleware(['auth', 'XSS']);
        Route::resource('coupons', CouponController::class);

        //Role
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        //Contact Notes
        Route::get('/contact-note/{id?}', [ContactsController::class, 'add_note'])->middleware('XSS', 'auth')->name('contact.add-note');
        Route::post('/contact-note-store/{id?}', [ContactsController::class, 'note_store'])->middleware('XSS', 'auth')->name('contact.note.store');

        //Pixel
        Route::get('pixel/create/{id}', [BusinessController::class, 'pixel_create'])->name('pixel.create');
        Route::post('pixel', [BusinessController::class, 'pixel_store'])->name('pixel.store');
        Route::delete('pixel-delete/{id}', [BusinessController::class, 'pixeldestroy'])->name('pixel.destroy');

        Route::resource('userlogs', UserlogController::class);


        Route::resource('webhook', WebhookController::class);

        // Ai Chatgpt 
        Route::post('chatgptkey', [SystemController::class, 'chatgptkey'])->name('settings.chatgptkey');
        Route::get('generate/{template_name}', [AiTemplateController::class, 'create'])->name('generate');

        Route::post('generate/keywords/{id}', [AiTemplateController::class, 'getKeywords'])->name('generate.keywords');
        Route::post('generate/response', [AiTemplateController::class, 'aiGenerate'])->name('generate.response');

        Route::get('generate_ai_business/{template_name}/{id}', [AiTemplateController::class, 'create_business'])->name('generate_ai_business');
        Route::get('generate_ai/{template_name}/{id}', [AiTemplateController::class, 'create_service'])->name('generate_ai');
        Route::get('generate_ai_2/{template_name}/{id}', [AiTemplateController::class, 'create_testimonial'])->name('generate_ai_testimonial');


        //Company Email settings
        Route::post('company-email-settings', [SystemController::class, 'saveCompanyEmailSettings'])->name('company.email.settings');
        Route::post('business/status/{id}', 'BusinessController@ChangeStatus')->middleware(['auth'])->name('business.status');
        Route::get('user/{id}/business', [BusinessController::class, 'adminBusiness'])->name('business.upgrade')->middleware(['XSS','auth']);
        Route::post('business-unable', 'BusinessController@businessEnable')->name('business.unable')->middleware(['auth','XSS']);
        Route::get('user-login/{id}', 'UserController@LoginManage')->name('users.login')->middleware(['auth']);
        Route::get('users/{id}/login-with-company', 'UserController@LoginWithCompany')->name('login.with.company');
    });

    
    
    Route::post('stripe-settings', [SystemController::class, 'savePaymentSettings'])->middleware('XSS', 'auth')->name('payment.settings');
    Route::post('cookie_setting', [SystemController::class, 'saveCookieSettings'])->middleware('XSS', 'auth')->name('cookie.setting');


    Route::get('/stripe/{code}', [StripePaymentController::class, 'stripe'])->middleware('XSS', 'auth')->name('stripe');
    Route::post('/stripe', [StripePaymentController::class, 'stripePost'])->middleware('XSS', 'auth')->name('stripe.post');
    Route::get('/fetch-payment-intent', [StripePaymentController::class, 'fetchPaymentIntent'])->name('fetch.payment.intent');
    Route::get('/fetch-payment-method', [StripePaymentController::class, 'fetchPaymentMethod'])->name('fetch.payment.method');;
    Route::post('/store-payment-and-card-details', [StripePaymentController::class, 'storePaymentAndCardDetails'])->name('stripe.payment.success');
    Route::post('/assign-stripe-plan', [StripePaymentController::class, 'assignPlanAndRecordOrder'])->name('stripe.free.coupon');


    Route::get('order', [StripePaymentController::class, 'index'])->middleware('XSS', 'auth')->name('order.index');
    Route::any('/plan/error/{flag}', [PaymentWallPaymentController::class, 'paymenterror'])->name('callback.error');



    Route::any('plan-mercado-callback/{plan_id}', [MercadoPaymentController::class, 'mercadopagoPaymentCallback'])->middleware('auth')->name('plan.mercado.callback');
    Route::resource('plans', PlanController::class)->middleware('XSS');
    

    Route::get('business/{slug}/get_card', [BusinessController::class, 'cardpdf'])->name('get.card');
    Route::get('businessqr/download/', [BusinessController::class, 'downloadqr'])->middleware('XSS', 'auth')->name('download.qr');

    Route::post('business/block-setting/{id}', [BusinessController::class, 'blocksetting'])->middleware('XSS', 'auth')->name('business.block-setting');

    Route::any('order_destroy/{id}', [StripePaymentController::class, 'destroyOrder'])->middleware('XSS', 'auth')->name('order.destory');

    //================================= Custom Landing Page ====================================//




    Route::post('change-password', [UserController::class, 'updatePassword'])->name('update.password');


    // Route::get('/apply-coupon', [CouponController::class, 'applyCoupon'])->middleware('XSS','auth')->name('apply.coupon');



    Route::post('prepare-payment', [PlanController::class, 'preparePayment'])->middleware('XSS', 'auth')->name('prepare.payment');
    Route::get('/payment/{code}', [PlanController::class, 'payment'])->middleware('XSS', 'auth')->name('payment');

    Route::post('plan-pay-with-paypal', [PaypalController::class, 'planPayWithPaypal'])->middleware('XSS', 'auth')->name('plan.pay.with.paypal');


    //================================= Plan Payment Gateways  ====================================//



    Route::post('/plan-pay-with-paystack', [PaystackPaymentController::class, 'planPayWithPaystack'])->middleware('XSS', 'auth')->name('plan.pay.with.paystack');
    Route::get('/plan/paystack/{pay_id}/{plan_id}', [PaystackPaymentController::class, 'getPaymentStatus'])->name('plan.paystack');

    Route::post('/plan-pay-with-flaterwave', [FlutterwavePaymentController::class, 'planPayWithFlutterwave'])->middleware('XSS', 'auth')->name('plan.pay.with.flaterwave');
    Route::get('/plan/flaterwave/{txref}/{plan_id}', [FlutterwavePaymentController::class, 'getPaymentStatus'])->name('plan.flaterwave');

    Route::post('/plan-pay-with-razorpay', [RazorpayPaymentController::class, 'planPayWithRazorpay'])->middleware('XSS', 'auth')->name('plan.pay.with.razorpay');
    Route::get('/plan/razorpay/{txref}/{plan_id}', [RazorpayPaymentController::class, 'getPaymentStatus'])->name('plan.razorpay');

    Route::post('/plan-pay-with-paytm', [PaytmPaymentController::class, 'planPayWithPaytm'])->middleware('XSS', 'auth')->name('plan.pay.with.paytm');
    Route::post('plan/paytm/{plan}', [PaytmPaymentController::class, 'getPaymentStatus'])->name('plan.paytm', 'uses');

    Route::post('/plan-pay-with-mercado', [MercadoPaymentController::class, 'planPayWithMercado'])->middleware('XSS', 'auth')->name('plan.pay.with.mercado');
    Route::post('/plan/mercado', [MercadoPaymentController::class, 'getPaymentStatus'])->name('plan.mercado');

    Route::post('/plan-pay-with-mollie', [MolliePaymentController::class, 'planPayWithMollie'])->middleware('XSS', 'auth')->name('plan.pay.with.mollie');
    Route::get('/plan/mollie/{plan}/{price}', [MolliePaymentController::class, 'getPaymentStatus'])->name('plan.mollie');

    Route::post('/plan-pay-with-skrill', [SkrillPaymentController::class, 'planPayWithSkrill'])->middleware('XSS', 'auth')->name('plan.pay.with.skrill');
    Route::get('/plan/skrill/{plan}', [SkrillPaymentController::class, 'getPaymentStatus'])->name('plan.skrill');

    Route::post('/plan-pay-with-coingate', [CoingatePaymentController::class, 'planPayWithCoingate'])->middleware('XSS', 'auth')->name('plan.pay.with.coingate');
    Route::get('/plan/coingate/{plan}', [CoingatePaymentController::class, 'getPaymentStatus'])->name('plan.coingate');


    Route::get('{id}/{amount}/{coupons}   /plan-get-payment-status', [PaypalController::class, 'planGetPaymentStatus'])->middleware('XSS', 'auth')->name('plan.get.payment.status');

    Route::post('/plan-pay-with-toyyibpay', [ToyyibpayPaymentController::class, 'charge'])->name('plan.pay.with.toyyibpay')->middleware(['auth', 'XSS']);
    Route::get('/plan-get-payment-status/{id}/{amount}/{couponCode}', [ToyyibpayPaymentController::class, 'status'])->name('plan.status');

    Route::post('payfast-plan', [PayfastController::class, 'index'])->name('payfast.payment')->middleware(['auth']);
    Route::get('payfast-plan/{success}', [PayfastController::class, 'success'])->name('payfast.payment.success')->middleware(['auth']);
    // Route::post('payfast-payment', [PayfastController::class, 'PaymentPayfast'])->name('payfast.payment.coupon')->middleware(['auth']);


    Route::post('plan-pay-with-bank', [bankTransferController::class, 'planPayWithbank'])->middleware('XSS', 'auth')->name('plan.pay.with.bank');
    Route::get('order-view/{id}', [bankTransferController::class, 'viewOrder'])->middleware('XSS', 'auth')->name('view.status.bank');
    Route::get('assign_plan_status/{id}/{response}', [bankTransferController::class, 'ChangeStatus'])->middleware('XSS', 'auth')->name('change.status');

    //sspay 
    Route::post('sspay-prepare-plan', [SspayController::class, 'SspayPaymentPrepare'])->middleware(['auth'])->name('sspay.prepare.plan');
    Route::get('sspay-payment-plan/{plan_id}/{amount}/{couponCode}', [SspayController::class, 'SspayPlanGetPayment'])->middleware(['auth'])->name('plan.sspay.callback');
    //iyzipay
    Route::post('iyzipay/prepare', [IyziPayController::class, 'initiatePayment'])->name('iyzipay.payment.init');
    Route::post('iyzipay/callback/plan/{id}/{amount}/{coupan_code?}', [IyzipayController::class, 'iyzipayCallback'])->name('iyzipay.payment.callback');

    //paytab 
    Route::post('plan-pay-with-paytab', [PaytabController::class, 'planPayWithpaytab'])->middleware(['auth'])->name('plan.pay.with.paytab');
    Route::any('plan-paytab-success/', [PaytabController::class, 'PaytabGetPayment'])->middleware(['auth'])->name('plan.paytab.success');

    //Benefit
    Route::any('/payment/initiate', [BenefitPaymentController::class, 'initiatePayment'])->name('benefit.initiate');
    Route::any('call_back', [BenefitPaymentController::class, 'call_back'])->name('benefit.call_back');

    //Cashfree
    Route::post('cashfree/payments/store', [CashfreeController::class, 'cashfreePaymentStore'])->name('cashfree.payment');
    Route::any('cashfree/payments/success', [CashfreeController::class, 'cashfreePaymentSuccess'])->name('cashfreePayment.success');

    //aamarpay
	Route::post('/aamarpay/payment', [AamarpayController::class, 'pay'])->name('pay.aamarpay.payment');
    Route::any('/aamarpay/success/{data}', [AamarpayController::class, 'aamarpaysuccess'])->name('pay.aamarpay.success');

    //Paytr
	Route::post('/paytr/payment', [PaytrController::class, 'PlanpayWithPaytr'])->name('pay.paytr.payment');
   Route::any('/paytr/success', [PaytrController::class, 'paytrsuccess'])->name('pay.paytr.success');

   // Midtrans
    Route::any('/midtrans', [MidtransController::class, 'planPayWithMidtrans'])->name('plan.get.midtrans');
    Route::any('/midtrans/callback', [MidtransController::class, 'planGetMidtransStatus'])->name('plan.get.midtrans.status');

    // Xendit
    Route::any('/xendit/payment', [XenditPaymentController::class, 'planPayWithXendit'])->name('plan.xendit.payment');
    Route::any('/xendit/payment/status', [XenditPaymentController::class, 'planGetXenditStatus'])->name('plan.xendit.status');

    // YooKassa Plan
    Route::any('/plan/yookassa/payment', [YooKassaController::class,'planPayWithYooKassa'])->name('plan.pay.with.yookassa');
    Route::any('/plan/yookassa/{plan}', [YooKassaController::class,'planGetYooKassaStatus'])->name('plan.get.yookassa.status');

    //=================================Plan Request Module ====================================//

    Route::get('plan_request/index', [PlanRequestController::class, 'index'])->middleware('XSS', 'auth')->name('plan_request.index');
    Route::get('request_frequency/{id}', [PlanRequestController::class, 'requestView'])->middleware('XSS', 'auth')->name('request.view');
    Route::get('request_send/{id}', [PlanRequestController::class, 'userRequest'])->middleware('XSS', 'auth')->name('send.request');
    Route::get('request_response/{id}/{response}', [PlanRequestController::class, 'acceptRequest'])->middleware('XSS', 'auth')->name('response.request');
    Route::get('request_cancel/{id}', [PlanRequestController::class, 'cancelRequest'])->middleware('XSS', 'auth')->name('request.cancel');



    /*==================================Recaptcha====================================================*/

    Route::post('/recaptcha-settings', [SystemController::class, 'recaptchaSettingStore'])->middleware('XSS', 'auth')->name('recaptcha.settings.store');
    Route::post('/cache-clear', [SystemController::class, 'cacheClear'])->middleware('XSS', 'auth')->name('cache.settings.clear');

    /*====================================Contacts====================================================*/
    Route::get('/contacts/show', [ContactsController::class, 'index'])->middleware('XSS', 'auth')->name('contacts.index');
    Route::delete('/contacts/delete/{id}', [ContactsController::class, 'destroy'])->middleware('XSS', 'auth')->name('contacts.destroy');
    Route::get('/contacts/business/show{id}', [ContactsController::class, 'index'])->middleware('XSS', 'auth')->name('business.contacts.show');
    Route::get('/contacts/edit/{id}', [ContactsController::class, 'edit'])->middleware('XSS', 'auth')->name('contacts.edit');
    Route::post('/contacts/update/{id}', [ContactsController::class, 'update'])->middleware('XSS', 'auth')->name('Contacts.update');

    /*========================================================================================================================*/
    Route::post('business/custom-js-setting/{id}', [BusinessController::class, 'savejsandcss'])->name('business.custom-js-setting');
    Route::post('business/seo/{id}', [BusinessController::class, 'saveseo'])->name('business.seo-setting');
    Route::post('business/googlefont/{id}', [BusinessController::class, 'savegooglefont'])->name('business.googlefont-setting');
    Route::post('business/setpassword/{id}', [BusinessController::class, 'savepassword'])->name('business.password-setting');
    Route::post('business/setgdpr/{id}', [BusinessController::class, 'savegdpr'])->name('business.gdpr-setting');
    Route::post('business/setbranding/{id}', [BusinessController::class, 'savebranding'])->name('business.branding-setting');

    Route::get('businessqr/download/', [BusinessController::class, 'downloadqr'])->name('download.qr');

    Route::post('business/destroy/', [BusinessController::class, 'destroyGallery'])->name('destory.gallery');

    Route::post('business/pwa/{id}', [BusinessController::class, 'savePWA'])->name('business.pwa-setting');
    Route::post('business/cookie/{id}', [BusinessController::class, 'saveCookiesetting'])->name('business.cookie-setting');
    Route::post('business/custom_qrcode/{id}', [BusinessController::class, 'saveCustomQrsetting'])->name('business.qrcode_setting');
    /*==============================================================================================================================*/

    Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('user.reset');
    Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');



    /*=============================*/

    Route::post('paymentwall', [PaymentWallPaymentController::class, 'index'])->name('paymentwall');
    Route::post('plan-pay-with-paymentwall/{plan}', [PaymentWallPaymentController::class, 'planPayWithPaymentwall'])->name('plan.pay.with.paymentwall');

    Route::get('email_template_lang/{id}/{lang?}', [EmailTemplateController::class, 'manageEmailLang'])->middleware('XSS', 'auth')->name('manage.email.language');
    Route::put('email_template_lang/{id}/', [EmailTemplateController::class, 'updateEmailSettings'])->middleware('XSS', 'auth')->name('updateEmail.settings');

    Route::post('storage-settings', [SystemController::class, 'storageSettingStore'])->middleware('XSS', 'auth')->name('storage.setting.store');
    Route::post('/google-settings', [SystemController::class, 'saveGoogleCalendaSetting'])->name('setting.GoogleCalendaSetting')->middleware(['auth', 'XSS']);

    Route::get('export/appointment', [AppointmentDeatailController::class, 'export'])->name('appointments.export');


    // Language Disable
    Route::post('disable-language', [LanguageController::class, 'disableLang'])->name('disablelanguage')->middleware(['auth', 'XSS']);
});

 Route::get('/{slug}', [BusinessController::class, 'getcard']);
Route::get('/download/{slug}', [BusinessController::class, 'getVcardDownload'])->name('bussiness.save');
Route::post('appoinment/make-appointment', [AppointmentDeatailController::class, 'store'])->middleware('XSS')->name('appoinment.store');
Route::post('/contacts/store/', [ContactsController::class, 'store'])->name('contacts.store');