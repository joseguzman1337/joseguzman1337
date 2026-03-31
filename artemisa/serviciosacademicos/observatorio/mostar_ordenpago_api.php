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
}
 ?>