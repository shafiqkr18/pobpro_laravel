@extends('employee_portal.layouts.inner')

@section('title')
Visa Request
@endsection

@section('content')
<div class="my-visa">
	<h2 class="section-title">
		Visa Application Form
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="row">

				<div class="col-md-6 offset-md-3">
					<form action="">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Name</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Mobile Number</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Job Title</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Location</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Approval Date</label>
									<div class="form-inline justify-content-between flex-nowrap">
										<select name="" id="" class="form-control">
											<option value="" selected>Day</option>
											<option value="">1</option>
											<option value="">2</option>
											<option value="">3</option>
											<option value="">4</option>
											<option value="">5</option>
											<option value="">6</option>
											<option value="">7</option>
											<option value="">8</option>
											<option value="">9</option>
											<option value="">10</option>
											<option value="">11</option>
											<option value="">12</option>
											<option value="">13</option>
											<option value="">14</option>
											<option value="">15</option>
											<option value="">16</option>
											<option value="">17</option>
											<option value="">18</option>
											<option value="">19</option>
											<option value="">20</option>
											<option value="">21</option>
											<option value="">22</option>
											<option value="">23</option>
											<option value="">24</option>
											<option value="">25</option>
											<option value="">26</option>
											<option value="">27</option>
											<option value="">28</option>
											<option value="">29</option>
											<option value="">30</option>
											<option value="">31</option>
										</select>

										<select name="" id="" class="form-control">
											<option value="" selected>Month</option>
											<option value="">January</option>
											<option value="">February</option>
											<option value="">March</option>
											<option value="">April</option>
											<option value="">May</option>
											<option value="">June</option>
											<option value="">July</option>
											<option value="">August</option>
											<option value="">September</option>
											<option value="">October</option>
											<option value="">November</option>
											<option value="">December</option>
										</select>

										<select name="" id="" class="form-control">
											<option value="" selected>Year</option>
											<option value="">2010</option>
											<option value="">2011</option>
											<option value="">2012</option>
											<option value="">2013</option>
											<option value="">2014</option>
											<option value="">2015</option>
											<option value="">2016</option>
											<option value="">2017</option>
											<option value="">2018</option>
											<option value="">2019</option>
										</select>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Applied Date</label>
									<div class="form-inline justify-content-between flex-nowrap">
										<select name="" id="" class="form-control">
											<option value="" selected>Day</option>
											<option value="">1</option>
											<option value="">2</option>
											<option value="">3</option>
											<option value="">4</option>
											<option value="">5</option>
											<option value="">6</option>
											<option value="">7</option>
											<option value="">8</option>
											<option value="">9</option>
											<option value="">10</option>
											<option value="">11</option>
											<option value="">12</option>
											<option value="">13</option>
											<option value="">14</option>
											<option value="">15</option>
											<option value="">16</option>
											<option value="">17</option>
											<option value="">18</option>
											<option value="">19</option>
											<option value="">20</option>
											<option value="">21</option>
											<option value="">22</option>
											<option value="">23</option>
											<option value="">24</option>
											<option value="">25</option>
											<option value="">26</option>
											<option value="">27</option>
											<option value="">28</option>
											<option value="">29</option>
											<option value="">30</option>
											<option value="">31</option>
										</select>

										<select name="" id="" class="form-control">
											<option value="" selected>Month</option>
											<option value="">January</option>
											<option value="">February</option>
											<option value="">March</option>
											<option value="">April</option>
											<option value="">May</option>
											<option value="">June</option>
											<option value="">July</option>
											<option value="">August</option>
											<option value="">September</option>
											<option value="">October</option>
											<option value="">November</option>
											<option value="">December</option>
										</select>

										<select name="" id="" class="form-control">
											<option value="" selected>Year</option>
											<option value="">2010</option>
											<option value="">2011</option>
											<option value="">2012</option>
											<option value="">2013</option>
											<option value="">2014</option>
											<option value="">2015</option>
											<option value="">2016</option>
											<option value="">2017</option>
											<option value="">2018</option>
											<option value="">2019</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="">Description</label>
									<textarea name="" id=""rows="7" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input type="file" name="file" id="file" class="inputfile" />
									<label for="file">
										<img src="{{ URL::asset('employee_portal/img/icon-upload.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-upload.png') }} 1x, {{ URL::asset('employee_portal/img/icon-upload@2x.png') }} 2x" class="img-fluid mr-2">
										Upload
									</label>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="customCheck1">
									<label class="custom-control-label" for="customCheck1">I agree to the terms and conditions.</label>
								</div>
							</div>
						</div>

						<div class="row mt-5">
							<div class="col-md-12 d-flex align-items-center justify-content-end">
								<a href="" class="btn-cancel mr-3">Cancel</a>
								<a href="" class="btn-submit">Submit</a>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection