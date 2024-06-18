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

        return view('menu.home.index-home', compact('widget'));
    }

    private function getAdminWidgetData(Request $request)
    {
        $users = User::count();
        $transaksi_total = Transaksi::count();
        $transaksi = Transaksi::orderBy('created_at', 'desc')->take(10)->get();
        $transaksi_perbulan = $this->getMonthlyTransactions();
        $transaksi_perminggu = $this->getWeeklyTransactions();
        $transaksi_perweek_avg = $transaksi_perminggu->avg('count');
        $transaksi_total_month = Transaksi::whereMonth('tanggal', Carbon::now()->month)->count();
        $top_users = User::withCount('transaksi')
            ->orderBy('transaksi_count', 'desc')
            ->take(5)
            ->get();

        // Pastikan kunci 'users' ada dalam larik $widget
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
        $transaksi_perbulan = $this->getMonthlyTransactions();
        $transaksi_perminggu = $this->getWeeklyTransactions();
        $transaksi_perweek_avg = $transaksi_perminggu->avg('count');
        $historicalData = $this->generateHistoricalData();
        $pegawai = Pegawai::where('user_id', $userId)->first();
    
        if ($pegawai) {
            $pegawai_task_total = (float)$pegawai->total_transaksi;
            $pegawai_task_min = (float)$pegawai->min_transaksi;
            $pegawai_task_percentage = (int)min(($pegawai_task_total / $pegawai_task_min) * 100, 100);
        } else {
            $pegawai_task_total = $pegawai_task_min = $pegawai_task_percentage = 0;
        }
    
        // Pastikan variabel $transaksi_total_month selalu terdefinisi, meskipun tidak relevan untuk pengguna pegawai
        $transaksi_total_month = null;
    
        return [
            'transaksi' => $transaksi,
            'transaksi_total' => $transaksi_total,
            'transaksi_perbulan' => $transaksi_perbulan,
            'transaksi_perminggu' => $transaksi_perminggu,
            'transaksi_perweek_avg' => $transaksi_perweek_avg,
            'transaksi_total_month' => $transaksi_total_month,
            'pegawai_task_percentage' => $pegawai_task_percentage,
        ];
    }    

    private function getMonthlyTransactions()
    {
        // Check the user role
        if (Auth::user()->role == 'admin') {
            // For admin, retrieve all monthly transactions
            return Transaksi::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as month_year"),
                DB::raw('count(*) as count')
            )
                ->groupBy('month_year')
                ->orderByRaw('min(tanggal) desc')
                ->get();
        } elseif (Auth::user()->role == 'pegawai') {
            // For user, retrieve only their monthly transactions
            $userId = Auth::id();
            return Transaksi::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as month_year"),
                DB::raw('count(*) as count')
            )
                ->where('user_id', $userId)
                ->groupBy('month_year')
                ->orderByRaw('min(tanggal) desc')
                ->get();
        }
    }    

    private function getWeeklyTransactions()
    {
        return Transaksi::select(
            DB::raw('YEARWEEK(tanggal) as week_year'),
            DB::raw('count(*) as count')
        )
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy('week_year')
            ->orderByRaw('min(tanggal) desc')
            ->get();
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
    
        public function searchTransactionsByMonth(Request $request)
        {
            // Ambil bulan yang dikirim dari permintaan
            $clickedMonth = $request->input('month');
            // Ubah format bulan menjadi sesuai
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