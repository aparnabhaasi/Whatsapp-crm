<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>WhatsApp CRM</title>
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/02RpgdM2/whatsapp3d.png">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="assets/css/ready.css">
	<link rel="stylesheet" href="assets/css/demo.css">

	<!-- bootstrap js -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	
	<!-- font awsome -->
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
		<!-- header -->
		@extends('layout.app')

		@section('content')
		
			<div class="main-panel">
				<div class="content">
					<div class="container-fluid">
					@if(session('error'))
					<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                        <p class="mb-0">{{ session('error') }}</p>
                        <a type="button" class="" data-bs-dismiss="alert" aria-label="Close" style="cursor:pointer; color:#fff;">X</a>
                    </div>
					@endif
						<h4 class="page-title">Dashboard</h4>
						<div class="row">
							
							<div class="col-md-3">
								<a href="chat" style="text-decoration: none;">
									<div class="card card-stats card-success" style="border-radius: 10px;">
										<div class="card-body ">
											<div class="row">
												<div class="col-5">
													<div class="icon-big text-center">
														<i class="fa-regular fa-message"></i>
													</div>
												</div>
												<div class="col-7 d-flex align-items-center">
													<div class="numbers">
														<p class="card-category">Chats</p>
														<h4 class="card-title">1,345</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>

							<div class="col-md-3">
								<a href="contacts" style="text-decoration: none;">
									<div class="card card-stats card-warning" style="border-radius: 10px;">
										<div class="card-body ">
											<div class="row">
												<div class="col-5">
													<div class="icon-big text-center">
														<i class="la la-users"></i>
													</div>
												</div>
												<div class="col-7 d-flex align-items-center">
													<div class="numbers">
														<p class="card-category">Contacts</p>
														<h4 class="card-title">1,294</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
							
							<div class="col-md-3">
								<a href="broadcast" style="text-decoration: none;">
									<div class="card card-stats card-danger" style="border-radius: 10px;">
										<div class="card-body">
											<div class="row">
												<div class="col-5">
													<div class="icon-big text-center">
														<i class="fa-solid fa-bullhorn"></i>
													</div>
												</div>
												<div class="col-7 d-flex align-items-center">
													<div class="numbers">
														<p class="card-category">Broadcasts</p>
														<h4 class="card-title">1303</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="col-md-3">
								<a href="template" style="text-decoration: none;">
									<div class="card card-stats card-primary" style="border-radius: 10px;">
										<div class="card-body ">
											<div class="row">
												<div class="col-5">
													<div class="icon-big text-center">
														<i class="fa-solid fa-file-invoice"></i>
													</div>
												</div>
												<div class="col-7 d-flex align-items-center">
													<div class="numbers">
														<p class="card-category">Message Template</p>
														<h4 class="card-title">76</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>	
							<div class="col-12 d-flex mb-1">
								<div class="form-group border rounded mr-1">
									<label for="pillInput1">Date from</label>
									<input type="date" class="form-control input-pill" id="pillInput1" placeholder="Eg: lead">
								</div>
								<div class="form-group border rounded">
									<label for="pillInput1">Date to</label>
									<input type="date" class="form-control input-pill" id="pillInput1" placeholder="Eg: lead">
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats" style="border-radius: 5px;">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center icon-warning">
													<i class="fa-regular fa-clock text-warning"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Pending Messages</p>
													<h4 class="card-title">250</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats" style="border-radius: 5px;">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="fa-regular fa-circle-check text-success"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Message Delivered</p>
													<h4 class="card-title">1,345</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats" style="border-radius: 5px;">
									<div class="card-body">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="fa-regular fa-circle-xmark text-danger"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Not Send</p>
													<h4 class="card-title">23</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats" style="border-radius: 5px;">
									<div class="card-body">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="fa-solid fa-reply-all text-primary"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Responses</p>
													<h4 class="card-title">1045</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row row-card-no-pd" style="border-radius: 20px;">
							<div class="col-md-4">
								<div class="card" >
									<div class="card-body">
										<div class="d-flex justify-content-between">
											<p class="fw-bold mt-1">Last Broadcast Message</p>
											<p class="nav-item ml-auto"><a class="btn btn-default btn-link" href="#"><i class="la la-refresh"></i> Refresh</a></p>
										</div>
										<h4><b>301</b></h4>
										<a href="broadcast" class="btn btn-primary btn-full text-left mt-3 mb-3"><i class="la la-plus"></i> Send new broadcast message</a>
									</div>
									<div class="card-footer">
										<p>Scheduled on 10-10-2024, 10:30 AM</p>
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="card">
									<div class="card-body">
										<div class="progress-card">
											<div class="d-flex justify-content-between mb-1">
												<span class="text-muted">Reply</span>
												<span class="text-muted fw-bold"> 28</span>
											</div>
											<div class="progress mb-2" style="height: 7px;">
												<div class="progress-bar bg-success" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="78%"></div>
											</div>
										</div>
										<div class="progress-card">
											<div class="d-flex justify-content-between mb-1">
												<span class="text-muted">Opened</span>
												<span class="text-muted fw-bold"> 76</span>
											</div>
											<div class="progress mb-2" style="height: 7px;">
												<div class="progress-bar bg-info" role="progressbar" style="width: 65%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="65%"></div>
											</div>
										</div>
										<div class="progress-card">
											<div class="d-flex justify-content-between mb-1">
												<span class="text-muted">Delivered</span>
												<span class="text-muted fw-bold"> 190</span>
											</div>
											<div class="progress mb-2" style="height: 7px;">
												<div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="70%"></div>
											</div>
										</div>
										<div class="progress-card">
											<div class="d-flex justify-content-between mb-1">
												<span class="text-muted">Pending</span>
												<span class="text-muted fw-bold"> 17</span>
											</div>
											<div class="progress mb-2" style="height: 7px;">
												<div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="60%"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card card-stats">
									<div class="card-body">
										<p class="fw-bold mt-1">Statistic</p>
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center icon-warning">
													<i class="fa-regular fa-clock text-warning"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Pending</p>
													<h4 class="card-title">17</h4>
												</div>
											</div>
										</div>
										<hr/>
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="fa-regular fa-circle-xmark text-danger"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Not Send</p>
													<h4 class="card-title">84</h4>
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
				<!-- footer -->

				
			</div>
	
	
</body>

<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/chartist/chartist.min.js"></script>
<script src="assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>
<script src="assets/js/demo.js"></script>

</html>