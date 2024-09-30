<div class="main-header">
			<div class="logo-header">
				<a href="/" class="logo text-success align-items-center" style="text-decoration: none;">
					<img src="https://i.postimg.cc/02RpgdM2/whatsapp3d.png" alt="" width="30"><b>WhatsApp CRM</b   >
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
							.back-button, .forward-button {
								color: rgb(151, 151, 151);
								cursor: pointer;
								border: 1px solid rgb(171, 171, 171);
								background: rgb(252, 252, 252);
								padding: 10px 11px;
								border-radius: 50%;
							}
							.back-button:hover, .forward-button:hover {
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
					
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
					
						<li class="nav-item dropdown hidden-caret">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="la la-bell"></i>
								<span class="notification">3</span>
							</a>
							<ul class="dropdown-menu notif-box" aria-labelledby="navbarDropdown">
								<li>
									<div class="dropdown-title">You have 3 new notification</div>
								</li>
								<li>
									<div class="notif-center">
										<a href="#">
											<div class="notif-icon notif-primary"> <i class="la la-user-plus"></i> </div>
											<div class="notif-content">
												<span class="block">
													New user
												</span>
												<span class="time">5 minutes ago</span> 
											</div>
										</a>
										<a href="#">
											<div class="notif-icon notif-success"> <i class="la la-comment"></i> </div>
											<div class="notif-content">
												<span class="block">
													New message from 7 contacts
												</span>
												<span class="time">12 minutes ago</span> 
											</div>
										</a>
										<a href="#">
											<div class="notif-icon notif-danger"> <i class="la la-heart"></i> </div>
											<div class="notif-content">
												<span class="block">
													3 Interests
												</span>
												<span class="time">17 minutes ago</span> 
											</div>
										</a>
									</div>
								</li>
								<li>
									<a class="see-all" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="la la-angle-right"></i> </a>
								</li>
							</ul>
						</li>
						<li class="nav-item dropdown">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> <img src="assets/img/profile.jpg" alt="user-img" width="36" class="img-circle"><span >Name</span></span> </a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<div class="user-box">
										<div class="u-img"><img src="assets/img/profile.jpg" alt="user"></div>
										<div class="u-text">
											<h4>Name</h4>
											<a href="profile" class="btn btn-rounded btn-success btn-sm">View Profile</a>
										</div>
									</div>
								</li>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="settings"><i class="fa-solid fa-gears"></i> Setting</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="users"><i class="fas fa-users"></i> Users</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#"><i class="fa fa-power-off"></i> Logout</a>
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
							<img src="assets/img/profile.jpg">
						</div>
						<div class="info">
							<a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									Name
									<span class="user-level">Admin</span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample" aria-expanded="true" >
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
                                <i class="la la-dashboard"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('chat') ? 'active' : '' }}">
                            <a href="/chat">
                                <i class="fa-regular fa-comment-dots"></i>
                                <p>Chats</p>
								@if($unreadMessageCount > 0)
									<span class="badge badge-success">{{ $unreadMessageCount }}</span>
								@endif
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
						<div class="modal-header bg-warning" style="border-radius:30px 30px 0 0 !important;">
							<div>
								<h5 class="modal-title" id="exampleModalLongTitle"><b>Report an Issue <i class="fa-solid fa-triangle-exclamation" style="color: #ff0000;"></i></b></h5>
								<p class="text-light">Please provide the details of the problem</p>
							</div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body row p-5">
							<div class="form-group col-md-6">
								<label for="couponCode">Name<span class="text-danger">*</span></label>
								<input type="text" class="form-control input-pill" id="couponCode" name="coupon_code" placeholder="Enter your name" required>
							</div>
							<div class="form-group col-md-6">
								<label for="couponCode">Mobile Number<span class="text-danger">*</span></label>
								<input type="text" class="form-control input-pill" id="couponCode" name="coupon_code" placeholder="Enter your mobile number" required>
							</div>
							<div class="form-group col-md-12">
								<label for="couponCode">Email <span class="text-danger">*</span></label>
								<input type="text" class="form-control input-pill" id="couponCode" name="coupon_code" placeholder="Enter your email address" required>
							</div>
							<div class="form-group col-md-12">
								<label for="message">Describe the problem<span class="text-danger">*</span></label>
								<textarea class="form-control input-pill" id="message" name="message" rows="4" placeholder="Type here..." required></textarea>
							</div>
							<div class="form-group col-md-12">
								<label for="mediaUpload">Upload Screenshot</label>
								<div class="upload-area" id="uploadfile">
									<input type="file" id="fileInput" name="media" accept="image/*" required>
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
					</div>
				</div>
			</div>
						<!-- Support modal end -->