<?php
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 

switch($_REQUEST['actionID']){
    case 'Validar':{
        global $db;
        
        MainJson();
      
        $alias              = $_POST['alias'];
        $Validar            = $_POST['Validar'];
        $Periodo            = $_POST['Periodo'];
        
           $query="select	 
            
                        sbu.id
                        
					from siq_bienestaruniversitario sbu 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbu.semestre=".$Periodo." and sch2.aliasclasificacionesinfhuerfana='".$alias."'";
                    
            if($Data=&$db->Execute($query)===false){
                $a_vectt['val']			='FALSE';
                $a_vectt['descrip']		='Error en la Consulta de la Data... '.$query;
                echo json_encode($a_vectt);
                exit; 
            } 
            
            while(!$Data->EOF){
                /*******************************************/
                $id  = $Data->fields['id'];
                
                $Update='UPDATE  siq_bienestaruniversitario
                         
                         SET     validar="'.$Validar.'"
                         
                         WHERE   
                                 id="'.$id.'"';
                                 
                      if($Modificar=&$db->Execute($Update)===false){
                            $a_vectt['val']			='FALSE';
                            $a_vectt['descrip']		='Error en la Modificar la Data... '.$Update;
                            echo json_encode($a_vectt);
                            exit; 
                      }           
                /*******************************************/
                $Data->MoveNext();
            }//while
            
            $a_vectt['val']			='TRUE';
            if($Validar==1 || $Validar=='1'){
                $Text = 'La Informacion ha sido Validada.';
            }else{
                $Text = 'La Informacion ha sido Desvalidada.';
            }
            $a_vectt['descrip']		=$Text;
            echo json_encode($a_vectt);
            exit;       
        
    }break;
}
function MainJson(){
    
    global $db;
    
    require_once("../../../templates/template.php");
    $db = getBD();
    
}
?>