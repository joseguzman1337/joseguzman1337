<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}
$varguardar = 0;
$varanular = 0;

        $query_objetivo ="SELECT o.nombreobjetivocarrera, o.descripcionobjetivocarrera, o.codigocarrera
        FROM objetivocarrera o
        WHERE o.idobjetivocarrera='".$_REQUEST['idobjetivocarrera']."'";
        $objetivo= $db->Execute($query_objetivo);
        $totalRows_objetivo = $objetivo->RecordCount();
        $row_objetivo = $objetivo->FetchRow();
?>

<?php
if (isset($_POST['anular'])) {
    if ($varanular==0){
        if (isset($_REQUEST['idobjetivocarrera'])){
            echo "<script language='javascript'> alert('Se ha Anulado el Objetivo');
                window.location.href = 'lista_objetivos_carrera.php?codigocarrera=".$row_objetivo['codigocarrera']."'; </script>";
            $query_actualizar = "UPDATE objetivocarrera SET codigoestado = 200 where idobjetivocarrera = '{$_REQUEST['idobjetivocarrera']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            }
        }
}
?>
<?php
  if (isset($_POST['grabar'])) {
    if ($_POST['nombreobjetivocarrera'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Nombre del Objetivo")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['descripcionobjetivocarrera'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar la Descripción")</script>';
                    $varguardar = 1;
              }
        elseif ($varguardar == 0) {
                if (isset($_REQUEST['idobjetivocarrera'])){

           $query_actualizar = "UPDATE objetivocarrera SET nombreobjetivocarrera='".$_POST['nombreobjetivocarrera']."',
           descripcionobjetivocarrera='".$_POST['descripcionobjetivocarrera']."', codigoestado = 100
           where idobjetivocarrera = '{$_REQUEST['idobjetivocarrera']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');
                window.location.href = 'lista_objetivos_carrera.php?codigocarrera=".$row_objetivo['codigocarrera']."';</script>";
            }
            else {
            $query_guardar = "INSERT INTO objetivocarrera (idobjetivocarrera, codigocarrera, nombreobjetivocarrera,
            descripcionobjetivocarrera, fechaingresoobjetivocarrera, codigoestado) values (0, '{$_REQUEST['codigocarrera']}',
            '{$_POST['nombreobjetivocarrera']}','{$_POST['descripcionobjetivocarrera']}', '$fechahoy', 100)";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());            
            echo "<script language='javascript'> alert('Se ha guardado la información correctamente');
                window.location.href = 'lista_objetivos_carrera.php?codigocarrera=".$_REQUEST['codigocarrera']."';</script>";
            }
            //$db->debug = true;            
         }
  }
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<SCRIPT language="JavaScript" type="text/javascript">
function cambiar()
{
    document.form1.submit();
}
</SCRIPT>
</head>
    <body>
<form name="form1" id="form1"  method="POST">
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR id="trgris">
           <TD align="center"><label id="labelresaltadogrande">MANTENIMIENTO OBJETIVOS DE APRENDIZAJE </label></TD>
          </TR>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltado"><?php if(isset ($_REQUEST['idobjetivocarrera'])){
            $query_nomobjetivo = "select nombreobjetivocarrera from objetivocarrera where idobjetivocarrera = '".$_REQUEST['idobjetivocarrera']."'";
                $nomobjetivo= $db->Execute($query_nomobjetivo);
                $totalRows_nomobjetivo = $nomobjetivo->RecordCount();
                $row_nomobjetivo = $nomobjetivo->FetchRow();
                echo $row_nomobjetivo['nombreobjetivocarrera'];              
                 }
             ?>
            </label></TD>
         </TR>
    </table>       

            <TABLE width="50%"  border="1" align="center">
                <tr align="left" >
                    <td id="tdtitulogris">Nombre Objetivo<label  id="labelasterisco">*</label>
                    </td>
                    <td id="tdtitulogris">
                        <?php
                        if (isset($_REQUEST['idobjetivocarrera'])){
                        $row_objetivo['nombreobjetivocarrera']==$_POST['nombreobjetivocarrera'];?>
                        <INPUT type="text" name="nombreobjetivocarrera" id="nombreobjetivocarrera" size="40px" value="<?php echo $row_objetivo['nombreobjetivocarrera']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="nombreobjetivocarrera" id="nombreobjetivocarrera" size="40px" value="<?php if ($_POST['nombreobjetivocarrera']!=""){
                        echo $_POST['nombreobjetivocarrera']; } ?>">
                         <?php }
                            ?>
                    </td>
                </tr>
                <tr align="left" >
                    <td id="tdtitulogris">Descripción Objetivo<label  id="labelasterisco">*</label>
                    </td>
                    <td id="tdtitulogris">
                        <?php
                        if (isset($_REQUEST['idobjetivocarrera'])){
                        $row_objetivo['descripcionobjetivocarrera']==$_POST['descripcionobjetivocarrera'];?>
                        <TEXTAREA name="descripcionobjetivocarrera" id="descripcionobjetivocarrera" cols="45" rows="3"><?php echo $row_objetivo['descripcionobjetivocarrera']; ?></TEXTAREA>
                        <?php
                         }
                         else {?>
                         <TEXTAREA name="descripcionobjetivocarrera" id="descripcionobjetivocarrera" cols="45" rows="3"><?php if ($_POST['descripcionobjetivocarrera']!=""){
                        echo $_POST['descripcionobjetivocarrera']; } ?></TEXTAREA>
                         <?php }
                            ?>
                    </td>
                </tr>
                

            <script language="javascript">
                function guardar()
                {
                    document.form1.submit();
                }
            </script>
             <TR align="left">
                <TD id="tdtitulogris" colspan="2" rowspan="2" align="center">
                <INPUT type="submit" value="Guardar" name="grabar">
<?php

                    if (isset($_REQUEST['idobjetivocarrera'])){
                ?>
                <input type="hidden" name="idobjetivocarrera" value="<?php echo $_REQUEST['idobjetivocarrera']; ?>">
                <INPUT type="button" value="Regresar" onClick="window.location.href='lista_objetivos_carrera.php?codigocarrera=<?php echo $row_objetivo['codigocarrera']; ?>'">
                    <?php
                    }
                    else{
                    ?>
                        <INPUT type="button" value="Regresar" onClick="window.location.href='lista_objetivos_carrera.php?codigocarrera=<?php echo $_REQUEST['codigocarrera']; ?>'">
                    <?php
                    }
                    if (isset($_REQUEST['idobjetivocarrera'])){ ?>
                        <INPUT type="submit" value="Anular Objetivo" name="anular">
                    <?php } ?>
                </TD>
              </TR>
        </TABLE>
</form>
</body>
</html>