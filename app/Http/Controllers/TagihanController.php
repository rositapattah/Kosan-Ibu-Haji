<?php

namespace App\Http\Controllers;

use App\Events\UserActivityLogged;
use App\Models\tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role == 'admin'){
            $sudahDibayar = tagihan::where('status', 'lunas')->count();
            $belumDibayar = tagihan::where('status', 'belum bayar')->count();
            $total = tagihan::all()->count();
            $tagihan = tagihan::all();
            return view('admin.tagihan.index', compact('tagihan', 'sudahDibayar','belumDibayar','total'));
        }
        else if(auth()->user()->role == 'user'){
            $tagihan = tagihan::with('user')
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
            return view('tagihan.index', compact('tagihan'));
        }
    }

    public function bayar_manual($id){
        $tagihan = Tagihan::with('user')->findOrFail($id);
        return view('admin.tagihan.konfirmasi', compact('tagihan'));
    }
    
    public function konfirmasi_manual($id){
        $tagihan = Tagihan::with('user')->findOrFail($id);
        $tagihan->status = 'lunas';

        $tagihan->update();
        
        // Cek apakah pembayaran sudah ada
        $pembayaran = Pembayaran::where('tagihan_id', $tagihan->id)->first();

        if ($pembayaran) {
            // Jika sudah ada, update
            $pembayaran->update([
                'tanggal_bayar' => now(),
                'total_harga' => $tagihan->jumlah_tagihan ?? 0,
                'metode_pembayaran' => 'manual',
                'status' => 'sudah bayar',
            ]);
        } else {
            // Jika belum ada, buat baru
            Pembayaran::create([
                'tagihan_id' => $tagihan->id,
                'user_id' => $tagihan->user_id,
                'tanggal_bayar' => now(),
                'total_harga' => $tagihan->jumlah_tagihan ?? 0,
                'metode_pembayaran' => 'manual',
                'status' => 'sudah bayar',
            ]);
        }

        // Log the user activity
        event(new UserActivityLogged(
            Auth::id(),
            'Admin mengonfirmasi pembayaran manual untuk tagihan dengan ID ' . $tagihan->id,
            request()->ip()
        ));

        return redirect()->route('tagihan.index')->with('success', "Tagihan berhasil Dilunasi");

    }

    public function checkout(Tagihan $tagihan)
    {
        // Pastikan tagihan ini milik user yang sedang login
        if ($tagihan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke tagihan ini.');
        }

        // Cek jika tagihan sudah lunas
        if ($tagihan->status === 'lunas') {
            return redirect()->back()->with('info', 'Tagihan ini sudah lunas.');
        }

        // Cari apakah sudah ada pembayaran pending untuk tagihan ini
        $existingPembayaran = Pembayaran::where('tagihan_id', $tagihan->id)
                                        ->where('user_id', Auth::id())
                                        ->where('status', 'belum bayar') // Atau 'pending' jika kamu punya status itu
                                        ->first();

        // Set konfigurasi Midtrans (diperlukan baik untuk membuat token baru maupun memvalidasi)
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $snapToken = null;
        $orderId = null;
        $user = Auth::user();

        if ($existingPembayaran && $existingPembayaran->snap_token) {
            // Jika ada pembayaran pending dan snap_token sudah ada, gunakan snap_token yang sudah ada
            $snapToken = $existingPembayaran->snap_token;
            $orderId = $existingPembayaran->order_id;
            // Opsional: Anda bisa memvalidasi snap_token ke Midtrans jika ingin lebih aman,
            // namun untuk kasus sederhana ini kita asumsikan valid.
            session()->flash('info', 'Anda melanjutkan pembayaran yang belum selesai.');
        } else {
            // Jika belum ada pembayaran pending atau snap_token belum ada, buat yang baru
            $orderId = 'TRX-' . $tagihan->id . '-' . time() . '-' . rand(100, 999); // Contoh Order ID yang lebih unik
            $params = array(
                'transaction_details' => array(
                    'order_id' => $orderId,
                    'gross_amount' => $tagihan->jumlah_tagihan,
                ),
                'customer_details' => array(
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->no_hp, // Opsional: tambahkan nomor telepon user
                ),
                'item_details' => array(
                    [
                        'id' => $tagihan->id,
                        'price' => $tagihan->jumlah_tagihan,
                        'quantity' => 1,
                        'name' => 'Pembayaran Kosan Bulan ' . Carbon::parse($tagihan->bulan_tagih)->format('F Y'),
                    ]
                )
            );

            try {
                $snapToken = Snap::getSnapToken($params);

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal membuat transaksi Midtrans: ' . $e->getMessage());
            }
        }

        // Simpan atau update data pembayaran ke database
        // Gunakan updateOrCreate untuk menghindari duplikasi
        $pembayaran = Pembayaran::updateOrCreate(
            ['tagihan_id' => $tagihan->id, 'user_id' => Auth::id(), 'status' => 'belum bayar'], // Kriteria untuk menemukan record existing
            [
                'tanggal_bayar' => Carbon::now(),
                'total_harga' => $tagihan->jumlah_tagihan,
                'metode_pembayaran' => 'Midtrans Snap',
                'status' => 'belum bayar',
                'order_id' => $orderId,
                'snap_token' => $snapToken,
            ]
        );

        return view('tagihan.checkout', compact('snapToken', 'tagihan'));
    }

    public function showResi($id)
    {
        $pembayaran = Pembayaran::with('tagihan')->findOrFail($id);

        // Optional: cek kepemilikan data
        if ($pembayaran->user_id !== auth()->id()) {
            abort(403);
        }

        return view('tagihan.resi', [
            'pembayaran' => $pembayaran,
            'tagihan' => $pembayaran->tagihan,
        ]);
    }

}
