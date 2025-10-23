<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('positions')->insert([
        ['nama_jabatan' => 'Manager', 'gaji_pokok' => 8000000],
        ['nama_jabatan' => 'Staff', 'gaji_pokok' => 5000000],
        ['nama_jabatan' => 'Supervisor', 'gaji_pokok' => 6500000],
        ['nama_jabatan' => 'Intern', 'gaji_pokok' => 3000000],
]);

    }
}
