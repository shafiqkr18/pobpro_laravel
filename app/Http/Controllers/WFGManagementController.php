<?php

namespace App\Http\Controllers;

use App\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

use App\WFGMyRequest;
use Illuminate\Http\Request;

class WFGManagementController extends Controller
{
    //
    public function my_requests()
    {
		$u_id = Auth::user()->id;
		$base64_u_id=base64_encode($u_id);  
        $url = "http://8.209.76.37/eFormIntegrated/getMyRequest.ashx?username=".$base64_u_id."&state=open&type=sid";
        $request = curl_init();
        $timeOut = 0;
        curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);

        $lists = json_decode($response,true);
        //$lists = WFGMyRequest::all();
        return view('admin.pages.wfg.my_request',compact('lists'));
    }

    public function my_requests_closed()
    {
		$u_id = Auth::user()->id;
		$base64_u_id=base64_encode($u_id);  
        $url = "http://8.209.76.37/eFormIntegrated/getMyRequest.ashx?username=".$base64_u_id."&state=closed&type=sid";
        $request = curl_init();
        $timeOut = 0;
        curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);

        $lists = json_decode($response,true);
        //$lists = WFGMyRequest::all();
        return view('admin.pages.wfg.my_request_closed',compact('lists'));
    }

    public function wfg_process_list()
    {
		$AuthenticateWFG_u_id = Auth::user()->id;
		$AuthenticateWFG_base64_u_id=base64_encode($AuthenticateWFG_u_id);  

        $AuthenticateWFG_url = "http://8.209.76.37/wfgen/AuthenticateWFG.ashx?username=".$AuthenticateWFG_base64_u_id."&type=sid";
        $AuthenticateWFG_request = curl_init();
        $AuthenticateWFG_timeOut = 0;
		
        curl_setopt ($AuthenticateWFG_request, CURLOPT_URL, $AuthenticateWFG_url);
        curl_setopt ($AuthenticateWFG_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($AuthenticateWFG_request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($AuthenticateWFG_request, CURLOPT_CONNECTTIMEOUT, $AuthenticateWFG_timeOut);
        $AuthenticateWFG_response = curl_exec($AuthenticateWFG_request);
        curl_close($AuthenticateWFG_request);

		$u_id = Auth::user()->id;
		$base64_u_id=base64_encode($u_id);  

        $url = "http://8.209.76.37/eFormIntegrated/getProcessesList.ashx?username=".$base64_u_id."&type=sid";
        $request = curl_init();
        $timeOut = 0;
        curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);

        $lists = json_decode($response,true);
        if(!$lists)  $lists = [];
        //print_r($lists);exit();
        return view('admin.pages.wfg.process_list',compact('lists'));
    }

    public  function wfg_action_list()
    {
		$u_id = Auth::user()->id;
		$base64_u_id=base64_encode($u_id); 
        $url = "http://8.209.76.37/eFormIntegrated/getMyActions.ashx?username=".$base64_u_id."&state=open&type=sid";
        $request = curl_init();
        $timeOut = 0;
        curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);

        $lists = json_decode($response,true);
        return view('admin.pages.wfg.myaction_list',compact('lists'));

    }

    public  function wfg_action_list_closed()
    {
		$u_id = Auth::user()->id;
		$base64_u_id=base64_encode($u_id); 
        $url = "http://8.209.76.37/eFormIntegrated/getMyActions.ashx?username=".$base64_u_id."&state=closed&type=sid";
        $request = curl_init();
        $timeOut = 0;
        curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);

        $lists = json_decode($response,true);
        return view('admin.pages.wfg.myaction_list_closed',compact('lists'));

    }
}
