<?php
ini_set('memory_limit', '16384M');
ini_set('max_execution_time', 24000);
date_default_timezone_set("America/Bogota");

require(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);
$usuario = Factory::getSessionVar('usuario');

$itemId = Factory::getSessionVar('itemId');
require_once('../../../../assets/lib/Permisos.php');
if (!Permisos::validarPermisosComponenteUsuario($usuario, $itemId)) {
    header("Location: " . HTTP_ROOT . "/serviciosacademicos/GestionRolesYPermisos/index.php?option=error");
    exit();
}

?>
<head>
    <title>materias pendientes</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">        
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">        
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/select2.min.css">
    <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
    <script type="text/javascript" src="../../../../assets/js/select2.min.js"></script>
</head>
<body>
    <div class="container">        
        <div class="row">
            <div class="col-md-5">
                <label for="periodo">Periodo(*):</label>
                <select id="periodo" name="periodo" class="form-control" onchange="instrumentos(this.value)" style="width:400px;"></select>
            </div>
            <div class="col-xs-4 col-xs-offset-2" >
                <label for="instrumento">Instrumento(*):</label>
                <select id="instrumento" name="instrumento"class="form-control" onchange="programasacademicos(this.value)"></select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="carrera">Programa Académico(*):</label>
                <select id="carrera" name="carrera" class="form-control js-example-basic-single" >
                </select>
            </div>
        </div>     
        <br>
        <div class="row">
            <div class="col-md-3 col-xs-offset-4">
                <input class="btn btn-fill-green-XL" type="button" onclick="consultardatos()" value="consultar">
            </div>
            <div class="col-md-3  text-center" id="exportar" style="display: none">
                <input class="btn btn-fill-green-XL" type="button" onclick="exportarExcel()" value="Exportar a Excel">
            </div>
            <form id="formInforme" style="z-index: -1;" method="post" action="../../../utilidades/imprimirReporteExcel.php">
                <input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
            </form>
        </div>            
        <br>
        <div class="col-xs-4 col-xs-offset-2">
            <div id="procesando" style="display:none">
                <img src="../../../../assets/ejemplos/img/Procesando.gif"><br>
                <p>Procesando, por favor espere...</p>
            </div>
        </div>    
        <br>  
        <div class="table-responsive" id="tabla" style="display: none"> 
            <table  id="dataR" width="80%" class="table table-bordered table-line-ColorBrandDark-headers">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>MATERIAS MATRICULADAS</th>
                        <th>MATERIAS AVALUADAS</th>
                        <th>MATERIAS SIN EVALUAR</th>
                        <th>DOCUMENTO</th>
                        <th>NOMBRE COMPLETO</th>
                        <th>TELEFONO</th>                            
                        <th>CELULAR</th>
                        <th>EMAIL PERSONAL</th>
                        <th>EMAIL INSTITUCIONAL</th>
                        <th>COD CARRERA</th>
                        <th>NOMBRE CARRERA</th>
                    </tr>
                </thead>
                <tbody id="resultado">
                </tbody>
            </table>
        </div>  
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function () {
        periodo();
        instrumentos();
        $('.js-example-basic-single').select2();
    });

    function exportarExcel() {
        $("#datos_a_enviar").val($("<div>").append($("#tabla").eq(0).clone()).html());
        $("#formInforme").submit();
    }

    function consultardatos() {
        var id = $("#instrumento").val();
        var carrera = $('#carrera').val();
        var periodo = $('#periodo').val();

        if (carrera == 0 || periodo == 0 || id == 0) {
            alert("Debe Seleccionar una Carrrera, Periodo y Instrumento...");
        } else {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: 'funcionesReportes.php',
                data: {action: 'consultardatos', id: id, carrera: carrera, periodo: periodo},
                beforeSend: function () {
                    $('#tabla').attr("style", "display:none");
                    $('#exportar').attr("style", "display:none");
                    $('#procesando').attr("style", "display:inline");
                },
                success: function (data) {
                    $('#procesando').attr("style", "display:none");
                    $('#tabla').attr("style", "display:inline");
                    $('#exportar').attr("style", "display:inline");
                    $('#resultado').html(data);
                }

            });
        }
    }

    function programasacademicos() {
        var periodo = $('#periodo').val();
        $.ajax({
            type: 'POST',
            url: 'funcionesReportes.php',
            dataType: "html",
            data: {action: 'Consultaprogramas', periodo: periodo},
            success: function (data) {
                $('#carrera').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }   

    function periodo() {
        $.ajax({
            type: 'POST',
            url: 'funcionesReportes.php',
            dataType: "html",
            data: {action: 'Consultaperiodo'},
            success: function (data) {
                $('#periodo').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }    

    function instrumentos(periodo) {
        var periodo = periodo;
        $.ajax({
            type: 'POST',
            url: 'funcionesReportes.php',
            dataType: "html",
            data: {action: 'Consultainstrumentos', periodo: periodo},
            success: function (data) {
                $('#instrumento').html(data);
            },
            error: function (data, error)
            {
                alert("Error en la consulta de los datos.");
            }
        });
    }    
</script>