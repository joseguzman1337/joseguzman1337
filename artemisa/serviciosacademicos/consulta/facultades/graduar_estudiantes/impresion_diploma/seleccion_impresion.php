<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');
if(!isset ($_SESSION['MM_Username'])){
echo "No tiene permiso para acceder a esta opción";
exit();
}
?>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">

    </head>
    <body>
        <form name="form1" id="form1"  method="POST" action="folios.php?tipogeneracion='<?php echo $_REQUEST['tipogeneracion']; ?>'">
            <table width="50%"  border="0"  cellpadding="3" cellspacing="3">
                <TR >
                    <TD align="center" colspan="4" >
                        <label id="labelresaltadogrande" >Selección Generación de Diplomas
                        </label>
                    </TD>
                </TR>
                <tr>
                    <td  id="tdtitulogris" >Seleccione el tipo de generacion de Diplomas</td>
                    <td width="50%">
                        <select name="tipogeneracion" id="tipogeneracion" >
                            <option value="">
                                Seleccionar
                            </option>
                            <option value="generacionmasiva">
                                Generación Masiva
                            </option>
                            <option value="generacionestudiante">
                                Generación por Estudiante
                            </option>
                            <option value="generacionduplicado">
                                Generación Duplicado
                            </option>
                        </select>
                    </td>
                </tr>                
                <TR>
                    <TD align="center" colspan="4" >
                        <input type="submit" name="enviar" value="&nbsp;&nbsp;&nbsp;&nbsp;Ir&nbsp;&nbsp;&nbsp;&nbsp;">
                    </TD>
                </TR>                
            </table>
       </form>
    </body>
</html>