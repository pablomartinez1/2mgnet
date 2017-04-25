@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
            <div id="boton-cerrar-form"><a href="{!! url('/abm/contrataciones') !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url("abm_acciones/actualizarcontratacion/".$contratacion->CD_Evento) !!}"">
                <h2>Editar una Contratacion:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Evento: (*)</label>
                        <select class="form-control" name="evento" required>
                            <option value="{{$contratacion->CD_Evento}}">{{$contratacion->Evento->Nombre}}</option>
                            @foreach($eventos as $evento)
                              @if($evento->CD_Evento == $contratacion->CD_Evento)
                                @continue
                              @endif
                              <option value="{{$evento->CD_Evento}}">{{$evento->Nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Proveedor: (*)</label>
                        <select class="form-control" name="proveedor" required>
                            <option value="{{$contratacion->CD_Proveedor}}">{{$contratacion->Proveedor->Nombre}}</option>
                            @foreach($proveedores as $proveedor)
                              @if($proveedor->CD_Proveedor == $contratacion->CD_Proveedor)
                                @continue
                              @endif
                              <option value="{{$proveedor->CD_Proveedor}}">{{$proveedor->Nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Condicion Pago: (*)</label>
                        <select class="form-control" name="condpago" required>
                          <option value="{{$contratacion->CD_CondPago}}">{{$contratacion->CondPago->Descripcion}}</option>
                          @foreach($condpago as $pago)
                            @if($pago->CD_CondPago == $contratacion->CD_CondPago)
                              @continue
                            @endif
                            <option value="{{$pago->CD_CondPago}}">{{$pago->Descripcion}}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label>Total: </label>
                        <input type="text" name="total" value="{{$contratacion->Total}}" class="form-control" maxlength="50" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
    </div>

@endsection
