/**
 * @author Carlos
 */

$(function () {
    $("#menuFacilitador").tabs({
        selected: 0,
        spinner: "Cargando <img width='16' height='16' src='../css/images/cargando.gif' />"
    });

    $("#mensageDialogo").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        hide: "explode",
        buttons: {
            "Cerrar": function ( ) {
                $(this).dialog("close");
            }
        }
    });

    $("#mensageAlert").dialog({
        autoOpen: false,
        modal: true,
        width: 700,
        resizable: false,
        hide: "explode",
        buttons: {
            "Cerrar": function ( ) {
                $(this).dialog("close");
            }
        }
    });

    $("#alertas").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        hide: "explode",
        title: "Lista de alertas",
        width: 800,
        height: 400,
        buttons: {
            "Cerrar": function ( ) {
                $(this).dialog("close");
            }
        }
    });

    $("#mensageConfirmacion").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        title: "Confirmacion",
        hide: "explode",
        buttons: {
            "Cancelar": function ( ) {
                $(this).dialog("close");
            },
            "Continuar": function ( ) {
                $("#" + objeto).dialog("close");
                $(this).dialog("close");
            }
        }
    });

    $("#mensageCargando").dialog({
        title: "Cargando <img width='16' height='16' src='../css/images/cargando.gif' />",
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 0,
        height: 0,
        hide: "explode",
        open: function (event, ui) {
            $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
        }
    });

    $("#mensageRegistroGrado").dialog({
        autoOpen: false,
        show: "blind",
        modal: true,
        resizable: false,
        title: "Registro Grado",
        width: 250,
        height: 200,
        hide: "explode"
    });

    $("#mensageEliminarRegistroGrado").dialog({
        autoOpen: false,
        show: "blind",
        modal: true,
        resizable: false,
        title: "Eliminar Registro Grado",
        width: 250,
        height: 200,
        hide: "explode"
    });

    $("#mensageActualizarDiploma").dialog({
        autoOpen: false,
        show: "blind",
        modal: true,
        resizable: false,
        title: "Actualizar Número Diploma",
        width: 250,
        height: 200,
        hide: "explode"
    });

    $("#dialogNota").dialog({
        autoOpen: false,
        show: "blind",
        modal: true,
        resizable: false,
        width: 500,
        height: "auto",
        hide: "explode"
    });

    /*$( "#notificacion" ).dialog({
     autoOpen: true,
     modal: true,
     resizable: false,
     title: "Alerta de Inscripciones a Vencersen",
     hide: "explode",
     buttons: {
     "Continuar": function( ) {
     $( this ).dialog("close"); 
     verInscripcionesNoPagadas( );
     
     },
     "Cancelar": function( ) { 
     $( this ).dialog("close"); 
     }
     }
     });	*/


});

function crearMensaje(data) {
    $.ajax({
        url: "../servicio/mensajes.php",
        type: "POST",
        data: data,
        success: function (data) {
            $("#dialogo").html(data);
            $("#mensageDialogo").dialog("open");
        }
    });
}

/** Modified Diego Rivera <riveradiego@unbosque.edu.co>
 * Se agrega funcion actualizarMensaje  
 * Since july 15,2019
 */

function actualizarMensaje( ) {
    var mensaje = 'promocionActualizado';
    $.ajax({
        url: "../servicio/mensajes.php",
        type: "POST",
        data: {mensaje: mensaje},
        success: function (data) {
            $("#dialogo").html(data);
            $("#mensageDialogo").dialog("open");
        }
    });
}

function trim(dato) {
    dato = String(dato);
    return dato.replace(/^\s+/g, '').replace(/\s+$/g, '');
}

function llenarFormulario(data) {
    var datos = data.split('&');
    for (var i = 0; i < datos.length; i++) {
        var campo = datos[i].split('=');
        $("#" + campo[0]).val(trim(campo[1]));
        //alert(campo[0] + ' ' + campo[1]);
    }
}

function validar(errores, radicacion) {
    var mensaje = "controlCampos";
    $.ajax({
        url: "../servicio/mensajes.php",
        type: "POST",
        data: {mensaje: mensaje, errores: errores},
        success: function (data) {
            $("#alerta").html(data);
            $("#mensageAlert").dialog("option", "buttons", [
                {
                    text: "Aceptar",
                    click: function () {
                        $(this).dialog("close");
                        $("#" + radicacion).remove( );
                        $("#dialogQueja").dialog("close");
                        crearMensaje("mensaje=complementada");
                    }
                }
            ]);

            $("#mensageAlert").dialog("open");
        }
    });
}


function validar(errores) {
    var mensaje = "controlCampos";
    $.ajax({
        url: "../servicio/mensajes.php",
        type: "POST",
        data: {mensaje: mensaje, errores: errores},
        success: function (data) {
            $("#alerta").html(data);
            $("#mensageAlert").dialog("option", "buttons", [
                {
                    text: "Aceptar",
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ]);

            $("#mensageAlert").dialog("open");
        }
    });
}


function validarTipos(errores) {
    var mensaje = "tipoGrado";
    $.ajax({
        url: "../servicio/mensajes.php",
        type: "POST",
        data: {mensaje: mensaje, errores: errores},
        success: function (data) {
            $("#alerta").html(data);
            $("#mensageAlert").dialog("option", "buttons", [
                {
                    text: "Aceptar",
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ]);

            $("#mensageAlert").dialog("open");
        }
    });
}



function validarSinDatos(errores) {
    var mensaje = "sinDatos";
    $.ajax({
        url: "../servicio/mensajes.php",
        type: "POST",
        data: {mensaje: mensaje, errores: errores},
        success: function (data) {
            $("#alerta").html(data);
            $("#mensageAlert").dialog("option", "buttons", [
                {
                    text: "Aceptar",
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ]);

            $("#mensageAlert").dialog("open");
        }
    });
}







function validarFormulario(data) {
    var datosVacios = "";
    var datos = data.split('&');
    for (var i = 0; i < datos.length; i++) {
        var campos = datos[i].split('=');
        var valor = trim(campos[1]);
        if (valor == "" || valor == "-1") {
            var titulo = $("#" + campos[0]).attr("title");
            datosVacios = datosVacios + campos[0] + "=" + titulo + "&";
        }
    }
    if (datosVacios != "")
        datosVacios = datosVacios + "mensaje=ValidarCampos";
    return datosVacios;
}

/*
 function llenarFormulario( data ){
 var datos = data.split('&');
 for( var i = 0 ; i < datos.length ; i++ ){
 var campo = datos[i].split('=');
 $( "#"+campo[0] + "" + txtNumeroCarga ).val( trim( campo[1] ) );
 }
 }*/



function conexion(  ) {
    $.ajax({
        url: "../servicio/estadoConexion.php",
        success: function (data) {
            $("#conexion").html(data);
        }
    });
    setTimeout("conexion( )", 10000);
}

function mensajeConfirmacion(objeto) {
    $("#mensageConfirmacion").dialog("option", "buttons", [
        {
            text: "Cancelar",
            click: function () {
                $(this).dialog("close");
            }
        },
        {
            text: "Continuar",
            click: function () {
                $("#" + objeto).dialog("close");
                $(this).dialog("close");
            }
        }
    ]);
    $("#mensageConfirmacion").dialog("open");
}





/*$(function(){
 $('#formInscribirPersona').validate({
 rules: {
 'nombre': 'required'           
 },
 messages: {
 'nombre': 'Debe ingresar el nombre'           
 },
 debug: true,
 /*errorElement: 'div',*/
//errorContainer: $('#errores'),
/* submitHandler: function(form){
 alert('El formulario ha sido validado correctamente!');
 }
 });
 });*/





