<?php
session_start();
$nombrearchivo = 'seguimientodetalle';
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
require_once('../../../funciones/sala/seguimiento/seguimiento.php');

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
</head>
<body>
<form action="" method="post" name="f1">
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
while($row_carrera = $carrera->FetchRow())
?>
  </select>
</td>
</tr>
<tr>
<td id="tdtitulogris">
  Periodo</td>
<td><?php
//echo "<h1>".$_REQUEST['especializacion']."</h1>";
$query_periodo = "select p.codigoperiodo, p.nombreperiodo
from periodo p
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

?><select name="nacodigoperiodo">
 <option value="0"<?php if (!(strcmp("0", $_REQUEST['nacodigoperiodo']))) {echo "SELECTED";} ?>>
      Seleccionar
    </option>
  <?php
do
{
?>
    <option value="<?php echo $row_periodo['codigoperiodo']?>" <?php if (!(strcmp($row_periodo['codigoperiodo'], $_REQUEST['nacodigoperiodo']))) {echo "SELECTED";} ?>>
      <?php echo $row_periodo['nombreperiodo']?>
    </option>
  <?php
}
while ($row_periodo = $periodo->FetchRow());
?>
</select>
</td>
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
  <td id="labelresaltado"><div align="justify"><label id="labelresaltado">Escoja los estados que prefiera en la estadistica con ayuda del click del mouse y las teclas (shift) o (ctrl). Para seleccionar todas no escoja ninguna opci&oacute;n o la opci&oacute;n TODOS </label></div></td>
</tr>
</table>
<?php
}
?>
<br>
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Regresar" onClick="window.location.href='menuseguimiento.php'">

<br><br>
<?php
if(isset($_REQUEST['naenviar']) || isset($_REQUEST['formato']))
{
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
    //$totalRows_pv = $pv->RecordCount();
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
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr id="trtitulogris">
  <td rowspan="2" align="center">Facultad</td>
<?php
    while($row_pv = $pv->FetchRow()) :
        $totalcolumna[$row_pv['codigoprocesovidaestudiante']]['300'] = 0;
        $totalcolumna[$row_pv['codigoprocesovidaestudiante']]['400'] = 0;
?>
  <td colspan="6" align="center"><?php echo $row_pv['nombreprocesovidaestudiante']; ?></td>
<?php
    endwhile;
    $pv->MoveFirst();
?>
  <td rowspan="2" align="center">Total</td>
  <td rowspan="2" align="center">%</td>
</tr>
<tr id="trtitulogris">
<?php
    while($row_pv = $pv->FetchRow()) :
?>
  <td align="center">Total</td>
  <td align="center">%</td>
  <td align="center">Seguimiento</td>
  <td align="center">%</td>
  <td align="center">No Interesado</td>
  <td align="center">%</td>
<?php
    endwhile;
    $pv->MoveFirst();
?>
</tr>
<?php
    $sql_carrera = "select c.codigocarrera, c.nombrecarrera
    from carrera c
    where now() between c.fechainiciocarrera and c.fechavencimientocarrera
    $filtrocarrera
    $filtromodalidad
    order by 2";
    $carrera = $db->Execute($sql_carrera);
    $totalRows_carrera = $carrera->RecordCount();
    $totalinteresados = 0;
    $totalinteresadosSeg = 0;
    $totalinteresadosNoInt = 0;
    $totalinteresados2 = 0;
    $totalinteresadosSeg2 = 0;
    $totalinteresadosNoInt2 = 0;

    $fila = 0;
    while($row_carrera = $carrera->FetchRow()) :
        $data[$fila]['nombrecarrera'] = $row_carrera['nombrecarrera'];
        $totalfila = 0;
        $seg = new seguimiento($row_carrera['codigocarrera'], $_REQUEST['nacodigoperiodo']);
        while($row_pv = $pv->FetchRow()) :
            //$total = $seg->totalInteresadosUltimoSeguimiento();
            //$db->debug = true;
            $total = $seg->totalProcesosUltimoSeguimiento($row_pv['codigoprocesovidaestudiante']);
            //$totaldemas = $seg->totalDemasUltimoSeguimiento();
            $totalfila += $total['300']+$total['400'];
            $totalcolumna[$row_pv['codigoprocesovidaestudiante']]['300'] += $total['300'];
            $totalcolumna[$row_pv['codigoprocesovidaestudiante']]['400'] += $total['400'];
            $data[$fila][$row_pv['codigoprocesovidaestudiante']]['300'] = $total['300'];
            $data[$fila][$row_pv['codigoprocesovidaestudiante']]['400'] = $total['400'];
        endwhile;
        $pv->MoveFirst();
        $data[$fila]['totalfila'] = $totalfila;
        $fila++;
        endwhile;
    $totalfila = 0;
    foreach($totalcolumna as $key => $totales) :
        $totalfila += $totales['300']+$totales['400'];
    endforeach;
    $data['totalfin'] = $totalfila;
    for($fi = 0; $fi < $fila; $fi++) :
?>
<tr>
  <td><?php echo $data[$fi]['nombrecarrera']; ?></td>
<?php
        //$totalfila = 0;
        $totfi = $data[$fi]['totalfila'];
        while($row_pv = $pv->FetchRow()) :
            //$total = $seg->totalInteresadosUltimoSeguimiento();
            //$db->debug = true;

            //$totalcolumna[$row_pv['codigoprocesovidaestudiante']]['300'] += $total['300'];
            //$totalcolumna[$row_pv['codigoprocesovidaestudiante']]['400'] += $total['400'];
            //$data[$fi]['300'] = $total['300'];
            //$data[$fi]['300'] = $total['400'];
            $seg_total = $data[$fi][$row_pv['codigoprocesovidaestudiante']]['300'];
            $noint_total = $data[$fi][$row_pv['codigoprocesovidaestudiante']]['400'];
            $tot_total = $seg_total + $noint_total;

            if($totfi == 0)
            {
                $seg_por = 0;
                $noint_por = 0;
                $tot_por = 0;
            }
            else
            {
                $seg_por = $seg_total/$totfi*100;
                $noint_por = $noint_total/$totfi*100;
                $tot_por = $tot_total/$totfi*100;
            }

?>
  <td align="right"><?php echo "$tot_total";?></td>
  <td align="right"><?php echo round($tot_por,2);?>%</td>
  <td align="right"><?php echo "$seg_total";?></td>
  <td align="right"><?php echo round($seg_por,2);?>%</td>
  <td align="right"><?php echo "$noint_total";?></td>
  <td align="right"><?php echo round($noint_por,2);?>%</td>
<?php
        endwhile;
        $pv->MoveFirst();
        $totfi_por = 0;
        if($totfi != 0)
        {
            $totfi_por = $totfi/$totfi*100;
        }
?>
    <td align="right"><?php echo "$totfi";?></td>
    <td align="right"><?php echo round($totfi_por,2);?></td>
</tr>
<?php
    endfor;
?>
<tr id="trtitulogris">
  <td align="right">Total:</td>
<?php
    $totalfila = 0;
    $totfi = $data['totalfin'];
    //print_r($totalcolumna);
    foreach($totalcolumna as $key => $totales) :
        $totalfila += $totales['300']+$totales['400'];
        $tot_total = $totales['300']+$totales['400'];
        $seg_total = $totales['300'];
        $noint_total = $totales['400'];

        if($totfi == 0)
        {
            $seg_por = 0;
            $noint_por = 0;
            $tot_por = 0;
        }
        else
        {
            $seg_por = $seg_total/$totfi*100;
            $noint_por = $noint_total/$totfi*100;
            $tot_por = $tot_total/$totfi*100;
        }

?>
  <td align="right"><?php echo "$tot_total";?></td>
  <td align="right"><?php echo round($tot_por,2);?>%</td>
  <td align="right"><?php echo "$seg_total";?></td>
  <td align="right"><?php echo round($seg_por,2);?>%</td>
  <td align="right"><?php echo "$noint_total";?></td>
  <td align="right"><?php echo round($noint_por,2);?>%</td>
<?php
    endforeach;
?>
  <td align="right"><?php echo "$totalfila";?></td>
  <td align="right"><?php echo $totalfila/$totalfila*100;?></td>
</tr>
</table>
<br>
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Restablecer" onClick="window.location.href='seguimientogeneral.php')"><input type="button" value="Regresar" onClick="window.location.href='menuseguimiento.php'">
<input type="submit" value="Exportar a Excel" name="formato" />
<?php
}
?>
</form>
</body>
<script language="javascript">
function enviar()
{
    document.f1.submit();
}
</script>
</html>
