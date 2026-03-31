<?php
include ('Desercion_class.php');  $C_Desercion = new Desercion();

global $db;
MainJson();

$CodigoPeriodo  = '20082';



$Periodo_Actual = $C_Desercion->Periodo('Actual','','');

$C_Periodos = $C_Desercion->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);

//echo '<pre>';print_r($C_Periodos);

$Periodos   = array();

for($i=0;$i<count($C_Periodos);$i++){
    /**********************************************/
        $Periodos['Periodo'][]=$C_Periodos[$i]['codigoperiodo'];
    /**********************************************/
}//for

//echo '<pre>';print_r($Periodos);

$P_Anual    = array();

for($j=0;$j<count($Periodos['Periodo']);$j=$j+2){
    /****************************************************/
        $x  = $j+1;
        
       $P_Anual['Anual'][]=$Periodos['Periodo'][$j].'-'.$Periodos['Periodo'][$x];
    /****************************************************/
}//for

echo '<pre>',print_r($P_Anual);
echo '<br>xxx->'.count($P_Anual['Anual']);

include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

for($l=0;$l<count($P_Anual['Anual']);$l++){//
    /********************************************/
    $C_Anual    = explode('-',$P_Anual['Anual'][$l]);
    
    //echo '<pre>';print_r($C_Anual);
    
    if($C_Anual[0] && $C_Anual[1]){
       
      $L_Carrera = $C_Desercion->Carreras(); //echo '<pre>';print_r($L_Carrera);
        
      $datos_estadistica_Uno = new obtener_datos_matriculas($db,$C_Anual[0]);
      
      $datos_estadistica_Dos = new obtener_datos_matriculas($db,$C_Anual[1]);
      
      $R_Datos  = array();
      
     $R_Datos[$l]['Periodos'][]=$C_Anual[0].'-'.$C_Anual[1];
      
      for($Q=0;$Q<count($L_Carrera);$Q++){
             
        /*********************************************/
              $U_DesercionDato       = $datos_estadistica_Uno->obtener_datos_estudiantes_desercion($L_Carrera[$Q]['codigocarrera'],'arreglo');
      
              $U_Matriculados        = $datos_estadistica_Uno->obtener_total_matriculados($L_Carrera[$Q]['codigocarrera'],'arreglo');
              
              $T_Matriculados        = $datos_estadistica_Dos->obtener_total_matriculados($L_Carrera[$Q]['codigocarrera'],'arreglo');
                
              /*******************************************/
              $D_PeriodoUno=count($U_DesercionDato);
              //echo '<pre>';print_r($U_DesercionDato);
              $Matriculados_uno=count($U_Matriculados);
              $Matriculados_Dos=count($T_Matriculados);
              //echo '<pre>';print_r($T_Matriculados); die;
              
              $C_Existe = array();
              
              //echo '<pre>',print_r($T_Matriculados); 
              /*******************************************/  
              for($D=0;$D<count($T_Matriculados);$D++){
                /*******************************************/
                    //echo '<br>Codigo_Estudiante ==>'.$U_DesercionDato[$U]['codigoestudiante'];
                    for($U=0;$U<count($U_DesercionDato);$U++){
                        /*************************************/
                            //echo '<br>'.$U_DesercionDato[$U]['codigoestudiante'].'=='.$T_Matriculados[$D]['codigoestudiante'];
                            if($U_DesercionDato[$U]['codigoestudiante']==$T_Matriculados[$D]['codigoestudiante']){
                                /*******************************************/
                                    $C_Existe['Retomaron'][]=$T_Matriculados[$D]['codigoestudiante'];
                                /*******************************************/
                            }//if   
                        /*************************************/
                    }//for
                   
                /*******************************************/
              }//for
              /*******************************************/
               //echo '<pre>';print_r($C_Existe['Retomaron']);
              
               /*echo '<br>CodigoCarrera->'.$L_Carrera[$Q]['codigocarrera'];
               echo '<br>NombreCarrera->'.$L_Carrera[$Q]['nombrecarrera'];*/
               $R_Matriculados=count($C_Existe['Retomaron']);
               
               $Valor_final = (($D_PeriodoUno-$R_Matriculados)/($Matriculados_uno+$Matriculados_Dos));
               
              /* echo '<br>Num_Der->'.($D_PeriodoUno-$R_Matriculados);
               echo '<br>Desercion Anual %-->'.$Valor_final;
               echo '<br><br>';*/
               
               $R_Datos[$l]['CodigoCarrera'][]=$L_Carrera[$Q]['codigocarrera'];
               $R_Datos[$l]['Nombre'][]=$L_Carrera[$Q]['nombrecarrera']; 
               $R_Datos[$l]['Total_Matriculados'][]=$Matriculados_uno+$Matriculados_Dos;
               $R_Datos[$l]['Desercion_Anual'][]=$D_PeriodoUno-$R_Matriculados;
               $R_Datos[$l]['Porcentaje_Anual'][]=number_format($Valor_final,'2',',','.');
        /*********************************************/
      }//for
    }//if
    
    echo '<pre>';print_r($R_Datos);
    /********************************************/
}//for

echo 'Num->'.count($R_Datos);

 

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