<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServicioMedicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicio = [
            ['codigo' => '1', 'valor' => 'Cirugía', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Operación', 'status' => 'Desactivado'],
            ['codigo' => '3', 'valor' => 'Tratamiento médico', 'status' => 'Desactivado'],
            ['codigo' => '4', 'valor' => 'Cirugía instituto salvadoreño de Bienestar Magisterial', 'status' => 'Desactivado'],
            ['codigo' => '5', 'valor' => 'Operación Instituto Salvadoreño de Bienestar Magisterial', 'status' => 'Desactivado'],
            ['codigo' => '6', 'valor' => 'Tratamiento médico Instituto Salvadoreño de Bienestar Magisterial', 'status' => 'Desactivado'],
        ];  

        DB::table('tipo_servicio_medicos')->insert($servicio);
    }
}
