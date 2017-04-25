@extends('layouts.app')
    <style type="text/css">
    #div-agregado-cliente
    {
        background:rgba(0, 0, 0, 0.75);
        width: 100%;
        height: 100%;
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
    </style>
@section('content')

    <div id="div-agregado-cliente" class="container">
    <div id="boton-cerrar-form"><a href="{!! url('/abm/clientesfinales') !!}"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></a></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url("abm_acciones/actualizarclientefinal/".$clientefinal->CD_ClienteFinal) !!}"">
                <h2>Editar un Evento:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre: (*)</label>
                        <input type="text" name="nombre" value="{{$clientefinal->Nombre}}" class="form-control" maxlength="50" required>
                    </div>
                
                    <div class="col-md-6 form-group">
                        <label>Rubro Empresa: (*)</label>
                        <select class="form-control" name="empresarubro" required>
                            @foreach($empresarubro as $rubro)
                                <option value="{{$rubro->CD_EmpresaRubro}}">{{$rubro->Descripcion}}</option>
                            @endforeach
                            @foreach($listaempresarubro as $listarubro)
                                @if($listarubro->CD_EmpresaRubro == $clientefinal->CD_EmpresaRubro)
                                    @continue
                                @endif
                                <option value="{{ $listarubro->CD_EmpresaRubro }}">{{ $listarubro->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
            </form>
    </div>

@endsection