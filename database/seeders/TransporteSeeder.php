<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transporte = [
            ['codigo' => '1', 'valor' => 'TERRESTRE', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'AEREO', 'status' => 'Desactivado'],
            ['codigo' => '3', 'valor' => 'MARITIMO', 'status' => 'Desactivado'],
            ['codigo' => '4', 'valor' => 'FERREO', 'status' => 'Desactivado'],
            ['codigo' => '5', 'valor' => 'MULTIMODAL', 'status' => 'Desactivado'],
            ['codigo' => '6', 'valor' => 'CORREO', 'status' => 'Desactivado'],            
        ];  

        DB::table('transportes')->insert($transporte);
    }
}
