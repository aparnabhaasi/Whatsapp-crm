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

	 <!-- export as excel -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
	                        
	                        <div class="col-12 text-right pb-4 d-flex justify-content-between">
								<h4 class="page-title">Contacts</h4>
	                            <div>
									<button class="btn btn-primary" onclick="exportTableToExcel('contactsTable', 'contacts')">
										Export Contacts <i class="fa-solid fa-file-arrow-down"></i>
									</button>

		                            <button class="btn btn-success" data-toggle="modal" data-target="#bulkUploadModal">Bulk Upload <i class="fa-solid fa-upload"></i></button>
	                            </div>
	                        </div>
	
	                        <div class="col-12">
	
	                            <div class="card" style="border-radius: 15px;">
	                                <div class="card-header d-md-flex justify-content-between">
	                                    <div class="d-md-flex align-items-center">
	                                    	<form class="navbar-left navbar-form nav-search mr-md-3" action="">
		                                        <style>
		                                            .search-container {
		                                                border: .5px solid transparent;
		                                                border-radius: 30px;
		                                                transition: border-color 0.3s;
														width: 400px;
		                                            }
		                                            .search-container:hover,
		                                            .search-container:focus-within {
		                                                border-color: #25D366 !important;
		                                            }
		                                        </style>
		                                        <div class="input-group search-container">
													<input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search ..." class="form-control search-input">
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

										<button class="btn btn-outline-success my-1" data-toggle="modal" data-target="#addContactModal">
											Add Contact <i class="fa-solid fa-user-plus"></i>
										</button>
	                                </div>
	                                <div class="card-body">
										<div class="table-responsive">
											<table class="table table-hover" id="contactsTable">
												<thead>
													<tr class="bg-light">
														<th scope="col">#</th>
														<th scope="col">Name</th>
														<th scope="col">WhatsApp Number</th>
														<th scope="col">Email</th>
														<th scope="col" class="text-center">Tags</th>
														<th scope="col" class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													@foreach ($contacts as $contact)
													<tr>
														<td>{{$loop->iteration}}</td>
														<td>{{$contact->name}}</td>
														<td>+ {{$contact->mobile}}</td>
														<td>{{$contact->email}}</td>
														<td class="text-center">
															@if (is_array(json_decode($contact->tags)))
																@foreach (json_decode($contact->tags) as $tag)
																	<span class="badge badge-count">{{ $tag }}</span>
																@endforeach
															@endif
														</td>
														<td class="text-center d-flex justify-content-center">
															<a href="" class="text-info mx-1" title="Edit" data-toggle="modal" data-target="#editContactModal{{$contact->id}}">
																<i class="fa fa-pen-to-square bg-light border rounded-circle p-2"></i>
															</a>
															<form method="POST" action="{{ route('contacts.destroy', $contact->id) }}">
																@csrf
																@method('DELETE')
																<a href="#" class="text-danger mx-1" onclick="confirmMessage(event, this)" title="Delete">
																	<i class="fa fa-trash-can bg-light border rounded-circle p-2"></i>
																</a>
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

				@endsection
			</div>
			

<script>
	function searchTable() {
    // Get the value of the search input
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();

    // Get the table and all rows
    let table = document.getElementById("contactsTable");
    let rows = table.getElementsByTagName("tr");

    // Loop through all rows, excluding the table header
    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName("td");
        let match = false;

        // Check each cell in the row
        for (let j = 0; j < cells.length; j++) {
            let cellValue = cells[j].innerText.toLowerCase();

            // If the cell contains the search term, mark it as a match
            if (cellValue.includes(filter)) {
                match = true;
                break;
            }
        }

        // If a match is found, display the row, otherwise hide it
        if (match) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

</script>


	<!-- Bulk upload Modal -->
	<div class="modal fade" id="bulkUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content" style="border-radius: 30px !important;">
				<div class="modal-body p-4">
					<style>
						.file-upload {
						max-width: 100%;
						display: none;
						}

						.labelFile {
						display: flex;
						flex-direction: column;
						justify-content: center;
						width: 100%;
						height: 190px;
						border: 2px dashed #25D366  ;
						border-radius: 15px;
						align-items: center;
						text-align: center;
						padding: 5px;
						color: #404040;
						cursor: pointer;
						}
						.download-file{
							border-bottom: 1px solid gray;
							margin-bottom: 15px;
							padding-bottom: 10px;
						}
					</style>

					<div class="d-flex justify-content-between align-items-center download-file">
						<p>Download example file to upload</p>
						<a href="assets/contact/Contact_Book_Sample.xlsx" download class="btn btn-outline-primary btn-sm" style="border-radius:50px;">
							Download <i class="fa-regular fa-circle-down"></i>
						</a>
					</div>


					<label for="file" class="labelFile">
						<span><svg 
						xml:space="preserve"
						viewBox="0 0 184.69 184.69"
						xmlns:xlink="http://www.w3.org/1999/xlink"
						xmlns="http://www.w3.org/2000/svg"
						id="Capa_1"
						version="1.1"
						width="60px"
						height="60px">
						<g>
							<g>
							<g>
								<path
								d="M149.968,50.186c-8.017-14.308-23.796-22.515-40.717-19.813
									C102.609,16.43,88.713,7.576,73.087,7.576c-22.117,0-40.112,17.994-40.112,40.115c0,0.913,0.036,1.854,0.118,2.834
									C14.004,54.875,0,72.11,0,91.959c0,23.456,19.082,42.535,42.538,42.535h33.623v-7.025H42.538
									c-19.583,0-35.509-15.929-35.509-35.509c0-17.526,13.084-32.621,30.442-35.105c0.931-0.132,1.768-0.633,2.326-1.392
									c0.555-0.755,0.795-1.704,0.644-2.63c-0.297-1.904-0.447-3.582-0.447-5.139c0-18.249,14.852-33.094,33.094-33.094
									c13.703,0,25.789,8.26,30.803,21.04c0.63,1.621,2.351,2.534,4.058,2.14c15.425-3.568,29.919,3.883,36.604,17.168
									c0.508,1.027,1.503,1.736,2.641,1.897c17.368,2.473,30.481,17.569,30.481,35.112c0,19.58-15.937,35.509-35.52,35.509H97.391
									v7.025h44.761c23.459,0,42.538-19.079,42.538-42.535C184.69,71.545,169.884,53.901,149.968,50.186z"
								style="fill:#25D366 ;"
								></path>
							</g>
							<g>
								<path
								d="M108.586,90.201c1.406-1.403,1.406-3.672,0-5.075L88.541,65.078
									c-0.701-0.698-1.614-1.045-2.534-1.045l-0.064,0.011c-0.018,0-0.036-0.011-0.054-0.011c-0.931,0-1.85,0.361-2.534,1.045
									L63.31,85.127c-1.403,1.403-1.403,3.672,0,5.075c1.403,1.406,3.672,1.406,5.075,0L82.296,76.29v97.227
									c0,1.99,1.603,3.597,3.593,3.597c1.979,0,3.59-1.607,3.59-3.597V76.165l14.033,14.036
									C104.91,91.608,107.183,91.608,108.586,90.201z"
								style="fill:#25D366 ;"
								></path>
							</g>
							</g>
						</g></svg></span>
					<p style="color: #25D366 ;">drag and drop your file here or click to select a file!</p></label>
					<form action="{{ route('contacts.upload') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<input class="input file-upload" name="file" id="file" type="file" />
						<div class="text-center pt-3">
							<button type="button" class="btn btn-danger mx-2" data-dismiss="modal">Cancel <i class="fa-solid fa-ban"></i></button>
							<button type="submit" class="btn btn-success mx-2">Upload <i class="fa fa-upload"></i></button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>



	<!-- Add contact Modal start -->
	<div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h6 id="exampleModalLongTitle">Add new Contact</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{ route('contacts.store') }}">
						@csrf
						<div class="form-group">
							<label for="pillInput1">Name</label>
							<input type="text" name="name" class="form-control input-pill" id="pillInput1" placeholder="Enter name">
						</div>
						<div class="form-group">
							<label for="pillInput2">WhatsApp number</label>
							<input type="text" name="mobile" class="form-control input-pill" id="pillInput2" placeholder="Eg: 91 999999999">
						</div>
						<div class="form-group">
							<label for="pillInput3">Email</label>
							<input type="text" name="email" class="form-control input-pill" id="pillInput3" placeholder="Eg: mail@domain.com">
						</div>

						<div class="form-group">
							<label for="tagInput">Tags</label>
							<div class="input-group">
								<input type="text" class="form-control input-pill" id="tagInput" placeholder="Eg: lead">
								<div class="input-group-append">
									<button class="btn btn-rounded" type="button" id="addTagButton">Add Tag +</button>
								</div>
							</div>
						</div>
						<div id="badgeContainer"></div>

						<!-- Hidden input to store tags array -->
						<input type="hidden" name="tags" id="tagsArray">

						<script>
							let tags = [];

							document.getElementById('addTagButton').addEventListener('click', function() {
								var input = document.getElementById('tagInput');
								var tagText = input.value.trim();

								if (tagText !== '' && !tags.includes(tagText)) {
									tags.push(tagText);
									updateTagsInput();

									var badgeContainer = document.getElementById('badgeContainer');
									var newBadge = document.createElement('span');
									newBadge.className = 'badge badge-count mx-1';

									// Create the close icon
									var closeIcon = document.createElement('span');
									closeIcon.innerHTML = '&times;';
									closeIcon.className = 'ml-2 close-icon';
									closeIcon.style.cursor = 'pointer';

									closeIcon.addEventListener('click', function() {
										badgeContainer.removeChild(newBadge);
										tags = tags.filter(tag => tag !== tagText);
										updateTagsInput();
									});

									newBadge.innerText = tagText;
									newBadge.appendChild(closeIcon);
									badgeContainer.appendChild(newBadge);

									input.value = '';
								}
							});

							document.getElementById('tagInput').addEventListener('keypress', function(e) {
								if (e.key === 'Enter') {
									e.preventDefault();
									document.getElementById('addTagButton').click();
								}
							});

							function updateTagsInput() {
								document.getElementById('tagsArray').value = JSON.stringify(tags);
							}
						</script>

						<div class="mt-2 text-right">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary px-5">Save</button>
						</div>
					</form>
				</div>



					
			</div>
		</div>
	</div>
	<!-- Add contact Modal end -->


	<!-- Edit contact Modal start -->
	@foreach ($contacts as $contact)
	<div class="modal fade editContactModal" id="editContactModal{{$contact->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle{{$contact->id}}" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h6 id="exampleModalLongTitle{{$contact->id}}">Edit Contact</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{ route('contacts.update', $contact->id) }}">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="editPillInput1{{$contact->id}}">Name</label>
							<input type="text" name="name" value="{{ $contact->name }}" class="form-control input-pill" id="editPillInput1{{$contact->id}}" placeholder="Enter name">
						</div>
						<div class="form-group">
							<label for="editPillInput2{{$contact->id}}">WhatsApp number</label>
							<input type="text" name="mobile" value="{{ $contact->mobile }}" class="form-control input-pill" id="editPillInput2{{$contact->id}}" placeholder="Eg: 91 999999999">
						</div>
						<div class="form-group">
							<label for="editPillInput3{{$contact->id}}">Email</label>
							<input type="text" name="email" value="{{ $contact->email }}" class="form-control input-pill" id="editPillInput3{{$contact->id}}" placeholder="Eg: mail@domain.com">
						</div>

						<div class="form-group">
							<label for="editTagInput{{$contact->id}}">Tags</label>
							<div class="input-group">
								<input type="text" class="form-control input-pill" id="editTagInput{{$contact->id}}" placeholder="Eg: lead">
								<div class="input-group-append">
									<button class="btn btn-rounded" type="button" id="editAddTagButton{{$contact->id}}">Add Tag +</button>
								</div>
							</div>
						</div>
						<div id="editBadgeContainer{{$contact->id}}"></div>

						<input type="hidden" name="tags" id="editTagsArray{{$contact->id}}" value="{{ $contact->tags ? json_encode(json_decode($contact->tags)) : '[]' }}">

						<div class="mt-2 text-right">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary px-5">Save changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endforeach

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		@foreach ($contacts as $contact)
		(function(contactId) {
			let tags = @json(json_decode($contact->tags, true)) || [];
			let badgeContainer = document.getElementById('editBadgeContainer' + contactId);
			let tagInput = document.getElementById('editTagInput' + contactId);
			let addTagButton = document.getElementById('editAddTagButton' + contactId);
			let tagsArrayInput = document.getElementById('editTagsArray' + contactId);

			function updateTagsInput() {
				tagsArrayInput.value = JSON.stringify(tags);
			}

			function loadTags() {
				badgeContainer.innerHTML = '';
				tags.forEach(tag => {
					let newBadge = document.createElement('span');
					newBadge.className = 'badge badge-count mx-1';

					let closeIcon = document.createElement('span');
					closeIcon.innerHTML = '&times;';
					closeIcon.className = 'ml-2 close-icon';
					closeIcon.style.cursor = 'pointer';

					closeIcon.addEventListener('click', function() {
						badgeContainer.removeChild(newBadge);
						tags = tags.filter(t => t !== tag);
						updateTagsInput();
					});

					newBadge.innerText = tag;
					newBadge.appendChild(closeIcon);
					badgeContainer.appendChild(newBadge);
				});
			}

			addTagButton.addEventListener('click', function() {
				let tagText = tagInput.value.trim();

				if (tagText !== '' && !tags.includes(tagText)) {
					tags.push(tagText);
					updateTagsInput();
					loadTags();
					tagInput.value = '';
				}
			});

			tagInput.addEventListener('keypress', function(e) {
				if (e.key === 'Enter') {
					e.preventDefault();
					addTagButton.click();
				}
			});

			loadTags();
		})('{{ $contact->id }}');
		@endforeach
	});
	</script>

	<!-- Edit contact Modal end -->
	
	<!-- export as excel -->
	<script>
		function exportTableToExcel(tableID, filename = '') {
			// Select the table element
			const table = document.getElementById(tableID);
			const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet 1" });

			// Create the file name if not provided
			filename = filename ? filename + '.xlsx' : 'excel_data.xlsx';

			// Use SheetJS to write and download the Excel file
			XLSX.writeFile(workbook, filename);
		}
	</script>

	<!-- confirm message -->
	<script>
		function confirmMessage(event, element) {
			event.preventDefault(); // Prevent default link behavior

			if (confirm('Are you sure you want to delete this contact? This will also delete chat history')) {
				// Find the closest form and submit it
				const form = element.closest('form');
				if (form) {
					form.submit();
				}
			}
		}
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