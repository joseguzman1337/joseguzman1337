<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();

require_once('../../../Connections/sala2.php');
$rutaado=("../../../funciones/adodb/");
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php'); 
require('../../../funciones/sala/nota/nota.php');

if(isset($_GET['debug']))
{
	$db->debug = true; 
}
?>
<form method="get" name="f1">
Documento: <input type="text" name="documento"><br>
Semestre: <input type="text" name="semestre"><br>
<input type="submit" value="Enviar" name="enviar"> 
</form>

<?php
if(!isset($_SESSION['codigoperiodosesion']))
{
	$_SESSION['codigoperiodosesion'] = 20081;	
}

if(isset($_REQUEST['documento']))
{
	$numerodocumento = $_REQUEST['documento'];
	$semestre = $_REQUEST['semestre'];
	$codigoperiodo = $_SESSION['codigoperiodosesion'];

	$query_datosini = "select ed.numerodocumento, pee.idplanestudio, e.codigoestudiante
	from estudiante e, estudiantedocumento ed, planestudioestudiante pee
	where e.codigocarrera = 98
	and e.idestudiantegeneral = ed.idestudiantegeneral
	and ed.numerodocumento = '$numerodocumento'
	and pee.codigoestudiante = e.codigoestudiante";
 	$datosini = $db->Execute($query_datosini);
    $totalRows_datosini = $datosini->RecordCount();
    $row_datosini = $datosini->FetchRow();
    
    print_r($row_datosini);
    $codigoestudiante = $row_datosini['codigoestudiante'];
    $idplanestudio = $row_datosini['idplanestudio'];
    
    $query_orden = "select do.numeroordenpago, do.codigoconcepto
	from ordenpago o, detalleordenpago do
	where o.codigoperiodo = '$codigoperiodo'
	and o.codigoestadoordenpago like '4%'
	and do.numeroordenpago = o.numeroordenpago
	and do.codigoconcepto in(151,159)
	and o.codigoestudiante = '$codigoestudiante'
	order by do.codigoconcepto
	limit 1";
	$orden = $db->Execute($query_orden);
	$totalRows_orden = $orden->RecordCount();
	$row_orden = $orden->FetchRow();
	
	print_r($row_orden);
	$numeroordenpago = $row_orden['numeroordenpago'];
	if($totalRows_orden == 0)
	{
		echo "<br>Debe generar oden de pago de matricula o pensión la cual debe estar paga";
		exit();		
	}
    
	$query_prematricula = "select p.idprematricula
	from prematricula p
	where p.codigoperiodo = '$codigoperiodo'
	and p.codigoestudiante = '$codigoestudiante'
	and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')";
	$prematricula = $db->Execute($query_prematricula);
	$totalRows_prematricula = $prematricula->RecordCount();
	$row_prematricula = $prematricula->FetchRow();
	
	print_r($row_prematricula);
	if($totalRows_prematricula == 0)
	{
		echo "<br>Debe generar prematricula";
		$query_insprematricula = "INSERT INTO prematricula(idprematricula, fechaprematricula, codigoestudiante, codigoperiodo, codigoestadoprematricula, observacionprematricula, semestreprematricula) 
    	VALUES(0, now(), '$codigoestudiante', '$codigoperiodo', '40', '', '$semestre')";
		$insprematricula = $db->Execute($query_insprematricula);

		$idprematricula = $db->Insert_ID();
	}
	else
	{
		$idprematricula = $row_prematricula['idprematricula'];	
		
		echo "<br>Debe modificar prematricula";
		$query_updprematricula = "UPDATE prematricula 
		codigoestadoprematricula='40'
		WHERE idprematricula = '$idprematricula'";
		$updprematricula = $db->Execute($query_updprematricula);
	}
	
	$query_materias = "select dpe.codigomateria, g.idgrupo
	from detalleplanestudio dpe, grupo g
	where dpe.idplanestudio = '$idplanestudio'
	and g.codigomateria = dpe.codigomateria
	and g.codigoperiodo = '$codigoperiodo'
	and g.maximogrupo > 0
	and dpe.semestredetalleplanestudio = '$semestre'";
	$materias = $db->Execute($query_materias);
	$totalRows_materias = $materias->RecordCount();
	while($row_materias = $materias->FetchRow())
	{
		$codigomateria = $row_materias['codigomateria'];
		$idgrupo = $row_materias['idgrupo'];
		$query_detalleprematricula = "select dp.codigomateria
		from detalleprematricula dp
		where dp.idprematricula = '$idprematricula'
		and (dp.codigoestadodetalleprematricula like '1' or dp.codigoestadodetalleprematricula like '3')
		and dp.codigomateria = '$codigomateria'";
		$detalleprematricula = $db->Execute($query_detalleprematricula);
		$totalRows_detalleprematricula = $detalleprematricula->RecordCount();
		if($totalRows_detalleprematricula == 0)
		{
			echo "<br>Debe generar detalle prematricula";
			$query_insdetprematricula = "INSERT INTO detalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago) 
    		VALUES('$idprematricula', '$codigomateria', 1, '30', '10', '$idgrupo', '$numeroordenpago')";
			$insdetprematricula = $db->Execute($query_insdetprematricula);
	
			$idprematricula = $db->Insert_ID();
		}
		else
		{
			$idprematricula = $row_prematricula['idprematricula'];	
		
			echo "<br>Debe modificar detalle prematricula";
			$query_updprematricula = "UPDATE detalleprematricula 
			set codigoestadodetalleprematricula='30'
			WHERE idprematricula = '$idprematricula'
			and codigoestadodetalleprematricula like '1%'
			and codigomateria = '$codigomateria'  ";
			$updprematricula = $db->Execute($query_updprematricula);
		}
	}
?>
<script language="javascript">
<!--
alert("Estudiante matriculado correctamente, por favor verificar");
//-->
</script>
<input type="button" value="Regresar" name="regresar" onClick="window.location.href='../matriculaautomaticaordenmatricula.php'"> 
<?php
}
?>