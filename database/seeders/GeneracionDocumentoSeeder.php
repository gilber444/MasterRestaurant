<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneracionDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generacion = [
            ['codigo' => '1', 'valor' => 'Físico', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'Electrónico', 'status' => 'Desactivado'],
        ];  

        DB::table('generacion_documentos')->insert($generacion);
    }
}
