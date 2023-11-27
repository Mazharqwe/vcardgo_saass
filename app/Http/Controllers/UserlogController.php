<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginDetail;
use App\Models\User;
use Carbon\Carbon;

class UserlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $userList = [];
        $user = \Auth::user(); 
        $userList = User::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $userList->prepend('All', '');
        $time = date_create($request->month);
        $firstDayofMOnth = (date_format($time, 'Y-m-d'));
        $lastDayofMonth =    \Carbon\Carbon::parse($request->month)->endOfMonth()->toDateString();

        if($request->month==null && $request->user==null)
        {
            $userlogdetail = LoginDetail::select('login_details.*', 'users.name','users.avatar','users.email','users.type')
            ->leftjoin('users', 'users.id', '=', 'login_details.user_id')
            ->where('login_details.created_by','=',\Auth::user()->creatorId())
            ->whereMonth('login_details.date','=', Carbon::now()->month)
            ->get();
        }
        else
        {
            
            $userlogdetail = LoginDetail::select('login_details.*', 'users.name','users.avatar','users.email','users.type')
            ->leftjoin('users', 'users.id', '=', 'login_details.user_id')
            ->where('login_details.created_by','=',\Auth::user()->creatorId());

            if(!empty($request->month))
            {
                $userlogdetail->where('date', '>=', $firstDayofMOnth);
                $userlogdetail->where('date', '<=', $lastDayofMonth);
            }
            if(!empty($request->user))
            {
                $userlogdetail->where('user_id', $request->user);
            }
            $userlogdetail = $userlogdetail->get();
        }
        return view('userlog.index', compact('userlogdetail', 'userList'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $logData = LoginDetail::find($id);
        $json=json_decode($logData->details);
        return view('userlog.show')->with('json', $json);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $logData = LoginDetail::find($id);
        $logData->delete();
        return redirect()->back()->with('success', __('Userlog successfully deleted.'));
    }    
}
