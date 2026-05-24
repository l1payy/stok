<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penggunaan Obat</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px 30px;
        }

        .kop-surat {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            height: 100px;
            /* Atur tinggi tetap agar proporsional */
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .kop-logo {
            width: 120px;
            text-align: center;
        }

        .kop-logo img {
            width: 100px;
            height: auto;
            margin-left: 15px;
        }

        .kop-text {
            text-align: center;
            line-height: 1.2;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            font-weight: normal;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 11px;
            font-style: italic;
        }

        .info {
            margin-bottom: 20px;
        }

        .info h3 {
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .info table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            padding: 5px 0;
            font-size: 12px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th {
            background-color: #0C447C;
            color: white;
            padding: 10px;
            font-size: 11px;
            text-align: center;
            border: 1px solid #0C447C;
        }

        table.data td {
            padding: 8px 5px;
            border: 1px solid #ddd;
            font-size: 10px;
            vertical-align: middle;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }

        .footer p {
            margin-bottom: 60px;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ public_path('storage/logo/kop.jpg') }}" alt="Logo" class="logo-img">
                </td>
                <td class="kop-text">
                    <h2>PEMERINTAH KABUPATEN LANGKAT</h2>
                    <h1>UPT PUSKESMAS KARANG REJO</h1>
                    <p>JL. TG. PURA KM. 33,3 KARANG REJO KODE POS. 20811</p>
                    <p>Laman : pkmkrejo@gmail.com</p>
                </td>
                <td width="80"></td> <!-- Spacer agar teks tetap di tengah -->
            </tr>
        </table>
    </div>

    <div class="info">
        <h3 class="text-center">LAPORAN REKAPITULASI PENGGUNAAN OBAT</h3>
        <table>
            <tr>
                <td width="100">Tanggal Cetak</td>
                <td width="10">:</td>
                <td class="font-bold">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Rentang Laporan</td>
                <td>:</td>
                <td class="font-bold">{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Obat</th>
                <th width="10%">Satuan</th>
                <th width="10%">Masuk</th>
                <th width="10%">Keluar</th>
                <th width="15%">Harga Satuan</th>
                <th width="15%">Total Harga Keluar</th>
                <th width="10%">Sisa Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="font-bold">{{ $item->nama_obat }}</td>
                <td class="text-center">{{ ucfirst($item->satuan) }}</td>
                <td class="text-center">{{ number_format($item->masuk, 0, ',', '.') }}</td>
                <td class="text-center">{{ number_format($item->keluar, 0, ',', '.') }}</td>
                <td class="text-center">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-center">Rp {{ number_format($item->harga_satuan * $item->keluar, 0, ',', '.') }}</td>
                <td class="text-center">{{ number_format($item->sisa_stok, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Karang Rejo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Mengetahui,</p>
        <p class="font-bold">( __________________________ )</p>
        <p>Kepala Puskesmas</p>
    </div>
</div>
</body>

</html>