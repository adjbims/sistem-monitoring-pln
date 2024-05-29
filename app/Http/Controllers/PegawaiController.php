<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $data = Pegawai::where('tipe', 'pegawai')->get();
        return view('menu.pegawai.index-pegawai', compact('data'));
    }

    public function create()
    {
        return view('menu.pegawai.index-pegawai-create');
    }

    public function store(StorePegawaiRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'pegawai',
        ]);

        Pegawai::create([
            'user_id' => $user->id,
            'nip' => $request->tipe == 'tad' ? null : $request->nip,
            'tipe' => $request->tipe,
            'min_transaksi' => $request->min_transaksi,
        ]);

        return redirect()->route('kelola-pegawai.index')->withSuccess('Pegawai created successfully.');
    }

    public function show(Pegawai $kelola_pegawai)
    {
        return view('menu.pegawai.index-pegawai-show', compact('kelola_pegawai'));
    }

    public function edit(Pegawai $kelola_pegawai)
    {
        return view('menu.pegawai.index-pegawai-edit', compact('kelola_pegawai'));
    }

    public function update(UpdatePegawaiRequest $request, Pegawai $kelola_pegawai)
    {
        $kelola_pegawai->user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password ? $request->password : $kelola_pegawai->user->password,
        ]);

        $kelola_pegawai->update([
            'nip' => $request->tipe == 'tad' ? null : $request->nip,
            'tipe' => $request->tipe,
            'min_transaksi' => $request->min_transaksi,
        ]);

        return redirect()->route('kelola-pegawai.index')->withSuccess('Pegawai updated successfully.');
    }

    public function destroy(Pegawai $kelola_pegawai)
    {
        $kelola_pegawai->delete();
        return redirect()->route('kelola-pegawai.index')->withSuccess('Pegawai deleted successfully.');
    }
}
