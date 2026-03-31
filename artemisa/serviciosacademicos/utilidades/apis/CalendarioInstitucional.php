<?PHP 
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
require_once('./funcionesValidacion.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){     
    $token       = $_POST["token"];
    $usuario     = $_POST["idusuario"];
    
    switch ($_POST["action"]){
        case 'filtro':{
            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once(realpath(dirname(__FILE__)).'/../../CalendarioInstitucional/Class/CalenadrioInstitucional_class.php');
                
                $C_CalendarioInstitucional = new CalendarioInstitucional($db,$usuario,1);
                
                $json['programas'] = $C_CalendarioInstitucional->filtroApp();
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
            }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
            }
        }break;
        case 'ViewCalendario':{
			if(validarToken($usuario,$token)){
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once(realpath(dirname(__FILE__)).'/../../CalendarioInstitucional/Class/CalenadrioInstitucional_class.php');
                
                $C_CalendarioInstitucional = new CalendarioInstitucional($db,$usuario,1);
                if(isset($_POST['codigocarrera'])){
					$C_CalendarioInstitucional->codigocarrera = $_POST['codigocarrera'];
				}
                $json['Eventos'] = $C_CalendarioInstitucional->ConsumoAppCalendario();
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
            }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
            }
        }break;    
    }//switch
}//if
    echo json_encode($json);
?>