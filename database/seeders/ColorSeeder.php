<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colors')->insert([
            ['name' => 'Trang', 'code' => '#FFFFFF'],
            ['name' => 'Xanh', 'code' => '#2b9e23'],
            ['name' => 'Do', 'code' => '#9e4723'],
            ['name' => 'Tim', 'code' => '#9e238b'],
        ]);
    }
}
