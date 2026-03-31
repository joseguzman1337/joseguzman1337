<?php

function eliminaLista($service, $emailList){

  $emailList=$emailList."@unbosque.edu.co";
  $results = $service->groups->delete($emailList);

}

function creaLista($service, $emailList){

  $nombregrupo=$emailList;  
  $emailList=$emailList."@unbosque.edu.co";

  $body = new Google_Service_Directory_Group();
  $body->setEmail($emailList);
  $body->setName($nombregrupo);
  $results = $service->groups->insert($body);  

}

function agregarCorreosLista($service, $service2, $emailList, $arraylista) {

    $emailList=$emailList."@unbosque.edu.co";

    #1. Se asignan permisos al grupo antes de incluir los correos al grupo
    $body = new Google_Service_Groupssettings_Groups();
    $body->setWhoCanJoin('CAN_REQUEST_TO_JOIN');
    $body->setWhoCanPostMessage('ALL_MANAGERS_CAN_POST');
    $body->setWhoCanViewGroup('ALL_MANAGERS_CAN_VIEW');
    $body->setWhoCanViewMembership('ALL_MANAGERS_CAN_VIEW');
    $body->setMembersCanPostAsTheGroup('false');
    $body->setAllowWebPosting('false');
    $body->setWhoCanLeaveGroup('ALL_MEMBERS_CAN_LEAVE');
    $results = $service2->groups->update($emailList,$body);    
    
    #2. Luego el ciclo para agregar los correos a la lista
    foreach ($arraylista as $ilista => $infolista) {
        
        $dircorreo=trim($infolista['Correo_Institucional']);        
        
        $arro="@";
        $mirasihay=substr_count($dircorreo,$arro);
        if($mirasihay > 1){
	  $texto_partido = explode('@',$dircorreo); 
	  $dircorreo=$texto_partido[0]."@unbosque.edu.co";
        }
        
        $verificacion=$dircorreo;      
        
        
        $verificacion=substr($verificacion,0,1);
        if($verificacion=='@'){
        $notienecorreo=1;
        }
        else{
        $notienecorreo=0;
        }
        
        if(isset($dircorreo) && $dircorreo!='' && $notienecorreo==0){
        sleep(1);
        $body = new Google_Service_Directory_Member();
	$body->setEmail($dircorreo);
	$body->setRole('MEMBER');
	
	  try{
	  $results = $service->members->insert($emailList,$body);
	  
	  echo "<h5>Agrego correo= " . $dircorreo . " en lista.</h5>";
	  
	  ob_flush();
	  flush();
	  } catch (Google_Service_Exception $miExcepcion) {
	      echo "<h5>No pudo agregar correo:". $dircorreo ."</h5>";	      
	  } catch(Exception $e){
	  //lo demas no importa
	  }
        }
    }
    
    $body = new Google_Service_Directory_Member();
    $body->setEmail('comunicaciones@unbosque.edu.co');
    $body->setRole('MANAGER');
    $results = $service->members->insert($emailList,$body);
    
}
?>
