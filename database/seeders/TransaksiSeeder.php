<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define the data to be inserted
        $transaksis = [
            [
                'user_id' => 1,
                'bukti_transfer' => 'example_transfer_proof.jpg',
                'tanggal' => now(), // Assuming current date
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'bukti_transfer' => 'example_transfer_proof.jpg',
                'tanggal' => now(), // Assuming current date
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'bukti_transfer' => 'example_transfer_proof.jpg',
                'tanggal' => now(), // Assuming current date
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert the data into the transaksis table
        DB::table('transaksis')->insert($transaksis);
    }
}
