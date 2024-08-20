<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoContingenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contingencia = [
            ['codigo' => '1', 'valor' => 'No disponibilidad de sistema MH', 'status' => 'Desactivado'],
            ['codigo' => '2', 'valor' => 'No disponibilidad de sistema del emisor', 'status' => 'Desactivado'],
            ['codigo' => '3', 'valor' => 'Falla en el suministro de servicio de Internet del Emisor', 'status' => 'Desactivado'],
            ['codigo' => '4', 'valor' => 'Falla en el suministro de servicio de energía eléctrica del emisor que impida la transmisión de los DTE', 'status' => 'Desactivado'],
            ['codigo' => '5', 'valor' => 'Otro (deberá digitar un máximo de 500 caracteres explicando el motivo)', 'status' => 'Desactivado'],
        ];  

        DB::table('tipo_contingencias')->insert($contingencia);
    }
}
