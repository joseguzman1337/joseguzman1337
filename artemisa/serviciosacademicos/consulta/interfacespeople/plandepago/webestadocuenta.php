<?php
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once(dirname(__FILE__).'/../../../../nusoap/lib/nusoap.php');
//require_once('../conexionpeople.php');

$query_dataestudiante = "SELECT *
       FROM estudiante e,estudiantegeneral eg,documento d
       WHERE e.idestudiantegeneral = eg.idestudiantegeneral and eg.tipodocumento=d.tipodocumento
   	   and e.codigoestudiante = '56203'";
//echo $query_dataestudiante,"<br>";
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);

   /*  $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';*/

//$client = new soapclient("http://campusxxide.unbosque.edu.co:8210/PSIGW/PeopleSoftServiceListeningConnector/UBI_CONS_PLANPAGO_SRV.1.wsdl", true);
  $client = new nusoap_client(WEBESTADOCUENTA, true, false, false, false, false, 0, 300);
$err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
   // $proxy = $client->getProxy();

        // $parametros['NATIONAL_ID_TYPE']='CC';//$row_dataestudiante['nombrecortodocumento'];
         //  $parametros['NATIONAL_ID']='1019008573';//$row_dataestudiante['numerodocumento'];

     /*$param2="   <UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>CC</NATIONAL_ID_TYPE>
    <NATIONAL_ID>1026252690</NATIONAL_ID>
        </UB_DATOSCONS_WK>";*/

    /*$param2="<UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>CC</NATIONAL_ID_TYPE>
    <NATIONAL_ID>1019008573</NATIONAL_ID>
        </UB_DATOSCONS_WK>";*/

   /* $param2="<UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>TI</NATIONAL_ID_TYPE>
    <NATIONAL_ID>93101005079</NATIONAL_ID>
        </UB_DATOSCONS_WK>";*/
        
         $param2="   <UB_DATOSCONS_WK>
           <NATIONAL_ID_TYPE>".$row_dataestudiante['nombrecortodocumento']."</NATIONAL_ID_TYPE>
    <NATIONAL_ID>".$row_dataestudiante['numerodocumento']."</NATIONAL_ID>
	<DEPTID></DEPTID>
        </UB_DATOSCONS_WK>";



$resultado = $client->call('UBI_CUENTA_CLIENTE_OPR_SRV',$param2);

/*if($resultado['ERRNUM']!=0) {
		echo "<script>alert('Se presento un error al mostrar su estado de cuenta, por favor comunicarse con la Universidad.')</script>";
		//$this->anular_ordenpago();
        	mysql_query("update logordenpago set observacionlogordenpago='ESTADOCUENTA (ERROR PEOPLE = id: ".$resultado['ERRNUM']." - descripcion: ".$resultado['DESCRLONG'].") ' where numeroordenpago=".$numerodeorden." and observacionlogordenpago like '%ESTADOCUENTA%'", $sala) or die(mysql_error());
	}*/
echo "Resultado<pre>";
           print_r($resultado);
            echo "</pre>";

          
            echo "<pre>";
           print_r($param2);
            echo "</pre>";

   echo '<h2>Request</h2>';
    echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
   echo '<h2>Response</h2>';
    echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
   echo '<h2>Debug</h2>';
    echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';


//$results=$resultado['UBI_ITEMS_WRK'] ['UBI_ITEM_WRK'];


         /* echo "<pre>";
           print_r($param2);
            echo "</pre>";*/

?>
