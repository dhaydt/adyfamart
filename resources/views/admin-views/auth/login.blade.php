<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title -->
    <title>{{\App\CPU\translate('Adyfamart | Login')}}</title>

    <link rel="shortcut icon" href="favicon.ico">
    {{--
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet"> --}}
    {{--
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/vendor.min.css"> --}}
    {{--
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/vendor/icon-set/style.css"> --}}
    {{--
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/theme.minc619.css?v=1.0"> --}}
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/toastr.css">

    <!-- Favicon -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('public/login/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('public/login/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/login/css/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
    <style>
        .half {
            height: 100vh;
        }

        .half .bg {
            background-size: cover;
            background-position: center;
        }

        .half .contents,
        .half .bg {
            width: 50%;
        }

        .half,
        .half .container>.row {
            height: 100vh;
        }

    </style>
</head>

<body>


    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url({{ asset('public/login/images/bg_1.jpg') }});">
        </div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <h3><strong>Login</strong></h3>
                        <p class="mb-4">Masukan Username & Password.</p>
                        <form action="{{ route('admin.auth.login') }}" method="post">
                            @csrf
                            <div class="form-group first">
                                <label for="username">Username</label>
                                <input type="text" name="email" class="form-control" placeholder="your-email@gmail.com"
                                    id="username">
                            </div>
                            <div class="form-group last mb-3">
                                <label for="password">Password</label>
                                <input name="password" type="password" class="form-control" placeholder="Your Password"
                                    id="password">
                            </div>

                            <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                                    <input type="checkbox" checked="checked" />
                                    <div class="control__indicator"></div>
                                    <!--</label>
                    <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> -->
                            </div>

                            <input type="submit" value="Log In" class="btn btn-block btn-primary">

                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <!-- JS Implementing Plugins -->
    {{-- <script src="{{asset('public/assets/back-end')}}/js/vendor.min.js"></script>

    <!-- JS Front -->
    <script src="{{asset('public/assets/back-end')}}/js/theme.min.js"></script> --}}
    <script src="{{ asset('public/login/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('public/login/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/login/js/main.js') }}"></script>
    <script src="{{asset('public/assets/back-end')}}/js/toastr.js"></script>
    {!! Toastr::message() !!}

    @if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
    @endif

    <!-- JS Plugins Init. -->
    <script>
    </script>

    @if(env('APP_MODE')=='demo')
    <script>
        function copy_cred() {
            $('#signinSrEmail').val('admin@admin.com');
            $('#signupSrPassword').val('12345678');
            toastr.success('Copied successfully!', 'Success!', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
    @endif

    <!-- IE Support -->
    <script>
        if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
    </script>
</body>

</html>
