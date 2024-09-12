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

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                                            <input type="text" class="form-control input-pill" id="pillInput1" placeholder="Eg: Summer season sale">
                                        </div>
                                        <div class="form-group">
                                            <label for="categorySelect">Category</label>
                                            <select class="form-control input-pill" id="categorySelect">
                                                <option value="MARKETING">Marketing</option>
                                                <option value="UTILITY">Utility</option>
                                                <option value="AUTHENTICATION">Authentication</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="languageSelect">Select Language</label>
                                            <select class="form-control input-pill" id="languageSelect">
                                                <option value="af">Afrikaans</option>
                                                <option value="sq">Albanian</option>
                                                <option value="ar">Arabic</option>
                                                <option value="az">Azerbaijani</option>
                                                <option value="bn">Bengali</option>
                                                <option value="bg">Bulgarian</option>
                                                <option value="ca">Catalan</option>
                                                <option value="zh_CN">Chinese (CHN)</option>
                                                <option value="zh_HK">Chinese (HKG)</option>
                                                <option value="zh_TW">Chinese (TAI)</option>
                                                <option value="hr">Croatian</option>
                                                <option value="cs">Czech</option>
                                                <option value="da">Danish</option>
                                                <option value="nl">Dutch</option>
                                                <option value="en" selected>English</option>
                                                <option value="en_US">English (US)</option>
                                                <option value="en_GB">English (UK)</option>
                                                <option value="et">Estonian</option>
                                                <option value="fil">Filipino</option>
                                                <option value="fi">Finnish</option>
                                                <option value="fr">French</option>
                                                <option value="ka">Georgian</option>
                                                <option value="de">German</option>
                                                <option value="el">Greek</option>
                                                <option value="gu">Gujarati</option>
                                                <option value="ha">Hausa</option>
                                                <option value="he">Hebrew</option>
                                                <option value="hi">Hindi</option>
                                                <option value="hu">Hungarian</option>
                                                <option value="id">Indonesian</option>
                                                <option value="ga">Irish</option>
                                                <option value="it">Italian</option>
                                                <option value="ja">Japanese</option>
                                                <option value="kn">Kannada</option>
                                                <option value="kk">Kazakh</option>
                                                <option value="ko">Korean</option>
                                                <option value="ky">Kyrgyz (Kyrgyzstan)</option>
                                                <option value="lo">Lao</option>
                                                <option value="lv">Latvian</option>
                                                <option value="lt">Lithuanian</option>
                                                <option value="mk">Macedonian</option>
                                                <option value="ml">Malayalam</option>
                                                <option value="ms">Malay</option>
                                                <option value="mr">Marathi</option>
                                                <option value="no">Norwegian</option>
                                                <option value="fa">Persian</option>
                                                <option value="pl">Polish</option>
                                                <option value="pt_BR">Portuguese (BR)</option>
                                                <option value="pt_PT">Portuguese (POR)</option>
                                                <option value="pa">Punjabi</option>
                                                <option value="ro">Romanian</option>
                                                <option value="ru">Russian</option>
                                                <option value="rw">Kinyarwanda</option>
                                                <option value="sr">Serbian</option>
                                                <option value="sk">Slovak</option>
                                                <option value="sl">Slovenian</option>
                                                <option value="es_AR">Spanish (ARG)</option>
                                                <option value="es_ES">Spanish (SPA)</option>
                                                <option value="es_MX">Spanish (MEX)</option>
                                                <option value="sw">Swahili</option>
                                                <option value="sv">Swedish</option>
                                                <option value="ta">Tamil</option>
                                                <option value="te">Telugu</option>
                                                <option value="th">Thai</option>
                                                <option value="tr">Turkish</option>
                                                <option value="uk">Ukrainian</option>
                                                <option value="ur">Urdu</option>
                                                <option value="uz">Uzbek</option>
                                                <option value="vi">Vietnamese</option>
                                                <option value="zu">Zulu</option>
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
                                            <select class="form-control input-pill" id="headerSelect" onchange="handleHeaderChange()">
                                                <option value="None">None</option>
                                                <option value="Text">Text</option>
                                                <option value="Image">Image</option>
                                                <option value="Video">Video</option>
                                                <option value="Document">Document</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="uploadFileGroup" style="display: none;">
                                            <label for="uploadFileInput" id="uploadFileLabel">Upload file</label>
                                            <input type="text" class="form-control input-pill" id="uploadFileInput" placeholder="Eg: Marketing">
                                        </div>

                                        <div class="form-group">
                                            <label for="messageTextarea">Message</label>
                                            <textarea class="form-control input-pill" id="messageTextarea" oninput="updatePreviewMessage()" rows="4" placeholder="Enter your message here">Hello</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="footerInput">Footer (Optional)</label>
                                            <input type="text" class="form-control input-pill" id="footerInput" oninput="updateFooterContent()" placeholder="Enter footer text">
                                        </div>


                                        <div class="p-2 mt-3">
                                            <label for="addButton" class="mb-2">Additional Interactions</label>
                                            <div class="add-btn" id="addButton">
                                                + Add Button
                                            </div>
                                        </div>
                                        
                                        <div id="buttonContainer" class="p-2 w-100">
                                            <!-- Template for cus-btn-container -->
                                            <div class="cus-btn-container-template" style="display: none;">
                                                <div class="d-flex align-items-center cus-btn-container w-100">
                                                    <select class="form-control" style="width: auto;" onchange="updateFields(this)">
                                                        <option value="Text">Text</option>
                                                        <option value="URL">URL</option>
                                                        <option value="Phone">Phone</option>
                                                    </select>
                                                    <input type="text" id="buttonText" class="form-control mx-1" placeholder="Button Text" data-input="text">
                                                    <input type="text" id="buttonLink" class="form-control" placeholder="Button link" data-input="url" style="display: none;">
                                                    <input type="text" id="mobileNumber" class="form-control" placeholder="Mobile Number" data-input="phone" style="display: none;">
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
                                        
                                        <script>
                                            function addButtonContainer() {
                                                var container = document.getElementById("buttonContainer");
                                                var template = document.querySelector(".cus-btn-container-template");
                                                var newContainer = template.cloneNode(true);
                                        
                                                newContainer.classList.remove("cus-btn-container-template");
                                                newContainer.style.display = "flex";
                                        
                                                container.appendChild(newContainer);
                                            }
                                        
                                            function updateFields(selectElement) {
                                                var selectedValue = selectElement.value;
                                                var container = selectElement.closest('.cus-btn-container');
                                                var inputs = container.querySelectorAll('input[data-input]');
                                        
                                                inputs.forEach(function(input) {
                                                    input.style.display = 'none'; // Hide all inputs initially
                                                    input.style.width = ''; // Reset width
                                                });
                                        
                                                if (selectedValue === 'URL') {
                                                    container.querySelector('input[data-input="url"]').style.display = 'inline-block';
                                                } else if (selectedValue === 'Phone') {
                                                    container.querySelector('input[data-input="phone"]').style.display = 'inline-block';
                                                }
                                        
                                                var buttonTextInput = container.querySelector('input[data-input="text"]');
                                                buttonTextInput.style.display = 'inline-block'; // Button Text is always displayed
                                        
                                                // Full width for Button Text input if "Text" is selected
                                                if (selectedValue === 'Text') {
                                                    buttonTextInput.style.width = '100%';
                                                } else {
                                                    buttonTextInput.style.width = ''; // Reset width for other selections
                                                }
                                            }
                                        
                                            function removeButtonContainer(element) {
                                                var container = element.parentElement;
                                                container.parentElement.removeChild(container);
                                            }
                                        
                                            document.getElementById("addButton").onclick = addButtonContainer;


                                            // Handle the header change
                                            function handleHeaderChange() {
                                                var headerSelect = document.getElementById("headerSelect");
                                                var uploadFileGroup = document.getElementById("uploadFileGroup");
                                                var uploadFileInput = document.getElementById("uploadFileInput");
                                                var uploadFileLabel = document.getElementById("uploadFileLabel");
                                                var headerText = document.getElementById("headerText");
                                                
                                                // Get the preview image elements
                                                var imageThumb = document.getElementById("imageThumb");
                                                var videoThumb = document.getElementById("videoThumb");
                                                var documentThumb = document.getElementById("documentThumb");

                                                // Hide all thumbnail images initially
                                                imageThumb.style.display = "none";
                                                videoThumb.style.display = "none";
                                                documentThumb.style.display = "none";

                                                // Handle different header options
                                                if (headerSelect.value === "None") {
                                                    uploadFileGroup.style.display = "none";
                                                    headerText.style.display = "none"; // Hide header text
                                                } else {
                                                    uploadFileGroup.style.display = "block";
                                                    
                                                    if (headerSelect.value === "Text") {
                                                        uploadFileLabel.innerHTML = "Enter your text";
                                                        uploadFileInput.type = "text";
                                                        uploadFileInput.placeholder = "Enter your text here";
                                                        uploadFileInput.style.display = "block";
                                                        headerText.style.display = "block"; // Show header text
                                                        uploadFileInput.addEventListener('input', updateHeaderText); // Add input event listener
                                                    } else if (headerSelect.value === "Image") {
                                                        uploadFileLabel.innerHTML = "Upload Image";
                                                        uploadFileInput.type = "file";
                                                        uploadFileInput.accept = "image/*";
                                                        imageThumb.style.display = "block"; // Show image thumbnail
                                                        headerText.style.display = "none"; // Hide header text
                                                    } else if (headerSelect.value === "Video") {
                                                        uploadFileLabel.innerHTML = "Upload Video";
                                                        uploadFileInput.type = "file";
                                                        uploadFileInput.accept = "video/*";
                                                        videoThumb.style.display = "block"; // Show video thumbnail
                                                        headerText.style.display = "none"; // Hide header text
                                                    } else if (headerSelect.value === "Document") {
                                                        uploadFileLabel.innerHTML = "Upload Document";
                                                        uploadFileInput.type = "file";
                                                        uploadFileInput.accept = ".pdf,.doc,.docx";
                                                        documentThumb.style.display = "block"; // Show document thumbnail
                                                        headerText.style.display = "none"; // Hide header text
                                                    }
                                                }
                                            }

                                            // Update header text content
                                            function updateHeaderText() {
                                                var headerInput = document.getElementById("uploadFileInput");
                                                var headerText = document.getElementById("headerText");

                                                headerText.textContent = headerInput.value; // Update text content
                                            }
                                            
                                            // Initial setup
                                            document.getElementById("headerSelect").addEventListener('change', handleHeaderChange);


                                            // update message contents
                                            function updatePreviewMessage(){
                                                var messageTextarea = document.getElementById('messageTextarea');
                                                var previewMessage = document.getElementById('messageContent');

                                                previewMessage.innerHTML = messageTextarea.value.replace(/\n/g, '<br>');
                                            }


                                            // update footer contet
                                            function updateFooterContent(){
                                                var footerInput = document.getElementById('footerInput');
                                                var footerContent = document.getElementById('footerContent');

                                                footerContent.textContent = footerInput.value;
                                            }

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
                                            <img id="imageThumb" src="assets/img/image-thumb.png" alt="" style="display: none;">
                                            <img id="videoThumb" src="assets/img/video-thumb.png" alt="" style="display: none;">
                                            <img id="documentThumb" src="assets/img/document-thumb.png" alt="" style="display: none;">
                                                <p id="messageContent" class="mt-2">Hello</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p id="footerContent" style="color: #acacac;"></p>
                                                    <p id="currentTime" style="color: #acacac;"></p>
                                                    <!-- detect current time for message template preview -->
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
                                                </div>
                                                <hr>
                                                <div class="text-center">
                                                    <a href="">
                                                        <h6><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp; Order Now</h6>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
	                                </div>

                                    <div class="p-3">
                                        <button class="btn btn-outline-primary w-100 mb-2 cancel-btn">Cancel</button>
                                        <button class="btn btn-primary w-100 submit-btn">Submit</button>
                                    </div>
	                            </div>

							</div>
                            
						</div>
					</div>
				</div>

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