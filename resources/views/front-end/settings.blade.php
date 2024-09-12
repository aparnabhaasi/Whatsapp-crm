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
                                <div>
                                    <a href="" class="btn btn-outline-info" style="border-radius: 40px;">Setup Guide <i class="fa-regular fa-file-lines"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card p-4 w-100" style="border-radius: 15px;">
                            <form method="post" action="{{ route('settings.update', $settings->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="pillInput1">WhatsApp Business Account ID</label>
                                    <input type="text" name="account_id" value="{{ $settings->account_id }}" class="form-control input-pill" id="pillInput1" placeholder="Enter WhatsApp Business Account ID">
                                </div>
                                <div class="form-group">
                                    <label for="pillInput2">Phone number ID</label>
                                    <input type="text" name="phone_number_id" value="{{ $settings->phone_number_id }}" class="form-control input-pill" id="pillInput2" placeholder="Enter Phone number ID">
                                </div>
                                <div class="form-group">
                                    <label for="pillInput3">Whatsapp Phone number</label>
                                    <input type="text" name="phone_number" value="{{ $settings->phone_number }}" class="form-control input-pill" id="pillInput3" placeholder="Enter Whatsapp Phone number">
                                </div>
                                <div class="form-group">
                                    <label for="pillInput4">Access Token</label>
                                    <input type="text" name="access_token" value="{{ $settings->access_token }}" class="form-control input-pill" id="pillInput4" placeholder="Enter Access Token">
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-outline-success px-4" style="border-radius: 40px;">Update</button>
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
                                    <input type="text" class="form-control input-pill" id="callbackUrl" value="https://f967-106-222-237-68.ngrok-free.app/whatsapp/callback" readonly>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mb-3">
            <a href="privacy-policy" style="color: #25D366;"><h6>Privacy Policy</h6></a>
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
