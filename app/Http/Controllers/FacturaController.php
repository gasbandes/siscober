<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Personal;
use Illuminate\Http\Request;

class FacturaController extends Controller
{

      public function __construct()
    {
        $this->middleware('permission:Ver Factura')->only('index');
        $this->middleware('permission:Registrar Factura')->only('create');
        $this->middleware('permission:Registrar Factura')->only('store');
        $this->middleware('permission:Editar Factura')->only('edit');
        $this->middleware('permission:Editar Factura')->only('update');
        $this->middleware('permission:Ver Factura')->only('show');

    }

   /**
     * Verificacion de la tasa
     *
     * @return DB::table('tasas')
     */

     public function montoglobal()
    {
        $monto = \DB::table('monto_globals')->count();

        return $monto;
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $montog = $this->montoglobal();

        if ($montog <> 0 ) {

         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver el listado de facturas ingresadas al sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id();
          $logs->save();

        $facturas = Factura::with('beneficiarios')->get();


        return view('admin.factura.index',compact('facturas'));
       }
       else
       {
          \Alert::info('¡Anuncio!', 'Ingresa el monto global disponible.');
          return redirect()->to('montoglobal');
       }

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
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado para crear nueva factura en el sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id();
          $logs->save();
          $tasa = $this->bolivares();

        if ($tasa == 0) {
             \Alert::info('¡Anuncio!', 'Ingresa la tasa del día.');
             return redirect()->to('tasa');
        }

          $titulares = \DB::table('personals')->get();
          return view('admin.factura.create',compact('titulares'));





    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mes =  \Carbon\Carbon::parse($request->fecha_factura)->format('m');


        $tasa = \DB::table('tasas')->where('id',$request->tasa_id)->first();
        $titular = \DB::table('personals')->where('id', $request->titular_id)->first();
        //$tasa = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->first();

        $total_factura = number_format($request->total_factura /$tasa->amount,2);

       if ($titular->saldo_consumido >= '2500.00') {

             //\Alert::info('¡Anuncio!', 'El titular ha sobrepasado el límite de cobertura');
             return json_encode(['error' => true,'message' => 'El titular ha sobrepasado el límite de cobertura']);

       }
       else
       {
         if ($request->titular_beneficiario <> 1) {


             try {

            $factura = new Factura();
            $factura->descripcion = $request->descripcion;
            $factura->fecha_factura = $request->fecha_factura;
            $factura->nu_factura = $request->nu_factura;
            $factura->nu_control = $request->nu_control;
            $factura->proveedor_id = $request->proveedor_id;
            $factura->personal_id = $request->titular_id;
            $factura->beneficiario_id = $request->beneficiario_id;
            $factura->base_importe = $request->base_importe;
            $factura->iva = $request->iva;
            $factura->total_factura = $request->total_factura;
            $factura->monto_pagado = $request->monto_pagado;
            $factura->status = $request->status;
            $factura->fecha_emision = date('Y-m-d');
            $factura->usuario_id = \Auth::id();
            $factura->mes = date('m');
            $factura->year = date('Y');
            $factura->total_dolar = number_format($request->total_factura /$tasa->amount,2);
            $factura->tasa_id = $tasa->id;

            $factura->save();

           /*Se le descuenta al trabajor segun el estado de la factura*/

           if ($factura->status == 1 ) {

                $monto_global = \DB::table('monto_globals')->where('status',1)->first();
                $titular = Personal::find($request->titular_id);
                $titular->saldo_disponible = $titular->saldo_disponible - $factura->total_dolar;
                $titular->saldo_consumido  = $factura->total_dolar + $titular->saldo_consumido;
                $titular->save();
           }

            return json_encode(['success' => true]);

             $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado nueva factura con el número: '.$factura->nu_factura.' ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id();
               $logs->save();

        } catch (\Exception $e) {

                //dd($e);

             return json_encode(['success' => false,'message' => 'Algo salió mal']);
        }




        }

         //$tasa = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->first();
         //dd(number_format($request->total_factura /$tasa->amount,2));

         $trabajador = Personal::find($request->titular_id);

            $factura = new Factura();

            $factura->descripcion = $request->descripcion;
            $factura->fecha_factura = $request->fecha_factura;
            $factura->nu_factura = $request->nu_factura;
            $factura->nu_control = $request->nu_control;
            $factura->proveedor_id = $request->proveedor_id;
            $factura->personal_id = $request->titular_id;
            $factura->titular_beneficiario = $trabajador->tx_nombres.' '.$trabajador->tx_apellidoss;
            $factura->base_importe = $request->base_importe;
            $factura->iva = $request->iva;
            $factura->total_factura = $request->monto_pagado;
            $factura->monto_pagado = $request->total_factura;
            $factura->status = $request->status;
            $factura->fecha_emision = date('Y-m-d');
            $factura->usuario_id = \Auth::id();
            $factura->mes = date('m');
            $factura->year = date('Y');
            $factura->total_dolar = number_format($request->total_factura /$tasa->amount,2);
            $factura->tasa_id = $tasa->id;

            $factura->save();

           /*Se le descuenta al trabajor segun el estado de la factura*/

           if ($factura->status == 1 || $factura->status == 2 ) {

                $monto_global = \DB::table('monto_globals')->where('status',1)->first();
                $titular = Personal::find($request->titular_id);
                $titular->saldo_disponible = $titular->saldo_disponible - $factura->total_dolar;
                $titular->saldo_consumido  = $factura->total_dolar + $titular->saldo_consumido;
                $titular->save();
           }
            $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado nueva factura con el número: '.$factura->nu_factura.' ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id();
               $logs->save();

            return json_encode(['success' => true]);

       }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function beneficiario($id)
    {

       $titular = \DB::table('personals')->find($id);

        return \DB::table('beneficiarios')->where('status',1)->where('titular',$titular->tx_nombres.' '.$titular->tx_apellidos)->get();
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


         if ($request->tipo_busqueda_reembolso) {


             if ($request->tipo_busqueda_reembolso == 1) {

            $reembolso_busqueda = Factura::whereBetween('fecha_emision',[$request->from_reembolso , $request->to_reembolso])->get();
            $busqueda_reembolso  = true;
            $busqueda = false;
            return view('admin.home.index',compact('reembolso_busqueda','busqueda','busqueda_reembolso','facpagada','facpendiente','faccancelada','reempagada','reempendiente','reemcancelada'));
        }
        else
        {
            $facpagada    = Factura::where('status',1)->count();
            $facpendiente = Factura::where('status',2)->count();
            $faccancelada = Factura::where('status',3)->count();

            $reempagada    = \App\Models\Reembolso::where('status',1)->count();
            $reempendiente = \App\Models\Reembolso::where('status',2)->count();
            $reemcancelada = \App\Models\Reembolso::where('status',3)->count();
            //dd($request->mes_reembolso);

            $reembolso_busqueda = \App\Models\Reembolso::where('mes',$request->mes_reembolso)->get();
            $busqueda_reembolso = true;
            $busqueda = false;

            return view('admin.home.index',compact('reembolso_busqueda','busqueda','busqueda_reembolso','facpagada','facpendiente','faccancelada','reempagada','reempendiente','reemcancelada'));
        }

         }

            $facpagada    = Factura::where('status',1)->count();
            $facpendiente = Factura::where('status',2)->count();
            $faccancelada = Factura::where('status',3)->count();

            $reempagada    = \App\Models\Reembolso::where('status',1)->count();
            $reempendiente = \App\Models\Reembolso::where('status',2)->count();
            $reemcancelada = \App\Models\Reembolso::where('status',3)->count();

        if ($request->tipo_busqueda_factura == 1) {

            $factura_busqueda = Factura::whereBetween('fecha_emision',[$request->from_factura , $request->to_factura])->get();
            $busqueda = true;
            $busqueda_reembolso = false;
            return view('admin.home.index',compact('busqueda_reembolso','factura_busqueda','busqueda','facpagada','facpendiente','faccancelada','reempagada','reempendiente','reemcancelada'));
        }
        else
        {
            $facpagada    = Factura::where('status',1)->count();
            $facpendiente = Factura::where('status',2)->count();
            $faccancelada = Factura::where('status',3)->count();

            $reempagada    = \App\Models\Reembolso::where('status',1)->count();
            $reempendiente = \App\Models\Reembolso::where('status',2)->count();
            $reemcancelada = \App\Models\Reembolso::where('status',3)->count();

            $factura_busqueda = Factura::where('mes',$request->mes_factura)->get();
            $busqueda = true;
            $busqueda_reembolso = false;

            return view('admin.home.index',compact('busqueda_reembolso','factura_busqueda','busqueda','facpagada','facpendiente','faccancelada','reempagada','reempendiente','reemcancelada'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $factura)
    {
        $mes =  \Carbon\Carbon::parse($request->fecha_factura)->format('m');
        $tasa = \DB::table('tasas')->where('id',$request->tasa_id)->first();
         //dd(number_format($request->total_factura /$tasa->amount,2));

         if ($request->titular_beneficiario <> 1) {


             try {



            $factura->descripcion = $request->descripcion;
            $factura->fecha_factura = $request->fecha_factura;
            $factura->nu_factura = $request->nu_factura;
            $factura->nu_control = $request->nu_control;
            $factura->proveedor_id = $request->proveedor_id;
            $factura->personal_id = $request->titular_id;
            $factura->beneficiario_id = $request->beneficiario_id;
            $factura->base_importe = $request->base_importe;
            $factura->iva = $request->iva;
            $factura->total_factura = $request->total_factura;
            $factura->monto_pagado = $request->monto_pagado;
            $factura->status = $request->status;
            $factura->fecha_emision = date('Y-m-d');
            $factura->usuario_id = \Auth::id();
            $factura->mes = date('m');
            $factura->year = date('Y');
            $factura->total_dolar = number_format($request->total_factura /$tasa->amount,2);
            $factura->tasa_id = $tasa->id;

            $factura->save();

           /*Se le descuenta al trabajor segun el estado de la factura*/

           if ($factura->status == 1 ) {

                $monto_global = \DB::table('monto_globals')->where('status',1)->first();
                $titular = Personal::find($request->titular_id);
                $titular->saldo_disponible = $titular->saldo_disponible - $factura->total_dolar;
                $titular->saldo_consumido  = $factura->total_dolar + $titular->saldo_consumido;
                $titular->save();
           }

            return json_encode(['success' => true]);

             $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado nueva factura con el número: '.$factura->nu_factura.' ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id();
               $logs->save();

        } catch (\Exception $e) {

                //dd($e);

             return json_encode(['success' => false,'message' => 'Algo salió mal']);
        }




        }

         //$tasa = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->first();
         //dd(number_format($request->total_factura /$tasa->amount,2));

         $trabajador = Personal::find($request->titular_id);




            $factura->descripcion = $request->descripcion;
            $factura->fecha_factura = $request->fecha_factura;
            $factura->nu_factura = $request->nu_factura;
            $factura->nu_control = $request->nu_control;
            $factura->proveedor_id = $request->proveedor_id;
            $factura->personal_id = $request->titular_id;
            $factura->titular_beneficiario = $trabajador->tx_nombres.' '.$trabajador->tx_apellidoss;
            $factura->base_importe = $request->base_importe;
            $factura->iva = $request->iva;
            $factura->total_factura = $request->monto_pagado;
            $factura->monto_pagado = $request->total_factura;
            $factura->status = $request->status;
            $factura->fecha_emision = date('Y-m-d');
            $factura->usuario_id = \Auth::id();
            $factura->mes = date('m');
            $factura->year = date('Y');
            $factura->total_dolar = number_format($request->total_factura /$tasa->amount,2);
            $factura->tasa_id = $tasa->id;

            $factura->save();

           /*Se le descuenta al trabajor segun el estado de la factura*/

           if ($factura->status == 1 || $factura->status == 2 ) {

                $monto_global = \DB::table('monto_globals')->where('status',1)->first();
                $titular = Personal::find($request->titular_id);
                $titular->saldo_disponible = $titular->saldo_disponible - $factura->total_dolar;
                $titular->saldo_consumido  = $factura->total_dolar + $titular->saldo_consumido;
                $titular->save();
           }
            $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado nueva factura con el número: '.$factura->nu_factura.' ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id();
               $logs->save();

            return json_encode(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        //
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
       $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado para editar la factura Nro:'. $factura->nu_factura.',  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id();
          $logs->save();

        $tasa = 1;
        if ($tasa == 0) {
             \Alert::info('¡Anuncio!', 'Ingresa la tasa del día.');
             return redirect()->to('tasa');
        }

          $titulares = \DB::table('personals')->get();
          return view('admin.factura.edit',compact('titulares','factura'));
    }

     public function bolivares()
    {
        $tbolivares = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->count();

        return $tbolivares;
    }

     public function detalle( $id)
     {
            $factura = Factura::find($id);

            return view('admin.factura.detalle',compact('factura'));

     }
}
