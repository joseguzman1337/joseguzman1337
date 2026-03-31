<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Subir archivos</title>
<link rel="stylesheet" href="<?php echo $rutaEstilos; ?>sic_normal.css" />
<script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.css" />
<script src="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.js" type="text/javascript"></script>

<?php
if($nopuedeadjuntar):
?>
<script type="text/javascript">
$(function() {
    var p = parent;
    alert("Ya ha adjuntado el máximo de archivos permitidos el cual es de <?php echo $adjunto->cantidadadjuntospermitidos; ?>");
    p.$(".window-container").fadeOut();
})
</script>
</head>
<body>
</body>
</html>
<?php
    //exit();
else:
    $ruta = explode("sic/",$_SERVER['REQUEST_URI']);
?>
<script type="text/javascript">
$(function() {
    var p = parent;
    var q = p.parent;
    var error = "<?php echo $adjunto->error; ?>";
    var cantidadadjuntados = <?php echo $adjunto->cantidadadjuntados; ?>;
    var iditemsiccarrera = <?php echo $iditemsiccarrera; ?>;
    var iditemsic = <?php echo $iditemsic; ?>;
    var cantidadadjuntos = p.$("#cantidadadjuntados").attr("value");

    //$("#zadjuntar").click( function() {
    //alert(cantidadadjuntados);
    if(cantidadadjuntos == 0)
    {
        if(p.$("#longituddescripcionitemsic").attr("value") == 0)
        {
            q.$("#img" + iditemsic).attr("src", "imagenes/noiniciado.gif");
        }
    }
    if(error == "0")
        {
            p.$("#listaadjuntos").append("<tr id='iditemsiccarreraadjunto<?php echo $adjunto->iditemsiccarreraadjunto; ?>'><td><?php echo ereg_replace(".*_","",$adjunto->nombreitemsiccarreraadjunto); ?></td><td><img id='eliminaradjunto<?php echo $adjunto->iditemsiccarreraadjunto; ?>' alt='eliminaradjunto' title='<?php echo $adjunto->iditemsiccarreraadjunto; ?>' src='../../../../imagenes/eliminar.png' /><?php if(ereg("pdf|PDF",$adjunto->nombreitemsiccarreraadjunto) || ereg("doc|DOC",$adjunto->nombreitemsiccarreraadjunto)){ ?><a href='../../../../adjuntos/<?php echo $adjunto->nombreitemsiccarreraadjunto; ?>'><img id='veradjunto' title='<?php echo $adjunto->iditemsiccarreraadjunto; ?>' src='../../../../imagenes/ver.png' /></a><?php } else {?><a href='../../../../adjuntos/<?php echo $adjunto->nombreitemsiccarreraadjunto; ?>' rel='lightbox'><img id='veradjunto' title='<?php echo $adjunto->iditemsiccarreraadjunto; ?>' src='../../../../imagenes/ver.png' /></a><?php } ?></td><td>http://<?php echo $_SERVER['SERVER_NAME'].$ruta[0];?>sic/adjuntos/<?php echo $adjunto->nombreitemsiccarreraadjunto;?></td></tr>");
            p.$("#iditemsiccarrera").attr('value','iditemsiccarrera');
            if(p.$("#longituddescripcionitemsic").attr("value") == 0)
            {
                if(q.$("#img" + iditemsic).attr("src") == "imagenes/noiniciado.gif")
                    q.$("#img" + iditemsic).attr("src", "imagenes/poraprobar.gif");
            }
            alert('El archivo <?php echo $adjunto->estatus; ?> se ha adjuntado correctamente');
            p.$("#cantidadadjuntados").attr("value", cantidadadjuntos++);
            p.$("#adjuntos").newWindow({
                windowTitle:"Adjuntar Archivos",
                content: "<iframe id='#idadjunto' width='300px' height='300px' src='../php/adjunto.php?iditemsiccarrera=" + iditemsiccarrera + "&iditemsic=" + iditemsic + "'>",
                windowType: "iframe",
                posx : 400,
                posy : 80,
                width: 300,
                height: 180
            });
            p.$('a[rel*=lightbox]').lightBox();

            p.$("img[alt*=eliminaradjunto]").click(function(){
                var iditemsiccarreraadjunto = p.$(this).attr("title");
                if(confirm("Esta seguro de elminar el archivo adjunto"))
                {
                    $.ajax({
                        url: "adjunto.php?eliminar=" + iditemsiccarreraadjunto,
                        success: function(datos){
                            //alert(datos);
                            if(datos == "eliminado")
                            {
                                //alert("Adjuntados" + cantidadadjuntados);
                                //alert("adjunto.php" + cantidadadjuntos);
                                if(cantidadadjuntos <= 1)
                                {
                                    if(p.$("#longituddescripcionitemsic").attr("value") == 0)
                                    {
                                        q.$("#img" + iditemsic).attr("src", "imagenes/noiniciado.gif");
                                    }
                                }
                                p.$("#cantidadadjuntados").attr("value", cantidadadjuntos--);
                                p.$("#iditemsiccarreraadjunto" + iditemsiccarreraadjunto).remove();

                                alert("El archivo adjunto fue eliminado satisfactoriamente");
                            }
                            else
                            {
                                alert(datos);
                            }
                        }
                    });
                }
            });
            p.$(".window-container").fadeOut();
        }
        else if(error == "1")
        {
            alert('<?php echo $adjunto->estatus; ?>');
        }
    //    return false;
    //})
})
</script>
</head>
<body>
<br>
<?php
    if(!isset($_REQUEST['enviar']))
    {
?>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="iditemsic" value="<?php echo $iditemsic; ?>">
    <input type="hidden" name="iditemsiccarrera" value="<?php echo $iditemsiccarrera; ?>">
    <div style="width: auto;">
        Por favor seleccione el archivo a subir:<br>
        <b>El archivo debe tener extensión (jpg, png, gif) </b>
        <br><br>
        <input name="archivo" type="file">
        <br><br>
        <input name="enviar" type="submit" value="Cargar Archivo">
    </div>
    </form>
<?php
    }
    //echo "<pre>"; print_r($_SERVER); echo "</pre>";
?>
</body>
</html>
<?php
endif;
?>