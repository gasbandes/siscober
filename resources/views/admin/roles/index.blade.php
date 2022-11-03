@extends('layouts.admin')
@section('title', 'Roles')
@section('contenido')
<!-- start page title -->
 @include('sweetalert::alert')
 <div class="page-content">
  <div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
        <div class="card card-line-primary">
          <div class="card-header card-header-primary">
           
            <p class="card-category">
              @can('Registrar Role')
            <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="zmdi zmdi-plus fa-1x"></i> Nuevo role</a>
            @endcan
            </p>
          </div>
          <div class="card-body">
          
            <div class="table-responsive">
              <table id="tableExport" class="table table-responsive-sm table-hover table-outline mb-0 table-sm" >
                <thead class="text-primary">
                  <th width="200"> ID </th>
                  <th> Nombre </th>
                  {{-- <th> Guard </th> --}}
                 
                  <th> Permisos </th>
                  <th class="text-right"> Acciones </th>
                </thead>
                <tbody>
                  @forelse ($roles as $role)
                  <tr>
                    <td width="200">{{ $role->id }}</td>
                    <td width="200" >{{ $role->name }}</td>
                    {{--<td>{{ $role->guard_name }}</td>
                     <td class="text-primary">{{ $role->created_at->toFormattedDateString() }}</td> --}}
                    <td>
                      @forelse ($role->permissions as $permission)
                          <span class="badge bg-info">{{ $permission->name }}</span>
                      @empty
                          <span class="badge bg-danger">Sin permisos asignados</span>
                      @endforelse
                    </td>
                    <td class="td-actions text-cente">
                  
                      <div class="dropdown">
                        <a href="#" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cog"></i> Opciones
                        </a>
                        <div class="dropdown-menu">
                           
                          @can('Editar Role')
                            <a href="{{ route('roles.edit', $role->id) }}" class="dropdown-item"> <i
                                class="mdi mdi-pencil"></i> Modificar registro </a>
                          @endcan
                          <div role="separator" class="dropdown-divider"></div>
                          @can('Eliminar Role')
                            <form action="{{ route('roles.destroy', $role->id) }}" method="post"
                              onsubmit="return confirm('areYouSure')" style="display: inline-block;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" rel="tooltip" class="dropdown-item">
                                <i class="mdi mdi-delete"></i>
                                Eliminar registros
                              </button>
                            </form>
                          @endcan
                        </div>
                    </div>
                    </td>
                  </tr>
                  @empty
                  
                  @endforelse
                </tbody>
              </table>
              {{-- {{ $users->links() }} --}}
            </div>
          </div>
         
        </div>
      </div>
    </div>
  </div>
</div>
   
@endsection
@push('scripts')
   <script>
      tablaModulos = $('#tableExport').DataTable({  
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
          'excel', 'pdf'
        ]
      });
    </script>
@endpush

