<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\Pegawai;
use App\Models\Transaksi;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Transaksi::all()->sortByDesc('created_at');
        return view('menu.transaksi.index-transaksi', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.transaksi.index-transaksi-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request)
    {
        // Store bukti_transfer with a unique name
        $bukti_transfer = $request->file('bukti_transfer');
        $bukti_transfer_name = Str::random(20) . '.' . $bukti_transfer->extension();
        $bukti_transfer->storeAs('public/bukti_transfer', $bukti_transfer_name);

        // Create transaksi
        $transaksi = new Transaksi();
        $transaksi->user_id = auth()->id();
        $transaksi->bukti_transfer = $bukti_transfer_name;
        $transaksi->tanggal = $request->tanggal;
        $transaksi->save();

        // iccrease total transaksi
        $pegawai = Pegawai::where('user_id', auth()->id())->first();
        $pegawai->total_transaksi += 1;
        $pegawai->save();

        return redirect()->route('upload-transaksi.create')->withSuccess('Transaksi created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $data_transaksi)
    {
        return view('menu.transaksi.index-transaksi-show', compact('data_transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $data_transaksi)
    {
        return view('menu.transaksi.index-transaksi-edit', compact('data_transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $data_transaksi)
    {
        if ($request->hasFile('bukti_transfer')) {
            $old_bukti_transfer = $data_transaksi->bukti_transfer;
            if ($old_bukti_transfer) {
                unlink(storage_path('app/public/bukti_transfer/' . $old_bukti_transfer));
            }

            // Store new bukti_transfer with a unique name
            $bukti_transfer = $request->file('bukti_transfer');
            $bukti_transfer_name = Str::random(20) . '.' . $bukti_transfer->extension();
            $bukti_transfer->storeAs('public/bukti_transfer', $bukti_transfer_name);

            $data_transaksi->bukti_transfer = $bukti_transfer_name;
        }

        $data_transaksi->tanggal = $request->tanggal;
        $data_transaksi->save();

        return redirect()->route('data-transaksi.index')->withSuccess('Transaksi updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $data_transaksi)
    {
        $bukti_transfer = $data_transaksi->bukti_transfer;
        if (
            $bukti_transfer
            && file_exists(storage_path('app/public/bukti_transfer/' . $bukti_transfer))
        ) {
            unlink(storage_path('app/public/bukti_transfer/' . $bukti_transfer));
        }

        $data_transaksi->delete();

        // get pegawai and decrease total transaksi
        $pegawai = Pegawai::where('user_id', $data_transaksi->user_id)->first();
        $pegawai->total_transaksi -= 1;
        $pegawai->save();

        return redirect()->route('data-transaksi.index')->withSuccess('Transaksi deleted successfully.');
    }

    public function riwayatIndex()
    {
        $data = Transaksi::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('menu.transaksi.index-transaksi-history-user', compact('data'));
    }
}