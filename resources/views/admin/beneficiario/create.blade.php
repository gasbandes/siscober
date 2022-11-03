@extends('layouts.admin')
@section('title', 'Beneficiarios')
@section('contenido')
<!-- start page title -->
<div class="page-content">
     @include('sweetalert::alert')
       <div class="container-fluid">
       	<form role="form" id="proveedores-form" autocomplete="off">
              <input type="hidden" id="_url" value="{{ url('beneficiario') }}">
              <input type="hidden" id="_token" value="{{ csrf_token() }}">
    				<div class="card">
    					<div class="card-header">
    						Ingresa los datos del beneficiario
    						 <a href="{{ url('beneficiario') }}" class="btn btn-primary" style="float: right !important;"><i class="mdi mdi-plus"></i> Lista de beneficiarios</a>
    					</div>
    					
    					<div class="card-body">
    						<div class="row">
                  <div class="col-lg-12">
                    <div class="form-group mt-1">
                      <label>Titular</label>
                       <select name="titular" class="select2 form-control">
                         <option value="">Seleccione</option>
                         @foreach ($titulares as $element)
                          <option value="{{ $element->id}}">{{ $element->cedula.' '.  '| '.$element->tx_nombres.' '. $element->tx_apellidos.' | '.$element->ente}}</option>
                         @endforeach
                       </select>
                       <span class="missing_alert text-danger" id="razon_social_alert"></span>
                    </div>
                  </div>
        				<div class="col-lg-4">
        					<div class="form-group mt-3">
        						<label>Nombres</label>
        						 <input type="text" name="tx_nombres" class="form-control input-sm" placeholder="Ingresa los nombres " id="tx_nombres">
        						 <span class="missing_alert text-danger" id="tx_nombres_alert"></span>
        					</div>
        				</div>
                  <div class="col-lg-4">
                      <div class="form-group mt-3">
                      <label>Apellidos</label>
                       <input type="text" name="tx_apellidos" class="form-control input-sm" placeholder="Ingresa los apellidos" id="tx_apellidos">
                       <span class="missing_alert text-danger" id="tx_apellidos_alert"></span>
                    </div> 
                  </div>
                  <div class="col-lg-4">
                      <div class="form-group mt-3">
                      <label>Cédula</label>
                       <input type="text" name="cedula" class="form-control input-sm" placeholder="Ingresa la cédula " id="nu_cedula">
                       <span class="missing_alert text-danger" id="nu_cedula_alert"></span>
                    </div>
                  </div>
                  <div class="col-lg-6">
                      <div class="form-group mt-3">
                      <label>Fecha de nacimiento</label>
                       <input type="date" name="fe_nacimiento" class="form-control input-sm" placeholder="Ingresa los apellidos" id="fe_nacimiento">
                       <span class="missing_alert text-danger" id="tx_apellidos_alert"></span>
                    </div> 
                  </div>
                   <div class="col-lg-6">
                      <div class="form-group mt-3">
                      <label>Parentezco</label>
                       <select name="nb_parentezco" id="" class="form-control">
                         <option value="Madre">Madre</option>
                         <option value="Padre">Padre</option>
                         <option value="Esposo(a)">Esposo(a)</option>
                         <option value="Hijo(a)">Hijo(a)</option>
                         
                       </select>
                       <span class="missing_alert text-danger" id="tx_apellidos_alert"></span>
                    </div> 
                  </div>
                   
                   <div class="col-lg-12 text-center">
                      <div class="form-group mt-4">
                      <label for="status">Estado del beneficiario</label>
                      <div class="checkbox icheck">
                        <label>
                          <input type="radio" name="status" value="1" checked> Activo&nbsp;&nbsp;
                          <input type="radio" name="status" value="0"> Deshabilitado
                        </label>
                      </div>
                    </div>
                  </div>
			      	</div>
				  </div>
				<div class="card-footer"> 
					<button class="btn btn-primary" type="submit"><i class="far fa-save"></i> Guardar</button>
				</div>
			</div>
          </form>

       </div>
   </div>


@endsection

@push('styles')
 <!-- gridjs css -->
 <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
 <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
 
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
  <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
    });
</script>
@endpush

@push('scripts')
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
                console.log(json)
                if(json.success){
                  $('#proveedores-form #tx_nombres').val('');
                  $('#proveedores-form #tx_apellidos').val('');
                  $('#proveedores-form #nu_cedula').val('');
                  
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
               else
               {
                var timerInterval;
                  Swal.fire({
                    title: '¡El beneficiario sobrepasa la edad permitida !',
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

 
@endpush
