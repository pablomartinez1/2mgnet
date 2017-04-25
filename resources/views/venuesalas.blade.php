@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')
    <div class="container">
        <h1>Lista de Salas</h1>
    </div>

    <div class="container">
        <form class="form-group" method="post" action="{!! url('/abm/venuesalas') !!}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row">
                <div class="col-md-1"><p class="filtro-texto"><strong>Venue:</strong></p></div>
                <div class="col-md-9">
                    <select class="form-control" name="venue" required>
                        @if(!empty($venueSeleccionado))
                            <option value="{{$venueSeleccionado->CD_Venue}}">{{$venueSeleccionado->Nombre}}</option>
                        @else
                            <option value="">Seleccione uno:</option>
                        @endif

                        @foreach($venues as $venue)
                            @if(!empty($venueSeleccionado) && $venueSeleccionado->CD_Venue == $venue->CD_Venue)
                                @continue
                            @endif
                            <option value="{{$venue->CD_Venue}}">{{$venue->Nombre}}</option>
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
      @if(!empty($venueSeleccionado))
      <form class="form-group" method="post" action="{!! url('/crearvenuesalas') !!}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="hidden" name="venue" value="{{$venueSeleccionado->CD_Venue}}">

        <div class="row form-group">
            <div class="col-md-2">
                <a href="{!! url("abm_acciones/nuevasala/".$venueSeleccionado->CD_Venue) !!}"" class="btn btn-primary" id="boton-nuevo-cliente"><span class="glyphicon glyphicon-plus"></span> Nueva Sala</a>
            </div>
        </div>

        @if(!empty($venueSalas))
        <div id="clientesActuales" class="container panel-body table-responsive mostrar-lista cambiar-zindex">
            <table class="table table-bordered table-striped table-condensed table-hover table-list-search">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Capacidad</th>
                        <th>Altura Maxima</th>
                        <th class="col-md-2">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venueSalas as $vs)
                        <tr>
                            <td>{{$vs->Nombre}}</td>
                            <td>{{$vs->Capacidad}}</td>
                            <td>{{$vs->AlturaMax}}</td>
                            <td>
                                <a href="{!! url("abm_acciones/mostrarsala/".$vs->CD_VenueSala) !!}""><span class="label label-primary">Mostrar</span></a>
                                @if($vs->FechaBaja == NULL)
                                <a href="{!! url("abm_acciones/editarsala/".$vs->CD_VenueSala) !!}""><span class="label label-success">Editar</span></a>
                                <a href="{!! url("/eliminarsalas/".$vs->CD_VenueSala) !!}"><span class="label label-danger">Eliminar</span></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        @endif
    </div>

@endsection
