@extends('layouts.app')
    <style type="text/css">
    #div-agregado-cliente
    {
        background:rgba(0, 0, 0, 0.75);
        width: 100%;
        height: 190%;
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
    .glyph-cerrar
    {
      margin-left: 130px;
    }
    .glyph-cerrar:hover
    {
      color:black;
    }
    </style>
@section('content')

    <div id="div-agregado-cliente" class="container">
    <div id="boton-cerrar-form"><span id="glyph-cerrar" class="glyphicon glyphicon-remove"></span></div>
            <form id="form-agregar-cliente" class="form-group" method="post" action="{!! url('/crear') !!}">
                <h2>Test:</h2>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                  <div class="col-md-2 form-group">
                    <label>Holi</label>
                    <a><span class="glyphicon glyphicon-remove glyph-cerrar"></span></a>

                    <div>
                      <input type="text" class="form-control">
                    </div>
                  </div>

                  <div class="col-md-2 form-group">
                    <label>Holi</label>
                    <a><span class="glyphicon glyphicon-remove glyph-cerrar"></span></a>

                    <div>
                      <input type="text" class="form-control">
                    </div>
                  </div>
                </div>

                <div class="row">

                </div>

                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
    </div>

@endsection
