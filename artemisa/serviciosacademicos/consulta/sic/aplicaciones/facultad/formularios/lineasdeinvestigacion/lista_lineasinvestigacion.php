<?php
session_start;
include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../../../../Connections/sala2.php');
$rutaado = "../../../../../../funciones/adodb/";
require_once('../../../../../../Connections/salaado.php');

//unset ($_SESSION['sesion_planestudioporcarrera']);
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../../../../estilos/sala.css" type="text/css">
         <SCRIPT language="JavaScript" type="text/javascript">

function prueba()
{
    document.form1.submit();
}

         </SCRIPT>
    </head>
 <body>
    <form name="form1" id="form1"  method="POST">
    <INPUT type="hidden" name="idgrupoinvestigacion" value="<?php echo $_REQUEST['idgrupoinvestigacion'];?>">
        <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">

            <TR><TD id="tdtitulogris" align="center"><label id="labelresaltadogrande" >LÍNEAS DE INVESTIGACIÓN</label></TD></TR>
        </table>
                <?php
                        $query_lineainvestigacion ="SELECT l.idlineainvestigacion, l.idgrupoinvestigacion, l.nombrelineainvestigacion, g.nombregrupoinvestigacion FROM lineainvestigacion l, grupoinvestigacion g
                        where
                        l.idgrupoinvestigacion = g.idgrupoinvestigacion
                        and g.idgrupoinvestigacion = '".$_REQUEST['idgrupoinvestigacion']."'
                        and l.codigoestado like '1%'";
                        $lineainvestigacion= $db->Execute($query_lineainvestigacion);
                        $totalRows_lineainvestigacion = $lineainvestigacion->RecordCount();
                        $row_lineainvestigacion = $lineainvestigacion->FetchRow();
                        // print_r($_POST);
                ?>

                            <table width="50%"  border="1" align="center">
                                <tr align="left" >
                                    <TD  align="center">
                                        <label id="labelresaltado">ID </label>
                                    </TD>
                                    <TD  align="center">
                                        <label id="labelresaltado">Nombre Línea Investigación</label>
                                    </TD>

                                </tr>
                                <?php do {?>
                                <TR >
                                    <TD width="5%" align="center"><A id="aparencialink" href="insertar_modificar_lineainvestigacion.php?idlineainvestigacion=<?php echo $row_lineainvestigacion['idlineainvestigacion']."&idgrupoinvestigacion=".$row_lineainvestigacion['idgrupoinvestigacion']; ?>"><?php echo $row_lineainvestigacion['idlineainvestigacion']; ?></A>
                                    </TD>
                                    <TD  align="center"><?php echo $row_lineainvestigacion['nombrelineainvestigacion']; ?>
                                    </TD>
                                </TR>
                                <?php } while($row_lineainvestigacion = $lineainvestigacion->FetchRow());
                                ?>
                                <TR >
                                    <TD align="center" colspan="3">
                                    <INPUT type="button" value="Adicionar" onClick="window.location.href='insertar_modificar_lineainvestigacion.php?idgrupoinvestigacion=<?php echo $_REQUEST['idgrupoinvestigacion']; ?>'">
                                    <INPUT type="button"  value="Regresar" onClick="window.location.href='menu_grupoinvestigacion.php'">
                                    </TD>

                                </TR>
                            </table>

   </form>
 </body>
</html>