<?php

namespace App\Http\Controllers;

use App\Models\MontoGlobal;
use App\Models\Personal;
use App\Models\HistorialMontoGlobal;
use Illuminate\Http\Request;

class MontoGlobalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $montos = MontoGlobal::get();
        return view('admin.montoglobal.index',compact('montos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listado ()
    {

        $montos = MontoGlobal::get();
        return $montos;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {




         $monto = new MontoGlobal();
         $monto->usuario_id = \Auth::user()->id;
         $monto->total = $request->total;
         $monto->fecha = date('Y-m-d');
         $monto->dia =date('d');
         $monto->mes = date('m');
         $monto->year = date('Y');
         $monto->status = $request->status;
         $monto->save();

         $historial = new HistorialMontoGlobal();
         $historial->monto_global_id = $monto->id;
         $historial->total = $request->total;
         $historial->fecha = date('Y-m-d');
         $historial->dia =date('d');
         $historial->mes = date('m');
         $historial->year = date('Y');
         $historial->descripcion = 'El usuario '.\Auth::user()->name.' '.\Auth::user()->last_name.' Ha ingresado un monto al saldo global por: '.$request->total.' USD';
         $historial->save();

          if ($this->personal() <> 0 ) {

              Personal::where('status', 1)
              ->orWhere('status','=','2')
              ->update(['monto_global_id'  => $monto->id,
                        'saldo_disponible' => $request->total ]);
          }

          return json_encode(['success' => true]);










    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MontoGlobal  $montoGlobal
     * @return \Illuminate\Http\Response
     */
    public function historial()
    {
        $historiales = HistorialMontoGlobal::get();
        return view('admin.montoglobal.historial.index',compact('historiales'));
    }


     /**
     * Display the specified resource.
     *
     * @param  \App\Models\MontoGlobal  $montoGlobal
     * @return \Illuminate\Http\Response
     */
    public function personal()
    {
        $personal = \DB::table('personals')->count();
        return $personal;
    }
   /**
     * Display the specified resource.
     *
     * @param  \App\Models\MontoGlobal  $montoGlobal
     * @return \Illuminate\Http\Response
     */
    public function historialmontos ()
    {
        $historiales = HistorialMontoGlobal::get();
        return $historiales;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MontoGlobal  $montoGlobal
     * @return \Illuminate\Http\Response
     */
    public function edit(MontoGlobal $montoGlobal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MontoGlobal  $montoGlobal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $monto = MontoGlobal::find($id);
         $monto->usuario_id = \Auth::user()->id;
         $monto->total = $request->total;
         $monto->fecha = date('Y-m-d');
         $monto->dia =date('d');
         $monto->mes = date('m');
         $monto->year = date('Y');
         $monto->status = $request->status;
         $monto->save();

         $historial = new HistorialMontoGlobal();
         $historial->monto_global_id = $id;
         $historial->total = $request->total;
         $historial->fecha = date('Y-m-d');
         $historial->dia =date('d');
         $historial->mes = date('m');
         $historial->year = date('Y');

         if ($request->status == 0) {
              $historial->descripcion = 'El usuario '.\Auth::user()->name.' '.\Auth::user()->last_name.' Ha modificado el status del monto globla a : Inactivo ';
         }
         else
         {
             $historial->descripcion = 'El usuario '.\Auth::user()->name.' '.\Auth::user()->last_name.' Ha  modificado el saldo global por: '.$request->total.' USD';
         }


         $historial->save();

          return json_encode(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MontoGlobal  $montoGlobal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
