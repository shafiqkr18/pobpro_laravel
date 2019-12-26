<?php


namespace App\Http\Controllers;


use App\Company;
use App\ContractManagement;
use App\OrganizationManagement;
use App\PositionManagement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
	/**
	 * Index/List page
	 *
	 * @return View
	 */
	public function index()
	{
        $company_id = Auth::user()->company_id;
        if (!Auth::user()->hasRole('itfpobadmin'))
        {
            $all_users = User::where('is_active',1)->where('company_id',$company_id)->get();
        }else{
            $all_users = User::where('is_active',1)->get();
        }

		$user_id = Auth::user()->id;
		$data = array(
			'all_users' => $all_users,
			'user_id' =>$user_id,


		);
		return view('admin.pages.users.list')->with('data', $data);
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$all_users = User::all();
		$user_id = Auth::user()->id;
		$user = User::findOrFail($id);
		$organizations = OrganizationManagement::all();
		$roles = \App\Role::all();

		$data = array(
			'all_users' => $all_users,
			'user_id' =>$user_id,


		);

		return view('admin.pages.users.detail', compact(
			'user',
			'all_users',
			'user_id',
			'organizations',
			'roles'
		));
	}


    /**
     * Create page
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_users = User::all();
        $user_id = Auth::user()->id;
        $company_id =  Auth::user()->company_id;
        $organizations = OrganizationManagement::where('company_id',$company_id)->get();
        $roles = \App\Role::where('company_id',$company_id)->get();
        $all_companies = Company::where('deleted_at', null)->get();
        $positions = PositionManagement::whereNull('deleted_at')->where('company_id',$company_id)->get();
        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'roles'=>$roles,
            'organizations'=>$organizations,
            'all_companies'=>$all_companies,
            'positions' =>$positions

        );
        return view('admin.pages.users.create')->with('data', $data);
		}

	/**
	 * Update page
	 *
	 * @return View
	 */
	public function update($id)
	{
		$all_users = User::all();
		$user_id = Auth::user()->id;
		$user = User::findOrFail($id);
        $company_id =  Auth::user()->company_id;
        $organizations = OrganizationManagement::where('company_id',$company_id)->get();
		$roles = \App\Role::where('company_id',$company_id)->get();
		$user_roles = $user->roles->pluck('name','name')->all();
        $positions = PositionManagement::whereNull('deleted_at')->where('company_id',$company_id)->get();
		$data = array(
			'all_users' => $all_users,
			'user_id' =>$user_id,


		);

		return view('admin.pages.users.update', compact(
			'user',
			'all_users',
			'user_id',
			'organizations',
			'roles',
			'user_roles','positions'
		));
	}

    public function save_new_user(Request $request)
    {

        try {

						$validator = $request->input('is_update')
							? Validator::make($request->all(), [
									'name' => ['required', 'string', 'max:255'],
									'email' => ['required', 'string', 'email', 'max:255', function ($attribute, $value, $fail) use($request) {
										$_user = User::find($request->input('user_id'));

										if ($_user) {
											$findEmail = User::where('email', $value)->where('id', '!=', $_user->id)->get();
											if (count($findEmail) > 0) {
												$fail('Email already exists.');
											}
										}
									}],
									'password' => ['nullable', 'string', 'min:8', 'confirmed'],
									'org_id'=>'required',
									'div_id'=>'required',
									'dept_id'=>'required',
									'roles'=>'required',
                                    'position_id'=>'required',
								])
							: Validator::make($request->all(), [
									'name' => ['required', 'string', 'max:255'],
									'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
									'password' => ['required', 'string', 'min:8', 'confirmed'],
									'org_id'=>'required',
									'div_id'=>'required',
									'dept_id'=>'required',
									'roles'=>'required',
                 'position_id'=>'required',
								]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }
            $user_id = 0;
            if($request->input('is_update')){
                $user = User::find($request->input('user_id'));
                DB::table('model_has_roles')->where('model_id',$request->input('user_id'))->delete();
            }else{
                $user = new User();
                $user->user_uuid = (string) Str::uuid();
            }
            /*save file*/
            $my_files = '';
            if ($request->hasFile('file')) {
                $files = Arr::wrap($request->file('file'));
                $filesPath = [];
                $path = generatePath('users');

                foreach ($files as $file) {
                    $filename = generateFileName($file, $path);
                    $file->storeAs(
                        $path,
                        $filename.'.'.$file->getClientOriginalExtension(),
                        config('app.storage.disk', 'public')

                    );

                    array_push($filesPath, [
                        'download_link' => $path.$filename.'.'.$file->getClientOriginalExtension(),
                        'original_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                    ]);
                }
                $my_files = json_encode($filesPath);
            }

						$user->name = $request->input('name');
						$user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
						if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
						}
            $user->mobile_number =$request->input('mobile_number');
            $user->notes = $request->input('notes');
						$user->is_active = $request->input('is_active');
						$user->user_type = $request->input('user_type');
            $user->org_id = $request->input('org_id');
            $user->div_id = $request->input('div_id');
            $user->dept_id = $request->input('dept_id');
            $user->sec_id = $request->input('sec_id');
            $user->position_id = $request->input('position_id');
			$user->company_id = $request->input('company_id') ? $request->input('company_id') : Auth::user()->company_id;

						if ($my_files != '') {
							$user->avatar = $my_files;
						}

            if(!$request->input('is_update')){
                $user->created_at = date('Y-m-d H:i:s');
						}

            $user->updated_at = date('Y-m-d H:i:s');

            if($user->save())
            {
                $user->assignRole($request->input('roles'));
                $user_id = $user->id;
                //save user in candidate table as well
                $message = "Saved Successfully! ";
                return response()->json([
                    'success' => true,
                    'user_id' => $user_id,
										'message' =>$message,
										'is_update' => $request->input('is_update')
                ]);
            }else{
                $message = "Error Occured!";
                return response()->json([
                    'success' => true,
                    'user_id' => $user_id,
                    'message' =>$message
                ]);
            }

        } catch (\Exception $e) {

            $message =  $e->getMessage();
            return response()->json([
                'success' => false,
                'contract_id' => $user_id,
								'message' =>$message
            ]);
        }



		}

}