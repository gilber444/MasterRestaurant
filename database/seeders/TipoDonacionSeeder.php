<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDonacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donacion = [
            ['codigo' => '1', 'valor' => 'Efectivo', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Bien', 'status' => 'Desactivado'],
            ['codigo' => '3', 'valor' => 'Servicio', 'status' => 'Desactivado'],
            
        ];  

        DB::table('tipo_donacions')->insert($donacion);
    }
}
