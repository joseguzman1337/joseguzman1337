<?php
$fechahoy=date("Y-m-d H:i:s");
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');

$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}

if(!isset($_REQUEST['codigocarrera'])) {
    $_REQUEST['codigocarrera'] = $_SESSION['codigofacultad'];
    $devolverse=true;
}
$filtroNombreObjetivo = "";
$filtroFechaObjetivo = "";

if(isset($_REQUEST['filtronombre'])) {
    $filtroNombreObjetivo = " and o.nombreobjetivocarrera like '%".$_REQUEST['filtronombre']."%'";
}
if(isset($_REQUEST['filtrofecha'])) {
    $filtroFechaObjetivo = " and o.fechaingresoobjetivocarrera like '%".$_REQUEST['filtrofecha']."%'";
}
$query_carrera ="SELECT c.nombrecarrera
FROM carrera c
WHERE c.codigocarrera='".$_REQUEST['codigocarrera']."'";
$carrera= $db->Execute($query_carrera) or die("$query_carrera".mysql_error());
$totalRows_carrera = $carrera->RecordCount();
$row_carrera = $carrera->FetchRow();

$query_objetivo ="SELECT o.idobjetivocarrera,o.nombreobjetivocarrera, o.descripcionobjetivocarrera, o.fechaingresoobjetivocarrera
FROM objetivocarrera o
WHERE o.codigocarrera='".$_REQUEST['codigocarrera']."'
and o.codigoestado like '1%'
$filtroNombreObjetivo
$filtroFechaObjetivo
order by 1";
$objetivo= $db->Execute($query_objetivo) or die("$query_objetivo".mysql_error());
$totalRows_objetivo = $objetivo->RecordCount();
$rutaJS = "../../sic/librerias/js/";
$rutaEstilos = "../../sic/estilos/";
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">

    </head>
    <body>
     <form name="form1" id="form1"  method="POST" action="">
            <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
                <TR >
                    <TD align="center">
                        <label id="labelresaltadogrande" >OBJETIVOS DE APRENDIZAJE
                        <?php if($_REQUEST['codigocarrera']=='156'){
                            echo "INSTITUCIONALES";
                            }
                            else{
                                echo "PARA EL PROGRAMA<BR>".$row_carrera['nombrecarrera'];
                            }
                            ?>

                        </label>
                    </TD>
                </TR>
            </table>
            <TABLE width="70%"  border="1" align="center">
                <TR id="trgris">
                    <TD align="center"><label id="labelresaltado">Id</label></TD>
                    <TD align="center"><label id="labelresaltado">Nombre</label></TD>
                    <TD align="center"><label id="labelresaltado">Fecha Ingreso</label></TD>
                    <TD width="40%" align="center"><label id="labelresaltado">Descripción</label></TD>
                </TR>
                <?php
                if ($totalRows_objetivo!=""){
                ?>
                <TR>
                    <TD >&nbsp;</TD>
                    <TD align="center"><INPUT type="text" name="filtronombre" id="filtronombre" value="<?php if ($_REQUEST['filtronombre']!=""){
                            echo $_REQUEST['filtronombre']; } ?>"></TD>
                    <TD align="center"><INPUT type="text" name="filtrofecha" id="filtrofecha" size="12" value="<?php if ($_REQUEST['filtrofecha']!=""){
                            echo $_REQUEST['filtrofecha']; } ?>"></TD>
                    <TD align="center">&nbsp;<input type="submit" name="Filtrar" value="Filtrar"></TD>
                </TR>
                <?php 
                }   
                while($row_objetivo = $objetivo->FetchRow()) {

                ?>
                <TR valign="baseline">
                    <TD align="center"><?php echo $row_objetivo['idobjetivocarrera']; ?></TD>
                    <TD align="center" >
                        <A id="aparencialink" href="insertar_objetivo_carrera.php?idobjetivocarrera=<?php echo $row_objetivo['idobjetivocarrera']; ?>"><?php echo $row_objetivo['nombreobjetivocarrera']; ?></A>
                    </TD>
                    <TD align="center"><?php echo $row_objetivo['fechaingresoobjetivocarrera']; ?></TD>
                    <TD style="text-align:justify;"><?php echo $row_objetivo['descripcionobjetivocarrera']; ?></TD>
                </TR>
                <?php
                }
                ?>
                <TR align="left">
                    <TD id="tdtitulogris" colspan="5"  align="center">
                        <INPUT type="button" value="Adicionar" onClick="window.location.href='insertar_objetivo_carrera.php?codigocarrera=<?php echo $_REQUEST['codigocarrera']; ?>'">

                        <?php
                        if($_REQUEST['codigocarrera']!='156' && $_SESSION['codigofacultad']!=$_REQUEST['codigocarrera']){
                            ?>
                        <INPUT type="button" value="Regresar" onClick="window.location.href='../carrera2/insertar2.php?codigocarrera=<?php echo $_REQUEST['codigocarrera']; ?>'">
                        <?php
                        }
                        ?>
                    </TD>
                </TR>
            </TABLE>
      </form>
    </body>
</html>