<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../Connections/salaado.php');

$query_usuarios = "select idusuario, usuario
from usuario
where usuario = '".$_POST['nombre']."'";
$usuarionombres = $db->Execute($query_usuarios);
$totalRows_usuarios = $usuarionombres->RecordCount();
$row_usuarios = $usuarionombres->FetchRow();
if (isset ($_POST['nombre'])){
    if ($row_usuarios['usuario']==""){
        echo '<script language="JavaScript">alert("No existe un usuario con ese nombre")</script>';
        $entro = true;
        $readonly='';
    }
}

?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
    </head>
<script language="javascript">
    function cambiar()
        {
            document.form1.submit();
        }
</script>

    <body>
        <form name="form1" id="form1"  method="POST">
            <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
                <TR >
                    <TD colspan="2" align="center">
                        <label id="labelresaltadogrande" >Permisos Usuario Facultad</label>
                    </TD>
                </TR>
            </table>
            <TABLE width="30%"  border="1" align="center">
                <tr align="left" >
                    <TD id="tdtitulogris">
                         Ingrese el Nombre del Usuario
                    </TD>
                    <TD >
                        <?php //if(isset $row_usuarios['usuario'])
                        //$readonly='';
                        if (isset ($_POST['nombre']) && $_POST['nombre'] != ''){
                            if(!$entro)
                                $readonly='readonly';
                        }
                        ?>
                        <INPUT type="text" name="nombre" value="<?php echo $_POST['nombre'] ?>" <?php echo $readonly; ?>>
                    </TD>
                </tr>

            <?php

//echo "nombre".$_POST['nombre'];
//$db->debug=true;



$query_modalidadacademica = "select codigomodalidadacademica, nombremodalidadacademica from modalidadacademica
where codigoestado like '1%'";
$modalidadacademica = $db->Execute($query_modalidadacademica);
$totalRows_modalidadacademica = $modalidadacademica->RecordCount();
$row_modalidadacademica = $modalidadacademica->FetchRow();

$query_dependencia = "SELECT codigocarrera, nombrecarrera FROM carrera  where codigomodalidadacademica = '".$_POST['modalidadacademica']."'
order by nombrecarrera";
$dependencia = $db->Execute($query_dependencia);
    $totalRows_dependencia = $dependencia->RecordCount();
    $row_dependencia = $dependencia->FetchRow();

if (isset ($_POST['grabar'])){

    $query_actualizar1 = "UPDATE usuariofacultad set codigoestado = 200 where usuario = '".$_POST['nombre']."' AND codigofacultad IN (
						SELECT codigocarrera FROM carrera where codigomodalidadacademica='".$_POST['modalidadacademica']."'
						)";
					//echo $query_actualizar1."<br/>";
    $actualizar1 = $db->Execute ($query_actualizar1) or die("$query_actualizar1".mysql_error());
            //$_REQUEST['idcohorte'] = $db->Insert_ID();
    foreach ($_POST as $key => $valor){
        if(ereg ('activar', $key)){
            $codigodependencia = ereg_replace('activar',"",$key);
            $query_usuariofacultad1 = "SELECT c.nombrecarrera, u.idusuario, u.emailusuariofacultad, t.nombretipousuariofacultad, u.codigoestado   FROM carrera c,  usuariofacultad u, tipousuariofacultad t
            where
            c.codigocarrera = u.codigofacultad
            and u.codigotipousuariofacultad=t.codigotipousuariofacultad
            and u.codigofacultad= '$codigodependencia'
            and u.usuario= '".$_POST['nombre']."'";
					//echo $query_usuariofacultad1."<br/>";
            $usuariofacultad1 = $db->Execute($query_usuariofacultad1);
            $totalRows_usuariofacultad1 = $usuariofacultad1->RecordCount();
            if ($_POST['tipousuariofacultad'.$codigodependencia] !=""){
                if ($totalRows_usuariofacultad1 == 0){

                    $query_guardar = "INSERT INTO usuariofacultad (idusuario, usuario, codigofacultad, codigotipousuariofacultad, emailusuariofacultad, codigoestado) values (0, '{$_POST['nombre']}', '$valor', '".$_POST['tipousuariofacultad'.$codigodependencia]."', '".$_POST['email'.$codigodependencia ]."', 100)";
                    //echo $query_guardar."<br/>";
					$guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
                    //$_REQUEST['idcohorte'] = $db->Insert_ID();
                }

                else {
                    $query_actualizar2 = "UPDATE usuariofacultad set codigoestado = 100, emailusuariofacultad= '".$_POST['email'.$codigodependencia ]."', codigotipousuariofacultad = '".$_POST['tipousuariofacultad'.$codigodependencia]."' where usuario = '".$_POST['nombre']."'
                    and codigofacultad= '$codigodependencia' ";
					//echo $query_actualizar2."<br/>";
                    $actualizar2 = $db->Execute ($query_actualizar2) or die("$query_actualizar2".mysql_error());
                    //$_REQUEST['idcohorte'] = $db->Insert_ID();
                }
            }
            else{
                echo '<script language="JavaScript">alert("ERROR: Debe seleccionar el tipo de Usuario")</script>';
                $query_actualizar2 = "UPDATE usuariofacultad set codigoestado = 100 where usuario = '".$_POST['nombre']."'
                and codigofacultad= '$codigodependencia' ";
					//echo $query_actualizar2."<br/>";
                $actualizar2 = $db->Execute ($query_actualizar2) or die("$query_actualizar2".mysql_error());

            }
        }
    }
}


if ($_POST['nombre']!="" && isset($row_usuarios['usuario'])){ ?>

<tr align="left" >
                    <TD id="tdtitulogris">
                         Seleccione la Modalidad Académica
                    </TD>
                    <TD >
                        <select name="modalidadacademica" id="modalidadacademica" onchange="cambiar()">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php do {?>
                            <option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                                <?php
                                if($row_modalidadacademica['codigomodalidadacademica'] == $_POST['modalidadacademica']) {
                                        echo "Selected";
                                }
                                ?>>
                                <?php echo $row_modalidadacademica['nombremodalidadacademica'];?>
                            </option>
                            <?php }while($row_modalidadacademica= $modalidadacademica->FetchRow())?>
                            </select>
                    </TD>
                </tr>
<?php
}
?>
</TABLE>

<?php
if ($totalRows_dependencia!=""){
?>
            <TABLE width="50%"  border="1" align="center">
                <tr align="left" >
                    <TD  align="center">
                        <label id="labelresaltado">Nombre Dependencia </label>
                    </TD>
                    <TD  align="center">
                        <label id="labelresaltado">E-mail </label>
                    </TD>
                    <TD width="5%" align="center">
                        <label id="labelresaltado">Tipo de Usuario </label>
                    </TD>
                    <TD width="2%" align="center">
                        <label id="labelresaltado">Activar/Desactivar </label>
                    </TD>
                </tr>
                <?php


    do {

        //  Consultar a la base de datos si existe codigocarrera para el usuario
        $query_usuariofacultad = "SELECT c.nombrecarrera, u.idusuario, u.emailusuariofacultad, t.nombretipousuariofacultad, t.codigotipousuariofacultad   FROM carrera c,  usuariofacultad u, tipousuariofacultad t
        where
        c.codigocarrera = u.codigofacultad
        and u.codigotipousuariofacultad=t.codigotipousuariofacultad
        and u.codigofacultad= '".$row_dependencia['codigocarrera']."'
        and u.usuario= '".$_POST['nombre']."'
        and u.codigoestado like '1%'";
		//echo $query_usuariofacultad;
		//echo $row_dependencia['codigocarrera']."<br/>";
        $usuariofacultad = $db->Execute($query_usuariofacultad);
        $totalRows_usuariofacultad = $usuariofacultad->RecordCount();
        $row_usuariofacultad = $usuariofacultad->FetchRow();
        $checked="";
        if ($totalRows_usuariofacultad>0){
            $checked='checked';
			//echo $checked."<br/>";
		}
        //echo "imprime".$_POST['activar'.$row_dependencia['codigocarrera']];
        if ($_POST['activar'.$row_dependencia['codigocarrera']]){
                $checked='checked';
            }
?>
                <TR>
                    <TD align="left">
                        <?php echo $row_dependencia['nombrecarrera'];
                        ?>
                    </TD>
                    <TD align="left">
                        <INPUT type="text" name="email<?php echo $row_dependencia['codigocarrera'];?>"  id="email" value="<?php if (!isset ($row_usuariofacultad['emailusuariofacultad'])){
                            echo $_POST['email'.$row_dependencia['codigocarrera']];}
                            else{
                                 echo  $row_usuariofacultad['emailusuariofacultad'];
                                } ?>">
                    </TD>
                    <?php
                    $query_tipousuariofacultad = "select codigotipousuariofacultad, nombretipousuariofacultad
                    from tipousuariofacultad";
                    $tipousuariofacultad = $db->Execute($query_tipousuariofacultad);
                    $totalRows_tipousuariofacultad = $tipousuariofacultad->RecordCount();
                    $row_tipousuariofacultad = $tipousuariofacultad->FetchRow();
                     ?>
                    <TD align="left">
                        <SELECT name="tipousuariofacultad<?php echo $row_dependencia['codigocarrera'];?>" id="tipousuariofacultad">
                        <option value="">
                                Seleccionar
                            </option>
                                <?php do {?>
                            <option value="<?php echo $row_tipousuariofacultad['codigotipousuariofacultad'];?>"
                                <?php
                                            if($row_tipousuariofacultad['codigotipousuariofacultad'] == $_POST['tipousuariofacultad'.$row_dependencia['codigocarrera']]) {
                                                 echo "Selected";
                                            }
                                            else if($row_usuariofacultad['codigotipousuariofacultad']==$row_tipousuariofacultad['codigotipousuariofacultad'])
                                            echo "Selected";
                                            ?>>
                                            <?php echo $row_tipousuariofacultad['nombretipousuariofacultad'];?>
                            </option>
                                <?php }
                                      while($row_tipousuariofacultad= $tipousuariofacultad->FetchRow())?>
                        </SELECT>
                    </TD>
                    <TD align="left">
                        <INPUT type="checkbox" name="activar<?php echo $row_dependencia['codigocarrera'];?>" value="<?php echo $row_dependencia['codigocarrera'];?>" <?php echo $checked;?>>
                    </TD>
                </TR>
        <?php
    }
    while($row_dependencia = $dependencia->FetchRow());
        ?>
                <TR>
                    <TD colspan="4" align="center">
                        <INPUT type="submit" value="Activar/Desactivar" name="grabar"><INPUT type="button" value="Restablecer" name="restablecer" onclick="window.location.href='usuariofacultad.php'">
                    </TD>
                </TR>
            </TABLE>
<?php
}
?>
        </form>
    </body>
</html>
