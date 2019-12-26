<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/', 'landing\HomeController@index');

/*
 * Routes for admin auth section
 */
Route::group(['prefix'=>'admin'],function (){
    Route::get('login',[ 'as' => 'login', 'uses' =>  'Auth\LoginController@login']);
    Route::post('login_post','Auth\LoginController@authenticate');
    Route::get('register', 'Auth\RegisterController@register');
    Route::post('register_post','Auth\RegisterController@register_submit');
    Route::get('logout', 'Auth\LoginController@logout');

    // wechat work login
    Route::match(['get', 'post'], 'Login_WeChat_Work', 'WechatController@Login_WeChat_Work');
    Route::match(['get', 'post'], 'login_wechatwork', 'WechatController@login_wechatwork_gettoken');
    Route::match(['get', 'post'], 'login_wechatwork_final', 'WechatController@login_wechatwork_final');
});
/*
 * Routes for admin section
 */
Route::group(['prefix' => 'admin','middleware' => 'auth'], function () {
	Route::get('/', 'DashboardController@index');
	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('home', 'DashboardController@index');


	Route::get('logout', 'Auth\LoginController@logout');


	Route::get('contract-management', 'ContractManagementController@index');
	Route::get('contract-management/detail/{id}', 'ContractManagementController@detail');
	Route::get('contract-management/create', 'ContractManagementController@create');
	Route::get('contract-management/update/{id}', 'ContractManagementController@update');
	Route::post('contract-management/delete/{id}', 'ContractManagementController@delete');
	Route::post('save_contract','ContractManagementController@save_contract');
	Route::post('contracts_filter', 'ContractManagementController@contracts_filter');

	Route::get('contracts', 'ContractManagementController@list')->name('employee_contracts_list');
	Route::get('contract/detail/{id}', 'ContractManagementController@detail');
	Route::post('contract/status', 'ContractManagementController@saveStatus');
	Route::post('contract_list_filter', 'ContractManagementController@contract_list_filter');

    Route::get('contracts_pending', 'ContractManagementController@list_pending')->name('employee_contracts_pending_list');
    Route::post('contract_list_filter_pending', 'ContractManagementController@contract_list_filter_pending');
    Route::post('contracts/xple_status', 'ContractManagementController@saveXpleStatus');

    Route::get('relation-map', 'CorrelativeMapController@index');



	Route::get('organization-management', 'OrganizationManagementController@index');
	Route::get('organization-management/detail/{id}', 'OrganizationManagementController@detail');
	Route::get('organization-management/create', 'OrganizationManagementController@create');
	Route::get('organization-management/update/{id}', 'OrganizationManagementController@update');
	Route::post('organization-management/delete/{id}', 'OrganizationManagementController@delete');
	Route::post('save_organization','OrganizationManagementController@save_organization');
	Route::post('organization_filter', 'OrganizationManagementController@organization_filter');
	Route::get('my-organization', 'OrganizationManagementController@myOrganization')->name('myorganization');
	Route::get('organization/create', 'OrganizationManagementController@create');
    Route::get('organization/use_template', 'OrganizationManagementController@use_template');


    Route::get('division-management', 'DivisionController@index');
    Route::get('division-management/detail/{id}', 'DivisionController@detail');
    Route::get('division-management/create', 'DivisionController@create');
    Route::get('division-management/update/{id}', 'DivisionController@update');
    Route::post('division-management/delete/{id}', 'DivisionController@delete');
    Route::post('save_division','DivisionController@save_division');
    Route::post('division_filter', 'DivisionController@division_filter');


    Route::get('department-management', 'DepartmentManagementController@index');
    Route::get('department-management/detail/{id}', 'DepartmentManagementController@detail');
    Route::get('department-management/create', 'DepartmentManagementController@create');
    Route::get('department-management/update/{id}', 'DepartmentManagementController@update');
    Route::post('department-management/delete/{id}', 'DepartmentManagementController@delete');
    Route::post('save_department','DepartmentManagementController@save_department');
    Route::post('department_filter', 'DepartmentManagementController@department_filter');


    Route::get('section-management', 'SectionController@index');
    Route::get('section-management/detail/{id}', 'SectionController@detail');
    Route::get('section-management/create', 'SectionController@create');
    Route::get('section-management/update/{id}', 'SectionController@update');
    Route::post('section-management/delete/{id}', 'SectionController@delete');
    Route::post('save_section','SectionController@save_section');
    Route::post('section_filter', 'SectionController@section_filter');


	Route::get('organization-chart', 'OrganizationChartController@index');
	Route::get('organization/company-view', 'OrganizationChartController@companyView');
	Route::get('organization/division-view/{id}', 'OrganizationChartController@divisionView');
	Route::get('organization/department-view/{id}', 'OrganizationChartController@departmentView');


	Route::get('travel', 'TravelController@list')->name('administration.travel.travel-plan.list');
	Route::post('travel_filter', 'TravelController@travel_filter');


	Route::get('interviews', 'InterviewController@list')->name('hr.recruitment.interviews.list');
	Route::get('interview/detail/{id}', 'InterviewController@detail');
	Route::post('interview/comment/save', 'InterviewController@saveComment');
	Route::post('interview_filter', 'InterviewController@interview_filter');
	Route::get('interview/pdf/{id}/{test?}', 'InterviewController@generatePdf');
    Route::post('candidate_status', 'InterviewController@candidate_status');


	Route::get('position-management', 'PositionManagementController@index')->name('hr.recruitment.positions.list');
	Route::get('position-management/detail/{id}', 'PositionManagementController@detail');
	Route::get('position-management/create', 'PositionManagementController@create');
	Route::get('position-management/update/{id}', 'PositionManagementController@update');
	Route::post('position-management/delete/{id}', 'PositionManagementController@delete');
	Route::post('save_position','PositionManagementController@save_position');
	Route::post('position_filter', 'PositionManagementController@position_filter');
	Route::get('position-management/export_docx/{id}', 'PositionManagementController@export_docx');
	Route::post('position-management/get-position/{id}', 'PositionManagementController@getPosition');

	Route::get('monitoring', 'PositionManagementController@monitoring');


	Route::get('quick-links', 'QuickLinksController@create')->name('quick-links.create');
	Route::post('quick-links/save', 'QuickLinksController@save')->name('quick-links.save');


	Route::get('candidates', 'CandidateController@index')->name('hr.recruitment.candidates.list');
	// Route::get('candidate/detail/{id}', 'CandidateController@detail');
	Route::match(['get', 'post'], 'candidate/detail/{id}/{modal?}', 'CandidateController@detail');
	Route::get('candidate/create', 'CandidateController@create')->name('hr.recruitment.candidates.create');
	Route::get('candidate/update/{id}', 'CandidateController@update');
	Route::post('candidate/delete/{id}', 'CandidateController@delete');
	Route::post('candidate/short-list/{id}', 'CandidateController@short_list');
	Route::get('candidate/import', 'CandidateController@import');
	Route::post('save_candidate','CandidateController@save_candidate');
    Route::post('import_candidate_xls','CandidateController@import_candidate_xls');
	Route::post('candidate_filter', 'CandidateController@candidate_filter');
	Route::get('applicants', 'CandidateController@applicants');
	Route::post('applicant_filter', 'CandidateController@applicant_filter');

	Route::get('shortlisted', 'CandidateController@shortlisted');
	Route::post('shortlisted_filter', 'CandidateController@shortlisted_filter');

    Route::get('vacancy/shortlisted_by_position/{id}/{planid}', 'CandidateController@shortlisted_by_position');
    Route::post('shortlisted_filter_by_position', 'CandidateController@shortlisted_filter_by_position');
    Route::post('assignPersonTOList','CandidateController@assignPersonTOList');
    Route::post('removePersonTOList','CandidateController@removePersonTOList');
    Route::post('assignToQualified','CandidateController@assignToQualified');


    Route::get('vacancy-management', 'VacancyController@index');
    Route::post('vacancy_filter', 'VacancyController@vacancy_filter');
    Route::get('vacancy/post_job/{id}', 'VacancyController@post_job');
    Route::post('save_job','VacancyController@save_job');
    Route::get('vacancy/all_jobs/{id}', 'VacancyController@all_jobs');
    Route::get('vacancy/matching_candidates/{id}','VacancyController@matching_candidates');
    Route::get('vacancy/online_candidates/{id}','VacancyController@online_candidates');
    Route::post('matching_candidate_filter', 'VacancyController@matching_candidate_filter');
    Route::post('online_candidate_filter', 'VacancyController@online_candidate_filter');

    Route::get('vacancy/interviewee_list/{id}/{planid}','VacancyController@interviewee_list');
    Route::post('interviewee_filter', 'VacancyController@interviewee_filter');



	Route::get('offers', 'OfferController@list')->name('offerlist');
	Route::get('offer/detail/{id}', 'OfferController@detail');
	Route::post('offer/comment/save', 'OfferController@saveComment');
	Route::post('offer/status', 'OfferController@saveStatus');
	Route::post('offers_filter', 'OfferController@offers_filter');
	Route::post('offer_list_filter', 'OfferController@offer_list_filter');

    Route::get('offers_pending', 'OfferController@offers_pending')->name('offers_pending');
    Route::post('offer_list_filter_pending', 'OfferController@offer_list_filter_pending');
    Route::post('offers/xple_status', 'OfferController@saveXpleStatus');

	Route::get('insurance', 'InsuranceController@index')->name('hr.employees.insurance.list');
	Route::get('insurance/detail/{id}', 'InsuranceController@detail');
	Route::get('insurance/create', 'InsuranceController@create')->name('hr.employees.insurance.create');
	Route::get('insurance/update/{id}', 'InsuranceController@update');

	Route::get('hr-plan', 'PlanController@list')->name('hr-plan');
	Route::get('hr-plan/add-position', 'PlanController@addPosition')->name('hr.recruitment.recruit-plans.create');
	Route::get('hr-plan/create', 'PlanController@create');
	Route::get('hr-plan/new', 'PlanController@new');
	Route::get('hr-plan/detail/{id}', 'PlanController@detail');
	Route::post('hr-plan/delete/{id}', 'PlanController@delete');
	Route::post('hr-plan/approval/{id}/{status}', 'PlanController@approval');
	Route::post('plans_filter', 'PlanController@plans_filter');
	Route::post('recruitment_plans_filter', 'PlanController@recruitment_plans_filter');
	Route::post('save_plan', 'PlanController@save_plan');
	Route::post('save_plan_new', 'PlanController@save_plan_new');
	Route::get('contract-onboarding/{id}/{planid}', 'RecruitmentController@contractOnboarding');
    Route::post('contract_onboarding_filter', 'RecruitmentController@contract_onboarding_filter');
    Route::get('plans/export_plans/{id}','PlanExportController@export_plans');
    Route::get('plans/export_plans_pdf/{id}','PlanExportController@export_plans_pdf');
    Route::get('plans/export_plans_test/{id}','PlanExportController@export_plans_test');


	Route::get('employees', 'EmployeeController@list')->name('hr.employees.list');
	Route::get('employee/create', 'EmployeeController@create')->name('hr.employees.create');
	Route::get('employee/detail/{id}', 'EmployeeController@detail');
	Route::post('employees_filter', 'EmployeeController@employees_filter');
	Route::post('save_employee', 'EmployeeController@save_employee');
	Route::get('employee/enrollment/{id}', 'EmployeeController@enrollment');
		Route::post('save_enrollment', 'EmployeeController@save_enrollment');

	Route::get('questions', 'QuestionController@list')->name('hr.questions.list');
	Route::get('question/create', 'QuestionController@create')->name('hr.questions.create');
	Route::post('question/save', 'QuestionController@save');
	Route::get('question/update/{id}', 'QuestionController@update');
	Route::get('question/detail/{id}', 'QuestionController@detail');
	Route::post('question/delete/{id}', 'QuestionController@delete');
	Route::post('questions_filter', 'QuestionController@questions_filter');
    Route::post('save_question_answer', 'QuestionController@save_question_answer');

	Route::get('budgets', 'BudgetController@list');
	Route::get('budget/create', 'BudgetController@create');
	Route::post('budget/save', 'BudgetController@save');
	Route::post('budget_filter', 'BudgetController@budget_filter');

	Route::get('company-profile', 'CompanyController@profile');
	Route::post('company/save', 'CompanyController@save');

	Route::get('department-requests', 'DepartmentRequestController@index')->name('management.department-requests.list');
	Route::post('department-requests/get-positions', 'DepartmentRequestController@getPositions');
	Route::post('department-requests/save-section', 'DepartmentRequestController@saveSection');
	Route::post('department-requests/save-position', 'DepartmentRequestController@savePosition');
	Route::post('department-requests/delete-section/{id}/{delete_type?}', 'DepartmentRequestController@deleteSection');
	Route::post('department-requests/delete-position/{id}/{delete_type?}', 'DepartmentRequestController@deletePosition');
	Route::get('department-requests/quick-view/{id?}/{show_buttons?}/{approval_id?}', 'DepartmentRequestController@quickView');

	Route::get('department-requests/submit-for-approval', 'DepartmentRequestController@SubmitForApproval');
	Route::get('department-requests/approve-request', 'DepartmentRequestController@ApproveRequestById');
	Route::get('department-requests/reject-request', 'DepartmentRequestController@RejectRequestById');


	Route::get('correspondence/address', 'CorrespondenceAddressController@list')->name('correspondence.address.list');
	Route::get('correspondence/address/create', 'CorrespondenceAddressController@create')->name('correspondence.address.create');
	Route::get('correspondence/address/update/{id}', 'CorrespondenceAddressController@update')->name('correspondence.address.update');
	Route::get('correspondence/address/detail/{id}', 'CorrespondenceAddressController@detail')->name('correspondence.address.detail');
	Route::post('correspondence/address/delete/{id}', 'CorrespondenceAddressController@delete')->name('correspondence.address.delete');
	Route::get('correspondence/reply', 'CorrespondenceMessageController@replyList')->name('correspondence.reply.list');
	Route::get('correspondence/create', 'CorrespondenceMessageController@createList')->name('correspondence.create.list');
	Route::get('correspondence/relative', 'CorrespondenceRelativeController@list')->name('correspondence.relative.list');

	Route::post('correspondence/address/save_address', 'CorrespondenceAddressController@save_address');

	Route::get('correspondence', 'CorrespondenceController@index');
	Route::get('correspondence/letter/create', 'CorrespondenceController@create');
	Route::get('correspondence/letter/create_for_received', 'CorrespondenceController@create_for_received');
	Route::get('correspondence/letter/detail/{id}', 'CorrespondenceController@detail');
	Route::post('correspondence/letters/move-to-trash', 'CorrespondenceController@moveToTrash');
	Route::post('correspondence/messages_filter', 'CorrespondenceController@messages_filter');
	Route::post('correspondence/letters/save_new_letter', 'CorrespondenceController@save_new_letter');
	Route::get('correspondence/letter/reply', 'CorrespondenceController@reply');
	Route::get('correspondence/letter/receive', 'CorrespondenceController@receive');

	Route::get('topics', 'TopicController@list');
	Route::get('topic/create', 'TopicController@create');
	Route::get('topic/update/{id}', 'TopicController@update');
	Route::get('topic/detail/{id}', 'TopicController@detail');
	Route::post('topic/save', 'TopicController@save');
	Route::post('topic/assign', 'TopicController@assign');
	Route::post('topic/delete/{id}', 'TopicController@delete');
	Route::post('topics_filter', 'TopicController@topics_filter');

	Route::match(['get', 'post'], 'tasks', 'TaskController@list');
	Route::get('task/create', 'TaskController@create');
	Route::get('task/update/{id}', 'TaskController@update');
	Route::get('task/detail/{id}', 'TaskController@detail');
	Route::post('task/save', 'TaskController@save');
	Route::post('task/assign', 'TaskController@assign');
	Route::post('task/delete/{id}', 'TaskController@delete');
	Route::post('tasks_filter', 'TaskController@tasks_filter');
	Route::post('task/history', 'TaskController@history');


	Route::get('contracts-mgt/contracts', 'CompanyContractController@index')->name('company_contracts.contracts.index');
	Route::get('contracts-mgt/contract/create', 'CompanyContractController@create');
	Route::post('contracts-mgt/contract/save_contract', 'CompanyContractController@save_contract');
	Route::get('contracts-mgt/contract/update/{id}', 'CompanyContractController@update');
	Route::get('contracts-mgt/contract/detail/{id}', 'CompanyContractController@detail');
	Route::post('contracts-mgt/contract/delete/{id}', 'CompanyContractController@delete');
	Route::get('contracts-mgt/contract/import', 'CompanyContractController@import');
	Route::post('contracts-mgt/contract/import_excel', 'CompanyContractController@import_excel');
	Route::get('contracts-mgt/contracts/export-excel/{id?}', 'CompanyContractController@exportExcel');


	Route::get('contracts-mgt/contractors', 'CompanyContractorController@index')->name('company_contracts.contractors.index');
	Route::get('contracts-mgt/contractor/create', 'CompanyContractorController@create');
	Route::post('contracts-mgt/contractor/save_contractor', 'CompanyContractorController@save_contractor');
	Route::get('contracts-mgt/contractor/update/{id}', 'CompanyContractorController@update');
	Route::get('contracts-mgt/contractor/detail/{id}', 'CompanyContractorController@detail');
	Route::post('contracts-mgt/contractor/delete/{id}', 'CompanyContractorController@delete');
	Route::get('contracts-mgt/contractor/import', 'CompanyContractorController@import');
	Route::get('contracts-mgt/contractors/export-excel/{id?}', 'CompanyContractorController@exportExcel');
	Route::post('contracts-mgt/contractor/import_excel', 'CompanyContractorController@import_excel');

	Route::get('contracts-mgt/contractor/employees/{id?}', 'ContractorEmployeeController@list')->name('company_contracts.contractors.employees.list');
	Route::get('contracts-mgt/contractor/employee/create/{id?}', 'ContractorEmployeeController@create');
	Route::get('contracts-mgt/contractor/employee/update/{id}', 'ContractorEmployeeController@update');
	Route::post('contracts-mgt/contractor/employee/delete/{id}', 'ContractorEmployeeController@delete');
	Route::post('contracts-mgt/contractor/employee/save', 'ContractorEmployeeController@save');

	Route::get('onboarding', 'CandidateController@onboarding')->name('onboarding.list');


	Route::get('templates', 'TemplateController@index')->name('settings.email-templates.list');
	Route::get('template/detail/{id}', 'TemplateController@detail');
	Route::get('template/create', 'TemplateController@create')->name('settings.email-templates.create');
	Route::get('template/update/{id}', 'TemplateController@update');
	Route::post('template/delete/{id}', 'TemplateController@delete');
	Route::post('save_template','TemplateController@save_template');
	Route::post('template_filter', 'TemplateController@template_filter');

	Route::get('pdf-templates', 'PdfTemplateController@index')->name('settings.pdf-templates.list');
	Route::get('pdf-template/create', 'PdfTemplateController@create')->name('settings.pdf-templates.create');
	Route::get('pdf-template/update/{id}', 'PdfTemplateController@update');
	Route::post('pdf-template/save','PdfTemplateController@save');
	Route::post('pdf_filter', 'PdfTemplateController@template_filter');
	Route::get('pdf-template/generate', 'PdfTemplateController@generate');

	Route::get('hr', 'PositionManagementController@monitoring');
	Route::get('minutes-of-meeting', 'DashboardController@minutesOfMeeting')->name('management.minutes-of-meeting');
	Route::get('meeting-details', 'DashboardController@meetingDetails');
	Route::get('department-reports', 'DepartmentManagementController@reports')->name('management.department-reports');
	Route::get('management-reports-new', 'DepartmentManagementController@reportsNew');
	Route::get('management-reports-compose', 'DepartmentManagementController@reportsCompose');

	Route::get('minutes-of-meeting/list', 'MeetingController@list')->name('meeting-list');
	Route::match(['get', 'post'], 'minutes-of-meeting/create/{modal?}', 'MeetingController@create');
	Route::get('minutes-of-meeting/detail/{id}', 'MeetingController@detail');
	Route::get('minutes-of-meeting/update/{id}', 'MeetingController@update');
	Route::get('minutes-of-meeting/task/{id}', 'MeetingController@task');
	Route::post('meeting_filter', 'MeetingController@meeting_filter');
	Route::post('mom_filter', 'MeetingController@mom_filter');
	Route::post('save_meeting','MeetingController@save_meeting');
    Route::post('mom/getMeetingHTMLData','MeetingController@getMeetingHTMLData');
    Route::post('meeting/save_meeting_mom','MeetingController@save_meeting_mom');



	Route::get('enterprises', 'CompanyController@list')->name('system-admin.companies.list');
	Route::get('enterprise/create', 'CompanyController@create');
	Route::get('enterprise/detail/{id}', 'CompanyController@detail');
	Route::get('enterprise/update/{id}', 'CompanyController@update');
	Route::post('enterprise/delete/{id}', 'CompanyController@delete');
	Route::post('companies_list', 'CompanyController@companies_filter');

	Route::get('rotation-types', 'RotationTypeController@list')->name('settings.rotation-types.list');
	Route::get('rotation-type/create', 'RotationTypeController@create')->name('settings.rotation-types.create');
	Route::get('rotation-type/update/{id}', 'RotationTypeController@update');
	Route::post('rotations_filter', 'RotationTypeController@rotations_filter');

	Route::get('organization-mapping', 'PositionRelationshipController@index')->name('hr.organization-mapping');
	Route::get('organization-mapping/settings/{id?}', 'PositionRelationshipController@settings');
	Route::post('organization-mapping/get-departments/{id}', 'PositionRelationshipController@getDepartments');
	Route::post('organization-mapping/get-department-positions/{id}', 'PositionRelationshipController@getDepartmentPositions');
	Route::post('organization-mapping/save', 'PositionRelationshipController@save');
	Route::post('organization-mapping/delete/{id}', 'PositionRelationshipController@delete');

	Route::get('address-book', 'AddressBookController@list')->name('hr.employees.address-book');
	Route::post('address_book_filter', 'AddressBookController@employees_filter');
	Route::match(['get', 'post'], 'user/address-book/detail/{id}/{modal?}', 'AddressBookController@detail');

	Route::get('reports', 'ReportController@index')->name('reports');
	Route::get('report/detail/{id}','ReportController@detail');
	Route::get('report/create', 'ReportController@create')->name('report.create');
	Route::post('report/add-next-task', 'ReportController@addNextTask');
	Route::post('report/add-remark', 'ReportController@addRemark');
	Route::post('report/save_report','ReportController@save_report');

	Route::post('remark/save','RemarkController@save');


	Route::post('modal/{modal_type}', 'Controller@modal');


	/*populate dropdown start*/
    Route::get('org-divisions', 'OrganizationManagementController@get_divisions');
    Route::get('division-department', 'DivisionController@division_department');
    Route::get('department-section', 'DepartmentManagementController@department_section');

    /*populate dropdown ends*/

		Route::get('passport-management', 'PassportManagementController@list')->name('administration.visa.passport-management.list');
		Route::get('passport-management/create', 'PassportManagementController@create');
		Route::get('passport-management/update/{id}', 'PassportManagementController@update');
		Route::post('passport-management/delete/{id}', 'PassportManagementController@delete');
		Route::post('passport_filter', 'PassportManagementController@passport_filter');


    /*users & roles management*/
    Route::get('user-management', 'UserController@index')->name('user-admin.user-management.list');
    Route::get('user-management/detail/{id}', 'UserController@detail')->name('users.show');
    Route::get('user-management/create', 'UserController@create')->name('users.create');
    Route::get('user-management/update/{id}', 'UserController@update')->name('users.edit');
    Route::post('user-management/delete/{id}', 'UserController@delete');
    Route::post('save_new_user','UserController@save_new_user');

    Route::get('role-management', 'RoleController@index')->name('user-admin.role-management.list');
    Route::get('role-management/detail/{id}', 'RoleController@detail')->name('roles.show');
    Route::get('role-management/create', 'RoleController@create')->name('roles.create');
    Route::get('role-management/update/{id}', 'RoleController@update')->name('roles.edit');
    Route::post('role-management/delete/{id}', 'RoleController@delete');
    Route::post('save_new_role','RoleController@save_new_role');
		/*end users & role management*/

		Route::get('main-contract', 'MainContractController@index')->name('management.main-contract');
		Route::get('organization-plan', 'OrganizationPlanController@index')->name('management.organization-chart');

    Route::get('recruitment', 'RecruitmentController@index')->name('recruitment');



    Route::post('short_list_xple_candidate','VacancyController@short_list_xple_candidate');
    Route::get('call_for_interview','VacancyController@call_for_interview');
		Route::post('save_interview','VacancyController@save_interview');

    Route::get('send_offer','OfferController@sendOffer');
    Route::post('send_offer_letter','OfferController@send_offer_letter');
    Route::post('send_offer_letter_final','OfferController@send_offer_letter_final');



    Route::get('send_contract','OfferController@sendContract');
    Route::post('send_contract_letter','OfferController@send_contract_letter');
    Route::post('send_contract_letter_final','OfferController@send_contract_letter_final');




    Route::get('test_email','VacancyController@test_email');


    /*partial paths*/
    Route::post('getServiceData', 'DepartmentManagementController@getServiceData');
    Route::post('getPositionHTMLData', 'PositionManagementController@getPositionHTMLData');
    Route::post('getPositionHTMLDataTable', 'PositionManagementController@getPositionHTMLDataTable');
    Route::post('getPositionHTMLDataTableService', 'PositionManagementController@getPositionHTMLDataTableService');
    Route::post('getEnrollmentHtml','EmployeeController@getEnrollmentHtml');

    Route::match(['get', 'post'], 'get_wfg_requests', 'api\WFGController@get_wfg_requests');
    Route::get('wfg-my-requests','WFGManagementController@my_requests')->name('wfg-my-requests');
    Route::get('wfg-my-requests-closed','WFGManagementController@my_requests_closed');
    Route::get('wfg-process-list','WFGManagementController@wfg_process_list')->name('process-and-procedures.process-list');
    Route::get('wfg-action-list','WFGManagementController@wfg_action_list')->name('process-and-procedures.my-actions');
    Route::get('wfg-action-list-closed','WFGManagementController@wfg_action_list_closed');


    //DB dumper
    Route::get('db_dumper','BackupDbController@db_dumper');

});


/*
 * Routes for client end
 */
Route::group(['prefix' => 'client'], function () {

});

// log in candidate using uuid
Route::get('candidate/uuid/{id}', 'frontend\CandidateController@loginByUuid');
Route::get('candidate/uuid/{id}/{redirect}', 'frontend\CandidateController@loginByUuid');

Route::get('candidate/vacancies', 'frontend\CandidateController@vacancies');

/*
 * Candidate routes
 */
Route::group(['prefix' => 'candidate','middleware' => 'auth'], function () {
	Route::get('', function () {
    return redirect('candidate/profile');
	});

	Route::match(['get', 'post'], 'profile', 'frontend\CandidateController@profile');
	Route::post('save-profile', 'frontend\CandidateController@saveProfile');

	Route::get('interview', 'frontend\CandidateController@interview');
	Route::get('interview/detail/{id}', 'frontend\CandidateController@interviewDetail');
	Route::get('interview/feedback', 'frontend\CandidateController@interviewFeedback');
	Route::post('interview/respond', 'frontend\CandidateController@saveInterviewResponse');

	Route::get('offers', 'frontend\CandidateController@offers');
	Route::get('offer/detail/{id}', 'frontend\CandidateController@offerDetail');
	Route::post('offer/feedback', 'frontend\CandidateController@saveOfferFeedback');
	Route::get('offer/accept', 'frontend\CandidateController@offerAccept');
	Route::get('offer/decline', 'frontend\CandidateController@offerDecline');

	Route::get('contracts', 'frontend\CandidateController@contracts');
	Route::get('contract/detail/{id}', 'frontend\CandidateController@contractDetail');
	Route::post('contract/send', 'frontend\CandidateController@saveOfferFeedback');

	Route::get('onboarding', 'frontend\CandidateController@onboarding');

	Route::get('questions', 'frontend\CandidateController@questions');
	Route::get('question/create', 'frontend\CandidateController@createQuestion');
	Route::get('question/detail/{id}', 'frontend\CandidateController@questionDetail');

	Route::match(['get', 'post'], 'vacancy/detail/{id}', 'frontend\CandidateController@vacancyDetail');
});

/*
 * Employee portal routes
 */
Route::group(['prefix' => 'employee-portal', 'middleware' => 'auth'], function () {

	Route::get('/', 'employee_portal\DashboardController@index')->name('employee_portal.dashboard');
	// Route::get('dashboard', 'employee_portal\DashboardController@index')->name('employee_portal.dashboard');

	Route::get('my-profile', 'employee_portal\HrController@profile');
	Route::get('my-profile/update', 'employee_portal\HrController@updateProfile');

	Route::get('my-passport', 'employee_portal\HrController@passport');
	Route::get('my-passport/create', 'employee_portal\HrController@createPassport');
	Route::get('my-passport/update/{id}', 'employee_portal\HrController@updatePassport');

	Route::get('questions', 'employee_portal\HrController@questions');

	Route::get('offers', 'employee_portal\HrController@offers');

	Route::get('timesheet', 'employee_portal\DashboardController@timesheet');
	Route::get('handover', 'employee_portal\DashboardController@handover');
	Route::get('training', 'employee_portal\DashboardController@training');
	Route::get('my-travel', 'employee_portal\DashboardController@myTravel');
	Route::get('my-visa', 'employee_portal\DashboardController@myVisa');
	Route::get('visa-request', 'employee_portal\DashboardController@visaRequest');
	Route::get('create-ticket', 'employee_portal\DashboardController@createTicket');
	Route::get('my-accommodation', 'employee_portal\DashboardController@myAccommodation');
	Route::get('dining-card-request', 'employee_portal\DashboardController@diningCardRequest');
	Route::get('accommodation-form', 'employee_portal\DashboardController@accommodationForm');
	Route::get('ppe-management', 'employee_portal\DashboardController@ppeManagement');
	Route::get('certification-and-training', 'employee_portal\DashboardController@certificationAndTraining');
	Route::get('ppe-form', 'employee_portal\DashboardController@ppeForm');
	Route::get('daily-pob-submit', 'employee_portal\DashboardController@dailyPobSubmit');
	Route::get('access-application', 'employee_portal\DashboardController@accessApplication');
	Route::get('access-application-form', 'employee_portal\DashboardController@accessApplicationForm');
	Route::get('it-systems', 'employee_portal\DashboardController@itSystems');
	Route::get('cash-advance', 'employee_portal\DashboardController@cashAdvance');
	Route::get('cash-advance-form', 'employee_portal\DashboardController@cashAdvanceForm');
	Route::get('reimbursement', 'employee_portal\DashboardController@reimbursement');
	Route::get('reimbursement-form', 'employee_portal\DashboardController@reimbursementForm');

	Route::get('my-jobs', 'employee_portal\DashboardController@myJobs');
	Route::get('my-offers', 'employee_portal\DashboardController@myOffers');
	Route::get('faq', 'employee_portal\DashboardController@faq');
	Route::get('detail', 'employee_portal\DashboardController@detail');
	Route::get('my-rotation', 'employee_portal\DashboardController@myRotation');


});

//Auth::routes();

Route::get('/home', 'DashboardController@index')->name('home');

Route::get('login', 'frontend\LoginController@login');

Route::get('register-organization', 'OrganizationManagementController@register');

// SaaS registration
Route::match(['get', 'post'], 'saas', 'CompanyController@register');

Route::get('login/wechat_web', 'Auth\LoginController@redirectToProvider');
Route::get('login/wechat_web/callback', 'Auth\LoginController@handleProviderCallback');

