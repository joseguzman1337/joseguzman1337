$(document).ready(function(){
    $("#consultar_btn").click(function(e){
        e.preventDefault();
        e.stopPropagation();

        var documento = $('#ndocumento').val();
        var fechanacimiento = $('#fechanacimiento').val();

        $.ajax({
            url: "../control/ControlConsultaUsuarios.php",
            type: "POST",
            dataType: "json",
            data: {
                tmpl: 'json',
                action: "buscarUsuario",
                documento: documento,
                fechanacimiento: fechanacimiento
            },
            success: function( data ){
                if(data.val == true){
                    $('#resultado').html("" +
                        "<h3>Detalles: </h3>" +
                        "<p>Usuario Institucional: <strong>"+data.id+"@unbosque.edu.co</strong>"+
                        "<br>Apellidos: <strong>"+data.apellidos+"</strong>"+
                        "<br>Nombres: <strong>"+data.nombres+"</strong>"+
                        "<br>Email personal : <strong>"+data.emailestudiantegeneral+"</strong>"+
                        "<br>Clave Temporal: <strong>"+data.claveusuario+"</strong>"+
                        "<br>Fecha de creacion : <strong>"+data.fechalogcreacionusuario+"</strong>"+
                        "</p>");
                }else{
                    swal(data.msg)
                    $('#resultado').html("");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("error de consulta");
            }
        });
    });
});


;