<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecintoFiscalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recinto = [
            ['codigo' => '02', 'valor' => 'Marítima de Acajutla', 'status' => 'Desactivado'],
            ['codigo' => '03', 'valor' => 'Aérea Monseñor Óscar Arnulfo Romero', 'status' => 'Desactivado'],
            ['codigo' => '04', 'valor' => 'Terrestre Las Chinamas', 'status' => 'Desactivado'],
            ['codigo' => '05', 'valor' => 'Terrestre La Hachadura', 'status' => 'Desactivado'],
            ['codigo' => '06', 'valor' => 'Terrestre Santa Ana', 'status' => 'Desactivado'],
            ['codigo' => '07', 'valor' => 'Terrestre San Cristóbal', 'status' => 'Desactivado'],
            ['codigo' => '08', 'valor' => 'Terrestre Anguiatú', 'status' => 'Desactivado'],
            ['codigo' => '09', 'valor' => 'Terrestre El Amatillo', 'status' => 'Desactivado'],
            ['codigo' => '10', 'valor' => 'Marítima La Unión (Puerto Cutuco)', 'status' => 'Desactivado'],
            ['codigo' => '11', 'valor' => 'Terrestre El Poy', 'status' => 'Desactivado'],
            ['codigo' => '12', 'valor' => 'Aduana Terrestre Metalío', 'status' => 'Desactivado'],
            ['codigo' => '15', 'valor' => 'Fardos Postales', 'status' => 'Desactivado'],
            ['codigo' => '16', 'valor' => 'Z.F. San Marcos', 'status' => 'Desactivado'],
            ['codigo' => '17', 'valor' => 'Z.F. El Pedregal', 'status' => 'Desactivado'],
            ['codigo' => '18', 'valor' => 'Z.F. San Bartolo', 'status' => 'Desactivado'],
            ['codigo' => '20', 'valor' => 'Z.F. Exportsalva', 'status' => 'Desactivado'],
            ['codigo' => '21', 'valor' => 'Z.F. American Park', 'status' => 'Desactivado'],
            ['codigo' => '23', 'valor' => 'Z.F. Internacional', 'status' => 'Desactivado'],
            ['codigo' => '24', 'valor' => 'Z.F. Diez', 'status' => 'Desactivado'],
            ['codigo' => '26', 'valor' => 'Z.F. Miramar', 'status' => 'Desactivado'],
            ['codigo' => '27', 'valor' => 'Z.F. Santo Tomas', 'status' => 'Desactivado'],
            ['codigo' => '28', 'valor' => 'Z.F. Santa Tecla', 'status' => 'Desactivado'],
            ['codigo' => '29', 'valor' => 'Z.F. Santa Ana', 'status' => 'Desactivado'],
            ['codigo' => '30', 'valor' => 'Z.F. La Concordia', 'status' => 'Desactivado'],
            ['codigo' => '31', 'valor' => 'Aérea Ilopango', 'status' => 'Desactivado'],
            ['codigo' => '32', 'valor' => 'Z.F. Pipil', 'status' => 'Desactivado'],
            ['codigo' => '33', 'valor' => 'Puerto Barillas', 'status' => 'Desactivado'],
            ['codigo' => '34', 'valor' => 'Z.F. Calvo Conservas', 'status' => 'Desactivado'],
            ['codigo' => '35', 'valor' => 'Feria Internacional', 'status' => 'Desactivado'],
            ['codigo' => '36', 'valor' => 'Delg. Aduana El Papalón', 'status' => 'Desactivado'],
            ['codigo' => '37', 'valor' => 'Z.F. Sam-Li', 'status' => 'Desactivado'],
            ['codigo' => '38', 'valor' => 'Z.F. San José', 'status' => 'Desactivado'],
            ['codigo' => '39', 'valor' => 'Z.F. Las Mercedes', 'status' => 'Desactivado'],
            ['codigo' => '71', 'valor' => 'Aldesa', 'status' => 'Desactivado'],
            ['codigo' => '72', 'valor' => 'Agdosa Merliot', 'status' => 'Desactivado'],
            ['codigo' => '73', 'valor' => 'Bodesa', 'status' => 'Desactivado'],
            ['codigo' => '76', 'valor' => 'Delegacion DHL', 'status' => 'Desactivado'],
            ['codigo' => '77', 'valor' => 'Transauto', 'status' => 'Desactivado'],
            ['codigo' => '80', 'valor' => 'Nejapa', 'status' => 'Desactivado'],
            ['codigo' => '81', 'valor' => 'Almaconsa', 'status' => 'Desactivado'],
            ['codigo' => '83', 'valor' => 'Agdosa Apopa', 'status' => 'Desactivado'],
            ['codigo' => '85', 'valor' => 'Gutierrez Courrier y Cargo', 'status' => 'Desactivado'],
            ['codigo' => '99', 'valor' => 'San Bartolo Envío Hn/Gt', 'status' => 'Desactivado'],
            
        ];  

        DB::table('recinto_fiscals')->insert($recinto);
    }
}
