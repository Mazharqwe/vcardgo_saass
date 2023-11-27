<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\PlanOrder;
use App\Models\Plan;
use App\Models\UserCoupon;
use Exception;
use App\Models\Utility;
use Auth;

class ToyyibpayPaymentController extends Controller
{
    public $secretKey, $callBackUrl, $returnUrl, $categoryCode, $is_enabled, $invoiceData;

    public function __construct()
    {
        $payment_setting = Utility::getAdminPaymentSetting();


        $this->secretKey = isset($payment_setting['toyyibpay_secret_key']) ? $payment_setting['toyyibpay_secret_key'] : '';
        $this->categoryCode = isset($payment_setting['toyyibpay_category_code']) ? $payment_setting['toyyibpay_category_code'] : '';
        $this->is_enabled = isset($payment_setting['is_toyyibpay_enabled']) ? $payment_setting['is_toyyibpay_enabled'] : 'off';
    }

    public function index()
    {
        return view('payment');
    }

    public function charge(Request $request)
    {
        $payment_setting = Utility::getAdminPaymentSetting();
        try {
            $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
            $plan   = Plan::find($planID);
            if ($plan) {
                $get_amount = $plan->price;
                $coupon_id = 0;
                if (!empty($request->coupon)) {
                    $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                    if (!empty($coupons)) {
                        $usedCoupun     = $coupons->used_coupon();
                        $discount_value = ($plan->price / 100) * $coupons->discount;
                        $get_amount          = $plan->price - $discount_value;

                        if ($coupons->limit == $usedCoupun) {
                            return redirect()->back()->with('error', __('This coupon code has expired.'));
                        }
                        $coupon_id = $coupons->id;
                    } else {
                        return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                    }
                }

                $coupons = Coupon::find($coupon_id);
                $user = Auth::user();
                $orderID = time();
                if(!empty($coupons))
                {
                    $userCoupon            = new UserCoupon();
                    $userCoupon->user   = $user->id;
                    $userCoupon->coupon = $coupons->id;
                    $userCoupon->order  = $orderID;
                    $userCoupon->save();
                    $usedCoupun = $coupons->used_coupon();
                    if($coupons->limit <= $usedCoupun)
                    {
                        $coupons->is_active = 0;
                        $coupons->save();
                    }
                }
                if($get_amount <= 0)
                {
                    $authuser   = Auth::user();
                    $authuser->plan = $plan->id;
                    $authuser->save();
                    $assignPlan = $authuser->assignPlan($plan->id);
                    if($assignPlan['is_success'] == true && !empty($plan))
                    {
                        if(!empty($authuser->payment_subscription_id) && $authuser->payment_subscription_id != '')
                        {
                            try
                            {
                                $authuser->cancel_subscription($authuser->id);
                            }
                            catch(\Exception $exception)
                            {
                                \Log::debug($exception->getMessage());
                            }
                        }
                        $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                        PlanOrder::create(
                            [
                                'order_id'        => $orderID,
                                'name'            => null,
                                'email'           => null,
                                'card_number'     => null,
                                'card_exp_month'  => null,
                                'card_exp_year'   => null,
                                'plan_name'       => $plan->name,
                                'plan_id'         => $plan->id,
                                'price'           => $get_amount==null?0:$get_amount,
                                'price_currency'  => !empty($payment_setting['CURRENCY']) ? $payment_setting['CURRENCY'] : 'USD',
                                'txn_id'          => '',
                                'payment_type'    => 'Toyyibpay',
                                'payment_status'  => 'succeeded',
                                'receipt'         => null,
                                'user_id'         => $authuser->id,
                            ]
                        );
                        $assignPlan = $authuser->assignPlan($plan->id , $request->toyyibpay_payment_frequency);

                        return redirect()->route('plans.index')->with('success',__('Plan Successfully Activated'));
                    }
                }


                $coupon = (empty($request->coupon)) ? "0" : $request->coupon;
                $this->callBackUrl = route('plan.status', [$plan->id, $get_amount, $coupon]);
                $this->returnUrl = route('plan.status', [$plan->id, $get_amount, $coupon]);

                $Date = date('d-m-Y');
                $ammount = $get_amount;
                $billName = $plan->name;
                $description = !empty($plan->description) ? $plan->description: $plan->name;
                $billExpiryDays = 3;
                $billExpiryDate = date('d-m-Y', strtotime($Date . ' + 3 days'));
                $billContentEmail = "Thank you for purchasing our product!";

                $authuser   = Auth::user();
                $some_data = array(
                    'userSecretKey' => $this->secretKey,
                    'categoryCode' => $this->categoryCode,
                    'billName' => $billName,
                    'billDescription' => $description,
                    'billPriceSetting' => 1,
                    'billPayorInfo' => 1,
                    'billAmount' => 100 * $ammount,
                    'billReturnUrl' => $this->returnUrl,
                    'billCallbackUrl' => $this->callBackUrl,
                    'billExternalReferenceNo' => 'AFR341DFI',
                    'billTo' => !empty($authuser->name)?$authuser->name:'',
                    'billEmail' => !empty($authuser->email)?$authuser->email:'',
                    'billPhone' => !empty($authuser->phone)?$authuser->phone:'0000000000',
                    'billSplitPayment' => 0,
                    'billSplitPaymentArgs' => '',
                    'billPaymentChannel' => '0',
                    'billContentEmail' => $billContentEmail,
                    'billChargeToCustomer' => 1,
                    'billExpiryDate' => $billExpiryDate,
                    'billExpiryDays' => $billExpiryDays
                );
              
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
                $result = curl_exec($curl);
                $info = curl_getinfo($curl);
                curl_close($curl);
                $obj = json_decode($result);
                return redirect('https://toyyibpay.com/' . $obj[0]->BillCode);
            } else {
                return redirect()->route('plans.index')->with('error', __('Plan is deleted.'));
            }
        } catch (Exception $e) {
            return redirect()->route('plans.index')->with('error', __($e->getMessage()));
        }
    }
    //

    public function status(Request $request, $planId, $getAmount, $couponCode)
    {
        $payment_setting = Utility::getAdminPaymentSetting();
        if ($couponCode != 0) {
            $coupons = Coupon::where('code', strtoupper($couponCode))->where('is_active', '1')->first();
            $request['coupon_id'] = $coupons->id;
        } else {
            $coupons = null;
        }

        $plan = Plan::find($planId);
        $user = auth()->user();
        

        // 1=success, 2=pending, 3=fail
        // $request['status_id'] = 1;
        try {
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            if ($request->status_id == 3) {
                $statuses = 'Fail';
                $order                 = new PlanOrder();
                $order->order_id       = $orderID;
                $order->name           = $user->name;
                $order->card_number    = '';
                $order->card_exp_month = '';
                $order->card_exp_year  = '';
                $order->plan_name      = $plan->name;
                $order->plan_id        = $plan->id;
                $order->price          = $getAmount;
                $order->price_currency = !empty($payment_setting['CURRENCY']) ? $payment_setting['CURRENCY'] : 'USD';
                $order->payment_type   = __('Toyyibpay');
                $order->payment_status = $statuses;
                $order->txn_id         = '';
                $order->receipt        = '';
                $order->user_id        = $user->id;
                $order->save();
                return redirect()->route('plans.index')->with('success', __('Your Transaction is fail please try again'));
            } else if ($request->status_id == 2) {
                $statuses = 'pending';
                $order                 = new PlanOrder();
                $order->order_id       = $orderID;
                $order->name           = $user->name;
                $order->card_number    = '';
                $order->card_exp_month = '';
                $order->card_exp_year  = '';
                $order->plan_name      = $plan->name;
                $order->plan_id        = $plan->id;
                $order->price          = $getAmount;
                $order->price_currency = !empty($payment_setting['CURRENCY']) ? $payment_setting['CURRENCY'] : 'USD';
                $order->payment_type   = __('Toyyibpay');
                $order->payment_status = $statuses;
                $order->txn_id         = '';
                $order->receipt        = '';
                $order->user_id        = $user->id;
                $order->save();
                return redirect()->route('plans.index')->with('success', __('Your transaction on pandding'));
            } else if ($request->status_id == 1) {
                $statuses = 'success';
                $order                 = new PlanOrder();
                $order->order_id       = $orderID;
                $order->name           = $user->name;
                $order->card_number    = '';
                $order->card_exp_month = '';
                $order->card_exp_year  = '';
                $order->plan_name      = $plan->name;
                $order->plan_id        = $plan->id;
                $order->price          = $getAmount;
                $order->price_currency = !empty($payment_setting['CURRENCY']) ? $payment_setting['CURRENCY'] : 'USD';
                $order->payment_type   = __('Toyyibpay');
                $order->payment_status = $statuses;
                $order->txn_id         = '';
                $order->receipt        = '';
                $order->user_id        = $user->id;
                $order->save();
                $assignPlan = $user->assignPlan($plan->id);
                $coupons = Coupon::find($request->coupon_id);
                if (!empty($request->coupon_id)) {
                    if (!empty($coupons)) {
                        $userCoupon         = new UserCoupon();
                        $userCoupon->user   = $user->id;
                        $userCoupon->coupon = $coupons->id;
                        $userCoupon->order  = $orderID;
                        $userCoupon->save();
                        $usedCoupun = $coupons->used_coupon();
                        if ($coupons->limit <= $usedCoupun) {
                            $coupons->is_active = 0;
                            $coupons->save();
                        }
                    }
                }
                if ($assignPlan['is_success']) {
                    return redirect()->route('plans.index')->with('success', __('Plan activated Successfully.'));
                } else {
                    return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
                }
            } else {
                return redirect()->route('plans.index')->with('error', __('Plan is deleted.'));
            }
        } catch (Exception $e) {
            return redirect()->route('plans.index')->with('error', __($e->getMessage()));
        }
    }
}
