<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Utility;
use File;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage plan'))
        { 
            \App::setLocale(\Auth::user()->currentLanguage());
            $users = \Auth::user();
            $currantLang = $users->currentLanguage();
            $plans = Plan::get();
            $admin_payment_setting = Utility::getAdminPaymentSetting();

            return view('plan.index', compact('plans', 'admin_payment_setting','currantLang','users'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
    public function create()
    {
        $arrDuration = [
            'Lifetime' => __('Lifetime'),
            'Month' => __('Per Month'),
            'Year' => __('Per Year'),
        ];

        return view('plan.create', compact('arrDuration'));
    }
    public function store(Request $request)
    {
        $admin_payment_setting = Utility::getAdminPaymentSetting();

        if($admin_payment_setting['is_stripe_enabled'] == 'on' ||  $admin_payment_setting['is_paypal_enabled'] == 'on' ||  $admin_payment_setting['is_paystack_enabled'] == 'on' ||  $admin_payment_setting['is_flutterwave_enabled'] == 'on' ||  $admin_payment_setting['is_razorpay_enabled'] == 'on' ||  $admin_payment_setting['is_mercado_enabled'] == 'on' ||  $admin_payment_setting['is_paytm_enabled'] == 'on' ||  $admin_payment_setting['is_mollie_enabled'] == 'on' ||  $admin_payment_setting['is_skrill_enabled'] == 'on' ||  $admin_payment_setting['is_coingate_enabled'] == 'on')
        {
            $post = $request->all();
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|unique:plans',
                    'duration' => 'required',
                    'price' => 'required',
                    'themes'=>'required',
                    'business'=>'required',
                    'max_users'=>'required',
                    'storage_limit'=>'required',
                    ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }
                if($request->has('themes')){
                    $post['themes'] = implode(',',$request->themes);
                }
            if(!isset($request->enable_custdomain))
            {
                $post['enable_custdomain'] = 'off';
            }
            if(!isset($request->enable_custsubdomain))
            {
                $post['enable_custsubdomain'] = 'off';
            }
            if(!isset($request->enable_branding))
            {
                $post['enable_branding'] = 'off';
            }
            if(!isset($request->pwa_business))
            {
                $post['pwa_business'] = 'off';
            }
            if(!isset($request->enable_qr_code))
            {
                $post['enable_qr_code'] = 'off';
            }
            if(!isset($request->enable_chatgpt))
            {
                $post['enable_chatgpt'] = 'off';
            }
            //dd($post);
            if(Plan::create($post))
            {
                return redirect()->back()->with('success', __('Plan Successfully created.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        }
        else
            {
                return redirect()->back()->with('error', __('Please set stripe or paypal api key & secret key for add new plan.'));
            }

        }

        public function edit($plan_id)
        {
            $arrDuration = [
                'Lifetime' => __('Lifetime'),
                'Month' => __('Per Month'),
                'Year' => __('Per Year'),
            ];
            $plan        = Plan::find($plan_id);

        return view('plan.edit', compact('plan', 'arrDuration'));
    }


    public function update(Request $request, $plan_id)
    {

        
        $admin_payment_setting = Utility::paySettings();

        if(($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on' || $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on' || $admin_payment_setting['is_paytm_enabled'] == 'on' || $admin_payment_setting['is_mollie_enabled'] == 'on' || $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on') || $request->price <= 0)
        {
            $plan = Plan::find($plan_id);
            if(!empty($plan))
            {
                $validator = \Validator::make(
                    $request->all(), [
                        'name' => 'required|unique:plans,name,' . $plan_id,
                        'duration' => 'required',
                        'themes'=>'required',
                    ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }
                $post = $request->all();
                if($request->has('themes')){
                    $post['themes'] = implode(',',$request->themes);
                }
                if(!isset($request->enable_custdomain))
                {
                    $post['enable_custdomain'] = 'off';
                }
                if(!isset($request->enable_custsubdomain))
                {
                    $post['enable_custsubdomain'] = 'off';
                }
                if(!isset($request->enable_branding))
                {
                    $post['enable_branding'] = 'off';
                }
                if(!isset($request->pwa_business))
                {
                    $post['pwa_business'] = 'off';
                }
                if(!isset($request->enable_qr_code))
                {
                    $post['enable_qr_code'] = 'off';
                }
                if(!isset($request->enable_chatgpt))
                {
                    $post['enable_chatgpt'] = 'off';
                }
                
                if($plan->update($post))
                {
                    return redirect()->back()->with('success', __('Plan successfully updated.'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Something is wrong.'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('Plan not found.'));
            }
        }
        else
            {
            return redirect()->back()->with('error', __('Please set stripe api key & secret key for add new plan.'));
        }
    }

    public function userPlan(Request $request)
    {
        $objUser = \Auth::user();

        $planID  = \Illuminate\Support\Facades\Crypt::decrypt($request->code);
        $plan    = Plan::find($planID);

        if($plan)
        {
            if($plan->price <= 0)
            {
                $objUser->assignPlan($plan->id);

                return redirect()->route('plans.index')->with('success', __('Plan successfully activated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Plan not found.'));
        }
    }
    public function payment($code)
    {
        if(\Auth::user()->can('buy plan'))
        {   
            try {
                $planID = \Illuminate\Support\Facades\Crypt::decrypt($code);
                $plan   = Plan::find($planID);
                if($plan)
                {
                    return redirect()->route('stripe', compact('code'))->with('error', __('Your Payment has failed!'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Plan is deleted.'));
                }  
            } catch (\Throwable $th) {
                return redirect()->route('plans.index')->with('error', __('Plan not found!'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
}
