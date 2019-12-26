<div class="col-md-3 sidebar">
	<div class="widget-wrap candidate-menu d-flex flex-column h-100" style="min-height: 70vh; max-height: 70vh">
		<div class="quick-links">
			<ul class="list-unstyled m-0 d-flex flex-column">
				<li>
					<a class="{{ Request::is('candidate/profile') ? 'active' : '' }}" href="{{ url('candidate/profile') }}">
						<img src="{{ URL::asset('frontend/img/profile.png') }}" srcset="{{ URL::asset('frontend/img/profile.png') }} 1x, {{ URL::asset('frontend/img/profile@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						<img src="{{ URL::asset('frontend/img/profile-white.png') }}" srcset="{{ URL::asset('frontend/img/profile-white.png') }} 1x, {{ URL::asset('frontend/img/profile-white@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						My Profile / CV
					</a>
				</li>

				<li>
					<a class="{{ Request::is('candidate/vacancies') ? 'active' : '' }}" href="{{ url('candidate/vacancies') }}">
						<img src="{{ URL::asset('frontend/img/jobs.png') }}" srcset="{{ URL::asset('frontend/img/jobs.png') }} 1x, {{ URL::asset('frontend/img/jobs@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						<img src="{{ URL::asset('frontend/img/jobs-white.png') }}" srcset="{{ URL::asset('frontend/img/jobs-white.png') }} 1x, {{ URL::asset('frontend/img/jobs-white@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						Job Opportunities
					</a>
				</li>

				<li>
					<a class="{{ Request::is('candidate/interview') || Request::is('candidate/interview/*') ? 'active' : '' }}" href="{{ url('candidate/interview') }}">
						<img src="{{ URL::asset('frontend/img/interview.png') }}" srcset="{{ URL::asset('frontend/img/interview.png') }} 1x, {{ URL::asset('frontend/img/interview@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						<img src="{{ URL::asset('frontend/img/interview-white.png') }}" srcset="{{ URL::asset('frontend/img/interview-white.png') }} 1x, {{ URL::asset('frontend/img/interview-white@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						My Interviews @if (Auth::user() && Auth::user()->candidate && Auth::user()->candidate->interviews && count(Auth::user()->candidate->interviews) > 0) <span class="total">{{ count(Auth::user()->candidate->interviews) }}</span> @endif
					</a>
				</li>

				<li>
					<a class="{{ Request::is('candidate/offers') || Request::is('candidate/offer/*') ? 'active' : '' }}" href="{{ url('candidate/offers') }}">
						<img src="{{ URL::asset('frontend/img/offers.png') }}" srcset="{{ URL::asset('frontend/img/offers.png') }} 1x, {{ URL::asset('frontend/img/offers@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						<img src="{{ URL::asset('frontend/img/offers-white.png') }}" srcset="{{ URL::asset('frontend/img/offers-white.png') }} 1x, {{ URL::asset('frontend/img/offers-white@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						My Offers @if (Auth::user() && Auth::user()->candidate && Auth::user()->candidate->sentOffers && count(Auth::user()->candidate->sentOffers) > 0) <span class="total">{{ count(Auth::user()->candidate->sentOffers) }}</span> @endif
					</a>
				</li>

				<li>
					<a class="{{ Request::is('candidate/contracts')||  Request::is('candidate/contract/detail/*') ? 'active' : '' }}" href="{{ url('candidate/contracts') }}">
						<img src="{{ URL::asset('frontend/img/contracts.png') }}" srcset="{{ URL::asset('frontend/img/contracts.png') }} 1x, {{ URL::asset('frontend/img/contracts@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						<img src="{{ URL::asset('frontend/img/contracts-white.png') }}" srcset="{{ URL::asset('frontend/img/contracts-white.png') }} 1x, {{ URL::asset('frontend/img/contracts-white@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						My Contracts
					</a>
				</li>

				<li>
					<a class="{{ Request::is('candidate/onboarding') ? 'active' : '' }}" href="{{ url('candidate/onboarding') }}">
						<img src="{{ URL::asset('frontend/img/onboarding.png') }}" srcset="{{ URL::asset('frontend/img/onboarding.png') }} 1x, {{ URL::asset('frontend/img/onboarding@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						<img src="{{ URL::asset('frontend/img/onboarding-white.png') }}" srcset="{{ URL::asset('frontend/img/onboarding-white.png') }} 1x, {{ URL::asset('frontend/img/onboarding-white@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						My Onboarding
					</a>
				</li>

				<li>
					<a class="{{ Request::is('candidate/questions') || Request::is('candidate/question/*') ? 'active' : '' }}" href="{{ url('candidate/questions') }}">
						<img src="{{ URL::asset('frontend/img/qa.png') }}" srcset="{{ URL::asset('frontend/img/qa.png') }} 1x, {{ URL::asset('frontend/img/qa@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						<img src="{{ URL::asset('frontend/img/qa-white.png') }}" srcset="{{ URL::asset('frontend/img/qa-white.png') }} 1x, {{ URL::asset('frontend/img/qa-white@2x.png') }} 2x" class="img-fluid mr-2 pr-1">
						Q &amp; A
					</a>
				</li>
			</ul>
		</div>

		@if (Auth::user() && Auth::user()->candidate && Auth::user()->candidate->company_id)
		<div class="sidebar-contact mt-auto">
			<h6 class="mb-4">Contact Information</h6>

			<p>
				{{ Auth::user()->candidate->company ? Auth::user()->candidate->company->company_name : '' }}<br>
				Email: <a href="mailto:{{ Auth::user()->candidate->company ? Auth::user()->candidate->company->email : '' }}" target="_blank">{{ Auth::user()->candidate->company ? Auth::user()->candidate->company->email : '' }}</a><br>
				Telephone: {{ Auth::user()->candidate->company ? Auth::user()->candidate->company->phone_no : '' }}
			</p>
		</div>
		@endif
	</div>
</div>