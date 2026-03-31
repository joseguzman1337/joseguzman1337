<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSIO);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../../../../Connections/sala2.php');
$rutaado = "../../../../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../../../../Connections/salaado.php');
$rutaPHP="../../../../librerias/php/";
require_once( realpath(dirname(__FILE__)).'/../../../textogeneral/modelo/textogeneral.php');
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
<script language="javascript">
    function cambio()
        {
            document.form1.submit();
        }
</script>
<?php


if (isset($_POST['anular'])) {
        if ($varanular==0){
            if (isset($_REQUEST['idgrupoinvestigacion'])){ ?>
                <script language='javascript'> alert('Se ha Anulado el Convenio'); window.location.href = 'menu_grupoinvestigacion.php?iditemsic=<?php echo $_REQUEST['iditemsic'];?>'</script>
                <?php
                $query_actualizar = "UPDATE grupoinvestigacion SET codigoestado = 200 where idgrupoinvestigacion = '{$_REQUEST['idgrupoinvestigacion']}'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            }

        }
}
?>
<?php
  if (isset($_POST['grabar'])) {

      if ($_POST['nombregrupoinvestigacion'] == "") {
            echo '<script language="JavaScript">alert("Debe Digitar el Nombre para el Grupo")</script>';
                $varguardar = 1;
                }

        elseif ($varguardar == 0) {
                if (isset($_REQUEST['idgrupoinvestigacion']) && $_REQUEST['idgrupoinvestigacion']!=""){

           $query_actualizar = "UPDATE grupoinvestigacion SET nombregrupoinvestigacion='".$_POST['nombregrupoinvestigacion']."'
           where idgrupoinvestigacion = '{$_REQUEST['idgrupoinvestigacion']}'";
            $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";
                }

            else {
                if ($_REQUEST['codigodefacultad'] == ""){
                    $query_facultad ="SELECT codigofacultad FROM carrera
                        where
                        codigocarrera = '".$_SESSION['codigofacultad']."'";
                        $facultad= $db->Execute($query_facultad);
                        $totalRows_facultad = $facultad->RecordCount();
                        $row_facultad = $facultad->FetchRow();
                        $_REQUEST['codigodefacultad'] = $row_facultad['codigofacultad'] ; }



            $query_guardar = "INSERT INTO grupoinvestigacion (idgrupoinvestigacion, nombregrupoinvestigacion, codigofacultad, codigoestado) values (0, '{$_POST['nombregrupoinvestigacion']}','{$_REQUEST['codigodefacultad']}', 100)";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            $_REQUEST['idgrupoinvestigacion'] = $db->Insert_ID();
            echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  </script>";
                    }

                    $mensaje = $itemsic->insertarItemsiccarrera();
                echo "<script type='text/javascript'>
                        cambiaestado('".$mensaje."',".$_REQUEST['iditemsic'].");
                    </script>";
             }
  }

$query_datos ="SELECT idgrupoinvestigacion, nombregrupoinvestigacion FROM grupoinvestigacion
where idgrupoinvestigacion = '".$_REQUEST['idgrupoinvestigacion']."'
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
    <INPUT type="hidden" name="codigodefacultad" value="<?php echo $_REQUEST['codigodefacultad'];?>">
    <INPUT type="hidden" name="iditemsic" value="<?php echo $_REQUEST['iditemsic'];?>">
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR id="trgris">
           <TD align="center"><label id="labelresaltadogrande">Edición e Ingreso Grupo de Investigación</label></TD>
          </TR>
    </table>

            <TABLE width="50%"  border="1" align="center">
                <tr align="left" >
                    <td width="30%" id="tdtitulogris"><div align="left">Nombre Grupo Investigación<label  id="labelasterisco">*</label></div>
                    </td>
                    <td id="tdtitulogris">
                        <div align="justify">
                        <?php
                        if (isset($_REQUEST['idgrupoinvestigacion'])){
                        $row_datos['nombregrupoinvestigacion']==$_POST['nombregrupoinvestigacion'];?>
                        <TEXTAREA  name="nombregrupoinvestigacion" id="nombregrupoinvestigacion" cols="60" rows="2"><?php echo $row_datos['nombregrupoinvestigacion']; ?></TEXTAREA>
                        <?php
                         }
                         else {?>
                        <TEXTAREA  name="nombregrupoinvestigacion" id="nombregrupoinvestigacion" cols="60" rows="2"><?php if ($_POST['nombregrupoinvestigacion']!=""){
                        echo $_POST['nombregrupoinvestigacion']; } ?></TEXTAREA>
                         <?php }
                            ?>
                        </div>
                    </td>
                </tr>




             <TR align="left">
                <TD id="tdtitulogris" colspan="2" rowspan="2" align="center">
                <INPUT type="submit" value="Guardar" name="grabar">
                <?php

                    if (isset($_REQUEST['idgrupoinvestigacion'])){
                ?>
                <input type="hidden" name="idcohorte" value="<?php echo $_REQUEST['idcohorte']; ?>">
                    <?php
                    }
                    ?>
                <INPUT type="button" value="Regresar" onClick="window.location.href='menu_grupoinvestigacion.php?iditemsic=<?php echo $_REQUEST['iditemsic']; ?>'">
                <?php if (isset($_REQUEST['idgrupoinvestigacion'])){ ?>
                        <INPUT type="submit" value="Anular Grupo" name="anular">
                    <?php } ?>
                </TD>
              </TR>
        </TABLE>
</form>
</body>
</html>