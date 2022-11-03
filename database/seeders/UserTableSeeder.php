<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gerencia;
use App\Models\Ente;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();
        $user->name = 'Theizer';
        $user->last_name = 'Gonzalez';
        $user->username = 'tgonzalez';
        $user->email = 'tgonzalez@bandes.gob.ve';
        $user->password = 'admin';
        $user->status = 1;
        $user->save();

        $user->assignRole('Tecnologia');


        $user = new \App\Models\User();
        $user->name = 'Ydhoia';
        $user->last_name = 'Páez';
        $user->username = 'ypaez';
        $user->email = 'ypaez@bandes.gob.ve';
        $user->password = '123456';
        $user->status = 1;
        $user->save();

        $user->assignRole('Verificador');


        $user = new \App\Models\User();
        $user->name = 'Brenda';
        $user->last_name = 'Díaz';
        $user->username = 'bdiaz';
        $user->email = 'bdiaz@bandes.gob.ve';
        $user->password = '123456';
        $user->status = 1;
        $user->save();

        $user->assignRole('Verificador');


        $user = new \App\Models\User();
        $user->name = 'Aaron';
        $user->last_name = 'Moncada';
        $user->username = 'amoncada';
        $user->email = 'amoncada@bandes.gob.ve';
        $user->password = '123456';
        $user->status = 1;
        $user->save();

        $user->assignRole('Usuario');


        $user = new \App\Models\User();
        $user->name = 'Javier';
        $user->last_name = 'cañizalez';
        $user->username = 'jcanizalez';
        $user->email = 'jcanizalez@bandes.gob.ve';
        $user->password = '123456';
        $user->status = 1;
        $user->save();

        $user->assignRole('Usuario');



        $ente = new Ente();
        $ente->name     = 'BANDES';
        $ente->status   = 1;
        $ente->save();

        $ente = new Ente();
        $ente->name     = 'CORPOVEX';
         $ente->status   = 1;
        $ente->save();

        $gerencia = new Gerencia();
        $gerencia->name = 'AUDITORIA INTERNA';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = 'CONSULTORIA JURIDICA';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA EJEC.ADM DE FONDOS OPER.CAMBIARIAS';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA. EJEC. COOP. Y FINAN. INTERNACIONAL';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA. EJEC. DE ADMINISTRACION DE FONDOS';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA. EJEC. DE ADMON INTEGRAL DE RIESGO';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA. EJEC. FONDOS PARA EL DESARROLLO';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA. EJEC. GESTION DEL TALENTO HUMANO';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA. EJEC. SECRETARIA DE LA PRESIDENCIA';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA. EJEC. SEGURIDAD DE LA INFORMACION';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();


        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA. EJECUTIVA  RESGUARDO INSTITUCIONAL';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA.EJEC. COOP. FINANCIAMIENTO NACIONAL';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = '  GCIA.EJEC.INFORMACIÓN Y RELACIONES PUBLI';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA.EJEC.PLANIFICACION GESTION ESTRATEG';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();


        $gerencia = new Gerencia();
        $gerencia->name = 'GCIA.EJEC.TECNOLOGIA DE LA INFORMACION';

        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GCIA.PREVENCION Y CONTROL DE LC/FT/FPADM';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GERENCIA DE PREINVERSION Y ASIST.TECNICA';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GERENCIA EJECUTIVA DE ADMINISTRACION';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' GERENCIA EJECUTIVA DE FINANZAS';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = ' PRESIDENCIA';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = '  SECRETARÍA DE LA COMISION CONTRATACIONES';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();

        $gerencia = new Gerencia();
        $gerencia->name = '  VICEPRESIDENCIA EJECUTIVA';
        $gerencia->ente = 'BANDES';
        $gerencia->status   = 1;
        $gerencia->save();



    }
}
