<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Add Your favicon here -->
    <link rel="icon" href="{{ URL::asset('landing/img/logo/favicon.ico') }}">

    <title>POB Pro - ITforce Personnel On Board System</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('landing/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="{{ URL::asset('landing/css/animate.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('landing/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
		<link href="{{ URL::asset('landing/css/style.css') }}" rel="stylesheet">
		<link href="{{ URL::asset('landing/css/custom.css') }}" rel="stylesheet">
</head>
<body id="page-top" class="landing-page">
<div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top navbar-expand-md" role="navigation">
        <div class="container">
            <a class="" href="{{ url('/') }}"><img src="{{ URL::asset('landing/img/logo/logo.png') }}"  height="58" alt=""/></a>
            <div class="navbar-header page-scroll">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="nav-link page-scroll" href="#page-top">Home</a></li>
                    <li><a class="nav-link page-scroll" href="#features">Features</a></li>
                    <li><a class="nav-link page-scroll" href="#team">Customers</a></li>
                    <li><a class="nav-link page-scroll" href="#testimonials">Testimonials</a></li>
                    <li><a class="nav-link page-scroll" href="#contact">Contact</a></li>
                    <li><a class="nav-link page-scroll" href="{{ url('candidate/vacancies') }}">Jobs</a></li>
										<li><a class="nav-link page-scroll" href="#pricing">Pricing</a></li>
										<li><a class="nav-link page-scroll" href="{{ url('admin/login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div id="inSlider" class="carousel slide" data-ride="carousel" >
    <ol class="carousel-indicators">
        <li data-target="#inSlider" data-slide-to="0" class="active"></li>
        <li data-target="#inSlider" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Personnel Management <br/>
                        Onsite for<br/>
                        Security, Life and Works<br/>
                        </h1>
                    <p>POB for Oil & Gas, Construction Industry</p>
                    <p>
                        <a class="btn btn-lg btn-primary" href="#" role="button">READ MORE</a>
                        <a class="caption-link" href="#" role="button">Professional POB System</a>
                    </p>
                </div>
                <div class="carousel-image wow zoomIn">
                    <img src="{{ URL::asset('landing/img/laptop.png') }}" alt="laptop"/>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back one"></div>

        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="carousel-caption blank">
                    <h1>We create meaningful <br/> interfaces that inspire.</h1>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back two"></div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#inSlider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#inSlider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<section id="features" class="container services">
    <div class="row">
        <div class="col-sm-3">
            <h2>Management Onboard</h2>
            <p>Start from project contract award! <br>
We setup fast Communication and Collaborations for core management team before project launched by Management Reporting, Minutes of Meeting, Orgnization Planning tools. </p>
            <p><a class="navy-link" href="#" role="button">Details &raquo;</a></p>
        </div>
        <div class="col-sm-3">
            <h2>Employees Onboarding</h2>
            <p>Helping HR team take fastest employee enrollment is our task. HR team can create job positions, find right candidates from thousand CVs. Bulk send interview letter, offers to thousand candidates in one-click and collect feedback online.</p>
            <p><a class="navy-link" href="#" role="button">Details &raquo;</a></p>
        </div>
        <div class="col-sm-3">
            <h2>Travel & Visa Ready</h2>
            <p>Administration can make traveling plan for hundred of person in short time. Manage and track all visa of employees. Track the workflow to apply new or renew exist visa. Help to get flight tickets booked in case of no ERP or OA system.</p>
            <p><a class="navy-link" href="#" role="button">Details &raquo;</a></p>
        </div>
        <div class="col-sm-3">
            <h2>Compus Services Ready</h2>
            <p>Compus or Camp will be ready in short time to accept mobilized persons and welcome personnel on board. These works include the PPE applications, Security Access, Accommodation and Catering.</p>
            <p><a class="navy-link" href="#" role="button">Details &raquo;</a></p>
        </div>
    </div>
</section>

<section  class="container features" >
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1>Personnel-Centrelized Management System<br/> <span class="navy"> Online interactions accross departments</span> </h1>
            <p>Provide employees ONE-SITE interface to manage all tasks onsite </p>
        </div>
    </div>
    <div class="row" style="background-color: #EEEEEE">
        <div class="col-md-3 text-center wow fadeInLeft">
            <div><i
					class="fa fa-mobile features-icon"></i>
              <h2>Employee</h2>
                <p>All employees have account to logon to process daily request onsite. Include life, works, security onsite.</p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-bar-chart features-icon"></i>
                <h2>Contractor</h2>
                <p>Not only employees, contractor of vendors also have account with limited access to some resource and get connected with site management.</p>
            </div>
			<div class="m-t-lg">
                <i class="fa fa-bar-chart features-icon"></i>
                <h2>Candidates</h2>
                <p>During HR recruitment, candidates can have a temp communication center where they can logon to track and take interactions with HR team. </p>
            </div>
        </div>
        <div class="col-md-6 text-center  wow zoomIn">
            <img src="{{ URL::asset('landing/img/logo/pob-1.png') }}" alt="dashboard" class="img-fluid">
        </div>
        <div class="col-md-3 text-center wow fadeInRight" >
            <div>
                <i class="fa fa-envelope features-icon"></i>
                <h2>Department</h2>
                <p>Administrator of each department have a workspace to process daily reqeusts from users. It will be a special designed process beside ERP or OA system by highest efficency.</p>
            </div>
            
			<div class="m-t-lg">
                <i class="fa fa-bar-chart features-icon"></i>
                <h2>Compus Services</h2>
                <p>Include Camp services, HSE, Security, Warehouse</p>
            </div>
			<div class="m-t-lg">
                <i class="fa fa-google features-icon"></i>
                <h2>Executive</h2>
                <p>Executive team take use this platform to take communication, daily report, meeting minutes. Mornitoring and check the reports fo the site.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1>Discover great feautres</h1>
            <p>Light-Weighted and Fastest Personnel Management System in All Over the World.</p>
        </div>
    </div>
    <div class="row features-block">
        <div class="col-lg-6 features-text wow fadeInLeft">
            <small>ITF POB pro</small>
            <h2>What's Difference with ERP or OA? </h2>
            <p>OA is actually a China-Style ERP system which can do anythings but need to be customize developed. However there normally no Out-Of-Box features to manage personnel onsite. Or each functions are standalone and just manage particial works.</p>
			<p>ERP sytem is very powerful but also expensive at the sametime. And ERP is too heavry to used for managing personnel or just for some specific affairs onsite. </p>
			<p>POB pro can be understood as a special OA system which is special customize developed for personnel management only. All are out-of-box features. And with POB pro, things never be so easy as now that employees or contracts just logon one system then can process one tasks accross departments with workflow enabled and never go to each department as before. To department admins, they just need to take care for the reqeusts sent from users then take actions and don't need to care which next step should be. </p>
			
            
        </div>
        <div class="col-lg-6 text-right wow fadeInRight">
            <img src="{{ URL::asset('landing/img/dashboard.png') }}" alt="dashboard" class="img-fluid float-right">
		<a href="" class="btn btn-primary">Learn more</a>	
        </div>
    </div>
	<div class="row features-block">
		<div class="col-lg-12 text-right wow fadeInRight">
            
			<img src="{{ URL::asset('landing/img/logo/POBpro.png') }}" alt="dashboard" class="img-fluid float-right">
        </div>
	</div>
</section>

<!-- <section id="team" class="gray-section team">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Our Customers</h1>
                <p>Our customers are in oil & gase industry and contrstruction companies. They used ITF POB pro to manage their employees and contractors in the compus.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 wow fadeInLeft">
                <div class="team-member">
                    <img src="{{ URL::asset('landing/img/logo/boc.png') }}" class="img-fluid rounded-circle img-small" alt="">
                    <h4><font color="#1ab394">BOC</font></h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus. </p>
                    <ul class="list-inline social-icon">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="team-member wow zoomIn">
                    <img src="{{ URL::asset('landing/img/logo/cnpc_7070-70.png') }}" class="img-fluid rounded-circle" alt="">
                    <h4><font color="#1ab394">PetroChina</font></h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.</p>
                    <ul class="list-inline social-icon">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 wow fadeInRight">
                <div class="team-member">
                    <img src="{{ URL::asset('landing/img/logo/shell.png') }}" class="img-fluid rounded-circle img-small" alt="">
                    <h4><font color="#1ab394">Shell</font></h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.</p>
                    <ul class="list-inline social-icon">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center m-t-lg m-b-lg">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
            </div>
        </div>
    </div>
</section> -->

<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Even more great feautres</h1>
                <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. </p>
            </div>
        </div>
        <div class="row features-block">
            <div class="col-lg-3 features-text wow fadeInLeft">
                <small>POB Pro </small>
                <h2>Perfectly designed </h2>
                <p>ITforce POB Pro is a premium admin dashboard template with flat design concept. It is fully responsive admin dashboard template built with Bootstrap 3+ Framework, HTML5 and CSS3, Media query. It has a huge collection of reusable UI components and integrated with latest jQuery plugins.</p>
                <a href="" class="btn btn-primary">Learn more</a>
            </div>
            <div class="col-lg-6 text-right m-t-n-lg wow zoomIn">
                <img src="{{ URL::asset('landing/img/iphone.jpg') }}" class="img-fluid" alt="dashboard">
            </div>
            <div class="col-lg-3 features-text text-right wow fadeInRight">
                <small>POB Pro </small>
                <h2>Perfectly designed </h2>
                <p>INSPINIA Admin Theme is a premium admin dashboard template with flat design concept. It is fully responsive admin dashboard template built with Bootstrap 3+ Framework, HTML5 and CSS3, Media query. It has a huge collection of reusable UI components and integrated with latest jQuery plugins.</p>
                <a href="" class="btn btn-primary">Learn more</a>
            </div>
        </div>
    </div>

</section>

<section class="timeline gray-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Our Roadmap</h1>
                <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. </p>
            </div>
        </div>
        <div class="row features-block">

            <div class="col-lg-12">
                <div id="vertical-timeline" class="vertical-container light-timeline center-orientation">
                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon navy-bg">
                            <i class="fa fa-briefcase"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>Meeting</h2>
                            <p>Conference on the sales results for the previous year. Monica please examine sales trends in marketing and products. Below please find the current status of the sale.
                            </p>
                            <a href="#" class="btn btn-xs btn-primary"> More info</a>
                            <span class="vertical-date"> Today <br/> <small>Dec 24</small> </span>
                        </div>
                    </div>

                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon navy-bg">
                            <i class="fa fa-file-text"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>Decision</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
                            <a href="#" class="btn btn-xs btn-primary"> More info</a>
                            <span class="vertical-date"> Tomorrow <br/> <small>Dec 26</small> </span>
                        </div>
                    </div>

                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon navy-bg">
                            <i class="fa fa-cogs"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>Implementation</h2>
                            <p>Go to shop and find some products. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's. </p>
                            <a href="#" class="btn btn-xs btn-primary"> More info</a>
                            <span class="vertical-date"> Monday <br/> <small>Jan 02</small> </span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</section>

<section id="testimonials" class="navy-section testimonials" style="margin-top: 0">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center wow zoomIn">
                <i class="fa fa-comment big-icon"></i>
                <h1>
                    What our users say
                </h1>
                <div class="testimonials-text">
                    <i>"We keep finding a perfect solution to manage all personnel onsite until we find ITforce POBpro. <br>
It not only provide tradition POB funcitons which normally focus on security, <br>but also provide a number of funtions to manage personnel onsite include accommodation, catering, works and healthy. <br>
And also provide a number of helpful functions which will be very expensive if take bay ERP or other IT systems. "</i>
                </div>
				 <div class="testimonials-text">
                <small>
                    <strong>12.02.2019 - Andy Smith / IT Director of PetroChina</strong>
                </small>
				</div>
            </div>
        </div>
    </div>

</section>

<section class="comments gray-section" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>What our partners say</h1>
                <p>Donec sed odio dui. Etiam porta sem malesuada. </p>
            </div>
        </div>
        <div class="row features-block">
            <div class="col-lg-4">
                <div class="bubble">
                    "Uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
                </div>
                <div class="comments-avatar">
                    <a href="" class="float-left">
                        <img alt="image" src="{{ URL::asset('landing/img/avatar3.jpg') }}">
                    </a>
                    <div class="media-body">
                        <div class="commens-name">
                            Andrew Williams
                        </div>
                        <small class="text-muted">Company X from California</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bubble">
                    "Uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
                </div>
                <div class="comments-avatar">
                    <a href="" class="float-left">
                        <img alt="image" src="{{ URL::asset('landing/img/avatar1.jpg') }}">
                    </a>
                    <div class="media-body">
                        <div class="commens-name">
                            Andrew Williams
                        </div>
                        <small class="text-muted">Company X from California</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bubble">
                    "Uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)."
                </div>
                <div class="comments-avatar">
                    <a href="" class="float-left">
                        <img alt="image" src="{{ URL::asset('landing/img/avatar2.jpg') }}">
                    </a>
                    <div class="media-body">
                        <div class="commens-name">
                            Andrew Williams
                        </div>
                        <small class="text-muted">Company X from California</small>
                    </div>
                </div>
            </div>



        </div>
    </div>

</section>

<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>More and more extra great feautres</h1>
                <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-5 col-lg-offset-1 features-text">
                <small>INSPINIA</small>
                <h2>Perfectly designed </h2>
                <i class="fa fa-bar-chart big-icon float-right"></i>
                <p>INSPINIA Admin Theme is a premium admin dashboard template with flat design concept. It is fully responsive admin dashboard template built with Bootstrap 3+ Framework, HTML5 and CSS3, Media query. It has a huge collection of reusable UI components and integrated with.</p>
            </div>
            <div class="col-lg-5 features-text">
                <small>INSPINIA</small>
                <h2>Perfectly designed </h2>
                <i class="fa fa-bolt big-icon float-right"></i>
                <p>INSPINIA Admin Theme is a premium admin dashboard template with flat design concept. It is fully responsive admin dashboard template built with Bootstrap 3+ Framework, HTML5 and CSS3, Media query. It has a huge collection of reusable UI components and integrated with.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-5 col-lg-offset-1 features-text">
                <small>INSPINIA</small>
                <h2>Perfectly designed </h2>
                <i class="fa fa-clock-o big-icon float-right"></i>
                <p>INSPINIA Admin Theme is a premium admin dashboard template with flat design concept. It is fully responsive admin dashboard template built with Bootstrap 3+ Framework, HTML5 and CSS3, Media query. It has a huge collection of reusable UI components and integrated with.</p>
            </div>
            <div class="col-lg-5 features-text">
                <small>INSPINIA</small>
                <h2>Perfectly designed </h2>
                <i class="fa fa-users big-icon float-right"></i>
                <p>INSPINIA Admin Theme is a premium admin dashboard template with flat design concept. It is fully responsive admin dashboard template built with Bootstrap 3+ Framework, HTML5 and CSS3, Media query. It has a huge collection of reusable UI components and integrated with.</p>
            </div>
        </div>
    </div>

</section>
<section id="pricing" class="pricing">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Services or License Pricing</h1>
                <p>We provide both Cloud SaaS services and On-Premise solution</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 wow zoomIn">
                <ul class="pricing-plan list-unstyled selected basic">
                    <li class="pricing-title">
                        Basic
                    </li>
                    <li class="pricing-desc">
                        Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.
                    </li>
                    <li class="pricing-price">&nbsp;</li>
                    <li> Inforamtion Onboard</li>
                    <li>Executive Onboard</li>
                    <li>-</li>
					<li>
                       -
                    </li>
					<li>
                       -
                    </li>
					
                    <li>
                        <a class="btn btn-primary btn-xs" href="{{ url('saas?subscription_type=0') }}">Signup</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 wow zoomIn">
                <ul class="pricing-plan list-unstyled selected professional">
                    <li class="pricing-title">
                        Professional
                    </li>
                    <li class="pricing-desc">
                        Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.
                    </li>
                    <li class="pricing-price">&nbsp;</li>
                    <li>Information Onbaord</li>
                    <li> Executive Onbaord</li>
                    <li> Personnel Onboard</li>
                    <li> - </li>
					<li>
                       -
                    </li>
					
                    <li class="plan-action">
                        <a class="btn btn-primary btn-xs" href="{{ url('saas?subscription_type=0') }}">Signup</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 wow zoomIn">
                <ul class="pricing-plan list-unstyled selected premium">
                    <li class="pricing-title">
                        Enterprise Premium
                    </li>
                    <li class="pricing-desc">
                        Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.
                    </li>
                    <li class="pricing-price">&nbsp;</li>
                    <li> Information Onboard</li>
                    <li> Executive Onboard</li>
                    <li> Personnel Onbaord</li>
                    <li> Material Onboard</li>
					<li>
                        Customization Services
                    </li>
					
                    <li>
                        <a class="btn btn-primary btn-xs" href="{{ url('saas?subscription_type=0') }}">Signup</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row m-t-lg">
            <div class="col-lg-12 text-center m-t-lg">
                <p>*Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. <span class="navy">Various versions</span>  have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
            </div>
        </div>
    </div>

</section>

<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Contact Us</h1>
                <p>ITforce Technology</p>
            </div>
        </div>
        <div class="row m-b-lg justify-content-center">
            <div class="col-lg-3 ">
                <address>
              <strong><span class="navy">ITforce Technology Dubai</span></strong><br>
1607 HDS Tower, Cluster F, <br>
Jumeirah Lake Towers<br>
Dubai, UAE 430505<br>
                </address>
            </div>
			<div class="col-lg-3 ">
                <address>
				  <strong><span class="navy">ITforce Technology Beiijng</span></strong><br>
805 Soho Newtown, Jianguo Road, Chaoyang, Beijing<br>
China 100022<br>
                </address>
            </div>
           <div class="col-lg-3 ">
                <address>
                    <strong><span class="navy">ITforce Technology Hongkong</span></strong><br/>
                    Unit 04, 7/F, Bright Way Tower, No.33 <br/>
                    Mong Kok Road, Kowloon,<br>
Hong Kong<br/>
                    <abbr title="Phone">P:</abbr> +86 10 82769612
                </address>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="mailto:info@itforce-tech.com" class="btn btn-primary">Send us mail</a>
                <p class="m-t-sm">
                    Or follow us on social platform
                </p>
                <ul class="list-inline social-icon">
                    <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center m-t-lg m-b-lg">
                <p><strong>&copy; 2019 ITforce Technology</strong><br/> consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
            </div>
        </div>
    </div>
</section>

<script src="{{ URL::asset('landing/js/jquery-2.1.1.js') }}"></script>
<script src="{{ URL::asset('landing/js/pace.min.js') }}"></script>
<script src="{{ URL::asset('landing/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('landing/js/classie.js') }}"></script>
<script src="{{ URL::asset('landing/js/cbpAnimatedHeader.js') }}"></script>
<script src="{{ URL::asset('landing/js/wow.min.js') }}"></script>
<script src="{{ URL::asset('landing/js/inspinia.js') }}"></script>
</body>
</html>
