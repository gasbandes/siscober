<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use App\Models\Personal;
use Illuminate\Http\Request;

class BeneficiarioController extends Controller
{


     public function __construct()
    {
        $this->middleware('permission:Ver Beneficiario')->only('index');
        $this->middleware('permission:Registrar Beneficiario')->only('create');
        $this->middleware('permission:Registrar Beneficiario')->only('store');
        $this->middleware('permission:Editar Beneficiario')->only('edit');
        $this->middleware('permission:Editar Beneficiario')->only('update');
        $this->middleware('permission:Ver Beneficiario')->only('show');

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
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver datos de los beneficiaros ingresados al sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id();
          $logs->save();

        $titulares = Personal::with('entes')->get();
        //dd($titulares);
        return view('admin.beneficiario.index',compact('titulares'));
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado para crear nuevo beneficiario en el sistema,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id();
          $logs->save();

        $titulares = Personal::with('entes')->get();
        //dd($titulares);
        return view('admin.beneficiario.create',compact('titulares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listado()
    {
        return Beneficiario::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $edad = \Carbon\Carbon::parse($request->fe_nacimiento)->age;


        //$this->validator($request->all())->validate();
        //dd($request);



         $personal = Personal::where('id',$request->titular)->first();


           if ($request->nb_parentezco == 'Hijo(a)') {

                if ($edad >= 25 ) {

                    return json_encode(['false' => 'El beneficiario sobrepasa la edad correspondida'],500);

                }
                else
                {
                    $edad = \Carbon\Carbon::parse($request->fe_nacimiento)->age;

                    $beneficiario = new Beneficiario();

                    $beneficiario->nu_edad   = $edad;
                    $beneficiario->nb_parentezco  = $request->nb_parentezco;
                    $beneficiario->fe_nacimiento =  $request->fe_nacimiento;
                    $beneficiario->tx_nombres  = $request->tx_nombres;
                    $beneficiario->tx_apellidos  = $request->tx_apellidos;
                    $beneficiario->cedula  = $request->cedula;
                    $beneficiario->usuario_id  = \Auth::id();
                    $beneficiario->fecha_emision  =date('Y-m-d');
                    $beneficiario->status  = $request->status;
                    $beneficiario->ente =  $personal->ente;
                    $beneficiario->titular = $personal->tx_nombres.' '. $personal->tx_apellidos;
                    $beneficiario->save();


                   $logs = new \App\Models\Log();
                      $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
                      $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado nuevo beneficiario: '.$request->tx_nombres.' '.$request->tx_apellidos.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
                      $logs->usuario_id =\Auth::id();
                      $logs->save();

                   return json_encode(['success' => true]);
                }

           }
           else
           {
             $edad = \Carbon\Carbon::parse($request->fe_nacimiento)->age;

             $beneficiario = new Beneficiario();

             $beneficiario->nu_edad   = $edad;
             $beneficiario->nb_parentezco  = $request->nb_parentezco;
             $beneficiario->fe_nacimiento =  $request->fe_nacimiento;
             $beneficiario->tx_nombres  = $request->tx_nombres;
             $beneficiario->tx_apellidos  = $request->tx_apellidos;
             $beneficiario->cedula  = $request->cedula;
             $beneficiario->usuario_id  = \Auth::id();
             $beneficiario->fecha_emision  =date('Y-m-d');
             $beneficiario->status  = $request->status;
             $beneficiario->ente =  $personal->ente;
             $beneficiario->titular = $personal->tx_nombres.' '. $personal->tx_apellidos;
             $beneficiario->save();


            $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado nuevo beneficiario: '.$request->tx_nombres.' '.$request->tx_apellidos.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id();
               $logs->save();

            return json_encode(['success' => true]);
           }
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

        //dd($request);

         $beneficiario = \App\Models\Beneficiario::find($id);
         $beneficiario->tx_nombres = $request->tx_nombres;
         $beneficiario->tx_apellidos = $request->tx_apellidos;
         $beneficiario->cedula = $request->cedula;
         $beneficiario->fecha_emision = date('Y-m-d');
         $beneficiario->usuario_id = \Auth::id();
         $beneficiario->status = $request->status;
         $beneficiario->save();

          $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha modificado los datos del beneficiario: '.$request->tx_nombres.' '.$request->tx_apellidos.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
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
         $beneficiario = \App\Models\Beneficiario::find($id);
          $logs = new \App\Models\Log();
               $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
               $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha eliminado los datos del beneficiario: '.$beneficiario->tx_nombres.' '.$beneficiario->tx_apellidos.' en el sistema ,  a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
               $logs->usuario_id =\Auth::id();
               $logs->save();

         $beneficiario->delete();
         return json_encode(['success' => true]);
    }

      /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
            //'tx_nombres' => ['required', 'max:255'],
            //'tx_apellidos' => ['required', 'max:255'],
            'cedula' => ['required', 'string', 'max:255', 'unique:beneficiarios'],
            //'saldo_disponible' => ['required', 'min:6', 'confirmed'],
            //'status' => ['required', 'string'],
            //'ente' => ['required'],
            //'gerencia_id' => ['required'],
        ]);
    }
}
