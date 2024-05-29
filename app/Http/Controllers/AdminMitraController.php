<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class AdminMitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pegawai::where('tipe', 'mitra')->get();
        return view('menu.mitra.index-mitra', compact('data'));
    }

    public function create()
    {
        return view('menu.mitra.index-mitra-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'mitra',
        ]);

        Pegawai::create([
            'user_id' => $user->id,
            'nip' => null,
            'tipe' => 'mitra',
            'min_transaksi' => $request->min_transaksi,
        ]);

        return redirect()->route('kelola-mitra.index')->withSuccess('mitra created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelola_pegawai = Pegawai::find($id);
        return view('menu.mitra.index-mitra-show', compact('kelola_pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelola_pegawai = Pegawai::find($id);
        return view('menu.mitra.index-mitra-edit', compact('kelola_pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $kelola_mitra)
    {
        $kelola_mitra->user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password ? $request->password : $kelola_mitra->user->password,
        ]);

        $kelola_mitra->update([
            'nip' => null,
            'tipe' => 'mitra',
            'min_transaksi' => $request->min_transaksi,
        ]);

        return redirect()->route('kelola-tad.index')->withSuccess('Tad updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
