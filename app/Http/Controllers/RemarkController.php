<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Remark;

class RemarkController extends Controller
{
  /**
	* Save remark
	*
	* @return \Illuminate\Http\Response
	*/
	public function save(Request $request)
	{
		$user_id = Auth::user()->id;
		$company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
		$listing_id = 0;
		$message = '';
		$success = false;
		$view = null;

		try {
			if ($request->input('is_update')) {
				$remark = Remark::findOrFail($request->input('remark_id'));
				$remark->updated_at = date('Y-m-d H:i:s');
			}
			else {
				$remark = new Remark();
				$remark->created_by = $user_id;
				$remark->created_at = date('Y-m-d H:i:s');
			}

			$remark->title = $request->input('title');
			$remark->comments = $request->input('comments');
			$remark->type = $request->input('type');
			$remark->listing_id = $request->input('listing_id');
			$remark->company_id = $company_id;

			if ($remark->save()) {
				$success = true;
				$message = 'Remark ' . ($request->input('is_update') ? 'updated' : 'saved') . '.';

				if ($request->input('source') == 'report_detail') {
					$view = view('admin.pages.remark._remark', [
										'remark' => $remark
									])->render();
				}
			}

		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'listing_id' => $listing_id,
			'message' => $message,
			'view' => $view
		]);
	}

}
