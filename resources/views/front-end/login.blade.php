<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <div class="row align-items-center py-5" style="height: 100vh;">
            <div class="col-md-6">
                <h2 style="line-height:1.3;">Transform the Way You Engage with Customers on <b style="color: #44d449;">WhatsApp <i class="fa-brands fa-whatsapp"></i></b></h2>

                <div class="mt-4 p-2">
                    <p><i class="fa-solid fa-check"></i> Targeted campaigns for personalized offers.</p>
                    <p><i class="fa-solid fa-check"></i> Customizable templates for quick communication.</p>
                    <p><i class="fa-solid fa-check"></i> Secure platform for managing conversations.</p>
                    <p><i class="fa-solid fa-check"></i> User-friendly interface for all businesses.</p>
                    <p><i class="fa-solid fa-check"></i> Send bulk messages with a personal touch.</p>
                    <p><i class="fa-solid fa-check"></i> Unified dashboard for customer interactions.</p>
                    <p><i class="fa-solid fa-check"></i> Easily organize and import contact lists.</p>
                    <p><i class="fa-solid fa-check"></i> Boost sales with timely follow-ups via WhatsApp.</p>
                </div >
            </div>


            <div class="col-md-6 justify-content-center d-flex">
                <div class="custom-card text-center p-md-5 p-4">
                    <h4>Log in to your account</h4>
                    <p class="login-sub mb-5">Welcome Back! Login to continue</p>

                    <form action="{{ route('admin-login') }}" method="post">
                        @csrf
                        <input class="input" type="email" name="email" placeholder="Enter your email">
    
                        <div class="password-container">
                            <input class="input" type="password" name="password" id="password" placeholder="Enter your password">
                            <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                        </div>
                        
    
                        <div class="text-end" style="width: 95%;">
                            <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                        </div>
    
                        <button type="submit" class="login">LOGIN</button>
                    </form>

                    @if ($errors->has('loginError'))
                        <div class="alert alert-danger d-flex justify-content-between mt-4" role="alert">
                            <p class="mb-0">{{ $errors->first('loginError') }}</p>
                            <a type="button" class="" data-bs-dismiss="alert" aria-label="Close" style="cursor:pointer; color:#ff0000; text-decoration:none;">X</a>
                        </div>
                    @endif

                    <p class="mt-5">Don't have an Account? <a href="register" class="forgot-password">Register Now</a></p>
                </div>
            </div>

            <div class="col-12 text-center">
                <p class="mt-3">Powered By <a href="https://ictglobaltech.com/" style="text-decoration:none; font-weight:500;">ICT Global Tech Pvt. Ltd.</a></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
    
            // Change the icon based on the password visibility
            if (type === 'text') {
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash'); // Show the eye-slash icon when the password is visible
            } else {
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye'); // Show the eye icon when the password is hidden
            }
        });
    </script>
    
</body>
</html>