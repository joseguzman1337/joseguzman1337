<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../../../../Connections/sala2.php');
$rutaado = "../../../../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../../../../Connections/salaado.php');
//$codigocarrera = $_SESSION['codigofacultad'];
$fechahoy=date("Y-m-d H:i:s");
$varguardar = 0;
$varanular = 0;
?>
<script language="javascript">
    function cambio()
        {
            document.form1.submit();
        }
</script>
<?php
if (isset($_POST['anular'])) {
        if ($varanular==0){
            if (isset($_REQUEST['idlineainvestigacion'])){ ?>
                <script language='javascript'> alert('Se ha Anulado la Línea'); window.location.href = 'lista_lineasinvestigacion.php?idgrupoinvestigacion=<?php echo $_REQUEST['idgrupoinvestigacion'];?>' </script>
                <?php
                $query_actualizar = "UPDATE lineainvestigacion SET codigoestado = 200 where idlineainvestigacion = '{$_REQUEST['idlineainvestigacion']}'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            }

        }
}
?>
<?php
//echo "algo".$_REQUEST['idlineainvestigacion'];
//echo "algo".$_REQUEST['idgrupoinvestigacion'];
  if (isset($_POST['grabar'])) {
      if ($_POST['nombrelineainvestigacion'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Nombre para la Línea de Investigación")</script>';
                $varguardar = 1;
                }

        elseif ($varguardar == 0) {
                if (isset($_REQUEST['idlineainvestigacion']) && $_REQUEST['idlineainvestigacion']!=""){
           $query_actualizar = "UPDATE lineainvestigacion SET nombrelineainvestigacion='".$_POST['nombrelineainvestigacion']."'
           where idlineainvestigacion = '{$_REQUEST['idlineainvestigacion']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
                }

            else {
            $query_guardar = "INSERT INTO lineainvestigacion (idlineainvestigacion, idgrupoinvestigacion, nombrelineainvestigacion, codigoestado) values (0, '{$_REQUEST['idgrupoinvestigacion']}', '{$_POST['nombrelineainvestigacion']}', 100)";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            $_REQUEST['idlineainvestigacion'] = $db->Insert_ID();
            echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  </script>";
                    }
             }
  }

$query_datos ="SELECT idlineainvestigacion, nombrelineainvestigacion FROM lineainvestigacion
where idlineainvestigacion = '".$_REQUEST['idlineainvestigacion']."'
and codigoestado = 100";
$datos= $db->Execute($query_datos);
$totalRows_datos = $datos->RecordCount();
$row_datos = $datos->FetchRow();

?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../../../../estilos/sala.css" type="text/css">

<SCRIPT language="JavaScript" type="text/javascript">
function cambiar()
{
    document.form1.submit();
}
</SCRIPT>
</head>
    <body>
<form name="form1" id="form1"  method="POST">
    <INPUT type="hidden" name="idgrupoinvestigacion" value="<?php echo $_REQUEST['idgrupoinvestigacion'];?>">
    <INPUT type="hidden" name="idlineainvestigacion" value="<?php echo $_REQUEST['idlineainvestigacion'];?>">
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR id="trgris">
           <TD align="center"><label id="labelresaltadogrande">Edición e Ingreso de Líneas de Investigación</label></TD>
          </TR>
    </table>

            <TABLE width="50%"  border="1" align="center">
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Nombre Línea Investigación<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idlineainvestigacion'])){
                        $row_datos['nombrelineainvestigacion']==$_POST['nombrelineainvestigacion'];?>
                        <TEXTAREA  name="nombrelineainvestigacion" id="nombrelineainvestigacion" cols="60" rows="2"><?php echo $row_datos['nombrelineainvestigacion']; ?></TEXTAREA>
                        <?php
                         }
                         else {?>
                        <TEXTAREA  name="nombrelineainvestigacion" id="nombrelineainvestigacion" cols="60" rows="2"><?php if ($_POST['nombrelineainvestigacion']!=""){
                        echo $_POST['nombrelineainvestigacion']; } ?></TEXTAREA>
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>




             <TR align="left">
                <TD id="tdtitulogris" colspan="2" rowspan="2" align="center">
                <INPUT type="submit" value="Guardar" name="grabar">

                <INPUT type="button" value="Regresar" onClick="window.location.href='lista_lineasinvestigacion.php?idgrupoinvestigacion=<?php echo              $_REQUEST['idgrupoinvestigacion']; ?>'">
                <?php if (isset($_REQUEST['idlineainvestigacion'])){ ?>
                        <INPUT type="submit" value="Anular Línea" name="anular">
                    <?php } ?>
                </TD>
              </TR>
        </TABLE>
</form>
</body>
</html>