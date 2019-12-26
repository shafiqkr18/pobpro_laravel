@php
$avatar = Auth::user() && Auth::user()->avatar ? json_decode(Auth::user()->avatar, true) : null;
@endphp

<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse pb-5">
		<ul class="nav metismenu mb-4" id="side-menu">
			<li class="nav-header p-0">
				<div class="d-flex align-items-center justify-content-center company-logo-wrap">
					<img src="{{ URL::asset('img/itf-logo@2x.png') }}" class="img-fluid" alt="">
					<a class="navbar-minimalize" href="#"><i class="fas fa-bars"></i> </a>
				</div>

			</li>

			<li class="nav-header text-center p-sm">
				<div class="dropdown profile-element">
					@if ($avatar)
					<img alt="image" class="rounded-circle img-fluid"
						src="{{ asset('/storage/' . $avatar[0]['download_link']) }}"
						style="width: 48px; height: 48px;" />
					@else
					<img alt="image" class="rounded-circle img-fluid"
						src="{{ URL::asset('img/avatar-default.jpg') }}" style="width: 48px; height: 48px;" />
					@endif

					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<span
							class="block m-t-xs m-b-xs font-bold text-white">{{ Auth::user() && Auth::user()->getName() ? Auth::user()->getName() : '' }}</span>
						<span
							class="text-xs badge badge-primary">{{ Auth::user() && Auth::user()->roles && count(Auth::user()->roles->pluck('display_name')) > 0 ? Auth::user()->roles->pluck('display_name')[0] : '' }}
							<small><i class="fas fa-chevron-down"></i></small></span>
					</a>
					<ul class="dropdown-menu animated fadeInRight m-t-xs">
						<li><a class="dropdown-item"
								href="{{ url('admin/user-management' . (Auth::user() ? '/detail/' . Auth::user()->id : '')) }}">My
								Profile</a></li>
						<li><a class="dropdown-item" href="{{ url('admin/company-profile') }}">Company
								Profile</a></li>
						<li class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="{{ url('admin/logout') }}">Logout</a></li>
					</ul>
				</div>
				<div class="logo-element">
					ITF
				</div>
			</li>
			@can('dashboard')
			<li
				class="border border-left-0 border-secondary border-top-0 {{ Request::is('admin') ? 'active' : '' }}">
				<a href="{{ url('admin') }}"><i class="fa fa-th-large"></i> <span
						class="nav-label">{{__('messages.dashboard')}}</span></a>
			</li>
			@endcan

			<li class="{{ Request::is('admin/topics')
						|| Request::is('admin/topic/*') 
						|| Request::is('admin/tasks')
						|| Request::is('admin/task/*') 
						|| Request::is('admin/relation-map') ? 'active' : '' }}">
				<a href=""><i class="fas fa-tasks"></i> <span class="nav-label">EXECUTIVE</span>
					<span class="fa arrow"></span></a>

				<ul class="nav nav-second-level">
					<li class="{{ Request::is('admin/relation-map') ? 'active' : '' }}">
						<a href="{{ url('admin/relation-map') }}">Correlative Map</a>
					</li>

					<li
						class="{{ Request::is('admin/topics') || Request::is('admin/topic/*') ? 'active' : '' }}">
						<a href="{{ url('admin/topics') }}">Topics</a>
					</li>

					<li
						class="{{ Request::is('admin/tasks') || Request::is('admin/task/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/tasks') }}">Tasks</a>
					</li>

					<li class="{{ Request::is('admin/reports') ? 'active' : '' }}">
						<a href="{{ url('admin/reports') }}">Work reports</a>
					</li>

					<li class="{{ Request::is('admin/minutes-of-meeting') ? 'active' : '' }}">
						<a href="{{ url('admin/minutes-of-meeting') }}">Minutes of Meeting</a>
					</li>

					<li class="{{ Request::is('admin/correspondence') ? 'active' : '' }}">
						<a href="{{ url('admin/correspondence') }}">Letters</a>
					</li>

					<li
						class="{{ Request::is('admin/correspondence/address') || Request::is('admin/correspondence/address/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/correspondence/address') }}">Contacts</a>
					</li>
				</ul>
			</li>

			<!-- <li
				class="{{ Request::is('admin/reports') || Request::is('admin/report/*') ? 'active' : '' }}">
				<a href=""><i class="far fa-calendar-alt"></i> <span class="nav-label">Work Reports</span>
					<span class="fa arrow"></span></a>

				<ul class="nav nav-second-level">
					<li class="{{ Request::is('admin/reports') ? 'active' : '' }}">
						<a href="{{ url('admin/reports') }}">Work reports</a>
					</li>
				</ul>
			</li> -->

			<!-- <li class="{{ Request::is('admin/minutes-of-meeting') 
						|| Request::is('admin/minutes-of-meeting/*') ? 'active' : '' }}">
				<a href=""><i class="far fa-edit"></i> <span class="nav-label">Minutes of Meeting</span>
					<span class="fa arrow"></span></a>

				<ul class="nav nav-second-level">
					<li class="{{ Request::is('admin/minutes-of-meeting') ? 'active' : '' }}">
						<a href="{{ url('admin/minutes-of-meeting') }}">Minutes of Meeting</a>
					</li>
				</ul>
			</li> -->

			<!-- <li class="{{Request::is('admin/correspondence')
								|| Request::is('admin/correspondence/*') ? 'active' : '' }}">
				<a href=""><i class="fas fa-exchange-alt"></i> <span class="nav-label">Correspondence</span>
					<span class="fa arrow"></span></a>

				<ul class="nav nav-second-level">
					<li class="{{ Request::is('admin/correspondence') ? 'active' : '' }}">
						<a href="{{ url('admin/correspondence') }}">Letters</a>
					</li>

					<li
						class="{{ Request::is('admin/correspondence/address') || Request::is('admin/correspondence/address/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/correspondence/address') }}">Contacts</a>
					</li>
				</ul>
			</li> -->

			<!-- Planning -->
			{{--	<li class="
				{{ Request::is('admin/contract-management')
				|| Request::is('admin/contract-management/*')
				|| Request::is('admin/organization-management')
				|| Request::is('admin/organization-management/*')
				|| Request::is('admin/position-management')
				|| Request::is('admin/position-management/*')
				|| Request::is('admin/division-management')
				|| Request::is('admin/division-management/*')
				|| Request::is('admin/department-management')
				|| Request::is('admin/department-management/*')
				|| Request::is('admin/section-management')
				|| Request::is('admin/section-management/*')
				|| Request::is('admin/monitoring')
				|| Request::is('admin/organization-chart') ? 'active' : '' }}">
			<a href=""><i class="fa fa-line-chart"></i> <span class="nav-label">Planning</span> <span
					class="fa arrow"></span></a>

			<ul class="nav nav-second-level">
				<li
					class="{{ Request::is('admin/contract-management') || Request::is('admin/contract-management/*') ? 'active' : '' }}">
					<a href="{{ url('admin/contract-management') }}">Contract Management</a>
				</li>
				<li class="
						{{ Request::is('admin/organization-management')
						|| Request::is('admin/organization-management/*')
						|| Request::is('admin/division-management')
						|| Request::is('admin/division-management/*')
						|| Request::is('admin/position-management')
						|| Request::is('admin/position-management/*')
						|| Request::is('admin/department-management')
						|| Request::is('admin/department-management/*')
						|| Request::is('admin/section-management')
						|| Request::is('admin/section-management/*')
						|| Request::is('admin/organization-chart') ? 'active' : '' }}">
					<a href="#" id="make-planning">Make Planning <span class="fa arrow"></span></a>
					<ul class="nav nav-third-level">
						<li class="
										{{ Request::is('admin/division-management')
										|| Request::is('admin/division-management/*')
										|| Request::is('admin/organization-management')
										|| Request::is('admin/organization-management/*')
										|| Request::is('admin/department-management')
										|| Request::is('admin/department-management/*')
										|| Request::is('admin/section-management')
										|| Request::is('admin/section-management/*')
										|| Request::is('admin/organization-chart') ? 'active' : '' }}">
							<a href="#"><span class="nav-label">Organization Mgt.</span> <span
									class="fa arrow"></span></a>

							<ul class="nav nav-fourth-level">
								<li
									class="{{ Request::is('admin/organization-management') || Request::is('admin/organization-management/*') ? 'active' : '' }}">
									<a href="{{ url('admin/organization-management') }}">Organizations</a>
								</li>

								<li
									class="{{ Request::is('admin/division-management') || Request::is('admin/division-management/*') ? 'active' : '' }}">
									<a href="{{ url('admin/division-management') }}">Divisions</a>
								</li>

								<li
									class="{{ Request::is('admin/department-management') || Request::is('admin/department-management/*') ? 'active' : '' }}">
									<a href="{{ url('admin/department-management') }}">Departments</a>
								</li>

								<li
									class="{{ Request::is('admin/section-management') || Request::is('admin/section-management/*') ? 'active' : '' }}">
									<a href="{{ url('admin/section-management') }}">Sections</a>
								</li>
								<li
									class="{{ Request::is('admin/organization-chart') || Request::is('admin/organization-chart/*') ? 'active' : '' }}">
									<a href="{{ url('admin/organization-chart') }}">Org. Chart</a>
								</li>


							</ul>
						</li>
						<li
							class="{{ Request::is('admin/position-management') || Request::is('admin/position-management/*') ? 'active' : '' }}">
							<a href="{{ url('admin/position-management') }}">Position Management</a>
						</li>
					</ul>
				</li>
				<!-- <li class="{{ Request::is('admin/monitoring') ? 'active' : '' }}">
						<a href="{{ url('admin/monitoring') }}">Monitoring</a>
					</li> -->
			</ul>
			</li>--}}
			@php
			$user = Auth::user();
			//print_r($user->getAllPermissions());
			//foreach ($user->getAllPermissions() as $p)
			//{
			//echo $p->name." ==";
			//}
			//if(!empty($user->getRoleNames()))
			//foreach ($user->getRoleNames() as $v)
			//{
			//echo $v." ==";
			//}
			@endphp
			{{-- check for enterprise --}}
			@unlessrole("EnterpriseAdmin")
			<!-- Management -->
			@can('management')
			<li class="border border-left-0 border-secondary border-top-0 
				{{ Request::is('admin/main-contract')
				|| Request::is('admin/main-contract/*')
				|| Request::is('admin/organization-plan')
				|| Request::is('admin/organization-plan/*')
				|| Request::is('admin/department-requests')
				|| Request::is('admin/department-requests/*') ? 'active' : '' }}">
				<a href=""><i class="fa fa-sitemap"></i> <span class="nav-label">Planning</span> <span
						class="fa arrow"></span></a>

				<ul class="nav nav-second-level">
					@can('main-contract')
					<li
						class="{{ Request::is('admin/main-contract') || Request::is('admin/main-contract/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/main-contract') }}">{{__('messages.main-contract')}}</a>
					</li>
					@endcan
					@can('org-chart')
					<li
						class="{{ Request::is('admin/organization-plan') || Request::is('admin/organization-plan/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/organization-plan') }}">{{__('messages.organization-chart')}}</a>
					</li>
					@endcan

					<li class="{{ Request::is('admin/budgets') 
											|| Request::is('admin/budgets/*') ? 'active' : '' }}">
						<a href="{{ url('admin/budgets') }}">Budget Management</a>
					</li>



					<!-- <li class="{{ Request::is('admin/minutes-of-meeting') ? 'active' : '' }}">
						<a href="{{ url('admin/minutes-of-meeting') }}">{{__('messages.minutes-of-meeting')}}</a>
					</li>

					<li class="{{ Request::is('admin/department-reports') ? 'active' : '' }}">
						<a href="{{ url('admin/department-reports') }}">{{__('messages.department-reports')}}</a>
					</li>

					<li class="{{ Request::is('admin/department-requests') ? 'active' : '' }}">
						<a href="{{ url('admin/department-requests') }}">Department Requests</a>
					</li> -->
				</ul>
			</li>
			@endcan
			<!-- HR -->
			@can('HR')
			<li class="
				{{ Request::is('admin/candidates')
				|| Request::is('admin/candidate/*')
				|| Request::is('admin/insurance')
				|| Request::is('admin/insurance/*')
				|| Request::is('admin/vacancy-management')
				|| Request::is('admin/vacancy-management/*')
				|| Request::is('admin/recruitment')
				|| Request::is('admin/hr')
				|| Request::is('admin/hr-plan')
				|| Request::is('admin/hr-plan/*')
				|| Request::is('admin/employees')
				|| Request::is('admin/employee/*')
				|| Request::is('admin/position-management')
				|| Request::is('admin/position-management/*')
				|| Request::is('admin/candidates')
				|| Request::is('admin/candidate/*')
				|| Request::is('admin/interviews')
				|| Request::is('admin/interview/*')
				|| Request::is('admin/employees')
				|| Request::is('admin/employee/*')
				|| Request::is('admin/offers')
				|| Request::is('admin/offer/*')
				|| Request::is('admin/contracts')
				|| Request::is('admin/contract/*')
				|| Request::is('admin/questions')
				|| Request::is('admin/question/*')
				|| Request::is('admin/organization-mapping')
				|| Request::is('admin/organization-mapping/*')
				|| Request::is('admin/address-book')
				|| Request::is('admin/address-book/*') ? 'active' : '' }}">
				<a href=""><i class="fa fa-users"></i> <span class="nav-label">{{__('messages.hr')}}</span>
					<span class="fa arrow"></span></a>

				<ul class="nav nav-second-level">
					<!-- <li class="{{ Request::is('admin/hr')  ? 'active' : '' }}">
						<a href="{{ url('admin/hr') }}">Dashboard</a>
					</li> -->
					@can('recruitment')
					<li class="
				{{ Request::is('admin/candidates')
				|| Request::is('admin/candidate/*')
				|| Request::is('admin/vacancy-management')
				|| Request::is('admin/vacancy-management/*')
				|| Request::is('admin/recruitment')
				|| Request::is('admin/hr')
				|| Request::is('admin/hr-plan')
				|| Request::is('admin/hr-plan/*')
				|| Request::is('admin/position-management')
				|| Request::is('admin/position-management/*')
				|| Request::is('admin/candidates')
				|| Request::is('admin/candidate/*')
				|| Request::is('admin/interviews')
				|| Request::is('admin/interview/*')
				|| Request::is('admin/offers')
				|| Request::is('admin/offer/*')
				|| Request::is('admin/contracts')
				|| Request::is('admin/contract/*') 
				|| Request::is('admin/onboarding') ? 'active' : '' }}">
						<a href="#" id="mobilization-menu">{{__('messages.recruitment')}} <span
								class="fa arrow"></span></a>

						<ul class="nav nav-third-level">
							@can('recruit')
							<li class="{{ Request::is('admin/recruitment') ? 'active' : '' }}">
								<a href="{{ url('admin/recruitment') }}">{{__('messages.recruit')}}</a>
							</li>
							@endcan

							@can('recruit-plans')
							<li
								class="{{ Request::is('admin/hr-plan') || Request::is('admin/hr-plan/*')  ? 'active' : '' }}">
								<a href="{{ url('admin/hr-plan') }}">{{__('messages.recruit-plans')}}</a>
							</li>
							@endcan
							@can('positions')
							<li class="{{ Request::is('admin/position-management') ? 'active' : '' }}">
								<a href="{{ url('admin/position-management') }}">{{__('messages.positions')}}</a>
							</li>
							@endcan
							@can('candidates')
							<li class="{{ Request::is('admin/candidates') ? 'active' : '' }}">
								<a href="{{ url('admin/candidates') }}">{{__('messages.candidates')}}</a>
							</li>
							@endcan
							@can('interviews')
							<li class="{{ Request::is('admin/interviews') ? 'active' : '' }}">
								<a href="{{ url('admin/interviews') }}">{{__('messages.interviews')}}</a>
							</li>
							@endcan


							@can('offers')
							<li class="{{ Request::is('admin/offers') ? 'active' : '' }}">
								<a href="{{ url('admin/offers') }}">{{__('messages.offers')}}</a>
							</li>
							@endcan
							@can('contracts')
							<li class="{{ Request::is('admin/contracts') ? 'active' : '' }}">
								<a href="{{ url('admin/contracts') }}">{{__('messages.contracts')}}</a>
							</li>
							@endcan

							<li class="{{ Request::is('admin/onboarding') ? 'active' : '' }}">
								<a href="{{ url('admin/onboarding') }}">Onboarding</a>
							</li>

						</ul>
					</li>
					@endcan

					@can('employees')
					<li class="
								 	{{ Request::is('admin/employees')
									|| Request::is('admin/employee/*')
									|| Request::is('admin/address-book')
									|| Request::is('admin/address-book/*')
									|| Request::is('admin/insurance')
									|| Request::is('admin/insurance/*') ? 'active' : '' }}">
						<a href="#" id="mobilization-menu">{{__('messages.employees')}} <span
								class="fa arrow"></span></a>

						<ul class="nav nav-third-level">
							@can('employees-list')
							<li
								class="{{ Request::is('admin/employees') || Request::is('admin/employee/*')  ? 'active' : '' }}">
								<a href="{{ url('admin/employees') }}">{{__('messages.employees-list')}}</a>
							</li>
							@endcan


							<li class="{{ Request::is('admin/address-book')  ? 'active' : '' }}">
								<a href="{{ url('admin/address-book') }}">{{__('messages.address-book')}}</a>
							</li>

							@can('mobilization')
							<li>
								<a href="#" id="mobilization-menu">{{__('messages.mobilization')}} <span
										class="fa arrow"></span></a>

								<ul class="nav nav-third-level">
									<li class="">
										<a
											href="http://demo.pobpro.com/admin/plan_list.php">{{__('messages.plan-list')}}</a>
									</li>

									<li class="">
										<a href="http://demo.pobpro.com/admin/servey.php">{{__('messages.survey')}}</a>
									</li>
								</ul>
							</li>
							@endcan
							@can('insurance')
							<li
								class="{{ Request::is('admin/insurance') || Request::is('admin/insurance/*')  ? 'active' : '' }}">
								<a href="{{ url('admin/insurance') }}">{{__('messages.insurance')}}</a>
							</li>
							@endcan
						</ul>
					</li>
					@endcan

					@can('QA')
					<li class="{{ Request::is('admin/questions') ? 'active' : '' }}">
						<a href="{{ url('admin/questions') }}">{{__('messages.q-and-a')}}</a>
					</li>
					@endcan

					<li class="{{ Request::is('admin/organization-mapping') ? 'active' : '' }}">
						<a href="{{ url('admin/organization-mapping') }}">Organization Mapping</a>
					</li>


				</ul>
			</li>
			@endcan
			{{--direct links starts from here--}}



			{{--administration--}}
			@can('administration')
			<li class="
				{{ Request::is('admin/travel')
				|| Request::is('admin/travel/*')
				|| Request::is('admin/visa')
				|| Request::is('admin/visa/*') ? 'active' : '' }}">
				<a href=""><i class="fas fa-user-shield"></i> <span
						class="nav-label">{{__('messages.administration')}}</span> <span
						class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					@can('travel')
					<li class="
						{{ Request::is('admin/travel')
						|| Request::is('admin/travel/*') ? 'active' : '' }}">
						<a href="#" id="mobilization-menu">{{__('messages.travel')}} <span
								class="fa arrow"></span></a>

						<ul class="nav nav-third-level">
							<li class="{{ Request::is('admin/travel') ? 'active' : '' }}">
								<a href="{{ url('admin/travel') }}">Travel Plan</a>
							</li>

							<li class="">
								<a href="http://demo.pobpro.com/admin/ticketing.php">Flight Booking</a>
							</li>
						</ul>
					</li>
					@endcan
					@can('visa')
					<li>
						<a href="#" id="mobilization-menu">{{__('messages.visa')}} <span
								class="fa arrow"></span></a>

						<ul class="nav nav-third-level">
							<li class="{{Request::is('admin/passport-management')
				|| Request::is('admin/passport-management/*') ? 'active' : '' }}">
								<a href=""> <span class="nav-label">Passport Mgt.</span>
									<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li
										class="{{ Request::is('admin/passport-management') || Request::is('admin/passport-management/*')  ? 'active' : '' }}">
										<a href="{{ url('admin/passport-management') }}">Passports List</a>
									</li>
								</ul>
							</li>
							<li class="">
								<a
									href="http://demo.pobpro.com/admin/employeelist.php">{{__('messages.passport-visa')}}</a>
							</li>

							<li class="">
								<a href="http://demo.pobpro.com/admin/loi.php">LOI List</a>
							</li>
							<li class="">
								<a href="http://demo.pobpro.com/admin/travel_request.php">Application Request</a>
							</li>
						</ul>
					</li>
					@endcan
				</ul>
			</li>
			@endcan
			{{--Camp Services--}}
			@can('camp-services')
			<li class="">
				<a href=""><i class="fa fa-home"></i> <span
						class="nav-label">{{__('messages.camp-services')}}</span> <span
						class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="#" id="mobilization-menu">Accommodation <span class="fa arrow"></span></a>

						<ul class="nav nav-third-level">

							<li class="">
								<a href="http://demo.pobpro.com/admin/accommodation_list.php">Accommodation List</a>
							</li>
							<li class="">
								<a href="http://demo.pobpro.com/admin/reservation_list.php">Reservation List</a>
							</li>
							<li class="">
								<a href="http://demo.pobpro.com/admin/checkin.php">CheckIn List</a>
							</li>

							<li class="">
								<a href="http://demo.pobpro.com/admin/checkout.php">CheckOut List</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" id="mobilization-menu">Catering <span class="fa arrow"></span></a>

						<ul class="nav nav-third-level">
							<li class="">
								<a href="http://demo.pobpro.com/admin/cat_users.php">Registered Users</a>
							</li>


						</ul>
					</li>
				</ul>
			</li>
			@endcan


			{{--HSE--}}
			@can('HSE')
			<li class="">
				<a href=""><i class="fas fa-first-aid"></i> <span
						class="nav-label">{{__('messages.hse')}}</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li class="">
						<a href="http://demo.pobpro.com/admin/ppe.php">PPE Mgt.</a>
					</li>
					<li class="">
						<a href="http://demo.pobpro.com/admin/certificate.php">Training & Certification</a>
					</li>
				</ul>
			</li>
			@endcan

			{{--Finance--}}
			@can('finance')
			<li class="">
				<a href=""><i class="fas fa-money-bill-wave"></i> <span
						class="nav-label">{{__('messages.finance')}}</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li class="">
						<a href="http://demo.pobpro.com/admin/reimbursement.php">Reimbursement</a>
					</li>
					<li class="">
						<a href="http://demo.pobpro.com/admin/cash-advance.php">Cash Advance</a>
					</li>
				</ul>
			</li>
			@endcan
			{{--Rotation--}}
			@can('rotation-mgt')
			<li class="">
				<a href=""><i class="far fa-calendar-check"></i> <span
						class="nav-label">{{__('messages.rotation-mgt')}}</span> <span
						class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li class="">
						<a href="http://demo.pobpro.com/admin/rotation.php">Rotation List</a>
					</li>
					<li class="">
						<a href="http://demo.pobpro.com/admin/timesheet.php">Time Sheet</a>
					</li>
				</ul>
			</li>
			@endcan
			{{--It System & Assets--}}
			@can('IT-system')
			<li class="">
				<a href=""><i class="fas fa-desktop"></i> <span
						class="nav-label">{{__('messages.it-system-assets')}}</span> <span
						class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li class="">
						<a href="http://demo.pobpro.com/admin/it-account.php">IT Account</a>
					</li>
					<li class="">
						<a href="http://demo.pobpro.com/admin/it-support.php">IT Support</a>
					</li>
					<li class="">
						<a href="http://demo.pobpro.com/admin/itassets.php">IT Support</a>
					</li>
				</ul>
			</li>
			@endcan
			{{--security--}}
			@can('security')
			<li class="">
				<a href=""><i class="fas fa-lock"></i> <span
						class="nav-label">{{__('messages.security')}}</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li>
						<a href="#" id="mobilization-menu">Emergency Evacuation <span
								class="fa arrow"></span></a>

						<ul class="nav nav-third-level">
							<li class="">
								<a href="http://demo.pobpro.com/admin/pob_tracking.php">POB Tracking</a>
							</li>

							<li class="">
								<a href="http://demo.pobpro.com/admin/pob_allocation.php">POB Allocation</a>
							</li>
							<li class="">
								<a href="http://demo.pobpro.com/admin/emergency_response.php">Emergency Response</a>
							</li>
							<li class="">
								<a href="http://demo.pobpro.com/admin/access-card.php">Access Control</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" id="mobilization-menu">Contractor Mgt. <span class="fa arrow"></span></a>

						<ul class="nav nav-third-level">
							<li class="">
								<a href="http://demo.pobpro.com/admin/contractor-management.php">Contractor Mgt.
									Report</a>
							</li>

							<li class="">
								<a href="http://demo.pobpro.com/admin/organization-management.php">Organization
									Report</a>
							</li>
							<li class="">
								<a href="http://demo.pobpro.com/admin/employee-management.php">Empolyee Mgt.</a>
							</li>
						</ul>
					</li>
				</ul>
			</li>
			@endcan


			{{--training--}}
			@can('training')
			<li class="">
				<a href="http://demo.pobpro.com/admin/training.php"><i class="fas fa-toolbox"></i> <span
						class="nav-label">{{__('messages.training')}}</span></a>
			</li>
			@endcan
			{{--direct links ends here--}}

			{{--			<li class="{{Request::is('admin/passport-management')--}}
			{{--				|| Request::is('admin/passport-management/*') ? 'active' : '' }}">--}}
			{{--				<a href=""><i class="fas fa-passport"></i> <span class="nav-label">Passport Mgt.</span> <span class="fa arrow"></span></a>--}}
			{{--				<ul class="nav nav-second-level">--}}
			{{--					<li class="{{ Request::is('admin/passport-management') || Request::is('admin/passport-management/*')  ? 'active' : '' }}">--}}
			{{--						<a href="{{ url('admin/passport-management') }}">List</a>--}}
			{{--					</li>--}}
			{{--				</ul>--}}
			{{--			</li>--}}

			<li class="{{Request::is('admin/wfg-management')
				|| Request::is('admin/wfg-management/*') ? 'active' : '' }}">
				<a href=""><i class="fas fa-book"></i> <span
						class="nav-label">{{__('messages.process-procedures')}}</span> <span
						class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li
						class="{{ Request::is('admin/wfg-my-requests') || Request::is('admin/wfg-process-list/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/wfg-process-list') }}">Process List</a>
					</li>
					<li
						class="{{ Request::is('admin/wfg-my-requests') || Request::is('admin/wfg-my-requests/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/wfg-my-requests') }}">My Requests</a>
					</li>

					<li
						class="{{ Request::is('admin/wfg-action-list') || Request::is('admin/wfg-action-list/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/wfg-action-list') }}">My Actions</a>
					</li>
				</ul>
			</li>

			<li class="border border-left-0 border-secondary border-top-0 
				{{ Request::is('admin/contracts-mgt')
				|| Request::is('admin/contracts-mgt/*') ? 'active' : '' }}">
				<a href=""><i class="fas fa-file-contract"></i> <span class="nav-label">Contracts
						Mgt.</span> <span class="fa arrow"></span></a>

				<ul class="nav nav-second-level">
					<li
						class="{{ Request::is('admin/contracts-mgt/contracts') || Request::is('admin/contracts-mgt/contract/*') ? 'active' : '' }}">
						<a href="{{ url('admin/contracts-mgt/contracts') }}">Contracts</a>
					</li>

					<li
						class="{{ Request::is('admin/contracts-mgt/contractors') || Request::is('admin/contracts-mgt/contractor/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/contracts-mgt/contractors') }}">Contractors</a>
					</li>
				</ul>
			</li>

			<!-- User Admin -->
			@can('user-admin')
			<li class="{{Request::is('admin/user-management')
				|| Request::is('admin/user-management/*') ? 'active' : '' }}">
				<a href=""><i class="fas fa-users-cog"></i> <span
						class="nav-label">{{__('messages.user-admin')}}</span> <span
						class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li
						class="{{ Request::is('admin/user-management') || Request::is('admin/user-management/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/user-management') }}">{{__('messages.users-mgt')}}</a>
					</li>
					<li
						class="{{ Request::is('admin/role-management') || Request::is('admin/role-management/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/role-management') }}">{{__('messages.roles-mgt')}}</a>
					</li>
				</ul>
			</li>
			@endcan
			@can('system-admin')
			<li class="">
				<a href=""><i class="fas fa-user-lock"></i> <span
						class="nav-label">{{__('messages.system-admin')}}</span> <span
						class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					{{--                    @can('cmp-list')--}}
					{{--                    <li class="{{ Request::is('admin/enterprise/*') ? 'active' : '' }}">--}}
					{{--                        <a href="{{ url('admin/enterprises' )}}"><i
						class="fa fa-user"></i> <span
						class="nav-label">{{__('messages.companies')}}</span></a>--}}
					{{--                    </li>--}}
					{{--                    @endcan--}}
					<li class="">
						<a href="http://demo.pobpro.com/admin/comming-soon.php">API/SDK.</a>
					</li>
					<li class="">
						<a href="http://demo.pobpro.com/admin/db.php">DB Admin.</a>
					</li>
				</ul>
			</li>
			@endcan


			<!-- templates -->
			@can('settings')
			<li class="
			{{ Request::is('admin/templates')
			|| Request::is('admin/template/*')
			|| Request::is('admin/pdf-templates')
			|| Request::is('admin/pdf-template/*')
			|| Request::is('admin/division-management')
			|| Request::is('admin/division-management/*')
			|| Request::is('admin/department-management')
			|| Request::is('admin/department-management/*')
			|| Request::is('admin/section-management')
			|| Request::is('admin/section-management/*') ? 'active' : '' }}">
				<a href=""><i class="fa fa-cog"></i> <span
						class="nav-label">{{__('messages.settings')}}</span> <span class="fa arrow"></span></a>

				<ul class="nav nav-second-level">
					<li
						class="{{ Request::is('admin/templates') || Request::is('admin/template/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/templates') }}">Email Templates</a>
					</li>

					<li
						class="{{ Request::is('admin/pdf-templates') || Request::is('admin/pdf-template/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/pdf-templates') }}">PDF Templates</a>
					</li>

					<li
						class="{{ Request::is('admin/division-management') || Request::is('admin/division-management/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/division-management') }}">Divison Management</a>
					</li>

					<li
						class="{{ Request::is('admin/department-management') || Request::is('admin/department-management/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/department-management') }}">Department Management</a>
					</li>

					<li
						class="{{ Request::is('admin/section-management') || Request::is('admin/section-management/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/section-management') }}">Section Management</a>
					</li>

					<li
						class="{{ Request::is('admin/rotation-types') || Request::is('admin/rotation-type/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/rotation-types') }}">Rotation Types</a>
					</li>

					<li
						class="{{ Request::is('admin/contract-durations') || Request::is('admin/contract-duration/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/contract-durations') }}">Contract Duration</a>
					</li>
				</ul>

			</li>
			@endcan
			{{-- end of menu --}}
			@else

			{{--                this area for EnterpriseAdmin--}}
			<li class="{{ Request::is('admin/enterprise/*') ? 'active' : '' }}">
				<a
					href="{{ url('admin/enterprise/detail/' . (Auth::user() && Auth::user()->company ? Auth::user()->company->id : '')) }}"><i
						class="fa fa-user"></i> <span class="nav-label">My Company</span></a>
			</li>
			<li class="{{ Request::is('admin/my-organization')  ? 'active' : '' }}">
				<a href="{{ url('admin/my-organization') }}"><i class="fa fa-institution"></i> <span
						class="nav-label">My Organization</span></a>
			</li>
			<!-- User Admin -->
			<li class="{{Request::is('admin/user-management')
				|| Request::is('admin/user-management/*') ? 'active' : '' }}">
				<a href=""><i class="fa fa-users"></i> <span
						class="nav-label">{{__('messages.user-admin')}}</span> <span
						class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li
						class="{{ Request::is('admin/user-management') || Request::is('admin/user-management/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/user-management') }}">{{__('messages.users-mgt')}}</a>
					</li>
					<li
						class="{{ Request::is('admin/role-management') || Request::is('admin/role-management/*')  ? 'active' : '' }}">
						<a href="{{ url('admin/role-management') }}">{{__('messages.roles-mgt')}}</a>
					</li>
				</ul>
			</li>
			@endunlessrole
			{{--            employee console--}}
			<li>
				<a href="{{url('employee-portal')}}"><i class="fas fa-briefcase"></i> <span
						class="nav-label">{{__('messages.employee-console')}}</span> </a>
			</li>

		</ul>

	</div>

	<div
		class="sidebar-footer d-flex flex-nowrap align-items-center flex-nowrap justify-content-center">
		<img src="{{ URL::asset('img/logo.png') }}" class="img-fluid" alt="" width="40">
		<span class="mr-3 ml-3">Powered by</span>
		<img src="{{ URL::asset('img/itf-logo@2x.png') }}" class="img-fluid" alt="" width="40">
	</div>
</nav>