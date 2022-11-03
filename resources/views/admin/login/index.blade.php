@extends('layouts.admin')
@section('title', 'LOGINS')
@section('page_title', 'LOGINS')
@section('contenido')
<div class="page-content">
     <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-line-primary">
              <div class="card-header  ">
                <h5 >Listado de inicio de sesión</h5>
               
              </div>
               <!-- /.card-header -->
                  <div class="card-body table-responsive">
                       
                  <table  class=" table table-striped table-sm" style="width:100%" id="tablaModulos">
                      <thead>
                      <tr>
                      <th>#</th>
                       <th>Usuario</th>
                      <th>Inicio</th>
                      <th>Cierre</th>
                      <th>IP</th>
                      <th>Cliente</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach ($logins as $login)
                      <tr class="row{{ $login->id }}">
                      <td>{{ $login->id }}</td>
                      <td>{{ $login->user->display_name }}</td>
                      <td>{{ $login->login_at  }}</td>
                      <td>{{ $login->logout_at }}</td>
                      <td>{{ $login->ip_address }}</td>
                      <td>{{ $login->user_agent }}</td>
                      </tr>
                      @endforeach
                      </tr>
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
<script type="text/javascript">
     tablaModulos =  $('#tablaModulos').DataTable({ 
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
         responsive:true,
         lengthChange: true,
         buttons: [
            'excel', 'pdf', 'print'
        ],
    });

</script>
@endpush