@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
            <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="">
                <h2>Mostrar un Servicio:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Evento: (*)</label>
                        <select class="form-control" name="evento" disabled>
                            <option value="">{{$servicio->Evento->Nombre}}</option>
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Sala Venue: (*)</label>
                        <select class="form-control" name="venuesala" disabled>
                            <option value="">{{$servicio->VenueSala->Nombre}}</option>
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Servicio: (*)</label>
                        <select class="form-control" name="servicio" disabled>
                            <option value="">{{$servicio->ServicioTipo->Descripcion}}</option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label>Total: </label>
                        <input type="text" name="total" value="{{$servicio->Total}}" class="form-control" maxlength="50" disabled>
                    </div>
                </div>

                <a href="{!! url()->previous() !!}"><button type="button" class="btn btn-success">Volver</button></a>
            </form>
    </div>

@endsection
