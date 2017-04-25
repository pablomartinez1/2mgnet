@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
    <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url("abm_acciones/actualizarproveedor/".$proveedor->CD_Proveedor) !!}"">
                <h2>Editar un Proveedor:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label>Nombre: (*)</label>
                    <input type="text" name="nombre" value="{{ $proveedor->Nombre }}" class="form-control" maxlength="50" required>
                </div>

                <div class="form-group">
                    <label>Razon Social: </label>
                    <input type="text" name="razonsocial" value="{{ $proveedor->RazonSocial }}" class="form-control" maxlength="50">
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Pais: (*)</label>
                        <select class="form-control" name="pais" required>
                            @if($proveedor->CD_Pais != NULL)
                              <option value="{{ $proveedor->Pais->CD_Pais }}">{{ $proveedor->Pais->Descripcion }}</option>
                            @else
                              <option value="">Seleccione uno: </option>
                            @endif
                        @foreach($listapaises as $pais)
                            @if($pais->CD_Pais == $proveedor->CD_Pais)
                                @continue
                            @endif
                            <option value="{{ $pais->CD_Pais }}">{{$pais->Descripcion}}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Provincia: </label>
                        <select class="form-control" name="provincia">
                          @if($proveedor->CD_Provincia != NULL)
                            <option value="{{ $proveedor->CD_Provincia }}">{{ $proveedor->Provincia->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listaprovincias as $provincia)
                            @if($provincia->CD_Provincia == $proveedor->CD_Provincia)
                                @continue
                            @endif
                            <option value="{{ $provincia->CD_Provincia }}">{{$provincia->Descripcion}}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Localidad: </label>
                        <input type="text" id="cuit" name="localidad" value="{{ $proveedor->Localidad }}" class="form-control" maxlength="40">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Calle: </label>
                        <input type="text" name="calle" value="{{ $proveedor->Calle }}" class="form-control" maxlength="50">
                    </div>

                    <div class="col-md-3">
                        <label>Codigo Postal: </label>
                        <input type="text" name="codpostal" value="{{ $proveedor->CodPostal }}" class="form-control" maxlength="12">
                    </div>

                    <div class="col-md-3">
                        <label>CUIT: </label>
                        <input type="text" id="cuit" name="cuit" value="{{ $proveedor->CUIT }}" class="form-control" maxlength="15">
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
                        <input type="text" name="web" value="{{ $proveedor->Web }}" class="form-control" maxlength="50">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Situacion Iva: (*)</label>
                        <select class="form-control" name="situacioniva">
                          @if($proveedor->CD_SituacionIva != NULL)
                            <option value="{{ $proveedor->CD_SituacionIva }}">{{ $proveedor->SituacionIva->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listasituacionesiva as $listasitiva)
                            @if($listasitiva->CD_SituacionIVA == $proveedor->CD_SituacionIva)
                                @continue
                            @endif
                            <option value="{{ $listasitiva->CD_SituacionIVA }}">{{ $listasitiva->Descripcion }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Rubro Empresa: </label>
                        <select class="form-control" name="empresarubro">
                          @if($proveedor->CD_EmpresaRubro != NULL)
                            <option value="{{ $proveedor->CD_EmpresaRubro }}">{{ $proveedor->EmpresaRubro->Descripcion }}</option>
                          @else
                            <option value="">Seleccione uno: </option>
                          @endif
                        @foreach($listarubrosempresa as $rubro)
                            @if($rubro->CD_EmpresaRubro == $proveedor->CD_EmpresaRubro)
                                @continue
                            @endif
                            <option value="{{ $rubro->CD_EmpresaRubro }}">{{ $rubro->Descripcion }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Horario: </label>
                        <input type="text" name="horario" value="{{ $proveedor->Horario }}" class="form-control" maxlength="6">
                    </div>

                    <div class="col-md-1">
                        <label>Comisión: </label>
                        <input type="text" name="comision" value="{{ $proveedor->Comisión }}" class="form-control" maxlength="6">
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
                        <div class="col-md-10">
                            <label>Contacto: </label>
                            <a id='boton-contacto2'><span class='glyphicon glyphicon-remove borrar-contactos-glyph'></span></a>
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
                    </div>
                    @endforeach
                  </div>
                </div>

                <div class="form-group">
                    <label>Notas: </label>
                    <textarea class="form-control" name="notas" rows="3" maxlength="500" resize="none">{{ $proveedor->Notas }}</textarea>
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

        $('#contactos-js').append("<div><div class='col-md-10'><label>Contacto: (*)</label><a id='boton-contacto2'><span class='glyphicon glyphicon-remove borrar-contactos-glyph'></span></a><select class='form-control' name='contacto[]' required><option value=''>Seleccione uno:</option>@foreach($listacontactos as $contacto)<option value='{{$contacto->CD_Contacto}}'>{{$contacto->Nombre}}</option>@endforeach</select></div></div></div>");
      });

      $('body').on('click', '#boton-contacto2', function(e) {
        $(this).parent('div').parent('div').remove();
      });
    })
    </script>

@endsection
