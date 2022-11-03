<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionTableSeeder extends Seeder
{
     private $permissions , $user_permissions;


    public function __construct()
    {
        /*
        set the default permissions
        */
        $this->permissions =  [


                                /* Usuarios */
                                'Ver Usuario',
                                'Registrar Usuario',
                                'Editar Usuario',
                                'Eliminar Usuario',


                                /* Asignar permisos */
                                'Asignar Permisos',


                                'Ver Permisos',
                                'Crear Permisos',
                                'Editar Permisos',
                                'Eliminar Permisos',

                                /* Logins */
                                'Ver Logins',
                                'Ver LogSistema',


                                /* Roles */
                                'Ver Role',
                                'Registrar Role',
                                'Editar Role',
                                'Eliminar Role',

                                /* Facturas */
                                'Ver Factura',
                                'Registrar Factura',
                                'Editar Factura',
                                'Eliminar Factura',

                                 /* Reembolsos */
                                'Ver Reembolso',
                                'Registrar Reembolso',
                                'Editar Reembolso',
                                'Eliminar Reembolso',

                                 /* Titulares */
                                'Ver Titulares',
                                'Registrar Titulares',
                                'Editar Titulares',
                                'Eliminar Titulares',

                                /* Tasa */
                                'Ver Tasa',
                                'Registrar Tasa',
                                'Editar Tasa',
                                'Eliminar Tasa',

                                /* Personal */
                                'Ver Personal',
                                'Registrar Personal',
                                'Editar Personal',
                                'Eliminar Personal',

                                /* Beneficiario */
                                'Ver Beneficiario',
                                'Registrar Beneficiario',
                                'Editar Beneficiario',
                                'Eliminar Beneficiario',

                                /* Proveedores */
                                'Ver Proveedores',
                                'Registrar Proveedores',
                                'Editar Proveedores',
                                'Eliminar Proveedores',

                                /* Gerencias */
                                'Ver Gerencia',
                                'Registrar Gerencia',
                                'Editar Gerencia',
                                'Eliminar Gerencia',


                                /* Historial Montos */
                                'Ver Historial de Montos',
                                'Registrar Historial de Montos',
                                'Editar Historial de Montos',
                                'Eliminar Historial de Montos',

                                /* Log del sistema */
                                'Ver Log del sistema',
                                'Registrar Log del sistema',
                                'Editar Log del sistema',
                                'Eliminar Log del sistema',

                                /* Monto Global */
                                'Ver Monto Global',
                                'Registrar Monto Global',
                                'Editar Monto Global',
                                'Eliminar Monto Global',










                              ];


        /*
        set the permissions for the user role, by default
        role admin we will assign all the permissions
        */
        $this->user_permissions = [

                                    'Ver Beneficiario',

                                    'Registrar Beneficiario',
                                    'Editar Beneficiario',

                                     /* Facturas */
                                    'Ver Factura',
                                    'Registrar Factura',
                                    //'Editar Factura',
                                    //'Eliminar Factura',

                                     /* Reembolsos */
                                    'Ver Reembolso',
                                    'Registrar Reembolso',
                                    //'Editar Reembolso',
                                    //'Eliminar Reembolso',

                             ];

    }




    public function run()
      {


	        // Reset cached roles and permissions
	        app()['cache']->forget('spatie.permission.cache');

	        // create permissions
	        foreach ($this->permissions as $permission)
	        {
	            Permission::create(['name' => $permission]);
	        }

	        // create the admin role and set all default permissions
	        $role = Role::create(['name' => 'Seguridad']);
	        $role->givePermissionTo($this->permissions);
             // create the admin role and set all default permissions
            $role = Role::create(['name' => 'Tecnologia']);
            $role->givePermissionTo($this->permissions);


	        // create the user role and set all user permissions
	        $role = Role::create(['name' => 'Verificador']);
	        $role->givePermissionTo($this->permissions);

	         // create the user role and set all user permissions
	        $role = Role::create(['name' => 'Usuario']);
	        $role->givePermissionTo($this->user_permissions);




    }
}
