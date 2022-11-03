 
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
     <input type="text" name="nu_factura" class="form-control input-sm" placeholder="Ingresa el número de factura " id="nu_factura">
     <span class="missing_alert text-danger" id="nu_factura_alert"></span>
  </div>
</div>
<div class="col-lg-3">
  <div class="form-group mt-3">
    <label>Nro Control</label>
     <input type="text" name="nu_control" class="form-control input-sm" placeholder="Ingresa el número de factura " id="nu_control">
     <span class="missing_alert text-danger" id="nu_control_alert"></span>
  </div>
</div>
  <div class="col-lg-3">
      <div class="form-group mt-3">
      <label>Fecha de factura</label>
        <div>
          <input type="date" name="fecha_factura" class="form-control input-sm" placeholder="Ingresa el número de factura " id="fecha_factura">
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
          <option value="{{ $element->id}}">{{ $element->cedula.' '.  '| '.$element->tx_nombres.' '. $element->tx_apellidos.' | '.$element->ente}}</option>
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
          <option value="{{ $element->id}}">{{ $element->razon_social.' '.  '| '.$element->tx_rif}}</option>
         @endforeach
       </select>
       <span class="missing_alert text-danger" id="razon_social_alert"></span>
    </div>
  </div>
  <input type="hidden" name="titular_beneficiario" id="titular_beneficiario">

  <div class="col-lg-4">
  <div class="form-group mt-3">
    <label> Base Imponible </label>
     <input type="text" name="base_importe" class="form-control input-sm" placeholder="Ingresa la Base Imponible de factura " id="base_importe">
     <span class="missing_alert text-danger" id="base_importe_alert"></span>
  </div>
</div>
 <div class="col-lg-4">
  <div class="form-group mt-3">
    <label> IVA </label>
     <input type="text" name="iva" class="form-control input-sm" placeholder="Ingresa el iva de la factura " id="iva">
     <span class="missing_alert text-danger" id="iva_alert"></span>
  </div>
</div>
<div class="col-lg-4">
  <div class="form-group mt-3">
    <label> Monto Total de Factura </label>
     <input type="text" name="monto_pagado" class="form-control input-sm" placeholder="Ingresa el monto pagado de la factura " id="monto_pagado">
     <span class="missing_alert text-danger" id="monto_pagado_alert"></span>
  </div>
</div>
<div class="col-lg-12">
  <div class="form-group mt-3">
    <label> Monto Total Pagado </label>
     <input type="text" name="total_factura" class="form-control input-sm" placeholder="Ingresa el monto total de la factura " id="total_factura">
     <span class="missing_alert text-danger" id="total_factura_alert"></span>
  </div>
</div>

<div class="col-lg-12">
  <div class="form-group mt-3">
    <label> Notas de la factura </label>
     <textarea name="descripcion" id="" class="form-control" cols="10" rows="3"></textarea>
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
			