<?php

namespace App\Http\Controllers;

use App\Events\UserActivityLogged;
use App\Models\laporan;
use App\Models\Kamar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role == 'admin') {
            
            $laporan = laporan::all();
            return view('admin.laporan.index', compact('laporan'));
        }else if(auth()->user()->role == 'user') {
            $laporan = Laporan::with('user')
                        ->where('user_id', Auth::user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
            return view('laporan.index', compact('laporan'));
        }
        // Redirect or return an error if the user role is not recognized
        return redirect()->back()->with('error', 'Unauthorized access');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the incoming request data
        $data = $request->validate([
            'media' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:255',
            'tanggal_laporan' => 'required|date',
        ]);

        // Set the user_id to the authneticated user's ID
        $data['user_id'] = auth()->user()->id;

        // Set the media path if a file is uploaded
        if ($request->hasFile('media')) {
            $data['media'] = $request->file('media')->store('laporan_media', 'public');
        }
        
        // Create the laporan record
        laporan::create($data);

        $user = Auth::user();
        // Log the user activity
        event(new UserActivityLogged(
            Auth::id(),
            $user->name . ' membuat laporan pada tanggal ' . $data['tanggal_laporan'],
            $request->ip()
        ));

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(laporan $laporan)
    {
        if(auth()->user()->role == 'admin') {
            return view('admin.laporan.edit', compact('laporan'));
        }
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, laporan $laporan)
    {
        $data = $request->validate([
            'status' => 'required|in:diproses,selesai',
        ]);

        $laporan->update($data);

        // Log the user activity
        event(new UserActivityLogged(
            Auth::id(),
            'Admin memperbarui status laporan dengan ID ' . $laporan->id . ' menjadi ' . $data['status'],
            $request->ip()
        ));

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(laporan $laporan)
    {
        
        $laporan->delete();

        // Optionally, delete the media file if it exists
        if ($laporan->media) {
            Storage::disk('public')->delete($laporan->media);
        }

        // Log the user activity
        event(new UserActivityLogged(
            Auth::id(),
            'Admin menghapus laporan dengan ID ' . $laporan->id,
            request()->ip()
        ));

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus');
    }
}
