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

	<!-- bootstrap -->
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
					@if(session('error'))
					<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                        <p class="mb-0">{{ session('error') }}</p>
                        <a type="button" class="" data-bs-dismiss="alert" aria-label="Close" style="cursor:pointer; color:#fff;">X</a>
                    </div>
					@endif
					@if(session('success'))
					<div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                        <p class="mb-0">{{ session('success') }}</p>
                        <a type="button" class="" data-bs-dismiss="alert" aria-label="Close" style="cursor:pointer; color:#fff;">X</a>
                    </div>
					@endif
						<div class="row">
							<div class="col-12">
								<h5 class="text-center">Message Templates</h5>
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
														.badge-cus{
															padding: 10px;
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
												<a href="add-template" class="btn btn-outline-success">Add new Template <i class="fa-regular fa-newspaper"></i></a>
											</div>
	                                    </div>

	                                </div>
	                                <div class="card-body">
	                                    <div class="table-responsive">
	                                    	<table class="table table-hover">
		                                        <thead>
		                                            <tr class="bg-light">
		                                                <th scope="col">#</th>
		                                                <th scope="col">Template Name</th>
														<th scope="col">Category</th>
		                                                <th scope="col">Language</th>
														<th scope="col">Status</th>
		                                                <th scope="col" class="text-center">Action</th>
		                                            </tr>
		                                        </thead>
		                                        <tbody>

												@foreach ($templates as $template)
		                                            <tr>
		                                                <td>{{$loop->iteration}}</td>
		                                                <td>{{$template['name']}}</td>
		                                                <td>{{$template['category']}}</td>
		                                                <td>{{$template['language']}}</td>
														<td>
															<span class="badge
																@if($template['status'] === 'APPROVED')
																	badge-success
																@elseif($template['status'] === 'REJECTED')
																	badge-danger
																@else
																	badge-warning
																@endif
															">
																{{$template['status']}}
															</span>
														</td>
		                                                <td class="justify-content-center d-flex">
		                                                    <a href="" class="text-info mx-2" data-toggle="modal" data-target="#viewTemplateModal{{$template['id']}}" title="View Broadcast Details">
		                                                        <i class="fa-solid fa-eye bg-light border rounded-circle p-2"></i>
		                                                    </a>
															<!-- <a href="" class="text-dark" data-toggle="modal" data-target=".updateBroadcast" title="Edit Broadcast">
		                                                        <i class="fa-solid fa-pen bg-light border rounded-circle p-2"></i>
		                                                    </a> -->
															<form method="post" action="{{ route('template.destroy', $template['id']) }}">
																@csrf
																@method('DELETE')
																<input type="hidden" name="template_name" value="{{ $template['name'] }}">
																<button class="text-danger cus-del-btn" style="border:none; background:transparent; cursor:pointer;" title="Delete" onclick="return confirm('Are you sure you want to delete this template?')">
			                                                        <i class="fa-solid fa-trash-can bg-light border rounded-circle p-2"></i>
			                                                    </button>
															</form>
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


			<style>
				.mesages-card-container{
					background-image: url(assets/img/chat-bg-yellow.png);
					background-size: cover;
					padding: 30px;
					margin-bottom: 8px;
					border-radius: 10px;
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
				.b2{
					font-weight: 700;
				}
			
			</style>
			<!-- View Template Modal -->
			 @foreach ($templates as $template)
				<div class="modal fade" id="viewTemplateModal{{$template['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h6 class="modal-title" id="exampleModalLongTitle">{{$template['name']}}</h6>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="mesages-card-container">
									<div class="message-card">

										<!-- header -->
										@if (isset($template['components']))
											@foreach ($template['components'] as $component)
												<!-- text -->
												@if ($component['type']=== 'HEADER' && $component['format'] === 'TEXT')
													<p><b>{{$component['text']}}</b></p>

												<!-- image -->
												@elseif($component['type'] === 'HEADER' && $component['format'] === 'IMAGE')
													@if (isset($component['example']['header_handle'][0]))
														<img src="{{ $component['example']['header_handle'][0] }}" alt="Header Image">
													@endif

												<!-- video -->
												@elseif($component['type'] === 'HEADER' && $component['format'] === 'VIDEO')
													@if (isset($component['example']['header_handle'][0]))
														<video width="100%" controls>
															<source src="{{ $component['example']['header_handle'][0] }}" type="video/mp4">
															Your browser does not support the video tag.
														</video>
													@else
														<p>No video available</p>
													@endif

												<!-- document -->
												 @elseif($component['type'] === 'HEADER' && $component['format'] === 'DOCUMENT')
												 	@if (isset($component['example']['header_handle'][0]))
													 <embed src="{{ $component['example']['header_handle'][0] }}" type="application/pdf" width="100%">
													@endif
												@endif
											@endforeach
										@endif

										<!-- body -->
										<style>
											.custom-monospace {
												color: black;
												font-family: monospace;
											}
										</style>

										@if (isset($template['components']))
											@foreach ($template['components'] as $component)
												@if ($component['type'] === 'BODY')
													<p class="mt-3">
														{!! nl2br(
															preg_replace(
																[
																	'/\*(.*?)\*/', // Bold
																	'/_(.*?)_/',   // Italics
																	'/~(.*?)~/',   // Strikethrough
																	'/`(.*?)`/',   // Monospace
																],
																[
																	'<strong>$1</strong>',
																	'<em>$1</em>',
																	'<del>$1</del>',
																	'<span class="custom-monospace">$1</span>', // Apply custom class for monospace
																],
																e($component['text'])
															)
														) !!}
													</p>
												@endif
											@endforeach
										@endif

										<!-- footer -->
										<div class="d-flex justify-content-between align-items-center">
											@if (isset($template['components']))
												@foreach ($template['components'] as $component)
													@if ($component['type'] === 'FOOTER')
													<p id="footerContent" style="color: #acacac;">{{$component['text']}}</p>
													@endif
												@endforeach
											@endif
										
											
											<p id="currentTime" style="color: #acacac;">10:10 am</p>
										</div>
										

										<!-- Buttons Section -->
										@if (isset($template['components']))
											@foreach ($template['components'] as $component)
												@if ($component['type'] === 'BUTTONS')
													<div class="text-center">
														@foreach ($component['buttons'] as $button)
															<!-- Display URL Button -->
															@if ($button['type'] === 'URL')
																<hr>
																<a href="{{ $button['url'] }}" target="_blank">
																	<h6>
																		<i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp; {{ $button['text'] }}
																	</h6>
																</a>
															@endif

															<!-- Display Call Phone Number Button -->
															@if ($button['type'] === 'PHONE_NUMBER')
																<hr>
																<a href="tel:{{ $button['phone_number'] }}">
																	<h6>
																		<i class="fa-solid fa-phone"></i>&nbsp; {{ $button['text'] }}
																	</h6>
																</a>
															@endif

															<!-- Display Copy Offer Code Button -->
															@if ($button['type'] === 'COPY_CODE' && isset($button['example'][0]))
																<hr>
																<a href="javascript:void(0)" onclick="copyToClipboard('{{ $button['example'][0] }}')">
																	<h6>
																		<i class="fa-regular fa-copy"></i>&nbsp; {{ $button['text'] }}
																	</h6>
																</a>
															@endif
														@endforeach
													</div>
												@endif
											@endforeach
										@endif

										<!-- JavaScript for Copy Offer Code Button -->
										<script>
											function copyToClipboard(text) {
												navigator.clipboard.writeText(text).then(function () {
													alert('Offer code copied to clipboard!');
												}, function (err) {
													console.error('Could not copy text: ', err);
												});
											}
										</script>

			
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			@endforeach
	
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