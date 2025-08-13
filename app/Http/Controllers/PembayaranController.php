<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role === "admin"){
            $berhasil = Pembayaran::where('status', 'sudah bayar')->count();
            $belum = Pembayaran::where('status', 'belum bayar')->count();
            $total = Pembayaran::all()->count();
            $pembayaran = Pembayaran::all();
            return view('admin.pembayaran.index', compact('pembayaran','berhasil','belum','total'));
        }
        abort(404);
    }
}
