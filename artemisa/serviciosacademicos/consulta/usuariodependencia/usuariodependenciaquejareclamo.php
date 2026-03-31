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
                        <label id="labelresaltadogrande" >Permisos Usuario PQRS</label>
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



$query_modalidadacademica = "select codigoareaquejareclamo, nombreareaquejareclamo from areaquejareclamo";
$modalidadacademica = $db->Execute($query_modalidadacademica);
$totalRows_modalidadacademica = $modalidadacademica->RecordCount();
$row_modalidadacademica = $modalidadacademica->FetchRow();

$query_dependencia = "SELECT iddependenciaquejareclamo, nombredependenciaquejareclamo FROM dependenciaquejareclamo  where codigoareaquejareclamo = '".$_POST['modalidadacademica']."'
order by nombredependenciaquejareclamo";
$dependencia = $db->Execute($query_dependencia);
    $totalRows_dependencia = $dependencia->RecordCount();
    $row_dependencia = $dependencia->FetchRow();

if (isset ($_POST['grabar'])){

    $query_actualizar1 = "UPDATE usuariodependenciaquejareclamo set codigoestado = 200 where usuarioquejareclamo = '".$_POST['nombre']."'";
    $actualizar1 = $db->Execute ($query_actualizar1) or die("$query_actualizar1".mysql_error());
            //$_REQUEST['idcohorte'] = $db->Insert_ID();
    foreach ($_POST as $key => $valor){
        if(ereg ('activar', $key)){
            $codigodependencia = ereg_replace('activar',"",$key);
            $query_usuariofacultad1 = "SELECT u.idusuariodependenciaquejareclamo, c.nombredependenciaquejareclamo FROM dependenciaquejareclamo c,  usuariodependenciaquejareclamo u where  c.iddependenciaquejareclamo = u.iddependenciaquejareclamo
            and u.iddependenciaquejareclamo= '$codigodependencia'
            and u.usuarioquejareclamo= '".$_POST['nombre']."'";
            $usuariofacultad1 = $db->Execute($query_usuariofacultad1);
            $totalRows_usuariofacultad1 = $usuariofacultad1->RecordCount();
            if ($totalRows_usuariofacultad1 == 0){

                $query_guardar = "INSERT INTO usuariodependenciaquejareclamo (idusuariodependenciaquejareclamo, usuarioquejareclamo, iddependenciaquejareclamo, codigoestado) values (0, '{$_POST['nombre']}', '$valor', 100)";
                $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
                //$_REQUEST['idcohorte'] = $db->Insert_ID();            
            }            
            else{
                $query_guardar = "UPDATE usuariodependenciaquejareclamo set codigoestado = 100 where usuarioquejareclamo = '".$_POST['nombre']."'
                and iddependenciaquejareclamo= '$codigodependencia' ";
                $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
                //$_REQUEST['idcohorte'] = $db->Insert_ID();            
            }
        }
    }
}


if ($_POST['nombre']!="" && isset($row_usuarios['usuario'])){ ?>

<tr align="left" >
                    <TD id="tdtitulogris">
                         Seleccione el Área
                    </TD>
                    <TD >
                        <select name="modalidadacademica" id="modalidadacademica" onchange="cambiar()">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php do {?>
                            <option value="<?php echo $row_modalidadacademica['codigoareaquejareclamo'];?>"
                                <?php
                                if($row_modalidadacademica['codigoareaquejareclamo'] == $_POST['modalidadacademica']) {
                                        echo "Selected";
                                }
                                ?>>
                                <?php echo $row_modalidadacademica['nombreareaquejareclamo'];?>
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
                    <TD width="2%" align="center">
                        <label id="labelresaltado">Activar/Desactivar </label>
                    </TD>
                </tr>
                <?php


    do {

        //  Consultar a la base de datos si existe codigocarrera para el usuario
        $query_usuariofacultad = "SELECT c.nombredependenciaquejareclamo, u.idusuariodependenciaquejareclamo   FROM dependenciaquejareclamo c,  usuariodependenciaquejareclamo u
        where
        c.iddependenciaquejareclamo = u.iddependenciaquejareclamo        
        and u.iddependenciaquejareclamo= '".$row_dependencia['iddependenciaquejareclamo']."'
        and u.usuarioquejareclamo= '".$_POST['nombre']."'
        and u.codigoestado like '1%'";
        $usuariofacultad = $db->Execute($query_usuariofacultad);
        $totalRows_usuariofacultad = $usuariofacultad->RecordCount();
        $row_usuariofacultad = $usuariofacultad->FetchRow();
        $checked="";
        if ($totalRows_usuariofacultad>0)
            $checked='checked';
        //echo "imprime".$_POST['activar'.$row_dependencia['codigocarrera']];
        if ($_POST['activar'.$row_dependencia['iddependenciaquejareclamo']]){
                $checked='checked';
            }
?>
                <TR>
                    <TD align="left">
                        <?php echo $row_dependencia['nombredependenciaquejareclamo'];
                        ?>
                    </TD>                    
                    <TD align="left">
                        <INPUT type="checkbox" name="activar<?php echo $row_dependencia['iddependenciaquejareclamo'];?>" value="<?php echo $row_dependencia['iddependenciaquejareclamo'];?>" <?php echo $checked;?>>
                    </TD>
                </TR>
        <?php
    }
    while($row_dependencia = $dependencia->FetchRow());
        ?>
                <TR>
                    <TD colspan="4" align="center">
                        <INPUT type="submit" value="Activar/Desactivar" name="grabar"><INPUT type="button" value="Restablecer" name="restablecer" onclick="window.location.href='usuariodependenciaquejareclamo.php'">
                    </TD>
                </TR>
            </TABLE>
<?php
}
?>
        </form>
    </body>
</html>
