<?php

namespace App\Http\Controllers;

use App\Models\Gerencia;
use Illuminate\Http\Request;

class GerenciaController extends Controller
{

      public function __construct()
    {
        $this->middleware('permission:Ver Gerencia')->only('index'); 
        $this->middleware('permission:Registrar Gerencia')->only('create');
        $this->middleware('permission:Registrar Gerencia')->only('store');
        $this->middleware('permission:Editar Gerencia')->only('edit');
        $this->middleware('permission:Editar Gerencia')->only('update');
        $this->middleware('permission:Ver Gerencia')->only('show'); 

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver las gerencias ingresadas al sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        $gerencias = Gerencia::get();

        return view('admin.gerencia.index', compact('gerencias'));
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listado()
    {
        $gerencias = Gerencia::get();

        return $gerencias;
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
    public function store(Request $request)
    {
        $gerencias = new Gerencia();
        $gerencias->ente = $request->ente;
        $gerencias->name = $request->name;
        $gerencias->status = $request->status;
        $gerencias->save();

        $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado una nueva gerencia: '.$request->name.' en el sistema, a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        return json_encode(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gerencia  $gerencia
     * @return \Illuminate\Http\Response
     */
    public function show(Gerencia $gerencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gerencia  $gerencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Gerencia $gerencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gerencia  $gerencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gerencias =Gerencia::find($id);
        $gerencias->ente = $request->ente;
        $gerencias->name = $request->name;
        $gerencias->status = $request->status;
        $gerencias->save();

         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha modificado la gerencia: '.$request->name.' en el sistema, a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        return json_encode(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gerencia  $gerencia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

         $gerencia = Gerencia::find($id);

         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha eliminado la gerencia: '.$gerencia->name.' en el sistema, a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();
         $gerencia->delete();
         return json_encode(['success' => true]);
    }
}
