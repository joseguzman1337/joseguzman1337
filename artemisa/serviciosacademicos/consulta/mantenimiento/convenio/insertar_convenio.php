<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$rutaPHP="../../sic/librerias/php/";
require_once( '../../sic/aplicaciones/textogeneral/modelo/textogeneral.php');
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
            if (isset($_REQUEST['idconvenio'])){
                echo "<script language='javascript'> alert('Se ha Anulado el Convenio'); window.location.href = 'lista_convenio.php' </script>";
                $query_actualizar = "UPDATE convenio SET codigoestado = 200 where idconvenio = '{$_REQUEST['idconvenio']}'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            }

        }
}
?>
<?php
  if (isset($_POST['grabar'])) {
    if ($_POST['codigotipoconvenio']== 0){
                  echo '<script language="JavaScript">alert("Debe Seleccionar el Tipo de Convenio")</script>';
                    $varguardar = 1;
              }
        elseif ($_POST['objetivoconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Objetivo")</script>';
                    $varguardar = 1;
              }
        elseif ($_POST['nombreentidadconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Nombre de la Entidad ")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['representanteentidadconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Representante de la Entidad ")</script>';
                $varguardar = 1;
                }
       elseif ($_POST['contraprestacionconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar la Contraprestación")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechainiciovigenciaconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Inicio de la Vigencia")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechafinvigenciaconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Finalización de la Vigencia")</script>';
                $varguardar = 1;
                }
        /*elseif ($_POST['polizaconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar la Póliza")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechapublicacionconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Publicación")</script>';
                $varguardar = 1;
              }
        elseif ($_POST['mediopublicacionconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Medio de Publicación")</script>';
                $varguardar = 1;
              }*/
        elseif ($_POST['responsableconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Responsable del Seguimiento")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['renovacionconvenio'] == "") {
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
                if (isset($_REQUEST['idconvenio'])){

           $query_actualizar = "UPDATE convenio SET codigotipoconvenio='".$_POST['codigotipoconvenio']."', objetivoconvenio='".$_POST['objetivoconvenio']."',  nombreentidadconvenio='".$_POST['nombreentidadconvenio']."',representanteentidadconvenio='".$_POST['representanteentidadconvenio']."', contraprestacionconvenio='".$_POST['contraprestacionconvenio']."', fechainiciovigenciaconvenio='".$_POST['fechainiciovigenciaconvenio']."', fechafinvigenciaconvenio='".$_POST['fechafinvigenciaconvenio']."', polizaconvenio='".$_POST['polizaconvenio']."', fechapublicacionconvenio='".$_POST['fechapublicacionconvenio']."', mediopublicacionconvenio='".$_POST['mediopublicacionconvenio']."', responsableconvenio='".$_POST['responsableconvenio']."',  renovacionconvenio='".$_POST['renovacionconvenio']."', codigoestado = 100
           where idconvenio = '{$_REQUEST['idconvenio']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";

            }
            else {
            $query_guardar = "INSERT INTO convenio (idconvenio, codigotipoconvenio, objetivoconvenio, nombreentidadconvenio, representanteentidadconvenio, contraprestacionconvenio, fechainiciovigenciaconvenio, fechafinvigenciaconvenio, polizaconvenio, fechapublicacionconvenio, mediopublicacionconvenio, responsableconvenio, renovacionconvenio, codigoestado) values (0, '{$_POST['codigotipoconvenio']}','{$_POST['objetivoconvenio']}','{$_POST['nombreentidadconvenio']}','{$_POST['representanteentidadconvenio']}','{$_POST['contraprestacionconvenio']}','{$_POST['fechainiciovigenciaconvenio']}','{$_POST['fechafinvigenciaconvenio']}','{$_POST['polizaconvenio']}','{$_POST['fechapublicacionconvenio']}','{$_POST['mediopublicacionconvenio']}','{$_POST['responsableconvenio']}','{$_POST['renovacionconvenio']}', 100)";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            $_REQUEST['idconvenio'] = $db->Insert_ID();
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
           <TD align="center"><label id="labelresaltadogrande">MANTENIMIENTO DE CONVENIOS</label></TD>
          </TR>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltado"><?php if(isset ($_REQUEST['idconvenio'])){
            $query_nomconvenio = "select nombreentidadconvenio from convenio where idconvenio = '".$_REQUEST['idconvenio']."'";
                $nomconvenio= $db->Execute($query_nomconvenio);
                $totalRows_nomconvenio = $nomconvenio->RecordCount();
                $row_nomconvenio = $nomconvenio->FetchRow();
                echo $row_nomconvenio['nombreentidadconvenio'];
                 }
             ?>
            </label></TD>
         </TR>
    </table>
        <?php


        $query_convenio ="SELECT c.objetivoconvenio, c.nombreentidadconvenio, c.representanteentidadconvenio, c.contraprestacionconvenio, c.fechainiciovigenciaconvenio, c.fechafinvigenciaconvenio, c.polizaconvenio, c.fechapublicacionconvenio, c.mediopublicacionconvenio, c.responsableconvenio, c.renovacionconvenio, tc.codigotipoconvenio, tc.nombretipoconvenio FROM convenio c, tipoconvenio tc
        where
        tc.codigotipoconvenio =c.codigotipoconvenio
        and c.idconvenio = '".$_REQUEST['idconvenio']."'";
                $convenio= $db->Execute($query_convenio);
                $totalRows_convenio = $convenio->RecordCount();
                $row_convenio = $convenio->FetchRow();

          $query_codigotipoconvenio ="SELECT codigotipoconvenio, nombretipoconvenio from tipoconvenio where codigoestado like '1%' ";
                $codigotipoconvenio= $db->Execute($query_codigotipoconvenio);
                $totalRows_codigotipoconvenio = $codigotipoconvenio->RecordCount();
        ?>

            <TABLE width="50%"  border="1" align="center">
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Tipo de Convenio<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="codigotipoconvenio" id="codigotipoconvenio">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigotipoconvenio = $codigotipoconvenio->FetchRow()){?>
                            <option value="<?php echo $row_codigotipoconvenio['codigotipoconvenio'];?>"
                                <?php
                                 if($row_codigotipoconvenio['codigotipoconvenio']==$_POST['codigotipoconvenio']) {
                                echo "Selected";
                                 }
                                else if($row_convenio['codigotipoconvenio']==$row_codigotipoconvenio['codigotipoconvenio'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_codigotipoconvenio['nombretipoconvenio'];?>
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['objetivoconvenio']==$_POST['objetivoconvenio'];?>
                        <TEXTAREA name="objetivoconvenio" id="objetivoconvenio" cols="45" rows="3"><?php echo $row_convenio['objetivoconvenio']; ?></TEXTAREA>                        
                        <?php
                         }
                         else {?>
                         <TEXTAREA name="objetivoconvenio" id="objetivoconvenio" cols="45" rows="3"><?php if ($_POST['objetivoconvenio']!=""){
                        echo $_POST['objetivoconvenio']; } ?></TEXTAREA>                        
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['nombreentidadconvenio']==$_POST['nombreentidadconvenio'];?>
                        <INPUT type="text" name="nombreentidadconvenio" id="nombreentidadconvenio" size="40px" value="<?php echo $row_convenio['nombreentidadconvenio']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="nombreentidadconvenio" id="nombreentidadconvenio" size="40px" value="<?php if ($_POST['nombreentidadconvenio']!=""){
                        echo $_POST['nombreentidadconvenio']; } ?>">
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Representante Legal<label  id="labelasterisco">*</label>
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['representanteentidadconvenio']==$_POST['representanteentidadconvenio'];?>
                        <INPUT type="text" name="representanteentidadconvenio" id="representanteentidadconvenio" size="40px" value="<?php echo $row_convenio['representanteentidadconvenio']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" align="left" name="representanteentidadconvenio" id="representanteentidadconvenio" size="40px" value="<?php if ($_POST['representanteentidadconvenio']!=""){
                        echo $_POST['representanteentidadconvenio']; } ?>">
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['contraprestacionconvenio']==$_POST['contraprestacionconvenio'];?>
                        <TEXTAREA name="contraprestacionconvenio" id="contraprestacionconvenio" cols="45" rows="3"><?php echo $row_convenio['contraprestacionconvenio']; ?></TEXTAREA>    
                        <?php
                         }
                         else {?>
                        <TEXTAREA name="contraprestacionconvenio" id="contraprestacionconvenio" cols="45" rows="3"><?php if ($_POST['contraprestacionconvenio']!=""){
                        echo $_POST['contraprestacionconvenio']; } ?></TEXTAREA>                        
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['fechainiciovigenciaconvenio']==$_POST['fechainiciovigenciaconvenio'];
                        ?>
                        <INPUT type="text" name="fechainiciovigenciaconvenio" id="fechainiciovigenciaconvenio"  value="<?php echo $row_convenio['fechainiciovigenciaconvenio'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainiciovigenciaconvenio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechainiciovigenciaconvenio" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                            }
                       else {
                        ?>
                        <INPUT type="text" name="fechainiciovigenciaconvenio" id="fechainiciovigenciaconvenio"  value="<?php if ($_POST['fechainiciovigenciaconvenio']!=""){ echo $_POST['fechainiciovigenciaconvenio']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                            <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainiciovigenciaconvenio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechainiciovigenciaconvenio" // ID of the button
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['fechafinvigenciaconvenio']==$_POST['fechafinvigenciaconvenio'];
                        ?>
                        <INPUT type="text" name="fechafinvigenciaconvenio" id="fechafinvigenciaconvenio"  value="<?php echo $row_convenio['fechafinvigenciaconvenio'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechafinvigenciaconvenio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechafinvigenciaconvenio" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                          }
                          else {
                           ?>
                          <INPUT type="text" name="fechafinvigenciaconvenio" id="fechafinvigenciaconvenio"  value="<?php if ($_POST['fechafinvigenciaconvenio']!=""){ echo $_POST['fechafinvigenciaconvenio']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechafinvigenciaconvenio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechafinvigenciaconvenio" // ID of the button
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['polizaconvenio']==$_POST['polizaconvenio'];?>
                        <INPUT type="text" name="polizaconvenio" id="polizaconvenio" size="40px" value="<?php echo $row_convenio['polizaconvenio']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="polizaconvenio" id="polizaconvenio" size="40px" value="<?php if ($_POST['polizaconvenio']!=""){
                        echo $_POST['polizaconvenio']; } ?>">
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['fechapublicacionconvenio']==$_POST['fechapublicacionconvenio'];
                        ?>
                        <INPUT type="text" name="fechapublicacionconvenio" id="fechapublicacionconvenio"  value="<?php echo $row_convenio['fechapublicacionconvenio'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechapublicacionconvenio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechapublicacionconvenio" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                            }
                       else {
                        ?>
                        <INPUT type="text" name="fechapublicacionconvenio" id="fechapublicacionconvenio"  value="<?php if ($_POST['fechapublicacionconvenio']!=""){ echo $_POST['fechapublicacionconvenio']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                            <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechapublicacionconvenio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechapublicacionconvenio" // ID of the button
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['mediopublicacionconvenio']==$_POST['mediopublicacionconvenio'];?>
                        <INPUT type="text" name="mediopublicacionconvenio" id="mediopublicacionconvenio" size="40px" value="<?php echo $row_convenio['mediopublicacionconvenio']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" align="left" name="mediopublicacionconvenio" id="mediopublicacionconvenio" size="40px" value="<?php if ($_POST['mediopublicacionconvenio']!=""){
                        echo $_POST['mediopublicacionconvenio']; } ?>">
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['responsableconvenio']==$_POST['responsableconvenio'];?>
                        <INPUT type="text" name="responsableconvenio" id="responsableconvenio" size="40px" value="<?php echo $row_convenio['responsableconvenio']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="responsableconvenio" id="responsableconvenio" size="40px" value="<?php if ($_POST['responsableconvenio']!=""){
                        echo $_POST['responsableconvenio']; } ?>">
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
                        if (isset($_REQUEST['idconvenio'])){
                        $row_convenio['renovacionconvenio']==$_POST['renovacionconvenio'];?>
                        <INPUT type="text" name="renovacionconvenio" id="renovacionconvenio" size="40px" value="<?php echo $row_convenio['renovacionconvenio']; ?>">
                        <?php
                         }
                         else {?>
                        <INPUT type="text" name="renovacionconvenio" id="renovacionconvenio" size="40px" value="<?php if ($_POST['renovacionconvenio']!=""){
                        echo $_POST['renovacionconvenio']; } ?>">
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
                        if (isset($_REQUEST['idconvenio'])){ ?>
             <TR align="left">
                <td  id="tdtitulogris">Selección de Programa
                </td>
                <TD >
                    <div align="justify"><INPUT type="button" name="otracarrera" value="Asociar Programas" onClick="window.location.href='convenio_carrera.php?idconvenio=<?php echo $_REQUEST['idconvenio']; ?>'">
                      
                    </div>        
                </TD>
            </TR>
            <TR align="left">
                <td  id="tdtitulogris">Novedades
                </td>
                <TD >
                    <INPUT type="button" name="novedad" value="Novedades Convenio" onClick="window.location.href='lista_novedades_convenio.php?idconvenio=<?php echo $_REQUEST['idconvenio']."&iditemsic=".$_REQUEST['iditemsic']; ?>'">                   
                </TD>
            </TR>
            <?php } ?>
             <TR align="left">
                <TD id="tdtitulogris" colspan="2" rowspan="2" align="center">
                <INPUT type="submit" value="Guardar" name="grabar">
<?php

                    if (isset($_REQUEST['idconvenio'])){
                ?>
                <input type="hidden" name="idconvenio" value="<?php echo $_REQUEST['idconvenio']; ?>">
                    <?php
                    }
                    ?>
                <INPUT type="button" value="Regresar" onClick="window.location.href='lista_convenio.php'">

                    <?php if (isset($_REQUEST['idconvenio'])){ ?>
                        <INPUT type="submit" value="Anular Convenio" name="anular">
                    <?php } ?>
                </TD>
              </TR>
        </TABLE>
</form>
</body>
</html>