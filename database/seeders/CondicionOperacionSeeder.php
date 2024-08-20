<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CondicionOperacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $condicion = [
            ['codigo' => '1', 'valor' => 'Contado', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'A crédito', 'status' => 'Desactivado'],
            ['codigo' => '3', 'valor' => 'Otro', 'status' => 'Desactivado'],
        ];

        DB::table('condicion_operacions')->insert($condicion);
    }
}
