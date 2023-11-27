<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Order;
use App\Models\PlanOrder;
use App\Models\UserCoupon;
use App\Models\Plan;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MercadoPaymentController extends Controller
{
    public $mercado_access_token;
    public $mercado_mode;
    public $is_enabled;


    public function paymentConfig()
    {
        if(\Auth::user()->type == 'company')
        {
            $payment_setting = Utility::getAdminPaymentSetting();
        }
        else
        {
            $payment_setting = Utility::getCompanyPaymentSetting();
        }

        $this->mercado_access_token = isset($payment_setting['mercado_access_token']) ? $payment_setting['mercado_access_token'] : '';
        
        $this->mercado_mode = isset($payment_setting['mercado_mode']) ? $payment_setting['mercado_mode'] : '';
        $this->is_enabled = isset($payment_setting['is_mercado_enabled']) ? $payment_setting['is_mercado_enabled'] : 'off';

        return $this;
    }

    public function planPayWithMercado(Request $request)
    {

        $payment = $this->paymentConfig();
        $planID     = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan       = Plan::find($planID);
        $authuser   = Auth::user();
        $adminPaymentSettings = Utility::getAdminPaymentSetting();
        $coupons_id = '';
        if($plan)
        {
            $price = $plan->price;
            if(isset($request->coupon) && !empty($request->coupon))
            {
                $request->coupon = trim($request->coupon);
                $coupons         = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                if(!empty($coupons))
                {
                    $usedCoupun             = $coupons->used_coupon();
                    $discount_value         = ($price / 100) * $coupons->discount;
                    $plan->discounted_price = $price - $discount_value;
                    $coupons_id             = $coupons->id;
                    if($usedCoupun >= $coupons->limit)
                    {
                        return redirect()->back()->with('error', __('This coupon code has expired.'));
                    }
                    $price = $price - $discount_value;
                }
                else
                {
                    return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                }
            }

            if($price <= 0)
            {


                $authuser->plan = $plan->id;
                $authuser->save();

                $assignPlan = $authuser->assignPlan($plan->id);

                if($assignPlan['is_success'] == true && !empty($plan))
                {

                    $orderID = time();
                    PlanOrder::create(
                        [
                            'order_id' => $orderID,
                            'name' => null,
                            'email' => null,
                            'card_number' => null,
                            'card_exp_month' => null,
                            'card_exp_year' => null,
                            'plan_name' => $plan->name,
                            'plan_id' => $plan->id,
                            'price' => $price == null ? 0 : $price,
                            'price_currency' => !empty($adminPaymentSettings['CURRENCY']) ? $adminPaymentSettings['CURRENCY'] : 'USD',
                            'txn_id' => '',
                            'payment_type' => 'Mercado',
                            'payment_status' => 'succeeded',
                            'receipt' => null,
                            'user_id' => $authuser->id,
                        ]
                    );
                    // $res['msg']  = __("Plan successfully upgraded.");
                    // $res['flag'] = 2;
                    return redirect()->route('plans.index')->with('success',__('Plan Successfully Activated'));
                    //return $res;
                }
                else
                {
                    return Utility::error_res(__('Plan fail to upgrade.'));
                }
            }
           
            \MercadoPago\SDK::setAccessToken($payment->mercado_access_token);
            try
            {
                $amount = (float)$price;
                // Create a preference object
                $preference = new \MercadoPago\Preference();
                // Create an item in the preference
                $item              = new \MercadoPago\Item();
                $item->title       = "Plan : " . $plan->name;
                $item->quantity    = 1;
                $item->unit_price  = $amount;
                $preference->items = array($item);
               
                $success_url       = route(
                    'plan.mercado.callback', [
                                               encrypt($plan->id),
                                               'coupon_id=' . $coupons_id,
                                               'flag' => 'success',
                                           ]
                );
                $failure_url       = route(
                    'plan.mercado.callback', [
                                               encrypt($request->plan),
                                               'flag' => 'failure',
                                           ]
                );
                $pending_url       = route(
                    'plan.mercado.callback', [
                                               encrypt($request->plan),
                                               'flag' => 'pending',
                                           ]
                );

                $preference->back_urls = array(
                    "success" => $success_url,
                    "failure" => $failure_url,
                    "pending" => $pending_url,
                );

                $preference->auto_return = "approved";
                $preference->save();

                // Create a customer object
                $payer = new \MercadoPago\Payer();
                // Create payer information
                $payer->name    = \Auth::user()->name;
                $payer->email   = \Auth::user()->email;
                $payer->address = array(
                    "street_name" => '',
                );
                if($payment->mercado_mode == 'live')
                {
                    $redirectUrl = $preference->init_point;
                }
                else
                {
                    $redirectUrl = $preference->sandbox_init_point;
                }

                return redirect($redirectUrl);
            }
            catch(Exception $e)
            {
                return redirect()->back()->with('error', $e->getMessage());
            }


        }
        else
        {
            return redirect()->back()->with('error', 'Plan is deleted.');
        }

    }

    // Mercado mercadopagoPaymentCallback
    public function mercadopagoPaymentCallback($plan, Request $request)
    {
        $user                  = \Auth::user();
        $admin_payment_setting = Utility::getAdminPaymentSetting();
        $plan_id               = \Illuminate\Support\Facades\Crypt::decrypt($plan);
        $plan                  = Plan::find($plan_id);

        if($plan)
        {
            $orderID = time();
            if($plan && $request->has('status'))
            {
                $price = $plan->price;
                if($request->status == 'approved' && $request->flag == 'success')
                {
                    if($request->has('coupon_id') && $request->coupon_id != '')
                    {
                        $coupons = Coupon::find($request->coupon_id);
                        if(!empty($coupons))
                        {
                            $userCoupon            = new UserCoupon();
                            $userCoupon->user   = $user->id;
                            $userCoupon->coupon = $coupons->id;
                            $userCoupon->order  = $orderID;
                            $userCoupon->save();
                            $usedCoupun             = $coupons->used_coupon();
                            $discount_value         = ($price / 100) * $coupons->discount;
                            $plan->discounted_price = $price - $discount_value;
                            $coupons_id             = $coupons->id;
                            if($coupons->limit <= $usedCoupun)
                            {
                                    $coupons->is_active = 0;
                                    $coupons->save();
                            }
                            if($usedCoupun >= $coupons->limit)
                            {
                                return redirect()->back()->with('error', __('This coupon code has expired.'));
                            }
                            $price = $price - $discount_value;
                        }
                    }

                    $orderID = time();
                    PlanOrder::create(
                        [
                            'order_id' => $orderID,
                            'name' => $user->name,
                            'email' => null,
                            'card_number' => null,
                            'card_exp_month' => null,
                            'card_exp_year' => null,
                            'plan_name' => $plan->name,
                            'plan_id' => $plan->id,
                            'price' => $price == null ? 0 : $price,
                            'price_currency' => !empty($admin_payment_setting['CURRENCY']) ? $admin_payment_setting['CURRENCY'] : 'USD',
                            'txn_id' => $request->has('preference_id') ? $request->preference_id : '',
                            'payment_type' => 'Mercado',
                            'payment_status' => 'succeeded',
                            'receipt' => null,
                            'user_id' => $user->id,
                        ]
                    );

                    $assignPlan = $user->assignPlan($plan->id);

                    if($assignPlan['is_success'])
                    {
                        return redirect()->route('plans.index')->with('success', __('Plan activated Successfully.'));
                    }
                    else
                    {
                        return redirect()->route('plans.index')->with('error', $assignPlan['error']);
                    }
                }
                else
                {
                    return redirect()->back()->with('error', __('Transaction Unsuccesfull'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('Transaction Unsuccesfull'));
            }

            session()->forget('mollie_payment_id');
        }
        else
        {
            return redirect()->route('plans.index')->with('error', __('Transaction Unsuccesfull.'));
        }
    }

    public function invoicePayWithMercado(Request $request)
    {

        $orderID   = strtoupper(str_replace('.', '', uniqid('', true)));
        $payment   = $this->paymentConfig();
        $settings  = DB::table('settings')->where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('value', 'name');
        $invoiceID = \Illuminate\Support\Facades\Crypt::decrypt($request->invoice_id);
        $invoice   = Invoice::find($invoiceID);
        $authuser  = \Auth::user();

        if($invoice)
        {
            $price = $request->amount;

            if($price > 0)
            {
                $preference_data = array(
                    "items" => array(
                        array(
                            "title" => __('Invoice') . ' ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                            "quantity" => 1,
                            "currency_id" => Utility::getValByName('site_currency'),
                            "unit_price" => (float)$price,
                        ),
                    ),
                );

                try
                {
                    $mp         = new MP($this->app_id, $this->secret_key);
                    $preference = $mp->create_preference($preference_data);
                    if($preference['response']['init_point'])
                    {

                        $payments = InvoicePayment::create(
                            [
                                'invoice' => $invoice->id,
                                'date' => date('Y-m-d'),
                                'amount' => $request->amount,
                                'payment_method' => 1,
                                'transaction' => $orderID,
                                'payment_type' => __('Mercado'),
                                'receipt' => '',
                                'notes' => __('Invoice') . ' ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                            ]
                        );

                        $invoice = Invoice::find($invoice->id);

                        if($invoice->getDue() <= 0.0)
                        {
                            Invoice::change_status($invoice->id, 5);
                        }
                        elseif($invoice->getDue() > 0)
                        {
                            Invoice::change_status($invoice->id, 4);
                        }
                        else
                        {
                            Invoice::change_status($invoice->id, 3);
                        }


                        return redirect($preference['response']['init_point']);
                    }


                }
                catch(Exception $e)
                {
                    return redirect()->back()->with('error', $e->getMessage());
                }
                // callback url :  domain.com/plan/mercado
            }
            else
            {
                return redirect()->back()->with('error', 'Enter valid amount.');
            }


        }
        else
        {
            return redirect()->back()->with('error', 'Invoice is deleted.');
        }

    }

    public function getInvoicePaymentStatus(Request $request)
    {
        Log::info(json_encode($request->all()));
    }
}
