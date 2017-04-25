@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
            <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="">
                <h2>Mostrar una Contratacion:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Evento: (*)</label>
                        <select class="form-control" name="evento" disabled>
                              <option value="">{{ $contratacion->Evento->Nombre }}</option>
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Proveedor: (*)</label>
                        <select class="form-control" name="proveedor" disabled>
                              <option value="">{{ $contratacion->Proveedor->Nombre }}</option>
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Condicion Pago: (*)</label>
                        <select class="form-control" name="condpago" disabled>
                            <option value="">{{$contratacion->CondPago->Descripcion}}</option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label>Total: </label>
                        <input type="text" name="total" value="{{$contratacion->Total}}" class="form-control" disabled>
                    </div>
                </div>

                <a href="{!! url()->previous() !!}"><button type="button" class="btn btn-success">Volver</button></a>
            </form>
    </div>

@endsection
