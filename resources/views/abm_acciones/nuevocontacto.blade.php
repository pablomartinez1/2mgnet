@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
    <div id="boton-cerrar-form"><a href="{!! url('/abm/contactos') !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url('/crearcontacto') !!}">
                <h2>Agregar un nuevo Contacto:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre: (*)</label>
                        <input type="text" name="nombre" placeholder="Nombre" class="form-control" maxlength="50" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Tipo: (*)</label>
                        <select class="form-control" name="contactotipo" id="exampleSelect1" required>
                            <option value="">Seleccione uno:</option>
                            @foreach($contactotipo as $tipocontacto)
                                <option value="{{$tipocontacto->CD_ContactoTipo}}">{{$tipocontacto->Descripcion}}</option>
                            @endforeach
                        </select>
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
                    <div class="col-md-4">
                        <label>Correo Corporativo: </label>
                        <input type="email" name="correocorporativo" placeholder="Correo Corporativo" class="form-control" maxlength="50">
                    </div>

                    <div class="col-md-4">
                        <label>Correo Personal: </label>
                        <input type="email" name="correopersonal" placeholder="Correo Personal" class="form-control" maxlength="50">
                    </div>

                    <div class="col-md-4">
                        <label>Skype: </label>
                        <input type="text" name="skype" placeholder="Skype" class="form-control" maxlength="50">
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
    })
    </script>
@endsection
