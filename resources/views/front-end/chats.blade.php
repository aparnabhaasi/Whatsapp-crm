<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>WhatsApp CRM</title>
	<link rel="icon" type="image/x-icon" href="https://i.postimg.cc/02RpgdM2/whatsapp3d.png">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
		name='viewport' />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="assets/css/ready.css">
	<link rel="stylesheet" href="assets/css/demo.css">
	<link rel="stylesheet" href="assets/css/chat.css">

	<!-- font awsome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

	
	<style>
		.listHead h4 {
			margin-bottom: 0px;
		}

		.message_p p {
			margin-bottom: 0px;
		}

		.imgBox {
			width: 40px;
			height: 45px;
			color: #fff;
			display: flex;
			align-items: center;
			justify-content: center;
			text-align: center;
		}

		.profile-letters {
			margin-bottom: 0px;
			font-size: 17px;
			font-weight: 600;
		}

		.paperclip {
			margin-right: -20px !important;
			cursor: pointer !important;
			margin-bottom: 0px !important;
			background: #fff !important;
			padding: 20px !important;
			padding-right: 14px !important;
			border-radius: 30px 0px 0px 30px !important;
		}

		.popup-menu {
			display: none;
			position: absolute;
			background-color: #fff;
			color: #333;
			border-radius: 8px;
			padding: 10px;
			list-style-type: none;
			bottom: 50px;
			/* Position above the paperclip icon */
			left: 20px;
			/* Adjust to horizontal position of the icon */
			z-index: 1000;
			/* Ensure it has a higher z-index than other elements */
		}


		.popup-menu ul {
			padding: 0;
			list-style-type: none;
		}

		.popup-menu ul li {
			padding: 10px;
			cursor: pointer;
		}

		.popup-menu ul li i {
			margin-right: 10px;
		}

		.popup-menu ul li:hover {
			background-color: #e4e4e4;
		}

		.document-label {
			display: inline-block;
			cursor: pointer;
		}
		.noChatSelected {
            text-align: center;
			margin: 0;
            padding: 0;
            justify-content: center;
            align-items: center !important;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
			padding-top: 150px;
			flex: 70%;
        }
        .logo-for-chat {
            font-size: 100px;
            color: #cccccc;
        }
        .title-for-chat {
            font-size: 24px;
            margin-top: 20px;
            color: #333333;
        }
        .subtitle-for-chat {
            font-size: 14px;
            color: #666666;
            margin-top: 10px;
        }
        .subtitle-for-chat a {
            color: #2980b9;
            text-decoration: none;
        }
        .subtitle-for-chat a:hover {
            text-decoration: underline;
        }
        .encryption-for-chat {
            margin-top: 50px;
            font-size: 12px;
            color: #666666;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .encryption-for-chat img {
            width: 16px;
            height: 16px;
            margin-right: 5px;
        }
		.rightSide{
			display: none;
		}

		
		.scroll-btn {
			position: fixed;
			bottom: 100px;
			right: 10px;
			z-index: 10;
		}

		.popup-menu {
            display: none;
            position: absolute;
            background-color: white;
            border: 1px solid #ddd;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .popup-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .popup-menu ul li {
            padding: 5px 10px;
            cursor: pointer;
        }

        .popup-menu ul li:hover {
            background-color: #f1f1f1;
        }

        .media-preview-container {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
            display: none; /* Initially hidden */
            position: relative;
			width: 40%;
        }

        .close-button {
            font-size: 18px;
            color: #888;
			background: #fff;
			padding: 2px 4px;
			border-radius: 50%;
        }

        .close-button:hover {
            color: #000;
        }
	</style>
</head>

<body>

	<!-- header -->
	@extends('layout.app')

	@section('content')

	<div class="main-panel">
		<div class="content p-0">

			<div class="containerx" id="containerx">
				<div class="leftSide">
					<!-- Header -->
					<div class="header">
						<h6 style="font-weight:700;">Chats</h6>
						<ul class="nav_icons">
							<li><i class="fa-solid fa-expand" id="fullscreen-icon"></i></li>
							<li>
								<i class="fa-solid fa-tags" id="dropdownMenuButton" data-toggle="dropdown"
									aria-haspopup="true" aria-expanded="false"></i>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="#">Social Media</a>
									<a class="dropdown-item" href="#">Meta</a>
									<a class="dropdown-item" href="#">Google</a>
								</div>
							</li>
							<li>
								<ion-icon name="ellipsis-vertical" id="dropdownMenuButton"
									data-toggle="dropdown"></ion-icon>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item" href="#">Unread</a>
									<a class="dropdown-item" href="#">Broadcast</a>
									<a class="dropdown-item" href="#">Contacts</a>
								</div>
							</li>
						</ul>
					</div>

					<!-- Search Chat -->
					<div class="search_chat">
						<div>
							<input type="text" placeholder="Search or start new chat">
							<ion-icon name="search-outline"></ion-icon>
						</div>
					</div>

					<!-- CHAT LIST -->
					<div class="chatlist">

						@php
							// Array of solid background colors
							$colors = ['#FF5733', '#00951a', '#3357FF', '#FF33A1', '#003e9a', '#FFBD33', '#A133FF'];

							// Function to assign a fixed color based on the contact ID
							function getColorForContact($contactId, $colors)
							{
								return $colors[$contactId % count($colors)];
							}

							// Group messages by contact_id and get the last message for each contact
							$groupedMessages = $messages->groupBy('contact_id')->map(function ($group) {
								return $group->last();
							})->sortByDesc('created_at'); // Sort the grouped messages by the created_at in descending order

							// Calculate the unread chats count for each contact
							$unreadChatsCounts = \App\Models\Chats::select('contact_id', \DB::raw('COUNT(*) as unread_count'))
								->where('is_read', false)
								->groupBy('contact_id')
								->pluck('unread_count', 'contact_id');
						@endphp

						@foreach ($groupedMessages as $contactId => $message)
												@php
													// Assign a fixed color for each contact based on their ID
													$fixedColor = getColorForContact($message->contact->id, $colors);

													// Get the number of unread chats for the current contact
													$unreadChatsCount = $unreadChatsCounts[$contactId] ?? 0;
												@endphp

												<!-- Apply the 'unread' class only if there are unread chats -->
												<div class="block {{ $unreadChatsCount > 0 ? 'unread' : '' }}"
													id="chat{{ $message->contact_id }}"
													onclick="activateChat('chat{{ $message->contact_id }}')">
													<div class="imgBox" style="background: {{ $fixedColor }};">
														<p class="profile-letters">{{ strtoupper(substr($message->contact->name, 0, 2)) }}</p>
													</div>
													<div class="details">
														<div class="listHead">
															<h4>{{ $message->contact->name }}</h4>
															<p class="time">{{ $message->created_at->format('h:i a') }}</p>
														</div>
														<div class="message_p">
															<p>{{ $message->message }}</p>

															<!-- Display the number of unread chats if there are any -->
															@if ($unreadChatsCount > 0)
																<b>{{ $unreadChatsCount }}</b>
															@endif
														</div>
													</div>
												</div>
						@endforeach

					</div>
				</div>

				<!-- No chat selected -->
				<div class="container noChatSelected">
					<div class="logo-for-chat"><i class="fa-brands fa-whatsapp"></i></div>
					<div class="title-for-chat">WhatsApp CRM</div>
					<div class="subtitle-for-chat">
						Manage your customer conversations efficiently with our WhatsApp CRM. <br> To get started, choose a contact from the left, or add a new one.
					</div>
					<div class="encryption-for-chat">
						<img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" alt="Lock icon">
						All messages are end-to-end encrypted for secure communication.
					</div>
				</div>


				<!-- right side -->
				<div class="rightSide">

					<div class="header chatHeader">
						<div class="imgText">
							<div class="userimg">

							</div>
							<h6 class="ml-3">ICT Global Tech Pvt. Ltd. <br><small>online</small></h6>
						</div>
						<ul class="nav_icons">
							<li><ion-icon name="search-outline"></ion-icon></li>
							<li><ion-icon name="ellipsis-vertical"></ion-icon></li>
						</ul>
					</div>

					<style>
						.message-card {
							background: #dcf8c8;
							padding: 8px;
							border-radius: 10px;
							max-width: 45%;
							margin-left: auto;
							margin-bottom: 15px;
						}

						.message-card img {
							width: 100%;
							border-radius: 10px;
						}

						.message-card p,
						a {
							font-family: Helvetica, Arial, sans-serif;
						}
						.messageDate {
							background: #f6f8ff;
							display: inline-block;
							border-radius: 8px;
							padding: 6px;
							font-size: 12px;
							font-weight: 700;
							color: #918d8d;
						}

					</style>

					<!-- CHAT-BOX -->
					<div class="chatbox" id="chatbox">
						@foreach ($messages->groupBy('contact_id') as $contactId => $contactMessages)
							@php
								$combinedMessages = [];

								// Add customer and business messages to the combined array
								foreach ($contactMessages as $message) {
									$combinedMessages[] = [
										'type' => 'chat',
										'sender' => $message->sender,
										'message' => $message->message,
										'created_at' => $message->created_at
									];
								}

								// Add broadcast template messages to the combined array
								foreach ($broadcasts as $broadcast) {
									if (is_array($broadcast->contact_id) && in_array($contactId, $broadcast->contact_id)) {
										if (isset($templateData[$broadcast->id])) {
											foreach ($templateData[$broadcast->id] as $templateId => $template) {
												$combinedMessages[] = [
													'type' => 'template',
													'broadcast_id' => $broadcast->id,
													'template_id' => $templateId,
													'components' => $template['components'],
													'created_at' => \Carbon\Carbon::parse($broadcastMessages[$broadcast->id][$templateId]['created_at'])
												];
											}
										}
									}
								}

								// Sort combined messages by created_at
								usort($combinedMessages, function($a, $b) {
									return $a['created_at']->timestamp <=> $b['created_at']->timestamp;
								});

								// Variable to keep track of last message date
								$lastMessageDate = null;

								// Get current date and yesterday's date
								$currentDate = \Carbon\Carbon::now()->format('d-m-Y');
								$yesterdayDate = \Carbon\Carbon::yesterday()->format('d-m-Y');
							@endphp

							<!-- Chat content for each contact -->
							<div id="chat{{ $contactId }}Content" class="chatContent" style="display: none;">
								@foreach ($combinedMessages as $item)
									@php
										// Format message date
										$currentMessageDate = $item['created_at']->format('d-m-Y');

										// Check if the date is today, yesterday, or another date
										if ($currentMessageDate === $currentDate) {
											$displayDate = 'Today';
										} elseif ($currentMessageDate === $yesterdayDate) {
											$displayDate = 'Yesterday';
										} else {
											$displayDate = $currentMessageDate;
										}
									@endphp

									@if ($lastMessageDate !== $currentMessageDate)
										<!-- Display Date Before the First Message of the Day -->
										<div class="text-center">
											<p class="messageDate">{{ $displayDate }}</p>
										</div>
										@php
											$lastMessageDate = $currentMessageDate;
										@endphp
									@endif

									@if ($item['type'] === 'chat')
										<!-- Display Chat Messages -->
										@if ($item['sender'] === 'customer')
											<div class="message friend_msg">
												<p>{{ $item['message'] }} <br><span>{{ $item['created_at']->format('h:i a') }}</span></p>
											</div>
										@elseif ($item['sender'] === 'business')
											<div class="message my_msg">
												@if (!empty($item['media_url']))

													@if ($item['media_type'] === 'image')
														<img src="{{ $item['media_url'] }}" alt="Image" style="max-width: 100%; border-radius: 5px;">
													@elseif ($item['media_type'] === 'video')
														<video controls style="max-width: 100%; border-radius: 5px;">
															<source src="{{ $item['media_url'] }}" type="video/mp4">
															Your browser does not support the video tag.
														</video>
													@elseif ($item['media_type'] === 'document')
														<embed src="{{ $item['media_url'] }}" type="application/pdf" width="100%" style="border-radius: 5px;">
													@endif
													
												@endif

												<p>
													{{ $item['message'] }} <span>{{ $item['created_at']->format('h:i a') }}</span>
												</p>
											</div>
										@endif
									@elseif ($item['type'] === 'template')
										<!-- Display Template Messages -->
										<div class="message-card my_msg">
											<!-- Header Section -->
											@foreach ($item['components'] as $component)
												@if ($component['type'] === 'HEADER')
													@if ($component['format'] === 'TEXT' && isset($component['text']))
														<p><b>{{ $component['text'] }}</b></p>
													@elseif($component['format'] === 'IMAGE' && isset($broadcastMessages[$item['broadcast_id']][$item['template_id']]['media']))
														<img src="storage/{{ $broadcastMessages[$item['broadcast_id']][$item['template_id']]['media'] }}" alt="Header Image" />
													@elseif($component['format'] === 'VIDEO' && isset($component['example']['header_handle'][0]))
														<video width="100%" controls>
															<source src="{{ $component['example']['header_handle'][0] }}" type="video/mp4">
															Your browser does not support the video tag.
														</video>
													@elseif($component['format'] === 'DOCUMENT' && isset($component['example']['header_handle'][0]))
														<embed src="{{ $component['example']['header_handle'][0] }}" type="application/pdf" width="100%">
													@endif
												@endif
											@endforeach

											<!-- Body Section -->
											@foreach ($item['components'] as $component)
												@if ($component['type'] === 'BODY' && isset($component['text']))
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

											<div class="d-flex position-relative" style="min-height: 20px;">
												<!-- Footer Section -->
												@foreach ($item['components'] as $component)
													@if ($component['type'] === 'FOOTER' && isset($component['text']))
														<p id="footerContent" style="color: #acacac; font-size: 12px; position: absolute; left: 0; margin: 0;">
															{{ $component['text'] }}
														</p>
													@endif
												@endforeach

												<!-- Display Time for Template Message -->
												<p id="messageTime" style="color: #acacac; font-size: 12px; position: absolute; right: 0; margin: 0;">
													{{ $item['created_at']->format('h:i A') }}
												</p>
											</div>

											<!-- Buttons Section -->
											@foreach ($item['components'] as $component)
												@if ($component['type'] === 'BUTTONS')
													<div class="text-center">
														@foreach ($component['buttons'] as $button)
															@if ($button['type'] === 'URL')
																<hr>
																<a href="{{ $button['url'] }}" target="_blank">
																	<h6>
																		<i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp; {{ $button['text'] }}
																	</h6>
																</a>
															@elseif ($button['type'] === 'PHONE_NUMBER')
																<hr>
																<a href="tel:{{ $button['phone_number'] }}">
																	<h6>
																		<i class="fa-solid fa-phone"></i>&nbsp; {{ $button['text'] }}
																	</h6>
																</a>
															@elseif ($button['type'] === 'COPY_CODE' && isset($button['example'][0]))
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
										</div>
									@endif
								@endforeach
							</div>
						@endforeach

						<button class="scroll-btn btn btn-light"><i class="fa-solid fa-arrow-down"></i></button>
					</div>




					<!-- CHAT INPUT -->
					<div class="chat_input">
    <ion-icon name="happy-outline"></ion-icon>

    <p class="document-label" style="margin-bottom:0px;">
        <i class="paperclip fa fa-paperclip fa-xl" id="paperclip"></i>
    </p>

    <input type="text" id="messageInput" placeholder="Type a message">

    <div class="whatsapp-button-container">
        <button type="submit" class="whatsapp-button" id="sendMessage" style="cursor:pointer;">
            <i class="fa fa-paper-plane send-icon"></i>
        </button>
    </div>

    <!-- Popup with media upload options -->
    <div id="popupMenu" class="popup-menu" style="display: none;">
        <ul>
            <li id="photoUpload"><i class="fa fa-image"></i> Photos</li>
            <li id="videoUpload"><i class="fa fa-video"></i> Videos</li>
            <li id="documentUpload"><i class="fa fa-file"></i> Document</li>
        </ul>
    </div>

    <!-- Hidden file input elements -->
    <input type="file" id="imageInput" accept="image/*" style="display:none;">
    <input type="file" id="videoInput" accept="video/*" style="display:none;">
    <input type="file" id="documentInput" accept=".pdf,.doc,.docx,.txt" style="display:none;">

    <!-- Media preview area -->
    <div id="mediaPreviewContainer" class="media-preview-container" style="display:none; position: absolute; bottom: 40px; left: 10px; background: #fff; border: 1px solid #ddd; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 10px; z-index: 100;">
        <span class="close-button" id="closePreview" style="position: absolute; top: 5px; right: 5px; cursor: pointer;">&times;</span>
        <div id="previewContent"></div>
    </div>

    <!-- Include Axios via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const paperclipIcon = document.getElementById('paperclip');
            const popupMenu = document.getElementById('popupMenu');
            const imageInput = document.getElementById('imageInput');
            const videoInput = document.getElementById('videoInput');
            const documentInput = document.getElementById('documentInput');
            const mediaPreviewContainer = document.getElementById('mediaPreviewContainer');
            const previewContent = document.getElementById('previewContent');
            const sendMessageButton = document.getElementById('sendMessage');
            let selectedMediaFile = null; // Store selected media file
            let selectedMediaType = ''; // Store selected media type

            // Toggle popup display on paperclip icon click
            paperclipIcon.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent click propagation
                popupMenu.style.display = (popupMenu.style.display === 'block') ? 'none' : 'block';
            });

            // Function to show media preview
            function showMediaPreview(content) {
                previewContent.innerHTML = content;
                mediaPreviewContainer.style.display = 'block'; // Show the preview container
            }

            // Close media preview
            document.getElementById('closePreview').addEventListener('click', function () {
                mediaPreviewContainer.style.display = 'none';
                selectedMediaFile = null; // Clear selected media
            });

            // Trigger file input for Photos
            document.getElementById('photoUpload').addEventListener('click', function () {
                imageInput.click();
            });

            // Trigger file input for Videos
            document.getElementById('videoUpload').addEventListener('click', function () {
                videoInput.click();
            });

            // Trigger file input for Documents
            document.getElementById('documentUpload').addEventListener('click', function () {
                documentInput.click();
            });

            // Preview image
            imageInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    selectedMediaFile = this.files[0]; // Store the selected file
                    selectedMediaType = 'image'; // Set media type
                    const file = this.files[0];
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const imgContent = `<img src="${e.target.result}" alt="Image Preview" style="max-width: 100%; height: auto;">`;
                        showMediaPreview(imgContent); // Show image
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Preview video
            videoInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    selectedMediaFile = this.files[0]; // Store the selected file
                    selectedMediaType = 'video'; // Set media type
                    const file = this.files[0];
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const videoContent = `<video controls style="max-width: 100%; height: auto;">
                                                <source src="${e.target.result}" type="${file.type}">
                                                Your browser does not support the video tag.
                                              </video>`;
                        showMediaPreview(videoContent); // Show video
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Preview document
            documentInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    selectedMediaFile = this.files[0]; // Store the selected file
                    selectedMediaType = 'document'; // Set media type
                    const file = this.files[0];
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        let documentContent;
                        if (file.type === "application/pdf") {
                            documentContent = `<embed src="${e.target.result}" width="100%" height="auto" type="application/pdf">`;
                        } else {
                            documentContent = `<p>${file.name}</p>`;
                        }
                        showMediaPreview(documentContent); // Show document preview
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Send message button click handler
sendMessageButton.addEventListener('click', function () {
    const messageInput = document.getElementById('messageInput');
    const messageContent = messageInput.value.trim();

    // Use the activeChatId dynamically
    const contactId = activeChatId;

    // Log the contact ID being sent
    console.log('Contact ID being sent to backend:', contactId);

    // Validate message or media before sending
    if (!messageContent && !selectedMediaFile) {
        alert("Please enter a message or select a media file.");
        return;
    }

    // Create FormData object to send message and media
    const formData = new FormData();
    formData.append('message', messageContent);

    // Log the contact ID to the console
    console.log('Contact ID being appended to FormData:', contactId);
    formData.append('contact_id', contactId);

    // Append selected media if available
    if (selectedMediaFile) {
        formData.append('media', selectedMediaFile, selectedMediaFile.name);
        console.log('Media file appended:', selectedMediaFile);
    } else {
        console.log('No media file selected');
    }

    // Log all FormData entries for debugging
    console.log('FormData Entries:');
    for (let pair of formData.entries()) {
        if (pair[0] === 'media') {
            console.log(`${pair[0]}:`, pair[1].name); // Log file name
        } else {
            console.log(`${pair[0]}:`, pair[1]);
        }
    }

    // Send the form data using Axios
    axios.post('https://ictglobaltech.org.in/api/send-message', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(function (response) {
        console.log('Response from server:', response.data);
        if (response.data.success) {
            // Clear input and media selection on success
            messageInput.value = '';
            selectedMediaFile = null;
            mediaPreviewContainer.style.display = 'none';
            previewContent.innerHTML = '';
        } else {
            alert('Error: ' + response.data.error);
        }
    })
    .catch(function (error) {
        console.error('Error sending message:', error);
        alert('An error occurred while sending the message.');
    });
});



            // Close popup when clicking outside
            document.addEventListener('click', function (event) {
                if (!popupMenu.contains(event.target) && !paperclipIcon.contains(event.target)) {
                    popupMenu.style.display = 'none';
                }
            });
        });
    </script>
</div>



					<script>
						// Define activeChatId globally
						let activeChatId = null;

						//==== Scroll to the bottom of the chatbox ====
						function scrollToBottom() {
							const chatbox = document.getElementById('chatbox');
							chatbox.scrollTop = chatbox.scrollHeight;
						}

						// Check if the user has scrolled to the bottom
						function toggleScrollButton() {
							const chatbox = document.getElementById('chatbox');
							const scrollBtn = document.querySelector('.scroll-btn');

							// Check if the user is at the bottom of the chatbox
							if (chatbox.scrollTop + chatbox.clientHeight >= chatbox.scrollHeight) {
								scrollBtn.style.display = 'none'; // Hide the button
							} else {
								scrollBtn.style.display = 'block'; // Show the button
							}
						}

						// Attach the scroll function to the button
						document.querySelector('.scroll-btn').addEventListener('click', scrollToBottom);

						// Check scroll position when the user scrolls the chatbox
						document.getElementById('chatbox').addEventListener('scroll', toggleScrollButton);

						// Optional: Automatically scroll to bottom on page load or when new messages arrive
						window.onload = () => {
							scrollToBottom();  // On page load, scroll to the bottom
							toggleScrollButton(); // Check if the button should be displayed
						};

					</script>


				</div>
			</div>

		</div>
		<!-- footer -->
		@endsection

	</div>

</body>

<!-- Ionicons -->
<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


<script>
	
	//Function to activate a chat and display its content

	function activateChat(chatId) {
    activeChatId = chatId.replace('chat', '');

    // Hide all chat content sections
    document.querySelectorAll('.chatContent').forEach(content => content.style.display = 'none');

    // Show the content of the active chat
    const activeChatContent = document.getElementById(chatId + 'Content');
    activeChatContent.style.display = 'block';

    // Clear the message input
    document.getElementById('messageInput').value = '';

    // Enable the chat input
    document.getElementById('messageInput').disabled = false;

    // Hide the 'noChatSelected' div and show the 'rightSide' div
    document.querySelector('.noChatSelected').style.display = 'none';
    document.querySelector('.rightSide').style.display = 'block';

    // Call the backend to mark messages as read
    fetch(`/mark-as-read/${activeChatId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mark the chat as read in the frontend
            document.getElementById(chatId).classList.remove('unread');
            const unreadCountElement = document.getElementById(chatId).querySelector('.message_p b');
            if (unreadCountElement) {
                unreadCountElement.remove();
            }
        }
    })
    .catch(error => console.error('Error:', error));

    // Update the header with chat details
    const chatName = document.getElementById(chatId).querySelector('.listHead h4').innerText;
    const chatImage = document.getElementById(chatId).querySelector('.imgBox').cloneNode(true);

    // Update right-side chat header
    const userImgContainer = document.querySelector('.rightSide .header .userimg');
    userImgContainer.innerHTML = ''; // Clear previous image
    userImgContainer.appendChild(chatImage);

    const userNameContainer = document.querySelector('.rightSide .header h6');
    userNameContainer.innerHTML = chatName + '<br><small>online</small>';
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