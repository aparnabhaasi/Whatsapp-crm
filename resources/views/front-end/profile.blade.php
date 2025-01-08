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
				<div class="content pb-0">
					<div class="container-fluid">
                        @if(session('success'))
							<div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
								<p class="mb-0">{{ session('success') }}</p>
								<a type="button" class="" data-bs-dismiss="alert" aria-label="Close" style="cursor:pointer; color:#fff;">X</a>
							</div>
						@endif
						@if(session('error'))
							<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
								<p class="mb-0">{{ session('error') }}</p>
								<a type="button" class="" data-bs-dismiss="alert" aria-label="Close" style="cursor:pointer; color:#fff;">X</a>
							</div>
						@endif
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
                                            <img src="{{ $profile_picture_url }}" alt="" width="70" style="border-radius: 50%;">
                                        </div>
									</div>

								</divc>
							</div>
						</div>
                        
                        <div class="row">

                            <div class="col-12 d-flex">
                                <div class="card p-4 w-100" style="border-radius: 15px;">
                                    <h6>WhatsApp Profile Details</h6>
                                    <form method="post" action="{{ route('update.profile') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class='row'>
                                            <div class="form-group col-md-6">
                                                <label for="pillInput1">Verified Name</label>
                                                <input type="text" value="{{ $verified_name }}" class="form-control input-pill" id="pillInput1" placeholder="Enter display name" readonly>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pillInput1">Update profile picture</label>
                                                <small>[Please upload JPG image of resolution greater than 192 pixel * 192 pixel]</small>
                                                <input type="file" name="profile_picture" class="form-control input-pill" id="pillInput1" placeholder="Enter display name" >
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pillInput2">About</label>
                                                <input type="text" name="about" value="{{ $about }}" class="form-control input-pill" id="pillInput2" placeholder="About you" >
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pillInput3">Description</label>
                                                <input type="text" name="description" value="{{ $description }}" class="form-control input-pill" id="pillInput3" placeholder="Enter description" >
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pillInput4">Website</label>
                                                <input type="text" name="website" value="{{ $websites }}" class="form-control input-pill" id="pillInput4" placeholder="eg: https://ictglobaltech.com/" >
                                            </div>
                                        </div>
    
                                        <div class="text-center mt-3">
                                            <button class="btn btn-success">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-6 d-flex">
                                <div class="card p-4 w-100" style="border-radius: 15px;">
                                    <h6>CRM Profile Details</h6>
                                    <form method="post" action="{{ route('update.basic') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="pillInput1">Name</label>
                                            <input type="text" name="name" value="{{ $user->name }}" class="form-control input-pill" id="pillInput1" placeholder="Enter name">
                                        </div>
                                        <div class="form-group">
                                            <label for="pillInput3">Contact Number</label>
                                            <input type="text" name="mobile" value="{{ $user->mobile }}" class="form-control input-pill" id="pillInput3" placeholder="Enter contact number">
                                        </div>
                                        <div class="form-group">
                                            <label for="pillInput4">Email address</label>
                                            <input type="text" name="email" value="{{ $user->email }}" class="form-control input-pill" id="pillInput4" placeholder="Enter email address">
                                        </div>
    
                                        <div class="text-center mt-3">
                                            <button type="submi" class="btn btn-success">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-6 d-flex">
                                <div class="card p-4 w-100" style="border-radius: 15px;">
                                    <h6>Reset Password</h6>
                                    <hr>
                                    <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="currentPassword">Current Password</label>
                                            <input type="password" name="current_password" class="form-control input-pill" id="currentPassword" placeholder="* * * * * *" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="newPassword">New Password</label>
                                            <input type="password" name="new_password" class="form-control input-pill" id="newPassword" placeholder="* * * * * *" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmPassword">Confirm New Password</label>
                                            <input type="password" name="new_password_confirmation" class="form-control input-pill" id="confirmPassword" placeholder="* * * * * *" required>
                                            <small id="passwordMismatch" class="text-danger" style="display: none;">Passwords do not match!</small>
                                        </div>

                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-success" id="updatePasswordBtn" disabled>Update Password</button>
                                        </div>
                                    </form>
                                </div>

                                <script>
                                    const newPasswordInput = document.getElementById('newPassword');
                                    const confirmPasswordInput = document.getElementById('confirmPassword');
                                    const passwordMismatchMessage = document.getElementById('passwordMismatch');
                                    const updatePasswordBtn = document.getElementById('updatePasswordBtn');

                                    // Function to check if passwords match
                                    function checkPasswords() {
                                        // Only check when typing in the confirm password field
                                        if (confirmPasswordInput.value) {
                                            if (newPasswordInput.value !== confirmPasswordInput.value) {
                                                passwordMismatchMessage.style.display = 'block';
                                                updatePasswordBtn.disabled = true;
                                            } else {
                                                passwordMismatchMessage.style.display = 'none';
                                                updatePasswordBtn.disabled = false;
                                            }
                                        } else {
                                            // Hide the message when the confirm password field is empty
                                            passwordMismatchMessage.style.display = 'none';
                                            updatePasswordBtn.disabled = true; // Disable button until both passwords are filled
                                        }
                                    }

                                    // Attach event listener to the confirm password input
                                    confirmPasswordInput.addEventListener('input', checkPasswords);
                                </script>

                            </div>
                        </div>
					</div>
				</div>
                <form action="{{ route('logout') }}" method="post" class="text-center mb-3">
                    @csrf
					<button href="{{ route('logout') }}" class="btn btn-outline-danger px-5" style="border-radius:50px;">Log out <i class="fa fa-power-off"></i></button>
				</form>
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