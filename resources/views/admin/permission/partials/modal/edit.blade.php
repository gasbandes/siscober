<div id="myModal{{ $element->id }}" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalgridLabel">Creación de permiso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
     <div class="modal-body">
           {!! Form::model($element, ['route' => ['permission.update',$element->id],'method' => 'PUT']) !!}
          @include('admin.permission.partials.input.form')
          <br><br>
          <button type="submit" class="btn blue darken-4 text-white form-control">Guardar cambios</button>
           {!! Form::close()!!}
       </div>
    </div>
  </div>
</div>