alowNavigate = false;
$(document).ready(function(){
    $(".selCarrera").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        seleccionarCarrera(this);
    });
});

function seleccionarCarrera(obj){
    var codigoestudiante = $(obj).attr("data-codigoestudiante");
    var codigoperiodo = $(obj).attr("data-codigoperiodo");
    showLoader();
    $.ajax({
        url: HTTP_SITE+'/index.php',
        type: "GET",
        dataType: "json",
        data: {
            tmpl : 'json',
            action : "seleccionarCarreraEstudiante",
            option : "dashBoard",
            codigoestudiante : codigoestudiante,
            codigoperiodo : codigoperiodo
        },
        success: function( data ){
            if(data.s){
                alowNavigate = true;
                contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.mensaje+'</span>');
                showAlert(dataAlert[2].type,contentHTML);
                window.location.reload();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
            contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">El servidor no responde, por favor comuniquese con la mesa de servicio</span>');
            showAlert(dataAlert[4].type,contentHTML);
        },
        complete: function( ){
            hideLoader();
        }
    }).always(function() {
        hideLoader();
    });
}
