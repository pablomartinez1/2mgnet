@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')
    <div id="div-agregado" class="container">
    <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <div id="form-agregar-cliente" class="form-group"">
                <h2>Mostrar un Cliente:</h2>

                <div class="form-group">
                    <label>Nombre: </label>
                    <input type="text" name="nombre" value="{{ $cliente->Nombre }}" class="form-control" maxlength="50" disabled>
                </div>

                <div class="form-group">
                    <label>Razon Social: </label>
                    <input type="text" name="razonsocial" value="{{ $cliente->RazonSocial }}" class="form-control" maxlength="50" disabled>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Pais: </label>
                        <select class="form-control" name="pais" id="exampleSelect1" disabled>
                          @if($cliente->CD_Pais != NULL)
                            <option>{{ $cliente->Pais->Descripcion }}</option>
                          @endif
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Provincia: </label>
                        <select class="form-control" name="provincia" id="exampleSelect1" disabled>
                          @if($cliente->CD_Provincia != NULL)
                            <option>{{ $cliente->Provincia->Descripcion }}</option>
                          @endif
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Localidad: </label>
                        <input type="text" id="cuit" name="localidad" value="{{ $cliente->Localidad }}" class="form-control" maxlength="40" disabled>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Calle: </label>
                        <input type="text" name="calle" value="{{ $cliente->Calle }}" class="form-control" maxlength="50" disabled>
                    </div>

                    <div class="col-md-3">
                        <label>Codigo Postal: </label>
                        <input type="text" name="codpostal" value="{{ $cliente->CodPostal }}" class="form-control" maxlength="12" disabled>
                    </div>

                    <div class="col-md-3">
                        <label>CUIT: </label>
                        <input type="text" id="cuit" name="cuit" value="{{ $cliente->CUIT }}" class="form-control" maxlength="15" disabled>
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
                        <input type="text" name="web" value="{{ $cliente->Web }}" class="form-control" maxlength="50" disabled>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Situacion Iva: </label>
                        <select class="form-control" name="situacioniva" id="exampleSelect1" disabled>
                          @if($cliente->CD_SituacionIva != NULL)
                            <option>{{ $cliente->SituacionIva->Descripcion }}</option>
                          @endif
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label>Comisión: </label>
                        <input type="text" name="comision" value="{{ $cliente->Comisión }}" class="form-control" maxlength="6" disabled>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Tipo Cliente: </label>
                        <select class="form-control" name="clientetipo" id="exampleSelect1" disabled>
                          @if($cliente->CD_ClienteTipo != NULL)
                            <option>{{ $cliente->ClienteTipo->Descripcion }}</option>
                          @endif
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Canal: </label>
                        <select class="form-control" name="canal" id="exampleSelect1" disabled>
                          @if($cliente->CD_Canal != NULL)
                            <option>{{ $cliente->Canal->Descripcion }}</option>
                          @endif
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Rubro Empresa: </label>
                        <select class="form-control" name="empresarubro" id="exampleSelect1" disabled>
                          @if($cliente->CD_EmpresaRubro != NULL)
                            <option>{{ $cliente->EmpresaRubro->Descripcion }}</option>
                          @endif
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Condicion de Pago: </label>
                        <select class="form-control" name="condpago" id="exampleSelect1" disabled>
                          @if($cliente->CD_CondPago != NULL)
                            <option>{{ $cliente->CondPago->Descripcion }}</option>
                          @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Clasificacion de Cliente: </label>
                        <select class="form-control" name="clienteclasificacion" id="exampleSelect1" disabled>
                          @if($cliente->CD_ClienteClasificacion != NULL)
                            <option>{{ $cliente->ClienteClasificacion->Descripcion }}</option>
                          @endif
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    @foreach($contactos as $contacto)
                        <div class="col-md-6">
                            <label>Contacto: </label>
                            <select class="form-control" name="contacto" disabled>
                                <option value=""> {{ $contacto->Nombre }} </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Cargo: </label>
                            <input type="text" name="cargoarea" value="{{ $contacto->CargoArea }}" class="form-control" maxlength="30" disabled>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label>Notas: </label>
                    <textarea class="form-control" name="notas" rows="3" maxlength="500" resize="none" disabled>{{ $cliente->Notas }}</textarea>
                </div>

                <a href="{!! url()->previous() !!}"><button type="button" class="btn btn-success">Volver</button></a>
            </div>
    </div>

@endsection
