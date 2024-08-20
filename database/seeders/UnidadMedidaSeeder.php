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
            ['codigo' => '01', 'valor' => 'Metro', 'status' => 'Desactivado'],
            ['codigo' => '02', 'valor' => 'Yarda', 'status' => 'Desactivado'],
            ['codigo' => '03', 'valor' => 'Vara', 'status' => 'Desactivado'],
            ['codigo' => '04', 'valor' => 'Pie', 'status' => 'Desactivado'],
            ['codigo' => '05', 'valor' => 'Pulgada', 'status' => 'Desactivado'],
            ['codigo' => '06', 'valor' => 'Milímetro', 'status' => 'Desactivado'],
            ['codigo' => '08', 'valor' => 'Milla cuadrada', 'status' => 'Desactivado'],
            ['codigo' => '09', 'valor' => 'Kilómetro cuadrado', 'status' => 'Desactivado'],
            ['codigo' => '10', 'valor' => 'Hectárea', 'status' => 'Desactivado'],
            ['codigo' => '11', 'valor' => 'Manzana', 'status' => 'Desactivado'],
            ['codigo' => '12', 'valor' => 'Acre', 'status' => 'Desactivado'],
            ['codigo' => '13', 'valor' => 'Metro cuadrado', 'status' => 'Desactivado'],
            ['codigo' => '14', 'valor' => 'Yarda cuadrada', 'status' => 'Desactivado'],
            ['codigo' => '15', 'valor' => 'Vara cuadrada', 'status' => 'Desactivado'],
            ['codigo' => '16', 'valor' => 'Pie cuadrado', 'status' => 'Desactivado'],
            ['codigo' => '17', 'valor' => 'Pulgada cuadrada', 'status' => 'Desactivado'],
            ['codigo' => '18', 'valor' => 'Metro cúbico', 'status' => 'Desactivado'],
            ['codigo' => '19', 'valor' => 'Yarda cúbica', 'status' => 'Desactivado'],
            ['codigo' => '20', 'valor' => 'Barril', 'status' => 'Desactivado'],
            ['codigo' => '21', 'valor' => 'Pie cúbico', 'status' => 'Desactivado'],
            ['codigo' => '22', 'valor' => 'Galón', 'status' => 'Desactivado'],
            ['codigo' => '23', 'valor' => 'Litro', 'status' => 'Desactivado'],
            ['codigo' => '24', 'valor' => 'Botella', 'status' => 'Desactivado'],
            ['codigo' => '25', 'valor' => 'Pulgada cúbica', 'status' => 'Desactivado'],
            ['codigo' => '26', 'valor' => 'Mililitro', 'status' => 'Desactivado'],
            ['codigo' => '27', 'valor' => 'Onza fluida', 'status' => 'Desactivado'],
            ['codigo' => '29', 'valor' => 'Tonelada métrica', 'status' => 'Desactivado'],
            ['codigo' => '30', 'valor' => 'Tonelada', 'status' => 'Desactivado'],
            ['codigo' => '31', 'valor' => 'Quintal métrico', 'status' => 'Desactivado'],
            ['codigo' => '32', 'valor' => 'Quintal', 'status' => 'Desactivado'],
            ['codigo' => '33', 'valor' => 'Arroba', 'status' => 'Desactivado'],
            ['codigo' => '34', 'valor' => 'Kilogramo', 'status' => 'Desactivado'],
            ['codigo' => '35', 'valor' => 'Libra troy', 'status' => 'Desactivado'],
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
            ['codigo' => '59', 'valor' => 'Unidad', 'status' => 'Desactivado'],
            ['codigo' => '99', 'valor' => 'Otra', 'status' => 'Desactivado'],            

        ];  

        DB::table('unidad_medidas')->insert($medidas);    }
}