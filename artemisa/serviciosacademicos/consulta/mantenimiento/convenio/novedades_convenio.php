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
            if (isset($_REQUEST['idnovedadesconvenio'])){
                echo "<script language='javascript'> alert('Se ha Anulado la Novedad'); window.location.href = 'lista_novedades_convenio.php?idconvenio=".$_REQUEST['idconvenio']."' </script>";
                $query_actualizar = "UPDATE novedadesconvenio SET codigoestado = 200 where idnovedadesconvenio = '{$_REQUEST['idnovedadesconvenio']}'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            }

        }
}
?>
<?php
  if (isset($_POST['grabar'])) {
     if ($_POST['tiponovedad']== 0){
                  echo '<script language="JavaScript">alert("Debe Seleccionar el Tipo de Novedad")</script>';
                    $varguardar = 1;
              }        
        elseif ($_POST['fechainicionovedadesconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Inicio de la Vigencia")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechafinnovedadesconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Finalización de la Vigencia")</script>';
                $varguardar = 1;
                }        
        elseif ($_POST['observacionnovedadesconvenio'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar la observación")</script>';
                $varguardar = 1;
                }       

        elseif ($varguardar == 0) {
            if (isset($_REQUEST['idnovedadesconvenio'])){

                $query_actualizar = "UPDATE novedadesconvenio SET codigotiponovedadesconvenio='".$_POST['tiponovedad']."',  fechainicionovedadesconvenio='".$_POST['fechainicionovedadesconvenio']."', fechafinnovedadesconvenio='".$_POST['fechafinnovedadesconvenio']."',  observacionnovedadesconvenio='".$_POST['observacionnovedadesconvenio']."', codigoestado = 100
                where idnovedadesconvenio = '{$_REQUEST['idnovedadesconvenio']}'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
                echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
    
            }
            else {
                $query_guardar = "INSERT INTO novedadesconvenio (idnovedadesconvenio, idconvenio, codigotiponovedadesconvenio, fechainicionovedadesconvenio, fechafinnovedadesconvenio, observacionnovedadesconvenio, codigoestado) values (0, '{$_REQUEST['idconvenio']}','{$_POST['tiponovedad']}','{$_POST['fechainicionovedadesconvenio']}','{$_POST['fechafinnovedadesconvenio']}','{$_POST['observacionnovedadesconvenio']}', 100)";
                $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
                $_REQUEST['idnovedadesconvenio'] = $db->Insert_ID();
                echo "<script language='javascript'> alert('Se ha guardado la información correctamente');
                 </script>";
    
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
    <input id="idnovedadesconvenio" type="hidden" value="">
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR id="trgris">
           <TD align="center"><label id="labelresaltadogrande">NOVEDADES CONVENIOS</label></TD>
          </TR>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltado"><?php 
            $query_nomconvenio = "select nombreentidadconvenio from convenio where idconvenio = '".$_REQUEST['idconvenio']."'";
                $nomconvenio= $db->Execute($query_nomconvenio);
                $totalRows_nomconvenio = $nomconvenio->RecordCount();
                $row_nomconvenio = $nomconvenio->FetchRow();
                echo $row_nomconvenio['nombreentidadconvenio'];
                
             ?>
            </label></TD>
         </TR>
    </table>
        <?php


        $query_convenio ="SELECT n.fechainicionovedadesconvenio, n.fechafinnovedadesconvenio, n.observacionnovedadesconvenio, n.adjuntonovedadesconvenio, tn.codigotiponovedadesconvenio, tn.nombretiponovedadesconvenio FROM novedadesconvenio n, tiponovedadesconvenio tn
        where
        tn.codigotiponovedadesconvenio =n.codigotiponovedadesconvenio
        and n.idnovedadesconvenio = '".$_REQUEST['idnovedadesconvenio']."'";
                $convenio= $db->Execute($query_convenio);
                $totalRows_convenio = $convenio->RecordCount();
                $row_convenio = $convenio->FetchRow();

          $query_tiponovedad ="SELECT codigotiponovedadesconvenio, nombretiponovedadesconvenio from tiponovedadesconvenio where codigoestado like '1%' order by 2";
                $tiponovedad= $db->Execute($query_tiponovedad);
                $totalRows_tiponovedad = $tiponovedad->RecordCount();
        ?>

            <TABLE width="50%"  border="1" align="center">
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="justify">Tipo Novedad<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                            <select name="tiponovedad" id="tiponovedad">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_tiponovedad = $tiponovedad->FetchRow()){?>
                            <option value="<?php echo $row_tiponovedad['codigotiponovedadesconvenio'];?>"
                                <?php
                                 if($row_tiponovedad['codigotiponovedadesconvenio']==$_POST['tiponovedad']) {
                                echo "Selected";
                                 }
                                else if($row_convenio['codigotiponovedadesconvenio']==$row_tiponovedad['codigotiponovedadesconvenio'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_tiponovedad['nombretiponovedadesconvenio'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
                
                <tr align="left" >
                    <td rowspan="2" width="30%" id="tdtitulogris"><div align="left">Vigencia</div>
                    </td>
                    <td id="tdtitulogris">Fecha Inicio Novedad<label  id="labelasterisco">*</label>
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idnovedadesconvenio'])){
                        $row_convenio['fechainicionovedadesconvenio']==$_POST['fechainicionovedadesconvenio'];
                        ?>
                        <INPUT type="text" name="fechainicionovedadesconvenio" id="fechainicionovedadesconvenio"  value="<?php echo $row_convenio['fechainicionovedadesconvenio'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainicionovedadesconvenio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechainicionovedadesconvenio" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                            }
                       else {
                        ?>
                        <INPUT type="text" name="fechainicionovedadesconvenio" id="fechainicionovedadesconvenio"  value="<?php if ($_POST['fechainicionovedadesconvenio']!=""){ echo $_POST['fechainicionovedadesconvenio']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                            <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainicionovedadesconvenio",         // ID of the input field
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
                    <td id="tdtitulogris">Fecha Finalización Novedad<label  id="labelasterisco">*</label>
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idnovedadesconvenio'])){
                        $row_convenio['fechafinnovedadesconvenio']==$_POST['fechafinnovedadesconvenio'];
                        ?>
                        <INPUT type="text" name="fechafinnovedadesconvenio" id="fechafinnovedadesconvenio"  value="<?php echo $row_convenio['fechafinnovedadesconvenio'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechafinnovedadesconvenio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechafinnovedadesconvenio" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                          }
                          else {
                           ?>
                          <INPUT type="text" name="fechafinnovedadesconvenio" id="fechafinnovedadesconvenio"  value="<?php if ($_POST['fechafinnovedadesconvenio']!=""){ echo $_POST['fechafinnovedadesconvenio']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechafinnovedadesconvenio",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechafinnovedadesconvenio" // ID of the button
                                  }
                                 );
                        </script>
                          <?php } ?>
                        </div>
                    </td>
                </tr>

                <tr align="left" >
                    <td width="30%" id="tdtitulogris">Observaciones<label  id="labelasterisco">*</label>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idnovedadesconvenio'])){
                        $row_convenio['observacionnovedadesconvenio']==$_POST['observacionnovedadesconvenio'];?>
                        <TEXTAREA name="observacionnovedadesconvenio" id="observacionnovedadesconvenio"><?php echo $row_convenio['observacionnovedadesconvenio']; ?></TEXTAREA>           
                        <?php
                         }
                         else {?>
                        <TEXTAREA name="observacionnovedadesconvenio" id="observacionnovedadesconvenio"><?php if ($_POST['observacionnovedadesconvenio']!=""){ echo $_POST['observacionnovedadesconvenio']; } ?></TEXTAREA>                        
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
            
                <TR align="left">
                    <TD id="tdtitulogris" colspan="2" rowspan="2" align="center">
                    <INPUT type="submit" value="Guardar" name="grabar">
                    <?php if (isset($_REQUEST['idnovedadesconvenio'])){ ?>
                        <input type="hidden" name="idnovedadesconvenio" value="<?php echo $_REQUEST['idnovedadesconvenio']; ?>">
                    <?php
                    } ?>
                    <INPUT type="button" value="Regresar" onClick="window.location.href='lista_novedades_convenio.php?idconvenio=<?php echo $_REQUEST['idconvenio']; ?>'">
    
                        <?php if (isset($_REQUEST['idnovedadesconvenio'])){ ?>
                            <INPUT type="submit" value="Anular Novedad" name="anular">
                        <?php } ?>
                    </TD>
                </TR>
        </TABLE>
</form>
</body>
</html>