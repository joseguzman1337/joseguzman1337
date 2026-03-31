
<?php
session_start();
include("../templates/template.php"); 	
//var_dump(is_file('../../mgi/Menu.class.php'));die;
include_once('../../mgi/Menu.class.php');
include_once('InterfazSolicitud_class.php');  $C_InterfazSolicitud = new InterfazSolicitud();

$db = writeHeader('Reportes Espacio Fisico',true);


$SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		$userid=$Usario_id->fields['id'];
        $codigorol=$Usario_id->fields['codigorol'];

$C_Menu_Global  = new Menu_Global();

$Data = $C_InterfazSolicitud->UsuarioMenu($db,$userid);

//echo '<pre>';print_r($Data);die;

if($Data['val']==true){
    for($i=0;$i<count($Data['Data']);$i++){
        /**********************************************/
        if('InterfazSolicitud_html.php'==$Data['Data'][$i]['Url']){
            $URL[] = $Data['Data'][$i]['Url'];
        }else if('InterfazSolicitud_html.php?actionID=Creacion'==$Data['Data'][$i]['Url']){
            $URL[] = $Data['Data'][$i]['Url'];
        }else if('fromReportesEspacioFisico.php'==$Data['Data'][$i]['Url']){
            $URL[] = $Data['Data'][$i]['Url'];
        }else if('../Notificaciones/ConsolaNotificaciones_html.php'==$Data['Data'][$i]['Url']){
            $URL[] = $Data['Data'][$i]['Url'];
        }
        
        
        $Nombre[] = $Data['Data'][$i]['Nombre'];
        
        if($Data['Data'][$i]['Url']=='fromReportesEspacioFisico.php'){
            $Active[] = '1';    
        }else{
            $Active[] = '0';
        }
        
        /**********************************************/
    }//for
}else{
    echo $Data['Data'];die; 
}//if



$C_Menu_Global->writeMenu($URL,$Nombre,$Active);

?>
<script>
$(function() {
    $( "#tabs" ).tabs();
});

</script>
<script src="../js/tooltip.js" type="text/javascript"></script>
-<div id="tabs" style="margin-left: 10px;">
    <ul>
        <li><a href="../asignacionSalones/SalonesDisponibles_html.php" style="cursor: pointer;">Espacios Disponibles</a></li>
        <li><a href="InterfazSolicitud_html.php?actionID=PendienteAsignar" style="cursor: pointer;">Solicitud Detalle Pendiente</a></li>
        <li><a href="../reportes/reporteAulasDiarioInicio.php" style="cursor: pointer;">Reporte ocupación de aulas</a></li>
   </ul>
</div>   