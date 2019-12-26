@extends('admin.layouts.default')

@section('title')
	Create PDF Template
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<style>
.custom-radio-tabs {
	display: flex;
	flex-wrap: nowrap;
}

.custom-radio-tabs input {
	position: absolute;
  left: -99999px;
  top: -99999px;
  opacity: 0;
  z-index: -1;
	visibility: hidden;
}

.custom-radio-tabs label {
	cursor: pointer;
	padding: 8px 15px;
	font-size: 13px;
	border: 1px solid rgba(24,28,33,0.06);
	margin: 0;
	line-height: 1;
}

.custom-radio-tabs input[type=radio]:checked+label {
  background-color: #e6e6e6;
  z-index: 1;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?v=') }}{{rand(11,99)}}"></script>
<script>
$(document).ready(function(){
	$('.summernote').summernote({
		toolbar: [
			// [groupName, [list of button]]
			['style', ['bold', 'italic', 'underline', 'clear']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['insert', ['link']],
			['view', ['codeview']],
		]
	});
});
</script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Settings
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/pdf-templates') }}">PDF Templates</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Create</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/pdf-templates') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			Create PDF Template
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title indented">
					<h5>Template Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_template" enctype="multipart/form-data">
						<input type="hidden" id="reference_no" name="reference_no" value="{{ $ref_no }}">
						<input type="hidden" name="summary">

						<div class="row">
							<div class="col-sm-8 b-r">
								<div class="form-group form-inline">
									<label>Type</label>
									<div class="custom-radio-tabs">
										<input type="radio" name="type" id="offer" value="offer" checked><label for="offer">Offer</label>
										<input type="radio" name="type" id="contract" value="contract"><label for="contract">Contract</label>
									</div>
								</div>

								<div class="form-group form-inline">
									<label>Title</label>
									<input type="text" class="form-control form-control-sm" name="title" id="title">
								</div>

								<div class="form-group form-inline">
									<label class="align-self-start">Message</label>
									<div class="summernote">
										<p><b><span style="font-size: 14px;">Strictly Private and Confidential</span></b></p>
										<p style="text-align: center; "><b><span style="font-size: 12px;"><br></span></b></p>
										<p style="text-align: center; "><b><span style="font-size: 12px;">Offer of Employment</span></b></p>
										<p style="text-align: left;"><b><span style="font-size: 12px;"><br></span></b></p>
										<p style="text-align: left;"><span style="font-size: 12px;">Date: {date}<br>Name: {name}<br>Email: {email}</span></p>
										<p style="text-align: left;"><span style="font-size: 12px;">Dear {name},</span></p>
										<p style="text-align: left;">I am pleased to extend our offer of employment for the position of Position. In this position you will work in Majnoon Oil Field, Nashwa, Basra Province, Iraq.&nbsp;</p>
										<p style="text-align: left;"><b>Effective Date</b>
												<br>Should you accept this Job Offer, your appointment will be effective from the date you join us, which should not be later than {effective_date}. Should you not join on or before the date, the Company will cancel this Job offer without any liability
												to pay compensation or damages on any grounds whatsoever. This Job Offer shall remain open until {effective_date}. If no acceptance by you hereof is received by us on or before such date, this offer shall lapse and expire.</p>
										<p style="text-align: left;"><b>Contract Duration</b>
												<br>End date of the employment contract is {contract_end_date}, unless terminated by either party giving the other party 60 days prior written notice of their intention to terminate the employment contract</p>
										<p style="text-align: left;"><b>Probationary Period</b>
												<br>Your employment is subject to a probationary period of 3 months beginning from your start date.</p>
										<p><b>Work Pattern<br></b>Your nominal working pattern {days_work}/{days_leave}&nbsp;shall be:
												<br>a.<span style="white-space: pre;">	</span>{days_work}&nbsp;days continuous days working followed by {days_leave}&nbsp;days of continuous leave.
												<br>b.<span style="white-space: pre;">	</span>Working days and days off will be calculated according to arrival/departure times to/from Iraq in accordance with Company Policy.&nbsp;</p>
										<p>The nominal working pattern may change according to the business need.</p>
										<p><b>Remuneration<br></b>1.<span style="white-space: pre;">	</span>You shall be paid {pay_type} USD$ {salary}/- (US Dollars only) for working  {pay_days} only. NO PAY while on rotational leave.
												<br>2.<span style="white-space: pre;">	</span>The employer will apply all statutory requisites, such as but not limited to, taxes, social security, etc. and submit all payable deductions as required by law of the Republic of Iraq. However, you shall
												remain responsible for reporting and paying any tax liability arising from any other country applicable laws.
												<br>3.<span style="white-space: pre;">	</span>The salary is payable monthly by direct deposit to the financial institution of your choice.
												<br>4.<span style="white-space: pre;">	</span>Payment will be based on authorised timesheets submitted at the end of each month.</p>
										<p><b>Benefits<br></b>In addition to your salary you will receive the below benefits:
												<br>1-<span style="white-space: pre;">	</span>Medical &amp; Life Insurance;
												<br>2-<span style="white-space: pre;">	</span>All transportation from Basra to Majnoon Oil Field, Nashwa, Basra Province, Iraq and meals in Iraq shall be provided by the Company free of charge.</p>
										<p><b>Ticketing&nbsp;<br></b>A return Economy Air Ticket shall be provided to you from Iraq to point of Origin (nearest International Airport). A single Air Ticket shall be provided from Iraq to the Point or Origin at the end of the contract. All tickets
												shall be issued as defined in the Employer Company’s HR Policies.</p>
										<p><b>Employment Visa<br></b>The Employment Visa is subject to issuance of security clearance from Iraqi Government. Should Iraq governmental authorities for any reason refuse to grant or revoke this clearance, the Company may cancel this Job Offer without
												any liability to pay compensation or damages on any grounds whatsoever.</p>
										<p><b>Remote Location Fitness to Work<br></b>You will have to undergo a medical examination to Majnoon Oil Field Remote Site Work Standard or the UKOOA/OGUK/NOGEPA medical or equivalent to certify that you are fit to work in remote locations in Iraq. The
												medical examination results will be reviewed by AOS DMCC HSSE department (Majnoon Doctor), for final approval. If your medical examination results are not approved by the Majnoon Doctor, the Company may cancel this Job Offer without any liability
												to reimburse medical examination expenses or to pay compensation or damages on any grounds whatsoever.&nbsp;</p>
										<p><b>Confidentiality&nbsp;<br></b>a.<span style="white-space: pre;">	</span>By accepting this Job Offer, you irrevocably agree that during the course of your employment, and for a period of one (1) year thereafter, you shall not, other than in the course
												of fulfilling your obligations as an employee thereof, communicate any information that might be of a confidential or proprietary nature regarding us or any of our associate entities, to any person including, without limitation, information regarding
												the business and finances thereof.
												<br>b.<span style="white-space: pre;">	</span>Upon termination of your employment, all documents, art or office supplies, records, computer hard drive, diskettes, or tape, notebooks and similar repositories of or containing Confidential Information,
												including copies thereof, then in your possession, whether prepared by you or others, will be left with the Employer.
												<br>c.<span style="white-space: pre;">	</span>In the event of a breach or threatened breach by you of the provisions of this Section, the employer shall be entitled to an injunction restraining you from disclosing, in whole or in part, the Confidential
												Information, or from rendering any services to any person, firm, corporation, association or other entity to whom Confidential Information, in whole or in part, has been disclosed or is threatened to be disclosed.&nbsp; Nothing herein shall be construed
												as prohibiting the Employer from pursuing any other remedies available to the Employer for such breach or threatened breach, including the recovery of damages from you.
												<br>d.<span style="white-space: pre;">	</span>You shall not during the term of Employment Contract&nbsp; and&nbsp; for&nbsp; a period&nbsp; of&nbsp; One year&nbsp; (1)&nbsp; after the expiration or termination&nbsp; of the Employment Contract&nbsp;
												for any reason, directly or indirectly, whether as owner, partner, shareholder, director, employee, consultant,&nbsp; distributor,&nbsp; agent,&nbsp; representative, sponsor or otherwise carry on or be engaged, concerned or interested in carrying
												on within Iraq of any business or employment which may compete with the business of the Company or any of its affiliates or subsidiaries and in respect of which you have performed services during the period falling Six (6) months prior to the expiration
												or termination of your employment.</p>
										<p><b>Law and Jurisdiction&nbsp;<br></b>The Employment Contract shall be construed, governed and interpreted in accordance with Labor Law and its amendments, or any other law replacing it and its amendments, or any other law replacing it.</p>
										<p>
												<br>
										</p>
										<p>Yours truly,</p>
										<p>
												<br>
										</p>
										<p>For and on behalf of the Company</p>
										<div>
												<br>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-4">
								<!-- <div class="form-group">
									<label>Template name</label>
									<input type="text" class="form-control form-control-sm" name="template_name" id="template_name">
								</div> -->

								<div class="form-group">
									<label>Variables</label>
									<p>You can use these variables in the content of the letter. It will be replaced by real data when sending the email.</p>

									<p>
										{date} - Date
										{name} - Candidate name<br>
										{email} - Candidate email<br>
										{position} - Position / Job Title<br>
										{effective_date} - Effective date<br>
										{contract_end_date} - Contract end date<br>
										{days_work} - Continuous days work<br>
										{days_leave} - Continuous days leave<br>
                                        {salary} - Monthly salary<br>
                                        {pay_type} - Pay Type (Monthly/Daily)<br>
                                        {pay_days} - Pay Days
									</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<a href="javascript:void(0)" id="save_pdftemplate" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div>
					</form>

				</div>

			</div>
		</div>
	</div>
</div>
@endsection