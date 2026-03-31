<?PHP    


if($_SERVER["REQUEST_METHOD"] == "POST"){
    switch ($_POST["action"]){
        case 'ordenes_estudiante':{ 
                include_once 'funcionesValidacion.php';
                if(validarToken($_POST["idusuario"],$_POST["token"])){
					$json = ordenespago($_POST["idusuario"],$_POST['carrera']); 
				} else {
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =2;
					$json["mensaje"]         ="El token no es válido.";
				}
        }break;
       
    }
}       

echo json_encode($json);
function ordenespago($usuario,$carrera){
        include(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
        
        $SQL_U='SELECT
            	numerodocumento,
            	codigorol,
            	codigotipousuario
            FROM
            	usuario
            WHERE
            	idusuario = "'.$usuario.'"';
    
        if($DataUser=&$db->GetAll($SQL_U)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
         $SQL='SELECT
                	e.codigoestudiante,
                	eg.idestudiantegeneral,
                    dt.nombrecortodocumento
                FROM
                	estudiantegeneral eg INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
                                         INNER JOIN documento dt ON dt.tipodocumento=eg.tipodocumento
                WHERE
                	eg.numerodocumento ="'.$DataUser[0]['numerodocumento'].'"
                AND e.codigocarrera ="'.$carrera.'"';
                
           if($EstudianteCarrera=&$db->GetAll($SQL)===false){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
           } 
               
        $codigoestudiante = $EstudianteCarrera[0]['codigoestudiante']; 
        
        $SQL='SELECT
                codigoperiodo, 
                codigoestadoperiodo
             FROM
                periodo
             WHERE
                codigoestadoperiodo IN(1,3)';
                
                
      if($PeriodoActivo=&$db->GetAll($SQL)===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA...3";
            echo json_encode($json);
            exit;
       } 
       
       for($i=0;$i<count($PeriodoActivo);$i++){
        if($PeriodoActivo[$i]['codigoestadoperiodo']==3){
            $codigoperiodo = $PeriodoActivo[$i]['codigoperiodo'];
        }else{
            $codigoperiodo = $PeriodoActivo[$i]['codigoperiodo'];
        }
       }//for periodo
       
      
        include_once(realpath(dirname(__FILE__)).'/../../funciones/funcionip.php');
        
        $ruta = "../../funciones/";
        
        $rutaorden = realpath(dirname(__FILE__))."/../../funciones/ordenpago/";
        
        include_once($rutaorden.'claseordenpago.php');
        
        mysql_select_db($database_sala, $db->_connectionID);     
        
        $ordenesxestudiante = new Ordenesestudiante($db->_connectionID, $codigoestudiante, $codigoperiodo);
        
        $rutaorden = "../../funciones/ordenpago/";
        
        $json = $ordenesxestudiante->mostar_ordenpago_api($rutaorden,'');
        
		if(empty($json)){
			/*
			 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
			 * Se agregó una escepcion para dar una respuesta cuando no se registren ordenes de pago, cuando esto ocurra se agrega al log de errores
			 * @since  January 24, 2017
			*/
			$text ='';
			require_once("ErrorLog.php");
			$log = new ErrorLog("logOrdenesPago", "/logs/");
			
			$text .= 'token: '.$_REQUEST['token'];
			$text .= ' - idusuario: '.$_REQUEST['idusuario'];
			$text .= ' - carrera: '.$_REQUEST['carrera'];
			$text .= ' - action: '.$_REQUEST['action'];
			
			$log->insert( $text );
		
			$Dato["result"] = "ERROR";
		    $Dato["codigoresultado"] = 1;
		    $Dato["mensaje"] = "Error No se registran ordenes de pago";
			/*Fin Modificacion*/
		}
		
      return $json;        
       
    }    
?>