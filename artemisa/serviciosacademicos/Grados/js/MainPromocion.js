$("#cmbFacultadPromocion").off( ).change(function ( ) {
    var tipoOperacion = 'listaCarreras';
    var cmbFacultad = $("#cmbFacultadPromocion").val( );
    $.ajax({
        url: "../servicio/carrera.php",
        type: "POST",
        data: {tipoOperacion: tipoOperacion, cmbFacultad: cmbFacultad},
        success: function (data) {
            //alert(data);
            $("#cmbCarreraPromocion").html(data);
        }
    });
});


$("#btnBuscarPromocion").button( ).off('click').on('click', function () {
    var datosPromocion = $("#formPromocion").serialize( );
    var camposVacios = validarFormulario(datosPromocion);
    if (camposVacios == "") {
        $("#btnBuscarPromocion").button({label: "Buscando <img width='16' height='16' src='../css/images/cargando.gif' />"});
        $("#btnBuscarPromocion").button("option", "disabled", true);

        $.ajax({
            url: "../servicio/promocion.php",
            type: "POST",
            data: $("#formPromocion").serialize( ) + "&tipoOperacion=buscar",
            cache: false,
            success: function (data) {
                if (data != 0 ) {
                    $("#mensageCargando").dialog("close");
                    data = trim(data);
                    $("#btnBuscarPromocion").button({label: "Consultar"});
                    $("#btnBuscarPromocion").button("option", "disabled", false);
                    $("#formularioPromocion").html(data);

                } else {
                    $("#formularioPromocion").html("");
                    $("#btnBuscarPromocion").button({label: "Consultar"});
                    $("#btnBuscarPromocion").button("option", "disabled", false);
                    validarSinDatos();
                }
            }
        });
    } else {
        crearMensaje(camposVacios);
    }
});

$("#btnActualizarPromocion").button( ).off('click').on('click', function () {

    $.ajax({
        url: "../servicio/promocion.php",
        type: "POST",
        data: $("#formPromocionActualizar").serialize( ) + "&tipoOperacion=actualizar",
        cache: false,
        success: function (data) {
            if (data != 0) {
                $("#mensageCargando").dialog("close");
                data = trim(data);
                $("#btnBuscarPromocion").button({label: "Consultar"});
                $("#btnBuscarPromocion").button("option", "disabled", false);
                $("#formularioPromocion").html("");
                actualizarMensaje();

            } else {
                $("#formularioPromocion").html("");
                $("#btnBuscarPromocion").button({label: "Consultar"});
                $("#btnBuscarPromocion").button("option", "disabled", false);
                actualizarMensaje();
            }
        }
    });

})

