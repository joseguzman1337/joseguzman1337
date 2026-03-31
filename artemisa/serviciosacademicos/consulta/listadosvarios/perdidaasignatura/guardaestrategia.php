<?php

session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$varguardar = 0;

$codigocarrera = $_REQUEST['codigocarrera'];
$codigoperiodo = $_REQUEST['codigoperiodo'];
$semestre= $_REQUEST['semestre'];

        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
        where codigocarrera='$codigocarrera'
        and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera";
        $carrera= $db->Execute($query_carrera);
        $totalRows_carrera = $carrera->RecordCount();
        $row_carrera= $carrera->FetchRow();
      // print_r($_POST);

        $query_periodo = "SELECT codigoperiodo, nombreperiodo from periodo where codigoperiodo='$codigoperiodo'";
        $periodo = $db->Execute($query_periodo);
        $totalRows_periodo = $periodo->RecordCount();
        $row_periodo= $periodo->FetchRow();

        $query_estrategiasem="SELECT * FROM estrategiaperiodo
        where codigocarrera='$codigocarrera'
        and codigoperiodo='$codigoperiodo'
        and semestre='$semestre'
        and codigoestado like '1%'";
        $estrategiasem= $db->Execute($query_estrategiasem);
        $totalRows_estrategiasem= $estrategiasem->RecordCount();
        $row_estrategiasem = $estrategiasem->FetchRow();
?>
<html>
    <head>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">

    </head>
 <body>
     <form action=""  name="form1" method="POST">
                <table  border="0" cellpadding="3" cellspacing="3">
                    <TR>
                     <TD id="tdtitulogris" align="center" colspan="4">
                         <label id="labelresaltadogrande" >ESTRATEGIAS Y OBSERVACIONES PÉRDIDA POR SEMESTRE<br><?php echo $row_carrera['nombrecarrera'] ?></label>
                     </TD>
                    </TR>
                    <TR>
                     <TD id="tdtitulogris" align="center" colspan="4">
                         <label id="labelresaltadogrande" ><?php echo strtoupper($row_periodo['nombreperiodo']); ?></label>
                     </TD>
                    </TR>
                    <TR>
                     <TD id="tdtitulogris" align="center" colspan="4">
                         <label id="labelresaltadogrande" ><?php echo "SEMESTRE ".$semestre; ?></label>
                     </TD>
                    </TR>
                     <TR>
                         <TD id="tdtitulogris" align="center" >Estrategia:</TD>
                         <td align="left" >
                            <TEXTAREA name=estrategia cols="35" rows="3" ><?php if($row_estrategiasem['estrategiaperiodo']!=""){
                            echo $row_estrategiasem['estrategiaperiodo']; }
                            else { echo $_POST['estrategia']; }
                            ?></TEXTAREA>
                         </td>
                     </TR>
                     <TR>
                         <TD id="tdtitulogris" align="center" >Observación:</TD>
                         <td align="left" >
                             <TEXTAREA name="observacion" cols="35" rows="3" ><?php if($row_estrategiasem['observacionestrategiaperiodo']!=""){
                            echo $row_estrategiasem['observacionestrategiaperiodo']; }
                            else { echo $_POST['observacion']; }
                            ?></TEXTAREA>
                         </td>
                     </TR>
                     <TR>

                         <TD  id="tdtitulogris" colspan="2" align="center"><input type="submit" name="almacenar" value="Guardar Modificar">
                          <input type="button" name="Regresar" value="Regresar" onclick="window.location.href='ingresoestrategiaperiodo.php'">
                      <?php if($totalRows_estrategiasem!=""){ ?>
                          <input type="submit" name="anular" value="Anular">
                          <?php } ?>
                      </TD>
                  </TR>
                   <input type="hidden" name="estrategiasem" value="<?php echo $row_estrategiasem['idestrategiaperiodo']; ?>">
                   <input type="hidden" name="codigocarrera" value="<?php echo $codigocarrera; ?>">
                   <input type="hidden" name="codigoperiodo" value="<?php echo $codigoperiodo; ?>">
                   <input type="hidden" name="semestre" value="<?php echo $semestre; ?>">
                </table>

         <?php
         if(isset($_REQUEST['almacenar'])){
             if(isset($_POST['estrategia']) && $_POST['estrategia']==''){
                 echo '<script language="JavaScript">alert("Debe Digitar la Estrategia Semestral.")</script>';
                 $varguardar = 1;
             }
             elseif(isset($_POST['observacion']) && $_POST['observacion']==''){
                 echo '<script language="JavaScript">alert("Debe Digitar la Observación Semestral.")</script>';
                 $varguardar = 1;
             }
             elseif($varguardar == 0) {
                if($_POST['estrategiasem']==""){                    
                    $query_insertaestrategia = "INSERT INTO estrategiaperiodo (idestrategiaperiodo, codigocarrera,
                    codigoperiodo, semestre, estrategiaperiodo, observacionestrategiaperiodo, fechaestrategiaperiodo, codigoestado)
                    values (0,'".$_POST['codigocarrera']."','".$_POST['codigoperiodo']."','".$_POST['semestre']."','".$_POST['estrategia']."',
                    '".$_POST['observacion']."','$fechahoy', '100')";
                    $insertaestrategia = $db->Execute ($query_insertaestrategia);
                    echo '<script language="JavaScript">alert("Se ha guardado la información correctamente.");
                        window.location.href="ingresoestrategiaperiodo.php"</script>';
                }
                else{
                    $query_actualizar = "UPDATE estrategiaperiodo SET estrategiaperiodo = '".$_POST['estrategia']."'
                    , observacionestrategiaperiodo='".$_POST['observacion']."'
                    where idestrategiaperiodo = '".$_POST['estrategiasem']."'";
                    $actualizar = $db->Execute ($query_actualizar);
                     echo '<script language="JavaScript">alert("Se ha actualizado la información correctamente.");
                        window.location.href="ingresoestrategiaperiodo.php"</script>';
                }
             }
         }
         if(isset($_REQUEST['anular'])){
             $query_anular= "UPDATE estrategiaperiodo SET codigoestado= '200'
                    where idestrategiaperiodo = '".$_POST['estrategiasem']."'";
                    $anular= $db->Execute ($query_anular);
                     echo '<script language="JavaScript">alert("Ha Anulado las estrategias y observaciones del periodo.");
                        window.location.href="ingresoestrategiaperiodo.php"</script>';
         }
         ?>
</form>
  </body>
</html>

