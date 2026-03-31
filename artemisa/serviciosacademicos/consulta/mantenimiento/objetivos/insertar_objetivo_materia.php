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

        $query_objetivo ="SELECT o.nombreobjetivomateria, o.descripcionobjetivomateria, o.codigomateria
        FROM objetivomateria o
        WHERE o.idobjetivomateria='".$_REQUEST['idobjetivomateria']."'";
        $objetivo= $db->Execute($query_objetivo);
        $totalRows_objetivo = $objetivo->RecordCount();
        $row_objetivo = $objetivo->FetchRow();
?>

<?php
if (isset($_POST['anular'])) {
    if ($varanular==0){
        if (isset($_REQUEST['idobjetivomateria'])){
            echo "<script language='javascript'> alert('Se ha Anulado el Objetivo');
                window.location.href = 'lista_objetivos_materia.php?codigomateria=".$row_objetivo['codigomateria']."'; </script>";
            $query_actualizar = "UPDATE objetivomateria SET codigoestado = 200 where idobjetivomateria = '{$_REQUEST['idobjetivomateria']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            }
        }
}
?>
<?php
  if (isset($_POST['grabar'])) {
    if ($_POST['nombreobjetivomateria'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Nombre del Objetivo")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['descripcionobjetivomateria'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar la Descripción")</script>';
                    $varguardar = 1;
              }
        elseif ($varguardar == 0) {
                if (isset($_REQUEST['idobjetivomateria'])){

           $query_actualizar = "UPDATE objetivomateria SET nombreobjetivomateria='".$_POST['nombreobjetivomateria']."',
           descripcionobjetivomateria='".$_POST['descripcionobjetivomateria']."', codigoestado = 100
           where idobjetivomateria = '{$_REQUEST['idobjetivomateria']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');
                window.location.href = 'lista_objetivos_materia.php?codigomateria=".$row_objetivo['codigomateria']."';</script>";
            }
            else {
            $query_guardar = "INSERT INTO objetivomateria (idobjetivomateria, codigomateria, nombreobjetivomateria,
            descripcionobjetivomateria, fechaingresoobjetivomateria, codigoestado) values (0, '{$_REQUEST['codigomateria']}',
            '{$_POST['nombreobjetivomateria']}','{$_POST['descripcionobjetivomateria']}', '$fechahoy', 100)";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            echo "<script language='javascript'> alert('Se ha guardado la información correctamente');
                window.location.href = 'lista_objetivos_materia.php?codigomateria=".$_REQUEST['codigomateria']."';</script>";
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
           <TD align="center"><label id="labelresaltadogrande">MANTENIMIENTO OBJETIVOS DE APRENDIZAJE PARA LA MATERIA</label></TD>
          </TR>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltado"><?php if(isset ($_REQUEST['idobjetivomateria'])){
            $query_nomobjetivo = "select nombreobjetivomateria from objetivomateria where idobjetivomateria = '".$_REQUEST['idobjetivomateria']."'";
                $nomobjetivo= $db->Execute($query_nomobjetivo);
                $totalRows_nomobjetivo = $nomobjetivo->RecordCount();
                $row_nomobjetivo = $nomobjetivo->FetchRow();
                echo $row_nomobjetivo['nombreobjetivomateria'];
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
                        if (isset($_REQUEST['idobjetivomateria'])){
                        $row_objetivo['nombreobjetivomateria']==$_POST['nombreobjetivomateria'];?>
                        <INPUT type="text" name="nombreobjetivomateria" id="nombreobjetivomateria" size="40px" value="<?php echo $row_objetivo['nombreobjetivomateria']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="nombreobjetivomateria" id="nombreobjetivomateria" size="40px" value="<?php if ($_POST['nombreobjetivomateria']!=""){
                        echo $_POST['nombreobjetivomateria']; } ?>">
                         <?php }
                            ?>
                    </td>
                </tr>
                <tr align="left" >
                    <td id="tdtitulogris">Descripción Objetivo<label  id="labelasterisco">*</label>
                    </td>
                    <td id="tdtitulogris">
                        <?php
                        if (isset($_REQUEST['idobjetivomateria'])){
                        $row_objetivo['descripcionobjetivomateria']==$_POST['descripcionobjetivomateria'];?>
                        <TEXTAREA name="descripcionobjetivomateria" id="descripcionobjetivomateria" cols="45" rows="3"><?php echo $row_objetivo['descripcionobjetivomateria']; ?></TEXTAREA>
                        <?php
                         }
                         else {?>
                         <TEXTAREA name="descripcionobjetivomateria" id="descripcionobjetivomateria" cols="45" rows="3"><?php if ($_POST['descripcionobjetivomateria']!=""){
                        echo $_POST['descripcionobjetivomateria']; } ?></TEXTAREA>
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

                    if (isset($_REQUEST['idobjetivomateria'])){
                ?>
                <input type="hidden" name="idobjetivomateria" value="<?php echo $_REQUEST['idobjetivomateria']; ?>">
                <INPUT type="button" value="Regresar" onClick="window.location.href='lista_objetivos_materia.php?codigomateria=<?php echo $row_objetivo['codigomateria']; ?>'">
                    <?php
                    }
                    else{
                    ?>
                        <INPUT type="button" value="Regresar" onClick="window.location.href='lista_objetivos_materia.php?codigomateria=<?php echo $_REQUEST['codigomateria']; ?>'">
                    <?php
                    }
                    if (isset($_REQUEST['idobjetivomateria'])){ ?>
                        <INPUT type="submit" value="Anular Objetivo" name="anular">
                    <?php } ?>
                </TD>
              </TR>
        </TABLE>
</form>
</body>
</html>