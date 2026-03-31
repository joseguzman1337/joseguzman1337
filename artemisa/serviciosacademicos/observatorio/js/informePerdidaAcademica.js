/**
 * Caso Interno 307.
 * @created Luis Dario Gualteros Castro <castroluisd@unbosque.edu.co>.
 * Creación funciones para el REPORTE CONSOLIDADO PÉRDIDA ACADÉMICA
 * @since 23 de Abril 2019.
 */

$(document).ready(function(){
    periodos();
    modalidadacademica();
    //Inicia complemento select2 para mejora visual de selects
    $('#tiporeporte').select2();
    $('#periodo').select2({
        width: '60%'
    });
    $('#modalidad').select2({
        width: '100%'
    });
    $('#carrera').select2({
        width: '100%',
        dropdownAutoWidth : true
    });
});


function periodos(){
    $.ajax({
        type: "POST" ,
        url: "funciones/funciones.php",
        datatype: "html",
        data: {action:'consulta_periodos'},
        success:function(data){
            $('#periodo').html(data);
            $('#periodoinicial').html(data);
            $('#periodofinal').html(data);
        }
    });
}// End function periodos

function modalidadacademica(){
    $.ajax({
        type: "POST" ,
        url: "funciones/funciones.php",
        datatype: "html",
        data: {action:'consulta_modalidad'},
        success:function(data){
            $('#modalidad').html(data);
        }
    });
}//End function modalidadacademica

function programasacademicos(){
    var modalidad = $('#modalidad').val();
    var periodo = $('#periodo').val();
    $.ajax({
        type: "POST" ,
        url: "funciones/funciones.php",
        datatype: "html",
        data: {
            action: 'consulta_programasacademicos',
            modalidad: modalidad,
            periodo: periodo
        },
        success:function(data){
            $('#carrera').html(data);
        }
    });
}//End  function programasacademicos

function reportes(){
    var tiporeporte = $('#tiporeporte').val();
    if(tiporeporte === '1'){
        $('#titulo2').hide();
        $('#titulo3').hide();
        $('#linea3').hide();
        $('#linea5').hide();
        $('#linea6').hide();

        $('#titulo1').show();
        $('#linea1').show();
        $('#linea2').show();
        $('#linea21').show();
        $('#linea4').show();
    }else{
        if(tiporeporte === '2'){
            $('#titulo1').hide();
            $('#titulo3').hide();
            $('#linea1').hide();
            $('#linea2').hide();
            $('#linea21').hide();
            $('#linea6').hide();

            $('#titulo2').show();
            $('#linea3').show();
            $('#linea4').hide();
            $('#linea5').show();
        }else{
            if(tiporeporte === '3'){
                $('#titulo2').hide();
                $('#titulo1').hide();
                $('#linea3').hide();
                $('#linea4').hide();
                $('#linea5').hide();

                $('#titulo3').show();
                $('#linea1').show();
                $('#linea2').show();
                $('#linea21').show();
                $('#linea6').show();
            }
        }
    }
}//function reportes

function consultardatosdocentes(){
    var periodo = $('#periodo').val();
    var modalidad = $('#modalidad').val();
    var carrera = $('#carrera').val();

    $.ajax({
        type: 'POST',
        url: 'funciones/funciones.php',
        dataType: "html",
        data:{periodo1:periodo, carrera:carrera, modalidad:modalidad, action:"consultardatosdocentes"},
        beforeSend: function() {
            $('#procesando').attr("style", "display:inline");
            $('#tabla3').attr("style", "display:none");
        },
        success:function(data){
            $('#procesando').attr("style", "display:none");
            $('#tabla1').attr("style", "display:none");
            $('#exportarbtn1').attr("style", "display:none");
            $('#dataReporte3').html(data);
            $('#tabla3').attr("style", "display:inline");
            $('#exportarbtn3').attr("style", "display:inline");
        },
        error: function(data,error)
        {
            alert("Error en la consulta de los datos.");
        }
    });
}// function consultardatosdocentes


function consultarvalores(){
    var periodoinicial = $('#periodoinicial').val();
    var periodofinal = $('#periodofinal').val();

    $.ajax({
        type: 'POST',
        url: 'funciones/funciones.php',
        dataType: "html",
        data:{periodo1:periodoinicial, periodo2:periodofinal, action:"Consultarvalores"},
        beforeSend: function() {
            $('#procesando').attr("style", "display:inline");
            $('#tabla2').attr("style", "display:none");
        },
        success:function(data){
            $('#procesando').attr("style", "display:none");
            $('#tabla1').attr("style", "display:none");
            $('#exportarbtn1').attr("style", "display:none");
            $('#dataReporte2').html(data);
            $('#tabla2').attr("style", "display:inline");
            $('#exportarbtn2').attr("style", "display:inline");
        },
        error: function(data,error)
        {
            alert("Error en la consulta de los datos.");
        }
    });
}// function consultarvalores

function consultar(){
    var periodo = $('#periodo').val();
    var modalidad = $('#modalidad').val();
    var carrera = $('#carrera').val();
    var nombrecarrera = $("#carrera option:selected").text();
    if(periodo){
        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            dataType: "html",
            data:{periodo1:periodo, modalidad:modalidad, carrera:carrera, nombrecarrera:nombrecarrera, action:"ConsultarPerdidaCorte"},
            beforeSend: function() {
                $('#procesando').attr("style", "display:inline");
                $('#tabla1').attr("style", "display:none");
            },
            success:function(data){
                $('#procesando').attr("style", "display:none");
                $('#dataReporte1').html(data);
                $('#tabla1').attr("style", "display:inline");
                $('#exportarbtn1').attr("style", "display:inline");

            },
            error:function(jqXHR, textStatus, errorThrown)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }else{
        alert("Debe seleccionar el periodo a consultar.");
    }
}//funtion consultar

function totalMatriculados(id,valor,periodo,materia){
    var idgrupo = id;
    var carrera = valor;

    $.ajax({
        type: 'POST',
        url: 'funciones/funciones.php',
        dataType: "html",
        data: {action: "ConsultarMatriculados", idgrupo: idgrupo, carrera:carrera,periodo:periodo,materia:materia },
        beforeSend: function () {
        },
        success: function (data) {
            bootbox.dialog({
                title : "Estudiantes Matriculados",
                message : data,
                size: "large",
                buttons : {
                    cancel: {
                        label: "Cerrar",
                        className: 'btn-danger',
                        callback: function( ){
                        }
                    }
                }
            });
        },
        error: function (data, error){
            alert("Error en la consulta de los datos.");
        }
    });

}//End function totalMatriculados

function perdieronCorte(id,valor,car){
    var idgrupo = id;
    var corte = valor;
    var carrera = car;
    var periodo = $('#periodo').val();


    $.ajax({
        type: 'POST',
        url: 'funciones/funciones.php',
        dataType: "html",
        data: {action: "ConsultaPerdida",
            idgrupo: idgrupo,
            corte:corte,
            carrera:carrera,
            periodo: periodo,
        },
        beforeSend: function () {
        },
        success: function (data) {
            bootbox.dialog({
                title : "Estudiantes",
                message : data,
                size: "large",
                buttons : {
                    cancel: {
                        label: "Cerrar",
                        className: 'btn-danger',
                        callback: function( ){
                        }
                    }
                }
            });
        },
        error: function (data, error){
            alert("Error en la consulta de los datos.");
        }
    });
}//End function perdieronCorte

function retiraronMateria(periodo,grupo,materia,carrera, contador){

    var Periodo = periodo;
    var Grupo = grupo;
    var Materia = materia;
    var Carrera = carrera;
    var Contador = contador;

    $.ajax({
        type: 'POST',
        url: 'funciones/funciones.php',
        dataType: "html",
        data: {action: "MateriasRetiradas", Periodo: Periodo, Grupo:Grupo, Materia:Materia, Carrera:Carrera, Contador:Contador },
        beforeSend: function () {
        },
        success: function (data) {
            bootbox.dialog({
                title : "Estudiantes Materia Cancelada",
                message : data,
                size: "large",
                buttons : {
                    cancel: {
                        label: "Cerrar",
                        className: 'btn-danger',
                        callback: function( ){
                        }
                    }
                }
            });
        },
        error: function (data, error){
            alert("Error en la consulta de los datos.");
        }
    });
}//End function perdieronCorte