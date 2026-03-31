<?php
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
$varguardar = 0;
//session_start();
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
                echo "<script language='javascript'> window.location.href='listadoestado.php?idpersonaquejareclamo=".$row_solicitud['idpersonaquejareclamo']."';</script>";
            }
            else {
                echo '<script language="JavaScript">alert("No se encuentra registrado el número de tiquete '.$_POST['idsolicitud'].', por verificar que el número digitado este correcto.")</script>';
            }
         }
     }

?>
<html>
    <head>
        <title>EL Bosque Te Escucha</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<SCRIPT language="JavaScript" type="text/javascript">
function abre(){
  if(document.validacion.ticket){
      //alert ("Hola");
    digitaticket.style.display ='';
  }
  
}
</SCRIPT>
    </head>
    <body vlink="#8AB200" alink="#8AB200">
<form name="validacion" id="validacion" method="POST" action="" >
<input type="hidden" name="tipodoc" value="<?php echo $_REQUEST['tipodoc']; ?>">
<TABLE  border="0" align="center" cellpadding="3">
<tr>
    <td  colspan="3" valign="center"><a style="color: #8AB200" href="http://www.uelbosque.edu.co"><img src="../../../imagenes/logo_quejas.gif" height="71"></a></td>
                </tr>
</TABLE></BR></BR>
    <TABLE width="35%" border="0" align="center" cellpadding="3">
        <TR id="trgris">
            <TD id="tdtitulogris" style="text-align:justify;">
                <label id="labelresaltado">Bienvenido al sistema de felicitaciones, sugerencias, ideas, reclamos, peticiones y oportunidades de mejora  de la Universidad El Bosque.<BR>
                    Por favor seleccione una opción para comenzar.</label>
            </TD>
        </TR>
       
        <tr align="center" id="trgris">
            <td id="tdtitulogris">
                <INPUT type="button" name="nuevo" value="NUEVO REGISTRO" onclick="window.location.href='organizado.php'">
                <INPUT type="button" name="ticket" value="CONSULTAR TIQUETE" onclick="abre()">
            </td>
        </tr>
    </TABLE>
    <div id="digitaticket" style="display: none ">
        <table  width="35%" border="0" align="center" cellpadding="3">
            <tr align="center" id="trgris">
                <td id="tdtitulogris" colspan="2">Digite su  número de Tiquete.
                    <INPUT type="text" name="idsolicitud" ><BR><INPUT type="submit" value="Enviar" name="enviar" >
                </td>
            </tr>
        </table>    
    </div>
    
</form>
</body>
</html>
