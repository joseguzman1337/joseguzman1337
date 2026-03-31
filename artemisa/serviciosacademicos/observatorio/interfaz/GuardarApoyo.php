
<?php 


        include('../templates/templateObservatorio.php');
        $db = writeHeaderBD();




$idestudiantegeneral = $_REQUEST['idestudiantegeneral'];
$codigoestudiante = $_REQUEST['codigoestudiante'];
$idusuario = $_REQUEST['idusuario'];


$PeriodoAcademico = $_REQUEST['periodo'];
$hoy = date("Y-m-d H:i:s");
$TipoRemisionId = $_REQUEST['idRemision']; 

$IdCanalContacto = $_REQUEST['canalContacto'];
$FechaAtencion = $_REQUEST['fechaAtencion'];
$Lugar = $_REQUEST['Lugar'];
$ProfesionalQueHaceAtencion = $_REQUEST['profesionalAtencion'];
$Observacion = $_REQUEST['Observacion'];
$Observacion2 = $_REQUEST['Observacion2']; 
$ResumenGeneralAtencion = $_REQUEST['RemGeneral'];


$riesgoAcademico = $_REQUEST['riesgoAcademico'];
$nivelAcademico = $_REQUEST['nivelAcademico'];
$riesgoEconomico = $_REQUEST['riesgoEconomico'];
$nivelEconomico = $_REQUEST['nivelEconomico'];
$riesgoPsicosocial = $_REQUEST['riesgoPsicosocial'];
$nivelPsicosocial = $_REQUEST['nivelPsicosocial'];
$riesgoInstitucional = $_REQUEST['riesgoInstitucional'];
$nivelInstitucional = $_REQUEST['nivelInstitucional'];
$riesgoOtras = $_REQUEST['riesgoOtras'];
$nivelOtras = $_REQUEST['nivelOtras'];

$TipoApoyo = $_REQUEST['TipoApoyo'];

$tipoPeticion = $_REQUEST['tipoEnvio'];

$idCampoAct = $_REQUEST['idActualizar'];


// var_dump($tipoPeticion);http://172.16.1.43/serviciosacademicos/observatorio/interfaz/form_estudiante_tutor2.php?id=row_39&periodo=20151#close-modal
// exit();


/*echo "idestudiantegeneral: ".$idestudiantegeneral."<br>";
echo "codigoestudiante: ".$codigoestudiante."<br>";
echo "idusuario: ".$idusuario."<br>";

echo "PeriodoAcademico: ".$PeriodoAcademico."<br>";
echo "fecha: ".$hoy."<br>";
echo "TipoRemisionId: ".$TipoRemisionId."<br><br>";

echo "canalContacto: ".$IdCanalContacto."<br>";
echo "FechaAtencion: ".$FechaAtencion."<br>";
echo "Lugar: ".$Lugar."<br>";
echo "ProfesionalQueHaceAtencion: ".$ProfesionalQueHaceAtencion."<br>";
echo "Observacion: ".$Observacion."<br>";
echo "ResumenGeneralAtencion: ".$ResumenGeneralAtencion."<br><br>";

foreach ($riesgoAcademico as $indice => $valor){ 

	echo "riesgoAcademico: ".$valor."<br>";

 
}
echo "Nivel: ".$nivelAcademico."<br><br>";

foreach ($riesgoEconomico as $indice => $valor){ 

	echo "riesgoEconomico: ".$valor."<br>";

 
} 
echo "Nivel: ".$nivelEconomico."<br><br>";

foreach ($riesgoPsicosocial as $indice => $valor){ 

	echo "riesgoPsicosocial: ".$valor."<br>";

 
} 
echo "Nivel: ".$nivelPsicosocial."<br><br>";

foreach ($riesgoInstitucional as $indice => $valor){ 

	echo "riesgoInstitucional: ".$valor."<br>";

 
} 
echo "Nivel: ".$nivelInstitucional."<br><br>";

foreach ($riesgoOtras as $indice => $valor){ 

	echo "riesgoOtras: ".$valor."<br>";

 
} 
echo "Nivel: ".$nivelOtras."<br><br>";



foreach ($TipoApoyo as $indice => $valor){ 

	echo "TipoApoyo: ".$valor."<br>";

 
} */


$idobs_estudiante_tutor = null;

if($TipoRemisionId==26){

	echo "consulta a";

			if ( $tipoPeticion == 'delete' ) {

				$ApoyoEstudianteDel = 'DELETE FROM obs_estudiante_tutor WHERE idobs_estudiante_tutor = '.$idCampoAct;

				if ($delete = $db->Execute($ApoyoEstudianteDel) === false) {
				    echo 'Error en el SQL de DELETE';
				    exit;
			    }else{
					echo "Borrado exitoso";
			   	}

			   	eliminarRegistros($idCampoAct, $db);

			   	return true;

			}
			else
			if ($tipoPeticion == 'update' ) {
				$ApoyoEstudiante = 'UPDATE obs_estudiante_tutor SET codigoperiodo = "'.$PeriodoAcademico.'", 
				codigoestudiante = "'.$codigoestudiante.'", codigoestado = "100", IdTipoApoyo = "'.$TipoRemisionId.'", 
				IdCanalContacto = "'.$IdCanalContacto.'", FechaAtencion = "'.$FechaAtencion.'", Lugar = "'.$Lugar.'", 
				Observacion = "'.$Observacion.'", ProfesionalQueHaceAtencion = "'.$ProfesionalQueHaceAtencion.'" 
				WHERE idobs_estudiante_tutor = '.$idCampoAct;

				if ($insert = $db->Execute($ApoyoEstudiante) === false) {
			    	echo 'Error en el SQL de UPDATE';
			    	exit;
			    }else{
			    	echo "Actualización exitoso";			                	
			    }

			    $idobs_estudiante_tutor = $idCampoAct;

			    eliminarRegistros($idobs_estudiante_tutor, $db);
			}
			else { // comienzo insert 

				$ApoyoEstudiante = 'INSERT INTO obs_estudiante_tutor (codigoperiodo, codigoestudiante, codigoestado, fechacreacion, usuariocreacion, IdTipoApoyo, IdCanalContacto, FechaAtencion, Lugar, Observacion, ProfesionalQueHaceAtencion)
				VALUES ("'.$PeriodoAcademico.'","'.$codigoestudiante.'","100","'.date("Y-m-d H:i:s").'","'.$idusuario.'","'.$TipoRemisionId.'","'.$IdCanalContacto.'","'.$FechaAtencion.'","'.$Lugar.'","'.$Observacion.'","'.$ProfesionalQueHaceAtencion.'")'; 


			    if ($insert = $db->Execute($ApoyoEstudiante) === false) {
			        echo 'Error en el SQL de INSERT';
			        exit;
			    }else{
			        echo "registro exitoso";			                	
			    }


	            $query_Facultad ="SELECT MAX(idobs_estudiante_tutor) as idestudiante
	                              FROM obs_estudiante_tutor";

				if($Datos=&$db->Execute($query_Facultad)===false){
					echo 'Error en el SQl -...<br>'.$query_Facultad;
					die;
				}

	            echo $Datos->fields['idestudiante'];

	            $idobs_estudiante_tutor = $Datos->fields['idestudiante'];
	        }


	            if ($riesgoAcademico!=""){


					foreach ($riesgoAcademico as $indice => $valor){ 
			

					$SQLriesgoacademico = 'INSERT INTO obs_estudiante_tutor_tipo_riesgoPAE (idobs_estudiante_tutor, IdTipoRiesgo, ValoracionRiesgo)
					VALUES ("'.$idobs_estudiante_tutor.'","'.$valor.'","'.$nivelAcademico.'")'; 


				                if ($insert = $db->Execute($SQLriesgoacademico) === false) {
				                    echo 'Error en el SQL de INSERT';
				                    exit;
				                }else{


				                	echo "registro exitoso";
				                	
				                }

				 
					}

            	
	            }

	            if ($riesgoEconomico!=""){


					foreach ($riesgoEconomico as $indice => $valor){ 

				

					$SQLriesgoEconomico = 'INSERT INTO obs_estudiante_tutor_tipo_riesgoPAE (idobs_estudiante_tutor, IdTipoRiesgo, ValoracionRiesgo)
					VALUES ("'.$idobs_estudiante_tutor.'","'.$valor.'","'.$nivelEconomico.'")'; 


				                if ($insert = $db->Execute($SQLriesgoEconomico) === false) {
				                    echo 'Error en el SQL de INSERT';
				                    exit;
				                }else{


				                	echo "registro exitoso";
				                	
				                }

				 
					}

            	
            	}

	            if ($riesgoPsicosocial!=""){


					foreach ($riesgoPsicosocial as $indice => $valor){ 

				

					$SQLriesgoPsicosocial = 'INSERT INTO obs_estudiante_tutor_tipo_riesgoPAE (idobs_estudiante_tutor, IdTipoRiesgo, ValoracionRiesgo)
					VALUES ("'.$idobs_estudiante_tutor.'","'.$valor.'","'.$nivelPsicosocial.'")'; 


				                if ($insert = $db->Execute($SQLriesgoPsicosocial) === false) {
				                    echo 'Error en el SQL de INSERT';
				                    exit;
				                }else{


				                	echo "registro exitoso";
				                	
				                }

				 
					}

            	
            	}

	            if ($riesgoInstitucional!=""){


					foreach ($riesgoInstitucional as $indice => $valor){ 

				

					$SQLriesgoInstitucional = 'INSERT INTO obs_estudiante_tutor_tipo_riesgoPAE (idobs_estudiante_tutor, IdTipoRiesgo, ValoracionRiesgo)
					VALUES ("'.$idobs_estudiante_tutor.'","'.$valor.'","'.$nivelInstitucional.'")'; 


				                if ($insert = $db->Execute($SQLriesgoInstitucional) === false) {
				                    echo 'Error en el SQL de INSERT';
				                    exit;
				                }else{


				                	echo "registro exitoso";
				                	
				                }

				 
					}

            	
            	}


	            if ($riesgoOtras!=""){


					foreach ($riesgoOtras as $indice => $valor){ 

				

					$SQLriesgoOtras = 'INSERT INTO obs_estudiante_tutor_tipo_riesgoPAE (idobs_estudiante_tutor, IdTipoRiesgo, ValoracionRiesgo)
					VALUES ("'.$idobs_estudiante_tutor.'","'.$valor.'","'.$nivelOtras.'")'; 


				                if ($insert = $db->Execute($SQLriesgoOtras) === false) {
				                    echo 'Error en el SQL de INSERT';
				                    exit;
				                }else{

				                	echo "registro exitoso";
				           
				                }
				 
					}

            	
            	}


				foreach ($TipoApoyo as $indice => $valor){
			

				$SQLTipoApoyo = 'INSERT INTO obs_estudiante_tutor_otrosapoyosPAE (idobs_estudiante_tutor, IdOtroApoyo)
				VALUES ("'.$idobs_estudiante_tutor.'","'.$valor.'")'; 


				                if ($insert = $db->Execute($SQLTipoApoyo) === false) {
				                    echo 'Error en el SQL de INSERT';
				                    exit;
				                }else{


				                	echo "registro exitoso";
				               
				                }				 
				}


				return true;

			//} //fin insert


}else{

	echo "consulta b";

	if ( $tipoPeticion == 'delete' ) {

				$ApoyoEstudianteDel = 'DELETE FROM obs_estudiante_tutor WHERE idobs_estudiante_tutor = '.$idCampoAct;

				if ($delete = $db->Execute($ApoyoEstudianteDel) === false) {
				    echo 'Error en el SQL de DELETE';
				    exit;
			    }else{
					echo "Borrado exitoso";
			   	}
			   	// eliminarRegistros($idCampoAct, $db);

			   	return true;

	}
	else
	if ($tipoPeticion == 'update' ) {
		$ApoyoEstudiante = 'UPDATE obs_estudiante_tutor SET codigoperiodo = "'.$PeriodoAcademico.'", 
				codigoestudiante = "'.$codigoestudiante.'", codigoestado = "100", IdTipoApoyo = "'.$TipoRemisionId.'", 
				IdCanalContacto = "'.$IdCanalContacto.'", FechaAtencion = "'.$FechaAtencion.'", Lugar = "'.$Lugar.'", 
				Observacion = "'.$Observacion2.'", ProfesionalQueHaceAtencion = "'.$ProfesionalQueHaceAtencion.'",
				ResumenGeneralAtencion = "'.$ResumenGeneralAtencion.'"
				WHERE idobs_estudiante_tutor = '.$idCampoAct;

				if ($insert = $db->Execute($ApoyoEstudiante) === false) {
                    echo 'Error en el SQL de UPDATE';
                    exit;
                }else{

                	echo "Actualización exitoso";
			        return true;     	
                }

	}
	else {
		$ApoyoEstudiante = 'INSERT INTO obs_estudiante_tutor (codigoperiodo, codigoestudiante, codigoestado, fechacreacion, usuariocreacion, IdTipoApoyo, IdCanalContacto, FechaAtencion, Lugar, Observacion, ProfesionalQueHaceAtencion, ResumenGeneralAtencion)
		VALUES ("'.$PeriodoAcademico.'","'.$codigoestudiante.'","100","'.date("Y-m-d H:i:s").'","'.$idusuario.'","'.$TipoRemisionId.'","'.$IdCanalContacto.'","'.$FechaAtencion.'","'.$Lugar.'","'.$Observacion2.'","'.$ProfesionalQueHaceAtencion.'","'.$ResumenGeneralAtencion.'")'; 



                if ($insert = $db->Execute($ApoyoEstudiante) === false) {
                    echo 'Error en el SQL de INSERT';
                    exit;
                }else{


                	echo "registro exitoso";
                	return true;
                }
	}

	
}

function eliminarRegistros( $idRemover, $dbs ) 
{
	$SQLDelriesgoacademico = 'DELETE FROM obs_estudiante_tutor_tipo_riesgoPAE WHERE idobs_estudiante_tutor = "'.$idRemover.'"';

	if ($delete = $dbs->Execute($SQLDelriesgoacademico) === false) {
	    echo 'Error en el SQL de DELETE';
	    exit;
    }else{
		echo "Borrado exitoso";
   	}

	$SQLDelTipoApoyo = 'DELETE FROM obs_estudiante_tutor_otrosapoyosPAE WHERE idobs_estudiante_tutor = "'.$idRemover.'"';

	if ($delete = $dbs->Execute($SQLDelTipoApoyo) === false) {
	    echo 'Error en el SQL de DELETE';
	    exit;
    }else{
		echo "Borrado exitoso";
   	}
}


?>








