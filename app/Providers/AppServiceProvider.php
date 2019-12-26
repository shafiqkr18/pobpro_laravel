<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Offer;
use App\Plan;
use App\DepartmentApproval;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
			
				
      // View::composer('admin.layouts.includes.page-wrapper', function ($view) {
      //   $view->with('notification_offers', $notification_offers);
			// });
			
			//compose all the views....
			view()->composer(['admin.pages.index', 'admin.layouts.includes.navbar'], function ($view) {
				$plans = [];
				$notification_tasks_count = 0;
				$notification_offers = null;
				$notification_contracts = null;
				$notification_plans = null;
				$notification_department_approvals = null;

				if (\Auth::user()->hasRole('itfpobadmin')) {
					$notification_offers = Offer::where('deleted_at', null)
																			->where('type', 0)
																			->where(function ($query) {
																				$query->where('gm_approved', 0)
																							->orWhere('hrm_approved', 0)
																							->orWhere('gm_approved', 0);
																			})
																			->get();

					$notification_contracts = Offer::where('deleted_at', null)
																					->where('type', 1)
																					->where(function ($query) {
																						$query->where('gm_approved', 0)
																									->orWhere('hrm_approved', 0)
																									->orWhere('gm_approved', 0);
																					})
																					->get();

					$notification_plans =  Plan::where('is_approved',0)
																			->where('deleted_at', null)
																			->get();

					$notification_department_approvals = Auth::user()->company && Auth::user()->company->departmentApprovals ? Auth::user()->company->departmentApprovals : null;

					$notification_tasks_count += $notification_offers->count();
					$notification_tasks_count += $notification_contracts->count();
					$notification_tasks_count += $notification_plans->count();

					if ($notification_department_approvals) {
						foreach ($notification_department_approvals as $department_approval) {
							if ($department_approval->approvalRelationships)
								$notification_tasks_count += count($department_approval->approvalRelationships);
						}
					}
				}
				else {
					$offers = Offer::where('deleted_at', null)
													->where('company_id', \Auth::user()->company_id)
													->get();

					$notification_plans = Plan::where('is_approved',0)
																		->where('deleted_at', null)
																		->where('company_id', Auth::user()->company_id)
																		->get();

					$notification_department_approvals = Auth::user()->company && Auth::user()->company->departmentApprovals ? Auth::user()->company->departmentApprovals : null;

					if (Auth::user()->hasRole('DM')) {
						$notification_offers = $offers->where('dm_approved', 0)
																					->where('type', 0);

						$notification_contracts = $offers->where('dm_approved', 0)
																							->where('type', 0);

						$notification_tasks_count += $notification_offers->count();
						$notification_tasks_count += $notification_contracts->count();
					}
					elseif (Auth::user()->hasRole('HRM')) {
						$notification_offers = $offers->where('hrm_approved', 0)
																					->where('dm_approved',1)
																					->where('type', 0);

						$notification_contracts = $offers->where('hrm_approved', 0)
																							->where('dm_approved',1)
																							->where('type', 1);
					}
					elseif (Auth::user()->hasRole('GM')) {
						$notification_offers = $offers->where('gm_approved', 0)
																					->where('dm_approved',1)
																					->where('hrm_approved',1)
																					->where('type', 0);
																					
						$notification_contracts = $offers->where('gm_approved', 0)
																							->where('dm_approved',1)
																							->where('hrm_approved',1)
																							->where('type', 1);
					}
					elseif (Auth::user()->hasRole('HR')) {
						$notification_department_approvals = Auth::user()->company && Auth::user()->company->departmentApprovals ? Auth::user()->company->departmentApprovals : null;

						if ($notification_department_approvals) {
							foreach ($notification_department_approvals as $department_approval) {
								if ($department_approval->approvalRelationships)
									$notification_tasks_count += count($department_approval->approvalRelationships);
							}
						}
					}
				}

				//...with this variable
				$view->with(compact(
					'notification_offers',
					'notification_contracts', 
					'notification_plans',
					// 'plans', 
					// 'notification_requested_sections',
					// 'notification_requested_positions'
					'notification_department_approvals',
					'notification_tasks_count'
				));
			});
			
    }
}
