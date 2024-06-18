<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user_dev = \App\Models\User::factory()->create([
            'name' => 'bimo',
            'last_name' => 'adji',
            'email' => 'sbima2206@gmail.com',
            'password' => 'sbima2206',
            'role' => 'pegawai',
        ]);

        \App\Models\Pegawai::factory()->create([
            'user_id' => $user_dev->id,
            'nip' => '0987654321',
            'total_transaksi' => 3,
        ]);

        $user_pegawai = \App\Models\User::factory()->create([
            'name' => 'Pegawai',
            'last_name' => 'Satu',
            'email' => 'pegawai@pegawai.com',
            'password' => 'pegawai11',
            'role' => 'pegawai',
        ]);

        // create pegawai
        \App\Models\Pegawai::factory()->create([
            'user_id' => $user_pegawai->id,
            'nip' => '1234567890',
            'total_transaksi' => 3,
        ]);

        // user pegawai tad
        $user_pegawai_tad = \App\Models\User::factory()->create([
            'name' => 'Pegawai',
            'last_name' => 'Dua',
            'email' => 'pegawaitad1@pegawaitad1.com',
            'password' => 'pegawaitad11',
        ]);

        // create pegawai tad
        \App\Models\Pegawai::factory()->create([
            'user_id' => $user_pegawai_tad->id,
            'nip' => '1234567891',
            'tipe' => 'tad',
        ]);


        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'last_name' => 'Satu',
            'email' => 'admin@admin.com',
            'password' => 'admin11',
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'last_name' => 'Satu',
            'email' => 'admin2@admin.com',
            'password' => 'admin22',
            'role' => 'admin',
        ]);

        // call
        $this->call(TransaksiSeeder::class);
    }
}