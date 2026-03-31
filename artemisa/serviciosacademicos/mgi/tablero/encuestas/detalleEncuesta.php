<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 global $db;
 include_once('../../ReportesAuditoria/templates/mainjson.php');
 include_once('class/Encuestas_Class.php'); $C_Encuestas = new Encuestas(); 
 $valorMinimo = 15;
 
//echo '<pre>';print_r($_REQUEST);

 $Periodo = $C_Encuestas->Periodo('Actual','','');
 
 //$Periodo = '20132';
 
 //echo '<pre>';print_r($Periodo);
/*
***Estudiante en la tabla detalledel publico objetivo exiten dos campos E_new E_old si alguno de estos esta en 1 aplica a estudiante

***Docente  en la tabla detalle publico objetivo existe un (1) docente y esta en 1 aplica  a docente la encueta o instrumento.

***Graduado en la talba detalle publico objetivo exite un campo llamado E_Gra  1 aplica a estudiantes graduados 

***Si el campo en la tabla publico objetivo cvs esta en 0 toca revisar la tabla cvspublico objetivo 

*/

$id_instrumento   = $_REQUEST['id_instrumento'];

  $C_Data = $C_Encuestas->PublicoObjetivo($id_instrumento);

  //echo '<pre>';print_r($C_Data);      

  if($C_Data['Estudiante']['data']==1){ 
    
    if($C_Data['Estudiante']['Carrera']=='0'){
        
    $C_Estudiantes = $C_Encuestas->DataEstudiantes($id_instrumento,$C_Data['Estudiante']['modalidad'],$Periodo);
    
    //echo '<pre>';print_r($C_Estudiantes);
    
    $C_Info = array();
    
    for($i=0;$i<count($C_Estudiantes);$i++){
        
        $TotalMatriculados = $C_Encuestas->LLamaMatriuclados($Periodo,$C_Estudiantes[$i]['codigocarrera']);
        
        $Porcentaje  = (($C_Estudiantes[$i]['num']*100)/$TotalMatriculados);
        
        $C_Info['Labes'][]  = $C_Estudiantes[$i]['Nombre'];
        $C_Info['Porcentaje'][]  = number_format($Porcentaje,'2','.','.');     
        
    }//for
    
    //echo '<pre>';print_r($C_Info);
    
    $C_Encuestas->GraficaBarras($C_Info,'Global');
    
    //include_once('PruebaBarras.php');die;
    
    ?>
    <table border="1">
        <thead>
            <tr>
                <!--<th>N&deg;</th>-->
                <th></th>
                <th>Total Matriculados</th>
                <th>Total Deligenciados</th>
                <th>Porcentaje diligenciado (%)</th>
            </tr>
        </thead>
        <tbody>
        <?PHP 
        for($i=0;$i<count($C_Estudiantes);$i++){
            
            $TotalMatriculados = $C_Encuestas->LLamaMatriuclados($Periodo,$C_Estudiantes[$i]['codigocarrera']);
            
            $Porcentaje  = (($C_Estudiantes[$i]['num']*100)/$TotalMatriculados);
            ?>
            <tr>
                <!--<td><?PHP //echo $i+1?></td>-->
                <td class="first"><?php echo $C_Estudiantes[$i]['Nombre']; ?></td>
                <td><?php echo $TotalMatriculados; ?></td>
                <td><?php echo $C_Estudiantes[$i]['num']; ?></td>
                <td><span <?php if($Porcentaje<$valorMinimo){ ?>class="badResult"<?php } ?>><?php echo number_format($Porcentaje,'2','.','.'); ?></span></td>
            </tr>
            <?PHP
        }//for
        ?>
        </tbody>
    </table>
    <?PHP
    }else{
        $C_Carrera  = explode('::',$C_Data['Estudiante']['Carrera']);
        
        $F_Data = array();
        
        for($j=1;$j<count($C_Carrera);$j++){
            
            $E_Data = $C_Encuestas->DetalleCarreraEncuesta($id_instrumento,$C_Carrera[$j]);
            
            $TotalMatriculados = $C_Encuestas->LLamaMatriuclados($Periodo,$C_Carrera[$j]);
        
            $Porcentaje  = (($E_Data[0]['num']*100)/$TotalMatriculados);
            
            $F_Data['Labes'][]       = $E_Data[0]['nombrecarrera'];
            $F_Data['Porcentaje'][]  = number_format($Porcentaje,'2','.','.');     
            
        }//for
        
        //echo '<pre>';print_r($F_Data);
        
        $C_Encuestas->GraficaBarras($F_Data,'Detalle');
        
        ?>
        <table border="1">
            <thead>
                <tr>
                    <!--<th>N&deg;</th>-->
                    <th></th>
                    <th>Total Matriculados</th>
                    <th>Total Deligenciados</th>
                    <th>Porcentaje diligenciado (%)</th>
                </tr>
            </thead>
            <tbody>
            <?PHP 
            
            for($j=1;$j<count($C_Carrera);$j++){
                
                $E_Data = $C_Encuestas->DetalleCarreraEncuesta($id_instrumento,$C_Carrera[$j]);
                
                //echo '<pre>';print_r($E_Data);
                
                $TotalMatriculados = $C_Encuestas->LLamaMatriuclados($Periodo,$C_Carrera[$j]);
            
                $Porcentaje  = (($E_Data[0]['num']*100)/$TotalMatriculados);
                
                ?>
                <tr>
                    <!--<td><?PHP //echo $j?></td>-->
                    <td class="first"><?php echo $E_Data[0]['nombrecarrera']?></td>
                    <td><?php echo $TotalMatriculados?></td>
                    <td><?php echo $E_Data[0]['num']?></td>
                    <td><span <?php if($Porcentaje<$valorMinimo){ ?>class="badResult"<?php } ?>><?php echo number_format($Porcentaje,'2','.','.')?></span></td>
                </tr>
                <?PHP
                
            }//for
            ?>
            </tbody>
        </table>    
        <?PHP
        
    }//if
  }
  if($C_Data['Graduado']['data']==1){/*  senior*/
    
    if($C_Data['Graduado']['recienegresado']){
        
        $C_Total = $C_Encuestas->DataRecienEgresado();
        
        $Nombre  = 'Recien Egresado';
        
        $C_Dato  = $C_Encuestas->DataEgresado($id_instrumento,0);
        
        
       
    }
    
    if($C_Data['Graduado']['consolidacionprofesional']){
        
        $C_Total = $C_Encuestas->ConsolidacionEgresado();
        
        $Nombre  = 'Consolidacion Profesional';
        
        $C_Dato  = $C_Encuestas->DataEgresado($id_instrumento,1);
        
    }
    
    
   $G_Data = array();
   $C_Info = array();
        
        for($i=0;$i<count($C_Dato['CodigoCarrera']);$i++){
            
            for($j=0;$j<count($C_Total['CodigoCarrera']);$j++){
                
                if($C_Dato['CodigoCarrera'][$i]==$C_Total['CodigoCarrera'][$j]){
                    
                    $C_Info['Nombre'][]     =$C_Dato['Nombre'][$i];
                    $C_Info['Num'][]        =$C_Dato['Num'][$i];
                    $C_Info['Num2'][]       = $C_Total['num'][$j];
                    
                    $G_Data['Labes'][]       = $C_Dato['Nombre'][$i];
                    $Porcentaje  = (($C_Dato['Num'][$i]*100)/$C_Total['num'][$j]);
                    $G_Data['Porcentaje'][]  = number_format($Porcentaje,'2','.','.'); 
                    
                    $C_Info['CodigoCarrera'][]   = $C_Total['CodigoCarrera'][$j];
                    
                }
                
            }
            
        }
            
            
     $C_Encuestas->GraficaBarras($G_Data,'Egresado');
     
     //echo '<pre>';print_r($C_Dato); 
     
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Programa Acad&eacute;mico</th>
                    <th>Total Egresados</th>
                    <th>Total Deligenciados</th>
                    <th>Porcentaje diligenciado (%)</th>
                </tr>
            </thead>
            <tbody>
            <?PHP 
            for($i=0;$i<count($C_Info['Nombre']);$i++){
                
                $Porcentaje  = (($C_Info['Num'][$i]*100)/$C_Info['Num2'][$i]);
                
                ?>
                <tr>
                    <td class="first"><?PHP echo $C_Info['Nombre'][$i]?></td>
                    <td><?php echo $C_Info['Num2'][$i]; ?></td>
                    <td><?php echo $C_Info['Num'][$i]; ?></td>
                    <td><span <?php if($Porcentaje<$valorMinimo){ ?>class="badResult"<?php } ?>><?php echo number_format($Porcentaje,'2','.','.'); ?></span></td>
                </tr>
                <?PHP
            }/*for*/
            ?>  
            </tbody>
        </table>    
        <?PHP
   
   
    
  }
  if($C_Data['Docente']==1 || $C_Data['Docente']=='1'){
    
    $D_Docente = $C_Encuestas->DataDocente($id_instrumento,$Periodo);
    
    echo '<pre>';print_r($D_Docente);
    ?>
    <table border="1">
        <thead>
            <tr>
                <!--<th>N&deg;</th>-->
                <th></th>
                <th>Total Deligenciados</th>
            </tr>
        </thead>
        <tbody>
        <?PHP 
        for($t=0;$t<count($D_Docente);$t++){
            if(!$D_Docente[$t]['Nombre']){
                $Nombre  = 'Sin Asignacion Carrera';
            }else{
                $Nombre  = $D_Docente[$t]['Nombre'];
            }
        ?>
            <tr>
                <td class="first"><?php echo $Nombre?></td>
                <td><?PHP echo $D_Docente[$t]['Num']?></td>
            </tr>
        <?PHP
        }//for
        ?>
        </tbody>
    </table>        
    <?PHP
  }
  if($C_Data['CVS']==1){
    
    $L_Data  = array();
    
    for($i=0;$i<count($C_Data['Label']);$i++){
        
        $Porcentaje  = (($C_Data['Contestado'][$i]*100)/$C_Data['total'][$i]);
        
        $L_Data['Labes'][]       = $C_Data['Label'][$i];
        $L_Data['Porcentaje'][]  = number_format($Porcentaje,'2','.','.');
        
    }//for
    
    $C_Encuestas->GraficaBarras($L_Data,'Grafic_CVS');
    
    ?>
     <table border="1">
        <thead>
            <tr>
                <th></th>
                <th>Total Matriculados</th>
                <th>Total Deligenciados</th>
                <th>Porcentaje diligenciado (%)</th>
            </tr>
        </thead>
        <tbody>
        <?PHP 
        for($i=0;$i<count($C_Data['Label']);$i++){
            
            $Porcentaje  = (($C_Data['Contestado'][$i]*100)/$C_Data['total'][$i]);
            
            ?>
            <tr>
                <td><?PHP echo $C_Data['Label'][$i]?></td>
                <td><?PHP echo $C_Data['total'][$i]?></td>
                <td><?PHP echo $C_Data['Contestado'][$i]?></td>
                <td><span <?php if($Porcentaje<$valorMinimo){ ?>class="badResult"<?php } ?>><?PHP echo number_format($Porcentaje,'2','.','.')?></span></td>
            </tr>
            <?PHP
        }//for
        ?>
        </tbody>
    </table>    
    <?PHP
  }