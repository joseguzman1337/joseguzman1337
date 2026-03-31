<?php
session_start();

if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi�n en el sistema</strong></blink>';
	exit();
}
include('../templates/templateObservatorio.php');
$db = writeHeaderBD();


$SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    
    if($Usario_id=&$db->Execute($SQL_User)===false){
    		echo 'Error en el SQL Userid...<br>'.$SQL_User;
    		die;
    	}
    
     $userid=$Usario_id->fields['id'];
		//las materias de la prueba nueva
        //echo '<pre>';print_r($_POST);
        
        $codigoPeriodo = $_POST["codigoperiodo"]; 
		$modalidad = $_POST["codigomodalidadacademica"];
        $Carreras = $_POST["Carrera_1"];
        
		$SQL='select idasignaturaestado,nombreasignaturaestado from asignaturaestado WHERE TipoPrueba=2 AND codigoestado=100 AND CuentaCompetenciaBasica=1 
		ORDER BY nombreasignaturaestado ASC';
        $MateriasExamenNuevo = $db->GetAll($SQL);
		
		$carrera = "";
		
		/*if(isset($_POST["carrera"])&&$_POST["carrera"]<>""){
			$carrera = ' AND e.codigocarrera="'.$_POST["carrera"].'"';
		}*/
        
        for($i=0;$i<count($Carreras);$i++){
            if($i<1){
                $List = '"'.$Carreras[$i].'"';
            }else{
                $List = $List.',"'.$Carreras[$i].'"';
            }
        }//for
        
        $carrera = ' AND e.codigocarrera IN ('.$List.')';
        
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
							drp.idasignaturaestado AS asignaturas,e.codigoestudiante,
                            CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) AS NameEstudiante,
                            c.nombrecarrera
							
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
			
                if($quintilActual==1){
                    
    				$estudiantes[$resultadoEstudiante["codigoestudiante"]][$key]["valor"] = $resultadoEstudiante["resultado"];//
    				$estudiantes[$resultadoEstudiante["codigoestudiante"]][$key]["quintil"] = $quintilActual;
                    $estudiantes[$resultadoEstudiante["codigoestudiante"]]["CodigoEstudiante"] = $resultadoEstudiante["codigoestudiante"];                   
                    $estudiantes[$resultadoEstudiante["codigoestudiante"]]["Curso"][] = $key;
                    $estudiantes[$resultadoEstudiante["codigoestudiante"]]["Estudiante"] = $resultadoEstudiante["NameEstudiante"];
                    $estudiantes[$resultadoEstudiante["codigoestudiante"]]["Documento"] = $resultadoEstudiante["numerodocumento"];
                    $estudiantes[$resultadoEstudiante["codigoestudiante"]]["nombrecarrera"] = $resultadoEstudiante["nombrecarrera"];
                    $estudiantes['Codigo'][$key][] = $resultadoEstudiante["codigoestudiante"];
                    
				}
				if($posicion==$posicionFinal){
					$quintil++;
				}	
			}			
		 } 
         
     // echo '<pre>';print_r($estudiantes);die;
     
     $DataEstudiante = $estudiantes['Codigo'];
     
     ?>
     <link rel="stylesheet" type="text/css" href="../../js/datatables/media/css/jquery.dataTables.css" media="screen" />
		<style>
		.dataTables_paginate{
			display:block;min-width:450px;
		}
		</style>
        <script type="text/javascript" language="javascript" src="../../js/datatables/media/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/datatables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/datatables/extensions/TableTools/js/dataTables.tableTools.js"></script>
		<script type="text/javascript" language="javascript" class="init">
		$(document).ready(function() {
			$('#example').dataTable( {
				"dom": 'T<"clear">lfrtip',
				"language": {
						"url": "../../js/datatables/Spanish.json"
					},
                    "aLengthMenu": [[50], [50,  "All"]],
                     "iDisplayLength": 50,
                   
					"tableTools": {
						"aButtons": [
							"copy",						
							{
								"sExtends": "csv",
								"sFileName": "Competencias.csv"
							},	
							{
								"sExtends": "xls",
								"sFileName": "Competencias.xls",
                                "bFooter": false
							},	
							{
								"sExtends": "pdf",
								"sFileName": "Competencias.pdf"
							},		
							{
								"sExtends": "print",
								"sButtonText": "Imprimir"
							}
						],
						"sSwfPath": "../../js/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
						"sPrintMessage": ""
					}				
				
			} );
            
		} );
	</script>
    <div style="margin-top:20px;">
		<table id="example" class="display" cellspacing="0" width="100%" >
        <thead>
            <tr>
                <th>Pragrama Académico</th>
                <th>Estudiante</th>
                <th>N&deg; Documento</th>
                <th>N&deg; Salas a las que debe asistir</th>
                <th>Salas a las que debe asistir</th>
            </tr>
        </thead>
        <tbody>
        <?PHP 
        foreach($estudiantes AS $val){ //echo '<pre>';print_r($val['Curso']);die;
            if($val['nombrecarrera']){
            ?>
            <tr>
                <td><?PHP echo $val['nombrecarrera'];?></td>
                <td><?PHP echo $val['Estudiante'];?></td>
                <td><?PHP echo $val['Documento'];?></td>
                <td style="text-align: center;"><?PHP echo count($val['Curso']);?></td>
                <td><?PHP dataSalaAsitirName($db,$val['Curso']);?></td>
            </tr>
            <?PHP
            }
         }//foreach 
        ?>
        </tbody>
     </table>
    </div> 
    <br />
    <br />
    <hr />
    <?PHP 
    
     for($x=0;$x<count($MateriasExamenNuevo);$x++){
        for($l=0;$l<count($DataEstudiante[$MateriasExamenNuevo[$x]['idasignaturaestado']]);$l++){
                $Data[$MateriasExamenNuevo[$x]['idasignaturaestado']][] = DataAdiconalEstudiante($db,$DataEstudiante[$MateriasExamenNuevo[$x]['idasignaturaestado']][$l]);  
                $CodigoEstudiante = $DataEstudiante[$MateriasExamenNuevo[$x]['idasignaturaestado']][$l];              
        }//for
        ?>
        <link rel="stylesheet" type="text/css" href="../../js/datatables/media/css/jquery.dataTables.css" media="screen" />
		<style>
		.dataTables_paginate{
			display:block;min-width:450px;
		}
		</style>
        <script type="text/javascript" language="javascript" src="../../js/datatables/media/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/datatables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/datatables/extensions/TableTools/js/dataTables.tableTools.js"></script>
		<script type="text/javascript" language="javascript" class="init">
		$(document).ready(function() {
			$('#example_<?PHP echo $MateriasExamenNuevo[$x]['idasignaturaestado']?>').dataTable( {
				"dom": 'T<"clear">lfrtip',
				"language": {
						"url": "../../js/datatables/Spanish.json"
					},
                    "aLengthMenu": [[50], [50,  "All"]],
                     "iDisplayLength": 50,
					"tableTools": {
						"aButtons": [
							"copy",						
							{
								"sExtends": "csv",
								"sFileName": "Competencias.csv"
							},	
							{
								"sExtends": "xls",
								"sFileName": "Competencias.xls",
                                "bFooter": false
							},	
							{
								"sExtends": "pdf",
								"sFileName": "Competencias.pdf"
							},		
							{
								"sExtends": "print",
								"sButtonText": "Imprimir"
							}
						],
						"sSwfPath": "../../js/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
						"sPrintMessage": ""
					}				
				
			} );
            
		} );
	</script>
    <br />
    <br />
    <div style="margin-top:20px;">
		<table id="example_<?PHP echo $MateriasExamenNuevo[$x]['idasignaturaestado']?>" class="display" cellspacing="0" width="100%" >
        <thead>
            <tr>
                <th colspan="5"><?PHP echo $MateriasExamenNuevo[$x]['nombreasignaturaestado']?></th>
            </tr>
            <tr>
                <th>Pragrama Académico</th>
                <th>Estudiante</th>
                <th>N&deg; Documento</th>                
            </tr>
        </thead>
        <tbody>
           <?PHP 
          for($t=0;$t<count($Data[$MateriasExamenNuevo[$x]['idasignaturaestado']]);$t++){
            //echo '<br>->'.$Data[$MateriasExamenNuevo[$x]['idasignaturaestado']][$t][0]['codigoestudiante'];
            BuscarSala($db,$MateriasExamenNuevo[$x]['idasignaturaestado'],$Data[$MateriasExamenNuevo[$x]['idasignaturaestado']][$t][0]['codigoestudiante'],$userid);
            ?>
            <tr>
                <td><?PHP echo $Data[$MateriasExamenNuevo[$x]['idasignaturaestado']][$t][0]['nombrecarrera']?></td>
                <td><?PHP echo $Data[$MateriasExamenNuevo[$x]['idasignaturaestado']][$t][0]['FulName']?></td>
                <td><?PHP echo $Data[$MateriasExamenNuevo[$x]['idasignaturaestado']][$t][0]['numerodocumento']?></td>
            </tr>
            <?PHP
          }//for
           ?> 
        </tbody>
     </table>
    </div>
    <br /><br /><hr /> 
        <?PHP
     }//for
     
 function DataAdiconalEstudiante($db,$Estudiante){
   $SQL='SELECT 
         CONCAT(eg.nombresestudiantegeneral," ",eg.apellidosestudiantegeneral) AS FulName,
         eg.numerodocumento,
         c.nombrecarrera,
         e.codigoestudiante
         FROM
        
         estudiante e INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
         INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
        
         WHERE
        
         e.codigoestudiante="'.$Estudiante.'"'; 
            
      if($Datos=&$db->GetAll($SQL)===false){
         echo 'Error al Buscar Estudiantes....<br><br>'.$SQL;
         die;
      }      
      
      return $Datos;
 }//function DataAdiconalEstudiante  
 function dataSalaAsitirName($db,$datos){
    //echo '<pre>';print_r($datos);
    for($i=0;$i<count($datos);$i++){
            if($i<1){
                $List = '"'.$datos[$i].'"';
            }else{
                $List = $List.',"'.$datos[$i].'"';
            }
    }//for
    
   // echo 'Lis->'.$List;
    
    $SQL='select idasignaturaestado,nombreasignaturaestado from asignaturaestado WHERE TipoPrueba=2 AND codigoestado=100 AND CuentaCompetenciaBasica=1  AND  idasignaturaestado IN('.$List.')
		ORDER BY nombreasignaturaestado ASC';
        
    if($name=&$db->GetAll($SQL)===false){
        echo 'Error al Buscar NAme...<br><br>'.$SQL;
        die;
    }    
    
    ?>
    <table>
        <?PHP 
        for($j=0;$j<count($name);$j++){
            ?>   
            <tr>
                <td><?PHP echo $name[$j]['nombreasignaturaestado']?></td>
            </tr>
            <?PHP
        }
        ?>
    </table>
    <?PHP
 }// function dataSalaAsitirName
 function BuscarSala($db,$Competencia,$Estudiante,$userid){
     $SQL='SELECT
                SalaAprendizajeId
           FROM
                SalaAprendizaje
                
           WHERE
                CodigoEstado=100
                AND
                IdAsignaturaEstado="'.$Competencia.'"';
                
         if($SalaAjudjuntar=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Buscar Sala disponible...<br><br>'.$SQL;
            die;
         }  
         
         if($SalaAjudjuntar->EOF){
            $nameSala = SalaName($db,$Competencia);
            ?>
            <br />
            <samp style="color: blue;">No se encontro sala para <?PHP echo $nameSala?>...</samp>
            <?PHP
         }else{
              $SQL='SELECT
                    *
                    FROM
                    SalaAprendizajeEstudiante 
                    
                    WHERE
                    
                    SalaAprendizajeId="'.$SalaAjudjuntar->fields['SalaAprendizajeId'].'"
                    AND
                    CodigoEstudiante="'.$Estudiante.'"
                    AND
                    CodigoEstado=100';
                    
                    if($Validacion=&$db->Execute($SQL)===false){
                        echo 'Error al Validar la Existencia del Estudiante en la Sala de Aprendizaje...<br><br>'.$SQL;
                        die;
                    }
                    
                    if($Validacion->EOF){
                        $Insert='INSERT INTO SalaAprendizajeEstudiante(SalaAprendizajeId,CodigoEstudiante,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion) VALUES("'.$SalaAjudjuntar->fields['SalaAprendizajeId'].'","'.$Estudiante.'","'.$userid.'","'.$userid.'",NOW(),NOW());';
                        
                        if($SalaEstudiante=&$db->Execute($Insert)===false){
                            echo 'Error en el SQL del Insert a la SAla de Aprendizaje Estudiante...<br><br>'.$Insert;
                            die;
                        }
                    }    
         }     
 }//function BuscarSala
 function SalaName($db,$id){
          $SQL='SELECT
                	nombreasignaturaestado
                FROM
                	asignaturaestado
                WHERE
                	idasignaturaestado ="'.$id.'"';
                    
          if($NameSala=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Name Sala Aprendizaje Disponible...<br><br>'.$SQL;
            die;
          }          
          
          return $NameSala->fields['nombreasignaturaestado'];
 }//function SalaName
?>