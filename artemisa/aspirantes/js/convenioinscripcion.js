$(document).ready(function(){
    $("#convenioinscrip_btn").click(function(e){
        e.preventDefault();
        e.stopPropagation();

        var idconvenio = $('#idconvenio option:selected').attr("id");
        var codigoestudiante = $('#codigoestudiante').val();
        var periodo = $('#codigoperiodo').val();
        var idusuario = $('#idusuario').val();
        swal(idconvenio);
        $.ajax({
            url: "control/ControlEnLineaCentral.php",
            type: "POST",
            dataType: "json",
            data: {
                tmpl: 'json',
                action: "asignarConvenio",
                idconvenio: idconvenio,
                codigoestudiante: codigoestudiante,
                codigoperiodo: periodo,
                idusuario:idusuario
            },
            success: function( data ){
                swal(data.msg);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("error de consulta");
            }
        });
    });
});