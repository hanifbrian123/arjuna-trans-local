<!doctype html>
<html lang="en" data-layout="horizontal" data-layout-style="" data-layout-position="fixed" data-topbar="light">
<head>
    <meta charset="utf-8" />
    <title>Arjuna Trans</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />    
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .hero-banner {
            position: relative;            
            background: url('assets/images/header-customer.jpg') center/cover no-repeat;
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

        .tour-card {
            background: url('assets/images/footer-customer.jpg') center/cover no-repeat;
            position: relative;
            border-radius: 0px;
            height: 180px;
            overflow: hidden;
            color: white;
        }

        .tour-card .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 128, 0, 0.85);
            z-index: 1;
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
    </style>
</head>
<body>

    <!-- Begin page -->
    <div id="layout-wrapper">    
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
        <div class="two-column-menu"></div>
        <div class="navbar-menu"></div>

        <!-- Hero Start -->
        <div class="hero-banner">
            <div class="hero-content">
                <h1>
                    Pemesanan Arjuna Trans Pariwisata<br>
                    <span>Nyaman, Aman, Bikin Liburan Asik!</span>
                </h1>
                <p>
                    Nggak perlu pusing soal transportasi, karena Arjuna Trans siap antar Anda dengan<br>
                    layanan aman, nyaman, dan terpercaya. Liburan jadi lebih tenang, perjalanan makin menyenangkan!
                </p>                
            </div>
        </div>
        <!-- Hero End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
                <div class="container-fluid">                    
                    <!-- start page title -->
                    <div class="row" style="margin-bottom: 20px;margin-top: 20px">
                        <div class="col-12 text-center">
                            <h3 class="mb-0" style="color: rgb(29, 98, 210)">Formulir Pemesanan</h3>
                        </div>
                    </div>
                
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8 mx-auto">
                            <div class="card">                                
                                <div class="card-body">
                                    <form action="{{ route('customer.saveCust') }}" method="POST">
                                        @csrf                                    
                                        <!-- Nama Pemesan -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">NAMA PEMESAN (WAJIB)</label>                                            
                                                    <input type="text" id="nameInput" name="name" class="form-control" placeholder="Masukkan nama pemesan" required>
                                                </div>
                                            </div>
                                            <!-- Nomor Telepon -->                                        
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="phoneInput" class="form-label">NO.WHATSAPP (WAJIB)</label>
                                                    <input type="number" id="phoneInput" name="phone_number" class="form-control" placeholder="Masukkan nomor telepon" required>
                                                </div>
                                            </div>
                                        </div>                                    
                                  
                                    
                                        <!-- Alamat -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="addressInput" class="form-label">ALAMAT PEMESAN (WAJIB)</label>
                                                    <textarea id="addressInput" name="address" class="form-control" placeholder="Masukkan alamat lengkap" rows="3" required></textarea>
                                                </div>
                                            </div>                                            
                                        </div>                                                                        
                                    
                                        <!-- Tanggal Pakai -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="startDateInput" class="form-label">WAKTU KEBERANGKATAN</label>
                                                    <input type="datetime-local" id="startDateInput" name="start_date" class="form-control" required>
                                                </div>
                                            </div>
                                            <!-- Tanggal Selesai -->                                        
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="endDateInput" class="form-label">WAKTU TIBA KEMBALI</label>
                                                    <input type="datetime-local" id="endDateInput" name="end_date" class="form-control" required>
                                                </div>
                                            </div>                                        
                                        </div>
                                                                        
                                        <!-- Alamat Penjemputan -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="pickupAddressInput" class="form-label">ALAMAT PENJEMPUTAN (WAJIB)</label>
                                                    <textarea id="pickupAddressInput" name="pickup_address" class="form-control" placeholder="Masukkan alamat penjemputan" rows="3" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Tujuan -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="destinationInput" class="form-label">TUJUAN UTAMA (WAJIB)</label>
                                                    <input type="text" id="destinationInput" name="destination" class="form-control" placeholder="Masukkan tujuan utama" required>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Rute -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="routeInput" class="form-label">RUTE TUJUAN (WAJIB)</label>
                                                    <textarea id="routeInput" name="route" class="form-control" placeholder="Masukkan rute perjalanan" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>                                                                        
                                    
                                        <!-- Armada -->
                                        <div class="row">
                                            <div class="col-lg-12">                                            
                                                <div class="mb-3">
                                                    <label for="vehicleIdsInput" class="form-label">PILIH ARMADA (WAJIB) <small class="text-muted">Pilih satu atau lebih armada</small></label>
                                                    <select id="vehicleIdsInput" name="vehicle_ids[]" class="form-select" data-choices data-choices-removeItem multiple required>
                                                        @foreach ($vehicles as $vehicle)
                                                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }} - {{ $vehicle->type }} ({{ $vehicle->capacity }} Seat)</option>
                                                        @endforeach
                                                    </select>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Driver Pilihan -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="driverIdsInput" class="form-label">PILIH DRIVER (OPSIONAL) <small class="text-muted">Pilih satu atau lebih driver</small></label>
                                                    <select id="driverIdsInput" name="driver_ids[]" class="form-select" data-choices data-choices-removeItem multiple required>
                                                        @foreach ($drivers as $driver)
                                                            <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                                                        @endforeach
                                                    </select>                                                    
                                                </div>
                                            </div>
                                        </div>                                                                              
                                    
                                        <!-- Tombol Simpan -->
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg" style="background-color: #ff7f00; color: white; border: none; border-radius: 6px; padding: 10px 20px;">
                                                Pesan Sekarang
                                            </button>
                                        </div>                                        
                                    </form>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                </div>
                <!-- container-fluid -->

                <!-- Footer Inform -->
                <div class="tour-card">
                    <div class="overlay"></div>
                    <div class="content">
                        <div class="left">
                            <h3>Mitra Pariwisata<br>Untuk Anda</h3>
                        </div>
                        <div class="right">
                            <ul>
                                <li>Antar Jemput Door to Door</li>
                                <li>Armada Nyaman</li>
                                <li>Driver Berpengalaman</li>
                                <li>Tarif Terjangkau</li>
                                <li>Pesan via Online</li>
                                <li>Bebas Jam Berangkat</li>
                            </ul>
                        </div>
                    </div>
                </div>                
                <!-- End Footer Inform -->                   
            </div>
            <!-- end main content-->                    
    </div>
    <!-- END layout-wrapper -->
    
    {{-- @include('layouts.partials.scripts') --}}
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script>
        (z = document.querySelectorAll("[data-choices]")),
        Array.from(z).forEach(function (e) {
            var t = {},
                a = e.attributes;
            a["data-choices-groups"] &&
                (t.placeholderValue =
                    "This is a placeholder set in the config"),
                a["data-choices-search-false"] && (t.searchEnabled = !1),
                a["data-choices-search-true"] && (t.searchEnabled = !0),
                a["data-choices-removeItem"] && (t.removeItemButton = !0),
                a["data-choices-sorting-false"] && (t.shouldSort = !1),
                a["data-choices-sorting-true"] && (t.shouldSort = !0),
                a["data-choices-multiple-remove"] && (t.removeItemButton = !0),
                a["data-choices-limit"] &&
                    (t.maxItemCount = a["data-choices-limit"].value.toString()),
                a["data-choices-limit"] &&
                    (t.maxItemCount = a["data-choices-limit"].value.toString()),
                a["data-choices-editItem-true"] && (t.maxItemCount = !0),
                a["data-choices-editItem-false"] && (t.maxItemCount = !1),
                a["data-choices-text-unique-true"] &&
                    (t.duplicateItemsAllowed = !1),
                a["data-choices-text-disabled-true"] && (t.addItems = !1),
                a["data-choices-text-disabled-true"]
                    ? new Choices(e, t).disable()
                    : new Choices(e, t);
        });
    </script>

    <!-- Global Alert Component -->
    <x-alert />

</body>

</html>
