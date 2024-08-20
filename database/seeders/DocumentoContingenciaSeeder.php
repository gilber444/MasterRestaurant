<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoContingenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contingencia = [
            ['codigo' => '01', 'valor' => 'Factura Electrónico', 'status' => 'Desactivado'],
            ['codigo' => '03', 'valor' => 'Conprobante de Crédito Fiscal Electrónico', 'status' => 'Desactivado'],
            ['codigo' => '04', 'valor' => 'Nota de Remisión Electrónica', 'status' => 'Desactivado'],
            ['codigo' => '05', 'valor' => 'Nota de Crédito Electrónica', 'status' => 'Desactivado'],
            ['codigo' => '06', 'valor' => 'Nota de Débito Electrónica', 'status' => 'Desactivado'],
            ['codigo' => '11', 'valor' => 'Factura de Exportación Electrónica', 'status' => 'Desactivado'],
            ['codigo' => '14', 'valor' => 'Factura de Sujeto Excluido Electrónica', 'status' => 'Desactivado'],
            
        ];  

        DB::table('documento_contingencias')->insert($contingencia);
    }
}
