<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DomicilioFiscalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domicilio = [
            ['codigo' => '1', 'valor' => 'Domiciliado', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'No Domiciliado', 'status' => 'Desactivado'],            
        ];  

        DB::table('domicilio_fiscals')->insert($domicilio);
    }
}
