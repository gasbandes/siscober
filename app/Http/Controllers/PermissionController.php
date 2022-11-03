<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
   
    public function index()
    {
        $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver los permisos del sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        $permissions = Permission::get();
        return view('admin.permission.index', ['permissions' => $permissions]);
    }


    public function show($id)
    {  
        
        //$roles = Role::get();
        $role = Role::findByName($id);
        
        $name = $role->name;

         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver datos del permiso:'.$name.'en el sistema, a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();
        
        return view('admin.permission.asignar',compact('name','role'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado  nuevo permiso:'.$request->name.' en el sistema, a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        Permission::create($request->only('name'));


         


        return redirect()->route('permission.index');
    }


    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->only('name'));

         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha modificado el permiso: '.$request->name.' en el sistema, a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();
        
        return redirect()->route('permission.index');
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        
         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha eliminado el permiso: '.$permission->name.' en el sistema, a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        $permission->delete();

        return redirect()->route('permission.index');
    }

}
