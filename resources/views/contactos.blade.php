@extends('layouts.app')
    <style>
    #div-filtro
    {
        padding-top: 20px;
    }

    #div-filtro-busqueda
    {
        padding-top: 10px;
        display: none;
    }

    #btn-busqueda
    {
        padding: 10px;
    }

    #btn-filtro
    {
        padding: 10px;
    }

    #div-agregado-cliente
    {
        background:rgba(0, 0, 0, 0.75);
        width: 100%;
        height: 100%;
        display: none;
        z-index:2;
        float:left;
        top:0px;
        left:0px;
        padding-left: 50px;
        padding-right: 50px;
        padding-top: 100px;
        position:absolute;
    }
    #form-agregar-cliente
    {
        background-color: white;
        padding:20px;
    }
    #boton-cerrar-form
    {
        position: relative;
        float:right;
        z-index:3
    }
    #glyph-cerrar
    {
        margin:10px;
        padding: 5px;
    }
    #select-size
    {
        padding: 8px;
    }
    #padding-para-form
    {
        padding-top-top: 10px;
    }
    #boton-telefono, #boton-telefono2
    {
        margin-top: 28px;
        padding: 9px;
    }
    .filtro-texto
    {
        padding-top:8px;
        padding-left:15px;
        font-size:15px;
    }
    .div-filtros
    {
        padding-top:10px;
    }
    .cambiar-zindex
    {
        z-index:0;
    }
    .mostrar-lista
    {
        display: block;
    }
    .ocultar-lista
    {
        display: none;
    }
    </style>
    </style>

@section('content')
    <div class="container">
        <h1>Lista de Contactos</h1>
    </div>

    <div id="div-nuevo-cliente" class="container">
        <a href="{!! url('/abm_acciones/nuevocontacto') !!}" class="btn btn-primary" id="boton-nuevo-cliente"><span class="glyphicon glyphicon-plus"></span> Nuevo Contacto</a>
        <a href="{!! url('/excel/contactos') !!}" class="btn btn-success" id="boton-nuevo-cliente"><span class="glyphicon glyphicon-file"></span> Exportar a Excel</a>
    </div>

    <div class="container">
        <form class="form-group" method="post" action="{!! url('/abm/contactos') !!}">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <p><strong>Filtros:</strong></p>
            <div class="row container">
                <div class="col-md-1"><p class="filtro-texto"><strong>Buscar:</strong></p></div>
                <div class="col-md-5">
                    <input class="form-control" name="filtro" placeholder="Buscar...">
                </div>

                <div class="col-md-1"><p class="filtro-texto"><strong>Estado:</strong></p></div>
                <div class = "col-md-5 input-group cambiar-zindex">
                    <select name="opcionesfiltro" class="form-control">
                        <option value="activo">ACTIVO</option>
                        <option value="inactivo">INACTIVO</option>
                    </select>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" name="limpiar" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Limpiar Filtros</button>
                <button type="submit" name="filtrar" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button>
            </div>
        </form>
    </div>

    <div id="contactosActuales" class="container panel-body table-responsive mostrar-lista">
        <div class="text-center cambiar-zindex">
            {{ $contactos->links() }}
        </div>

        <table class="table table-bordered table-striped table-condensed table-hover table-list-search">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Correo Personal</th>
                    <th class="col-md-2">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contactos as $contacto)
                    <tr>
                        <td>{{$contacto->Nombre}}</td>
                        @foreach($descripciontipo as $tipo)
                            @if($tipo->CD_Contacto != $contacto->CD_Contacto)
                                @continue
                            @endif
                            <td>{{$tipo->Descripcion}}</td>
                        @endforeach
                        <td>{{$contacto->CorreoPersonal}}</td>
                        <td>
                            <a href="{!! url("abm_acciones/mostrarcontacto/".$contacto->CD_Contacto) !!}""><span class="label label-primary">Mostrar</span></a>
                            @if($contacto->FechaBaja == NULL)
                            <a href="{!! url("abm_acciones/editarcontacto/".$contacto->CD_Contacto) !!}""><span class="label label-success">Editar</span></a>
                            <a href="{!! url("/eliminarcontacto/".$contacto->CD_Contacto) !!}"><span class="label label-danger">Eliminar</span></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center">
            {{ $contactos->links() }}
        </div>
    </div>
@endsection
