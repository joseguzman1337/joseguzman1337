<?php
include("../templates/template.php");
include_once('ConsolaNotificaciones_class.php');       $C_ConsolaNotificaciones = new ConsolaNotificaciones();
include_once('ConsolaNotificaciones_View.php');        $V_ConsolaNotificaciones = new ViewConsolaNotificaciones();
include_once('NotificacionEspaciosFisicos_class.php'); $C_NotificacionEspaciosFisicos = new NotificacionEspaciosFisicos();		

$db = getBD();

$Data = $C_ConsolaNotificaciones->InfoConsola($db);

//echo '<pre>';print_r($Data);

for($i=0;$i<count($Data);$i++){
    
    $id = $Data[$i]['id'];
    
    $Alumnos = $C_NotificacionEspaciosFisicos->AlumnosSolicitudCambio($db,$id);
           /*
            (
                [0] => 56516
                [codigoestudiante] => 56516
                [1] => CHRISTIAN YESID LUNA GALINDO
                [FulName] => CHRISTIAN YESID LUNA GALINDO
                [2] => clunag@unbosque.edu.co
                [Correo] => clunag@unbosque.edu.co
            )
            */
            for($j=0;$j<count($Alumnos);$j++){
                $CodigoEstudiante = $Alumnos[$j]['codigoestudiante'];
                $Correo           = $Alumnos[$j]['Correo'];
                $FulName          = $Alumnos[$j]['FulName'];   
                
                $Info = $C_NotificacionEspaciosFisicos->InfoManualCambios($db,$id,$CodigoEstudiante);
                
                //echo '<pre>';print_r($Info);
                $Mensaje = $V_ConsolaNotificaciones->Mensaje($Info,$FulName);
                
                $to = $Correo;//'ramirezmarcos@unbosque.edu.co';//
                //echo '<br><br>'.$Mensaje;
                $tittle = 'Cambios De Aula o Camcelaci&oacute;n de Clase';
                
                $Resultado = $C_NotificacionEspaciosFisicos->EnviarCorreo($to,$tittle,$Mensaje,true);
            }//for           
    
}//for
for($j=0;$j<count($Data);$j++){
   $id = $Data[$j]['id']; 
   
   $C_NotificacionEspaciosFisicos->CambiarAEnviado($db,$id);
}//for

//echo '<br><br>Termino';
?>