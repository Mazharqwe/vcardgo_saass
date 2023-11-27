<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\PlanOrder;
use App\Mail\UserCreate;
use Illuminate\Support\Facades\Hash;
use Auth;
use File;
use App\Models\Utility;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Lab404\Impersonate\Impersonate;

class UserController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('manage user')) {
            $user = \Auth::user();
            if ($user->type == 'super admin') {
                $users = User::where('type', '!=', 'super admin')->where('created_by', '=', $user->creatorId())->with('currentPlan')->get();
            } else {
                $users = User::where('created_by', '=', $user->creatorId())->get();
            }

            return view('user.index')->with('users', $users);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function create()
    {
        $user = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create user')) {
            $default_language = \DB::table('settings')->select('value')->where('name', 'default_language')->first();
            $company_default_language = \DB::table('settings')->select('value')->where('name', 'company_default_language')->first();
            $user = \Auth::user();


            if ($user->type == 'super admin') {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users',
                        'password' => 'required|min:6',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $setting = Utility::settings();
                if (isset($setting['email_verification']) && $setting['email_verification'] == 'on') {
                    $user = new User();
                    $user['name'] = $request->name;
                    $user['email'] = $request->email;
                    $psw = $request->password;
                    $user['password'] = \Hash::make($request->password);
                    $user['type'] = 'company';
                    $user['lang'] = !empty($default_language) ? $default_language->value : 'en';
                    //$user['email_verified_at'] = date("Y-m-d H:i:s");
                    $user['created_by'] = \Auth::user()->creatorId();
                    $user['plan'] = Plan::first()->id;
                    $user->save();
                    $user->password = $psw;
                    $role = Role::findByName('company');
                    $user->assignRole($role);
                } else {
                    $user = new User();
                    $user['name'] = $request->name;
                    $user['email'] = $request->email;
                    $psw = $request->password;
                    $user['password'] = \Hash::make($request->password);
                    $user['type'] = 'company';
                    $user['lang'] = !empty($default_language) ? $default_language->value : 'en';
                    $user['email_verified_at'] = date("Y-m-d H:i:s");
                    $user['created_by'] = \Auth::user()->creatorId();
                    $user['plan'] = Plan::first()->id;
                    $user->save();
                    $user->password = $psw;
                    $role = Role::findByName('company');
                    $user->assignRole($role);
                }
            } else {

                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users',
                        'password' => 'required|min:6',
                        'role' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $max_users = \Auth::user()->getMaxUser();
                $count = User::where('created_by', \Auth::user()->id)->count();

                $UserData=User::where('id', \Auth::user()->id)->first();
                $role = Role::findById($request->role);
                if ($count < $max_users || $max_users == -1) {
                    $user = new User();
                    $user['name'] = $request->name;
                    $user['email'] = $request->email;
                    $psw = $request->password;
                    $user['password'] = \Hash::make($request->password);
                    $user['type'] = $role->name;
                    $user['lang'] = !empty($company_default_language) ? $company_default_language->value : 'en';
                    $user['email_verified_at'] = date("Y-m-d H:i:s");
                    $user['created_by'] = \Auth::user()->creatorId();
                    $user['plan'] = $UserData->plan;
                    $user->save();
                    $user->password = $psw;
                    $user->assignRole($role);
                } else {
                    return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
                }

            }
            $userArr = [
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_password' => $request->password,
                'user_type' => $user->type,
                'created_by' => $user->created_by,
            ];

            try {
                $resp = \Utility::sendEmailTemplate('User Created', $userArr, $user->email);

                // \Mail::to($user->email)->send(new UserCreate($user));
            } catch (\Exception $e) {

                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

            $module = 'New User';

            $webhook = Utility::webhookSetting($module, \Auth::user()->creatorId());

            if ($webhook) {
                $parameter = json_encode($user);

                // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
                $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
                if ($status == true) {
                    return redirect()->back()->with('success', __('User successfully created!'));
                } else {
                    return redirect()->back()->with('error', __('Webhook call failed.'));
                }
            }

            return redirect()->route('users.index')->with('success', __('User successfully added.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');
        $user = User::findOrFail($id);
        return view('user.edit', compact('user', 'roles'));
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit user')) {
            if (Auth::user()->type == 'super admin') {
                $user = User::findOrFail($id);
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users,email,' . $id,
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $input = $request->all();
                $user->fill($input)->save();

                return redirect()->route('users.index')->with(
                    'success',
                    'User successfully updated.'
                );

            } else {
                $user = User::findOrFail($id);
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users,email,' . $id,
                        'role' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('users.index')->with('error', $messages->first());
                }

                $role = Role::findById($request->role);
                $input = $request->all();
                $input['type'] = $role->name;
                $user->fill($input)->save();

                $roles[] = $request->role;
                $user->roles()->sync($roles);

                return redirect()->route('users.index')->with(
                    'success',
                    __('User successfully updated.')
                );
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
    public function upgradePlan($user_id)
    {
        $user = User::find($user_id);

        $plans = Plan::get();

        return view('user.plan', compact('user', 'plans'));
    }


    public function destroy($id)
    {
        if (\Auth::user()->can('delete user')) {
            $user = User::find($id);
            if ($user) {
                $user->delete();

                return redirect()->route('users.index')->with('success', __('User successfully deleted .'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function profile()
    {
        $userDetail = \Auth::user();
        return view('user.profile', compact('userDetail'));
    }

    public function editprofile(Request $request)
    {
        $userDetail = \Auth::user();
        $user = User::findOrFail($userDetail['id']);
        $this->validate(
            $request,
            [
                'name' => 'required|max:120',
                'email' => 'required|email|unique:users,email,' . $userDetail['id'],
            ]
        );
        $image_path1 = 'uploads/avatar/' . $user['avatar'];
        if ($request->hasFile('profile')) {
            $image_size = $request->file('profile')->getSize();
            $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
            if ($result == 1) {
                $result = Utility::changeStorageLimit(\Auth::user()->creatorId(), $image_path1);

                $filenameWithExt = $request->file('profile')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('profile')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $settings = Utility::getStorageSetting();

                if ($settings['storage_setting'] == 'local') {
                    $dir = 'uploads/avatar/';
                } else {
                    $dir = 'uploads/avatar';
                }

                $image_path = $dir . $userDetail['avatar'];
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                $path = Utility::upload_file($request, 'profile', $fileNameToStore, $dir, []);

                if ($path['flag'] == 1) {
                    $url = $path['url'];
                } else {
                    return redirect()->route('profile', \Auth::user()->id)->with('error', __($path['msg']));
                }
            }

        }

        if (!empty($request->profile)) {
            $user['avatar'] = $fileNameToStore;
        }
        $user['name'] = $request['name'];
        $user['email'] = $request['email'];
        $user->save();


        return redirect()->back()->with(
            'success',
            'Profile successfully updated.' . ((isset($result) && $result != 1) ? '<br> <span class="text-danger">' . $result . '</span>' : '')
        );
    }

    public function updatePassword(Request $request)
    {
        if (Auth::Check()) {
            $request->validate(
                [
                    'current_password' => 'required',
                    'new_password' => 'required|same:new_password',
                    'confirm_password' => 'required|same:new_password',
                ]
            );
            $objUser = Auth::user();
            $request_data = $request->All();
            $current_password = $objUser->password;

            if (Hash::check($request_data['current_password'], $current_password)) {
                $user_id = Auth::User()->id;
                $obj_user = User::find($user_id);
                $obj_user->password = Hash::make($request_data['new_password']);
                ;
                $obj_user->save();

                return redirect()->route('profile')->with('success', __('Password Updated Successfully!'));
            } else {
                return redirect()->route('profile')->with('error', __('Please Enter Correct Current Password!'));
            }
        } else {
            return redirect()->route('profile')->with('error', __('Something is wrong!'));
        }
    }

    public function changeLanquage($lang)
    {

        $user = Auth::user();
        $user->lang = $lang;
        if ($lang == 'ar' || $lang == 'he') {
            $setting = Utility::settings();
            $arrSetting['SITE_RTL'] = 'on';
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            foreach ($arrSetting as $key => $val) {
                \DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                    [
                        $val,
                        $key,
                        \Auth::user()->creatorId(),
                        $created_at,
                        $updated_at,
                    ]
                );
            }
        } else {
            $arrSetting['SITE_RTL'] = 'off';
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            foreach ($arrSetting as $key => $val) {
                \DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ',
                    [
                        $val,
                        $key,
                        \Auth::user()->creatorId(),
                        $created_at,
                        $updated_at,
                    ]
                );
            }
        }
        $user->save();

        return redirect()->back()->with('success', __('Language Change Successfully!'));


    }
    public function activePlan($user_id, $plan_id)
    {

        $user = User::find($user_id);
        $assignPlan = $user->assignPlan($plan_id);
        $plan = Plan::find($plan_id);
        if ($assignPlan['is_success'] == true && !empty($plan)) {
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            PlanOrder::create(
                [
                    'order_id' => $orderID,
                    'name' => null,
                    'card_number' => null,
                    'card_exp_month' => null,
                    'card_exp_year' => null,
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id,
                    'price' => $plan->price,
                    'price_currency' => isset(\Auth::user()->planPrice()['currency']) ? \Auth::user()->planPrice()['currency'] : '',
                    'txn_id' => '',
                    'payment_status' => 'succeeded',
                    'receipt' => null,
                    'user_id' => $user->id,
                ]
            );

            return redirect()->back()->with('success', 'Plan successfully upgraded.');
        } else {
            return redirect()->back()->with('error', 'Plan fail to upgrade.');
        }

    }
    public function userPassword($id)
    {

        $eId = \Crypt::decrypt($id);
        $user = User::where('id', $eId)->first();
        return view('user.reset', compact('user'));
    }
    public function userPasswordReset(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'password' => 'required|confirmed|same:password_confirmation',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $user = User::where('id', $id)->first();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();
        return redirect()->route('users.index')->with(
            'success',
            'User Password successfully updated.'
        );
    }

    public function LoginManage($id)
    {
        $eId = \Crypt::decrypt($id);
        $user = User::find($eId);
        if ($user->is_enable_login == 1) {
            $user->is_enable_login = 0;
            $user->save();
            return redirect()->route('users.index')->with('success', 'User login disable successfully.');
        } else {
            $user->is_enable_login = 1;
            $user->save();
            return redirect()->route('users.index')->with('success', 'User login enable successfully.');
        }

    }

    public function LoginWithCompany(Request $request, User $user, $id)
    {

        $user = User::find($id);
        if ($user && auth()->check()) {
            Impersonate::take($request->user(), $user);
            return redirect('/home');
        }
    }

}