@extends('layouts.admin')
@section('title', 'Inicio')
@section('contenido')
 <div class="page-content">
     <div class="container-fluid">
     	<div class="row">
     		<div class="col-12">
     			<div class="card">
     				<div class="card-header">
     					<h4>Movimientos del saldo global.</h4>
     				</div>
     				<div class="card-body">
     					<table  class="table table-sm table-hover " id="tablaModulos">
                          <thead>
                          <tr> 
                          <th>#</th>
                          <th>Monto ($)</th>
                          <th>Fecha</th>    
                          <th>Descripción</th>                      
                          
                          </tr>

                          </thead>
                     </table>
     				</div>
     			</div>
     		</div>
     	</div>
    

    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection
@push('scripts')
<script >
	var user_id, opcion;
    opcion = 4;
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
    "ajax":{            
        "url": "{{ route('historialmontos.listado') }}", 
        "method": 'GET', //usamos el metodo POST
        "dataSrc":""
    },

    "columns":[
        {"data": "id"},
        {"data": "total"},
        {"data": "fecha"},
        {"data": "descripcion"},
        
       
      
    ]
});
</script>
@endpush