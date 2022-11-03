@extends('layouts.admin')
@section('title', 'Reembolsos')
@section('contenido')
<!-- start page title -->
<div class="page-content">
     @include('sweetalert::alert')
       <div class="container-fluid">
  	  
            
            <div class="row">
            <div class="col-lg-12">
              <div class="card">

              <div class="card-header">
                Listado de reembolsos
                <a href="{{ url('reembolsos/create') }}" class="btn btn-primary" style="float: right !important;"><i class="mdi mdi-plus"></i> Registrar nuevo reembolso</a>
              </div>
              <div class="card-body table-responsive ">
                 
                    <table  class="table table-hover table-lg " id="tablaModulos">
                    <thead>
                      <tr> 
                      <th>#</th>
                      <th>Fecha de factura</th>
                      <th>Ente</th>
                      <th>N° Factura</th>
                      <th>N° Control</th>
                      <th>Proveedor</th>
                      <th>Titular</th>
                      <th>C.I</th>
                      <th>Beneficiario</th>
                      <th>C.I</th>
                      <th>Base Imponible</th>
                      <th>IVA</th>
                      <th>Monto Total</th>
                      <th>Monto Pagado</th>
                      <th>Monto Pagado ($)</th>
                      <th>Estado</th>
                      <th></th>
                      </tr>
                    </thead>
                        <tbody>
                          @foreach ($reembolsos as $element)
                            <tr>
                              <td>
                                {{ $element->id }}
                              </td>
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
                                {{ $element->proveedor->razon_social }}
                              </td>
                              <td>
                                {{ $element->titular->tx_nombres.' '. $element->titular->tx_apellidos }}
                              </td>
                               <td>
                                {{ $element->titular->cedula }}
                              </td>
                               <td>
                                @if ($element->titular_beneficiario <>NULL )
                                  {{ $element->titular->tx_nombres.' '. $element->titular->tx_apellidos }}
                                  @else
                                   {{ $element->beneficiario->tx_nombres.' '. $element->beneficiario->tx_apellidos }}
                                @endif
                              </td>
                               <td>
                                  @if ($element->titular_beneficiario <>NULL )
                                  {{ $element->titular->cedula }}
                                  @else
                                    {{ $element->beneficiario->cedula }}
                                @endif
                              </td>
                              
                               <td>
                                {{ number_format( $element->base_importe) }} BS
                              </td>
                               <td>
                                {{ number_format( $element->iva) }} BS
                              </td>
                               <td>
                                {{ number_format( $element->monto_pagado) }} BS
                              </td>
                              <td>
                                {{ number_format( $element->total_factura) }} BS
                              </td>
                              <td>
                                {{ number_format( $element->total_dolar) }} USD
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
                                  <a href="{{ url('reembolsos',[$element->id,'edit']) }}" class="btn btn-round btn-info"><i class="mdi mdi-pencil"></i></a>
                                   @elseif ($element->status == 2)
                                 <div class="btn-group">
                                   <a href="{{ url('reembolsos',[$element->id,'edit']) }}" class="btn btn-rounded btn-info"><i class="mdi mdi-pencil"></i></a>

                                 </div>
                                 @else
                                     <a href="{{ url('reembolsos',[$element->id,'edit']) }}" class="btn btn-round btn-info"><i class="mdi mdi-pencil"></i></a>
                                 @endif
                               </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                 
                </div>  
              </div>
            </div>
           
      </div>
    </div>
  </div>
</div>
@include('admin.factura.partials.modal.edit')
<!-- end page title -->
@endsection
@push('styles')
 <!-- gridjs css -->
 <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
 
@endpush
@push('scripts')
 <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-green ',
          radioClass: 'iradio_square-green mt-1',
          increaseArea: '20%' // optional
        });
      });
    </script>
  <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
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
         responsive:false,
         lengthChange: true,
         pageLength: 3,
         buttons: [
            'excel', 'pdf', 'print'
        ],
});
    var fila; //captura la fila, para editar o eliminar
//Editar        
$(document).on("click", ".btnEditar", function(){           
    opcion = 2;//editar
    fila = $(this).closest("tr");   

    user_id  = parseInt(fila.find('td:eq(0)').text()); //capturo el ID               
    titular   = fila.find('td:eq(1)').text();
    nombre   = fila.find('td:eq(3)').text();
    apellido = fila.find('td:eq(4)').text();
    cedula  = fila.find('td:eq(5)').text();
    emailInput  = fila.find('td:eq(4)').text();
    //status = parseInt(fila.find('td:eq(4)').text());
  

    $("#titular_form").val(titular);
    $("#tx_nombres_titular").val(nombre);
    $("#tx_apellidos_titular").val(apellido);
    $("#nu_cedula_titular").val(cedula);
    $("#emailInput").val(emailInput);
    $(".modal-title").text("Edición de Usuarios");   
    $('#ModulosEdit').modal('show');       
});

var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización
$('#main-form').submit(function(e){                        
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    name = $.trim($('#tx_nombres_titular').val());    
    last_name = $.trim($('#tx_apellidos').val());
    status = $.trim($('#nu_cedula').val());
    username = $.trim($('#usuario').val());
    codigo = $.trim($('#txtCodigo').val());  
    var data = $('#main-form').serialize();        
    $('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');             
    $.ajax({
         url: "/beneficiario/" + user_id,
          headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
          type: "PUT",
          datatype:"json",  
          cache: false,  
          data:  data, 
        success: function (response) {
          var json = $.parseJSON(response);
          if(json.success){
            $('#main-form #edit-button').removeClass('hide');
            tablaModulos.ajax.reload(null, false);
             var timerInterval;
                  Swal.fire({
                    title: '¡Datos actualizados!',
                    type: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading();
                      timerInterval = setInterval(() => {
                        const content = Swal.getHtmlContainer();
                        if (content) {
                          const b = content.querySelector('b');
                          if (b) {
                            b.textContent = Swal.getTimerLeft();
                          }
                        }
                      }, 100);
                    },
                    willClose: () => {
                      clearInterval(timerInterval);
                    }
                  }).then(result => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                      console.log('I was closed by the timer');
                    }
                  });
          }
        },error: function (data) {
          var errors = data.responseJSON;
          $.each( errors.errors, function( key, value ) {
            toastr.error(value);
            return false;
          });
          $('input').iCheck('enable');
          $('#main-form input, #main-form button').removeAttr('disabled');
          $('#ajax-icon').removeClass('fas fa-spin fa-sync-alt').addClass('far fa-save');
        }
     });        
    $('#ModulosEdit').modal('hide');                                
});

</script>
  <script>
    $('#edit-button').hide();
    $('#proveedores-form').submit(function(){

         $('.missing_alert').css('display', 'none');

        if ($('#proveedores-form #tx_nombres').val() === '') {
            $('#proveedores-form #tx_nombres_alert').text('Ingrese el nombre del beneficiario.').show();
            $('#proveedores-form #tx_nombres').addClass('is-invalid')
            $('#proveedores-form #tx_nombres').focus();
            return false;
        }


        if ($('#proveedores-form #tx_apellidos').val() === '') {
            $('#proveedores-form #tx_apellidos_alert').text('Ingrese el apellido del beneficiario').show();
            $('#proveedores-form #tx_apellidos').addClass('is-invalid');
            $('#proveedores-form #tx_apellidos').focus();
            return false;
        }

         if ($('#proveedores-form #nu_cedula').val() === '') {
            $('#proveedores-form #nu_cedula_alert').text('Ingrese la cédula del beneficiario').show();
            $('#proveedores-form #nu_cedula').addClass('is-invalid');
            $('#proveedores-form #nu_cedula').focus();
            return false;
        }
       

        var data = $('#proveedores-form').serialize();
        //$('input').iCheck('disable');
        //$('#proveedores-form input, #proveedores-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');


       
            $.ajax({
              url: $('#proveedores-form #_url').val(),
              headers: {'X-CSRF-TOKEN': $('#proveedores-form #_token').val()},
              type: 'POST',
              cache: false,
              data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  $('#proveedores-form #tx_nombres').val('');
                  $('#proveedores-form #tx_apellidos').val('');
                  $('#proveedores-form #nu_cedula').val('');
                  tablaModulos.ajax.reload(null, false);
                  var timerInterval;
                  Swal.fire({
                    title: '¡Datos ingresados!',
                    type: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading();
                      timerInterval = setInterval(() => {
                        const content = Swal.getHtmlContainer();
                        if (content) {
                          const b = content.querySelector('b');
                          if (b) {
                            b.textContent = Swal.getTimerLeft();
                          }
                        }
                      }, 100);
                    },
                    willClose: () => {
                      clearInterval(timerInterval);
                    }
                  }).then(result => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                      console.log('I was closed by the timer');
                    }
                  });
                  $('#descripcion').val('');
                  $('#precio').val('');
                  $('#status').val('');
                  $('#ajax-icon').removeClass('fas fa-spin fa-sync-alt').addClass('far fa-save');
                   //Define la cantidad de numeros aleatorios.
                    var cantidadNumeros = 8;
                    var myArray = []
                    while(myArray.length < cantidadNumeros ){
                      var numeroAleatorio = Math.ceil(Math.random()*cantidadNumeros);
                      var existe = false;
                      for(var i=0;i<myArray.length;i++){
                        if(myArray [i] == numeroAleatorio){
                            existe = true;
                            break;
                        }
                      }
                      if(!existe){
                        myArray[myArray.length] = numeroAleatorio;
                      }

                    }
                    var codigo = myArray.join("") +'-'+'2';

                    $('#txtCodigo').val(codigo)
                     console.log(myArray.join("") +'-'+'2' );

                  
                   
               }
              },error: function (data) {
                var errors = data.responseJSON;
                $.each( errors.errors, function( key, value ) {
                   var timerInterval;
                  Swal.fire({
                    title: '¡No se admiten datos duplicados!',
                    type: 'error',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading();
                      timerInterval = setInterval(() => {
                        const content = Swal.getHtmlContainer();
                        if (content) {
                          const b = content.querySelector('b');
                          if (b) {
                            b.textContent = Swal.getTimerLeft();
                          }
                        }
                      }, 100);
                    },
                    willClose: () => {
                      clearInterval(timerInterval);
                    }
                  }).then(result => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                      console.log('I was closed by the timer');
                    }
                  });
                  return false;
                });
                //$('input').iCheck('enable');
                $('#formModulos input, #main-form button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fas fa-spin fa-sync-alt').addClass('far fa-save');
              }
           });
       

       return false;

    });
  </script>
  <script>
   $(document).on("click", ".btnBorrar", function(e){
    e.preventDefault();
    fila = $(this);           
    user_id = parseInt($(this).closest('tr').find('td:eq(0)').text()) ;   
    opcion = 3; //eliminar        
    Swal.fire({
        title: '¿Estás seguro(a)?',
        text: "¡Si confirmas no habrá marcha atrás!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '¡Eliminar!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
        $.ajax({
          url: "/beneficiario/" +user_id +'/delete' ,
          type: "GET",
          datatype:"json",    
          data:  {user_id:user_id},    
          success: function() {
              tablaModulos.row(fila.parents('tr')).remove().draw();  
               var timerInterval;
                  Swal.fire({
                    title: '¡Datos eliminados!',
                    type: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading();
                      timerInterval = setInterval(() => {
                        const content = Swal.getHtmlContainer();
                        if (content) {
                          const b = content.querySelector('b');
                          if (b) {
                            b.textContent = Swal.getTimerLeft();
                          }
                        }
                      }, 100);
                    },
                    willClose: () => {
                      clearInterval(timerInterval);
                    }
                  }).then(result => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                      console.log('I was closed by the timer');
                    }
                  });         
           }
        }); 
         
        }
      });        
    
 });
  </script>
@endpush
@push('styles')
 <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush


@push('scripts')
 <script>
   $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
 </script>
 <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
    });
</script>
@endpush
