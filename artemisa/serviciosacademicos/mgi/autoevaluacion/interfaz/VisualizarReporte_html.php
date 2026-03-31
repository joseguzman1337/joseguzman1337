<?php

session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

if(!isset ($_SESSION['MM_Username'])){
	?>
	<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>
	<?PHP
    exit();
} 
switch($_REQUEST['actionID']){
    case 'Reporte':{
        global $userid,$db,$C_VisualizarReporte;
       
        MainGeneral(); 
        
        //echo '<pre>';print_r($_POST);die;
        
        $id        = $_POST['id'];
        $Modalidad = $_POST['Modalidad'];
        $Carrera   = $_POST['Carrera'];
        
        $C_VisualizarReporte->ViewReport($id,$Carrera,$Modalidad,$_POST['color']);
        
    }break;
    case 'Carrera':{
       global $userid,$db,$C_VisualizarReporte;
       
       MainGeneral(); 
              
       $Modalidad   = $_POST['Modalidad'];
       
       $C_VisualizarReporte->Carrera($Modalidad);
       
    }break;
    default:{
        global $db,$userid,$C_VisualizarReporte;
        MainGeneral();
        JSGenral();
        
        //echo '<pre>';print_r($_GET);
        /*
        [cat_ins] => OTRAS
        [id] => row_92
        */
        
        $id = str_replace('row_','',$_GET['id']);
        
       // $carrera = '10';
       // $Modalidad = '200';
        
            $C_VisualizarReporte->Consola($id);
        ?>
        </div>
        </body>
        </html>
        <?PHP    
    }break;
}//switch
function MainGeneral(){
    
        global $userid,$db,$C_VisualizarReporte;
        
		//var_dump (is_file('../mgi/templates/template.php'));die;
        
        include ("../../templates/templateAutoevaluacion.php");
        include_once('VisualizarReporte_class.php');   $C_VisualizarReporte = new VisualizarReporte();

        $db = writeHeader('Reportes Detalle',true);
        
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
}
function JSGenral(){
    ?>
    <script type="text/javascript" language="javascript" src="VisualizarReporte.js"></script>
    <?PHP
}
?>