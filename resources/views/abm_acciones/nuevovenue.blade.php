@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
        <div id="boton-cerrar-form"><a href="{!! url('/abm/venues') !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url('/crearvenue') !!}">
                <h2>Agregar un nuevo Venue:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label>Nombre: (*)</label>
                    <input type="text" name="nombre" placeholder="Nombre" class="form-control" maxlength="80" required>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Pais: (*)</label>
                        <select class="form-control" name="pais" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($paises as $pais)
                                <option value="{{$pais->CD_Pais}}">{{$pais->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Provincia: (*)</label>
                        <select class="form-control" name="provincia" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($provincias as $provincia)
                                <option value="{{$provincia->CD_Provincia}}">{{$provincia->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Localidad: </label>
                        <input type="text" name="localidad" placeholder="Localidad" class="form-control" maxlength="40">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Calle: </label>
                        <input type="text" name="calle" placeholder="Calle" class="form-control" maxlength="50">
                    </div>

                    <div class="col-md-3">
                        <label>Codigo Postal: </label>
                        <input type="text" name="codpostal" placeholder="Codigo Postal" class="form-control" maxlength="12">
                    </div>

                    <div class="col-md-3">
                        <label>CUIT: </label>
                        <input type="text" id="cuit" name="cuit" placeholder="CUIT" class="form-control" maxlength="15">
                    </div>
                </div>

                <div id="div-telefonos" class="row form-group">
                    <div class="col-md-2">
                        <button type="button" id="boton-telefono" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Agregar Telefono</button>
                    </div>
                </div>

                <div class="row form-group">
                  <div id="telefonos-js">

                  </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label>Web: </label>
                        <input type="text" name="web" placeholder="Web" class="form-control" maxlength="50">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label>Situacion Iva: (*)</label>
                        <select class="form-control" name="situacioniva" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($situacioniva as $sitiva)
                                <option value="{{$sitiva->CD_SituacionIVA}}">{{$sitiva->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label>Comisión: </label>
                        <input type="text" id="comision" name="comision" class="form-control" maxlength="6">
                    </div>

                    <div class="col-md-5">
                        <label>Tipo Venue: (*)</label>
                        <select class="form-control" name="venuetipo" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($venuetipo as $tipo)
                                <option value="{{$tipo->CD_VenueTipo}}">{{$tipo->Descripcion}}</option>
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
      $('#boton-telefono').click(function(e) {
        event.preventDefault();

        $('#telefonos-js').append("<div class='col-md-2'><label id='label-telefono'>Telefono: </label><a id='boton-telefono2'><span class='glyphicon glyphicon-remove borrar-telefonos-glyph'></span></a><input type='text' placeholder='Telefono' name='telefono[]' class='form-control' required><select class='form-control' name='tipotelefono[]' required><option value=''>Seleccione uno:</option>@foreach($telefonotipo as $tipotelefono)<option value='{{$tipotelefono->CD_TelefonoTipo}}''>{{$tipotelefono->Descripcion}}</option>@endforeach</select></div>");
      });

      $('body').on('click', '#boton-telefono2', function(e) {
        $(this).parent('div').remove();
      });

      $('#boton-contacto').click(function(e) {
        event.preventDefault();

        $('#contactos-js').append("<div><div class='col-md-10'><label>Contacto: (*)</label><a id='boton-telefono2'><span class='glyphicon glyphicon-remove borrar-contactos-glyph'></span></a><select class='form-control' name='contacto[]' required><option value=''>Seleccione uno:</option>@foreach($contactos as $contacto)<option value='{{$contacto->CD_Contacto}}'>{{$contacto->Nombre}}</option>@endforeach</select></div></div>");
      });

      $('body').on('click', '#boton-contacto2', function(e) {
        $(this).parent('div').parent('div').remove();
      });
    })
    </script>

@endsection
