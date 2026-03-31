<?php
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
//$codigocarrera = $_SESSION['codigofacultad'];
$fechahoy=date("Y-m-d H:i:s");
$varguardar = 0;
?>
<script language="javascript">
    function cambio()
        {
            document.form1.submit();
        }
</script>

<?php
  if (isset($_POST['grabar'])) {

      if ((!isset($_REQUEST['idcohorte'])) && $_POST['codigomodalidadacademica'] == 0) {
                echo '<script language="JavaScript">alert("Debe Seleccionar la Modalidad Académica")</script>';
                    $varguardar = 1;
              }
      elseif ((!isset($_REQUEST['idcohorte'])) && $_POST['codigocarrera'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Carrera ")</script>';
                $varguardar = 1;
                }

       elseif ($_POST['numerocohorte'] == "" || !is_numeric($_POST['numerocohorte']) || $_POST['numerocohorte'] <0) {
            echo '<script language="JavaScript">alert("Debe Digitar el Nº de Cohorte, el dato debe ser Numérico y no debe ser menor a Cero")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['periodoinicial'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Periodo Inicial")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['periodofinal'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar el Periodo Final")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['codigojornada'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Jornada")</script>';
                $varguardar = 1;
                }

        elseif ($varguardar == 0) {
                if (isset($_REQUEST['idcohorte'])){

           $query_actualizar = "UPDATE cohorte SET codigoperiodoinicial='".$_POST['periodoinicial']."',
           codigoperiodofinal='".$_POST['periodofinal']."',
           codigojornada='".$_POST['codigojornada']."'
           where idcohorte = '{$_REQUEST['idcohorte']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
                }

            else {

            $query_guardar = "INSERT INTO cohorte (idcohorte, numerocohorte, codigocarrera, codigoperiodo, codigoestadocohorte, codigoperiodoinicial, codigoperiodofinal, codigojornada) values (0, '{$_POST['numerocohorte']}','{$_POST['codigocarrera']}','{$_REQUEST['codigoperiodo']}','01', '{$_POST['periodoinicial']}','{$_POST['periodofinal']}','{$_POST['codigojornada']}')";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            $_REQUEST['idcohorte'] = $db->Insert_ID();
            echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  </script>";
                    }
             }
  }

$query_datos ="SELECT ch.idcohorte, ch.numerocohorte, c.nombrecarrera, ch.codigoperiodo, ec.nombreestadocohorte, ch.codigoperiodoinicial, ch.codigoperiodofinal, ch.codigojornada, j.nombrejornada
FROM
cohorte ch, carrera c, estadocohorte ec, jornada j
WHERE
ch.codigocarrera=c.codigocarrera
AND ch.codigoestadocohorte=ec.codigoestadocohorte
and ch.codigoestadocohorte='01'
and ch.codigojornada=j.codigojornada
and ch.idcohorte = '".$_REQUEST['idcohorte']."'
order by c.nombrecarrera asc, ch.numerocohorte asc";
$datos= $db->Execute($query_datos);
$totalRows_datos = $datos->RecordCount();
$row_datos = $datos->FetchRow();

?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
function cambiar()
{
    document.form1.submit();
}
</SCRIPT>
</head>
    <body>
<form name="form1" id="form1"  method="POST">
    <INPUT type="hidden" name="codigocarrera" value="<?php echo $_REQUEST['codigocarrera'];?>">
    <INPUT type="hidden" name="codigoperiodo" value="<?php echo $_REQUEST['codigoperiodo'];?>">
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR id="trgris">
           <TD align="center"><label id="labelresaltadogrande">Edición e Ingreso de Cohortes</label></TD>
          </TR>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltado"><?php if(isset ($_REQUEST['idcohorte'])){

                echo $row_datos['nombrecarrera'];
                 }
             ?>
            </label></TD>
         </TR>
    </table>

                <?php
                $query_modalidadacademica = "SELECT codigomodalidadacademica, nombremodalidadacademica from modalidadacademica where codigoestado=100";
                $modalidadacademica= $db->Execute($query_modalidadacademica);
                $totalRows_modalidadacademica = $modalidadacademica->RecordCount();


                        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
                        where codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
                        and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera
                        order by nombrecarrera";


                $carrera= $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
              // print_r($_POST);
                ?>

            <TABLE width="50%"  border="1" align="center">
                <?php if (!isset($_REQUEST['idcohorte'])){ ?>

                      <tr>
                    <td width="22%" id="tdtitulogris"><div align="left">Modalidad Académica<label  id="labelasterisco">*</label> </div>
                    </td>
                    <td id="tdtitulogris" >
                        <div align="left">
                            <select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="cambio()">
                            <option value="">
                                Seleccionar
                            </option><?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?><option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                            <?php
                                 if($row_modalidadacademica['codigomodalidadacademica']==$_POST['codigomodalidadacademica']) {
                                echo "Selected";
                                 }?>>
                            <?php echo $row_modalidadacademica['nombremodalidadacademica'];?>
                            </option><?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="22%" id="tdtitulogris"><div align="left">Carrera<label  id="labelasterisco">*</label> </div>
                    </td>
                    <td  id="tdtitulogris"><div align="left">
                            <select name="codigocarrera" id="codigocarrera">
                            <option value="">Seleccionar</option>
                            <?php while ($row_carrera = $carrera->FetchRow()){?><option value="<?php echo $row_carrera['codigocarrera'] ?>"<?php
                                if ($row_carrera['codigocarrera']==$_POST['codigocarrera']) {
                                echo "Selected";
                                $nombrecarrera = $row_carrera['nombrecarrera'];
                                 }?>>
                                <?php echo $row_carrera['nombrecarrera'];
                                ?>

                            </option><?php };?>
                            </select>
                      </div>
                    </td>
                </tr>
                <?php }
                ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">No. Cohorte<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcohorte'])){
                        $row_datos['numerocohorte']==$_POST['numerocohorte'];?>
                        <INPUT type="text" name="numerocohorte" id="numerocohorte" size="10px" readonly="true" value="<?php echo $row_datos['numerocohorte']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="numerocohorte" id="numerocohorte" size="10px"  value="<?php if ($_POST['numerocohorte']!=""){
                        echo $_POST['numerocohorte']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>

                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Periodo Cohorte<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        echo $_REQUEST['codigoperiodo'];
                            ?>
                        </div>
                    </td>
                </tr>

          <?php
          $query_periodoinicial ="SELECT codigoperiodo FROM periodo order by codigoperiodo asc";
                $periodoinicial= $db->Execute($query_periodoinicial);
                $totalRows_periodoinicial = $periodoinicial->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Periodo Inicial<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="periodoinicial" id="periodoinicial">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_periodoinicial = $periodoinicial->FetchRow()){?>
                            <option value="<?php echo $row_periodoinicial['codigoperiodo'];?>"
                                <?php
                                 if($row_periodoinicial['codigoperiodo']==$_POST['periodoinicial']) {
                                echo "Selected";
                                 }
                                else if($row_datos['codigoperiodoinicial']==$row_periodoinicial['codigoperiodo'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_periodoinicial['codigoperiodo'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            <?php
          $query_periodofinal ="SELECT codigoperiodo FROM periodo order by codigoperiodo desc";
                $periodofinal= $db->Execute($query_periodofinal);
                $totalRows_periodofinal= $periodofinal->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Periodo Final<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="periodofinal" id="periodofinal">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_periodofinal = $periodofinal->FetchRow()){?>
                            <option value="<?php echo $row_periodofinal['codigoperiodo'];?>"
                                <?php
                                 if($row_periodofinal['codigoperiodo']==$_POST['periodofinal']) {
                                echo "Selected";
                                 }
                                else if($row_datos['codigoperiodofinal']==$row_periodofinal['codigoperiodo'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_periodofinal['codigoperiodo'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>

        <?php
          $query_codigojornada ="SELECT codigojornada, nombrejornada FROM jornada";
                $codigojornada= $db->Execute($query_codigojornada);
                $totalRows_codigojornada = $codigojornada->RecordCount();
          ?>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Jornada<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigojornada" id="codigojornada">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigojornada = $codigojornada->FetchRow()){?>
                            <option value="<?php echo $row_codigojornada['codigojornada'];?>"
                                <?php
                                 if($row_codigojornada['codigojornada']==$_POST['codigojornada']) {
                                echo "Selected";
                                 }
                                else if($row_datos['codigojornada']==$row_codigojornada['codigojornada'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigojornada['nombrejornada'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>



             <TR align="left">
                <TD id="tdtitulogris" colspan="2" rowspan="2" align="center">
                <INPUT type="submit" value="Guardar" name="grabar">
                <?php

                    if (isset($_REQUEST['idcohorte'])){
                ?>
                <input type="hidden" name="idcohorte" value="<?php echo $_REQUEST['idcohorte']; ?>">
                    <?php
                    }
                    ?>
                <INPUT type="button" value="Regresar" onClick="window.location.href='lista.php?codigocarrera=<?php echo $_REQUEST['codigocarrera']."&codigoperiodo=".$_REQUEST['codigoperiodo']; ?>'">
                </TD>
              </TR>
        </TABLE>
</form>
</body>
</html>