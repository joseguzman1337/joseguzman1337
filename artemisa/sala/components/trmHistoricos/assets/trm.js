$(function () {
    $("#fechainicio").on('change',function(){
        $("#fechafin").attr('min', $("#fechainicio").val());
    });
    $("#formTrm").bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            valortrm: {
                validators: {
                    notEmpty: {
                        message: 'Debe digitar un valor para la TRM'
                    }
                }
            },
            tipomoneda:{
                validators: {
                    notEmpty: {
                        message: 'Seleccion el tipo de modena'
                    }
                }
            },
            fechainicio:{
                validators: {
                    notEmpty: {
                        message: 'Digíte la fecha inicial para la TRM del día'
                    }
                }
            },
            fechafin:{
                validators: {
                    notEmpty: {
                        message: 'Es necesario una fecha de finalizacion para la TRM del día'
                    }
                }
            },
            novedad:{
                validators: {
                    notEmpty: {
                        message: 'Registre el motivo por el cual se ingreso la trm de modo manual'
                    }
                }
            },
        }, onSuccess: function (e) {
            e.preventDefault( );
            e.stopPropagation();
            e.stopImmediatePropagation();
            showLoader();
            let valorTrm = $("#valortrm").val();
            let fechaInicio = $("#fechainicio").val();
            let fechaFin = $("#fechafin").val();
            let novedad = $("#novedad").val();
            let tipoMoneda = $("#tipomoneda").val();
            let tipotrm = "Ingreso-Manual";
            let estadoTrm = $("#estadoTrm").val();
            let item = $("#item").val();
            $.ajax({
                url: HTTP_SITE + "/index.php",
                type: "POST",
                dataType: "json",
                data: {
                    tmpl: 'json',
                    action: "administrarTrmHistorico",
                    option: "trmHistoricos",
                    valorTrm: valorTrm,
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin,
                    novedad: novedad,
                    tipoMoneda: tipoMoneda,
                    tipotrm:tipotrm,
                    estadoTrm:estadoTrm,
                    item:item
                },
                success: function (data) {

                    var contentHTML = "";
                    if (!data.s) {
                        contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">' + data.msj + '</span>');
                        $("#mensajeLoader").html('<div class="alert alert-' + dataAlert[4].type + ' fade in">' + contentHTML + ' </div>');
                        window.setTimeout(function () {
                            hideLoader();
                        }, 3000);
                    } else {
                        contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">' + data.msj + '</span>');
                        $("#mensajeLoader").html('<div class="alert alert-' + dataAlert[2].type + ' fade in">' + contentHTML + ' </div>');
                        window.setTimeout(function () {
                            bootbox.hideAll();
                            // $("#menuId_" + item + "").trigger('click');
                            hideLoader();
                        }, 3000);
                    }
                }
            });
        }
    });
});
