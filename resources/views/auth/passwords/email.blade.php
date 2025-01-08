<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Email</title>
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/02RpgdM2/whatsapp3d.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- font awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">    
    
    <style>
        body{
            background: rgb(187,255,189);
            background: linear-gradient(252deg, rgb(177, 251, 181) 0%, rgb(239, 255, 239) 51%, rgba(223,255,224,1) 100%);
            font-family: "Montserrat", sans-serif;
        }
        .custom-card{
            background: #fff;
            border-radius: 25px;
            width: 90%;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }
        .login-sub{
            color: rgb(128, 128, 128);
        }
        .input{
            width: 90%;
            margin-bottom: 30px;
            padding: 10px 30px 10px 30px;
            border-radius: 10px;
            border: .5px solid rgb(228, 228, 228);
        }
        .forgot-password{
           color: rgb(0, 143, 0);
           text-decoration: none;
        }
        .login{
            width: 90%;
            margin-top: 20px;
            background: #44d449;
            border: none;
            font-size: 20px;
            padding: 10px;
            border-radius: 50px;
            color: #fff;
            font-weight: 600;
        }
        .login:hover{
            background: #1ca320;
        }
        .password-container {
            position: relative; /* Allows positioning of the icon */
        }

        .toggle-password {
            position: absolute; /* Position the icon inside the input */
            right: 40px; /* Adjust the spacing from the right edge */
            top: 30%; /* Center the icon vertically */
            transform: translateY(-50%); /* Adjust for proper vertical alignment */
            cursor: pointer; /* Change cursor to pointer on hover */
            color: #aaa; /* Optional: change icon color */
        }


    </style>
</head>
<body>
    <div class="container">
        <div class="row align-items-center justify-content-center py-5" style="height: 100vh;">
        
            <div class="col-md-6 justify-content-center d-flex">
                <div class="custom-card text-center p-md-5 p-2">
                    <h4>Reset your password</h4>
                    <p class="login-sub mb-5">Forgot your password? No worries!</p>
                    
                    @if (session('status'))
                        <h6>{{ session('status') }}</h6>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <input class="input" name="email" type="email" placeholder="Enter your registered email">

                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
    
                        <button class="login">SEND RESET LINK</button>
                    </form>

                </div>
            </div>

            <div class="col-12 text-center fixed-bottom py-4">
                <p class="mt-3">Powered By <a href="https://ictglobaltech.com/" style="text-decoration:none; font-weight:500;">ICT Global Tech Pvt. Ltd.</a></p>
            </div>
        </div>
    </div>
    
</body>
</html>