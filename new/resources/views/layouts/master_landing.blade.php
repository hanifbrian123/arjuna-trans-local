<!doctype html>
<html lang="en" data-layout="horizontal" data-layout-style="" data-layout-position="fixed" data-topbar="light">
    <head>
        <meta charset="utf-8" />
        <title>Order Customer || Arjuna Trans</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon_arjuna/favicon.ico') }}">
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        @stack('styles')
        <style>
            .hero-banner {
                position: relative;
                background: url('{{ asset('assets/images/header-customer.jpg') }}') center/cover no-repeat;
                /* background: url('assets/images/header-customer.jpg') center/cover no-repeat; */
                height: 300px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                text-align: center;
                padding: 20px;
            }

            .hero-banner::before {
                content: "";
                position: absolute;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* overlay hitam transparan */
                z-index: 1;
            }

            .hero-content {
                position: relative;
                z-index: 2;
                max-width: 800px;
            }

            .hero-content h1 {
                font-size: 28px;
                font-weight: 700;
                margin-bottom: 10px;
                color: aliceblue;
            }

            .hero-content h1 span {
                color: #EA6602;
            }

            .hero-content p {
                font-size: 16px;
                margin-bottom: 20px;
            }

            .hero-content .btn-order {
                background-color: #EA6602;
                color: white;
                padding: 10px 20px;
                border-radius: 8px;
                font-weight: bold;
                border: none;
                transition: background 0.3s;
                text-decoration: none;
            }

            .hero-content .btn-order:hover {
                background-color: #EA6602;
            }

            .container-fluid{
                position: relative;
                z-index: 3;

            }

            .tour-card {
                background: url('{{ asset('assets/images/footer-customer.jpg') }}') center/cover no-repeat;
                /* background: url('assets/images/footer-customer.jpg') center/cover no-repeat; */
                position: relative;
                border-radius: 0px;
                height: 180px;
                overflow: hidden;
                color: white;
                /* z-index: 0; */
            }

            .tour-card .overlay {
                /* position: absolute; */
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(255, 128, 0, 0.85);
                z-index: 1;
                /* Lebih rendah dari dropdown */
                position: absolute; /* atau sesuai kebutuhan */
            }

            .tour-card .content {
                position: relative;
                z-index: 2;
                display: flex;
                justify-content: space-between;
                align-items: center;
                height: 100%;
                padding: 0 40px;
            }

            .tour-card .left {
                flex: 1;
                text-align: center !important;

            }

            .tour-card .right {
                flex: 1;
            }

            .tour-card h3 {
                font-size: 24px;
                margin: 0;
                color: white;
            }

            .tour-card ul {
                list-style: none;
                padding-left: 0;
            }

            .tour-card ul li::before {
                content: "✔️ ";
                margin-right: 6px;
            }

            .select {
                position: relative; /* atau absolute/fixed sesuai konteks */
                z-index: 9999;
            }

            .btn-orange {
                background: linear-gradient(45deg, #ff9a00, #ff5e00);
                color: white;
                border: none;
                border-radius: 50px;
                padding: 10px 20px;
                transition: all 0.4s ease;
                font-weight: 500;
            }

            .btn-orange:hover {
                background: linear-gradient(45deg, #ffb347, #ff7043);
                transform: scale(1.05);
                box-shadow: 0 4px 10px rgba(255, 94, 0, 0.4);
                color: white;
            }

            .modal-backdrop {
                z-index: -1;
            }
        </style>
    </head>
<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.landing.partials.header')

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row my-4">
                    <div class="col-12 text-center">
                        <div class="btn-group" role="group" aria-label="Menu Navigation">
                            <a href="{{ route('customer.calendar') }}" class="btn btn-orange mx-2" title="Klik untuk melihat jadwal">Jadwal</a>
                            <a href="{{ route('customer.formCust') }}" class="btn btn-primary mx-2" title="Klik untuk melakukan pemesanan">Formulir Pemesanan</a>
                            <a href="{{ route('login') }}" class="btn btn-orange mx-2" title="Klik untuk login">Login</a>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- start page title -->
                @yield('content')
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            @include('layouts.landing.partials.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/alert-utils.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
