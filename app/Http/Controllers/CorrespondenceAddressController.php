<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CorrespondenceAddress;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CorrespondenceAddressController extends Controller
{

  /**
	* Index/List page
	*
	* @return View
	*/
	public function list()
	{
		$addresses = CorrespondenceAddress::where('company_id',Auth::user()->company_id)->get();

		return view('admin.pages.correspondence.address.list', compact(
			'addresses'
		));
	}

	/**
	* Create page
	*
	* @return View
	*/
	public function create()
	{
		return view('admin.pages.correspondence.address.create');
	}

	/**
	* Update page
	*
	* @return View
	*/
	public function update($id)
	{
		$address = CorrespondenceAddress::findOrFail($id);

		return view('admin.pages.correspondence.address.update', compact(
			'address'
		));
	}

	/**
	* Detail page
	*
	* @return View
	*/
	public function detail($id)
	{
		$address = CorrespondenceAddress::findOrFail($id);

		return view('admin.pages.correspondence.address.detail', compact(
			'address'
		));
	}

	/**
	 * Delete address.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
			$address = CorrespondenceAddress::find($id);
			$type = $request->input('type');
			$view = $request->input('view');

			if ($address) {
					$success = false;
					$msg = 'An error occured.';
					$address->deleted_at = date('Y-m-d H:i:s');

					if ($address->save()) {
							$success = true;
							$msg = 'Address deleted.';
					}

					return response()->json([
							'success' => $success,
							'address_id' => $address->id,
							'msg' => $msg,
							'type' => $type,
							'view' => $view,
							'return_url' => url('admin/correspondence/address')
					]);
			}
	}

    public function save_address(Request $request)
    {
        $user_id = Auth::user()->id;
				$company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
        $listing_id = 0;
        $message = '';
        $success = false;

        try {

            $validator = Validator::make($request->all(), [
                'first_name'					=> 'required',
                'company'	=> 'required',
                'email'	=> 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'=>$validator->getMessageBag()->toArray()
                ]);
            }

            if($request->input('is_update')){
                $cAddress = CorrespondenceAddress::find($request->input('listing_id'));
            }else{
                $cAddress = new CorrespondenceAddress();
            }


            /*save file*/
            $company_logo = '';
            if ($request->hasFile('company_logo')) {
                $files = Arr::wrap($request->file('company_logo'));
                $filesPath = [];
                $path = generatePath('lettercontacts');

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
                $company_logo = json_encode($filesPath);
            }

            $contact_person_avatar = '';
            if ($request->hasFile('contact_person_avatar')) {
                $files = Arr::wrap($request->file('contact_person_avatar'));
                $filesPath = [];
                $path = generatePath('lettercontacts');

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
                $contact_person_avatar = json_encode($filesPath);
            }

            $cAddress->first_name = $request->input('first_name');
            $cAddress->middle_name = $request->input('middle_name');
            $cAddress->last_name = $request->input('last_name');
            $cAddress->company = $request->input('company');
            $cAddress->position = $request->input('position');
            $cAddress->email = $request->input('email');
            $cAddress->website = $request->input('website');
            $cAddress->country = $request->input('country');
            $cAddress->city = $request->input('city');
            $cAddress->address = $request->input('address');
						$cAddress->company_id = $company_id;
            $cAddress->created_by = $user_id;
            $cAddress->u_id = rand(00000,99999);
            $cAddress->contact_person_avatar = $contact_person_avatar;
            $cAddress->company_logo = $company_logo;

            if ($cAddress->save()) {
                $listing_id = $cAddress->id;
                $success = true;
                $message = 'Address ' . ($request->input('is_update') ? 'updated' : 'submitted') . '.';
            }


        }catch (\Exception $e) {
            $message =  $e->getMessage();
        }

        return response()->json([
						'success' => $success,
						'contact' => $cAddress,
            'listing_id' => $listing_id,
						'message' => $message,
						'modal' => $request->input('modal')
        ]);
    }

}
