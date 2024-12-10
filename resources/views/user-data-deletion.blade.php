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
    <title>User Data Deletion</title>

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
            font-family: 'Quicksand', sans-serif;
            text-align: justify;
            font-size: 2vh;
            font-weight: 400;
            line-height: 1.5;
            margin-bottom: 20px;
        }

    </style>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="theme-color-1">
    <!-- User Data Deletion section start -->
    <section class="about-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="page-title">
                    <h2>User Data Deletion:</h2>
                </div>
                <div class="col-sm-12">
                    <p class="privacy-text">Users have the right to request deletion of their personal data.</p>

                    <p class="privacy-text">Upon receipt of a deletion request, kleancor will delete the user's personal data immediately.</p>
                    <p class="privacy-text">Kleancor will also delete any backup copies of the user's personal data within a reasonable timeframe.</p>
                    <p class="privacy-text">In case of legal obligations or legitimate business interests, kleancor may retain some personal data even after a deletion request, but only for as long as necessary and in accordance with applicable laws.</p>
                    <p class="privacy-text">We inform the user of any retention periods that apply to their personal data upon receipt of a deletion request.</p>
                    <h5>Using the Kleancor app, follow the below screen steps to delete your account</h5>

                    <img src="{{asset('assets/images/data-deletion/delete-screen-1.png')}}" alt="delete-screen"> <br> <br> <br>

                    <h5>Confrim by typing "DELETE ACCOUNT"</h5>
                    <img src="{{asset('assets/images/data-deletion/delete-screen-2.png')}}" alt="delete-screen"> <br> <br> <br>

                    <h5>IT WILL BE DELETED YOUR ACCOUNT IMMEDIATELY</h5>
                    <img src="{{asset('assets/images/data-deletion/delete-screen-3.png')}}" alt="delete-screen">

                </div>
            </div>
        </div>
    </section>
    <!-- about section end -->

    <!-- tap to top -->
    <div class="tap-top">
        <div>
            <i class="fa fa-angle-double-up"></i>
        </div>
    </div>
    <!-- tap to top end -->

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
