<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeloFacturacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modelo = [
            ['codigo' => '1', 'valor' => 'Modelo Facturación previo', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Modelo Facturación diferido', 'status' => 'Desactivado'],
        ];  

        DB::table('modelo_facturacions')->insert($modelo);
    }
}
