<?php  
require_once('./funcionesValidacion.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){     
    $token       = $_POST["token"];
    $usuario     = $_POST["idusuario"];
        
    $id=$_POST["id"];
    $url= $_POST["url"];
    $tipo= $_POST["tipo"];
//    $fechaLimite= $_POST["fechaLimite"];
//    $cupo= $_POST["cupo"];
    $codigoEstado= $_POST["codigoEstado"];
    switch ($_POST["action"]){
        case 'Listar':{
//            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once('StreamingActividadesBienestar_Class.php');
                
                $Lista = new StreamingActividadesBienestar($db,$usuario);
                $json['streaming'] = $Lista->ListarStreamingActividadesBienestar();
                $json["result"] = "OK";
                $json["codigoresultado"] = 0;
//            }else{
//                $json["result"]          ="ERROR";
//                $json["codigoresultado"] =1;
//                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
//                echo json_encode($json);
//                exit;
//            }
        }break;
        case 'Consultar':{
//            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once('StreamingActividadesBienestar_Class.php');
                
                $Traiga = new StreamingActividadesBienestar($db,$usuario);
                $json['streaming'] = $Traiga->TraigaStreamingActividadesBienestar($id);
                $json["result"] = "OK";
                $json["codigoresultado"] = 0;
//            }else{
//                $json["result"]          ="ERROR";
//                $json["codigoresultado"] =1;
//                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
//                echo json_encode($json);
//                exit;
//            }
        }break;
        case 'Insercion':{
//            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once('StreamingActividadesBienestar_Class.php');
                
                $Inserta = new StreamingActividadesBienestar($db,$usuario);
                
                $json['Eventos'] = $Inserta->InsertarStreamingActividadesBienestar($url,$tipo,$usuario,$codigoEstado);
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
//            }else{
//                $json["result"]          ="ERROR";
//                $json["codigoresultado"] =1;
//                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
//                echo json_encode($json);
//                exit;
//            }
        }break;    
        case 'Actualizacion':{
//            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once('StreamingActividadesBienestar_Class.php');
                
                $Actualiza = new StreamingActividadesBienestar($db,$usuario);
                
                $json['Eventos'] = $Actualiza->ActualizarStreamingActividadesBienestar($url,$tipo,$usuario,$codigoEstado,$id);
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
//            }else{
//                $json["result"]          ="ERROR";
//                $json["codigoresultado"] =1;
//                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
//                echo json_encode($json);
//                exit;
//            }
        }break;    
    }//switch
}//if
    echo json_encode($json);
?>

