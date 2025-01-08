<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        
        .form-check{
            margin-left: 5%;
            margin-right: 5%;
        }

    </style>
</head>
<body>
    <div class="container">
        
        <div class="row align-items-center py-5" style="height: 100vh;">
            <div class="col-12">
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
            </div>
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
                <div class="custom-card text-center p-md-4 p-2">
                    <h4>Create an account</h4>
                    <p class="login-sub mb-5">Register to continue</p>

                    <form action="{{ route('app.register') }}" method="post">
                        @csrf
                        <input class="input" type="text" name="name" placeholder="Enter your name" required>
                        <input class="input" type="tel" name="mobile" placeholder="Enter your mobile number" required>
                        <input class="input" type="email" name="email" placeholder="Enter your email" required>
                        
                        <div class="password-container">
                            <input class="input" type="password" id="password" placeholder="Create your password" required>
                            <i class="fa-solid fa-eye toggle-password" id="togglePassword1"></i>
                        </div>

                        <div class="password-container">
                            <input class="input" type="password" name="password" id="confirmPassword" placeholder="Confirm your password" required>
                            <i class="fa-solid fa-eye toggle-password" id="togglePassword2"></i>
                        </div>
                        <small id="passwordError" style="color: red; display: none; margin-top: -25px; text-align:start;  margin-left:5%;">Passwords not matching</small>

                        <div class="form-check text-start mt-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                            <label class="form-check-label" for="flexCheckDefault">
                                I agree to the <a href="" style="text-decoration:none;">Terms & Conditions</a> and <a href="" style="text-decoration:none;">Privacy Policy</a>
                            </label>
                        </div>

                        <button class="login">REGISTER</button>

                    </form>

                    <p class="mt-3">Already have an Account? <a href="login" class="forgot-password">Login Now</a></p>
                </div>
            </div>

            <div class="col-12 text-center">
                <p class="mt-5">Powered By <a href="https://ictglobaltech.com/" style="text-decoration:none; font-weight:500;">ICT Global Tech Pvt. Ltd.</a></p>
            </div>
        </div>
    </div>

    <script>
        // Function to check password matching
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const errorElement = document.getElementById('passwordError');

    if (password !== confirmPassword) {
        errorElement.style.display = 'block';
        return false; // Prevent form submission
    } else {
        errorElement.style.display = 'none';
        return true;
    }
}

// Toggle password visibility for the first password input
document.getElementById('togglePassword1').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});

// Toggle password visibility for the confirm password input
document.getElementById('togglePassword2').addEventListener('click', function () {
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPasswordInput.setAttribute('type', type);

    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});

// Add event listener for form submission
document.querySelector('form').addEventListener('submit', function (e) {
    if (!checkPasswordMatch()) {
        e.preventDefault(); // Prevent form submission if passwords don't match
    }
});

// Add event listener for typing in confirm password input
document.getElementById('confirmPassword').addEventListener('input', checkPasswordMatch);

    </script>
    
</body>
</html>