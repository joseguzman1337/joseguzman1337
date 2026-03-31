<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../Connections/salaado.php');
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
</head>
    <body>
<form name="form1" id="form1"  method="POST">
<table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
<TR >
           <TD colspan="2" align="center"><label id="labelresaltadogrande" >Permisos Usuario Dependencia</label></TD>
          </TR>
 </table>

       <TABLE width="30%"  border="1" align="center">

                <tr align="left" >

                    <TD id="tdtitulogris">Ingrese el Nombre del Usuario</TD>
                    <TD ><?php
                        $readonly='';
                        if (isset ($_POST['nombre'])){
                        $readonly='readonly';
                        }
                        ?>
                        <INPUT type="text" name="nombre" value="<?php echo $_POST['nombre'] ?>" <?php echo $readonly; ?>>
                    </TD>
                </tr>
       </TABLE>

<?php


$query_usuarios = "select idusuario, usuario
    from usuario
    where usuario = '".$_POST['nombre']."'";
    $usuarionombres = $db->Execute($query_usuarios);
    $totalRows_usuarios = $usuarionombres->RecordCount();
    $row_usuarios = $usuarionombres->FetchRow();


$query_dependencia = "SELECT codigocarrera, nombrecarrera FROM carrera  where codigomodalidadacademica like '5%'
order by nombrecarrera";
$dependencia = $db->Execute($query_dependencia);
    $totalRows_dependencia = $dependencia->RecordCount();
    $row_dependencia = $dependencia->FetchRow();

if (isset ($_POST['grabar'])){
$query_guardar = "UPDATE usuariodependencia set codigoestado = 200 where usuario = '".$_POST['nombre']."'";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            //$_REQUEST['idcohorte'] = $db->Insert_ID();
foreach ($_POST as $key => $valor){
    if(ereg ('activar', $key)){
        $codigodependencia = ereg_replace('activar',"",$key);
        $query_usuariodependencia1 = "SELECT u.idusuariodependencia, c.nombrecarrera FROM carrera c,  usuariodependencia u where  c.codigocarrera = u.codigodependencia
and u.codigodependencia= '$codigodependencia'
and u.usuario= '".$_POST['nombre']."'";
    $usuariodependencia1 = $db->Execute($query_usuariodependencia1);
    $totalRows_usuariodependencia1 = $usuariodependencia1->RecordCount();
 if ($totalRows_usuariodependencia1 == 0){

$query_guardar = "INSERT INTO usuariodependencia (idusuariodependencia, usuario, codigodependencia, codigoestado) values (0, '{$_POST['nombre']}', '$valor', 100)";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            //$_REQUEST['idcohorte'] = $db->Insert_ID();


            }

else{
$query_guardar = "UPDATE usuariodependencia set codigoestado = 100 where usuario = '".$_POST['nombre']."'
and codigodependencia= '$codigodependencia' ";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            //$_REQUEST['idcohorte'] = $db->Insert_ID();

}
        }
    }
}
?>
<?php
if (isset ($_POST['nombre'])){
    if ($row_usuarios['usuario']==""){
    echo '<script language="JavaScript">alert("No existe un usuario con ese nombre")</script>';
    }
}
if ($_POST['nombre']!="" && isset($row_usuarios['usuario'])){?>

            <TABLE width="30%"  border="1" align="center">
                <tr align="left" >
                    <TD  align="center"><label id="labelresaltado">Nombre Dependencia </label></TD>
                    <TD width="5%" align="center"><label id="labelresaltado">Activar/Desactivar </label></TD>
                </tr>
                <?php


do {

//  Consultar a la base de datos si existe codigocarrera para el usuario
 $query_usuariodependencia = "SELECT u.idusuariodependencia, c.nombrecarrera FROM carrera c,  usuariodependencia u where  c.codigocarrera = u.codigodependencia
and u.codigodependencia= '".$row_dependencia['codigocarrera']."'
and u.usuario= '".$_POST['nombre']."'
and u.codigoestado like '1%'";
    $usuariodependencia = $db->Execute($query_usuariodependencia);
    $totalRows_usuariodependencia = $usuariodependencia->RecordCount();
    $row_usuariodependencia = $usuariodependencia->FetchRow();
  $checked="";
if ($totalRows_usuariodependencia>0)
$checked='checked';
?>
                <TR>
                    <TD align="left"><?php echo $row_dependencia['nombrecarrera']; ?></TD>
                    <TD align="left"><INPUT type="checkbox" name="activar<?php echo $row_dependencia['codigocarrera'];?>" value="<?php echo $row_dependencia['codigocarrera'];?>" <?php echo $checked;?>> </TD>
                </TR>
                <?php } while($row_dependencia = $dependencia->FetchRow());?>
                <TR>
                    <TD colspan="2" align="center">
                        <INPUT type="submit" value="Activar/Desactivar" name="grabar">
                        <INPUT type="button" value="Restablecer" name="restablecer" onclick="window.location.href='usuariodependencia.php'">
                    </TD>
                </TR>


       </TABLE>
<?php

}

?>

</form>
</body>
</html>