<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/animation.js') }}"></script>
        <style>
            body {
                background-color:#ffffff;
                margin:0;
                height: 100%;
                display: none;
            }

            .container-fluid {
                padding-left: 0;
            }
            #left-object {
                background-color: #C8151B;
                position: fixed;
                top:0;
                left:0;
                z-index:1;
                bottom:0;
                overflow: hidden;
            }
            #right-object {
                background-color: #fff;
            }
            @media screen and (max-width: 992px){
                #left-object,#grid-inline{
                    display: none;
                }
            }
            /* .path-image {
                width: 90%;
            } */
            .login-logo {
                margin-top:70px;
            }
            .logo {
                width: 200px;
            }
            .form-costum {
                border-radius: 0;
                text-align: center;
            }
            .image{
                height: 100%;
                background-position: center center;
                background-repeat: no-repeat;
                background-size:80%;
            }
            .card-hover {
                width: 100%;
                height:100%;
            }
            .card{
                width: 100%;
                height: 100%;
                background: transparent;
                overflow: hidden;
                border:none;
            }
            .card-content{
                transform-style: preserve-3d;
                height: 100%;
            }
            .hover-in{
                transition: .3s ease-out;
            }
            .hover-out{
                transition: .3s ease-in;
            }
            .shine {
                display:none;
            }
            .custom-control-label:before {
                border:1px solid #c7c7c7;
                border-radius: 0 !important;
                background: transparent;
            }
            .custom-control-label:after, .custom-control-label:before {
                width:19px;
                height:19px;
                margin-top:-1px !important;
            }
            .costumcheckbox1 {
                font-size: 14px !important;
            }
            .custom-checkbox .custom-control-input:checked~.custom-control-label:before {
                background: #e3342f;
            }
        </style>
    </head>
<body>
<div class="container-fluid">
    <div class="row">
        @if (session('notActiveSession'))
            <script>
                toastr.error('{{ session('notActiveSession') }}', {timeOut:5000})
            </script>
        @endif
        @if (session('ipSession'))
            <script>
                toastr.error('{{ session('ipSession') }}', {timeOut:5000})
            </script>
        @endif
        @if (session('resetPassword'))
            <script>
                toastr.success('{{ session('resetPassword') }}', {timeOut:5000})
            </script>
        @endif

        <div class="col-md-6" id="left-object" align="center">
                <!-- <img src="images/group198.png" class="path-image"> -->
                <div class="card-hover">
			    <div class="card">
				<div class="card-content">
					<div class="image" style="background-image: url('images/group198.png');"></div>
				</div>
			</div>
		</div>
        </div>
        <div class="col-md-6" id="grid-inline">
        </div>
        <div class="col-lg-6 col-md-12 col-sx-12" id="right-object">
            <center>
                <div class="mb-5">
                    <img src="images/group677.png" alt="Logo" class="mt-5 logo">
                </div>
                <div>
                    <img src="images/logo.png" class="login-logo">
                    <p class="text-danger"><b>Willkommen zum Termin Haus</b></p>
                </div>
            </center>
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                @csrf

                <div class="form-group">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-sm-8 mx-3 mt-5">
                            <input id="email" type="text" class="form-costum form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus >

                            @if ($errors->has('email'))
                                <span class="invalid-feedback text-center" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback text-center">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-sm-8 mx-3">
                            <input id="password" type="password" class="form-costum form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Kennwort" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback text-center" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @else
                                <div class="invalid-feedback text-center">
                                    <strong> Dieses Feld ist erforderlich </strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <center>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label checkbox-inline costumcheckbox1" for="remember">{{ __('Anmelde Datei speichern') }}</label>
                    </div>
                </center>
                <center>
                    <button type="submit" class="btn btn-danger px-5 mt-4 mb-3">
                        {{ __('Anmelden') }}
                    </button>
                </center>

            </form>
        </div>
    </div>
</div>
</body>
<script>
    $('body').delay(500).fadeIn();
    (function() {
            'use strict';
            window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
                }, false);
            });
            }, false);
        })();
</script>
</html>
