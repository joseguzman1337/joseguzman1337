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
<?php
if(!isset($_SESSION['MM_Username']))
{
    echo "NO TIENE PERMISO PARA ACCEDER A ESTA OPCIÓN";
    exit();
}
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
Busqueda Por documentos
</td>
<td>
<input type="text" name="nanumerodocumento" value="<?php echo $_REQUEST['nanumerodocumento']; ?>"> <label id="labelresaltado">Si es más de uno digite los documentos separados por coma</label>
</td>
</tr>
</table>
<br>
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Restablecer" onClick="window.location.href='listadoprimeraclave.php'">	

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
	$array_campos['idestudiantegeneral'] = "e.idestudiantegeneral";
	$array_campos['nombre'] = "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral)";
	$array_campos['codigoperiodo'] = "e.codigoperiodo";
	$array_campos['numerodocumento'] = "eg.numerodocumento";
	//$array_campos['codigosituacioncarreraestudiante'] = "e.codigoperiodo";
	
	//$db->debug = true; 
	
	//print_r($_REQUEST);
        $filtrodocumento = "";
        if($_REQUEST['nanumerodocumento'] != 0)
        {
            $filtrodocumento = " and u.numerodocumento in(".$_REQUEST['nanumerodocumento'].")";
        }
	if($_REQUEST['nacodigomodalidadacademica'] != 0 && $_REQUEST['nacodigocarrera'] != 0)
	{
		$sqlini = "select e.idestudiantegeneral, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		c.nombrecarrera, e.semestre, eg.emailestudiantegeneral, u.usuario, l.tmpclavelogcreacionusuario
		from estudiante e, estudiantegeneral eg, carrera c, logcreacionusuario l, (select usuario,numerodocumento,idusuario,codigotipousuario,codigorol from usuario) u, estudiantedocumento ed
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigocarrera = c.codigocarrera
		and eg.idestudiantegeneral = ed.idestudiantegeneral
                and ed.numerodocumento = u.numerodocumento
                and u.idusuario = l.idusuario
                and u.codigotipousuario = 600
                and u.codigorol = 1
                and e.codigocarrera = '".$_REQUEST['nacodigocarrera']."'
                and l.codigoestado like '1%'
		$filtrodocumento";
	}
	else if($_REQUEST['nacodigomodalidadacademica'] != 0)
	{
		$sqlini = "select e.idestudiantegeneral, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		c.nombrecarrera, e.semestre, eg.emailestudiantegeneral, u.usuario, l.tmpclavelogcreacionusuario
		from estudiante e, estudiantegeneral eg, carrera c, logcreacionusuario l, (select usuario,numerodocumento,idusuario,codigotipousuario,codigorol from usuario) u, estudiantedocumento ed
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigocarrera = c.codigocarrera
		and eg.idestudiantegeneral = ed.idestudiantegeneral
                and ed.numerodocumento = u.numerodocumento
                and u.idusuario = l.idusuario
                and u.codigotipousuario = 600
                and u.codigorol = 1
		and c.codigomodalidadacademica = '".$_REQUEST['nacodigomodalidadacademica']."'
                and l.codigoestado like '1%'
                $filtrodocumento";
	}
        else if($_REQUEST['nanumerodocumento'] != 0)
        {
                $sqlini = "select e.idestudiantegeneral, eg.numerodocumento, 
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		c.nombrecarrera, e.semestre, eg.emailestudiantegeneral, u.usuario, l.tmpclavelogcreacionusuario
		from estudiante e, estudiantegeneral eg, carrera c, logcreacionusuario l, (select usuario,numerodocumento,idusuario,codigotipousuario,codigorol from usuario) u, estudiantedocumento ed
		where e.idestudiantegeneral = eg.idestudiantegeneral
		and e.codigocarrera = c.codigocarrera
		and eg.idestudiantegeneral = ed.idestudiantegeneral
                and ed.numerodocumento = u.numerodocumento
                and u.idusuario = l.idusuario
                and u.codigotipousuario = 600
                and u.codigorol = 1
		and l.codigoestado like '1%'
                $filtrodocumento";
        }
        else
        {
            ?>
<script language="JavaScript">
    alert("Debe seleccionar uno de los filtros para poder continuar");
    history.go(-1);
</script>
            <?php
        }
	//$sqlfin =" group by 1";
		
	//$gSQLBlockRows = 100;
	//rs2html($matriculas,'width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"',array('Documento','Nombre','Periodo de Ingreso')); 
	$pager = new ADODB_Pager($db,$sqlini.$sqlfin);
	$pager->Filter($sqlini,$sqlfin,$array_campos,$linkadd);
	//$pager->totalsColumns = true;
	$pager->Render($rows_per_page,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"', array('ID General','Documento','Nombre','Carrera','Semestre', 'Correo', 'Usuario', 'Clave Temporal Asignada'));
?>
<br>
<input type="submit" value="Enviar" name="naenviar"><input type="button" value="Restablecer" onClick="window.location.href='listadoprimeraclave.php'">
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
