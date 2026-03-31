<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.css" />
<link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-ui/css/ui-lightness/jquery-ui-3.6.0.custom.css" />
<link rel="stylesheet" href="<?php echo $rutaEstilos; ?>sic_normal.css" />
<link rel="stylesheet" href="<?php echo $rutaEstilos; ?>jquery.lightbox-0.5.css" />

<script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery.layout.js"></script>
<script src="<?php echo $rutaJS; ?>jquery.lightbox-0.5.min.js"></script>
<script src="<?php echo $rutaJS; ?>jquery.maxlength-min.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery-treeview/lib/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery-ui/js/jquery-ui-3.6.0.custom.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.css" />
<script src="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
    var p = parent;
    var datos = "<?php echo $mensaje; ?>";
    var iditemsic = <?php echo $itemsic->iditemsic; ?>;
    var iditemsiccarrera = <?php echo $row_itemsiccarrera['iditemsiccarrera']; ?>;
    var cantidadadjuntos = $("#cantidadadjuntados").attr("value");
    var longituddescripcionitemsic = "<?php echo $itemsic->longituddescripcionitemsic; ?>";
    $("#valoritemsiccarrera").maxlength( {statusText: "Caracteres faltantes", maxCharacters: longituddescripcionitemsic, slider: true});

    /*$("#adjuntos").click(function(){
        if($("#iditemsiccarrera").attr('value') != 0)
        {
            iditemsiccarrera = $("#iditemsiccarrera").attr('value');
        }
        $("#adjuntos").newWindow({
            windowTitle:"Adjuntar Archivos",
            content: "<iframe id='#idadjunto' width='300px' height='300px' src='../php/adjunto.php?iditemsiccarrera=" + iditemsiccarrera + "&iditemsic=" + iditemsic + "'>",
            windowType: "iframe",
            posx : 400,
            posy : 80,
            width: 300,
            height: 180
        });
    });*/

    $("#adjuntos").newWindow({
        windowTitle:"Adjuntar Archivos",
        content: "<iframe id='#idadjunto' width='300px' height='300px' src='adjunto.php?iditemsiccarrera=" + iditemsiccarrera + "&iditemsic=" + iditemsic + "'>",
        windowType: "iframe",
        posx : 400,
        posy : 80,
        width: 300,
        height: 180
    });

    if(datos == 'insertado')
    {
        alert("El valor fue insertado satisfactoriamente");
        if(p.$("#img" + iditemsic).attr("src") == "imagenes/noiniciado.gif")
            p.$("#img" + iditemsic).attr("src", "imagenes/poraprobar.gif");
    }
    else if(datos == 'actualizado')
    {
        alert("El valor fue actualizado satisfactoriamente");
        if(p.$("#img" + iditemsic).attr("src") == "imagenes/aprobado.gif")
            alert("ADVERTENCIA: El item ha quedado por aprobar debido a la modificación hecha")
        p.$("#img" + iditemsic).attr("src", "imagenes/poraprobar.gif");
    }
    else if(datos != '')
    {
        alert("ERROR:" + datos);
    }

    //$(".lightbox").lightBox();
    $('a[rel*=lightbox]').lightBox();

    $("img[alt*=eliminaradjunto]").click(function(){
        var iditemsiccarreraadjunto = $(this).attr("title");
        if(confirm("Esta seguro de eliminar el archivo adjunto"))
        {
            $.ajax({
                url: "adjunto.php?eliminar=" + iditemsiccarreraadjunto,
                success: function(datos){
                    //alert(datos);
                    if(datos == "eliminado")
                    {
                        if(cantidadadjuntos <= 1)
                        {
                            if($("#longituddescripcionitemsic").attr("value") == 0)
                            {
                                p.$("#img" + iditemsic).attr("src", "imagenes/noiniciado.gif");
                            }
                        }
                        $("#cantidadadjuntados").attr("value", cantidadadjuntos--);
                        $("#iditemsiccarreraadjunto" + iditemsiccarreraadjunto).remove();
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
})
</script>
</head>
<body>
<div id="textogeneral">
    <h2 id="titulotextogeneral"><?php echo $itemsic->nombreitemsic; ?></h2>
 <fieldset style="width:533px" class="titulogris">
    <?php echo $itemsic->descripcionitemsic; ?></fieldset><br />
    <input id="longituddescripcionitemsic" type="hidden" value="<?php echo $itemsic->longituddescripcionitemsic; ?>" />
    <input id="cantidadadjuntados" type="hidden" value="<?php echo count($adjuntos); ?>" />
<?php
if($itemsic->longituddescripcionitemsic != 0):
?>
    <form id="f1" method="POST" action="">
    <input type="hidden" id="iditemsic" value="<?php echo $itemsic->iditemsic; ?>" />
    <input type="hidden" id="iditemsiccarrera" value="" />
    <textarea id="valoritemsiccarrera" cols="50" rows="5" name="valoritemsiccarrera" style="width: 550px"><?php if(isset($_REQUEST['valoritemsiccarrera'])){ echo $_REQUEST['valoritemsiccarrera']; } else { echo $row_itemsiccarrera['valoritemsiccarrera']; } ?></textarea>
    <div class="status"></div>
    <br>
    <input id="botonaceptar" type="submit" name="Aceptar" value="Aceptar" />
<?php
endif;
?>
    </form>
</div>
<?php
if($itemsic->cantidadadjuntositemsic > 0) :
?>
<br>
<table id="listaadjuntos">
<tr id="adjuntos" class="titulogris" style="cursor:pointer;"><td colspan="3">Archivos Adjuntos <img src="https://artemisa.unbosque.edu.co/imagenes/correo1.png"></td></tr>
<tr class="titulo"><td>Nombre Archivo</td><td>Acción</td><td>Ruta al archivo</td></tr>
<?php
    if(is_array($adjuntos)):
        foreach($adjuntos as $row_adjunto) :
?>
  <tr id="iditemsiccarreraadjunto<?php echo $row_adjunto['iditemsiccarreraadjunto'];?>">
    <td><?php echo ereg_replace(".*_","",$row_adjunto['nombreitemsiccarreraadjunto']); ?></td>
    <td>
    <img id="eliminaradjunto<?php echo $row_adjunto['iditemsiccarreraadjunto'];?>" alt="eliminaradjunto"  title="<?php echo $row_adjunto['iditemsiccarreraadjunto'];?>" src="../../../../imagenes/eliminar.png" />
<?php if(ereg("pdf|PDF|doc|DOC",$row_adjunto['nombreitemsiccarreraadjunto'])){ ?>
    <a href="../../../../adjuntos/<?php echo $row_adjunto['nombreitemsiccarreraadjunto'];?>" >
    <img id="veradjunto" title="<?php echo $row_adjunto['iditemsiccarreraadjunto'];?>" src="../../../../imagenes/ver.png" /></a>
<?php } else {?>
    <a href="../../../../adjuntos/<?php echo $row_adjunto['nombreitemsiccarreraadjunto'];?>" rel="lightbox">
    <img id="veradjunto" title="<?php echo $row_adjunto['iditemsiccarreraadjunto'];?>" src="../../../../imagenes/ver.png" /></a>
<?php } ?>
    </td>
<?php
   //print_r(explode("sic/",$_SERVER['REQUEST_URI']));
   $ruta = explode("sic/",$_SERVER['REQUEST_URI']);
?>
    <td>http://<?php echo $_SERVER['SERVER_NAME'].$ruta[0];?>sic/adjuntos/<?php echo $row_adjunto['nombreitemsiccarreraadjunto'];?></td>
</tr>
<?php
        endforeach;
?>
<?php
    endif;
?>
</table>
<?php
endif;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";
?>
</body>
</html>