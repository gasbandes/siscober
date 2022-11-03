<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"> 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
     <link rel="shortcut icon" href="{{ asset('assets/images/logo-bandes-mini-green.png') }}">
    <!-- General CSS Files -->
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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/system.css') }}" rel="stylesheet">
      
      @stack('styles')
  </head>

  
<body class="blue">
        
        @yield('content')

        
        <script type="text/javascript" src="{{asset('js/clock.js')}} "></script>
        <!-- end auth-page-wrapper -->
        
        
  </body>

</html>
