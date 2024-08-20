<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RetencionIvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $retencion = [
            ['codigo' => '22', 'valor' => 'Retención IVA 1%', 'status' => 'Desactivado'],
            ['codigo' => 'C4', 'valor' => 'Retención IVA 13%', 'status' => 'Desactivado'],
            ['codigo' => 'C9', 'valor' => 'Otras retenciones IVA casos especiales', 'status' => 'Desactivado'],
            
        ];  

        DB::table('retencion_ivas')->insert($retencion);
    }
}
