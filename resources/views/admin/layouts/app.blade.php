<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Backend</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-bar-rating/fontawesome-stars.css') }}">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />


    @stack('styles')
</head>

<body class="sidebar-dark">
    <div class="container-scroller">
        <!-- Navbar -->
        @include('partials.backend-navbar')
        <!-- End Navbar -->

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            @include('partials.backend-sidebar')
            <!-- End Sidebar -->

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- Footer -->
                @include('partials.backend-footer')
                <!-- End Footer -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <!-- End DataTables -->

    <script src="{{ asset('assets/vendors/jquery-bar-rating/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/morris.js/morris.min.js') }}"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    {{-- <script src="{{ asset('assets/js/dashboard.js') }}"></script> --}}
    <!-- End custom js for this page-->
    @stack('scripts')
</body>

</html>
