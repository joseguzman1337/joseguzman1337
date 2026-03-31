<?php      
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	  
	  require_once('../../Connections/sala2.php' );
	  mysql_select_db($database_sala, $sala);
	  @session_start();      
	  $link = "../../../imagenes/estudiantes/"; 	
	  require_once('../../funciones//datosestudiante.php');
	  //require_once($_SESSION['path_live'].'consulta/interfacespeople/lib/nusoap.php');
	  //require_once(realpath(dirname(__FILE__)).'/../interfacespeople/lib/nusoap.php');
	  require_once(realpath(dirname(__FILE__)).'/../../../nusoap/lib/nusoap.php');
	  require_once(realpath(dirname(__FILE__)).'/../interfacespeople/conexionpeople.php');
    // require_once('../../../../libsoap/nusoap.php');
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

	$array=array();
require_once(dirname(__FILE__).'/../interfacespeople/reporteCaidaPeople.php');
$envio=0;
	$servicioPS = verificarPSEnLinea();
	if($servicioPS){
$client = new nusoap_client(WEBPLANDEPAGO, true, false, false, false, false, 0, 90);
                          
$err = $client->getError();
if ($err) 
	echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
	
    $proxy = $client->getProxy();
}
     $param2="   <UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>".$row_dataestudiante['nombrecortodocumento']."</NATIONAL_ID_TYPE>
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
	} 		
}
/*
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se le agregan las comillas sencillas en la condicional del numero de documento cuando sea pasaporte ya que es alfanumerico. 
 * @since Agosto 15, 2018
 */
 $query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,
respuestalogtraceintegracionps,documentologtraceintegracionps) VALUES ('Consulta Plan de Pago',
'".$param2."','id:".$resultado['ERRNUM']." descripcion: ".$resultado['DESCRLONG']."','".$row_dataestudiante['numerodocumento']."')";
$plandepago = mysql_query($query, $sala) or die("$query" . mysql_error());
	  
	  
if ($results <> "")
  {  	

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

		
}

 elseif (($results[0]['ITEM_TYPE']=='019000000001')&&($results[0]['DUE_DT']=$results[1]['DUE_DT']))
		   {

$cantidadarry1=0;
		   }
		
		  else
		   {

		    $cantidadarry1=1;
		   }




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
$valortotalcuota=$valortotalcuotainteres-$totalabono;




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

		 


  } 

}

}

