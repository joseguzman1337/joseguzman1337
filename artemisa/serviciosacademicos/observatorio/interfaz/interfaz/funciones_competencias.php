<?php 
include('../templates/templateObservatorio.php');
$db = writeHeaderBD();
		//las materias de la prueba nueva
		$SQL='select idasignaturaestado,nombreasignaturaestado from asignaturaestado WHERE TipoPrueba=2 AND codigoestado=100 AND CuentaCompetenciaBasica=1 
		ORDER BY nombreasignaturaestado ASC';
		//echo '<pre>';print_r($SQL);
        $MateriasExamenNuevo = $db->GetAll($SQL);
		$codigoPeriodo = $_POST["periodo"]; 
		$modalidad = $_POST["modalidad"];
		$carrera = "";
		
		if(isset($_POST["carrera"])&&$_POST["carrera"]<>""){
			$carrera = str_replace("\\", "", $_POST["carrera"]);
			$carrera = ' AND e.codigocarrera in ('.$_POST["carrera"].')';
		}
		$SQL='SELECT 
                        eg.numerodocumento,
                        CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) as nombreEstudiante, 
                        ee.codigoperiodo,c.nombrecarrera,e.codigoestudiante
                        
                        FROM estudianteestadistica ee INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante '.$carrera.'
                                                      INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera and c.codigomodalidadacademica="'.$modalidad.'"
                                                      INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral                      
                        WHERE ee.codigoperiodo="'.$codigoPeriodo.'"
                              AND 
                              ee.codigoprocesovidaestudiante= 400
                              AND 
                              ee.codigoestado like "1%" 
							  GROUP BY eg.numerodocumento 
                        ORDER BY 3,2';
         
		 // echo '<pre>';print_r($SQL);
		               
         if($DataExamenEstado=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Los Reultados Prueba Estado....<br>'.$SQL;
            die;
         }    
         
         $D_ExamenEstado = $DataExamenEstado->GetAll();
		 /*$filtrados = array_chunk($D_ExamenEstado,$_POST["length"],false);
		 echo json_encode( array("recordsTotal"    => count( $D_ExamenEstado ),"data"=>$filtrados[$_POST['draw']],
					"draw" =>  intval($_POST['draw']), "recordsFiltered"  => count( $D_ExamenEstado ) )); die;*/
		 
		 $arreglosMaterias = array();
		 foreach($MateriasExamenNuevo as $materia){
			 $SQL='SELECT 
							eg.numerodocumento,
							ee.codigoperiodo,
							drp.notadetalleresultadopruebaestado as resultado, 
							drp.idasignaturaestado AS asignaturas,e.codigoestudiante
							
							FROM estudianteestadistica ee INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante '.$carrera.'
                                                          INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera and c.codigomodalidadacademica="'.$modalidad.'"
														  INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral
														  INNER JOIN resultadopruebaestado rp on rp.idestudiantegeneral=e.idestudiantegeneral
														  INNER JOIN detalleresultadopruebaestado drp on drp.idresultadopruebaestado=rp.idresultadopruebaestado 
														  INNER JOIN asignaturaestado ae on ae.idasignaturaestado=drp.idasignaturaestado AND ae.CuentaCompetenciaBasica=1  
															AND	ae.idasignaturaestado="'.$materia["idasignaturaestado"].'"												  
							WHERE ee.codigoperiodo="'.$codigoPeriodo.'"
								  AND 
								  ee.codigoprocesovidaestudiante= 400
								  AND 
								  ee.codigoestado like "1%" 
							ORDER BY CAST(drp.notadetalleresultadopruebaestado AS DECIMAL(5,2)) ASC';
			
				//echo '<pre>';print_r($SQL);
				
				$arreglosMaterias[$materia["idasignaturaestado"]] = $db->GetAll($SQL);		 
		 }
		 
		 $estudiantes = array();
		 foreach($arreglosMaterias as $key=>$resultadosMateria){
			 $quintil = 1;
			 $quintilActual = null;
			 $posicion = 0;
			foreach($resultadosMateria as $resultadoEstudiante){
				$posicion++;
				if($quintilActual!=$quintil){
					$quintilActual = $quintil;
					$posicionFinal = round($quintil*count($arreglosMaterias[$key])/5);
				}
				
				$estudiantes[$resultadoEstudiante["codigoestudiante"]][$key]["valor"] = $resultadoEstudiante["resultado"];
				$estudiantes[$resultadoEstudiante["codigoestudiante"]][$key]["quintil"] = $quintilActual;
				
				if($posicion==$posicionFinal){
					$quintil++;
				}	
			}			
		 } 
         

		 
?>