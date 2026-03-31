<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();

    function CalcularTamano($bytes) 
    {
        $bytes = $bytes[0];
        $labels = array('B', 'KB', 'MB', 'GB', 'TB');
    	foreach($labels AS $label)
        {
            if ($bytes > 1024)
            {
    	       $bytes = $bytes / 1024;
            }
            else {
    	      break;
    	    }
        }  
        $datos[] =round($bytes, 2);
        $datos[] = $label; 
        return $datos;
    } 

switch($_REQUEST['actionID']){
    case 'carga_facultad':
    {
         $convenio=$_REQUEST['convenio'];
        $modalidad = $_REQUEST['modalidad'];
        if($modalidad == 200){
			$SQL = 'SELECT DISTINCT fac.codigofacultad, fac.nombrefacultad FROM facultad fac WHERE fac.codigoestado = 100 ORDER BY fac.nombrefacultad';
		}else{
			 $SQL = 'SELECT DISTINCT car.codigocarrera, car.nombrecarrera '
                                . 'FROM carrera car WHERE (fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1) '
                                . 'AND car.codigomodalidadacademica = '.$modalidad.' ORDER BY car.nombrecarrera';
		}
		
		if($Resultado=&$db->Execute($SQL)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'ERROR '.$sql_update_actividades; 
        }else{
			if($modalidad == 200){
				$imp = '<option value="0" selected="selected">Seleccione</option>';
				if(!$Resultado->EOF){
					while(!$Resultado->EOF){
						$imp .= '<option value="'.$Resultado->fields['codigofacultad'].'">'.$Resultado->fields['nombrefacultad'].'</option>';
						$Resultado->MoveNext();
					}
				}
			}else{
                                 $SQLC="SELECT DISTINCT CC.codigocarrera, CC.codigoestado
                                    FROM carrera car
                                    LEFT JOIN conveniocarrera CC ON car.codigocarrera=CC.codigocarrera	 
                                    WHERE
                                            (car.fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1) 
                                             AND CC.ConvenioId='$convenio' ";
                                if($ResultadoCheck=&$db->Execute($SQLC)===false){
                                    echo 'Error en consulta a base de datos';
                                    die; 
                                }
				//$imp = '<option value="0" selected="selected">Seleccione</option>';
                                $check='';
				$imp = '<tr>';
				$i=1;
                                $z=0;
				if(!$Resultado->EOF){
					while(!$Resultado->EOF){
                        if($ResultadoCheck=&$db->Execute($SQLC)===false){
                                echo 'Error en consulta a base de datos';
                                die; 
                            }
                                while(!$ResultadoCheck->EOF){
                                    if($Resultado->fields['codigocarrera']===$ResultadoCheck->fields['codigocarrera'] && $ResultadoCheck->fields['codigoestado'] == '100'){
                                            $check='checked';
                                    }
                                     $ResultadoCheck->MoveNext();
                                    
                                }
                                                
                                                //$imp .= '<option value="'.$Resultado->fields['codigocarrera'].'">'.$Resultado->fields['nombrecarrera'].'</option>';
						$imp .= "<td><input $check type='checkbox' name='carrera".$i."' id='carrera".$i."' value='".$Resultado->fields['codigocarrera']."'>".$Resultado->fields['nombrecarrera']."</td></tr>";
                                                $check='';
						$Resultado->MoveNext();
                                                
						$i++;  
					}
					$imp.= "<input type='hidden' name='contador' id='contador' value='".$i."'";
				}
                              
			}
		}
        $a_vectt['option'] = $imp;
		$a_vectt['val'] = 'TRUE';
		$a_vectt['modalidad'] = $modalidad;
		echo json_encode($a_vectt);
    }break;
    case 'cargar_programa_academico':{
            $documento_docente = $_REQUEST['documento_docente'];
            $Facultad_id = $_REQUEST['facultad_id'];
            $Periodo_id = $_REQUEST['periodo_id'];
			$modalidad = $_REQUEST['modalidad'];
            $SQL = 'SELECT DISTINCT car.codigocarrera, car.nombrecarrera FROM carrera car WHERE (car.fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1)
                AND car.codigofacultad = '.$Facultad_id.'
                AND car.codigomodalidadacademica <> 400
				AND car.codigomodalidadacademica = '.$modalidad.'
                ORDER BY car.nombrecarrera';
            if($Resultado=&$db->Execute($SQL)===false){
                echo 'Error en consulta a base de datos';
                die; 
            }
            $check='';
           $imp = '<tr><td><select name="carrera" id="carrera">';
		   $t =1;
            if(!$Resultado->EOF){
                while(!$Resultado->EOF){
                    //$imp .= "<td><input $check id='carrera".$t."' name='carrera[]' type='checkbox' value='".$Resultado->fields['codigocarrera']."'>".$Resultado->fields['nombrecarrera']."</td></tr>";
                    $imp .= '<option value = "'.$Resultado->fields['codigocarrera'].'">'.$Resultado->fields['nombrecarrera'].'</option>';
					$t++;
                    $Resultado->MoveNext();
                    
                }
				$imp .= '</td></tr>';
                $imp.= "<input type='hidden' name='contador_carrera' id='contador_carrera' value='".$t."'";
            }
            echo $imp;
        }break;
        case 'cargar_programa_academico_carreraconvenio':{
            $documento_docente = $_REQUEST['documento_docente'];
            $Facultad_id = $_REQUEST['facultad_id'];
            $Periodo_id = $_REQUEST['periodo_id'];
            $convenio=$_REQUEST['convenio'];
	    $modalidad = $_REQUEST['modalidad'];
            $SQL = 'SELECT DISTINCT car.codigocarrera, car.nombrecarrera FROM carrera car                
                WHERE
                	(car.fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1)
                AND car.codigofacultad = '.$Facultad_id.'
                AND car.codigomodalidadacademica <> 400
				AND car.codigomodalidadacademica = '.$modalidad.'
                ORDER BY car.nombrecarrera';
            if($Resultado=&$db->Execute($SQL)===false){
                echo 'Error en consulta a base de datos';
                die; 
            }
            $SQL="SELECT DISTINCT CC.codigocarrera, CC.codigoestado FROM carrera car
                            LEFT JOIN conveniocarrera CC ON car.codigocarrera=CC.codigocarrera	 
                            WHERE
                                    (car.fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1) 
                                     AND car.codigofacultad = '".$Facultad_id."' 
                                     AND car.codigomodalidadacademica <> 400
                                     AND car.codigomodalidadacademica = '".$modalidad."'                                     
                                     AND CC.ConvenioId='".$convenio."'";                                     
            if($ResultadoCheck=&$db->Execute($SQL)===false){
                echo 'Error en consulta a base de datos';
                die; 
            }
            $check='';
            $imp = '<tr>';
            $i=1;
            if(!$Resultado->EOF){
                while(!$Resultado->EOF)
                {
                    if($ResultadoCheck=&$db->Execute($SQL)===false){
                        echo 'Error en consulta a base de datos';
                        die; 
                    }
                     while(!$ResultadoCheck->EOF){
                            if($Resultado->fields['codigocarrera']===$ResultadoCheck->fields['codigocarrera'] && $ResultadoCheck->fields['codigoestado']== '100'){
                                    $check='checked';
                            }
                             $ResultadoCheck->MoveNext();                 
                        }
                    $imp .= "<td><input $check type='checkbox' name='carrera".$i."' id='carrera".$i."' value='".$Resultado->fields['codigocarrera']."'>".$Resultado->fields['nombrecarrera']."</td></tr>";
                    $check='';
                    $Resultado->MoveNext();
                      $i++;            
                }
                $imp.= "<input type='hidden' name='contador' id='contador' value='".$i."'";
            }
            echo $imp;
        }break;
        case 'SaveData':
        {
		//echo '<pre>'; print_r($_POST); die;
             if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
            {
                $user = $_POST['user'];
                $FechaCreacion = date("Y-m-d H:i:s");                
                $contador = $_POST['contador'];
                $contador_carrera = $_POST['contador_carrera'];
                $numeroAcuerdo=$_POST['numeroAcuerdo'];
                
                $contador_carrera = filter_var($contador_carrera,FILTER_SANITIZE_NUMBER_INT);
                $contador = filter_var($contador,FILTER_SANITIZE_NUMBER_INT);
                $numeroAcuerdo = filter_var($numeroAcuerdo,FILTER_SANITIZE_NUMBER_INT);
                
                $institucion = array();
                $cupos = array();
                
                for($i = 1; $contador >= $i; $i++)
                {
                    $institucion[$i] = $_POST['instituciones_0'.$i];
                    $cupos[$i] = $_POST['cupos_0'.$i];        
                }
                
                $DataCarrera = $_POST['carrera'];
                
               //echo '<pre>';print_r($carrea_C);die;
                
                /*for($l = 1; $contador_carrera >= $l; $l++)
                {
                     $programa[$l] = $_POST['carrera'];        
                }*/
                
                
                //obtenemos el archivo a subir
                $file = $_FILES['archivo']['name'];
                $tmp_archivo = $_FILES['archivo']['tmp_name'];
                $nombrecarpeta = "files/".$file;                 
                //comprobamos si existe un directorio para subir el archivo
                //si no es así, lo creamos
                if(!is_dir("files/")) 
                    mkdir("files/", 0777);
                 
                if(!file_exists($nombrecarpeta))
                {
                    $subir = move_uploaded_file($tmp_archivo,$nombrecarpeta); 
                }else
                {
                    $subir = true;
                }
                //comprobamos si el archivo ha subido
                
                if($subir== true) 
                {
                   //echo 'subio';
				   $a = 0;
                   for($i = 1; $contador >= $i; $i++)
                   {
                       
                           $sqlacuerdo= "select AcuerdoConvenioId from AcuerdoConvenios where codigocarrera = '".$DataCarrera."' and RutaArchivo = '".$file."' and InstitucionConvenioId = '".$institucion[$i]."' and CodigoEstado= '100' and cupos= '".$cupos[$i]."'";
                           $buscar=&$db->Execute($sqlacuerdo);
                           //echo $sqlacuerdo.'<br>';
                           if(!$buscar->EOF)
                            {
                                //echo 'si existe..';
                                //echo $buscar->fields['AcuerdoConvenioId'];                                         
                            }else
                            {
                                $sqlagregaracuerdo= "INSERT INTO AcuerdoConvenios(codigocarrera, numeroAcuerdo , RutaArchivo, InstitucionConvenioId, Cupos, CodigoEstado, UsuarioCreacion, FechaCreacion)
                                VALUES ('".$DataCarrera."', '".$numeroAcuerdo."' , '".$file."', '".$institucion[$i]."', '".$cupos[$i]."', '100', '".$user."', '".$FechaCreacion."' );";
                                //echo $sqlagregaracuerdo.'<br>';                            
                                $agregar = $db->execute($sqlagregaracuerdo);   
                            }
                    $a++;
                   } 
                }else
                {
                    //echo 'no subio';   
                }
            }
            else{
            throw new Exception("Error Processing Request", 1);
            }
            return $sqlacuerdo;
        }break;
        case 'GuardaCambios':
        {
            $cupos = $_POST['cupos'];
            $estado = $_POST['estado'];
            $acuerdoid = $_POST['AcuerdoId'];
            $fechamodificacion = date("Y-m-d H:i:s");
            $user = $_POST['user'];
            
            $cupos = filter_var($cupos,FILTER_SANITIZE_NUMBER_INT);
            $estado = filter_var($estado,FILTER_SANITIZE_NUMBER_INT);
            $acuerdoid = filter_var($acuerdoid,FILTER_SANITIZE_NUMBER_INT);
            
            $sqlactualizar = "UPDATE AcuerdoConvenios SET Cupos='".$cupos."', CodigoEstado='".$estado."', FechaModificacion='".$fechamodificacion."', UsuarioModificacion='".$user."' WHERE (AcuerdoConvenioId='".$acuerdoid."')";
            //echo $sqlactualizar; 
            $actualizar = $db->execute($sqlactualizar);            
        }break;
}  
?>