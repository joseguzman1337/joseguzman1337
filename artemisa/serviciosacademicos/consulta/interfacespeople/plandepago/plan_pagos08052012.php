<?php      

require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
@session_start();      
$link = "../../../imagenes/estudiantes/"; 	
require('../../../funciones/datosestudiante.php');
require_once($_SESSION['path_live'].'consulta/interfacespeople/lib/nusoap.php');
require_once('../conexionpeople.php');

$cont = 0;

$codigoestudiante = $_SESSION['codigo'];
$hoy = date('Y-m-d');

$query_dataestudiante="	SELECT *
			FROM estudiante e,estudiantegeneral eg,documento d
			WHERE e.idestudiantegeneral = eg.idestudiantegeneral and eg.tipodocumento=d.tipodocumento and e.codigoestudiante = '" . $codigoestudiante . "'";
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);

$idestudiante = $row_dataestudiante['idestudiantegeneral'];

$client = new soapclient("http://campus.unbosque.edu.co/PSIGW/PeopleSoftServiceListeningConnector/UBI_CONS_PLANPAGO_SRV.1.wsdl", true);
                          
$err = $client->getError();
if ($err) 
	echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';

$proxy = $client->getProxy();

$param2 = "	<UB_DATOSCONS_WK>
			<NATIONAL_ID_TYPE>".$row_dataestudiante['nombrecortodocumento']."</NATIONAL_ID_TYPE>
			<NATIONAL_ID>".$row_dataestudiante['numerodocumento']."</NATIONAL_ID>
		</UB_DATOSCONS_WK>";

$resultado = $client->call('UBI_CONS_PLANPAGO_OPR_SRV',$param2);

$query = "	INSERT INTO logtraceintegracionps
			(transaccionlogtraceintegracionps
			,enviologtraceintegracionps
			,respuestalogtraceintegracionps
			,documentologtraceintegracionps)
		VALUES ('Consulta Plan de Pago'
			,'".$param2."'
			,'id:".$resultado['ERRNUM']." descripcion: ".$resultado['DESCRLONG']."'
			,'".$row_dataestudiante['numerodocumento']."')";
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
<?
$array=$resultado['UBI_ITEMS_WRK']['UBI_ITEM_WRK'];


$_SESSION['arreglos']=$array; 


/*echo"Plan de Pago<pre>";
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
	 /*$query = "select e.codigoestudiante from ordenpago o, estudiante e 
	where o.codigoestudiante=e.codigoestudiante and 
	numeroordenpago=".$ordenes."";
$orden = mysql_query($query, $sala) or die("$query".mysql_error());
$row_orden = mysql_fetch_assoc($orden);*/


/*CONDICION*/
//if($row_orden['codigoestudiante']==$_SESSION['codigo']){
	



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
if(isset($arr)){
foreach ($arr as $clave => $valor) 

		
echo "<tr><td align='center'>".rtrim($arr[$clave]['DESCR'],' - ')."</td><td align='center'>$clave</td><td align='right'>".$arr[$clave]['ITEM_AMT']."</td><td align='center'><a href='../../estadocredito/generarorden.php?ordenpago=$numeroorden&fecha=$clave'>Generar Orden Pago</a></td></tr>";

//}

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

