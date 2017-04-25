@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
    <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url("abm_acciones/actualizarcliente/".$cliente->CD_Cliente) !!}"">
                <h2>Editar un Cliente:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label>Nombre: (*)</label>
                    <input type="text" name="nombre" value="{{ $cliente->Nombre }}" class="form-control" maxlength="50" required>
                </div>

                <div class="form-group">
                    <label>Razon Social: </label>
                    <input type="text" name="razonsocial" value="{{ $cliente->RazonSocial }}" class="form-control" maxlength="50">
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Pais: (*)</label>
                        <select class="form-control" name="pais" required>
                            @if($cliente->CD_Pais != NULL)
                              <option value="{{ $cliente->Pais->CD_Pais }}">{{ $cliente->Pais->Descripcion }}</option>
                            @else
                              <option value="">Seleccione uno: </option>
                            @endif
                        @foreach($listapaises as $pais)
                            @if($pais->CD_Pais == $cliente->CD_Pais)
                                @continue
                            @endif
                            <option value="{{ $pais->CD_Pais }}">{{$pais->Descripcion}}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Provincia: </label>
                        <select class="form-control" name="provincia">
                          @if($cliente->CD_Provincia != NULL)
                            <option value="{{ $cliente->CD_Provincia }}">{{ $cliente->Provincia->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listaprovincias as $provincia)
                            @if($provincia->CD_Provincia == $cliente->CD_Provincia)
                                @continue
                            @endif
                            <option value="{{ $provincia->CD_Provincia }}">{{$provincia->Descripcion}}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Localidad: </label>
                        <input type="text" id="cuit" name="localidad" value="{{ $cliente->Localidad }}" class="form-control" maxlength="40">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Calle: </label>
                        <input type="text" name="calle" value="{{ $cliente->Calle }}" class="form-control" maxlength="50">
                    </div>

                    <div class="col-md-3">
                        <label>Codigo Postal: </label>
                        <input type="text" name="codpostal" value="{{ $cliente->CodPostal }}" class="form-control" maxlength="12">
                    </div>

                    <div class="col-md-3">
                        <label>CUIT: </label>
                        <input type="text" id="cuit" name="cuit" value="{{ $cliente->CUIT }}" class="form-control" maxlength="15">
                    </div>
                </div>

                <div id="div-telefonos" class="row form-group">
                    <div class="col-md-2">
                        <button type="button" id="boton-telefono" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Agregar Telefono</button>
                    </div>
                </div>

                <div class="row form-group">
                  <div id="telefonos-js">
                    @foreach($telefonos as $telefono)
                        <div class="col-md-2">
                            <label>Telefono: (*)</label>
                            <a id='boton-telefono2'><span class='glyphicon glyphicon-remove borrar-telefonos-glyph'></span></a>

                            <input type="text" id="telefono" name="telefono[]" value="{{ $telefono->Telefono }}" class="form-control" maxlength="30">
                            <select class="form-control" name="tipotelefono[]">
                                <option value="{{ $telefono->CD_TelefonoTipo }}">{{ $telefono->Descripcion }}</option>
                                @foreach($listatelefonostipo as $telefonotipo)
                                    @if($telefonotipo->CD_TelefonoTipo == $telefono->CD_TelefonoTipo)
                                        @continue
                                    @endif
                                    <option value="{{ $telefonotipo->CD_TelefonoTipo }}">{{ $telefonotipo->Descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                  </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label>Web: </label>
                        <input type="text" name="web" value="{{ $cliente->Web }}" class="form-control" maxlength="50">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Situacion Iva: (*)</label>
                        <select class="form-control" name="situacioniva">
                          @if($cliente->CD_SituacionIva != NULL)
                            <option value="{{ $cliente->CD_SituacionIva }}">{{ $cliente->SituacionIva->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listasituacionesiva as $listasitiva)
                            @if($listasitiva->CD_SituacionIVA == $cliente->CD_SituacionIva)
                                @continue
                            @endif
                            <option value="{{ $listasitiva->CD_SituacionIVA }}">{{ $listasitiva->Descripcion }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label>Comisión: </label>
                        <input type="text" name="comision" value="{{ $cliente->Comisión }}" class="form-control" maxlength="6">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Tipo Cliente: (*)</label>
                        <select class="form-control" name="clientetipo">
                          @if($cliente->CD_ClienteTipo != NULL)
                            <option value="{{ $cliente->CD_ClienteTipo }}">{{ $cliente->ClienteTipo->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listaclientestipo as $clientetipo)
                            @if($clientetipo->CD_ClienteTipo == $cliente->CD_ClienteTipo || $clientetipo->CD_ClienteTipo == 99)
                                @continue
                            @endif
                            <option value="{{ $clientetipo->CD_ClienteTipo }}">{{ $clientetipo->Descripcion }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Canal: </label>
                        <select class="form-control" name="canal">
                          @if($cliente->CD_Canal != NULL)
                            <option value="{{ $cliente->CD_Canal }}">{{ $cliente->Canal->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listacanales as $canal)
                            @if($canal->CD_Canal == $cliente->CD_Canal)
                                @continue
                            @endif
                            <option value="{{ $canal->CD_Canal }}">{{ $canal->Descripcion }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Rubro Empresa: </label>
                        <select class="form-control" name="empresarubro">
                          @if($cliente->CD_EmpresaRubro != NULL)
                            <option value="{{ $cliente->CD_EmpresaRubro }}">{{ $cliente->EmpresaRubro->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listarubrosempresa as $rubro)
                            @if($rubro->CD_EmpresaRubro == $cliente->CD_EmpresaRubro)
                                @continue
                            @endif
                            <option value="{{ $rubro->CD_EmpresaRubro }}">{{ $rubro->Descripcion }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Condicion de Pago: </label>
                        <select class="form-control" name="condpago">
                          @if($cliente->CD_CondPago != NULL)
                            <option value="{{ $cliente->CD_CondPago }}">{{ $cliente->CondPago->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listacondicionespago as $pago)
                            @if($pago->CD_CondPago == $cliente->CD_CondPago)
                                @continue
                            @endif
                            <option value="{{ $pago->CD_CondPago }}">{{ $pago->Descripcion }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Clasificacion de Cliente: (*)</label>
                        <select class="form-control" name="clienteclasificacion">
                          @if($cliente->CD_ClienteClasificacion != NULL)
                            <option value="{{ $cliente->CD_ClienteClasificacion }}">{{ $cliente->ClienteClasificacion->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listaclasificacionescliente as $clasificacioncliente)
                            @if($clasificacioncliente->CD_ClienteClasificacion == $cliente->CD_ClienteClasificacion)
                                @continue
                            @endif
                            <option value="{{ $clasificacioncliente->CD_ClienteClasificacion }}">{{ $clasificacioncliente->Descripcion }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-2">
                        <button type="button" id="boton-contacto" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Agregar Contacto</button>
                    </div>
                </div>

                <div class="row">
                  <div id="contactos-js">
                    @foreach($contactos as $contacto)
                    <div>
                        <div class="col-md-5">
                            <label>Contacto: </label>
                            <select class="form-control" name="contacto[]">
                                <option value="{{ $contacto->CD_Contacto }}"> {{ $contacto->Nombre }} </option>
                            @foreach($listacontactos as $lista)
                                @if($lista->CD_Contacto == $contacto->CD_Contacto || $lista->FechaBaja != NULL)
                                    @continue
                                @endif
                                <option value="{{ $lista->CD_Contacto }}">{{ $lista->Nombre }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label>Cargo: </label>
                            <a id='boton-contacto2'><span class='glyphicon glyphicon-remove borrar-contactos-glyph'></span></a>
                            <input type="text" name="cargoarea[]" value="{{ $contacto->CargoArea }}" class="form-control" maxlength="30">
                        </div>
                    </div>
                    @endforeach
                  </div>
                </div>

                <div class="form-group">
                    <label>Notas: </label>
                    <textarea class="form-control" name="notas" rows="3" maxlength="500" resize="none">{{ $cliente->Notas }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
            </form>
    </div>

    <script>
    $(document).ready(function(){
      $('#boton-telefono').click(function(e) {
        event.preventDefault();

        $('#telefonos-js').append("<div class='col-md-2'><label id='label-telefono'>Telefono: </label><a id='boton-telefono2'><span class='glyphicon glyphicon-remove borrar-telefonos-glyph'></span></a><input type='text' placeholder='Telefono' name='telefono[]' class='form-control' required><select class='form-control' name='tipotelefono[]' required><option value=''>Seleccione uno:</option>@foreach($listatelefonostipo as $tipotelefono)<option value='{{$tipotelefono->CD_TelefonoTipo}}''>{{$tipotelefono->Descripcion}}</option>@endforeach</select></div>");
      });

      $('body').on('click', '#boton-telefono2', function(e) {
        $(this).parent('div').remove();
      });

      $('#boton-contacto').click(function(e) {
        event.preventDefault();

        $('#contactos-js').append("<div><div class='col-md-5'><label>Contacto: (*)</label><select class='form-control' name='contacto[]' required><option value=''>Seleccione uno:</option>@foreach($listacontactos as $contacto)<option value='{{$contacto->CD_Contacto}}'>{{$contacto->Nombre}}</option>@endforeach</select></div><div class='col-md-5'><label>Cargo: </label><a id='boton-contacto2'><span class='glyphicon glyphicon-remove borrar-contactos-glyph'></span></a><input type='text' name='cargoarea[]' placeholder='Cargo' class='form-control' maxlength='30'></div></div>");
      });

      $('body').on('click', '#boton-contacto2', function(e) {
        $(this).parent('div').parent('div').remove();
      });
    })
    </script>

@endsection
