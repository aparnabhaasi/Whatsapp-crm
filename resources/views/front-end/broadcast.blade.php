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
							<div class="col-12">
								<h5 class="text-center">Broadcast Messaging</h5>
							</div>
							<div class="col-12 mb-0">
								<divc class="card p-4" style="border-radius: 15px;">
									<div class="d-flex justify-content-between align-items-center">
										<div>
											<h6 class="mb-0" data-toggle="modal" data-target="#messagingLimit" style="cursor: pointer;">Messaging Limit <i class="fa-solid fa-circle-question"></i></h6>
											<hr class="m-1">
											<p class="mb-0">1000 Customers/24 hours</p>
										</div>
										<div>
											<button class="btn btn-success p-3" data-toggle="modal" data-target=".newBroadcastMessage" style="border-radius: 30px; font-size: 15px; font-weight: 600;">
												New Broadcast Message <i class="fa-regular fa-paper-plane"></i>
											</button>
										</div>
									</div>

								</divc>
							</div>
							<div class="col-12">
								<div class="card" style="border-radius: 15px;">
	                                <div class="card-header ">
	                                    <div class="d-flex align-items-center justify-content-between">
	                                    	<div class="d-flex align-items-center">
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
												<button class="btn btn-outline-success my-1" style="border-radius: 30px;">
													<i class="fa-solid fa-filter"></i> <b>Filter</b>
												</button>
	                                    	</div>
		                                    
											<div class="align-items-center d-flex">
												<button class="btn btn-outline-success" data-toggle="modal" data-target=".bd-example-modal-xl">Add New Broadcast Group <i class="fa-solid fa-user-group"></i></button>
											</div>
	                                    </div>

	                                </div>
	                                <div class="card-body">
	                                    <div class="table-responsive">
	                                    	<table class="table table-hover">
		                                        <thead>
		                                            <tr class="bg-light">
		                                                <th scope="col">#</th>
		                                                <th scope="col">Broadcast Name</th>
		                                                <!-- <th scope="col">Scheduled at</th> -->
		                                                <th scope="col" class="text-center">Recipients</th>
		                                                <th scope="col" class="text-center">Sent</th>
														<th scope="col" class="text-center">Failed</th>
														<th scope="col">Status</th>
		                                                <th scope="col" class="text-center">Action</th>
		                                            </tr>
		                                        </thead>
		                                        <tbody>
													@foreach ($broadcasts as $broadcast)
														<tr>
															<td>{{ $loop -> iteration }}</td>
															<td>{{ $broadcast -> broadcast_name }}</td>
															<!-- <td>{{ $broadcast->scheduled_at ? $broadcast->scheduled_at : 'Not scheduled' }}</td> -->
															<td class="text-center">{{ count($broadcast->contact_id) }}</td>
															<td class="text-center">0</td>
															<td class="text-center">0</td>
															<td><span class="badge badge-primary">No messages</span></td>
															<td class="text-center">
																<a href="" class="text-dark" data-toggle="modal" data-target=".updateBroadcast" title="Edit Broadcast Group">
																	<i class="fa-solid fa-pen bg-light border rounded-circle p-2"></i>
																</a>
																<a href="" class="text-danger"  title="Delete Broadcast Group">
																	<i class="fa-regular fa-trash-can bg-light border rounded-circle p-2"></i>
																</a>
															</td>
														</tr>
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


	<!--==== New Broadcast Message start ====-->
<style>
    .input-pill:focus {
        border-color: #25D366;
    }
</style>
<!-- first step -->
<form method="post" action="{{ route('broadcast.message') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade newBroadcastMessage" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-dark" id="exampleModalLongTitle" style="font-weight: 700;">New Broadcast
                        Message <i class="fa-solid fa-bullhorn text-secondary"></i></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Broadcast Group Selection -->
                    <div class="form-group">
                        <label for="pillSelect1">Select Broadcast Group</label>
                        <select class="form-control input-pill " id="pillSelect1" name="broadcast_group">
                            @foreach ($broadcasts as $broadcast)
                                <option value="{{ $broadcast->id }}"
                                    data-contact-count="{{ count($broadcast->contact_id) }}">{{ $broadcast->broadcast_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Template Selection -->
                    <div class="form-group">
                        <label for="pillSelect2">Select Template</label>
                        <select class="form-control input-pill" id="pillSelect2">
                            <option value="" disabled selected>Select a pre-approved template</option>
                            @foreach ($allTemplates as $template)
                                <option value="{{ json_encode($template) }}">{{ $template['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Hidden input to store the template ID -->
                    <input type="hidden" id="templateId" name="message_template">

                    <!-- Placeholder for dynamic inputs -->
                    <div id="dynamic-inputs"></div>

                    <div class="modal-footer">
                        <a href="" type="button" class="btn btn-secondary px-5">Cancel</a>
                        <button type="button" id="nextButton" class="btn btn-success py-2 px-5" data-dismiss="modal"
                            data-toggle="modal" data-target=".broadCastPreview">Next <i
                                class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- second step -->
    <style>
        .mesages-card-container {
            background-image: url(assets/img/chat-bg-yellow.png);
            background-size: cover;
            padding: 30px;
            margin-bottom: 8px;
            border-radius: 10px;
        }

        .message-card {
            background: #fff;
            padding: 8px;
            border-radius: 0px 15px 15px 15px;
        }

        .message-card img {
            width: 100%;
            border-radius: 10px;
        }

        .message-card p,
        a {
            font-family: Helvetica, Arial, sans-serif;
        }

        .cancel-btn,
        .submit-btn {
            font-size: 16px;
            border: 1px solid;
            border-radius: 10px;
            font-weight: 800;
        }

        .b2 {
            font-weight: 700;
        }

        /* Custom styles for document preview */
        .custom-document-link {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .custom-monospace {
            font-family: monospace;
        }
    </style>
    <div class="modal fade broadCastPreview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-dark" id="exampleModalLongTitle" style="font-weight: 700;">Broadcast
                        Preview <i class="fa-solid fa-bullhorn text-secondary"></i></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Message Preview -->
                        <div class="col-md-6">
                            <div class="mesages-card-container">
                                <div class="message-card">
                                    <img src="" alt="">
                                    <p class="mt-3"></p>
                                    <div id="buttons-container" class="text-center">
                                        <!-- Buttons will be dynamically inserted here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Overview and Actions -->
                        <div class="col-md-6">
                            <h5><b>Overview</b></h5>
                            <hr>
                            <h6>Broadcast Name: <span class="b2" id="selectedBroadcastName">Broadcast 1</span></h6>
                            <hr>
                            <h6>Message Template: <span class="b2" id="selectedTemplateName">Template 1</span></h6>
                            <hr>
                            <h6>Sending to: <span class="b2" id="selectedContactCount">0 Contacts</span></h6>
                            <hr>

                            <div class="p-3">
                                <button class="btn btn-outline-secondary w-100 mb-2 cancel-btn" data-dismiss="modal"
                                    data-toggle="modal" data-target=".newBroadcastMessage"><i
                                        class="fa-solid fa-arrow-left"></i> Back</button>
                                <button type="submit" class="btn btn-primary w-100 submit-btn">Send <i
                                        class="fa-regular fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<!-- JavaScript Code -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const broadcastSelect = document.getElementById('pillSelect1');
        const templateSelect = document.getElementById('pillSelect2');
        const dynamicInputsContainer = document.getElementById('dynamic-inputs');
        const messageCard = document.querySelector('.message-card');
        const messageImage = messageCard.querySelector('img');
        const messageText = messageCard.querySelectorAll('p');
        const buttonsContainer = document.getElementById('buttons-container');
        const nextButton = document.getElementById('nextButton');
        const templateIdInput = document.getElementById('templateId');

        // Function to update the broadcast details in the preview
        function updateBroadcastDetails() {
            const selectedBroadcastOption = broadcastSelect.options[broadcastSelect.selectedIndex];
            const selectedBroadcastName = selectedBroadcastOption.text; // Get the name of the broadcast
            const contactCount = selectedBroadcastOption.getAttribute('data-contact-count');

            // Update broadcast name and contact count in the preview modal
            document.getElementById('selectedBroadcastName').textContent = selectedBroadcastName; // Display the broadcast name
            document.getElementById('selectedContactCount').textContent = `${contactCount} Contacts`;
        }

        // Update broadcast details when the broadcast group changes
        broadcastSelect.addEventListener('change', updateBroadcastDetails);

        // Template selection change event
        templateSelect.addEventListener('change', function () {
            dynamicInputsContainer.innerHTML = ''; // Clear previous inputs
            messageCard.querySelectorAll('.message-video, .custom-document-link').forEach(el => el.remove()); // Clear additional previews
            buttonsContainer.innerHTML = ''; // Clear previous buttons
            messageImage.style.display = 'none'; // Hide image preview
            messageText[0].innerHTML = ''; // Clear message text

            const selectedOption = this.options[this.selectedIndex];
            let templateData;
            try {
                templateData = JSON.parse(selectedOption.value);
            } catch (error) {
                console.error('Error parsing template JSON:', error);
                return;
            }

            // Update template ID and name in the preview
            templateIdInput.value = templateData.id;
            document.getElementById('selectedTemplateName').textContent = templateData.name;

            if (templateData.components) {
                templateData.components.forEach((component) => {
                    if (component.type === 'HEADER' && component.format) {
                        createHeaderInput(component);
                    }

                    if (component.type === 'BODY' && component.text) {
                        createBodyInputs(component.text);
                        updateBodyPreview(component.text);
                    }

                    if (component.type === 'BUTTONS' && component.buttons) {
                        createButtons(component.buttons);
                        createCouponInput(component.buttons);
                    }
                });
            }
        });

        // Function to create the header input
        function createHeaderInput(component) {
            let inputType = '';
            let acceptType = '';
            let labelText = `Upload ${component.format}`;

            if (component.format === 'IMAGE') {
                inputType = 'file';
                acceptType = 'image/*';
            } else if (component.format === 'VIDEO') {
                inputType = 'file';
                acceptType = 'video/*';
            } else if (component.format === 'DOCUMENT') {
                inputType = 'file';
                acceptType = '.pdf';
                labelText = 'Upload Document';
            }

            if (inputType) {
                // Create elements
                const formGroup = document.createElement('div');
                formGroup.className = 'form-group';

                const label = document.createElement('label');
                label.innerHTML = `${labelText} (<span class="text-danger">Required*</span>)`;

                const input = document.createElement('input');
                input.type = inputType;
                input.className = 'form-control input-pill';
                input.name = 'media';
                input.accept = acceptType;
                input.id = 'headerInput';
                input.required = true;

                // Append elements
                formGroup.appendChild(label);
                formGroup.appendChild(input);
                dynamicInputsContainer.appendChild(formGroup);

                // Add event listener
                input.addEventListener('change', handleHeaderPreview);
            }
        }

        // Function to create body inputs
        function createBodyInputs(text) {
            const variableMatches = text.match(/\{\{\d+\}\}/g);
            if (variableMatches) {
                variableMatches.forEach((variable, index) => {
                    // Create elements
                    const formGroup = document.createElement('div');
                    formGroup.className = 'form-group';

                    const label = document.createElement('label');
                    label.setAttribute('for', `variable${index + 1}`);
                    label.innerHTML = `Variable ${index + 1} (<span class="text-danger">Required*</span>)`;

                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'variables[]';
                    input.className = 'form-control input-pill';
                    input.id = `variable${index + 1}`;
                    input.placeholder = `Enter value for ${variable}`;
                    input.required = true;

                    // Append elements
                    formGroup.appendChild(label);
                    formGroup.appendChild(input);
                    dynamicInputsContainer.appendChild(formGroup);

                    // Add event listener
                    input.addEventListener('input', updateBodyPreview.bind(null, text));
                });
            }
        }

        // Function to update the body preview
        function updateBodyPreview(text) {
            let updatedText = text;
            const variableMatches = text.match(/\{\{\d+\}\}/g);

            if (variableMatches) {
                variableMatches.forEach((variable, index) => {
                    const input = document.getElementById(`variable${index + 1}`);
                    if (input) {
                        updatedText = updatedText.replace(variable, input.value || '');
                    }
                });
            }

            updatedText = updatedText
                .replace(/\*(.*?)\*/g, '<strong>$1</strong>')  // Bold
                .replace(/_(.*?)_/g, '<em>$1</em>')           // Italics
                .replace(/~(.*?)~/g, '<del>$1</del>')         // Strikethrough
                .replace(/`(.*?)`/g, '<span class="custom-monospace">$1</span>') // Monospace
                .replace(/\n/g, '<br>');

            messageText[0].innerHTML = updatedText;
        }

        // Function to handle header media preview
        function handleHeaderPreview(event) {
            const file = event.target.files[0];
            if (!file) return;

            messageCard.querySelectorAll('.message-video, .custom-document-link').forEach(el => el.remove());

            if (file.type.startsWith('image/')) {
                messageImage.src = URL.createObjectURL(file);
                messageImage.style.display = 'block';
            } else if (file.type.startsWith('video/')) {
                messageImage.style.display = 'none';
                const videoElement = document.createElement('video');
                videoElement.controls = true;
                videoElement.className = 'message-video';
                videoElement.style.width = '100%';
                videoElement.style.borderRadius = '10px';
                videoElement.innerHTML = `<source src="${URL.createObjectURL(file)}" type="${file.type}">`;
                messageCard.insertBefore(videoElement, messageText[0]);
            } else if (file.type.startsWith('application/')) {
                messageImage.style.display = 'none';
                const documentWrapper = document.createElement('div');
                documentWrapper.className = 'custom-document-link';

                documentWrapper.innerHTML = `
                    <i class="fa-solid fa-file-pdf" style="font-size: 24px; color: #d9534f; margin-right: 10px;"></i>
                    <div style="flex-grow: 1;">
                        <a href="${URL.createObjectURL(file)}" download="${file.name}" style="color: black; text-decoration:none;">
                            <p style="margin: 0; font-weight: bold;">${file.name}</p>
                        </a>
                    </div>
                `;

                messageCard.insertBefore(documentWrapper, messageText[0]);
            }
        }

        // Function to create buttons
        function createButtons(buttons) {
            buttonsContainer.innerHTML = ''; // Clear previous buttons

            buttons.forEach((button) => {
                const hr = document.createElement('hr');
                buttonsContainer.appendChild(hr);

                let buttonElement;
                switch (button.type) {
                    case 'URL':
                        buttonElement = document.createElement('a');
                        buttonElement.href = button.url;
                        buttonElement.target = '_blank';
                        buttonElement.innerHTML = `<h6><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp; ${button.text}</h6>`;
                        break;
                    case 'PHONE_NUMBER':
                        buttonElement = document.createElement('a');
                        buttonElement.href = `tel:${button.phone_number}`;
                        buttonElement.innerHTML = `<h6><i class="fa-solid fa-phone"></i>&nbsp; ${button.text}</h6>`;
                        break;
                    case 'COPY_CODE':
                        buttonElement = document.createElement('a');
                        buttonElement.href = 'javascript:void(0)';
                        buttonElement.onclick = () => copyToClipboard(button.example[0]);
                        buttonElement.innerHTML = `<h6><i class="fa-regular fa-copy"></i>&nbsp; ${button.text}</h6>`;
                        break;
                }

                if (buttonElement) {
                    buttonsContainer.appendChild(buttonElement);
                }
            });
        }

        // Function to create coupon input for COPY_CODE buttons
        function createCouponInput(buttons) {
            buttons.forEach((button) => {
                if (button.type === 'COPY_CODE') {
                    // Create elements
                    const formGroup = document.createElement('div');
                    formGroup.className = 'form-group';

                    const label = document.createElement('label');
                    label.setAttribute('for', 'couponCode');
                    label.innerHTML = `Coupon Code (<span class="text-danger">Required*</span>)`;

                    const input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'form-control input-pill';
                    input.id = 'couponCode';
                    input.name = 'coupon_code';
                    input.placeholder = 'Enter coupon code';
                    input.required = true;

                    // Append elements
                    formGroup.appendChild(label);
                    formGroup.appendChild(input);
                    dynamicInputsContainer.appendChild(formGroup);
                }
            });
        }

        // Validation function to check required inputs
        function validateInputs() {
            const inputs = dynamicInputsContainer.querySelectorAll('input');
            let allValid = true;

            // Remove existing error messages
            inputs.forEach(input => {
                const errorElement = input.nextElementSibling;
                if (errorElement && errorElement.classList.contains('error-message')) {
                    errorElement.remove();
                }
            });

            inputs.forEach(input => {
                if (input.value.trim() === '') {
                    allValid = false;
                    input.classList.add('is-invalid');

                    // Create and insert an error message below the input
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'error-message text-danger mt-1';
                    errorMessage.textContent = 'This field is required.';
                    input.parentElement.appendChild(errorMessage);
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            return allValid;
        }

        // Prevent the next modal from showing if required inputs are not filled
        nextButton.addEventListener('click', function (event) {
            if (!validateInputs()) {
                event.preventDefault(); // Prevents the default action, i.e., hiding the modal
                // Display an alert or highlight the form fields that need attention.
                alert('Please fill out all required fields before proceeding.');
                return; // Stops further execution if validation fails
            }

            // If validation passes, manually show the next modal
            $('.newBroadcastMessage').modal('hide');
            $('.broadCastPreview').modal('show');
        });

        // Copy to clipboard function for COPY_CODE buttons
        function copyToClipboard(code) {
            navigator.clipboard.writeText(code).then(() => {
                alert('Coupon code copied to clipboard!');
            }, (err) => {
                console.error('Failed to copy: ', err);
            });
        }

        // Initial call to update broadcast details
        updateBroadcastDetails();

    });
</script>
<!--==== New Broadcast Message end ====-->



	<!-- Update broadcast group modal -->
	<div class="modal fade updateBroadcast" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content" style="border-radius: 20px !important;">
			<div class="card" style="border-radius: 15px;">
				<h5 class="text-center mt-3">Update Broadcast 2</h5>
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
				<div class="card-body" style="height: 400px; overflow-y: auto;">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr class="bg-light">
									<th scope="col" style="width: 10px;">
										<label class="form-check-label">
											<input class="form-check-input" type="checkbox" value="">
											<span class="form-check-sign"></span>
										</label>
									</th>
									<th scope="col">#</th>
									<th scope="col">Name</th>
									<th scope="col">Mobile</th>
									<th scope="col">Email</th>
									<th scope="col" class="text-center">Tags</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<label class="form-check-label">
											<input class="form-check-input" type="checkbox" value="" checked >
											<span class="form-check-sign"></span>
										</label>
									</td>
									<td>1</td>
									<td>Mark</td>
									<td>+91 9087654321</td>
									<td>mark@mail.com</td>
									<td class="text-center">
										<span class="badge badge-count">Meta</span>
										<span class="badge badge-count">Google</span>
									</td>
									
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<style>
				.cus-input:focus{
					border: 2px solid green;
				}
			</style>
			<div class="p-4 d-flex">
				<input type="text" class="form-control cus-input" placeholder="Broadcast Name" value="Broadcast 2" required>
				<button class="btn btn-success ml-3">Update Broadcast</button>
			</div>
		  </div>
		</div>
	</div>


	<!-- Create broadcast modal -->
	<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content" style="border-radius: 20px !important;">
		  	
				<div class="card" style="border-radius: 15px;">
					<h5 class="text-center mt-3">Create Broadcast Group</h5>
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
					<div class="card-body" style="height: 400px; overflow-y: auto;">
						<form action="{{ route('broadcast.store')}}" method="post">
							@csrf
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr class="bg-light">
											<th scope="col" style="width: 10px;">
												<label class="form-check-label">
													<input id="selectAll" class="form-check-input" type="checkbox" value="">
													<span class="form-check-sign"></span>
												</label>
											</th>
											<th scope="col">#</th>
											<th scope="col">Name</th>
											<th scope="col">Mobile</th>
											<th scope="col">Email</th>
											<th scope="col" class="text-center">Tags</th>
										</tr>
									</thead> 
									<tbody>
										@foreach ($contacts as $contact)
										<tr>
											<td>
												<label class="form-check-label">
													<input class="form-check-input row-checkbox" type="checkbox" name="contact_id[]" value="{{ $contact->id }}">
													<span class="form-check-sign"></span>
												</label>
											</td>
											<td>{{$loop->iteration}}</td>
											<td>{{$contact->name}}</td>
											<td>{{$contact->mobile}}</td>
											<td>{{$contact->email}}</td>
											<td class="text-center">
												@foreach (json_decode($contact->tags, true) as $tag)
													<span class="badge badge-count">{{$tag}}</span>
												@endforeach
		
											</td>
										</tr>
										@endforeach
										
									</tbody>
								</table>
							</div>
					</div>
				</div>
				<style>
					.cus-input:focus{
						border: 2px solid green;
					}
				</style>
				<div class="p-4 d-flex">
					<input type="text" class="form-control cus-input" name="broadcast_name" placeholder="Broadcast Name" required>
					<button type="submit" class="btn btn-success ml-3" onclick="console.log('Button clicked')">Create Broadcast</button>
				</div>
			</form>
		  </div>
		</div>
	</div>
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
	</script>



	<!-- Messaging Limit info Modal -->
	<div class="modal fade bd-example-modal-lg" id="messagingLimit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<style>
				ul {
					list-style: none; /* Remove default bullets */
				}
				ul .li {
					position: relative;
					padding-left: 20px; 
					margin-bottom: 12px;
				}
				ul .li::before {
					content: '•'; /* Custom bullet */
					position: absolute;
					left: 0;
					color: #25D366;
				}
			</style>
		<div class="modal-content" style="background: #e3f9e8; border-radius: 20px !important;">
			<div class="modal-body p-4">
				<div class="d-flex justify-content-between">
					<h5><b>Messaging Limit</b></h5>
					<i class="fa-solid fa-circle-xmark fa-2x" data-dismiss="modal" aria-label="Close" style="cursor: pointer; color: #c4c4c4;"></i>
				</div>
				<div class="p-2">
					
					<p>Messaging limits determine how many unique users your business can send messages to on a daily basis. 
						This includes new conversations as well as existing conversations with users. The messaging limit does NOT limit 
						the number of messages your business can send, just the number of users you are trying to message. It also does 
						NOT apply to messages sent in response to a user-initiated message within a 24-hour period.</p>
					<div class="card p-3" style="border-top: 5px solid rgb(0, 140, 255);">
						<p class="d-flex align-items-center">
							<i class="fa-regular fa-hand-point-right mr-3" style="color: #25D366;"></i>
							To upgrade out of Sandbox Tier, you need to send messages to 1,000+ unique contacts within a rolling 30-day period.
						</p>
						<p class="text-center"><b>Meta Business Verification is not required</b> to upgrade your messaging limit</p>
					</div>
					
					<ul>
						<li class="li"><b class="text-danger">Sandbox Tier</b>: Right after signing up to WhatsApp CRM, you can send message templates to up to 250 unique customers in a rolling 24-hour period without completing Business Verification.</li>
						<li class="li"><b>Tier 1</b>: Allows your business to send <b>1k business-initiated conversations (1k unique customers)</b> in a rolling 24-hour period.</li>
						<li class="li"><b>Tier 2</b>: Allows your business to send <b>10k business-initiated conversations (10k unique customers)</b> in a rolling 24-hour period.</li>
						<li class="li"><b>Tier 3</b>: Allows your business to send <b>100k business-initiated conversations (100k unique customers)</b> in a rolling 24-hour period.</li>
						<li class="li"><b>Tier 4</b>: Allows your business to send <b>unlimited business-initiated</b> conversations</li>
					</ul>

					<div class="card p-3" style="border-top: 5px solid rgb(0, 140, 255);">
						<p class="d-flex align-items-center">
							<i class="fa-regular fa-hand-point-right mr-3" style="color: #25D366;"></i>
							In any of the above tiers, businesses can reply to unlimited user-initiated conversations
						</p>
					</div>

					<p><b>Note:</b> A business starts in Tier 1 when it registers its phone number.</p>
					<p>A business's phone number will be upgraded to the next tier if:</p>
					<ul>
						<li class="li">your phone number status is <b>Connected</b></li>
						<li class="li">your phone number quality rating is <b>Medium</b> or <b>High</b></li>
						<li class="li">in the last 7 days you have initiated X or more conversations with unique customers, where X is your current messaging limit divided by 2</li>
					</ul>
					<p>Once the business reaches this threshold, it will be moved to the next tier.</p>
				</div>
			</div>
		</div>
		</div>
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