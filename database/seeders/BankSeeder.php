<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks')->insert([
            [
                'name' => 'Bank Central Asia',
                'code' => 1123,
                'description' => 'BCA adalah bank swasta terbesar di Indonesia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Rakyat Indonesia',
                'code' => 1124,
                'description' => 'BRI adalah bank milik pemerintah yang fokus pada UMKM.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Mandiri',
                'code' => 1126,
                'description' => 'Bank Mandiri adalah salah satu bank BUMN terbesar di Indonesia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Negara Indonesia',
                'code' => 1125,
                'description' => 'BNI adalah salah satu bank pemerintah tertua di Indonesia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
