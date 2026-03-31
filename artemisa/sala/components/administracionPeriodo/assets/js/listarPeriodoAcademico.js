$(document).on('click', '.accionPeriodoAcademico', function (e) {
    e.preventDefault( );
    e.stopPropagation();
    e.stopImmediatePropagation();
    var id = $(this).data("id");
    
    var accion = $(this).data("action");
    switch(accion){
        case "nuevo":
        case "editar":
            opcion="estadoOculto"
            editar(id,opcion);
            break;
        case "editarEstado":
            var opcion="estadoVisible";
            editar(id, opcion );
        
    }
});

$(document).on('change', '#programaAcademico,#anios ', function (e) {
    e.preventDefault( );
    e.stopPropagation();
    e.stopImmediatePropagation();
    
    var programaAcademico = $("#programaAcademico").val();
    var anio = $("#anios").val();
    $.ajax({
        url: HTTP_SITE + "/index.php",
        type: "POST",
        dataType: "html",
        data: {
            tmpl: 'json',
            layout: "listarPeriodoAcademico",
            option: "administracionPeriodo",
            dataAction: "listar",
            dataType: "PeriodoAcademico",
            anio:anio,
            programaAcademico:programaAcademico
        },
        success: function (data) {
            $("#cargarContenido").html(data);
            hideLoader();
        }
    });
})

function editar(id , opcion ){
    var titulo = "Editar";
    if(id==""){
        titulo = "Nuevo";
    }else if(opcion=="estadoVisible"){
        titulo = "Editar Estado";
    }
    showLoader();
    $.ajax({
        url: HTTP_SITE + "/index.php",
        type: "POST",
        dataType: "html",
       
        data: {
            tmpl: 'json',
            option: "administracionPeriodo",
            layout:"nuevoPeriodoAcademico",
            id:id,
            dataType: "PeriodoAcademico",
            dataAction:"nuevo",
            estado:opcion
        },
        success: function (data) {
            abrirModal(titulo+" Período Académico", data);
            hideLoader();
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function () {
        hideLoader();
    });
}
