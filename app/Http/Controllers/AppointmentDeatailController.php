<?php

namespace App\Http\Controllers;

use App\Models\Appointment_deatail;
use App\Models\Business;
use App\Models\User;
use App\Mail\AppointmentCreate;
use Mail;
use Illuminate\Http\Request;
use App\Models\Utility;
use App\Exports\ExportAppoinment;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\GoogleCalendar\Event;

use Carbon\Carbon;

class AppointmentDeatailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $user=\Auth::user();
        $business_id=$user->current_business;

        if(\Auth::user()->can('manage appointment'))
        {   
            if(!empty($business_id))
            {
                if($business_id!=0)
                {
                    $appointment_deatails = Appointment_deatail::where('business_id',$business_id)->where('created_by',\Auth::user()->creatorId())->orderBy('date','DESC');
                    if (!empty($request->start_date)) {
                        $appointment_deatails->where('date', '>=', $request->start_date);
                    }
                    if (!empty($request->end_date)) {
                        $appointment_deatails->where('date', '<=', $request->end_date);
                    }
                    $appointment_deatails = $appointment_deatails->get();
                    foreach ($appointment_deatails as $key => $value) {
                        $business_name = Business::where('id',$value->business_id)->pluck('title')->first();
                        $value->business_name = $business_name;
                        }
                }
                else
                {
                    $appointment_deatails = Appointment_deatail::where('created_by',\Auth::user()->creatorId())->orderBy('date','DESC');
                    if (!empty($request->start_date)) {
                        $appointment_deatails->where('date', '>=', $request->start_date);
                    }
                    if (!empty($request->end_date)) {
                        $appointment_deatails->where('date', '<=', $request->end_date);
                    }
                    $appointment_deatails = $appointment_deatails->get();
                    foreach ($appointment_deatails as $key => $value) {
                        $business_name = Business::where('id',$value->business_id)->pluck('title')->first();
                        $value->business_name = $business_name;
                    }
                }   
            }else{
                $appointment_deatails = Appointment_deatail::where('created_by',\Auth::user()->creatorId())->orderBy('date','DESC');
                if (!empty($request->start_date)) {
                    $appointment_deatails->where('date', '>=', $request->start_date);
                }
                if (!empty($request->end_date)) {
                    $appointment_deatails->where('date', '<=', $request->end_date);
                }
                $appointment_deatails = $appointment_deatails->get();
                foreach ($appointment_deatails as $key => $value) {
                    $business_name = Business::where('id',$value->business_id)->pluck('title')->first();
                    $value->business_name = $business_name;
                    }
            }

            
            $id=$business_id;
            if($request->get('is_live')=='1')
            {
                $type ='appointents';
                $arrayJson =  Utility::getCalendarData($type);
            }
            else
            {
                $objUser          = \Auth::user();
                if($id== null){
                    $appointents = Appointment_deatail::where('created_by',\Auth::user()->creatorId());
                    if (!empty($request->start_date)) {
                        $appointents->where('date', '>=', $request->start_date);
                    }
                    if (!empty($request->end_date)) {
                        $appointents->where('date', '<=', $request->end_date);
                    }
                    $appointents = $appointents->get();
                }else{
                    $appointents = Appointment_deatail::where('business_id',$id)->where('created_by',\Auth::user()->creatorId());
                    if (!empty($request->start_date)) {
                        $appointents->where('date', '>=', $request->start_date);
                    }
                    if (!empty($request->end_date)) {
                        $appointents->where('date', '<=', $request->end_date);
                    }
                    $appointents = $appointents->get();
                }

                $arrayJson = [];
                foreach($appointents as $appointent)
                {
                    $time = explode('-',$appointent->time);
                    $stime = isset($time[0])?trim($time[0]).':00':'00:00:00';
                    $etime = isset($time[1])?trim($time[1]).':00':'00:00:00';
                    $start_date = date("Y-m-d",strtotime($appointent->date)).' '.$stime;
                    $end_date = date("Y-m-d",strtotime($appointent->date)).' '.$etime;

                    $arrayJson[] = [
                        "title" =>'('.$stime .' - '. $etime.') '.$appointent->name .'-'. $appointent->getBussinessName(),
                        "start" => $start_date,
                        "end" => $end_date ,
                        "app_id" => $appointent->id,
                        "url" => route('appointment.details',$appointent->id),
                        "className" =>  'event-info',
                        "allDay" => false,
                        "business_id"=>$id,
                    ];
                }
            }
            return view('appointments.index',compact('appointment_deatails','arrayJson'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $business_id = $request->business_id;
        $business = Business::where('id',$business_id)->first();
        
        $appointment_deatails = Appointment_deatail::where('business_id',$business_id)->where('created_by',$business->created_by)->get();
        
        if($appointment_deatails)
        {
            foreach ($appointment_deatails as $key => $value) {
                
                if($value->date==$request->date && $value->time==$request->time)
                {
                    $data['msg']  = __("The appointment already booked.Please select another date or time.");
                    $data['flag'] = false;
                    return $data;
                }
            }
        }
        $user = User::where('id',$business->created_by)->first();
        $appointment = Appointment_deatail::create([
            'business_id' => $request->business_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'created_by' => $business->created_by
        ]);

        $module ='New Appointment';
        if(\Auth::user())
        {
            $webhook=  Utility::webhookSetting($module,\Auth::user()->creatorId());
        }
        else
        {
            $webhook=  Utility::webhookSetting($module,$business->created_by);
        }
        
        if($webhook)
        {
            $parameter = json_encode($appointment);
            // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
            $status = Utility::WebhookCall($webhook['url'],$parameter,$webhook['method']);
            if($status == true)
            {
                //return redirect()->back()->with('success', __('User successfully created!'));
            }
            else
            {
                //return redirect()->back()->with('error', __('Webhook call failed.'));
            }
        }

        $email = Utility::getValByName('company_email');
        if(!isset($email) || empty($email) || $email == null || $email == ""){
            $email = $user->email;
        }
        $settings = [];
        $settings['from_name'] = $appointment->name;
        $settings['from_email'] = $appointment->email;

        $settings = Utility::settings();
        if(isset($settings['Google_Calendar']) && $settings['Google_Calendar'] == 'on')
        {
            $type ='appointents';
                Utility::googleCalendarConfig();

                $event = new Event();

                $event->name = $request->name;
                $event->startDateTime = Carbon::parse($request->date);$newDateTime = Carbon::now()->addHours(5);
                $event->endDateTime = Carbon::parse($request->date)->addHours($request->time);
                $event->colorId = Utility::colorCodeData($type);

                $event->save();
        }
        try
        {
            $appArr = [
                'appointment_name' => $request->name,
                'appointment_email' => $request->email,
                'appointment_phone' => $request->phone,
                'appointment_date' => $request->date,
                'appointment_time' => $request->time,
                'created_by' => $business->created_by,
            ];
                
            $resp = Utility::sendEmailTemplate('Appointment Created',$appArr,$appointment->email);
            Mail::to($email)->send(new AppointmentCreate($appointment,$settings));
        }
        catch(\Exception $e)
        {
            $error = __('E-Mail has been not sent due to SMTP configuration');
        }
    }
    
 
    public function destroy(Appointment_deatail $appointment_deatail,$id)
    {
        if(\Auth::user()->can('delete appointment'))
        {
            $app = Appointment_deatail::find($id);
            if($app){
                $app->delete();
                return redirect()->back()->with('success', __('Appointment successfully deleted.'));
            }
            return redirect()->back()->with('error', __('Appointment not found.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getCalenderAllData($id=null)
    {
        if(\Auth::user()->can('calendar appointment'))
        {
            $objUser          = \Auth::user();
            if($id== null){
                $appointents = Appointment_deatail::where('created_by',\Auth::user()->creatorId())->get();
            }else{
                $appointents = Appointment_deatail::where('business_id',$id)->where('created_by',\Auth::user()->creatorId())->get();
            }

            $arrayJson = [];
            foreach($appointents as $appointent)
            {
                $time = explode('-',$appointent->time);
                $stime = isset($time[0])?trim($time[0]).':00':'00:00:00';
                $etime = isset($time[1])?trim($time[1]).':00':'00:00:00';
                $start_date = date("Y-m-d",strtotime($appointent->date)).' '.$stime;
                $end_date = date("Y-m-d",strtotime($appointent->date)).' '.$etime;

                $arrayJson[] = [
                    "title" =>'('.$stime .' - '. $etime.') '.$appointent->name .'-'. $appointent->getBussinessName(),
                    "start" => $start_date,
                    "end" => $end_date ,
                    "app_id" => $appointent->id,
                    "url" => route('appointment.details',$appointent->id),
                    "className" =>  'event-info',
                    "allDay" => false,
                    "business_id"=>$id,
                ];
            }
            return view('appointments.calender',compact('arrayJson','id'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function getAppointmentDetails($id){
        $ad = Appointment_deatail::find($id);
        return view('appointments.calender-modal',compact('ad'));
    }

    public function add_note($id){
        $appointment = Appointment_deatail::where('id',$id)->first();
        return view('appointments.add_note',compact('appointment'));
    }

    public function note_store($id,Request $request){

        if(\Auth::user()->can('edit appointment'))
        {
            $appointment = Appointment_deatail::where('id',$id)->first();
            $appointment->status = $request->status;
            $appointment->note = $request->note;
            $appointment->save();
            return redirect()->back()->with('success', __('Note added successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function get_appointment_data(Request $request)
    {
        $objUser=\Auth::user();
        $business_id=$objUser->current_business;
        
        $id=$request->id;
        if($request->get('is_live')=='1')
        {
            $type ='appointents';
            $arrayJson =  Utility::getCalendarData($type);
        }
        else
        {
            if($id== null){
                if($business_id!=null)
                {
                    $appointents = Appointment_deatail::where('business_id',$business_id)->where('created_by',\Auth::user()->creatorId());
                    if (!empty($request->start_date)) {
                        $appointents->where('date', '>=', $request->start_date);
                    }
                    if (!empty($request->end_date)) {
                        $appointents->where('date', '<=', $request->end_date);
                    }
                    $appointents = $appointents->get();
                }else{
                    $appointents = Appointment_deatail::where('created_by',\Auth::user()->creatorId());
                    if (!empty($request->start_date)) {
                        $appointents->where('date', '>=', $request->start_date);
                    }
                    if (!empty($request->end_date)) {
                        $appointents->where('date', '<=', $request->end_date);
                    }
                    $appointents = $appointents->get();
                }
               
            }else{
                
                    $appointents = Appointment_deatail::where('business_id',$id)->where('created_by',\Auth::user()->creatorId());
                    if (!empty($request->start_date)) {
                        $appointents->where('date', '>=', $request->start_date);
                    }
                    if (!empty($request->end_date)) {
                        $appointents->where('date', '<=', $request->end_date);
                    }
                    $appointents = $appointents->get();
                
            }

            $arrayJson = [];
            foreach($appointents as $appointent)
            {
                $time = explode('-',$appointent->time);
                $stime = isset($time[0])?trim($time[0]).':00':'00:00:00';
                $etime = isset($time[1])?trim($time[1]).':00':'00:00:00';
                $start_date = date("Y-m-d",strtotime($appointent->date)).' '.$stime;
                $end_date = date("Y-m-d",strtotime($appointent->date)).' '.$etime;

                $arrayJson[] = [
                    "title" =>'('.$stime .' - '. $etime.') '.$appointent->name .'-'. $appointent->getBussinessName(),
                    "start" => $start_date,
                    "end" => $end_date ,
                    "app_id" => $appointent->id,
                    "url" => route('appointment.details',$appointent->id),
                    "className" =>  'event-info',
                    "allDay" => false,
                    "business_id"=>$id,
                ];
            }
        }
        return $arrayJson;
    }

    public function export()
    {
        $name = 'name' . date('Y-m-d i:h:s');
        $data = Excel::download(new ExportAppoinment(), $name . '.xlsx'); ob_end_clean();
        return $data;
    }
}

