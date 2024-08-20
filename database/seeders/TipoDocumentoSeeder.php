<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documento = [
            ['codigo' => '01', 'valor' => 'Factura', 'status' => 'Desactivado'],
            ['codigo' => '03', 'valor' => 'Comprobante de crédito fiscal', 'status' => 'Desactivado'],
            ['codigo' => '04', 'valor' => 'Nota de remisión', 'status' => 'Desactivado'],
            ['codigo' => '05', 'valor' => 'Nota de crédito', 'status' => 'Desactivado'],
            ['codigo' => '06', 'valor' => 'Nota de débito', 'status' => 'Desactivado'],
            ['codigo' => '07', 'valor' => 'Comprobante de retención', 'status' => 'Desactivado'],
            ['codigo' => '08', 'valor' => 'Comprobante de liquidación', 'status' => 'Desactivado'],
            ['codigo' => '09', 'valor' => 'Documento contable de liquidación', 'status' => 'Desactivado'],
            ['codigo' => '11', 'valor' => 'Facturas de exportación', 'status' => 'Desactivado'],
            ['codigo' => '14', 'valor' => 'Factura de sujeto excluido', 'status' => 'Desactivado'],
            ['codigo' => '15', 'valor' => 'Comprobante de donación', 'status' => 'Desactivado'],

        ];  

        DB::table('tipo_documentos')->insert($documento);
    }
}
