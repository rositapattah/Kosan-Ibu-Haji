<?php

namespace App\Http\Controllers;

use App\Events\UserActivityLogged;
use App\Models\kamar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role == 'admin') {
            $tersedia = Kamar::where('status_kamar', 'tersedia')->count();
            $penuh = Kamar::where('status_kamar', 'penuh')->count();
            $total = Kamar::count();
            $kamars = Kamar::paginate(10);
            return view('admin.kamar.index', compact('kamars', 'tersedia', 'penuh', 'total'));
        }
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(auth()->user()->role == 'admin') {
            return view('admin.kamar.create');
        }
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_kamar' => 'string|max:12|required',
            'status_kamar' => 'required|in:tersedia,penuh'
        ]);

        Kamar::create($data);

        event(new UserActivityLogged(
            Auth::id(),
            'Admin menambahkan kamar dengan nomor ' . $data['nomor_kamar'] . ' dan status ' . $data['status_kamar'],
            $request->ip()
        ));


        return redirect()->route('kamar.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(kamar $kamar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kamar $kamar)
    {
        if(auth()->user()->role == 'admin') {
            return view('admin.kamar.edit', compact('kamar'));
        }
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, kamar $kamar)
    {
        $data = $request->validate([
            'nomor_kamar' => 'string|max:12|required',
            'status_kamar' => 'required|in:tersedia,penuh'
        ]);

        $kamar->update($data);
        if($kamar->status_kamar == 'tersedia') {
            $user = User::where('kamar_id', $kamar->id)->first();
            $user->delete();
        }

        event(new UserActivityLogged(
            Auth::id(),
            'Admin memperbarui kamar dengan nomor ' . $data['nomor_kamar'] . ' dan status ' . $data['status_kamar'],
            $request->ip()
        ));

        return redirect()->route('kamar.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kamar $kamar)
    {
        

        // Log the user activity
        event(new UserActivityLogged(
            Auth::id(),
            'Admin menghapus kamar dengan nomor ' . $kamar->nomor_kamar,
            request()->ip()
        ));

        $kamar->delete();

        return redirect()->route('kamar.index')->with('success', 'Data Berhasil Dihapus');
    }
}
