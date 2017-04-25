@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
    <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <div id="form-agregar-cliente" class="form-group"">
                <h2>Mostrar un Evento:</h2>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre: </label>
                        <input type="text" name="nombre" value="{{ $evento->Nombre }}" class="form-control" maxlength="45" disabled>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Cliente: </label>
                        <select class="form-control" name="cliente" disabled>
                            @foreach($cliente as $clnt)
                                <option value="{{ $clnt->CD_Cliente }}">{{ $clnt->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Cliente Final: </label>
                        <select class="form-control" name="clientefinal" disabled>
                          @foreach($clientefinal as $final)
                              <option value="{{ $final->CD_Cliente }}">{{ $final->Nombre }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Tipo Evento: </label>
                        <select class="form-control" name="eventotipo" disabled>
                            @foreach($eventotipo as $tipo)
                                <option value="{{ $tipo->CD_EventoTipo }}">{{ $tipo->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Frecuencia Evento: </label>
                        <select class="form-control" name="eventofrecuencia" disabled>
                            @foreach($eventofrecuencia as $frecuencia)
                                <option value="{{ $frecuencia->CD_EventoFrecuencia }}">{{ $frecuencia->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Estado del Evento: </label>
                        <select class="form-control" name="eventoestado" disabled>
                            @foreach($eventoestado as $estado)
                                <option value="{{$estado->CD_EventoEstado}}">{{$estado->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-4 form-group">
                      <label>Venue: </label>
                      <select class="form-control" name="venue" disabled>
                          @foreach($venue as $vn)
                              <option value="{{$vn->CD_Venue}}">{{$vn->Nombre}}</option>
                          @endforeach
                      </select>
                  </div>
                </div>

                <div class="row">
                  @foreach($eventosalas as $salas)
                    <div class="col-md-2 form-group">
                      <label>Sala y Asistentes:</label>
                        <select class="form-control" name="sala[]" disabled>
                              <option value="">{{$salas->Nombre}}</option> // Seguir aca
                        </select>
                      <input type="text" name="asistentes[]" class="form-control" value="{{$salas->Asistentes}}" disabled>
                    </div>
                  @endforeach
                </div>

                <div class="row">
                    <div class="col-md-2 form-group">
                        <label>Fecha Evento (Desde): </label>
                        <input type="date" name="fechadesde" value="{{$evento->FechaDesde}}" class="form-control" disabled>
                    </div>

                    <div class="col-md-2 form-group">
                        <label>Fecha Evento (Hasta): </label>
                        <input type="date" name="fechahasta" value="{{$evento->FechaHasta}}" class="form-control" disabled>
                    </div>

                    <div class="col-md-2 form-group checkbox-posicion">
                        <label class="checkbox-inline"><input type="checkbox" name="fechaconfirmada" {{ $evento->FechaConfirmada == 1 ? 'checked' : '' }} disabled>Fecha Confirmada</label>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-2 form-group">
                      <label>Fecha de Armado (Desde): </label>
                      <input type="date" name="fechaarmadodesde" class="form-control" value="{{$evento->FechaArmadoDesde}}" disabled>
                  </div>

                  <div class="col-md-2 form-group">
                      <label>Fecha de Armado (Hasta): </label>
                      <input type="date" name="fechaarmadohasta" class="form-control" value="{{$evento->FechaArmadoHasta}}" disabled>
                  </div>
                  <div class="col-md-3 form-group checkbox-posicion">
                      <label class="checkbox-inline"><input type="checkbox" name="fechaarmadoconfirmada" {{ $evento->FechaArmadoConfirmada == 1 ? 'checked' : '' }} disabled>Fecha Armado Confirmada</label>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Usuario: </label>
                        <select class="form-control" name="usuario" disabled>
                            @foreach($user as $usr)
                                <option value="{{$usr->id}}">{{$usr->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Condicion de Pago: </label>
                        <select class="form-control" name="condpago" disabled>
                            @foreach($condpago as $pago)
                                <option value="{{$pago->CD_CondPago}}">{{$pago->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Codificacion de Evento: </label>
                        <select class="form-control" name="eventocodificacion" disabled>
                            @foreach($eventocodificacion as $codificacion)
                                <option value="{{$codificacion->CD_EventoCodificacion}}">{{$codificacion->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1 form-group">
                        <label>Presupuesto: </label>
                        <input type="text" name="presupuesto" value="{{$evento->NumeroPresupuesto}}" class="form-control" disabled>
                    </div>

                    <div class="col-md-1 form-group checkbox-posicion">
                        <label class="checkbox-inline"><input type="checkbox" name="licitacion" {{ $evento->Liciatacion == 1 ? 'checked' : '' }} disabled>Licitacion </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Notas: </label>
                    <textarea class="form-control" name="notas" rows="3" resize="none" disabled>{{ $evento->Notas }}</textarea>
                </div>

                <a href="{!! url()->previous() !!}"><button type="button" class="btn btn-success">Volver</button></a>
            </div>
    </div>

@endsection
