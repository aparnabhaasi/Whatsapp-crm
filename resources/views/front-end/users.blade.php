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

                <div class="content">
                	<div class="container-fluid">
	                    <div class="row">
	                        <div class="col-12">
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
							</div>
	                        <div class="col-12 mb-0">
								<divc class="card p-4" style="border-radius: 15px;">
									<div class="d-flex justify-content-between align-items-center">
										<div>
										    <h4 class="mb-0" data-toggle="modal" data-target="#messagingLimit" style="cursor: pointer;"><i class="fa-solid fa-users"></i> Users</h4>
    										<hr class="m-1">
    										<small class="mb-0 text-secondary">You can create users and assign role for performing tasks.</small>
										</div>
                                        <div>
                                            <button class="btn btn-outline-success ml-3" style="border-radius: 40px;" data-toggle="modal" data-target="#addUserModal">
                                                Add User <i class="fa-solid fa-user-plus"></i>
                                            </button>
                                        </div>
									</div>

								</divc>
							</div>
	
	                        <div class="col-12">
	
	                            <div class="card" style="border-radius: 15px;">
	                                
	                                <div class="card-body">
	                                    <div class="table-responsive">
	                                    	<table class="table table-hover">
		                                        <thead>
		                                            <tr class="bg-light">
		                                                <th scope="col">#</th>
		                                                <th scope="col">Name</th>
		                                                <th scope="col">Email</th>
		                                                <th scope="col" class="text-center">Role</th>
		                                                <th scope="col" class="text-center">Action</th>
		                                            </tr>
		                                        </thead>
		                                        <tbody>

												@foreach ($users as $user)
		                                            <tr>
		                                                <td>{{ $loop->iteration }}</td>
		                                                <td>{{ $user->name }}</td>
		                                                <td>{{ $user->email }}</td>
		                                                <td class="text-center">
															@foreach (json_decode($user->role, true) ?? [] as $role)
																<span class="badge badge-light">{{ $role }}</span>
															@endforeach
														</td>

		                                                <td class="text-center">
															<!-- <a href="" class="text-success" title="Assign Chats" data-toggle="modal" data-target="#assignChatModal{{$user->id}}">
																<i class="fa-solid fa-comments bg-light border rounded-circle p-2"></i>
		                                                    </a> -->
		                                                    <a href="" class="text-info" title="Edit" data-toggle="modal" data-target="#updateUserModal{{$user->id}}">
		                                                        <i class="fa fa-pen-to-square bg-light border rounded-circle p-2"></i>
		                                                    </a>
		                                                    <a href="" class="text-danger" title="Delete">
		                                                        <i class="fa fa-trash-can bg-light border rounded-circle p-2"></i>
		                                                    </a>
		                                                </td>
		                                            </tr>


													<!-- update user -->
													<div class="modal fade updateUserModal" id="updateUserModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h6 id="exampleModalLongTitle">Update {{$user->name}}</h6>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">

																<form action="{{ route('update.user', $user->id) }}" method="post" id="userForm">
																	@csrf
																	<div class="form-group">
																		<label for="name">Name</label>
																		<input type="text" class="form-control input-pill" id="name" name="name" 
																			value="{{$user->name}}" placeholder="Enter name" required>
																	</div>

																	<div class="form-group">
																		<label for="customPillSelect1">Select Roles</label>
																		<div id="roleSelection" class="px-4">
																			@php
																				$roles = json_decode($user->role, true) ?? [];
																			@endphp

																			<div class="form-check p-0">
																				<input class="form-check-input" type="checkbox" name="roles[]" id="admin" value="admin" 
																					{{ in_array('admin', $roles) ? 'checked' : '' }}>
																				<label class="form-check-label" for="admin">Admin (All access)</label>
																			</div>

																			<div class="form-check p-0">
																				<input class="form-check-input" type="checkbox" name="roles[]" id="user" value="chat manager" 
																					{{ in_array('chat manager', $roles) ? 'checked' : '' }}>
																				<label class="form-check-label" for="user">Chat Manager</label>
																			</div>

																			<div class="form-check p-0">
																				<input class="form-check-input" type="checkbox" name="roles[]" id="contact manager" value="contact manager" 
																					{{ in_array('contact manager', $roles) ? 'checked' : '' }}>
																				<label class="form-check-label" for="contact_manager">Contact Manager</label>
																			</div>

																			<div class="form-check p-0">
																				<input class="form-check-input" type="checkbox" name="roles[]" id="broadcast manager" value="broadcast manager" 
																					{{ in_array('broadcast manager', $roles) ? 'checked' : '' }}>
																				<label class="form-check-label" for="broadcast_manager">Broadcast Manager</label>
																			</div>

																			<div class="form-check p-0">
																				<input class="form-check-input" type="checkbox" name="roles[]" id="template manager" value="template manager" 
																					{{ in_array('template manager', $roles) ? 'checked' : '' }}>
																				<label class="form-check-label" for="template_manager">Template Manager</label>
																			</div>
																		</div>
																	</div>

																	<div class="form-group">
																		<label for="email">Email</label>
																		<input type="email" class="form-control input-pill" id="email" name="email" 
																			value="{{$user->email}}" placeholder="Eg: mail@domain.com" required>
																	</div>

																	<div class="form-group">
																		<label for="password">Password</label>
																		<input type="password" class="form-control input-pill" id="password" name="password" placeholder="* * * * * *" >
																	</div>

																	<div class="form-group">
																		<label for="confirmPassword">Confirm Password</label>
																		<input type="password" class="form-control input-pill" id="confirmPassword" name="confirmPassword" 
																			placeholder="* * * * * *" >
																		<small id="passwordError" class="text-danger d-none">Passwords do not match</small>
																	</div>

																	<div class="d-flex justify-content-end">
																		<button type="button" class="btn btn-danger mx-2" data-dismiss="modal">Cancel</button>
																		<button type="submit" class="btn btn-success">Save changes</button>
																	</div>
																</form>

																<script>
																	document.getElementById('userForm').addEventListener('submit', function (event) {
																		const password = document.getElementById('password').value;
																		const confirmPassword = document.getElementById('confirmPassword').value;
																		const errorElement = document.getElementById('passwordError');

																		if (password !== confirmPassword) {
																			event.preventDefault();  // Prevent form submission
																			errorElement.classList.remove('d-none');  // Show the error message
																		} else {
																			errorElement.classList.add('d-none');  // Hide the error message if passwords match
																		}
																	});
																</script>

																</div>
															</div>
														</div>
													</div>
												@endforeach
		                                            
		                                        </tbody>
		                                    </table>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
                </div>


				<!-- footer -->
			 	@endsection
			</div>


    <!-- Add user Modal -->
    <style>
        .custom-pill-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .custom-pill {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 25px;
            /* background-color: #007bff; */
            border: 2px solid #25D366;
            color: white;
            margin-right: 5px;
            color: #25D366;
        }
        .custom-pill .remove-pill {
            margin-left: 10px;
            cursor: pointer;
        }

		.form-check-input{
			left: 0px !important;
		}
    </style>
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<h6 id="exampleModalLongTitle">Add new user</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" action="{{ route('storeUser') }}">
					@csrf <!-- This adds a CSRF token for form submission in Laravel -->
					<div class="modal-body">
						<div class="form-group">
							<label for="nameInput">Name</label>
							<input type="text" name="name" class="form-control input-pill" id="nameInput" placeholder="Enter name">
						</div>

						<div class="form-group">
							<label for="customPillSelect1">Select Roles</label>
							<div id="roleSelection" class="px-4">
								<div class="form-check p-0">
									<input class="form-check-input" type="checkbox" name="roles[]" id="admin" value="admin">
									<label class="form-check-label" for="admin">Admin (All access)</label>
								</div>
								<div class="form-check p-0">
									<input class="form-check-input" type="checkbox" name="roles[]" id="user" value="chat manager">
									<label class="form-check-label" for="user">Chat Manager</label>
								</div>
								<div class="form-check p-0">
									<input class="form-check-input" type="checkbox" name="roles[]" id="contact_manager" value="contact manager">
									<label class="form-check-label" for="contact_manager">Contact Manager</label>
								</div>
								<div class="form-check p-0">
									<input class="form-check-input" type="checkbox" name="roles[]" id="broadcast_manager" value="broadcast manager">
									<label class="form-check-label" for="broadcast_manager">Broadcast Manager</label>
								</div>
								<div class="form-check p-0">
									<input class="form-check-input" type="checkbox" name="roles[]" id="template_manager" value="template manager">
									<label class="form-check-label" for="template_manager">Template Manager</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="emailInput">Email</label>
							<input type="text" name="email" class="form-control input-pill" id="emailInput" placeholder="Eg: mail@domain.com">
						</div>

						<div class="form-group">
							<label for="passwordInput">Password</label>
							<input type="password" name="password" class="form-control input-pill" id="passwordInput" placeholder="* * * * * *">
						</div>

						<div class="form-group">
							<label for="confirmPasswordInput">Confirm Password</label>
							<input type="password" name="password_confirmation" class="form-control input-pill" id="confirmPasswordInput" placeholder="* * * * * *">
							<small id="passwordMismatchError" class="text-danger" style="display:none;">Passwords do not match</small>
						</div>

						<div class="py-3 d-flex justify-content-end">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-success ml-2">Save changes</button>
						</div>
					</div>
				</form>

			<script>
				// Handle role selection logic (Admin disables others)
				const adminCheckbox = document.getElementById('admin');
				const otherCheckboxes = document.querySelectorAll('#roleSelection .form-check-input:not(#admin)');

				adminCheckbox.addEventListener('change', function () {
					if (this.checked) {
						otherCheckboxes.forEach(checkbox => {
							checkbox.checked = false;
							checkbox.disabled = true;
						});
					} else {
						otherCheckboxes.forEach(checkbox => {
							checkbox.disabled = false;
						});
					}
				});
			</script>

			</div>
        </div>
    </div>

	<!-- Chat asssign modal -->
	<!-- @foreach ($users as $user)
	
	
	<div class="modal fade assignChatModal" id="assignChatModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content" style="border-radius: 20px !important;">
			<div class="card mb-0" style="border-radius: 15px;">
				<h5 class="text-center mt-3">Assign Chats</h5>
				<div class="card-header d-md-flex justify-content-between">
					<div class="d-md-flex align-items-center">
						<form class="navbar-left navbar-form nav-search mr-md-3" action="">
							<style>
								.search-container {
									border: .5px solid transparent;
									border-radius: 30px;
									transition: border-color 0.3s;
								}
								.search-container:hover,
								.search-container:focus-within {
									border-color: #25D366 !important;
								}
							</style>
							<div class="input-group search-container">
								<input type="text" placeholder="Search ..." class="form-control search-input">
								<div class="input-group-append">
									<span class="input-group-text">
										<a href="" style="text-decoration: none;">
											<i class="la la-search search-icon text-success"></i>
										</a>
									</span>
								</div>
							</div>
						</form>
						
					</div>
					<button class="btn btn-outline-success my-1" style="border-radius: 30px;">
						<i class="fa-solid fa-filter"></i> <b>Filter</b>
					</button>
				</div>
				<form action="" method="post">
					@csrf
					<div class="card-body" style="height: 400px; overflow-y: auto;">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr class="bg-light">
										<th scope="col" style="width: 10px;">
											<label class="form-check-label">
												<input type="hidden" name="user_id" value="{{$user->id}}">
												<input id="selectAll" class="form-check-input d-none" type="checkbox" value="">
												<span class="form-check-sign"></span>
											</label>
										</th>
										<th scope="col">#</th>
										<th scope="col">Name</th>
										<th scope="col">Mobile</th>
										<th scope="col" class="text-center">Tags</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($contacts as $contact)
										<tr>
											<td>
												<label class="form-check-label">
													<input class="form-check-input row-checkbox d-none" type="checkbox" name="contact_id[]" value="{{ $contact->id }}" >
													<span class="form-check-sign"></span>
												</label>
											</td>
											<td>{{ $loop->iteration }}</td>
											<td>{{ $contact->name }}</td>
											<td>{{ $contact->mobile }}</td>
											<td class="text-center">
												@foreach (json_decode($contact->tags, true) ?? [] as $tag)
													<span class="badge badge-count">{{ $tag }}</span>
												@endforeach
											</td>										
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="p-3 d-flex justify-content-end bg-light">
						<button class="btn btn-success ml-3 px-5">Update</button>
					</div>
				</form>
			</div>
			<style>
				.cus-input:focus{
					border: 2px solid green;
				}
			</style>
			
		  </div>
		</div>
	</div>
	@endforeach

	<script>
		document.getElementById('selectAll').addEventListener('change', function() {
			// Get the state of the header checkbox
			const isChecked = this.checked;
			
			// Select all checkboxes with the class 'row-checkbox'
			const rowCheckboxes = document.querySelectorAll('.row-checkbox');
			
			// Set the checked state of all row checkboxes to match the header checkbox
			rowCheckboxes.forEach(function(checkbox) {
				checkbox.checked = isChecked;
			});
		});
	</script> -->
	<!-- Chat asssign modal -->


	<script>
		const passwordInput = document.getElementById('passwordInput');
		const confirmPasswordInput = document.getElementById('confirmPasswordInput');
		const errorElement = document.getElementById('passwordMismatchError');

		// Function to check if passwords match
		function checkPasswords() {
			if (confirmPasswordInput.value !== passwordInput.value) {
				errorElement.style.display = 'block'; // Show error message
			} else {
				errorElement.style.display = 'none'; // Hide error message
			}
		}

		// Add event listener only to the confirm password field
		confirmPasswordInput.addEventListener('input', checkPasswords);
	</script>


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