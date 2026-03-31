<?php

session_start(); 
$_SESSION['MM_Username'] = 'estudiante';

/****** 1 vez a la semana domingo en la madrugrada *****/

    include("../templates/template.php");
    $db = getBD();
	//var_dump($db);
    $utils = new Utils_datos();
    //var_dump(function_exists('curl_init'));
    if(function_exists('curl_init')) // Comprobamos si hay soporte para cURL
    {
        //$url = "http://sitiio.unbosque.edu.co/session"; 
        //$postData = "login=apiuser&password=k5PgiYOr7z";   
        /*******GRUPOS DE INVESTIGACION ****/
        $ch = curl_init();  
        
        $url = "http://sitiio.unbosque.edu.co/admin/stats/custom/api/stat16";
        
        $opts = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            //CURLOPT_POST => 1,
            //CURLOPT_POSTFIELDS => array('data' => json_encode($postData)),
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FAILONERROR => 1,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC, 
            CURLOPT_USERPWD => "apiuser:k5PgiYOr7z",
            CURLOPT_CUSTOMREQUEST, 'GET'
        );
        // Assign the cURL options
        curl_setopt_array($ch, $opts);
        
        // Get the response
        $resultado = curl_exec($ch);
        
        //$url = "http://sitiio.unbosque.edu.co/session"; 
        //$postData = "login=apiuser&password=k5PgiYOr7z";  
        //buscar por nombre de grupo--> http://sitiio.unbosque.edu.co/search?query=ANALIMA.+Grupo+de+Investigaci%C3%B3n+en+Filosof%C3%ADa+de+la+Ciencia%2C+Acci%C3%B3n+y+Comunicaci%C3%B3n.
        //coger el primer search result el href --> http://sitiio.unbosque.edu.co/communities/7
        //buscar el que dice área colciencias

        // Close cURL
        curl_close($ch);
        
        $data = json_decode($resultado, TRUE);
		//echo "<pre>";print_r($data);
        $num = count($data["Grupos"]);
		//echo "</pre><br/><br/>";var_dump($num);
        $areas = array();
        for($i=0; $i<$num; $i++){
            $sql = 'SELECT * FROM areaconocimientositiio WHERE nombre LIKE "%'.$data["Grupos"][$i]["total_cells"].'%" AND codigoestado=100';
            $area = $db->GetRow($sql);
            if(count($area)>0){
                //echo "<pre>";print_r($data["Grupos"][$i]); echo "<br/><br/>";
                $areas[$area["idareaconocimientositiio"]][] = $data["Grupos"][$i]["grupo"];
            } else {
                $fields = array();
                //echo "voy a insertar"; echo "<br/><br/>";
                $fields["nombre"] = $data["Grupos"][$i]["total_cells"];
                $result = $utils->processData("save","areaconocimientositiio",$fields,false,false,"");
                $areas[$result][] = $data["Grupos"][$i]["grupo"];
            }
        }
        echo "<pre>";print_r($areas);echo "<br/><br/>";
        
        $year = date("Y");
        $currentdate  = date("Y-m-d H:i:s");
        
        $sql = 'SELECT * FROM areasconocimientocolciencias WHERE periosidaanual = "'.$year.'" AND codigoestado=100';
		echo $sql;
        $area = $db->GetRow($sql);
        $sql = 'SELECT * FROM verificar_areasconocimientocolciencias WHERE codigoperiodo = "'.$year.'" AND codigoestado=100';
        $validar = $db->GetRow($sql);
        $fields = array();
        $fields["CienciasSociales"] = "0";
        $fields["CienciasSalud"] = "0";
        $fields["Ingenierias"] = "0";
        $fields["letrasArtes"] = "0";
        foreach ($areas as $key => $value){
            if($key==1){
                $fields["CienciasSociales"] = count($value);
            }
            if($key==2){
                $fields["CienciasSalud"] = count($value);
            }
            if($key==4){
                $fields["Ingenierias"] = count($value);
            }
            if($key==3){
                $fields["letrasArtes"] = count($value);
            }
        }
        
        $user = $utils->getUser();
        $userid = $user["idusuario"];
		var_dump(count($area));
        if(count($area)==0){
            $sql = "INSERT INTO `areasconocimientocolciencias` (`CienciasSalud`, `CienciasSociales`, `Ingenierias`, `letrasArtes`, `periosidaanual`, `entrydate`, `userid`, `codigoestado`) 
                        VALUES (".$fields['CienciasSalud'].", ".$fields['CienciasSociales'].", ".$fields['Ingenierias'].", ".$fields['letrasArtes'].", ".$year.", '".$currentdate."', ".$userid.", 100)";
						echo $sql;
            $result = $db->Execute($sql);
        } else {
            $query = "";
            if($validar["vCienciasSalud"]!=1){
                $query = "`CienciasSalud`=".$fields['CienciasSalud'];
            }
            if($validar["vCienciasSociales"]!=1){
                if($query!==""){
                    $query .= ", ";
                }
                $query .= "`CienciasSociales`=".$fields['CienciasSociales'];
            }
            if($validar["vIngenierias"]!=1){
                if($query!==""){
                    $query .= ", ";
                }
                $query .= "`Ingenierias`=".$fields['Ingenierias'];
            }
            if($validar["vLetrasArtes"]!=1){
                if($query!==""){
                    $query .= ", ";
                }
                $query .= "`letrasArtes`=".$fields['letrasArtes'];
            }
            
            if($query!==""){
                $sql = "UPDATE `areasconocimientocolciencias` SET 
                                $query WHERE periosidaanual = '".$year."' AND codigoestado=100";
								echo $sql;
                $result = $db->Execute($sql);
            }
        }
        
		$defYear = $year;
		//últimos 5 años
		for($z=0; $z<5; $z++){
			$year = $defYear - $z;
				echo "<br/>año--> ".$year;
			//PUBLICACIONES
			$ch = curl_init();  
			$url = "http://sitiio.unbosque.edu.co/admin/stats/custom/api/stat8?year=".$year;
			
			$opts = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_TIMEOUT => 120,
				CURLOPT_FAILONERROR => 1,
				CURLOPT_HTTPAUTH => CURLAUTH_BASIC, 
				CURLOPT_USERPWD => "apiuser:k5PgiYOr7z",
				CURLOPT_CUSTOMREQUEST, 'GET'
			);
			// Assign the cURL options
			curl_setopt_array($ch, $opts);
			
			// Get the response
			$resultado = curl_exec($ch);

			// Close cURL
			curl_close($ch);
			
			$data = json_decode($resultado, TRUE);
			$num = count($data["Publicaciones"]);
			$publicaciones = array();
			$publicaciones["index"] = 0;
			$publicaciones["notIndex"] = 0;
			for($i=0; $i<$num; $i++){
				$publicaciones["index"] += $data["Publicaciones"][$i]["total_indexed"];
				$publicaciones["notIndex"] += $data["Publicaciones"][$i]["total_not_indexed"];
			}
			//echo "<pre>";print_r($publicaciones);echo "<br/><br/>";
			
			$sql = 'SELECT * FROM publicacionesperiodicas WHERE periosidaanual = "'.$year.'" AND codigoestado=100';
			$area = $db->GetRow($sql);
			$sql = 'SELECT * FROM verificar_publicacionesperiodicas WHERE codigoperiodo = "'.$year.'" AND codigoestado=100';
			$validar = $db->GetRow($sql);
			$fields = array();
			$fields["indexadas"] = "0";
			$fields["no_indexada"] = "0";
			foreach ($publicaciones as $key => $value){
				if($key==="index"){
					$fields["indexadas"] = $value;
				}
				if($key==="notIndex"){
					$fields["no_indexada"] = $value;
				}
			}
			
			if(count($area)==0){
				$sql = "INSERT INTO `sala`.`publicacionesperiodicas` (`indexadas`, `no_indexada`, `periosidaanual`, `entrydate`, `userid`, `codigoestado`)  
							VALUES (".$fields['indexadas'].", ".$fields['no_indexada'].", ".$year.", '".$currentdate."', ".$userid.", 100)";
				$result = $db->Execute($sql);
			} else {
				$query = "";
				if($validar["vIndexadas"]!=1){
					$query = "`indexadas`=".$fields['indexadas'];
				}
				if($validar["vNo_indexada"]!=1){
					if($query!==""){
						$query .= ", ";
					}
					$query .= "`no_indexada`=".$fields['no_indexada'];
				}
				
				if($query!==""){
				 $sql = "UPDATE `sala`.`publicacionesperiodicas` SET 
								$query WHERE periosidaanual = '".$year."' AND codigoestado=100";
				 $result = $db->Execute($sql);
				}
			}     
		}	
		$year = $defYear;		
        
        //SEMILLEROS
        /*$ch = curl_init();  
        
        $url = "http://sitiio.unbosque.edu.co/api/users/";
        
        $opts = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FAILONERROR => 1,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC, 
            CURLOPT_USERPWD => "apiuser:k5PgiYOr7z",
            CURLOPT_CUSTOMREQUEST, 'GET'
        );
        // Assign the cURL options
        curl_setopt_array($ch, $opts);
        
        // Get the response
        $resultado = curl_exec($ch);

        // Close cURL
        curl_close($ch);
        
        $data = json_decode($resultado, TRUE);
        $num = count($data["Users"]);
        $estudiantes = array();
        for($i=0; $i<$num; $i++){
            $correoUsuario = $data["Users"][$i]["email"];
            if (strpos($correoUsuario,'@unbosque.edu.co') !== false) {
                //echo "<pre>";print_r($correoUsuario);echo "<br/><br/>";
                $usuario = str_replace('@unbosque.edu.co', '', $correoUsuario);
                //verificar si es un usuario estudiante
                $sql = 'SELECT ec.codigocarrera FROM usuario u 
                        INNER JOIN estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento 
                        INNER JOIN estudiantecarrerainscripcion ec ON ec.idestudiantegeneral=eg.idestudiantegeneral 
                        WHERE u.usuario = "'.$usuario.'" AND u.codigoestadousuario=100 AND u.codigorol=1';
                //var_dump($sql);echo "<br/><br/>";
                $estudiante = $db->GetRow($sql);
                if(count($estudiante)>0){
                    $estudiantes[$estudiante["codigocarrera"]][] = $usuario;
                }
            }
        }
        //echo "<pre>";print_r($estudiantes);echo "<br/><br/>";
        
        $sql = 'SELECT codigocarrera as id, nombrecarrera FROM carrera
		WHERE codigomodalidadacademicasic="200" AND codigocarrera  NOT IN (1, 2) AND fechavencimientocarrera>"'.$currentdate.'"';
        $carreras = $db->GetAll($sql);
        foreach ($carreras as $row) {
            $sql = 'SELECT * FROM semillerosinvestigacion WHERE carrera_id ='.$row["id"].' AND periosidaanual = "'.$year.'" AND codigoestado=100';
            $resultRow = $db->GetRow($sql);
            $sql = 'SELECT * FROM verificar_semillerosinvestigacion WHERE codigocarrera='.$row["id"].' AND codigoperiodo = "'.$year.'" AND codigoestado=100';
            $validar = $db->GetRow($sql);
            //echo $sql."<br/><br/>";
            
            if($estudiantes[$row["id"]]!=null && isset($estudiantes[$row["id"]])){                
                if(count($resultRow)==0){
                        $sql = "INSERT INTO `sala`.`semillerosinvestigacion` (`carrera_id`, `num_semillero`, `periosidaanual`, `entrydate`, `userid`, `codigoestado`) 
                                    VALUES (".$row["id"].", ".count($estudiantes[$row["id"]]).", ".$year.", '".$currentdate."', ".$userid.", 100)";
                        $result = $db->Execute($sql);
                    } else {
                        $query = "";
                        if($validar["vnum_semillero"]!=1){
                            $query = "`num_semillero`=".count($estudiantes[$row["id"]]);
                        }

                        if($query!==""){
                            $sql = "UPDATE `sala`.`semillerosinvestigacion` SET 
                                      $query WHERE carrera_id ='".$row["id"]."' AND periosidaanual = '".$year."' AND codigoestado=100";
                            $result = $db->Execute($sql);
                        }
                    }
            } else {                
                if(count($resultRow)==0){
                        $sql = "INSERT INTO `sala`.`semillerosinvestigacion` (`carrera_id`, `num_semillero`, `periosidaanual`, `entrydate`, `userid`, `codigoestado`) 
                                    VALUES (".$row["id"].", 0, ".$year.", '".$currentdate."', ".$userid.", 100)";
                        $result = $db->Execute($sql);
                    } else {
                        $query = "";
                        if($validar["vnum_semillero"]!=1){
                            $query = "`num_semillero`=0";
                        }

                        if($query!==""){
                            $sql = "UPDATE `sala`.`semillerosinvestigacion` SET 
                                    $query WHERE carrera_id ='".$row["id"]."' AND periosidaanual = '".$year."' AND codigoestado=100";
                            $result = $db->Execute($sql);
                        }
                    }
            }
            //echo $sql."<br/><br/>";
        } */
        
    } else {
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        //$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        

        // Cabeceras adicionales
        //$cabeceras .= 'To: ' .$to. "\r\n";
        $cabeceras .= 'From: Equipo MGI <equipomgi@unbosque.edu.co>' . "\r\n";
        //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
        $mensaje = "No functiona cURL en producción";
        $to = "bonillaleyla@unbosque.edu.co";
        $asunto = "Actualizar Investigacion no funciona";
          // Enviamos el mensaje
          if (mail($to, $asunto, $mensaje, $cabeceras)) {
                $aviso = "Su mensaje fue enviado.";
                $succed = true;
          } else {
                $aviso = "Error de envío.";
                $succed = false;
          }
    }
?>
