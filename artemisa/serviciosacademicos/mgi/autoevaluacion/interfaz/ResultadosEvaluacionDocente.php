<?php
/*
 * Reporte de resultados evaluacion docente (pregrado)
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Creado 14 de Agosto de 2017.
 */  
/*
 * Modificacion logica para generacion de reporte
 * debido a que segun la materia es una encuesta diferente (caso  95693)
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 1 de Diciembre de 2017.
 */  
session_start();
include_once('../../../../serviciosacademicos/utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION); 
    
error_reporting(E_ALL);

ini_set('memory_limit', '16384M');
ini_set('max_execution_time', 24000);
date_default_timezone_set("America/Bogota");


?>

<html>
    <head>
        <title>Resultados Evaluacion Docente</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
        <style>
            .textop{
                font-size:12px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <center>
                <h2>Informe de Resultados Evaluacion Docente</h2>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <h3>Periodo(*):</h3>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <select id="periodo" name="periodo"  class="form-control">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <h3>Programa Academico(*):</h3> 
                    </div>
                    <div class="col-md-2">
                        <br>
                        <select id="programa_academico" name="programa_academico" class="form-control" onchange="materia(this.value);">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h3>Materia(*):</h3>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <select id="codigomateria" name="codigomateria"  class="form-control" onchange="docente(this.value);">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <h3>Docente:</h3> 
                    </div>
                    <div class="col-md-2">
                        <br>
                        <select id="numerodocumento" name="numerodocumento" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <input class="btn btn-fill-green-XL" type="button" id="consultar" value="Consulta Detallada" onclick="consultar_encabezado();">
                    </div>
                    <div class="col-md-2">
                        <input class="btn btn-fill-green-XL" type="button" id="consultarnob" value="Consulta Resultados" onclick="consultarencabezadonob()">
                    </div>
                    <div class="col-md-2" id="exportarbtn" style="display:none;">
                        <button class="btn btn-fill-green-XL" type="button" id="exportExcel">
                            Exportar a Excel
                        </button>
                        <form id="formInforme" method="post" action="../../../../assets/lib/ficheroExcel.php" align="center">
                            <input  id="flag" type="hidden" name="flag" value="">
                            <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                        </form>
                    </div>
                </div>
                <br/>
                <div id="procesando" style="display:none">
                    <img src="../../../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                    <p>Procesando, por favor espere...</p>
                </div>
            </center>
            <div class="table-responsive " id="tabla" style="display: none">                
                <table id="dataR" class="table table-bordered table-line-ColorBrandDark-headers">
                    <thead id="encabezados">
                    </thead>                    
                    <tbody id="dataReporte">
                    </tbody>                     
                </table>      
            </div>    
            <div class="table-responsive " id="tablanob" style="display: none">                    
                <table id="dataRnob" class="table table-bordered table-line-ColorBrandDark-headers">
                    <thead id="encabezadosnob">
                    </thead>                    
                    <tbody id="dataReportenob">
                    </tbody>                     
                </table>      
            </div>
        </div>
    </body>
</html>
<script>
    $('#exportExcel').click(function (e)
    {
        var flag = $('#flag').val();
        if (flag == 0) {
            $("#datos_a_enviar").val($("<div>").append($("#dataR").eq(0).clone()).html());
        } else if (flag == 1) {
            $("#datos_a_enviar").val($("<div>").append($("#dataRnob").eq(0).clone()).html());
        }
        $("#formInforme").submit();
    });
    function consultar_encabezado()
    {
        $('#flag').val(0);
        var periodo = $('#periodo').val();
        var prograacad = $('#programa_academico').val();
        var codigomateria = $('#codigomateria').val();
        var numerodocumento = $('#numerodocumento').val();
        var mvalid = "";
        if (periodo == "") {
            mvalid += "Debe seleccionar el periodo \n";
        }
        if (prograacad == "") {
            mvalid += "Debe seleccionar el Programa academico \n";
        }
        if (codigomateria == "") {
            mvalid += "Debe seleccionar la materia \n";
        }
        if (mvalid == "") {
            $.ajax({
                type: 'POST',
                url: 'funciones/funciones.php',
                dataType: "html",
                data: {periodo: periodo, prograacad: prograacad, codigomateria: codigomateria, numerodocumento: numerodocumento, action: "Consultar_Encabezado"},
                beforeSend: function () {
                    $('#procesando').attr("style", "display:inline");
                },
                success: function (data) {
                    $('#procesando').attr("style", "display:none");
//                    $('#dataReporte').html(data);
                    $('#encabezados').html(data);
                    consultar();
                    $('#tabla').attr("style", "display:inline");
                    $('#tablanob').attr("style", "display:none");
                    $('#exportarbtn').attr("style", "display:inline");
                },
                error: function (data, error)
                {
                    alert("Error en la consulta de los datos.");
                }
            });
        } else {
            alert(mvalid);
        }
    }//funtion consultar_encabezado
    function consultar()
    {
        var periodo = $('#periodo').val();
        var prograacad = $('#programa_academico').val();
        var codigomateria = $('#codigomateria').val();
        var numerodocumento = $('#numerodocumento').val();
            $.ajax({
                type: 'POST',
                url: 'funciones/funciones.php',
                dataType: "html",
                data: {periodo: periodo, prograacad: prograacad, codigomateria: codigomateria, numerodocumento: numerodocumento, action: "Consultar"},
                success: function (data) {
                    $('#procesando').attr("style", "display:none");
                    $('#dataReporte').html(data);
                    $('#tabla').attr("style", "display:inline");
                    $('#tablanob').attr("style", "display:none");
                    $('#exportarbtn').attr("style", "display:inline");
                }
            });
    }//funtion consultar
    
    function consultarencabezadonob() {
        $('#flag').val(1);
        var periodo = $('#periodo').val();
        var prograacad = $('#programa_academico').val();
        var codigomateria = $('#codigomateria').val();
        var numerodocumento = $('#numerodocumento').val();
        var mvalid = "";
        if (periodo == "") {
            mvalid += "Deba seleccionar el periodo \n";
        }
        if (prograacad == "") {
            mvalid += "Deba seleccionar el Programa academico \n";
        }
        if (codigomateria == "") {
            mvalid += "Debe seleccionar la materia \n";
        }
        if (mvalid == "") {
            $.ajax({
                type: 'POST',
                url: 'funciones/funciones.php',
                dataType: "html",
                data: {periodo: periodo, prograacad: prograacad, codigomateria: codigomateria, numerodocumento: numerodocumento, action: "Consultarencabezadonob"},
                beforeSend: function () {
                    $('#procesando').attr("style", "display:inline");
                },
                success: function (data) {
                    $('#procesando').attr("style", "display:none");
                    $('#encabezadosnob').html(data);
                    consultarnob();
                    $('#tabla').attr("style", "display:none");
                    $('#tablanob').attr("style", "display:inline");
                    $('#exportarbtn').attr("style", "display:inline");
                },
                error: function (data, error)
                {
                    alert("Error en la consulta de los datos.");
                }
            });
        } else {
            alert(mvalid);
        }
    }//funtion consultarencabezadonob
    function consultarnob() {
        var periodo = $('#periodo').val();
        var prograacad = $('#programa_academico').val();
        var codigomateria = $('#codigomateria').val();
        var numerodocumento = $('#numerodocumento').val();
            $.ajax({
                type: 'POST',
                url: 'funciones/funciones.php',
                dataType: "html",
                data: {periodo: periodo, prograacad: prograacad, codigomateria: codigomateria, numerodocumento: numerodocumento, action: "Consultarnob"},
                success: function (data) {
                    $('#procesando').attr("style", "display:none");
                    $('#dataReportenob').html(data);
                    $('#tabla').attr("style", "display:none");
                    $('#tablanob').attr("style", "display:inline");
                    $('#exportarbtn').attr("style", "display:inline");
                }
            });
    }//funtion consultarnob
    function periodo()
    {

        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            dataType: "html",
            data: {action: "Periodo"},
            success: function (data) {
                $('#periodo').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }//funtion periodo
    function carrera()
    {

        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            dataType: "html",
            data: {action: "Carrera"},
            success: function (data) {
                $('#programa_academico').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }//funtion carrera
    function materia(prograacad)
    {

        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            dataType: "html",
            data: {prograacad: prograacad, action: "Materia"},
            success: function (data) {
                $('#codigomateria').html(data);
                $('#numerodocumento').val('');
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }//funtion materia
    function docente(codigomateria)
    {

        var periodo = $('#periodo').val();
        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            dataType: "html",
            data: {periodo: periodo, codigomateria: codigomateria, action: "Docente"},
            success: function (data) {
                $('#numerodocumento').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }//funtion docente
    window.onload = periodo();
    carrera();
</script>
<!--end-->
<!--end-->