@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')
    <div class="container">
        <h1>Lista de Contrataciones</h1>
    </div>

    <div class="container">
        <form class="form-group" method="post" action="{!! url('/abm/contrataciones') !!}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row">
                <div class="col-md-1"><p class="filtro-texto"><strong>Evento:</strong></p></div>
                <div class="col-md-9">
                    <select class="form-control" name="evento" required>
                        @if(!empty($eventoSeleccionado))
                            <option value="{{$eventoSeleccionado->CD_Evento}}">{{$eventoSeleccionado->Nombre}}</option>
                        @else
                            <option value="">Seleccione uno:</option>
                        @endif

                        @foreach($eventos as $evento)
                            @if(!empty($eventoSeleccionado) && $eventoSeleccionado->CD_Evento == $evento->CD_Evento)
                                @continue
                            @endif
                            <option value="{{$evento->CD_Evento}}">{{$evento->Nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
      @if(!empty($eventoSeleccionado))
      <form class="form-group" method="post" action="{!! url('/crearcontratacion') !!}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="hidden" name="evento" value="{{$eventoSeleccionado->CD_Evento}}">

        <div class="row form-group">
            <div class="col-md-2">
                <button type="button" id="agregar-contratacion" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Agregrar Contratacion</button>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Guardar Contrataciones</button>
            </div>
        </div>

        @if(!empty($eventoContrataciones))
          <div id="contrataciones-js">
            @foreach($eventoContrataciones as $ec)
            <div class="row form-group">
                <div class="col-md-4">
                  <label>Proveedor: </label>
                  <select class="form-control" name="proveedor[]" required>
                      <option value="{{$ec->CD_Proveedor}}">{{$ec->Proveedor->Nombre}}</option>
                      @foreach($proveedores as $proveedor)
                        @if($proveedor->CD_Proveedor == $ec->CD_Proveedor)
                          @continue
                        @endif
                          <option value="{{$proveedor->CD_Proveedor}}">{{$proveedor->Nombre}}</option>
                      @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <label>Condicion de Pago: </label>
                  <select class="form-control" name="condpago[]" required>
                      <option value="{{$ec->CD_CondPago}}">{{$ec->CondPago->Descripcion}}</option>
                      @foreach($condpago as $pago)
                        @if($pago->CD_CondPago == $ec->CD_CondPago)
                          @continue
                        @endif
                          <option value="{{$pago->CD_CondPago}}">{{$pago->Descripcion}}</option>
                      @endforeach
                  </select>
                </div>

                <div class="col-md-2">
                  <label>Total: </label>
                  <input type="text" class="form-control" name="total[]" value="{{$ec->Total}}" required />
                </div>

                <div class="col-md-1">
                  <button type="button" id="eliminar-opcion-contratacion" class="btn btn-danger"><span class="glyphicon glyphicon-minus"></span></button>
                </div>
            </div>
            @endforeach
          </div>
        @endif
      </form>
      @endif
    </div>

    <script>
        $(document).ready(function(){
          $('#agregar-contratacion').click(function(e) {
            event.preventDefault();

            $('#contrataciones-js').append('<div class="row form-group"><div class="col-md-4"><label>Proveedor: </label><select class="form-control" name="proveedor[]" required><option value="">Seleccione uno: </option>@foreach($proveedores as $proveedor)<option value="{{$proveedor->CD_Proveedor}}">{{$proveedor->Nombre}}</option>@endforeach</select></div><div class="col-md-4"><label>Condicion de Pago: </label><select class="form-control" name="condpago[]" required><option value="">Seleccione uno:</option>@foreach($condpago as $pago)<option value="{{$pago->CD_CondPago}}">{{$pago->Descripcion}}</option>@endforeach</select></div><div class="col-md-2"><label>Total: </label><input type="text" class="form-control" name="total[]" required /></div><div class="col-md-1"><button type="button" id="eliminar-opcion-contratacion" class="btn btn-danger"><span class="glyphicon glyphicon-minus"></span></button></div></div>');
          });

          $('body').on('click', '#eliminar-opcion-contratacion', function(e) {
            $(this).parent().parent('div').remove();
          });
        })
    </script>

@endsection
