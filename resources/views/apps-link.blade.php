<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Kleancor Privacy Policy" />
    <meta name="keywords" content="Privacy Policy" />
    <link rel="icon" href="{{asset('assets/images/dashboard/favicon.png')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{asset('assets/images/dashboard/favicon.png')}}" type="image/x-icon" />
    <title>Kleancor: Cleaning Service App | Share Link</title>

    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">

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
    <style>
        .privacy-text {
            font-family: 'Quicksand', sans-serif !important;
            text-align: justify;
            font-size: 2vh !important;
            font-weight: 400 !important;
            line-height: 1.8 !important;
            margin-bottom: 20px !important;
            color: #222 !important;
        }

        .mobile-img img {
            height: 450px;
            width: auto;
            text-align: center;
        }

        .share-button {
            position: absolute;
            transform: translate(155%, 23%);
            background: transparent !important;
            border: none !important;
        }

        .share-button img {
            height: 45px !important;
        }

        .share-button-2 {
            position: absolute;
            transform: translate(-265%, 23%);
            background: transparent !important;
            border: none !important;
        }

        .share-button-2 img {
            height: 45px !important;
        }

        @media (max-width: 480px) {
            .page-header {
                display: none;
            }

            .footer {
                display: none;
            }

            .mobile-img img {
                height: 220px;
                width: auto;
                text-align: center;
            }

            .share-button {
                position: absolute;
                transform: translate(64%, 100%);
                background: transparent !important;
                border: none !important;
            }

            .share-button img {
                height: 45px !important;
                width: 153px;
            }

            .share-button-2 {
                position: absolute;
                transform: translate(63%, 0%);
                background: transparent !important;
                border: none !important;
            }

            .share-button-2 img {
                height: 45px !important;
            }
        }
    </style>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="theme-color-1">
    <div class="page-wrapper">
        <div class="authentication-box">
            <div class="container">
                <div class="row">
                    <div style="color: #222;text-align: center;">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <h2 style="font-size: 25px;font-weight: 600; text-align: center; margin-top: 0!important;">Kleancor Apps</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <p class="privacy-text">
                                    Download the app to post your cleaning service job from your smartphone and share it with your friends to get a 20% discount.
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="mobile-img">
                                    <img src="{{asset('assets/images/data-deletion/app-screen.png')}}" alt="app-screen">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="share-button">
                                    <a href="https://play.google.com/store/apps/details?id=com.kleancor.kleancorapp" target="_blank">
                                        <img src="{{asset('assets/images/data-deletion/vantamart-play-store.png')}}" alt="play-store-link">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="share-button-2">
                                    <a href="https://apps.apple.com/us/app/ventamart-flea-market-latino/id1528834094" target="_blank">
                                        <img src="{{asset('assets/images/data-deletion/vantamart-app-store.png')}}" alt="app-store">
                                    </a>
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
            arrows: false,
            dots: true,
        });
    </script>
</body>

</html>