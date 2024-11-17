<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $pago = [
            ['codigo' => '01', 'valor' => 'Billetes y monedas', 'status' => 'Desactivado'],
            ['codigo' => '02', 'valor' => 'Tarjeta Débito', 'status' => 'Desactivado'],
            ['codigo' => '03', 'valor' => 'Tarjeta Crédito', 'status' => 'Desactivado'],
            ['codigo' => '04', 'valor' => 'Cheque', 'status' => 'Desactivado'],
            ['codigo' => '05', 'valor' => 'Transferencia_ Depósito Bancario', 'status' => 'Desactivado'],
            ['codigo' => '08', 'valor' => 'Dinero electrónico', 'status' => 'Desactivado'],
            ['codigo' => '09', 'valor' => 'Monedero electrónico', 'status' => 'Desactivado'],
            ['codigo' => '11', 'valor' => 'Bitcoin', 'status' => 'Desactivado'],
            ['codigo' => '12', 'valor' => 'Otras Criptomonedas', 'status' => 'Desactivado'],
            ['codigo' => '13', 'valor' => 'Cuentas por pagar del receptor', 'status' => 'Desactivado'],
            ['codigo' => '14', 'valor' => 'Giro bancario', 'status' => 'Desactivado'],
            ['codigo' => '99', 'valor' => 'Otros (se debe indicar el medio de pago)', 'status' => 'Desactivado'],
        ];  

        DB::table('forma_pagos')->insert($pago);
    }
}
