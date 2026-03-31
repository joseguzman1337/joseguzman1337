<?php
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
$rutaPHP="../../sic/librerias/php/";
require_once( realpath(dirname(__FILE__)).'/../../sic/aplicaciones/textogeneral/modelo/textogeneral.php');
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}
$codigocarrera = $_SESSION['codigofacultad'];
$itemsic = new textogeneral($_REQUEST['iditemsic']);
$fechahoy=date("Y-m-d H:i:s");
$varguardar = 0;
$varanular = 0;
?>
<script LANGUAGE="JavaScript">
function cambiaestado(mensaje,iditemsic){

var imagen = window.parent.document.getElementById("img" + iditemsic);

    if(mensaje == 'insertado')
    {
        alert("El valor fue insertado satisfactoriamente");
        //if(imagen.src == "imagenes/noiniciado.gif")
            imagen.src="imagenes/poraprobar.gif";
    }
    else if(mensaje == 'actualizado')
    {
        alert("El valor fue actualizado satisfactoriamente");
        if(imagen.src == "imagenes/aprobado.gif")
            alert("ADVERTENCIA: El item ha quedado por aprobar debido a la modificación hecha");
       imagen.src= "imagenes/poraprobar.gif";
    }
    else if(mensaje != '')
    {
        alert("ERROR:" + mensaje);
    }

}
</script>
<?php
if (isset($_POST['anular'])) {
        if ($varanular==0){
            if (isset($_REQUEST['idcontrato'])){
                echo "<script language='javascript'> alert('Se ha Anulado el contrato'); window.location.href = 'lista_contrato.php' </script>";
                $query_actualizar = "UPDATE contrato SET codigoestado = 200 where idcontrato = '{$_REQUEST['idcontrato']}'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            }

        }
}
?>
<?php
  if (isset($_POST['grabar'])) {
    if ($_POST['codigotipocontratosec']== 0){
                  echo '<script language="JavaScript">alert("Debe Seleccionar el Tipo de contrato")</script>';
                    $varguardar = 1;
              }
        elseif ($_POST['objetivocontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Objetivo")</script>';
                    $varguardar = 1;
              }
        elseif ($_POST['nombreentidadcontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Nombre de la Entidad ")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['representanteentidadcontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Representante de la Entidad ")</script>';
                $varguardar = 1;
                }
       elseif ($_POST['contraprestacioncontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar la Contraprestación")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechainiciovigenciacontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Inicio de la Vigencia")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechafinvigenciacontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Finalización de la Vigencia")</script>';
                $varguardar = 1;
                }
        /*elseif ($_POST['polizacontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar la Póliza")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechapublicacioncontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Publicación")</script>';
                $varguardar = 1;
              }
        elseif ($_POST['mediopublicacioncontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Medio de Publicación")</script>';
                $varguardar = 1;
              }*/
        elseif ($_POST['responsablecontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Responsable del Seguimiento")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['supervisorcontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Supervisor del Contrato")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['renovacioncontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Tipo de Renovación")</script>';
                $varguardar = 1;
                }
        /*elseif ($_POST['modalidadacademica'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Modalidad Académica")</script>';
              $varguardar = 1;
              }
        elseif ($_POST['codigocarrera'] == 0) {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Carrera")</script>';
              $varguardar = 1;
              }*/

        elseif ($varguardar == 0) {
                if (isset($_REQUEST['idcontrato'])){

           $query_actualizar = "UPDATE contrato SET codigotipocontratosec='".$_POST['codigotipocontratosec']."',
           objetivocontrato='".$_POST['objetivocontrato']."',  nombreentidadcontrato='".$_POST['nombreentidadcontrato']."',
           representanteentidadcontrato='".$_POST['representanteentidadcontrato']."', contraprestacioncontrato='".$_POST['contraprestacioncontrato']."',
           fechainiciovigenciacontrato='".$_POST['fechainiciovigenciacontrato']."', fechafinvigenciacontrato='".$_POST['fechafinvigenciacontrato']."',
           polizacontrato='".$_POST['polizacontrato']."', fechapublicacioncontrato='".$_POST['fechapublicacioncontrato']."',
           mediopublicacioncontrato='".$_POST['mediopublicacioncontrato']."', responsablecontrato='".$_POST['responsablecontrato']."',
           supervisorcontrato='".$_POST['supervisorcontrato']."', renovacioncontrato='".$_POST['renovacioncontrato']."',
           codigoestado = 100
           where idcontrato = '{$_REQUEST['idcontrato']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";

            }
            else {
            $query_guardar = "INSERT INTO contrato (idcontrato, codigotipocontratosec, objetivocontrato, nombreentidadcontrato,
            representanteentidadcontrato, contraprestacioncontrato, fechainiciovigenciacontrato,
            fechafinvigenciacontrato, polizacontrato, fechapublicacioncontrato, mediopublicacioncontrato,
            responsablecontrato, supervisorcontrato, renovacioncontrato, codigoestado)
            values (0, '{$_POST['codigotipocontratosec']}','{$_POST['objetivocontrato']}',
            '{$_POST['nombreentidadcontrato']}','{$_POST['representanteentidadcontrato']}',
            '{$_POST['contraprestacioncontrato']}','{$_POST['fechainiciovigenciacontrato']}',
            '{$_POST['fechafinvigenciacontrato']}','{$_POST['polizacontrato']}',
            '{$_POST['fechapublicacioncontrato']}','{$_POST['mediopublicacioncontrato']}',
            '{$_POST['responsablecontrato']}','{$_POST['supervisorcontrato']}',
            '{$_POST['renovacioncontrato']}', 100)";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            $_REQUEST['idcontrato'] = $db->Insert_ID();
            echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  </script>";

            }
            //$db->debug = true;
            $mensaje = $itemsic->insertarItemsiccarrera();
echo "<script type='text/javascript'>
        cambiaestado('".$mensaje."',".$_REQUEST['iditemsic'].");
    </script>";
         }
  }
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
    <INPUT type="hidden" name="iditemsic" value="<?php echo $_REQUEST['iditemsic'];?>">
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR id="trgris">
           <TD align="center"><label id="labelresaltadogrande">MANTENIMIENTO DE CONTRATOS</label></TD>
          </TR>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltado"><?php if(isset ($_REQUEST['idcontrato'])){
            $query_nomcontrato = "select nombreentidadcontrato from contrato where idcontrato = '".$_REQUEST['idcontrato']."'";
                $nomcontrato= $db->Execute($query_nomcontrato);
                $totalRows_nomcontrato = $nomcontrato->RecordCount();
                $row_nomcontrato = $nomcontrato->FetchRow();
                echo $row_nomcontrato['nombreentidadcontrato'];
                 }
             ?>
            </label></TD>
         </TR>
    </table>
        <?php


        $query_contrato ="SELECT c.objetivocontrato, c.nombreentidadcontrato, c.representanteentidadcontrato, 
            c.contraprestacioncontrato, c.fechainiciovigenciacontrato, c.fechafinvigenciacontrato,
            c.polizacontrato, c.fechapublicacioncontrato, c.mediopublicacioncontrato, c.responsablecontrato,
            c.renovacioncontrato, c.supervisorcontrato, tc.codigotipocontratosec, tc.nombretipocontratosec
            FROM contrato c, tipocontratosec tc
        where
        tc.codigotipocontratosec =c.codigotipocontratosec
        and c.idcontrato = '".$_REQUEST['idcontrato']."'";
                $contrato= $db->Execute($query_contrato);
                $totalRows_contrato = $contrato->RecordCount();
                $row_contrato = $contrato->FetchRow();

          $query_codigotipocontratosec ="SELECT codigotipocontratosec, nombretipocontratosec from tipocontratosec where codigoestado like '1%' order by 2 ";
                $codigotipocontratosec= $db->Execute($query_codigotipocontratosec);
                $totalRows_codigotipocontratosec = $codigotipocontratosec->RecordCount();
        ?>

            <TABLE width="50%"  border="1" align="center">
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Tipo de contrato<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigotipocontratosec" id="codigotipocontratosec">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigotipocontratosec = $codigotipocontratosec->FetchRow()){?>
                            <option value="<?php echo $row_codigotipocontratosec['codigotipocontratosec'];?>"
                                <?php
                                 if($row_codigotipocontratosec['codigotipocontratosec']==$_POST['codigotipocontratosec']) {
                                echo "Selected";
                                 }
                                else if($row_contrato['codigotipocontratosec']==$row_codigotipocontratosec['codigotipocontratosec'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigotipocontratosec['nombretipocontratosec'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>

                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Objetivo<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['objetivocontrato']==$_POST['objetivocontrato'];?>
                        <TEXTAREA name="objetivocontrato" id="objetivocontrato" cols="45" rows="3"><?php echo $row_contrato['objetivocontrato']; ?></TEXTAREA>
                        <?php
                         }
                         else {?>
                         <TEXTAREA name="objetivocontrato" id="objetivocontrato" cols="45" rows="3"><?php if ($_POST['objetivocontrato']!=""){
                        echo $_POST['objetivocontrato']; } ?></TEXTAREA>
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>

                <tr align="left" >
                    <td rowspan="2" width="30%" id="tdtitulogris"><div align="left">Entidad</div>
                    </td>
                    <td id="tdtitulogris">Nombre Entidad<label  id="labelasterisco">*</label>
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['nombreentidadcontrato']==$_POST['nombreentidadcontrato'];?>
                        <INPUT type="text" name="nombreentidadcontrato" id="nombreentidadcontrato" size="40px" value="<?php echo $row_contrato['nombreentidadcontrato']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="nombreentidadcontrato" id="nombreentidadcontrato" size="40px" value="<?php if ($_POST['nombreentidadcontrato']!=""){
                        echo $_POST['nombreentidadcontrato']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Representante Legal<label  id="labelasterisco">*</label>
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['representanteentidadcontrato']==$_POST['representanteentidadcontrato'];?>
                        <INPUT type="text" name="representanteentidadcontrato" id="representanteentidadcontrato" size="40px" value="<?php echo $row_contrato['representanteentidadcontrato']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" align="left" name="representanteentidadcontrato" id="representanteentidadcontrato" size="40px" value="<?php if ($_POST['representanteentidadcontrato']!=""){
                        echo $_POST['representanteentidadcontrato']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>

                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Contraprestación<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['contraprestacioncontrato']==$_POST['contraprestacioncontrato'];?>
                        <TEXTAREA name="contraprestacioncontrato" id="contraprestacioncontrato" cols="45" rows="3"><?php echo $row_contrato['contraprestacioncontrato']; ?></TEXTAREA>
                        <?php
                         }
                         else {?>
                        <TEXTAREA name="contraprestacioncontrato" id="contraprestacioncontrato" cols="45" rows="3"><?php if ($_POST['contraprestacioncontrato']!=""){
                        echo $_POST['contraprestacioncontrato']; } ?></TEXTAREA>
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>

                <tr align="left" >
                    <td rowspan="2" width="30%" id="tdtitulogris"><div align="left">Vigencia</div>
                    </td>
                    <td id="tdtitulogris">Fecha Inicio Vigencia<label  id="labelasterisco">*</label>
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['fechainiciovigenciacontrato']==$_POST['fechainiciovigenciacontrato'];
                        ?>
                        <INPUT type="text" name="fechainiciovigenciacontrato" id="fechainiciovigenciacontrato"  value="<?php echo $row_contrato['fechainiciovigenciacontrato'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainiciovigenciacontrato",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechainiciovigenciacontrato" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                            }
                       else {
                        ?>
                        <INPUT type="text" name="fechainiciovigenciacontrato" id="fechainiciovigenciacontrato"  value="<?php if ($_POST['fechainiciovigenciacontrato']!=""){ echo $_POST['fechainiciovigenciacontrato']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                            <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainiciovigenciacontrato",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechainiciovigenciacontrato" // ID of the button
                                  }
                                 );
                        </script>
                        <?php } ?>

                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td id="tdtitulogris">Fecha Finalización Vigencia<label  id="labelasterisco">*</label>
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['fechafinvigenciacontrato']==$_POST['fechafinvigenciacontrato'];
                        ?>
                        <INPUT type="text" name="fechafinvigenciacontrato" id="fechafinvigenciacontrato"  value="<?php echo $row_contrato['fechafinvigenciacontrato'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechafinvigenciacontrato",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechafinvigenciacontrato" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                          }
                          else {
                           ?>
                          <INPUT type="text" name="fechafinvigenciacontrato" id="fechafinvigenciacontrato"  value="<?php if ($_POST['fechafinvigenciacontrato']!=""){ echo $_POST['fechafinvigenciacontrato']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechafinvigenciacontrato",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechafinvigenciacontrato" // ID of the button
                                  }
                                 );
                        </script>
                          <?php } ?>
                        </div>
                    </td>
                </tr>

                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Pólizas</div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['polizacontrato']==$_POST['polizacontrato'];?>
                        <INPUT type="text" name="polizacontrato" id="polizacontrato" size="40px" value="<?php echo $row_contrato['polizacontrato']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="polizacontrato" id="polizacontrato" size="40px" value="<?php if ($_POST['polizacontrato']!=""){
                        echo $_POST['polizacontrato']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>

                <tr align="left" >
                    <td rowspan="2" width="30%" id="tdtitulogris"><div align="left">Publicación</div>
                    </td>
                    <td id="tdtitulogris">Fecha Publicación
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['fechapublicacioncontrato']==$_POST['fechapublicacioncontrato'];
                        ?>
                        <INPUT type="text" name="fechapublicacioncontrato" id="fechapublicacioncontrato"  value="<?php echo $row_contrato['fechapublicacioncontrato'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechapublicacioncontrato",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechapublicacioncontrato" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                            }
                       else {
                        ?>
                        <INPUT type="text" name="fechapublicacioncontrato" id="fechapublicacioncontrato"  value="<?php if ($_POST['fechapublicacioncontrato']!=""){ echo $_POST['fechapublicacioncontrato']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                            <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechapublicacioncontrato",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechapublicacioncontrato" // ID of the button
                                  }
                                 );
                        </script>
                        <?php } ?>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Medio de Publicación
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['mediopublicacioncontrato']==$_POST['mediopublicacioncontrato'];?>
                        <INPUT type="text" name="mediopublicacioncontrato" id="mediopublicacioncontrato" size="40px" value="<?php echo $row_contrato['mediopublicacioncontrato']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" align="left" name="mediopublicacioncontrato" id="mediopublicacioncontrato" size="40px" value="<?php if ($_POST['mediopublicacioncontrato']!=""){
                        echo $_POST['mediopublicacioncontrato']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Responsable de Seguimiento<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['responsablecontrato']==$_POST['responsablecontrato'];?>
                        <INPUT type="text" name="responsablecontrato" id="responsablecontrato" size="40px" value="<?php echo $row_contrato['responsablecontrato']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="responsablecontrato" id="responsablecontrato" size="40px" value="<?php if ($_POST['responsablecontrato']!=""){
                        echo $_POST['responsablecontrato']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Supervisor Contrato<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['supervisorcontrato']==$_POST['supervisorcontrato'];?>
                        <INPUT type="text" name="supervisorcontrato" id="supervisorcontrato" size="40px" value="<?php echo $row_contrato['supervisorcontrato']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="supervisorcontrato" id="supervisorcontrato" size="40px" value="<?php if ($_POST['supervisorcontrato']!=""){
                        echo $_POST['supervisorcontrato']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Tipo de Renovación<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idcontrato'])){
                        $row_contrato['renovacioncontrato']==$_POST['renovacioncontrato'];?>
                        <INPUT type="text" name="renovacioncontrato" id="renovacioncontrato" size="40px" value="<?php echo $row_contrato['renovacioncontrato']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="renovacioncontrato" id="renovacioncontrato" size="40px" value="<?php if ($_POST['renovacioncontrato']!=""){
                        echo $_POST['renovacioncontrato']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
            
            <script language="javascript">
                function guardar()
                {
                    document.form1.submit();
                }
            </script>
            <?php
                        if (isset($_REQUEST['idcontrato'])){ ?>
             
            <TR align="left">
                <td  id="tdtitulogris">Novedades
                </td>
                <TD >
                    <INPUT type="button" name="novedad" value="Novedades contrato" onClick="window.location.href='lista_novedades_contrato.php?idcontrato=<?php echo $_REQUEST['idcontrato']."&iditemsic=".$_REQUEST['iditemsic']; ?>'">
                </TD>
            </TR>
            <?php } ?>
             <TR align="left">
                <TD id="tdtitulogris" colspan="2" rowspan="2" align="center">
                <INPUT type="submit" value="Guardar" name="grabar">
<?php

                    if (isset($_REQUEST['idcontrato'])){
                ?>
                <input type="hidden" name="idcontrato" value="<?php echo $_REQUEST['idcontrato']; ?>">
                    <?php
                    }
                    ?>
                <INPUT type="button" value="Regresar" onClick="window.location.href='lista_contrato.php'">

                    <?php if (isset($_REQUEST['idcontrato'])){ ?>
                        <INPUT type="submit" value="Anular contrato" name="anular">
                    <?php } ?>
                </TD>
              </TR>
        </TABLE>
</form>
</body>
</html>