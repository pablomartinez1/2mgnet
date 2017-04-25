@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
            <div id="boton-cerrar-form"><a href="{!! url('/abm/contrataciones') !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url('/crearcontratacion') !!}">
                <h2>Agregar una nueva Contratacion:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Evento: (*)</label>
                        <select class="form-control" name="evento" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($eventos as $evento)
                                <option value="{{$evento->CD_Evento}}">{{$evento->Nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Proveedor: (*)</label>
                        <select class="form-control" name="proveedor" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{$proveedor->CD_Proveedor}}">{{$proveedor->Nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Condicion Pago: (*)</label>
                        <select class="form-control" name="condpago" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($condpago as $pago)
                                <option value="{{$pago->CD_CondPago}}">{{$pago->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label>Total: </label>
                        <input type="text" name="total" placeholder="Total" class="form-control" maxlength="50" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
    </div>

@endsection
