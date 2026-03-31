<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    require_once($rutaConeccion.'Connections/sala2.php');
    require_once($rutaConeccion.'Connections/salaado.php');
    $varguardar = 0;

    if(!isset($conJquery)) {
?>
<html>
    <head>
        <title>Reporteador</title>
        <link rel="stylesheet" href="<?php echo $rutaConeccion; ?>estilos/sala.css" type="text/css">
        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function (){
                var ipreporteador = "reportes.unbosque.edu.co:8080";
                var reportUnit = "<?php echo $_REQUEST['reportUnit'];?>";
                var usuario = "sala";
                var clave = "sala";
                var ruta = "http://" + ipreporteador + "/jasperserver/flow.ht�ml?_flowId=viewReportFlow&reportUnit=" + reportUnit + "&j_username=" + usuario + "&j_password=" + clave + "&decorate=no";
                //alert(ruta);
                $("#reporteador").attr("src", ruta);
            })

        </script>
    </head>
    <body>
        <iframe src="" id="reporteador" height="100%" width="100%" frameborder="0">

        </iframe>
    </body>
</html>
<?php
}
else {
    $ipreporteador = "reportes.unbosque.edu.co:8080";
    $usuario = "sala";
    $clave = "sala";
    $ruta = "http://$ipreporteador/jasperserver/flow.html?_flowId=viewReportFlow&reportUnit=$reportUnit&j_username=$usuario&j_password=$clave&decorate=no";
    //echo "asdasdassd $ruta";
?>
        <iframe src="<?php echo $ruta; ?>" id="reporteador" height="1000" width="100%" frameborder="0">

        </iframe>
<?php
}
?>