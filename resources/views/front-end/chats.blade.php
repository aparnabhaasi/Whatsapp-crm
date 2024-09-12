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
								<div class="userimg">
									<img src="https://ictglobaltech.com/assets/img/logo.png" alt="" class="cover">
								</div>
								<ul class="nav_icons">
									<li><i class="fa-solid fa-expand" id="fullscreen-icon"></i></li>
									<li>
										<i class="fa-solid fa-tags" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
										<!-- Ensure the `dropdown-toggle` class is added to activate dropdown functionality -->
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

								<div class="block active" id="chat1" onclick="activateChat('chat1')">
									<div class="imgBox">
										<img src="https://ictglobaltech.com/assets/img/logo.png" class="cover" alt="">
									</div>
									<div class="details">
										<div class="listHead">
											<h4>ICT Global Tech Pvt. Ltd.</h4>
											<p class="time">10:56</p>
										</div>
										<div class="message_p">
											<p>How are you doing?</p>
										</div>
									</div>
								</div>
				
								<div class="block unread" id="chat2" onclick="activateChat('chat2')">
									<div class="imgBox">
										<img src="assets/img/chat/img2.jpg" class="cover" alt="">
									</div>
									<div class="details">
										<div class="listHead">
											<h4>Bimal</h4>
											<p class="time">12:34</p>
										</div>
										<div class="message_p">
											<p>Your web development service is good</p>
											<b>1</b>
										</div>
									</div>
								</div>
				
								<div class="block unread" id="chat3" onclick="activateChat('chat3')">
									<div class="imgBox">
										<img src="assets/img/chat/img3.jpg" class="cover" alt="">
									</div>
									<div class="details">
										<div class="listHead">
											<h4>Aparna</h4>
											<p class="time">Yesterday</p>
										</div>
										<div class="message_p">
											<p>Meeting scheduled on Jan 10th</p>
											<b>2</b>
										</div>
									</div>
								</div>
								<div class="block" id="chat4" onclick="activateChat('chat4')">
									<div class="imgBox">
										<img src="assets/img/chat/img4.jpg" class="cover" alt="">
									</div>
									<div class="details">
										<div class="listHead">
											<h4>Angel</h4>
											<p class="time">Yesterday</p>
										</div>
										<div class="message_p">
											<p>Hey!</p>                            
										</div>
									</div>
								</div>
								<div class="block" id="chat5" onclick="activateChat('chat5')">
									<div class="imgBox">
										<img src="assets/img/chat/img7.jpg" class="cover" alt="">
									</div>
									<div class="details">
										<div class="listHead">
											<h4>Karthika</h4>
											<p class="time">18/01/2022</p>
										</div>
										<div class="message_p">
											<p>I'll get back to you</p>
										</div>
									</div>
								</div>
								<div class="block" id="chat6" onclick="activateChat('chat6')">
									<div class="imgBox">
										<img src="assets/img/chat/img8.jpg" class="cover" alt="">
									</div>
									<div class="details">
										<div class="listHead">
											<h4>Sajin</h4>
											<p class="time">22/01/2022</p>
										</div>
										<div class="message_p">
											<p>I'll get back to you</p>
										</div>
									</div>
								</div>

								<div class="block" id="chat6" onclick="activateChat('chat6')">
									<div class="imgBox">
										<img src="assets/img/chat/img8.jpg" class="cover" alt="">
									</div>
									<div class="details">
										<div class="listHead">
											<h4>Sajin</h4>
											<p class="time">22/01/2022</p>
										</div>
										<div class="message_p">
											<p>I'll get back to you</p>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- right side -->
						<div class="rightSide">

							<div class="header">
								<div class="imgText">
									<div class="userimg">
										<img src="https://ictglobaltech.com/assets/img/logo.png" alt="" class="cover">
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

								<!-- chat 1 -->
								<div id="chat1Content" class="chatContent">
									<div class="message my_msg">
										<p>Hi <br><span>12:18</span></p>
									</div>
									<div class="message friend_msg">
										<p>Hey <br><span>12:18</span></p>
									</div>
									<div class="message my_msg">
										<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. <br><span>12:15</span></p>
									</div>
									<div class="message friend_msg">
										<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. <br><span>12:15</span></p>
									</div>
									<div class="message my_msg">
										<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque aliquid fugiat accusamus dolore qui vitae ratione optio sunt <br><span>12:15</span></p>
									</div>
									<div class="message friend_msg">
										<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. <br><span>12:15</span></p>
									</div>
									<div class="message my_msg">
										<p>Lorem ipsum dolor sit amet consectetur <br><span>12:15</span></p>
									</div>
									<div class="message friend_msg">
										<p>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br><span>12:15</span></p>
									</div>
									<div class="message my_msg">
										<p>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br><span>12:15</span></p>
									</div>
									
								</div>


								<!-- message from Aparna -->
								<div id="chat2Content" class="chatContent" style="display: none;">
									<div class="message my_msg">
										<p>Hi <br><span>12:18</span></p>
									</div>
									<div class="message friend_msg">
										<p>Hey message from Bimal<br><span>12:18</span></p>
									</div>
									<div class="message my_msg">
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, consequatur mollitia. Alias nam dignissimos dolores debitis saepe reiciendis vel accusamus architecto est dolore consequuntur odit, magnam voluptatum quae similique optio. <br><span>12:18</span></p>
									</div>
								</div>

								<!-- chat 3 -->
								<div id="chat3Content" class="chatContent" style="display: none;">
									<div class="message my_msg">
										<p>Hi <br><span>12:18</span></p>
									</div>
									<div class="message friend_msg">
										<p>Hey message from Aparna<br><span>12:18</span></p>
									</div>
									<div class="message my_msg">
										<p>Hello Aparna <br><span>12:18</span></p>
									</div>
								</div>

								<!-- chat 4 -->
								<div id="chat4Content" class="chatContent" style="display: none;">
									<div class="message my_msg">
										<p>Hi <br><span>12:18</span></p>
									</div>
									<div class="message friend_msg">
										<p>Hey message from Angel<br><span>12:18</span></p>
									</div>
									
								</div>

								<!-- chat 5 -->
								<div id="chat5Content" class="chatContent" style="display: none;">
									<div class="message my_msg">
										<p>Hi <br><span>12:18</span></p>
									</div>
									<div class="message friend_msg">
										<p>Hey message from Karthika<br><span>12:18</span></p>
									</div>
									<div class="message my_msg">
										<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. <br><span>12:15</span></p>
									</div>
									<div class="message friend_msg">
										<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. <br><span>12:15</span></p>
									</div>
								</div>

								<!-- chat 6 -->
								<div id="chat6Content" class="chatContent" style="display: none;">
									<div class="message my_msg">
										<p>Hi <br><span>12:18</span></p>
									</div>
									<div class="message friend_msg">
										<p>Hey message from Sajin<br><span>12:18</span></p>
									</div>
									
								</div>
							</div>
							<!-- CHAT INPUT -->
							<div class="chat_input">
								<ion-icon name="happy-outline"></ion-icon>
								<!-- <ion-icon name="happy-outline"></ion-icon> -->
								<input type="text" placeholder="Type a message">
								<div class="whatsapp-button-containr">
									<a href="" target="_blank" class="whatsapp-button">
										<i class="fa fa-paper-plane send-icon"></i>
									</a>
								</div>
								<ion-icon name="mic"></ion-icon>
							</div>
						</div>
					</div>
				
				
					<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
				<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

				</div>
				<!-- footer -->
				@endsection

			</div>
	
</body>

<!-- Ionicons -->
<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
	document.getElementById("fullscreen-icon").addEventListener("click", function() {
		document.getElementById("containerx").classList.toggle("fullscreen");
	});
</script>

<script>
	// Function to activate a chat and display its content
function activateChat(chatId) {
  // Remove active class from all chat blocks
  const chatBlocks = document.querySelectorAll('.chatlist .block');
  chatBlocks.forEach(block => block.classList.remove('active'));

  // Add active class to the clicked chat block
  const activeChat = document.getElementById(chatId);
  activeChat.classList.add('active');

  // Hide all chat content sections
  const chatContents = document.querySelectorAll('.chatContent');
  chatContents.forEach(content => content.style.display = 'none');

  // Show the content of the active chat
  const activeChatContent = document.getElementById(chatId + 'Content');
  activeChatContent.style.display = 'block';

  // Update the header with chat details
  const chatName = activeChat.querySelector('.listHead h4').innerText;
  const chatImage = activeChat.querySelector('.imgBox img').getAttribute('src');
  document.querySelector('.rightSide .header .imgText h6').innerHTML = `${chatName} <br><small>online</small>`;
  document.querySelector('.rightSide .header .userimg img').setAttribute('src', chatImage);
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