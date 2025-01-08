<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0 align-items-center">
                    <div class="col-lg-4 mx-auto mt-5 py-5">
                        <div class="auth-form-light custom-card text-center p-md-5 p-2" style="border-radius: 20px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                            <h4>Reset your password</h4>
                            <p class="login-sub mb-5">Create a new password</p>

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div>
                                    <input id="email" type="email" class="input" name="email" placeholder="Email address" value="{{ old('email') }}" required>
                                    @error('email')
                                    <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <input id="password" class="input"  type="password" name="password" placeholder="New password" required>
                                    @error('password')
                                    <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <input id="password_confirmation" class="input" type="password" name="password_confirmation" placeholder="Confirm password" required>
                                </div>

                                <div>
                                    <button class="login mt-5" type="submit">Reset Password</button>
                                </div>
                            </form>
                        </div>
                        <!-- page-body-wrapper ends -->
                    </div>
                    <!-- container-scroller -->
                    <!-- plugins:js -->
                    <script src=".vendors/js/vendor.bundle.base.js"></script>
                    <!-- endinject -->
                    <!-- Plugin js for this page -->
                    <!-- End plugin js for this page -->
                    <!-- inject:js -->
                    <script src="{{asset('admin/.js/off-canvas.js')}}"></script>
                    <script src="{{asset('admin/.js/hoverable-collapse.js')}}"></script>
                    <script src="{{asset('admin/.js/template.js')}}"></script>
                    <script src="{{asset('admin/.js/settings.js')}}"></script>
                    <script src="{{asset('admin/.js/todolist.js')}}"></script>
                    <!-- endinject -->
</body>

</html>