<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>WhatsApp CRM</title>
	<link rel="icon" type="image/x-icon" href="https://i.postimg.cc/02RpgdM2/whatsapp3d.png">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
		name='viewport' />
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="assets/css/ready.css">
	<link rel="stylesheet" href="assets/css/demo.css">
	<link rel="stylesheet" href="assets/css/chat.css">

	<!-- font awsome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

	<style>
		.footer{
			display:none;
		}
		.message-card {
			background: #dcf8c8;
			padding: 8px;
			border-radius: 10px;
			max-width: 45%;
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

		.message-card-left{
			margin-right: auto;
			background: #fff;
		}
		.message-card-right{
			margin-left: auto;
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
</head>

<body>

	<!-- header -->
	@extends('layout.app')

	@section('content')

	<div class="main-panel" id="main-panel">
	<div class="content p-0">
		<div class="containerx" id="containerx">
			<div class="leftSide">
					<!-- Header -->
					<div class="header">
						<h6 style="font-weight:700;">Chats</h6>
						<ul class="nav_icons">
                        <li onclick="toggleContacts()">
                            <i class="fa-regular fa-circle-user"></i>
                        </li>
							<li><i class="fa-solid fa-expand" id="fullscreen-icon"></i></li>
							
							<li>
								<ion-icon name="ellipsis-vertical" id="dropdownMenuButton"
									data-toggle="dropdown"></ion-icon>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" href="#">Social Media</a>
									<a class="dropdown-item" href="#">Meta</a>
									<a class="dropdown-item" href="#">Google</a>
								</div>
							</li>
						</ul>
					</div>
					<script>
						document.addEventListener('DOMContentLoaded', function () {
							const fullscreenIcon = document.getElementById('fullscreen-icon');
							const mainPanel = document.getElementById('main-panel');

							fullscreenIcon.addEventListener('click', function () {
								if (mainPanel) {
									if (!document.fullscreenElement) {
										mainPanel.requestFullscreen().catch(err => {
											alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`); // Fixed template literal
										});
									} else {
										document.exitFullscreen();
									}
								} else {
									console.warn("mainPanel element not found.");
								}
							});
						});
					</script>



				<!-- CSS -->
				<style>
					/* Style the main-panel to be truly fullscreen */
					.main-panel:fullscreen {
						width: 100vw;
						height: 100vh;
						overflow: hidden;
						margin: 0;
						padding: 0;
					}

					/* Ensure child elements fill the screen in fullscreen mode */
					.main-panel:fullscreen .content,
					.main-panel:fullscreen .containerx,
					.main-panel:fullscreen .leftSide,
					.main-panel:fullscreen .chat-section {
						width: 100%;
						height: 100%;
						margin: 0;
						padding: 0;
						box-sizing: border-box;
					}
				</style>
					<!-- Search Chat -->
					<div class="search_chat">
						<div>
							<input type="text" id="searchInput" placeholder="Search or start new chat" onkeyup="filterContacts()">
							<ion-icon name="search-outline"></ion-icon>
						</div>
					</div>
					<div id="contacts">
						<!-- CHAT LIST -->
						<div class="chatlist" id="chattedContacts">
							@php
    use Illuminate\Support\Facades\Auth;

    $authAppId = Auth::user()->app_id;
    $colors = ['#FF5733', '#00951a', '#3357FF', '#FF33A1', '#003e9a', '#FFBD33', '#A133FF'];

    function getColorForContact($contactId, $colors) {
        return $colors[$contactId % count($colors)];
    }

    // Group messages by contact_id, taking the latest message for each contact and filtering based on app_id
    $groupedMessages = $messages->filter(function ($message) use ($authAppId) {
        // Ensure the contact's app_id matches the authenticated user's app_id
        $contact = \App\Models\Contacts::find($message->contact_id);
        return $contact && $contact->app_id === $authAppId;
    })->groupBy('contact_id')->map(function ($group) {
        return $group->last(); // Get the latest message for each contact
    })->sortByDesc('created_at');

    // Count unread messages per contact
    $unreadChatsCounts = \App\Models\Chats::select('contact_id', \DB::raw('COUNT(*) as unread_count'))
        ->where('is_read', false)
        ->groupBy('contact_id')
        ->pluck('unread_count', 'contact_id');

    // Fetch contacts that belong to the authenticated user's app_id
    $contacts = \App\Models\Contacts::where('app_id', $authAppId)->get();

    // Separate chatted and non-chatted contacts
    $chattedContactIds = $groupedMessages->keys();
    $chattedContacts = $groupedMessages->values();
    $nonChattedContacts = $contacts->whereNotIn('id', $chattedContactIds)->sortBy('name');
@endphp


							<!-- Display Chatted Contacts -->
							@foreach ($chattedContacts as $contact)
								@php
									$fixedColor = getColorForContact($contact->contact->id, $colors);
									$unreadChatsCount = $unreadChatsCounts[$contact->contact->id] ?? 0;
								@endphp

								@php
									// Ensure $contact->tags is treated as an array
									$tags = is_array($contact->contact->tags) ? $contact->contact->tags : explode(',', $contact->contact->tags);
								@endphp
								<div class="block {{ $unreadChatsCount > 0 ? 'unread' : '' }} contact-item"
									id="chat{{ $contact->contact_id }}"
									onclick="activateChat('chat{{ $contact->contact_id }}')"
									data-name="{{ strtolower($contact->contact->name) }}"
									data-phone="{{ $contact->contact->mobile }}"
									data-tags="{{ implode(',', $tags) }}">



 
									<div class="imgBox" style="background: {{ $fixedColor }};">
										<p class="profile-letters">{{ strtoupper(substr($contact->contact->name, 0, 2)) }}</p>
									</div>
									<div class="details">
										<div class="listHead">
											<h4>{{ $contact->contact->name }}</h4>
											<p class="time">{{ $contact->created_at->format('h:i a') }}</p>
										</div>
										<div class="message_p">
											<p>{{ $contact->message }}</p>
											@if ($unreadChatsCount > 0)
												<b>{{ $unreadChatsCount }}</b>
											@endif
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>

					<div id="all-contacts" style="display: none; max-height: 670px; overflow-y: auto;">
						<div class="chatlist">
							<!-- Display All Contacts with the same structure as Chatted Contacts -->
							@foreach ($allContacts as $contact)
								@php
									$fixedColor = getColorForContact($contact->id, $colors);
								@endphp

								<div class="block contact-item"
									id="chat{{ $contact->id }}"
									onclick="activateChat('chat{{ $contact->id }}')"
									data-name="{{ strtolower($contact->name) }}">
									<div class="imgBox" style="background: {{ $fixedColor }};">
										<p class="profile-letters">{{ strtoupper(substr($contact->name, 0, 2)) }}</p>
									</div>
									<div class="details">
										<div class="listHead">
											<h4>{{ $contact->name }}</h4>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>

					<!-- JavaScript for Filtering -->
					<script>
						function filterContacts() {
							const input = document.getElementById("searchInput").value.toLowerCase();
							const contacts = document.getElementsByClassName("contact-item");

							Array.from(contacts).forEach(contact => {
								const name = contact.getAttribute("data-name");
								if (input === "" || name.includes(input)) {
									// Restore original display and style when search is cleared or contact matches the search
									contact.style.removeProperty("display");
								} else {
									// Hide unmatched contacts
									contact.style.display = "none";
								}   
							});
						}
					</script>





                    <script>
                        function toggleContacts() {
                            const chattedContacts = document.getElementById('contacts');
                            const allContacts = document.getElementById('all-contacts');

                            if (chattedContacts.style.display === 'none') {
                                chattedContacts.style.display = 'block';
                                allContacts.style.display = 'none';
                            } else {
                                chattedContacts.style.display = 'none';
                                allContacts.style.display = 'block';
                            }
                        }

                         
                    </script>
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
								<!-- Image will be dynamically added here -->
							</div>
							<h6 class="ml-3">
								<!-- Name and phone will be updated here dynamically -->
							</h6>
						</div>
						<!-- Display tags as badges -->
						<div id="contactTags" class="badge-container">
							<!-- Tags will be dynamically added here -->
							@php
								// Ensure $contact->tags is treated as an array
								$tags = is_string($contact->tags) ? json_decode($contact->tags, true) : $contact->tags;
							@endphp
							@if (is_array($tags) && !empty($tags))
								@foreach ($tags as $tag)
									<span class="badge badge-count">{{ $tag }}</span>
								@endforeach
							@else
								<span class="text-muted">No tags</span>
							@endif
						</div>
					</div>



					<!-- CHAT-BOX -->
					<div class="chatbox" id="chatbox">
    @foreach ($messages->groupBy('contact_id') as $contactId => $contactMessages)
        @php
            $combinedMessages = [];

            // Add customer and business messages to the combined array
            foreach ($contactMessages as $message) {
                $combinedMessages[] = [
                'id' => $message->id,
                    'type' => 'chat',
                    'sender' => $message->sender,
                    'message' => $message->message,
                    'created_at' => $message->created_at,
                    'media_url' => $message->media_url, // Add media URL from the message
                    'media_type' => $message->media_type // Add media type from the message
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
    <button 
    type="button" 
    class="btn btn-sm forward-btn" 
    data-message-id="{{ $item['id'] }}" 
    data-type="chat" 
    data-toggle="modal" 
    data-target="#forwardModal">
    <i class="fa fa-share" aria-hidden="true"></i>
</button>
        @if (!empty($item['media_url']))
            <div class="message-card message-card-left friend_msg">
                @if ($item['media_type'] === 'image')
                    <img src="{{ asset('storage/'.$item['media_url']) }}" alt="Image" style="max-width: 100%; border-radius: 5px;">
                @elseif ($item['media_type'] === 'video')
                    <video controls style="max-width: 100%; border-radius: 5px;">
                        <source src="{{ asset('storage/'.$item['media_url']) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @elseif ($item['media_type'] === 'audio')
                    <audio controls style="width: 100%;">
                        <source src="{{ asset('storage/'.$item['media_url']) }}" type="audio/mpeg">
                        Your browser does not support the audio tag.
                    </audio>
                @elseif ($item['media_type'] === 'document')
                    @php
                        $filename = basename($item['media_url']);
                        $extension = pathinfo($item['media_url'], PATHINFO_EXTENSION);
                    @endphp
                    <div class="d-flex align-items-center border-bottom p-2">
                        <i class="fa-solid fa-file-invoice fa-3x text-danger mr-3"></i>
                        <div>
                            <h6 class="mb-0">{{ $filename }}</h6>
                            <small>{{ strtoupper($extension) }} Document</small>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ asset('storage/'.$item['media_url']) }}" target="_blank" class="btn btn-light border mr-1 w-100">Open</a>
                    </div>
                @endif

                <p style="margin: 0; margin-top: 5px;">
                    {{ $item['message'] }}
                </p>
                <small style="display: block; text-align: right;">{{ $item['created_at']->format('h:i a') }}</small>
            </div>
        @else
            <div class="message friend_msg">
                <p style="margin: 0; margin-top: 5px;">
                    {{ $item['message'] }} <br>
                    <small style="text-align: right;">{{ $item['created_at']->format('h:i a') }}</small>
                </p>
            </div>
        @endif
    @elseif ($item['sender'] === 'business')
        @if (!empty($item['media_url']))
            <div class="message-card message-card-right my_msg">
                <button type="button" style="background-color: transparent;" class="btn btn-sm forward-btn" data-message-id="{{ $item['id'] }}" data-toggle="modal" data-target="#forwardModal">
                                            <i class="fa fa-share" aria-hidden="true"></i>
                                        </button>
                @if ($item['media_type'] === 'image')
                    <img src="{{ $item['media_url'] }}" alt="Image" style="max-width: 100%; border-radius: 5px;">
                @elseif ($item['media_type'] === 'video')
                    <video controls style="max-width: 100%; border-radius: 5px;">
                        <source src="{{ $item['media_url'] }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @elseif ($item['media_type'] === 'audio')
                    <audio controls style="width: 100%;">
                        <source src="{{ $item['media_url'] }}" type="audio/mpeg">
                        Your browser does not support the audio tag.
                    </audio>
                @elseif ($item['media_type'] === 'document')
                    @php
                        $filename = basename($item['media_url']);
                        $extension = pathinfo($item['media_url'], PATHINFO_EXTENSION);
                    @endphp
                    <div class="d-flex align-items-center border-bottom p-2">
                        <i class="fa-solid fa-file-invoice fa-3x text-danger mr-3"></i>
                        <div>
                            <h6 class="mb-0">{{ $filename }}</h6>
                            <small>{{ strtoupper($extension) }} Document</small>
                        </div>
                    </div>
                    <div class="mt-4 d-flex">
                        <a href="{{ $item['media_url'] }}" target="_blank" class="btn btn-light border mr-1 w-100">Open</a>
                    </div>
                @endif

                <p style="margin: 0; margin-top: 5px;">
                    {{ $item['message'] }}
                </p>
                <small style="display: block; text-align: right;">{{ $item['created_at']->format('h:i a') }}</small>
            </div>
        @else
            <div class="message my_msg">
                <p style="margin: 0; margin-top: 5px;">
                    {{ $item['message'] }} <br>
                    <small style="text-align: right;">{{ $item['created_at']->format('h:i a') }}</small>
                </p>
            </div>
        @endif
    @endif
@elseif ($item['type'] === 'template')
    <!-- Display Template Messages -->
    <div class="message-card message-card-right my_msg">
        <!-- Header Section -->
      
                                <button 
                                    type="button" 
                                    class="btn btn-sm forward-btn" 
                                    data-message-id="{{ $item['broadcast_id'] }}" 
                                    data-type="template" 
                                    data-template-id="{{ $item['template_id'] }}" 
                                    data-toggle="modal" 
                                    data-target="#forwardModal">
                                    <i class="fa fa-share" aria-hidden="true"></i>
                                </button>
 

        @foreach ($item['components'] as $component)
            @if ($component['type'] === 'HEADER')
                @if ($component['format'] === 'TEXT' && isset($component['text']))
                    <p><b>{{ $component['text'] }}</b></p>
                @elseif($component['format'] === 'IMAGE' && isset($broadcastMessages[$item['broadcast_id']][$item['template_id']]['media']))
                    <img src="storage/{{ $broadcastMessages[$item['broadcast_id']][$item['template_id']]['media'] }}" alt="Header Image">
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
													<script>
                                            $('.forward-btn').on('click', function() {
                                                const messageId = $(this).data('message-id');
                                                const type = $(this).data('type');
                                                const templateId = $(this).data('template-id') || null; // Optional for chat messages

                                                // Set the modal's hidden input values
                                                $('#forwardModal #messageId').val(messageId);
                                                $('#forwardModal #messageType').val(type);
                                                $('#forwardModal #templateId').val(templateId);
                                            });

                                        </script>
													<!-- Forward Modal -->
                                    <div class="modal fade" id="forwardModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="forwardForm" method="POST" action="{{ route('forward.message') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Forward Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="message_id" id="messageId">
                    <input type="hidden" name="type" id="messageType">
                    <input type="hidden" name="template_id" id="templateId">
                    <div class="form-group">
                        <label for="contactId">Select Contact</label>
                        <select class="form-control" name="contact_id" id="contactId" required>
                            @foreach ($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Forward</button>
                </div>
            </div>
        </form>
    </div>
</div>
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
						<script>
                    $('.scroll-btn').on('click', function () {
                        $('#chatbox').animate({ scrollTop: $('#chatbox')[0].scrollHeight }, 'slow');
                    });
                </script>
					</div>
					<!-- Broadcast Message Form -->
<form method="post" action="{{ route('broadcast.message') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade newBroadcastMessage" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-dark" id="exampleModalLongTitle" style="font-weight: 700;">
                        New Broadcast Message <i class="fa-solid fa-bullhorn text-secondary"></i>
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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

                    <!-- Hidden inputs to store the template ID and contact ID -->
                    <input type="hidden" id="templateId" name="message_template">
                    <input type="hidden" id="contactId" name="contact_id">

                    <!-- Placeholder for dynamic inputs -->
                    <div id="dynamic-inputs"></div>

                    <div class="modal-footer">
                        <a href="" type="button" class="btn btn-secondary px-5">Cancel</a>
                        <button type="submit" id="nextButton" class="btn btn-success py-2 px-5">Next <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- JavaScript Code -->
<!-- Broadcast Message Form -->


<!-- JavaScript Code -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const templateSelect = document.getElementById('pillSelect2');
        const dynamicInputsContainer = document.getElementById('dynamic-inputs');
        const templateIdInput = document.getElementById('templateId');
        const contactIdInput = document.getElementById('contactId'); 

        // Function to set the contact ID in the hidden input
        function setContactId(contactId) {
            console.log("Setting contact ID:", contactId); // Debugging line to check contactId
            contactIdInput.value = contactId; // Set the contactId in the hidden input field
        }

        // Updated activateChat function to set contact_id for broadcast form
        function activateChat(chatId) {
            const activeContactId = chatId.replace('chat', ''); 
            setContactId(activeContactId); 

            document.querySelectorAll('.chatContent').forEach(content => content.style.display = 'none');
            const activeChatContent = document.getElementById(chatId + 'Content');
            if (activeChatContent) {
                activeChatContent.style.display = 'block';
            }

            const messageInput = document.getElementById('messageInput');
            if (messageInput) {
                messageInput.value = '';
                messageInput.disabled = false;
            }

            const noChatSelected = document.querySelector('.noChatSelected');
            const rightSide = document.querySelector('.rightSide');
            if (noChatSelected && rightSide) {
                noChatSelected.style.display = 'none';
                rightSide.style.display = 'block';
            }

            const chatElement = document.getElementById(chatId);
            if (chatElement) {
                const chatName = chatElement.querySelector('.listHead h4').innerText;
                const chatPhone = chatElement.getAttribute('data-phone');
                const chatTagsString = chatElement.getAttribute('data-tags') || '';

                const chatTags = chatTagsString
                    .replace(/^\[|\]$/g, '')
                    .replace(/"/g, '')
                    .split(',')
                    .map(tag => tag.trim())
                    .filter(tag => tag);

                const userImgContainer = document.querySelector('.rightSide .header .userimg');
                if (userImgContainer) {
                    userImgContainer.innerHTML = '';
                    const chatImage = chatElement.querySelector('.imgBox').cloneNode(true);
                    userImgContainer.appendChild(chatImage);
                }

                const userNameContainer = document.querySelector('.rightSide .header h6');
                if (userNameContainer) {
                    userNameContainer.innerHTML = `${chatName}<br><small>${chatPhone}</small>`;
                }

                const tagsContainer = document.getElementById('contactTags');
                if (tagsContainer) {
                    tagsContainer.innerHTML = ''; 
                    if (chatTags.length === 0) {
                        tagsContainer.innerHTML = '<span class="text-muted">No tags</span>';
                    } else {
                        chatTags.forEach(tag => {
                            const tagElement = document.createElement('span');
                            tagElement.classList.add('badge', 'badge-count');
                            tagElement.innerText = tag;
                            tagsContainer.appendChild(tagElement);
                        });
                    }
                }
            }
        }

        // Show the modal and confirm the contact_id is set
        $('.newBroadcastMessage').on('show.bs.modal', function () {
            console.log("Opening modal with contact ID:", contactIdInput.value); // Confirm activeContactId in modal
        });

        templateSelect.addEventListener('change', function () {
            dynamicInputsContainer.innerHTML = ''; 

            const selectedOption = this.options[this.selectedIndex];
            let templateData;

            try {
                templateData = JSON.parse(selectedOption.value);
            } catch (error) {
                console.error('Error parsing template JSON:', error);
                return;
            }

            templateIdInput.value = templateData.id;

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
                    }
                });
            }
        });
        
        // Function definitions for createHeaderInput, createBodyInputs, updateBodyPreview, etc. remain the same.
    });
</script>



 

   



					<div class="chat_input" style="position: relative; display: flex; align-items: center;">
                    <!--<i class="fa-regular fa-newspaper" data-toggle="modal" data-target=".newBroadcastMessage" title="Template Message" style="font-size: 24px; margin-right: 10px; cursor: pointer;"></i>-->

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
        <li id="audioUpload"><i class="fa fa-image"></i> Audio</li>
            <li id="photoUpload"><i class="fa fa-image"></i> Photos</li>
            <li id="videoUpload"><i class="fa fa-video"></i> Videos</li>
            <li id="documentUpload"><i class="fa fa-file"></i> Document</li>
        </ul>
    </div>

    <!-- Hidden file input elements -->
    <input type="file" id="audioInput" accept="audio/*" style="display:none;">
    <input type="file" id="imageInput" accept="image/*" style="display:none;">
    <input type="file" id="videoInput" accept="video/*" style="display:none;">
    <input type="file" id="documentInput" accept=".pdf,.doc,.docx,.txt" style="display:none;">

    <!-- Media preview area -->
    <div id="mediaPreviewContainer" class="media-preview-container" style="display:none; position: absolute; bottom: 40px; left: 10px; background: #fff; border: 1px solid #ddd; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 10px; z-index: 100;">
        <span class="close-button" id="closePreview" style="position: absolute; top: 5px; right: 5px; cursor: pointer;">&times;</span>
        <div id="previewContent"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
     

    <script>
                            function markAsRead(contactId) {
    console.log("Marking messages as read for contact ID:", contactId);

    // Make an AJAX request to mark messages as read in the database
    fetch(`/mark-as-read/${contactId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Messages marked as read successfully");
            // Update the UI to reflect the read status
            const chatElement = document.getElementById(`chat${contactId}`);
            if (chatElement) {
                const unreadBadge = chatElement.querySelector('.unread-badge');
                if (unreadBadge) {
                    unreadBadge.style.display = 'none'; // Hide unread badge
                }
            }
        } else {
            console.error("Failed to mark messages as read:", data.message);
        }
    })
    .catch(error => {
        console.error("Error marking messages as read:", error);
    });
}


                            let activeChatId = null;

                            function activateChat(chatId) {
    // Extract contact_id from the chatId (remove 'chat' prefix)
    const activeContactId = chatId.replace('chat', ''); 

    // Update global activeChatId
    activeChatId = activeContactId; 

    const contactIdInput = document.getElementById('contactId');
    if (contactIdInput) {
        contactIdInput.value = activeContactId; // Set contact_id in the hidden input
    }

    // Call markAsRead for the selected contact
    markAsRead(activeContactId); // Mark the messages of this contact as read

    // Hide all other chats and show the active chat content
    document.querySelectorAll('.chatContent').forEach(content => content.style.display = 'none');
    const activeChatContent = document.getElementById(chatId + 'Content');
    if (activeChatContent) {
        activeChatContent.style.display = 'block';
    }

    // Enable message input
    const messageInput = document.getElementById('messageInput');
    if (messageInput) {
        messageInput.value = '';
        messageInput.disabled = false;
    }

    // Show the right side and hide 'no chat selected' message
    const noChatSelected = document.querySelector('.noChatSelected');
    const rightSide = document.querySelector('.rightSide');
    if (noChatSelected && rightSide) {
        noChatSelected.style.display = 'none';
        rightSide.style.display = 'block';
    }

    // Get chat details
    const chatElement = document.getElementById(chatId);
    if (chatElement) {
        const chatName = chatElement.querySelector('.listHead h4').innerText;
        const chatPhone = chatElement.getAttribute('data-phone');
        const chatTagsString = chatElement.getAttribute('data-tags') || '';

        // Parse tags, removing brackets and double quotes, then splitting into an array
        const chatTags = chatTagsString
            .replace(/^\[|\]$/g, '')
            .replace(/"/g, '')
            .split(',')
            .map(tag => tag.trim())
            .filter(tag => tag);

        // Update user image and name/phone
        const userImgContainer = document.querySelector('.rightSide .header .userimg');
        if (userImgContainer) {
            userImgContainer.innerHTML = ''; // Clear previous image
            const chatImage = chatElement.querySelector('.imgBox').cloneNode(true);
            userImgContainer.appendChild(chatImage);
        }

        const userNameContainer = document.querySelector('.rightSide .header h6');
        if (userNameContainer) {
            userNameContainer.innerHTML = `${chatName}<br><small>${chatPhone}</small>`;
        }

        // Display tags as badges
        const tagsContainer = document.getElementById('contactTags');
        if (tagsContainer) {
            tagsContainer.innerHTML = ''; // Clear previous tags
            if (chatTags.length === 0) {
                tagsContainer.innerHTML = '<span class="text-muted">No tags</span>';
            } else {
                chatTags.forEach(tag => {
                    const tagElement = document.createElement('span');
                    tagElement.classList.add('badge', 'badge-count');
                    tagElement.innerText = tag;
                    tagsContainer.appendChild(tagElement);
                });
            }
        }
    }
}

    document.addEventListener("DOMContentLoaded", function () {
        const paperclipIcon = document.getElementById('paperclip');
        const popupMenu = document.getElementById('popupMenu');
        const audioInput = document.getElementById('audioInput');
        const imageInput = document.getElementById('imageInput');
        const videoInput = document.getElementById('videoInput');
        const documentInput = document.getElementById('documentInput');
        const mediaPreviewContainer = document.getElementById('mediaPreviewContainer');
        const previewContent = document.getElementById('previewContent');
        const sendMessageButton = document.getElementById('sendMessage');
        let selectedMediaFile = null;
        let selectedMediaType = '';

        paperclipIcon.addEventListener('click', function (event) {
            event.stopPropagation();
            popupMenu.style.display = (popupMenu.style.display === 'block') ? 'none' : 'block';
        });

        function showMediaPreview(content) {
            previewContent.innerHTML = content;
            mediaPreviewContainer.style.display = 'block';
        }

        document.getElementById('closePreview').addEventListener('click', function () {
            mediaPreviewContainer.style.display = 'none';
            selectedMediaFile = null;
        });

        document.getElementById('photoUpload').addEventListener('click', function () {
            imageInput.click();
        });
        document.getElementById('audioUpload').addEventListener('click', function () {
            audioInput.click();
        });
        document.getElementById('videoUpload').addEventListener('click', function () {
            videoInput.click();
        });

        document.getElementById('documentUpload').addEventListener('click', function () {
            documentInput.click();
        });

        imageInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                selectedMediaFile = this.files[0];
                selectedMediaType = 'image';
                const file = this.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    const imgContent = `<img src="${e.target.result}" alt="Image Preview" style="max-width: 100%; height: auto;">`;
                    showMediaPreview(imgContent);
                };

                reader.readAsDataURL(file);
            }
        });
        audioInput.addEventListener('change', function () {
    if (this.files.length > 0) {
        selectedMediaFile = this.files[0];
        selectedMediaType = 'audio';
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const audioContent = `<audio controls style="max-width: 100%; height: auto;">
                <source src="${e.target.result}" type="${file.type}">
                Your browser does not support the audio element.
            </audio>`;
            showMediaPreview(audioContent);
        };

        reader.readAsDataURL(file);
    }
});
        videoInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                selectedMediaFile = this.files[0];
                selectedMediaType = 'video';
                const file = this.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    const videoContent = `<video controls style="max-width: 100%; height: auto;">
                        <source src="${e.target.result}" type="${file.type}">
                        Your browser does not support the video tag.
                    </video>`;
                    showMediaPreview(videoContent);
                };

                reader.readAsDataURL(file);
            }
        });

        documentInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                selectedMediaFile = this.files[0];
                selectedMediaType = 'document';
                const file = this.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    const documentContent = file.type === "application/pdf" ?
                        `<embed src="${e.target.result}" width="100%" height="auto" type="application/pdf">` :
                        `<p>${file.name}</p>`;
                    showMediaPreview(documentContent);
                };

                reader.readAsDataURL(file);
            }
        });
// Pass PHP variables to JavaScript
    const authAppId = @json($authAppId);
    const authUserId = @json($authUserId);
        // Send message button click handler
        sendMessageButton.addEventListener('click', function () {
            const messageInput = document.getElementById('messageInput');
            const messageContent = messageInput.value.trim();

            // Use the activeChatId dynamically
            const contactId = activeChatId;

            // Validate message or media before sending
            if (!messageContent && !selectedMediaFile) {
                alert("Please enter a message or select a media file.");
                return;
            }

            // Create FormData object to send message and media
            const formData = new FormData();
formData.append('message', messageContent);
formData.append('contact_id', contactId);

// Append authAppId and authUserId to the formData
formData.append('authAppId', authAppId);
formData.append('authUserId', authUserId);

            

            // Append selected media if available
            if (selectedMediaFile) {
                formData.append('media', selectedMediaFile, selectedMediaFile.name);
                formData.append('media_type', selectedMediaType); // Append media type (image, video, document)
            }

            // Send the form data using Axios
            axios.post('/api/send-message', formData, {
    headers: {
        'Content-Type': 'multipart/form-data'
    }
})
.then(function (response) {
    if (response.data.success) {
        // Handle success
    } else {
        alert('Error: ' + (response.data.error || 'Unknown error'));
    }
})
.catch(function (error) {
    if (error.response && error.response.data) {
        console.error('Validation errors:', error.response.data.errors);
        alert('Validation failed: ' + JSON.stringify(error.response.data.errors));
    } else {
        console.error('Request failed with status code 422:', error);
        alert('There was an error sending your message. Please check the form fields or try again.');
    }
});



        });

        document.addEventListener('click', function (event) {
            if (!popupMenu.contains(event.target) && !paperclipIcon.contains(event.target)) {
                popupMenu.style.display = 'none';
            }
        });
    });
</script>
<script>
    function fetchNewMessages() {
        axios.get('/api/load-messages', { params: { last_message_id: lastMessageId } })
        .then(function (response) {
            if (response.data.messages.length > 0) {
                response.data.messages.forEach(function (message) {
                    appendMessage(message);
                    lastMessageId = message.id;
                });
            }
        })
        .catch(function (error) {
            console.error('Error fetching new messages:', error);
        });
    }

    // Append a message to the chatbox
    function appendMessage(data) {
        const messageDiv = document.createElement('div');
        const isSenderCustomer = data.sender === 'customer';
        messageDiv.classList.add(isSenderCustomer ? 'message-card-left' : 'message-card-right', 'message-card');

        let messageContent = `<p>${data.message}</p>`;
        if (data.media_url) {
            if (data.media_type === 'image') {
                messageContent += `<img src="${data.media_url}" alt="Media" style="max-width: 100%; height: auto;">`;
            } else if (data.media_type === 'video') {
                messageContent += `<video controls style="max-width: 100%; height: auto;">
                    <source src="${data.media_url}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>`;
            } else if (data.media_type === 'document') {
                messageContent += `<embed src="${data.media_url}" width="100%" height="auto" type="application/pdf">`;
            }
        }

        messageDiv.innerHTML = messageContent + `<small>${new Date(data.created_at).toLocaleTimeString()}</small>`;
        chatbox.appendChild(messageDiv);
        chatbox.scrollTop = chatbox.scrollHeight;
    }

    setInterval(fetchNewMessages, 3000);
</script>

</div>


</div>


					<script defer>
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
							} else {
								scrollBtn.style.display = 'none'; // Hide the button
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
