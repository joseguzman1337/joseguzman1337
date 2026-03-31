<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    require_once('../Connections/sala2.php');
    $rutaado = "../funciones/adodb/";
    require_once('../Connections/salaado.php');
    $rutaJS = "../consulta/sic/librerias/js/";
    $varguardar = 0;
    //session_start();
    //unset ($_SESSION['session_sqr']);
?>
<html>
    <head>
        <title>Reporteador</title>
        <link rel="stylesheet" href="../estilos/sala.css" type="text/css">
        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function (){
                var ipreporteador = "reportes.unbosque.edu.co:8080";
                var reportUnit = "<?php echo $_REQUEST['reportUnit'];?>";
                var usuario = "sala";
                var clave = "sala";
                var ruta = "http://" + ipreporteador + "/jasperserver/flow.html?_flowId=viewReportFlow&reportUnit=" + reportUnit + "&j_username=" + usuario + "&j_password=" + clave + "&decorate=no";
                //alert(reportUnit);
                $("#reporteador").attr("src", ruta);
            })

        </script>
    </head>
    <body>
        <iframe src="" id="reporteador" height="100%" width="100%" frameborder="0">

        </iframe>
    </body>
</html>
