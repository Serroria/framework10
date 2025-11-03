<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $judul ?? 'Laporan' }}</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 98%;
            margin: 0 auto;
        }

        /* --- Bagian Header --- */
        .header {
            width: 100%;
            margin-bottom: 10px;
            /* Menggunakan flexbox, tapi tabel lebih aman untuk dompdf */
            display: table;
            width: 100%;
            border-bottom: 2px solid #000;
        }
        .header-logo, .header-title, .header-spacer {
            display: table-cell;
            vertical-align: top;
        }
        .header-logo {
            width: 120px;
        }
        .header-logo img {
            width: 100%;
        }
        .header-title {
            text-align: center;
        }
        .header-title h2 {
            margin: 0;
            padding: 0;
            font-size: 18px;
            color: #D90000; /* Warna dari contoh gambar */
        }
        .header-title h3 {
            margin: 5px 0;
            font-size: 16px;
        }
        .header-title p {
            margin: 0;
            font-size: 12px;
        }
        .header-spacer {
            width: 120px;
        }

        /* --- Bagian Tabel Konten --- */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .content-table th,
        .content-table td {
            border: 1px solid #000;
            padding: 4px; /* Perkecil padding untuk laporan */
            text-align: left;
        }
        .content-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-size: 10px;
        }
        .content-table td {
            font-size: 9px; /* Perkecil font data tabel */
        }
        .text-center {
            text-align: center;
        }

        /* --- Bagian Tanda Tangan (Footer) --- */
        .footer-signatures {
            margin-top: 30px;
            width: 100%;
            display: table;
        }
        .signature-box {
            display: table-cell;
            width: 33.3%;
            text-align: center;
        }
        .signature-box .signature-title {
            margin-bottom: 60px; /* Ruang untuk TTD */
        }

    </style>
</head>
<body>

    <div class="container">

        <div class="header">
            <div class="header-logo">
                <img src="{{ public_path('cat.png') }}" alt="Logo">
            </div>
            <div class="header-title">
                <h2>REKAP MUTASI STOK</h2> <h3>{{ $judul ?? 'Laporan' }}</h3>
                <p>Periode Cetak: {{ $periode ?? 'N/A' }}</p>
            </div>
            <div class="header-spacer"></div> </div>

        <table class="content-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Unit</th>
                    <th>Type</th>
                    <th>Information</th>
                    <th>Qty</th>
                    <th>Producer</th>
                    </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td class="text-center">{{ $item->id }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->information }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td>{{ $item->producer }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data untuk ditampilkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-signatures">
            <div class="signature-box">
                <div class="signature-title">Ditandatangani Oleh,</div>
                <div class="signature-name">(.....................)</div>
                <div>Kepala Produksi</div>
            </div>
            {{-- <div class="signature-box">
                <div class="signature-title">Diketahui Oleh,</div>
                <div class="signature-name">(.....................)</div>
                <div>Kepala Depo</div>
            </div>
            <div class="signature-box">
                <div class="signature-title">&nbsp;</div>
                <div class="signature-name">(.....................)</div>
                <div>Fin & ACC</div>
            </div> --}}
        </div>

    </div>

</body>
</html>
