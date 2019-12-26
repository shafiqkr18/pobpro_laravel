<div class="row border-bottom">
	<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header d-flex align-items-center company-name">
			<span>{{ Auth::user() && Auth::user()->company ? Auth::user()->company->company_name : '' }}</span>
		</div>

			<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown mr-2">
							<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
									<i class="fa fa-bell"></i>  <span class="label label-primary">{{ $notification_tasks_count }}</span>
							</a>
							<ul class="dropdown-menu dropdown-alerts">
								@if ($notification_tasks_count == 0)
								<li>
									<p class="text-center mb-0">You have no notifications.</p>
								</li>
								@else
									@include('admin/pages/partials/_tasks', [
										'offers' => $notification_offers, 
										'contracts' => $notification_contracts, 
										'plans' => $notification_plans,
										'department_approvals' => $notification_department_approvals,
										'li_classes' => ''
									])
								@endif
							</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle language-selector d-flex align-items-center" data-toggle="dropdown">
							<i class="fas fa-globe-asia mr-2" style="font-size: 16px;"></i>
							<span style="font-size: 12px;">
                                @if(App::isLocale('en'))
                                ENG
                                 @else
                                 中文
                                @endif

                            </span>
							<i class="fas fa-chevron-down ml-1" style="font-size: 8px;"></i>
						</a>

						<ul class="dropdown-menu languages">
							<li>
								<a href="{{ url('locale/en') }}">{{__('messages.en')}}</a>
							</li>

							<li>
								<a href="{{ url('locale/zh') }}">{{__('messages.zh')}}</a>
							</li>
						</ul>
					</li>

					<li class="pl-3 border-left">
						<img src="{{ URL::asset('img/logo.png') }}" class="img-fluid" alt="" width="83">
					</li>
			</ul>

	</nav>
</div>