<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    if(!isset ($_SESSION['MM_Username'])){
            //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
            echo "No ha iniciado sesión en el sistema";
            exit();
        }
    $db = getBD();
?>
<html>
<head>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <title>Buscar Pago PSE</title><style type="text/css"></style>
    
    <link rel="stylesheet" href="js/jquery-ui.css">
    <script src="js/jquery-1.13.1.js"></script>
    <script src="js/jquery-ui.js"></script>
    
    
<script>
$(function () {
$("#datepicker").datepicker({
    showOn: "button",
      buttonImage: "js/images/calendar.gif",
      buttonImageOnly: true
});
});
$(function () {
$("#datepicker1").datepicker({
    showOn: "button",
      buttonImage: "js/images/calendar.gif",
      buttonImageOnly: true
});
});
</script>
</head>
<body>
<div align="center">

            <form name="f1" action="reportepagospseexcel.php" method="post">
            <p class="Estilo3">BUSCAR REPORTE PAGOS PSE POR FECHA</p>
	               <p>Fecha Inicial: <input type="text" name="fechaInicial" id="datepicker"></p>
                   <p>Fecha Final: <input type="text" name="fechaFinal" id="datepicker1"></p>
                   <input type="submit" name="Buscar" />
                   
            </form>
</div>
</body>
</html>