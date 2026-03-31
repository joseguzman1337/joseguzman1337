<?php

/*
 * Se encarga del procesamiento de datos
 */
include_once("../../variables.php");
include($rutaTemplateCalendar.'templateProcess.php');

$api = new API_Monitoreo();

if(isset($_POST["realAction"])&& (strcmp($_POST["realAction"],"revision")==0)){
        $data = $api->enviarIndicadorARevision($_POST["idIndicador"]);
        
        // JSON encode and send back to the server
        echo json_encode($data);
} else if(isset($_POST["realAction"])&& (strcmp($_POST["realAction"],"seguimiento")==0)){
    //guardar seguimiento
    $result = $utils->processData("save", $_POST["entity"]);
    
    //programar nuevo seguimiento si toca
    if($_POST["fecha_prox_seguimiento"]!=""){
        $apiA = new API_Alertas();
        
        $parametros = array();
        
        $nombre="";
        $indicador = $utils->getDataEntity("indicador", $_POST["idIndicador"]); 
        $indicadorG = $utils->getDataEntity("indicadorGenerico", $indicador["idIndicadorGenerico"]);
        $nombre = $indicadorG["nombre"];
        if($indicador["discriminacion"]==3){
            $carrera = $utils->getDataNonEntity($db,"nombrecarrera", "carrera","codigocarrera = '".$indicador["idCarrera"]."'"); 
            $nombre = $nombre ." ( ".$carrera["nombrecarrera"]." )";
        } else {
            $nombre = $nombre ." ( Institucional )";
        }
        
        $parametros["indicador"]=$nombre;  
        
        $user = $utils->getUser();
        $to = $user["nombres"]." ".$user["apellidos"]." <".$usu["usuario"]."@unbosque.edu.co>";
        //$responsables = $api->getIDUsuarioResponsableSeguimientoIndicador($_POST["idIndicador"],$db);
        
        //$apiA->enviarAlerta("Leyla Bonilla <bonillaleyla@unbosque.edu.co>", $subject, $mensaje);
        $apiA->programarAlertaEventoConPlantilla(1,$to,$parametros,$_POST["fecha_prox_seguimiento"]);
    }
    
   // Set up associative array
   $data = array('success'=> true,'message'=> $result);

   // JSON encode and send back to the server
   echo json_encode($data);
} else if(isset($_POST["realAction"])&& (strcmp($_POST["realAction"],"revisionCalidad")==0)){
    //var_dump($db);
    $api->initialize($db);
    
    //guardar srevision
    $result = $api->registrarRevisionCalidadIndicador($_POST["idIndicador"],$_POST["aprobado"],$_POST["comentarios"]);
    
    //se rechazo y toca enviar el correo a la persona encargada de actualizar el indicador
    if($_POST["aprobado"]==0 || $_POST["aprobado"]=="0"){
        $apiA = new API_Alertas();
        $data = $utils->getDataEntity("indicador", $_POST["idIndicador"]); 
        
        $nombre="";
        $indicador = $utils->getDataEntity("indicador", $_POST["idIndicador"]); 
        $indicadorG = $utils->getDataEntity("indicadorGenerico", $indicador["idIndicadorGenerico"]);
        $nombre = $indicadorG["nombre"];
        if($indicador["discriminacion"]==3){
            $carrera = $utils->getDataNonEntity($db,"nombrecarrera", "carrera","codigocarrera = '".$indicador["idCarrera"]."'"); 
            $nombre = $nombre ." ( ".$carrera["nombrecarrera"]." )";
        } else {
            $nombre = $nombre ." ( Institucional )";
        }
        
        $parametros["indicador"]=$nombre;
        $user = $utils->getUser();
        $parametros["comentarios"]=$_POST["comentarios"];
        $parametros["nombre_calidad"]=$user["nombres"]." ".$user["apellidos"];
        
        $responsables = $api->getIDUsuarioResponsableActualizarIndicador($_POST["idIndicador"],$db);
        $num = count($responsables);
        
        for ($i=0; $i<$num; $i++){
             $usu = $utils->getDataEntity("usuario", $responsables[$i],""); 
             $parametros["nombre_usuario"]=$usu["nombres"]." ".$usu["apellidos"];
             
             //asi me dijeron los de sistemas que es el correo pero no creo que aplique a todo usuario entonces toca ver
             $to = $parametros["nombre_usuario"]." <".$usu["usuario"]."@unbosque.edu.co>";
             //var_dump($to);
             //$to = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
             
             $apiA->enviarAlertaEventoConPlantilla(2,$to,$parametros);
        }
        
        //$apiA->enviarAlerta("Leyla Bonilla <bonillaleyla@unbosque.edu.co>", $subject, $mensaje);
        //$apiA->enviarAlertaEventoConPlantilla(2,$to,$parametros);
    }
    
   // Set up associative array
   $data = array('success'=> true,'message'=> $result);

   // JSON encode and send back to the server
   echo json_encode($data);
}
?>
