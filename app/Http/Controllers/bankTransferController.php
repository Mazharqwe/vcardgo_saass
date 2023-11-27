<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\PlanOrder;
use App\Models\Plan;
use App\Models\UserCoupon;
use App\Models\Utility;
use Auth;
use File;
use App\Models\User;

class bankTransferController extends Controller
{
    //
   
    public function planPayWithbank(Request $request)
    {
       

        $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan   = Plan::find($planID);
        
        $price=$plan->price;
        $user = Auth::user();
        $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
        $payment_setting = Utility::getAdminPaymentSetting();
        $currency = !empty($payment_setting['CURRENCY']) ? $payment_setting['CURRENCY'] : 'USD';

        $request->validate(
            [
                'receipt' => 'required',
            ]
        );

        $dir = storage_path() . '/bank_receipt/';
        if (!is_dir($dir)) {
            \File::makeDirectory($dir, $mode = 0777, true, true);
        }
        $file_path = $request->receipt->getClientOriginalName();
        $file = $request->file('receipt');
        $file->move($dir, $file_path);
        $coupon_id = 0;
        if(!empty($request->coupon))
        {
           
            $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
            
            if(!empty($coupons))
            {
                
                $usedCoupun     = $coupons->used_coupon();
                $discount_value = ($plan->price / 100) * $coupons->discount;
                $price          = $plan->price - $discount_value;
                if($coupons->limit == $usedCoupun)
                {
                    return redirect()->back()->with('error', __('This coupon code has expired.'));
                }
                $coupon_id = $coupons->id;
            }
            else
            {
                return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
            }
        }
        
        $coupons = Coupon::find($coupon_id);
        
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
       
       
        if($price >= 0)
        {
            
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
                    'price'           => $price==null?0:$price,
                    'price_currency'  => $currency,
                    'txn_id'          => '',
                    'payment_type'    => 'Bank Transfer',
                    'payment_status'  => 'pending',
                    'receipt'         => !empty($file_path)?$file_path:'',
                    'user_id'         => $user->id,
                ]
            );

            return redirect()->route('plans.index')->with('success',__('Plan payment request send successfully'));
        }
        else{
            return redirect()->route('plans.index')->with('error', 'Something went wrong.');
        }
    }
   

    public function  viewOrder($id)
    {
            
            $order = PlanOrder::find($id);
            $settings=Utility::getAdminPaymentSetting();
            $bank_detail=$settings['bank_detail'];
            return view('order.view', compact('order','bank_detail'));
    }
    public function  ChangeStatus($id,$response)
    {
        
        $order = PlanOrder::find($id);
        if($response==1)
        {
            $order->payment_status='succeeded';
            $order->save();
            $user=User::find($order->user_id);
            $user->plan = $order->plan_id;
            
            $assignPlan = $user->assignPlan($order->plan_id);
            if(!empty($user->payment_subscription_id) && $user->payment_subscription_id != '')
            {
                try
                {
                    $user->cancel_subscription($user->id);
                }
                catch(\Exception $exception)
                {
                    \Log::debug($exception->getMessage());
                }
            }
            return redirect()->back()->with('success', __('Plan payment status updated successfully'));
        }else{
            $order->payment_status='rejected';
            $order->save();
            return redirect()->back()->with('error', __('Plan payment status updated successfully'));
        }
    }
    

   
   
}
