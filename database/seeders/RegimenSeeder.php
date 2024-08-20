<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegimenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regimen = [
                ['codigo' => 'EX-1.1000.000', 'valor' => 'Exportación Definitiva, Exportación Definitiva, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1040.000', 'valor' => 'Exportación Definitiva, Exportación Definitiva Sustitución de Mercancías, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1041.020', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Provisional, Franq. Presidenciales exento de DAI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1041.021', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Provisional, Franq. Presidenciales exento de DAI e IVA', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.025', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Maquinaria y Equipo LZF. DPA', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.031', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Distribución Internacional', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.032', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Operaciones Internacionales de Logística', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.033', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Centro Internacional de llamadas (Call Center)', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.034', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Tecnologías de Información LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.035', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Investigación y Desarrollo LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.036', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Reparación y Mantenimiento de Embarcaciones Marítimas LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.037', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Reparación y Mantenimiento de Aeronaves LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.038', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Procesos Empresariales LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.039', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Servicios Medico-Hospitalarios LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.040', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Servicios Financieros Internacionales LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.043', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Reparación y Mantenimiento de Contenedores LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.044', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definida, Reparación de Equipos Tecnológicos LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.054', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Atención Ancianos y Convalecientes LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.055', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Telemedicina LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1048.056', 'valor' => 'Exportación Definitiva, Exportación Definitiva Proveniente de Franquicia Definitiva, Cinematografía LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1052.000', 'valor' => 'Exportación Definitiva, Exportación Definitiva de DPA con origen en Compras Locales, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1054.000', 'valor' => 'Exportación Definitiva, Exportación Definitiva de Zona Franca con origen en Compras Locales, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1100.000', 'valor' => 'Exportación Definitiva, Exportación Definitiva de Envíos de Socorro, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1200.000', 'valor' => 'Exportación Definitiva, Exportación Definitiva de Envíos Postales, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1300.000', 'valor' => 'Exportación Definitiva, Exportación Definitiva Envíos que requieren despacho urgente, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1400.000', 'valor' => 'Exportación Definitiva, Exportación Definitiva Courier, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1400.011', 'valor' => 'Exportación Definitiva, Exportación Definitiva Courier, Muestras Sin Valor Comercial', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1400.012', 'valor' => 'Exportación Definitiva, Exportación Definitiva Courier, Material Publicitario', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1400.017', 'valor' => 'Exportación Definitiva, Exportación Definitiva Courier, Declaración de Documentos', 'status' => 'Desactivado'],
                ['codigo' => 'EX-1.1500.000', 'valor' => 'Exportación Definitiva, Exportación Definitiva Menaje de casa, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-2.2100.000', 'valor' => 'Exportación Temporal, Exportación Temporal para Perfeccionamiento Pasivo, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-2.2200.000', 'valor' => 'Exportación Temporal, Exportación Temporal con Reimportación en el mismo estado, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3050.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Importación Temporal, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3051.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Tiendas Libres, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3052.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal para Perfeccionamiento Activo, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3053.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3054.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Régimen de Zona Franca, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3055.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal para Perfeccionamiento Activo con Garantía, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3056.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Distribución Internacional Parque de Servicios, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3056.057', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Distribución Internacional Parque de Servicios, Remisión entre Usuarios Directos del Mismo Parque de Servicios', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3056.058', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Distribución Internacional Parque de Servicios, Remisión entre Usuarios Directos de Diferente Parque de Servicios', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3056.072', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Distribución Internacional Parque de Servicios, Decreto 738 Eléctricos e Híbridos', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3057.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Operaciones Internacional de Logística Parque de Servicios, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3057.057', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Operaciones Internacional de Logística Parque de Servicios, Remisión entre Usuarios Directos del Mismo Parque de Servicios', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3057.058', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Operaciones Internacional de Logística Parque de Servicios, Remisión entre Usuarios Directos de Diferente Parque de Servicios', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3058.033', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Centro Servicio LSI, Centro Internacional de llamadas (Call Center)', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3058.036', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Centro Servicio LSI, Reparación y Mantenimiento de Embarcaciones Marítimas LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3058.037', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Centro Servicio LSI, Reparación y Mantenimiento de Aeronaves LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3058.043', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Centro Servicio LSI, Reparación y Mantenimiento de Contenedores LSI', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3059.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Reparación de Equipo Tecnológico Parque de Servicios, Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX-3.3059.057', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Reparación de Equipo Tecnológico Parque de Servicios, Remisión entre Usuarios Directos del Mismo Parque de Servicios', 'status' => 'Desactivado'],
                ['codigo' => 'EX- 3.3059.058', 'valor' => 'Re-Exportación, Reexportación Proveniente de Admisión Temporal Reparación de Equipo Tecnológico Parque de Servicios, Remisión entre Usuarios Directos de Diferente Parque de Servicios', 'status' => 'Desactivado'],
                ['codigo' => 'EX- 3.3070.000', 'valor' => 'Re-Exportación, Reexportación Proveniente de Depósito., Régimen Común', 'status' => 'Desactivado'],
                ['codigo' => 'EX- 3.3070.072', 'valor' => 'Re-Exportación, Reexportación Proveniente de Depósito., Decreto 738 Eléctricos e Híbridos', 'status' => 'Desactivado'],
        ];  

        DB::table('regimens')->insert($regimen);
    }
}
