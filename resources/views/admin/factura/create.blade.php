@extends('layouts.admin')
@section('title', 'Facturas')
@section('contenido')
<!-- start page title -->
<div class="page-content">
     @include('sweetalert::alert')
       <div class="container-fluid">
       	<form role="form" id="facturas-form" autocomplete="off">
              <input type="hidden" id="_url" value="{{ url('facturas') }}">
              <input type="hidden" id="_token" value="{{ csrf_token() }}">
    				<div class="card">
    					<div class="card-header">
    						Ingresa los datos la factura
    						 <a href="{{ url('facturas') }}" class="btn btn-primary" style="float: right !important;"><i class="mdi mdi-plus"></i> Lista de facturas</a>
    					</div>
    					
    					<div class="card-body">
    						<div class="row">
                 @include('admin.factura.partials.form.input')
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
 <script type="text/javascript">

   var form    = false;


$(document).ready(function() {

  form = $('#facturas-form');
     
    $.fn.eventos();

    
  

  //$('#objetivos').hide();
    
});


$.fn.eventos = function(){


  
  $('#select_titular').on("change", function(e) { //asigno el evento change u otro
   
    titular = e.target.value;
    console.log(titular);
    if(titular != '0')
    {

      $.fn.get_municipio(titular);
      $(".gerencia_form").removeAttr('disabled');

     
    }else{
      console.log('epa selecciona un proyecto valido');
    }

  });
  
}

/********* AJAX ***********/

$.fn.get_municipio = function(ente_form){

      $.ajax({url: "/facturas/"+ente_form+"/beneficiario",
        method: 'GET',
        //data: {'gerencias': estados_id}
      }).then(function(result) {
        console.log(result);
          
        $('#select_beneficiario').html('<option value="0"> Seleccione el beneficiario </option>');
        

        $(result).each(function( index, element ) {
          console.log(element.descricion);
          $('#select_beneficiario').append('<option value="'+ element.id +'">'+ element.tx_nombres +' ' +element.tx_apellidos +' </option>');
      
        });
      })
      .catch(function(err) {
          console.error(err);
      });

}




  
  
 
  </script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
      $('.select1').select2()
      $('#select_proveedores').select2()
      
    });
</script>
@endpush

@push('scripts')
  <script>
       $("#funcionario_beneficiario").on( 'change', function(e) {
              
            if (e.target.value == 1) {

              $('#select_beneficiario').attr('disabled', 'disabled');
              $('#titular_beneficiario').val(1)
            }
            else
            {
              $('#select_beneficiario').removeAttr('disabled');
              $('#titular_beneficiario').val(0)
            }
        });


    $('#edit-button').hide();
    $('#facturas-form').submit(function(){

         $('.missing_alert').css('display', 'none');

        if ($('#facturas-form #tx_nombres').val() === '') {
            $('#facturas-form #tx_nombres_alert').text('Ingrese el nombre del beneficiario.').show();
            $('#facturas-form #tx_nombres').addClass('is-invalid')
            $('#facturas-form #tx_nombres').focus();
            return false;
        }


        if ($('#facturas-form #tx_apellidos').val() === '') {
            $('#facturas-form #tx_apellidos_alert').text('Ingrese el apellido del beneficiario').show();
            $('#facturas-form #tx_apellidos').addClass('is-invalid');
            $('#facturas-form #tx_apellidos').focus();
            return false;
        }

         if ($('#facturas-form #nu_cedula').val() === '') {
            $('#facturas-form #nu_cedula_alert').text('Ingrese la cédula del beneficiario').show();
            $('#facturas-form #nu_cedula').addClass('is-invalid');
            $('#facturas-form #nu_cedula').focus();
            return false;
        }



        var data = $('#facturas-form').serialize();
        //$('input').iCheck('disable');
        //$('#facturas-form input, #facturas-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('far fa-save').addClass('fas fa-spin fa-sync-alt');


       
            $.ajax({
              url: $('#facturas-form #_url').val(),
              headers: {'X-CSRF-TOKEN': $('#facturas-form #_token').val()},
              type: 'POST',
              cache: false,
              data: data,
              success: function (response) {
                
                var json = $.parseJSON(response);
                console.log(json.success)
                if(json.success){
                  $('#facturas-form #tx_nombres').val('');
                  $('#facturas-form #tx_apellidos').val('');
                  $('#facturas-form #nu_cedula').val('');
                  
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
                    title: '¡El titular ha sobrepasado el límite de cobertura!',
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
               }
              },error: function (data) {
                consol.log(data);
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
