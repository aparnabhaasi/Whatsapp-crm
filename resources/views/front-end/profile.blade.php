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

	<!-- font awsome -->
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
		<!-- header -->
		 @extends('layout.app')

		 @section('content')
		 			
			<div class="main-panel">
				<div class="content pb-0">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12 mb-0">
								<divc class="card p-4" style="border-radius: 15px;">
									<div class="d-flex justify-content-between align-items-center">
										<div>
										    <h4 class="mb-0" data-toggle="modal" data-target="#messagingLimit" style="cursor: pointer;"><i class="fa-regular fa-user"></i> Profile</h4>
    										<hr class="m-1">
    										<small class="mb-0 text-secondary">Update your profile information to personalize your WhatsApp experience using the WhatsApp API.</small>
										</div>
                                        <div>
                                            <img src="assets/img/profile.jpg" alt="" width="70" style="border-radius: 50%;">
                                        </div>
									</div>

								</divc>
							</div>
						</div>
                        

                        <div class="row">

                            <div class="col-md-6 d-flex">
                                <div class="card p-4 w-100" style="border-radius: 15px;">
                                    <div class="form-group">
                                        <label for="pillInput1">Name</label>
                                        <input type="text" class="form-control input-pill" id="pillInput1" placeholder="Enter name">
                                    </div>
                                    <div class="form-group">
                                        <label for="pillInput2">Company Name</label>
                                        <input type="text" class="form-control input-pill" id="pillInput2" placeholder="Enter company name">
                                    </div>
                                    <div class="form-group">
                                        <label for="pillInput3">Contact Number</label>
                                        <input type="text" class="form-control input-pill" id="pillInput3" placeholder="Enter contact number">
                                    </div>
                                    <div class="form-group">
                                        <label for="pillInput4">Email address</label>
                                        <input type="text" class="form-control input-pill" id="pillInput4" placeholder="Enter email address">
                                    </div>

                                    <div class="text-center mt-3">
                                        <button class="btn btn-success">Save changes</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 d-flex">
                                <div class="card p-4 w-100" style="border-radius: 15px;">
                                    <h6>Reset Password</h6>
                                    <hr>
                                    <div class="form-group">
                                        <label for="pillInput1">Current Password</label>
                                        <input type="password" class="form-control input-pill" id="pillInput1" placeholder="* * * * * *">
                                    </div>
                                    <div class="form-group">
                                        <label for="pillInput1">New Password</label>
                                        <input type="password" class="form-control input-pill" id="pillInput1" placeholder="* * * * * *">
                                    </div>
                                    <div class="form-group">
                                        <label for="pillInput1">confirm New Password</label>
                                        <input type="password" class="form-control input-pill" id="pillInput1" placeholder="* * * * * *">
                                    </div>

                                    <div class="text-center mt-3">
                                        <button class="btn btn-success">Update Password</button>
                                    </div>
                                </div>                                
                            </div>

                        </div>
					</div>
				</div>
                <div class="text-center mb-3">
					<a href="privacy-policy" style="color: #25D366;"><h6>Privacy Policy</h6></a>
				</div>
                <!-- footer -->
				@endsection
			</div>
			

</body>


<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/chartist/chartist.min.js"></script>
<script src="assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<!-- <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script> -->
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>
<script src="assets/js/demo.js"></script>
</html>