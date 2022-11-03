@extends('layouts.admin')
@section('title', 'Inicio')
@section('contenido')
 <div class="page-content">
   @include('sweetalert::alert')
            <div class="container-fluid">


                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="card text-center">
                            <div class="mb-2 card-body text-muted">
                                <h3 class="text-info mt-2">{{ $facpagada }}</h3> Facturas pagadas
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card text-center">
                            <div class="mb-2 card-body text-muted">
                                <h3 class="text-purple mt-2">{{ $facpendiente }}</h3> Facturas pendientes
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card text-center">
                            <div class="mb-2 card-body text-muted">
                                <h3 class="red-text mt-2">{{ $faccancelada }}</h3> Facturas canceladas
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <div class="card text-center">
                            <div class="mb-2 card-body text-muted">
                                <h3 class="blue-text  mt-2">{{ $reempagada }}</h3> Reembolsos efectuados
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card text-center">
                            <div class="mb-2 card-body text-muted">
                                <h3 class="green-text mt-2">{{ $reempendiente }}</h3> Reembolsos pendientes
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card text-center">
                            <div class="mb-2 card-body text-muted">
                                <h3 class="red-text mt-2">{{ $reemcancelada }}</h3> Reembolsos cancelados
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- end row -->

              @if (\Auth::user()->hasRole('Seguridad') || \Auth::user()->hasRole('Tecnologia') || \Auth::user()->hasRole('Verificador') )
                  <div class="row">

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Márgen de facturas y reembolsos efecutados en el {{ date('Y') }}</h4>

                                @php
                                     
                                     
                                     $reembolso  = \App\Models\Reembolso::where('status',1)
                                                                            ->where('year',date('Y'))
                                                                            ->sum('monto_pagado');

                                     $factura    = \App\Models\Factura::where('status',1)
                                                                            ->where('year',date('Y'))
                                                                            ->sum('total_dolar');
                                @endphp

                                <div class="row text-center mt-4">
                                    <div class="col-6">
                                        <h5 class="mb-2 font-size-18">{{ number_format($factura ,2)  }} USD</h5>
                                        <p class="text-muted text-truncate">Facturas</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-2 font-size-18">{{ number_format($reembolso,2)  }} USD</h5>
                                        <p class="text-muted text-truncate">Reembolsos</p>
                                    </div>
                                </div>

                                <div id="morris-donut-example" class="morris-charts morris-chart-height"></div>
                            </div>
                        </div>
                    </div>

                   
                

                </div>
                 @php
                        $facturas   = App\Models\Factura::orderBy('id','DESC')->get();
                        $reembolsos = App\Models\Reembolso::orderBy('id','DESC')->get();
                    @endphp
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                         <label for="">Tipo de búsqueda</label><br>
                          <form action="{{ url('buscar/facturas') }}" method="POST">
                            
                            @csrf
                            
                        <div class="input-group">

                            <select name="tipo_busqueda_factura" id="tipo_busqueda_factura" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">Por rango de fecha</option>
                                <option value="2">Por mes</option>
                            </select>
                          
                                <input type="date" name="from_factura" id="from_factura" class="form-control" hidden>
                                <input type="date" name="to_factura" id="to_factura" class="form-control" hidden>

                                <select name="mes_factura" id="buscar_mes_factura" class="form-control" hidden>
                                    <option value="01">ENERO</option>
                                    <option value="02">FEBRERO</option>
                                    <option value="03">MARZO</option>
                                    <option value="04">ABRIL</option>
                                    <option value="05">MAYO</option>
                                    <option value="06">JUNIO</option>
                                    <option value="07">JULIO</option>
                                    <option value="08">AGOSTO</option>
                                    <option value="09">SEPTIEMBRE</option>
                                    <option value="10">OCTUBRE</option>
                                    <option value="11">NOVIEMBRE</option>
                                    <option value="12">DICIEMBRE</option>
                                </select>

                                <button type="submit" class="btn btn-primary" hidden id="button_factura"><i class="mdi mdi-account-search"></i></button>
                           
                        </div>
                        </form>
                        <br>
                        @if ($busqueda)
                            <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Facturas cargadas en el sistema</h4>

                                <div class="table-responsive">
                                    <table class="table mt-4 mb-0 table-centered table-nowrap" id="tablaFacturas">
                                       <thead>
                                        <tr>
                                            <th>Fecha de factura</th>
                                            <th>Ente</th>
                                            <th>N° Factura</th>
                                            <th>N° Control</th> 
                                            <th>Monto Pagado</th>
                                            <th>Monto Divisa</th>
                                            <th>Estado</th>
                                            <th></th>

                                        </tr> 
                                         </thead>  
                                        <tbody>
                                           @foreach ($factura_busqueda as $element)
                                                <tr>
                                                    <td>
                                                        {!! date('d-m-Y', strtotime($element->fecha_factura)) !!} 
                                                    </td>
                                                    <td>
                                                        {{ $element->titular->ente }}
                                                     </td>
                                                     <td>
                                                        {{ $element->nu_factura }}
                                                    </td>
                                                    <td>
                                                        {{ $element->nu_control }}
                                                    </td>
                                                    <td>
                                                        {{ number_format( $element->monto_pagado) }} BS
                                                    </td>
                                                    <td>
                                                        {{  $element->total_dolar }} USD
                                                    </td>
                                                     <td>
                                                     @if ($element->status == 1)
                                                        <span class="badge bg-primary">PAGADO</span>
                                                     @elseif ($element->status == 2)
                                                        <span class="badge bg-info">PENDIENTE</span>
                                                     @else
                                                        <span class="badge bg-danger">ANULADO</span>
                                                     @endif
                                                  </td>
                                                   <td>
                                                     @if ($element->status == 1)
                                                      <a href="{{ url('facturas',[$element->id,'edit']) }}" class="btn btn-round btn-info"><i class="mdi mdi-pencil"></i></a>
                                                       @elseif ($element->status == 2)
                                                     <div class="btn-group">
                                                       <a href="{{ url('facturas',[$element->id,'edit']) }}" class="btn btn-rounded btn-info"><i class="mdi mdi-pencil"></i></a>

                                                     </div>
                                                     @else
                                                         <a href="{{ url('facturas',[$element->id,'edit']) }}" class="btn btn-round btn-info"><i class="mdi mdi-pencil"></i></a>
                                                     @endif
                                                  </td>
                                                 </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="card">

                            <div class="card-body">
                                <h4 class="card-title mb-4">Facturas cargadas en el sistema</h4>

                                <div class="table-responsive">
                                    <table class="table mt-4 mb-0 table-centered table-nowrap" id="tablaFacturas">
                                       <thead>
                                        <tr>
                                            <th>Fecha de factura</th>
                                            <th>Ente</th>
                                            <th>N° Factura</th>
                                            <th>N° Control</th> 
                                            <th>Monto Pagado</th>
                                            <th>Monto Divisa</th>
                                            <th>Estado</th>
                                            <th></th>

                                        </tr> 
                                         </thead>  
                                        <tbody>
                                           @foreach ($facturas as $element)
                                                <tr>
                                                    <td>
                                                        {!! date('d-m-Y', strtotime($element->fecha_factura)) !!} 
                                                    </td>
                                                    <td>
                                                        {{ $element->titular->ente }}
                                                     </td>
                                                     <td>
                                                        {{ $element->nu_factura }}
                                                    </td>
                                                    <td>
                                                        {{ $element->nu_control }}
                                                    </td>
                                                    <td>
                                                        {{ number_format( $element->monto_pagado) }} BS
                                                    </td>
                                                    <td>
                                                         {{  $element->total_dolar }} USD
                                                    </td>
                                                     <td>
                                                     @if ($element->status == 1)
                                                        <span class="badge bg-primary">PAGADO</span>
                                                     @elseif ($element->status == 2)
                                                        <span class="badge bg-info">PENDIENTE</span>
                                                     @else
                                                        <span class="badge bg-danger">ANULADO</span>
                                                     @endif
                                                  </td>
                                                  <td>
                                                     @if ($element->status == 1)
                                                      <a href="{{ url('facturas',[$element->id,'edit']) }}" class="btn btn-round btn-info"><i class="mdi mdi-pencil"></i></a>
                                                       @elseif ($element->status == 2)
                                                     <div class="btn-group">
                                                       <a href="{{ url('facturas',[$element->id,'edit']) }}" class="btn btn-rounded btn-info"><i class="mdi mdi-pencil"></i></a>

                                                     </div>
                                                     @else
                                                         <a href="{{ url('facturas',[$element->id,'edit']) }}" class="btn btn-round btn-info"><i class="mdi mdi-pencil"></i></a>
                                                     @endif
                                                  </td>

                                                </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-6">
                         <label for="">Tipo de búsqueda</label><br>
                         <form action="{{ url('buscar/facturas') }}" method="POST">
                            
                            @csrf
                            
                        <div class="input-group">

                            <select name="tipo_busqueda_reembolso" id="tipo_busqueda_reembolso" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">Por rango de fecha</option>
                                <option value="2">Por mes</option>
                            </select>
                          
                                <input type="date" name="from_reembolso" id="from_reembolso" class="form-control" hidden>
                                <input type="date" name="to_reembolso" id="to_reembolso" class="form-control" hidden>

                                <select name="mes_reembolso" id="buscar_mes_reembolso" class="form-control" hidden>
                                    <option value="01">ENERO</option>
                                    <option value="02">FEBRERO</option>
                                    <option value="03">MARZO</option>
                                    <option value="04">ABRIL</option>
                                    <option value="05">MAYO</option>
                                    <option value="06">JUNIO</option>
                                    <option value="07">JULIO</option>
                                    <option value="08">AGOSTO</option>
                                    <option value="09">SEPTIEMBRE</option>
                                    <option value="10">OCTUBRE</option>
                                    <option value="11">NOVIEMBRE</option>
                                    <option value="12">DICIEMBRE</option>
                                </select>

                                <button type="submit" class="btn btn-primary" hidden id="button_reembolso"><i class="mdi mdi-account-search"></i></button>
                           
                        </div>
                        </form><br>
                        @if ($busqueda_reembolso)
                            <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Reembolsos cargados en el sistema</h4>

                                <div class="table-responsive">
                                    <table class="table mt-4 mb-0 table-centered table-nowrap" id="tablaReembolsos">
                                       <thead>
                                        <tr>
                                            <th>Fecha de factura</th>
                                            <th>Ente</th>
                                            <th>N° Factura</th>
                                            <th>N° Control</th> 
                                            <th>Monto Pagado</th>
                                            <th>Monto Divisa</th>
                                            <th>Estado</th>

                                        </tr> 
                                         </thead>  
                                        <tbody>
                                           @foreach ($reembolso_busqueda as $element)
                                                <tr>
                                                    <td>
                                                        {!! date('d-m-Y', strtotime($element->fecha_factura)) !!} 
                                                    </td>
                                                    <td>
                                                        {{ $element->titular->ente }}
                                                     </td>
                                                     <td>
                                                        {{ $element->nu_factura }}
                                                    </td>
                                                    <td>
                                                        {{ $element->nu_control }}
                                                    </td>
                                                    <td>
                                                        {{ number_format( $element->monto_pagado) }} BS
                                                    </td>
                                                    <td>
                                                         {{  $element->total_dolar }} USD
                                                    </td>
                                                     <td>
                                                     @if ($element->status == 1)
                                                        <span class="badge bg-primary">PAGADO</span>
                                                     @elseif ($element->status == 2)
                                                        <span class="badge bg-info">PENDIENTE</span>
                                                     @else
                                                        <span class="badge bg-danger">ANULADO</span>
                                                     @endif
                                                  </td>
                                                </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @else
                         <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Reembolsos cargados en el sistema</h4>

                                <div class="table-responsive">
                                    <table class="table mt-4 mb-0 table-centered table-nowrap" id="tablaReembolsos">
                                       <thead>
                                        <tr>
                                            <th>Fecha de factura</th>
                                            <th>Ente</th>
                                            <th>N° Factura</th>
                                            <th>N° Control</th> 
                                            <th>Monto Pagado</th>
                                            <th>Monto Divisa</th>
                                            <th>Estado</th>

                                        </tr> 
                                         </thead>  
                                        <tbody>
                                           @foreach ($reembolsos as $element)
                                                <tr>
                                                    <td>
                                                        {!! date('d-m-Y', strtotime($element->fecha_factura)) !!} 
                                                    </td>
                                                    <td>
                                                        {{ $element->titular->ente }}
                                                     </td>
                                                     <td>
                                                        {{ $element->nu_factura }}
                                                    </td>
                                                    <td>
                                                        {{ $element->nu_control }}
                                                    </td>
                                                    <td>
                                                        {{ number_format( $element->monto_pagado) }} BS
                                                    </td>
                                                    <td>
                                                         {{  $element->total_dolar }} USD
                                                    </td>
                                                     <td>
                                                     @if ($element->status == 1)
                                                        <span class="badge bg-primary">PAGADO</span>
                                                     @elseif ($element->status == 2)
                                                        <span class="badge bg-info">PENDIENTE</span>
                                                     @else
                                                        <span class="badge bg-danger">ANULADO</span>
                                                     @endif
                                                  </td>
                                                </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                   

                </div>
                <!-- end row -->
              @endif


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
@endsection
@push('scripts')
    <script>
      
    var user_id, opcion;
    opcion = 4;
    tablaModulos =  $('#tablaFacturas').DataTable({ 
       language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
            },
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
        },
        dom: 'Bfrtip',
         responsive:false,
         lengthChange: true,
         pageLength: 4,
         buttons: [
            'excel', 'pdf', 'print'
        ],
});
    </script>
    <script>
      
    var user_id, opcion;
    opcion = 4;
    tablaModulos =  $('#tablaReembolsos').DataTable({ 
       language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
            },
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
        },
        dom: 'Bfrtip',
         responsive:false,
         lengthChange: true,
          pageLength: 4,
         buttons: [
            'excel', 'pdf', 'print'
        ],
});
    </script>
<script>
      $("#tipo_busqueda_factura").on( 'change', function(e) {
              
            if (e.target.value == 1 ) {

              $('#from_factura').removeAttr('hidden');
              $('#to_factura').removeAttr('hidden');
              $('#button_factura').removeAttr('hidden');
              
            }
            else
            {
               $('#from_factura').attr('hidden', 'hidden');
               $('#to_factura').attr('hidden', 'hidden');
               $('#button_factura').attr('hidden', 'hidden');
             
            }
        });

         $("#tipo_busqueda_factura").on( 'change', function(e) {
              
            if (e.target.value == 2 ) {

              $('#buscar_mes_factura').removeAttr('hidden');
              $('#button_factura').removeAttr('hidden');
              
            }
            else
            {
               $('#buscar_mes_factura').attr('hidden', 'hidden');
              
             
            }
        });
</script>
<script>
      $("#tipo_busqueda_reembolso").on( 'change', function(e) {
              
            if (e.target.value == 1 ) {

              $('#from_reembolso').removeAttr('hidden');
              $('#to_reembolso').removeAttr('hidden');
              $('#button_reembolso').removeAttr('hidden');
              
            }
            else
            {
               $('#from_reembolso').attr('hidden', 'hidden');
               $('#to_reembolso').attr('hidden', 'hidden');
               $('#button_reembolso').attr('hidden', 'hidden');
             
            }
        });

         $("#tipo_busqueda_reembolso").on( 'change', function(e) {
              
            if (e.target.value == 2 ) {

              $('#buscar_mes_reembolso').removeAttr('hidden');
              $('#button_reembolso').removeAttr('hidden');
              
            }
            else
            {
               $('#buscar_mes_reembolso').attr('hidden', 'hidden');
              
             
            }
        });
</script>
@endpush

