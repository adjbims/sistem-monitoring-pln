<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(env("MAIL_ENCRYPTION"));
        $widget = [];

        if (Auth::user()->role == 'admin') {
            $users = User::count();
            $tansaksi_total = Transaksi::count();
            $tansaksi = Transaksi::orderBy('created_at', 'desc')->take(10)->get();
            $transaksi_perbulan = Transaksi::select(
                DB::raw('count(id) as `count`'), // Counting the number of transactions per month
                DB::raw("DATE_FORMAT(created_at, '%M %Y') as month_year") // Updated format here

            )
                ->groupBy('month_year')
                ->orderBy('month_year', 'asc')
                ->get();

            $widget = [
                'users' => $users,
                'transaksi' => $tansaksi,
                'transaksi_total' => $tansaksi_total,
                'transaksi_perbulan' => $transaksi_perbulan
            ];
        } else if (Auth::user()->role == 'pegawai') {
            $transaksi = Transaksi::where('user_id', Auth::id())->orderBy('created_at', 'desc')->take(10)->get();
            $transaksi_total = Transaksi::where('user_id', Auth::id())->count();
            $transaksi_perbulan = Transaksi::select(
                DB::raw('count(id) as `count`'), // Counting the number of transactions per month
                DB::raw("DATE_FORMAT(created_at, '%M %Y') as month_year") // Updated format here

            )
                ->where('user_id', Auth::id())
                ->groupBy('month_year')
                ->orderBy('month_year', 'asc')
                ->get();
            $pegawai = Pegawai::where('user_id', Auth::id())->first();

            $pegawai_task_total = (float) $pegawai->total_transaksi;
            $pegawai_task_min = (float) $pegawai->min_transaksi;

            $pegawai_task_percentage = (int) min(($pegawai_task_total / $pegawai_task_min) * 100, 100);

            $widget = [
                'transaksi' => $transaksi,
                'transaksi_total' => $transaksi_total,
                'transaksi_perbulan' => $transaksi_perbulan,
                'pegawai_task_percentage' => $pegawai_task_percentage,
            ];
        }

        return view('menu.home.index-home', compact('widget'));
    }
}