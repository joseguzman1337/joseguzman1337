$(function () {
    var allowContinue = true;
    $("#formPeriodoFinanciero").bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            anio: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar el año del período'
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
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'Debe digitar el nombre del período financiero'
                    }
                }
            },
            fechaInicio: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar la fecha de inicio del período financiero'
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
                        message: 'Debe seleccionar la fecha de fin del período financiero'
                    }, 
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'No es una fecha válida'
                    },
                    callback: {
                        message: 'La fecha fin debe ser mayor que la fecha de inicio',
                        callback: function() {
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
        },onSuccess: function (e) {
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
                var idanio = $("#anio").val();
                var idPeriodoMaestro = $("#idPeriodoMaestro").val();
                var nombre = $("#nombre").val();
                var fechaInicio = $("#fechaInicio").val();
                var fechaFin = $("#fechaFin").val();

                $.ajax({
                    url: HTTP_SITE + "/index.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        tmpl: 'json',
                        action: "administrarPeriodo",
                        dataAction: "guardar",
                        dataType: "PeriodoFinanciero",
                        option: "administracionPeriodo",
                        id: id,
                        idanio: idanio,
                        idPeriodoMaestro: idPeriodoMaestro,
                        nombre: nombre,
                        fechaInicio: fechaInicio,
                        fechaFin: fechaFin
                    },
                    success: function (data) {
                        if(!data.s){
                            allowContinue = true;
                            contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                            contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                            $("#mensajeLoader").html('<div class="alert alert-'+dataAlert[4].type+' fade in">'+contentHTML+' </div>');
                            timeOutVar = window.setTimeout(function(){hideLoader();}, 5000);
                        }else{

                            contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                            contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                            $("#mensajeLoader").html('<div class="alert alert-'+dataAlert[2].type+' fade in">'+contentHTML+' </div>');
                            timeOutVar = window.setTimeout(function(){
                                $(".accionMenu[data-action=listar][data-type=PeriodoFinanciero]").trigger("click");
                                bootbox.hideAll();
                                hideLoader();
                            }, 5000);/**/
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
        autoclose:true,
        todayBtn: "linked",
        format: "yyyy-mm-dd" 
    }).on("change", function() {
        var field = $(this).data("name");
        $('#formPeriodoFinanciero').bootstrapValidator('revalidateField', field);
    });
    
    $("#anio").change(function (){        
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
                dataAction: "getPeriodosDelAgno",
                dataType: "PeriodoFinanciero",
                idAnio: idAnio        
            },
            success: function (data) {
                if(data.s){
                    $('#idPeriodoMaestro').empty(); //remove all child nodes 
                    $('#idPeriodoMaestro').append(data.options);
                    $('#idPeriodoMaestro').trigger("chosen:updated");
                    $('#formPeriodoFinanciero').bootstrapValidator('revalidateField', 'idPeriodoMaestro');
                    hideLoader();
                }else{
                    $("#mensajeLoader").html("<strong>"+data.msj+"</strong>");
                    timeOutVar = window.setTimeout(function(){hideLoader();}, 15000);
                    $('#formPeriodoFinanciero').bootstrapValidator('revalidateField', 'idPeriodoMaestro');
                }
            }
        }).always(function () {
            hideLoader();
        });
    });
});