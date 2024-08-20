<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['codigo' => '1', 'valor' => 'Bienes', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Servicios', 'status' => 'Desactivado'],
            ['codigo' => '3', 'valor' => 'Ambos (Bienes y Servicios, incluye los dosinherentes a los Productos o servicios)', 'status' => 'Desactivado'],
            ['codigo' => '4', 'valor' => 'Otros tributos por item', 'status' => 'Desactivado'],
        ];  

        DB::table('tipo_items')->insert($items);    }
}
