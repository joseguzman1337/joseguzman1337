<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php'); 
include($rutazado.'zadodb-pager.inc.php');

session_start();
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
<title>Listado de Históricos</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<form action="" method="post" name="f1">
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
      Seleccionar
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
      Seleccionar
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
  Periodo de Generación de la Orden</td>
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
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Regresar" onClick="window.location.reload('ordenesdepago.php')">	

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
	$rows_per_page=10;
	if($_REQUEST['row_page'] != "")
	{
		$rows_per_page = $_REQUEST['row_page'];
	}
		
	$linkadd = "&nafinicial=".$_REQUEST['nafinicial']."&naffinal=".$_REQUEST['naffinal']."&nacodigomodalidadacademica=".$_REQUEST['nacodigomodalidadacademica']."&nacodigocarrera=".$_REQUEST['nacodigocarrera']."&nacodigoperiodo=".$_REQUEST['nacodigoperiodo']."&naenviar=".$_REQUEST['naenviar']."";
	$filter = "";
	
	// Campos que se van a filtrar, en el valor del arreglo va la condición
	$array_campos['nombre'] = "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral)";
	$array_campos['codigoperiodo'] = "e.codigoperiodo";
	$array_campos['fechaordenpago'] = "fo.fechaordenpago";
	//$array_campos['codigosituacioncarreraestudiante'] = "e.codigoperiodo";
	
	//$db->debug = true; 
	
	//print_r($_REQUEST);
	if($_REQUEST['nacodigomodalidadacademica'] != 0 && $_REQUEST['nacodigocarrera'] != 0 && $_REQUEST['nacodigoperiodo'] != 0)
	{
		$sqlini = "select e.idestudiantegeneral, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		c.nombrecarrera, o.numeroordenpago, o.documentocuentaxcobrarsap, o.documentocuentacompensacionsap, 
		fo.valorfechaordenpago, fo.fechaordenpago, o.fechapagosapordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and o.codigoestadoordenpago like '4%'
		and fo.porcentajefechaordenpago = '0'
		and e.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
		and o.codigoperiodo = '".$_REQUEST['nacodigoperiodo']."'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	else if($_REQUEST['nacodigomodalidadacademica'] != 0 && $_REQUEST['nacodigoperiodo'] != 0)
	{
		$sqlini = "select e.idestudiantegeneral, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, o.numeroordenpago, o.documentocuentaxcobrarsap, o.documentocuentacompensacionsap, 
		fo.valorfechaordenpago, fo.fechaordenpago, o.fechapagosapordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and o.codigoestadoordenpago like '4%'
		and fo.porcentajefechaordenpago = '0'
		and c.codigomodalidadacademica = '".$_REQUEST['nacodigomodalidadacademica']."'
		and o.codigoperiodo = '".$_REQUEST['nacodigoperiodo']."'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	else if($_REQUEST['nacodigomodalidadacademica'] != 0 && $_REQUEST['nacodigocarrera'] != 0)
	{
		$sqlini = "select e.idestudiantegeneral, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, o.numeroordenpago, o.documentocuentaxcobrarsap, o.documentocuentacompensacionsap, 
		fo.valorfechaordenpago, fo.fechaordenpago, o.fechapagosapordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and o.codigoestadoordenpago like '4%'
		and fo.porcentajefechaordenpago = '0'
		and e.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	else if($_REQUEST['nacodigomodalidadacademica'] != 0)
	{
		$sqlini = "select e.idestudiantegeneral, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, o.numeroordenpago, o.documentocuentaxcobrarsap, o.documentocuentacompensacionsap, 
		fo.valorfechaordenpago, fo.fechaordenpago, o.fechapagosapordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and o.codigoestadoordenpago like '4%'
		and fo.porcentajefechaordenpago = '0'
		and c.codigomodalidadacademica = '".$_REQUEST['nacodigomodalidadacademica']."'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	else if($_REQUEST['nacodigoperiodo'] != 0)
	{
		$sqlini = "select e.idestudiantegeneral, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, o.numeroordenpago, o.documentocuentaxcobrarsap, o.documentocuentacompensacionsap, 
		fo.valorfechaordenpago, fo.fechaordenpago, o.fechapagosapordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and o.codigoestadoordenpago like '4%'
		and fo.porcentajefechaordenpago = '0'
		and o.codigoperiodo = '".$_REQUEST['nacodigoperiodo']."'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	else
	{
		$sqlini = "select e.idestudiantegeneral, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, o.numeroordenpago, o.documentocuentaxcobrarsap, o.documentocuentacompensacionsap, 
		fo.valorfechaordenpago, fo.fechaordenpago, o.fechapagosapordenpago, e.semestre
		from estudiante e, ordenpago o, fechaordenpago fo, estudiantegeneral eg, carrera c
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante
		and e.codigocarrera = c.codigocarrera
		and fo.numeroordenpago = o.numeroordenpago
		and o.codigoestadoordenpago like '4%'
		and fo.porcentajefechaordenpago = '0'
		and e.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
		and o.codigoperiodo = '".$_REQUEST['nacodigoperiodo']."'
		and fo.fechaordenpago >= '".$_REQUEST['nafinicial']."'
		and fo.fechaordenpago <= '".$_REQUEST['naffinal']."'";
	}
	//$sqlfin =" group by 1";
		
	//$gSQLBlockRows = 100;
	//rs2html($matriculas,'width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"',array('Documento','Nombre','Periodo de Ingreso')); 
	$pager = new ADODB_Pager($db,$sqlini.$sqlfin);
	$pager->Filter($sqlini,$sqlfin,$array_campos,$linkadd);
	$pager->totalsColumns = true;
	$pager->Render($rows_per_page,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"', array('ID General','Documento','Nombre','Carrera','Orden de Pago','Cuenta por Cobrar','Cuenta Compensación','Valor','Fecha Pago 1','Fecha Pago SAP','Semestre')); 
?>
<br>
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Restablecer" onClick="window.location.reload('ordenesdepagopagas.php')"><input type="button" value="Regresar" onClick="window.location.reload('ordenesdepago.php')">
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
