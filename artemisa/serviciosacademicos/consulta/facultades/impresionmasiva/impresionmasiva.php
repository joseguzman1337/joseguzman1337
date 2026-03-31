<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php'); 
include($rutazado.'zadodb-pager.inc.php');

session_start();
$codigocarrera = $_SESSION['codigofacultad'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];
if(isset($_SESSION['debug_sesion']))
{
	$db->debug = true; 
}
//$db->debug = true;
//print_r($_SESSION);
if($_REQUEST['naipseleccionaimpresora'] != 0 || !isset($_REQUEST['naimprimir']))
{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Impresión Masiva de Ordenes</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<form action="" method="post" name="f1">
<?php
}
if(isset($_REQUEST['naimprimir']))
{
	if($_REQUEST['naipseleccionaimpresora'] != 0)
	{
?>
<p>Se han impreso las siguientes ordenes de pago</p>
<?php
		foreach($_REQUEST as $key => $value)
		{
			if(ereg("naselect",$key))
			{
				$numeroordenpago = $value;
				$str .= "o.numeroordenpago = '$numeroordenpago' or ";
				require("imprimir.php");
			}
		}
		$str = ereg_replace("or $","",$str);
		$sql = "select o.numeroordenpago, e.codigoestudiante, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, eo.nombreestadoordenpago,
		fo.valorfechaordenpago, fo.fechaordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c, estadoordenpago eo
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and eo.codigoestadoordenpago = o.codigoestadoordenpago
		and fo.porcentajefechaordenpago = '0'
		and e.codigocarrera = '$codigocarrera'
		and o.codigoperiodo = '$codigoperiodo'
		and ($str)";
		$rs = $db->Execute($sql);
		$totalRows_rs = $rs->RecordCount();
?>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php
		if($totalRows_rs != "")
		{
			require($rutazado.'ztohtml.inc.php');
			rs2html($rs,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"',array('Orden de Pago','ID Estudiante','Documento','Nombre','Estado Orden','Valor','Fecha Pago','Semestre'));
		}
		else
		{
?>
<tr>
<td id="tdtitulogris">No Se Imprimieron Ordenes de Pago</td>
</tr>
<?php
		}
?>
</table>
<br>
<br>
<?php
	}
	else
	{
		// Se genera pdf
		require_once('../../../funciones/clases/fpdf/fpdf.php');
		require_once("../../../Connections/salaado-pear.php");
		require_once("obtener_datos.php");
		require_once("../../../funciones/ordenpago/factura_pdf/ean128.php");
			//require_once("../../../consulta/facultades/admision/informes/funciones/imprimir_arrays_bidimensionales.php");
		define('FPDF_FONTPATH','../../../funciones/clases/fpdf/font/');
		setlocale(LC_MONETARY, 'en_US');
		error_reporting(0);
		$factura=new FPDF("P","cm","letter");
		$factura->AddFont('code128','','code128.php');
		foreach($_REQUEST as $key => $value)
		{
			//echo "$key => $value<br>";
			if(ereg("naselect",$key))
			{
				//exit();
				$numeroordenpago = $value;
				$query_selcodigoestudiante = "SELECT codigoestudiante
				FROM ordenpago
				where numeroordenpago = '$numeroordenpago'";
				$selcodigoestudiante = $db->Execute($query_selcodigoestudiante);
				$totalRows_selcodigoestudiante = $selcodigoestudiante->RecordCount();
				$row_selcodigoestudiante = $selcodigoestudiante->FetchRow(); 
				
				$codigoestudiante = $row_selcodigoestudiante['codigoestudiante'];
				$str .= "o.numeroordenpago = '$numeroordenpago' or ";
				require("facturamasiva.php");
			}
		}
		$factura->Output();
		$str = ereg_replace("or $","",$str);
		$sql = "select o.numeroordenpago, e.codigoestudiante, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, eo.nombreestadoordenpago,
		fo.valorfechaordenpago, fo.fechaordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c, estadoordenpago eo
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and eo.codigoestadoordenpago = o.codigoestadoordenpago
		and fo.porcentajefechaordenpago = '0'
		and e.codigocarrera = '$codigocarrera'
		and o.codigoperiodo = '$codigoperiodo'
		and ($str)";
		$rs = $db->Execute($sql);
		$totalRows_rs = $rs->RecordCount();
?>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php
		if($totalRows_rs != "")
		{
			require($rutazado.'ztohtml.inc.php');
			rs2html($rs,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"',array('Orden de Pago','ID Estudiante','Documento','Nombre','Estado Orden','Valor','Fecha Pago','Semestre'));
		}
		else
		{
?>
<tr>
<td id="tdtitulogris">No Se Imprimieron Ordenes de Pago Pdf</td>
</tr>
<?php
		}
?>
</table>
<br>
<br>
<?php
	}
}
?>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr>
	<td colspan="2"><label id="labelresaltado">Seleccione los filtros que desee para efectuar la consulta y Seleccione las órdenes que desea imprimir</label></td>
  </tr>
</tr>
<tr>
<td id="tdtitulogris">
  Concepto<label id="labelresaltado"></label>
</td>
<td>
<?php
$query_concepto = "SELECT codigoconcepto, nombreconcepto
FROM concepto
where codigoestado like '1%'
order by 2";
$concepto = $db->Execute($query_concepto);
$totalRows_concepto = $concepto->RecordCount();
$row_concepto = $concepto->FetchRow(); 
?>
  <select name="nacodigoconcepto">
    <option value="0"<?php if (!(strcmp("0", $_REQUEST['nacodigoconcepto']))) {echo "SELECTED";} ?>>
      Seleccionar
    </option>
<?php
do 
{
?>
    <option value="<?php echo $row_concepto['codigoconcepto']?>" <?php if (!(strcmp($row_concepto['codigoconcepto'], $_REQUEST['nacodigoconcepto']))) {echo "SELECTED";} ?>>
      <?php echo $row_concepto['nombreconcepto']?>
    </option>
    <?php
}
while($row_concepto = $concepto->FetchRow());
?>
  </select>
</td>
</tr>
<tr>
<td id="tdtitulogris">
  Estado Orden Pago<label id="labelresaltado"></label>
</td>
<td>
<?php
$query_estadoorden = "SELECT codigoestadoordenpago, nombreestadoordenpago 
FROM estadoordenpago
order by 1";
$estadoorden = $db->Execute($query_estadoorden);
$totalRows_estadoorden = $estadoorden->RecordCount();
$row_estadoorden = $estadoorden->FetchRow(); 
?>
  <select name="nacodigoestadoordenpago">
    <option value="0"<?php if (!(strcmp("0", $_REQUEST['nacodigoestadoordenpago']))) {echo "SELECTED";} ?>>
      Seleccionar
    </option>
<?php
do 
{
?>
    <option value="<?php echo $row_estadoorden['codigoestadoordenpago']?>" <?php if (!(strcmp($row_estadoorden['codigoestadoordenpago'], $_REQUEST['nacodigoestadoordenpago']))) {echo "SELECTED";} ?>>
      <?php echo $row_estadoorden['nombreestadoordenpago']?>
    </option>
    <?php
}
while($row_estadoorden = $estadoorden->FetchRow());
?>
  </select>
</td>
</tr>
<tr>
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
</table>
<br>
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Restablecer" onClick="window.location.href='impresionmasiva.php'">	

<br><br>
<?php
if(isset($_REQUEST['naenviar']))
{
	if($_REQUEST['nafinicial'] == "")
	{
		$_REQUEST['nafinicial'] = "1000-01-01";
	}
	if($_REQUEST['naffinal'] == "")
	{
		$_REQUEST['naffinal'] = "2999-01-01";
	}
	if($_REQUEST['row_page'] != "")
	{
		$rows_per_page = $_REQUEST['row_page'];
	}
	
	if($_REQUEST['row_page'] != "")
	{
		$rows_per_page = $_REQUEST['row_page'];
	}
		
	$linkadd = "&nafinicial=".$_REQUEST['nafinicial']."&naffinal=".$_REQUEST['naffinal']."&naenviar=".$_REQUEST['naenviar']."&nacodigoestadoordenpago=".$_REQUEST['nacodigoestadoordenpago']."&nacodigoconcepto=".$_REQUEST['nacodigoconcepto']."";
	$filter = "";
	
	// Campos que se van a filtrar, en el valor del arreglo va la condición
	$array_campos['nombre'] = "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral)";
	$array_campos['codigoperiodo'] = "e.codigoperiodo";
	$array_campos['fechaordenpago'] = "fo.fechaordenpago";
	//$array_campos['codigosituacioncarreraestudiante'] = "e.codigoperiodo";
	
	//$db->debug = true; 
	
	//print_r($_REQUEST);
	if($_REQUEST['nacodigoestadoordenpago'] != 0 && $_REQUEST['nacodigoconcepto'] != 0)
	{
		$sqlini = "select o.numeroordenpago, e.codigoestudiante, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, eo.nombreestadoordenpago,
		fo.valorfechaordenpago, fo.fechaordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c, estadoordenpago eo, 
		detalleordenpago do
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and eo.codigoestadoordenpago = o.codigoestadoordenpago
		and do.numeroordenpago = o.numeroordenpago
		and fo.porcentajefechaordenpago = '0'
		and e.codigocarrera = '$codigocarrera'
		and o.codigoperiodo = '$codigoperiodo'
		and do.codigoconcepto = '".$_REQUEST['nacodigoconcepto']."'
		and o.codigoestadoordenpago like '".$_REQUEST['nacodigoestadoordenpago']."'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	else if($_REQUEST['nacodigoestadoordenpago'] != 0)
	{
		$sqlini = "select o.numeroordenpago, e.codigoestudiante, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, eo.nombreestadoordenpago,
		fo.valorfechaordenpago, fo.fechaordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c, estadoordenpago eo
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and eo.codigoestadoordenpago = o.codigoestadoordenpago
		and fo.porcentajefechaordenpago = '0'
		and e.codigocarrera = '$codigocarrera'
		and o.codigoperiodo = '$codigoperiodo'
		and o.codigoestadoordenpago like '".$_REQUEST['nacodigoestadoordenpago']."'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	else if($_REQUEST['nacodigoconcepto'] != 0)
	{
		$sqlini = "select o.numeroordenpago, e.codigoestudiante, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, eo.nombreestadoordenpago,
		fo.valorfechaordenpago, fo.fechaordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c, estadoordenpago eo,
		detalleordenpago do
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and eo.codigoestadoordenpago = o.codigoestadoordenpago
		and do.numeroordenpago = o.numeroordenpago
		and fo.porcentajefechaordenpago = '0'
		and e.codigocarrera = '$codigocarrera'
		and o.codigoperiodo = '$codigoperiodo'
		and do.codigoconcepto = '".$_REQUEST['nacodigoconcepto']."'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	else
	{
		$sqlini = "select o.numeroordenpago, e.codigoestudiante, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, eo.nombreestadoordenpago,
		fo.valorfechaordenpago, fo.fechaordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c, estadoordenpago eo
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and eo.codigoestadoordenpago = o.codigoestadoordenpago
		and fo.porcentajefechaordenpago = '0'
		and e.codigocarrera = '$codigocarrera'
		and o.codigoperiodo = '$codigoperiodo'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	//$sqlfin =" group by 1";
		
	$pager = new ADODB_Pager($db,$sqlini.$sqlfin,'adodb',false,true);
	
	// Hace que no acepte registros menores a cero
	if($rows_per_page < 1)
	{
		$rs_sqlini = $db->Execute($sqlini);
		$rows_per_page = $rs_sqlini->RecordCount();
	}
	
	$pager->linkfilter .= $linkadd;
	//$pager->numberRegisters = false;
	//$pager->Filter($sqlini,$sqlfin,$array_campos,$linkadd);
	// Deja listo para editar
	$pager->select = true;
	$pager->Render($rows_per_page,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"', array('Orden de Pago','ID Estudiante','Documento','Nombre','Estado Orden','Valor','Fecha Pago','Semestre')); 
?>
<br>
<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr>
<td colspan="2"><label id="labelresaltado">Seleccione la impresora siempre y cuando la impresión se haga por red,<br>si va a generar un pdf con las ordenes no seleccione nada</label></td>
</tr>
<tr>
<td colspan="2">
<?php
$query_impresora = "select s.idseleccionaimpresora, s.nombreseleccionaimpresora, s.ubicacionseleccionaimpresora, s.ipseleccionaimpresora
from seleccionaimpresora s
where s.fechafinalseleccionaimpresora >= '".date("Y-m-d")."'";
$impresora = $db->Execute($query_impresora);
$totalRows_impresora = $impresora->RecordCount();
$row_impresora = $impresora->FetchRow(); 
?>
  <select name="naipseleccionaimpresora">
    <option value="0"<?php if (!(strcmp("0", $_REQUEST['naipseleccionaimpresora']))) {echo "SELECTED";} ?>>
      Seleccionar
    </option>
<?php
do 
{
?>
    <option value="<?php echo $row_impresora['ipseleccionaimpresora']?>" <?php if (!(strcmp($row_impresora['ipseleccionaimpresora'], $_REQUEST['naipseleccionaimpresora']))) {echo "SELECTED";} ?>>
      <?php echo $row_impresora['nombreseleccionaimpresora']?>
    </option>
    <?php
}
while($row_impresora = $impresora->FetchRow());
?>
  </select>
</td>
</tr>
</table>
<br>
<input type="submit" value="Imprimir" name="naimprimir"><input type="button" value="Restablecer" onClick="window.location.href='impresionmasiva.php'">
<?php
}
?>
</form>
</body>
<script language="javascript">
function HabilitarGrupo(seleccion)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		
		var reg = new RegExp("^periodo");
		//elemento.name.search(regexp)
		//elemento.title == seleccion 	
		if(!elemento.name.search(reg))
		{
			//alert("aca"+elemento.name+" == "+seleccion);
			if(elemento.disabled == true)//alert("aca"+elemento.title+" == "+seleccion);
			{	
				elemento.disabled = false;
			}
			else
			{
				elemento.disabled = true;
			}
		}
	}
}
</script>
<script language="javascript">
function enviar()
{
	document.f1.submit();
}
</script>
</html>
