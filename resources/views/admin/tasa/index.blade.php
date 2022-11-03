@extends('layouts.admin')
@section('title', 'Tasa')
@section('contenido')
<!-- start page title -->
<div class="page-content">
     @include('sweetalert::alert')
       <div class="container-fluid">
  	   <div class="row">
    			<div class="col-lg-12">
            <form role="form" id="tasa-form" autocomplete="off">
              <input type="hidden" id="_url" value="{{ url('tasa') }}">
              <input type="hidden" id="_token" value="{{ csrf_token() }}">
    				<div class="card">
    					<div class="card-header">
    						Vista general de los tasa
    					</div>
<<<<<<< HEAD
    					
=======

>>>>>>> b75ec073 (integracion general)
    					<div class="card-body">
    						<div class="row">
    							<div class="col-lg-6">
    								<div class="form-group mt-1">
    									<label>Tasa</label>
    									 <input type="text" name="amount" class="form-control input-sm" placeholder="Tasa BCV " id="amount_id">
    									 <span class="missing_alert text-danger" id="amount_alert"></span>
    								</div>
<<<<<<< HEAD
    							</div>
                 <div class="col-lg-6">
                    <div class="form-group mt-1">
                      <label>Fecha de la tasa</label>
                       <input type="date" name="fecha_emision" class="form-control input-sm" placeholder="Tasa BCV " id="fecha_emision">
                       <span class="missing_alert text-danger" id="fecha_emision_alert"></span>
                    </div>
                  </div>
                 
    						</div>
    					</div>
    					<div class="card-footer"> 
=======
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mt-1">
                                <label>Fecha de la tasa</label>
                                <input name="fecha_emision" class="form-control input-sm" placeholder="Tasa BCV " value="{{ date('d-m-Y') }}" id="fecha_emision">
                                <span class="missing_alert text-danger" id="fecha_emision_alert"></span>
                                </div>
                            </div>

    						</div>
    					</div>
    					<div class="card-footer">
>>>>>>> b75ec073 (integracion general)
    						<button class="btn btn-primary" type="submit"><i class="far fa-save"></i> Guardar</button>
    					</div>
    				</div>
          </form>
            <div class="row">
            <div class="col-lg-12">
              <div class="card">
              <div class="card-header">
                Listado de tasa
              </div>
              <div class="card-body">
                 <div class="card-body table-responsive">
                    <table  class="table table-sm table-hover " id="tablaModulos">
                    <thead>
<<<<<<< HEAD
                      <tr> 
=======
                      <tr>
>>>>>>> b75ec073 (integracion general)
                      <th>#</th>
                      <th>Tasa</th>
                      <th>Fecha</th>
                      <th></th>
<<<<<<< HEAD
                    
                      </tr>
                    </thead>
                        
                    </table>
                  </div>
                </div>  
=======

                      </tr>
                    </thead>

                    </table>
                  </div>
                </div>
>>>>>>> b75ec073 (integracion general)
              </div>
            </div>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.tasa.partials.modal.edit')
<!-- end page title -->
@endsection
@push('styles')
 <!-- gridjs css -->
 <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
<<<<<<< HEAD
 
=======

>>>>>>> b75ec073 (integracion general)
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
<<<<<<< HEAD
    tablaModulos =  $('#tablaModulos').DataTable({ 
=======
    tablaModulos =  $('#tablaModulos').DataTable({
>>>>>>> b75ec073 (integracion general)
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
<<<<<<< HEAD
            'excel', 'pdf', 'print','colvis' 
        ],
    "ajax":{            
        "url": "{{ url('listado/tasa') }}", 
=======
            'excel', 'pdf', 'print','colvis'
        ],
    "ajax":{
        "url": "{{ url('listado/tasa') }}",
>>>>>>> b75ec073 (integracion general)
        "method": 'GET', //usamos el metodo POST
        "dataSrc":""
    },

    "columns":[
        {"data": "id"},
        {"data": "amount"},
        {"data": "fecha_emision"},
<<<<<<< HEAD
    
        
=======


>>>>>>> b75ec073 (integracion general)
        {"defaultContent": "<div class='text-center'><button class='btn btn-primary btn-sm btn-circle btnEditar'><i class='mdi mdi-pencil'></i></button><button class='btn btn-danger btn-sm btn-circle btnBorrar'><i class='mdi mdi-delete'></i></button></div>"}
    ]
});
    var fila; //captura la fila, para editar o eliminar
<<<<<<< HEAD
//Editar        
$(document).on("click", ".btnEditar", function(){           
    opcion = 2;//editar
    fila = $(this).closest("tr");   

    user_id  = parseInt(fila.find('td:eq(0)').text()); //capturo el ID               
=======
//Editar
$(document).on("click", ".btnEditar", function(){
    opcion = 2;//editar
    fila = $(this).closest("tr");

    user_id  = parseInt(fila.find('td:eq(0)').text()); //capturo el ID
>>>>>>> b75ec073 (integracion general)
    nombre   = fila.find('td:eq(1)').text();
    apellido = fila.find('td:eq(2)').text();
    usuario  = fila.find('td:eq(3)').text();
    emailInput  = fila.find('td:eq(4)').text();
    //status = parseInt(fila.find('td:eq(4)').text());
    console.log(status);

    $("#nombreusuario").val(nombre);
    $("#apellido").val(apellido);
    $("#usuario").val(usuario);
    $("#emailInput").val(emailInput);
<<<<<<< HEAD
    $(".modal-title").text("Edición de Usuarios");   
    $('#ModulosEdit').modal('show');       
=======
    $(".modal-title").text("Edición de Usuarios");
    $('#ModulosEdit').modal('show');
>>>>>>> b75ec073 (integracion general)
});

var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización
<<<<<<< HEAD
$('#main-form').submit(function(e){                        
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    name = $.trim($('#nombreusuario').val());    
    last_name = $.trim($('#apellido').val());
    status = $.trim($('#status').val());
    username = $.trim($('#usuario').val());
    codigo = $.trim($('#txtCodigo').val());  
    var data = $('#main-form').serialize();        
    $('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');             
=======
$('#main-form').submit(function(e){
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    name = $.trim($('#nombreusuario').val());
    last_name = $.trim($('#apellido').val());
    status = $.trim($('#status').val());
    username = $.trim($('#usuario').val());
    codigo = $.trim($('#txtCodigo').val());
    var data = $('#main-form').serialize();
    $('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');
>>>>>>> b75ec073 (integracion general)
    $.ajax({
         url: "/tasa/" + user_id,
          headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
          type: "PUT",
<<<<<<< HEAD
          datatype:"json",  
          cache: false,  
          data:  data, 
=======
          datatype:"json",
          cache: false,
          data:  data,
>>>>>>> b75ec073 (integracion general)
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
<<<<<<< HEAD
     });        
    $('#ModulosEdit').modal('hide');                                
=======
     });
    $('#ModulosEdit').modal('hide');
>>>>>>> b75ec073 (integracion general)
});

</script>
  <script>
    $('#edit-button').hide();
    $('#tasa-form #amount_id').focus();
    $('#tasa-form').submit(function(){

         $('.missing_alert').css('display', 'none');

        if ($('#tasa-form #amount_id').val() === '') {
            $('#tasa-form #amount_alert').text('Ingrese la tasa BCV.').show();
            $('#tasa-form #amount_id').addClass('is-invalid')
            $('#tasa-form #amount_id').focus();
            return false;
        }


        if ($('#tasa-form #tx_rif_id').val() === '') {
            $('#tasa-form #tx_rif_alert').text('Ingrese el RIF del proveedor').show();
            $('#tasa-form #tx_rif_id').addClass('is-invalid');
            $('#tasa-form #tx_rif_id').focus();
            return false;
        }
<<<<<<< HEAD
       
=======

>>>>>>> b75ec073 (integracion general)

        var data = $('#tasa-form').serialize();
        //$('input').iCheck('disable');
        //$('#tasa-form input, #tasa-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');


<<<<<<< HEAD
       
=======

>>>>>>> b75ec073 (integracion general)
            $.ajax({
              url: $('#tasa-form #_url').val(),
              headers: {'X-CSRF-TOKEN': $('#tasa-form #_token').val()},
              type: 'POST',
              cache: false,
              data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  $('#tasa-form #submit').hide();
                  $('#tasa-form #edit-button').attr('href', $('#tasa-form #_url').val() + '/' + json.user_id + '/edit');
                  $('#tasa-form #edit-button').removeClass('hide');
                  $('#tasa-form #amount_id').val('');
                  $('#tasa-form #fecha_emision').val('');
                  $('#tasa-form #tx_rif_id').val('');
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

<<<<<<< HEAD
                  
                  
=======


>>>>>>> b75ec073 (integracion general)
               }
              },error: function (data) {
                var errors = data.responseJSON;
                $.each( errors.errors, function( key, value ) {
                  toastr.error(value);
                  return false;
                });
                //$('input').iCheck('enable');
                $('#formModulos input, #main-form button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fas fa-spin fa-sync-alt').addClass('far fa-save');
              }
           });
<<<<<<< HEAD
       
=======

>>>>>>> b75ec073 (integracion general)

       return false;

    });
  </script>
  <script>
   $(document).on("click", ".btnBorrar", function(e){
    e.preventDefault();
<<<<<<< HEAD
    fila = $(this);           
    user_id = parseInt($(this).closest('tr').find('td:eq(0)').text()) ;   
    opcion = 3; //eliminar        
=======
    fila = $(this);
    user_id = parseInt($(this).closest('tr').find('td:eq(0)').text()) ;
    opcion = 3; //eliminar
>>>>>>> b75ec073 (integracion general)
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
          url: "/tasa/" +user_id +'/delete' ,
          type: "GET",
<<<<<<< HEAD
          datatype:"json",    
          data:  {user_id:user_id},    
          success: function() {
              tablaModulos.row(fila.parents('tr')).remove().draw();  
=======
          datatype:"json",
          data:  {user_id:user_id},
          success: function() {
              tablaModulos.row(fila.parents('tr')).remove().draw();
>>>>>>> b75ec073 (integracion general)
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
<<<<<<< HEAD
                  });         
           }
        }); 
         
        }
      });        
    
=======
                  });
           }
        });

        }
      });

>>>>>>> b75ec073 (integracion general)
 });
  </script>
@endpush
