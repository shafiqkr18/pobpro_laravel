<?php


namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class WechatController
 * @package App\Http\Controllers
 */
class WechatController extends Controller
{
    public function Login_WeChat_Work()
    {
        return view('admin.pages.wechat.login');
    }

    public function  login_wechatwork_gettoken()
    {
        return view('admin.pages.wechat.login_token');
    }

    public function login_wechatwork_final(Request $request)
    {
        $userid =  $request->input('userid');
        $uuid =  $request->input('uuid');
        if(!empty($userid))
        {
            if (User::where('user_name', '=', $userid)->where('str_code', '=', $uuid)->exists()) {
                $user = User::where('user_name', $userid)->where('str_code', '=', $uuid)->first();
                Auth::login($user);
                return redirect('admin/dashboard');
            }
        }else{
            return redirect('admin/login_wechatwork');
        }

    }

}
