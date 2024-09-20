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
	<link rel="stylesheet" href="assets/css/chat.css">

	<!-- font awsome -->
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

	 <script>
		document.getElementById("fullscreen-icon").addEventListener("click", function() {
			document.getElementById("containerx").classList.toggle("fullscreen");
		});
	</script>
	 <style>
		.fullscreen {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: #fff;
		}
		.listHead h4{
			margin-bottom: 0px;
		}
		.message_p p{
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
										<i class="fa-solid fa-tags" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="#">Social Media</a>
											<a class="dropdown-item" href="#">Meta</a>
											<a class="dropdown-item" href="#">Google</a>
										</div>
									</li>
									<li>
										<ion-icon name="ellipsis-vertical" id="dropdownMenuButton" data-toggle="dropdown"></ion-icon>
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
								function getColorForContact($contactId, $colors) {
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
								<div class="block {{ $unreadChatsCount > 0 ? 'unread' : '' }}" id="chat{{ $message->contact_id }}" onclick="activateChat('chat{{ $message->contact_id }}')">
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

						<!-- right side -->
						<div class="rightSide">

							<div class="header">
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

							<!-- CHAT-BOX -->
							<div class="chatbox">
								@foreach ($messages->groupBy('contact_id') as $contactId => $contactMessages)
									<!-- Chat content for each contact -->
									<div id="chat{{ $contactId }}Content" class="chatContent" style="display: none;">
										@foreach ($contactMessages as $message)
											@if ($message->sender === 'customer') <!-- If the sender is the customer -->
												<div class="message friend_msg">
													<p>{{ $message->message }} <br><span>{{ $message->created_at->format('h:i a') }}</span></p>
												</div>
											@elseif ($message->sender === 'business') <!-- If the sender is the business -->
												<div class="message my_msg">
													<p>{{ $message->message }} <span>{{ $message->created_at->format('h:i a') }}</span></p>
												</div>
											@endif
										@endforeach
									</div>
								@endforeach
							</div>


							<!-- CHAT INPUT -->
							<div class="chat_input">
								<ion-icon name="happy-outline"></ion-icon>
								<input type="text" id="messageInput" placeholder="Type a message" >
								<div class="whatsapp-button-container">
									<button type="button" class="whatsapp-button" id="sendMessage" style="cursor:pointer;">
										<i class="fa fa-paper-plane send-icon"></i>
									</button>
								</div>
							</div>

							<script>
								// Define activeChatId globally
								let activeChatId = null;

								document.addEventListener("DOMContentLoaded", function() {
									// Get the send button and message input
									const sendButton = document.getElementById('sendMessage');
									const messageInput = document.getElementById('messageInput');

									// Attach click event listener to the send button
									sendButton.addEventListener('click', function() {
										const messageContent = messageInput.value.trim();

										// Check if there's an active chat and message content
										if (messageContent !== '' && activeChatId) {
											fetch('/send-whatsapp-message', {
												method: 'POST',
												headers: {
													'X-CSRF-TOKEN': '{{ csrf_token() }}',
													'Content-Type': 'application/json',
												},
												body: JSON.stringify({
													message: messageContent,
													contact_id: activeChatId // Use the activeChatId here
												})
											})
											.then(response => response.json())
											.then(data => {
												if (data.success) {
													console.log('Message sent successfully');
													messageInput.value = '';
												} else {
													console.error('Message sending failed:', data.error);
												}
											})
											.catch(error => console.error('Error:', error));
										} else {
											console.warn('Message content is empty or contact ID is missing');
										}
									});
								});

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
    document.querySelector('.rightSide .header .imgText h6').innerHTML = `${chatName} <br><small>online</small>`;
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