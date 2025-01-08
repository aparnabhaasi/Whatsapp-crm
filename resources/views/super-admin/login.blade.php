<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login</title>
    <link rel="icon" type="image/x-icon" href="https://ictglobaltech.com/assets/imgs/logo/favicon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        .cus-card{
            background: #fff;
            border-radius: 20px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
        input{
            width: 100%;
            padding: 10px;
            border-radius: 50px;
            margin-bottom: 20px;
            border: 1px solid rgb(192, 192, 192);
            padding-left: 20px;
        }
        .login{
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border-radius: 50px;
            border: none;
            color: #fff;
            background: rgb(0, 180, 0);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 20px;
        }
        .login:hover{
            background: rgb(0, 150, 0);
        }
        input:focus{
            border: 2px solid rgb(0, 189, 0);
            outline: none;
        }
    </style>
</head>
<body style="background: #f2f5ff;">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-4">
                <div class="cus-card text-center p-5">
                    <h2 style="color: rgb(1, 209, 1);"><b>WhatsAPP CRM</b></h2>
                    <h4 style="color: rgb(194, 194, 194); margin-bottom: 60px;">Super Admin Login</h4>

                    <form action="{{ url('/super-admin-login') }}" method="post">
                        @csrf
                        <input type="email" name="email" placeholder="Username">
                        <input type="password" name="password" placeholder="Password">
                        <button type="submit" class="login">Login</button>
                    </form>
                    
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <p class="text-danger mt-3">{{ $error }}</p>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <p class="fixed-bottom text-center">Powered by ICT Global Tech Pvt. Ltd.</p>
        </div>
    </div>
</body>
</html>