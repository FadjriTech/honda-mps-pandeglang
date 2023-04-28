<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/skydash/vendors/feather/feather.css">
    <link rel="stylesheet" href="/skydash/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/skydash/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="/skydash/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="/skydash/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/skydash/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/skydash/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        @include('components.topbar')
        <div class="container-fluid page-body-wrapper">
            @include('components.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.
                            Premium <a href="/skydash/https://www.bootstrapdash.com/" target="_blank">Bootstrap admin
                                template</a> from BootstrapDash. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="ti-heart text-danger ml-1"></i></span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="/skydash/vendors/js/vendor.bundle.base.js"></script>
    <script src="/skydash/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="/skydash/js/dataTables.select.min.js"></script>
    <script src="/skydash/js/off-canvas.js"></script>
    <script src="/skydash/js/hoverable-collapse.js"></script>
    <script src="/skydash/js/template.js"></script>
    <script src="/skydash/js/settings.js"></script>
    <script src="/skydash/js/todolist.js"></script>
    <script src="/skydash/js/dashboard.js"></script>
    <script src="/skydash/js/Chart.roundedBarCharts.js"></script>

    @yield('script')
</body>

</html>
