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
          {!! Form::open(['route' => ['personal.store'],'method' => 'POST','autocomplete'=>'off']) !!}
           <div class="card-body">
              
              <div class="row">
                 @include('admin.personal.partials.form')

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
 <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
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