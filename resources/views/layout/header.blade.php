	<!-- <style>
        /* Preloader container styles */
        .preloader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 9999;
        }

        /* Text styles */
        .preloader-text {
            font-size: 20px;
            color: #444;
            margin-bottom: 15px;
            font-family: Arial, sans-serif;
        }

        /* Progress bar container styles */
        .progress-bar-container {
            width: 80%;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            height: 10px;
        }

        /* Progress bar styles */
        .progress-bar {
            width: 0;
            height: 100%;
            background-color: #25D366; /* WhatsApp green color */
            animation: loadingAnimation 2s infinite;
        }

        /* Keyframes for progress bar animation */
        @keyframes loadingAnimation {
            0% { width: 0; }
            50% { width: 75%; }
            100% { width: 100%; }
        }
    </style> -->
	<!-- Preloader -->
	<!-- <div class="preloader-container" id="preloader">
		<div class="preloader-text">Loading...</div>
		<div class="progress-bar-container">
			<div class="progress-bar"></div>
		</div>
	</div> -->
	<script>
		// Remove the preloader after the page has fully loaded
		window.onload = function() {
			var preloader = document.getElementById('preloader');
			preloader.style.display = 'none';
		};
	</script>

	<div class="main-header">
		<div class="logo-header">
			<a href="/" class="logo text-success align-items-center" style="text-decoration: none;">
				<!-- <img src="{{ asset('assets/img/logo-dark.png')}}" alt="" width="30"> -->
				<img src="https://i.postimg.cc/02RpgdM2/whatsapp3d.png" alt="" width="30"><b>WhatsApp CRM</b>
			</a>
			<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
		</div>
		<nav class="navbar navbar-header navbar-expand-lg">
			<div class="container-fluid">
				<!-- back button start-->
				<div>
					<style>
						.back-button,
						.forward-button {
							color: rgb(151, 151, 151);
							cursor: pointer;
							border: 1px solid rgb(171, 171, 171);
							background: rgb(252, 252, 252);
							padding: 10px 11px;
							border-radius: 50%;
						}

						.back-button:hover,
						.forward-button:hover {
							background: rgb(238, 238, 238);
						}

						.hidden {
							display: none;
						}
					</style>
					<i class="fa-solid fa-arrow-left back-button" onclick="goBack()"></i>
					<i class="fa-solid fa-arrow-right forward-button hidden" onclick="goForward()"></i>
					<script>
						function goBack() {
							window.history.back();
						}

						function goForward() {
							window.history.forward();
						}

						function updateForwardButtonVisibility() {
							const forwardButton = document.querySelector('.forward-button');
							const hasForwardHistory = window.history.length > 1; // Adjust condition as needed

							if (hasForwardHistory) {
								forwardButton.classList.remove('hidden');
							} else {
								forwardButton.classList.add('hidden');
							}
						}

						// Check forward button visibility on page load
						window.onload = updateForwardButtonVisibility;

						// Optionally, also check on history changes
						window.addEventListener('popstate', updateForwardButtonVisibility);
					</script>
				</div>
				<!-- back button end-->
				<style>
					.notif-box {
						display: none;
						/* Hide initially */
					}
				</style>
				<!-- <script>
						const BASE_URL = "{{ url('') }}";

						function fetchUnreadMessagesCount() {
							$.ajax({
								url: `${BASE_URL}/unread-messages-count`,
								type: 'GET',
								success: function(response) {
									const unreadCount = response.unreadCount;

									// Update the notification count in the dropdown
									if (unreadCount > 0) {
										$('.notification').text(unreadCount);
										$('.contact-count').text(unreadCount); // Update contact count text
										$('#navbarDropdown').show();
										$('#unread-badge').text(unreadCount).show(); // Show and update badge
									} else {
										$('.notification').text(0);
										$('#navbarDropdown').hide();
										$('#unread-badge').hide(); // Hide badge if no unread messages
									}
								}
							});
						}

						// Show/hide notification box when clicking the notification icon
						$(document).ready(function() {
							fetchUnreadMessagesCount();
							setInterval(fetchUnreadMessagesCount, 3000); // Update every 10 seconds

							$('#navbarDropdown').on('click', function(event) {
								event.preventDefault(); // Prevent default anchor behavior
								$('.notif-box').toggle(); // Toggle visibility of notif-box
							});

							// Optional: Close the notif-box if clicked outside
							$(document).on('click', function(event) {
								if (!$(event.target).closest('#navbarDropdown').length && !$(event.target).closest('.notif-box').length) {
									$('.notif-box').hide();
								}
							});
						});


					</script> -->

				<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">

					<li class="nav-item dropdown hidden-caret">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="la la-bell"></i>
							<span class="notification">1</span>
						</a>
						<ul class="dropdown-menu notif-box" aria-labelledby="navbarDropdown">
							<li>
								<div class="dropdown-title">You have a new notification</div>
							</li>
							<li>
								<div class="notif-center">
									<a href="chat">
										<div class="notif-icon notif-success"> <i class="la la-comment"></i> </div>
										<div class="notif-content">
											<span class="block">
												New message from <span class="contact-count"></span> contacts
											</span>
											<span class="time">Just now</span>
										</div>
									</a>
								</div>
							</li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
							<img src="{{ $profile_picture_url ?? asset('assets/img/profile.jpg') }}" alt="user-img" width="36" class="img-circle">
							<span>{{ Auth::user()->name }}</span>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li>
								<div class="user-box">
									<div class="u-img">
										<img src="{{ $profile_picture_url ?? asset('assets/img/profile.jpg') }}" alt="user">
									</div>

									<div class="u-text">
										<h4>{{ Auth::user()->name }}</h4>
										<a href="profile" class="btn btn-rounded btn-success btn-sm">View Profile</a>
									</div>
								</div>
							</li>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="settings"><i class="fa-solid fa-gears"></i> Setting</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="users"><i class="fas fa-users"></i> Users</a>
							<div class="dropdown-divider"></div>
							<form action="{{route('logout')}}" method="post">
								@csrf
								<button class="dropdown-item text-danger" style="cursor:pointer;">
									<i class="fa fa-power-off"></i> Logout
								</button>
							</form>
						</ul>
						<!-- /.dropdown-user -->
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="sidebar">
		<div class="scrollbar-inner sidebar-wrapper">
			<div class="user">
				<div class="photo">
					<img src="{{ $profile_picture_url ?? asset('assets/img/profile.jpg') }}">
				</div>
				<div class="info">
					<a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
						<span>
							{{ Auth::user()->name ?? 'Guest' }}
							<span class="user-level">{{ Auth::user()->role == 'admin' ? 'Admin' : 'User' }}</span>
							<span class="caret"></span>
						</span>
					</a>
					<div class="clearfix"></div>

					<div class="collapse in" id="collapseExample" aria-expanded="true">
						<ul class="nav">
							<li>
								<a href="profile" class="text-white">
									<p class="link-collapse"><i class="fa-regular fa-user"></i>&nbsp; <b>Profile</b></p>
								</a>
							</li>
							<li>
								<a href="users" class="text-white">
									<p class="link-collapse"><i class="fa-solid fa-users"></i>&nbsp; <b>Users</b></p>
								</a>
							</li>
							<li>
								<a href="settings" class="text-white">
									<p class="link-collapse"><i class="fa-solid fa-gears"></i>&nbsp; <b>Settings</b></p>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<ul class="nav">
				<li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
					<a href="/">
						<i class="fa-solid fa-chart-pie"></i>
						<p>Dashboard</p>
					</a>
				</li>
				<li class="nav-item {{ request()->is('chat') ? 'active' : '' }}">
					<a href="/chat">
						<i class="fa-regular fa-comment-dots"></i>
						<p>Chats</p>
						<span id="unread-badge" class="badge badge-success" style="display: none;">0</span>
					</a>
				</li>
				<li class="nav-item {{ request()->is('contacts') ? 'active' : '' }}">
					<a href="/contacts">
						<i class="fa-solid fa-user-group"></i>
						<p>Contacts</p>
						<!-- <span class="badge badge-count">50</span> -->
					</a>
				</li>
				<li class="nav-item {{ request()->is('broadcast') ? 'active' : '' }}">
					<a href="/broadcast">
						<i class="fa-solid fa-tower-broadcast"></i>
						<p>Broadcasts</p>
						<!-- <span class="badge badge-count">6</span> -->
					</a>
				</li>
				<li class="nav-item {{ request()->is('template') ? 'active' : '' }}">
					<a href="/template">
						<i class="fa-solid fa-object-group"></i>
						<p>Message Template</p>
						<!-- <span class="badge badge-count">5</span> -->
					</a>
				</li>
				<li class="nav-item update-pro mt-5 pt-5">
					<a href="" data-toggle="modal" data-target=".supportModal" class="btn btn-primary" style="border-radius:50px;">
						<i class="fa-solid fa-headset"></i>
						<p>Get Support</p>
					</a>
				</li>
			</ul>
		</div>
	</div>


	<!-- Supprot modal start -->
	<style>
		.upload-area {
			border: 2px dashed #ccc;
			border-radius: 20px;
			background-color: #f9f9f9;
			text-align: center;
			padding: 0px;
			cursor: pointer;
			transition: background-color 0.3s ease;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			position: relative;
		}

		.upload-area:hover {
			background-color: #f1f1f1;
		}

		.upload-text {
			color: #888;
		}

		.upload-icon {
			font-size: 40px;
			color: #888;
			margin-bottom: 10px;
		}

		#fileInput {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			opacity: 0;
			cursor: pointer;
		}
	</style>
	<div class="modal fade supportModal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content" style="border-radius:30px !important;">
				<div class="modal-header" style="border-radius:30px 30px 0 0 !important;">
					<div>
						<h4 class="modal-title ms-4" id="exampleModalLongTitle"><b>Report an Issue <i class="fa-solid fa-triangle-exclamation" style="color: #ff0000;"></i></b></h4>
						<p class="">Please provide the details of the problem</p>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="{{ route('store.tickets') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-body row p-5">
						<div class="form-group col-md-6">
							<label for="couponCode">Name<span class="text-danger">*</span></label>
							<input type="text" class="form-control input-pill" id="couponCode" name="name" placeholder="Enter your name" required>
						</div>
						<div class="form-group col-md-6">
							<label for="couponCode">Mobile Number<span class="text-danger">*</span></label>
							<input type="text" class="form-control input-pill" id="couponCode" name="mobile" placeholder="Enter your mobile number" required>
						</div>
						<div class="form-group col-md-6">
							<label for="couponCode">Email <span class="text-danger">*</span></label>
							<input type="text" class="form-control input-pill" id="couponCode" name="email" placeholder="Enter your email address" required>
						</div>
						<div class="form-group col-md-6">
							<label for="couponCode">CRM ID <span class="text-danger">*</span> <small> [You can find this in settings page]</small></label>
							<input type="text" class="form-control input-pill" id="couponCode" name="app_id" placeholder="Enter your CRM ID" required>
						</div>
						<div class="form-group col-md-12">
							<label for="message">Describe the problem<span class="text-danger">*</span></label>
							<textarea class="form-control input-pill" id="message" name="description" rows="4" placeholder="Type here..." required></textarea>
						</div>
						<div class="form-group col-md-12">
							<label for="mediaUpload">Upload Screenshot</label>
							<div class="upload-area" id="uploadfile">
								<input type="file" id="fileInput" name="img" accept="image/*">
								<div class="upload-text">
									<i class="fa fa-cloud-upload upload-icon"></i>
									<p id="fileName">Upload a File</p>
								</div>
							</div>
						</div>
						<script>
							document.getElementById('fileInput').addEventListener('change', function() {
								// Get the file name
								const fileName = this.files[0] ? this.files[0].name : "Upload a File";

								// Display the file name in the p tag
								document.getElementById('fileName').textContent = fileName;
							});
						</script>
						<div class="col-12 text-center mt-4">
							<button class="btn btn-primary w-75 py-3" style="border-radius:50px;"><b>Submit</b>&nbsp; <i class="fa-solid fa-arrow-right-long"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>