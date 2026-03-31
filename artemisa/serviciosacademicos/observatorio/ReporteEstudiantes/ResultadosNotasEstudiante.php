<?php
/*
 * Reporte de resultados notas estudiante (pregrado)
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Creado 10 de Octubre de 2017.
 */  
session_start();
include_once('../../../serviciosacademicos/utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION); 
    
error_reporting(E_ALL);

ini_set('memory_limit', '16384M');
ini_set('max_execution_time', 24000);
date_default_timezone_set("America/Bogota");

require_once("../../../assets/lib/paginator.class.php");


//variables del paginador
$size = 15;
$page = $_GET['page'];
//examino la página a mostrar y el inicio del registro a mostrar 
if (!$page) {
    $start = 0;
    $page = 1;
} else {
    $start = ($page) * $size;
}


$varguardar = 0;

if ($_GET) {
    $args = explode("&", $_SERVER['QUERY_STRING']);
    foreach ($args as $arg) {
        $keyval = explode("=", $arg);
        if ($keyval[0] != "page" And $keyval[0] != "ipp" And $keyval[0] != "json") {
            $querystring .= "&" . $arg;
        }
    }
}

if ($_POST) {
    foreach ($_POST as $key => $val) {
        if ($key != "page" And $key != "ipp" And $key != "json") {
            $querystring .= "&$key=$val";
        }
    }
}
?>

<html>
    <head>
        <title>Resultados Notas Estudiante</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../assets/css/chosen.css">
        <script type="text/javascript" src="../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../assets/js/bootstrap.js"></script> 
    </head>
    <body>
        <div class="container">
            <center>
                <h2>Informe de Resultados Notas Estudiante</h2>
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
                        <select id="programa_academico" name="programa_academico" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h3>Recurso Financiero:</h3>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <select id="rec_fin" name="rec_fin"  class="form-control">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <h3>Documento Estudiante:</h3> 
                    </div>
                    <div class="col-md-2">
                        <input id="numerodocumento" type="text" name="numerodocumento" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <input class="btn btn-fill-green-XL" type="button" id="consultar" value="Consulta" onclick="consultar()">
                    </div>
                    <div class="col-md-2" id="exportarbtn" style="display:none;">
                        <button class="btn btn-fill-green-XL" type="button" id="exportExcel">
                            Exportar a Excel
                        </button>
                        <form id="formInforme" method="post" action="../../../assets/lib/ficheroExcel.php" align="center">
                            <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                        </form>
                    </div>
                </div>
                <br/>
                <div id="procesando" style="display:none">
                    <img src="../../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                    <p>Procesando, por favor espere...</p>
                </div>
            </center>
            <div class="table-responsive " id="tabla" style="display: none;">                
                <table id="dataR" class="table table-bordered table-line-ColorBrandDark-headers">
                    <thead>
                        <tr>
                            <th rowspan="3" style="text-align: center">#</th>
                            <th colspan="2" rowspan="2" style="text-align: center">CARRERA</th>
                            <th rowspan="3" style="text-align: center">SEMESTRE</th>
                            <th colspan="6" style="text-align: center">ESTUDIANTE</th>
                            <th rowspan="3" style="text-align: center">RECURSO FINANCIERO</th>
                            <th colspan="4" style="text-align: center">MATERIA</th>  
                            
                            <th colspan="9" style="text-align: center">SEMESTRE</th>
                            <th rowspan="3" style="text-align: center">PERIODO</th>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align: center">DOCUMENTO</th>
                            <th rowspan="2" style="text-align: center">APELLIDOS</th>
                            <th rowspan="2" style="text-align: center">NOMBRES</th>
                            <th rowspan="2" style="text-align: center">E-MAIL</th>
                            <th rowspan="2" style="text-align: center">CELULAR</th>
                            
                            <th colspan="2" style="text-align: center">CARRERA</th>
                            <th rowspan="2" style="text-align: center">CODIGO</th>
                            <th rowspan="2" style="text-align: center">NOMBRE</th>
                            
                            <th colspan="3" style="text-align: center">CORTES</th>
                            <th rowspan="2" style="text-align: center">DEFINITIVA</th>
                            <th colspan="3" style="text-align: center">CANTIDAD MATERIAS</th>
                            <th colspan="2" style="text-align: center">PROMEDIO PONDERADO</th>                            
                        </tr>
                        <tr>
                            <th style="text-align: center">CODIGO</th>
                            <th style="text-align: center">NOMBRE</th>
                            <th style="text-align: center">TIPO</th>
                            <th style="text-align: center">NUMERO</th>
                            <th style="text-align: center">CODIGO</th>
                            <th style="text-align: center">NOMBRE</th>
                            <th style="text-align: center">1</th>
                            <th style="text-align: center">2</th>
                            <th style="text-align: center">3</th>
                            <th style="text-align: center">INSCRITAS</th>
                            <th style="text-align: center">CANCELADAS</th>
                            <th style="text-align: center">PERDIDAS</th>
                            <th style="text-align: center">ACUMULADO</th>                            
                            <th style="text-align: center">SEMESTRAL</th>                            
                        </tr>
                    </thead>                    
                    <tbody id="dataReporte">
                    </tbody>                     
                </table>
            </div> 
        </div>
    </body>
</html>
<script>
    $('#exportExcel').click(function (e)
    {
        $("#datos_a_enviar").val($("<div>").append($("#dataR").eq(0).clone()).html());
        $("#formInforme").submit();
    });
    function consultar()
    {
        var periodo = $('#periodo').val();
        var prograacad = $('#programa_academico').val();
        var numerodocumento = $('#numerodocumento').val();
        var recfin = $('#rec_fin').val();
        var mvalid = "";
        if (periodo == "") {
            mvalid += "Deba seleccionar el periodo \n";
        }
        if (prograacad == "") {
            mvalid += "Deba seleccionar el Programa academico \n";
        }else{
            if (prograacad == "1" && recfin=="") {
                mvalid += "Deba seleccionar el Recurso financiero \n";
            }            
        }        
        if (mvalid == "") {
            $.ajax({
                type: 'POST',
                url: 'funciones/funciones.php',
                dataType: "html",
                data: {periodo: periodo, prograacad: prograacad, numerodocumento: numerodocumento, recfin: recfin, action: "Consultar"},
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
        } else {
            alert(mvalid);
        }
    }//funtion consultar
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
    function recursosf()
    {

        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            dataType: "html",
            data: {action: "Recursosf"},
            success: function (data) {
                $('#rec_fin').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }//funtion carrera
    window.onload = periodo();
    carrera();recursosf();
</script>
<!--end-->

