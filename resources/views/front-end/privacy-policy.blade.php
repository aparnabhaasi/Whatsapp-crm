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
					<div class="card p-5" style="border-radius: 15px;">
							<h3 class="text-center" style="color: #25D366;"><b>Privacy Policy</b></h3>
                            <hr>
                            <p style="text-align: justify; font-size: 18px;">This Privacy Policy explains how we collect, use, and protect your information when you 
                                use our WhatsApp CRM solution. By logging in via WhatsApp, you provide us with your WhatsApp 
                                User ID and profile details, which we use to authenticate your account and integrate your 
                                WhatsApp communications with our CRM system. This allows us to provide you with a seamless 
                                and personalized user experience.We collect and use various types of data to enhance the 
                                functionality of our CRM, including interaction data (such as messages and contact information) 
                                and usage statistics. This information helps us tailor our services to your needs, improve 
                                app performance, and offer targeted support. Your data is securely managed and is not sold or 
                                traded to third parties. We implement robust security measures to protect your information 
                                from unauthorized access and misuse. While we strive to maintain high standards of security, 
                                please note that no online system is entirely immune to risks. You have the right to access, 
                                update, or delete your information, and you can opt out of promotional communications at any 
                                time through your CRM settings. By using our WhatsApp CRM, you agree 
                                to the terms outlined in this policy. Thank you for trusting ICT with your data.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- footer -->
		@endsection 
	</div>

</body>

<!-- script fory copying the content from input -->
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
<!-- <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script> -->
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>
<script src="assets/js/demo.js"></script>
</html>