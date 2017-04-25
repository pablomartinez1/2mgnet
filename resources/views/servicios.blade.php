@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')
    <div class="container">
        <h1>Lista de Servicios</h1>
    </div>

    <div class="container">
        <form class="form-group" method="post" action="{!! url('/abm/servicios') !!}">

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
      <form class="form-group" method="post" action="{!! url('/crearservicio') !!}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="hidden" name="evento" value="{{$eventoSeleccionado->CD_Evento}}">

        <div class="row form-group">
            <div class="col-md-2">
                <button type="button" id="agregar-servicio" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Agregrar Servicio</button>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Guardar Servicios</button>
            </div>
        </div>

        @if(!empty($eventoServicios))
          <div id="servicios-js">
            @foreach($eventoServicios as $es)
            <div class="row form-group">
                <div class="col-md-4">
                  <label>Sala Venue: </label>
                  <select class="form-control" name="venuesalas[]" required>
                      <option value="{{$es->CD_VenueSala}}">{{$es->VenueSala->Nombre}}</option>
                      @foreach($eventosalas as $eventosala)
                        @if($eventosala->CD_VenueSala == $es->CD_VenueSala)
                          @continue
                        @endif
                          <option value="{{$eventosala->CD_VenueSala}}">{{$eventosala->Nombre}}</option>
                      @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <label>Servicio: </label>
                  <select class="form-control" name="serviciostipo[]" required>
                      <option value="{{$es->CD_Servicio}}">{{$es->ServicioTipo->Descripcion}}</option>
                      @foreach($serviciostipo as $tipo)
                        @if($tipo->CD_Servicio == $es->CD_Servicio)
                          @continue
                        @endif
                          <option value="{{$tipo->CD_Servicio}}">{{$tipo->Descripcion}}</option>
                      @endforeach
                  </select>
                </div>

                <div class="col-md-2">
                  <label>Total: </label>
                  <input type="text" class="form-control" name="total[]" value="{{$es->Total}}" required />
                </div>

                <div class="col-md-1">
                  <button type="button" id="eliminar-opcion-servicio" class="btn btn-danger"><span class="glyphicon glyphicon-minus"></span></button>
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
      $('#agregar-servicio').click(function(e) {
        event.preventDefault();

        $('#servicios-js').append('<div class="row form-group"><div class="col-md-4"><label>Sala Venue: </label><select class="form-control" name="venuesalas[]" required><option value="">Seleccione uno: </option>@foreach($eventosalas as $eventosala)<option value="{{$eventosala->CD_VenueSala}}">{{$eventosala->Nombre}}</option>@endforeach</select></div><div class="col-md-4"><label>Servicio: </label><select class="form-control" name="serviciostipo[]" required><option value="">Seleccione uno: </option>@foreach($serviciostipo as $tipo)<option value="{{$tipo->CD_Servicio}}">{{$tipo->Descripcion}}</option>@endforeach</select></div><div class="col-md-2"><label>Total: </label><input type="text" class="form-control" name="total[]" required /></div><div class="col-md-1"><button type="button" id="eliminar-opcion-servicio" class="btn btn-danger"><span class="glyphicon glyphicon-minus"></span></button></div></div>');
      });

      $('body').on('click', '#eliminar-opcion-servicio', function(e) {
        $(this).parent().parent('div').remove();
      });
    })
    </script>

@endsection
