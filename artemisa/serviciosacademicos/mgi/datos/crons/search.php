<?php
	session_start();
    require_once("../templates/template.php");
    $db = getBD();
	$Letra   		= $_REQUEST['term'];
        
	$SQL_Buscar='SELECT
				iddiploma,
				nombrediploma
			FROM
				diploma
			WHERE
				nombrediploma LIKE "%'.$Letra.'%"';
				
			if($ResultUsuario=&$db->Execute($SQL_Buscar)===false){
				$a_vectt['val']			='FALSE';
				$a_vectt['descrip']		='Error en el SQL de Busqueda de Usuarios... ';
				echo json_encode($a_vectt);
				exit; 
			}
			$Result = array();
			while(!$ResultUsuario->EOF){
				/************************************/
				  $C_Result['label']                 = $ResultUsuario->fields['nombrediploma'];
				  $C_Result['id_diploma']            = $ResultUsuario->fields['iddiploma'];
				  array_push($Result,$C_Result);
				/************************************/
				$ResultUsuario->MoveNext();
			}//while  
		if(empty($Result))	{
			
			echo '<script> $("#DIV_DataActuales").empty(); </script>'; 
		}else{
			echo json_encode($Result); 
		}
?>