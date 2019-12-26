<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Generate modal.
     *
     * @return modal
     */
    public function modal($modal_type, Request $request)
    {
				$url = $request->input('url');
				$type = $request->input('type');
				$view = $request->input('view');

        return view('admin.modals.' . $modal_type, compact(
					'url',
					'type',
					'view'
        ));
    }
}
