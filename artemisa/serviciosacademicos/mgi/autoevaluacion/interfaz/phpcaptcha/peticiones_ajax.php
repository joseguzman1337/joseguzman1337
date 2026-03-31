<?php

session_start();
/*include_once('../../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/

 include_once ('../../../../EspacioFisico/templates/template.php');
 $db = getBD();

switch($_REQUEST['actionID']){    
    case 'carga_facultad':{
        $modalidad = $_REQUEST['modalidad'];
        if($modalidad == 200){
			$SQL = 'SELECT
						DISTINCT fac.codigofacultad,
						fac.nombrefacultad
					FROM
						facultad fac        
					WHERE
						fac.codigoestado = 100
					ORDER BY fac.nombrefacultad';
		}else{
			$SQL = 'SELECT
						DISTINCT car.codigocarrera,
						car.nombrecarrera
					FROM
						carrera car                
					WHERE
						(fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1)
					AND car.codigomodalidadacademica = '.$modalidad.' 
					ORDER BY car.nombrecarrera';
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
				$imp = '<option value="0" selected="selected">Seleccione</option>';
				if(!$Resultado->EOF){
					while(!$Resultado->EOF){
						$imp .= '<option value="'.$Resultado->fields['codigocarrera'].'">'.$Resultado->fields['nombrecarrera'].'</option>';
						$Resultado->MoveNext();
					}
				}
			}
		}
		$a_vectt['option'] = $imp;
		$a_vectt['val'] = 'TRUE';
		$a_vectt['modalidad'] = $modalidad;
		echo json_encode($a_vectt); 
    }break;
	case 'cargar_programa_academico':{
            $Facultad_id = $_REQUEST['facultad_id'];
            $Periodo_id = $_REQUEST['periodo_id'];
			$modalidad = $_REQUEST['modalidad'];
            $SQL = 'SELECT
                	DISTINCT car.codigocarrera,
                	car.nombrecarrera
                FROM
                	carrera car                
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
            $imp = '<option value="0" selected="selected">Seleccione</option>';
            if(!$Resultado->EOF){
                while(!$Resultado->EOF){
                    $imp .= '<option value="'.$Resultado->fields['codigocarrera'].'">'.$Resultado->fields['nombrecarrera'].'</option>';
                    $Resultado->MoveNext();
                }
            }
            echo $imp;
        }break;
}

?>