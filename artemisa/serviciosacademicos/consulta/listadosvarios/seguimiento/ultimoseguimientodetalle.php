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
<td id="tdtitulogris">
  Tipo Seguimiento: </td>
<td>
<select name="codigotipoestudianteseguimiento">
  <option value="0"<?php if (!(strcmp("0", $_REQUEST['codigotipoestudianteseguimiento']))) {echo "SELECTED";} ?>>
      Seleccionar
  </option>
  <option value="300"<?php if (!(strcmp("300", $_REQUEST['codigotipoestudianteseguimiento']))) {echo "SELECTED";} ?>>SEGUIMIENTO</option>
  <option value="400"<?php if (!(strcmp("400", $_REQUEST['codigotipoestudianteseguimiento']))) {echo "SELECTED";} ?>>NO INTERESADO (Se detiene el seguimiento)</option>
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
if(isset($_REQUEST['naenviar']) || isset($_REQUEST['formato']))
{
    if($_REQUEST['codigotipoestudianteseguimiento'] == 0)
    {
?>
<script type="text/javascript">
    alert("Debe seleccionar le tipo de seguimiento que quiere visualizar");
    history.go(-1);
</script>
<?php
        exit();
    }
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

    //$db->debug=true;
    $sql_pvd = "select nombretipodetalleestudianteseguimiento, idtipodetalleestudianteseguimiento
    from tipodetalleestudianteseguimiento
    where codigotipoestudianteseguimiento = ".$_REQUEST['codigotipoestudianteseguimiento']."";
    $pvd = $db->Execute($sql_pvd);
    $totalRows_pvd = $pvd->RecordCount();

    while($row_pv = $pv->FetchRow()) :
    unset($totalF);
?>
<h2><?php echo $row_pv['nombreprocesovidaestudiante'];?></h2>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr id="trtitulogris">
  <td rowspan="2" align="center">Facultad</td>
  <td colspan="<?php echo $totalRows_pvd*2+2; ?>" align="center">Tipo detalle seguimiento --
<?php
    if (!(strcmp("300", $_REQUEST['codigotipoestudianteseguimiento']))) {echo "SEGUIMIENTO";}
    if (!(strcmp("400", $_REQUEST['codigotipoestudianteseguimiento']))) {echo "NO INTERESADO (Se detiene el seguimiento)";}
?></td>
</tr>
<!--<tr id="trtitulogris">
  <td colspan="<?php echo $totalRows_pvd+1; ?>" align="center">Interesados</td>
  <td colspan="<?php echo $totalRows_pvd+1; ?>" align="center">Demás</td>
</tr>
-->
<tr id="trtitulogris">
<?php
    while($row_pvd = $pvd->FetchRow()) :
?>
  <td align="center"><?php echo $row_pvd['nombretipodetalleestudianteseguimiento'];?></td>
  <td align="center">%</td>
<?php
    endwhile;
    $pvd->MoveFirst();
?>
  <td align="right">Total</td>
  <td align="right">%</td>
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

    $fila = 0;
    while($row_carrera = $carrera->FetchRow()) :
        $data[$fila]['nombrecarrera'] = $row_carrera['nombrecarrera'];
        $seg = new seguimiento($row_carrera['codigocarrera'], $_REQUEST['nacodigoperiodo']);

        $totalcol1 = 0;
        while($row_pvd = $pvd->FetchRow()) :
            $total = $seg->totalProcesosUltimoSeguimientoDetalle($row_pv['codigoprocesovidaestudiante'], $row_pvd['idtipodetalleestudianteseguimiento'], $_REQUEST['codigotipoestudianteseguimiento']);

            $totalcol1 += $total;
            $totalF[$row_pvd['idtipodetalleestudianteseguimiento']] += $total;
            $data[$fila][$row_pvd['idtipodetalleestudianteseguimiento']]['total'] = $total;
        endwhile;
        $pvd->MoveFirst();
        $data[$fila]['totalcol1'] = $totalcol1;
        $fila++;
    endwhile;
    for($fi = 0; $fi < $fila; $fi++) :
?>
<tr>
  <td><?php echo $data[$fi]['nombrecarrera']; ?></td>
<?php
        $totalcol1 = $data[$fi]['totalcol1'];
        while($row_pvd = $pvd->FetchRow()) :
            $total = $data[$fi][$row_pvd['idtipodetalleestudianteseguimiento']]['total'];
            if($totalcol1 != 0)
            {
                $tot_por = $total/$totalcol1*100;
                $totcol_por = $totalcol1/$totalcol1*100;
            }
            else
            {
                $tot_por = 0;
                $totcol_por = 0;
            }
?>
  <td align="right"><?php echo "$total";?></td>
  <td align="right"><?php echo round($tot_por,2);?>%</td>
<?php
        endwhile;
        $pvd->MoveFirst();
?>
  <td align="right"><?php echo "$totalcol1"; ?></td>
  <td align="right"><?php echo round($totcol_por,2); ?>%</td>
<?php
    endfor;
?>
</tr>
<tr id="trtitulogris">
  <td align="right">Total:</td>
<?php
    $totalcol1 = 0;
    foreach($totalF as $key => $totales) :
        $totalcol1 += $totales;
?>
<!--  <td align="right"><?php echo $totales;?></td>-->
<?php
    endforeach;

    foreach($totalF as $key => $totales) :
        if($totalcol1 != 0)
        {
            $tot_por = $totales/$totalcol1*100;
        }
        else
        {
            $tot_por = 0;
        }
?>
  <td align="right"><?php echo "$totales";?></td>
  <td align="right"><?php echo round($tot_por,2);?>%</td>
<?php
    endforeach;
    $totcol_por = 0;
    if($totalcol1 != 0)
    {
        $totcol_por = $totalcol1/$totalcol1*100;
    }
?>
  <td align="right"><?php echo "$totalcol1";?></td>
  <td align="right"><?php echo round($totcol_por,2);?>%</td>
</tr>
</table>
<?php
    endwhile;
?>
<br>
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Restablecer" onClick="window.location.href='seguimientogeneral.php'"><input type="button" value="Regresar" onClick="window.location.href='menuseguimiento.php'">
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
