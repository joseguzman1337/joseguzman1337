<?php
/*$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
include($rutazado.'zadodb-pager.inc.php');
require_once('../../../funciones/sala/seguimiento/seguimiento.php');*/
if(isset($_SESSION['debug_sesion']))
{
    $db->debug = true;
}
//$db->debug = true;
//print_r($_SERVER);
//print_r($arregloperiodos);

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
        <td rowspan="1" align="center">Facultad</td>
        <td rowspan="1" align="center">Periodo</td>
        <td rowspan="1" align="center">Fecha</td>
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
    and codigoindicadorprocesovidaestudiante like '1%'
    order by 2";
}
else
{
    $sql_pv = "select nombreprocesovidaestudiante, codigoprocesovidaestudiante
    from procesovidaestudiante
    where codigoestado like '1%'
    and codigoprocesovidaestudiante in ($filtropv)
    and codigoindicadorprocesovidaestudiante like '1%'
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
      <td colspan="1" align="center"><?php echo $row_pv['nombreprocesovidaestudiante']; ?></td>
<?php
endwhile;
$pv->MoveFirst();
?>
<!--    </tr>
    <tr id="trtitulogris">-->
<?php
/*while($row_pv = $pv->FetchRow()) :
?>
                    <td align="left">Total <?php //echo $row_pv['nombreprocesovidaestudiante']; ?></td>
                    <td align="left">Seg.</td>
                    <td align="left">%</td>
                    <?php
endwhile;
$pv->MoveFirst();*/

$sql_carrera = "select c.codigocarrera, c.nombrecarrera
from carrera c
where now() between c.fechainiciocarrera and c.fechavencimientocarrera
$filtrocarrera
$filtromodalidad
order by 2";
$carrera = $db->Execute($sql_carrera);
$totalRows_carrera = $carrera->RecordCount();

$cuentaperiodos = count($arregloperiodos);

while($row_carrera = $carrera->FetchRow()) :
    foreach($arregloperiodos as $codigoperiodo => $fechaperiodo) :
?>
    <tr>
      <td><?php echo $row_carrera['nombrecarrera']; ?></td>
      <td align="right"><?php echo $codigoperiodo;?></td>
      <td align="right"><?php echo $fechaperiodo;?></td>

<?php
        $seg = new seguimiento($row_carrera['codigocarrera'], $codigoperiodo, $fechaperiodo);
    while($row_pv = $pv->FetchRow()) :
        //$db->debug = true;
        $total = $seg->totalProcesos($row_pv['codigoprocesovidaestudiante']);
        //$seguimiento = $seg->totalProcesosSeguimiento($row_pv['codigoprocesovidaestudiante']);

        $totalA[$row_pv['codigoprocesovidaestudiante']][$codigoperiodo] += $total;
        $porcentaje = 0;
        if($total != 0)
            $porcentaje = $seguimiento / $total * 100;
?>
    <td align="right"><?php echo $total;?></td>
<?php
    endwhile;
    $pv->MoveFirst();
?>
      </tr>
<?php
    endforeach;
endwhile;
?>
</tr>
<?php
foreach($arregloperiodos as $codigoperiodo => $fechaperiodo) :
?>
<tr id="trtitulogris">
        <td align="right">Total <?php echo $codigoperiodo; ?>:</td>
        <td align="right"><?php echo $codigoperiodo;?></td>
        <td align="right"><?php echo $fechaperiodo;?></td>
<?php
foreach($totalA as $key => $totalesA) :
    $porcentaje = 0;
    if($totalesA['total'] != 0)
        $porcentaje = $totalesA['seg'] / $totalesA['total'] * 100;
?>
        <td align="right"><?php echo $totalesA[$codigoperiodo];?></td>
<!--        <td align="right"><?php echo $totalesA['seg'];?></td>
        <td align="right"><?php echo round($porcentaje,1);?>%</td>-->
<?php
endforeach;
?>
    </tr>
<?php
endforeach;
?>
</table>
<br>
        <input type="submit" value="Enviar" name="naenviar"><input type="button" value="Regresar" onClick="window.location.href='seguimientogeneral.php'">
<input type="submit" value="Exportar a Excel" name="formato" />
