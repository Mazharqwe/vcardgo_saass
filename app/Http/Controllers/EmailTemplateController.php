<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\Utility;
use App\Models\EmailTemplateLang;
use Illuminate\Http\Request;
use App\Models\Languages;


class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function manageEmailLang($lang = 'en',$id = '1')
    {
        $count = EmailTemplate::where('id',$id)->where('created_by',\Auth::user()->id)->count();
        if ($count == 0)
        {
            return redirect()->back()->with('error', __('This card number is not yours.'));
        }
        $languages         = Utility::languages();
        $emailTemplate     = EmailTemplate::where('id', '=', $id)->first();
        $EmailTemplates =EmailTemplate::all();
        $currEmailTempLang = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', $lang)->first();

        if(!isset($currEmailTempLang) || empty($currEmailTempLang))
        {
            $currEmailTempLang       = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', 'en')->first();
            $currEmailTempLang->lang = $lang;
        }
        $languageData=Languages::languageData($currEmailTempLang->lang);
        
        if($languageData==null)
            {
                return redirect()->back();
            }
        return view('email_templates.index', compact('emailTemplate','EmailTemplates', 'languages', 'currEmailTempLang','languageData'));  
    }

    public function updateEmailSettings(Request $request,$id){

       
        $validator = \Validator::make(
            $request->all(), [
                               'from' => 'required',
                               'subject' => 'required',
                               'content' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $emailTemplate       = EmailTemplate::where('id',$id)->first();
        $emailTemplate->from = $request->from;
        $emailTemplate->save();
        $emailLangTemplate = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', '=', $request->lang)->first();
        // if record not found then create new record else update it.
        if(empty($emailLangTemplate))
        {
            $emailLangTemplate            = new EmailTemplateLang();
            $emailLangTemplate->parent_id = $id;
            $emailLangTemplate->lang      = $request['lang'];
            $emailLangTemplate->subject   = $request['subject'];
            $emailLangTemplate->content   = $request['content'];
            $emailLangTemplate->save();
        }
        else
        {
            $emailLangTemplate->subject = $request['subject'];
            $emailLangTemplate->content = $request['content'];
            $emailLangTemplate->save();
        }
        return redirect()->route(
            'manage.email.language', [
                                        $request->lang,
                                       $emailTemplate->id,
                                       
                                   ]
        )->with('success', __('Email Template successfully updated.'));
    }

}
