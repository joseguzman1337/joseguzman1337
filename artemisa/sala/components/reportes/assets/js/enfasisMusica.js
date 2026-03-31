$(document).ready(function () {
    var exportar = false;
    $("#exportar").click(function () {
        exportar = true;
    });
    $("#consultar").click(function () {
        exportar = false;
    });
    $("#reporteEnfasisSemestre").bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            enfasis: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar la enfasis'
                    }
                }
            },
            semestre: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar el  semestre'
                    }
                }
            },
            periodo: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar un perido'
                    }
                }
            }
        },
        onSuccess: function (e) {
            showLoader();
            e.preventDefault( );
            e.stopPropagation( );
            if (exportar) {
                var enfasis = $("#enfasis").val( );
                var semestre = $("#semestre").val( );
                var periodo = $("#periodo").val( )
                var url = HTTP_SITE + "/index.php?tmpl=json&action=descargarReporteEnfasisMusica&option=reportes&idEnfasis=" + enfasis + "&semestre=" + semestre + "&periodo=" + periodo;
                window.open(url, '_blank');
                hideLoader();
            } else {
                consultar();
            }
        }
    });
});

function consultar() {
    var enfasis = $("#enfasis").val( );
    var semestre = $("#semestre").val( );
    var periodo = $("#periodo").val( )
    $("#visualizar").html("");
    $.ajax({
        url: HTTP_SITE + "/index.php",
        type: "GET",
        dataType: "html",
        data: {
            tmpl: 'json',
            layout: "reporteEnfasisMusica",
            option: "reportes",
            idEnfasis: enfasis,
            semestre: semestre,
            periodo: periodo
        },
        success: function (data) {
            $("#visualizar").html(data);

            $('#datosCambioPeriodo').bootstrapTable({
                onPostBody: function () {
                    onClickPlanEstudio();
                    onClickMatricula();
                    onClickPreMatricula();
                    onClickNota();
                }
            });
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function () {
        hideLoader();
    });
}
function onClickNota() {
    $(".notas").click(function (e) {
        showLoader();
        e.stopPropagation();
        e.preventDefault();
        var href = $(this).attr("href");
        var cuerpoIframe = '<iframe scrolling="auto" marginheight="0" marginwidth="0" src="'+href+'" width="100%" height="492" frameborder="0"></iframe>';
        
        abrirModal("", cuerpoIframe);
        hideLoader();
    });    
}
function onClickPlanEstudio() {
    $(".planEstudio").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var codigoEstudiante = $(this).attr("id");
        showLoader();
        $.ajax({
            url: HTTP_ROOT + "/serviciosacademicos/consulta/facultades/planestudioestudiante/planestudioestudiante.php",
            type: "POST",
            dataType: "html",
            data: {
                tmpl: 'json',
                codigoestudiante: codigoEstudiante
            },
            success: function (data) {
                abrirModal("Plan estudio", data);
                hideLoader();
            },
            error: function (xhr, ajaxOptions, thrownError) {}
        }).always(function () {
            hideLoader();
        });
    });
}

function onClickMatricula() {

    $(".registroMatricula").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var codigoEstudiante = $(this).attr("id");
        showLoader();
        $.ajax({
            url: HTTP_ROOT + "/serviciosacademicos/consulta/facultades/registromatriculas/registromatriculasformulario.php",
            type: "GET",
            dataType: "html",
            data: {
                tmpl: 'json',
                tipodetalleseguimiento: 100,
                codigo: codigoEstudiante,
                busqueda_semestre: ""
            },
            success: function (data) {
                abrirModal("", data);
                hideLoader();
            },
            error: function (xhr, ajaxOptions, thrownError) {}
        }).always(function () {
            hideLoader();
        });
    });
}

function onClickPreMatricula() {
    $(".registroPreMatricula").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var codigoEstudiante = $(this).attr("id");
        showLoader();
            
        $.ajax({
            url: HTTP_SITE + "/index.php",
            type: "POST",
            dataType: "html",
            data: {
                tmpl: 'json',
                action:"sesionEstudiante",
                option: "reportes",
                codigoEstudiante:codigoEstudiante 
            },
            success: function (data) {
                showLoader();
                $.ajax({
                    url: HTTP_ROOT + "/serviciosacademicos/consulta/prematricula/matriculaautomatica.php",
                    type: "GET",
                    dataType: "html",
                    data: {
                        tmpl: 'json',
                        tipodetalleseguimiento: 100,
                        codigo: codigoEstudiante,
                        busqueda_semestre: ""
                    },
                    success: function (data) {
                        abrirModal("Registro matricula", data);
                        hideLoader();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {}
                }).always(function () {
                    hideLoader();
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {}
        }).always(function () {
       
        });
       
    });

}
