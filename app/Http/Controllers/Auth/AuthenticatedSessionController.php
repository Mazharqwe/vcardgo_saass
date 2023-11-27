<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use App\Models\Utility;
use App\Models\LoginDetail;

class AuthenticatedSessionController extends Controller
{
    public function __construct()
    {
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        }
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $setting = Utility::settings();
        $recaptcha = Utility::setCaptchaConfig();
        
        if ($setting['RECAPTCHA_MODULE'] == 'yes') {
            $validation['g-recaptcha-response'] = 'required|captcha';
        } else {
            $validation = [];
        }
        $this->validate($request, $validation);
        $request->authenticate();

        
        $userData=User::where('email', '=', $request->email)->first();

        //Email Verification 
        if(isset($setting['email_verification']) && $setting['email_verification'] == "on" && $userData->email_verified_at==null){
            try{
                $request->user()->sendEmailVerificationNotification();
            }
            catch(\Exception $e)
            {
                $smtp='E-Mail has been not sent due to SMTP configuration';
            }
        }
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->type == 'company') {
            $plan = Plan::find($user->plan);
            if ($plan) {
                if ($plan->duration != 'Lifetime') {
                    $datetime1 = $user->plan_expire_date;
                    $datetime2 = date('Y-m-d');
                    if (!empty($datetime1) && $datetime1 < $datetime2) {
                        $user->assignplan(1);

                        return redirect()->intended(RouteServiceProvider::HOME)->with('error', __('Your plan expired limit is over, please upgrade your plan.'));
                    }   
                }
            }
        }

        $ip = $_SERVER['REMOTE_ADDR']; // your ip address here

        //$ip = '49.36.83.154'; // This is static ip address

        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        if (isset($query['status']) && $query['status'] != 'fail') {
            $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
            if ($whichbrowser->device->type == 'bot') {
                return;
            }
            $referrer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : null;

            /* Detect extra details about the user */
            $query['browser_name'] = $whichbrowser->browser->name ?? null;
            $query['os_name'] = $whichbrowser->os->name ?? null;
            $query['browser_language'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            $query['device_type'] = get_device_type($_SERVER['HTTP_USER_AGENT']);
            $query['referrer_host'] = !empty($referrer['host']);
            $query['referrer_path'] = !empty($referrer['path']);

            isset($query['timezone']) ? date_default_timezone_set($query['timezone']) : '';


            $json = json_encode($query);
            if ($user->type != 'company' && $user->type != 'super admin') {
                $login_detail = new LoginDetail();
                $login_detail->user_id = Auth::user()->id;
                $login_detail->ip = $ip;
                $login_detail->date = date('Y-m-d H:i:s');
                $login_detail->Details = $json;
                $login_detail->created_by = \Auth::user()->creatorId();
                $login_detail->save();

            }
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function showLoginForm($lang = '')
    {
        if (empty($lang)) {
            $lang = Utility::getValByName('default_language');
        }
        \App::setLocale($lang);

        return view('auth.login', compact('lang'));
    }

    public function showLinkRequestForm($lang = '')
    {
        if (empty($lang)) {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.forgot-password', compact('lang'));
        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}