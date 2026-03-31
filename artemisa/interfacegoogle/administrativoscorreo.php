<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();
$rutaado = ("../serviciosacademicos/funciones/adodb/");
require_once("../serviciosacademicos/Connections/salaado-pear.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
require_once("../serviciosacademicos/funciones/sala_genericas/clasebasesdedatosgeneral.php");
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

if ($_GET['ejecutar'] == 1) {
    echo "CREANDO";//exit();
    

    # CONEXION LDAP
    $objetoldap = new claseldap("openldap.unbosque.edu.co", "Unb0squ3_M4n4g3r", PUERTOLDAP, CADENAADMINLDAP, "", RAIZDIRECTORIO);
    //$objetoldap = new claseldap("172.16.3.227", "Unb0squ3_M4n4g3r", PUERTOLDAP, CADENAADMINLDAP, "", RAIZDIRECTORIO);
    $objetoldap->ConexionAdmin();
    
    # CONEXION BASE DE DATOS    
    $objetobase = new BaseDeDatosGeneral($sala);
    
    # FUNCION DE USUARIO    
    $objusuario = new Usuario($objetobase, $objetoldap);
    
    #DATOS DE PERIODO ACTIVO
    $datosperiodo = $objetobase->recuperar_datos_tabla("periodo", "codigoestadoperiodo", "1", "");
    $codigoperiodo = $datosperiodo["codigoperiodo"];
    
    # ESTADISTICAS
    $objestadisticas = new obtener_datos_matriculas($objetobase->conexion, $codigoperiodo);
    $objusuario->setObjEstadisticas($objestadisticas);
    
    # CONEXION A GOOGLE
    
    $client_id = '950142759358-9uqnqkts3fk6e74d7bl42r3ksgfoqtqi.apps.googleusercontent.com';
    $service_account_name = '950142759358-9uqnqkts3fk6e74d7bl42r3ksgfoqtqi@developer.gserviceaccount.com';
    $key_file_location = 'google-privatekey.p12';
    
    $client = new Google_Client();
    $client->setApplicationName("Listas de Correo Administrativos U. El Bosque");
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
        
        $emailList = "administrativo";        
         
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
        try {
	    
	    $listausuario = $objusuario->listaUsuarioAdministrativo(1);         
	               
            if(!empty($listausuario)){
            
	      agregarCorreosLista($service, $service2, $emailList, $listausuario);  
	      echo "<h4>Se agregan correos a la lista= " . $emailList . "</h4>";
	            
	      unset($fila);	      
	      $tabla = "carreraemail";
	      $fila['codigocarrera'] = $codigocarrera;
	      $fila['codigotipousuario'] = '700';
	      $fila['emailcarreraemail'] = $emailList;
	      $fila['codigoestado'] = '100';
	      $condicion = " codigocarrera='" . $fila['codigocarrera'] . "'" .
		      " and codigotipousuario=" . $fila['codigotipousuario'];
		
		if(!mysql_ping ($sala)){
		  $sala->Close();
		  $sala->Connect($server, $user, $password, $database);		 
		}
	      
	      try{
	      
	      $objetobase->insertar_fila_bd($tabla, $fila, $imprimir, $condicion);
	      
	      }catch(Exception $excepcion){  
		
		  $sala->Close();
		  $sala->Connect($server, $user, $password, $database);	
		  $objetobase->insertar_fila_bd($tabla, $fila, $imprimir, $condicion);
	      
	      }
	      
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

$sala->Close();

?>
