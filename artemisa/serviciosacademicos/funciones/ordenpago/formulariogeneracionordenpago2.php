<?
require_once('Cimpresionescyc.php');
session_start();
$ruta="../";
require_once('claseordenpago.php');
mysql_select_db($database_sala, $sala);
//$_GET['numeroordenpago'] = 1021839;
// En un comienzo cogia el periodo menor, ahora debe coger el periodo de la sesion
$query_selperiodo = "select p.codigoperiodo, p.codigoestadoperiodo
from periodo p
where p.codigoestadoperiodo not like '2%'
and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
order by 2 desc";

$selperiodo = mysql_query($query_selperiodo, $sala) or die("$query_selperiodo");
$totalRows_selperiodo = mysql_num_rows($selperiodo);
$row_selperiodo = mysql_fetch_array($selperiodo);
$codigoperiodo = $row_selperiodo['codigoperiodo'];
$codigoestudiante = $_GET['codigoestudiante'];
$codigocarrera = $_GET['codigocarrera'];
$numeroordenpago = $_GET['numeroordenpago'];

$ordenjoda = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago, $idprematricula=1, $fechaentregaordenpago=0, $codigoestadoordenpago=70);

if(isset($_GET['crearorden']))if(!@$ordenjoda->existe_ordenpago())$ordenjoda->insertarordenpago();

if(isset($_GET['Activar'])){

	$query_selgrupos = "select dp.idgrupo, dp.codigomateria from detalleprematricula dp, prematricula p
	where dp.idprematricula = p.idprematricula and p.codigoestudiante = '$codigoestudiante' and p.codigoperiodo = '$codigoperiodo'
	and (dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '3%')
	and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')";
        
	$selgrupos=mysql_query($query_selgrupos,$sala) or die("$query_selgrupos".mysql_error());
	$totalRows_selgrupos = mysql_num_rows($selgrupos);
	while($row_selgrupos = mysql_fetch_array($selgrupos)){
		$materiascongrupo[] = $row_selgrupos['idgrupo'];		
	}
	if($ordenjoda->existe_ordeninternaocentrobeneficio($ordeninternaocentrobeneficio, $materiascongrupo, $tipoorden)){
		$query_updorden = "update ordenpago set codigoestadoordenpago = '10' where numeroordenpago = '$numeroordenpago'";
		$updorden = mysql_query($query_updorden, $sala) or die("$query_updorden");
		$ordenjoda->enviarsap_orden($materiascongrupo[0]);
	}else{
            echo "<script>alert('La orden no se deja activar por que no tiene centro de beneficio, o por que no posee orden interna')</script>";
        }
    echo "<script>window.location.href='../../consulta/prematricula/matriculaautomaticaordenmatricula.php'</script>";
    exit();
}
$query_selordenes = "select o.numeroordenpago from ordenpago o where o.codigoestudiante = '$codigoestudiante' and o.codigoestadoordenpago like '7%'";

$selordenes = mysql_query($query_selordenes, $sala) or die("$query_selordenes");
$totalRows_selordenes = mysql_num_rows($selordenes);
?>
<html>
<head>
<!-- Page styles -->
<link type='text/css' href='css/demo.css' rel='stylesheet' media='screen' />

<!-- Contact Form CSS files -->
<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />

<!-- IE6 "fix" for the close png image -->
<!--[if lt IE 7]>
<link type='text/css' href='css/basic_ie.css' rel='stylesheet' media='screen' />
<![endif]-->

<!-- JS files are loaded at the bottom of the page -->

<style type="text/css">
<!--
.Estilo1 {font-family: tahoma;	font-size: x-small;}
.Estilo19 {font-weight: bold}
.Estilo20 {font-size: xx-small}
.Estilo21 {font-size: 12px}
-->
</style>
<title>Orden de PAgo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<script>
    function recargar(dir){
	window.location.href="formulariogeneracionordenpago.php"+dir;
	history.go();
    }
</script>
<body>


<div id='container'>	
	<div id='content'>
		<!-- modal content -->
		<div id="basic-modal-content">
                        <div id="ordenpagoid">
                        </div>			
		</div>
                <div id="detalle">
                        <div id="additems">agregar detalles
                        </div>
		</div>
		<!-- preload the images -->
		<div style='display:none'>
			<img src='img/basic/x.png' alt='' />
		</div>
	</div>
	<div id='footer'>
	</div>
</div>
<!-- Load jQuery, SimpleModal and Basic JS files -->



<form name="form1" method="get" action="">
<input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?=$codigoestudiante;?>">
<input type="hidden" name="codigocarrera" id="codigocarrera" value="<?=$codigocarrera;?>">
<div align="center">
    <p class="Estilo1 Estilo2  Estilo7 Estilo1"><strong>ORDENES EN CONSTRUCCI&Oacute;N</strong><br>
<?
if(!isset($_GET['numeroordenpago'])){
	$numeroordenpagojoda = $ordenjoda->tomar_numeroordenpago();
?>
<select name="numeroordenpago" onChange="form1.submit()">
<option value="<?=$numeroordenpagojoda?>">Seleccionar</option>
<?
	while($row_selordenes = mysql_fetch_array($selordenes))	{
            echo '<option value="'.$row_selordenes['numeroordenpago'].'"';
            if($_GET['numeroordenpago'] == $row_selordenes['numeroordenpago']) echo "selected";
            echo ">".$row_selordenes['numeroordenpago']. "</option>";
	}
?>
</select>
<?}?>
</p>
<br><br>
<?
if(!isset($_GET['numeroordenpago'])) echo "<div id='basic-modal'><input type='button' name='basic' value='Crear Orden' class='basic'/></div>";


if(isset($_GET['numeroordenpago']) || $_GET['crearorden']){

     $orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago);

        if(isset($_GET['crearcuentas']))
	{
		if(!$orden->tiene_cuentabancoorden())
		{
			$orden->insertarbancosordenpago();
		}
	}

	$query_dataestudiante= "SELECT e.codigocarrera, e.codigoperiodo, eg.numerodocumento, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre,
	c.nombrecarrera, t.nombretipocliente, te.codigoreferenciatipoestudiante, c.codigoindicadortipocarrera, e.idestudiantegeneral,
	e.codigoestudiante, eg.numerodocumento
	FROM estudiante e, carrera c, estudiantegeneral eg, tipocliente t, tipoestudiante te
	WHERE e.codigoestudiante = '$codigoestudiante'
	AND e.codigocarrera = c.codigocarrera
	and eg.idestudiantegeneral = e.idestudiantegeneral
	and eg.codigotipocliente = t.codigotipocliente
	and e.codigotipoestudiante = te.codigotipoestudiante
	and e.codigocarrera = '$codigocarrera'";
	
	$dataestudiante=mysql_query($query_dataestudiante,$sala) or die("$query_dataestudiante".mysql_error());
	$totalRows_dataestudiante = mysql_num_rows($dataestudiante);
	$row_dataestudiante = mysql_fetch_array($dataestudiante);

	$query_selgrupos = "select dp.idgrupo, dp.codigomateria
	from detalleprematricula dp, prematricula p
	where dp.idprematricula = p.idprematricula
	and p.codigoestudiante = '$codigoestudiante'
	and p.codigoperiodo = '$codigoperiodo'
	and (dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '3%')
	and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')";
	
	$selgrupos=mysql_query($query_selgrupos,$sala) or die("$query_selgrupos".mysql_error());
	$totalRows_selgrupos = mysql_num_rows($selgrupos);
	while($row_selgrupos = mysql_fetch_array($selgrupos))
	{
		$materiascongrupo[] = $row_grupos['idgrupo'];
	}
	$orden->existe_ordeninternaocentrobeneficio(&$ordeninternaocentrobeneficio, $materiascongrupo=0, $tipoorden);
	$numeroordenpago = $orden->tomar_numeroordenpago();
	$idsubperiodo = $orden->tomar_idsubperiodo();
	//numerodocumento_ordenpago
?>
<input type="hidden" name="codigoestudiante" value="<?=$codigoestudiante; ?>">
<input type="hidden" name="codigocarrera" value="<?=$codigocarrera; ?>">
<input type="hidden" name="codigoperiodo" value="<?=$codigoperiodo; ?>">
<input type="hidden" name="numeroordenpago" value="<?=$numeroordenpago; ?>">

  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
      <td class="Estilo1"><div align="center" class="Estilo19">Id General</div></td>
      <td class="Estilo1"><div align="center" class="Estilo19">Id Estudiante</div></td>
      <td class="Estilo1"><div align="center" class="Estilo19"><?=$tipoorden;?></div></td>
      <td class="Estilo1"><div align="center" class="Estilo19">Subperiodo</div></td>
      <td class="Estilo1"><div align="center" class="Estilo19">Cuenta por Cobrar</div></td>
      <td class="Estilo1"><div align="center" class="Estilo19">Cuenta Compensaci&oacute;n</div></td>
      <td class="Estilo1"><div align="center" class="Estilo19">Fecha de Pago</div></td>
    </tr>
    <tr>
      <td class="Estilo1"><div align="center"><span ><?=$row_dataestudiante['idestudiantegeneral'];?>&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span ><?=$row_dataestudiante['codigoestudiante'];?>&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span ><?if($ordeninternaocentrobeneficio != "") echo $ordeninternaocentrobeneficio; else echo "No tiene"?>&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span ><?=$idsubperiodo;?>&nbsp;</span></div></td>
      <td class="Estilo1" ><div align="center"><span ><?=$row_dataestudiante['documentocuentaxcobrarsap'];?>&nbsp;</span></div></td>
      <td class="Estilo1" ><div align="center"><span ><?=$row_dataestudiante['documentocuentacompensacionsap'];?>&nbsp;</span></div></td>
      <td class="Estilo1" ><div align="center"><span ><?=$row_dataestudiante['fechapagosapordenpago'];?>&nbsp;</span></div></td>
    </tr>
 </table>
 <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6">
      <td class="Estilo1"> <div align="center" class="Estilo19">No. Orden</div></td>
      <td class="Estilo1" > <div align="center" class="Estilo19">Carrera</div></td>
      <td class="Estilo1"> <div align="center" class="Estilo19">Periodo</div></td>
      <td class="Estilo1" > <div align="center" class="Estilo19">Tipo de Cliente</div></td>
    </tr>
    <tr>
      <td class="Estilo1"><div align="center"><span ><?=$orden->tomar_numeroordenpago();?></span></div></td>
      <td class="Estilo1" ><div align="center"><span ><?=$row_dataestudiante['nombrecarrera'];?></span></div></td>
      <td class="Estilo1"><div align="center"><span ><?=$orden->tomar_codigoperiodo();?></span></div></td>
      <td class="Estilo1" ><div align="center"><span ><?=$row_dataestudiante['nombretipocliente'];?></span></div></td>
    </tr>
    <tr bgcolor="#C5D5D6">
      <td class="Estilo1"> <div align="center" class="Estilo20"><strong>Fecha </strong></div></td>
      <td class="Estilo1"><div align="center" class="Estilo20"><strong>Nombre Estudiante</strong></div></td>
      <td class="Estilo1" colspan="2"><div align="center" class="Estilo20"><strong>Documento</strong></div></td>
    </tr>
    <tr>
      <td class="Estilo1"><div align="center"><span ><?=date("Y-m-d");?>&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span ><?=$row_dataestudiante['nombre'];?>&nbsp;</span></div></td>
      <td class="Estilo1" colspan="3"><div align="center"><span ><?=$row_dataestudiante['numerodocumento'];?>&nbsp;</span></div></td>
    </tr>
    <tr bordercolor="#336633">
      <td colspan="4" class="Estilo1"> <div align="center"><strong>DETALLE ORDEN DE PAGO</strong></div></td>
    </tr>
    <tr bgcolor="#C5D5D6">
      <td class="Estilo1" width="20%"> <div align="center" class="Estilo20"><strong>C&oacute;digo Concepto </strong></div></td>
      <td class="Estilo1" width="50%"> <div align="center" class="Estilo20"><strong>Concepto</strong></div></td>
      <td class="Estilo1" width="10%"> <div align="center" class="Estilo20"><strong>Cantidad</strong></div></td>
      <td class="Estilo1" width="20%"> <div align="center" class="Estilo20"><strong>Valor</strong></div></td>
    </tr>  
<?
	$banderadeudas = 0;
	$deuda="SELECT * FROM detalleordenpago d,concepto c,tipoconcepto t
	WHERE d.numeroordenpago = '$numeroordenpago'
	AND d.codigoconcepto = c.codigoconcepto AND c.codigotipoconcepto = t.codigotipoconcepto";
	$query=mysql_query($deuda,$sala);
	$totalRows_seldeudas = mysql_num_rows($query);
	$solucion=mysql_fetch_array($query);
	$fechaconpecuniarios = false;
	if($totalRows_seldeudas != ""){
		do{
			if($solucion['codigotipodetalleordenpago'] == '2' )$banderadeudas = 1;			
			if($solucion['codigotipodetalleordenpago'] == '3' )$fechaconpecuniarios = true;			
?>  
  
    <tr>
    <td class=" Estilo1"  width="20%" align="center"><span ><strong><strong><?=$solucion['codigoconcepto'];?></strong></strong></span></td>
    <td class=" Estilo1"  width="50%" align="left"><span ><strong>
<?
			echo $solucion['nombreconcepto'];
			if($solucion['codigotipoconcepto'] == 01)echo "(+)";
			if($solucion['codigotipoconcepto'] == 02)echo "(-)";			
?>
	</strong></span></td>
    <td class=" Estilo1" width="10%" align="center"><span ><strong><strong><?=$solucion['cantidaddetalleordenpago'];?></strong></strong></span></td>
    <td class=" Estilo1" width="20%" align="right"><span >$&nbsp;&nbsp;<?=number_format($solucion['valorconcepto'],2);?></span></td>
  </tr>
</table>
  <span class=" Estilo1">
<?
		}while ($solucion=mysql_fetch_array($query));
	}
?>
<table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td class=" Estilo1" align="center" colspan="4"><span ><strong><strong><input type="button" value="Adicionar" name="AdicionarDetalle" onClick="<?
	echo "window.open('ordenmanual/adicionardetalle.php?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo','miventana','width=700,height=200,top=200,left=150,scrollbars=yes')";
	?>" style="width: 80px">
<?
	if($totalRows_seldeudas != "")	{
?>
<input type="button" value="Editar" name="EditarDetalle" onClick="<?
	echo "window.open('ordenmanual/editardetalle.php?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo','miventana','width=700,height=200,top=200,left=150,scrollbars=yes')";
	?>" style="width: 80px">
<input type="button" value="Eliminar" name="EditarDetalle" onClick="<?
	echo "window.open('ordenmanual/eliminardetalle.php?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo','miventana','width=700,height=200,top=200,left=150,scrollbars=yes')";
	?>" style="width: 80px">
<?
	}
?>
    </strong></strong></span></td>
  </tr>
 </table>
<?
	if($totalRows_seldeudas != "")	{
?>
<table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bordercolor="#006600">
      <td colspan="4" class=" Estilo1"><div align="center"><strong>FECHAS DE PAGO</strong></div></td>
  </tr>
  <tr bgcolor="#C5D5D6">
      <td width="232" class=" Estilo1"><div align="center"><strong>Tipo de Matricula </strong></div></td>
      <td width="200" class=" Estilo1"><div align="center"><strong>Paguese Hasta </strong></div></td>
      <td width="175" class=" Estilo1"><div align="center"><strong>Total a Pagar </strong></div></td>
  </tr>
</table>
  <span class="Estilo1">  </span>
<table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#FF9900">
<?php
		if(!ereg("^3.+$",$row_dataestudiante['codigoindicadortipocarrera'])){
			$fecha="select distinct f.fechaordenpago, f.porcentajefechaordenpago, d.nombredetallefechafinanciera, f.valorfechaordenpago
			from fechaordenpago f, detallefechafinanciera d
			where f.fechaordenpago = d.fechadetallefechafinanciera
			and f.porcentajefechaordenpago = d.porcentajedetallefechafinanciera
			and f.numeroordenpago = '$numeroordenpago'
			order by f.porcentajefechaordenpago";			
		}else{
			$fecha="select distinct f.fechaordenpago, f.porcentajefechaordenpago, d.nombredetallefechaeducacioncontinuada as nombredetallefechafinanciera, f.valorfechaordenpago
			from fechaordenpago f, detallefechaeducacioncontinuada d
			where f.fechaordenpago = d.fechadetallefechaeducacioncontinuada
			and f.porcentajefechaordenpago = d.porcentajedetallefechaeducacioncontinuada
			and f.numeroordenpago = '$numeroordenpago'
			order by f.porcentajefechaordenpago";			
		}
		
		$queryfechas=mysql_query($fecha,$sala);
		$totalRows_selfechas = mysql_num_rows($queryfechas);
		$fechas=mysql_fetch_array($queryfechas);
		if($totalRows_selfechas == ""){
			$fecha="select distinct f.fechaordenpago, f.porcentajefechaordenpago, f.valorfechaordenpago
			from fechaordenpago f
			where f.numeroordenpago = '$numeroordenpago'
			order by f.porcentajefechaordenpago";			
			$queryfechas=mysql_query($fecha,$sala);
			$totalRows_selfechas = mysql_num_rows($queryfechas);
			$fechas=mysql_fetch_array($queryfechas);
			$fechas['nombredetallefechafinanciera'] = "Pago 1";
		}
		if($totalRows_selfechas != ""){
			$contadorfechas = 1;

			do{
?>
    <tr>
    <td width="232" class=" Estilo1"><div align="center"><span ><?echo "Pago $contadorfechas";?></span></div></td>
    <td width="200" class=" Estilo1"><div align="center"><span ><?=$fechas['fechaordenpago'];?></span></div></td>
    <td width="175" class=" Estilo1"><div align="center"><span >$&nbsp;<?=number_format($fechas['valorfechaordenpago'],2);?></span></div></td>
  </tr>
<?
				$contadorfechas ++;
			}
			while($fechas=mysql_fetch_array($queryfechas));
		}
?>
 <tr>
    <td class=" Estilo1" colspan="3" align="center"><input type="button" value="Adicionar" name="AdicionarFecha" onClick="<?
	echo "window.open('ordenmanual/adicionarfecha.php?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo&codigoindicadortipocarrera=".$row_dataestudiante['codigoindicadortipocarrera']."','miventana','width=700,height=200,top=200,left=150')";
	?>" style="width: 80px">
	<?
	if($totalRows_selfechas != ""){
?>
<input type="button" value="Editar" name="EditarDetalle" onClick="<?
	echo "window.open('ordenmanual/editarfecha.php?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo&codigoindicadortipocarrera=".$row_dataestudiante['codigoindicadortipocarrera']."','miventana','width=700,height=200,top=200,left=150')";
	?>" style="width: 80px">
<input type="button" value="Eliminar" name="EditarDetalle" onClick="<?
	echo "window.open('ordenmanual/eliminarfecha.php?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo&codigoindicadortipocarrera=".$row_dataestudiante['codigoindicadortipocarrera']."','miventana','width=700,height=200,top=200,left=150')";
	?>" style="width: 80px">
<?
	}
?>
</td>
  </tr>
</table>
<?
	}
	if($totalRows_seldeudas != "" && $totalRows_selfechas != ""){
?>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr><td colspan="4" class=" Estilo1"><div align="center"><strong>CUENTAS BANCARIAS </strong></div></td></tr>
    <tr bgcolor="#C5D5D6">
      <td width="145" class=" Estilo1"><div align="center"><strong>C&oacute;digo Banco </strong></div></td>
      <td width="295" class=" Estilo1"><div align="center"><strong>Nombre Banco </strong></div></td>
      <td width="169" class=" Estilo1"><div align="center"><strong>Cuenta Banco </strong></div></td>
    </tr>
  </table>
<?
		$banco="SELECT *
		FROM cuentabanco c,banco b, cuentabancoordenpago cb
		WHERE c.codigocarrera = '".$row_dataestudiante['codigocarrera']."'
		AND c.codigobanco = b.codigobanco
		AND c.codigoperiodo = '$codigoperiodo'
		AND cb.numeroordenpago = '$numeroordenpago'
		AND cb.idcuentabanco = c.idcuentabanco
		order by 4 desc";
		$banco5=mysql_query($banco,$sala);
		$totalRows_selbancos = mysql_num_rows($banco5);
		$bancos=mysql_fetch_array($banco5);
		if(! $bancos){
			$banco="SELECT *
			FROM cuentabanco c, banco b, cuentabancoordenpago cb
			WHERE  c.codigobanco = b.codigobanco
			AND c.codigoperiodo = '$codigoperiodo'
			AND codigocarrera = '1'
			AND cb.numeroordenpago = '$numeroordenpago'
			AND cb.idcuentabanco = c.idcuentabanco
			order by 4 desc";
			$banco5=mysql_query($banco,$sala);
			$totalRows_selbancos = mysql_num_rows($banco5);
			$bancos=mysql_fetch_array($banco5);
		}		
		if($totalRows_selbancos != ""){
			do{
?>
  </span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#FF9900">
    <tr>
    <td width="146" class=" Estilo1"><div align="center"><span ><?=$bancos['codigobanco'];?></span></div></td>
    <td width="295" class=" Estilo1"><div align="center"><span ><?=$bancos['nombrebanco'];?></span></div></td>
    <td width="168" class=" Estilo1"><div align="center"><span ><?=$bancos['numerocuentabanco'];?> </span></div></td>
  </tr>
</table>
<?
			}while($bancos=mysql_fetch_array($banco5));
		}else{
?>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#FF9900">
    <tr><td class="Estilo1" align="center"><input type="submit" name="crearcuentas" value="Crear Cuentas Bancarias"></td></tr>
 </table>
<?
		}
	}
}
if($totalRows_seldeudas != "" && $totalRows_selfechas != "" && $totalRows_selbancos != ""){
    echo '<br><input type="submit" name="Activar" value="Activar Orden">';
}
?>
 <input type="button" name="regresar" value="Regresar" onClick="window.location.href='../../consulta/prematricula/matriculaautomaticaordenmatricula.php'">
</div>
</form>
<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='js/basic.js'></script>
</body>
</html>