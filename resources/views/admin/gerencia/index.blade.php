@extends('layouts.admin')
@section('title', 'Gerencias')
@section('contenido')
 <div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Alta de Gerencias</h4>
                    </div>
                     <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                               <form role="form" id="gerencias-form" autocomplete="off">
                                    <input type="hidden" id="_url" value="{{ url('gerencia') }}">
                                    <input type="hidden" id="_token" value="{{ csrf_token() }}">

                                    <div class="form-group mt-2 pading">
                                        <label for="name">Entes</label>
                                        <select class="form-control" name="ente">
                                            <option value="BANDES">BANDES</option>
                                            <option value="CORPOVEX">CORPOVEX</option>
                                        </select>

                                        <span class="missing_alert text-danger" id="ente_alert"></span>
                                   </div>

                                    <div class="form-group mt-2 pading">
                                        <label for="name">Nombre de la gerencia</label>
                                        <input class="form-control" id="name" name="name" placeholder="Nombre de la gerencia">
                                        <span class="missing_alert text-danger" id="name_alert"></span>
                                   </div>
                                    <div class="form-group mt-3">
                                    <label for="status">Estado de la gerencia</label>
                                    <div class="checkbox icheck">
                                      <label>
                                        <input type="radio" name="status" value="1" checked> Activo&nbsp;&nbsp;
                                        <input type="radio" name="status" value="0"> Deshabilitado
                                      </label>
                                    </div>
                                  </div><br>
                                   <div>
                                  <button type="submit" class="btn btn-primary ajax" id="submit">
                                    <i id="ajax-icon" class="far fa-save"></i> Ingresar
                                  </button>
                                  <a type="submit" class="btn btn-info ajax hide" id="edit-button">
                                    <i class="fa fa-edit"></i> Editar
                                  </a>
                                </div>
                              </form>
                            </div>
                            <div class="col-8">
                                <div class=" table-responsive">
                                       <table  class="table table-sm table-hover " id="tablaModulos">
                                              <thead>
                                              <tr>
                                              <th>#</th>
                                              <th>Nombres</th>
                                              <th>Apellidos</th>

                                              <th>Estado</th>

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
            </div>
        </div>
    </div>
    <!-- container-fluid -->
    @include('admin.gerencia.partials.modal.edit')
</div>
<!-- End Page-content -->
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
            'excel', 'pdf', 'print','colvis'
        ],
    "ajax":{
        "url": "{{ url('listado/gerencias') }}",
        "method": 'GET', //usamos el metodo POST
        "dataSrc":""
    },

    "columns":[
        {"data": "id"},
        {"data": "ente"},
        {"data": "name"},
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

        {"defaultContent": "<div class='text-center'><button class='btn btn-primary btn-sm btn-circle btnEditar'><i class='mdi mdi-pencil'></i></button><button class='btn btn-danger btn-sm btn-circle btnBorrar'><i class='mdi mdi-delete'></i></button></div>"}
    ]
});
    var fila; //captura la fila, para editar o eliminar
//Editar
$(document).on("click", ".btnEditar", function(){
    opcion = 2;//editar
    fila = $(this).closest("tr");

    user_id  = parseInt(fila.find('td:eq(0)').text()); //capturo el ID
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
    $(".modal-title").text("Edición de la Gerencia");
    $('#ModulosEdit').modal('show');
});

var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización
$('#main-form').submit(function(e){
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    name = $.trim($('#nombreusuario').val());
    last_name = $.trim($('#apellido').val());
    status = $.trim($('#status').val());
    username = $.trim($('#usuario').val());
    codigo = $.trim($('#txtCodigo').val());
    var data = $('#main-form').serialize();
    //$('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');
    $.ajax({
         url: "/gerencia/" + user_id,
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
    $('#gerencias-form').submit(function(){

         $('.missing_alert').css('display', 'none');

        if ($('#gerencias-form #name').val() === '') {
            $('#gerencias-form #name_alert').text('Ingrese nombre de la gerencia').show();
            $('#gerencias-form #name').addClass('is-invalid');
            $('#gerencias-form #name').focus();
            return false;
        }

        var data = $('#gerencias-form').serialize();
        //$('input').iCheck('disable');
        //$('#gerencias-form input, #gerencias-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');



            $.ajax({
              url: $('#gerencias-form #_url').val(),
              headers: {'X-CSRF-TOKEN': $('#gerencias-form #_token').val()},
              type: 'POST',
              cache: false,
              data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  $('#gerencias-form #submit').hide();
                  $('#gerencias-form #edit-button').attr('href', $('#gerencias-form #_url').val() + '/' + json.user_id + '/edit');
                  $('#gerencias-form #edit-button').removeClass('hide');
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
          url: "/gerencia/" +user_id +'/delete' ,
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
