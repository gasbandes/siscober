<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Reembolso;

class HomeController extends Controller
{

     /**
     * Verificacion de la tasa
     *
     * @return DB::table('tasas')
     */

     public function bolivares()
    {
        $tbolivares = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->count();

        if ($tbolivares == 0) {

            $tbolivares = \DB::table('tasas')
            ->orwhere('mes','01')
            ->orwhere('mes','02')
            ->orwhere('mes','03')
            ->orwhere('mes','04')
            ->orwhere('mes','05')
            ->orwhere('mes','06')
            ->orwhere('mes','07')
            ->orwhere('mes','08')
            ->orwhere('mes','09')
            ->orwhere('mes','10')
            ->orwhere('mes','11')
            ->orwhere('mes','12')
            ->count();
            return $tbolivares;
        }
        else
        {
            return $tbolivares;
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $tasa = $this->bolivares();

        \App\Models\Notificaciones::cargarNotificaciones();

            $facpagada    = Factura::where('status',1)->count();
            $facpendiente = Factura::where('status',2)->count();
            $faccancelada = Factura::where('status',3)->count();

            $reempagada    = Reembolso::where('status',1)->count();
            $reempendiente = Reembolso::where('status',2)->count();
            $reemcancelada = Reembolso::where('status',3)->count();
            $busqueda = false;
            $busqueda_reembolso = false;

             $tbolivares = \DB::table('tasas')->where('fecha_emision',date('d-m-Y'))->first();

             if ($tbolivares == null) {

                 $tbolivares = \DB::table('tasas')
                    ->orwhere('mes','01')
                    ->orwhere('mes','02')
                    ->orwhere('mes','03')
                    ->orwhere('mes','04')
                    ->orwhere('mes','05')
                    ->orwhere('mes','06')
                    ->orwhere('mes','07')
                    ->orwhere('mes','08')
                    ->orwhere('mes','09')
                    ->orwhere('mes','10')
                    ->orwhere('mes','11')
                    ->orwhere('mes','12')
                    ->first();


             }


            return view('admin.home.index',compact('tbolivares','facpagada','busqueda_reembolso','busqueda','facpendiente','faccancelada','reempagada','reempendiente','reemcancelada'));



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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

   public function borrarNotificacion(Request $request, $notificacion_id){
        if($request->ajax()){
            $notificacion = \App\Models\Notificaciones::find($notificacion_id);
            $usuario = \Auth::user();
            if($notificacion != null && $usuario != null){
                $usuario->notificaciones()->detach($notificacion);
                $usuario->save();
                \App\Models\Notificaciones::cargarNotificaciones();

                if($notificacion->usuarios()->count() == 0){
                    $notificacion->delete();
                }
            }
            $notificaciones_total = $usuario->notificaciones()->count();

            return Response()->json([
                'total' => $notificaciones_total,
                'mensaje' => 'Notiicación borrada'
            ]);
        }
    }


}
