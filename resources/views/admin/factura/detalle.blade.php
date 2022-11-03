@extends('layouts.admin')

@section('title', 'Usuarios')
@section('page_title', 'Usuarios')
@section('page_subtitle', 'Datos')

@section('breadcrumb')
    @parent
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="{{ url('user') }}">usuarios</a></li>
    <li class="active">datos</li>
@endsection

@section('contenido')
<div class="page-content">
 <div class="container-fluid">
      <div class="row">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">

                      <h4 class="card-title">Detalles de la factura </h4>
                      <p class="card-title-desc">Datos generales para ser modificados</p>

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                          <li class="nav-item">
                              <a class="nav-link active" data-bs-toggle="tab" href="#home1"
                                  role="tab">Datos del empleado</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">Factura</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="tab" href="#messages1"
                                  role="tab">Totales</a>
                          </li>
                         
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                          <div class="tab-pane active p-3" id="home1" role="tabpanel">
                            <table  class="table table-sm table-hover " id="tablaModulos">
                            <thead>
                              <tr class="text-center"> 
                              <th>Nombre completo</th>
                              <th>Cédula</th>
                              <th>Gerencia</th>                            
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="text-center">
                                  <th >{{ $factura->titular->tx_nombres }} {{ $factura->titular->tx_apellidos }}</th>
                                  <th >{{ $factura->titular->cedula }}</th>
                                  <th >{{ $factura->titular->gerencia->name }}</th>
                                  
                              </tr>
                             
                              </tbody>
                                
                            </table>
                          </div>
                          <div class="tab-pane p-3" id="profile1" role="tabpanel">
                            <table  class="table table-hover table-lg " id="tablaModulos">
                             <thead>
                              <tr class="text-center"> 
                                 <th>Fecha de factura</th>
                                  <th>Ente</th>
                                  <th>N° Factura</th>
                                  <th>N° Control</th>
                                  <th>Proveedor</th>               
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="text-center">
                                  <th >{{ $factura->fecha_factura }}</th>
                                  <th >{{ $factura->titular->ente }}</th>
                                  <th >{{ $factura->nu_factura }}</th>
                                  <th >{{ $factura->nu_control }}</th>
                                  <th >{{ $factura->proveedor->razon_social }}</th>

                              </tr>
                             
                              </tbody>
                                
                            </table>
                          </div>
                          <div class="tab-pane p-3" id="messages1" role="tabpanel">
                               <table  class="table table-hover table-lg " id="tablaModulos">
                             <thead>
                              <tr class="text-center"> 
                                 <th>Base Imponible</th>
                                  <th>IVA</th>
                                  <th>Monto Total</th>
                                  <th>Monto Pagado</th>
                                  <th>Monto Pagado ($)</th>     
                                  <th>Estado de la factura</th>      
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="text-center">
                                  <td>
                                {{ number_format( $factura->base_importe) }}
                              </td>
                               <td>
                                {{ number_format( $factura->iva) }}
                              </td>
                               <td>
                                {{ number_format( $factura->total_factura) }}
                              </td>
                              <td>
                                  {{ number_format( $factura->monto_pagado) }} BS
                              </td>
                              <td>
                                  {{  $factura->total_dolar }} USD
                              </td>
                              <td>
                                 @if ($factura->status == 1)
                                    <span class="badge bg-primary">PAGADO</span>
                                 @elseif ($factura->status == 2)
                                    <span class="badge bg-info">PENDIENTE</span>
                                 @else
                                    <span class="badge bg-danger">ANULADO</span>
                                 @endif
                              </td>

                              </tr>
                             
                              </tbody>
                                
                            </table>
                          </div>
                         
                      </div>
                  </div>
                  <div class="card-footer">
                    <a class="btn btn-primary" href="{{ url('facturas/autorizada/'.$factura->id) }}"> Autorizar</a>
                  </div>
              </div>
          </div>
      </div>
    </div>


@endsection