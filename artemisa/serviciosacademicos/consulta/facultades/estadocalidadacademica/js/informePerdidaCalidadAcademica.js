/**
  * Caso 986.
  * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.co>.
  * Adición funciones para los nuevos campos: correo Personal, Correo Institucional y Género a la consulta. 
  * Para el reporte: Listado de Estudiantes Bloqueados Académicamente.
  * @since 24 de Abril 2019.
*/
function carreras() {
    $.ajax({
        type: "POST",
        url: "seguridadinformeperdidacalidadacademica.php",
        datatype: "html",
        data: {action: 'consulta_carreras'},
        success: function (data) {
            $('#carrera').html(data);
        }
    });
}//End carreras

function situaciones() {
    $.ajax({
        type: "POST",
        url: "seguridadinformeperdidacalidadacademica.php",
        datatype: "html",
        data: {action: 'consulta_situaciones'},
        success: function (data) {
            $('#situacion').html(data);
        }
    });
}//End situaciones

function consultardatos() {
    var situacion = $('#situacion').val();
    var carrera = $('#carrera').val();
    
        $.ajax({
            type: 'POST',
            url: "seguridadinformeperdidacalidadacademica.php",
            dataType: "html",
            data: {carrera: carrera, situacion: situacion, action: "consultardatos"},
            beforeSend: function () {
                $('#procesando').attr("style", "display:inline");
            },
            success: function (data) {
                $('#procesando').attr("style", "display:none");
                $('#dataReporte').html(data);
                $('#tabla').attr("style", "display:inline");
                $('#exportarbtn').attr("style", "display:inline");
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
}//End consultardatos