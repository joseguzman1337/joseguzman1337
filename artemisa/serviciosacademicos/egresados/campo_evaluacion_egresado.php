<?php
/*
 * Caso 90158
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso  90158
include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../Connections/sala2.php');

mysql_select_db($database_sala, $sala);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tabulación de Encuesta</title>
</head>
<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
<script type="text/javascript" src="js/jquery.js"></script>
<style>
    button, input[type="submit"], input[type="reset"], input[type="button"], .button {
    background-color: #ECF1F4;
    background-image: url("../../../../index.php?entryPoint=getImage&themeName=Sugar5&imageName=bgBtn.gif");
    border-color: #ABC3D7;
    color: #000000;
}

.yui-dt table {
    border: 1px solid #7F7F7F;
    border-collapse: collapse;
    border-spacing: 0;
    font-family: arial;
    font-size: inherit;
    margin: 0;
    padding: 0;
}
</style>
<script>
    function editar_campo(obj,field,esInstrumento){
		esInstrumento = (typeof esInstrumento === 'undefined') ? false : esInstrumento;
        var iditem = obj.id;
        //elemnt = document.getElementById(obj.id+'name');
        document.location='editar_campo.php?id='+iditem+'&name='+field+'&esInstrumento='+esInstrumento;
    }
</script>
</link>
<body>
    <table align="center" width="50%" style="" >
    <tr><td colspan="3">
            <div id="studiofields">
        <input class="button" type="button" onclick="document.location ='agregar_campo.php'" value="Agregar Campo" name="addfieldbtn"/>
        <input class="button" type="button" onclick="document.location ='admin_egresado.php'" value="Regresar" name="addfieldbtn"/>
        </div>
            <hr>
             Base Egresados
            <hr>
        </td></tr>
    <tr align="left">
        <th>Nombre del Campo</th>
        <th>Etiqueta</th>
        <th>Tipo</th>
    </tr>
    <?php
    $query_table = "desc egresado;";
    $query_table = mysql_query($query_table, $sala) or die(mysql_error());

    while (($row = mysql_fetch_array($query_table, MYSQL_ASSOC)) != NULL) {
        //echo "<pre>";
        //print_r($row);
            echo "<tr>";
            if ($row['Key'] != 'PRI'){
                $r_field = "select * from label where table_name = 'egresado' and field = '".$row['Field']."';";
                $r_field = mysql_query($r_field, $sala) or die(mysql_error());
                $r_field = mysql_fetch_array($r_field, MYSQL_ASSOC);
                    echo "<td  style='cursor: pointer;' onclick=\"javascript:editar_campo(this,'".$row['Field']."');\" id='".$r_field['idlabel']."'  >
                        <a>".$row['Field']."</a>
                        <input type=hidden value='".$row['Field']."' id='".$r_field['idlabel']."name'></td>";
                echo "<td>".$r_field['label_field']."</td>";
                        $query_type = "select * from label_type where idlabel_type = '".$r_field['idlabel_type']."';";
                        $query_type = mysql_query($query_type, $sala) or die(mysql_error());
                        $r_type = mysql_fetch_array($query_type, MYSQL_ASSOC);
                echo "<td>".$r_type['name']."</td>";

            }
            echo "</tr>";
        }
    ?>
        <tr><td colspan="3"><hr>Extendida<hr> </td></tr>
<?php
    $query_table = "desc egresado_ext;";
    $query_table = mysql_query($query_table, $sala) or die(mysql_error());

    while (($row = mysql_fetch_array($query_table, MYSQL_ASSOC)) != NULL) {        
            echo "<tr>";
            if ($row['Key'] != 'PRI'){
                $r_field = "select * from label where table_name = 'egresado_ext' and field = '".$row['Field']."';";
                $r_field = mysql_query($r_field, $sala) or die(mysql_error());
                $r_field = mysql_fetch_array($r_field, MYSQL_ASSOC);
                    echo "<td  style='cursor: pointer;' onclick=\"javascript:editar_campo(this,'".$row['Field']."');\" id='".$r_field['idlabel']."'  >
                        <a>".$row['Field']."</a>
                        <input type=hidden value='".$row['Field']."' id='".$r_field['idlabel']."name'></td>";
                echo "<td>".$r_field['label_field']."</td>";
                        $query_type = "select * from label_type where idlabel_type = '".$r_field['idlabel_type']."';";
                        $query_type = mysql_query($query_type, $sala) or die(mysql_error());
                        $r_type = mysql_fetch_array($query_type, MYSQL_ASSOC);
                echo "<td>".$r_type['name']."</td>";

            }
            echo "</tr>";
        }
    ?>
            <tr><td colspan="3"><hr>Instrumentos de Percepción<hr> </td></tr>
<?php
    $query_table = "select * from label where idlabel_type=13";
    $query_table = mysql_query($query_table, $sala) or die(mysql_error());

    while (($row = mysql_fetch_array($query_table, MYSQL_ASSOC)) != NULL) {        
            echo "<tr>";
            
                $r_field = "select titulo from siq_Apregunta where idsiq_Apregunta = '".$row['idPregunta']."' ;";
                $r_field = mysql_query($r_field, $sala) or die(mysql_error());
                $r_field = mysql_fetch_array($r_field, MYSQL_ASSOC);
                    echo "<td  style='cursor: pointer;' onclick=\"javascript:editar_campo(this,'".$row['idlabel']."',true);\" id='".$row['idlabel']."'  >
                        <a>".strip_tags($r_field['titulo'])."</a></td>";
					echo "<td></td>";
                        $query_type = "select * from label_type where idlabel_type = '".$row['idlabel_type']."';";
                        $query_type = mysql_query($query_type, $sala) or die(mysql_error());
                        $r_type = mysql_fetch_array($query_type, MYSQL_ASSOC);
                echo "<td>".$r_type['name']."</td>";

            
            echo "</tr>";
        }
    ?>

</table>


</body>
</html>