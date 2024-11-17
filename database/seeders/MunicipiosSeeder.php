<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipios = [
            ['codigo' => '00', 'municipio' => 'Otro (Para extranjeros)', 'departamento' => 00, 'status' => 'Activo'],
            ['codigo' => '13', 'municipio' => 'AHUACHAPAN NORTE', 'departamento' => 1, 'status' => 'Activo'],
            ['codigo' => '14', 'municipio' => 'AHUACHAPAN CENTRO', 'departamento' => 1, 'status' => 'Activo'],
            ['codigo' => '15', 'municipio' => 'AHUACHAPAN SUR', 'departamento' => 1, 'status' => 'Activo'],
            ['codigo' => '10', 'municipio' => 'CABAÑAS ESTE', 'departamento' => 9, 'status' => 'Activo'],
            ['codigo' => '11', 'municipio' => 'CABAÑAS OESTE', 'departamento' => 9, 'status' => 'Activo'],
            ['codigo' => '34', 'municipio' => 'CHALATENANGO NORTE', 'departamento' => 4, 'status' => 'Activo'],
            ['codigo' => '35', 'municipio' => 'CHALATENANGO CENTRO', 'departamento' => 4, 'status' => 'Activo'],
            ['codigo' => '36', 'municipio' => 'CHALATENANGO SUR', 'departamento' => 4, 'status' => 'Activo'],
            ['codigo' => '17', 'municipio' => 'CUSCATLAN NORTE', 'departamento' => 7, 'status' => 'Activo'],
            ['codigo' => '18', 'municipio' => 'CUSCATLAN SUR', 'departamento' => 7, 'status' => 'Activo'],
            ['codigo' => '23', 'municipio' => 'LA LIBERTAD NORTE', 'departamento' => 5, 'status' => 'Activo'],
            ['codigo' => '24', 'municipio' => 'LA LIBERTAD CENTRO', 'departamento' => 5, 'status' => 'Activo'],
            ['codigo' => '25', 'municipio' => 'LA LIBERTAD OESTE', 'departamento' => 5, 'status' => 'Activo'],
            ['codigo' => '26', 'municipio' => 'LA LIBERTAD ESTE', 'departamento' => 5, 'status' => 'Activo'],
            ['codigo' => '27', 'municipio' => 'LA LIBERTAD COSTA', 'departamento' => 5, 'status' => 'Activo'],
            ['codigo' => '28', 'municipio' => 'LA LIBERTAD SUR', 'departamento' => 5, 'status' => 'Activo'],
            ['codigo' => '23', 'municipio' => 'LA PAZ OESTE', 'departamento' => 8, 'status' => 'Activo'],
            ['codigo' => '24', 'municipio' => 'LA PAZ CENTRO', 'departamento' => 8, 'status' => 'Activo'],
            ['codigo' => '19', 'municipio' => 'LA PAZ ESTE', 'departamento' => 8, 'status' => 'Activo'],
            ['codigo' => '20', 'municipio' => 'LA UNION NORTE', 'departamento' => 14, 'status' => 'Activo'],
            ['codigo' => '2', 'municipio' => 'LA UNION SUR', 'departamento' => 14, 'status' => 'Activo'],
            ['codigo' => '27', 'municipio' => 'MORAZAN NORTE', 'departamento' => 13, 'status' => 'Activo'],
            ['codigo' => '28', 'municipio' => 'MORAZAN SUR', 'departamento' => 13, 'status' => 'Activo'],
            ['codigo' => '21', 'municipio' => 'SAN MIGUEL NORTE', 'departamento' => 12, 'status' => 'Activo'],
            ['codigo' => '22', 'municipio' => 'SAN MIGUEL CENTRO', 'departamento' => 12, 'status' => 'Activo'],
            ['codigo' => '23', 'municipio' => 'SAN MIGUEL OESTE', 'departamento' => 12, 'status' => 'Activo'],
            ['codigo' => '20', 'municipio' => 'SAN SALVADOR NORTE', 'departamento' => 6, 'status' => 'Activo'],
            ['codigo' => '21', 'municipio' => 'SAN SALVADOR OESTE', 'departamento' => 6, 'status' => 'Activo'],
            ['codigo' => '22', 'municipio' => 'SAN SALVADOR ESTE', 'departamento' => 6, 'status' => 'Activo'],
            ['codigo' => '23', 'municipio' => 'SAN SALVADOR CENTRO', 'departamento' => 6, 'status' => 'Activo'],
            ['codigo' => '24', 'municipio' => 'SAN SALVADOR SUR', 'departamento' => 6, 'status' => 'Activo'],
            ['codigo' => '14', 'municipio' => 'SAN VICENTE NORTE', 'departamento' => 10, 'status' => 'Activo'],
            ['codigo' => '15', 'municipio' => 'SAN VICENTE SUR', 'departamento' => 10, 'status' => 'Activo'],
            ['codigo' => '14', 'municipio' => 'SANTA ANA NORTE', 'departamento' => 2, 'status' => 'Activo'],
            ['codigo' => '15', 'municipio' => 'SANTA ANA CENTRO', 'departamento' => 2, 'status' => 'Activo'],
            ['codigo' => '16', 'municipio' => 'SANTA ANA ESTE', 'departamento' => 2, 'status' => 'Activo'],
            ['codigo' => '17', 'municipio' => 'SANTA ANA OESTE', 'departamento' => 2, 'status' => 'Activo'],
            ['codigo' => '17', 'municipio' => 'SONSONATE NORTE', 'departamento' => 3, 'status' => 'Activo'],
            ['codigo' => '18', 'municipio' => 'SONSONATE CENTRO', 'departamento' => 3, 'status' => 'Activo'],
            ['codigo' => '19', 'municipio' => 'SONSONATE ESTE', 'departamento' => 3, 'status' => 'Activo'],
            ['codigo' => '20', 'municipio' => 'SONSONATE OESTE', 'departamento' => 3, 'status' => 'Activo'],
            ['codigo' => '24', 'municipio' => 'USULUTAN NORTE', 'departamento' => 11, 'status' => 'Activo'],
            ['codigo' => '25', 'municipio' => 'USULUTAN ESTE', 'departamento' => 11, 'status' => 'Activo'],
            ['codigo' => '26', 'municipio' => 'USULUTAN OESTE', 'departamento' => 11, 'status' => 'Activo'],
        ];

        foreach ($municipios as $municipio) {
            DB::table('municipios')->updateOrInsert(
                ['codigo' => $municipio['codigo'], 'departamento' => $municipio['departamento']],
                ['municipio' => $municipio['municipio'], 'status' => $municipio['status']]
            );
        }
    }
}
