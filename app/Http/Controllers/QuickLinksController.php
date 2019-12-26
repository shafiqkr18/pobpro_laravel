<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

use App\Permission;
use App\QuickLinks;

class QuickLinksController extends Controller
{
  /**
	 * Add quick links page
	 *
	 * @return View
	 */
	public function create()
	{
		$role_ids = [];
		$user_roles = Auth::user()->roles;
		if ($user_roles) {
			foreach ($user_roles as $_user_role) {
				array_push($role_ids, $_user_role->id);
			}
		}	

		$_permission_ids = [];
		$role_permissions = DB::table('role_has_permissions')
												->whereIn('role_id', $role_ids)
												->pluck('permission_id')
												->all();

		$user_links = Auth::user()->quickLinks;
		$user_links_ids = Auth::user()->quickLinks->pluck('link_id')->toArray();

		$tree = [];

		if ($role_permissions) {
			foreach ($role_permissions as $rp) {
				array_push($_permission_ids, $rp);
			}

			$permissions = Permission::whereIn('id', $_permission_ids)->where('parent_id', 0)->get();

			if ($permissions) {
				foreach ($permissions as $permission) {
					if (in_array($permission->id, $_permission_ids)) {
						$root = [
							'text' => '<span>' . $permission->display_name . '</span> ' . (count($permission->children) == 0 ? '<i class="fa fa-minus-circle text-danger remove-link ml-3"></i>' : ''),
							'id' => $permission->id,
							'children' => $this->getChildPermissions($permission),
							'state' => [
								'opened' => true
							],
							'a_attr' => [
								'data-route' => $permission->route_name,
								'class' => (count($permission->children) == 0 ? 'sortable' : '') . (in_array($permission->id, $user_links_ids) ? ' link-added' : '')
							]
						];

						array_push($tree, $root);
					}
				}
			}
		}

		return view('admin.pages.quick_links.create', compact(
			'role_permissions',
			'user_roles',
			'role_ids',
			'permissions',
			'tree',
			'user_links'
		));
	}

	/**
	 * Get child permissions
	 *
	 * @return Permission
	 */
	private function getChildPermissions($permission) 
	{
		$children = [];

		$role_ids = [];
		$user_roles = Auth::user()->roles;
		if ($user_roles) {
			foreach ($user_roles as $_user_role) {
				array_push($role_ids, $_user_role->id);
			}
		}	
		
		$role_permissions = DB::table('role_has_permissions')
												->whereIn('role_id', $role_ids)
												->pluck('permission_id')
												->all();

		$user_links_ids = Auth::user()->quickLinks->pluck('link_id')->toArray();

		if ($permission->children) {
			foreach ($permission->children as $child_permission) {
				if (in_array($child_permission->id, $role_permissions)) {
					$_child = [
						'text' => '<span>' . $child_permission->display_name . '</span> ' . (count($child_permission->children) == 0 ? '<i class="fa fa-minus-circle text-danger remove-link ml-3"></i>' : ''),
						'id' => $child_permission->id,
						'children' => $this->getChildPermissions($child_permission),
						'state' => [
							'opened' => true
						],
						'a_attr' => [
							'data-route' => $child_permission->route_name,
							'class' => (count($child_permission->children) == 0 ? 'sortable' : '') . (in_array($child_permission->id, $user_links_ids) ? ' link-added' : '')
						]
					];

					array_push($children, $_child);
				}
			}
		}

		return $children;
	}
	
	/**
	 * Save quick links.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function save(Request $request)
	{
		$success = false;
		$message = '';

		try {
			$validator = Validator::make($request->all(), [
				'link_id' => 'required',
			]);
			if ($validator->fails()) {
				return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
			}

			$permission_ids = $request->input('link_id');

			$user_links = Auth::user()->quickLinks;

			if ($user_links) {
				foreach ($user_links as $_link) {
					if (!in_array($_link->permission->id, $permission_ids)) {
						$_link->deleted_at = date('Y-m-d H:i:s');
						$_link->save();
					}
				}
			}

			if ($permission_ids) {
				$i = 0;
				foreach ($permission_ids as $permission_id) {
					$quick_link = QuickLinks::where('link_id', $permission_id)
																	->where('created_by', Auth::user()->id)
																	->where('deleted_at', null)
																	->first();

					if ($quick_link) {
						$quick_link->updated_at = date('Y-m-d H:i:s');
					}
					else {
						$quick_link = new QuickLinks();
					}

					$quick_link->link_id = $permission_id;
					$quick_link->link_position = $i;
					$quick_link->created_by = Auth::user()->id;
					$quick_link->company_id = Auth::user()->company ? Auth::user()->company->id : 0;
					$quick_link->created_at = date('Y-m-d H:i:s');

					if ($quick_link->save()) {
						$success = true;
						$message = 'Quick links saved.';
					}

					$i++;
				}
			}
		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'request' => $request->all()
		]);
	}

}
