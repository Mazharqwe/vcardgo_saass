<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use App\Models\Business;
use App\Models\PlanOrder;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Utility;
use App\Models\LandingPageSection;
use Auth;
use App\Models\User;

class HomeController extends Controller
{
    use \RachidLaasri\LaravelInstaller\Helpers\MigrationsHelper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (\Auth::check()) {
            if (\Auth::user()->can('show dashboard')) {

                if (!file_exists(storage_path() . "/installed")) {
                    header('location:install');
                    die;
                } else {

                    $uri = url()->full();
                    $segments = explode('/', str_replace('' . url('') . '', '', $uri));
                    $segments = $segments[1] ?? null;
                    if ($segments == null) {
                        $local = parse_url(config('app.url'))['host'];
                        // Get the request host
                        $remote = request()->getHost();
                        // Get the remote domain

                        // remove WWW
                        $remote = str_replace('www.', '', $remote);
                        $business = Business::where('domains', '=', $remote)->where('enable_domain', 'on')->first();
                        // If the domain exists
                        if ($business && $business->enable_domain == 'on') {
                            return app('App\Http\Controllers\BusinessController')->getcard($business->slug);
                        }
                        $sub_business = Business::where('subdomain', '=', $remote)->where('enable_subdomain', 'on')->first();
                        if ($sub_business && $sub_business->enable_subdomain == 'on') {
                            return app('App\Http\Controllers\BusinessController')->getcard($sub_business->slug);
                        }
                    }

                    if (\Auth::user()->type == 'super admin') {
                        $user = \Auth::user();
                        $user['total_user'] = $user->countCompany();
                        $user['total_paid_user'] = $user->countPaidCompany();
                        $user['total_orders'] = PlanOrder::total_orders();
                        $user['total_orders_price'] = PlanOrder::total_orders_price();
                        $user['total_plan'] = Plan::total_plan();
                        $user['most_purchese_plan'] = (!empty(Plan::most_purchese_plan()) ? Plan::most_purchese_plan()->name : 0);
                        $chartData = $this->getPlanOrderChart(['duration' => 'week']);

                        return view('dashboard.admin_dashboard', compact('user', 'chartData'));
                    } else {
                        $cards = Business::getBusiness();

                        $total_bussiness = Business::where('created_by', \Auth::user()->creatorId())->count();
                        $total_app = \App\Models\Appointment_deatail::where('created_by', \Auth::user()->creatorId())->count();
                        $total_staff = User::where('created_by', \Auth::user()->creatorId())->count();

                        $chartData = $this->getOrderChart(['duration' => 'week']);

                        $user = \Auth::user();


                        $visitor_url = \DB::table('visitor')->selectRaw("count('*') as total, url")->where('created_by', \Auth::user()->creatorId())->groupBy('url')->orderBy('total', 'DESC')->get();
                        $user_device = \DB::table('visitor')->selectRaw("count('*') as total, device")->where('created_by', \Auth::user()->creatorId())->groupBy('device')->orderBy('device', 'DESC')->get();
                        $user_browser = \DB::table('visitor')->selectRaw("count('*') as total, browser")->where('created_by', \Auth::user()->creatorId())->groupBy('browser')->orderBy('browser', 'DESC')->get();
                        $user_platform = \DB::table('visitor')->selectRaw("count('*') as total, platform")->where('created_by', \Auth::user()->creatorId())->groupBy('platform')->orderBy('platform', 'DESC')->get();


                        $devicearray = [];
                        $devicearray['label'] = [];
                        $devicearray['data'] = [];

                        foreach ($user_device as $name => $device) {
                            if (!empty($device->device)) {
                                $devicearray['label'][] = $device->device;
                            } else {
                                $devicearray['label'][] = 'Other';
                            }
                            $devicearray['data'][] = $device->total;
                        }

                        $browserarray = [];
                        $browserarray['label'] = [];
                        $browserarray['data'] = [];

                        foreach ($user_browser as $name => $browser) {
                            $browserarray['label'][] = $browser->browser;
                            $browserarray['data'][] = $browser->total;
                        }
                        $platformarray = [];
                        $platformarray['label'] = [];
                        $platformarray['data'] = [];

                        foreach ($user_platform as $name => $platform) {
                            $platformarray['label'][] = $platform->platform;
                            $platformarray['data'][] = $platform->total;
                        }
                        $users = User::find(\Auth::user()->creatorId());
                        $planUser=$users->plan;
                        $plan = cache()->remember('plan_user' . $planUser, now()->addHours(24), function () use ($planUser) {
                            return Plan::getPlansUser($planUser);
                         });
                        if ($plan->storage_limit > 0) {
                            $storage_limit = ($users->storage_limit / $plan->storage_limit) * 100;
                        } else {
                            $storage_limit = 0;
                        }

                        
                        if($users->current_business == 0)
                        {
                            $business = Business::where('created_by', \Auth::user()->creatorId())->first();
                            if($business)
                            {
                                $users->current_business=$business->id;
                                $users->save();
                            }
                            
                        }
                        $businessData = User::getCurrentBusiness($users->current_business);
                        $qr_detail = '';
                        if (!empty($businessData)) {
                            $qr_detail = \App\Models\Businessqr::where('business_id', $businessData->id)->first();
                        }

                        return view('dashboard.dashboard', compact('total_bussiness', 'total_app', 'visitor_url', 'devicearray', 'browserarray', 'platformarray', 'chartData', 'cards', 'users', 'plan', 'storage_limit', 'businessData', 'qr_detail', 'total_staff'));
                    }

                }
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            } else {
                if (Utility::getValByName('display_landing_page') == 'on') {
                    return view('landingpage::layouts.landingpage');
                } else {
                    return redirect('login');
                }
            }
        }

    }
    public function getOrderChart($arrParam)
    {
        $user = \Auth::user();
        $arrDuration = [];
        if ($arrParam['duration']) {
            if ($arrParam['duration'] == 'week') {
                $previous_month = strtotime("-1 week");
                for ($i = 0; $i < 7; $i++) {
                    $arrDuration[date('Y-m-d', $previous_month)] = date('d-M', $previous_month);
                    $previous_month = strtotime(date('Y-m-d', $previous_month) . " +1 day");
                }
            }
        }
        $arrTask = [];
        $arrTask['label'] = [];
        $arrTask['data'] = [];


        foreach ($arrDuration as $date => $label) {
            $data['visitor'] = \DB::table('visitor')->select(\DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->where('created_by', \Auth::user()->creatorId())->first();
            $uniq = \DB::table('visitor')->select('ip')->distinct()->whereDate('created_at', '=', $date)->where('created_by', \Auth::user()->creatorId())->get();

            $data['unique'] = $uniq->count();
            $arrTask['label'][] = $label;
            $arrTask['data'][] = $data['visitor']->total;
            $arrTask['unique_data'][] = $data['unique'];
        }

        $business = Business::getBusiness();
        $array_app = [];
        foreach ($business as $b) {
            $d['data'] = [];
            $d['name'] = $b->title;
            foreach ($arrDuration as $date => $label) {
                $d['data'][] = \DB::table('appointment_deatails')->where('business_id', $b->id)->where('created_by', \Auth::user()->creatorId())->whereDate('created_at', '=', $date)->count();
            }
            $array_app[] = $d;
        }
        $arrTask['data'] = $array_app;
        return $arrTask;
    }
    public function getPlanOrderChart($arrParam)
    {
        $arrDuration = [];
        if ($arrParam['duration']) {
            if ($arrParam['duration'] == 'week') {
                $previous_week = strtotime("-1 week +1 day");
                for ($i = 0; $i < 8; $i++) {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);
                    $previous_week = strtotime(date('Y-m-d', $previous_week) . " +1 day");
                }
            }
        }

        $arrTask = [];
        $arrTask['label'] = [];
        $arrTask['data'] = [];
        foreach ($arrDuration as $date => $label) {

            $data = PlanOrder::select(\DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
            $arrTask['label'][] = $label;
            $arrTask['data'][] = $data->total;
        }

        return $arrTask;
    }

    public function landingPage()
    {
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        } else {
            $local = parse_url(config('app.url'))['host'];

            // Get the request host
            $remote = request()->getHost();
            // Get the remote domain

            // remove WWW
            $remote = str_replace('www.', '', $remote);
            $business = Business::where('domains', '=', $remote)->where('enable_domain', 'on')->first();

            // If the domain exists
            if ($business && $business->enable_domain == 'on') {

                // $data=app('App\Http\Controllers\BusinessController')->getcard($business->slug);
                return app('App\Http\Controllers\BusinessController')->getcard($business->slug);
            }


            $sub_business = Business::where('subdomain', '=', $remote)->where('enable_subdomain', 'on')->first();

            if ($sub_business && $sub_business->enable_subdomain == 'on') {
                return app('App\Http\Controllers\BusinessController')->getcard($sub_business->slug);
            }



            if (\Auth::check()) {
                return $this->index();
            } else {
                if (Utility::getValByName('display_landing_page') == 'off') {
                    return redirect()->route('login');
                } else {
                    $get_section = LandingPageSection::orderBy('section_order', 'ASC')->get();
                    $plans = Plan::get();
                    return view('layouts.landing', compact('plans', 'get_section'));
                }
            }

        }
    }

    // ChangeCurrentBusiness
    public function changeCurrantBusiness($business_id)
    {
        
        $user = Auth::user();
        $business = Business::find($business_id);
        if ($business_id != '0') {
            if ($business) {
                if ($business->status == "active") {
                    $user->current_business = $business_id;
                    $user->save();
                    return redirect()->back();
                } else {
                    return redirect()->back()->with('error', __('Business is locked'));
                }
            } else {
                return redirect()->back()->with('error', __('Business is not found'));
            }
        } else {

            $user->current_business = $business_id;
            $user->save();
            return redirect()->back();

        }


    }

   

}