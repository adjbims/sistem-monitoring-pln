<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pegawai::where('tipe', 'tad')->get();
        return view('menu.tad.index-tad', compact('data'));
    }

    public function create()
    {
        return view('menu.tad.index-tad-create');
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
            'role' => 'tad',
        ]);

        Pegawai::create([
            'user_id' => $user->id,
            'nip' => null,
            'tipe' => 'tad',
            'min_transaksi' => $request->min_transaksi,
        ]);

        return redirect()->route('kelola-tad.index')->withSuccess('Tad created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelola_pegawai = Pegawai::find($id);
        return view('menu.tad.index-tad-show', compact('kelola_pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelola_pegawai = Pegawai::find($id);
        return view('menu.tad.index-tad-edit', compact('kelola_pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $kelola_tad)
    {
        $kelola_tad->user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password ? $request->password : $kelola_tad->user->password,
        ]);

        $kelola_tad->update([
            'nip' => null,
            'tipe' => 'tad',
            'min_transaksi' => $request->min_transaksi,
        ]);

        return redirect()->route('kelola-tad.index')->withSuccess('Tad updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $kelola_tad)
    {
        $kelola_tad->delete();
        return redirect()->route('kelola-tad.index')->withSuccess('Tad deleted successfully.');
    }
}
