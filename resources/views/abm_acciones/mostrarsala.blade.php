@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
            <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url()->previous() !!}">
                <h2>Mostrar Sala:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Nombre: </label>
                        <input type="text" name="nombre" value="{{$salaSeleccionada->Nombre}}" class="form-control" maxlength="50" disabled>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Capacidad: </label>
                        <input type="text" name="capacidad" value="{{$salaSeleccionada->Capacidad}}" class="form-control" maxlength="50" disabled>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Altura Maxima: </label>
                        <input type="text" name="alturamax" value="{{$salaSeleccionada->AlturaMax}}" class="form-control" maxlength="50" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Puntos Colgado: </label>
                        <input type="text" name="puntoscolgado" value="{{$salaSeleccionada->PuntosColgado}}" class="form-control" maxlength="50" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Uso de Energia: </label>
                        <input type="text" name="usoenergia" value="{{$salaSeleccionada->UsoEnergia}}" class="form-control" maxlength="50" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label>Notas: </label>
                    <textarea class="form-control" name="notas" rows="3" maxlength="500" resize="none" disabled>{{$salaSeleccionada->Notas}}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Volver</button>
            </form>
    </div>

@endsection
