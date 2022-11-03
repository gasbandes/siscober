<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Log;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


<<<<<<< HEAD
=======

    public function username()

    {
        return 'username';
    }
>>>>>>> b75ec073 (integracion general)
     public function login(Request $request)
    {
         $this->validateLogin($request);



        if(\Auth::attempt($request->only('username','password')))
        {

            $logs = new Log();
            $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
            $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha iniciado sesión '. 'a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
<<<<<<< HEAD
            $logs->usuario_id =\Auth::id(); 
=======
            $logs->usuario_id =\Auth::id();
>>>>>>> b75ec073 (integracion general)
            $logs->save();


        Alert::success('¡Bien hecho', 'Bienvenido: '.\Auth::user()->display_name );
        return redirect('/');
        }
         Alert::error('¡Algo salió mal!', 'Los datos ingresados no son los correctos.');
        return back();

<<<<<<< HEAD
    } 
=======
    }
>>>>>>> b75ec073 (integracion general)


     /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {

        $logs = new Log();
            $logs->fecha_registro = date('Y-m-d H').' ' . now()->isoFormat('H:mm:ss A');
            $logs->name = 'El usuario '.\Auth::user()->name.' '. \Auth::user()->last_name.' Ha cerrado sesión '. 'a las '.now()->isoFormat('H:mm:ss A'). ' del día '. date('d-m-Y');
<<<<<<< HEAD
            $logs->usuario_id =\Auth::id(); 
            $logs->save();
        
=======
            $logs->usuario_id =\Auth::id();
            $logs->save();

>>>>>>> b75ec073 (integracion general)
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }


<<<<<<< HEAD
            
=======

>>>>>>> b75ec073 (integracion general)
        Alert::success('¡Bien hecho!', 'Ha cerrado sesión satisfactoriamente.');
        return  redirect('/login');
    }
}
