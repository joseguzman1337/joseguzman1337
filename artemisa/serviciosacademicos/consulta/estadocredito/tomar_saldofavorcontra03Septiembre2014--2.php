<?php 	 
	$path = getcwd();
		$index = stripos($path, "serviciosacademicos");
		$pathFinal = substr($path,0,$index+20);
require_once($pathFinal.'consulta/interfacespeople/lib/nusoap.php');
//echo "<pre>Entro Aqui STomar Aldos</pre>";
unset($saldoafavor); 
unset($saldoencontra); 

if(isset($_POST['orden'])){
	
	 $query_codigoestudiante = "SELECT d.nombrecortodocumento,eg.numerodocumento 
FROM ordenpago o, estudiante e, estudiantegeneral eg,documento d,documentopeople dp 
 WHERE o.codigoestudiante=e.codigoestudiante 
and eg.idestudiantegeneral=e.idestudiantegeneral and d.tipodocumento=dp.tipodocumentosala
and eg.tipodocumento=d.tipodocumento and numeroordenpago=  '" . $_POST['orden'] . "'";
          $codigoestudiante = mysql_query($query_codigoestudiante, $sala) or die("$query_dataestudiante".mysql_error());
       $row_codigoestudiante = mysql_fetch_assoc($codigoestudiante);
       $totalRows_codigoestudiante = mysql_num_rows($codigoestudiante);	 
       
		

$numerodocumento=$row_codigoestudiante['numerodocumento'];
$nombredocumento=$row_codigoestudiante['nombrecortodocumento'];
}
elseif($banderaestadocuenta){

$numerodocumentose = $_SESSION['codigo'];

	$query_codigoestudiante = "SELECT dp.codigodocumentopeople,eg.numerodocumento,eg.idestudiantegeneral  
FROM estudiantegeneral eg,documento d,documentopeople dp WHERE 
d.tipodocumento=dp.tipodocumentosala
and eg.tipodocumento=d.tipodocumento and eg.numerodocumento = '" . $numerodocumentose . "'";
          $codigoestudiante = mysql_query($query_codigoestudiante, $sala) or die("$query_dataestudiante".mysql_error());
       $row_codigoestudiante = mysql_fetch_assoc($codigoestudiante);
       $totalRows_codigoestudiante = mysql_num_rows($codigoestudiante);

$numerodocumento=$row_codigoestudiante['numerodocumento'];
$nombredocumento=$row_codigoestudiante['codigodocumentopeople'];

}
else{
/*ESTA PARTE DEL CODIGO SE COMENTO POR CAMBIO DE VERSION EN CASO DE ALGUN ERROR  DESCOMENTAR LAS LINEAS Y VERIFICAR EL PROBLEMA*/
/*if($this->codigoestudiante){
	$codigoestudiante=$this->codigoestudiante;
	$sala=$this->sala;
	}
else{
Se metio la conexion a la BD ya que por estado de cuenta funcionaba, pero por la visualizacion de las ordenes se presentaba un problema de conexion a la BD
*/
require($pathFinal.'Connections/sala2.php');
  mysql_select_db($database_sala, $sala);

if(isset($_SESSION['codigo']) && $_SESSION['codigo']!=''){
$codigoestudiante = $_SESSION['codigo'];
}
else{
$codigoestudiante = $this->codigoestudiante;
}

//}
        $query_dataestudiante = "SELECT dp.codigodocumentopeople,eg.numerodocumento,eg.idestudiantegeneral  FROM estudiante e,estudiantegeneral eg,documento d,documentopeople dp WHERE 
e.idestudiantegeneral = eg.idestudiantegeneral and d.tipodocumento=dp.tipodocumentosala
and eg.tipodocumento=d.tipodocumento and e.codigoestudiante = '" . $codigoestudiante . "'";
          $dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
       $row_dataestudiante = mysql_fetch_assoc($dataestudiante);
       $totalRows_dataestudiante = mysql_num_rows($dataestudiante);	 
       
/*echo "No sabe<pre>";
print_r($_SESSION);
echo"</pre>";*/
$numerodocumento=$row_dataestudiante['numerodocumento'];
$nombredocumento=$row_dataestudiante['codigodocumentopeople'];
	
}
     
    $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

  /*$client = new soapclient("http://campus.unbosque.edu.co/PSIGW/PeopleSoftServiceListeningConnector/UBI_ESTADO_CUENTA_SRV.1.wsdl", true);
                           
                                                     
                                   
    $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
    $proxy = $client->getProxy();

       $param2="   <UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>".$nombredocumento."</NATIONAL_ID_TYPE>
    <NATIONAL_ID>".$numerodocumento."</NATIONAL_ID>
        </UB_DATOSCONS_WK>";

    $resultado = $client->call('UBI_CUENTA_CLIENTE_OPR_SRV',$param2);
                              
                                                         


                    
                    
  $query="INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,
respuestalogtraceintegracionps,documentologtraceintegracionps) VALUES ('Consulta Estado de Cuenta',
'".$param2."','id:".$resultado['ERRNUM']." descripcion: ".$resultado['DESCRLONG']."',".$numerodocumento.")";
$plandepago = mysql_query($query, $sala) or die("$query" . mysql_error());


$results=$resultado['UBI_ITEMS_WRK'] ['UBI_ITEM_WRK'];
*/
$results="";
       
/*echo "No sabe<pre>";
print_r($results);
echo"</pre>";*/
$_session['codigofacultad'];

if(!is_array($results[0])){

    $resultstmp=$results;
    unset($results);
   $results[0]=$resultstmp;

}

   /*echo "Estado Cuenta ub<pre>";
                    print_r($row_carrera );
                    echo"</pre>";*/  
if ($results <> "") {
  
    foreach ($results as $valor => $total) { 
		
		$itemconcepto = $total['ITEM_TYPE'];
		
	  	$query_carrera = "SELECT *
		   FROM carrera c, carreraconceptopeople  ccp
		   WHERE  c.codigocarrera=ccp.codigocarrera AND
ccp.itemcarreraconceptopeople = '$itemconcepto'
AND c.codigotipocosto = '100'";
        
        $carrera1 = mysql_query($query_carrera, $sala) or die("$query_carrera" . mysql_error());
        $row_carrera = mysql_fetch_assoc($carrera1);
        $totalRows_carrera = mysql_num_rows($carrera1);  
        
  
       

  
  $fechavence = $total['DUE_DT'];
$valor = $total['ITEM_AMT']-$total['APPLIED_AMT'];

$numerodeorden = $total['INVOICE_ID'];
$cuenta=$total['ACCOUNT_NBR'];
$nombreconcepto=$total['DESCR'];
$fechasaldoafavor=$total['ITEM_EFFECTIVE_DT'];
  
        $query_concepto = "SELECT * FROM carreraconceptopeople ccp, concepto
 c WHERE c.codigoconcepto=ccp.codigoconcepto and itemcarreraconceptopeople='$itemconcepto'";
       
        $concepto = mysql_query($query_concepto, $sala) or die("$query_concepto" . mysql_error());
        $row_concepto = mysql_fetch_assoc($concepto);
        $totalRows_concepto = mysql_num_rows($concepto);
        
                             
/*echo "aquiFDS<pre>";
                    print_r($row_concepto );
                    echo"</pre>";*/


       // $codigocarrera = "";





        //$codigocarrera = $row_carrera['codigocarrera'];
   

        
 $query_codigoestudiantecarrera = "SELECT *
		   FROM estudiante e, prematricula p
		   WHERE e.idestudiantegeneral = '" . $row_dataestudiante['idestudiantegeneral'] . "'
		    and p.codigoestudiante = e.codigoestudiante group by codigocarrera";
       
        $codigoestudiantecarrera = mysql_query($query_codigoestudiantecarrera, $sala) or die("$query_codigoestudiantecarrera" . mysql_error());
        $row_codigoestudiantecarrera = mysql_fetch_assoc($codigoestudiantecarrera);
        $totalRows_codigoestudiantecarrera = mysql_num_rows($codigoestudiantecarrera);

        $codigoestudiante = $row_codigoestudiantecarrera['codigoestudiante'];
$codigocarrera=$row_codigoestudiantecarrera['codigocarrera'];

        if ($row_concepto <> "") {
            if ($row_concepto['codigoconcepto'] == '149' and $codigocarrera <> '98') {
                $row_concepto['codigoconcepto'] = '154';
            }
            if ($row_concepto['codigotipoconcepto'] == '02') {
				
				
               
                //f (isset($codigocarreraantes) && $row_concepto['codigoconcepto'] != 'C9017')
                    
                    
                    
                     $saldoafavor[] = array($codigocarrera,$row_concepto['codigoconcepto'],$row_concepto['nombreconcepto'] , $fechasaldoafavor, $valor, $numerodeorden, $codigoestudiante,$cuenta);
/*echo "aquiFDS<pre>";
                    print_r($saldoafavor );
                    echo"</pre>";*/

               
            }
            else
            if ($row_concepto['codigotipoconcepto'] == '01') {

                $saldoencontra[] = array($codigocarrera,$itemconcepto, $row_concepto['codigoconcepto'], $nombreconcepto , $fechavence,$fechasaldoafavor, $valor, $numerodeorden, $codigoestudiante,$cuenta);
                 
 
            }
        }
    } 
} 
?>	 
