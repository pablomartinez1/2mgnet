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
            <div id="form-agregar-cliente" class="form-group"">
                <h2>Mostrar un Cliente Final:</h2>
                
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nombre: (*)</label>
                        <input type="text" name="nombre" value="{{$clientefinal->Nombre}}" class="form-control" maxlength="50" disabled>
                    </div>
                
                    <div class="col-md-6 form-group">
                        <label>Rubro Empresa: (*)</label>
                        <select class="form-control" name="empresarubro" disabled>
                            @foreach($empresarubro as $rubro)
                                <option value="{{$rubro->CD_EmpresaRubro}}">{{$rubro->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <a href="{!! url("abm/clientesfinales") !!}"><button type="button" class="btn btn-success">Volver</button></a>
            </div>
    </div>

@endsection