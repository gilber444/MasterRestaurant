<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEstablecimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $establecimiento = [
            ['codigo' => '01', 'valor' => 'Sucursal', 'status' => 'Desactivado'],
            ['codigo' => '02', 'valor' => 'Casa Matriz', 'status' => 'Desactivado'],
            ['codigo' => '04', 'valor' => 'Bodega', 'status' => 'Desactivado'],
            ['codigo' => '07', 'valor' => 'Patio', 'status' => 'Desactivado'],
            ['codigo' => '20', 'valor' => 'Otro', 'status' => 'Desactivado'],
        ];  

        DB::table('tipo_establecimientos')->insert($establecimiento);
    }
}
