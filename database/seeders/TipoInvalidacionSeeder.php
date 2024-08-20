<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoInvalidacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invalidacion = [
            ['codigo' => '1', 'valor' => 'Error en la Información del Documento Tributario Electrónico a invalidar', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Rescindir de la operación realizada', 'status' => 'Desactivado'],
            ['codigo' => '3', 'valor' => 'Otro', 'status' => 'Desactivado'],
            
        ];  

        DB::table('tipo_invalidacions')->insert($invalidacion);
    }
}
