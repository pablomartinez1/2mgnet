@extends('layouts.app')
  <link rel='stylesheet' href="{{ url('/css/vistas.css') }}" />
@section('content')

    <div id="div-agregado" class="container">
    <div id="boton-cerrar-form"><a href="{!! url()->previous() !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <div id="form-agregar-cliente" class="form-group"">
                <h2>Mostrar un Contacto:</h2>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre: (*)</label>
                        <input type="text" name="nombre" value="{{ $contacto->Nombre }}" class="form-control" maxlength="50" disabled>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Tipo: (*)</label>
                        <select class="form-control" name="contactotipo" id="exampleSelect1" disabled>
                          @if($contacto->CD_ContactoTipo != NULL)
                            <option value="{{$contacto->CD_ContactoTipo}}">{{$contacto->ContactoTipo->Descripcion}}</option>
                          @endif
                        </select>
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
                    <div class="col-md-4">
                        <label>Correo Corporativo: </label>
                        <input type="text" name="correocorporativo" value="{{ $contacto->CorreoCorporativo }}" class="form-control" maxlength="50" disabled>
                    </div>

                    <div class="col-md-4">
                        <label>Correo Personal: </label>
                        <input type="text" name="correopersonal" value="{{ $contacto->CorreoPersonal }}" class="form-control" maxlength="50" disabled>
                    </div>

                    <div class="col-md-4">
                        <label>Skype: </label>
                        <input type="text" name="skype" value="{{ $contacto->Skype }}"class="form-control" maxlength="50" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label>Notas: </label>
                    <textarea class="form-control" name="notas" rows="3" maxlength="500" resize="none" disabled> {{ $contacto->Notas }}</textarea>
                </div>

                <a href="{!! url()->previous() !!}"><button type="button" class="btn btn-success">Volver</button></a>
            </div>
    </div>

@endsection
