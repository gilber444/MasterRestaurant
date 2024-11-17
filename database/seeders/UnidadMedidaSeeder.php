<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medidas = [
            [
                ['codigo' => '13', 'valor' => 'metro cuadrado', 'status' => 'Desactivado'],
                ['codigo' => '15', 'valor' => 'Vara cuadrada', 'status' => 'Desactivado'],
                ['codigo' => '18', 'valor' => 'metro cúbico', 'status' => 'Desactivado'],
                ['codigo' => '20', 'valor' => 'Barril', 'status' => 'Desactivado'],
                ['codigo' => '22', 'valor' => 'Galón', 'status' => 'Desactivado'],
                ['codigo' => '23', 'valor' => 'Litro', 'status' => 'Desactivado'],
                ['codigo' => '24', 'valor' => 'Botella', 'status' => 'Desactivado'],
                ['codigo' => '26', 'valor' => 'Mililitro', 'status' => 'Desactivado'],
                ['codigo' => '30', 'valor' => 'Tonelada', 'status' => 'Desactivado'],
                ['codigo' => '32', 'valor' => 'Quintal', 'status' => 'Desactivado'],
                ['codigo' => '33', 'valor' => 'Arroba', 'status' => 'Desactivado'],
                ['codigo' => '34', 'valor' => 'Kilogramo', 'status' => 'Desactivado'],
                ['codigo' => '36', 'valor' => 'Libra', 'status' => 'Desactivado'],
                ['codigo' => '37', 'valor' => 'Onza troy', 'status' => 'Desactivado'],
                ['codigo' => '38', 'valor' => 'Onza', 'status' => 'Desactivado'],
                ['codigo' => '39', 'valor' => 'Gramo', 'status' => 'Desactivado'],
                ['codigo' => '40', 'valor' => 'Miligramo', 'status' => 'Desactivado'],
                ['codigo' => '42', 'valor' => 'Megawatt', 'status' => 'Desactivado'],
                ['codigo' => '43', 'valor' => 'Kilowatt', 'status' => 'Desactivado'],
                ['codigo' => '44', 'valor' => 'Watt', 'status' => 'Desactivado'],
                ['codigo' => '45', 'valor' => 'Megavoltio-amperio', 'status' => 'Desactivado'],
                ['codigo' => '46', 'valor' => 'Kilovoltio-amperio', 'status' => 'Desactivado'],
                ['codigo' => '47', 'valor' => 'Voltio-amperio', 'status' => 'Desactivado'],
                ['codigo' => '49', 'valor' => 'Gigawatt-hora', 'status' => 'Desactivado'],
                ['codigo' => '50', 'valor' => 'Megawatt-hora', 'status' => 'Desactivado'],
                ['codigo' => '51', 'valor' => 'Kilowatt-hora', 'status' => 'Desactivado'],
                ['codigo' => '52', 'valor' => 'Watt-hora', 'status' => 'Desactivado'],
                ['codigo' => '53', 'valor' => 'Kilovoltio', 'status' => 'Desactivado'],
                ['codigo' => '54', 'valor' => 'Voltio', 'status' => 'Desactivado'],
                ['codigo' => '55', 'valor' => 'Millar', 'status' => 'Desactivado'],
                ['codigo' => '56', 'valor' => 'Medio millar', 'status' => 'Desactivado'],
                ['codigo' => '57', 'valor' => 'Ciento', 'status' => 'Desactivado'],
                ['codigo' => '58', 'valor' => 'Docena', 'status' => 'Desactivado'],
                ['codigo' => '99', 'valor' => 'Otra', 'status' => 'Desactivado'],
            ]            
        ];  

        DB::table('unidad_medidas')->insert($medidas);    }
}