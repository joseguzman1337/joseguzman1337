<?php 
$ordenesvencidas = false;     

$Dato = array();

//$cuentaconceptos = $this->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
if($this->existe_ordenespagas() || $this->existe_ordenesenproceso() || $this->existe_ordenesporpagar()){


$Dato['result']          =  'OK';
$Dato['codigoresultado'] = 0;  
$Dato['periodo']         = $this->codigoperiodo;
 
 foreach($this->ordenesdepago as $key => $value){ 
        if($value->api_dataordenesestudiante()!==false){  
            $Dato['ordenes'][] = $value->api_dataordenesestudiante();    
        }
    	            
  }  
 
 $Dato;
}else{ 
	/*
	 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
	 * Se agregó una escepcion para dar una respuesta cuando no se registren ordenes de pago, cuando esto ocurra se agrega al log de errores
	 * @since  January 24, 2017
	*/
	$text ='';
	require_once("../../utilidades/apis/ErrorLog.php");
	$log = new ErrorLog("logOrdenesPago", "../../utilidades/apis/logs/");
	
	$text .= 'token: '.$_REQUEST['token'];
	$text .= ' - idusuario: '.$_REQUEST['idusuario'];
	$text .= ' - carrera: '.$_REQUEST['carrera'];
	$text .= ' - action: '.$_REQUEST['action'];
	
	$log->insert( $text );

	$Dato["result"] = "ERROR";
    $Dato["codigoresultado"] = 1;
    $Dato["mensaje"] = "Error No se registran ordenes de pago";
	/*Fin Modificacion*/
}
 ?>