<?php

namespace App\Http\Controllers;

use App\Models\Tasa;
use Illuminate\Http\Request;

class TasaController extends Controller
{


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
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver las tasas ingresadas al sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id();
          $logs->save();

        return view('admin.tasa.index');
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
    public function listado()
    {
        return Tasa::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tasa = new Tasa();
        $tasa->amount = $request->amount;
        $tasa->fecha_emision = date('d-m-Y');
        $tasa->mes = \Carbon\Carbon::parse($request->fecha_emision)->format('m');
        $tasa->usuario_id = \Auth::id();
        $tasa->save();

        $logs = new \App\Models\Log();
        $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
        $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha cargado una nueva tasa al sistema por: '.$tasa->amount.',  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id();
          $logs->save();

         return json_encode(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tasa  $tasa
     * @return \Illuminate\Http\Response
     */
    public function show(Tasa $tasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tasa  $tasa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasa $tasa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tasa  $tasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tasa = Tasa::find($id);
        $tasa->amount = $request->amount;
        $tasa->fecha_emision = date('d-m-Y');
        $tasa->usuario_id = \Auth::id();
        $tasa->save();

        $logs = new \App\Models\Log();
        $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
        $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha modificado la tasa en el sistema por: '.$tasa->amount.',  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id();
          $logs->save();

         return json_encode(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tasa  $tasa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasa = Tasa::find($id);

         $logs = new \App\Models\Log();
        $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
        $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha eliminado la tasa: '.$tasa->amount.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id();
          $logs->save();

        $tasa->delete();
        return json_encode(['success' => true]);
    }

     public function bolivares()
    {
        $tbolivares = \DB::table('tasas')->where('fecha_emision',date('Y-m-d'))->count();

        return $tbolivares;
    }



}
