$(function () {
    var allowContinue = true;
    $('#secuencia').on("click", function () {
        if ($('#secuencia').prop('checked')) {
            $("#nombre").prop("disabled", true);
            $("#obligatorio").hide();
        } else {
            $("#nombre").prop("disabled", false);
            $("#obligatorio").show();
        }
    });

    $("#formPeriodoMaestro").bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            anio: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar el año del período maestro'
                    }
                }
            },
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'Debe digitar el nombre del período'
                    }
                }
            },
            numeroPeriodo: {
                validators: {
                    notEmpty: {
                        message: 'Debe digitar el número de período'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Solo admite valores numericos'
                    }
                }
            },
            estado: {

            }
        },
        onSuccess: function (e) {
            if(allowContinue){
                allowContinue = false;
                showLoader();
                e.preventDefault( );
                e.stopPropagation();
                e.stopImmediatePropagation();
                var secuencia = "";

                if ($('#secuencia').prop('checked')) {
                    secuencia = "secuencia";
                } else {
                    secuencia = "unico";
                }

                var id = $("#id").val();
                var estado = "";

                if ($("#estado").length) {
                    estado = $('select[id=estado]').val();
                } else {
                    estado = 100;
                }

                $.ajax({
                    url: HTTP_SITE + "/index.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        tmpl: 'json',
                        action: "administrarPeriodo",
                        dataAction: "guardar",
                        dataType: "PeriodoMaestro",
                        option: "administracionPeriodo",
                        codigoMaestro: $("#codigoMaestro").val(),
                        anio: $("#anio").val(),
                        nombre: $("#nombre").val(),
                        numeroPeriodo: $("#numeroPeriodo").val(),
                        secuencia: secuencia,
                        estado: estado,
                        id: id
                    },
                    success: function (data) {
                        if(!data.s){
                            allowContinue = true;
                            contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                            contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                            $("#mensajeLoader").html('<div class="alert alert-'+dataAlert[4].type+' fade in">'+contentHTML+' </div>');
                            timeOutVar = window.setTimeout(function(){hideLoader();}, 3000);
                        }else{

                            contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                            contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                            $("#mensajeLoader").html('<div class="alert alert-'+dataAlert[2].type+' fade in">'+contentHTML+' </div>');
                            timeOutVar = window.setTimeout(function(){
                                $(".accionMenu[data-action=listar][data-type=PeriodoMaestro]").trigger("click");
                                bootbox.hideAll();
                                hideLoader();
                            }, 3000);
                        }
                    }
                });
            }
        }
    }).on('error.form.bv', function(e, data) {
        allowContinue = true;
    });

});