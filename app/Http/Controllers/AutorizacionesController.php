<?php

namespace App\Http\Controllers;

use App\Models\Autorizaciones;
use App\Models\Notificaciones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutorizacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autorizacion ($id)
    {
        $factura = \DB::table('facturas')->where('id',$id)->first();

        $logs = new \App\Models\Log();
        $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
        $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha solicitado una autorización para modificar la factura nro: '.$factura->nu_factura.',  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
        $logs->usuario_id =\Auth::id(); 
        $logs->save();

        $autorizacion = new \App\Models\Autorizaciones();
        $autorizacion->usuario_id = \Auth::id();
        $autorizacion->factura_id = $id;
        $autorizacion->status = 2;
        $autorizacion->save();

        $titulo = "Solicitud de autorización";
        $texto = "Se desea modificar la factura N°: ".$factura->nu_factura; 
        $link_texto = "Ir a la factura";
        $link = "/facturas/detalle/" . $factura->id;
        Notificaciones::crearNotificacion($titulo, $texto, $link, $link_texto);

        return \Redirect::to('facturas');


       


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $factura = \DB::table('facturas')->where('id',$id)->first();

        $logs = new \App\Models\Log();
        $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
        $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha autorizado modificar la factura nro: '.$factura->nu_factura.',  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
        $logs->usuario_id =\Auth::id(); 
        $logs->save();

        $autorizacion =  \App\Models\Autorizaciones::find($factura->id);
        $autorizacion->usuario_id = \Auth::id();
        $autorizacion->factura_id = $id;
        $autorizacion->status = 1;
        $autorizacion->save();

       

        return \Redirect::to('facturas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Autorizaciones  $autorizaciones
     * @return \Illuminate\Http\Response
     */
    public function show(Autorizaciones $autorizaciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Autorizaciones  $autorizaciones
     * @return \Illuminate\Http\Response
     */
    public function edit(Autorizaciones $autorizaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Autorizaciones  $autorizaciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Autorizaciones $autorizaciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Autorizaciones  $autorizaciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(Autorizaciones $autorizaciones)
    {
        //
    }
}
