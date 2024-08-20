<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TributosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tributos = [
            ['codigo' => '20', 'valor' => 'Impuesto al Valor Agregado 13%', 'status' => 'Desactivado'],
            ['codigo' => 'C3', 'valor' => 'Impuesto al Valor Agregado (exportaciones) 0%', 'status' => 'Desactivado'],
            ['codigo' => '59', 'valor' => 'Turismo: por alojamiento (5%)', 'status' => 'Desactivado'],
            ['codigo' => '71', 'valor' => 'Turismo: salida del país por vía aérea $7.00', 'status' => 'Desactivado'],
            ['codigo' => 'D1', 'valor' => 'FOVIAL ($0.20 Ctvs. por galón)', 'status' => 'Desactivado'],
            ['codigo' => 'C8', 'valor' => 'COTRANS ($0.10 Ctvs. por galón)', 'status' => 'Desactivado'],
            ['codigo' => 'D5', 'valor' => 'Otras tasas casos especiales', 'status' => 'Desactivado'],
            ['codigo' => 'D4', 'valor' => 'Otros impuestos casos especiales', 'status' => 'Desactivado'],
            ['codigo' => 'A8', 'valor' => 'Impuesto Especial al Combustible (0%, 0.5%, 1%)', 'status' => 'Desactivado'],
            ['codigo' => '57', 'valor' => 'Impuesto industria de Cemento', 'status' => 'Desactivado'],
            ['codigo' => '90', 'valor' => 'Impuesto especial a la primera matrícula', 'status' => 'Desactivado'],
            ['codigo' => 'A6', 'valor' => 'Impuesto ad-valorem, armas de fuego, municiones explosivas y artículos similares', 'status' => 'Desactivado'],
            ['codigo' => 'C5', 'valor' => 'Impuesto ad-valorem por diferencial de precios de bebidas alcohólicas (8%)', 'status' => 'Desactivado'],
            ['codigo' => 'C6', 'valor' => 'Impuesto ad-valorem por diferencial de precios al tabaco cigarrillos (39%)', 'status' => 'Desactivado'],
            ['codigo' => 'C7', 'valor' => 'Impuesto ad-valorem por diferencial de precios al tabaco cigarros (100%)', 'status' => 'Desactivado'],
            ['codigo' => '19', 'valor' => 'Fabricante de Bebidas Gaseosas, Isotónicas, Deportivas, Fortificantes, Energizante o Estimulante', 'status' => 'Desactivado'],
            ['codigo' => '28', 'valor' => 'Importador de Bebidas Gaseosas, Isotónicas, Deportivas, Fortificantes, Energizante o Estimulante', 'status' => 'Desactivado'],
            ['codigo' => '31', 'valor' => 'Detallistas o Expendedores de Bebidas Alcohólicas', 'status' => 'Desactivado'],
            ['codigo' => '32', 'valor' => 'Fabricante de Cerveza', 'status' => 'Desactivado'],
            ['codigo' => '33', 'valor' => 'Importador de Cerveza', 'status' => 'Desactivado'],
            ['codigo' => '34', 'valor' => 'Fabricante de Productos de Tabaco', 'status' => 'Desactivado'],
            ['codigo' => '35', 'valor' => 'Importador de Productos de Tabaco', 'status' => 'Desactivado'],
            ['codigo' => '36', 'valor' => 'Fabricante de Armas de Fuego, Municiones y Artículos Similares', 'status' => 'Desactivado'],
            ['codigo' => '37', 'valor' => 'Importador de Arma de Fuego, Munición y Artículos Similares', 'status' => 'Desactivado'],
            ['codigo' => '38', 'valor' => 'Fabricante de Explosivos', 'status' => 'Desactivado'],
            ['codigo' => '39', 'valor' => 'Importador de Explosivos', 'status' => 'Desactivado'],
            ['codigo' => '42', 'valor' => 'Fabricante de Productos Pirotécnicos', 'status' => 'Desactivado'],
            ['codigo' => '43', 'valor' => 'Importador de Productos Pirotécnicos', 'status' => 'Desactivado'],
            ['codigo' => '44', 'valor' => 'Productor de Tabaco', 'status' => 'Desactivado'],
            ['codigo' => '50', 'valor' => 'Distribuidor de Bebidas Gaseosas, Isotónicas, Deportivas, Fortificantes, Energizante o Estimulante', 'status' => 'Desactivado'],
            ['codigo' => '51', 'valor' => 'Bebidas Alcohólicas', 'status' => 'Desactivado'],
            ['codigo' => '52', 'valor' => 'Cerveza', 'status' => 'Desactivado'],
            ['codigo' => '53', 'valor' => 'Productos del Tabaco', 'status' => 'Desactivado'],
            ['codigo' => '54', 'valor' => 'Bebidas Carbonatadas o Gaseosas Simples o Endulzadas', 'status' => 'Desactivado'],
            ['codigo' => '55', 'valor' => 'Otros Específicos', 'status' => 'Desactivado'],
            ['codigo' => '58', 'valor' => 'Alcohol', 'status' => 'Desactivado'],
            ['codigo' => '77', 'valor' => 'Importador de Jugos, Néctares, Bebidas con Jugo y Refrescos', 'status' => 'Desactivado'],
            ['codigo' => '78', 'valor' => 'Distribuidor de Jugos, Néctares, Bebidas con Jugo y Refrescos', 'status' => 'Desactivado'],
            ['codigo' => '79', 'valor' => 'Sobre Llamadas Telefónicas Provenientes del Ext.', 'status' => 'Desactivado'],
            ['codigo' => '85', 'valor' => 'Detallista de Jugos, Néctares, Bebidas con Jugo y Refrescos', 'status' => 'Desactivado'],
            ['codigo' => '86', 'valor' => 'Fabricante de Preparaciones Concentradas o en Polvo para la Elaboración de Bebidas', 'status' => 'Desactivado'],
            ['codigo' => '91', 'valor' => 'Fabricante de Jugos, Néctares, Bebidas con Jugo y Refrescos', 'status' => 'Desactivado'],
            ['codigo' => '92', 'valor' => 'Importador de Preparaciones Concentradas o en Polvo para la Elaboración de Bebidas', 'status' => 'Desactivado'],
            ['codigo' => 'A1', 'valor' => 'Específicos y Ad-Valorem', 'status' => 'Desactivado'],
            ['codigo' => 'A5', 'valor' => 'Bebidas Gaseosas, Isotónicas, Deportivas, Fortificantes, Energizantes o Estimulantes', 'status' => 'Desactivado'],
            ['codigo' => 'A7', 'valor' => 'Alcohol Etílico', 'status' => 'Desactivado'],
            ['codigo' => 'A9', 'valor' => 'Sacos Sintéticos', 'status' => 'Desactivado'],           

        ];  

        DB::table('unidad_medidas')->insert($tributos);    }
}