@extends('layouts.admin')

@section('title', 'Personal')
@section('page_title', 'Personal del banco')
@section('contenido')
 <div class="page-content">
  @include('sweetalert::alert')
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
         <div class="card">
          <div class="card-header">
            <h3>Datos del personal</h3>
          </div>
          {!! Form::model($personal, ['route' => ['personal.update',$personal->id],'method' => 'PUT','enctype'=>'multipart/form-data','autocomplete'=>'off','edicion']) !!}
           <div class="card-body">
              
              <div class="row">
                
         <div class="mt-3 col-6">
           <div class="form-group">
          <label>Nombre del empleado</label>
            {{ Form:: text('tx_nombres',null,['class'=>'form-control','placeholder' => 'Nombre del empleado','id'=>'tx_nombres','required']) }}
            
          </div>
         </div>
       
        <div class="mt-3 col-6">
          <div class="form-group">
          <label>Apellido del empleado</label>
            {{ Form:: text('tx_apellidos',null,['class'=>'form-control','placeholder' => 'Apellido del empleado','id'=>'tx_apellidos','required']) }}
            
          </div>
        </div>
         <div class="mt-3 col-6">
            <div class="form-group">
          <label>Cédula del empleado</label>
            {{ Form:: text('cedula',null,['class'=>'form-control','placeholder' => 'Cédula del empleado','id'=>'cedula','required']) }}
          </div>
         </div>
           <div class="mt-3 col-6">
             <div class="form-group">
           
          <label>Ente del empleado</label>
           
        @php
          $entes = App\Models\Ente::pluck('name', 'id');
          $monto = App\Models\MontoGlobal::where('status',1)->first();
        @endphp
           {!! Form::select('ente_id', $entes, null,array('class' => 'form-control  ente_form ','placeholder'=>'Selecione el ente ')) !!}    
     
          </div>
           </div>
           <div class="mt-3 col-12">
             <div class="form-group">
           
          <label>Gerencia del empleado</label>
           
       
           <select name="gerencia_id" data-width="100%" class="form-control input-sm  gerencia_form">
              
           </select>  
     
          </div>
           </div>
         <div class="mt-3 col-6">
            <div class="form-group">
                <label for="status_id">Monto Global</label>
                {{ Form:: text('cedula',$monto->total,['class'=>'form-control','disabled','placeholder' => 'Cédula del empleado','id'=>'cedula','required']) }}
              </div>
          </div>
          <div class="mt-3 col-6">
            <div class="form-group">
                <label for="status_id">Monto disponible</label>
               <input type="text" id="monto_disponible" value="{{ $personal->saldo_disponible }}" name="saldo_disponible" class="form-control" disabled>
              </div>
          </div>


          <div class="mt-3 col-6">
            <div class="form-group">
                <label for="status_id">Estado del empleado</label>
                <div class="checkbox">
                  <label>
                    <input type="radio" name="status_id" value="1" checked> Activo&nbsp;&nbsp;
                    <input type="radio" name="status_id" value="2"> Jubilado
                  </label>
                </div>
              </div>
          </div>              
            <div class="mt-3 col-6">
                    <div class="form-group">
                        <label for="status_id">Autorización de aumento</label>
                       
                           <select name="autorizado" id="autorizado" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="1">SI</option>
                         </select>
                      </div>
                  </div>

              </div>
            
           </div>

           <div class="card-footer">
              <div class="col-sm-4">
                  <button type="submit" class="btn btn-primary form-control text-white">
                      Guardar empleado
                  </button>
              </div>
           </div>
            {!! Form::close()!!}
         </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
 <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush


@push('scripts')
 <script>
   $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
 </script>

       
 <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-green ',
        radioClass: 'iradio_square-green mt-1',
        increaseArea: '20%' // optional
      });
    });
</script>
 
 <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

<script>
     // A $( document ).ready() block.
$( document ).ready(function() {
 
      $('#autorizado').unbind('change');//borro evento click
      $('#autorizado').on("change", function(e) { //asigno el evento change u otro
       
                autorizado = e.target.value;

                if (autorizado > 0) {

                 $('#monto_disponible').removeAttr('disabled');
                  $('#monto_disponible').focus();
                 
                }
               

             });
        });
    </script>


<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
    });
</script>


  <script type="text/javascript">

   var form    = false;


$(document).ready(function() {

  form = $('#personal_form');
     
    $.fn.eventos();

    
  

  //$('#objetivos').hide();
    
});


$.fn.eventos = function(){


  $('.ente_form').unbind('change');//borro evento click
  $('.ente_form').on("change", function(e) { //asigno el evento change u otro
   
    ente_form = e.target.value;
    console.log(ente_form);
    if(ente_form != '0')
    {

      $.fn.get_municipio(ente_form);
      $(".gerencia_form").removeAttr('disabled');

     
    }else{
      console.log('epa selecciona un proyecto valido');
    }

  });
  
}

/********* AJAX ***********/

$.fn.get_municipio = function(ente_form){

      $.ajax({url: "/empleado/"+ente_form+"/gerencia",
        method: 'GET',
        //data: {'gerencias': estados_id}
      }).then(function(result) {
        console.log(result);
          
        $('.gerencia_form').html('<option value=""> Seleccione la gerencia del funcionario </option>');
        

        $(result).each(function( index, element ) {
          //console.log(element.descricion);
          $('.gerencia_form').append('<option value="'+ element.id +'">'+ element.name +' </option>');
      
        });
      })
      .catch(function(err) {
          console.error(err);
      });

}

 

  </script>
@endpush
@push('scripts')
   <!-- Sweet Alerts js -->
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
         <script>
          @if(Session::has('error'))
            alert(1);
          @endif
     </script>

     
         
@endpush
@push('styles')
    <!-- Sweet Alert css-->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
