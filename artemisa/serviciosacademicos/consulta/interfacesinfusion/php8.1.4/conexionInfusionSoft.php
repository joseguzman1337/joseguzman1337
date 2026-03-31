<?php
/*
 * @modified Luis Dario Gualteros C. <castroluisd@unbosque.edu.co>
 * Ajustes para el envio de datos cuando el aspirante se registra a un Programa de Educación Continuada.
 * @since Julio 19, 2018.
*/ 

require_once 'vendor/autoload.php';

if(!isset($_SESSION)){
    session_start();
}

/**
 * @modified Dario Gualteros <castroluisd@unbosque.edu.do>
 * Se agregan los archivos de configuracion y conexion a bases de datos utilizados en /sala para unificar conexiones
 * y trabajar con bases de datos persistentes
 * @since Julio 19, 2018
*/
require_once(realpath(dirname(__FILE__)."/../../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();

if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    require_once(PATH_ROOT.'/kint/Kint.class.php');
}

require_once(PATH_SITE.'/lib/Factory.php');

$db = Factory::createDbo();

$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	//CLAVES DE ACCESO A INFUSIONSOFT.
    'clientId' => 'ae9gn8aj9c7vnra69yyyvrz8',
    'clientSecret' => 'RKXmFpQKR4',
    'redirectUri' => 'https://artemisa.unbosque.edu.co//serviciosacademicos/consulta/interfacesinfusion/php5.3/conexionInfusionSoft.php',
));

$infusionsoft->setToken(unserialize($_SESSION['token']));
/*Función para crear y actualizar los token en la base de datos*/
function creaToken($infusionsoft, $db, $tokenRefrescado = 0){
    $hoy = date("Y-m-d H:i:s"); 
    
    //Si no existe ningun token ingresa a crearlo por primera vez dando click en Autorizar.
	if (!$infusionsoft->getToken() && !isset($_GET['code']) && $tokenRefrescado == 0){
		echo '<a href="'.$infusionsoft->getAuthorizationUrl().'">Click aquí para Autorizar</a>';
	}else{
        //Si existe un Token activo, se accede al Token.
		if($tokenRefrescado == 0){
            $tokenAccess = $infusionsoft->requestAccessToken($_GET['code']);
			$infusionsoft->setToken(unserialize($tokenAccess));
        
		}else{
            $tokenAccess = $infusionsoft->getToken();
		}		
        // Se serializa el Token para guardarlo en la Base de Datos (En la tabla TokenInfusionSoft)
		$tokenAccess = serialize($tokenAccess);
		$tokenNuevo = $infusionsoft->getToken()->accessToken;
        
		$SQL_Mod ="UPDATE `TokenInfusionSoft`
			SET `CodigoEstado` = '200'
			WHERE
				(`CodigoEstado` = '100')
			LIMIT 1";
		$resMod =  $db->execute($SQL_Mod);
		 
		$SQL_Insert ="INSERT INTO `TokenInfusionSoft`(
		`token`,
		`FechaCreacion`,
		`CodigoEstado`,
		TokenSerializado
		)
		VALUES
			(
				'".$tokenNuevo."',
				'".$hoy."',
				'100',
				'".mysql_real_escape_string($tokenAccess)."'
			)";
		$resInsert = $db->execute($SQL_Insert); 
        if($resInsert){
            echo "Se creo el Token con Exito";
        }else{
            echo "Error al crear el Token de Acceso";
        }    
	}
}

/*Función para verificar la validez del token en la base de datos e infusionsoft*/
function verificaToken($infusionsoft, $token = '', $db){
	$infusionsoft->setToken(unserialize($token));
    $infusionsoft->getToken()->accessToken;
    //Se verifica si el token actual esta activo
	if($infusionsoft->getToken()->endOfLife <= time()){
        //Si esta vencido se refresca el token 
		$infusionsoft->refreshAccessToken();
        //Se genera un nuen Token de Actualización.
		creaToken($infusionsoft, $db, 1);
	}
}
//Consulta a la tabla TokenInfusionSoft el token activo
$SQL_tokenInicial = "SELECT TokenSerializado FROM TokenInfusionSoft WHERE CodigoEstado = 100";
$ResConsultaT= $db->GetRow($SQL_tokenInicial);
$tokenInicial=$ResConsultaT['TokenSerializado'];
//Si no existe un token activo secrea el token
if($tokenInicial == ''){
   	creaToken($infusionsoft, $db);
}else{
   	$SQL_token = "SELECT TokenSerializado FROM TokenInfusionSoft WHERE CodigoEstado = 100";
	$ResConsulta= $db->GetRow($SQL_token);
	$token=$ResConsulta['TokenSerializado'];
    
	$verificacion = verificaToken($infusionsoft, $token, $db);
}

crearContacto($infusionsoft,$db);

function crearContacto($infusionsoft, $db){

$periodo = $_REQUEST['FechaInicio'];

//Si el periodo viene vacio desde el Formulario se la asigna por defecto el periodo activo para Inscripciones.    
if($periodo =='Fecha de ingreso'){
    $periodo = consultaPeriodo($db, $periodo);  
}   
    
//Consulta el codigo de la Ciudad al nombre de la Ciudad para ser enviada a Infusion.
$SQL_ciudad = "select idciudad, nombreciudad from ciudad where codigosapciudad = ".$_REQUEST['Ciudad']." ";
$resCiudad=$db->GetRow($SQL_ciudad);
    
//Consulta el codigo de la Carerra al nombre de la Carrera para ser enviada a Infusion.	
$SQL_carreraPre = "SELECT nombrecarrera, codigomodalidadacademica FROM carrera WHERE codigocarrera = '".$_REQUEST['Programa']."' ";
$resCarerraPre=$db->GetRow($SQL_carreraPre);
$Modalidad = $resCarerraPre['codigomodalidadacademica'];     
//Si la modalidad es 300 Postgradose le asigna el nombre de la carrera a la variable de InfusionSoft _ProgramasdePosgrado 
if($Modalidad==300){
   $modPostgrado = $resCarerraPre['nombrecarrera'];
   $modPregrado='';
   $modEdContinuada= '';
   $tag = '295'; //Id del Tag creadao para los programas de Postgrados
}else
    if($Modalidad==400){
     $modEdContinuada =  $resCarerraPre['nombrecarrera'];
     $modPregrado='';
     $modPostgrado = '';
     $tag = '299';  //Id del Tag creadao para los programas de Educación Continuada
     
    }else{
     //Si la modalidad es 200 o 800 Pregrado le asigna el nombre de la carrera a la variable de InfusionSoft _Programa
     $modPregrado = $resCarerraPre['nombrecarrera'];    
     $modPostgrado = '';
     $modEdContinuada ='';
     $tag = '283';  //Id del Tag creadao para los programas de Pregrado
    }

//Insercion a InfusionSoft.
$contact = array(
  'FirstName' => $_REQUEST['Nombres'],
  'LastName' => $_REQUEST['Apellidos'],
  'Email' => $_REQUEST['Email'],
  'City' => $resCiudad['nombreciudad'],
  'Phone1' => $_REQUEST['Telefono'],
  '_Programa' => $modPregrado,  // Campo Nuevo en InfusionSoft que recibe el programa de Pregrado
  '_ProgramasdePosgrado' => $modPostgrado, // Campo Nuevo en InfusionSoft que recibe el programa de Postgrado
  '_ProgramasdeEducaciónContinuada'=> $modEdContinuada,  
  '_FechaInicio' => $periodo,  // Campo Nuevo en InfusionSoft que recibe el Periodo del aspirante.
);

//Esta linea activa el check para la autorización del correo del contacto. 
$infusionsoft->emails()->optIn($contact['Email'], 'I have Permission box was checked');

//La siguiente linea autoriza el email del contacto para enviarle correos.
$infusionsoft->emails()->getOptStatus($contact['Email']);

//verificacion de correos duplicados y inserción del contacto a InfusionSoft.    
$cid = $infusionsoft->contacts->addWithDupCheck($contact, 'Email');

if($infusionsoft->contacts->addWithDupCheck($contact, 'Email')){
   echo "Contacto Creado Correctamente en InfusionSoft...";
   //Consulta de el id del contacto insertado en Infusionsoft.
   $idcontacto= $infusionsoft->contacts->load($cid, array('id'));
   $IdContacto = $idcontacto['id'];
   
   //Asignacion del Tag al contacto.
   $infusionsoft->contacts()->addToGroup($IdContacto, $tag);  
   
  
   //consulta el id prematricula para identificarlo y luego modificar el estado del campo EstadoEnvioInfusionSoft.     
   $SQL_idPreinscripcion = "SELECT idpreinscripcion FROM preinscripcion WHERE emailestudiante = '".$_REQUEST['Email']."' AND codigoperiodo = '".$periodo."' LIMIT 1";
   $resIdPreinscripcion = $db->GetRow($SQL_idPreinscripcion);
   $idPreinscripcion = $resIdPreinscripcion['idpreinscripcion'];
   
//Modificacion del campo EstadoEnvioInfusionSoft=1 que indica que el contacto fue creado en InfusionSoft con éxito.
$SQL_UpdateP = "UPDATE `preinscripcion`
        SET `EstadoEnvioInfusionSoft` = '1'
        WHERE
            (`idpreinscripcion` = '".$idPreinscripcion."')
        LIMIT 1 ";
    $resultInsert = $db->execute($SQL_UpdateP);
     
}else{
    echo "Error al crear el contacto en InfusionSoft...";
} 
   
}
?>