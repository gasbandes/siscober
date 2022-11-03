@extends('layouts.admin')
@section('title', 'Inicio')
@section('contenido')
<div class="page-content">
   <div class="container-fluid">
    <div class="row">
       <div class="col-12">
            <div class="card">
                 <div class="card-header">
                     <h4>Montos globales</h4>
                 </div>
                  <form role="form" id="usuarios-form" autocomplete="off">
                    <input type="hidden" id="_url" value="{{ url('montoglobal') }}">
                    <input type="hidden" id="_token" value="{{ csrf_token() }}">
                     <div class="card-body"> 
                         <div class="row">
                             <div class="col-12">
                                 <div class="form-group">
                                     <label for="">Monto global:</label>
                                     <input type="text" name="total" class="form-control" id="montoglobalinput" placeholder="$" >
                                     <span class="missing_alert text-danger" id="montoglobalinput_alert"></span>
                                 </div>
                             </div>
                             <div class="form-group mt-4">
                                <label for="status">Estado del monto global</label>
                                <div class="checkbox icheck">
                                  <label>
                                    <input type="radio" name="status" value="1" checked> Activo&nbsp;&nbsp;
                                    <input type="radio" name="status" value="0"> Deshabilitado
                                  </label>
                                </div>
                              </div>
                         </div>
                     </div>
                     <div class="card-footer">
                         <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Guardar</button>
                     </div>
                 </form>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Historial de montos</h4>
                </div>
                <div class="card-body">
                    <table  class="table table-sm table-hover " id="tablaModulos">
                          <thead>
                          <tr> 
                          <th>#</th>
                          <th>Monto ($)</th>
                          <th>Fecha</th>    
                          <th>status</th>                      
                          <th></th>
                        
                          </tr>
                          </thead>
                     </table>
                </div>  
            </div>
        </div>
     </div>
   </div>
</div>     
@include('admin.montoglobal.partials.modal.edit')  
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
         responsive:true,
         lengthChange: true,
         buttons: [
            'excel', 'pdf', 'print'
        ],
    "ajax":{            
        "url": "{{ route('montoglobal.listado') }}", 
        "method": 'GET', //usamos el metodo POST
        "dataSrc":""
    },

    "columns":[
        {"data": "id"},
        {"data": "total"},
        {"data": "fecha"},
        
        {
         "data": "status",
            render:function(data, type, row)
            {
             if (data == 1)
             {
               return '<div class="text-center badge bg-success">Activo</div>';
             } 
             else
             {
              return '<div class="text-center badge bg-danger">Inactivo</div>';
             }           
             
             
            },
        },
        
        {"defaultContent": "<div class='text-center'><button class='btn btn-primary btn-sm btn-circle btnEditar'><i class='mdi mdi-pencil'></i></button></div>"}
    ]
});
    var fila; //captura la fila, para editar o eliminar
//Editar        
$(document).on("click", ".btnEditar", function(){           
    opcion = 2;//editar
    fila = $(this).closest("tr");   

    user_id  = parseInt(fila.find('td:eq(0)').text()); //capturo el ID               
    monto   = fila.find('td:eq(1)').text();
    //status = parseInt(fila.find('td:eq(4)').text());
    console.log(status);

    $("#montoglobal").val(monto);
    
    $(".modal-title").text("Edición de Usuarios");   
    $('#ModulosEdit').modal('show');       
});

var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización
$('#main-form').submit(function(e){                        
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    name = $.trim($('#montoglobal').val());    

    var data = $('#main-form').serialize();        
    $('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');             
    $.ajax({
         url: "/montoglobal/" + user_id,
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
    $('#usuarios-form').submit(function(){

         $('.missing_alert').css('display', 'none');

        if ($('#usuarios-form #montoglobalinput').val() === '') {
            $('#usuarios-form #montoglobalinput_alert').text('Ingrese el monto global del seguro.').show();
             $('#usuarios-form #montoglobalinput').addClass('is-invalid');
            $('#usuarios-form #montoglobalinput').focus();
            return false;
        }

       

        var data = $('#usuarios-form').serialize();
        //$('input').iCheck('disable');
        //$('#usuarios-form input, #usuarios-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');


       
            $.ajax({
              url: $('#usuarios-form #_url').val(),
              headers: {'X-CSRF-TOKEN': $('#usuarios-form #_token').val()},
              type: 'POST',
              cache: false,
              data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  $('#usuarios-form #submit').hide();
                  $('#usuarios-form #edit-button').attr('href', $('#usuarios-form #_url').val() + '/' + json.user_id + '/edit');
                  $('#usuarios-form #edit-button').removeClass('hide');
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
                  toastr.error(value);
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
          url: "/montoglobal/" +user_id +'/delete' ,
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
