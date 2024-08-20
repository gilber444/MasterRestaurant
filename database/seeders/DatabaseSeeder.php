<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ActividadEconomicaSeeder::class,
            AmbienteDestinoSeeder::class,
            TipoDocumentoSeeder::class,
            ModeloFacturacionSeeder::class,
            TipoTransmisionSeeder::class,
            TipoContingenciaSeeder::class,
            RetencionIvaSeeder::class,
            GeneracionDocumentoSeeder::class,
            TipoEstablecimientoSeeder::class,
            TipoServicioMedicoSeeder::class,
            TipoItemSeeder::class,
            UnidadMedidaSeeder::class,
            TributosSeeder::class,
            CondicionOperacionSeeder::class,
            FormaPagoSeeder::class,
            PlazoSeeder::class,
            PaisSeeder::class,
            DocumentoAsociadosSeeder::class,
            IdentificacionReceptorSeeder::class,
            DocumentoContingenciaSeeder::class,
            TipoInvalidacionSeeder::class,
            RemisionBienesSeeder::class,
            TipoDonacionSeeder::class,
            RecintoFiscalSeeder::class,
            RegimenSeeder::class,
            RecintoFiscalSeeder::class,
            TipoPersonaSeeder::class,
            TransporteSeeder::class,            
            IncotermsSeeder::class,
            DomicilioFiscalSeeder::class,
            DepartamentosSeeder::class,
            MunicipiosSeeder::class,
            DistritosSeeder::class,
            EmpresasSeeder::class,
            PermissionsSeeder::class,//Primero, crea los permisos
            RolesSeeder::class,//Luego, crea los roles y asigna permisos
            UsersSeeder::class,//Finalmente, crea los usuarios y asigna roles
        ]);

    }
}
