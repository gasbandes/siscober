<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
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
          $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha ingresado a ver los usuarios '. 'a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        $usuarios = \App\Models\User::get();
        $roles    = \Spatie\Permission\Models\Role::get();
        return view('admin.usuarios.index',compact('usuarios','roles'));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listado()
    {
        $usuarios = \App\Models\User::get();
        
        return $usuarios;
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
        //dd($request);

        $user = \App\Models\User::create($request->except('role'));

        if ($request->has('role'))
        {
            $user->assignRole($request->role);
        }


         $logs = new \App\Models\Log();
         $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
         $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha cargado a '.$request->name.' '.$request->last_name .' entre los usuarios del sistema '. 'a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        return json_encode(['success' => true, 'user_id' => $user->id]);
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
        $user = \App\Models\User::find($id);
        $user->update($request->except('role'));

        if ($request->has('role'))
        {
            $user->syncRoles($request->role);
        }

        $logs = new \App\Models\Log();
        $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
        $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha modificado los datos del usuario: '.$request->name.' '.$request->last_name .' entre los usuarios del sistema '. 'a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

        return json_encode(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      

         $user = \App\Models\User::find($id);

          $logs = new \App\Models\Log();
          $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
          $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha  eliminado al usuario: '.$user->name.' '.$user->last_name .' entre los usuarios del sistema '. 'a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
          $logs->usuario_id =\Auth::id(); 
          $logs->save();

         $user->delete();
         return json_encode(['success' => true]);
    }
}
