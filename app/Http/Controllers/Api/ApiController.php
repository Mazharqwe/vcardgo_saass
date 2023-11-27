<?php

namespace App\Http\Controllers\Api;

use App\Models\Business;
use App\Models\Appointment_deatail;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Utility;

class ApiController extends Controller
{
    use ApiResponser;

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            $messages = $validator->getMessageBag();
            return $this->error(null,$messages->first());
        }

        if (!empty($request->password)) {
            $user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if (!$user) {
                return $this->error(null,"Invalid login details");
            }
            $user = Auth::user();

            // $user = Admin::find($user->id);
            $user = User::find(Auth::user()->id);

        } else {
            return $this->error(null,"Invalid login details");
        }
        // Auth::loginUsingId(1)

        $user_data = User::find(Auth::user()->id);
		$avtar=Utility::get_file('uploads/avatar/');
        $user_array['id'] = $user_data->id;
        $user_array['name'] = $user_data->name;
        $user_array['email'] = $user_data->email;
        $user_array['current_business'] = $user_data->current_business;
		$user_array['avtar'] =!empty($user_data->avatar)?$avtar.$user_data->avatar:'avatar.png';

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        $user_array['token'] = $token;
        $user_array['token_type'] = 'Bearer';

        return $this->success($user_array);
    }

    public function businessData(Request $request)
    {
		$url =  url('/');
        $businessArray = [];
        $business = Business::where('created_by', \Auth::user()->creatorId())->OrderBy('id', 'desc')->paginate(10);
        if (!$business) {
            return $this->error(null,"Business not found!");
        }
        if (!empty($business)) {
            $app_url = trim(env('APP_URL'), '/');
            foreach ($business as $key => $value)
            {
                $businessArray[$key]['title']=$value->title;
                $businessArray[$key]['subtitle']=$value->sub_title;
                $businessArray[$key]['logo']=!empty($value->logo) ? $url.'/storage/card_logo/'.$value->logo : asset("custom/img/logo-placeholder-image-2.png");
                $businessArray[$key]['domain']=!empty($value->domains) ? $value->domains : "";
                $businessArray[$key]['links']=$app_url . '/' . $value->slug;
                $businessArray[$key]['subdomain']=!empty($value->subdomain) ? $value->subdomain : "";
                $png = \QrCode::format('png')->size(512)->generate($app_url . '/' . $value->slug);
                $png = base64_encode($png);
                $businessArray[$key]['qrcode_base64']=$png;
                    
            }
            return $this->success($businessArray);
        } else {
            return $this->error(null,"Business Data not found.");
        }
    }
	public function appointmentData(Request $request)
    {
        if ($request->business_name) {
            $business = Business::where('title', $request->business_name)->first();
            if ($business) {
                $appointment_deatails = Appointment_deatail::where('business_id', $business->id)->where('created_by', \Auth::user()->creatorId())->orderBy('date', 'DESC')->paginate(10);
            foreach ($appointment_deatails as $key => $value) {
                $business_name = Business::where('id', $value->business_id)->pluck('title')->first();
                $value->business_name = $business_name;
            }
            }else{
                return $this->error(null,"Business Data not found.");
            }
            
        } else {
            $appointment_deatails = Appointment_deatail::where('created_by', \Auth::user()->creatorId())->orderBy('date', 'DESC')->paginate(10);
            foreach ($appointment_deatails as $key => $value) {
                $business_name = Business::where('id', $value->business_id)->pluck('title')->first();
                $value->business_name = $business_name;
            }
        }
        if (!empty($appointment_deatails)) {
            return $this->success($appointment_deatails);
        } else {
			return $this->error(null,"Appointment detail not found.");
        }

    }
	public function appointmentDestroy(Request $request)
    {
        $rules = [
            'appointment_id' => 'required'
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return $this->error([
                'message' => $messages->first()
            ]);
        }   
        $appointment_detail = Appointment_deatail::find($request->appointment_id);
		
        if(!empty($appointment_detail)){
            $appointment_detail->delete();
			return $this->success(null,"Appointment detail deleted successfully!.");
        }else {
                return $this->error(null,"Appointment detail not found.");
        }
    }

    public function ChangeStatusAppointment(Request $request)
    {
        $rules = [
            'appointment_id' => 'required',
            'status' => 'required'
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return $this->error([
                'message' => $messages->first()
            ]);
        }   
        $appointment_detail = Appointment_deatail::find($request->appointment_id);
        if(!empty($appointment_detail)){
            if(!empty($request->status))
            {
                $appointment_detail->status = $request->status;
                $appointment_detail->save();
            }
           return $this->success(null,"Appointment status change successfully!.");
        }else {
                return $this->error(null,"Appointment detail not found.");
        }
    }
	
	public function logout(Request $request)
    {
        $user = \Auth::user();
        if (!empty($user)) {
            $user->tokens()->delete();
            return $this->success(null,"User Successfully Logout!.");
			
        } else {
            return $this->error(null,"Invalid login details");
        }
    }
	
	public function changePassword(Request $request)
    {
        $rules=[
            'old_password' => 'required',
           'password' => 'required|same:password',
           'password_confirmation' => 'required|same:password',
       ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return $this->error([
                'message' => $messages->first()
            ]);
        }
        $objUser          = Auth::user();
        $request_data     = $request->All();
        $current_password = $objUser->password;
        if(Hash::check($request_data['old_password'], $current_password))
        {
            $objUser->password = Hash::make($request_data['password']);;
            $objUser->save();
            return $this->success(null, __('Password Successfully Updated!'));
        }
        else
        {
            return $this->error(null,__('Please Enter Correct Current Password!'));
        }

    }
	
	 public function updateProfile(Request $request)
    {
        $objUser = Auth::user();
		 $userdata=[];
        $rules = [
            'name' => 'required',
            'email' => 'required|email|max:100|unique:users,email,' . $objUser->id . ',id',
        ];
        if($request->has('avatar'))
        {
            $rules['avatar'] = 'required';
        }
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return $this->error(null,$messages->first());
        }
        if(!empty($objUser))
        {
            if (!empty($request->name)) {
                $objUser->name  = $request->name;
            }
            if (!empty($request->email)) {
                $objUser->email = $request->email;
            }
            
            $dir = 'uploads/avatar/';
            $avtar=Utility::get_file('uploads/avatar/');
            if($request->has('avtar'))
            {
                if(\File::exists($avtar.$objUser->avatar))
                {
                    \File::delete($avtar.$objUser->avatar);
                }
                $newavtar = uniqid() . '.png';
                $path = Utility::upload_file($request,'avtar',$newavtar,$dir,[]);
                
                if($path['flag'] == 1){
                    $avatar = $path['url'];
                }
                else{
                    return $this->error(null,__($path['msg']));
                }
                $objUser->avatar = $newavtar;
    
            }
            $objUser->save();
			$userdata['name']=$objUser->name;
			$userdata['email']=$objUser->email;
			$userdata['avtar']=$avtar.$objUser->avatar;
			
            return $this->success($userdata,'Profile updated successfully');
        }
        else
        {
            return $this->error(null,'User not found.');
        }
    }

}


