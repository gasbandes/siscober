@extends('layouts.admin')
@section('title','Permisos')
@section('page_title', 'Listado de Permisos')
@section('contenido')
<div class="page-content">
    <div class="container-fluid">

  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <b>Nuevo permiso</b>
        </div>
        <div class="card-body">
          {!! Form::open(['route' => ['permission.store'],'method' => 'POST']) !!}
        @include('admin.permission.partials.input.form')

        <br><br>
        <button type="submit" class="btn blue darken-4 text-white">Guardar cambios</button>
         {!! Form::close()!!}
        </div>
      </div>
    </div>
      <div class="col-lg-6">
            <div class="card card-line-primary">
                <div class="card-header">
                  <p>Listado de permisos</p>
                </div>
                  <div class="card-body">
                    
                    <div class="table-responsive">
                      <table id="tableExport" class="display table table-striped table-hover" >
                        <thead>
                          <tr>
                           <th>#</th>
                            <th>Nombre completo</th>
                            <th>Opciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($permissions as $element)
                              <tr class="row{{ $element->id }}">
                              <td>{{ $element->id }}</td>
                              <td>{{ $element->name }}</td>
                              <td>
                                @can('Editar Permisos')
                                  <button type="button" class="btn btn-primary btn-circle " data-bs-toggle="modal" data-bs-target="#myModal{{ $element->id }}"><i class="mdi mdi-pencil mt-2 text-white" data-toggle="tooltip" data-placement="top"
                                title="Editar Permiso."></i></button>
                               @endcan
                                @can('Eliminar Permisos')
                                  <form action="{{ route('permission.destroy', $element->id) }}" method="POST"
                                  style="display: inline-block;" onsubmit="return confirm('¿Desea eliminar?')">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-circle btn-danger" type="submit" >
                                   <i class="mdi mdi-delete mt-2 text-white" data-toggle="tooltip" data-placement="top"
                                title="Eliminar Permiso."></i>
                                  </button>
                                </form>
                               @endcan
                                 
                              </td>
                              </tr>
                                @include('admin.permission.partials.modal.edit')

                              @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
        @include('admin.permission.partials.modal.create')
      </div>

@endsection
@push('scripts')
<script>
  $('#tableExport').DataTable({
   
    
    
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
            'copy', 'csv', 'excel', 'pdf', 'print','colvis'
        ]
  });
  
</script>
@endpush