<?php 
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();
require('../serviciosacademicos/Connections/sala2.php');
$rutaado = ("../serviciosacademicos/funciones/adodb/");
require_once('../serviciosacademicos/Connections/salaado.php');
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
require_once('../serviciosacademicos/funciones/sala_genericas/tiposusuario/Usuario.php');
require_once('../serviciosacademicos/consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
require_once('../serviciosacademicos/funciones/clases/autenticacion/claseldap.php');
require_once("../serviciosacademicos/Connections/conexionldap.php");
require_once("crearlistacorreo.php");
include_once "google/examples/templates/base.php";
ini_set('max_execution_time', '216000');

set_include_path("google/src/" . PATH_SEPARATOR . get_include_path());
require_once 'Google/Client.php';
require_once 'Google/Service/Directory.php';
require_once 'Google/Service/Groupssettings.php';



    $query_periodoactivo = "select * from periodo where codigoestadoperiodo = 1";
    $periodoactivo = $db->Execute($query_periodoactivo);
    $totalRows_periodoactivo = $periodoactivo->RecordCount();
    $row_periodoactivo = $periodoactivo->FetchRow();
    $codigoperiodo=$row_periodoactivo['codigoperiodo'];
    
    $objestadisticas = new obtener_datos_matriculas($db, $codigoperiodo);
    
    # CONEXION A GOOGLE
    
    $client_id = '950142759358-9uqnqkts3fk6e74d7bl42r3ksgfoqtqi.apps.googleusercontent.com';
    $service_account_name = '950142759358-9uqnqkts3fk6e74d7bl42r3ksgfoqtqi@developer.gserviceaccount.com';
    $key_file_location = 'google-privatekey.p12';
    
    $client = new Google_Client();
    $client->setApplicationName("Listas de Correo Estudiantes U. El Bosque");
    $service = new Google_Service_Directory($client);
    $service2 = new Google_Service_Groupssettings($client);
    
    unset($_SESSION['service_token']); 
    if (isset($_SESSION['service_token'])) {
      $client->setAccessToken($_SESSION['service_token']);
    }
    $key = file_get_contents($key_file_location);
    $cred = new Google_Auth_AssertionCredentials(
	$service_account_name,
	array('https://www.googleapis.com/auth/admin.directory.group', 'https://www.googleapis.com/auth/admin.directory.group.member',
	      'https://www.googleapis.com/auth/apps.groups.settings'),
	$key
    );
    $cred->sub = "administradorcorreo@unbosque.edu.co";
    $client->setAssertionCredentials($cred);
    if($client->getAuth()->isAccessTokenExpired()) {
      $client->getAuth()->refreshTokenWithAssertion($cred);
    }
    $_SESSION['service_token'] = $client->getAccessToken();

    /****Fin de Conexion****/

  

	$query_carrera = "SELECT c.nombrecarrera, c.codigocarrera
	FROM carrera c
	where c.codigomodalidadacademica = '200'
	and now() between c.fechainiciocarrera and c.fechavencimientocarrera
	and c.codigocarrera <> 1
	order by 1";
	$carrera = $db->Execute($query_carrera);
	$totalRows_carrera = $carrera->RecordCount();
	//$row_carrera = $carrera->FetchRow();

//echo $row_carrera['nombrecarrera'];



while($row_carrera = $carrera->FetchRow()){

	
	if($client->getAuth()->isAccessTokenExpired()) {
	  $client->getAuth()->refreshTokenWithAssertion($cred);
	  $_SESSION['service_token'] = $client->getAccessToken();
	} 
	
	$codigocarrera=$row_carrera['codigocarrera'];

	$nombrecarrera = strtolower(str_replace(",", "", str_replace(" ", "", quitartilde($row_carrera['nombrecarrera']))));
	$emailList = "estnuevo" . $nombrecarrera;
	
	$simbolos= array(".", "-", "_");
        
        $emailList=str_replace($simbolos,"",$emailList);
        if(strlen($emailList) > 60){
        $emailList=substr($emailList,0,60);
        }
	
	echo "<br><h3>".$emailList." ".$codigoperiodo."</h3>";
	
	
	# 1. Eliminar Grupo 
        try {

            eliminaLista($service, $emailList);
            echo "<br><h5>Elimino la lista= " . $emailList . "</h5>";
        } catch (Google_Service_Exception $miExcepcion) {
        
        echo "<br><h5>No exite el grupo y por tanto no se puede eliminar: ". $emailList ."</h5>";
        
        } catch(Exception $e){
	  //lo demas no importa
        }
	
	# 2.Crear Lista
        $cuentaintentos=0;
        $secreo=true;
        
        do{
        
	  $cuentaintentos++;
	  if($cuentaintentos>10){
	  
	    echo "La lista ". $emailList. "No pudo ser creada";
	    break;
	  
	  }
	  
	  try{    
	      
	      creaLista($service, $emailList);
	      echo "<br><h5>Creo la lista= " . $emailList . "</h5><br>";
	      $secreo=false;
	  
	  } catch(Google_Service_Exception $miExcepcion) {
	  
	      echo "Intento fallido ".$cuentaintentos." Lista=".$emailList;                                     
	      $secreo=true;
	  }
        
        }while($secreo);
        
                
        ob_flush();
        flush();
	
	# 3. Agrega Correos a los grupos
	sleep(10);	
	
	try{
	   unset($usuarioestudiante);
           unset($listausuario);
           
           $db->Close();	   
	   $db->Connect($server, $user, $password, $database); 
           $objestadisticas = new obtener_datos_matriculas($db, $codigoperiodo);
	   $arregloestudiantesnuevos = $objestadisticas->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,"arreglo");
	   	   
	   if(!empty($arregloestudiantesnuevos)){
	   $i = 0;
           foreach ($arregloestudiantesnuevos as $idarreglo => $estudiantematriculado) {
                $datosestudiante = $objestadisticas->obtener_datos_estudiante($estudiantematriculado['codigoestudiante']);
                $usuarioestudiante[$i]["Nombre"] = $datosestudiante['nombre'];
                $usuarioestudiante[$i]["Documento"] = $datosestudiante['numerodocumento'];
                $usuarioestudiante[$i]["Correo_Institucional"] = $datosestudiante['usuario'] . "@unbosque.edu.co";
                $usuarioestudiante[$i]["Correo_Personal"] = $datosestudiante['email'];
                $i++;
            }
	    $listausuario=$usuarioestudiante;    
            agregarCorreosLista($service, $service2, $emailList, $listausuario);  
	    echo "<h4>Se agregan correos a la lista= " . $emailList . "</h4>";
            
	  }
          else{
	       echo "<br><h5>No se agregan correos por que no hay estudiantes matriculados en el periodo para la carrera = ". $emailList ."</h5>";
            }
	} catch (Google_Service_Exception $miExcepcion) {
            echo "<h5>No pudo agregar correos al grupo:". $emailList ."</h5>";
            echo "<pre>";
            print_r($miExcepcion);
            echo "</pre>";
        }

}
?>
