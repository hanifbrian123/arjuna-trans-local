<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INVOICE ARJUNA TRANS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&display=swap" rel="stylesheet">

    <style>
        html {
            font-family: 'Inter', sans-serif;
            padding: 20px;
            font-size: 14px;
        }

        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            margin-bottom: 20px;
        }

        .no-seri {
            display: flex;
            width: 100%;
            height: 25px;
            color: white;
            background-color: rgba(44, 180, 226, 0.517);
            font-weight: 900;
            align-items: center;
        }

        .table {
            width: 100%;
            font-size: 14px;
        }

        td {
            vertical-align: bottom;
            text-align: center;
        }

        .signature-box, .signature-box-pemesan {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            height: 100px;
        }

        .signature-line {
            width: 70%;
            border-top: 1px solid black;
        }

        td, th {
            text-align: left;
            padding: 0 !important;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .tanda-tangan {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .tanda-tangan .tanda-tangan-content {
            margin: 20px;
            text-align: center;
        }

        .tanda-tangan .tanda-tangan-content p {
            margin-top: 5em;
        }

        .flex-container li {
            list-style-type: none;
            margin-right: 10px;
        }

        .table td:first-child {
            width: 30%;
        }

        /* WATERMARK STYLE */
        .image-watermark img {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%; /* Lebar penuh agar responsif */
            height: 100%; /* Tinggi penuh */
            background-size: cover; /* Gambar akan disesuaikan agar tidak terpotong */
            background-position: center; /* Menempatkan gambar di tengah */
            background-repeat: no-repeat; /* Gambar tidak diulang */
            opacity: 0.4; /* Menambahkan transparansi untuk watermark */
            z-index: 3;
            pointer-events: none; /* Agar watermark tidak mengganggu interaksi dengan elemen lainnya */
        }

    </style>
</head>
<body>
    {{-- Tampilkan watermark hanya jika status dibatalkan --}}
    @if($data->status == 'canceled')
        <div class="image-watermark">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/FrameCencel.png'))) }}" alt="Photo"/>
        </div>
    @endif
    @if($data->status == 'approved' && $data->remaining_cost == 0)
    <div class="image-watermark">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/Frame 1022.png'))) }}" alt="Photo"/>
    </div>
    @endif

    <div class="page-break">
        <!-- HEADER -->
        <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

            <!-- LOGO KIRI -->
            <div class="logo">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/favicon_arjuna/android-chrome-512x512.png'))) }}" width="80" height="80" alt="Logo Arjuna"/>
            </div>

            <!-- TEKS KANAN -->
            <div class="header-text" style="text-align: right;">
                <p style="margin: 0; color: #0066cc; font-size: 62px;">INVOICE</p>
                <p style="margin: 0; color: #031425; font-size: 15px;">PESAN SEWA BUS & SURAT JALAN</p>
                <div class="no-seri" style="color: white; background-color: rgba(44, 180, 226, 0.517); padding: 5px 15px; font-weight: 500;">
                    NO : {{$data->order_num}}
                </div>
            </div>

        </div>

        <hr style="margin: 0px 0;">
        <div>
            <h3 style="margin: 5px 0;font-weight: bold;color:#0066cc;">Wisata, Privat Trip, Tour dan Rombongan</h3>
            <strong>Arjuna Trans</strong><br>
            RT 01 RW 01 Ds Pesanan, Ds Bicak, Kec Trowulan – Kab. Mojokerto<br>
            Telp: 081938845765 / 0838778345649
        </div>

        <div class="no-seri">
            @php
                $plates = collect($data->vehicles)->pluck('license_plate')->implode('--');
                $vehiclesInfo = collect($data->vehicles)
                    ->map(fn($v) => $v->name . ' - ' . $v->type)
                    ->implode(', ');
            @endphp
            <div style="margin-left: 25px">NOPOL : {{$plates}}</div>
        </div>

        <table class="table" style="width: 100%; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top; width: 25%;">Nama</td>
                    <td style="width: 1%; vertical-align: top;">:</td>
                    <td style="word-break: break-word;">{{$data->name}}</td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top;">Alamat</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="word-break: break-word;">{{$data->address}}</td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top;">Route</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="word-break: break-word;">{{$data->route}}</td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top;">Tanggal Pakai</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="word-break: break-word;">
                        : {{ \Carbon\Carbon::parse($data->start_date)->translatedFormat('d F Y H:i') }} s/d {{ \Carbon\Carbon::parse($data->end_date)->translatedFormat('d F Y H:i') }}
                    </td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top;">Pemberangkatan</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="word-break: break-word;">{{$data->pickup_address}}</td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top;">Jumlah Bus</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="word-break: break-word;">({{count($data->vehicles)}}) {{$vehiclesInfo}}</td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top;">Harga Sewa</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="word-break: break-word;">Rp {{ number_format($data->rental_price, 0, ',', '.') }} ,-</td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top;">Uang Muka</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="word-break: break-word;">Rp {{ number_format($data->down_payment, 0, ',', '.') }} ,-</td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top;">Sisa Ongkos</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="word-break: break-word;">Rp {{ number_format($data->remaining_cost, 0, ',', '.') }} ,-</td>
                </tr>
                <tr>
                    <td style="white-space: nowrap; vertical-align: top;">Lain - lain</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="word-break: break-word;">{{$data->additional_notes}}</td>
                </tr>
            </tbody>
        </table>


        <div style="margin-top: 30px; font-size: 14px; background-color: #f7f7f7; padding: 10px; border: 1px solid #ddd;">
            <strong>Catatan:</strong>
            <ol style="padding-left: 20px;">
                <li>Apabila terjadi keadaan darurat (Force Majeur) penyewa tidak berhak mengajukan klaim.</li>
                <li>Apabila mengalami kerusakan, dan bus penggantinya tidak ada, maka uang sewa dikembalikan 100%.</li>
                <li>Perubahan jadwal hanya dapat dilakukan H-10 keberangkatan.</li>
                <li>Pembatalan mengakibatkan DP hangus</li>
                <li>Barang hilang di dalam bus, resiko Panitia Rombongan</li>
                <li>Pelunasan pembayaran 3 hari sebelum bus berangkat</li>
                <li>Apabila ada kenaikan BBM, tarif ikut naik.</li>
            </ol>
        </div>

        <div style="width: 100%; font-size: 12pt; margin-top:30px;">
            <table style="width:100%; text-align:center;">
                <tbody>
                    <tr>
                        <!-- Kolom Tanda Tangan Pengurus -->
                        <td style="width:50%; text-align:left; vertical-align:bottom; padding-left: 10px;">
                            <p>Mojokerto, {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</p>
                            <p>Pengurus Arjuna Trans</p>

                            <div style="position: relative; width: fit-content; height: 100px;">
                                <!-- Gambar tanda tangan dan stempel -->
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/Group 3.png'))) }}" alt="Tanda Tangan + Stempel"
                                style="position: absolute; top: 0; left: 0; height: 100px; z-index: 1; opacity: 0.95;"/>
                            </div>
                            <div class="signature-line" style="width: 60%;""></div>
                        </td>

                        <!-- Kolom Tanda Tangan Pemesan -->
                        <td style="width:50%; text-align:center; vertical-align:bottom; padding-right: 20px;">
                            <p>Pemesan</p>
                            <div class="signature-box-pemesan" style="position: relative;">
                                <p style="margin: 0; position: absolute; left: 26%;">{{$data->name}}</p>
                                <div class="signature-line" style="width: 60%; margin-left: 25%;"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
