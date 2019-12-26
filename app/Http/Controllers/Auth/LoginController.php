<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Login page
     *
     * @return View
     */
    public function login()
    {
        return view('admin.pages.login');
    }


    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $requestNew = $request->all();
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
        }
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        $credentials = filter_var($email, FILTER_VALIDATE_EMAIL)
            ? ['email' => $email, 'password' => $password]
            : ['username' => $email, 'password' => $password];



        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed...
						$user = Auth::user();

			//check where should go
//            //if employee then go to employee
//            if(Auth::user()->hasRole('Employee'))
//            {
//                $redirect_me = 'employee';
//            }else{
//                $redirect_me = $user->user_type == 2 ? 'candidate' :'admin/dashboard';
//            }
                $redirect_me = $user->user_type == 2 ? 'candidate' :'employee-portal';


            return json_encode([
                'success' => true,
                'user' => Auth::user(),
                'type' => 'login',
                'redirect' => $redirect_me,
                //'token' => $token
            ]);
        } else {
            return json_encode([
                'success' => false,
                'type' => 'login'
            ]);
        }
    }

    /**
     * Logout current user.
     *
     * @return void
     */
    public function logout(Request $request)
    {
			$request->session()->forget('initial_login');
        Auth::logout();
        return redirect('/admin/login');
    }


    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('wechat_web')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('wechat_web')->user();

        // $user->token;
        dd($user->token);
    }
}
