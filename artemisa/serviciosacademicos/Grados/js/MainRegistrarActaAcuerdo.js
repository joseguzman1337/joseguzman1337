/**
 * @author suarezcarlos
 */

$("#mensageActaAcuerdo").dialog({
    autoOpen: false,
    show: "blind",
    modal: true,
    resizable: false,
    title: "Guardar Acta",
    width: 250,
    height: 200,
    hide: "explode"
});



var dates = $("#fechaActa").datepicker({
    defaultDate: "0w",
    changeMonth: true,
    numberOfMonths: 2,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    onSelect: function (selectedDate) {
        var option = this.id == "fechaActa" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
    }
}, $.datepicker.regional["es"]);

var table = $("#registroActaAcuerdo").dataTable({
    "bJQueryUI": true,
    "sPaginationType": "full_numbers",
    "responsive": true,
    "order": [[1, "asc"]],
    "oLanguage": {
        "sLoadingRecords": "Espere un momento, cargando...",
        "sSearch": "Buscar:",
        "sZeroRecords": "No hay datos con esa busqueda",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Ultimo",
            "sNext": "Siguiente",
            "sPrevious": "Anterior",
        }
    },
    "bDestroy": true
});


$("#btnRegistrarActaAcuerdo").button( ).click(function ( ) {
    var tipoOperacion = "crearActaAcuerdo";
    var txtCodigoEstudiantes = $("#ckSeleccionar", table.fnGetNodes()).serialize( );
    var txtNumeroActa = $("#txtNumeroActa").val( );
    var txtFechaActa = $("#fechaActa").val( );
    var txtFechaGrado = $("#txtFechaGrado").val( );
    var datos = "txtNumeroActa=" + txtNumeroActa + "&txtFechaActa=" + txtFechaActa;
    var camposVacios = validarFormulario(datos);
    if (camposVacios == "") {
        $("#btnRegistrarActaAcuerdo").button({label: "Registrando <img width='16' height='16' src='../css/images/cargando.gif' />"});
        $("#btnRegistrarActaAcuerdo").button("option", "disabled", true);
        $("#mensageActaAcuerdo").dialog("option", "buttons", {
            "Sí": function () {
                $.ajax({
                    url: "../servicio/actaAcuerdo.php",
                    type: "POST",
                    data: {tipoOperacion: tipoOperacion, txtNumeroActa: txtNumeroActa, txtFechaActa: txtFechaActa, txtFechaGrado: txtFechaGrado, txtCodigoEstudiantes: txtCodigoEstudiantes},
                    success: function (data) {
                        //alert(data);
                        if (data.length > 0) {
                            alert("Ocurrió un error");
                            $("#mensageActaAcuerdo").dialog("close");
                            $("#btnRegistrarActaAcuerdo").button({label: "Registrar"});
                            $("#btnRegistrarActaAcuerdo").button("option", "disabled", false);
                            $("#txtNumeroActa").val("");
                            $("#fechaActa").val("");
                        } else {
                            alert("Registro Guardado Correctamente");
                            $("#mensageActaAcuerdo").dialog("close");
                            $("#btnRegistrarActaAcuerdo").button({label: "Registrar"});
                            $("#btnRegistrarActaAcuerdo").button("option", "disabled", false);
                            $("#actaAcuerdo").dialog("close");
                            $("#btnBuscarTMando").trigger("click");
                        }
                    }
                });
                $("#btnRegistrarActaAcuerdo").off('click');
            },
            "No": function () {
                $("#mensageActaAcuerdo").dialog("close");
                $("#btnRegistrarActaAcuerdo").button({label: "Registrar"});
                $("#btnRegistrarActaAcuerdo").button("option", "disabled", false);
                $("#txtNumeroActa").val("");
                $("#fechaActa").val("");
            }
        });
        $("#mensageActaAcuerdo").dialog("open");
    } else {
        crearMensaje(camposVacios);
    }
  
});


if ($('#selectAll').is(':checked')) {
    $("#ckSeleccionar", table.fnGetNodes()).each(function () { //loop through each checkbox
        this.checked = true;  //select all checkboxes with class "checkbox1"               
    });
}


$('#selectAll').change(function (event) {  //on click 
    if (this.checked) {
        // check select status
        $("#ckSeleccionar", table.fnGetNodes()).each(function () { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"               
        });
    } else {
        $("#ckSeleccionar", table.fnGetNodes()).each(function () { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
        });
    }
});


var dates = $("#txtFechaActaIncentivo").datepicker({
    defaultDate: "0w",
    changeMonth: true,
    numberOfMonths: 2,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    onSelect: function (selectedDate) {
        var option = this.id == "txtFechaActaIncentivo" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
    }
}, $.datepicker.regional["es"]);



$("#btnRegistrarIncentivo").button( ).on("click", function ( ) {
    var tipoOperacion = "registrarIncentivo";
    var txtCodigoIncentivos = $("#ckIncentivo:checked").serialize( );
    var txtCodigoEstudiante = $("#txtEstudiante").val( );
    var txtObservacionIncentivo = $("#txtObservacion").val( );
    var txtNumeroIncentivo = $("#txtNumeroActaIncentivo").val( );
    var txtFechaActaIncentivo = $("#txtFechaActaIncentivo").val( );
    var txtCodigoCarrera = $("#txtCarrera").val( );

    var datos = "txtCodigoIncentivos=" + txtCodigoIncentivos + "&txtObservacionIncentivo=" + txtObservacionIncentivo + "&txtNumeroIncentivo=" + txtNumeroIncentivo + "&txtFechaActaIncentivo=" + txtFechaActaIncentivo;
    var camposVacios = validarFormulario(datos);
    if (camposVacios == "") {
        $.ajax({
            url: "../servicio/actaAcuerdo.php",
            type: "POST",
            data: {tipoOperacion: tipoOperacion, txtCodigoIncentivos: txtCodigoIncentivos, txtCodigoEstudiante: txtCodigoEstudiante, txtObservacionIncentivo: txtObservacionIncentivo, txtNumeroIncentivo: txtNumeroIncentivo, txtFechaActaIncentivo: txtFechaActaIncentivo, txtCodigoCarrera: txtCodigoCarrera},
            success: function (data) {
                $.each(data, function (index, value) {
                    //alert( value );
                    if (value != 1) {
                        alert("Incentivo Guardado Correctamente");
                        $("#formRegistrarIncentivo").reset( );
                        $("#dvRegistrarActaAcuerdo").css("display", "block");
                        $("#dvRegistrarIncentivo").css("display", "none");

                        /**
                         *@Modified Diego Rivera <riveradiego>
                         *Se  añade evento trigger("click") una vez se guarda el incentivo lo visualize automaticamente en pantalla
                         *@SInce february 21,2017 
                         */
                        $("#btnRActa").trigger("click");
                    } else {
                        alert("Ya existe un registro del incentivo seleccionado");
                        $("#formRegistrarIncentivo").reset( );
                        $("#dvRegistrarActaAcuerdo").css("display", "block");
                        $("#dvRegistrarIncentivo").css("display", "none");
                    }
                });
              
            }
        });
    } else {
        crearMensaje(camposVacios);
    }
    
});

/*
 *modified Diego RIvera <riveradiego@unbosque.edu.co>
 *se añaden atributos a  de dialog  actualizarIncentivo , mensageAnularIncentivo
 *se crea funcion  incentivos carga informacion de incentivo seleccionado  para actualizar
 *se crea funcion anularIncentivo para anular incentivo 
 */

$("#actualizarIncentivo").dialog({
    autoOpen: false,
    modal: true,
    resizable: false,
    title: "Actualizar incentivo",
    width: 800,
    height: 'auto',
    show: {
        effect: "blind",
        duration: 500
    },
    hide: {
        effect: "explode",
        duration: 500
    },
    buttons: {
        "Cerrar": function ( ) {
            $(this).dialog("close");
        }
    }
});

var dates = $("#txtFechaActaIncentivoActualizar").datepicker({
    defaultDate: "0w",
    changeMonth: true,
    numberOfMonths: 2,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    onSelect: function (selectedDate) {
        var option = this.id == "fechaActa" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
    }
}, $.datepicker.regional["es"]);



function incentivos(carrera, estudiante, incentivo, tipoOperacion, nombre) {

    $.ajax({
        url: "../interfaz/incentivos.php",
        type: "POST",
        data: {tipoOperacion: tipoOperacion, carrera: carrera, estudiante: estudiante, incentivo: incentivo, nombre: nombre},
        success: function (data) {

            if (tipoOperacion == 'actualizarIncentivo') {

                $("#actualizarIncentivo").html(data);
                $("#actualizarIncentivo").dialog("open");

            } else {


            }
        }

    })

}

$("#btnIncentivoActualizar").button( ).on("click", function () {
    var datos = $("#formActualizarIncentivo").serialize( );
    var camposVacios = validarFormulario(datos);
    if (camposVacios == "") {

        $.ajax({
            url: "../servicio/incentivoAcademico.php",
            type: "POST",
            data: datos,
            success: function (data) {

                if (data.length > 2) {

                    alert("Ha ocurrido un error al actualizar");

                } else {
                    alert("Incentivo actualizado");
                    $("#actualizarIncentivo").dialog("close");
                    $("#btnRActa").trigger("click");

                }
            }

        });

    } else {
        crearMensaje(camposVacios);
    }
})

$("#mensageAnularIncentivo").dialog({
    autoOpen: false,
    show: "blind",
    modal: true,
    resizable: false,
    title: "Anular Incentivo",
    width: 250,
    height: 150,
    hide: "explode"
});


function anularIncentivo(carrera, estudiante, incentivo, tipoOperacion, nombre, operacion) {
    tipoOperacion = 'eliminar';
    $("#mensageAnularIncentivo").dialog("option", "buttons", {
        "Sí": function () {

            $.ajax({
                url: "../servicio/incentivoAcademico.php",
                type: "POST",
                data: {accion: tipoOperacion, carrera: carrera, estudiante: estudiante, incentivo: incentivo, nombre: nombre},
                success: function (data) {

                    if (data.length > 2) {
                        alert("Ha ocurrido un error al eliminar ");
                    } else {
                        alert("Incentivo Eliminado");
                        $("#mensageAnularIncentivo").dialog("close");

                        if (operacion == 'imprimirIncentivos') {

                            $("#btnImprimirGrado").trigger("click");
                        } else {

                            $("#btnRActa").trigger("click");
                        }
                    }
                }

            });
        },
        "No": function () {
            $("#mensageAnularIncentivo").dialog("close");
        }
    });
    $("#mensageAnularIncentivo").dialog("open");

}

function capturarEstudiante(txtCodigoEstudiante, txtNombreEstudiante) {
    $("#txtEstudiante").val(txtCodigoEstudiante);
    $("#dvRegistrarActaAcuerdo").css("display", "none");
    $("#dvRegistrarIncentivo").css("display", "block");
    $("#txtNombreEstudiante").text(txtNombreEstudiante);
}

function capturarEstudianteIncentivo(txtCodigoEstudiante, txtNombreEstudiante) {
    $("#txtEstudiante").val(txtCodigoEstudiante);
    $("#txtNombreEstudiante").text(txtNombreEstudiante);
    $("#dvRegistrarIncentivoNuevo").dialog("open");

}

$("#btnRegistrarIncentivoNuevo").button( ).on("click", function ( e ) {
    e.stopImmediatePropagation();
    var tipoOperacion = "registrarIncentivo";
    var txtCodigoIncentivos = $("#ckIncentivo:checked").serialize( );
    var txtCodigoEstudiante = $("#txtEstudiante").val( );
    var txtObservacionIncentivo = $("#txtObservacion").val( );
    var txtNumeroIncentivo = $("#txtNumeroActaIncentivo").val( );
    var txtFechaActaIncentivo = $("#txtFechaActaIncentivo").val( );
    var txtCodigoCarrera = $("#txtCarrera").val( );

    var datos = "txtCodigoIncentivos=" + txtCodigoIncentivos + "&txtObservacionIncentivo=" + txtObservacionIncentivo + "&txtNumeroIncentivo=" + txtNumeroIncentivo + "&txtFechaActaIncentivo=" + txtFechaActaIncentivo;
    var camposVacios = validarFormulario(datos);
    if (camposVacios == "") {
        $.ajax({
            url: "../servicio/actaAcuerdo.php",
            type: "POST",
            data: {tipoOperacion: tipoOperacion, txtCodigoIncentivos: txtCodigoIncentivos, txtCodigoEstudiante: txtCodigoEstudiante, txtObservacionIncentivo: txtObservacionIncentivo, txtNumeroIncentivo: txtNumeroIncentivo, txtFechaActaIncentivo: txtFechaActaIncentivo, txtCodigoCarrera: txtCodigoCarrera},
            success: function (data) {
                $.each(data, function (index, value) {
                    if (value != 1) {
                        alert("Incentivo Guardado Correctamente");
                        $("#formRegistrarIncentivoNuevo").reset( );
                        $("#dvRegistrarIncentivoNuevo").css("display", "none");
                        $("#dvRegistrarIncentivoNuevo").dialog("close");
                        $("#btnImprimirGrado").trigger("click");
                        
                    } else {
                        alert("Ya existe un registro del incentivo seleccionado");
                        $("#formRegistrarIncentivoNuevo").reset( );
                        $("#dvRegistrarIncentivoNuevo").css("display", "none");
                      
                    }
                });
           
            }
        });
    } else {
        crearMensaje(camposVacios);
    }

});