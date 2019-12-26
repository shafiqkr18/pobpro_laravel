<?php


namespace App\Http\Controllers\api;
use App\CorrespondenceAddress;
use App\CorrespondenceMessage;
use App\DepartmentManagement;
use App\VisaManagement;
use App\WFGMyAction;
use App\WFGMyRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class WFGController extends Controller
{

    public function getDepartments(Request $request)
    {
        $validator = validator::make($request->all(), [
            'company_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors(),
                'code' => 400,
                'result' => ''
            ], 400);
        }
        $company_id = $request->input('company_id');
        $departments = DepartmentManagement::whereHas('organization', function ($query) use ($company_id) {
            $query->where('company_id', $company_id);
        })->whereNull('deleted_at')->get();
        $show_arr = array();
        foreach ($departments as $arr) {
            $show_arr[] = array(
                'id' =>  $arr->id,
                'org_id' =>  $arr->org_id,
                'division_id' =>  $arr->div_id,
                'dept_code' =>  $arr->dept_code,
                'short_name' =>  $arr->department_short_name,
                'full_name' =>  $arr->department_name,

            );
        }
        return response()->json([
            'status'=>'success',
            'message'=>'success result',
            'code'=>200,
            'result'=>$show_arr

        ], 200);

    }

    public function CorrespondenceAddresses(Request $request)
    {
        $addresses = CorrespondenceAddress::all();
        $show_arr = array();
        foreach ($addresses as $arr) {
            $show_arr[] = array(
                'id' =>  $arr->id,
                'u_id' =>  $arr->u_id,
                'first_name' =>  $arr->first_name,
                'middle_name' =>  $arr->middle_name,
                'last_name' =>  $arr->last_name,
                'email' =>  $arr->email,
                'position' =>  $arr->position,
                'company' =>  $arr->company,
                'address' =>  $arr->address,
                'city' =>  $arr->city,
                'country' =>  $arr->country,
                'website' =>  $arr->website,


            );
        }

        return response()->json([
            'status'=>'success',
            'message'=>'success result',
            'code'=>200,
            'result'=>$show_arr

        ], 200);
    }

    public function SaveCorrespondenceReply(Request $request)
    {
        $validator = validator::make($request->all(), [
            'wfg_id' => 'required',
            'reference_no' => 'required',
            //'msg_code' => 'required',
            'subject' => 'required',
            'msg_date' => 'required',
            'created_by' =>'required',


        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors(),
                'code' => 400,
                'result' => ''
            ], 400);
        }

        try {
           $wfg_id = $request->input('wfg_id');

           if(CorrespondenceMessage::where('wfg_id', '=', $wfg_id)->exists())
           {
               $CorrespondenceMsg = CorrespondenceMessage::where('wfg_id',$wfg_id)->first();
           }else{
               $CorrespondenceMsg = new CorrespondenceMessage();
               $CorrespondenceMsg->created_at = date('Y-m-d H:i:s');
           }


            $CorrespondenceMsg->updated_at = date('Y-m-d H:i:s');
            $CorrespondenceMsg->wfg_id = $request->input('wfg_id');
            $CorrespondenceMsg->msg_code = $request->input('msg_code');
            $CorrespondenceMsg->reference_no = $request->input('reference_no');
            $CorrespondenceMsg->subject = $request->input('subject');
            $CorrespondenceMsg->direction = $request->input('direction') ? $request->input('direction') : 'IN';
            $CorrespondenceMsg->msg_date = $request->input('msg_date');
            $CorrespondenceMsg->details_date = $request->input('details_date');
            $CorrespondenceMsg->contents = $request->input('contents');
            $CorrespondenceMsg->assign_dept_id = $request->input('assign_dept_id');
            $CorrespondenceMsg->attachment_file_name = $request->input('attachment_file_name');
            $CorrespondenceMsg->attachment_files = $request->input('attachment_files');
            $CorrespondenceMsg->orignal_file_name = $request->input('orignal_file_name');
            $CorrespondenceMsg->orignal_files = $request->input('orignal_files');
            $CorrespondenceMsg->msg_from_id = $request->input('msg_from_id');
            $CorrespondenceMsg->msg_to_id = $request->input('msg_to_id');
            $CorrespondenceMsg->msg_related_to = $request->input('msg_related_to');
            $CorrespondenceMsg->prepare_answer = $request->input('prepare_answer');

            $CorrespondenceMsg->line_mgr_approval = $request->input('line_mgr_approval');
            $CorrespondenceMsg->line_mgr_approval_text = $request->input('line_mgr_approval_text');
            $CorrespondenceMsg->gm_approval = $request->input('gm_approval');
            $CorrespondenceMsg->gm_approval_text = $request->input('gm_approval_text');
            $CorrespondenceMsg->vp_approval = $request->input('vp_approval');
            $CorrespondenceMsg->vp_approval_text = $request->input('vp_approval_text');
            $CorrespondenceMsg->hr_mgr_approval = $request->input('hr_mgr_approval');
            $CorrespondenceMsg->hr_mgr_approval_text = $request->input('hr_mgr_approval_text');
            $CorrespondenceMsg->hr_translategroup_topic = $request->input('hr_translategroup_topic');
            $CorrespondenceMsg->hr_translategroup_arabictopic = $request->input('hr_translategroup_arabictopic');
            $CorrespondenceMsg->hr_translategroup_attachfilename = $request->input('hr_translategroup_attachfilename');
            $CorrespondenceMsg->hr_translategroup_attachfile = $request->input('hr_translategroup_attachfile');

            $CorrespondenceMsg->hr_translategroup_translatefilename = $request->input('hr_translategroup_translatefilename');
            $CorrespondenceMsg->hr_translategroup_translatefile = $request->input('hr_translategroup_translatefile');
            $CorrespondenceMsg->gm_approvaltranslate = $request->input('gm_approvaltranslate');
            $CorrespondenceMsg->gm_approvaltranslate_text = $request->input('gm_approvaltranslate_text');
            $CorrespondenceMsg->created_by = $request->input('created_by');
            if($request->input('company_id'))
            {
                $CorrespondenceMsg->company_id = $request->input('company_id');
            }else{
                $user = User::where('id', '=', $request->input('created_by'))->first();
                $CorrespondenceMsg->company_id = $user->company_id;
            }

            $CorrespondenceMsg->status = $request->input('status')?$request->input('status'):0;



            if($CorrespondenceMsg->save())
            {
                $correspondence_id = $CorrespondenceMsg->id;
                return response()->json([
                    'status' => 'success',
                    'message' => "Data saved successfully",
                    'code' => 200,
                    'result' => $correspondence_id
                ], 200);
            }else{
                return response()->json([
                    'status' => 'failure',
                    'message' => "Some error occurred",
                    'code' => 400,
                    'result' => ''
                ], 400);
            }


        }catch (\Exception $e) {

            $message = $e->getMessage();
            return response()->json([
                'status' => 'failure',
                'message' => $message,
                'code' => 400,
                'result' => ''
            ], 400);
        }
    }
    //save visa request
    public function save_visa_info(Request $request)
    {
        $validator = validator::make($request->all(), [
            'user_id' => 'required',
            'reference_number' => 'required',
            'request_date' => 'required',
            'passport_number' => 'required',
            'issue_date' => 'required',
            'expiry_date' => 'required',
            'request_type' => 'required',
            'visa_expiry_date' => 'required',
            'visa_type' => 'required',
            'notes' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors(),
                'code' => 400,
                'result' => ''
            ], 400);
        }

        try {
            $visa = new VisaManagement();
            $visa->user_id = $request->input('user_id');
            $visa->reference_number = $request->input('reference_number');
            $visa->request_date = $request->input('request_date');
            $visa->passport_number = $request->input('passport_number');
            $visa->issue_date = $request->input('issue_date');
            $visa->expiry_date = $request->input('expiry_date');
            $visa->request_type = $request->input('request_type');
            $visa->visa_expiry_date = $request->input('visa_expiry_date');
            $visa->visa_type = $request->input('visa_type');
            $visa->notes = $request->input('notes');
            $visa->attachment = $request->input('attachment');
            $visa->created_at = date('Y-m-d H:i:s');
            if ($visa->save()) {
                $visa_id = $visa->save();
                return response()->json([
                    'status' => 'success',
                    'message' => "Data saved successfully",
                    'code' => 200,
                    'result' => $visa_id
                ], 200);

            }else{

                return response()->json([
                    'status' => 'failure',
                    'message' => "Some error occurred",
                    'code' => 400,
                    'result' => ''
                ], 400);
            }

        } catch (\Exception $e) {

            $message = $e->getMessage();
            return response()->json([
                'status' => 'failure',
                'message' => $message,
                'code' => 400,
                'result' => ''
            ], 400);
        }
    }


    public function get_wfg_requests(Request $request)
    {
        $url = "http://8.209.76.37/eFormIntegrated/getMyRequest.ashx?username=wfgen_admin&state=open";
        $request = curl_init();
        $timeOut = 0;
        curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);

        $results = json_decode($response,true);
        //print_r($results);
        foreach ($results as $res)
        {
           // echo $res['ID_PROCESS_INST'];
            if (WFGMyRequest::where('id_process_inst', '=', $res['ID_PROCESS_INST'])->exists()) {
                $myreq = WFGMyRequest::where('id_process_inst', '=', $res['ID_PROCESS_INST'])->first();
                $myreq->updated_at = date('Y-m-d H:i:s');
            }else{
                $myreq = new WFGMyRequest();
                $myreq->created_at = date('Y-m-d H:i:s');
            }

            $myreq->id_process_inst = $res['ID_PROCESS_INST'];
            $myreq->id_process = $res['ID_PROCESS'];
            $myreq->is_test = $res['TEST'];
            $myreq->name = $res['NAME'];
            $myreq->id_state = $res['ID_STATE'];
            $myreq->id_substate = $res['ID_SUBSTATE'];
            $myreq->description = $res['DESCRIPTION'];
            $myreq->date_open = $res['DATE_OPEN']?date('Y-m-d H:i:s',strtotime($res['DATE_OPEN'])):null;
            $myreq->date_close = $res['DATE_CLOSE']?date('Y-m-d H:i:s',strtotime($res['DATE_CLOSE'])):null;
            $myreq->date_limit = $res['DATE_LIMIT']?date('Y-m-d H:i:s',strtotime($res['DATE_LIMIT'])):null;
            $myreq->date_start = $res['DATE_START']?date('Y-m-d H:i:s',strtotime($res['DATE_START'])):null;
            $myreq->id_user_requester = $res['ID_USER_REQUESTER'];

            $myreq->id_user_requester_real = $res['ID_USER_REQUESTER_REAL'];
            $myreq->id_user_aborted = $res['ID_USER_ABORTED'];
            $myreq->id_parentprocess_inst = $res['ID_PARENTPROCESS_INST'];
            $myreq->id_parentactivity_inst = $res['ID_PARENTACTIVITY_INST'];

            $myreq->id_participant = $res['ID_PARTICIPANT'];
            $myreq->pname = $res['PNAME'];
            $myreq->save();
        }

        return redirect()
            ->route("wfg-my-requests")
            ->with([
                'alert-message'    => "Refresh successfully!",
                'alert-type' => 'success',
            ]);
    }

    public function get_wfg_actions(Request $request)
    {
        $url = "http://8.209.76.37/eFormIntegrated/getMyActions.ashx?username=wfgen_admin&state=open";
        $request = curl_init();
        $timeOut = 0;
        curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);

        $results = json_decode($response,true);
        //print_r($results);
        foreach ($results as $res)
        {
            // echo $res['ID_PROCESS_INST'];
            if (WFGMyAction::where('id_process_inst', '=', $res['ID_PROCESS_INST'])->where('id_activity_inst',$res['ID_ACTIVITY_INST'])->exists()) {
                $myreq = WFGMyAction::where('id_process_inst', '=', $res['ID_PROCESS_INST'])->where('id_activity_inst',$res['ID_ACTIVITY_INST'])->first();
                $myreq->updated_at = date('Y-m-d H:i:s');
            }else{
                $myreq = new WFGMyAction();
                $myreq->created_at = date('Y-m-d H:i:s');
            }

            $myreq->id_process_inst = $res['ID_PROCESS_INST'];
            $myreq->id_process = $res['ID_PROCESS'];
            $myreq->is_test = $res['TEST'];
            $myreq->process_name = $res['TEST'];
            $myreq->name = $res['NAME'];
            $myreq->id_state = $res['ID_STATE'];
            $myreq->id_substate = $res['ID_SUBSTATE'];
            $myreq->description = $res['DESCRIPTION'];
            $myreq->date_open = $res['DATE_OPEN']?date('Y-m-d H:i:s',strtotime($res['DATE_OPEN'])):null;
            $myreq->date_close = $res['DATE_CLOSE']?date('Y-m-d H:i:s',strtotime($res['DATE_CLOSE'])):null;
            $myreq->date_limit = $res['DATE_LIMIT']?date('Y-m-d H:i:s',strtotime($res['DATE_LIMIT'])):null;
            $myreq->date_start = $res['DATE_START']?date('Y-m-d H:i:s',strtotime($res['DATE_START'])):null;
            $myreq->id_user_requester = $res['ID_USER_REQUESTER'];

            $myreq->id_user_requester_real = $res['ID_USER_REQUESTER_REAL'];
            $myreq->id_user_aborted = $res['ID_USER_ABORTED'];
            $myreq->id_parentprocess_inst = $res['ID_PARENTPROCESS_INST'];
            $myreq->id_parentactivity_inst = $res['ID_PARENTACTIVITY_INST'];

            $myreq->id_participant = $res['ID_PARTICIPANT'];
            $myreq->pname = $res['PNAME'];
            $myreq->save();
        }

        return redirect()
            ->route("wfg-my-requests")
            ->with([
                'alert-message'    => "Refresh successfully!",
                'alert-type' => 'success',
            ]);
    }
}
