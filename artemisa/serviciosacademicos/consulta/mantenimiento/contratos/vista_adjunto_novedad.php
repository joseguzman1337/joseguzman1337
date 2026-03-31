<?php
 session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
require_once('adjunto_novedad.php');
$rutaJS = "../../sic/librerias/js/";
$rutaEstilos = "../../sic/estilos/";

//print_r($_REQUEST);
$idnovedadescontrato = $_REQUEST['idnovedadescontrato'];
$adjunto_novedad = new adjunto_novedad();
if(isset($_REQUEST['enviar'])) {
//$db->debug = true;
    $adjunto_novedad->adjuntarArchivoUnico("novedadescontrato");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Subir archivos</title>
        <link rel="stylesheet" href="<?php echo $rutaEstilos; ?>sic_normal.css" />
        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>

        <link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.css" />
        <script src="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        if(!isset($_REQUEST['enviar'])) {
            ?>
        <form action="" method="post" enctype="multipart/form-data">
            <br>
            <div id="div1"></div>
            <div style="width: auto;">
                Por favor seleccione el archivo a subir:<br>
                <b>El archivo debe tener extensión (pdf, doc) </b>
                <br><br>
                <input name="archivo" type="file">
                <br><br>
                <input id="enviar" name="enviar" type="submit" value="Cargar Archivo">
            </div>
        </form>
        <?php
        }
        ?>
    </body>
    <script type="text/javascript">
        $(function() {
            var p = parent;
            var idnovedadescontrato = p.$("#idnovedadescontrato").attr("value");
            //var hidden = '<input type="hidden" name="idcontrato" value="' + idcontrato +'"/>';

            //alert(idcontrato + hidden);
<?php
if($adjunto_novedad->error != 1 && isset($_REQUEST['enviar'])) {
    ?>
            alert("Se ha adjuntado el archivo satisfactoriamente");
            p.window.location.reload();
            p.$(".window-container").fadeOut();
<?php
}
?>
            $("#div1").after('<input type="hidden" name="idnovedadescontrato" value="' + idnovedadescontrato +'"/>');
    })
<?php
if($adjunto_novedad->error == 1 && isset($_REQUEST['enviar'])) {
    ?>
    alert('<?php echo $adjunto_novedad->estatus;?>');
<?php
}
?>
    </script>
</html>