<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemisionBienesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $remision = [
            ['codigo' => '01', 'valor' => 'Depósito', 'status' => 'Desactivado'],
            ['codigo' => '02', 'valor' => 'Propiedad', 'status' => 'Desactivado'],
            ['codigo' => '03', 'valor' => 'Consignación', 'status' => 'Desactivado'],
            ['codigo' => '04', 'valor' => 'Traslado', 'status' => 'Desactivado'],
            ['codigo' => '05', 'valor' => 'Otros', 'status' => 'Desactivado'],
            
        ];  

        DB::table('remision_bienes')->insert($remision);
    }
}
