<?php 	 
//unset($saldoafavor); 
//unset($saldoencontra); 

/*esta es para ordenes colegio*/
//require_once('../../../../libsoapInterfaz/nusoap.php');
/*esta es para ordenes normal*/
require_once($_SESSION['path_live'].'consulta/interfacespeople/lib/nusoap.php');

$codigoestudiante = $_SESSION['codigo'];
//require_once('../../consulta/interfacespeople/lib/nusoap.php');

//echo "<pre>Entro Aqui STomar Aldos</pre>";

/*echo "No sabe<pre>";
print_r($this->ruta);
echo"</pre>";*/
$query_dataestudiante = "SELECT *
       FROM estudiante e,estudiantegeneral eg,documento d
       WHERE e.idestudiantegeneral = eg.idestudiantegeneral and eg.tipodocumento=d.tipodocumento
   	   and e.codigoestudiante ='".$codigoestudiante."'";
$dataestudiante = mysql_query($query_dataestudiante, $this->sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);



if ($row_dataestudiante <> "")
{
	
	//$numerodocumento = $row_dataestudiante['numerodocumento'];	     
	$numerodocumento = $row_dataestudiante['idestudiantegeneral'];     
}	
  
     
    $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

  $client = new soapclient("http://campusxxide.unbosque.edu.co:8210/PSIGW/PeopleSoftServiceListeningConnector/UBI_ESTADO_CUENTA_SRV.1.wsdl", true);
    $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
    $proxy = $client->getProxy();

       $param2="   <UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>".$row_dataestudiante['nombrecortodocumento']."</NATIONAL_ID_TYPE>
    <NATIONAL_ID>".$row_dataestudiante['numerodocumento']."</NATIONAL_ID>
	<DEPTID></DEPTID>
        </UB_DATOSCONS_WK>";

    $resultado = $client->call('UBI_CUENTA_CLIENTE_OPR_SRV',$param2);


   /*echo"Esto es el resultado<pre>";
   print_r($resultado);
   echo "</pre>"; */
$results=$resultado['UBI_ITEMS_WRK'] ['UBI_ITEM_WRK'];

if ($results <> "") {
   
  
    foreach ($results as $valor => $total) { 
$fechavence = $total['DUE_DT'];
$valor = $total['ITEM_AMT'];
$itemconcepto = $total['ITEM_TYPE'];
$numerodeorden = $total['INVOICE_ID'];
$cuenta=$total['ACCOUNT_NBR'];

      
       
 $query_concepto = "SELECT * FROM carreraconceptopeople ccp, concepto
 c WHERE c.codigoconcepto=ccp.codigoconcepto and itemcarreraconceptopeople='$itemconcepto'";
      
     $concepto = mysql_query($query_concepto, $this->sala) or die("$query_concepto".mysql_error());
			$row_concepto = mysql_fetch_assoc($concepto);
			$totalRows_concepto = mysql_num_rows($concepto);
      

        $codigocarrera = "";



    $query_carrera = "SELECT *
		   FROM carrera c, carreraconceptopeople ccp
		   WHERE  c.codigocarrera=ccp.codigocarrera AND
ccp.itemcarreraconceptopeople = '$itemconcepto'
AND c.codigotipocosto = '100'";
        
        $carrera = mysql_query($query_carrera, $this->sala) or die("$query_carrera".mysql_error());
			$row_carrera = mysql_fetch_assoc($carrera);
			$totalRows_carrera = mysql_num_rows($carrera);
        
        
       
        $codigocarrera = $row_carrera['codigocarrera'];

        if ($codigocarrera == "") {
            $codigocarrera = $row_dataestudiante['codigocarrera'];
        }

 $query_codigoestudiantecarrera = "SELECT *
		   FROM estudiante e, prematricula p
		   WHERE e.idestudiantegeneral = '" . $row_dataestudiante['idestudiantegeneral'] . "'
		   AND e.codigocarrera = '$codigocarrera'
		   and p.codigoestudiante = e.codigoestudiante";
       
      $codigoestudiantecarrera = mysql_query($query_codigoestudiantecarrera, $this->sala) or die("$query_codigoestudiantecarrera".mysql_error());
			$row_codigoestudiantecarrera = mysql_fetch_assoc($codigoestudiantecarrera);
			$totalRows_codigoestudiantecarrera = mysql_num_rows($codigoestudiantecarrera);
            $codigoestudiante = $row_codigoestudiantecarrera['codigoestudiante'];


        if ($row_concepto <> "") {
            if ($row_concepto['codigoconcepto'] == '149' and $codigocarrera <> '98') {
                $row_concepto['codigoconcepto'] = '154';
            }
            if ($row_concepto['codigotipoconcepto'] == '02') {
               
                if (isset($codigocarreraantes) && $row_concepto['codigoconcepto'] != 'C9017')
                    $saldoafavor[] = array($codigocarrera, $row_concepto['codigoconcepto'], $row_concepto['nombreconcepto'], $fechavence, $valor, $numerodeorden, $codigoestudiante,$cuenta);
            
               
            }
            else
            if ($row_concepto['codigotipoconcepto'] == '01') {

                $saldoencontra[] = array($codigocarrera,$itemconcepto, $row_concepto['codigoconcepto'], $row_concepto['nombreconcepto'], $fechavence, $valor, $numerodeorden, $codigoestudiante,$cuenta);
               
            }
        }
    } 
} 
?>	 

