<?php


namespace App\Http\Controllers;


use App\Company;
use App\OrganizationManagement;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use App\Permission;
use DB;



class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
//        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
//        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        if(Auth::user()->hasRole('itfpobadmin'))
        {
        $all_users = User::all();
            $roles = \App\Role::all();
        }else{
            $all_users = User::where('company_id',Auth::user()->company_id)->get();
            $roles = \App\Role::where('company_id',Auth::user()->company_id)->get();

        }

        $user_id = Auth::user()->id;
        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'roles'=>$roles,


        );
        return view('admin.pages.roles.list')->with('data', $data);
    }

    /**
     * Create page
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('itfpobadmin'))
        {
        $all_users = User::all();

        }else{
            $all_users = User::where('company_id',Auth::user()->company_id)->get();

        }
        $user_id = Auth::user()->id;
				$_permissions = Permission::all();
				$permissions = $_permissions->where('parent_id', 0)->all();
        $companies = Auth::user()->hasRole('itfpobadmin')
            ? Company::where('deleted_at', null)->get()
            : Company::where('id', Auth::user()->company_id)->where('deleted_at', null)->get();

        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
						'permissions'=>$permissions,
			'role_permissions' => null,
            'companies' =>$companies

        );
        return view('admin.pages.roles.create')->with('data', $data);
		}

	/**
	 * Update page
	 *
	 * @return View
	 */
	public function update($id)
	{
		$user_id = Auth::user()->id;
		$role = Role::findOrFail($id);
		$_permissions = Permission::all();
		$role_permissions = DB::table('role_has_permissions')
						->where('role_id', $id)
            ->pluck('permission_id')
						->all();

		$permissions = $_permissions->where('parent_id', 0)->all();

        $companies = Auth::user()->hasRole('itfpobadmin')
            ? Company::where('deleted_at', null)->get()
            : Company::where('id', Auth::user()->company_id)->where('deleted_at', null)->get();

		return view('admin.pages.roles.update', compact(
			'role',
			'user_id',
			'permissions',
			'role_permissions',
            'companies'
		));
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$user_id = Auth::user()->id;
		$role = Role::findOrFail($id);
		$_permissions = Permission::all();
		$role_permissions = DB::table('role_has_permissions')
						->where('role_id', $id)
            ->pluck('permission_id')
            ->all();
        if(empty($role_permissions))
        {
            $role_permissions = [];
        }

		$permissions = $_permissions->where('parent_id', 0)->all();

		return view('admin.pages.roles.detail', compact(
			'role',
			'user_id',
			'permissions',
			'role_permissions'
		));
	}

    /*
     * just for reference
     * how to edit role
     * */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    public function save_new_role(Request $request)
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $role_id = 0;
        try {
            $name = $request->input('name');

						$validator = $request->input('is_update')
							? Validator::make($request->all(), [
									'name' => ['required', function ($attribute, $value, $fail) use($request,$company_id) {
										$_role = Role::find($request->input('listing_id'));

										if ($_role) {
											$findRole = Role::where('name', $value)->where('company_id', '=', $company_id)->where('id', '!=', $_role->id)->get();
											if (count($findRole) > 0) {
												$fail('Role already exists.');
											}
										}
									}],
									'permission' => 'required',
                                'display_name' => 'required',
								])
							: Validator::make($request->all(), [
               // 'name' => 'required|unique:roles,name',
                                'name' => ['required', function ($attribute, $value, $fail) use($request,$company_id) {

                                        $findRole = Role::where('name', $value)->where('company_id', '=', $company_id)->get();
                                        if (count($findRole) > 0) {
                                            $fail('Role already exists.');
                                        }

                                }],
									'permission' => 'required',
                                'display_name' => 'required',
								]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }

            if($request->input('is_update')){
                $role = \App\Role::find($request->input('listing_id'));
            }else{
                $role = new \App\Role();
            }


            $role->name = $request->input('name');
            $role->created_by = $user_id;
            $role->display_name = $request->input('display_name');
            $role->company_id = $request->input('company_id') ? $request->input('company_id') : Auth::user()->company_id;
           // $role->notes = $request->input('notes');

            if(!$request->input('is_update')){
                $role->created_at = date('Y-m-d H:i:s');

            }
            $role->updated_at = date('Y-m-d H:i:s');

            if($role->save())
            {
                $role_id = $role->id;
                $role->syncPermissions($request->input('permission'));
                $message = "Saved Successfully! ";
                return response()->json([
                    'success' => true,
                    'role_id' => $role_id,
										'message' =>$message,
										'is_update' => $request->input('is_update')
                ]);
            }else{
                $message = "Error Occured!";
                return response()->json([
                    'success' => false,
                    'role_id' => $role_id,
                    'message' =>$message
                ]);
            }

        } catch (\Exception $e) {

            $message =  $e->getMessage();
            return response()->json([
                'success' => false,
                'role_id' => $role_id,
                'message' =>$message
            ]);
        }
    }
}