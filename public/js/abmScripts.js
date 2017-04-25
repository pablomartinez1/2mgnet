//
$(document).load(function() {
    $("#glyph-cerrar").click(function(){
        $("#div-agregado-cliente").fadeToggle();
        $('#form-agregar-cliente').trigger("reset");
    });

    $("#boton-nuevo-cliente").click(function(){
        $("#div-agregado-cliente").fadeToggle(); 
    });
});
    /*============== AGREGAR TELEFONOS ==============*/
    /*
    var cantidadTelefonos = 1;
    var botonEliminar = false;

    $("#boton-telefono").click(function()
    {
        if(cantidadTelefonos < 5)
        {
            cantidadTelefonos++;
            $("#numeros-telefono").after('<div class="col-md-2"></div>');
        }

        if(cantidadTelefonos >= 2 && !botonEliminar)
        {
            botonEliminar = true;
            $("#boton-telefono2").css( { display: "inline-block" } );
        }
    });

    $("#boton-telefono2").click(function()
    {
        $("#telefono").before().remove();
        $("#label-telefono").before().remove();
    });*/
