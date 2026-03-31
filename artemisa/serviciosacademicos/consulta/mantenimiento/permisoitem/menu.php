<?php
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
require_once(realpath(dirname(__FILE__)).'/permisositem.php');

$query_itemsic = "SELECT iditemsic, nombreitemsic FROM itemsic where iditemsicpadre = 1
and codigoestado like '1%'";
$itemsic = $db->Execute($query_itemsic);
$totalRows_itemsic = $itemsic->RecordCount();
$row_itemsic = $itemsic->FetchRow();

?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
<script language="javascript">
    function cambiar()
        {
            document.form1.submit();
        }
</script>

    <body>
           <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
                <TR >
                    <TD colspan="2" align="center">
                        <label id="labelresaltadogrande" >Permisos para Menú SIQ</label>
                    </TD>
                </TR>
            </table>
            <?php
             filtroDependencia();
            ?>
        <form name="form1" id="form1"  method="POST">
        <input type="hidden" name="codigodependencia" value="<?php echo $_REQUEST['codigodependencia']; ?>">
        <input type="hidden" name="nacodigocarrera" value="<?php echo $_REQUEST['nacodigocarrera']; ?>">
<?php

if (isset ($_POST['grabar'])){
$query_guardar = "UPDATE permisoitemsicdependencia set codigoestado = 200 where codigocarrera='".$_REQUEST['nacodigocarrera']."'";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
            //$_REQUEST['idcohorte'] = $db->Insert_ID();
foreach ($_POST as $key => $valor){
    if(ereg ('activar', $key)){
        $codigodependencia = ereg_replace('activar',"",$key);
        $query_usuariodependencia1 = "SELECT p.iditemsic, c.codigocarrera, c.nombrecarrera, i.nombreitemsic
                    FROM
                    permisoitemsicdependencia p, carrera c, itemsic i
                    where
                    i.iditemsic = '$codigodependencia '
                    and p.iditemsic=i.iditemsic
                    and c.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
                    and c.codigocarrera = p.codigocarrera";
    $usuariodependencia1 = $db->Execute($query_usuariodependencia1);
    $totalRows_usuariodependencia1 = $usuariodependencia1->RecordCount();
 if ($totalRows_usuariodependencia1 == 0){

$query_guardar = "INSERT INTO permisoitemsicdependencia (idpermisoitemsicdependencia, codigocarrera, iditemsic, codigoestado) values (0, '{$_REQUEST['nacodigocarrera']}', '$valor', 100)";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());


            }

else{
$query_guardar = "UPDATE permisoitemsicdependencia set codigoestado = 100 where codigocarrera = '".$_REQUEST['nacodigocarrera']."'
and iditemsic= '$codigodependencia' ";
            $guardar = $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());

}
        }
    }
}

    if (isset ($_REQUEST['nacodigocarrera']) && $_REQUEST['nacodigocarrera']!=""){
        if ($totalRows_itemsic!=""){
?>
            <TABLE width="50%"  border="1" align="center">
                <tr align="left" >
                    <TD  align="center">
                        <label id="labelresaltado">IdItem </label>
                    </TD>
                    <TD  align="center">
                        <label id="labelresaltado">Nombre Item </label>
                    </TD>
                    <TD  align="center">
                        <label id="labelresaltado">Activar/Desactivar </label>
                    </TD>
                </tr>
                <?php


             do {

                    //  Consultar a la base de datos si existe codigocarrera para el usuario
                    $query_permisoitemsic = "SELECT p.iditemsic, c.codigocarrera, c.nombrecarrera, i.nombreitemsic
                    FROM
                    permisoitemsicdependencia p, carrera c, itemsic i
                    where
                    i.iditemsic = '".$row_itemsic['iditemsic']."'
                    and p.iditemsic=i.iditemsic
                    and c.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
                    and c.codigocarrera = p.codigocarrera
                    and p.codigoestado like '1%'";
                    $permisoitemsic = $db->Execute($query_permisoitemsic);
                    $totalRows_permisoitemsic = $permisoitemsic->RecordCount();
                    $row_permisoitemsic = $permisoitemsic->FetchRow();
                    $checked="";
                    if ($totalRows_permisoitemsic>0)
                        $checked='checked';
                    if ($_POST['activar'.$row_itemsic['iditemsic']]){
                            $checked='checked';
                        }

            ?>
                            <TR>
                                <TD align="left">
                                    <?php echo $row_itemsic['iditemsic'];
                                    ?>
                                </TD>
                                <TD align="left">
                                    <?php echo $row_itemsic['nombreitemsic'];
                                    ?>
                                </TD>
                                <TD align="left">
                                    <INPUT type="checkbox" name="activar<?php echo $row_itemsic['iditemsic'];?>" value="<?php echo $row_itemsic['iditemsic'];?>" <?php echo $checked;?>>
                                </TD>
                            </TR>
                    <?php
                }
                while($row_itemsic = $itemsic->FetchRow());
                    ?>
                            <TR>
                                <TD colspan="3" align="center">
                                    <INPUT type="submit" value="Activar/Desactivar" name="grabar">
                                    <INPUT type="button" value="Restablecer" name="restablecer" onclick="window.location.href='menu.php'">
                                </TD>
                            </TR>
                        </TABLE>
<?php
    }
}
?>
        </form>
    </body>
</html>
