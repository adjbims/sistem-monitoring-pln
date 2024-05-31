<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $widget = [];

        if (Auth::user()->role == 'admin') {
            $widget = $this->getAdminWidgetData($request);
        } elseif (Auth::user()->role == 'pegawai') {
            $widget = $this->getEmployeeWidgetData();
        }
        // return response()->json($widget);

        return view('menu.home.index-home', compact('widget'));
    }

    private function getAdminWidgetData(Request $request)
    {
        $users = User::count();
        $transaksi_total = Transaksi::count();
        $transaksi = Transaksi::orderBy('created_at', 'desc')->take(10)->get();

        // Mengambil data transaksi per bulan berdasarkan tanggal transaksi
        $transaksi_perbulan = Transaksi::select(
            DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as month_year"),
            DB::raw('count(*) as count')
        )
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy('month_year')
            ->orderByRaw('min(tanggal) desc')
            ->get();

        // Mengambil data transaksi per minggu
        $transaksi_perminggu = Transaksi::select(
            DB::raw('YEARWEEK(tanggal) as week_year'),
            DB::raw('count(*) as count')
        )
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy('week_year')
            ->orderByRaw('min(tanggal) desc')
            ->get();

        // Menghitung rata-rata transaksi per minggu
        $transaksi_perweek_avg = $transaksi_perminggu->avg('count');

        // Mengambil total transaksi bulan ini
        $transaksi_total_month = Transaksi::whereMonth('tanggal', Carbon::now()->month)->count();

        // Mengambil top 5 user berdasarkan jumlah transaksi
        $top_users = User::withCount('transaksi')
            ->orderBy('transaksi_count', 'desc')
            ->take(5)
            ->get();

        return [
            'users' => $users,
            'transaksi' => $transaksi,
            'transaksi_total' => $transaksi_total,
            'transaksi_perbulan' => $transaksi_perbulan,
            'transaksi_perminggu' => $transaksi_perminggu,
            'transaksi_perweek_avg' => $transaksi_perweek_avg,
            'transaksi_total_month' => $transaksi_total_month,
            'top_users' => $top_users,
        ];
    }


    private function getEmployeeWidgetData()
    {
        $userId = Auth::id();
        $transaksi = Transaksi::where('user_id', $userId)->latest()->take(10)->get();
        $transaksi_total = Transaksi::where('user_id', $userId)->count();

        // Mengambil data transaksi per bulan berdasarkan tanggal transaksi
        $transaksi_perbulan = Transaksi::select(
            DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as month_year"),
            DB::raw('count(*) as count')
        )
            ->where('user_id', $userId) // Filter berdasarkan user ID
            ->groupBy('month_year')
            ->orderByRaw('min(tanggal) desc')
            ->get();

        $historicalData = $this->generateHistoricalData();

        $pegawai = Pegawai::where('user_id', $userId)->first();

        if ($pegawai) {
            $pegawai_task_total = (float)$pegawai->total_transaksi;
            $pegawai_task_min = (float)$pegawai->min_transaksi;
            $pegawai_task_percentage = (int)min(($pegawai_task_total / $pegawai_task_min) * 100, 100);
        } else {
            $pegawai_task_total = $pegawai_task_min = $pegawai_task_percentage = 0;
        }

        return [
            'transaksi' => $transaksi,
            'transaksi_total' => $transaksi_total,
            'transaksi_perbulan' => $transaksi_perbulan, // Tambahkan ini
            'transaksi_total_month' => null,
            'historical_data' => $historicalData,
            'pegawai_task_percentage' => $pegawai_task_percentage,
        ];
    }


    private function generateHistoricalData()
    {
        $historicalData = [];
        for ($i = 5; $i >= 0; $i--) {
            $historicalData[] = [
                'month_year' => Carbon::now()->subMonths($i)->format('F Y'),
                'count' => rand(100, 1000)
            ];
        }
        return $historicalData;
    }

    public function searchTransactions(Request $request)
    {
        // Ambil bulan yang dikirim dari permintaan
        $clickedMonth = $request->input('month');
        // Ubah format bulan menjadi sesuai dengan format database jika diperlukan
        // Contoh: $formattedMonth = Carbon::createFromFormat('F Y', $clickedMonth)->format('Y-m');

        // Query data transaksi berdasarkan bulan yang diklik
        $transaksi_perbulan = Transaksi::select(
            DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as month_year"),
            DB::raw('count(*) as count')
        )
            ->whereMonth('tanggal', '=', Carbon::createFromFormat('F Y', $clickedMonth)->month)
            ->whereYear('tanggal', '=', Carbon::createFromFormat('F Y', $clickedMonth)->year)
            ->groupBy('month_year')
            ->orderByRaw('min(tanggal) desc')
            ->get();

        // Kirim data kembali ke klien
        return response()->json($transaksi_perbulan);
    }
}
