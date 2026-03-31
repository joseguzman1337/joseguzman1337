/**
 * @author Carlos
 */


$("#mensageFechaGrado").dialog({
    autoOpen: false,
    show: "blind",
    modal: true,
    resizable: false,
    title: "Inscribir Persona",
    width: 250,
    height: 200,
    hide: "explode"
});

var dates = $("#fechaGraduacion, #fechaMaxCumplimiento").datepicker({

    defaultDate: "0w",
    changeMonth: true,
    numberOfMonths: 2,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    onSelect: function (selectedDate) {
        var option = this.id == "fechaMaxCumplimiento" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
    }
}, $.datepicker.regional["es"]);


/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
 *Se añade opcion al cambio de los select para ocultar boton actualizar , esto con el fin de evitar actualizar datos erroneamente debido a que las 
 fechas se cargan al dal click en el boton consultar 
 *Since August 24 , 2017
 */

$("#cmbFacultad , #cmbCarrera , #cmbPeriodo , .gradoTipo ").change(function ( ) {
    $("#btnActualizarFGrado").button( ).hide();
})

//fin

$("#btnBuscarRFGrado").button( ).click(function ( ) {
    $("#btnBuscarRFGrado").button({label: "Buscando <img width='16' height='16' src='../css/images/cargando.gif' />"});
    $("#btnBuscarRFGrado").button("option", "disabled", true);
    $("#btnBuscarRFGrado").off('click');

    /*Modified Diego Rivera
     *se asignan valores a variables , eston para validar si todos los campos estas seleccionado o tienen un valor para mostrar el boton de actualizar
     *Since August 23,2017
     */
    var tipoOperacion = "consultarFechaGrado";
    var facultad = $("#cmbFacultad").val( );
    var programa = $("#cmbCarrera").val( );
    var fechaMaxima = $("#fechaMaxCumplimiento").val( );
    var fechaGrado = $("#fechaGraduacion").val( );
    var periodo = $("#cmbPeriodo").val( );
    var tipoGrados = $(".gradoTipo").val();

    $.ajax({
        url: "../servicio/fechaGrado.php",
        type: "POST",
        data: $("#formFechaGrado").serialize( ) + "&tipoOperacion=" + tipoOperacion,
        success: function (data) {
            data = trim(data);
            $("#TablaFechaGrado").html(data);
            $("#btnBuscarRFGrado").button({label: "Consultar"});
            $("#btnBuscarRFGrado").button("option", "disabled", false);

            if (facultad != -1 && programa != -1 && fechaMaxima != "" && fechaGrado != "" && periodo != -1 && tipoGrados != -1) {
                $("#btnActualizarFGrado").button( ).show();
                $("#actualizarFechaMaxCumplimiento").val(fechaMaxima);
                $("#actualizarFechaGraduacion").val(fechaGrado);
            }
        }
    });
});


$("#btnRestaurarRFGrado").button( ).click(function ( ) {
    $("#formFechaGrado").reset( );
    $("#btnActualizarFGrado").button( ).hide();
});


$(".editar").button( ).click(function ( ) {
   
    var id = $(this).attr('attr-id');
    var fechaGrado=$(this).attr('attr-fechagrado');
    var fechaCumplimiento=$(this).attr('attr-fechacumplimiento');
    var facultad = $(this).attr('attr-facultad');
    var periodo = $(this).attr('attr-periodo');
    var carrera = $(this).attr('attr-carrera');
    var tipo = $(this).attr('attr-tipo');    
    var itemCarrera = $('#cmbCarrera > option').length; 
    
    if(itemCarrera == 1 || itemCarrera == 3){
       	var tipoOperacion = 'listaCarreras';
        $.ajax({
                url: "../servicio/carrera.php",
                type: "POST",
                data: { tipoOperacion : tipoOperacion , cmbFacultad : facultad },
                success: function( data ){
                        $( "#cmbCarrera").html( data );
                        $("#cmbCarrera option[value='"+ carrera +"']").attr("selected",true); 
                }
        });
    }
    
    $("#fechaMaxCumplimiento").val(fechaCumplimiento);
    $("#fechaGraduacion").val(fechaGrado);
    $("#idfechaGrado").val(id);    
    $("#btnActualizarFGrado").button( ).show();
    $("#cmbFacultad option[value='"+ facultad +"']").attr("selected",true);    
    $("#cmbPeriodo option[value='"+ periodo +"']").attr("selected",true);    
    $("#cmbCarrera option[value='"+ carrera +"']").attr("selected",true);    
    $("#cmbTipoGrado option[value='"+ tipo +"']").attr("selected",true);    
});


$("#btnRegistrarFGrado").button( ).click(function ( ) {
    $("#btnActualizarFGrado").button( ).hide();
    $("#btnRegistrarFGrado").button({label: "Registrando <img width='16' height='16' src='../css/images/cargando.gif' />"});
    $("#btnRegistrarFGrado").button("option", "disabled", true);
    var tipoOperacion = "crearFechaGrado";
    $("#mensageFechaGrado").dialog("option", "buttons", {
        "Sí": function () {
            $.ajax({
                url: "../servicio/fechaGrado.php",
                type: "POST",
                data: $("#formFechaGrado").serialize( ) + "&tipoOperacion=" + tipoOperacion,
                success: function (data) {
                    if (data != "") {
                        if (data == 0) {
                            alert("Registro Guardado Correctamente");
                            $("#mensageFechaGrado").dialog("close");
                            $("#btnRegistrarFGrado").button({label: "Registrar"});
                            $("#btnRegistrarFGrado").button("option", "disabled", false);
                            $("#formFechaGrado").reset( );
                        } else {
                            if (data >= 1) {
                                alert("Ya existe un registro de grado");
                                $("#mensageFechaGrado").dialog("close");
                                $("#btnRegistrarFGrado").button({label: "Registrar"});
                                $("#btnRegistrarFGrado").button("option", "disabled", false);
                            } else {
                                validar(data);
                                $("#mensageFechaGrado").dialog("close");
                                $("#btnRegistrarFGrado").button({label: "Registrar"});
                                $("#btnRegistrarFGrado").button("option", "disabled", false);
                            }
                        }
                    }
                }
            });
        },
        "No": function () {
            $("#mensageFechaGrado").dialog("close");
            $("#btnRegistrarFGrado").button({label: "Registrar"});
            $("#btnRegistrarFGrado").button("option", "disabled", false);
            $("#formFechaGrado").reset( );
        }
    });
    $("#mensageFechaGrado").dialog("open");
    /*}else{
     crearMensaje( camposVacios );
     }*/
});

$("#fechasGrados").dataTable({
    "bJQueryUI": true,
    "sPaginationType": "full_numbers",
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


/*Modified Diego RIvera<riveradiego@unbosque.edu.co>
 *Se añade dom btnActualizarFGrado para realizar acutalizacion de fechas de grado
 *Since August 23,2017
 */


$("#btnActualizarFGrado").button( ).hide();

$("#btnActualizarFGrado").button( ).click(function ( ) {
  
    var tipoOperacion = "actualizarFechaGrado";

    $("#mensageFechaGrado").dialog("option", "buttons", {
        "Sí": function () {
            $.ajax({
                url: "../servicio/fechaGrado.php",
                type: "POST",
                data: $("#formFechaGrado").serialize( ) + "&tipoOperacion=" + tipoOperacion,
                success: function (data) {
                    if (data != "") {
                        if (data == 0) {
                            alert("Fecha de grado actualizado");
                            $("#mensageFechaGrado").dialog("close");
                            $("#btnRegistrarFGrado").button({label: "Registrar"});
                            $("#btnRegistrarFGrado").button("option", "disabled", false);
                            $("#btnActualizarFGrado").button( ).hide();
                            

                            var tipoOperacion = "consultarFechaGrado";

                            $.ajax({
                                url: "../servicio/fechaGrado.php",
                                type: "POST",
                                data: $("#formFechaGrado").serialize( ) + "&tipoOperacion=" + tipoOperacion,
                                success: function (data) {
                                    data = trim(data);
                                    $("#TablaFechaGrado").html(data);
                                    $("#btnBuscarRFGrado").button({label: "Consultar"});
                                    $("#btnBuscarRFGrado").button("option", "disabled", false);

                                    if (facultad != -1 && programa != -1 && fechaMaxima != "" && fechaGrado != "" && periodo != -1 && tipoGrados != -1) {

                                        $("#btnActualizarFGrado").button( ).show();
                                        $("#actualizarFechaMaxCumplimiento").val(fechaMaxima);
                                        $("#actualizarFechaGraduacion").val(fechaGrado);
                                    }
                                }
                            });

                            $("#formFechaGrado").reset( );

                        } else {
                            if (data >= 1) {
                                alert("Ya existe un registro de grado para la fecha seleccionada");
                                $("#mensageFechaGrado").dialog("close");
                                $("#btnRegistrarFGrado").button({label: "Registrar"});
                                $("#btnRegistrarFGrado").button("option", "disabled", false);
                            } else {
                                validar(data);
                                $("#mensageFechaGrado").dialog("close");
                                $("#btnRegistrarFGrado").button({label: "Registrar"});
                                $("#btnRegistrarFGrado").button("option", "disabled", false);
                            }
                        }
                    }
                }
            });
        },
        "No": function () {
            $("#mensageFechaGrado").dialog("close");
            $("#btnRegistrarFGrado").button({label: "Registrar"});
            $("#btnRegistrarFGrado").button("option", "disabled", false);
            $("#btnActualizarFGrado").button( ).hide();
            $("#formFechaGrado").reset( );
        }
    });
    $("#mensageFechaGrado").dialog("open");

});

//fin modificacion