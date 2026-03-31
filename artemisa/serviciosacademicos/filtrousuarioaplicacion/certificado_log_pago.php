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
        <title>Certificado Log Pagos</title>
        <link rel="stylesheet" type="text/css" href="../mgi/css/styleOrdenes.css" media="screen" />
		<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
        <style>
            h2{font-family: Arial; font-size: 22px; color: #AFAFAE;}
        </style>
    </head>
    <body>
    <div align="center" style="padding-top: 200px;">
            <h2>Consultar nueva orden</h2>
            <form id="f1" name="f1" action="listacertificadopago.php" method="post">
                <label>N&uacute;mero de Orden:</label>
                <input type="text" class="required number textbox" value="" name="ordenpago"/>
                
                <button type="button" class="myButton" onclick="$('#f1').submit();">Consultar</button>
                <img src="../educacionContinuada/images/ajax-loader2.gif" style="display:none;clear:both;margin-bottom:15px;margin-left: 16.4%;" id="loading"/>
            </form>
        </div>
    </body>
</html>