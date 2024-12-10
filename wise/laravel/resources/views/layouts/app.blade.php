<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>
        @isset ($title )
        Wise Trade | {{ $title }}
            @else
            Wise Trade | Home
        @endisset
         </title>


    <!-- Bootstrap -->
    <link href="{{ url('/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url('/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ url('/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ url('/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ url('/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ url('/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="{{ url('/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ url('/build/css/custom.min.css') }}" rel="stylesheet">
       <!--Dtae Picker -->

       <link href="{{ url('/build/css/jquery-ui.css') }}" rel="stylesheet">
       <link href="{{ url('/build/css/mystyle.css') }}" rel="stylesheet">

       <!-- End Date Picker -->

    @hasSection ('css')
    @yield('css')
    @endif
    <script src="{{ url('/vendors/jquery/dist/jquery.min.js') }}"></script>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            <!-- left navigation start -->
            @include('includes.leftnav')
            <!-- left navigation end -->

            <!-- top navigation start -->
            @include('includes.topnav')
            <!-- top navigation end -->

            <!-- main content -->
            <div class="right_col" role="main">
                @hasSection ('content')
                @yield('content')
                @else
                <h2>Start Adding Content Here.</h2>
                @endif
            </div>
            <!-- /main content -->

            <!-- footer content -->
            <footer>
                <div class="row">
                  <div class="col-sm-12">
                    Copyright &copy; Wise Trade
                  </div>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->

        </div>
    </div>
</body>



<!-- jQuery -->

<!-- Bootstrap -->
<script src="{{ url('/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('/vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ url('/vendors/nprogress/nprogress.js') }}"></script>
<!-- Chart.js -->
<script src="{{ url('/vendors/Chart.js/dist/Chart.min.js') }}"></script>
<!-- gauge.js -->
<script src="{{ url('/vendors/gauge.js/dist/gauge.min.js') }}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ url('/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ url('/vendors/iCheck/icheck.min.js') }}"></script>
<!-- Skycons -->
<script src="{{ url('/vendors/skycons/skycons.js') }}"></script>
<!-- Flot -->
<script src="{{ url('/vendors/Flot/jquery.flot.js') }}"></script>
<script src="{{ url('/vendors/Flot/jquery.flot.pie.js') }}"></script>
<script src="{{ url('/vendors/Flot/jquery.flot.time.js') }}"></script>
<script src="{{ url('/vendors/Flot/jquery.flot.stack.js') }}"></script>
<script src="{{ url('/vendors/Flot/jquery.flot.resize.js') }}"></script>
<!-- Flot plugins -->
<script src="{{ url('/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
<script src="{{ url('/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
<script src="{{ url('/vendors/flot.curvedlines/curvedLines.js') }}"></script>
<!-- DateJS -->
<script src="{{ url('/vendors/DateJS/build/date.js') }}"></script>
<!-- JQVMap -->
<script src="{{ url('/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
<script src="{{ url('/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ url('/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ url('/vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ url('/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<!-- Custom Theme Scripts -->
<script src="{{ url('/build/js/custom.min.js') }}"></script>
<!--Date Picker -->

<script src="{{ url('/build/js/jquery-1.12.4.js') }}"></script>
<script src="{{ url('/build/js/jquery-ui.js') }}"></script>

<!-- End Date Picker -->

@hasSection ('js')
@yield('js')
@endif

</html>
