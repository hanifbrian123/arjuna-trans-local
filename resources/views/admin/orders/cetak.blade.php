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
        .image-watermark {
            position: fixed;
            display: block;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: 100px 100px;
            background-position: 30px 30px;
            background-repeat: no-repeat;
            opacity: 1;
            z-index: 2;
            cursor: pointer;
        }
    </style>
</head>
<body>
    {{-- Tampilkan watermark hanya jika status dibatalkan --}}
    @if($data->status == 'canceled')
        <div class="image-watermark">
            <img src="{{ asset('assets/images/FrameCencel.png') }}" alt="Photo">
        </div>
    @endif
    @if($data->status == 'approved' && $data->remaining_cost == 0)
    <div class="image-watermark">
        <img src="{{ asset('assets/images/Frame 1022.png') }}" alt="Photo">
    </div>
    @endif

    <div class="page-break">
        <!-- HEADER -->
        <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

            <!-- LOGO KIRI -->
            <div class="logo">
                <img src="{{ asset('assets/images/arjuna-logo.png') }}" width="80" height="80" alt="Logo Arjuna">
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

        <div class="table-data" style="margin-top: 0px">
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <tr><td>Nama</td><td>: {{$data->name}}</td></tr>
                    <tr><td>Alamat</td><td>: {{$data->address}}</td></tr>
                    <tr><td>Route</td><td>: {{$data->route}}</td></tr>
                    <tr><td>Tanggal Pakai</td>
                        <td>: {{ \Carbon\Carbon::parse($data->start_date)->translatedFormat('d F Y') }} Jam : {{ \Carbon\Carbon::parse($data->start_time)->format('H:i') }}</td>
                    </tr>
                    <tr><td>Pemberangkatan</td><td>: {{$data->pickup_address}}</td></tr>
                    <tr><td>Jumlah Bus</td><td>: ({{$data->vehicle_count}}) {{$vehiclesInfo}}</td></tr>
                    <tr><td>Harga Sewa</td><td>: Rp {{ number_format($data->rental_price, 0, ',', '.') }} ,-</td></tr>
                    <tr><td>Uang Muka</td><td>: Rp {{ number_format($data->down_payment, 0, ',', '.') }} ,-</td></tr>
                    <tr><td>Sisa Ongkos</td><td>: Rp {{ number_format($data->remaining_cost, 0, ',', '.') }} ,-</td></tr>
                    <tr><td>Lain - lain</td><td>: {{$data->additional_notes}}</td></tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 30px; font-size: 14px; background-color: #f7f7f7; padding: 10px; border: 1px solid #ddd;">
            <strong>Catatan:</strong>
            <ol style="padding-left: 20px;">
                <li>Apabila terjadi keadaan darurat (Force Majeur) penyewa tidak berhak mengajukan klaim.</li>
                <li>Apabila mengalami kerusakan, dan bus penggantinya tidak ada, maka uang sewa dikembalikan 100%.</li>
                <li>Bila terjadi perubahan jadwal/pembatalan, harus memberitahukan 1 bulan sebelumnya. jika tidak uang tidak dapat diambil kembali.</li>
                <li>Barang hilang di dalam bus, resiko Panitia Rombongan</li>
                <li>Pelunasan pembayaran 3 hari sebelum bus berangkat</li>
                <li>Apabila ada kenaikan BBM, tarif ikut naik.</li>
            </ol>
        </div>

        <div style="width: 100%; font-size: 12pt; margin-top:30px;">
            <table style="width:100%; text-align:center;">
                <tbody>
                    <tr>
                        <td style="width:50%; text-align:left; vertical-align:bottom;">
                            <p>Mojokerto, {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</p>
                            <p>Pengurus Arjuna Trans</p>

                            <div style="position: relative; width: fit-content; height: 100px;">
                                <!-- Gambar tanda tangan dan stempel -->
                                <img src="{{ asset('assets/images/Group 3.png') }}"
                                     alt="Tanda Tangan + Stempel"
                                     style="position: absolute; top: 0; left: 0; height: 100px; z-index: 1; opacity: 0.95;">
                            </div>
                            <div class="signature-line"></div>
                        </td>
                        <td style="width:50%; text-align:center; vertical-align:bottom;">
                            <p>Pemesan</p>
                            <div class="signature-box-pemesan">
                                <p style="margin: 0;">{{$data->name}}</p>
                                <div class="signature-line"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p style="color:#db0404;"><small>Catatan: Biaya Tol, Parkir dan Fee Sopir menjadi tanggung jawab penyewa</small></p>
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
