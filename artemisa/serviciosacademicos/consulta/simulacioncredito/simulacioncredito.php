<?php 
// Este formulario lo debe visualizar credito y cartera
session_start();

require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php' );
require_once('../../funciones/simulacioncredito/clasesimulacioncredito.php' );
require_once('../../funciones/CalcDate.php');
require_once('../../funciones/ordenpago/claseordenestudiante.php');


//include_once($rutaado.'adodb-pager.inc.php');
//require_once("../../funciones/funciontiempo.php");
//$db->debug = true; 

//echo "Usuario".$_SESSION['codigo'];
//echo "Usuario".$_SESSION['MM_Username'];
// Selecciona el periodo activo que halla sido seleccionado por la facultad
$codigoestudiante = $_SESSION['codigo'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];

// Creación de la clase simulacion credito
@$sc = new clasesimulaciocredito($db,$seldataestudiante->fields['nombre'],$codigoestudiante);
// Inicializar valores de condición crédito
$sc->inicializarcondicioncredito($codigoperiodo);
$query_selordenpago = "select o.numeroordenpago, do.codigoconcepto, do.valorconcepto, fo.fechaordenpago, fo.valorfechaordenpago 
from ordenpago o, detalleordenpago do, fechaordenpago fo 
where o.codigoestudiante = '$codigoestudiante' 
and o.codigoperiodo = '$codigoperiodo' 
and o.codigoestadoordenpago like '%4'   
and do.numeroordenpago = o.numeroordenpago
and do.codigoconcepto = '151'
and fo.numeroordenpago = o.numeroordenpago
and fo.porcentajefechaordenpago = 0";
$selordenpago = $db->Execute($query_selordenpago); 
$totalRows_selordenpago = $selordenpago->RecordCount(); 
$sc->numeroordenpago = $selordenpago->fields['numeroordenpago'];
$sc->codigoperiodo = $codigoperiodo;
$sc->pecuniarios = $selordenpago->fields['valorfechaordenpago'] - $selordenpago->fields['valorconcepto'];
$sc->valorapagar = $selordenpago->fields['valorfechaordenpago'] - $sc->pecuniarios;
$sc->fechascreditos[] = $selordenpago->fields['fechaordenpago'];
?>
<html>
<head><title>Formulario de Devoluciones</title>
</head>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<body>
<form method="post" action="" name="f1"  onSubmit = "return validar(this)">
<div align="center">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
   <tr>
   <td>
<?php
//$pager = new ADODB_Pager($db,$query_seldevoluciones);
//$pager->Render($rows_per_page=5);
$sc->cabecerasimulacion();
$sc->cuerposimulacion();
$sc->piesimulacion();
?>
 </td>
 </tr>
</table>
 <br><br>
 <input type="submit" name="simular" value="Simular"><input type="button" value="Regresar" onClick="window.location.reload('simulacionesrealizadas.php')"><input type="submit" name="Guardar" value="Guardar">
 </div>
</form>
</body>
</html>
<script language="javascript">
function terminar()
{
	window.location.reload("matriculaautomaticabusquedaestudiante.php");
}
</script>
<script type="text/javascript">
	/*Calendar.setup(
	{ inputField : "fecha0", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		text : "fecha0" // ID of the button
	});*/
</script>
<script language="javascript">
function validar(formulario) 
{
	var valorminimoprimerpago; 
	var valorapagar;
	var primerpago;
	var porcentaje;
	var valorminimocondicioncredito;
	
	valorapagar = parseFloat(formulario.valorapagar.value);
	primerpago = parseFloat(formulario.primerpago.value);
	porcentaje = parseFloat(<?php echo $sc->porcentajeminimoinicialcondicioncredito; ?>);
	valorminimocondicioncredito = parseFloat(<?php echo $sc->valorminimocondicioncredito; ?>);
	valorminimoprimerpago = valorapagar*porcentaje/100;
	if(primerpago < valorminimoprimerpago) 
	{
		alert("Debe digitar un valor mayor o igual de "+valorminimoprimerpago+" para el primer pago");
		formulario.primerpago.select();
		formulario.primerpago.value = valorminimoprimerpago;
		formulario.primerpago.focus();
		return (false);
  	}
	if(valorapagar < valorminimocondicioncredito) 
	{
		alert("Debe digitar un valor mayor o igual de "+valorminimocondicioncredito+" para el valor a pagar");
		formulario.valorapagar.select();
		formulario.valorapagar.value = valorminimocondicioncredito;
		formulario.valorapagar.focus();
		return (false);
  	}
	if(valorapagar < primerpago)
	{
		alert("El valor a pagar debe ser mayor que el valor del primer pago");
		formulario.valorapagar.select();
		formulario.valorapagar.value = primerpago * 100 / porcentaje;
		formulario.valorapagar.focus();
		return (false);
	}
}
</script>
<?php
$sc->calendarios();
//$sc->db->debug = true; 
if(isset($_POST['Guardar']))
{
	$query_inssimulacioncredito = "INSERT INTO simulacioncredito(idsimulacioncredito, codigoestudiante, fechasimulacioncredito, valorsimulacioncredito, fechadesdesimulacioncredito, fechahastasimulacioncredito, numerocuotassimulacioncredito, observacionsimulacioncredito, codigoestado, idcondicioncredito) 
    VALUES(0, '$sc->codigoestudiante', '".date("Y-m-d H:i:s")."', '$sc->valorapagar', '".$sc->fechascreditos[0]."', '".$sc->fechascreditos[$sc->numerocuotas]."', '$sc->numerocuotas', '', '100', '$sc->idcondicioncredito')";
	$inssimulacioncredito = $sc->db->Execute($query_inssimulacioncredito);
	// Tengo que coger el idsimulacioncredito 
	//echo "<br> $query_inssimulacioncredito<br>";
	if(!($id = $sc->db->Insert_ID()))
	{
		echo "<br>$id Toca traer el id de otra forma";
		exit();
	}
	else
	{
		$sc->setIdsimulacioncredito($id);
	}
	
	// Inserta en la base de datos
	for($i = 0; $i <= $sc->numerocuotas; $i++)
	{
		$j = $i - 1;
		if($i == 0 || $i == 1)
		{
			$query_insdetallesimulacioncredito = "INSERT INTO detallesimulacioncredito(iddetallesimulacioncredito, idsimulacioncredito, nocuotadetallesimulacioncredito, fechadesdedetallesimulacioncredito, fechahastadetallesimulacioncredito, valorcapitaldetallesimulacioncredito, valorinteresesdetallesimulacioncredito, codigoestado) 
			VALUES(0, '$sc->idsimulacioncredito', '$i', '".date("Y-m-d")."', '".$sc->fechascreditos[$i]."', '".$sc->capitales[$i]."', '".$sc->intereses[$i]."', '100')";
		}
		else
		{
			$query_insdetallesimulacioncredito = "INSERT INTO detallesimulacioncredito(iddetallesimulacioncredito, idsimulacioncredito, nocuotadetallesimulacioncredito, fechadesdedetallesimulacioncredito, fechahastadetallesimulacioncredito, valorcapitaldetallesimulacioncredito, valorinteresesdetallesimulacioncredito, codigoestado) 
			VALUES(0, '$sc->idsimulacioncredito', '$i', '".$sc->fechascreditos[$j]."', '".$sc->fechascreditos[$i]."', '".$sc->capitales[$i]."', '".$sc->intereses[$i]."', '100')";
		}
		$insdetallesimulacioncredito = $sc->db->Execute($query_insdetallesimulacioncredito);
		//echo "<br> $query_insdetallesimulacioncredito<br>";
	}
?>
<script language="javascript">
	window.location.reload("simulacionesrealizadas.php?idsimulacioncredito=<?php echo $id;?>");
</script>
<?php
}
$db->Close(); # opcional
?>
