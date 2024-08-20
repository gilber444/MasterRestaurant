<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncotermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incoterm = [
            ['codigo' => '01', 'valor' => 'EXW-En fabrica', 'status' => 'Desactivado'],
            ['codigo' => '02', 'valor' => 'FCA-Libre transportista', 'status' => 'Desactivado'],
            ['codigo' => '03', 'valor' => 'CPT-Transporte pagado hasta', 'status' => 'Desactivado'],
            ['codigo' => '04', 'valor' => 'CIP-Transporte y seguro pagado hasta', 'status' => 'Desactivado'],
            ['codigo' => '05', 'valor' => 'DAP-Entrega en el lugar', 'status' => 'Desactivado'],
            ['codigo' => '06', 'valor' => 'DPU-Entregado en el lugar descargado', 'status' => 'Desactivado'],
            ['codigo' => '07', 'valor' => 'DDP-Entrega con impuestos pagados', 'status' => 'Desactivado'],
            ['codigo' => '08', 'valor' => 'FAS-Libre al costado del buque', 'status' => 'Desactivado'],
            ['codigo' => '09', 'valor' => 'FOB-Libre a bordo', 'status' => 'Desactivado'],
            ['codigo' => '10', 'valor' => 'CFR-Costo y flete', 'status' => 'Desactivado'],
            ['codigo' => '11', 'valor' => 'CIF- Costo seguro y flete', 'status' => 'Desactivado'],
            ['codigo' => '12', 'valor' => 'DAT-Entregado en terminal', 'status' => 'Desactivado'],
            ['codigo' => '13', 'valor' => 'DAF-Entregada en frontera', 'status' => 'Desactivado'],
            ['codigo' => '14', 'valor' => 'DES-Entregada sobre duque', 'status' => 'Desactivado'],
            ['codigo' => '15', 'valor' => 'DEQ-Entregada en muelle', 'status' => 'Desactivado'],
            ['codigo' => '16', 'valor' => 'DDU- Entregada derechos no pagados', 'status' => 'Desactivado'],
        ];  

        DB::table('incoterms')->insert($incoterm);
    }
}
