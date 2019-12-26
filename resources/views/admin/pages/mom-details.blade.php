@extends('admin.layouts.default') 

@section('title') 
Minutes of Meeting 
@endsection 

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Minutes of Meeting Detail</h2>
		<ol class="breadcrumb">
					<li class="breadcrumb-item">
							<a href="index.html">Home</a>
					</li>
<li class="breadcrumb-item">
							<a href="index.html">Management</a>
					</li>
					<li class="breadcrumb-item active">
							<strong>Minutes of Meeting</strong>
					</li>
			</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInUp">
	<div class="row">

	<div class="col-lg-4">
										
<div class="ibox-title">
							<h5>Meeting Actions Timeline</h5>
							<div class="ibox-tools">
									<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
									</a>
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">
											<i class="fa fa-wrench"></i>
									</a>
									<ul class="dropdown-menu dropdown-user">
											<li><a href="#" class="dropdown-item">Config option 1</a>
											</li>
											<li><a href="#" class="dropdown-item">Config option 2</a>
											</li>
									</ul>
									<a class="close-link">
											<i class="fa fa-times"></i>
									</a>
							</div>
					</div>

					<div class="ibox-content inspinia-timeline">

							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-briefcase"></i>
													6:00 am
													<br/>
													<small class="text-navy">2 hour ago</small>
											</div>
											<div class="col-9 content no-top-border">
													<p class="m-b-xs"><strong>Meeting</strong></p>

													<p>Conference on the sales results for the previous year. Monica please examine sales trends in marketing and products. Below please find the current status of the
															sale.</p>

													
											</div>
									</div>
							</div>
							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-file-text"></i>
													7:00 am
													<br/>
													<small class="text-navy">3 hour ago</small>
											</div>
											<div class="col-9 content">
													<p class="m-b-xs"><strong>Send documents to Mike</strong></p>
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
											</div>
									</div>
							</div>
							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-coffee"></i>
													8:00 am
													<br/>
											</div>
											<div class="col-9 content">
													<p class="m-b-xs"><strong>Coffee Break</strong></p>
													<p>
														Go to shop and find some products.
													Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.
													</p>
											</div>
									</div>
							</div>
							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-phone"></i>
													11:00 am
													<br/>
													<small class="text-navy">21 hour ago</small>
											</div>
											<div class="col-9 content">
													<p class="m-b-xs"><strong>Phone with Jeronimo</strong></p>
													<p>
													Lorem Ipsum has been the industry's standard dummy text ever since.
													</p>
											</div>
									</div>
							</div>
							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-user-md"></i>
													09:00 pm
													<br/>
													<small>21 hour ago</small>
											</div>
											<div class="col-9 content">
													<p class="m-b-xs"><strong>Go to the doctor dr Smith</strong></p>
													<p>
															Find some issue and go to doctor.
													</p>
											</div>
									</div>
							</div>
							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-user-md"></i>
													11:10 pm
											</div>
											<div class="col-9 content">
													<p class="m-b-xs"><strong>Chat with Sandra</strong></p>
													<p>
															Lorem Ipsum has been the industry's standard dummy text ever since.
													</p>
											</div>
									</div>
							</div>
							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-comments"></i>
													12:50 pm
													<br/>
													<small class="text-navy">48 hour ago</small>
											</div>
											<div class="col-9 content">
													<p class="m-b-xs"><strong>Chat with Monica and Sandra</strong></p>
													<p>
															Web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
													</p>
											</div>
									</div>
							</div>
							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-phone"></i>
													08:50 pm
													<br/>
													<small class="text-navy">68 hour ago</small>
											</div>
											<div class="col-9 content">
													<p class="m-b-xs"><strong>Phone to James</strong></p>
													<p>
															Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
													</p>
											</div>
									</div>
							</div>
							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-file-text"></i>
													7:00 am
													<br/>
													<small class="text-navy">3 hour ago</small>
											</div>
											<div class="col-9 content">
													<p class="m-b-xs"><strong>Send documents to Mike</strong></p>
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
											</div>
									</div>
							</div>

					</div>
			
			
	</div>
	<div class="col-lg-8">
					<div class="ibox">
							<div class="ibox-content">
									<div class="row">
											<div class="col-lg-12">
													<div class="m-b-md">
															<a href="#" class="btn btn-white btn-xs float-right">Edit project</a>
															<h2>ITB of DMS Project</h2>
													</div>

											</div>
									</div>
									<div class="row">
											<div class="col-lg-6">
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right"><dt>Status:</dt> </div>
															<div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-primary">Active</span></dd></div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right"><dt>Created by:</dt> </div>
															<div class="col-sm-8 text-sm-left"><dd class="mb-1">Alex Smith</dd> </div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right"><dt>Messages:</dt> </div>
															<div class="col-sm-8 text-sm-left"> <dd class="mb-1">  162</dd></div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right"><dt>Client:</dt> </div>
															<div class="col-sm-8 text-sm-left"> <dd class="mb-1"><a href="#" class="text-navy"> Zender Company</a> </dd></div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right"> <dt>Version:</dt></div>
															<div class="col-sm-8 text-sm-left"> <dd class="mb-1"> 	v1.4.2 </dd></div>
													</dl>

											</div>
											<div class="col-lg-6" id="cluster_info">

													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right">
																	<dt>Last Updated:</dt>
															</div>
															<div class="col-sm-8 text-sm-left">
																	<dd class="mb-1">16.08.2014 12:15:57</dd>
															</div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right">
																	<dt>Created:</dt>
															</div>
															<div class="col-sm-8 text-sm-left">
																	<dd class="mb-1"> 10.07.2014 23:36:57</dd>
															</div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right">
																	<dt>Participants:</dt>
															</div>
															<div class="col-sm-8 text-sm-left">
																	<dd class="project-people mb-1">
																			<a href=""><img alt="image" class="rounded-circle" src="{{ URL::asset('img/a3.jpg') }}"></a>
																			<a href=""><img alt="image" class="rounded-circle" src="{{ URL::asset('img/a1.jpg') }}"></a>
																			<a href=""><img alt="image" class="rounded-circle" src="{{ URL::asset('img/a2.jpg') }}"></a>
																			<a href=""><img alt="image" class="rounded-circle" src="{{ URL::asset('img/a4.jpg') }}"></a>
																			<a href=""><img alt="image" class="rounded-circle" src="{{ URL::asset('img/a5.jpg') }}"></a>
																	</dd>
															</div>
													</dl>
											</div>
									</div>
									<div class="row">
											<div class="col-lg-12">
													<dl class="row mb-0">
															<div class="col-sm-2 text-sm-right">
																	<dt>Completed:</dt>
															</div>
															<div class="col-sm-10 text-sm-left">
																	<dd>
																			<div class="progress m-b-1">
																					<div style="width: 60%;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
																			</div>
																			<small>Project completed in <strong>60%</strong>. Remaining close the project, sign a contract and invoice.</small>
																	</dd>
															</div>
													</dl>
											</div>
									</div>
		<div class="row">
			<div class="panel panel-default">
						<div class="panel-heading"> Minutes of Meeting Contents </div>
						<div class="panel-body">
							
						
			
			<div class="wrapper wrapper-content project-manager">
					
					
					<p> 1. Demoed DMS main functions and workflow, covered almost requirements.</p>
					<p> 2. Compared the difference with SharePoint and Share Folder. </p>
					<p> 3. F&amp;C is using a system which is developed from SharePoint and  using a standalone DC (no relationship with petrochina-hfy.local). It may need to be migrated or just keep it in place.&nbsp; </p>
					<p>4. Workflow. No detail workflow  requiement defined yet. Will create based on the real requirment. </p>
					<p>5. Name Policy. Need to setup a name policy for both company level and department level </p>
					<p> 6. There are some specific technical questions and requirement in function. Need to be confirmed later:
						
						F&amp;C ask how to upload huge volume of document from 3rd partners
						
						Check in remind: If one document is checked out but not check in a long time, how can send email to notify them
						
						Document change alert. How can give alert if one document or folder is updated
						
						Document Merge. Can someone only check out some part of doucment, then merge different document together? </p>
					<p class="small font-bold">
							<span><i class="fa fa-circle text-warning"></i> High priority</span>
					</p>
					
							
					<h5>Project Files</h5>
				
					<ul class="list-unstyled project-files">
	
	
							<li><a href=""><i class="fa fa-file"></i> Project_document.docx</a></li>
							<li><a href=""><i class="fa fa-file-picture-o"></i> Logo_zender_company.jpg</a></li>
							<li><a href=""><i class="fa fa-stack-exchange"></i> Email_from_Alex.mln</a></li>
							<li><a href=""><i class="fa fa-file"></i> Contract_20_11_2014.docx</a></li>
					</ul>
							
					<div class="text-center m-t-md">
							<a href="#" class="btn btn-xs btn-primary">Add files</a>
							<a href="#" class="btn btn-xs btn-primary">Report contact</a>

					</div>
				
</div>

				</div>				  
			</div>
		</div>
									<div class="row m-t-sm">
											<div class="col-lg-12">
											<div class="panel blank-panel">
											<div class="panel-heading">
													<div class="panel-options">
															<ul class="nav nav-tabs">
																	<li><a class="nav-link active" href="#tab-1" data-toggle="tab">Action Assignments</a></li>
																	<li><a class="nav-link" href="#tab-2" data-toggle="tab">Last activity</a></li>
															</ul>
													</div>
											</div>

											<div class="panel-body">

											<div class="tab-content">
											<div class="tab-pane active" id="tab-1">
													<div class="feed-activity-list">
															<div class="feed-element">
																	<a href="#" class="float-left">
																			<img alt="image" class="rounded-circle" src="{{ URL::asset('img/a2.jpg') }}">
																	</a>
																	<div class="media-body ">
																			<small class="float-right">2h ago</small>
																			<strong>Mark Johnson</strong> posted message on <strong>Monica Smith</strong> site. <br>
																			<small class="text-muted">Today 2:10 pm - 12.06.2014</small>
																			<div class="well">
																					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
																					Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
																			</div>
																	</div>
															</div>
															<div class="feed-element">
																	<a href="#" class="float-left">
																			<img alt="image" class="rounded-circle" src="{{ URL::asset('img/a3.jpg') }}">
																	</a>
																	<div class="media-body ">
																			<small class="float-right">2h ago</small>
																			<strong>Janet Rosowski</strong> add 1 photo on <strong>Monica Smith</strong>. <br>
																			<small class="text-muted">2 days ago at 8:30am</small>
																	</div>
															</div>
															<div class="feed-element">
																	<a href="#" class="float-left">
																			<img alt="image" class="rounded-circle" src="{{ URL::asset('img/a4.jpg') }}">
																	</a>
																	<div class="media-body ">
																			<small class="float-right text-navy">5h ago</small>
																			<strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
																			<small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
																			<div class="actions">
																					<a href=""  class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
																					<a href=""  class="btn btn-xs btn-white"><i class="fa fa-heart"></i> Love</a>
																			</div>
																	</div>
															</div>
															<div class="feed-element">
																	<a href="#" class="float-left">
																			<img alt="image" class="rounded-circle" src="{{ URL::asset('img/a5.jpg') }}">
																	</a>
																	<div class="media-body ">
																			<small class="float-right">2h ago</small>
																			<strong>Kim Smith</strong> posted message on <strong>Monica Smith</strong> site. <br>
																			<small class="text-muted">Yesterday 5:20 pm - 12.06.2014</small>
																			<div class="well">
																					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
																					Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
																			</div>
																	</div>
															</div>
															<div class="feed-element">
																	<a href="#" class="float-left">
																			<img alt="image" class="rounded-circle" src="{{ URL::asset('img/profile.jpg') }}">
																	</a>
																	<div class="media-body ">
																			<small class="float-right">23h ago</small>
																			<strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
																			<small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
																	</div>
															</div>
															<div class="feed-element">
																	<a href="#" class="float-left">
																			<img alt="image" class="rounded-circle" src="{{ URL::asset('img/a7.jpg') }}">
																	</a>
																	<div class="media-body ">
																			<small class="float-right">46h ago</small>
																			<strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
																			<small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
																	</div>
															</div>
													</div>

											</div>
											<div class="tab-pane" id="tab-2">

													<table class="table table-striped">
															<thead>
															<tr>
																	<th>Status</th>
																	<th>Title</th>
																	<th>Start</th>
																	<th>End</th>
																	<th>Comments</th>
															</tr>
															</thead>
															<tbody>
															<tr>
																	<td>
																			<span class="label label-primary"><i class="fa fa-check"></i> Completed</span>
																	</td>
																	<td nowrap>
																			Create project in webapp
																	</td>
																	<td>
							<p class="small">12.07.2014 10:10:1</p>
																	</td>
																	<td>
							<p class="small">14.07.2014 10:16:36</p>
																	</td>
																	<td>
																	<p>
																			Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable.
																	</p>
																	</td>

															</tr>
															<tr>
																	<td>
																			<span class="label label-primary"><i class="fa fa-check"></i> Accepted</span>
																	</td>
																	<td>
																			Various versions
																	</td>
																	<td>
																			12.07.2014 10:10:1
																	</td>
																	<td>
																			14.07.2014 10:16:36
																	</td>
																	<td>
																			<p>
																					Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
																			</p>
																	</td>

															</tr>
															<tr>
																	<td>
																			<span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
																	</td>
																	<td>
																			There are many variations
																	</td>
																	<td>
																			12.07.2014 10:10:1
																	</td>
																	<td>
																			14.07.2014 10:16:36
																	</td>
																	<td>
																			<p>
																					There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which
																			</p>
																	</td>

															</tr>
															<tr>
																	<td>
																			<span class="label label-primary"><i class="fa fa-check"></i> Reported</span>
																	</td>
																	<td>
																			Latin words
																	</td>
																	<td>
																			12.07.2014 10:10:1
																	</td>
																	<td>
																			14.07.2014 10:16:36
																	</td>
																	<td>
																			<p>
																					Latin words, combined with a handful of model sentence structures
																			</p>
																	</td>

															</tr>
															<tr>
																	<td>
																			<span class="label label-primary"><i class="fa fa-check"></i> Accepted</span>
																	</td>
																	<td>
																			The generated Lorem
																	</td>
																	<td>
																			12.07.2014 10:10:1
																	</td>
																	<td>
																			14.07.2014 10:16:36
																	</td>
																	<td>
																			<p>
																					The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
																			</p>
																	</td>

															</tr>
															<tr>
																	<td>
																			<span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
																	</td>
																	<td>
																			The first line
																	</td>
																	<td>
																			12.07.2014 10:10:1
																	</td>
																	<td>
																			14.07.2014 10:16:36
																	</td>
																	<td>
																			<p>
																					The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
																			</p>
																	</td>

															</tr>
															<tr>
																	<td>
																			<span class="label label-primary"><i class="fa fa-check"></i> Reported</span>
																	</td>
																	<td>
																			The standard chunk
																	</td>
																	<td>
																			12.07.2014 10:10:1
																	</td>
																	<td>
																			14.07.2014 10:16:36
																	</td>
																	<td>
																			<p>
																					The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.
																			</p>
																	</td>

															</tr>
															<tr>
																	<td>
																			<span class="label label-primary"><i class="fa fa-check"></i> Completed</span>
																	</td>
																	<td>
																			Lorem Ipsum is that
																	</td>
																	<td>
																			12.07.2014 10:10:1
																	</td>
																	<td>
																			14.07.2014 10:16:36
																	</td>
																	<td>
																			<p>
																					Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable.
																			</p>
																	</td>

															</tr>
															<tr>
																	<td>
																			<span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
																	</td>
																	<td>
																			Contrary to popular
																	</td>
																	<td>
																			12.07.2014 10:10:1
																	</td>
																	<td>
																			14.07.2014 10:16:36
																	</td>
																	<td>
																			<p>
																					Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical
																			</p>
																	</td>

															</tr>

															</tbody>
													</table>

											</div>
											</div>

											</div>

											</div>
											</div>

			
									</div>
							</div>
	
					</div>
			</div>

	
</div>

@endsection