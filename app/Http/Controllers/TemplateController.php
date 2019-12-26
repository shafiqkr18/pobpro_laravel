<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Template;
use App\User;

class TemplateController extends Controller
{
  /**
	 * Index/List page
	 *
	 * @return View
	 */
	public function index()
	{
		return view('admin.pages.hr.template.list');
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
		$ref_no = 'Temp-' . date('YmdHis');

		$data = array(
			'all_users' => $all_users,
			'user_id' 	=> $user_id,
			'ref_no'		=> $ref_no

		);

		return view('admin.pages.hr.template.create')->with('data', $data);
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$template = Template::findOrFail($id);

		return view('admin.pages.hr.template.detail', compact(
			'template'
		));
	}

	/**
	 * Update page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update($id)
	{
		$template = Template::findOrFail($id);

		return view('admin.pages.hr.template.update', compact(
			'template'
		));
	}

	/**
	 * Delete template.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
			$template = Template::find($id);
			$type = $request->input('type');
			$view = $request->input('view');

			if ($template) {
					$success = false;
					$msg = 'An error occured.';
					$template->deleted_at = date('Y-m-d H:i:s');

					if ($template->save()) {
							$success = true;
							$msg = 'Template deleted.';
					}

					return response()->json([
							'success' => $success,
							'template_id' => $template->id,
							'msg' => $msg,
							'type' => $type,
							'view' => $view,
							'return_url' => url('admin/templates')
					]);
			}
	}

	/**
	 * Save template
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function save_template(Request $request)
	{
			$user_id = Auth::user()->id;
			$listing_id = 0;
			try {

					$validator = Validator::make($request->all(), [
							'reference_no'		=> 'required',
							'subject' 				=> 'required',
							'template_name' 	=> 'required',
					]);
					if ($validator->fails()) {
							return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
					}

					if($request->input('is_update')){
							$template = Template::find($request->input('listing_id'));
					}else{
							$template = new Template();
					}

                    $template->company_id = Auth::user()->company_id;
					$template->reference_no = $request->input('reference_no');
					$template->type = $request->input('type');
					$template->template_name = $request->input('template_name');
					$template->subject = $request->input('subject');
					if($request->input('contents'))
                    {
                        $contents = str_replace("http://{view_link}", "{view_link}", $request->input('contents'));
                        $template->contents = $contents;
                    }

					$template->created_by = $user_id;

					if(!$request->input('is_update')){
							$template->created_at = date('Y-m-d H:i:s');

					}
					$template->updated_at = date('Y-m-d H:i:s');

					if($template->save())
					{
							$listing_id = $template->id;
							$message = "Saved Successfully! ";
							$status = true;

					}else{
							$message = "Error Occured!";
							$status = false;

					}

			} catch (\Exception $e) {
					$status = false;
					$message =  $e->getMessage();

			}

			return response()->json([
					'success' => $status,
					'contract_id' => $listing_id,
					'message' => $message,
					'is_update' => $request->input('is_update')
			]);
	}

	/**
	 * Get templates
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function template_filter(Request $request)
	{
			$template_data = array();
			$templates = Template::select("*");
			$draw = $request->get('draw');
			$start = $request->get('start');
			$length = $request->get('length');
			$is_filter = false;
			$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
			if($search)
			{
					$is_filter = true;
					$templates->where('reference_no','like', '%'.$request->get('search')['value'].'%');
			}
            if (!Auth::user()->hasRole('itfpobadmin')) {
                $templates->where('company_id', Auth::user()->company_id);
                $is_filter = true;
            }
			if($is_filter){
					$total_templates = count($templates->get());
					$templates = $templates->offset($start)->limit($length)->orderBy('id', 'desc')->get();

			}else{
					$templates = Template::all();
					$total_templates = count($templates);
					$templates = Template::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
			}

			$count = 0;
			foreach ($templates as $template) {
					$template_data[$count][] = $template->id;
					$template_data[$count][] = $template->reference_no;
					$template_data[$count][] = $template->type;
					$template_data[$count][] = $template->template_name;
					$template_data[$count][] = $template->subject;

					$template_data[$count][] = "";
					$count++;

			}

			$data = array(
					'draw'            => $draw,
					'recordsTotal'    => $total_templates,
					'recordsFiltered' => $total_templates,
					'data' => $template_data
			);
			return json_encode($data);
	}
}
