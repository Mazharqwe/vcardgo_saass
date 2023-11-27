<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utility;
use Illuminate\Support\Facades\Mail;
use App\Mail\testMail;
use Artisan;
use File;
use App\Models\Webhook;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Utility::settings();
        $timezones = config('timezones');
        $admin_payment_setting = Utility::getAdminPaymentSetting();

        $path = storage_path() . '/' . 'framework/';
        $size = \File::size(storage_path('/framework'));
        $file_size = 0;
        foreach (\File::allFiles(storage_path('/framework')) as $file) {
            $file_size += $file->getSize();
        }
        $file_size = number_format($file_size / 1000000, 4);

        $webhook = Webhook::get();
        if (\Auth::user()->type == 'super admin') {
            return view('settings.admin_settings', compact('settings', 'admin_payment_setting', 'file_size'));
        } else {
            return view('settings.index', compact('settings', 'timezones', 'webhook'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->logo) {


            $logoName = 'logo-dark.png';
            $dir = 'uploads/logo/';

            $validation = [
                'mimes:' . 'png',
                'max:' . '20480',
            ];
            $path = Utility::upload_file($request, 'logo', $logoName, $dir, $validation);
            if ($path['flag'] == 1) {
                $logo = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }
        }

        if ($request->landing_logo) {

            $landingLogoName = 'logo-light.png';
            $dir = 'uploads/logo/';
            $validation = [
                'mimes:' . 'png',
                'max:' . '20480',
            ];

            $path = Utility::upload_file($request, 'landing_logo', $landingLogoName, $dir, $validation);
            if ($path['flag'] == 1) {
                $logo_light = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }
        }
        if ($request->favicon) {

            $favicon = 'favicon.png';

            $dir = 'uploads/logo/';
            $validation = [
                'mimes:' . 'png',
                'max:' . '20480',
            ];

            $path = Utility::upload_file($request, 'favicon', $favicon, $dir, $validation);
            if ($path['flag'] == 1) {
                $favicon = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }
        }
        $arrEnv = [
            'SITE_RTL' => !isset($request->SITE_RTL) ? 'off' : 'on',
        ];
        $creatorId = \Auth::user()->creatorId();

        Utility::setEnvironmentValue($arrEnv);

        // Artisan::call('config:cache');
        // Artisan::call('config:clear');
        $settings = Utility::settings();
        if (!empty($request->title_text) || !empty($request->default_language) || isset($request->display_landing_page)) {
            $post = $request->all();
            if (!isset($request->SITE_RTL)) {
                $post['SITE_RTL'] = 'off';
            }

            if (!isset($request->signup_button)) {
                $post['signup_button'] = 'off';
            }
            if (!isset($request->email_verification)) {
                $post['email_verification'] = 'off';
            }
            if (!isset($request->cust_theme_bg)) {
                $post['cust_theme_bg'] = 'off';
            }
            if (!isset($request->cust_darklayout)) {
                $post['cust_darklayout'] = 'off';
            }
            if (!isset($request->display_landing_page)) {
                $post['display_landing_page'] = 'off';
            }

            unset($post['_token']);

            foreach ($post as $key => $data) {
                if (in_array($key, array_keys($settings))) {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                        [
                            $data,
                            $key,
                            $creatorId,
                        ]
                    );
                }
            }
        }
        return redirect()->back()->with('success', __('Brand Setting successfully save.'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function saveEmailSettings(Request $request)
    {
        $user = \Auth::user();
        $creatorId = \Auth::user()->creatorId();
        $settings = Utility::settings();
        $request->validate(
            [
                'mail_driver' => 'required|string|max:255',
                'mail_host' => 'required|string|max:255',
                'mail_port' => 'required|string|max:255',
                'mail_username' => 'required|string|max:255',
                'mail_password' => 'required|string|max:255',
                'mail_encryption' => 'required|string|max:255',
                'mail_from_address' => 'required|string|max:255',
                'mail_from_name' => 'required|string|max:255',
            ]
        );

        // $arrEnv = [
        //     'MAIL_DRIVER' => $request->mail_driver,
        //     'MAIL_HOST' => $request->mail_host,
        //     'MAIL_PORT' => $request->mail_port,
        //     'MAIL_USERNAME' => $request->mail_username,
        //     'MAIL_PASSWORD' => $request->mail_password,
        //     'MAIL_ENCRYPTION' => $request->mail_encryption,
        //     'MAIL_FROM_NAME' => $request->mail_from_name,
        //     'MAIL_FROM_ADDRESS' => $request->mail_from_address,
        // ];
        $arrEnv = [
            'mail_driver' => $request->mail_driver,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_name' => $request->mail_from_name,
            'mail_from_address' => $request->mail_from_address,
        ];
        foreach ($arrEnv as $key => $data) {
            if (in_array($key, array_keys($settings))) {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $data,
                        $key,
                        $creatorId,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', __('Setting successfully updated.'));

    }
    public function testMail(Request $request)
    {
        $user = \Auth::user();

        $data = [];
        $data['mail_driver'] = $request->mail_driver;
        $data['mail_host'] = $request->mail_host;
        $data['mail_port'] = $request->mail_port;
        $data['mail_username'] = $request->mail_username;
        $data['mail_password'] = $request->mail_password;
        $data['mail_encryption'] = $request->mail_encryption;
        $data['mail_from_address'] = $request->mail_from_address;
        $data['mail_from_name'] = $request->mail_from_name;
        return view('settings.test_mail', compact('data'));

    }


    public function testSendMail(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'mail_driver' => 'required',
                'mail_host' => 'required',
                'mail_port' => 'required',
                'mail_username' => 'required',
                'mail_password' => 'required',
                'mail_from_address' => 'required',
                'mail_from_name' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();


            return response()->json(
                [
                    'is_success' => false,
                    'message' => $messages->first(),
                ]
            );
        }
        try {
            config(
                [
                    'mail.driver' => $request->mail_driver,
                    'mail.host' => $request->mail_host,
                    'mail.port' => $request->mail_port,
                    'mail.encryption' => $request->mail_encryption,
                    'mail.username' => $request->mail_username,
                    'mail.password' => $request->mail_password,
                    'mail.from.address' => $request->mail_from_address,
                    'mail.from.name' => $request->mail_from_name,
                ]
            );
            Mail::to($request->email)->send(new testMail());
        } catch (\Exception $e) {

            return response()->json(
                [
                    'is_success' => false,
                    'message' => $e->getMessage(),
                ]
            );
        }

        return response()->json(
            [
                'is_success' => true,
                'message' => __('Email send Successfully'),
            ]
        );

    }
    public function saveCompanyEmailSettings(Request $request)
    {
        $user = \Auth::user();
        $creatorId = \Auth::user()->creatorId();
        $settings = Utility::settings();
        $request->validate(
            [
                'mail_driver' => 'required|string|max:255',
                'mail_host' => 'required|string|max:255',
                'mail_port' => 'required|string|max:255',
                'mail_username' => 'required|string|max:255',
                'mail_password' => 'required|string|max:255',
                'mail_encryption' => 'required|string|max:255',
                'mail_from_address' => 'required|string|max:255',
                'mail_from_name' => 'required|string|max:255',
            ]
        );

        $arrEnv = [
            'mail_driver' => $request->mail_driver,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_name' => $request->mail_from_name,
            'mail_from_address' => $request->mail_from_address,
        ];
        foreach ($arrEnv as $key => $data) {
            if (in_array($key, array_keys($settings))) {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $data,
                        $key,
                        $creatorId,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', __('Setting successfully updated.'));

    }
    public function savePaymentSettings(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'currency' => 'required|string',
                'currency_symbol' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $request->user = \Auth::user()->id;

        // Artisan::call('config:cache');
        // Artisan::call('config:clear');
        // Utility::setEnvironmentValue($arrEnv);

        self::adminPaymentSettings($request);


        return redirect()->back()->with('success', __('Payment setting successfully saved.'));

    }
    public function adminPaymentSettings($request)
    {
        $post['CURRENCY_SYMBOL'] = $request->currency_symbol;
        $post['CURRENCY'] = $request->currency;

        if (isset($request->is_stripe_enabled) && $request->is_stripe_enabled == 'on') {

            $request->validate(
                [
                    'stripe_key' => 'required|string|max:255',
                    'stripe_secret' => 'required|string|max:255',
                ]
            );

            $post['is_stripe_enabled'] = $request->is_stripe_enabled;
            $post['stripe_secret'] = $request->stripe_secret;
            $post['stripe_key'] = $request->stripe_key;
        } else {
            $post['is_stripe_enabled'] = 'off';
        }

        if (isset($request->is_paypal_enabled) && $request->is_paypal_enabled == 'on') {
            $request->validate(
                [
                    'paypal_mode' => 'required',
                    'paypal_client_id' => 'required',
                    'paypal_secret_key' => 'required',
                ]
            );

            $post['is_paypal_enabled'] = $request->is_paypal_enabled;
            $post['paypal_mode'] = $request->paypal_mode;
            $post['paypal_client_id'] = $request->paypal_client_id;
            $post['paypal_secret_key'] = $request->paypal_secret_key;
        } else {
            $post['is_paypal_enabled'] = 'off';
        }

        if (isset($request->is_paystack_enabled) && $request->is_paystack_enabled == 'on') {
            $request->validate(
                [
                    'paystack_public_key' => 'required|string',
                    'paystack_secret_key' => 'required|string',
                ]
            );
            $post['is_paystack_enabled'] = $request->is_paystack_enabled;
            $post['paystack_public_key'] = $request->paystack_public_key;
            $post['paystack_secret_key'] = $request->paystack_secret_key;
        } else {
            $post['is_paystack_enabled'] = 'off';
        }

        if (isset($request->is_flutterwave_enabled) && $request->is_flutterwave_enabled == 'on') {
            $request->validate(
                [
                    'flutterwave_public_key' => 'required|string',
                    'flutterwave_secret_key' => 'required|string',
                ]
            );
            $post['is_flutterwave_enabled'] = $request->is_flutterwave_enabled;
            $post['flutterwave_public_key'] = $request->flutterwave_public_key;
            $post['flutterwave_secret_key'] = $request->flutterwave_secret_key;
        } else {
            $post['is_flutterwave_enabled'] = 'off';
        }
        if (isset($request->is_razorpay_enabled) && $request->is_razorpay_enabled == 'on') {
            $request->validate(
                [
                    'razorpay_public_key' => 'required|string',
                    'razorpay_secret_key' => 'required|string',
                ]
            );
            $post['is_razorpay_enabled'] = $request->is_razorpay_enabled;
            $post['razorpay_public_key'] = $request->razorpay_public_key;
            $post['razorpay_secret_key'] = $request->razorpay_secret_key;
        } else {
            $post['is_razorpay_enabled'] = 'off';
        }



        if (isset($request->is_mercado_enabled) && $request->is_mercado_enabled == 'on') {
            $request->validate(
                [
                    'mercado_access_token' => 'required|string',
                ]
            );
            $post['is_mercado_enabled'] = $request->is_mercado_enabled;
            $post['mercado_access_token'] = $request->mercado_access_token;
            $post['mercado_mode'] = $request->mercado_mode;
        } else {
            $post['is_mercado_enabled'] = 'off';
        }

        if (isset($request->is_paytm_enabled) && $request->is_paytm_enabled == 'on') {
            $request->validate(
                [
                    'paytm_mode' => 'required',
                    'paytm_merchant_id' => 'required|string',
                    'paytm_merchant_key' => 'required|string',
                    'paytm_industry_type' => 'required|string',
                ]
            );
            $post['is_paytm_enabled'] = $request->is_paytm_enabled;
            $post['paytm_mode'] = $request->paytm_mode;
            $post['paytm_merchant_id'] = $request->paytm_merchant_id;
            $post['paytm_merchant_key'] = $request->paytm_merchant_key;
            $post['paytm_industry_type'] = $request->paytm_industry_type;
        } else {
            $post['is_paytm_enabled'] = 'off';
        }
        if (isset($request->is_mollie_enabled) && $request->is_mollie_enabled == 'on') {
            $request->validate(
                [
                    'mollie_api_key' => 'required|string',
                    'mollie_profile_id' => 'required|string',
                    'mollie_partner_id' => 'required',
                ]
            );
            $post['is_mollie_enabled'] = $request->is_mollie_enabled;
            $post['mollie_api_key'] = $request->mollie_api_key;
            $post['mollie_profile_id'] = $request->mollie_profile_id;
            $post['mollie_partner_id'] = $request->mollie_partner_id;
        } else {
            $post['is_mollie_enabled'] = 'off';
        }

        if (isset($request->is_skrill_enabled) && $request->is_skrill_enabled == 'on') {
            $request->validate(
                [
                    'skrill_email' => 'required|email',
                ]
            );
            $post['is_skrill_enabled'] = $request->is_skrill_enabled;
            $post['skrill_email'] = $request->skrill_email;
        } else {
            $post['is_skrill_enabled'] = 'off';
        }

        if (isset($request->is_coingate_enabled) && $request->is_coingate_enabled == 'on') {
            $request->validate(
                [
                    'coingate_mode' => 'required|string',
                    'coingate_auth_token' => 'required|string',
                ]
            );

            $post['is_coingate_enabled'] = $request->is_coingate_enabled;
            $post['coingate_mode'] = $request->coingate_mode;
            $post['coingate_auth_token'] = $request->coingate_auth_token;
        } else {
            $post['is_coingate_enabled'] = 'off';
        }
        if (isset($request->is_paymentwall_enabled) && $request->is_paymentwall_enabled == 'on') {
            $request->validate(
                [
                    'paymentwall_public_key' => 'required',
                    'paymentwall_private_key' => 'required',
                ]
            );
            $post['is_paymentwall_enabled'] = $request->is_paymentwall_enabled;
            $post['paymentwall_public_key'] = $request->paymentwall_public_key;
            $post['paymentwall_private_key'] = $request->paymentwall_private_key;
        } else {
            $post['is_paymentwall_enabled'] = 'off';
        }
        if (isset($request->is_toyyibpay_enabled) && $request->is_toyyibpay_enabled == 'on') {
            $request->validate(
                [
                    'toyyibpay_secret_key' => 'required',
                    'toyyibpay_category_code' => 'required',
                ]
            );
            $post['is_toyyibpay_enabled'] = $request->is_toyyibpay_enabled;
            $post['toyyibpay_secret_key'] = $request->toyyibpay_secret_key;
            $post['toyyibpay_category_code'] = $request->toyyibpay_category_code;
        } else {
            $post['is_toyyibpay_enabled'] = 'off';
        }

        if (isset($request->is_payfast_enabled) && $request->is_payfast_enabled == 'on') {

            $request->validate(
                [
                    'payfast_merchant_id' => 'required',
                    'payfast_merchant_key' => 'required',
                    'payfast_signature' => 'required',
                ]
            );
            $post['is_payfast_enabled'] = $request->is_payfast_enabled;
            $post['payfast_mode'] = $request->payfast_mode;
            $post['payfast_merchant_id'] = $request->payfast_merchant_id;
            $post['payfast_merchant_key'] = $request->payfast_merchant_key;
            $post['payfast_signature'] = $request->payfast_signature;
        } else {
            $post['is_payfast_enabled'] = 'off';
        }

        if (isset($request->is_manually_enabled) && $request->is_manually_enabled == 'on') {

            $post['is_manually_enabled'] = $request->is_manually_enabled;

        } else {
            $post['is_manually_enabled'] = 'off';
        }

        if (isset($request->is_bank_enabled) && $request->is_bank_enabled == 'on') {
            $request->validate(
                [
                    'bank_detail' => 'required',
                ]
            );
            $post['is_bank_enabled'] = $request->is_bank_enabled;
            $post['bank_detail'] = $request->bank_detail;
        } else {
            $post['is_bank_enabled'] = 'off';
        }
        //sspay
        if (isset($request->is_sspay_enabled) && $request->is_sspay_enabled == 'on') {
            $request->validate(
                [
                    'sspay_secret_key' => 'required',
                    'sspay_category_code' => 'required',
                ]
            );
            $post['is_sspay_enabled'] = $request->is_sspay_enabled;
            $post['sspay_secret_key'] = $request->sspay_secret_key;
            $post['sspay_category_code'] = $request->sspay_category_code;
        } else {
            $post['is_sspay_enabled'] = 'off';
        }

        //iyzipay
        if (isset($request->is_iyzipay_enabled) && $request->is_iyzipay_enabled == 'on') {
            $request->validate(
                [
                    'iyzipay_key' => 'required',
                    'iyzipay_secret' => 'required',
                ]
            );

            $post['is_iyzipay_enabled'] = $request->is_iyzipay_enabled;
            $post['iyzipay_mode'] = $request->iyzipay_mode;
            $post['iyzipay_key'] = $request->iyzipay_key;
            $post['iyzipay_secret'] = $request->iyzipay_secret;
        } else {
            $post['is_iyzipay_enabled'] = 'off';
        }

        //paytab
        
        if (isset($request->is_paytab_enabled) && $request->is_paytab_enabled == 'on') {
            $request->validate(
                [
                    'paytab_profile_id' => 'required',
                    'paytab_server_key' => 'required',
                    'paytab_region' => 'required',
                    
                ]
            );

            $post['is_paytab_enabled'] = $request->is_paytab_enabled;
            $post['paytab_profile_id'] = $request->paytab_profile_id;
            $post['paytab_server_key'] = $request->paytab_server_key;
            $post['paytab_region'] = $request->paytab_region;
        } else {
            $post['is_paytab_enabled'] = 'off';
        }

        //Benefit 
        if (isset($request->is_benefit_enabled) && $request->is_benefit_enabled == 'on') {
            $request->validate(
                [
                    'benefit_mode' => 'required',
                    'benefit_secret_key' => 'required',
                    'benefit_publishable_key' => 'required',
                ]
            );

            $post['is_benefit_enabled'] = $request->is_benefit_enabled;
            $post['benefit_mode'] = $request->benefit_mode;
            $post['benefit_secret_key'] = $request->benefit_secret_key;
            $post['benefit_publishable_key'] = $request->benefit_publishable_key;
        } else {
            $post['is_benefit_enabled'] = 'off';
        }
        
        //casefree
        if (isset($request->is_cashfree_enabled) && $request->is_cashfree_enabled == 'on') {

            $request->validate(
                [
                    'cashfree_key' => 'required|string|max:255',
                    'cashfree_secret' => 'required|string|max:255',
                ]
            );

            $post['is_cashfree_enabled'] = $request->is_cashfree_enabled;
            $post['cashfree_secret'] = $request->cashfree_secret;
            $post['cashfree_key'] = $request->cashfree_key;
        } else {
            $post['is_cashfree_enabled'] = 'off';
        }

         //Aamarpay 
         if (isset($request->is_aamarpay_enabled) && $request->is_aamarpay_enabled == 'on') {
            $request->validate(
                [
                    'aamarpay_store_id' => 'required',
                    'aamarpay_signature_key' => 'required',
                    'aamarpay_description' => 'required',
                ]
            );

            $post['is_aamarpay_enabled'] = $request->is_aamarpay_enabled;
            $post['aamarpay_store_id'] = $request->aamarpay_store_id;
            $post['aamarpay_signature_key'] = $request->aamarpay_signature_key;
            $post['aamarpay_description'] = $request->aamarpay_description;
        } else {
            $post['is_aamarpay_enabled'] = 'off';
        }

        //Paytr
        if (isset($request->is_paytr_enabled) && $request->is_paytr_enabled == 'on') {

            $request->validate(
                [
                    'paytr_merchant_id' => 'required',
                    'paytr_merchant_key' => 'required',
                    'paytr_merchant_salt' => 'required',
                ]
            );
            $post['is_paytr_enabled'] = $request->is_paytr_enabled;
            $post['paytr_merchant_id'] = $request->paytr_merchant_id;
            $post['paytr_merchant_key'] = $request->paytr_merchant_key;
            $post['paytr_merchant_salt'] = $request->paytr_merchant_salt;
        } else {
            $post['is_paytr_enabled'] = 'off';
        }

        //Midtrans
        if (isset($request->is_midtrans_enabled) && $request->is_midtrans_enabled == 'on') {

            $request->validate(
                [
                    'midtrans_secret_key' => 'required',
                ]
            );
            $post['is_midtrans_enabled'] = $request->is_midtrans_enabled;
            $post['midtrans_secret_key'] = $request->midtrans_secret_key;
        } else {
            $post['is_midtrans_enabled'] = 'off';
        }

        //Xendit
        if (isset($request->is_xendit_enabled) && $request->is_xendit_enabled == 'on') {

            $request->validate(
                [
                    'xendit_api_key' => 'required',
                    'xendit_token' => 'required'
                ]
            );
            $post['is_xendit_enabled'] = $request->is_xendit_enabled;
            $post['xendit_api_key'] = $request->xendit_api_key;
            $post['xendit_token'] = $request->xendit_token;
        } else {
            $post['is_xendit_enabled'] = 'off';
        }

        //YooKassa
        if (isset($request->is_yookassa_enabled) && $request->is_yookassa_enabled == 'on') {

            $request->validate(
                [
                    'yookassa_shop_id' => 'required',
                    'yookassa_secret_key' => 'required'
                ]
            );
            $post['is_yookassa_enabled'] = $request->is_yookassa_enabled;
            $post['yookassa_shop_id'] = $request->yookassa_shop_id;
            $post['yookassa_secret_key'] = $request->yookassa_secret_key;
        } else {
            $post['is_yookassa_enabled'] = 'off';
        }

        foreach ($post as $key => $data) {

            $arr = [
                $data,
                $key,
                $request->user,
            ];
            \DB::insert(
                'insert into admin_payment_settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );

        }


    }

    public function storeCompanySetting(Request $request)
    {
        
        if (\Auth::user()->can('manage company setting')) {
            $user = \Auth::user();
            if ($request->company_logo) {

                $image_path1 = 'uploads/logo/' . $request->company_logo;
                $image_size = $request->file('company_logo')->getSize();
                
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);

                if ($result == 1) {
                    $result = Utility::changeStorageLimit(\Auth::user()->creatorId(), $image_path1);
                    $logoName = 'company_logo' . time() . '.png';

                    $dir = 'uploads/logo/';

                    $validation = [
                        'mimes:' . 'png',
                        'max:' . '20480',
                    ];
                    $path = Utility::upload_file($request, 'company_logo', $logoName, $dir, $validation);

                    if ($path['flag'] == 1) {
                        $company_logo = $path['url'];
                    } else {
                        return redirect()->back()->with('error', __($path['msg']));
                    }
                    $company_logo = !empty($request->company_logo) ? $logoName : 'logo-dark.png';
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                        [
                            $logoName,
                            'company_logo',
                            \Auth::user()->id,
                        ]
                    );
                }
            }
            if ($request->company_logo_light) {

                $image_path1 = 'uploads/logo/' . $request->company_logo_light;
                $image_size = $request->file('company_logo_light')->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                if ($result == 1) {
                    $result = Utility::changeStorageLimit(\Auth::user()->creatorId(), $image_path1);
                    $logoName = 'company_logo_light_' . time() . '.png';

                    $dir = 'uploads/logo/';
                    $validation = [
                        'mimes:' . 'png',
                        'max:' . '20480',
                    ];

                    $path = Utility::upload_file($request, 'company_logo_light', $logoName, $dir, $validation);
                    if ($path['flag'] == 1) {
                        $logo_light = $path['url'];
                    } else {
                        return redirect()->back()->with('error', __($path['msg']));
                    }



                    $company_logo = !empty($request->logo_light) ? $logoName : 'company_logo_light.png';

                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                        [
                            $logoName,
                            'company_logo_light',
                            \Auth::user()->creatorId(),
                        ]
                    );
                }
            }
            if ($request->company_favicon) {

                $favicon = $user->id . '_favicon.png';
                $dir = 'uploads/logo/';
                $validation = [
                    'mimes:' . 'png',
                    'max:' . '20480',
                ];

                $path = Utility::upload_file($request, 'company_favicon', $favicon, $dir, $validation);
                if ($path['flag'] == 1) {
                    $company_favicon = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }


                $company_favicon = !empty($request->favicon) ? $favicon : 'favicon.png';

                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $favicon,
                        'company_favicon',
                        \Auth::user()->creatorId(),
                    ]
                );
            }


            $settings = Utility::settings();
            $post = $request->all();
            unset($post['_token'], $post['company_logo'], $post['company_favicon'], $post['company_logo_light']);

            if (!isset($request->SITE_RTL)) {
                $post['SITE_RTL'] = 'off';
            }

            if (!isset($request->cust_theme_bg)) {
                $post['cust_theme_bg'] = 'off';
            }
            if (!isset($request->cust_darklayout)) {
                $post['cust_darklayout'] = 'off';
            }

            unset($post['_token']);

            foreach ($post as $key => $data) {
                if (in_array($key, array_keys($settings)) && !empty($data)) {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                        [
                            $data,
                            $key, \Auth::user()->id,
                        ]
                    );
                }
            }
            $arrEnv = [
                'SITE_RTL' => !isset($request->SITE_RTL) ? 'off' : 'on',
            ];
            // Utility::setEnvironmentValue($arrEnv);

            // $arrEnv = [
            //     'APP_TIMEZONE' => $request->timezone,
            // ];

            //Utility::setEnvironmentValue($arrEnv);
            return redirect()->back()->with('success', __('Setting save successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function recaptchaSettingStore(Request $request)
    {
        $user = \Auth::user();
        $creatorId = \Auth::user()->creatorId();
        $request->user = $creatorId; 
        $rules = [];

        if ($request->recaptcha_module == 'yes') {
            $rules['google_recaptcha_key'] = 'required|string|max:50';
            $rules['google_recaptcha_secret'] = 'required|string|max:50';
        }

        $validator = \Validator::make(
            $request->all(),
            $rules
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $arrEnv = [
            'RECAPTCHA_MODULE' => $request->recaptcha_module ?? 'no',
            'NOCAPTCHA_SITEKEY' => $request->google_recaptcha_key,
            'NOCAPTCHA_SECRET' => $request->google_recaptcha_secret,
        ];

        foreach ($arrEnv as $key => $data) {

            $arr = [
                $data,
                $key,
                $request->user,
            ];
            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );

        }
        return redirect()->back()->with('success', __('Recaptcha Settings updated successfully'));

    }
    public function storageSettingStore(Request $request)
    {

        if (isset($request->storage_setting) && $request->storage_setting == 'local') {

            $request->validate(
                [

                    'local_storage_validation' => 'required',
                    'local_storage_max_upload_size' => 'required',
                ]
            );

            $post['storage_setting'] = $request->storage_setting;
            $local_storage_validation = implode(',', $request->local_storage_validation);
            $post['local_storage_validation'] = $local_storage_validation;
            $post['local_storage_max_upload_size'] = $request->local_storage_max_upload_size;

        }

        if (isset($request->storage_setting) && $request->storage_setting == 's3') {
            $request->validate(
                [
                    's3_key' => 'required',
                    's3_secret' => 'required',
                    's3_region' => 'required',
                    's3_bucket' => 'required',
                    's3_url' => 'required',
                    's3_endpoint' => 'required',
                    's3_max_upload_size' => 'required',
                    's3_storage_validation' => 'required',
                ]
            );
            $post['storage_setting'] = $request->storage_setting;
            $post['s3_key'] = $request->s3_key;
            $post['s3_secret'] = $request->s3_secret;
            $post['s3_region'] = $request->s3_region;
            $post['s3_bucket'] = $request->s3_bucket;
            $post['s3_url'] = $request->s3_url;
            $post['s3_endpoint'] = $request->s3_endpoint;
            $post['s3_max_upload_size'] = $request->s3_max_upload_size;
            $s3_storage_validation = implode(',', $request->s3_storage_validation);
            $post['s3_storage_validation'] = $s3_storage_validation;
        }

        if (isset($request->storage_setting) && $request->storage_setting == 'wasabi') {
            $request->validate(
                [
                    'wasabi_key' => 'required',
                    'wasabi_secret' => 'required',
                    'wasabi_region' => 'required',
                    'wasabi_bucket' => 'required',
                    'wasabi_url' => 'required',
                    'wasabi_root' => 'required',
                    'wasabi_max_upload_size' => 'required',
                    'wasabi_storage_validation' => 'required',
                ]
            );
            $post['storage_setting'] = $request->storage_setting;
            $post['wasabi_key'] = $request->wasabi_key;
            $post['wasabi_secret'] = $request->wasabi_secret;
            $post['wasabi_region'] = $request->wasabi_region;
            $post['wasabi_bucket'] = $request->wasabi_bucket;
            $post['wasabi_url'] = $request->wasabi_url;
            $post['wasabi_root'] = $request->wasabi_root;
            $post['wasabi_max_upload_size'] = $request->wasabi_max_upload_size;
            $wasabi_storage_validation = implode(',', $request->wasabi_storage_validation);
            $post['wasabi_storage_validation'] = $wasabi_storage_validation;
        }

        foreach ($post as $key => $data) {

            $arr = [
                $data,
                $key,
                \Auth::user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }

        return redirect()->back()->with('success', 'Storage setting successfully updated.');

    }

    public function saveGoogleCalendaSetting(Request $request)
    {
        if (\Auth::user()->can('manage company setting')) {
            $Google_Calendar = (!empty($request->Google_Calendar) && $request->Google_Calendar == 'on') ? 'on' : 'off';

            $post['Google_Calendar'] = $Google_Calendar;


            if ($request->google_calender_json_file) {

                $dir = storage_path() . '/' . md5(time());
                if (!is_dir($dir)) {
                    File::makeDirectory($dir, $mode = 0777, true, true);
                }
                $file_name = $request->google_calender_json_file->getClientOriginalName();
                $file_path = md5(time()) . '/' . md5(time()) . "." . $request->google_calender_json_file->getClientOriginalExtension();

                $file = $request->file('google_calender_json_file');
                $file->move($dir, $file_path);
                $post['google_calender_json_file'] = $file_path;
            }
            if ($request->google_calender_id) {
                $post['google_calender_id'] = $request->google_calender_id;
                foreach ($post as $key => $data) {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                        [
                            $data,
                            $key,
                            \Auth::user()->id,
                            date('Y-m-d H:i:s'),
                            date('Y-m-d H:i:s'),
                        ]
                    );
                }
            }
            return redirect()->back()->with('success', 'Google calender setting successfully updated.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function cacheClear(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        return redirect()->back()->with('success', 'Cache clear successfully');
    }

    public function saveCookieSettings(Request $request)
    {

        $validator = \Validator::make(
            $request->all(),
            [
                'cookie_title' => 'required',
                'cookie_description' => 'required',
                'strictly_cookie_title' => 'required',
                'strictly_cookie_description' => 'required',
                'more_information_title' => 'required',
                'contactus_url' => 'required',
            ]
        );

        $post = $request->all();

        unset($post['_token']);

        if ($request->enable_cookie) {
            $post['enable_cookie'] = 'on';
        } else {
            $post['enable_cookie'] = 'off';
        }
        if ($request->cookie_logging) {
            $post['cookie_logging'] = 'on';
        } else {
            $post['cookie_logging'] = 'off';
        }

        $post['cookie_title'] = $request->cookie_title;
        $post['cookie_description'] = $request->cookie_description;
        $post['strictly_cookie_title'] = $request->strictly_cookie_title;
        $post['strictly_cookie_description'] = $request->strictly_cookie_description;
        $post['more_information_title'] = $request->more_information_title;
        $post['contactus_url'] = $request->contactus_url;

        $settings = Utility::settings();
        foreach ($post as $key => $data) {

            if (in_array($key, array_keys($settings))) {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $data,
                        $key,
                        \Auth::user()->creatorId(),
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s'),
                    ]
                );
            }
        }
        return redirect()->back()->with('success', 'Cookie setting successfully saved.');
    }

    public function CookieConsent(Request $request)
    {
        $settings = Utility::settings();
        if ($request['cookie'] && is_array($request['cookie'])) {
            if ($settings['enable_cookie'] == "on" && $settings['cookie_logging'] == "on") {
                $allowed_levels = ['necessary', 'analytics', 'targeting'];
                $levels = array_filter($request['cookie'], function ($level) use ($allowed_levels) {
                    return in_array($level, $allowed_levels);
                });

                $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
                // Generate new CSV line
                $browser_name = $whichbrowser->browser->name ?? null;
                $os_name = $whichbrowser->os->name ?? null;
                $browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
                $device_type = get_device_type($_SERVER['HTTP_USER_AGENT']);

                $ip = $_SERVER['REMOTE_ADDR'];
                //$ip = '49.36.83.154';
                $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));


                $date = (new \DateTime())->format('Y-m-d');
                $time = (new \DateTime())->format('H:i:s') . ' UTC';


                $new_line = implode(',', [
                    $ip,
                    $date,
                    $time,
                    json_encode($request['cookie']),
                    $device_type,
                    $browser_language,
                    $browser_name,
                    $os_name,
                    isset($query) ? $query['country'] : '', isset($query) ? $query['region'] : '', isset($query) ? $query['regionName'] : '', isset($query) ? $query['city'] : '', isset($query) ? $query['zip'] : '', isset($query) ? $query['lat'] : '', isset($query) ? $query['lon'] : ''
                ]);
                if (!file_exists(storage_path() . '/uploads/sample/data.csv')) {

                    $first_line = 'IP,Date,Time,Accepted cookies,Device type,Browser language,Browser name,OS Name,Country,Region,RegionName,City,Zipcode,Lat,Lon';
                    file_put_contents(storage_path() . '/uploads/sample/data.csv', $first_line . PHP_EOL, FILE_APPEND | LOCK_EX);
                }
                file_put_contents(storage_path() . '/uploads/sample/data.csv', $new_line . PHP_EOL, FILE_APPEND | LOCK_EX);

                return response()->json('success');
            }
            return response()->json('error');
        }
        return redirect()->back();
    }

    //ChatGtp Key setting
    public function chatgptkey(Request $request)
    {
        if (\Auth::user()->type == 'super admin') {
            $user = \Auth::user();
            if (!empty($request->chatgpt_key)) {
                $post = $request->all();
                $post['chatgpt_key'] = $request->chatgpt_key;

                unset($post['_token']);
                foreach ($post as $key => $data) {
                    $settings = Utility::settings();
                    if (in_array($key, array_keys($settings))) {
                        \DB::insert(
                            'insert into settings (`name`, `value`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                            [
                                $key,
                                $data,
                                \Auth::user()->creatorId(),
                            ]
                        );
                    }
                }
            }
            return redirect()->back()->with('success', __('Chatgpykey successfully saved.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

}