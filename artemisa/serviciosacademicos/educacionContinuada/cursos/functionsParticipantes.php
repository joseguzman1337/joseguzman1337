<?php
	session_start;
/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	function getCiudad($db,$ciudadStr){
		$sql = "SELECT idciudad,nombreciudad FROM ciudad WHERE nombreciudad LIKE '%".$ciudadStr."%' OR 
								nombrecortociudad LIKE '%".$ciudadStr."%'";
						$ciudad = $db->GetRow($sql);
		$idCiudad = null;				
						if(count($ciudad)==0){
							//poner como estranjero
							$idCiudad=2000;
						} else {
							$idCiudad = $ciudad["idciudad"];
						}
		return $idCiudad;
	}
	
	function getEstudianteGeneral($db,$numeroDocumento){
			$estudiantegeneralSelectSql="select idestudiantegeneral from estudiantegeneral where numerodocumento='$numeroDocumento';";
            $estudiantegeneralSelectRow = $db->GetRow($estudiantegeneralSelectSql);
			
			return $estudiantegeneralSelectRow;
	}
?>