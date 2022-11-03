<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver datos de los proveedores ingresados al sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();
        return view('admin.proveedores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listado()
    {
        return Proveedores::get();
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            Proveedores::create([

                'razon_social' => $request->razon_social,
                'tx_rif' => $request->tx_rif,
                'fecha_emision' =>date('Y-m-d'),
                'usuario_id' => \Auth::id(),
                'status' => $request->status,

            ]);  

             $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado un nuevo proveedor: '.$request->razon_social.' '.$request->tx_rif.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save(); 

            return json_encode(['success' => true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedores $proveedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedores $proveedores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
         $proveedor = \App\Models\Proveedores::find($id);
         $proveedor->razon_social = $request->razon_social;
         $proveedor->tx_rif = $request->tx_rif;
         $proveedor->fecha_emision = date('Y-m-d');
         $proveedor->usuario_id = \Auth::id();
         $proveedor->status = $request->status;
         $proveedor->save();

            $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha modificado los datos del proveedor: '.$request->razon_social.' '.$request->tx_rif.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save(); 

         return json_encode(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
         $proveedor = \App\Models\Proveedores::find($id);

            $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha eliminado al proveedor: '.$proveedor->razon_social.' '.$proveedor->tx_rif.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save(); 
         $proveedor->delete();
         return json_encode(['success' => true]);
    }
}
