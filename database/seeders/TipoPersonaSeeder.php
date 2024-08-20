<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $persona = [
            ['codigo' => '1', 'valor' => 'Persona Natural', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Persona Jurídica', 'status' => 'Desactivado'],            
        ];  

        DB::table('tipo_personas')->insert($persona);
    }
}
