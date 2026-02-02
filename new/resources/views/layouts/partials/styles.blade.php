    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon_arjuna/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
         .btn-gray {
        background-color: #6c757d;
        color: white;
    }

    /* resize table*/    
        /* Ukuran font lebih kecil dan padding lebih rapat */
        .minimizeTable th,
        .minimizeTable td {
            font-size: 9px;
            padding: 3px 4px;
        }

        /* Responsif: wrap teks jika perlu, tanpa scroll horizontal */
        .minimizeTable th,
        .minimizeTable td {
            white-space: normal; /* Mengizinkan teks membungkus */
        }

        /* Maksimal lebar kolom agar proporsional */
        .minimizeTable th:nth-child(1),
        .minimizeTable td:nth-child(1) {
            width: 30px; /* No */
        }

        .minimizeTable th:nth-child(2),
        .minimizeTable td:nth-child(2),
        .minimizeTable th:nth-child(10),
        .minimizeTable td:nth-child(10) {
            width: 90px; /* No Order dan Tgl Order */
        }

        .minimizeTable th:nth-child(3),
        .minimizeTable td:nth-child(3) {
            width: 100px; /* Tgl Pakai */
        }

        .minimizeTable th:nth-child(4),
        .minimizeTable td:nth-child(4) {
            width: 120px; /* Nama Pemesan */
        }

        .minimizeTable th:nth-child(5),
        .minimizeTable td:nth-child(5),
        .minimizeTable th:nth-child(6),
        .minimizeTable td:nth-child(6) {
            width: 140px; /* Alamat & Tujuan */
        }

        .minimizeTable th:nth-child(7),
        .minimizeTable td:nth-child(7),
        .minimizeTable th:nth-child(8),
        .minimizeTable td:nth-child(8) {
            width: 100px; /* Armada & Driver */
        }

        .minimizeTable th:nth-child(9),
        .minimizeTable td:nth-child(9) {
            width: 80px; /* Status */
        }

        .minimizeTable th:nth-child(11),
        .minimizeTable td:nth-child(11) {
            width: 60px; /* Aksi */
            text-align: center;
        }

        /* Pastikan tabel menyusut sesuai ruang */
        .minimizeTable {
            table-layout: fixed;
            word-wrap: break-word;
        }

        /* Agar tidak ada scroll horizontal di container */
        .table-responsive {
            overflow-x: hidden;
        }
    </style>

    @stack('styles')
