<?php

namespace App\Http\Controllers;

use App\Models\Webhook;
use Illuminate\Http\Request;
use Auth;


class WebhookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $module = Webhook::$module;
        $method = Webhook::$method;
        return view('webhook.create',compact('module','method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'module' => 'required|unique:webhooks,module,NULL,id,created_by,' . \Auth::user()->creatorId(),
                'method' => 'required',
                'url' => 'required|',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $webhook = new Webhook();
        $webhook->module = $request->module;
        $webhook->method = $request->method;
        $webhook->url = $request->url;
        $webhook->created_by = Auth::user()->creatorId();
        $webhook->save();
        return redirect()->back()->with('success' , __('Webhook setting created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $webhook = Webhook::where('id', $id)->where('created_by', Auth::user()->id)->first();
        $module = Webhook::$module;
        $method = Webhook::$method;
        return view('webhook.edit', compact('webhook','module','method'));
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
        $webhook['module']       = $request->module;
        $webhook['method']      = $request->method;
        $webhook['url']       = $request->url;
        $webhook['created_by'] = Auth::user()->creatorId();
        Webhook::where('id', $id)->update($webhook);
        return redirect()->back()->with('success', __('Webhook Setting Succssfully Updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $webhook = Webhook::find($id);
        if ($webhook) {
                $webhook->delete();
            return redirect()->back()->with('success', __('Webhook Setting successfully deleted .'));
        } else {
            return redirect()->back()->with('error', __('Something is wrong.'));
        }
    }
}
