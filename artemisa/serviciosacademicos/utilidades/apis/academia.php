<?PHP 
require_once('funcionesAcademica.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    switch ($_POST["action"]){
        case 'notas_historico':{
                include_once 'funcionesValidacion.php';
                if(validarToken($_POST["idusuario"],$_POST["token"])){ 
					include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
					$json = HistoricoNotas($_POST["idusuario"],$_POST['carrera'],null); 
				} else {
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =2;
					$json["mensaje"]         ="El token no es válido.";
				}
        }break;
        case 'notas_semestre':{
                include_once 'funcionesValidacion.php';
                if(validarToken($_POST["idusuario"],$_POST["token"])){ 
					include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
					$json = NotasSemestre($_POST["idusuario"],$_POST['carrera'],$db); 
				} else {
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =2;
					$json["mensaje"]         ="El token no es válido.";
				}
        }break;
        case 'obtener_materias':{ 
                include_once 'funcionesValidacion.php';
                if(validarToken($_POST["idusuario"],$_POST["token"])){ 
					$usuario = $_POST['idusuario'];
                    $rol     = $_POST['idrol'];
                    include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                    include_once(realpath(dirname(__FILE__)).'/obtener_materias_class.php');
                    
                    $C_obtener_materias = new obtener_materias($db,$usuario,$rol);

                    $json = $C_obtener_materias->buscarmaterias();
				} else {
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =2;
					$json["mensaje"]         ="El token no es válido.";
				}
        }break;    
        case 'obtener_syllabus':{
                include_once 'funcionesValidacion.php';
               if(validarToken($_POST["idusuario"],$_POST["token"])){ 
					
                    include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                    include_once(realpath(dirname(__FILE__))."/../../modelos/Periodo.php"); /*Ruta a /calse o modelo */
                    include_once'Syllabus_contenido_class.php';   
                    
                    $periodo = new periodo();
            
                    $periodoArray = $periodo->Find("fechainicioperiodo<=CURDATE() AND   fechavencimientoperiodo >=CURDATE()");//codigoperiodo IS NOT NULL  ó 1=1
                    
                    $periodoActivo = $periodoArray[0]->codigoperiodo; 
                    $materia       = $_POST['codigomateria'];
            
                    $C_SyllabusContenido  = new Syllabus_contenido($db,$materia,$periodoActivo);
                    
                    $Syllabus = $C_SyllabusContenido->Syllabus();
                    
                    if($Syllabus===false){
                        $json["result"]          ="ERROR";    
                        $json["codigoresultado"] =1;
                        $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                    }else{
                        $json["result"]          ="OK";
                        $json["codigoresultado"] =0;
                        $json["mensaje"]         ="Syllabus de la materia ".$Syllabus['nombremateria'];
                        if($Syllabus['urlasyllabuscontenidoprogramatico']){
                        	/*
							 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
							 * Se ajusta la url del pdf ya que se estaba enviando una incorrecta
							 * @since  January 24, 2017
							*/
                        	//$url= "https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/".$Syllabus['urlasyllabuscontenidoprogramatico'];
							$url= "https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/".str_replace('../', '', $Syllabus['urlasyllabuscontenidoprogramatico']);
							/* Fin Modificacion */
                        }else{
                             $url = ' ';
                        }
                        
                        $json["url"]             = $url;
                       
                    }
                   
            
				} else {
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =2;
					$json["mensaje"]         ="El token no es válido.";
				}
        }break;    
    }
}    
echo json_encode($json);

?>