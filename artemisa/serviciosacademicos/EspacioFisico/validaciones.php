<?php
// echo "hola";
// echo "<pre>"; print_r($_REQUEST);


/**
* 
*/
class Validaciones
{
	private $error;
	function __construct(){
	}
	function validaFecha($fecha,$mensaje=""){
		if (($ts = strtotime($fecha))=== false){
			$this->error[] = $mensaje;
			return false;
		}else{
			return true;
		}
	}
}

?>