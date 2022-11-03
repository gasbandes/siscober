<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\Gerencia;
use App\Models\HistorialMontoGlobal;
use App\Models\MontoGlobal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 

         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver los titulares ingresados al sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

         $personales = Personal::get();
        return view ('admin.personal.index',compact('personales'));
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
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a cargar nuevo titular al sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

         
         return view ('admin.personal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate(); 
        $monto = MontoGlobal::get()->where('status',1)->first();


         if ($request->ente_id == 1 ) {
             $ente = 'BANDES';
         }
         else
         {
            $ente = 'CORPOVEX';
         }
        $personal = new Personal();

        $personal->tx_nombres = $request->tx_nombres;
        $personal->tx_apellidos = $request->tx_apellidos;
        $personal->cedula = $request->cedula;
        $personal->status = $request->status_id;
        $personal->ente =$ente;
        $personal->gerencia_id = $request->gerencia_id;
        $personal->monto_global_id = $monto->id;
        $personal->saldo_disponible =  $monto->total;

        $personal->usuario_id = \Auth::user()->id;

        $personal->save();

        if ($personal) {
              \Alert::success('¡Bien hecho', 'Datos guardados satisfactoriamente');
               $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado nuevo titular: '.$personal->tx_nombres.' '.$personal->tx_apellidos.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save();
             return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function gerencia($id)
    {
        $ente = '';
       

        if ($id == 1) {
            $ente = 'BANDES';
        }
        else
        {
            $ente = 'CORPOVEX'; 
        }

      $gerencias = Gerencia::where('ente',$ente)->get();

      return $gerencias;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $personal = Personal::find($id);
         $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a editar al titular: '.$personal->tx_nombres.' '.$personal->tx_apellidos.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save();
         return view ('admin.personal.edit',compact('personal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //dd($request);

         if ($request->ente_id == 1 ) {
             $ente = 'BANDES';
         }
         else
         {
            $ente = 'CORPOVEX';
         }
        $personal = Personal::find($id);

        $personal->tx_nombres = $request->tx_nombres;
        $personal->tx_apellidos = $request->tx_apellidos;
        $personal->cedula = $request->cedula;
        $personal->saldo_disponible = $request->saldo_disponible;
        $personal->status = $request->status_id;
        $personal->ente =$ente;
        $personal->gerencia_id = $request->gerencia_id;
        $personal->usuario_id = \Auth::user()->id;

        $personal->save();


        if ($request->autorizado == 1) {
             $historial = new HistorialMontoGlobal();
         $historial->monto_global_id = $personal->monto_global_id;
         $historial->total = $request->saldo_disponible;
         $historial->fecha = date('Y-m-d');
         $historial->dia =date('d');
         $historial->mes = date('m');
         $historial->year = date('Y');
         $historial->descripcion = 'El usuario '.\Auth::user()->name.' '.\Auth::user()->last_name.' Ha ingresado el aumento del saldo disponible para el trabajador : '.$personal->tx_nombres.' '.$personal->tx_apellidos.' por: '.$request->saldo_disponible.' USD';
         $historial->save();
        }


         \Alert::success('¡Bien hecho', 'Datos guardados satisfactoriamente');

          $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha modificado los datos del titular: '.$personal->tx_nombres.' '.$personal->tx_apellidos.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save();
             return redirect()->to('personal');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $personal = Personal::find($id);
          $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha eliminado los datos del titular: '.$personal->tx_nombres.' '.$personal->tx_apellidos.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id(); 
               $logs->save();
         $personal->delete();

         \Alert::success('¡Bien hecho', 'Dato eliminado satisfactoriamente');
          return redirect()->back();
    }

     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'tx_nombres' => ['required', 'max:255'],
            //'tx_apellidos' => ['required', 'max:255'],
            'cedula' => ['required', 'string', 'max:255', 'unique:personals'],
            //'saldo_disponible' => ['required', 'min:6', 'confirmed'],
            //'status' => ['required', 'string'],
            //'ente' => ['required'],
            //'gerencia_id' => ['required'],
        ]);
    }
}
