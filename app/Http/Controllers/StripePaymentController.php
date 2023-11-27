<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\PlanOrder;
use App\Models\Plan;
use App\Transaction;
use App\Models\UserCoupon;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;


class StripePaymentController extends Controller
{
    public $settings;
    public function index()
    {
        $objUser = \Auth::user();
        $orders = PlanOrder::select(
            [
                'plan_orders.*',
                'users.name as user_name',
            ]
        )->with('total_coupon_used.coupon_detail')
          ->join('users', 'plan_orders.user_id', '=', 'users.id')
          ->orderBy('plan_orders.created_at', 'DESC')
          ->get();
        


        return view('order.index', compact('orders'));
    }


    public function stripe($code)
    {

        try {
            $plan_id = \Illuminate\Support\Facades\Crypt::decrypt($code);
            $plan = Plan::find($plan_id);
            $admin_payment_setting = Utility::getAdminPaymentSetting();
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', __('Plan not avaliable'));
        }

        if ($plan) {
            return view('stripe', compact('plan', 'admin_payment_setting'));
        } else {
            return redirect()->back()->with('error', __('Plan is deleted.'));
        }
    }

    public function stripePost(Request $request)
    {
        $objUser = \Auth::user();
        $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan = Plan::find($planID);

        $admin_payment_setting = Utility::getAdminPaymentSetting();
        if ($plan) {
            try {
                $price = $plan->price;
                if (!empty($request->coupon)) {
                    $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                    if (!empty($coupons)) {
                        $usedCoupun = $coupons->used_coupon();
                        $discount_value = ($plan->price / 100) * $coupons->discount;
                        $price = $plan->price - $discount_value;

                        if ($coupons->limit == $usedCoupun) {
                            return redirect()->back()->with('error', __('This coupon code has expired.'));
                        }
                    } else {
                        return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                    }
                }

                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

                if ($price > 0.0) {
                    Stripe\Stripe::setApiKey($admin_payment_setting['stripe_secret']);


                    $paymentIntentData = [
                        'setup_future_usage' => 'off_session',
                        "amount" => $price,
                        'currency' => !empty($admin_payment_setting['CURRENCY']) ? $admin_payment_setting['CURRENCY'] : 'USD',
                        "description" => $plan->name,
                        'metadata' => [
                            "orderId" => $orderID,
                            'planId' => $planID,
                            'user_id' => $objUser->id,
                        ],
                    ];
                    if (!is_null($admin_payment_setting['CURRENCY']) && $admin_payment_setting['CURRENCY'] != 'INR') {
                        $paymentIntentData['shipping'] = [
                            'name' => \Auth::user()->name,
                            'address' => [
                                'line1' => $request->address,
                                'postal_code' => $request->postalCode,
                                'city' => $request->city,
                                'state' => $request->state,
                                'country' => $request->country,
                            ],
                        ];
                    }

                    $paymentIntent = PaymentIntent::create($paymentIntentData);
                    return response()->json(['paymentIntent' => $paymentIntent]);
                } else {
                    return redirect()->back()->with('error', __('Plan fail to upgrade.'));
                }

            } catch (\Exception $e) {
                return redirect()->route('plans.index')->with('error', __($e->getMessage()));
            }
        } else {
            return redirect()->route('plans.index')->with('error', __('Plan is deleted.'));
        }
    }

    public function fetchPaymentIntent(Request $request)
    {
        $admin_payment_setting = Utility::getAdminPaymentSetting();
        Stripe\Stripe::setApiKey($admin_payment_setting['stripe_secret']);
        $paymentIntent = PaymentIntent::retrieve($request->paymentIntentId);
        if ($paymentIntent) {
            return response()->json(['paymentIntent' => $paymentIntent]);

        } else {
            return response()->json(['error' => $paymentIntent], 500);
        }
    }

    // Function For Getting Payment Card Details
    public function fetchPaymentMethod(Request $request)
    {
        $admin_payment_setting = Utility::getAdminPaymentSetting();
        Stripe\Stripe::setApiKey($admin_payment_setting['stripe_secret']);
        $paymentMethod = PaymentMethod::retrieve($request->paymentMethodId);
        // dd($paymentMethod->toArray());

        if ($paymentMethod) {
            return response()->json(['paymentMethod' => $paymentMethod]);
        } else {
            return response()->json(['error' => $paymentMethod], 500);
        }
    }


    public function storePaymentAndCardDetails(Request $request)
    {
        $objUser = \Auth::user();
        $paymentIntent = $request->input('paymentIntent');
        $cardDetails = $request->input('cardDetails');
        $shippingArray = $paymentIntent['shipping']['address'] ?? null; // Use null if shipping is not available
        $shippingDetails = $shippingArray ? json_encode($shippingArray) : null; // Encode shipping only if it's available

        if ($paymentIntent['status'] == "succeeded") {
            PlanOrder::create(
                [
                    'order_id' => $paymentIntent['metadata']['orderId'],
                    'name' => \Auth::user()->name,
                    'email' => \Auth::user()->email,
                    'card_number' => $cardDetails['last4'],
                    'card_exp_month' => $cardDetails['exp_month'],
                    'card_exp_year' => $cardDetails['exp_year'],
                    'plan_name' => $paymentIntent['description'],
                    'plan_id' => $paymentIntent['metadata']['planId'],
                    'price' => $paymentIntent['amount'],
                    'price_currency' => $paymentIntent['currency'],
                    'txn_id' => '',
                    'payment_type' => __('STRIPE'),
                    'payment_status' => $paymentIntent['status'],
                    'receipt' => '',
                    'user_id' => $paymentIntent['metadata']['user_id'],
                    'shipping_details' => $shippingDetails,
                ]
            );

            if (!empty($request->coupon)) {
                $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                $userCoupon = new UserCoupon();
                $userCoupon->user = $objUser->id;
                $userCoupon->coupon = $coupons->id;
                $userCoupon->order = $paymentIntent['metadata']['orderId'];
                $userCoupon->save();

                $usedCoupun = $coupons->used_coupon();
                if ($coupons->limit <= $usedCoupun) {
                    $coupons->is_active = 0;
                    $coupons->save();
                }
            }
            $objUser = \Auth::user();
            $planId = $paymentIntent['metadata']['planId'];
            $assignPlan = $objUser->assignPlan($planId);
            if ($assignPlan['is_success']) {
                return response()->json(['success' => 'Your plan is activated..'], 200);
            } else {
                // return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
                return response()->json(['error' => $assignPlan['error']], 500);
            }
        } else {
            return redirect()->route('plan.index')->with('error', __('Your Payment has failed!'));
        }
    }

    public function destroyOrder($id)
    {
        $planorder = PlanOrder::find($id);
        if ($planorder) {
            $planorder->delete();
            return redirect()->back()->with('success', __('Order successfully deleted.'));
        }
        return redirect()->back()->with('error', __('Order not found.'));
    }

    public function assignPlanAndRecordOrder(Request $request)
    {
        $objUser = \Auth::user();
        $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan = Plan::find($planID);

        $admin_payment_setting = Utility::getAdminPaymentSetting();
        if ($plan) {
            $price = $plan->price;
            if (!empty($request->coupon)) {
                $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                if (!empty($coupons)) {
                    $usedCoupun = $coupons->used_coupon();
                    $discount_value = ($plan->price / 100) * $coupons->discount;
                    $price = $plan->price - $discount_value;

                    if ($coupons->limit == $usedCoupun) {
                        return redirect()->back()->with('error', __('This coupon code has expired.'));
                    }
                } else {
                    return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                }
            }

            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            $objUser->plan = $plan->id;
            $objUser->save();

            $assignPlan = $objUser->assignPlan($plan->id);

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
                        'price_currency' => $admin_payment_setting['CURRENCY'],
                        'txn_id' => '',
                        'payment_type' => __('STRIPE'),
                        'payment_status' => 'succeeded',
                        'receipt' => null,
                        'user_id' => $objUser->id,
                    ]
                );

                if (!empty($request->coupon)) {
                    $userCoupon = new UserCoupon();
                    $userCoupon->user = $objUser->id;
                    $userCoupon->coupon = $coupons->id;
                    $userCoupon->order = $orderID;
                    $userCoupon->save();

                    $usedCoupun = $coupons->used_coupon();
                    if ($coupons->limit <= $usedCoupun) {
                        $coupons->is_active = 0;
                        $coupons->save();
                    }

                }
                return response()->json(['success' => 'Your plan is activated..'], 200);
            }
        }
    }

}