<?php 	 
@session_start();
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once($_SESSION['path_live'].'consulta/interfacespeople/lib/nusoap.php');


$cicloelectivo=$_GET['codigoperiodo'];


  $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
$client = new soapclient("http://campus.unbosque.edu.co/PSIGW/PeopleSoftServiceListeningConnector/UBI_CONS_PLANPAGO_SRV.1.wsdl", true);
     
$err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
  $query_cicloelectivo = "SELECT * FROM tmp_reportePS where cicloelectivo='$cicloelectivo'";

  $cicloelectivo = mysql_query($query_cicloelectivo, $sala) or die("$query_cicloelectivo".mysql_error());
      
 $totalRows_cicloelectivo = mysql_num_rows($cicloelectivo);

   if($row_cicloelectivo = mysql_fetch_assoc($cicloelectivo)==""){
	   echo "<script type=\"text/javascript\">alert(\"No hay Registros para este ciclo Electivo\");</script>";
	  
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=menu.php'>";
        exit;  
   }
 
  $nombre_archivo_excel='ReporteEstadoCuenta.xls'; 
 header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=$nombre_archivo_excel");
     

 echo "<table border='1'>";
  echo "<tr>";
echo "<td>Documento</td>";

echo "<td>Tipo Documento</td>";
echo "<td>Nombre</td>";
echo "<td>Carrera</td>";
echo "<td>Concepto</td>";
echo "<td>Valor</td>";
echo "<td>Fecha Vencimiento</td>";
  echo "</tr>"; 
 while($row_cicloelectivo = mysql_fetch_assoc($cicloelectivo)){
	 
	 
	
	  $documento=$row_cicloelectivo['numerodocumento'];
	 $tipodocumento=$row_cicloelectivo['tipodocumento'];
	 	 

	
	
 
 $proxy = $client->getProxy();
	 $param2="   <UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>".$tipodocumento."</NATIONAL_ID_TYPE>
    <NATIONAL_ID>".$documento."</NATIONAL_ID>
        </UB_DATOSCONS_WK>";



$resultado = $client->call('UBI_CONS_PLANPAGO_OPR_SRV',$param2);
$results=$resultado['UBI_ITEMS_WRK'] ['UBI_ITEM_WRK'];
  if($resultado['UBI_ITEMS_WRK']!=""){
	 
	 
	  if(!is_array($results[0])){

    $resultstmp=$results;
    unset($results);
   $results[0]=$resultstmp;

}
  /*echo "paramtro<pre>";
  print_r($param2);
  echo"</pre>";*/
  /*echo "result<pre>";
  print_r($results);
  echo"</pre>";*/
foreach ($results as $valor) {
		   $ordenes=substr($valor['INVOICE_ID'],0,7);
		
		 $query_codigoestudianteord = "select e.codigoestudiante,e.codigocarrera from ordenpago o, estudiante e 
	where o.codigoestudiante=e.codigoestudiante and 
	numeroordenpago='$ordenes'";
          $codigoestudianteord = mysql_query($query_codigoestudianteord, $sala) or die("$query_codigoestudianteord".mysql_error());
       $row_codigoestudianteord = mysql_fetch_assoc($codigoestudianteord);
       $totalRows_codigoestudianteord = mysql_num_rows($codigoestudianteord);
		$codigoestudiantef=$row_codigoestudianteord['codigoestudiante'];
		
		
		
		
		 $query_codigoestudiante = "select nombrecortodocumento,nombrecarrera,
 nombresestudiantegeneral,eg.apellidosestudiantegeneral, eg.numerodocumento
from estudiante e, estudiantegeneral eg, documento d, carrera cr
 where  eg.tipodocumento=d.tipodocumento and  e.codigocarrera=cr.codigocarrera and
  e.idestudiantegeneral=eg.idestudiantegeneral and e.codigoestudiante='$codigoestudiantef'";
          $codigoestudiante = mysql_query($query_codigoestudiante, $sala) or die("$query_codigoestudiante".mysql_error());
       $row_codigoestudiante = mysql_fetch_assoc($codigoestudiante);
       $totalRows_codigoestudiante = mysql_num_rows($codigoestudiante);
		
		
		$carrera=$row_codigoestudiante['nombrecarrera'];
	
$nombre=$row_codigoestudiante['nombresestudiantegeneral']." ".$row_codigoestudiante['apellidosestudiantegeneral'];

		$saldo=$valor['ITEM_AMT']-$valor['APPLIED_AMT'];
		 			
		   echo "<tr>"; 
		   echo "<td>".$documento."</td>";
	   echo "<td>".$tipodocumento."</td>";
	   
	   
	   echo "<td>".$nombre."</td>";
	   echo "<td>".$carrera."</td>";
		              echo "<td>".$valor['DESCR']."&nbsp;</td>";
           echo "<td>".$saldo."</td>";
           echo "<td>".$valor['DUE_DT']."&nbsp;</td>";
             echo "</tr>";
            

	  	         

	 }
 
}

 
}
 
echo "</table>";

?>	 
 
