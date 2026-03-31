$(function () {
    var allowContinue = true;
    $("#formPeriodoAcademico").bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            codigoModalidadAcademica: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar un modalidad académica'
                    }
                }
            },
            codigoCarrera: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar un programa académico'
                    }
                }
            },
            anio: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar el año del periodo'
                    }
                }
            },
            idPeriodoMaestro: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar el período'
                    }
                }
            },
            idPeriodoFinanciero: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar un período financiero'
                    }
                }
            },
            fechaInicio: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar fecha de inicio del período académico'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'No es una fecha válida'
                    }
                }
            },
            fechaFin: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar fecha de fin del período académico'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'No es una fecha válida'
                    },
                    callback: {
                        message: 'La fecha fin debe ser mayor que la fecha de inicio',
                        callback: function () {
                            const fechaInicio = $("#fechaInicio").val();
                            const fechaFin = $("#fechaFin").val();
                            const mFechaFin = new moment(fechaFin, 'YYYY-MM-DD', true);
                            const mFechaInicio = new moment(fechaInicio, 'YYYY-MM-DD', true);
                            var resultado = mFechaFin.isAfter(mFechaInicio);
                            return  resultado;
                        }
                    }
                }
            }

        },
        onSuccess: function (e) {
            e.preventDefault( );
            e.stopPropagation();
            e.stopImmediatePropagation();
            if(allowContinue){
                allowContinue = false;
                showLoader();
                e.preventDefault( );
                e.stopPropagation();
                e.stopImmediatePropagation();

                var id = $("#id").val();
                var codigoModalidadAcademica = $("#codigoModalidadAcademica").val();
                var codigoCarrera = $("#codigoCarrera").val();
                var anio = $("#anio").val();
                var idPeriodoMaestro = $("#idPeriodoMaestro").val();
                var idPeriodoFinanciero = $("#idPeriodoFinanciero").val(); 
                var fechaInicio = $("#fechaInicio").val();
                var fechaFin  = $("#fechaFin").val();
                var idEstadoPeriodo  = $("#idEstadoPeriodo").val();

                $.ajax({
                    url: HTTP_SITE + "/index.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        tmpl: 'json',
                        option: "administracionPeriodo",
                        action: "administrarPeriodo",
                        dataType: "PeriodoAcademico",
                        dataAction: "guardar",
                        id: id,
                        codigoModalidadAcademica: codigoModalidadAcademica,
                        codigoCarrera: codigoCarrera,
                        anio: anio,
                        idPeriodoMaestro: idPeriodoMaestro,
                        idPeriodoFinanciero: idPeriodoFinanciero,
                        fechaInicio: fechaInicio,
                        fechaFin: fechaFin,
                        idEstadoPeriodo:  idEstadoPeriodo
                    },
                    success: function (data) {
                        if(!data.s){
                            allowContinue = true;
                            contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                            contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                            $("#mensajeLoader").html('<div class="alert alert-'+dataAlert[4].type+' fade in">'+contentHTML+' </div>');
                            timeOutVar = window.setTimeout(function(){hideLoader();}, 5000);
                            $('#formPeriodoAcademico').bootstrapValidator('revalidateField', 'codigoCarrera');
                        }else{
                            allowContinue = true;
                            contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                            contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                            $("#mensajeLoader").html('<div class="alert alert-'+dataAlert[2].type+' fade in">'+contentHTML+' </div>');
                            timeOutVar = window.setTimeout(function(){
                                $(".accionMenu[data-action=listar][data-type=PeriodoAcademico]").trigger("click");
                                bootbox.hideAll();
                                hideLoader();
                            }, 5000);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        allowContinue = true;
                        hideLoader();
                    }
                }).always(function () {
                  
                });
            }
        }
    }).on('error.form.bv', function(e, data) {
        allowContinue = true;
    });

    $('.input-group.date').datepicker({
        autoclose: true,
        todayBtn: "linked",
        format: "yyyy-mm-dd"
    }).on("change", function () {
        var field = $(this).data("name");
        $('#formPeriodoAcademico').bootstrapValidator('revalidateField', field);
    });

    $("#codigoModalidadAcademica").change(function () {
        var codigoModalidadAcademica = $(this).val();
        showLoader();
        $.ajax({
            url: HTTP_SITE + "/index.php",
            type: "POST",
            dataType: "json",
            data: {
                tmpl: 'json',
                action: "getCombo",
                option: "administracionPeriodo",
                dataAction: "getCarreras",
                dataType: "PeriodoAcademico",
                codigoModalidadAcademica: codigoModalidadAcademica
            },
            success: function (data) {
                if (data.s) {
                    $('#codigoCarrera').empty(); //remove all child nodes 
                    $('#codigoCarrera').append(data.options);
                    $('#codigoCarrera').trigger("chosen:updated");
                    $('#formPeriodoAcademico').bootstrapValidator('revalidateField', 'codigoCarrera');
                    hideLoader();
                } else {
                    $("#mensajeLoader").html("<strong>" + data.msj + "</strong>");
                    timeOutVar = window.setTimeout(function () {
                        hideLoader();
                    }, 15000);
                    $('#formPeriodoAcademico').bootstrapValidator('revalidateField', 'codigoCarrera');
                }
            }
        }).always(function () {
            hideLoader();
        });
    });


    $("#anio").change(function () {
        var idAnio = $(this).val();
        showLoader();
        $.ajax({
            url: HTTP_SITE + "/index.php",
            type: "POST",
            dataType: "json",
            data: {
                tmpl: 'json',
                action: "getCombo",
                option: "administracionPeriodo",
                dataAction: "getPeriodosMaestros",
                dataType: "PeriodoAcademico",
                idAnio: idAnio
            },
            success: function (data) {
                if (data.s) {
                    $('#idPeriodoMaestro').empty(); //remove all child nodes 
                    $('#idPeriodoMaestro').append(data.options);
                    $('#idPeriodoMaestro').trigger("chosen:updated");
                    $('#formPeriodoAcademico').bootstrapValidator('revalidateField', 'idPeriodoMaestro');
                    hideLoader();
                } else {
                    $("#mensajeLoader").html("<strong>" + data.msj + "</strong>");
                    timeOutVar = window.setTimeout(function () {
                        hideLoader();
                    }, 15000);
                    $('#formPeriodoAcademico').bootstrapValidator('revalidateField', 'idPeriodoMaestro');
                }
            }
        }).always(function () {
            hideLoader();
        });

        showLoader();
        $.ajax({
            url: HTTP_SITE + "/index.php",
            type: "POST",
            dataType: "json",
            data: {
                tmpl: 'json',
                action: "getCombo",
                option: "administracionPeriodo",
                dataAction: "getPeriodosFinancieros",
                dataType: "PeriodoAcademico",
                idAnio: idAnio
            },
            success: function (data) {
                if (data.s) {
                    $('#idPeriodoFinanciero').empty(); //remove all child nodes 
                    $('#idPeriodoFinanciero').append(data.options);
                    $('#idPeriodoFinanciero').trigger("chosen:updated");
                    $('#formPeriodoAcademico').bootstrapValidator('revalidateField', 'idPeriodoFinanciero');
                    hideLoader();
                } else {
                    $("#mensajeLoader").html("<strong>" + data.msj + "</strong>");
                    timeOutVar = window.setTimeout(function () {
                        hideLoader();
                    }, 15000);
                    $('#formPeriodoAcademico').bootstrapValidator('revalidateField', 'idPeriodoFinanciero');
                }
            }
        }).always(function () {
            hideLoader();
        });
    });
});