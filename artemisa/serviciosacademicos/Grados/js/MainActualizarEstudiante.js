/**
 * @author suarezcarlos
 */

/*
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se modifica la validacion de acuerdo al tipo de documento para cuando sea pasaporte permita ingresar letras y numeros
 * @since Agosto 29, 2018
 */ 
$(document).ready(function () {

    $("#cmbTipoDocumentoAE").on('change', function () {
        switch ($("#cmbTipoDocumentoAE").val()) {
            default :
                $("#txtNumeroDocumentoAE").val('');
                break;
        }
    });  

    $("#txtNumeroDocumentoAE").keyup(function(){
        cmbTipoDocumentoAE = $("#cmbTipoDocumentoAE").val();
        switch (cmbTipoDocumentoAE) {
            case '05':
                if (!/^[a-zA-Z0-9]+$/.test($("#txtNumeroDocumentoAE").val())){
                    $("#txtNumeroDocumentoAE").val('');
                }
                break;
            default :
                if (!/^[0-9]+$/.test($("#txtNumeroDocumentoAE").val())){
                    $("#txtNumeroDocumentoAE").val('');
                }
                break;
        }
    });

});

$("#btnActualizarEstudiante").button( ).click(function () {
    $("#btnActualizarEstudiante").button({label: "Buscando <img width='16' height='16' src='../css/images/cargando.gif' />"});
    $("#btnActualizarEstudiante").button("option", "disabled", true);
    $.ajax({
        url: "../servicio/estudiante.php",
        type: "POST",
        data: $("#formActualizarEstudiante").serialize( ),
        success: function (data) {
            //$("#log").html( data );
            alert(data);
            $("#btnActualizarEstudiante").button({label: "Actualizar"});
            $("#btnActualizarEstudiante").button("option", "disabled", false);

            /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
             *se crea variable id la cual recibe le codigo de  estudiante  esto con el fin de modificar el <td> de la tabla donde se visualizan los estudiantes 
             proximos para grado  esto permite el cambio del icono  y parametros de funcion sin consultar de nuevo todos los registros,
             se desactiva  $( "#btnBuscarTMando" ).trigger( "click" ); para evitar recargue de consulta
             *Since september 27 , 2017
             */
            var id = $("#txtCodigoEstudiante").val( );
            $("#" + id).html('<input class="editar" name="btnEdit-' + id + '" id="btn-' + id + '" title="Actualizar Estudiante" onclick="verActualizarEstudiante( ' + id + ' , 1 )" value="" style="background:url(../css/images/tick.png) no-repeat; border:none; margin-top:0.3cm; width:30px; height:30px; cursor:pointer;" type="button">');
            $("#mensageActualizarEstudiante").dialog("close");
            //$( "#btnBuscarTMando" ).trigger( "click" );
            //fin modificacion Diego 
        }
    });
    /*var txtValidaActualizar = $("#txtValidaActualizar").val( ); 
     $.ajax({
     url: "../../consulta/facultades/creacionestudiante/editarestudiante.php",
     type: "POST",
     data: $( "#formActualizarEstudiante" ).serialize( ),
     success: function( data ){
     alert(data);
     $( "#btnActualizarEstudiante" ).button({ label: "Actualizar" });
     $( "#btnActualizarEstudiante" ).button( "option", "disabled", false );
     $( "#mensageActualizarEstudiante" ).dialog( "close" );
     $( "#btnBuscarTMando" ).trigger( "click" );
     
     }
     });*/
});
