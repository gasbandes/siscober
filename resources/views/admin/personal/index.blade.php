@extends('layouts.admin')

@section('title', 'Personal')
@section('page_title', 'Personal del banco')
@section('contenido')
 <div class="page-content">
    @include('sweetalert::alert')
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
    <div class="card card-line-primary">
      <div class="card-header">
        <h3>Listado del personal actualmente registrado.</h3>
       </div>
       <!-- /.card-header -->
          <div class="card-body table-responsive">
               <ul class="list-inline">
             <li class="list-inline-item">
                <a href="/" class="link_ruta">
                  Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>
              </li>
             <li class="list-inline-item">
                <a href="/personal" class="link_ruta">
                  Listado &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a  href="{{ url('personal/create') }}" class="btn btn-sm green darken-3 text-white"><i class="mdi mdi-plus mt-2 text-white" data-toggle="tooltip" data-placement="top"
                      title="Registro de nuevo empleado."></i>Nuevo empleado</a>
              </li>

            </ul><br>
          <table id="tableExport" class="display table table-hover table-responsive-sm ">
                    <thead>
                    <tr>
                    <th>#</th>
                    <th>Empleado</th>
                    <th>Cédula</th>
                    <th>Ente</th>
                    <th>Gerencia</th>
                    <th>Estado del empleado</th>
                    <th>Saldo Consumido</th>
                    <th>Saldo disponible</th>

                    <th></th>
                    <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($personales as $personal)
                    <tr class="row{{ $personal->id }}">
                    <td>{{ $personal->id }}</td>
                    <td>{{ $personal->display_name }}</td>
                    <td>{{ $personal->cedula }}</td>
                    <td>{{ $personal->ente }}</td>
                    <td>{{ $personal->gerencia->name }}</td>

                     <td>

                        @if ($personal->status == 1)
                          <span class="badge green text-white"> Activo</span>
                        @elseif ($personal->status == 2)
                          <span class="badge blue  darken-4 text-white"> Jubilado</span>
                        @elseif ($personal->status == 3)
                          <span class="badge red  darken-4 text-white"> SUSPENDIDO</span>
                        @endif

                    </td>
                    <td> {{number_format($personal->saldo_consumido,2)}}$ </td>
                    <td> {{number_format($personal->saldo_disponible,2)}}$ </td>
                    <td>
                       <a href="{{ url('personal', [$personal->id, 'edit']) }}"  class="btn btn-circle green darken-3"><i class="mdi mdi-pencil mt-2 text-white" data-toggle="tooltip" data-placement="top"
                      title="Editar datos del empleado."></a>

                    </td>
                    <td>
                      <a href="{{ url('personal', [$personal->id, 'delete']) }}"  class="btn btn-circle green darken-3"><i class="mdi mdi-delete mt-2 text-white" data-toggle="tooltip" data-placement="top"
                      title="Borrar datos del empleado."></i></a>
                    </td>
                    </tr>

                    @endforeach

                    </tbody>
                </table>
          </div>
          <!-- /.card-body -->

      </div>
  </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
 <script>
   $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
 </script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
    });
</script>

<script>
  $(document).ready(function () {
  $('#tableExport').DataTable({

    dom: 'Bfrtip',
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ],
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
            }
        }
  });

});
</script>

@endpush
@push('scripts')
   <!-- Sweet Alerts js -->
        <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
         <script>
          @if(Session::has('error'))
            alert(1);
          @endif
     </script>

@endpush
@push('styles')
    <!-- Sweet Alert css-->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
