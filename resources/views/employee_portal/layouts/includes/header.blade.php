<nav class="header">
	<div class="container d-flex align-items-center flex-nowrap h-100">
		<div class="logo">
			<a href="{{ url('employee-portal') }}">
				<img src="{{ URL::asset('employee_portal/img/dashboard-logo.png') }}" srcset="{{ URL::asset('employee_portal/img/dashboard-logo.png') }} 1x, {{ URL::asset('employee_portal/img/dashboard-logo@2x.png') }} 2x" class="img-fluid">
			</a>
		</div>

		<ul class="links list-unstyled p-0 d-flex flex-nowrap justify-content-center h-100">
			<li>
				<a href="{{ url('employee-portal') }}" class="<?= Request::is('employee-portal') ? 'active' : '' ?>">Dashboard</a>
			</li>

			<li>
				<a href="javascript:void(0)" 
					class="<?= Request::is('employee-portal/timesheet') 
									|| Request::is('employee-portal/handover') ? 'active' : '' ?>">Timesheet</a>

				<ul class="sub-menu list-unstyled">
					<li>
						<a href="{{ url('employee-portal/timesheet') }}" class="<?= Request::is('employee-portal/timesheet') ? 'active' : '' ?>">Timesheet</a>
						<a href="{{ url('employee-portal/handover') }}" class="<?= Request::is('employee-portal/handover') ? 'active' : '' ?>">Handover</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="{{ url('employee-portal/training') }}" class="<?= Request::is('employee-portal/training') ? 'active' : '' ?>">Training Center</a>
			</li>

			<li>
				<a href="javascript:void(0)" 
					class="<?= Request::is('employee-portal/my-travel') 
									|| Request::is('employee-portal/my-visa') 
									|| Request::is('employee-portal/visa-request') ? 'active' : '' ?>">Administration</a>

				<ul class="sub-menu list-unstyled">
					<li>
						<a href="{{ url('employee-portal/my-travel') }}" class="<?= Request::is('employee-portal/my-travel') ? 'active' : '' ?>">My Travel</a>
						<a href="{{ url('employee-portal/my-visa') }}" class="<?= Request::is('employee-portal/my-visa') ? 'active' : '' ?>">My Visa</a>
						<a href="{{ url('employee-portal/visa-request') }}" class="<?= Request::is('employee-portal/visa-request') ? 'active' : '' ?>">Request New Visa</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="javascript:void(0)" 
					class="<?= Request::is('employee-portal/my-accommodation') 
									|| Request::is('employee-portal/dining-card-request') ? 'active' : '' ?>">Camp</a>

				<ul class="sub-menu list-unstyled">
					<li>
						<a href="{{ url('employee-portal/my-accommodation') }}" class="<?= Request::is('employee-portal/my-accommodation') ? 'active' : '' ?>">My Accommodation</a>
						<a href="{{ url('employee-portal/dining-card-request') }}" class="<?= Request::is('employee-portal/dining-card-request') ? 'active' : '' ?>">Dining Card Request</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="javascript:void(0)" 
					class="<?= Request::is('employee-portal/ppe-management') 
									|| Request::is('employee-portal/certification-and-training') ? 'active' : '' ?>">HSE</a>

				<ul class="sub-menu list-unstyled">
					<li>
						<a href="{{ url('employee-portal/ppe-management') }}" class="<?= Request::is('employee-portal/ppe-management') ? 'active' : '' ?>">PPE Management</a>
						<a href="{{ url('employee-portal/certification-and-training') }}" class="<?= Request::is('employee-portal/certification-and-training') ? 'active' : '' ?>">Certification &amp; Training</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="javascript:void(0)" 
					class="<?= Request::is('employee-portal/daily-pob-submit') 
									|| Request::is('employee-portal/access-application') ? 'active' : '' ?>">Security</a>

				<ul class="sub-menu list-unstyled">
					<li>
						<a href="{{ url('employee-portal/daily-pob-submit') }}" class="<?= Request::is('employee-portal/daily-pob-submit') ? 'active' : '' ?>">Daily POB Submit</a>
						<a href="{{ url('employee-portal/access-application') }}" class="<?= Request::is('employee-portal/access-application') ? 'active' : '' ?>">Access Application</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="{{ url('employee-portal/it-systems') }}" class="<?= Request::is('employee-portal/it-systems') ? 'active' : '' ?>">IT Systems</a>
			</li>

			<li>
				<a href="javascript:void(0)" 
					class="<?= Request::is('employee-portal/cash-advance') 
									|| Request::is('employee-portal/reimbursement') ? 'active' : '' ?>">Finances</a>

				<ul class="sub-menu list-unstyled">
					<li>
						<a href="{{ url('employee-portal/cash-advance') }}" class="<?= Request::is('employee-portal/cash-advance') ? 'active' : '' ?>">Cash Advance</a>
						<a href="{{ url('employee-portal/reimbursement') }}" class="<?= Request::is('employee-portal/reimbursement') ? 'active' : '' ?>">Reimbursement</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="javascript:void(0)" 
					class="<?= Request::is('employee-portal/my-profile') 
									|| Request::is('employee-portal/my-jobs') 
									|| Request::is('employee-portal/offers') 
									|| Request::is('employee-portal/faq') ? 'active' : '' ?>">HR</a>

				<ul class="sub-menu list-unstyled">
					<li>
						<a href="{{ url('employee-portal/my-profile') }}" class="<?= Request::is('employee-portal/my-profile') ? 'active' : '' ?>">My Profile</a>
						<a href="{{ url('employee-portal/my-passport') }}" class="<?= Request::is('employee-portal/my-passport') ? 'active' : '' ?>">My Passport</a>
						<a href="{{ url('employee-portal/questions') }}" class="<?= Request::is('employee-portal/questions') ? 'active' : '' ?>">Q &amp; A</a>
						<a href="{{ url('employee-portal/offers') }}" class="<?= Request::is('employee-portal/offers') ? 'active' : '' ?>">My Offers</a>
					</li>
				</ul>
			</li>
		</ul>

		<div class="profile d-flex align-items-center flex-nowrap">
			<div class="avatar">
				@php
				$avatar = Auth::user() && Auth::user()->avatar ? json_decode(Auth::user()->avatar, true) : null;
				@endphp

				@if ($avatar)
				<img src="{{ asset('/storage/' . $avatar[0]['download_link']) }}" class="img-fluid" alt="" style="max-height: 33px;">
				@else
				<img src="{{ URL::asset('img/avatar-default.jpg') }}" srcset="{{ URL::asset('img/avatar-default.jpg') }} 1x, {{ URL::asset('img/avatar-default@2x.jpg') }} 2x" class="img-fluid" style="max-height: 33px;">
				@endif
			</div>

			<div class="dropdown">
				<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ Auth::user() ? Auth::user()->getName() : '' }}
				</a>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="{{ url('admin') }}">Admin</a>
					<a class="dropdown-item" href="{{ url('admin/logout') }}">Log out</a>
				</div>
			</div>
		</div>
	</div>
</nav>