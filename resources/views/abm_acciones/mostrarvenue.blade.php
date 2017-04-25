@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')
    <div id="div-agregado" class="container">
    <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <div id="form-agregar-cliente" class="form-group"">
                <h2>Mostrar un Venue:</h2>

                <div class="form-group">
                    <label>Nombre: (*)</label>
                    <input type="text" name="nombre" value="{{$venue->Nombre}}" class="form-control" maxlength="80" disabled>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Pais: (*)</label>
                        <select class="form-control" name="pais" disabled>
                            @foreach($paises as $pais)
                                <option value="{{$pais->CD_Pais}}">{{$pais->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Provincia: </label>
                        <select class="form-control" name="provincia" disabled>
                            @foreach($provincias as $provincia)
                                <option value="{{$provincia->CD_Provincia}}">{{$provincia->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Localidad: </label>
                        <input type="text" name="localidad" value="{{$venue->Localidad}}" class="form-control" maxlength="40" disabled>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Calle: </label>
                        <input type="text" name="calle" value="{{$venue->Calle}}" class="form-control" maxlength="50" disabled>
                    </div>

                    <div class="col-md-3">
                        <label>Codigo Postal: </label>
                        <input type="text" name="codpostal" value="{{$venue->CodPostal}}" class="form-control" maxlength="12" disabled>
                    </div>

                    <div class="col-md-3">
                        <label>CUIT: </label>
                        <input type="text" id="cuit" name="cuit" value="{{$venue->CUIT}}" class="form-control" maxlength="15" disabled>
                    </div>
                </div>

                <div id="div-telefonos" class="row form-group">
                  @foreach($telefonos as $telefono)
                      <div id="numeros-telefono" class="col-md-2">
                          <label>Telefono: </label>
                              <input type="text" id="telefono" name="telefono" value="{{ $telefono->Telefono }}" class="form-control" maxlength="30" disabled>
                          <select class="form-control" name="tipotelefono" id="exampleSelect1" disabled>
                              <option value="{{ $telefono->CD_TelefonoTipo }}">{{ $telefono->Descripcion }}</option>

                          </select>
                      </div>
                  @endforeach
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label>Web: </label>
                        <input type="text" name="web" value="{{$venue->Web}}" class="form-control" maxlength="50" disabled>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Situacion Iva: </label>
                        <select class="form-control" name="situacioniva" disabled>
                            @foreach($situacioniva as $sitiva)
                                <option value="{{$sitiva->CD_SituacionIVA}}">{{$sitiva->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label>Comisión: </label>
                        <input type="text" id="comision" name="comision" value="{{$venue->Comision}}" class="form-control" maxlength="6" disabled>
                    </div>

                    <div class="col-md-5">
                        <label>Tipo Venue: </label>
                        <select class="form-control" name="venuetipo" disabled>
                            @foreach($venuetipo as $tipo)
                                <option value="{{$tipo->CD_VenueTipo}}">{{$tipo->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                  @foreach($contactos as $contacto)
                      <div class="col-md-12">
                          <label>Contacto: </label>
                          <select class="form-control" name="contacto" disabled>
                              <option value=""> {{ $contacto->Nombre }} </option>
                          </select>
                      </div>
                  @endforeach
                </div>

                <div class="form-group">
                    <label>Notas: </label>
                    <textarea class="form-control" name="notas" rows="3" maxlength="500" resize="none" disabled> {{$venue->Notas }}</textarea>
                </div>

                <a href="{!! url()->previous() !!}"><button type="button" class="btn btn-success">Volver</button></a>
            </div>
    </div>

@endsection
