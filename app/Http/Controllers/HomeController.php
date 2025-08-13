<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\kamar;
use Illuminate\Http\Request;
use App\Models\tagihan;
use App\Models\laporan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function home()
    {
        return view('index');
        
    }

    public function contact(){
        return view('contact');
    }

    public function dashboard(){

        $userId = auth()->id();

        $totalBelum = Tagihan::where('user_id', $userId)
            ->where('status', 'belum bayar')
            ->sum('jumlah_tagihan');

        $tagihanSummary = [
            'totalBelum' => $totalBelum
        ];

        $laporanCount = Laporan::where('user_id', $userId)->count();

        $tagihanList = Tagihan::where('user_id', $userId)
            ->get();
        
        return view('user.dashboard', compact(
            'tagihanSummary',
            'laporanCount',
            'tagihanList'
        ));
    }

    public function admin(){
        $userId = auth()->id();
        $penghuni = User::where('role', 'user')->count();
        $kamarTersedia = Kamar::where('status_kamar', 'tersedia')->count();
        $pembayaranPending = Tagihan::where('status', 'belum bayar')->count();
        $laporanPending = Laporan::where('status', 'diproses')->count();
        $logs = ActivityLog::latest()->take(3)->with('user')->get();
        return view('admin.dashboard', compact('penghuni', 'kamarTersedia', 'pembayaranPending', 'laporanPending', 'logs'));
    }
}
