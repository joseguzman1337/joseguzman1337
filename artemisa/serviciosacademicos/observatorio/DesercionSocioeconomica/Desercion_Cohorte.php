<?php
include ('Desercion_class.php');  $C_Desercion = new Desercion();

global $db;
MainJson();

$CodigoPeriodo  = '20082';

$CodigoCarrera=5;

$Periodo_Actual = $C_Desercion->Periodo('Actual','','');

$C_Periodos = $C_Desercion->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);

//echo '<pre>';print_r($C_Periodos);

$Periodos   = array();

for($i=0;$i<count($C_Periodos);$i++){
    /**********************************************/
        $Periodos['Periodo'][]=$C_Periodos[$i]['codigoperiodo'];
    /**********************************************/
}//for

include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

echo '<pre>';print_r($Periodos);

$n=20;

if($n<count($Periodos['Periodo'])){
    $Num_cohorte  = $n;
}else{
    $Num_cohorte = count($Periodos['Periodo']);
}

//echo '$Num_cohorte->'.$Num_cohorte;

/**************************************************************/
    $datos_estadistica   = new obtener_datos_matriculas($db,$CodigoPeriodo);
    
    $C_MatriculadosInicio        = $datos_estadistica->obtener_total_matriculados($CodigoCarrera,'arreglo');
    
    //echo '<pre>';print_r($C_MatriculadosInicio);
/**************************************************************/

for($j=0;$j<$Num_cohorte;$j++){
   /************************************************************/
   $D_estadistica   = new obtener_datos_matriculas($db,$Periodos['Periodo'][$j]);
   /************************************************************/
        if($CodigoPeriodo==$Periodos['Periodo'][$j]){
            /**************************************************/
            
            /**************************************************/
        }else{
          /****************************************************/
          $Desercion_Dato       = $D_estadistica->obtener_datos_estudiantes_desercion($CodigoCarrera,'arreglo');
          
          echo '<br>periodo->'.$Periodos['Periodo'][$j];
          //echo '<pre>';print_r($Desercion_Dato);
          /****************************************************/
          echo '<br>Num->'.count($Desercion_Dato);
          $p = 1;
          
          $D_Cohorte  = array();
          
          for($x=0;$x<count($C_MatriculadosInicio);$x++){
            for($k=0;$k<count($Desercion_Dato);$k++){
                /*******************************************/
                if($C_MatriculadosInicio[$x]['codigoestudiante']==$Desercion_Dato[$k]['codigoestudiante']){
                    echo '<br>'.$C_MatriculadosInicio[$x]['codigoestudiante'].'=='.$Desercion_Dato[$k]['codigoestudiante'];
                    
                    $D_Cohorte[$Periodos['Periodo'][$j]][]=$Desercion_Dato[$k]['codigoestudiante'];
                    
                    $p++;
                }
                
                /*******************************************/
            }//for
          }//for
          echo '<br><strong style="color:Red; font-size:18px">P-></strong>'.$p;
          echo '<pre>';print_r($D_Cohorte);
          /****************************************************/
         // die;
          /****************************************************/  
        }
   /************************************************************/ 
}//for



function MainJson(){
	
	global $db,$userid;
	
	include ('../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}
?>