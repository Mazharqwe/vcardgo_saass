<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Utility;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $setting = Utility::settings();
        $recaptcha = Utility::setCaptchaConfig();
        if ($setting['RECAPTCHA_MODULE'] == 'yes') 
        {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }else{
            $validation = [];
        }
        $this->validate($request, $validation);
        
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
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        try{
                $status = Password::sendResetLink(
                    $request->only('email')
                );

                return $status == Password::RESET_LINK_SENT
                            ? back()->with('status', __($status))
                            : back()->withInput($request->only('email'))
                                    ->withErrors(['email' => __($status)]);
        }
        catch(\Exception $e)
        {
            return redirect()->back()->withErrors('E-Mail has been not sent due to SMTP configuration');
        }
        
    }
}
