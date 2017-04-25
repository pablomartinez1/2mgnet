@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
    <div id="boton-cerrar-form"><a href="{!! url('/abm/eventos') !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url('/crearevento') !!}">
                <h2>Agregar un nuevo Evento:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre: (*)</label>
                        <input type="text" name="nombre" placeholder="Nombre" class="form-control" maxlength="45" required>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Cliente: (*)</label>
                        <select class="form-control" name="cliente" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($clientes as $cliente)
                                @if($cliente->FechaBaja != NULL || $cliente->CD_ClienteTipo == 4)
                                    @continue
                                @endif
                                <option value="{{$cliente->CD_Cliente}}">{{$cliente->Nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Cliente Final: </label>
                        <select class="form-control" name="clientefinal">
                            <option value="">Seleccione uno:</option>
                            @foreach($clientes as $cliente)
                                @if($cliente->FechaBaja != NULL || $cliente->CD_ClienteTipo != 4)
                                    @continue
                                @endif
                                <option value="{{$cliente->CD_Cliente}}">{{$cliente->Nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Tipo Evento: (*)</label>
                        <select class="form-control" name="eventotipo" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($eventotipo as $tipo)
                                <option value="{{$tipo->CD_EventoTipo}}">{{$tipo->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Frecuencia Evento: (*)</label>
                        <select class="form-control" name="eventofrecuencia" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($eventofrecuencia as $frecuencia)
                                <option value="{{$frecuencia->CD_EventoFrecuencia}}">{{$frecuencia->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Estado del Evento: (*)</label>
                        <select class="form-control" name="eventoestado" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($eventoestado as $estado)
                                <option value="{{$estado->CD_EventoEstado}}">{{$estado->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-4 form-group">
                      <label>Venue: (*)</label>
                      <select class="form-control" name="venue" required>
                          <option value="">Seleccione uno:</option>
                          @foreach($venues as $venue)
                              <option value="{{$venue->CD_Venue}}">{{$venue->Nombre}}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-md-2">
                      <button type="button" id="agregar-salas" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Agregrar Salas</button>
                  </div>
                </div>

                <div id="salas-js" class="row">

                </div>

                <div class="row">
                    <div class="col-md-2 form-group">
                        <label>Fecha Evento (Desde): (*)</label>
                        <input type="date" name="fechadesde" class="form-control" required>
                    </div>

                    <div class="col-md-2 form-group">
                        <label>Fecha Evento (Hasta): (*)</label>
                        <input type="date" name="fechahasta" class="form-control" required>
                    </div>

                    <div class="col-md-2 form-group checkbox-posicion">
                        <label class="checkbox-inline"><input type="checkbox" name="fechaconfirmada" value="1">Fecha Confirmada</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 form-group">
                        <label>Fecha de Armado (Desde): </label>
                        <input type="date" name="fechaarmadodesde" class="form-control" maxlength="45" >
                    </div>

                    <div class="col-md-2 form-group">
                        <label>Fecha de Armado (Hasta): </label>
                        <input type="date" name="fechaarmadohasta" class="form-control" maxlength="45">
                    </div>
                    <div class="col-md-3 form-group checkbox-posicion">
                        <label class="checkbox-inline"><input type="checkbox" name="fechaarmadoconfirmada" value="1">Fecha Armado Confirmada</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Usuario: (*)</label>
                        <select class="form-control" name="usuario" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Condicion de Pago: </label>
                        <select class="form-control" name="condpago">
                            <option value="">Seleccione uno:</option>
                            @foreach($condpago as $pago)
                                <option value="{{$pago->CD_CondPago}}">{{$pago->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Codificacion de Evento: (*)</label>
                        <select class="form-control" name="eventocodificacion" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($eventocodificacion as $codificacion)
                                <option value="{{$codificacion->CD_EventoCodificacion}}">{{$codificacion->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1 form-group">
                        <label>Presupuesto: </label>
                        <input type="text" name="presupuesto" class="form-control" maxlength="30">
                    </div>

                    <div class="col-md-1 form-group checkbox-posicion">
                        <label class="checkbox-inline"><input type="checkbox" name="licitacion" value="1">Licitacion </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Notas: </label>
                    <textarea class="form-control" name="notas" rows="3" maxlength="500" resize="none"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
    </div>

    <script>
    $(document).ready(function(){
      $('#agregar-salas').click(function(e) {
        event.preventDefault();

        $('#salas-js').append('<div class="col-md-2 form-group"><label>Sala y Asistentes:</label><a id="eliminar-sala"><span class="glyphicon glyphicon-remove borrar-salas-glyph"></span></a><div><select class="form-control" name="sala[]" required><option value="">Seleccione uno:</option>@foreach($venuesalas as $salas)<option value="{{$salas->CD_VenueSala}}">{{$salas->Nombre}}</option>@endforeach</select><input type="text" name="asistentes[]" class="form-control" placeholder="Asistentes..." required></div></div>');
      });

      $('body').on('click', '#eliminar-sala', function(e) {
        $(this).parent('div').remove();
      });
    })
    </script>

@endsection
