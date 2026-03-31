 <?php
 //session_start();
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
$varguardar = 0;

unset ($_SESSION['session_sqr']);

    if (isset($_POST['enviar'])) {
        if ($_POST['idsolicitud']== ""){
            echo '<script language="JavaScript">alert("Debe digitar un número de tiquete, o verificar que el número digitado este correcto.")</script>';
            $varguardar = 1;
        }        
        elseif ($varguardar == 0) {
            $query_solicitud = "SELECT idsolicitudquejareclamo, idpersonaquejareclamo FROM solicitudquejareclamo where idsolicitudquejareclamo = '".$_POST['idsolicitud']."' ";
            $solicitud = $db->Execute($query_solicitud);
            $totalRows_solicitud = $solicitud->RecordCount();
            $row_solicitud = $solicitud->FetchRow();
            if ($totalRows_solicitud !=''){
                echo "<script language='javascript'> window.location.href='requerimiento.php?idsolicitudquejareclamo=".$row_solicitud['idsolicitudquejareclamo']."';</script>";
            }
            else {
                echo '<script language="JavaScript">alert("No se encuentra registrado el número de tiquete '.$_POST['idsolicitud'].', por verificar que el número digitado este correcto.")</script>';
            }
         }
     }

?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
    </head>
    <body>
<form name="validacion" id="validacion" method="POST" action="" >
<input type="hidden" name="tipodoc" value="<?php echo $_REQUEST['idsolicitud']; ?>">

    <TABLE width="35%" border="0" align="center" cellpadding="3">
        <TR id="trgris">
            <TD id="tdtitulogris">
                <label id="labelresaltado">Consulta de Tiquete</label>
            </TD>
        </TR>
       
        <tr align="center" id="trgris">
                <td id="tdtitulogris" colspan="2">Digite el  número de Tiquete entregado por atención al Usuario.
                    <INPUT type="text" name="idsolicitud" ><BR><INPUT type="submit" value="Enviar" name="enviar" >
                </td>
            </tr>
    </TABLE>      
</form>         
</body>
</html>
