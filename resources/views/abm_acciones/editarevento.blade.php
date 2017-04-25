@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
    <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url("abm_acciones/actualizarevento/".$evento->CD_Evento) !!}"">
                <h2>Editar un Evento:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre: (*)</label>
                        <input type="text" name="nombre" value="{{$evento->Nombre}}" class="form-control" required>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Cliente: (*)</label>
                        <select class="form-control" name="cliente" required>
                            @foreach($cliente as $clnt)
                                <option value="{{ $clnt->CD_Cliente }}">{{ $clnt->Nombre }}</option>
                            @endforeach
                            @foreach($listaclientes as $clientes)
                                @if($clientes->CD_Cliente == $evento->CD_Cliente || $clientes->CD_ClienteTipo == 4)
                                    @continue
                                @endif
                                <option value="{{ $clientes->CD_Cliente }}">{{ $clientes->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Cliente Final: </label>
                        <select class="form-control" name="clientefinal">
                          @if($evento->CD_ClienteFinal == NULL)
                            <option value="">Seleccione uno:</option>
                          @endif
                            @foreach($clientefinal as $final)
                              <option value="{{ $final->CD_Cliente }}">{{ $final->Nombre }}</option>
                            @endforeach
                            @foreach($listaclientes as $clientes)
                                @if($clientes->CD_Cliente == $evento->CD_ClienteFinal || $clientes->CD_ClienteTipo != 4)
                                    @continue
                                @endif
                                <option value="{{ $clientes->CD_Cliente }}">{{ $clientes->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Tipo Evento: (*)</label>
                        <select class="form-control" name="eventotipo" required>
                            @foreach($eventotipo as $tipo)
                                <option value="{{ $tipo->CD_EventoTipo }}">{{ $tipo->Descripcion }}</option>
                            @endforeach
                            @foreach($listatipoeventos as $tipoeventos)
                                @if($tipoeventos->CD_EventoTipo == $evento->CD_EventoTipo)
                                    @continue
                                @endif
                                <option value="{{ $tipoeventos->CD_EventoTipo }}">{{ $tipoeventos->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Frecuencia Evento: (*)</label>
                        <select class="form-control" name="eventofrecuencia" required>
                            @foreach($eventofrecuencia as $frecuencia)
                                <option value="{{ $frecuencia->CD_EventoFrecuencia }}">{{ $frecuencia->Descripcion }}</option>
                            @endforeach
                            @foreach($listafrecuenciaevento as $frecevento)
                                @if($frecevento->CD_EventoFrecuencia == $evento->CD_EventoFrecuencia)
                                    @continue
                                @endif
                                <option value="{{ $frecevento->CD_EventoFrecuencia }}">{{ $frecevento->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Estado del Evento: (*)</label>
                        <select class="form-control" name="eventoestado" required>
                            @foreach($eventoestado as $estado)
                                <option value="{{$estado->CD_EventoEstado}}">{{$estado->Descripcion}}</option>
                            @endforeach
                            @foreach($listaestadoeventos as $estadoeventos)
                                @if($estadoeventos->CD_EventoEstado == $evento->CD_EventoEstado)
                                    @continue
                                @endif
                                <option value="{{ $estadoeventos->CD_EventoEstado }}">{{ $estadoeventos->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-4 form-group">
                      <label>Venue: (*)</label>
                      <select class="form-control" name="venue" required>
                          @foreach($venue as $vn)
                              <option value="{{$vn->CD_Venue}}">{{$vn->Nombre}}</option>
                          @endforeach
                          @foreach($listavenues as $venues)
                              @if($venues->CD_Venue == $evento->CD_Venue)
                                  @continue
                              @endif
                              <option value="{{ $venues->CD_Venue }}">{{ $venues->Nombre }}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-md-2">
                      <button type="button" id="agregar-salas" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Agregrar Salas</button>
                  </div>
                </div>

                <div id="salas-js" class="row">
                  @foreach($eventosalas as $salas)
                    <div class="col-md-2 form-group">
                      <label>Sala y Asistentes:</label>
                      <a id="eliminar-sala"><span class="glyphicon glyphicon-remove borrar-salas-glyph"></span></a>
                        <select class="form-control" name="sala[]" required>
                              <option value="{{$salas->CD_VenueSala}}">{{$salas->Nombre}}</option> // Seguir aca
                        </select>
                      <input type="text" name="asistentes[]" class="form-control" value="{{$salas->Asistentes}}" required>
                    </div>
                  @endforeach
                </div>

                <div class="row">
                    <div class="col-md-2 form-group">
                        <label>Fecha Evento (Desde): (*)</label>
                        <input type="date" name="fechadesde" value="{{$evento->FechaDesde}}" class="form-control" required>
                    </div>

                    <div class="col-md-2 form-group">
                        <label>Fecha Evento (Hasta): (*)</label>
                        <input type="date" name="fechahasta" value="{{$evento->FechaHasta}}" class="form-control" required>
                    </div>

                    <div class="col-md-2 form-group checkbox-posicion">
                        <label class="checkbox-inline"><input type="checkbox" name="fechaconfirmada" value="{{$evento->FechaConfirmada}}" {{$evento->FechaConfirmada == 1 ? 'checked' : ''}}>Fecha Confirmada</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 form-group">
                        <label>Fecha de Armado (Desde):</label>
                        <input type="date" name="fechaarmadodesde" value="{{$evento->FechaArmadoDesde}}" class="form-control">
                    </div>

                    <div class="col-md-2 form-group">
                        <label>Fecha de Armado (Hasta):</label>
                        <input type="date" name="fechaarmadohasta" value="{{$evento->FechaArmadoHasta}}" class="form-control">
                    </div>
                    <div class="col-md-3 form-group checkbox-posicion">
                        <label class="checkbox-inline"><input type="checkbox" name="fechaarmadoconfirmada" value="{{$evento->FechaArmadoConfirmada}}" {{$evento->FechaArmadoConfirmada == 1 ? 'checked' : ''}}>Fecha Armado Confirmada</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Usuario: (*)</label>
                        <select class="form-control" name="usuario" required>
                            @foreach($user as $usr)
                                <option value="{{$usr->id}}">{{$usr->name}}</option>
                            @endforeach
                            @foreach($listausuarios as $usuarios)
                                @if($usuarios->id == $evento->CD_Usuario)
                                    @continue
                                @endif
                                <option value="{{ $usuarios->id }}">{{ $usuarios->name }}</option>
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
                            @foreach($listacondpagos as $condpagos)
                                @if($condpagos->CD_CondPago == $evento->CD_CondPago)
                                    @continue
                                @endif
                                <option value="{{ $condpagos->CD_CondPago }}">{{ $condpagos->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Codificacion de Evento: (*)</label>
                        <select class="form-control" name="eventocodificacion" required>
                            @foreach($eventocodificacion as $codificacion)
                                <option value="{{$codificacion->CD_EventoCodificacion}}">{{$codificacion->Descripcion}}</option>
                            @endforeach
                            @foreach($listacodificacioneventos as $codeventos)
                                @if($codeventos->CD_EventoCodificacion == $evento->CD_EventoCodificacion)
                                    @continue
                                @endif
                                <option value="{{ $codeventos->CD_EventoCodificacion }}">{{ $codeventos->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1 form-group">
                        <label>Presupuesto: </label>
                        <input type="text" name="presupuesto" value="{{$evento->NumeroPresupuesto}}" class="form-control">
                    </div>

                    <div class="col-md-1 form-group checkbox-posicion">
                        <label class="checkbox-inline"><input type="checkbox" name="licitacion" value="{{$evento->Licitacion}}" {{$evento->Licitacion == 1 ? 'checked' : ''}}>Licitacion </label>
                    </div>
                </div>



                <div class="form-group">
                    <label>Notas: </label>
                    <textarea class="form-control" name="notas" rows="3" maxlength="500" resize="none">{{$evento->Notas}}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
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
