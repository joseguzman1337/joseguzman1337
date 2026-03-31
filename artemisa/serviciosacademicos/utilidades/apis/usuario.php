<?php 
header("Content-type: application/json");
require_once('./funcionesValidacion.php');
if(strcmp($_SERVER["SERVER_ADDR"], "172.16.36.5")==0  || strcmp($_SERVER["SERVER_NAME"], "localhost")==0  || strcmp($_SERVER["SERVER_ADDR"], "172.16.36.10")==0){
	//pruebas
        $password = 'MovilPruebasBosque2015';
	$salt = '$kubo$/';
	$s_salt = $salt . $password;
	$API_KEY = "Y5mv9Vcvu267k4LGI79P0Wo2Obf1MF9H";
	$appid = "pruebasmovil";
} else {
	//produccion
	$password = 'MovilBosque2015';
	$salt = '$ubm$/';
	$s_salt = $salt . $password;
	$API_KEY = "a9js21tDhmBq17t55w4RI6i3Z1xV6EeB";
	$appid = "eeeba4606501433b1859bdb957702c4cd8605b44";      //kbmovil sha1  
}

function DataCarrera($idusuario,$db,$rol){
    $SQL_User = "SELECT numerodocumento,tipodocumento,codigorol,codigotipousuario 
	FROM usuario WHERE idusuario=? AND codigoestadousuario=100 AND codigorol=?";
    $variables = array();
    
    $variables[] = "$idusuario";
    $variables[] = "$rol";
    
    
    $user = $db->GetRow($SQL_User,$variables);
    
	$exito = false;
    /**
     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Se agrega el codigotipousuario=900 para que el usuario padres de familia pueda visualizar las carreras asociadas al estudiante
     * @since Agosto 26, 2019
     */     
    if(intval($user["codigorol"]) == 1 && intval($user["codigotipousuario"]) == 600 || intval($user["codigotipousuario"]) == 900){
      $SQL='SELECT
            	c.codigocarrera,
            	c.nombrecarrera
            FROM
            	estudiantegeneral eg
            INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral 
			AND e.codigosituacioncarreraestudiante NOT IN (113,109,105) 
            INNER JOIN carrera c ON c.codigocarrera = e.codigocarrera
            WHERE
            	eg.numerodocumento ="'.$user["numerodocumento"].'"  AND (c.fechavencimientocarrera >=CURDATE() OR c.EsAdministrativa=1) '; 
				$exito = true;
    }else if($rol==2){
      $SQL='SELECT
            	c.codigocarrera,
            	c.nombrecarrera
            FROM
            	docente d
            INNER JOIN grupo g ON g.numerodocumento = d.numerodocumento
            INNER JOIN materia m ON m.codigomateria = g.codigomateria
            INNER JOIN carrera c ON c.codigocarrera = m.codigocarrera
            WHERE
            	d.numerodocumento ="'.$user["numerodocumento"].'"  AND (c.fechavencimientocarrera >=CURDATE() OR c.EsAdministrativa=1)  AND c.codigocarrera<>98
            GROUP BY
            	c.codigocarrera';
				$exito = true;
    }		//echo $SQL;
    
	if($exito){
		if($DataCarrera=&$db->Execute($SQL)===false){
			$json["result"]   ="ERROR";
			$json["codigoresultado"] =1;
			$json["mensaje"]         ="Error de Conexión del Sistema SALA";
		} else {			
			$json["result"]   ="OK";
			$json["codigoresultado"] =0;
			//echo "<pre>";print_r($DataCarrera);
            $i = 0;
            $DataNew = '';
            while(!$DataCarrera->EOF){
                /***************************************/
                  $DataNew[$i][0]               = $DataCarrera->fields['codigocarrera'];
                  $DataNew[$i]['codigocarrera'] = $DataCarrera->fields['codigocarrera'];
                  $DataNew[$i][1]               = utf8_encode($DataCarrera->fields['nombrecarrera']);
                  $DataNew[$i]['nombrecarrera'] = utf8_encode($DataCarrera->fields['nombrecarrera']); 
                /***************************************/
                $i++;
                $DataCarrera->MoveNext();
            }
			$json["carreras"] =$DataNew;
		}
	} else { 		
		$json["result"]   ="ERROR";
		$json["codigoresultado"] =3;
		$json["mensaje"]         ="El usuario no es válido.";
	}
      
   return $json; 
               
}//function DataCarrera


if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    
    $Tipo_acceso = $_POST["tipo"];
    $usuario     = $_POST["usuario"];
    $clave       = $_POST["clave"];
    $token       = $_POST["token"];
    $rol         = $_POST["idrol"];
    
    switch ($_POST["action"]){
		//var_dump($_POST); die;
    		case "autenticar_usuario": {	
                
                $sig = hash_hmac("sha1",$s_salt.$usuario.date('Y'),$API_KEY);	
				
				if($_POST["appid"]===$appid && md5($_POST["sig"])===md5($sig)){
				
					if(isset($usuario) && isset($clave) && $usuario!="" && $clave!=""){
                        switch ($Tipo_acceso){
                            case 1:{/****Autenticacion Inicial*****/
                                $json = autenticarUsuario($usuario,$clave,false,$rol);	        
                            }break;
                            case 2:{/****Autenticacion Segunda clave******/
                                $json = autenticarUsuario($usuario,$clave,true);	        
                            }break;                           
                        }//switch interno						
						
					} else {
						$json["result"]          ="ERROR";
						$json["codigoresultado"] =4;
						$json["mensaje"]         ="No se enviaron todos los campos requeridos para la autenticación.";					
					}
				}else{
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =3;
					$json["mensaje"]         ="Ocurrio un error en la autenticación del cliente ";
				}		
    		} break;
            case "carrera_usuario":{  
                $usuario     = $_POST["idusuario"];
				if(validarToken($usuario,$token)){					
					include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                    
                    $json = DataCarrera($usuario,$db,$_POST['idrol']);                         
					
                } else {
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =2;
					$json["mensaje"]         ="El token no es válido.";
				}
                
            }break;

    	}
 }
// echo '<pre>';print_r($json);
echo json_encode($json);
?>