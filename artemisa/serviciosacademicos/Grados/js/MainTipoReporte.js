/**
 * @author Carlos
 */


$("#cmbFacultadTReporte").change(function ( ) {
    /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
     *Se añade evento off y on en evento change del select de la pestaña de reportes para evitar llamado multiple de pagina
     *Since september 28,2017
     */

    var tipoOperacion = 'listaCarreras';
    var cmbFacultad = $("#cmbFacultadTReporte").val( );

    $("#cmbFacultadTReporte").off("click").on("click", function () {
        $.ajax({
            url: "../servicio/carrera.php",
            type: "POST",
            data: {tipoOperacion: tipoOperacion, cmbFacultad: cmbFacultad},
            cache: false,
            success: function (data) {
                //alert(data);
                $("#cmbCarreraTReporte").html(data);

            }
        });
    });
    //fin modificacion


});


$("#estudianteCeremoniaEgresados").dataTable({
    "bJQueryUI": true,
    //"sPaginationType": "full_numbers",
    "sPaginationType": "full_numbers",
    "bProcessing": true,
    "bServerSide": false,
    "bDeferRender": true,
    "bRetrieve": true,
    /*"paging": false,
     "processing": true,
     "bServerSide": false,
     "deferRender": true,*/
    "oLanguage": {
        "sLoadingRecords": "Espere un momento, cargando...",
        "sSearch": "Buscar:",
        "sZeroRecords": "No hay datos con esa busqueda",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Ultimo",
            "sNext": "Siguiente",
            "sPrevious": "Anterior",
        }
    },
    "bDestroy": true
});


$("#btnBuscarTReporte").button( ).off( ).click(function ( ) {

    var txtCodigoReferencia = $("#txtCodigoReferencia").val( );

    /*Modified Diego Rivera <riveradiego@unbsoque.edu.co>
     *Se añade validacion de referencia 7 "indexacion"
     *Since january 29 ,2018
     */
    if (txtCodigoReferencia == 7) {
        var tipoOperacion = "consultarIndexacion";
    } if(txtCodigoReferencia == 9){
        var tipoOperacion = "consultaColegioPsicologia";
    } else if (txtCodigoReferencia != 3 && txtCodigoReferencia != 4) {
        var tipoOperacion = "consultarCeremoniaEgresados";
    } else {
        if (txtCodigoReferencia == 3)
            var tipoOperacion = "consultarNumeroGraduados";
        else
            var tipoOperacion = "consultarTarjetaProfesional";
    }
    $.ajax({//Ajax
        type: "POST",
        url: "../servicio/tipoReporte.php",
        data: $("#formTipoReporte").serialize( ) + "&tipoOperacion=" + tipoOperacion,
        success: function (data) {
            if (data == 0) {
                validarSinDatos();
            } else {
                $("#TablaTipoReporte").html(data);
            }
        }
    });

});

$("#btnRestaurarTReporte").button( ).click(function ( ) {

});



/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
 *Se añaden parametros dialog reporteEntidades  cargar el formulario para diligenciar carta de entidades
 *Since  february 28,2018
 */

$("#reporteEntidades").dialog({
    autoOpen: false,
    modal: true,
    resizable: false,
    title: "Información del destinatario",
    width: 300,
    height: 'auto',
    show: {
        effect: "blind",
        duration: 500
    },
    hide: {
        effect: "explode",
        duration: 500
    },
    buttons: {
        "Cerrar": function ( ) {
            $(this).dialog("close");
        }
    }
});

//$("$#btnPdfCarta").button( );

$("#btnGenerarCarta").button( ).off( );
$("#btnGenerarCarta").button( ).click(function ( ) {

    var tipoOperacion = "generarCarta";
    var datos = $("#formTipoReporte").serialize( );
    var camposVacios = validarFormulario(datos);

    if (camposVacios == "") {

        $.ajax({
            type: "POST",
            url: "../servicio/tipoReporte.php",
            dataType: "html",
            data: $("#formTipoReporte").serialize( ) + "&tipoOperacion=" + tipoOperacion,
            success: function (data) {

                $("#reporteEntidades").html(data);
                $("#reporteEntidades").dialog("open");
                $("#btnExportarCarta").button( ).off( );

                $("#btnExportarCarta").button( ).click(function (e) {

                    var datos = $("#pdfCarta").serialize( );
                    var camposVacios = validarFormulario(datos);

                    if (camposVacios == "") {



                        $.ajax({
                            type: "POST",
                            url: "../servicio/pdf.php",
                            data: datos,
                            beforeSend: function (objeto) {
                                $('#carga').css({display: 'block'});
                            },
                            complete: function () {

                                $("#reporteEntidades").dialog("close");
                                $("#pdfCarta").submit();
                                $('#carga').css('display', 'none');
                            }

                        });



                    } else {

                        crearMensaje(camposVacios);
                    }
                });/**/
                //}/**/
            }
        });
    } else {
        crearMensaje(camposVacios);
    }


});

/*Modfied Diego Rivera <riveradiego@unbosque.edu.co>
 *Se añaden parametros dialog reporteCertificados  cargar el formulario para diligenciar carta de entidades
 *Since March 08,2018
 */


$("#reporteCertificados").dialog({
    autoOpen: false,
    modal: true,
    resizable: false,
    title: "Certificados de notas",
    width: 300,
    height: 'auto',
    show: {
        effect: "blind",
        duration: 500
    },
    hide: {
        effect: "explode",
        duration: 500
    },
    buttons: {
        "Cerrar": function ( ) {
            $(this).dialog("close");
        }
    }
});



$("#btnGenerarCertificados").button( ).off( );
$("#btnGenerarCertificados").button( ).click(function ( ) {
    var tipoOperacion = "generarCertificado";
    var datos = $("#formTipoReporte").serialize( );
    var camposVacios = validarFormulario(datos);

    if (camposVacios == "") {

        $.ajax({
            type: "POST",
            url: "../servicio/tipoReporte.php",
            dataType: "html",
            data: $("#formTipoReporte").serialize( ) + "&tipoOperacion=" + tipoOperacion,
            success: function (data) {
                $("#reporteCertificados").html(data);
                $("#reporteCertificados").dialog("open");
                $("#btnExportarCertificado").button( ).off( );
                $("#btnExportarCertificado").button( ).click(function (e) {
                    var datos = $("#pdfCertificado").serialize( );

                    $.ajax({

                        type: "POST",
                        url: "../servicio/pdf.php",
                        data: datos,
                        beforeSend: function (objeto) {
                            $('#carga').css({display: 'block'});
                        },
                        complete: function () {
                            $("#reporteCertificados").dialog("close");
                            $("#pdfCertificado").submit( );
                            $("#carga").css('display', 'none');
                        }
                    });

                });

            }

        });

    } else {

        crearMensaje(camposVacios);
    }

});

$("#btnExportarRGrado").button( );
$("#btnExportarRGradoPDF").button( );




