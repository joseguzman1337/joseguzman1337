/*
 * Ivan Dario Quintero rios
 * Julio 9 del 2018
 * Ajustes de educacion virtual pregrado y postgrado
 */

$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};

$.datepicker.setDefaults($.datepicker.regional['es']);

$(function() {
    $("#notas").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#carga").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#inicial_pre").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#final_pre").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#inicial_pos").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#final_pos").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#inicial_pre_carrera").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#final_pre_carrera").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#inicial_retiro").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#final_retiro").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#inicial_orden").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#final_orden").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#final_orden_carrera").datepicker({ dateFormat: 'yy-mm-dd' });
});

$(document).ready(function(){
    $('#periodo').change(function (){
        $('#tr_facultad').slideUp();
        $('#tabla_fechas').slideUp();
        $('#button').slideUp();
        $("#notas").val('');
        $("#carga").val('');
        $("#inicial_pre").val('');
        $("#final_pre").val('');
        $("#inicial_pos").val('');
        $("#final_pos").val('');
        $("#inicial_pre_carrera").val('');
        $("#final_pre_carrera").val('');
        $("#inicial_retiro").val('');
        $("#final_retiro").val('');
        $("#inicial_orden").val('');
        $("#final_orden").val('');
        $("#final_orden_carrera").val('');
        $('#tabla_check').html('');
        $('#codigocarrera').val('');
        var modalidad = $('#modalidad').val();
        var periodo = $('#periodo').val();
        $.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'carga_facultad',
                modalidad:modalidad,
                periodo:periodo
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
                if(data.val=='FALSE'){
                    alert(data.descrip);
                    return false;
                }else{					
                    if(modalidad == '200'){
                        $('#facultad').html(data.imp);
                        $('#facultad').attr('disabled', false);
                        $('#tr_facultad').slideDown();
                    }else{
                        $('#tabla_fechas').slideDown();
                        $('#tabla_check').html(data.imp);
                        $('#button').slideDown('style');
                    }
                }
            }   
        });
    });
	
    $('#facultad').change(function(){
        var modalidad = $('#modalidad').val();
        var facultad = $('#facultad').val();
        var periodo = $('#periodo').val();
        $("#notas").val('');
        $("#carga").val('');
        $("#inicial_pre").val('');
        $("#final_pre").val('');
        $("#inicial_pos").val('');
        $("#final_pos").val('');
        $("#inicial_pre_carrera").val('');
        $("#final_pre_carrera").val('');
        $("#inicial_retiro").val('');
        $("#final_retiro").val('');
        $("#inicial_orden").val('');
        $("#final_orden").val('');
        $("#final_orden_carrera").val('');
        $('#tabla_check').html('');
        $('#codigocarrera').val('');
        $.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'cargar_carrera',
                modalidad:modalidad,
                facultad:facultad,
                periodo:periodo
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
                if(data.val=='FALSE'){
                    alert(data.descrip);
                    return false;
                }else{
                    $('#button').slideDown();
                    $('#tabla_fechas').removeAttr('style');
                    $('#tabla_check').html(data.imp);
                }
            }
        });
    });
	
    $('#modalidad').change(function(){
        var modalidad = $('#modalidad').val();
        $('#periodo').val(0);
        $('#button').slideUp();
        $('#tabla_fechas').slideUp();
        $('#tr_facultad').slideUp();
        $('#tabla_check').html('');
        $('#codigocarrera').val('');
        $.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'cargar_periodo',
                modalidad:modalidad
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
                if(data.val=='FALSE'){
                    alert(data.descrip);
                    return false;
                }else{                    
                    $("#periodo").html(data.periodo);
                }
            }
        });
    });
	
    $('#limpiar').click(function(){
        $("#notas").val('');
        $("#carga").val('');
        $("#inicial_pre").val('');
        $("#final_pre").val('');
        $("#inicial_pos").val('');
        $("#final_pos").val('');
        $("#inicial_pre_carrera").val('');
        $("#final_pre_carrera").val('');
        $("#inicial_retiro").val('');
        $("#final_retiro").val('');
        $("#inicial_orden").val('');
        $("#final_orden").val('');
        $("#final_orden_carrera").val('');
        $('#codigocarrera').val('');
    });
});

function carga_fechas(codigocarrera){
    var periodo = $('#periodo').val();
    $('#codigocarrera').val(codigocarrera);
    $.ajax({
        type: 'POST',
        url: 'peticiones_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'cargar_anteriores',
            codigocarrera:codigocarrera,
            periodo:periodo			
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }else{
                $("#notas").val(data.notas);
                $("#carga").val(data.carga);
                $("#inicial_pre").val(data.inicial_pre);
                $("#final_pre").val(data.final_pre);
                $("#inicial_pos").val(data.inicial_pos);
                $("#final_pos").val(data.final_pos);
                $("#inicial_pre_carrera").val(data.inicial_pre_carrera);
                $("#final_pre_carrera").val(data.final_pre_carrera);
                $("#inicial_retiro").val(data.inicial_retiro);
                $("#final_retiro").val(data.final_retiro);
                $("#inicial_orden").val(data.inicial_orden);
                $("#final_orden").val(data.final_orden);
                $("#final_orden_carrera").val(data.final_orden_carrera);
                $("#codigocarrera_oculto").val(codigocarrera);
            }
        }
    });
}