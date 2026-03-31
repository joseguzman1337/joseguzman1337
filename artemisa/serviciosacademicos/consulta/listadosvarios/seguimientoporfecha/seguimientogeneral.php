<?php
session_start();
$nombrearchivo = 'seguimientogeneral';
require_once('../../../Connections/sala2.php');

if(isset($_REQUEST['formato']))
{
    $formato = $_REQUEST['formato'];
    switch ($formato)
    {
        case 'xls' :
            $strType = 'application/msexcel';
            $strName = $nombrearchivo.".xls";
            break;
        case 'doc' :
            $strType = 'application/msword';
            $strName = $nombrearchivo.".doc";
            break;
        case 'txt' :
            $strType = 'text/plain';
            $strName = $nombrearchivo.".txt";
            break;
        case 'csv' :
            $strType = 'text/plain';
            $strName = $nombrearchivo.".csv";
            break;
        case 'xml' :
            $strType = 'text/plain';
            $strName = $nombrearchivo.".xml";
            break;
        default :
            $strType = 'application/msexcel';
            $strName = $nombrearchivo.".xls";
            break;
    }
    header("Content-Type: $strType");
    header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("Cache-Control: no-store, no-cache");
    header("Pragma: public");
}
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
include($rutazado.'zadodb-pager.inc.php');
require_once('../../../funciones/sala/seguimiento/seguimientoporfecha.php');
if(isset($_SESSION['debug_sesion']))
{
	$db->debug = true;
}
//$db->debug = true;
//print_r($_SERVER);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Listado Seguimientos General</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
</head>
<script type="text/javascript">
function alternar(division){
    //document.getElementById("contentb1").
    //alert(division);
    //alert(division.style.display);
    //exit();
    /*if (division.style.display=="none")
    {
        division.style.display="";
    }
    else
    {
        division.style.display="none"
    }*/
    if (document.getElementById(division).style.display=="none")
    {
        document.getElementById(division).style.display="";
    }
    else
    {
        document.getElementById(division).style.display="none"
    }
}
</script>
<body>
<form action="" method="post" name="f1" onsubmit="return validar()">
<?php
if(!isset($_REQUEST['formato']))
{
?>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr>
	<td colspan="2"><label id="labelresaltado">Seleccione los filtros que desee para efectuar la consulta y oprima el botón Enviar</label></td>
  </tr>
<tr>
<td id="tdtitulogris">
  Modalidad Acad&eacute;mica<label id="labelresaltado"></label>
</td>
<td>
<?php
$query_modalidad = "SELECT codigomodalidadacademica, nombremodalidadacademica
FROM modalidadacademica
where codigoestado like '1%'
order by 1";
$modalidad = $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();
$row_modalidad = $modalidad->FetchRow();
?>
  <select name="nacodigomodalidadacademica" id="modalidad" onChange="enviar()">
    <option value="0"<?php if (!(strcmp("0", $_REQUEST['nacodigomodalidadacademica']))) {echo "SELECTED";} ?>>
      Todas *
    </option>
<?php
do
{
?>
    <option value="<?php echo $row_modalidad['codigomodalidadacademica']?>" <?php if (!(strcmp($row_modalidad['codigomodalidadacademica'], $_REQUEST['nacodigomodalidadacademica']))) {echo "SELECTED";} ?>>
      <?php echo $row_modalidad['nombremodalidadacademica']?>
    </option>
    <?php
}
while($row_modalidad = $modalidad->FetchRow());
?>
  </select>
</td>
</tr>
<tr>
<td id="tdtitulogris">
  Nombre del Programa<label id="labelresaltado"></label></td>
<td>
<?php
$fecha = date("Y-m-d G:i:s",time());
$query_carrera = "SELECT c.nombrecarrera, c.codigocarrera
FROM carrera c
where c.codigomodalidadacademica = '".$_REQUEST['nacodigomodalidadacademica']."'
and c.fechavencimientocarrera >= now()
order by 1";
$carrera = $db->Execute($query_carrera);
$totalRows_carrera = $carrera->RecordCount();
$row_carrera = $carrera->FetchRow();
?>
  <select name="nacodigocarrera" id="especializacion">
    <option value="0" <?php if (!(strcmp("0", $_REQUEST['nacodigocarrera']))) {echo "SELECTED";} ?>>
      Todas *
    </option>
<?php
do
{
	//$algo2 = ereg_replace("^.+ - ","",$row_car['codigocarrera']." - ".$row_car['codigoperiodo']);
?>
    <option value="<?php echo $row_carrera['codigocarrera'];?>" <?php if (!(strcmp($row_carrera['codigocarrera'], $_REQUEST['nacodigocarrera']))) {echo "SELECTED";} ?>>
      <?php echo $row_carrera['nombrecarrera']; ?>
    </option>
	<?php
}
while($row_carrera = $carrera->FetchRow());
?>
  </select>
</td>
</tr>
<tr>
<td id="tdtitulogris">
  Periodos a comparar</td>
<td><?php
//echo "<h1>".$_REQUEST['especializacion']."</h1>";
$query_periodo = "select p.codigoperiodo, p.nombreperiodo
from periodo p
where p.codigoperiodo >= 20051
order by 1 desc";
//where (p.codigoestadoperiodo like '1' or p.codigoestadoperiodo like '3')
//echo $query_periodo;
$periodo = $db->Execute($query_periodo);
$totalRows_periodo = $periodo->RecordCount();
$row_periodo = $periodo->FetchRow();

if ($row_periodo == "")
{
	echo '<script language="JavaScript">
	alert("No hay periodos activos"); histoy.go(-1);
	</script>';
	//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formulariopreinscripcion.php?documentoingreso=$documento&logincorrecto'>";
   exit;
}

?>
<table width="100%">

<?php
$cuentaperiodos = 0;
do
{
    if($cuentaperiodos == 0)
    {
?>
    <tr>
<?php
    }
    if(is_array($_REQUEST['codigoperiodo']))
        if(in_array($row_periodo['codigoperiodo'],$_REQUEST['codigoperiodo']))
        {
            $seleccionar=' checked="true"';
            $alternar = true;
        }
        else
        {
            $seleccionar="";
            $alternar = false;
        }
?>
        <td>
        <input name="codigoperiodo[]" type="checkbox" value="<?php echo $row_periodo['codigoperiodo']?>" onclick="alternar(<?php echo $row_periodo['codigoperiodo'];?>);" <?php echo $seleccionar;?>>
        <?php echo $row_periodo['codigoperiodo']; ?>
        <div id="<?php echo $row_periodo['codigoperiodo'];?>" style="display: none;">
        <input type="text" value="<?php if(isset($_REQUEST['fecha'.$row_periodo['codigoperiodo']])) echo $_REQUEST['fecha'.$row_periodo['codigoperiodo']]; /*else echo date("Y-m-d");*/?>" name="<?php echo "fecha".$row_periodo['codigoperiodo'];?>" id="<?php echo "fecha".$row_periodo['codigoperiodo'];?>" size="10"><!--&nbsp;&nbsp;&nbsp;<label id="labelresaltado">aaaa-mm-dd</label>-->
        <script type="text/javascript">
                Calendar.setup(
                {
            inputField  : "<?php echo "fecha".$row_periodo['codigoperiodo'];?>",         // ID of the input field
                ifFormat    : "%Y-%m-%d",    // the date format
                onUpdate    : "<?php echo "fecha".$row_periodo['codigoperiodo'];?>" // ID of the button
}
                );
        </script>
        </div>
        </td>
  <?php
        if($alternar)
        {
?>
        <script type="text/javascript">
            alternar(<?php echo $row_periodo['codigoperiodo'];?>)
        </script>

<?php
        }
    if($cuentaperiodos == 1)
    {
        $cuentaperiodos = -1;
?>
    </tr>
<?php
    }
    $cuentaperiodos++;
}
while ($row_periodo = $periodo->FetchRow());
?>
    </tr>
</table>
<td id="labelresaltado"><div align="justify"><label id="labelresaltado">Seleccione los periodos que desea comparar y digite la fecha con la que desea ver el reporte en cada periodo</label></div></td>
</tr>
<tr>
  <td nowrap id="tdtitulogris">Estados </td>
  <td>
    <select name="criteriosituacion[]" multiple='multiple'>
    <option value="todos" <?php if(is_array($_REQUEST['criteriosituacion']))
        if(in_array("todos",$_REQUEST['criteriosituacion']))
            echo " selected"; ?>>TODOS</option>
<?php
$sql_pv = "select nombreprocesovidaestudiante, codigoprocesovidaestudiante
from procesovidaestudiante
where codigoestado like '1%'
and codigoindicadorprocesovidaestudiante like '1%'
order by 2";
$pv = $db->Execute($sql_pv);
$totalRows_pv = $pv->RecordCount();
while($row_pv = $pv->FetchRow())
{
    if(is_array($_REQUEST['criteriosituacion']))
        if(in_array($row_pv['codigoprocesovidaestudiante'],$_REQUEST['criteriosituacion']))
            $seleccionar=" selected";
        else
            $seleccionar="";
    echo "<option value='".$row_pv['codigoprocesovidaestudiante']."' ".$seleccionar.">".$row_pv['nombreprocesovidaestudiante']."</option>";
}
?>
    </select>
  </td>
  <td id="labelresaltado"><div align="justify"><label id="labelresaltado">Escoja los estados que prefiera en la estadistica con ayuda del click del mouse y las teclas (shift) o (ctrl). Para seleccionar todas no escoja ninguna opci&oacute;n</label></div></td>
</tr>
<!--
<tr>
<td id="tdtitulogris">
Fecha de Inicio
</td>
<td>
<input type="text" name="nafinicial" value="<?php echo $_REQUEST['nafinicial']; ?>"> <label id="labelresaltado">aaaa-mm-dd</label>
</td>
</tr>
<tr>
<td id="tdtitulogris">
Fecha Final
</td>
<td>
<input type="text" name="naffinal" value="<?php echo $_REQUEST['naffinal']; ?>"> <label id="labelresaltado">aaaa-mm-dd</label>
</td>
</tr>
-->
</table>
<?php
}
?>
<br>
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Regresar" onClick="window.location.href='menuseguimiento.php'">

<br><br>
<?php
/*if(isset($_REQUEST['naenviar']) || isset($_REQUEST['formato']))
{
    print_r($_REQUEST);
    foreach($_REQUEST['codigoperiodo'] as $codigoperiodo)
    {
        if($_REQUEST['fecha'.$codigoperiodo] == "")
        {
?>
<script type="text/javascript">
    alert('Todos los periodos seleccionados deben llevar como obligatorio la fecha');
    history.go(-1);
</script>
<?php
            exit();
        }
    }
    echo "OKKKK";
    exit();
    require_once("listado.php");
	if($_REQUEST['nafinicial'] == "")
	{
		$_REQUEST['nafinicial'] = "1000-01-01";
	}
	if($_REQUEST['naffinal'] == "")
	{
		$_REQUEST['naffinal'] = "2999-01-01";
	}
	$rows_per_page=10;
	if($_REQUEST['row_page'] != "")
	{
		$rows_per_page = $_REQUEST['row_page'];
	}
    if($_REQUEST['nacodigocarrera'] != 0)
        $filtrocarrera .= "and c.codigocarrera = '".$_REQUEST['nacodigocarrera']."' ";
    if($_REQUEST['nacodigoperiodo'] != 0)
    {
        $filtroperiodo .= "and p.codigoperiodo = '".$_REQUEST['nacodigoperiodo']."' ";
    }
    else
    {
        $filtroperiodo .= "and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' ";
    }
    if($_REQUEST['nacodigomodalidadacademica'] != 0)
        $filtromodalidad .= "and c.codigomodalidadacademica = '".$_REQUEST['nacodigomodalidadacademica']."' ";

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr id="trtitulogris">
  <td rowspan="2" align="center">Facultad</td>
<?php
    $filtropv = "";
    $todos = false;
    foreach($_REQUEST['criteriosituacion'] as $key => $codigoprocesovidaestudiante)
    {
        $filtropv .= "$codigoprocesovidaestudiante ,";
        if($codigoprocesovidaestudiante == "todos")
            $todos = true;
    }
    $filtropv = ereg_replace(",$","",$filtropv);
    if($todos)
    {
        $sql_pv = "select nombreprocesovidaestudiante, codigoprocesovidaestudiante
        from procesovidaestudiante
        where codigoestado like '1%'
        order by 2";
    }
    else
    {
        $sql_pv = "select nombreprocesovidaestudiante, codigoprocesovidaestudiante
        from procesovidaestudiante
        where codigoestado like '1%'
        and codigoprocesovidaestudiante in ($filtropv)
        order by 2";
    }
    $pv = $db->Execute($sql_pv);
    if(!$pv)
    {
?>
<script type="text/javascript">
    alert('Debe seleccionar un Estado');
    history.go(-1);
</script>
<?php
        exit();
    }
    while($row_pv = $pv->FetchRow()) :
        $totalA[$row_pv['codigoprocesovidaestudiante']]['total'] = 0;
        $totalA[$row_pv['codigoprocesovidaestudiante']]['seg'] = 0;
?>
  <td colspan="3" align="center"><?php echo $row_pv['nombreprocesovidaestudiante']; ?></td>
<?php
    endwhile;
    $pv->MoveFirst();
?>
</tr>
<tr id="trtitulogris">
<?php
    while($row_pv = $pv->FetchRow()) :
?>
  <td align="left">Total <?php //echo $row_pv['nombreprocesovidaestudiante']; ?></td>
  <td align="left">Seg.</td>
  <td align="left">%</td>
<?php
    endwhile;
    $pv->MoveFirst();

    $sql_carrera = "select c.codigocarrera, c.nombrecarrera
    from carrera c
    where now() between c.fechainiciocarrera and c.fechavencimientocarrera
    $filtrocarrera
    $filtromodalidad
    order by 2";
    $carrera = $db->Execute($sql_carrera);
    $totalRows_carrera = $carrera->RecordCount();

    while($row_carrera = $carrera->FetchRow()) :
?>
<tr>
  <td><?php echo $row_carrera['nombrecarrera']; ?></td>
<?php
        $seg = new seguimiento($row_carrera['codigocarrera'], $_REQUEST['nacodigoperiodo']);
        while($row_pv = $pv->FetchRow()) :
            //$db->debug = true;
            $total = $seg->totalProcesos($row_pv['codigoprocesovidaestudiante']);
            $seguimiento = $seg->totalProcesosSeguimiento($row_pv['codigoprocesovidaestudiante']);

            $totalA[$row_pv['codigoprocesovidaestudiante']]['total'] += $total;
            $totalA[$row_pv['codigoprocesovidaestudiante']]['seg'] += $seguimiento;
            $porcentaje = 0;
            if($total != 0)
                $porcentaje = $seguimiento / $total * 100;


?>
        <td align="right"><?php echo $total;?></td>
        <td align="right"><?php echo $seguimiento;?></td>
        <td align="right"><?php echo round($porcentaje,1);?>%</td>
<?php
        endwhile;
        $pv->MoveFirst();
?>
</tr>
<?php
    endwhile;
?>
</tr>
<tr id="trtitulogris">
  <td align="right">Total:</td>
<?php
foreach($totalA as $key => $totalesA) :
    $porcentaje = 0;
    if($totalesA['total'] != 0)
        $porcentaje = $totalesA['seg'] / $totalesA['total'] * 100;
?>
  <td align="right"><?php echo $totalesA['total'];?></td>
  <td align="right"><?php echo $totalesA['seg'];?></td>
  <td align="right"><?php echo round($porcentaje,1);?>%</td>

<?php
endforeach;
?>
</tr>
</table>
<br>
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Restablecer" onClick="window.location.href='seguimientogeneral.php')"><input type="button" value="Regresar" onClick="window.location.href='menuseguimiento.php'">
<input type="submit" value="Exportar a Excel" name="formato" />
<?php
}*/
if(isset($_REQUEST['naenviar']) || isset($_REQUEST['formato']))
{
    //print_r($_REQUEST);
    if(isset($_REQUEST['codigoperiodo']))
    {
        foreach($_REQUEST['codigoperiodo'] as $codigoperiodo)
        {
            if($_REQUEST['fecha'.$codigoperiodo] == "")
            {
                ?>
                        <script type="text/javascript">
                        alert('Todos los periodos seleccionados deben llevar como obligatorio la fecha');
                history.go(-1);
                </script>
                        <?php
                        exit();
            }
            $arregloperiodos[$codigoperiodo] = $_REQUEST['fecha'.$codigoperiodo];
        }
    }
    else
    {
        ?>
                <script type="text/javascript">
                alert('Debe seleccionar un periodo como mínimo');
        history.go(-1);
        </script>
                <?php
                exit();
    }
    require_once("listado.php");
    exit();
}
?>
</form>
</body>
<script language="javascript">
function enviar()
{
    document.f1.submit();
}
function validar()
{
    //alert('Debe digitar una fecha para el periodo seleccionado');
    return true;
}
</script>
</html>
