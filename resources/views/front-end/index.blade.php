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
														<p class="card-category">New Chats</p>
														<h4 class="card-title">{{ $countChats }}</h4>
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
														<h4 class="card-title">{{ $contctCount }}</h4>
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
														<h4 class="card-title">{{ $broadcastCount }}</h4>
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
														<h4 class="card-title">
															{{ $isTemplateCountFetched ? $templateCount : 'Not connected' }}
														</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
	
							
							<div class="col-12 border-bottom-cus mb-4">
								<style>
									.border-bottom-cus{
										border-bottom: 3px solid #e1e1e1;
									} 
								</style>
							</div>

							<div class="col-md-3">
								<div class="card card-stats" style="border-radius: 5px;">
									<div class="card-body ">
										<div class="row">
											<div class="col-4">
												<div class="icon-big text-center icon-warning">
													<i class="fa-brands fa-whatsapp text-success"></i>
												</div>
											</div>
											<div class="col-8 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Phone number</p>
													<h4 class="card-title">{{ $display_phone_number }}</h4>
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
											<div class="col-4">
												<div class="icon-big text-center">
													<i class="fa-regular fa-circle-check text-primary"></i>
												</div>
											</div>
											<div class="col-8 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Verified Name</p>
													<h4 class="card-title">{{$verified_name}}</h4>
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
											<div class="col-4">
												<div class="icon-big text-center">
													<i class="fa-regular fa-star text-warning"></i>
												</div>
											</div>
											<div class="col-8 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Quality Rating</p>
													<h4 class="card-title">{{ $quality_rating }}</h4>
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
											<div class="col-4">
												<div class="icon-big text-center">
													<i class="fa-solid fa-reply-all text-primary"></i>
												</div>
											</div>
											<div class="col-8 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Phone number status</p>
													<h4 class="card-title">{{ $code_verification_status }}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row row-card-no-pd" style="border-radius: 15px;">
							<div class="col-md-4">
								<div class="card" >
									<div class="card-body">
										<div class="d-flex justify-content-between">
											<p class="fw-bold mt-1">Last Broadcast Message</p>
											<p class="nav-item ml-auto"><a class="btn btn-default btn-link" href="#"><i class="la la-refresh"></i> Refresh</a></p>
										</div>
										<div class="d-flex justify-content-between">
											<h4><b>{{ $totalContacts }}</b></h4>
											<p>Sent on {{ $sentDate }}</p>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="card card-stats">
									<div class="card-body">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center icon-warning">
													<i class="fa-regular fa-clock text-warning"></i>
												</div>
											</div>
											<div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Send</p>
													<h4 class="card-title">{{ $acceptedCount }}</h4>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="card card-stats">
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
													<h4 class="card-title">{{ $rejectedCount }}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<a href="broadcast" class="btn btn-primary btn-full text-center mt-3 mb-3"><i class="la la-plus"></i> Send new <br> broadcast message</a>
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