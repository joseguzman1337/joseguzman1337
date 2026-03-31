<?php 
error_reporting(E_ALL);

ini_set('memory_limit', '16384M');
ini_set('max_execution_time', 24000);
date_default_timezone_set("America/Bogota");

require_once("../../assets/lib/paginator.class.php");


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

if($_GET){
    $args = explode("&",$_SERVER['QUERY_STRING']);
    foreach($args as $arg){
        $keyval = explode("=",$arg);
        if($keyval[0] != "page" And $keyval[0] != "ipp" And $keyval[0] != "json"){
            $querystring .= "&" . $arg;
        }
    }
}

if($_POST){
    foreach($_POST as $key=>$val){
        if($key != "page" And $key != "ipp" And $key != "json"){
            $querystring .= "&$key=$val";
        }
    }
}

?>
    
<html>
    <head>
        <title>Perdidad de la Calidad</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/general.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css">
		<script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script>
		<script type="text/javascript" src="../../assets/js/bootstrap.js"></script> 
    </head>
    <body>
        <div class="container">
            <center>
                <h2>Reporte de Pérdida de la Calidad de Estudiante Académica</h2>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <h3>Periodo inicial:</h3>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="periodo_inicial" name="periodo_inicial" maxlength="5">
                    </div>
                    <div class="col-md-3">
                        <h3>Periodo final:</h3> 
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="periodo_final" name="periodo_final" maxlength="5">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <input class="btn btn-fill-green-XL" type="button" id="consultar" value="consultar" onclick="consultar()">
                    </div>
                    <div class="col-md-2" id="exportarbtn" style="display:none;" id="exportExcel">
                        <button class="btn btn-fill-green-XL" type="button" id="exportExcel">
                            Exportar a Excel
                        </button>
                        <form id="formInforme" method="post" action="../../assets/lib/ficheroExcel.php" align="center">
                            <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                        </form>
                    </div>
                </div>
                <br/>
                <div id="procesando" style="display:none">
                    <img src="../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                    <p>Procesando, por favor espere...</p>
                </div>
            </center>
            <div class="table-responsive" id="tabla" style="display: none">                
                <table id="dataR" class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="9"> 
                                <center>Pérdida de la Calidad de Estudiante Académica</center>
                            </th>
                        </tr>
                        <tr>
                            <th>Programa Academico</th>
                            <th>Nombre Estudiante</th>
                            <th>Numero documento</th>
                            <th>Semestre</th>
                            <th>Codigo Asignatura</th>
                            <th>Asiganturas perdidas</th>
                            <th>Notas</th>
                            <th> # veces matriculada la materia</th>
                            <th>Periodo academico</th>
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
        $('#procesando').attr("style", "display:inline");
    });
    function consultar()
    {
        var periodo1 = $('#periodo_inicial').val(); 
        var periodo2 = $('#periodo_final').val();
    
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'funciones/funciones.php',
            dataType: "html",
            data:{periodo1:periodo1, periodo2:periodo2, action:"Consultar"},   
            beforeSend: function() {   
                $('#procesando').attr("style", "display:inline");                
            },
            success:function(data){      
                $('#procesando').attr("style", "display:none");
                $('#dataReporte').html(data);
                $('#tabla').attr("style", "display:inline");
                $('#exportarbtn').attr("style", "display:inline");
            },
            error: function(data,error)
            {
                alert("Error en la consulta de los datos.");
            }
        });  
    }//funtion consultar
</script>