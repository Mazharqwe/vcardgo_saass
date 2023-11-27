<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\PlanOrder;
use App\Models\Plan;
use App\Models\UserCoupon;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MolliePaymentController extends Controller
{

    public $api_key;
    public $profile_id;
    public $partner_id;
    public $is_enabled;

    public function paymentConfig()
    {
        $payment_setting = Utility::getAdminPaymentSetting();
        $this->api_key = isset($payment_setting['mollie_api_key']) ? $payment_setting['mollie_api_key'] : '';
        $this->profile_id = isset($payment_setting['mollie_profile_id']) ? $payment_setting['mollie_profile_id'] : '';
        $this->partner_id = isset($payment_setting['mollie_partner_id']) ? $payment_setting['mollie_partner_id'] : '';
        $this->is_enabled = isset($payment_setting['is_mollie_enabled']) ? $payment_setting['is_mollie_enabled'] : 'off';

        return $this;
    }


    public function planPayWithMollie(Request $request)
    {
        $payment = $this->paymentConfig();
        $payment_setting = Utility::getAdminPaymentSetting();
        $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan = Plan::find($planID);
        $authuser = Auth::user();
        $coupons_id = '';
        if ($plan) {
            $price = $plan->price;
            if (isset($request->coupon) && !empty($request->coupon)) {
                $request->coupon = trim($request->coupon);
                $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                if (!empty($coupons)) {
                    $usedCoupun = $coupons->used_coupon();
                    $discount_value = ($price / 100) * $coupons->discount;
                    $plan->discounted_price = $price - $discount_value;
                    $coupons_id = $coupons->id;
                    if ($usedCoupun >= $coupons->limit) {
                        return redirect()->back()->with('error', __('This coupon code has expired.'));
                    }
                    $price = $price - $discount_value;
                } else {
                    return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                }
            }

            if ($price <= 0) {
                $authuser->plan = $plan->id;
                $authuser->save();

                $assignPlan = $authuser->assignPlan($plan->id);

                if ($assignPlan['is_success'] == true && !empty($plan)) {

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
                            'price_currency' => !empty($payment_setting['CURRENCY']) ? $payment_setting['CURRENCY'] : 'USD',
                            'txn_id' => '',
                            'payment_type' => __('Mollie'),
                            'payment_status' => 'succeeded',
                            'receipt' => null,
                            'user_id' => $authuser->id,
                        ]
                    );
                    $assignPlan = $authuser->assignPlan($plan->id);

                    return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
                } else {
                    return redirect()->back()->with('error', __('Plan fail to upgrade.'));
                }
            }

            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey($this->api_key);

            $payment = $mollie->payments->create(
                [
                    "amount" => [
                        "currency" => $payment_setting['CURRENCY'],
                        "value" => number_format($price, 2),
                    ],
                    "description" => "payment for product",
                    "redirectUrl" => route(
                        'plan.mollie',
                        [
                            $request->plan_id,
                            $price,
                            'coupon_id=' . $coupons_id,
                        ]
                    ),
                ]
            );

            session()->put('mollie_payment_id', $payment->id);

            return redirect($payment->getCheckoutUrl())->with('payment_id', $payment->id);
        } else {
            return redirect()->back()->with('error', 'Plan is deleted.');
        }

    }

    public function getPaymentStatus(Request $request, $plan, $price)
    {
        $payment_setting = Utility::getAdminPaymentSetting();
        $payment = $this->paymentConfig();
        $planID = \Illuminate\Support\Facades\Crypt::decrypt($plan);
        $plan = Plan::find($planID);
        $user = Auth::user();
        $orderID = time();
        if ($plan) {
            try {
                $mollie = new \Mollie\Api\MollieApiClient();
                $mollie->setApiKey($this->api_key);

                if (session()->has('mollie_payment_id')) {
                    $payment = $mollie->payments->get(session()->get('mollie_payment_id'));
                    if ($payment->isPaid()) {

                        if ($request->has('coupon_id') && $request->coupon_id != '') {
                            $coupons = Coupon::find($request->coupon_id);

                            if (!empty($coupons)) {
                                $userCoupon = new UserCoupon();
                                $userCoupon->user = $user->id;
                                $userCoupon->coupon = $coupons->id;
                                $userCoupon->order = $orderID;
                                $userCoupon->save();

                                $usedCoupun = $coupons->used_coupon();
                                if ($coupons->limit <= $usedCoupun) {
                                    $coupons->is_active = 0;
                                    $coupons->save();
                                }
                            }
                        }

                        $order = new PlanOrder();
                        $order->order_id = $orderID;
                        $order->name = $user->name;
                        $order->card_number = '';
                        $order->card_exp_month = '';
                        $order->card_exp_year = '';
                        $order->plan_name = $plan->name;
                        $order->plan_id = $plan->id;
                        $order->price = $price;
                        $order->price_currency = $payment_setting['CURRENCY'];
                        $order->txn_id = isset($request->TXNID) ? $request->TXNID : '';
                        $order->payment_type = __('Mollie');
                        $order->payment_status = 'success';
                        $order->receipt = '';
                        $order->user_id = $user->id;
                        $order->save();

                        $assignPlan = $user->assignPlan($plan->id, $request->payment_frequency);

                        if ($assignPlan['is_success']) {
                            return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
                        } else {
                            return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
                        }
                    } else {
                        return redirect()->route('plans.index')->with('error', __('Transaction has been failed! '));
                    }
                } else {
                    return redirect()->route('plans.index')->with('error', __('Transaction has been failed! '));
                }
            } catch (\Exception $e) {
                return redirect()->route('plans.index')->with('error', __('Plan not found!'));
            }
        }
    }
}