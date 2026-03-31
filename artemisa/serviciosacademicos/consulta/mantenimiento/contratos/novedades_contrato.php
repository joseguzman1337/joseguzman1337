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
            if (isset($_REQUEST['idnovedadescontrato'])){
                echo "<script language='javascript'> alert('Se ha Anulado la Novedad'); window.location.href = 'lista_novedades_contrato.php?idcontrato=".$_REQUEST['idcontrato']."' </script>";
                $query_actualizar = "UPDATE novedadescontrato SET codigoestado = 200 where idnovedadescontrato = '{$_REQUEST['idnovedadescontrato']}'";
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
        elseif ($_POST['fechainicionovedadescontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Inicio de la Vigencia")</script>';
                $varguardar = 1;
                }
        elseif ($_POST['fechafinnovedadescontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Seleccionar o Digitar la Fecha de Finalización de la Vigencia")</script>';
                $varguardar = 1;
                }        
        elseif ($_POST['observacionnovedadescontrato'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar la observación")</script>';
                $varguardar = 1;
                }       

        elseif ($varguardar == 0) {
            if (isset($_REQUEST['idnovedadescontrato'])){

                $query_actualizar = "UPDATE novedadescontrato SET codigotiponovedadescontrato='".$_POST['tiponovedad']."',
                fechainicionovedadescontrato='".$_POST['fechainicionovedadescontrato']."',
                fechafinnovedadescontrato='".$_POST['fechafinnovedadescontrato']."',
                observacionnovedadescontrato='".$_POST['observacionnovedadescontrato']."', codigoestado = 100
                where idnovedadescontrato = '{$_REQUEST['idnovedadescontrato']}'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
                echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
    
            }
            else {
                $query_guardar = "INSERT INTO novedadescontrato (idnovedadescontrato, idcontrato,
                codigotiponovedadescontrato, fechainicionovedadescontrato, fechafinnovedadescontrato,
                observacionnovedadescontrato, codigoestado)
                values (0, '{$_REQUEST['idcontrato']}','{$_POST['tiponovedad']}',
                '{$_POST['fechainicionovedadescontrato']}','{$_POST['fechafinnovedadescontrato']}',
                '{$_POST['observacionnovedadescontrato']}', 100)";
                $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
                $_REQUEST['idnovedadescontrato'] = $db->Insert_ID();
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
    <input id="idnovedadescontrato" type="hidden" value="">
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR id="trgris">
           <TD align="center"><label id="labelresaltadogrande">NOVEDADES CONTRATOS</label></TD>
          </TR>
         <TR id="trgris">
           <TD align="center"><label id="labelresaltado"><?php 
            $query_nomcontrato = "select nombreentidadcontrato from contrato where idcontrato = '".$_REQUEST['idcontrato']."'";
                $nomcontrato= $db->Execute($query_nomcontrato);
                $totalRows_nomcontrato = $nomcontrato->RecordCount();
                $row_nomcontrato = $nomcontrato->FetchRow();
                echo $row_nomcontrato['nombreentidadcontrato'];
                
             ?>
            </label></TD>
         </TR>
    </table>
        <?php


        $query_contrato ="SELECT n.fechainicionovedadescontrato, n.fechafinnovedadescontrato,
        n.observacionnovedadescontrato, n.adjuntonovedadescontrato, tn.codigotiponovedadescontrato,
        tn.nombretiponovedadescontrato FROM novedadescontrato n, tiponovedadescontrato tn
        where
        tn.codigotiponovedadescontrato =n.codigotiponovedadescontrato
        and n.idnovedadescontrato = '".$_REQUEST['idnovedadescontrato']."'";
                $contrato= $db->Execute($query_contrato);
                $totalRows_contrato = $contrato->RecordCount();
                $row_contrato = $contrato->FetchRow();

          $query_tiponovedad ="SELECT codigotiponovedadescontrato, nombretiponovedadescontrato
              from tiponovedadescontrato where codigoestado like '1%' order by 2";
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
                            <option value="<?php echo $row_tiponovedad['codigotiponovedadescontrato'];?>"
                                <?php
                                 if($row_tiponovedad['codigotiponovedadescontrato']==$_POST['tiponovedad']) {
                                echo "Selected";
                                 }
                                else if($row_contrato['codigotiponovedadescontrato']==$row_tiponovedad['codigotiponovedadescontrato'])
                                echo "Selected";
                                ?>>
                                <?php echo $row_tiponovedad['nombretiponovedadescontrato'];?>
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
                        if (isset($_REQUEST['idnovedadescontrato'])){
                        $row_contrato['fechainicionovedadescontrato']==$_POST['fechainicionovedadescontrato'];
                        ?>
                        <INPUT type="text" name="fechainicionovedadescontrato" id="fechainicionovedadescontrato"  value="<?php echo $row_contrato['fechainicionovedadescontrato'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainicionovedadescontrato",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechainicionovedadescontrato" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                            }
                       else {
                        ?>
                        <INPUT type="text" name="fechainicionovedadescontrato" id="fechainicionovedadescontrato"  value="<?php if ($_POST['fechainicionovedadescontrato']!=""){ echo $_POST['fechainicionovedadescontrato']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                            <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechainicionovedadescontrato",         // ID of the input field
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
                    <td id="tdtitulogris">Fecha Finalización Novedad<label  id="labelasterisco">*</label>
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idnovedadescontrato'])){
                        $row_contrato['fechafinnovedadescontrato']==$_POST['fechafinnovedadescontrato'];
                        ?>
                        <INPUT type="text" name="fechafinnovedadescontrato" id="fechafinnovedadescontrato"  value="<?php echo $row_contrato['fechafinnovedadescontrato'];?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechafinnovedadescontrato",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechafinnovedadescontrato" // ID of the button
                                  }
                                 );
                        </script>
                        <?php
                          }
                          else {
                           ?>
                          <INPUT type="text" name="fechafinnovedadescontrato" id="fechafinnovedadescontrato"  value="<?php if ($_POST['fechafinnovedadescontrato']!=""){ echo $_POST['fechafinnovedadescontrato']; } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                        <script type="text/javascript">
                            Calendar.setup(
                                 {
                                 inputField  : "fechafinnovedadescontrato",         // ID of the input field
                                 ifFormat    : "%Y-%m-%d",    // the date format
                                 onUpdate    : "fechafinnovedadescontrato" // ID of the button
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
                        if (isset($_REQUEST['idnovedadescontrato'])){
                        $row_contrato['observacionnovedadescontrato']==$_POST['observacionnovedadescontrato'];?>
                        <TEXTAREA name="observacionnovedadescontrato" id="observacionnovedadescontrato"><?php echo $row_contrato['observacionnovedadescontrato']; ?></TEXTAREA>
                        <?php
                         }
                         else {?>
                        <TEXTAREA name="observacionnovedadescontrato" id="observacionnovedadescontrato"><?php if ($_POST['observacionnovedadescontrato']!=""){ echo $_POST['observacionnovedadescontrato']; } ?></TEXTAREA>
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
                    <?php if (isset($_REQUEST['idnovedadescontrato'])){ ?>
                        <input type="hidden" name="idnovedadescontrato" value="<?php echo $_REQUEST['idnovedadescontrato']; ?>">
                    <?php
                    } ?>
                    <INPUT type="button" value="Regresar" onClick="window.location.href='lista_novedades_contrato.php?idcontrato=<?php echo $_REQUEST['idcontrato']; ?>'">
    
                        <?php if (isset($_REQUEST['idnovedadescontrato'])){ ?>
                            <INPUT type="submit" value="Anular Novedad" name="anular">
                        <?php } ?>
                    </TD>
                </TR>
        </TABLE>
</form>
</body>
</html>