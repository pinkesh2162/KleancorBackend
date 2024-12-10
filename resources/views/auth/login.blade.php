<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Multikart admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities." />
    <meta name="keywords" content="admin template, Multikart admin template, dashboard template, flat admin template, responsive admin template, web app" />
    <link rel="icon" href="{{asset('assets/images/dashboard/favicon.png')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{asset('assets/images/dashboard/favicon.png')}}" type="image/x-icon" />
    <title>Admin Login</title>

    <!-- Google font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&display=swap" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" />

    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/font-awesome.css')}}" />


    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/themify-icons.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/flag-icon.css')}}">

    <!-- slick icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/slick.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/slick-theme.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/icofont.css')}}">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="" href="{{asset('assets/css/vendors/bootstrap.css')}}" />

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="page-wrapper">
        <div class="authentication-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 p-2 card-left">
                        <div class="card bg-primary">
                            <div class="single-item">
                                <div>
                                    <div>
                                        <h3>Welcome to Kleancor</h3>
                                        <p>
                                            Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy. Lorem Ipsum has been the
                                            industry's standard dummy.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <h3>Welcome to Kleancor</h3>
                                        <p>
                                            Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy. Lorem Ipsum has been the
                                            industry's standard dummy.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <h3>Welcome to Kleancor</h3>
                                        <p>
                                            Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy. Lorem Ipsum has been the
                                            industry's standard dummy.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 p-0 card-right">
                        <div class="card tab2-card card-login">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="top-profile-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><span class="icon-user me-2"></span>Login</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="top-tabContent">
                                    <div class="tab-pane fade show active" id="top-profile" role="tabpanel" aria-labelledby="top-profile-tab">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input required="" name="email" type="email" class="form-control" placeholder="Username" id="exampleInputEmail1" />
                                            </div>
                                            <div class="form-group">
                                                <input required="" name="password" type="password" class="form-control" placeholder="Password" />
                                            </div>
                                            <div class="form-terms">
                                                <div class="form-check mesm-2">
                                                    <input type="checkbox" class="form-check-input" id="customControlAutosizing" />
                                                    <label class="form-check-label ps-2" for="customControlAutosizing">Remember me</label>
                                                    @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="btn btn-default forgot-pass">Forgot Password!</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-button">
                                                <button class="btn btn-primary" type="submit">
                                                    Login
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- latest jquery-->
    <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <!-- feather icon js-->
    <script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>

    <!-- Sidebar jquery-->
    <script src="{{asset('assets/js/slick.js')}}"></script>

    <!-- lazyload js-->
    <script src="{{asset('assets/js/lazysizes.min.js')}}"></script>

    <script>
        $(".single-item").slick({
            arrows: false
            , dots: true
        , });

    </script>
</body>

</html>
