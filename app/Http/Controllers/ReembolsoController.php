<?php

namespace App\Http\Controllers;

use App\Models\Reembolso;
use App\Models\Personal;
use Illuminate\Http\Request;

class ReembolsoController extends Controller
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
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver el listado de reemsolsos ingresados al sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();
        $reembolsos = Reembolso::get();
        return view('admin.reembolso.index',compact('reembolsos'));
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a crear un reemsolso en el sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();


        $tasa = $this->bolivares();
        if ($tasa == 0) {
             \Alert::info('¡Anuncio!', 'Ingresa la tasa del día.');
             return redirect()->to('tasa');
        }
            
          $titulares = \DB::table('personals')->orderBy('id', 'Asc')->get();
          return view('admin.reembolso.create',compact('titulares'));

       


       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


         $tasa = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->first();
         //dd(number_format($request->total_factura /$tasa->amount,2));

        if ($request->titular_beneficiario == 1) {
           
            $trabajador = Personal::find($request->titular_id);

            $reembolso = new Reembolso();

            $reembolso->fecha_factura = $request->fecha_factura;
            $reembolso->nu_factura = $request->nu_factura;
            $reembolso->nu_control = $request->nu_control;
            $reembolso->proveedor_id = $request->proveedor_id;
            $reembolso->personal_id = $request->titular_id;
            $reembolso->titular_beneficiario = $trabajador->tx_nombres.' '.$trabajador->tx_apellidos;
            $reembolso->base_importe = $request->base_importe;
            $reembolso->iva = $request->iva;
            $reembolso->total_factura = $request->total_factura;
            $reembolso->monto_pagado = $request->monto_pagado;
            $reembolso->status = $request->status;
            $reembolso->fecha_emision = date('Y-m-d');
            $reembolso->usuario_id = \Auth::id();
            $reembolso->mes = date('m');
            $reembolso->year = date('Y');
            $reembolso->total_dolar = number_format($request->total_factura /$tasa->amount,2);
            $reembolso->tasa_id = $tasa->id;
           
            $reembolso->save();

           /*Se le descuenta al trabajor segun el estado de la factura*/

           if ($reembolso->status == 1 || $reembolso->status == 2 ) {
            
                $monto_global = \DB::table('monto_globals')->where('status',1)->first();
                $titular = Personal::find($request->titular_id);
                $titular->saldo_disponible = $titular->saldo_disponible - $reembolso->total_dolar;
                $titular->saldo_consumido  = $reembolso->total_dolar + $titular->saldo_consumido;
                $titular->save();
           }
            $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado nuevo reembolso con el número: '.$reembolso->nu_factura.' ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save();

            return json_encode(['success' => true]);
        }


         $tasa = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->first();
         //dd(number_format($request->total_factura /$tasa->amount,2));


        try {

            $reembolso = new Reembolso();

            $reembolso->fecha_factura = $request->fecha_factura;
            $reembolso->nu_factura = $request->nu_factura;
            $reembolso->nu_control = $request->nu_control;
            $reembolso->proveedor_id = $request->proveedor_id;
            $reembolso->personal_id = $request->titular_id;
            $reembolso->beneficiario_id = $request->beneficiario_id;
            $reembolso->base_importe = $request->base_importe;
            $reembolso->iva = $request->iva;
            $reembolso->total_factura = $request->total_factura;
            $reembolso->monto_pagado = $request->monto_pagado;
            $reembolso->status = $request->status;
            $reembolso->fecha_emision = date('Y-m-d');
            $reembolso->usuario_id = \Auth::id();
            $reembolso->mes = date('m');
            $reembolso->year = date('Y');
            $reembolso->total_dolar = $request->total_factura / $tasa->amount;
            $reembolso->tasa_id = $tasa->id;
           
            $reembolso->save();

           /*Se le descuenta al trabajor segun el estado de la factura*/

           if ($reembolso->status == 1  ) {
            
                $monto_global = \DB::table('monto_globals')->where('status',1)->first();
                $titular = \App\Models\Personal::find($request->titular_id);
                $titular->saldo_disponible = $titular->saldo_disponible - $reembolso->total_dolar;
                $titular->saldo_consumido  = $reembolso->total_dolar + $titular->saldo_consumido;
                $titular->save();
           }

            $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado nuevo reembolso con el número: '.$reembolso->nu_factura.' ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save();

            return json_encode(['success' => true]);
            
        } catch (\Exception $e) {
                
                dd($e);

             return json_encode(['success' => false,'message' => 'Algo salió mal']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factura  $reembolso
     * @return \Illuminate\Http\Response
     */
    public function beneficiario($id)
    {
         $titular = \DB::table('personals')->find($id);

        return \DB::table('beneficiarios')->where('titular',$titular->tx_nombres.' '.$titular->tx_apellidos)->orderBy('id', 'Asc')->get();
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function buscar(Request $request)
    {
            $facpagada    = Factura::where('status',1)->count();
            $facpendiente = Factura::where('status',2)->count();
            $faccancelada = Factura::where('status',3)->count();

            $reempagada    = \App\Models\Reembolso::where('status',1)->count();
            $reempendiente = \App\Models\Reembolso::where('status',2)->count();
            $reemcancelada = \App\Models\Reembolso::where('status',3)->count();

        if ($request->tipo_busqueda_factura == 1) {
           
            $factura_busqueda = Reembolso::whereBetween('fecha_emision',[$request->from_factura , $request->to_factura])->get();
            $busqueda = true;

            return view('admin.home.index',compact('factura_busqueda','busqueda','facpagada','facpendiente','faccancelada','reempagada','reempendiente','reemcancelada'));
        }
        else
        {
            $facpagada    = Factura::where('status',1)->count();
            $facpendiente = Factura::where('status',2)->count();
            $faccancelada = Factura::where('status',3)->count();

            $reempagada    = \App\Models\Reembolso::where('status',1)->count();
            $reempendiente = \App\Models\Reembolso::where('status',2)->count();
            $reemcancelada = \App\Models\Reembolso::where('status',3)->count();

            $factura_busqueda = Reembolso::where('mes',$request->mes_factura)->get();
            $busqueda = true;

            return view('admin.home.index',compact('factura_busqueda','busqueda','facpagada','facpendiente','faccancelada','reempagada','reempendiente','reemcancelada'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Reembolso $reembolso)
    {
        //dd($reembolso);

       $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado para editar un reembolso con el Nro de factura:'. $reembolso->nu_factura.',  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        $tasa = $this->bolivares();
        if ($tasa == 0) {
             \Alert::info('¡Anuncio!', 'Ingresa la tasa del día.');
             return redirect()->to('tasa');
        }
            
          $titulares = \DB::table('personals')->get();
          return view('admin.reembolso.edit',compact('titulares','reembolso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factura  $reembolso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reembolso $reembolso)
    {
         $tasa = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->first();
         //dd(number_format($request->total_factura /$tasa->amount,2));

        if ($request->titular_beneficiario == 1) {
           
            $trabajador = Personal::find($request->titular_id);

            

            $reembolso->fecha_factura = $request->fecha_factura;
            $reembolso->nu_factura = $request->nu_factura;
            $reembolso->nu_control = $request->nu_control;
            $reembolso->proveedor_id = $request->proveedor_id;
            $reembolso->personal_id = $request->titular_id;
            $reembolso->titular_beneficiario = $trabajador->tx_nombres.' '.$trabajador->tx_apellidos;
            $reembolso->base_importe = $request->base_importe;
            $reembolso->iva = $request->iva;
            $reembolso->total_factura = $request->total_factura;
            $reembolso->monto_pagado = $request->monto_pagado;
            $reembolso->status = $request->status;
            $reembolso->fecha_emision = date('Y-m-d');
            $reembolso->usuario_id = \Auth::id();
            $reembolso->mes = date('m');
            $reembolso->year = date('Y');
            $reembolso->total_dolar = number_format($request->total_factura /$tasa->amount,2);
            $reembolso->tasa_id = $tasa->id;
           
            $reembolso->save();

           /*Se le descuenta al trabajor segun el estado de la factura*/

           if ($reembolso->status == 1 || $reembolso->status == 2 ) {
            
                $monto_global = \DB::table('monto_globals')->where('status',1)->first();
                $titular = Personal::find($request->titular_id);
                $titular->saldo_disponible = $titular->saldo_disponible - $reembolso->total_dolar;
                $titular->saldo_consumido  = $reembolso->total_dolar + $titular->saldo_consumido;
                $titular->save();
           }
            $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.'  Ha Modificado el reembolso con el el siguiete número de factura: '.$reembolso->nu_factura.' ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save();

            return json_encode(['success' => true]);
        }


         $tasa = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->first();
         //dd(number_format($request->total_factura /$tasa->amount,2));


        try {

            

            $reembolso->fecha_factura = $request->fecha_factura;
            $reembolso->nu_factura = $request->nu_factura;
            $reembolso->nu_control = $request->nu_control;
            $reembolso->proveedor_id = $request->proveedor_id;
            $reembolso->personal_id = $request->titular_id;
            $reembolso->beneficiario_id = $request->beneficiario_id;
            $reembolso->base_importe = $request->base_importe;
            $reembolso->iva = $request->iva;
            $reembolso->total_factura = $request->total_factura;
            $reembolso->monto_pagado = $request->monto_pagado;
            $reembolso->status = $request->status;
            $reembolso->fecha_emision = date('Y-m-d');
            $reembolso->usuario_id = \Auth::id();
            $reembolso->mes = date('m');
            $reembolso->year = date('Y');
            $reembolso->total_dolar = $request->total_factura / $tasa->amount;
            $reembolso->tasa_id = $tasa->id;
           
            $reembolso->save();

           /*Se le descuenta al trabajor segun el estado de la factura*/

           if ($reembolso->status == 1  ) {
            
                $monto_global = \DB::table('monto_globals')->where('status',1)->first();
                $titular = \App\Models\Personal::find($request->titular_id);
                $titular->saldo_disponible = $titular->saldo_disponible - $reembolso->total_dolar;
                $titular->saldo_consumido  = $reembolso->total_dolar + $titular->saldo_consumido;
                $titular->save();
           }

            $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha Modificado el reembolso con el el siguiete número de factura: '.$reembolso->nu_factura.' ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save();

            return json_encode(['success' => true]);
            
        } catch (\Exception $e) {
                
                dd($e);

             return json_encode(['success' => false,'message' => 'Algo salió mal']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factura  $reembolso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $reembolso)
    {
        //
    }
     public function bolivares()
    {
        $tbolivares = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->count();

        return $tbolivares;
    }
}
