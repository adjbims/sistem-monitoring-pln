<?php

namespace App\Console\Commands;

use App\Mail\TransaksiMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class KirimNotifikasiTransaksi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:kirim-notifikasi-transaksi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->info('Mulai mengirim notifikasi...');

        $users = User::where('role', '!=', 'admin')->with('pegawai')->get();
        $this->info($users->count());

        foreach ($users as $user) {
            // $this->info('masuk foreach...');


            $pegawai = $user->pegawai;

            if ($pegawai && $pegawai->total_transaksi < $pegawai->min_transaksi) {
                $now = Carbon::now();
                $formattedDate = $now->format('d F Y');

                $data = [
                    'message' => 'Total transaksi Anda kurang dari minimum transaksi yang ditentukan cron job. Total transaksi Anda: ' . $pegawai->total_transaksi . ' Minimum transaksi: ' . $pegawai->min_transaksi,
                    'date' => $formattedDate,
                    'count' => 1,
                    'name' => $user->getFullNameAttribute()
                ];

                Mail::to($user->email)->send(new TransaksiMail($data));
                $this->info('Notifikasi berhasil dikirim ke ' . $user->email);
            } else {
                $this->info('Pegawai tidak memenuhi syarat atau tidak memiliki data pegawai: ' . $user->name);
            }
        }
    }
}
