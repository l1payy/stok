<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penggunaan Obat</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0C447C; padding-bottom: 10px; }
        .header h1 { color: #0C447C; margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; font-size: 14px; color: #666; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; border-collapse: collapse; }
        .info td { padding: 5px 0; font-size: 12px; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background-color: #0C447C; color: white; padding: 10px; font-size: 12px; text-align: left; }
        table.data td { padding: 8px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
        .footer p { margin-bottom: 60px; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('storage/logo/logo.png') }}" alt="Logo">
        </div>
        <h1>UPT PUSKESMAS KARANG REJO</h1>
        <p>Aplikasi Monitoring Persediaan Stok Obat</p>
        <p>Jl. Karang Rejo No. 123, Karang Rejo</p>
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
                <th width="30">No</th>
                <th>Nama Obat</th>
                <th width="80">Satuan</th>
                <th width="60" class="text-center">Masuk</th>
                <th width="60" class="text-center">Keluar</th>
                <th width="80" class="text-center">Sisa Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold">{{ $item->nama_obat }}</td>
                    <td class="text-center">{{ ucfirst($item->satuan) }}</td>
                    <td class="text-center">{{ $item->masuk }}</td>
                    <td class="text-center">{{ $item->keluar }}</td>
                    <td class="text-center">{{ $item->sisa_stok }}</td>
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
</body>
</html>
