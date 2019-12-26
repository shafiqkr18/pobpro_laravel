<?php


namespace App\Http\Controllers\api;
use App\Company;
use App\Offer;
use App\Plan;
use App\PositionManagement;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function __construct()
    {

    }
    public function get_userinfo(Request $request)
    {
        //Auth::logout();
        $ACCESS_TOKEN = $request->input('ACCESS_TOKEN');
        $CODE =  $request->input('CODE');
        $corpid =  $request->input('corpid');
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=" .$ACCESS_TOKEN."&code=".$CODE;
        $request = curl_init();
        $timeOut = 0;
        curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);
        //print_r($response);
        $r = json_decode($response,true);

        //get company_id
        $company_id = 0;
        if (Company::where('wechat_corpid', '=', $corpid)->exists()) {
            $cmp = Company::where('wechat_corpid', $corpid)->first();
            $company_id = $cmp->id;
        }

        if($r['errcode'] == 0)
        {
            $UserId = $r['UserId'];
            if (User::where('user_name', '=', $UserId)->exists()) {
                $user = User::where('user_name', $UserId)->first();
                //Auth::login($user);
                $uuid = $user->str_code;
            }else{
                $uuid = (string) Str::uuid();
                $user = new User();
                $user->name = $UserId;
                $user->user_name = $UserId;
                $user->email = $UserId."55555@email.com";
                $user->password = Hash::make('123456789');
                $user->user_type = 5;//wechat user
                $user->user_uuid = $uuid;//$ACCESS_TOKEN;
                $user->str_code = $uuid;
                $user->wechat_code = $CODE;
                $user->device_id = $r['DeviceId'];
                $user->company_id = $company_id;
                if ($user->save()) {
                    $user_id = $user->id;
                    $user->assignRole('Wechat');
                    Auth::login($user);
                    $c = Company::find($company_id);
                    $c->user_uuid = $uuid;
                    $c->created_by = $user_id;
                    $c->ent_admin_id = $user_id;
                    $c->save();
                }
            }

            return response()->json([
                'success' => true,
                'UserId' => $UserId,
                'message' =>$r['errmsg'],
                'url' =>$url,
                'uuid' =>$uuid
            ]);
        }else{
            return response()->json([
                'success' => false,
                'UserId' => '',
                'message' =>$r['errmsg'],
                'url' =>$url,
                'uuid'=>''
            ]);
        }



//        return response()->json([
//            'data' => $response
//        ]);
    }
    public function get_Token(Request $request){
        $corpid = "ww940ffc36d366b31e";
        //check if token expired
        $result = DB::table('wechat_tokens')
           // where('token')
            ->where('created_at', '>',Carbon::now()->subHours(2)->toDateTimeString() )
            ->first();

        if(!$result)
        {

            $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=".$corpid."&corpsecret=F12HVScfloDO97CU2tAjdbU401EEOfREwkf906PKM5M";
            $request = curl_init();
            $timeOut = 0;
            curl_setopt ($request, CURLOPT_URL, $url);
            curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
            curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
            $response = curl_exec($request);
            curl_close($request);

            $r = json_decode($response,true);
            if($r['errcode'] == 0)
            {
                //check if company exist
                if (Company::where('wechat_corpid', '=', $corpid)->exists()) {
                    //TODO
                }else{
                    $company = new Company();
                    $company->company_name = $corpid;//they can update later
                   // $company->website = '';
                    //$company->email = $request->input('company_email');
                   // $company->phone_no = $request->input('phone_no');
                   // $company->address = $request->input('address');
                   // $company->city = $request->input('city');
                    $company->subscription_type =0;
                    $company->ent_admin_id = 0;
                    $company->created_by = 0;
                    $company->wechat_corpid = $corpid;
                    $company->created_at = date('Y-m-d H:i:s');
                    $company->expired_at = date('Y-m-d H:i:s', strtotime('+30 days'));
                    $company->updated_at = date('Y-m-d H:i:s');
                    $company->save();
                }

            DB::table('wechat_tokens')->insert(
                array('token' => $r['access_token'], 'created_at' => date('Y-m-d H:i:s'))
            );
            return response()->json([
                'success' => true,
                'access_token' => $r['access_token'],
                'errmsg' => 'ok',
                    'errcode' => 0,
                    'corpid' => $corpid
            ]);
        }else{

                return response()->json([
                    'success' => false,
                    'access_token' => $r['access_token'],
                    'errmsg' => 'error',
                    'errcode' => $r['errcode'],
                    'corpid' => $corpid
                ]);
            }

        }else{

            return response()->json([
                'success' => true,
                'access_token' => $result->token,
                'errmsg' => 'ok',
                'errcode' => 0,
                'corpid' => $corpid
            ]);
        }



    }

    public function positions_list(Request $request)
    {
        $validator = validator::make($request->all(), [
            'company_id' => 'required',


        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'failure',
                'message'=>$validator->errors(),
                'code'=>400,
                'result'=>''
            ], 400);
        }

        $positions = PositionManagement::where('status','=','open')->get();
        $show_arr = array();
        foreach ($positions as $arr) {
            $show_arr[] = array(
                'id' =>  $arr->id,
                'reference_no' =>  $arr->reference_no,
                'title' =>  $arr->title,
                'local_positions' =>  $arr->local_positions,
                'expat_positions' =>  $arr->expat_positions,
                'other_positions' =>  $arr->other_positions,
                'total_positions' =>  $arr->total_positions,
                'positions_filled' =>  $arr->positions_filled,
                'job_description' =>  $arr->job_description,
                'department_id' =>  $arr->department_id,


            );
        }

        return response()->json([
            'status'=>'success',
            'message'=>'success result',
            'code'=>200,
            'result'=>$show_arr

        ], 200);
    }

    public function get_pending_offers_contracts(Request $request)
    {
        $validator = validator::make($request->all(), [
            'company_id' => 'required',
            'approved_from' => 'required',
            'type' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'failure',
                'message'=>$validator->errors(),
                'code'=>400,
                'result'=>''
            ], 400);
        }

        $offers = Offer::whereNull('deleted_at');
        if($request->type == 1)
        {
            $offers =     $offers->where('type', 1);
        }else{
            $offers =     $offers->where('type', 0);
        }

        //approved_from = DM,HRM,GM
        $approved_from  = $request->approved_from;
        if($approved_from == 'DM')
        {
            $offers->where('dm_approved', 0);
        }elseif ($approved_from == 'GM')
        {
            $offers->where('gm_approved', 0);
        }else{
            $offers->where('hrm_approved', 0);
        }

        $offers = $offers->get();

        $show_arr = array();
        foreach ($offers as $arr) {
            $show_arr[] = array(
                'id' =>  $arr->id,
                'reference_no' =>  $arr->reference_no,
                'position_id' =>  $arr->position_id,
                'candidate_id' =>  $arr->candidate_id,
                'type' =>  $arr->type,
                'position_type' =>  $arr->position_type,
                'report_to' =>  $arr->report_to,
                'work_start_date' =>  $arr->work_start_date,
                'subject' =>  $arr->subject,
                'notes' =>  $arr->notes,
                'accepted' =>  $arr->accepted,
                'dm_approved' =>  $arr->dm_approved,
                'hrm_approved' =>  $arr->hrm_approved,
                'gm_approved' =>  $arr->gm_approved,
                'offer_amount' =>  $arr->offer_amount,

            );
        }

        return response()->json([
            'status'=>'success',
            'message'=>'success result',
            'code'=>200,
            'result'=>$show_arr

        ], 200);

    }

    public function pending_summary()
    {
        $offers = Offer::where('deleted_at', null)->get();
        $plans =  Plan::where('is_approved',0)->where('deleted_at', null)->get();
        $all_offers = $offers;
        $dm_offers  = $all_offers->where('dm_approved', 0)->where('type', 0);
        $hrm_offers  = $all_offers->where('hrm_approved', 0)->where('type', 0);
        $gm_offers  = $all_offers->where('gm_approved', 0)->where('type', 0);

        //find contracts
        $dm_contracts  = $offers->where('dm_approved', 0)->where('type', 1);
        $hrm_contracts  = $offers->where('hrm_approved', 0)->where('type', 1);
        $gm_contracts  = $offers->where('gm_approved', 0)->where('type', 1);


        //offers
        $dm_offers_cnt = 0;
        $dm_offers_time = 0;
        if(count($dm_offers)>0)
        {
            $dm_offers_cnt = count($dm_offers);
            $dm_offers_time = time_ago($dm_offers->first()->created_at);
        }

        $hrm_offers_cnt = 0;
        $hrm_offers_time = 0;
        if(count($hrm_offers)>0)
        {
            $hrm_offers_cnt = count($hrm_offers);
            $hrm_offers_time = time_ago($hrm_offers->first()->created_at);
        }

        $gm_offers_cnt = 0;
        $gm_offers_time = 0;
        if(count($gm_offers)>0)
        {
            $gm_offers_cnt = count($gm_offers);
            $hrm_offers_time = time_ago($gm_offers->first()->created_at);
        }


        //contracts
        $dm_cn_cnt = 0;
        $dm_cn_time = 0;
        if(count($dm_contracts)>0)
        {
            $dm_cn_cnt = count($dm_contracts);
            $dm_cn_time = time_ago($dm_contracts->first()->created_at);
        }

        $hrm_cn_cnt = 0;
        $hrm_cn_time = 0;
        if(count($hrm_contracts)>0)
        {
            $hrm_cn_cnt = count($hrm_contracts);
            $hrm_cn_time = time_ago($hrm_contracts->first()->created_at);
        }

        $gm_cn_cnt = 0;
        $gm_cn_time = 0;
        if(count($gm_contracts)>0)
        {
            $gm_cn_cnt = count($gm_contracts);
            $gm_cn_time = time_ago($gm_contracts->first()->created_at);
        }


        $show_arr = array(
            'DM_Offers' =>  $dm_offers_cnt,
            'DM_Offers_time' =>  $dm_offers_time,
            'HRM_Offers' =>  $hrm_offers_cnt,
            'HRM_Offers_time' =>  $hrm_offers_time,
            'GM_Offers' =>  $gm_offers_cnt,
            'GM_Offers_time' =>  $gm_offers_time,
            'DM_Contracts' =>  $dm_cn_cnt,
            'DM_Contracts_time' =>  $dm_cn_time,
            'HRM_Contracts' =>  $hrm_cn_cnt,
            'HRM_Contracts_time' =>  $hrm_cn_time,
            'GM_Contracts' =>  $gm_cn_cnt,
            'GM_Contracts_time' =>  $gm_cn_time,


        );

        return response()->json([
            'status'=>'success',
            'message'=>'success result',
            'code'=>200,
            'result'=>$show_arr

        ], 200);



    }

}
