<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlazoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plazos = [
            ['codigo' => '01', 'valor' => 'Días', 'status' => 'Desactivado'],
            ['codigo' => '02', 'valor' => 'Meses', 'status' => 'Desactivado'],
            ['codigo' => '03', 'valor' => 'Años', 'status' => 'Desactivado'],
            
        ];  

        DB::table('plazos')->insert($plazos);
    }
}
