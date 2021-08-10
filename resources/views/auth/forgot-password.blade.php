<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Order System - Forgot Password</title>

    <!-- Custom fonts for this template-->
     <link href="{{ asset('theme/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('theme/css/sb-admin-2.min.css') }}" rel="stylesheet">

    @livewireStyles

</head>

<body class="bg-gradient-primary" >

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block " style="background-image: url({{ asset('theme/img/forgot.jpg')}});">
                               
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                                    </div>

                                     @if (session('status'))
                                        <div class="mb-4 font-medium text-sm text-green-600">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <x-jet-validation-errors class="mb-4" />

                                    <form class="user" method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                       
                                        <div class="form-group">                                            
                                            <x-jet-input id="email" class="form-control form-control-user" 
                                            aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..."
                                            type="email" name="email" :value="old('email')" required autofocus />
                                        </div>                                      
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </button>
                                        
                                        
                                    </form>
                                    <hr>
                                    
                                    <div class="text-center">
                                        <a class="small" href={{ route('login') }}>Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src=" {{ asset('theme/vendor/jquery/jquery.min.js') }}"></script>
    <script src=" {{ asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src=" {{ asset('theme/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src=" {{ asset('theme/js/sb-admin-2.min.js') }}"></script>

    @livewireScripts    

</body>

</html>