<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\Pegawai;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;

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

    public function export()
    {
        return Excel::download(new TransaksiExport, 'transaksi.xlsx');
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
        $bukti_transfer_name = $this->storeBuktiTransfer($request->file('bukti_transfer'));

        $transaksi = new Transaksi();
        $transaksi->user_id = auth()->id();
        $transaksi->bukti_transfer = $bukti_transfer_name;
        $transaksi->tanggal = $request->tanggal;
        $transaksi->save();

        $this->updatePegawaiTotalTransaksi(auth()->id());

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
            $this->deleteBuktiTransfer($data_transaksi->bukti_transfer);
            $data_transaksi->bukti_transfer = $this->storeBuktiTransfer($request->file('bukti_transfer'));
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
        $this->deleteBuktiTransfer($data_transaksi->bukti_transfer);
        $data_transaksi->delete();

        return redirect()->route('data-transaksi.index')->withSuccess('Transaksi deleted successfully.');
    }

    public function riwayatIndex()
    {
        $data = Transaksi::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('menu.transaksi.index-transaksi-history-user', compact('data'));
    }

    /**
     * Store bukti_transfer file and return its name.
     */
    private function storeBuktiTransfer($bukti_transfer)
    {
        $bukti_transfer_name = Str::random(20) . '.' . $bukti_transfer->extension();
        $bukti_transfer->storeAs('public/bukti_transfer', $bukti_transfer_name);
        return $bukti_transfer_name;
    }

    /**
     * Delete the bukti_transfer file if it exists.
     */
    private function deleteBuktiTransfer($bukti_transfer_name)
    {
        if ($bukti_transfer_name && Storage::exists('public/bukti_transfer/' . $bukti_transfer_name)) {
            Storage::delete('public/bukti_transfer/' . $bukti_transfer_name);
        }
    }

    /**
     * Update the total_transaksi for the given user.
     */
    private function updatePegawaiTotalTransaksi($userId)
    {
        $pegawai = Pegawai::where('user_id', $userId)->first();
        $pegawai->total_transaksi += 1;
        $pegawai->save();
    }
}
