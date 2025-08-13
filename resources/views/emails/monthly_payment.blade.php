<!DOCTYPE html>
<html>
<head>
    <title>Tagihan Bulanan</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 10px; text-align: center; }
        .content { padding: 20px; }
        .footer { margin-top: 20px; font-size: 0.8em; color: #6c757d; }
        .invoice { background: #f9f9f9; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Tagihan Bulanan Anda</h2>
        </div>
        
        <div class="content">
            <p>Halo {{ $user->name }},</p>
            
            <p>Berikut adalah detail tagihan bulanan Anda:</p>
            
            <div class="invoice">
                <p><strong>Bulan Tagih:</strong> {{ \Carbon\Carbon::parse($tagihan->bulan_tagih)->format('F Y') }}</p>
                <p><strong>Jumlah Tagihan:</strong> Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($tagihan->status) }}</p>
                <p><strong>Batas Pembayaran:</strong> {{ \Carbon\Carbon::parse($tagihan->bulan_tagih)->addDays(7)->format('d F Y') }}</p>
            </div>
            
            <p>Silakan lakukan pembayaran sebelum tanggal jatuh tempo untuk menghindari denda.</p>
            
            <p>
                <a href="{{ route('tagihan.index') }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                    Bayar Sekarang
                </a>
            </p>
        </div>
        
        <div class="footer">
            <p>Jika Anda memiliki pertanyaan, hubungi kami di support@example.com</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>