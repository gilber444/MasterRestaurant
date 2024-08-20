<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTransmisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipo = [
            ['codigo' => '1', 'valor' => 'Transmisión normal', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Transmisión por contingencia', 'status' => 'Desactivado'],

        ];  

        DB::table('tipo_transmisions')->insert($tipo);
    }
}
