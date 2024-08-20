<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentificacionReceptorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $receptor = [
            ['codigo' => '36', 'valor' => 'NIT', 'status' => 'Desactivado'],
            ['codigo' => '13', 'valor' => 'DUI', 'status' => 'Desactivado'],
            ['codigo' => '37', 'valor' => 'Otro', 'status' => 'Desactivado'],
            ['codigo' => '03', 'valor' => 'Pasaporte', 'status' => 'Desactivado'],
            ['codigo' => '02', 'valor' => 'Carnet de Residencia', 'status' => 'Desactivado'],
            
        ];  

        DB::table('identificacion_receptors')->insert($receptor);
    }
}
