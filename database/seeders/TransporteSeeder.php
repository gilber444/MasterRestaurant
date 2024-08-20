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
            ['codigo' => '1', 'valor' => 'Terrestre', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Marítimo', 'status' => 'Desactivado'],
            ['codigo' => '3', 'valor' => 'Aéreo', 'status' => 'Desactivado'],
            ['codigo' => '4', 'valor' => 'Multimodal, Terrestre-marítimo', 'status' => 'Desactivado'],
            ['codigo' => '6', 'valor' => 'Multimodal, Terrestre-aéreo', 'status' => 'Desactivado'],
            ['codigo' => '7', 'valor' => 'Multimodal, Marítimo-aéreo', 'status' => 'Desactivado'],
            ['codigo' => '8', 'valor' => 'Multimodal, Terrestre-Marítimo-aéreo', 'status' => 'Desactivado'],
            
        ];  

        DB::table('transportes')->insert($transporte);
    }
}
