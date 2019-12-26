<?php

namespace App\Http\Controllers\frontend;

use App\Plan;
use App\PlanPosition;
use App\PositionManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\User;
use App\Candidate;
use App\Interview;
use App\Offer;
use App\Vacancy;
use App\Question;
use App\QuestionCategory;
use DB;

class CandidateController extends Controller
{
	/**
	* Login candidate by uuid
	*
	* @return View
	*/
	public function loginByUuid($id, $redirect = null)
	{
		$user = User::where('user_uuid', $id)->first();

		if ($user) {
			Auth::login($user);

			if ($redirect == null)
			return redirect('candidate/interview');
			elseif ($redirect == 'contract')
				return redirect('candidate/contract/detail');
			else
				return redirect ('candidate/' . $redirect);
		}
		else {
			return redirect('admin/login');
		}
	}

	/**
	* Get candidate
	*
	* @return View
	*/
	public function getCandidate()
	{
		$user = Auth::user();

		if ($user) {
			return Candidate::where('user_uuid', $user->user_uuid)->first();
		}
		else {
			// TODO: return to login page
		}
	}

	/**
	* Profile page
	*
	* @return View
	*/
	public function profile()
	{
		$candidate = $this->getCandidate();

		if ($candidate) {
			return view('frontend.pages.candidate.profile', compact(
				'candidate'
			));
		}
	}

	/**
	* Interview page
	*
	* @return View
	*/
	public function interview()
	{
		$candidate = $this->getCandidate();

		if ($candidate) {
			return view('frontend.pages.candidate.interview', compact(
				'candidate'
			));
		}

	}

	/**
	* Interview detail page
	*
	* @return View
	*/
	public function interviewDetail($id)
	{
		$interview = Interview::findOrFail($id);

		return view('frontend.pages.candidate.interview-detail', compact(
			'interview'
		));
	}

	/**
	* Interview feedback page
	*
	* @return View
	*/
	public function interviewFeedback()
	{
		return view('frontend.pages.candidate.interview-feedback');
	}

	/**
	* Offers page
	*
	* @return View
	*/
	public function offers()
	{
		$candidate = $this->getCandidate();
		$offers = $candidate->sentOffers;

		return view('frontend.pages.candidate.offers', compact(
			'offers'
		));
	}

	/**
	* Offer detail page
	*
	* @return View
	*/
	public function offerDetail($id)
	{
		$offer = Offer::findOrFail($id);

		return view('frontend.pages.candidate.offer-detail', compact(
			'offer'
		));
	}

	/**
	* Accept offer page
	*
	* @return View
	*/
	public function offerAccept()
	{
		return view('frontend.pages.candidate.offer-accept');
	}

	/**
	* Decline offer page
	*
	* @return View
	*/
	public function offerDecline()
	{
		return view('frontend.pages.candidate.offer-decline');
	}

	/**
	* Contracts list page
	*
	* @return View
	*/
	public function contracts()
	{
		$candidate = $this->getCandidate();
		$contracts = $candidate->contracts ? $candidate->contracts : null;

		return view('frontend.pages.candidate.contracts', compact(
			'contracts'
		));

	}

	/**
	* Contract detail page
	*
	* @return View
	*/
	public function contractDetail($id)
	{
		$candidate = $this->getCandidate();
		$contract = Offer::find($id);

		return view('frontend.pages.candidate.contract-detail', compact(
			'contract'
		));

	}

	/**
	* Onboarding page
	*
	* @return View
	*/
	public function onboarding()
	{
		return view('frontend.pages.candidate.onboarding');
	}

	/**
	 * Save candidate
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function saveProfile(Request $request)
	{
		//he should be login while apply to job
		if (!Auth::user()) {
			return redirect('admin/login');
		}

		try {

			$validator = Validator::make($request->all(), [
				'name'     => 'required',
				//'user_id' => 'required',
				// 'email' => 'required|email',
				'phone' => 'required',
				'gender' => 'required',
				'location' => 'required',
				//'age' => 'required'
			]);

			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'errors' => $validator->getMessageBag()->toArray()
				]);
			}

//			if ($request->input('is_online')) {
//				$candidate = new Candidate();
//				$candidate->is_online = $request->input('is_online');
//				$candidate->user_uuid = (string) Str::uuid();
//			}
//			else {
//			$candidate = $this->getCandidate();
//			}

			$user = Auth::user();
			if($user) {
				$existing_candidate = Candidate::where('user_uuid', $user->user_uuid)->first();

				if($existing_candidate) {
						$candidate = $existing_candidate;
				}
				else {
					$candidate = new Candidate();
					$candidate->user_uuid = (string) Str::uuid();
				}
			}
			else {
				return redirect('admin/login');
			}

			$candidate->is_online = $request->input('is_online')?$request->input('is_online'): 0;

			$position_id = $request->input('position_id');
			if (empty($position_id)) {
				$position_id = 3;
			}
			//find company_id for this position $position_id
			$ps = PositionManagement::where('id', '=', $position_id)->first();
			if($ps) {
				$my_company_id = $ps->company_id;
			}
			else {
				$my_company_id = Auth::user()->company_id;
			}
			$candidate->company_id  = $my_company_id;
			$candidate->position_id= $position_id;
			$candidate->name = $request->input('name');
			$candidate->last_name = $request->input('last_name');
			// $candidate->email = $request->input('email');//can not change email, as it associated with a user
			$candidate->phone = $request->input('phone');
			$candidate->gender = $request->input('gender');
			$candidate->date_of_birth = date('Y-m-d H:i:s', strtotime($request->input('date_of_birth')));
			$candidate->education_level = $request->input('education_level');
			$candidate->major = $request->input('major');
			$candidate->location = $request->input('location');
			$candidate->introduction = $request->input('introduction');
			$candidate->work_experience = $request->input('work_experience');
			$candidate->certifications = $request->input('certifications');
			$candidate->updated_at = date('Y-m-d H:i:s');
			$candidate->reference_no = 'A'.date('ymdHis');

			// save files
			$my_files = '';
			if ($request->hasFile('file')) {
				$files = Arr::wrap($request->file('file'));
				$filesPath = [];
				$path = generatePath('candidates');

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

			if ($my_files != '') {
				$candidate->resume = $my_files;
			}

			// $user = User::where('user_uuid', $request->input('uuid'))->first();
			if (User::where('user_uuid', '=', $user->user_uuid)->exists()) {
				$user = User::where('user_uuid', $user->user_uuid)->first();
			}else{
				// $user = new User();
				return redirect('admin/login');
			}

			$user->name = $request->input('name');
			$user->company_id  = $my_company_id;
			$user->mobile_number = $request->input('phone');
			$user->phone_number = $request->input('telephone');
			$user->notes = $request->input('self_introduce');
			$user->updated_at = date('Y-m-d H:i:s');

			if ($candidate->save() && $user->save()) {
				$message = $request->input('is_online') ? 'Thank you for applying. Our HR team will process it and may contact you.' : 'Candidate profile saved.';
				$status = true;
			} else {
					$message = 'An error occured.';
					$status = false;
			}

		} catch (\Exception $e) {

			$message = $e->getMessage();
			$status = false;

		}

		return response()->json([
			'success' => $status,
			'message' => $message,
			'is_online' => $request->input('is_online')
		]);
	}

	/**
	 * Save interview response
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function saveInterviewResponse(Request $request)
	{
		try {
			$interview = Interview::findOrFail($request->input('id'));
			$interview->is_confirmed = $request->input('is_confirmed');
			$interview->updated_at = date('Y-m-d H:i:s');

			//send email
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'HR');
            })->get();
            // get the first one
            if($users->first())
            {
                $email = $users->first()->email;
                if(!empty($email))
                {
                    if($request->input('is_confirmed')==3)
                        $intv_status = "Reject";
                    elseif ($request->input('is_confirmed')==2)
                        $intv_status = "Reschedule";
                    else
                        $intv_status = "Confirm";

                        $template_data = '<p>Dear HR,</p><p>I want to '.$intv_status.' my interview</p>
                        <p>&nbsp;Thank You.</p><p><br></p><br>
						<p>Regards
						</p>';
                    Mail::send([], [],
                        function ($message) use ($email,$template_data) {
                            $message->to($email)
                                ->from('muhammad.shafiq@itforce-tech.com')
                                ->subject('Interview Response')
                                ->setBody($template_data, 'text/html');
                        });
                }
            }


			if($interview->save())
			{
				$message = 'Feedback sent.';
				$status = true;
			}else{
					$message = 'An error occured.';
					$status = false;
			}

		} catch (\Exception $e) {

			$message = $e->getMessage();
			$status = false;

		}

		return response()->json([
			'success' => $status,
			'message' => $message
		]);
	}

	/**
	 * Save offer feedback
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function saveOfferFeedback(Request $request)
	{
		try {
			$accepted = $request->input('accepted');

			if ($request->input('type') == 1) {
				$validator = Validator::make($request->all(), [
					'accepted'	=> 'required',
					'file' 			=> 'required'
				]);

				if ($validator->fails()) {
					return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
				}

				$accepted = $request->input('accepted') ? 1 : 0;
			}

			$offer = Offer::findOrFail($request->input('id'));
			$offer->accepted = $accepted;
			$offer->updated_at = date('Y-m-d H:i:s');

			if ($request->input('ignore') != 1) {
				$offer->notes = $request->input('notes');
			}

			// save files
			$my_files = '';
			if ($request->hasFile('file')) {
				$files = Arr::wrap($request->file('file'));
				$filesPath = [];
				$path = generatePath('candidates');

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
			$offer->attachments = $my_files;



			if($offer->save())
			{
			    // update positions and plan_positions
                $offer_id = $offer->id;
                $position_id = $offer->position_id;
                $plan_id = $offer->plan_id;
                if($position_id > 0)
                {
                    //check if total_positions & positions_filled are equal
                    $position = PositionManagement::where('id', $position_id)->first();
                    if($position)
                    {
                        $total_positions = $position->total_positions ? $position->total_positions : 0;
                        $positions_filled = $position->positions_filled ? $position->positions_filled : 0;

                        if($positions_filled < $total_positions)
                        {
                    PositionManagement::where('id', $position_id)
                        ->update([
                                    'positions_filled'=> \DB::raw('IFNULL(positions_filled,0)+1'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                            $positions_filled_update = $positions_filled + 1; //as updated above
                        }else{
                            $positions_filled_update = $positions_filled;
                        }

                        //update back if equal
                        if($positions_filled_update >= $total_positions)
                        {
                            PositionManagement::where('id', $position_id)
                                ->update([
                                    'status'=> 'close',
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            //close job also
                            Vacancy::where('position_id', $position_id)
                                ->update([
                                    'status'=> 'close',
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                        }

                    }


                    if($plan_id > 0)
                    {
                        //first update plan_positions table
                        $plan_position = PlanPosition::where('position_id', $position_id)->where('plan_id', $plan_id)->first();
                        if($plan_position)
                        {
                            $total_positions = $plan_position->head_count ? $plan_position->head_count : 0;
                            $positions_filled = $plan_position->positions_filled ? $plan_position->positions_filled : 0;
                            if($positions_filled < $total_positions)
                            {
                        PlanPosition::where('position_id', $position_id)->where('plan_id', $plan_id)
                            ->update([
                                        'positions_filled'=> \DB::raw('IFNULL(positions_filled,0)+1'),
                            ]);
                                $positions_filled_update = $positions_filled + 1; //as updated above
                            }else{
                                $positions_filled_update = $positions_filled;
                            }

                            //update back if equal
                            if($positions_filled_update >= $total_positions)
                            {
                                PlanPosition::where('position_id', $position_id)->where('plan_id', $plan_id)
                                    ->update([
                                        'is_open'=> 0
                                    ]);

                                //close job also
                                Vacancy::where('position_id', $position_id)
                                    ->update([
                                        'status'=> 'close',
                                        'updated_at' => date('Y-m-d H:i:s')
                                    ]);
                            }

                        }

                        //check if total plan is closed or no
                        if(!PlanPosition::where('is_open', 1)->where('plan_id', $plan_id)->exists())
                        {
                            //all is closed
                            Plan::where('id', $plan_id)->update([
                                'is_open'=> 0
                            ]);
                        }


                    }
                }

                //update candidate back
                $candidate_id = $offer->candidate_id;
                if($candidate_id > 0)
                {
                    Candidate::where('id',$candidate_id)->update(['offer_accepted'=>1]);
                }

				$message = 'Feedback sent.';
				$status = true;
			}else{
					$message = 'An error occured.';
					$status = false;
			}

		} catch (\Exception $e) {

			$message = $e->getMessage();
			$status = false;

		}

		return response()->json([
			'success' => $status,
			'message' => $message
		]);
	}

	/**
	* Vacancies page
	*
	* @return View
	*/
	public function vacancies()
	{
	    //he should be login while apply to job
        if (!Auth::user()){
            return redirect('admin/login');
        }
		$vacancies = Vacancy::where('status', 'open')->where('is_approved', 1)->where('company_id',Auth::user()->company_id)->get();

		return view('frontend.pages.candidate.vacancies', compact(
			'vacancies'
		));
	}

	/**
	* Vacancy detail page
	*
	* @return View
	*/
	public function vacancyDetail(Request $request, $id)
	{
        //he should be login while apply to job
        if (!Auth::user()){
            return redirect('admin/login');
        }
		$vacancy = Vacancy::findOrFail($id);


		return view('frontend.pages.candidate.vacancy-detail', compact(
			'vacancy'
		));
	}

	/**
	* Q & A page
	*
	* @return View
	*/
	public function questions()
	{
		$user = Auth::user();
		$candidate = $this->getCandidate();
		$company_id = $candidate->company_id ? $candidate->company_id : $user->company_id;
		$questions = Question::where('company_id', $company_id)
												->where('created_by', $user->id)
												// ->orWhere(function ($query) use ($company_id) {
												// 	$query->where('question_type', 'public')
												// 				->where('company_id', $company_id);
												// })
												->orderBy('created_at', 'DESC')
												->get();
		$categories = QuestionCategory::all();
		$faqs = Question::where('company_id', $company_id)
										->where('created_by', '!=', $user->id)
										->whereHas('createdBy', function ($query) use ($company_id) {
											$query->whereHas('roles', function ($q) {
												$q->where('id', '!=', 8);
											});
										})
										->orderBy('created_at', 'DESC')
										->get();

		if ($candidate) {
			return view('frontend.pages.candidate.questions', compact(
				'candidate',
				'user',
				'questions',
				'categories',
				'faqs'
			));
		}
	}

	/**
	 * Create page
	 *
	 * @return View
	 */
	public function createQuestion()
	{
		$categories = QuestionCategory::all();

		return view('frontend.pages.candidate.create_question', compact(
			'categories'
		));
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function questionDetail($id)
	{
		$question = Question::findOrFail($id);

		return view('frontend.pages.candidate.question_detail', compact(
			'question'
		));
	}

}
