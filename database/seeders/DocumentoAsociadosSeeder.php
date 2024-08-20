<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoAsociadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asociados = [
            ['codigo' => '1', 'valor' => 'Emisor', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Receptor', 'status' => 'Desactivado'],
            ['codigo' => '3', 'valor' => 'Médico (solo aplica para contribuyentes obligados a la presentación de F-958)', 'status' => 'Desactivado'],
            ['codigo' => '4', 'Transporte (solo aplica para Factura de exportación)' => '', 'status' => 'Desactivado'],
            
        ];  

        DB::table('documento_asociados')->insert($asociados);
    }
}
