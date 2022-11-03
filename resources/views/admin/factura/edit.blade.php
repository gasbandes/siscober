@extends('layouts.admin')
@section('title', 'Facturas')
@section('contenido')
<!-- start page title -->
<div class="page-content">
     @include('sweetalert::alert')
       <div class="container-fluid">
        <form role="form" id="facturas-form">
            <input type="hidden" id="_url" value="{{ url('facturas', [$factura->id]) }}">
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <div class="card">
              <div class="card-header">
                Ingresa los datos la factura
                 <a href="{{ url('facturas') }}" class="btn btn-primary" style="float: right !important;"><i class="mdi mdi-plus"></i> Lista de facturas</a>
              </div>
              
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-3">
                  <div class="form-group mt-3">
                    <label>Fecha de la tasa</label>
                     <select name="tasa_id" class=" select2 form-control input-md" id="select_mes">
                       <option value="">Seleccione</option>
                       @php
                         $tasas = \DB::table('tasas')->get();
                       @endphp
                       @foreach ($tasas as $element)
                         <option value="{{ $element->id }}">{{ $element->fecha_emision }} - {{ $element->amount }}Bs</option>
                       @endforeach
                      
                     </select>
                     <span class="missing_alert text-danger" id="razon_social_alert"></span>
                  </div>
                </div>
                   <div class="col-lg-3">
                    <div class="form-group mt-3">
                      <label>Nro Factura</label>
                       <input type="text" name="nu_factura" value="{{ $factura->nu_factura }}" class="form-control input-sm" placeholder="Ingresa el número de factura " id="nu_factura">
                       <span class="missing_alert text-danger" id="nu_factura_alert"></span>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group mt-3">
                      <label>Nro Control</label>
                       <input type="text" name="nu_control" value="{{ $factura->nu_control }}"  class="form-control input-sm" placeholder="Ingresa el número de factura " id="nu_control">
                       <span class="missing_alert text-danger" id="nu_control_alert"></span>
                    </div>
                  </div>
                    <div class="col-lg-3">
                        <div class="form-group mt-3">
                        <label>Fecha de factura</label>
                          <div>
                            <input type="date" name="fecha_factura" value="{{ $factura->fecha_factura }}" class="form-control input-sm" placeholder="Ingresa el número de factura " id="fecha_factura">
                       <span class="missing_alert text-danger" id="fecha_factura_alert"></span>
                            <!-- input-group -->
                        </div>
                         <span class="missing_alert text-danger" id="nu_cedula_alert"></span>
                      </div>
                    </div>
                     <div class="col-lg-4">
                      <div class="form-group mt-3">
                        <label>Titular</label>
                         <select name="titular_id" class=" select1 form-control input-md" id="select_titular">
                            <option value="">Seleccione</option>
                           @foreach ($titulares as $element)
                            <option value="{{ $element->id}}"  {{ ($factura->titular_id == $factura->titular_id) ? 'selected' : '' }}>{{ $element->cedula.' '.  '| '.$element->tx_nombres.' '. $element->tx_apellidos.' | '.$element->ente}}</option>
                           @endforeach
                         </select>
                         <span class="missing_alert text-danger" id="razon_social_alert"></span>
                      </div>
                    </div>
                       <div class="col-lg-4">
                      <div class="form-group mt-3">
                        <label for="status"><span class="text-danger">¿El servicio fué consumido por el titular?</span></label>
                         <select  class="select2 form-control" id="funcionario_beneficiario">
                          <option value="">Seleccione</option>
                          <option value="1">SI</option>
                          <option value="0">NO</option>
                           
                         </select>
                         <span class="missing_alert text-danger" id="razon_social_alert"></span>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group mt-3">
                        <label>Beneficiario</label>
                         <select name="beneficiario_id" class="select2 form-control" id="select_beneficiario">
                          
                           
                         </select>
                         <span class="missing_alert text-danger" id="razon_social_alert"></span>
                      </div>
                    </div>

                   <div class="col-lg-12">
                      <div class="form-group mt-3">
                        <label>Proveedor</label>
                         <select name="proveedor_id" class=" form-control input-md" id="select_proveedores">
                          @php
                            $proveedores = \DB::table('proveedores')->where('status',1)->get();
                          @endphp
                           <option value="">Seleccione</option>
                           @foreach ($proveedores as $element)
                            <option value="{{ $element->id }}" {{ ( $element->id == $factura->proveedor_id) ? 'selected' : '' }}> {{ $element->razon_social }} </option>
                           @endforeach
                         </select>
                         <span class="missing_alert text-danger" id="razon_social_alert"></span>
                      </div>
                    </div>
                    <input type="hidden" name="titular_beneficiario" id="titular_beneficiario">

                    <div class="col-lg-4">
                    <div class="form-group mt-3">
                      <label> Base Imponible </label>
                       <input type="text" name="base_importe" value="{{ $factura->base_importe  }}" class="form-control input-sm" placeholder="Ingresa la Base Imponible de factura " id="base_importe">
                       <span class="missing_alert text-danger" id="base_importe_alert"></span>
                    </div>
                  </div>
                   <div class="col-lg-4">
                    <div class="form-group mt-3">
                      <label> IVA </label>
                       <input type="text" name="iva" class="form-control input-sm" value="{{ $factura->iva  }}" placeholder="Ingresa el iva de la factura " id="iva">
                       <span class="missing_alert text-danger" id="iva_alert"></span>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group mt-3">
                      <label> Monto Total de Factura </label>
                       <input type="text" name="monto_pagado" class="form-control input-sm" value="{{ $factura->total_factura  }}" placeholder="Ingresa el monto pagado de la factura " id="monto_pagado">
                       <span class="missing_alert text-danger" id="monto_pagado_alert"></span>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group mt-3">
                      <label> Monto Total Pagado </label>
                       <input type="text" name="total_factura" value="{{ $factura->monto_pagado  }}"  class="form-control input-sm" placeholder="Ingresa el monto total de la factura " id="total_factura">
                       <span class="missing_alert text-danger" id="total_factura_alert"></span>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="form-group mt-3">
                      <label> Notas de la factura </label>
                       <textarea name="descripcion" id="" class="form-control" cols="10" rows="3">
                         {{ $factura->descripcion  }}
                       </textarea>
                       <span class="missing_alert text-danger" id="total_factura_alert"></span>
                    </div>
                  </div>


                  <div class="col-lg-12 text-center">
                    <div class="form-group mt-4">
                    <label for="status">Estado de la factura</label>
                    <div class="checkbox icheck">
                      <label>
                        <input type="radio" name="status" value="1" checked> PAGADO&nbsp;&nbsp;
                        <input type="radio" name="status" value="2" > PENDIENTE POR PAGO&nbsp;&nbsp;
                        <input type="radio" name="status" value="3" > ANULADA&nbsp;&nbsp;
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
              type: 'PUT',
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
