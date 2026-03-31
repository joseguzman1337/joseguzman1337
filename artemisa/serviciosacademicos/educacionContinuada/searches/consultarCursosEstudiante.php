<?php
/****
 * Look for users base on name and last_name  
 ****/
include_once("../variables.php");
include($rutaTemplate."template.php");
$db = getBD();
    $utils = Utils::getInstance();

$q = strtolower($_REQUEST["documento"]);
//var_dump($_REQUEST);

if (!$q) die();
$estudiante = $utils->getDataEntity("estudiantegeneral", $q, "numerodocumento");    
       
	$sql = "SELECT g.idgrupo, c.nombrecarrera, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral 
                FROM relacionEstudianteGrupoInscripcion g 
		inner join estudiantegeneral eg ON eg.idestudiantegeneral=g.idEstudianteGeneral 
                AND eg.numerodocumento='".$q."'
                inner join documento d ON d.tipodocumento=eg.tipodocumento 
                inner join grupo gr ON gr.idgrupo=g.idGrupo 
                inner join materia m ON m.codigomateria=gr.codigomateria 
                inner join carrera c ON c.codigocarrera=m.codigocarrera AND c.codigomodalidadacademicasic=400 
                ORDER BY c.nombrecarrera";
		
            $sql2 = "SELECT g.idgrupo, c.nombrecarrera, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral 
                FROM detalleprematricula g 
                inner join prematricula p ON p.idprematricula=g.idprematricula 
                inner join estudiante e ON e.codigoestudiante = p.codigoestudiante 
		inner join estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
                AND eg.numerodocumento='".$q."'
                inner join documento d ON d.tipodocumento=eg.tipodocumento 
                inner join grupo gr ON gr.idgrupo=g.idGrupo 
                inner join materia m ON m.codigomateria=gr.codigomateria 
                inner join carrera c ON c.codigocarrera=m.codigocarrera AND c.codigomodalidadacademicasic=400  
                GROUP BY gr.idgrupo ORDER BY c.nombrecarrera";
				
			$rows = $db->GetAll($sql);
			
			$rows2 = $db->GetAll($sql2);
				
			$rows = array_merge($rows, $rows2);
$plantillasSelectSql="SELECT * FROM sala.plantillaGenericaEducacionContinuada where visible=1 and codigoestado=100;";
                                                $rowsPlantillas = $db->GetAll($plantillasSelectSql);
//var_dump($q);
	
if($rows!=NULL && count($rows)>0){
    $hayActividades = true;
    $html = '<label class="grid-2-12">Estudiante: </label><span style="position:relative;top:3px;left:15px;">'.$estudiante["apellidosestudiantegeneral"].' '.$estudiante["nombresestudiantegeneral"].'</span><br/><br/><div class="vacio"></div>';    
    
    $html .= '<label class="grid-2-12">Cursos: <span class="mandatory">(*)</span></label><select name="grupo" id="grupo" class="grid-4-12 required">';    
    $html .= '<option value="" selected></option>';
    foreach ($rows as $row){
         $html .= '<option value="'.$row["idgrupo"].'">'.$row["nombrecarrera"].'</option>';   
    }
    $html .= '</select>';
    
    $html .= '<label class="grid-2-12">Documento: <span class="mandatory">(*)</span></label><select name="plantilla" id="plantilla" class="grid-4-12 required">';    
    $html .= '<option value="" selected></option>';
    $html .= '<option value="1">Certificado del estudiante</option>';
    foreach ($rowsPlantillas as $rowx){
         $html .= '<option value="'.$rowx["idplantillaGenericaEducacionContinuada"].'">'.$rowx["nombre"].'</option>';   
    }
    $html .= '</select>';
    $button = '<input type="button" value="Generar PDF" class="first submitButton" id="submitButton"/>';
    $button = true;
} else {
    if(count($estudiante)>0){
        $html = '<p style="color:red;margin-left:30px">El estudiante no aparece registrado en ningún curso de educación continuada.</p>';
    } else {
        $html = '<p style="color:red;margin-left:30px">No se encontró ningún estudiante con el documento especificado.</p>';
    }
    $button = "";
    $button = false;
}

//var_dump($existe);
// return the array as json
echo json_encode(array("result"=>$hayActividades,"html"=>$html,"button"=>$button));
?>
