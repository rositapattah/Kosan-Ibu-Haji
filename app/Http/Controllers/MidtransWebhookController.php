<?php
namespace App\Http\Controllers;

use App\Events\UserActivityLogged;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\tagihan;
use Midtrans\Config;
use App\Mail\PembayaranBerhasilMail;
use Illuminate\Support\Facades\Mail;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Config::$isProduction = config('midtrans.is_production');
        Config::$serverKey = config('midtrans.server_key');

        $notif = new Notification();

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        // Cari pembayaran berdasarkan order_id yang diterima dari Midtrans
        $pembayaran = Pembayaran::where('order_id', $orderId)->first();

        if (!$pembayaran) {
            // Log this error: pembayaran not found for the given order ID
            return response()->json(['message' => 'Pembayaran not found'], 404);
        }

        $tagihan = $pembayaran->tagihan; // Ambil tagihan terkait

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                // TODO: set status 'challenge' di database
                $pembayaran->status = 'belum bayar'; // Atau status 'challenge' jika ada
                $pembayaran->metode_pembayaran = $notif->payment_type;
                $pembayaran->save();
                // Opsional: berikan notifikasi ke admin untuk review
            } else if ($fraudStatus == 'accept') {
                // TODO: set status 'sudah bayar' di database
                $pembayaran->status = 'sudah bayar';
                $pembayaran->tanggal_bayar = now();
                $pembayaran->metode_pembayaran = $notif->payment_type;
                $pembayaran->save();

                // Update status tagihan menjadi 'lunas'
                if ($tagihan) {
                    $tagihan->status = 'lunas';
                    $tagihan->save();
                }

                $user = $pembayaran->user;
                // Kirim email ke user
                if ($user && $user->email) {
                    Mail::to($user->email)->send(new PembayaranBerhasilMail($pembayaran));
                }

                // Log the user activity
                event(new UserActivityLogged(
                    $user->id,
                    $user->name . ' telah melakukan pembayaran sewa bulan ' . $tagihan->bulan . ' dengan total ' . $pembayaran->total_harga,
                    $request->ip()
                ));

                // Redirect ke halaman tagihan resi
                return redirect()->route('tagihan.resi', $pembayaran->id);
            }
        } else if ($transactionStatus == 'settlement') {
            // TODO: set status 'sudah bayar' di database
            $pembayaran->status = 'sudah bayar';
            $pembayaran->tanggal_bayar = now();
            $pembayaran->metode_pembayaran = $notif->payment_type;
            $pembayaran->save();

            // Update status tagihan menjadi 'lunas'
            if ($tagihan) {
                $tagihan->status = 'lunas';
                $tagihan->save();
            }
            $user = $pembayaran->user;
            // Kirim email ke user
            if ($user && $user->email) {
                Mail::to($user->email)->send(new PembayaranBerhasilMail($pembayaran));
            }

            // Log the user activity
                event(new UserActivityLogged(
                    $user->id,
                    $user->name . ' telah melakukan pembayaran sewa bulan ' . $tagihan->bulan . ' dengan total ' . 'Rp. '. number_format($pembayaran->total_harga, 10, ',', '.'),
                    $request->ip()
                ));

            // Redirect ke halaman tagihan resi
            return redirect()->route('tagihan.resi', $pembayaran->id);
        } else if ($transactionStatus == 'pending') {
            // TODO: set status 'pending' di database
            $pembayaran->status = 'belum bayar'; // Status masih belum bayar/pending
            $pembayaran->metode_pembayaran = $notif->payment_type;
            $pembayaran->save();
        } else if ($transactionStatus == 'deny') {
            // TODO: set status 'gagal' di database
            $pembayaran->status = 'gagal';
            $pembayaran->metode_pembayaran = $notif->payment_type;
            $pembayaran->save();
        } else if ($transactionStatus == 'expire') {
            // TODO: set status 'expired' di database
            $pembayaran->status = 'expired';
            $pembayaran->metode_pembayaran = $notif->payment_type;
            $pembayaran->save();
        } else if ($transactionStatus == 'cancel') {
            // TODO: set status 'batal' di database
            $pembayaran->status = 'batal';
            $pembayaran->metode_pembayaran = $notif->payment_type;
            $pembayaran->save();
        }

        return response()->json(['message' => 'Notification processed successfully.'], 200);
    }
}

