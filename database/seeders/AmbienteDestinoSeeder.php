<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmbienteDestinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ambiente = [
            ['codigo' => '00', 'valor' => 'Modo prueba', 'status' => 'Desactivado'],
            ['codigo' => '01', 'valor' => 'Modo producción', 'status' => 'Desactivado'],
        ];

        DB::table('ambiente_destinos')->insert($ambiente);
    }
}
