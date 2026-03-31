<?php      
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	require_once('../../Connections/sala2.php' );
	  mysql_select_db($database_sala, $sala);
	  @session_start();      
	  $link = "../../../imagenes/estudiantes/"; 	
	  require('../../funciones//datosestudiante.php');
          require_once('../interfacespeople/lib/nusoap.php');
          //require_once('../conexionpeople.php');
              
	  $cont = 0;
	 
	  $codigoestudiante = $_SESSION['codigo'];
	
        $query_dataestudiante = "SELECT *
       FROM estudiante e,estudiantegeneral eg,documento d
       WHERE e.idestudiantegeneral = eg.idestudiantegeneral and eg.tipodocumento=d.tipodocumento
   	   and e.codigoestudiante = '" . $codigoestudiante . "'";
          $dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
       $row_dataestudiante = mysql_fetch_assoc($dataestudiante);
       $totalRows_dataestudiante = mysql_num_rows($dataestudiante);	  

	   $idestudiante = $row_dataestudiante['idestudiantegeneral'];
	
	$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

$client = new soapclient("http://campusxxide.unbosque.edu.co:8210/PSIGW/PeopleSoftServiceListeningConnector/UBI_CONS_PLANPAGO_SRV.1.wsdl", true);
     $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
    $proxy = $client->getProxy();

     $param2="   <UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>".$row_dataestudiante['nombrecortodocumento']."</NATIONAL_ID_TYPE>
    <NATIONAL_ID>".$row_dataestudiante['numerodocumento']."</NATIONAL_ID>
        </UB_DATOSCONS_WK>";
     
$resultado = $client->call('UBI_CONS_PLANPAGO_OPR_SRV',$param2);

 $query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,
respuestalogtraceintegracionps,documentologtraceintegracionps) VALUES ('Consulta Plan de Pago',
'".$param2."','id:".$resultado['ERRNUM']." descripcion: ".$resultado['DESCRLONG']."','".$row_dataestudiante['numerodocumento']."')";
$plandepago = mysql_query($query, $sala) or die("$query" . mysql_error());

/*echo "<pre>";
         print_r($resultado);
         echo "</pre>";*/

/*echo "<pre>";
         print_r($param2);
         echo "</pre>";*/
   /* echo '<h2>Request</h2>';
    echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
    echo '<h2>Response</h2>';
    echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
    echo '<h2>Debug</h2>';
    echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';*/
      
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
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">

	 

<?php 
datosestudiante($codigoestudiante,$sala,$database_sala,$link); 
$results=$resultado['UBI_ITEMS_WRK'] ['UBI_ITEM_WRK'];

/*echo "<pre>";
print_r($results);
echo "</pre>";*/

 if ($results <> "")
  {  	

/*
echo "fecha1<pre>";
print_r($results);
echo "</pre>";
echo "Este arroy tiene :<pre>";
print_r(count($results));
echo "</pre>";*/




    ?>
<p align="left" class="Estilo10">Plan de Pagos</p>
<table width="60%"   border="1" align="left" cellpadding="1"  bordercolor="#E9E9E9">	
<tr bgcolor="#E9E9E9" >
  <td colspan="5"><div align="center" class="Estilo12"><span class="Estilo10">CUOTAS PENDIENTES</span></div></td>
</tr>
<tr bgcolor="#E9E9E9" >
  <td ><div align="center" class="Estilo12"><span class="Estilo10">Descripcion Orden</span></div></td>
  <td><div align="center" class="Estilo12"><span class="Estilo10">Fecha Vencimiento</span></div></td>
  <td  colspan="2"><div align="center" class="Estilo12"><span class="Estilo10">Valor</span></div></td>
  <td  colspan="1"><div align="center" class="Estilo12"><span class="Estilo10">Ordenes</span></div></td>
</tr>
<?php 	 

$cantidadarry=count($results);
$cantidadarry;

if(($results[0]['ITEM_TYPE']=='019000000001')&&($results[0]['DUE_DT']!=$results[1]['DUE_DT'])){

$desc=$results[0]['DESCR'];
$valorcuotasinabono=$results[0]['ITEM_AMT'];
$valorAbono=$results[0]['APPLIED_AMT'];
$valorcuota=($valorcuotasinabono-$valorAbono);
$numeroorden=$results[$cantidadarry1]['INVOICE_ID'];
$fechavencimiento=$results[0]['DUE_DT'];
$itemconceptocuota=$results[0]['ITEM_TYPE'];
$numerodocumentoplandepagosap=$numeroorden.$results[0]['ITEM_NBR'];//"1430019".$total['ITEM_NBR'];
$identificadorcuota=$numerodocumentoplandepagosap;

?>
 <tr>
<?php
  echo "<td ><div align='center' class='Estilo13 Estilo14'>".$desc."</div></td>";
  echo "<td colspan='$colspan'><div align='center' class='Estilo13 Estilo14'>".$fechavencimiento."</div></td>";
  echo "<td colspan='2'><div align='center' class='Estilo13 Estilo14'>".$valorcuota."</div></td>";


                $query_conceptosalacuota= "SELECT * FROM carreraconceptopeople ccp, concepto c
                WHERE c.codigoconcepto=ccp.codigoconcepto and itemcarreraconceptopeople=$itemconceptocuota";
    	        $conceptosalacuota = mysql_query($query_conceptosalacuota, $sala) or
                        die("$query_conceptosalacuota".mysql_error());
                $row_conceptosalacuota = mysql_fetch_assoc($conceptosalacuota);
                $totalRows_conceptosalacuota = mysql_num_rows($conceptosalacuota);
		$conceptocuota = $row_conceptosalacuota['codigoconcepto'];

            $hoy = date('Y-m-d');
	    $fechalimite = $fechavencimiento; 

			   if ($fechavencimiento < $hoy)  
			    {			
				  $fechalimite = $hoy; 
				  $timestamp = strtotime($fechavencimiento);
				  $undias = ($timestamp + (60 * 60 * 24 * 1));
                                  $fechapago = date ('Y-m-d',$undias);
			
		     }










        	
	        $query_ordenconplancuota = "SELECT * FROM ordenpagoplandepago
                          where numerorodenpagoplandepagosap = '$numeroorden'
                         and numerodocumentoplandepagosap='$identificadorcuota'";
		 $ordenconplancuota = mysql_query($query_ordenconplancuota, $sala) or die("$query_ordenconplancuota".mysql_error());
		 $row_ordenconplancuota = mysql_fetch_assoc($ordenconplancuota);
		 $totalRows_ordenconplancuota = mysql_num_rows($ordenconplancuota);


                 $query_ordenconplan = "SELECT *
			FROM ordenpagoplandepago
			WHERE codigoestado = '100'
			and (codigoindicadorprocesosap = '300' or codigoindicadorprocesosap = '200')
			and numerorodenpagoplandepagosap = '$numeroorden'";
		 $ordenconplan = mysql_query($query_ordenconplan, $sala) or die("$query_ordenconplan".mysql_error());
		 $row_ordenconplan = mysql_fetch_assoc($ordenconplan);
		 $totalRows_ordenconplan = mysql_num_rows($ordenconplan);

		  $indicadorplancuotapaga = '';

		   if ($totalRows_ordenconplan >= '')
		    {
			  $indicadorplancuotapaga = '1';
			
			}
	 if ($indicadorplancuotapaga == '1' and $text <> 'BLOQUEO')
		   {
		   
             echo "<td><div align='left' class='Estilo13 Estilo14'><a href='../../estadocredito/generarorden.php?ordenpago=$numeroorden&fechalimite=$fechalimite&valorcuota=$valorcuota&valorinteres=$valorinterescuota&conceptocuota=$conceptocuota&conceptointeres=$conceptointeres&identificadorcuota=$numerodocumentoplandepagosap&valortotalcuota=$valortotalcuota'>Generar Orden Pago</a></div></td>";
           }
		  else
		  if ($text == 'BLOQUEO')
		   {
		    echo  "<td>Cuota bloqueada y enviada a Covinoc</td>";
		   }
		  else
		   {
		     echo "<td>&nbsp;</td>";
		   }

?>
 </tr>
<?php
}

 elseif (($results[0]['ITEM_TYPE']=='019000000001')&&($results[0]['DUE_DT']=$results[1]['DUE_DT']))
		   {

$cantidadarry1=0;
		   }
		
		  else
		   {

		    $cantidadarry1=1;
		   }



/*if(($results[0]['ITEM_TYPE']=='019000000001')&&($results[0]['DUE_DT']=$results[1][0]))
{
$cantidadarry1=0
}
else{
$cantidadarry1=1
}*/


/*FOR*/

for($cantidadarry1; $cantidadarry1 < $cantidadarry; $cantidadarry1++) {

/*IF*/
$cantidadarry2=$cantidadarry1+1;
 if(($results[$cantidadarry1]['DUE_DT']=$results[$cantidadarry2]['DUE_DT'])&&($results[$cantidadarry1]['ITEM_TYPE']=='019000000001'))
{

$numeroorden=$results[$cantidadarry1]['INVOICE_ID'];
$fechavencimiento=$results[$cantidadarry1]['DUE_DT'];
$itemconceptocuota=$results[$cantidadarry1]['ITEM_TYPE'];
$itemconceptointeres=$results[$cantidadarry2]['ITEM_TYPE'];
$valorcuota=$results[$cantidadarry1]['ITEM_AMT']-$valorAbonocuota;
$valorinterescuota=$results[$cantidadarry2]['ITEM_AMT']-$valorAbonointeres;
$numerodocumentoplandepagosap="1430019".$numeroorden.$results[$cantidadarry1]['ITEM_NBR'];//"1430019".$total['ITEM_NBR'];
$identificadorcuota=$numerodocumentoplandepagosap;
$valorAbonointeres=$results[$cantidadarry2]['APPLIED_AMT'];
$valorAbonocuota=$results[$cantidadarry1]['APPLIED_AMT'];
$totalabono=($valorAbonointeres+$valorAbonointeres);
$valortotalcuotainteres=$results[$cantidadarry1]['ITEM_AMT']+$results[$cantidadarry2]['ITEM_AMT'];
$desc=$results[$cantidadarry1]['DESCR']." e ".$results[$cantidadarry2]['DESCR'];
$valortotalcuota=$valortotalcuotainteres-$totalabono

 ?>
 <tr>
<?php
  echo "<td ><div align='center' class='Estilo13 Estilo14'>".$desc."</div></td>";
  echo "<td colspan='$colspan'><div align='center' class='Estilo13 Estilo14'>".$fechavencimiento."</div></td>";
  echo "<td colspan='2'><div align='center' class='Estilo13 Estilo14'>".$valortotalcuota."</div></td>";


                $query_conceptosalacuota= "SELECT * FROM carreraconceptopeople ccp, concepto c
                WHERE c.codigoconcepto=ccp.codigoconcepto and itemcarreraconceptopeople=$itemconceptocuota";
    	        $conceptosalacuota = mysql_query($query_conceptosalacuota, $sala) or
                        die("$query_conceptosalacuota".mysql_error());
                $row_conceptosalacuota = mysql_fetch_assoc($conceptosalacuota);
                $totalRows_conceptosalacuota = mysql_num_rows($conceptosalacuota);
		$conceptocuota = $row_conceptosalacuota['codigoconcepto'];

                 $query_conceptosalainteres = "SELECT * FROM carreraconceptopeople ccp, concepto c
                WHERE c.codigoconcepto=ccp.codigoconcepto and itemcarreraconceptopeople=$itemconceptointeres";
    	        $conceptosalainteres = mysql_query($query_conceptosalainteres, $sala) or
                        die("$query_conceptosalainteres".mysql_error());
                $row_conceptosalainteres = mysql_fetch_assoc($conceptosalainteres);
                $totalRows_conceptosalainteres = mysql_num_rows($conceptosalainteres);
		 $conceptointeres = $row_conceptosalainteres['codigoconcepto'];

 $hoy = date('Y-m-d');
	    $fechalimite = $fechavencimiento; 


   
			   if ($fechavencimiento < $hoy)  
			    {			
				  $fechalimite = $hoy; 
				  $timestamp = strtotime($fechavencimiento);
				  $undias = ($timestamp + (60 * 60 * 24 * 1));
                                  $fechapago = date ('Y-m-d',$undias);
				  				 
					
		     }


                 $query_ordenconplancuota = "SELECT * FROM ordenpagoplandepago
                          where numerorodenpagoplandepagosap = '$numeroorden'
                         and numerodocumentoplandepagosap='$identificadorcuota'";
		 $ordenconplancuota = mysql_query($query_ordenconplancuota, $sala) or die("$query_ordenconplancuota".mysql_error());
		 $row_ordenconplancuota = mysql_fetch_assoc($ordenconplancuota);
		 $totalRows_ordenconplancuota = mysql_num_rows($ordenconplancuota);


                 $query_ordenconplan = "SELECT *
			FROM ordenpagoplandepago
			WHERE codigoestado = '100'
			and (codigoindicadorprocesosap = '300' or codigoindicadorprocesosap = '200')
			and numerorodenpagoplandepagosap = '$numeroorden'";
		 $ordenconplan = mysql_query($query_ordenconplan, $sala) or die("$query_ordenconplan".mysql_error());
		 $row_ordenconplan = mysql_fetch_assoc($ordenconplan);
		 $totalRows_ordenconplan = mysql_num_rows($ordenconplan);

		  $indicadorplancuotapaga = '';

		   if ($totalRows_ordenconplan >= '')
		    {
			  $indicadorplancuotapaga = '1';
			
			}
	 if ($indicadorplancuotapaga == '1' and $text <> 'BLOQUEO')
		   {
		    
             echo "<td><div align='left' class='Estilo13 Estilo14'><a href='../../estadocredito/generarorden.php?ordenpago=$numeroorden&fechalimite=$fechavencimiento&valorcuota=$valorcuota&valorinteres=$valorinterescuota&conceptocuota=$conceptocuota&conceptointeres=$conceptointeres&identificadorcuota=$numerodocumentoplandepagosap&valortotalcuota=$valortotalcuota'>Generar Orden Pago</a></div></td>";
           }
		  else
		  if ($text == 'BLOQUEO')
		   {
		    echo  "<td>Cuota bloqueada y enviada a Covinoc</td>";
		   }
		  else
		   {
		     echo "<td>&nbsp;</td>";
		   }

?>
 </tr>
<?php


  } 

}

}
?>
</table>
<br>
<?php
   if ($results <> "")
	{
	?>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
        <br>
	<br>
	<br>
	<?php
	}
?>
<div align="left">
   <input type="button" name="Imprimir" onClick="print()" value="Imprimir">&nbsp;<input type="button" name="Regresar" onClick="history.go(-1)" value="Regresar">
</div>

