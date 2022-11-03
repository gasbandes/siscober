
         <div class="mt-3 col-6">
           <div class="form-group">
          <label>Nombre del empleado</label>
            {{ Form:: text('tx_nombres',null,['class'=>'form-control ','placeholder' => 'Nombre del empleado','id'=>'tx_nombres','required']) }}
            
          </div>
         </div>
       
        <div class="mt-3 col-6">
          <div class="form-group">
          <label>Apellido del empleado</label>
            {{ Form:: text('tx_apellidos',null,['class'=>'form-control','required','placeholder' => 'Apellido del empleado','id'=>'tx_apellidos','required']) }}
            
          </div>
        </div>
         <div class="mt-3 col-6">
            <div class="form-group">
          <label>Cédula del empleado</label>
           <input type="text" class="form-control @error('cedula') is-invalid @enderror" placeholder="Ingresa la cédula " id="cedula" name="cedula" value="{{ old('cedula') }}">
            @if ($errors->has('cedula'))
              <p class="text-danger">{{ $errors->first('cedula') }}</p>
          @endif
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
                {{ Form:: text('monto_global',$monto->total,['class'=>'form-control','required','disabled','placeholder' => 'Cédula del empleado','id'=>'cedula','required']) }}
              </div>
          </div>
          <div class="mt-3 col-6">
            <div class="form-group">
                <label for="status_id">Monto disponible</label>
                {{ Form:: text('monto_disponible',$monto->total,['class'=>'form-control monto_disponible','required','id' => 'monto_disponible','placeholder' => 'Cédula del empleado','id'=>'cedula','required']) }}
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
  @endpush

