<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18pt;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items th, .items td {
            border: 1px solid #000;
            padding: 5px;
        }
        .items th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>NOTA TRANSAKSI</h1>
        <p>{{ config('app.name', 'Laravel') }}</p>
    </div>
    
    <div class="info">
        <table>
            <tr>
                <td width="50%">
                    <strong>No. Transaksi:</strong> {{ $transaksi->id }}<br>
                    <strong>Tanggal:</strong> {{ date('d/m/Y', strtotime($transaksi->tanggal_transaksi)) }}
                </td>
                <td width="50%">
                    <strong>Customer:</strong> {{ $transaksi->customer ? $transaksi->customer->nama_customer : 'Umum' }}<br>
                    @if($transaksi->customer && $transaksi->customer->alamat)
                    <strong>Alamat:</strong> {{ $transaksi->customer->alamat }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
    
    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksi as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->produk->nama_produk }}</td>
                <td>{{ $detail->jumlah_barang }}</td>
                <td>{{ $detail->jenis_satuan }}</td>
                <td>Rp {{ number_format($detail->sub_total / $detail->jumlah_barang, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="total">
        <table>
            <tr>
                <td width="80%" style="text-align: right;"><strong>Subtotal:</strong></td>
                <td width="20%">Rp {{ number_format($transaksi->total_transaksi + $transaksi->diskon, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td width="80%" style="text-align: right;"><strong>Diskon:</strong></td>
                <td width="20%">Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td width="80%" style="text-align: right;"><strong>Total:</strong></td>
                <td width="20%"><strong>Rp {{ number_format($transaksi->total_transaksi, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
    
    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
    </div>
</body>
</html>