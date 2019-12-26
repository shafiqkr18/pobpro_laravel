<?php

namespace App\Http\Controllers;

use App\DepartmentManagement;
use App\Division;
use App\OrganizationManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\User;
use App\Company;
use App\CompanyModule;
use App\ProductModule;

class CompanyController extends Controller
{
	/**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
		return view('admin.pages.company.list');
	}

	/**
	 * Create page
	 *
	 * @return View
	 */
	public function create()
	{
		$product_modules = ProductModule::all();

		return view('admin.pages.company.create', compact(
			'product_modules'
		));
	}

	/**
	 * Update page
	 *
	 * @return View
	 */
	public function update($id)
	{
		$product_modules = ProductModule::all();
		$company = Company::findOrFail($id);
		$company_modules = [];
		$_company_modules = $company->modules ? $company->modules : null;

		if ($_company_modules) {
			foreach ($_company_modules as $cm) {
				array_push($company_modules, $cm->module->module_name);
			}
		}

		return view('admin.pages.company.update', compact(
			'product_modules',
			'company',
			'company_modules'
		));
	}

  /**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$product_modules = ProductModule::all();
		$company = Company::findOrFail($id);
		$company_modules = [];
		$_company_modules = $company->modules ? $company->modules : null;

		if ($_company_modules) {
			foreach ($_company_modules as $cm) {
				array_push($company_modules, $cm->module->module_name);
			}
		}

		return view('admin.pages.company.detail', compact(
			'product_modules',
			'company',
			'company_modules'
		));
	}

  /**
	 * Delete company.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
		if($id) {
			$type = $request->input('type');
			$view = $request->input('view');

			$company = Company::find($id);
			$company->deleted_at = date('Y-m-d H:i:s');
			if ($company->save()) {
				$success = true;
				$msg = 'Company deleted.';
			}

			return response()->json([
				'success' => $success,
				'company_id' => $company->id,
				'msg' => $msg,
				'type' => $type,
				'view' => $view,
				'return_url' => url('admin/enterprises')
			]);
		}

	}

  /**
	 * SaaS registration page
	 *
	 * @return View
	 */
	public function register(Request $request)
	{
		if ($request->ajax()) {
			$success = false;
			$message = '';
			$company_id = 0;

			try {
				$validator = $request->input('is_update')
					? Validator::make($request->all(), [
							'company_name' => ['required', function ($attribute, $value, $fail) use($request) {
								$_company = Company::find($request->input('listing_id'));

								if ($_company) {
									$find_company = Company::where('company_name', $value)->where('id', '!=', $_company->id)->get();
									if (count($find_company) > 0) {
										$fail('Company name already exists.');
									}
								}
							}],
							'company_email' => ['required', 'email', function ($attribute, $value, $fail) use($request) {
								$_company = Company::find($request->input('listing_id'));

								if ($_company) {
									$find_company = Company::where('email', $value)->where('id', '!=', $_company->id)->get();
									if (count($find_company) > 0) {
										$fail('This email is associated with another company.');
									}
								}
							}],
							'phone_no' => 'required',
						])
					: Validator::make($request->all(), [
							'company_name' => 'required|unique:companies',
							'email' => 'required|unique:users|email',
							'password' => ['required', 'string', 'min:8', 'confirmed'],
							'company_email' => 'required|unique:companies,email|email',
							'phone_no' => 'required',
						]);

				if ($validator->fails()) {
					return response()->json([
						'success' => false,
						'errors' => $validator->getMessageBag()->toArray()
					]);
				}

				if ($request->input('is_update')) {
					$company = Company::findOrFail($request->input('listing_id'));
				}
				else {
					$company = new Company();
				}

                /*save file*/
                $my_files = '';
                if ($request->hasFile('file')) {
                    $files = Arr::wrap($request->file('file'));
                    $filesPath = [];
                    $path = generatePath('companies');

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

				$company->company_name = $request->input('company_name');
				$company->website = $request->input('website');
				$company->email = $request->input('company_email');
				$company->phone_no = $request->input('phone_no');
				$company->address = $request->input('address');
				$company->city = $request->input('city');
				$company->subscription_type = $request->input('subscription_type');
				$company->country = $request->input('country');
				$company->subscription_type = $request->input('subscription_type');
				$company->created_at = date('Y-m-d H:i:s');
				$company->expired_at = date('Y-m-d H:i:s', strtotime('+30 days'));

                $company->logo = $my_files;

				if ($request->input('is_update')) {
					$company->updated_at = date('Y-m-d H:i:s');
				}

				if ($company->save()) {
					$company_id = $company->id;



					if ($request->input('is_update')) {
						// get existing product modules
						$modules = $company->modules ? $company->modules->pluck('module_id')->all() : null;

						// get submitted product modules
						$products = [];
						$_products = $request->input('module_id');
						if ($_products) {
							foreach ($_products as $key => $value) {
								array_push($products, $value);

								// find module in company_modules
								$pm = CompanyModule::where('company_id', $company_id)
																		->where('module_id', $value)
																		->get();

								// create new relationship if not found
								if (count($pm) == 0) {
									$new_pm = new CompanyModule();
									$new_pm->company_id = $company_id;
									$new_pm->module_id = $value;
									$new_pm->save();
								}

							}
						}

						// cross check existing modules with submitted product modules
						if ($modules) {
							foreach ($modules as $module) {
								// if not found, delete
								if (!in_array($module, $products)) {
									$delete_module = CompanyModule::where('company_id', $company_id)
																								->where('module_id', $module)
																								->get();

									if (count($delete_module) > 0) {
										foreach ($delete_module as $dm) {
											$dm->delete();
										}
									}

								}
							}
						}


						$success = true;
						$message = 'Company updated.';
					}
					else {
						// save products
						$products = $request->input('module_id');
						if ($products) {
							foreach ($products as $key => $value) {
								$module = new CompanyModule();
								$module->company_id = $company->id;
								$module->module_id = $value;
								$module->save();
							}
						}

						// create user
						$user = new User();
						$user->email = $request->input('email');
						$user->name = $request->input('name');
						$user->last_name = $request->input('last_name');
						$user->password = Hash::make($request->input('password'));
						$user->user_type = 4;
						$user->company_id = $company->id;
						$user->created_at = date('Y-m-d H:i:s');
						$user->user_uuid = (string) Str::uuid();

						if ($user->save()) {
							// assign role to user
							$user->assignRole('EnterpriseAdmin');

                            $created_by = $request->input('user_id') ? $request->input('user_id') : $user->id;
							$company->ent_admin_id = $user->id;
							$company->user_uuid = $user->user_uuid;
							$company->created_by = $created_by;
							$company->save();

							$success = true;
							$message = $request->input('user_id') ? 'Company registered.' : 'Your company has been registered.';
							Auth::login($user);

                            //
                            /*default settings area for new company*/
                               // set default roles
                                $this->setDefaultRoles($created_by,$company->id);
                            /*end default settings area for company*/

						}
					}

				}

			} catch (\Exception $e) {
				$message =  $e->getMessage();
			}

			return response()->json([
				'success' => $success,
				'message' => $message,
				'company_id' => $company_id
			]);

		}

		$product_modules = ProductModule::all();
		$subscription_type = $request->input('subscription_type') ? $request->input('subscription_type') : 0;

		return view('admin.pages.company.register', compact(
			'product_modules',
			'subscription_type'
		));
	}

	/**
	 * Get companies.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function companies_filter(Request $request)
	{
		$companies_data = array();
		$companies = Company::select("*");
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		//only see his company
        $company_id =  Auth::user()->company_id;
        if (!Auth::user()->hasRole('itfpobadmin'))
        {
            $companies->where('id',$company_id);
            $is_filter = true;
        }

		if($search) {
			$is_filter = true;
			$companies->where('subject','like', '%'.$request->get('search')['value'].'%');
		}

		if($is_filter) {
			$total_companies = count($companies->get());
			$companies = $companies->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
			$companies = Company::all();
			$total_companies = count($companies);
			$companies = Company::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($companies as $company) {
			$companies_data[$count][] = $company->id;
			$companies_data[$count][] = $company->company_name;
			$companies_data[$count][] = $company->email;
			 $companies_data[$count][] = $company->user->name;
			$companies_data[$count][] = count($company->company_users);
            $companies_data[$count][] = $company->expired_at;
            $companies_data[$count][] = find_time_difference(date('Y-m-d H:i:s'),$company->expired_at);
			$companies_data[$count][] = '';
			$companies_data[$count][] = $company->website;
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_companies,
			'recordsFiltered' => $total_companies,
			'data' 						=> $companies_data
		);
		return json_encode($data);
	}

	public function setDefaultRoles($user_id = 0,$company_id = 0)
    {

        $data = array(
            array(
                'name'=>'DM',
                'display_name'=>'Department Manager',
                'created_by'=>$user_id,
                'company_id'=>$company_id,
                'created_at'=>date('Y-m-d H:i:s'),
            ),
            array(
                'name'=>'HRM',
                'display_name'=>'HR Manager',
                'created_by'=>$user_id,
                'company_id'=>$company_id,
                'created_at'=>date('Y-m-d H:i:s'),
            ),
            array(
                'name'=>'HR',
                'display_name'=>'HR',
                'created_by'=>$user_id,
                'company_id'=>$company_id,
                'created_at'=>date('Y-m-d H:i:s'),
            ),
            array(
                'name'=>'GM',
                'display_name'=>'General Manager',
                'created_by'=>$user_id,
                'company_id'=>$company_id,
                'created_at'=>date('Y-m-d H:i:s'),
            ),
            array(
                'name'=>'EnterpriseAdmin',
                'display_name'=>'Enterprise Admin',
                'created_by'=>$user_id,
                'company_id'=>$company_id,
                'created_at'=>date('Y-m-d H:i:s'),
            ),
            array(
                'name'=>'Wechat',
                'display_name'=>'Wechat Work',
                'created_by'=>$user_id,
                'company_id'=>$company_id,
                'created_at'=>date('Y-m-d H:i:s'),
            ),
            array(
                'name'=>'User',
                'display_name'=>'User',
                'created_by'=>$user_id,
                'company_id'=>$company_id,
                'created_at'=>date('Y-m-d H:i:s'),
            ),
            array(
                'name'=>'Employee',
                'display_name'=>'Employee',
                'created_by'=>$user_id,
                'company_id'=>$company_id,
                'created_at'=>date('Y-m-d H:i:s'),
            ),
            array(
                'name'=>'Candidate',
                'display_name'=>'Candidate',
                'created_by'=>$user_id,
                'company_id'=>$company_id,
                'created_at'=>date('Y-m-d H:i:s'),
            )

        );


        \App\Role::insert($data);

        //assign some default permissions as well to the role
        $this->assign_permission_to_roles('dashboard','HR',$user_id,$company_id);
        $this->assign_permission_to_roles('management','HR',$user_id,$company_id);
        $this->assign_permission_to_roles('HR','HR',$user_id,$company_id);
        $this->assign_permission_to_roles('administration','HR',$user_id,$company_id);
        $this->assign_permission_to_roles('user-admin','HR',$user_id,$company_id);

        $this->assign_permission_to_roles('dashboard','HRM',$user_id,$company_id);
        $this->assign_permission_to_roles('management','HRM',$user_id,$company_id);
        $this->assign_permission_to_roles('HR','HRM',$user_id,$company_id);
        $this->assign_permission_to_roles('administration','HRM',$user_id,$company_id);
        $this->assign_permission_to_roles('user-admin','HRM',$user_id,$company_id);

        $this->assign_permission_to_roles('dashboard','GM',$user_id,$company_id);
        $this->assign_permission_to_roles('management','GM',$user_id,$company_id);
        $this->assign_permission_to_roles('HR','GM',$user_id,$company_id);
        $this->assign_permission_to_roles('administration','GM',$user_id,$company_id);
        $this->assign_permission_to_roles('user-admin','GM',$user_id,$company_id);

        $this->assign_permission_to_roles('dashboard','DM',$user_id,$company_id);
        $this->assign_permission_to_roles('management','DM',$user_id,$company_id);
        $this->assign_permission_to_roles('HR','DM',$user_id,$company_id);
        $this->assign_permission_to_roles('administration','DM',$user_id,$company_id);
        $this->assign_permission_to_roles('user-admin','DM',$user_id,$company_id);


        return true;
    }

    public function assign_permission_to_roles($menu,$role,$user_id,$company_id)
    {
        $permission = \App\Permission::where('name',$menu)->first();
        $permissions = $permission->children;
        $p_ids = array();
        array_push($p_ids,$permission->id);
        foreach ($permissions as $p)
        {
            array_push($p_ids,$p->id);
            if(count($p->children))
            {
                foreach ($p->children as $pc)
                {
                    array_push($p_ids,$pc->id);
                }
            }
        }

        //some role do not need some permissions
        if($role == 'DM')
        {
            $dm_not_array = array(56,59,61,62,63,68,69);
            $final_array = array_diff($p_ids,$dm_not_array);
        }elseif($role == 'GM')
        {
            $gm_not_array = array(56,59,61,62,63,64,68,69);
            $final_array = array_diff($p_ids,$gm_not_array);
        }else{
            $final_array = $p_ids;
        }

        $role = \App\Role::where('name',$role)->where('created_by',$user_id)->where('company_id',$company_id)->first();
        //$role->syncPermissions($final_array);
        $role->givePermissionTo($final_array);
        return true;

		}
		
	/**
	 * Company profile page
	 *
	 * @return View
	 */
	public function profile()
	{	
		$company = Auth::user()->company;

		return view('admin.pages.company.profile', compact(
			'company'
		));
	}

	/**
	 * Save company
	 *
	 * @return View
	 */
	public function save(Request $request)
	{
		$success = false;
		$message = '';
		$company_id = 0;

		try {
			$validator = $request->input('is_update')
				? Validator::make($request->all(), [
						'company_name' => ['required', function ($attribute, $value, $fail) use($request) {
							$_company = Company::find($request->input('listing_id'));

							if ($_company) {
								$find_company = Company::where('company_name', $value)->where('id', '!=', $_company->id)->get();
								if (count($find_company) > 0) {
									$fail('Company name already exists.');
								}
							}
						}],
						'email' => ['required', 'email', function ($attribute, $value, $fail) use($request) {
							$_company = Company::find($request->input('listing_id'));

							if ($_company) {
								$find_company = Company::where('email', $value)->where('id', '!=', $_company->id)->get();
								if (count($find_company) > 0) {
									$fail('This email is associated with another company.');
								}
							}
						}],
						'phone_no' => 'required',
					])
				: Validator::make($request->all(), [
						'company_name' => 'required|unique:companies',
						'email' => 'required|unique:users|email',
						'password' => ['required', 'string', 'min:8', 'confirmed'],
						'email' => 'required|unique:companies,email|email',
						'phone_no' => 'required',
					]);

			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'errors' => $validator->getMessageBag()->toArray()
				]);
			}

			$company = Auth::user()->company;

			/*save file*/
			$my_files = '';
			if ($request->hasFile('file')) {
				$files = Arr::wrap($request->file('file'));
				$filesPath = [];
				$path = generatePath('companies');

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

			$company->company_name = $request->input('company_name');
			$company->website = $request->input('website');
			$company->email = $request->input('email');
			$company->phone_no = $request->input('phone_no');
			$company->address = $request->input('address');
			$company->city = $request->input('city');
			$company->country = $request->input('country');

			if ($my_files != '') {
				$company->logo = $my_files;
			}

			if ($request->input('is_update')) {
				$company->updated_at = date('Y-m-d H:i:s');
			}
			else {
				$company->created_at = date('Y-m-d H:i:s');
			}

			if ($company->save()) {
				$company_id = $company->id;
				$success = true;
				$message = 'Company ' . ($request->input('is_update') ? 'updated.' : 'saved.');
			}

		} catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'company_id' => $company_id,
			'redirect' => $request->input('is_update') ? url('admin/company-profile') : ''
		]);
	}

}
