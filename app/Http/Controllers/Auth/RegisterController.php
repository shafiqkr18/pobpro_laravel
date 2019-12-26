<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Candidate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
		
		protected $uuid;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
			$this->setUuid();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
						'user_type' => 2,
						'user_uuid' => $this->getUuid()
        ]);
    }

    /**
     * Register page
     *
     * @return View
     */
    public function register()
    {
        return view('admin.pages.register');
    }

    /**
     * Override default register method from RegistersUsers trait
     *
     * @param array $request
     * @return redirect to $redirectTo
     */
    public function register_submit(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
        }

        $user = $this->create($request->all());
        //$token = $user->createToken('POBPRO')->accessToken;
        \Auth::login($user);
				
				$candidate = new Candidate();
				$candidate->name = $request->input('name');
				$candidate->email = $request->input('email');
				$candidate->reference_no = 'A'.date('ymdHis');
				$candidate->user_uuid = $this->getUuid();
				$candidate->created_at = date('Y-m-d H:i:s');
				$candidate->save();
				
        return json_encode([
            'success' => true,
            'type' => 'register',
            'user' => $user,
            //'token' => $token,
            'redirect' =>  'candidate'
        ]);


    }
		
		/**
     * Set uuid 
     */
    public function setUuid()
    {
      $this->uuid = (string) Str::uuid();
		}
		
		/**
     * Get uuid 
     */
    public function getUuid()
    {
      return $this->uuid;
    }
}
