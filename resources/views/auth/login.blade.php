@extends('layouts/adminfront')

@section('title', 'Login Page')

@section('content')
@php
$mytime = Carbon\Carbon::now('America/Caracas');
$fecha=$mytime->format('Y-m-d');

$today = getdate();
$data_month = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
//$config = \DB::table('configuraciones')->first();
$current_month = $today['mon'];
$current_year = $today['year'];
$mes_actual =$data_month[$current_month - 1];
//dd($mes_actual);

$nombre_dia = date('w');
switch($nombre_dia)
{
    case 1: $nombre_dia="Lunes";
    break;
    case 2: $nombre_dia="Martes";
    break;
    case 3: $nombre_dia="Miercoles";
    break;
    case 4: $nombre_dia="Jueves";
    break;
    case 5: $nombre_dia="Viernes";
    break;
    case 6: $nombre_dia="Sabado";
    break;
}

@endphp
  <div class="auth-wrapper auth-v3 ">

    <div class="auth-content">
        <div class="card">
            <div class="row align-items-stretch ">
                <div class="col-md-6 img-card-side">
                    <img src="{{ asset('assets/images/auth-img-3.jpg') }}" alt="" class="img-fluid">
                    <div class="img-card-side-content">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                       <div>
                            <h5 class="text-primary">¡Bienvenidos!</h5>
                            <p class="text-muted">Ingresa tu usuario y contraseña para continuar.</p>
                        </div>
                        <form class="auth-login-form mt-2"
                          method="POST"
                        </div>
                        <form class="auth-login-form mt-2"
                          method="POST"
                          action="{{ route('login') }}"
                          autocomplete="off">
                          @csrf
                          <div >

                                  <div class="">
                                      <label for="username" class="form-label">Usuario</label>
                                     <input
                                     type="text"
                                     class="form-control
                                      @error('username') is-invalid
                                      @enderror"
                                      id="login-username"
                                      name="username"
                                      placeholder="Ingrese su usuario"
                                      aria-describedby="login-username"
                                      tabindex="1"
                                      autofocus>
                                  </div>

                                  <div class=" mt-2">

                                      <label for="password-input">Contraseña</label>
                                      <div class="position-relative auth-pass-inputgroup mb-3">
                                          <input
                                           type="password"
                                           class="form-control
                                            @error('password') is-invalid
                                            @enderror"
                                            id="login-password"
                                            name="password"
                                            placeholder="Ingresa la contraseña"
                                            aria-describedby="login-password"
                                            tabindex="1"
                                            autofocus>


                                  </div>




                                  <div class="mt-3">
                                      <div class="row">
                                        <div class="col-sm-12">
                                         <button class="btn btn-primary w-lg waves-effect waves-light"  type="submit">Ingresar</button>
                                        </div>
                                      </div>
                                  </div>

                                  <div class="   text-center">


                                  <div class="   text-center">


                                      <div class="text-center mt-5 mb-4 ">
                                        <span id="weekDay" class="weekDay">
                                            {{ $nombre_dia }}
                                        </span>,
                                        </span>,
                                        <span id="day" class="day"></span> de
                                        <span id="month" class="month">
                                            {{ $mes_actual }}
                                        </span> del
                                        <span id="year" class="year">
                                            {{ date('Y') }}
                                        </span> ,
                                        <span id="hours" class="hours"></span> :
                                        <span id="minutes" class="minutes"></span> :
                                        <span id="seconds" class="seconds"></span>
                                      </div>

                                  </div>


                              </form>


                         </form>
                    </div>


                              </form>


                         </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
   <!-- Sweet Alerts js -->
        <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
         <script>
          @if(Session::has('error'))
            alert(1);
          @endif
     </script>

@endsection
@section('styles')
    <!-- Sweet Alert css-->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
