<?php

namespace App\Http\Controllers;

use App\Events\UserActivityLogged;
use App\Models\kamar;
use App\Models\tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenghuniController extends Controller
{
    public function index(){
        if(Auth::user()->role == 'admin'){
            $penghunis = User::where('role', 'user')->paginate(10);
            return view('admin.penghuni.index', compact('penghunis'));
        }
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function create(){
        $kamars = kamar::where('status_kamar', 'tersedia')->get();
        return view('admin.penghuni.create', compact('kamars'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'no_hp' => 'required',
            'kamar_id' => 'required',
        ]);
        $penghuni = new User();
        $penghuni->name = $request->name;
        $penghuni->email = $request->email;
        $penghuni->password = bcrypt($request->password);
        $penghuni->kamar_id = $request->kamar_id;
        $penghuni->save();

        $kamar = Kamar::where('id', $request->kamar_id)->first();
        $kamar->status_kamar = 'penuh';
        $kamar->save();

        // Log the user activity
        event(new UserActivityLogged(
            Auth::id(),
            'Admin menambahkan penghuni dengan nama ' . $penghuni->name . ' di kamar ' . $kamar->nomor_kamar,
            $request->ip()
        ));

        return redirect()->route('penghuni.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id){
        $penghuni = User::findOrFail($id);
        $kamars = kamar::where('status_kamar', 'tersedia')->orWhere('id', $penghuni->kamar_id)->get();
        return view('admin.penghuni.edit', compact('penghuni', 'kamars'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'kamar_id' => 'required',
        ]);

        $penghuni = User::findOrFail($id);
        $penghuni->name = $request->name;
        $penghuni->email = $request->email;
        if ($request->filled('password')) {
            $penghuni->password = bcrypt($request->password);
        }
        $penghuni->kamar_id = $request->kamar_id;
        $penghuni->save();
        
        $kamar = Kamar::where('id', $request->kamar_id)->first();
        $kamar->status_kamar = 'penuh';
        $kamar->save();

        // Log the user activity
        event(new UserActivityLogged(
            Auth::id(),
            'Admin memperbarui data penghuni dengan nama ' . $penghuni->name . ' di kamar ' . $kamar->nomor_kamar,
            $request->ip()
        ));

        return redirect()->route('penghuni.index')->with('success', 'Data Berhasil Diperbarui');
    }
    public function destroy($id){
        $penghuni = User::findOrFail($id);
        $kamar = Kamar::where('id', $penghuni->kamar_id)->first();
        if($kamar){
            $kamar->status_kamar = 'tersedia';
            $kamar->save();
        }

        $tagihans = tagihan::where('user_id', $penghuni->id)->get();
        foreach ($tagihans as $tagihan) {
            $tagihan->delete();
        }
        
        // Log the user activity
        event(new UserActivityLogged(
            Auth::id(),
            'Admin menghapus penghuni dengan nama ' . $penghuni->name . ' dari kamar ' . $kamar->nomor_kamar,
            request()->ip()
        ));

        $penghuni->delete();
        
        return redirect()->route('penghuni.index')->with('success', 'Data Berhasil Dihapus');
    }
}

