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

     <style>
        .mesages-card-container{
            background-image: url(assets/img/chat-bg-yellow.png);
            background-size: cover;
            padding: 30px;
            margin-bottom: 8px;
        }
        .message-card{
            background: #fff;
            padding: 8px;
            border-radius: 0px 15px 15px 15px;
            
        }
        .message-card img{
            width: 100%;
            border-radius: 10px;
        }
        .message-card p,a{
            font-family: Helvetica, Arial, sans-serif;
          
        }
        .cancel-btn,.submit-btn{
            font-size: 16px;
            border: 1px solid;
            border-radius: 10px;
            font-weight: 800;
        }
        .cancel-btn:hover{
            background: red;
            border-color: red;
        }

        .warning-card{
            background: rgb(255, 243, 219);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
        }
        .warning-card .ax{
            color: rgb(0, 206, 0);
        }

        .blue-card{
            background: rgb(214, 224, 255);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px
        }
        .blue-card small{
            font-size: 13px;
        }
        .cus-bell{
            background: rgb(0, 123, 255);
            color: #fff;
            padding: 10px 11px;
            border-radius: 6px;
            margin-right: 10px;
        }
        .add-btn{
            width: 100%;
            background: rgb(239, 239, 239);
            text-align: center;
            border: 2px dashed gray;
            border-radius: 6px;
            padding: 8px;
        }
        .cus-btn-container{
            background: rgb(220, 255, 213);
            padding: 8px;
            margin-top: 10px;
            border-radius: 5px;
        }
                                
    </style>
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
						<form action="{{ route('template.add') }}" method="post" enctype="multipart/form-data">
                            @csrf
						    <div class="row">
    							<div class="col-12">
    								<h5 class="text-center">Create Template</h5>
    							</div>
                                <div class="col-12">
                                    <div class="warning-card">
                                        <p class="mb-0 text-center">
                                            All template must adhere to <a href="https://developers.facebook.com/docs/whatsapp/message-templates/guidelines/" target="_blank" class="ax"><b>WhatsApp's Template Message Guidlines</b></a>. 
                                            Before creating a template read the <a href="" data-toggle="modal" data-target="#commonRejection"><b>Common Rejection Reasons</b></a></p>
                                    </div>
                                </div>
    							<div class="col-lg-3">
    								<div class="card" style="border-radius: 15px;">
    	                                <div class="card-body">
    	                                    <h6>Template Properties</h6>
                                            <hr>
                                            <div class="form-group">
                                                <label for="pillInput1">Name of Template</label>
                                                <input type="text" name="template_name" class="form-control input-pill" id="pillInput1" placeholder="Eg: summer_season_sale" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="categorySelect">Category</label>
                                                <select class="form-control input-pill" name="category" id="categorySelect">
                                                    <option value="MARKETING">Marketing</option>
                                                    <option value="UTILITY">Utility</option>
                                                    <option value="AUTHENTICATION">Authentication</option>
                                                </select>
                                            </div>
    
                                            <div class="form-group">
                                                <label for="languageSelect">Select Language</label>
                                                <select class="form-control input-pill" name="language" id="languageSelect">
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->code }}" 
                                                            {{ $language->code == 'en' ? 'selected' : '' }}>
                                                            {{ $language->language }}
                                                        </option>
                                                    @endforeach  
                                                </select>
                                            </div>
                                            
    	                                </div>
    	                            </div>
    
                                    <div class="blue-card">
                                        <div class=" d-flex align-items-center mb-1">
                                            <i class="fa-solid fa-bell cus-bell"></i>
                                            <h6 class="mb-1">Reminder</h6>
                                        </div>
                                        <div>
                                            
                                            <small>
                                                From <a href="https://business.whatsapp.com/policy"  target="_blank"><b>Meta's messaging policy</b></a>, you should have acquired consent from customers
                                                for receiving your WhatsApp mesages before sending template message to them.
                                            </small>
                                        </div>
                                    </div>
    							</div>
    
                                <div class="col-lg-5">
    								<div class="card" style="border-radius: 15px;">
    	                                <div class="card-body">
                                            <h6>Content</h6>
                                            <hr>
                                            <div class="form-group">
                                                <label for="headerSelect">Header</label>
                                                <select class="form-control input-pill" name="header_type" id="headerSelect" onchange="handleHeaderChange()">
                                                    <option value="None">None</option>
                                                    <option value="IMAGE">Image</option>
                                                    <option value="VIDEO">Video</option>
                                                    <option value="DOCUMENT">Document</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="uploadFileGroup" style="display: none;">
                                                <label for="uploadFileInput" id="uploadFileLabel">Upload file</label>
                                                <input type="file" name="header_content" class="form-control input-pill" id="uploadFileInput" placeholder="Eg: Marketing" onchange="previewFile()">
                                            </div>

                                            <div class="form-group">
                                                <label for="messageTextarea">Body</label>
                                                <textarea class="form-control input-pill" name="body" id="messageTextarea" oninput="handleTextareaChange()" rows="4" placeholder="Enter your message here">Hello</textarea>
                                                <div id="error-message" class="text-danger mt-2"></div>
                                                <div class="text-right mt-2">
                                                    <a class="btn btn-light btn-sm border" onclick="addVariable()">Add variable +</a>
                                                </div>
                                                <div id="variable-inputs" class="mt-3"></div> 
                                                
                                            </div>

                                            <!-- Add variable and validation -->
                                            <script>
                                                let variableCount = 1;

                                                function addVariable() {
                                                    const textarea = document.getElementById('messageTextarea');
                                                    textarea.value += ` @{{${variableCount}}} `;

                                                    // Create new input field for variable
                                                    const variableContainer = document.getElementById('variable-inputs');
                                                    const newLabel = document.createElement('label');
                                                    newLabel.innerHTML = `@{{${variableCount}}}`;
                                                    newLabel.setAttribute('for', `variable-${variableCount}`);
                                                    newLabel.id = `label-${variableCount}`;

                                                    const newInput = document.createElement('input');
                                                    newInput.type = 'text';
                                                    newInput.className = 'form-control input-pill mt-2';
                                                    newInput.name = `variables[]`;  // Pass variables as array
                                                    newInput.id = `variable-${variableCount}`;
                                                    newInput.placeholder = `Enter sample value for @{{${variableCount}}}`;

                                                    variableContainer.appendChild(newLabel);
                                                    variableContainer.appendChild(newInput);

                                                    variableCount++;
                                                    validateTextarea(); // Run validation after adding a variable
                                                }

                                                function handleTextareaChange() {
                                                    const textarea = document.getElementById('messageTextarea');
                                                    const textareaValue = textarea.value;

                                                    const textareaValuePreview = document.getElementById("messageTextarea").value;
                                                    document.getElementById('messageContent').textContent = textareaValuePreview;

                                                    for (let i = 1; i < variableCount; i++) {
                                                        const variablePattern = `@{{${i}}}`;
                                                        if (!textareaValue.includes(variablePattern)) {
                                                            const label = document.getElementById(`label-${i}`);
                                                            const input = document.getElementById(`variable-${i}`);
                                                            if (label && input) {
                                                                label.remove();
                                                                input.remove();
                                                            }
                                                        }
                                                    }
                                                    validateTextarea(); // Run validation on every input change
                                                }

                                                function validateTextarea() {
                                                    const textarea = document.getElementById('messageTextarea');
                                                    const errorMessage = document.getElementById('error-message');
                                                    const variableRegex = /@{{\d+}}/g;  // Regex to find variable patterns

                                                    // Reset error message
                                                    errorMessage.textContent = '';

                                                    let match;
                                                    while ((match = variableRegex.exec(textarea.value)) !== null) {
                                                        // Check for two words after the variable
                                                        const afterVariable = textarea.value.slice(match.index + match[0].length).trim();
                                                        const wordsAfter = afterVariable.split(/\s+/).filter(word => word.length > 0); // Count valid words

                                                        if (wordsAfter.length < 2) {
                                                            errorMessage.textContent = `Each variable (@{{n}}) must be followed by at least two words.`;
                                                            break;
                                                        }
                                                    }
                                                }
                                            </script>

    
                                            <div class="form-group">
                                                <label for="footerInput">Footer (Optional)</label>
                                                <input type="text" name="footer" class="form-control input-pill" id="footerInput" oninput="updateFooterContent()" placeholder="Enter footer text">
                                            </div>
        
                                            <div class="p-2 mt-3">
                                                <label for="addButton" class="mb-2">Additional Interactions</label>
                                                <div class="add-btn" id="addButton" style="cursor: pointer; color: blue;">
                                                    + Add Button
                                                </div>
                                            </div>

                                            <div id="buttonContainer" class="p-2 w-100">
                                                <!-- Template for cus-btn-container -->
                                                <div class="cus-btn-container-template" style="display: none;">
                                                    <div class="d-flex align-items-center cus-btn-container w-100">
                                                        <select class="form-control" name="buttons[][type]" style="width: auto;" onchange="updateFields(this)">
                                                            <option value="" disabled selected>Select</option> 
                                                            <option value="URL">URL</option>
                                                            <option value="PHONE_NUMBER">Phone</option>
                                                        </select>
                                                        <input type="text" class="form-control mx-1" placeholder="Button Text" name="buttons[][text]" data-input="text">
                                                        <input type="text" class="form-control" placeholder="Button Link" name="buttons[][url]" data-input="url">
                                                        <input type="text" class="form-control" placeholder="Mobile Number" name="buttons[][phone]" data-input="phone" style="display: none;">
                                                        <a href="javascript:void(0);" class="text-danger" onclick="removeButtonContainer(this)"><i class="fa fa-trash ml-2"></i></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2">
                                                <div class="p-2 border" style="border-radius: 10px; background: rgb(255, 251, 237);">
                                                    <small style="font-size: 13px;">
                                                        Optionally add buttons for your broadcast message. There are two types of buttons: call-to-action (i.e. URL or Phone) and quick reply (i.e. text). You can add up to 2 call-to-action or 3 quick reply buttons. <b>Each template only allows one type of button.</b> 
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- generate button -->
                                            <script>
                                            document.getElementById("addButton").onclick = function() {
                                                var container = document.getElementById("buttonContainer");
                                                var template = document.querySelector(".cus-btn-container-template");
                                                var newContainer = template.cloneNode(true);

                                                // Remove the template class and show the new container
                                                newContainer.classList.remove("cus-btn-container-template");
                                                newContainer.style.display = "flex";

                                                // Clear previous input values and make sure names are properly formatted for each new entry
                                                newContainer.querySelectorAll('input, select').forEach(function(input) {
                                                    input.value = ''; // Clear values
                                                    const name = input.getAttribute('name');
                                                    if (name) {
                                                        // Adjust the name attribute to include the correct format for each new button
                                                        const updatedName = name.replace(/\[\]/, `[${Date.now()}]`);
                                                        input.setAttribute('name', updatedName);
                                                    }

                                                    // Add oninput event to update preview on each keystroke or selection change
                                                    input.oninput = updatePreviewButtons;
                                                    input.onchange = updatePreviewButtons;
                                                });

                                                // Update fields to show the correct inputs based on the default selection
                                                var select = newContainer.querySelector('select[name*="[type]"]');
                                                select.onchange = function() {
                                                    updateFields(this);
                                                    updatePreviewButtons();
                                                };
                                                container.appendChild(newContainer);

                                                updatePreviewButtons(); // Update the preview area
                                            };

                                            function updateFields(selectElement) {
                                                var selectedValue = selectElement.value;
                                                var container = selectElement.closest('.cus-btn-container');
                                                var inputs = container.querySelectorAll('input[data-input]');

                                                inputs.forEach(function(input) {
                                                    input.style.display = 'none'; // Hide all inputs initially
                                                    input.disabled = true; // Disable all inputs initially
                                                });

                                                // Enable and display only the relevant input fields based on the selected button type
                                                if (selectedValue === 'URL') {
                                                    var urlInput = container.querySelector('input[data-input="url"]');
                                                    urlInput.style.display = 'inline-block';
                                                    urlInput.disabled = false; // Enable URL input
                                                } else if (selectedValue === 'PHONE_NUMBER') {
                                                    var phoneInput = container.querySelector('input[data-input="phone"]');
                                                    phoneInput.style.display = 'inline-block';
                                                    phoneInput.disabled = false; // Enable Phone input
                                                }

                                                // Button text is always displayed and enabled
                                                var buttonTextInput = container.querySelector('input[data-input="text"]');
                                                buttonTextInput.style.display = 'inline-block';
                                                buttonTextInput.disabled = false; // Enable Button Text

                                                updatePreviewButtons(); // Update the preview area whenever fields change
                                            }

                                            function updatePreviewButtons() {
                                                var previewContainer = document.getElementById("footerButtonsPreview");
                                                previewContainer.innerHTML = ""; // Clear existing buttons in the preview

                                                // Find all button containers and create corresponding preview buttons
                                                document.querySelectorAll('.cus-btn-container').forEach(function(container) {
                                                    var buttonText = container.querySelector('input[data-input="text"]').value;
                                                    var buttonType = container.querySelector('select[name*="[type]"]').value;
                                                    var buttonUrl = container.querySelector('input[data-input="url"]').value;
                                                    var buttonPhone = container.querySelector('input[data-input="phone"]').value;

                                                    if (buttonText && buttonType) {
                                                        // Create a new anchor element for the preview
                                                        var previewButton = document.createElement("a");
                                                        var icon = document.createElement("i");
                                                        var buttonContent = document.createElement("h6");

                                                        // Set href and icon based on button type
                                                        if (buttonType === "URL" && buttonUrl) {
                                                            previewButton.href = buttonUrl;
                                                            icon.className = "fa-solid fa-arrow-up-right-from-square";
                                                        } else if (buttonType === "PHONE_NUMBER" && buttonPhone) {
                                                            previewButton.href = "tel:" + buttonPhone;
                                                            icon.className = "fa-solid fa-phone";
                                                        }

                                                        // Append icon and text to button
                                                        buttonContent.appendChild(icon);
                                                        buttonContent.innerHTML += "&nbsp;" + buttonText;
                                                        previewButton.appendChild(buttonContent);

                                                        // Style the button and append it to the preview container
                                                        previewButton.className = "preview-button";
                                                        previewContainer.appendChild(previewButton);
                                                    }
                                                });
                                            }

                                            function removeButtonContainer(element) {
                                                var container = element.parentElement;
                                                container.parentElement.removeChild(container);
                                                updatePreviewButtons(); // Update preview when a button is removed
                                            }

                                            // Function to disable unfilled button containers before form submission
                                            function disableEmptyButtonContainers() {
                                                var buttonContainers = document.querySelectorAll('.cus-btn-container');

                                                buttonContainers.forEach(function(container) {
                                                    var buttonText = container.querySelector('input[data-input="text"]').value;
                                                    var buttonType = container.querySelector('select[name="buttons[][type]"]').value;
                                                    var buttonUrl = container.querySelector('input[data-input="url"]').value;
                                                    var buttonPhone = container.querySelector('input[data-input="phone"]').value;

                                                    // Disable empty button containers
                                                    if (!buttonText || (buttonType === 'URL' && !buttonUrl) || (buttonType === 'Phone' && !buttonPhone)) {
                                                        container.querySelectorAll('input, select').forEach(function(element) {
                                                            element.disabled = true; // Disable all inputs in empty containers
                                                        });
                                                    }
                                                });
                                            }

                                            // Example: Call this function when submitting the form
                                            document.getElementById("yourFormId").onsubmit = function(event) {
                                                disableEmptyButtonContainers(); // Disable empty containers before submission
                                            };

                                            </script>

                                        </div>
    	                            </div>
    							</div>
    
                                <div class="col-lg-4">
                                    <div class="card" style="border-radius: 15px;">
                                        <div class="card-body">
                                            <h6>Template Preview</h6>
                                            <hr>
                                            <div class="mesages-card-container">
                                                <div class="message-card">
                                                    <h6 id="headerText" style="font-weight:700; color:black; display:none;"></h6>
                                                    <img id="imageThumb" src="assets/img/image-thumb.png" alt="" style="display: none; max-width: 100%; height: auto;">
                                                    <video id="videoThumb" controls style="display: none; max-width: 100%; height: auto;"></video>
                                                    <iframe id="documentThumb" src="" style="display: none; width: 100%; height: 300px;"></iframe>
                                                    <p id="messageContent" class="mt-2">Hello</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p id="footerContent" style="color: #acacac; font-size:14px;"></p>
                                                        <p id="currentTime" style="color: #acacac; font-size:14px;"></p>
                                                    </div>
                                                    
                                                    <div class="text-center footer-buttons border-top py-2" id="footerButtonsPreview">
                                                        <a href="">
                                                            <h6><i class="fa-solid"></i></h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3">
                                            <a href="/" class="btn btn-outline-primary w-100 mb-2 cancel-btn">Cancel</a>
                                            <button type="submit" class="btn btn-primary w-100 submit-btn">Submit</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- script for displaying inputs according to selected header and previewing file -->
                                <script>
                                    function handleHeaderChange() {
                                        var headerSelect = document.getElementById("headerSelect");
                                        var uploadFileGroup = document.getElementById("uploadFileGroup");
                                        var uploadFileInput = document.getElementById("uploadFileInput");
                                        var uploadFileLabel = document.getElementById("uploadFileLabel");

                                        // Hide all thumbnail elements initially
                                        document.getElementById("imageThumb").style.display = "none";
                                        document.getElementById("videoThumb").style.display = "none";
                                        document.getElementById("documentThumb").style.display = "none";

                                        // Show upload field if a header type is selected
                                        if (headerSelect.value === "None") {
                                            uploadFileGroup.style.display = "none";
                                            uploadFileInput.removeAttribute("name");
                                        } else {
                                            uploadFileGroup.style.display = "block";
                                            uploadFileInput.setAttribute("name", "header_content");

                                            // Update the upload field based on the selected header type
                                            if (headerSelect.value === "IMAGE") {
                                                uploadFileLabel.innerHTML = "Upload Image";
                                                uploadFileInput.type = "file";
                                                uploadFileInput.accept = "image/*";
                                            } else if (headerSelect.value === "VIDEO") {
                                                uploadFileLabel.innerHTML = "Upload Video";
                                                uploadFileInput.type = "file";
                                                uploadFileInput.accept = "video/*";
                                            } else if (headerSelect.value === "DOCUMENT") {
                                                uploadFileLabel.innerHTML = "Upload Document";
                                                uploadFileInput.type = "file";
                                                uploadFileInput.accept = ".pdf,.doc,.docx";
                                            }
                                        }
                                    }

                                    function previewFile() {
                                        var fileInput = document.getElementById("uploadFileInput");
                                        var file = fileInput.files[0];

                                        if (!file) return;

                                        var headerType = document.getElementById("headerSelect").value;
                                        var reader = new FileReader();

                                        if (headerType === "IMAGE" && file.type.startsWith("image/")) {
                                            reader.onload = function(e) {
                                                document.getElementById("imageThumb").src = e.target.result;
                                                document.getElementById("imageThumb").style.display = "block";
                                                document.getElementById("videoThumb").style.display = "none";
                                                document.getElementById("documentThumb").style.display = "none";
                                            };
                                            reader.readAsDataURL(file);
                                        } else if (headerType === "VIDEO" && file.type.startsWith("video/")) {
                                            reader.onload = function(e) {
                                                var videoThumb = document.getElementById("videoThumb");
                                                videoThumb.src = e.target.result;
                                                videoThumb.style.display = "block";
                                                document.getElementById("imageThumb").style.display = "none";
                                                document.getElementById("documentThumb").style.display = "none";
                                            };
                                            reader.readAsDataURL(file);
                                        } else if (headerType === "DOCUMENT" && (file.type === "application/pdf" || file.type === "application/msword" || file.type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) {
                                            var documentThumb = document.getElementById("documentThumb");
                                            documentThumb.src = URL.createObjectURL(file);
                                            documentThumb.style.display = "block";
                                            document.getElementById("imageThumb").style.display = "none";
                                            document.getElementById("videoThumb").style.display = "none";
                                        } else {
                                            alert("Invalid file type for selected header.");
                                        }
                                    }

                                    function updateFooterContent(){
                                        const footerInputContent = document.getElementById("footerInput").value;
                                        document.getElementById("footerContent").textContent = footerInputContent;
                                    }
                                </script>
    						</div>
						</form>


					</div>
				</div>

                <script>
                    function updateTime() {
                        const current = new Date();
                        let hours = current.getHours();
                        let minutes = current.getMinutes();
                        const ampm = hours >= 12 ? 'pm' : 'am';

                        hours = hours % 12;
                        hours = hours ? hours : 12; // the hour '0' should be '12'
                        minutes = minutes < 10 ? '0' + minutes : minutes;

                        const timeString = hours + ':' + minutes + ' ' + ampm;
                        document.getElementById('currentTime').textContent = timeString;
                    }

                    updateTime();
                    setInterval(updateTime, 60000); // Update the time every minute
                </script>
                <!-- footer -->
                @endsection

			</div>


    <!-- Common Rejection Reasond Modal -->
     <style>
        .fa-hand-point-right{
            color: #25D366;
        }
     </style>
    <div class="modal fade" id="commonRejection" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background: rgb(255, 247, 215); border-radius: 20px !important;">
            <div class="modal-body p-5">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h5><b>Common Rejection Reasons</b></h5>
                @php
                $content = '<p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Variables are placed at the beginning or end of the message.</p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Variables are placed next to each other, such as “{{1}} {{2}}”.</p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Variables have mismatched curly braces or use words instead of numbers. The correct format is "{{1}}", not "{{one}}".</p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Variable parameters are not sequential. For example, "{{1}}, {{2}}, {{4}}, {{5}}" are defined but "{{3}}" does not exist.</p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Call to action button URL contains a direct link to WhatsApp, such as "https://wa.me/14154443344", which Meta no longer allows.</p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Template is a duplicate of an existing template. WhatsApp rejects templates submitted with the same wording with a different name. </p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Template contains content violating the <a href="https://business.whatsapp.com/policy">WhatsApp Commerce Policy</a> or the <a href="https://www.facebook.com/flx/warn/?u=https%3A%2F%2Fwww.whatsapp.com%2Flegal%2Fbusiness-policy%2F%3Ffbclid%3DIwAR1yvdZWGarAKSb9ia6FBUpuZ9KSU9q5wsFoKqRZCRPEtOaLYagxy4Ad7YA&h=AT03VX8nHKyCLAWUFOPF82QKxnpqYTiSeDLtFcL66sbflImtk8vmRfTVvd0GBLpAS8rsggEu13xSrtdsNEGZMfi2fzsBqG3RVmEzTdZkhRybne36vemEsCoHpNhLCSQnms-JCGQSOx8mj4zf3kWqoLA">WhatsApp Business Policy</a>. Do not request sensitive identifiers from users, such as payment card numbers, financial account numbers, or National Identification numbers. Requesting partial identifiers (e.g., last 4 digits of their Social Security number) is OK.</p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Template appears to encourage gaming or gambling. Including words such as "raffle" or "win a prize" almost guarantees template rejection by WhatsApp.</p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Template is overly vague, such as “Hi, {{1}}, thanks”. This type of template could be abused to spam users. You need to surround the parameters with information so that it\'s clear what type of information will be inserted.</p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> You are using the wrong language. For example, a template in English is submitted with Portuguese language selected.</p>
                <p class=""><i class="fa-regular mr-3 fa-hand-point-right"></i> Grammatical or spelling mistakes. Even minor spelling or grammatical mistakes are likely to be rejected by WhatsApp.</p>';
                echo $content;
                @endphp
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