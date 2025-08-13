<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .content h4 {
            margin-top: 0;
            color: #343a40;
        }
        .content p {
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .details {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }
        .details li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .details strong {
            color: #495057;
        }
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h4>Resi Pembayaran Tagihan</h4>
    </div>
    <div class="content">
        <p>Halo <strong>{{ $user->name }}</strong>,</p>
        <p>Pembayaran Anda telah berhasil diproses. Berikut adalah rincian tagihan Anda:</p>
        <ul class="details">
            <li><strong>Bulan Tagih</strong> <span>{{ \Carbon\Carbon::parse($tagihan->bulan_tagih)->translatedFormat('F Y') }}</span></li>
            <li><strong>Jumlah Tagihan</strong> <span>Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</span></li>
            <li><strong>Tanggal Pembayaran</strong> <span>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y H:i') }}</span></li>
            <li><strong>Metode Pembayaran</strong> <span>{{ ucfirst($pembayaran->metode_pembayaran) }}</span></li>
            <li><strong>Status</strong> <span style="color:green;font-weight:bold;">LUNAS</span></li>
        </ul>
        <p>Terima kasih telah melakukan pembayaran tepat waktu.</p>
        <p>Salam hangat,<br>Kosan Ibu Haji</p>
    </div>
    <div class="footer">
        &copy; 2025 Kosan Ibu Haji. All rights reserved.
    </div>
</div>
</body>
</html>