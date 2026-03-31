<?php
require_once('./funcionesValidacion.php'); 
if($_SERVER["REQUEST_METHOD"] == "POST"){     
    $token       = $_POST["token"];
    $usuario     = $_POST["idusuario"];
    
    $id=$_POST["id"];
//    $nombre= $_POST["nombre"];
//    $descripcion= $_POST["descripcion"];
//    $fechaLimite= $_POST["fechaLimite"];
//    $cupo= $_POST["cupo"];
//    $codigoEstado= $_POST["codigoEstado"];
    switch ($_POST["action"]){
        case 'Listar':{
//            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once('ActividadesBienestar_Class.php');
                
                $Lista = new ActividadesBienestar($db,$usuario);
                $json['actividades'] = $Lista->ListarActividadesBienestar();
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
                include_once('ActividadesBienestar_Class.php');
                
                $Traiga = new ActividadesBienestar($db,$usuario);
                $json['actividades'] = $Traiga->TraigaActividadesBienestar($id);
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
       /* case 'Insercion':{
            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once('ActividadesBienestar_Class.php');
                
                $Inserta = new ActividadesBienestar($db,$usuario,1);
                
                $json['Eventos'] = $Inserta->InsertarActividadesBienestar($nombre,$descripción,$fechaLimite,$cupo,$usuario,$codigoEstado);
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
        case 'Actualizacion':{
            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once('ActividadesBienestar_Class.php');
                
                $Actualiza = new ActividadesBienestar($db,$usuario,1);
                
                $json['Eventos'] = $Actualiza->ActualizarActividadesBienestar($nombre,$descripción,$fechaLimite,$cupo,$usuario,$codigoEstado,$id);
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
            }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
            }
        }break;    */
    }//switch
}//if
    echo json_encode($json);
?>

