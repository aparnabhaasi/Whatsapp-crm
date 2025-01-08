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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
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

                <div class="row">
                    <div class="col-12 mb-0">
                        <div class="card p-4" style="border-radius: 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0" data-toggle="modal" data-target="#messagingLimit"><i class="fa-solid fa-gears"></i> Settings</h4>
                                    <hr class="m-1">
                                    <small class="mb-0 text-secondary">Perform the settings below inorder to start sending WhatsApp Messages using WhatsApp API</small>
                                </div>
                                <!-- Button to open the modal -->
                                <div>
                                    <a href="javascript:void(0);" class="btn btn-outline-info" style="border-radius: 40px;" data-toggle="modal" data-target="#setupGuideModal">
                                        Setup Guide <i class="fa-regular fa-file-lines"></i>
                                    </a>
                                </div>

                                <!-- Modal -->
<div class="modal fade" id="setupGuideModal" tabindex="-1" role="dialog" aria-labelledby="setupGuideModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setupGuideModalLabel">Setup Guide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Steps Container -->
                <div class="steps">
                    <!-- Step 1 -->
                    <div class="step" style="display: flex;">
                        <!-- Left Side (Image) -->
                        <div class="step-image" style="flex: 1; text-align: center;">
                            <img src="{{ asset('assets/img/connect/step1.png') }}" alt="Step 1 Image" style="max-width: 100%; height: auto; border-radius: 10px;">
                        </div>
                        <!-- Right Side (Title and Description) -->
                        <div class="step-content" style="flex: 2; padding-left: 20px;">
                            <h6>Step 1: Login to User Profile</h6>
                            <p>Login To user profile and  Create portfolio. if already created then use it. Click on below link for login <br><a href="https://business.facebook.com/">Business Profile</a></p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step" style="display: none;">
                        <!-- Right Side (Title and Description) -->
                        <div class="step-content" style="flex: 2; padding-right: 20px;">
                            <h6>Step 2: Create app in Developers</h6>
                            <p>In Developers section create new app. <a href="https://developers.facebook.com/">Click Here</a></p>
                        </div>
                        <!-- Left Side (Image) -->
                        <div class="step-image" style="flex: 1; text-align: center;">
                            <img src="{{ asset('assets/img/connect/step2.png') }}" alt="Step 2 Image" style="max-width: 70%; height: auto; border-radius: 10px;">
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step" style="display: none;">
                        <!-- Left Side (Image) -->
                        <div class="step-image" style="flex: 1; text-align: center;">
                            <img src="{{ asset('assets/img/connect/step3.png') }}" alt="Step 3 Image" style="max-width: 70%; height: auto; border-radius: 10px;">
                        </div>
                        <!-- Right Side (Title and Description) -->
                        <div class="step-content" style="flex: 2; padding-left: 20px;">
                            <h6>Step 3: Add Phone Number</h6>
                            <p>In the created app add New phone Number..</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step" style="display: none;">
                        <!-- Right Side (Title and Description) -->
                        <div class="step-content" style="flex: 2; padding-right: 20px;">
                            <h6>Step 4: Add Payment method</h6>
                            <p>In api configuration click on add payment method and then add your card details here.</p>
                        </div>
                        <!-- Left Side (Image) -->
                        <div class="step-image" style="flex: 1; text-align: center;">
                            <img src="{{ asset('assets/img/connect/step4.png') }}" alt="Step 2 Image" style="max-width: 100%; height: auto; border-radius: 10px;">
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step" style="display: none;">
                        <!-- Left Side (Image) -->
                        <div class="step-image" style="flex: 1; text-align: center;">
                            <img src="{{ asset('assets/img/connect/step5.png') }}" alt="Step 3 Image" style="max-width: 70%; height: auto; border-radius: 10px;">
                        </div>
                        <!-- Right Side (Title and Description) -->
                        <div class="step-content" style="flex: 2; padding-left: 20px;">
                            <h6>Step 5: Take the id and details from the account</h6>
                            <p>Copy the app_id, Phone_account id and whatsapp account id and paste it in a place safely. Also Change Development mode to live</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step" style="display: none;">
                        <!-- Left Side (Image) -->
                        <div class="step-image" style="flex: 1; text-align: center;">
                            <img src="{{ asset('assets/img/connect/step6.png') }}" alt="Step 3 Image" style="max-width: 70%; height: auto; border-radius: 10px;">
                        </div>
                        <!-- Right Side (Title and Description) -->
                        <div class="step-content" style="flex: 2; padding-left: 20px;">
                            <h6>Step 6: Generate Permenant access Token</h6>
                            <p>Generate permenant access token in system users and then create a ser an dgenertae token for the user</p>
                        </div>
                    </div>

                     
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary prev-btn" style="display: none;">Previous</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Script for Step Navigation -->
<script>
    $(document).ready(function () {
    let currentStep = 0; // Initialize at 0, steps are 0-indexed
    const steps = $('.step'); // All steps

    // Function to show the current step
    function showStep(stepIndex) {
        steps.hide(); // Hide all steps
        $(steps[stepIndex]).show(); // Show only the current step

        // Manage button visibility
        $('.prev-btn').toggle(stepIndex > 0); // Show "Previous" only after the first step
        $('.next-btn').toggle(stepIndex < steps.length - 1); // Show "Next" only before the last step
    }

    // Initialize the first step
    showStep(currentStep);

    // Next button click
    $('.next-btn').click(function () {
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    });

    // Previous button click
    $('.prev-btn').click(function () {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    });
});

</script>

 

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card p-4 w-100" style="border-radius: 15px;">
                            <form method="post" action="{{ route('settings.update', $settings->id ?? 0) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="pillInput1">WhatsApp Business Account ID</label>
                                    <input type="text" name="account_id" value="{{ $settings->account_id ?? '' }}" class="form-control input-pill" id="pillInput1" placeholder="Enter WhatsApp Business Account ID" required>
                                </div>
                                <div class="form-group">
                                    <label for="pillInput2">Phone number ID</label>
                                    <input type="text" name="phone_number_id" value="{{ $settings->phone_number_id ?? '' }}" class="form-control input-pill" id="pillInput2" placeholder="Enter Phone number ID" required>
                                </div>
                                <div class="form-group">
                                    <label for="pillInput3">Whatsapp Phone number</label>
                                    <input type="text" name="phone_number" value="{{ $settings->phone_number ?? '' }}" class="form-control input-pill" id="pillInput3" placeholder="Enter Whatsapp Phone number" required>
                                </div>
                                <div class="form-group">
                                    <label for="pillInput4">Access Token</label>
                                    <input type="text" name="access_token" value="{{ $settings->access_token ?? '' }}" class="form-control input-pill" id="pillInput4" placeholder="Enter Access Token" required>
                                </div>
                                <div class="form-group">
                                    <label for="pillInput4">App ID</label>
                                    <input type="text" name="meta_app_id" value="{{ $settings->meta_app_id ?? '' }}" class="form-control input-pill" id="pillInput4" placeholder="Enter App ID" required>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-outline-success px-4" style="border-radius: 40px;">{{ $settings ? 'Update' : 'Create' }}</button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <style>
                        .copy-icon {
                            cursor: pointer;
                            position: absolute;
                            right: 10px;
                            top: 50%;
                            transform: translateY(-50%);
                        }

                        .input-container {
                            position: relative;
                            display: inline-block;
                            width: 100%;
                        }

                        .form-control {
                            padding-right: 40px;
                        }
                    </style>

                    <div class="col-md-6 d-flex">
                        <div class="card p-4 w-100" style="border-radius: 15px;">
                            <div class="form-group">
                                <label for="pillInput1"><b>Callback URL for Incoming Messages</b></label>
                                <div class="input-container">
                                    <input type="text" class="form-control input-pill" id="callbackUrl" value="https://ictglobaltech.org.in/api/whatsapp/callback" readonly>
                                    <i class="far fa-xl fa-copy copy-icon" onclick="copyToClipboard('callbackUrl', this)"></i>
                                </div>
                            </div>
                            <hr class="m-2">
                            <div class="form-group">
                                <label for="pillInput2"><b>Verify Token</b></label>
                                <div class="input-container">
                                    <input type="text" class="form-control input-pill" id="verifyToken" value="ICTwtspcrm890" readonly>
                                    <i class="far fa-xl fa-copy copy-icon" onclick="copyToClipboard('verifyToken', this)"></i>
                                </div>
                            </div>
                            <hr class="m-2">
                            <div class="form-group">
                                <h6>Webhook Fields</h6>
                                <p>account_alerts, account_update, message_template_quality_update, message_template_status_update, messages, phone_number_name_update, security, template_category_update</p>
                            </div>
                            <hr>
                            @php
                            $user = Auth::user();
                            $crm_id = $user->app_id
                            @endphp
                            <p class="text-center">Your CRM ID : <b style="color:#00b300;">{{ $crm_id }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mb-3">
            <a href="privacy-policy" style="color: #25D366;">
                <h6>Privacy Policy</h6>
            </a>
        </div>
    </div>
    @endsection
</body>

<script>
    function copyToClipboard(inputId, iconElement) {
        const input = document.getElementById(inputId);
        input.select();
        input.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");

        // Change icon to check
        iconElement.classList.remove('fa-copy');
        iconElement.classList.add('fa-circle-check', 'check-icon');

        // Change back to copy icon after 2 seconds
        setTimeout(() => {
            iconElement.classList.remove('fa-circle-check', 'check-icon');
            iconElement.classList.add('fa-copy');
        }, 2000);
    }
</script>
<!-- jQuery, Popper.js, Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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