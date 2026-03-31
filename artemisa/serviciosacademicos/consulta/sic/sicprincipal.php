<?php
@session_start();
$rutabd = "../../";
require_once('conexionSIC.php');

$codigocarrera = $_SESSION['codigofacultad'];

require_once('funcionessic.php');
$rutaJS = 'librerias/js/';
$rutaEstilos = 'estilos/';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.css" />
<link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-ui/css/no-theme/jquery-ui-3.6.0.custom.css" />
<link rel="stylesheet" href="<?php echo $rutaEstilos; ?>sala2.css" />

<script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery.layout.js"></script>
<script src="<?php echo $rutaJS; ?>jquery.maxlength-min.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery-treeview/lib/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.js" type="text/javascript"></script>
<script src="<?php echo $rutaJS; ?>jquery-ui/js/jquery-ui-3.6.0.custom.min.js" type="text/javascript" ></script>

<script type="text/javascript">
$.ui.dialog.defaults.bgiframe = true;
$(function() {
    var texto;
    $("#tree").treeview({
    collapsed: true,
    animated: "medium",
    control:"#sidetreecontrol",
    //persist: "location"
    persist: "cookie"
    //unique: true
    });

    $("#dialog").dialog({
        autoOpen: false,
        width: 500
    });

    $("label").click(function(){
        texto = $(this).text();
        iditemsic = $(this).attr('name');
        desc = $(this).attr('title');
        long = $(this).attr('lang');
        //alert(long);
        $(".status").remove();

        $("#areadetexto").maxlength( {statusText: "Caracteres faltantes", maxCharacters: long, slider: true});
        $.ajax({
            url: "funcionessic.php?iditemsic=" + iditemsic + "&funcion=obtenerValoritemsiccarrera",
            success: function(datos){
                $("#areadetexto").val(datos);
                //$("#dialog").append(datos);
                //alert(datos);
            }
        });

        //$("#dialog").attr({
        //    title : 'texto'
        //});
        //$("#dialog").removeAttr("title");
        //$("#dialog").attr("title","button");
        //$("#dialog").replaceWith("<title>has changed</title>");
        //$("#dialog").attr('title','texto');
        //$("#dialog").attr("title",texto);
        //$("#dialog").attr("title", function(){ return texto });
        //if($("#dialog").dialog("isOpen"))
        //    $("#dialog").dialog("close");
        $("#iditemsicoculto").val(iditemsic);
        $("#descripcionitem").text(desc);
        $("#areadetexto").val("");
        //$("#dialog").dialog({
        //    autoOpen: false
        //});
        $("#dialog").dialog("open");
        $("#dialog").dialog("option", "title", texto);
        //$("#dialog").dialog("close");
        //alert($(this).text());
        //$("#dialog").dialog("open");
        //alert($(this).attr("name"));
    });

    $("#botonaceptar").click(function(){
        //alert('assssasd');
        var iditemsic = $("#iditemsicoculto").val();
        var valoritemsiccarrera = $("#areadetexto").val();
        if(valoritemsiccarrera != '')
        {
            //alert(iditemsic + valoritemsiccarrera);
            $.ajax({
                url: "funcionessic.php?iditemsic=" + iditemsic + "&valoritemsiccarrera=" + valoritemsiccarrera + "&funcion=insertarItemsiccarrera",
                success: function(datos){
                    //$("#areadetexto").val(datos);
                    //$("#dialog").append(datos);
                    if(datos == 'insertado')
                    {
                        alert("El valor fue insertado satisfactoriamente");
                        $("#img" + iditemsic).attr("src", "imagenes/poraprobar.gif");
                    }
                    else if(datos == 'actualizado')
                    {
                        alert("El valor fue actualizado satisfactoriamente");
                    }
                    else
                    {
                        alert("ERROR:" + datos);
                    }
                }
            });
        }
        else
        {
            alert("El campo de texto es requerido");
        }
    });

})
</script>
<script>
    $(document).ready(function () {
        $('body').layout({ applyDefaultStyles: true });
        $('body').layout().sizePane("west", 270);
        /*$('body').layout({
            west: {closable: true, size: 250}
        });*/
    });
</script>
</head>
<body>
<div class="ui-layout-north"><h1 align="center">SISTEMA DE INFORMACION DE CALIDAD DE LA UNIVERSIDAD EL BOSQUE</h1></div>

<!--<div class="ui-layout-south">South</div>-->
<!--<div class="ui-layout-east">East</div>-->

<div class="ui-layout-center">
<div id="dialog">
    <p id="descripcionitem">
    </p>
    <form id="f1">
    <input type="hidden" id="iditemsicoculto" value="" />
    <textarea id="areadetexto" cols="50" rows="5" name="areadetexto" style="width: 450px"></textarea>
        <div class="status"></div>
    <input id="botonaceptar" type="button" name="Aceptar" value="Aceptar" />
    </form>
</div>
</div>

<div class="ui-layout-west">
<img src="imagenes/todos.gif" width="252" height="25" />
<div id="sidetree">
<div id="sidetreecontrol"><a href="?#">Contraer Todo</a> | <a href="?#">Expandir Todo</a></div>
<?php
$iditemsicdel = 2;
$query_papas = "select i.iditemsic, i.nombreitemsic, i.descripcionitemsic, i.iditemsicpadre, i.codigotipoitemsic, i.pesoitemsic, i.enlaceitemsic, i.codigoestadoitemsic, i.codigoestado
from itemsic i
where i.iditemsicpadre = 0
and i.codigoestado like '100'
and i.iditemsic <> $iditemsicdel
order by i.pesoitemsic";
$papas = mysql_query($query_papas, $sala);
$totalRows_papas = mysql_num_rows($papas);
//$papas = $db->Execute($query_papas);
//$totalRows_papas = $papas->RecordCount();
?>
<ul id="tree">
<?php
//while($row_papas = $papas->FetchRow())
while($row_papas = mysql_fetch_assoc($papas))
{
?>
    <li><strong><?php echo $row_papas['nombreitemsic'];?></strong>
        <ul>
<?php
        getHijos($row_papas['iditemsic'], $iditemsicdel);
?>
        </ul>
    </li>
<?php
}
?>
</ul>
</div>
</div>

</body>

</html>
