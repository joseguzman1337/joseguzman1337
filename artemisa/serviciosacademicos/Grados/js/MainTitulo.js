$(function () {
    $("#btnBuscarTitulo").button({label: "Consultar"});
    $("#btnRestaurarTitulo").button({label: "Restaurar"});
    $("#btnActualizarTitulo").button({label: "Actualizar"});

    $("#cmbFacultadTitulo").off( ).change(function ( ) {
        $("#reportePaginadorTitulo").html(" ");
        var tipoOperacion = 'listaCarreras';
        var cmbFacultad = $("#cmbFacultadTitulo").val( );
        $.ajax({
            url: "../servicio/carrera.php",
            type: "POST",
            data: {tipoOperacion: tipoOperacion, cmbFacultad: cmbFacultad},
            success: function (data) {
                $("#cmbCarreraTitulo").html(data);
            }
        });
    });

    $("#cmbCarreraTitulo").change(function ( ) {
        $("#reportePaginadorTitulo").html(" ");
    });

    $("#btnRestaurarTitulo").button( ).on("click", function () {
        $("#formTitulo").reset( );
    });

    $("#btnBuscarTitulo").button( ).on("click", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var datos = $("#formTitulo").serialize( );
        var camposVacios = validarFormulario(datos);
        if (camposVacios == "") {
            $("#btnBuscarTitulo").button({label: "Buscando <img width='16' height='16' src='../css/images/cargando.gif' />"});
            $("#btnBuscarTitulo").button("option", "disabled", true);
            $.ajax({
                url: "../servicio/titulo.php",
                type: "POST",
                data: datos + "&tipoOperacionTitulo=consultar",
                cache: false,
                success: function (data) {
                    if (data != 0) {
                        if (data == "invalido") {
                            $("#btnBuscarTitulo").button({label: "Consultar"});
                            $("#btnBuscarTitulo").button("option", "disabled", false);
                            validarTipos("");

                        } else {
                            $("#mensageCargando").dialog("close");
                            data = trim(data);
                            $("#btnBuscarTitulo").button({label: "Consultar"});
                            $("#reportePaginadorTitulo").html(data);
                            $("#btnBuscarTitulo").button("option", "disabled", false);
                        }
                    } else {
                        $("#btnBuscarTitulo").button({label: "Consultar"});
                        $("#btnBuscarTitulo").button("option", "disabled", false);
                        validarSinDatos();
                    }
                }
            });

        } else {
            crearMensaje(camposVacios);
        }
    });

    $("#btnActualizarTitulo").button( ).on("click", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var datos = $("#modificarTitulo").serialize( );
        var camposVacios = validarFormulario(datos);
        if (camposVacios == "") {
            $.ajax({
                url: "../servicio/titulo.php",
                type: "POST",
                data: datos + "&tipoOperacionTitulo=actualizar",
                cache: false,
                success: function (data) {
                    if (data == 1) {
                        alert("Titulo Actualizado");
                    } else {
                        alert("Ha ocurrido un error al actualizar");
                    }
                }
            });
        } else {
            crearMensaje(camposVacios);
        }
    });
});