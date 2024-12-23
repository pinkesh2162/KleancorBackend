<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="Multikart admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities." />
    <meta name="keywords"
        content="admin template, Multikart admin template, dashboard template, flat admin template, responsive admin template, web app" />
    <meta name="author" content="pixelstrap" />
    <link rel="icon" href="{{ asset('assets/images/dashboard/favicon.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('assets/images/dashboard/favicon.png') }}" type="image/x-icon" />
    <title>@yield('title')</title>


    <!-- Google font-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&display=swap" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" />

    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/font-awesome.css') }}" />


    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify-icons.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">

    <!-- slick icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">

    <!-- Prism css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">

    <!-- Chartist css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/chartist.css') }}">

    <!-- Datatable css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="" href="{{ asset('assets/css/vendors/bootstrap.css') }}" />

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
        @include('components.header')

        <div class="page-body-wrapper">

            @include('components.side-bar')

            @yield('content')

            @include('components.footer')

        </div>
    </div>

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>

    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/slick.js') }}"></script>

    <!-- lazyload js-->
    <script src="{{ asset('assets/js/lazysizes.min.js') }}"></script>

    <!--script admin-->
    <script src="{{ asset('assets/js/admin-script.js') }}"></script>

    <!--chartist js-->
    <script src="{{ asset('assets/js/chart/chartist/chartist.js') }}"></script>

    <!--chartjs js-->
    <script src="{{ asset('assets/js/chart/chartjs/chart.min.js') }}"></script>


    <!--copycode js-->
    <script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>

    <!--counter js-->
    <script src="{{ asset('assets/js/counter/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>

    <!--peity chart js-->
    <script src="{{ asset('assets/js/chart/peity-chart/peity.jquery.js') }}"></script>

    <!-- Apex Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!--sparkline chart js-->
    <script src="{{ asset('assets/js/chart/sparkline/sparkline.js') }}"></script>

    <!-- Datatables js-->
    <script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/custom-basic.js') }}"></script>

    {{-- Font Awesome Icons --}}
    <script defer src="{{ asset('assets/js/fontawesome/all.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/fontawesome/fontawesome.min.js') }}"></script>


    <!--Customizer admin-->
    {{-- <script src="{{asset('assets/js/admin-customizer.js')}}"></script> --}}

    <!--dashboard custom js-->
    <script src="{{ asset('assets/js/dashboard/default.js') }}"></script>

    <!--right sidebar js-->
    <script src="{{ asset('assets/js/chat-menu.js') }}"></script>

    <!--height equal js-->
    <script src="{{ asset('assets/js/height-equal.js') }}"></script>

</body>

</html>