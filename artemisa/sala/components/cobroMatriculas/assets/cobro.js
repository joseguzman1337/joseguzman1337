$(function () {
    $("#formCobro").bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            periodoMatriculas: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar el perido'
                    }
                }
            },
            porcentajeDesde: {
                validators: {
                    notEmpty: {
                        message: 'Debe digitar un valor entre 0 y 100'
                    },
                    regexp: {

                        regexp: /^[0-9]+$/,
                        message: 'Solo puede contener números'

                    },

                    between: {
                        min: 0,
                        max: 100,
                        message: 'Debe digitar un valor entre 0 y 100'
                    }
                }
            },
            porcentajeHasta: {
                validators: {
                    notEmpty: {
                        message: 'Debe digitar un valor entre 0 y 100'
                    },
                    regexp: {

                        regexp: /^[0-9]+$/,
                        message: 'Solo puede contener números'

                    },

                    between: {
                        min: 0,
                        max: 100,
                        message: 'Debe digitar un valor entre 0 y 100'
                    }
                }
            },
            porcentajeCobro: {
                validators: {
                    notEmpty: {
                        message: 'Debe digitar un valor entre 0 y 100'
                    },
                    regexp: {

                        regexp: /^[0-9]+$/,
                        message: 'Solo puede contener números'

                    },

                    between: {
                        min: 0,
                        max: 100,
                        message: 'Debe digitar un valor entre 0 y 100'
                    }
                }
            }


        }, onSuccess: function (e) {
            e.preventDefault( );
            e.stopPropagation();
            e.stopImmediatePropagation();
            showLoader();
            var periodoActual = $("#periodoMatriculas").data("periodo");
            var periodoNuevo = $("#periodoMatriculas").val();
            var desdeActual = $("#porcentajeDesde").data("desde");
            var desdeNuevo = $("#porcentajeDesde").val();
            var hastaActual = $("#porcentajeHasta").data("hasta");
            var hastaNuevo = $("#porcentajeHasta").val();
            var cobroActual = $("#porcentajeCobro").data("cobro");
            var cobroNuevo = $("#porcentajeCobro").val();
            var item = $("#item").val();

            $.ajax({
                url: HTTP_SITE + "/index.php",
                type: "POST",
                dataType: "json",
                data: {
                    tmpl: 'json',
                    action: "administrarCobroMatriculas",
                    option: "cobroMatriculas",
                    periodoActual: periodoActual,
                    periodoNuevo: periodoNuevo,
                    desdeActual: desdeActual,
                    desdeNuevo: desdeNuevo,
                    hastaActual: hastaActual,
                    hastaNuevo: hastaNuevo,
                    cobroActual: cobroActual,
                    cobroNuevo: cobroNuevo
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
                            $("#menuId_" + item + "").trigger('click');
                            hideLoader();
                        }, 3000);
                    }
                }
            });
        }
    });

});
