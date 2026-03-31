<?php

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
//ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
require_once('../../../Connections/sala2.php');

mysql_select_db($database_sala, $sala);
session_start();
$link = "../../../imagenes/estudiantes/";
require('../../../funciones/datosestudiante.php');
//require_once(dirname(__FILE__).'/../lib/nusoap.php');
require_once(dirname(__FILE__).'/../../../../nusoap/lib/nusoap.php');
require_once(dirname(__FILE__).'/../conexionpeople.php');

$cont = 0;

$codigoestudiante = $_SESSION['codigo'];
$hoy = date('Y-m-d');

 $query_dataestudiante="SELECT dp.codigodocumentopeople,eg.numerodocumento
FROM estudiante e,estudiantegeneral eg,documento d,documentopeople dp WHERE
e.idestudiantegeneral = eg.idestudiantegeneral and d.tipodocumento=dp.tipodocumentosala
and eg.tipodocumento=d.tipodocumento and e.codigoestudiante = '" . $codigoestudiante . "'";
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);

$idestudiante = $row_dataestudiante['idestudiantegeneral'];

$array=array();
require_once(dirname(__FILE__).'/../reporteCaidaPeople.php');
$envio=0;
	$servicioPS = verificarPSEnLinea();
	if($servicioPS){
	$client = new nusoap_client(WEBPLANDEPAGO, true, false, false, false, false, 0, 90);

	$err = $client->getError();
	if ($err)
		echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';

	$proxy = $client->getProxy();
}
	$param2 = "	<UB_DATOSCONS_WK>
				<NATIONAL_ID_TYPE>".$row_dataestudiante['codigodocumentopeople']."</NATIONAL_ID_TYPE>
				<NATIONAL_ID>".$row_dataestudiante['numerodocumento']."</NATIONAL_ID>
			</UB_DATOSCONS_WK>";
if($servicioPS){
	$start = time();
	$resultado = $client->call('UBI_CONS_PLANPAGO_OPR_SRV',$param2);
	$array=$resultado['UBI_ITEMS_WRK']['UBI_ITEM_WRK'];
	$time =  time()-$start;
	$envio = 1;
	if($time>=100 || $resultado===false){
		$envio=0;
		reportarCaida(1,'Consulta Plan de Pago');
	}  else {
		$results=$resultado['UBI_ITEMS_WRK'] ['UBI_ITEM_WRK'];
	}
}

	$query = "	INSERT INTO logtraceintegracionps
				(transaccionlogtraceintegracionps
				,enviologtraceintegracionps
				,respuestalogtraceintegracionps
				,documentologtraceintegracionps,estadoenvio)
			VALUES ('Consulta Plan de Pago'
				,'".$param2."'
				,'id:".$resultado['ERRNUM']." descripcion: ".$resultado['DESCRLONG']."'
				,".$row_dataestudiante['numerodocumento'].",".$envio.")";
	$plandepago = mysql_query($query, $sala) or die("$query" . mysql_error());

?>
<style type="text/css">
<!--
.Estilo10 {
	font-family: tahoma;
	font-weight: bold;
}
.Estilo12 {font-size: 9px}
.Estilo13 {font-family: tahoma}
.Estilo14 {font-size: x-small}
.Estilo15 {font-family: tahoma; font-size: x-small; }
-->
</style>

<?php
datosestudiante($codigoestudiante,$sala,$database_sala,$link);
?>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">


<p align="left" class="Estilo10">Plan de Pagos</p>
<table width="60%" border="1" align="left" cellpadding="1" bordercolor="#E9E9E9">
	<tr bgcolor="#E9E9E9" >
		<td colspan="5"><div align="center" class="Estilo12"><span class="Estilo10">CUOTAS PENDIENTES</span></div></td>
	</tr>
	<tr bgcolor="#E9E9E9" >
		<td><div align="center" class="Estilo12"><span class="Estilo10">Descripcion Orden</span></div></td>
		<td><div align="center" class="Estilo12"><span class="Estilo10">Fecha Vencimiento</span></div></td>
		<td><div align="center" class="Estilo12"><span class="Estilo10">Valor</span></div></td>
		<td><div align="center" class="Estilo12"><span class="Estilo10">Ordenes</span></div></td>
	</tr>
<?php


$_SESSION['arreglos']=$array;


/*echo"Impreme Plan de Pago<pre>";
print_r($array);
echo"</pre>";*/



//echo $_SESSION[codigo];




if (is_array($array) && count($array)>0)
  {

	  if(!is_array($array[0])){

    $resultstmp=$array;
    unset($array );
   $array[0]=$resultstmp;

}


for($i=0;$i<count($array);$i++) {

	$ordenpago=$array[$i]['INVOICE_ID'];
    $ordenes=substr($ordenpago,0,7);


	/*CONSULTA PARA SEPARAR PLAN DE PAGO POR CARRERA*/
	$query = "select e.codigoestudiante from ordenpago o, estudiante e
	where o.codigoestudiante=e.codigoestudiante and
	numeroordenpago=".$ordenes."";
	//echo "<br>";
$orden = mysql_query($query, $sala) or die("$query".mysql_error());
$row_orden = mysql_fetch_assoc($orden);
//echo "imprime el codigo:". $row_orden['codigoestudiante'];
	//echo "<br>";
/*CONDICION*/
if($row_orden['codigoestudiante']==$_SESSION['codigo']){




	$arr[$array[$i]['DUE_DT']]['DESCR']=$arr[$array[$i]['DUE_DT']]['DESCR'].$array[$i]['DESCR']." - ";


	//$arr[$array[$i]['DUE_DT']]['ITEM_AMT']=$arr[$array[$i]['DUE_DT']]['ITEM_AMT']+$array[$i]['ITEM_AMT'];

    $arr[$array[$i]['DUE_DT']]['ITEM_AMT']=$arr[$array[$i]['DUE_DT']]['ITEM_AMT']-$arr[$array[$i]['DUE_DT']]['APPLIED_AMT']+$array[$i]['ITEM_AMT']-$array[$i]['APPLIED_AMT'];

	/*$arr[$array[$i]['DUE_DT']]['ITEM_AMT']=$array[$i]['ITEM_AMT'];

	$arr[$array[$i]['DUE_DT']]['DUE_DT']=$array[$i]['DUE_DT'];
	$arr[$array[$i]['ITEM_AMT']]=$array[$i]['ITEM_AMT'];*/
	//$arra=$array[$i]['ITEM_TYPE'];
	$numeroorden=$array[$i]['INVOICE_ID'];


}

}

/*Query para determinar si es la primera cuota*/
/*$queryPrimeraCuota = "SELECT
	o.numeroordenpago
FROM
	`ordenpago` o
inner join estudiante e on e.codigoestudiante = o.codigoestudiante
inner join carrera c ON e.codigocarrera = c.codigocarrera
inner join AportesBecas a ON o.numeroordenpago = a.numeroordenpago
WHERE
	o.codigoestudiante = ".$_SESSION['codigo']."
AND o.codigoperiodo = ".$_SESSION['codigoperiodosesion']."
AND a.codigoestado <> 200";*/

$queryPrimeraCuota = "SELECT
						o.numeroordenpago
					FROM
						`ordenpago` o
					WHERE
						o.codigoestudiante = ".$_SESSION['codigo']."
					AND o.codigoperiodo = ".$_SESSION['codigoperiodosesion']."
					and o.codigoestadoordenpago <> '20'
					and o.idprematricula <> 1";

$Cuota = mysql_query($queryPrimeraCuota, $sala) or die("$queryPrimeraCuota".mysql_error());
$i = mysql_num_rows($Cuota);

$queryModalidadAcademica = "SELECT
	c.codigomodalidadacademica
FROM
	estudiante e
INNER JOIN carrera c ON e.codigocarrera = c.codigocarrera
WHERE
	e.codigoestudiante = ".$_SESSION['codigo'];
$datamodalidad = mysql_query($queryModalidadAcademica, $sala) or die("$queryModalidadAcademica".mysql_error());
$row_datamodalidad = mysql_fetch_assoc($datamodalidad);
/*Fin determina cuota*/
if(isset($arr)){
foreach ($arr as $clave => $valor){
	if($i <= 1 && ($row_datamodalidad['codigomodalidadacademica'] == "200" || $row_datamodalidad['codigomodalidadacademica'] == "300")){
		echo "<tr><td align='center'>".rtrim($arr[$clave]['DESCR'],' - ')."</td><td align='center'>$clave</td><td align='right'>".$arr[$clave]['ITEM_AMT']."</td><td align='center'><a href='../../estadocredito/generarorden.php?ordenpago=$numeroorden&fecha=$clave&inicial=1'>Generar Orden Pago</a></td></tr>";
	}else{
		echo "<tr><td align='center'>".rtrim($arr[$clave]['DESCR'],' - ')."</td><td align='center'>$clave</td><td align='right'>".$arr[$clave]['ITEM_AMT']."</td><td align='center'><a href='../../estadocredito/generarorden.php?ordenpago=$numeroorden&fecha=$clave'>Generar Orden Pago</a></td></tr>";
	}
	$i++;
	}
}

}

?>
</table>

<br> <br> <br> <br>
<br> <br> <br> <br>
<br> <br> <br> <br>
<br> <br> <br> <br>
<div align="left">
<input type="button" name="Imprimir" onClick="print()" value="Imprimir">&nbsp;<input type="button" name="Regresar" onClick="history.go(-1)" value="Regresar">
</div>



