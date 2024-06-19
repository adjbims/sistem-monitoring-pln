<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ExcelHistoryPembayaran implements FromView
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $data = Transaksi::all()->sortByDesc('created_at');
        return view('menu.transaksi.excel', [
            'data' => $this->data
        ]);
    }
}
