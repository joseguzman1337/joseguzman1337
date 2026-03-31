$(document).ready(function () {
    var faIcon = {
        valid: 'fa fa-check-circle fa-lg text-success',
        invalid: 'fa fa-times-circle fa-lg',
        validating: 'fa fa-refresh'
    };
    $('#formu').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: faIcon,
        fields: {
            cbmTipoDocumentoAnterior: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar el Tipo documento antiguo'
                    }
                }
            },
            txtDocumentoAnterior: {
                validators: {
                    notEmpty: {
                        message: 'Debe digitar el Número documento antiguo'
                    }
                }
            },
            cbmTipoDocumentoNuevo: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar el Tipo documento nuevo'
                    }
                }
            },
            txtDocumentoNuevo: {
                validators: {
                    notEmpty: {
                        message: 'Debe digitar el Número documento nuevo'
                    }
                }
            }
        }, onSuccess: function (e) {
            e.preventDefault();
            e.stopPropagation();
            unificaDocumento();
        }
    });

    $("#cbmTipoDocumentoAnterior").change(function () {
        $("#errorTipoDocumentoAntiguo").html("");
        var numeroDocumento = $("#txtDocumentoAnterior").val("");
        $("#txtDocumentoAnterior").focus( );
        $("#nombreestudiante").html("");

    });

    $("#cbmTipoDocumentoNuevo").change(function () {
        $("#errorTipoDocumentoNuevo").html("");
        var numeroDocumento = $("#txtDocumentoNuevo").val("");
        $("#txtDocumentoNuevo").focus( );
        $("#nombreestudiantenuevo").html("");

    });

    $("#txtDocumentoAnterior").keyup(function ( ) {
        var url = HTTP_SITE + "/index.php";
        var tipoDocumento = $("#cbmTipoDocumentoAnterior").val();
        if (tipoDocumento != '05') {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        }
        var numeroDocumento = $("#txtDocumentoAnterior").val();
        var accion = "valiDatos";

        if (numeroDocumento != "") {
            $("#errordocumentoAnterior").html("");
        }
        if (tipoDocumento != '') {
            $.ajax({
                url: url,
                dataType: "html",
                type: "POST",
                data: {
                    tmpl: 'json',
                    tipoDocumento: tipoDocumento,
                    numeroDocumento: numeroDocumento,
                    option: "unificacionDocumento",
                    action: accion
                },
                success: function (data) {
                    var frag = data.split("-*-");
                    $("#idEstudianteGenaralAntiguo").val(frag[0]);
                    $("#nombreestudiante").html(frag[1]);
                }
            });
        }
    });

    $("#txtDocumentoNuevo").keyup(function () {
        var url = HTTP_SITE + "/index.php";
        var tipoDocumento = $("#cbmTipoDocumentoNuevo").val();
        if (tipoDocumento != '05') {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        }
        var numeroDocumento = $("#txtDocumentoNuevo").val();
        var accion = "valiDatos";

        if (numeroDocumento != "") {
            $("#errordocumentoNuevo").html("");
        }

        if (tipoDocumento != -1) {
            $.ajax({
                url: url,
                dataType: "html",
                type: "POST",
                data: {
                    tmpl: 'json',
                    tipoDocumento: tipoDocumento,
                    numeroDocumento: numeroDocumento,
                    option: "unificacionDocumento",
                    action: accion
                },
                success: function (data) {
                    var frag = data.split("-*-");
                    $("#idEstudianteGenaralNuevo").val(frag[0]);
                    $("#nombreestudiantenuevo").html(frag[1]);
                }
            });

        }
    });
    
});

function unificaDocumento() {
    var url = HTTP_SITE + "/index.php";
    var tipoDocumentoAnterior = $("#cbmTipoDocumentoAnterior").val();
    var numeroDocumentoAnterior = $("#txtDocumentoAnterior").val();
    var idEstudianteGenaralAntiguo = $("#idEstudianteGenaralAntiguo").val();
    var tipoDocumentoNuevo = $("#cbmTipoDocumentoNuevo").val();
    var numeroDocumentoNuevo = $("#txtDocumentoNuevo").val();
    var idEstudianteGenaralNuevo = $("#idEstudianteGenaralNuevo").val();
    var accion = "unificaDocumento";
    if (idEstudianteGenaralAntiguo != '' && idEstudianteGenaralNuevo != '') {
        $.ajax({
            url: url,
            dataType: "json",
            type: "POST",
            data: {
                tmpl: 'json',
                tipoDocumentoAnterior: tipoDocumentoAnterior,
                numeroDocumentoAnterior: numeroDocumentoAnterior,
                idEstudianteGenaralAntiguo: idEstudianteGenaralAntiguo,
                tipoDocumentoNuevo: tipoDocumentoNuevo,
                numeroDocumentoNuevo: numeroDocumentoNuevo,
                idEstudianteGenaralNuevo: idEstudianteGenaralNuevo,
                option: "unificacionDocumento",
                action: accion
            },
            success: function (data) {
                if (data.s) {
                    contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                    contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">' + data.msj + '</span>');
                    showAlert(dataAlert[2].type, contentHTML, true);
                    $("#cbmTipoDocumentoAnterior").val('');
                    $("#txtDocumentoAnterior").val('');
                    $("#idEstudianteGenaralAntiguo").val('');
                    $("#cbmTipoDocumentoNuevo").val('');
                    $("#txtDocumentoNuevo").val('');
                    $("#idEstudianteGenaralNuevo").val('');
                    $("#nombreestudiante").html('');
                    $("#nombreestudiantenuevo").html('');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">El servidor no responde</span>');
                showAlert(dataAlert[4].type, contentHTML, true);
            }
        });
    } else {
        contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">No se puede Unificar</span>');
        showAlert(dataAlert[4].type, contentHTML, true);
    }



}

