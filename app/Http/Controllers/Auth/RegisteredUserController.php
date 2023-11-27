<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if(Utility::getValByName('signup_button') == 'on'){
            return view('auth.register');
        }else{
            return abort('404', 'Page not found');
        }
        
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $setting = Utility::settings();
        $recaptcha = Utility::setCaptchaConfig();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' =>'required',
        ]);
        if ($setting['RECAPTCHA_MODULE'] == 'yes') 
        {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }else{
            $validation = [];
        }
        $this->validate($request, $validation);
        $role = Role::findByName('company');
        
    
        
        if(isset($setting['email_verification']) && $setting['email_verification']=='on' )
        {
           
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => $role->name,
                'lang' => Utility::getValByName('default_language'),
                'created_by' => 1,
            ]);
        }else{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'type' => $role->name,
                'lang' => Utility::getValByName('default_language'),
                'created_by' => 1,
            ]);
            $userArr = [
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_password' => $request->password,
                'user_type' => $user->type,
                'created_by' => $user->created_by,
            ];
           
        }
        
        $user->assignRole($role);
        //event(new Registered($user));

        Auth::login($user);
        if($setting['email_verification']=='off' )
        {   
            try {
                $resp = \Utility::sendEmailTemplateUser('User Created', $userArr, $user->email);
            } catch (\Exception $e) {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

        }
        config(
            [
                'mail.driver' => $setting['mail_driver'],
                'mail.host' => $setting['mail_host'],
                'mail.port' => $setting['mail_port'],
                'mail.encryption' => $setting['mail_encryption'],
                'mail.username' => $setting['mail_username'],
                'mail.password' => $setting['mail_password'],
                'mail.from.address' => $setting['mail_from_address'],
                'mail.from.name' => $setting['mail_from_name'],
            ]
        );
        try{
            event(new Registered($user));
        }catch(\Exception $e){
            $user->delete();
            return redirect('/register/lang?')->with('status', __('Email SMTP settings does not configure so please contact to your site admin.'));
        }
        //return view('auth.verify-email');

        return redirect(RouteServiceProvider::HOME);
    }

    public function showRegistrationForm($lang = '')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }
        \App::setLocale($lang);

      
        if(Utility::getValByName('signup_button')=='on'){
            return view('auth.register', compact('lang'));
        }
        else{
            return abort('404', 'Page not found');
        }
    }
}
