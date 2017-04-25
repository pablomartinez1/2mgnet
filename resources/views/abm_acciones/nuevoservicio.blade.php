@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
            <div id="boton-cerrar-form"><a href="{!! url('/abm/servicios') !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url('/crearservicio') !!}">
                <h2>Agregar un nuevo Servicio:</h2>

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
                        <label>Sala Venue: (*)</label>
                        <select class="form-control" name="venuesala" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($venuesalas as $salas)
                                <option value="{{$salas->CD_VenueSala}}">{{$salas->Nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Servicio: (*)</label>
                        <select class="form-control" name="servicio" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($tiposervicio as $tipo)
                                <option value="{{$tipo->CD_Servicio}}">{{$tipo->Descripcion}}</option>
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
