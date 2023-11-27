<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utility;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PaymentWallPaymentController extends Controller
{

    public function index(Request $request)
    {
        $data = $request->all();
        $admin_payment_setting = Utility::getAdminPaymentSetting();
        return view('plan.paymentwall', compact('data', 'admin_payment_setting'));
    }
    public function paymenterror(Request $request, $flag)
    {
        if ($flag == 1) {
            return redirect()->route("plans.index")->with('error', __('Transaction has been Successfull! '));
        } else {
            return redirect()->route("plans.index")->with('error', __('Transaction has been failed! '));
        }

    }
    public function planPayWithPaymentwall(Request $request, $plan_id)
    {
        $payment_setting = Utility::getAdminPaymentSetting();
        $planID = \Illuminate\Support\Facades\Crypt::decrypt($plan_id);
        $plan = Plan::find($planID);
        $user = Auth::user();
        $result = array();

        if (\Auth::user()->type == 'company') {
            $payment_setting = Utility::getAdminPaymentSetting();
        } else {
            $payment_setting = Utility::getCompanyPaymentSetting();
        }

        if ($plan) {
            try {
                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

                \Paymentwall_Config::getInstance()->set(
                    array(
                        'private_key' => $payment_setting['paymentwall_private_key']
                    )
                );

                $parameters = $_POST;

                $chargeInfo = array(
                    'email' => $parameters['email'],
                    'history[registration_date]' => '1489655092',
                    'amount' => $plan->price,
                    'currency' => !empty($payment_setting['CURRENCY']) ? $payment_setting['CURRENCY'] : 'USD',
                    'token' => $parameters['brick_token'],
                    'fingerprint' => $parameters['brick_fingerprint'],
                    'description' => 'Order #123'
                );

                $charge = new \Paymentwall_Charge();
                $charge->create($chargeInfo);
                $responseData = json_decode($charge->getRawResponseData(), true);
                $response = $charge->getPublicData();
                if ($charge->isSuccessful() and empty($responseData['secure'])) {
                    if ($charge->isCaptured()) {
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
                        $user->plan = $plan->id;
                        $user->save();

                        $assignPlan = $user->assignPlan($plan->id);
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
                                'price' => $plan->price == null ? 0 : $plan->price,
                                'price_currency' => !empty($payment_setting['CURRENCY']) ? $payment_setting['CURRENCY'] : 'USD',
                                'txn_id' => '',
                                'payment_type' => __('Paymentwall'),
                                'payment_status' => 'succeeded',
                                'receipt' => null,
                                'user_id' => $user->id,
                            ]
                        );
                        $assignPlan = $user->assignPlan($plan->id);
                        if ($assignPlan['is_success']) {
                            $res['flag'] = 1;
                            return $res;
                        } else {
                            $res['flag'] = 2;
                            return $res;
                        }
                    } elseif ($charge->isUnderReview()) {
                        $res['flag'] = 2;
                        return $res;
                    }
                } else {
                    $res['flag'] = 2;
                    return $res;
                }
            } catch (\Exception $e) {
                $res['flag'] = 2;
                return $res;
            }
        } else {
            return redirect()->route('plan.index')->with('error', __('Plan is deleted.'));
        }

    }

}