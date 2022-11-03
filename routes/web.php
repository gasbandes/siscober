<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth',])->group(function () {

#############################################################################################
##################  Administación del sistema   #############################################
#############################################################################################
   Route::get('/', 'HomeController@index')->name('home');
#############################################################################################
   Route::resource('usuarios',   'UserController');
   Route::get('listado/usuarios',   'UserController@listado');
   Route::get('usuarios/{usuarios}/delete',   'UserController@destroy');
   Route::resource('logins',   'LoginController');
   Route::resource('roles',   'RolesController');
   Route::get('listado/roles',   'RolesController@listado');
   Route::get('roles/{roles}/delete',   'RolesController@destroy');
   Route::DELETE('/notificaciones/borrar/{notificacion_id}', 'HomeController@borrarNotificacion')->name('borrarNotificacion');
#############################################################################################   

Route::resource('permission', 'PermissionController');
   
#############################################################################################
#############################################################################################
#############################################################################################
#############################################################################################
#
#
#
#
#############################################################################################
################################# MOD REGISTRO DE GERENCIAS    ##############################
#############################################################################################

  Route::resource('gerencia', 'GerenciaController');
  Route::get('listado/gerencias', 'GerenciaController@listado');
  Route::get('gerencia/{roles}/delete',   'GerenciaController@destroy');
#
#
#
#
#
#############################################################################################
################################# MOD REGISTRO DEL PERSONAL    ##############################
#############################################################################################
  Route::resource('personal', 'PersonalController');
  Route::get('personal/{roles}/delete',   'PersonalController@destroy');
  Route::get('empleado/{ente_form}/gerencia',   'PersonalController@gerencia');
#
#
#
#
#
#############################################################################################
################################# MOD REGISTRO DE MONTO GLOBAL ##############################
#############################################################################################
  Route::resource('montoglobal', 'MontoGlobalController');
  Route::get('listado/montoglobal',   'MontoGlobalController@listado')->name('montoglobal.listado');
  Route::get('montoglobal/{roles}/delete',   'MontoGlobalController@destroy');
  Route::get('empleado/{ente_form}/gerencia',   'PersonalController@gerencia');
  Route::get('historialmontos',   'MontoGlobalController@historial')->name('montoglobal.historial');
  Route::get('listado/historialmontos',   'MontoGlobalController@historialmontos')->name('historialmontos.listado');

#
#
#
#
##############################################################################################
################################# MOD REGISTRO DE Proveedores   #############################
#############################################################################################

  Route::resource('beneficiario', 'BeneficiarioController');
  Route::get('listado/beneficiario', 'BeneficiarioController@listado');
  Route::get('beneficiario/{roles}/delete',   'BeneficiarioController@destroy');
#
#
#
#
#############################################################################################
################################# MOD REGISTRO DE Proveedores   #############################
#############################################################################################

  Route::resource('proveedores', 'ProveedoresController');
  Route::get('listado/proveedores', 'ProveedoresController@listado');
  Route::get('proveedores/{roles}/delete',   'ProveedoresController@destroy');
#
#
#
#
#############################################################################################
################################# MOD REGISTRO DE Facturas  #################################
#############################################################################################

  Route::resource('facturas', 'FacturaController');
  Route::get('listado/facturas', 'FacturaController@listado');
  Route::get('facturas/{roles}/delete',   'FacturaController@destroy');
  Route::get('facturas/{titular}/beneficiario',   'FacturaController@beneficiario');
  Route::post('buscar/facturas',   'FacturaController@buscar');
#
#
#
#
#############################################################################################
################################# MOD REGISTRO DE Proveedores   #############################
#############################################################################################

  Route::resource('tasa', 'TasaController');
  Route::get('listado/tasa', 'TasaController@listado');
  Route::get('tasa/{roles}/delete',   'TasaController@destroy');
#
#
#
#
#############################################################################################
################################# MOD REGISTRO DE Reembolsos ################################
#############################################################################################

  Route::resource('reembolsos', 'ReembolsoController');
  Route::get('listado/reembolsos', 'ReembolsoController@listado');
  Route::get('reembolsos/{roles}/delete',   'ReembolsoController@destroy');
  Route::get('reembolsos/{titular}/beneficiario',   'ReembolsoController@beneficiario');
  
#
#
#
#
#############################################################################################
################################# MOD REGISTRO DE LOGS ######################################
#############################################################################################

  Route::resource('logs', 'LogController');
  Route::get('listado/logs',   'LogController@logs')->name('logs.listado');
  Route::get('autorizacion/{factura_id}/factura',   'AutorizacionesController@autorizacion');
  Route::get('facturas/detalle/{factura_id}',   'FacturaController@detalle');
  Route::get('facturas/autorizada/{factura_id}',   'AutorizacionesController@store');

#
#
#
#

});
