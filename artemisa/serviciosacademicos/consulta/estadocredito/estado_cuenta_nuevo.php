<?php
session_start();
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//$ruta = '../../'; 
require_once($ruta.'Connections/sala2.php'); 
mysql_select_db($database_sala, $sala);	
$rutaado = $ruta."funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once($ruta.'Connections/salaado.php'); 
//@session_start();      
//require_once($ruta.'Connections/sap.php');  
require_once($ruta.'funciones/cambia_fecha_sap.php');     
//$codigoestudiante = $_SESSION['codigo']; 
/********** BORRAR ******************/
//$codigoestudiante = 39207;

//print_r($db);
//if(isset($_GET['debug']))
//{
	$db->debug = false; 
//}

$tieneestadocuenta = false;
$tieneplanpagos = false;	
//require_once('saldo_favor_contra_nuevo.php');
$link = $ruta."../imagenes/estudiantes/"; 	 
require_once($ruta.'funciones/datosestudiante.php');
require_once($ruta.'funciones/sala/estadocuenta/estadocuenta.php');

//echo "<h1>$codigoestudiante</h1>";
//$estadocuenta = new estadocuenta($codigoestudiante);
//echo "<pre>".print_r($estadocuenta)."</pre>";
if(!$estadocuenta->tieneEstadocuentaactiva())
{
/*$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado, 
e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna, 
e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
from estadoconexionexterna e
where e.codigoestado like '1%'";*/
//and dop.codigoconcepto = '151'
//echo "sdas $query_ordenes<br>";
/*$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());     
$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);*/

//if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
//{
//	$login = array (                              // Set login data to R/3 
//	"ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],           	// application server host name 
//	"SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number 
//	"CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client 
//	"USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user 
//	"PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],			// password
//	"CODEPAGE"=>"1100");              												// codepage  
//	/*$login['ASHOST'] = "172.16.6.9";
//	$login['CLIENT'] = "500";*/
//	$rfc = saprfc_open($login);
//	if(!$rfc) 
//	{
//		// We have failed to connect to the SAP server
//		//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
//		//exit(1);
//	}
//}
//echo $row_estadoconexionexterna['mandanteestadoconexionexterna'];
//$codigoestudiante = $_SESSION['codigo'];
/********** BORRAR ******************/
//$codigoestudiante = 39207;

?>
<html>
<head>
<title>Estado de Cuenta</title>
<link rel="stylesheet" href="<?php echo $ruta?>estilos/sala.css" type="text/css">
</head>
<body>
<br><br>
<hr width="750" align="left">
<p>PARAMENTRIZACION DEL ESTADO DE CUENTA</p>
<table width="750" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">		
<tr id="trtitulogris">
  <td>TIPO DE FECHA DE CORTE</td>
  <td>TIPO DE ESTADO DE CUENTA</td>
  <td>FECHA DE CORTE</td>
  <td>DIAS VENCIMIENTO SOLICITUD</td>
</tr>
<tr>
  <td><?php echo $estadocuenta->getTipoestadocuenta(); ?></td>
  <td><?php echo $estadocuenta->getTipofechacorteestadocuenta(); ?></td>
  <td><?php 
if($estadocuenta->idtipofechacorteestadocuenta == '100')
	echo $estadocuenta->fechacorteestadocuenta; 
else if($estadocuenta->idtipofechacorteestadocuenta == '200')
	echo date("Y-m-d");
  ?></td>
  <td><?php echo $estadocuenta->diasvencimientosolicitudestadocuenta; ?></td>
</tr>
</table>
<?php 
 datosestudiante($codigoestudiante,$sala,$database_sala,$link);

 if ($saldoencontra <> "" or $saldoafavor <> "")
  { // if 1 
  		$tieneestadocuenta = true;	
?>
<br><br>
<hr width="750" align="left">
<p>ESTADO DE CUENTA</p>
<table width="750" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">		
<?php
 if ($saldoencontra <> "")
  { // if 2 	
  ?>
<tr id="trtitulogris">
  <td colspan="5">DEUDAS ESTUDIANTE</td>
</tr>
<tr id="trtitulogris">
  <td>Carrera</td>
  <td>Concepto</td>
  <td>Descripción</td>
  <td>Fecha Vencimiento</td>
  <td>Valor</td>
<!--  <td>Ordenes</td> -->
</tr>
<?php 

	 
 
 /*echo "<pre>";
 print_r($saldoencontra);
 echo"</pre>";	*/
	
	 foreach ($saldoencontra as $valor => $total)
	  {  // foreach 1
        $contador = 1;
		// Si la fecha es variable toma la actual o
		// Si la fecha es fija toma la de la tabla
		if ($estadocuenta->idtipofechacorteestadocuenta == '200')
		{
			$fechavalidar = date("Y-m-d");
		}
		else if ($estadocuenta->idtipofechacorteestadocuenta == '100')
		{
			$fechavalidar = $estadocuenta->fechacorteestadocuenta;
		}
		//$fechavalidar = date("Y-m-d");
		$dias = restarfecha(cambiaf_a_sala($total[3]), $fechavalidar);
		//echo "$dias <br>";
		if($dias >= 0)
		{
			// La fecha esta activa
			// Si el idtipoestadocuenta es 100 debe tomar las fechas vencidas, es decir que si esta activa la fecha debe continuar
			if($estadocuenta->idtipoestadocuenta == '100')
			{
				continue;
			}
		}
		else
		{
			// La fecha esta vencida
			// Si el idtipoestadocuenta es 200 debe tomar las fechas activas únicamente, es decir que si esta vencida la fecha debe continuar
			if($estadocuenta->idtipoestadocuenta == '200')
			{
				continue;
			}
		}
?>	 
 <tr>	  
<?php
	   foreach ($total as $valor1 => $total1) 
		{ // foreach 2 
					 
		   if ($contador == 4)
		    {
				
			  echo "<td colspan='$colspan'>",cambiaf_a_sala($total1),"</td>";
			}
		   if ($contador == 5)		
		    {
			  echo "<td colspan='$colspan'>",number_format($total1,0),"</td>";
			}   
		   if ($contador <> 6 and $contador <> 7 and $contador <> 4 and $contador <> 5)
		    { 
		      echo "<td>",$total1,"</td>";
	        } 	
		   
		 if ($contador == 1)
		   {	     
		     $carrera = $total1;
			 $contador ++;
           }
		  else
		   if ($contador == 2)
		    {	     
		      $concepto = $total1;
			  $contador ++;
            }
		   else
		   if ($contador == 3)
		    {
			  $nombreconcepto = $total1;
			  $contador ++;
			}
		  else
		  if ($contador == 4)
		    {
			  $fechapago = $total1;
			  $contador ++;
			}
		  else
		  if ($contador == 5)
		    {
			  $value = $total1;
			  //$value[$concepto] = $total1;
			  //$value[154] = 2000;
			  $contador ++;
			
			}
		  else
		  if ($contador == 6)
		    {
			  $registro = $total1;
			  $contador ++;
			}
		  else
		  if ($contador == 7)
		    {
			  $codigoestudiante = $total1;
			  $contador ++;
			}
 		} // foreach 1 
		
		   $query_orden = "SELECT * 
		   FROM ordenpago 
		   WHERE documentosapordenpago = '$registro'";
		   //echo $query_orden;
		   $orden = mysql_query($query_orden, $sala) or die("$query_orden".mysql_error());
		   $row_orden = mysql_fetch_assoc($orden);
		   $totalRows_orden = mysql_num_rows($orden); 
		
		 $fechapago = cambiaf_a_sala($fechapago);
		 
		/*if ($fechapago  >= date("Y-m-d"))
		 {
		   echo "vencida";
		 }
	   else
		if(! $row_orden) 
		 {     
          // $tmp = serialize($value); 
          // $tmp = urlencode($tmp);		   
		   echo "<td><div align='center' class='Estilo13 Estilo14'><a href='generarorden.php?codigoestudiante=$codigoestudiante&concepto=$concepto&valor=$value&registro=$registro&fecha=$fechapago'>Generar Orden</a></div></td>";
         }
		else
		 {
		   echo "<td><div align='center' class='Estilo13 Estilo14'><a href='cambiocodigosesion.php?codigoestudiante=$codigoestudiante'>".$row_orden['numeroordenpago']."</a></div></td>";
		 }*/
?>	 
 </tr>	  
<?php	
  	  } // foreach 1
    } // if 2 	
  } // if 1
    ////////////////////////// 	SALDOS A FAVOR //////////////////////////////////////
 if ($saldoafavor <> "")
  { // if 2 	

?>
<tr id="trtitulogris">
<td colspan="5">SALDOS A FAVOR  ESTUDIANTE</td>
</tr>
<tr id="trtitulogris">
  <td>Carrera</td>
  <td>Concepto</td>
  <td colspan="2">Descripción</td>  
  <td>Valor</td>
</tr>
<?php 	 
 if ($saldoafavor <> "")
  { // if 1
	 foreach ($saldoafavor as $valor => $total)
	  {
        $contador = 1;
        $colspan = 1;
?>	 
 <tr>	  
<?php	
	   foreach ($total as $valor1 => $total1) 
		{		  
		   
		   if($contador == 5)
		    {
			   echo "<td colspan='$colspan'>",number_format($total1,0),"</td>";
			}
		   else
		   if ($contador <> 4 and $contador <> 6 and $contador <> 7)
		    { 		      	 
			     echo "<td colspan='$colspan'>",$total1,"</td>";
	        } 	
		  
		 if ($contador == 1)
		   {	     
		     $carrera = $total1;
			 $colspan = 1;
			 $contador ++;
           }
		  else
		   if ($contador == 2)
		    {	     
		      $concepto = $total1;
			   $colspan = 2;
			  $contador ++;
             
			}
		   else
		   if ($contador == 3)
		    {
			  $nombreconcepto = $total1;
			  $colspan = 1;
			  $contador ++;
			}
		  else
		  if ($contador == 4)
		    {
			  $fechapago = cambiaf_a_sala($total1);
			  $colspan = 1;
			  $contador ++;
			}
		  else
		  if ($contador == 5)
		    {
			  $value = $total1;
			  $colspan = 1;
			  $contador ++;
			}
		  else
		  if ($contador == 6)
		    {
			  $registro = $total1;
			  $colspan = 1;
			  $contador ++;
			}
		  else
		  if ($contador == 7)
		    {
			  $codigoestudiante = $total1;
			  $colspan = 1;
			  $contador ++;
			}
 		 //echo $contador,"<br>";
		}		
?>	 
 </tr>	  
<?php	 
	 
	  }
	 } // if 2 
  } // if 1
 /// saprfc_function_free($rfcfunction);
//@saprfc_close($rfc);
?>
</table>	
<?php
unset($results);
$banderaestadocuenta=true;
include_once("tomar_saldofavorcontra.php");

if($saldoencontra <> "" or $saldoafavor <> "")
  {
$acumuladocontra=0;
$acumuladofavor=0;
?>
<p align="left" class="Estilo3"><b>ESTADO DE CUENTA</b></p>
<table width="60%"   border="1" cellpadding="1" bordercolor="#E9E9E9">
<tr bgcolor="#E9E9E9" >
  <td colspan="5"><div align="center" class="Estilo12"><span class="Estilo10">DEUDAS DEL ESTUDIANTE</span></div></td>
</tr>
<tr bgcolor="#E9E9E9" >
 <td><div align="center" class="Estilo12"><span class="Estilo10">Descripción</span></div></td>
  <td><div align="center" class="Estilo12"><span class="Estilo10">Fecha Vencimiento</span></div></td>
  <td><div align="center" class="Estilo12"><span class="Estilo10">Valor</span></div></td>
</tr>
<?php


   if ($saldoencontra <> "")
  {


$cantidadarry=count($saldoencontra);
$cantidadarry1=0;

for($cantidadarry1; $cantidadarry1 < $cantidadarry; $cantidadarry1++) {
$desc=$saldoencontra[$cantidadarry1][3];
$valorcuota=$saldoencontra[$cantidadarry1][6];
$fechavencimiento=$saldoencontra[$cantidadarry1][4];

echo "<td ><div align='center' class='Estilo13 Estilo14'>".$desc."</div></td>";
echo "<td colspan='$colspan'><div align='center' class='Estilo13 Estilo14'>".$fechavencimiento."</div></td>";
echo "<td colspan='2'><div align='center' class='Estilo13 Estilo14'>".$valorcuota."</div></td>";
$acumuladocontra=$valorcuota+$acumuladocontra;

 ?>
 <tr>
<?php

?>
 </tr>
<?php

}
 }
 }

if ($saldoafavor <> "")
  {
/*echo "<pre>";
                    print_r($saldoafavor);
                    echo"</pre>";*/
?>
<td colspan="5" bgcolor="#E9E9E9"><div align="center" class="Estilo12"><span class="Estilo10">SALDOS A FAVOR DEL ESTUDIANTE</span></div></td>
</tr>
<tr bgcolor="#E9E9E9" >
 <td><div align="center" colspan="5" class="Estilo12"><span class="Estilo10">Descripción</span></div></td>
  <td><div align="center" class="Estilo12"><span class="Estilo10">Fecha</span></div></td>
  <td><div align="center" colspan="5" class="Estilo12"><span class="Estilo10">Valor</span></div></td>
</tr>
<?php


$cantidadarry=count($saldoafavor);
$cantidadarry1=0;
function convertirPositivo($valortotal){
$valortotal=$valortotal * (-1);
return $valortotal;
}

for($cantidadarry1; $cantidadarry1 < $cantidadarry; $cantidadarry1++) {

$desc=$saldoafavor[$cantidadarry1][2];
$valortotal=convertirPositivo($saldoafavor[$cantidadarry1][4]);
$fechasaldoafavor=$saldoafavor[$cantidadarry1][3];


echo "<td ><div align='center' class='Estilo13 Estilo14'>".$desc."</div></td>";
echo "<td colspan='$colspan'><div align='center' class='Estilo13 Estilo14'>".$fechasaldoafavor."</div></td>";
echo "<td colspan='2'><div align='center' class='Estilo13 Estilo14'>".$valortotal."</div></td>";
$acumuladofavor=$valortotal+$acumuladofavor;
 ?>
 <tr>

 </tr>

 </tr>
<?php

  }
  }

 ?>
</table>
<?php 
if($saldoencontra <> "" or $saldoafavor <> "")
{
?>
<br><br>
<hr width="750" align="left">
<p style="font-size:12px">
<?php
	if($saldoencontra or $saldoafavor)
		echo "¿Está de acuerdo con su estado de cuenta?";
?>
</p>
<form name="f1" method="post" action="">
<input type="hidden" name="codigocreado" value="<?php echo $znumerodocumento;?>">
<input type="hidden" name="acumuladocontra" value="<?php echo $acumuladocontra;?>">
<input type="hidden" name="acumuladofavor" value="<?php echo $acumuladofavor;?>">

<table width="750" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr>
</tr>
<tr>
<td valign="top">Si <input type="radio" value="1" name="respuesta" onClick="ocultar()"></td>
<td valign="top"><table width="100%">
<tr><td valign="top">No <input type="radio" value="0" name="respuesta" onClick="mostrar()"></td>
<td>
<div id="observacionno" style="display: none"><b>Explique detalladamente por qué no está de acuerdo </b><br>
<textarea name="observacion" cols="70"></textarea>
</div>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="2"><input type="submit" name="continuar" value="Continuar"></td>
</tr>
</table>
</form>
<?php
}
else
{
?>
<script language="javascript">
	window.location.href='estudiante.php?codigocreado=<?php echo $znumerodocumento; ?>&sinestadocuenta';
</script>
<?php
}
?>
</body>
<script language="javascript">
	function mostrar()
	{
		document.getElementById("observacionno").style.display="block";
		document.f1.observacion.focus();
	}
	function ocultar()
	{
		document.getElementById("observacionno").style.display="none";
	}
</script>
</html>	 
<?php
	//exit();
}
?>
