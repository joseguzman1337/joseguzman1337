<?php
class DesercionCostos{
    
    public function Display(){
        global $db;
        
       $CodigoPeriodo   = '20081';
        
        include_once ('Desercion_class.php');  $C_Desercion = new Desercion();
        
        $PeriodoAnual   = $C_Desercion->PeriodosAnuales($CodigoPeriodo);
    
    //echo '<pre>';print_r($PeriodoAnual);
    
    $D_Periodo = array();
    
    for($i=0;$i<count($PeriodoAnual['Anual']);$i++){
    
        /***************************************/
        $C_Periodo  = explode('-',$PeriodoAnual['Anual'][$i]);
        
        $D_Periodo[] = $C_Periodo[0];
        
        if($C_Periodo[1]){
            
            $D_Periodo[] = $C_Periodo[1];
            
        }
                            
    }
    
    //echo '<pre>';print_r($D_Periodo);die;
    ?>
    <style type="text/css" title="currentStyle">
                @import "../data/media/css/demo_page.css";
                @import "../data/media/css/demo_table_jui.css";
                @import "../data/media/css/ColVis.css";
                @import "../data/media/css/TableTools.css";
                @import "../data/media/css/ColReorder.css";
                @import "../data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../data/media/css/jquery.modal.css";
                
    </style>
    <script type="text/javascript" language="javascript" src="../data/media/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="../jquery/js/jquery-3.6.0.js"></script>
    <script type="text/javascript" language="javascript" src="../data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/TableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/FixedColumns.js"></script>
    <script type="text/javascript" charset="utf-8" src="../data/media/js/ColReorder.js"></script>
    <script type="text/javascript" language="javascript">
        
        $(document).ready( function () {//"sDom": '<Cfrltip>',
				var oTable = $('#example').dataTable( {
				    
  					
  					"sScrollX": "100%",
					"sScrollXInner": "100,1%",
					"bScrollCollapse": true,
                    "bPaginate": true,
                    "aLengthMenu": [[50], [50,  "All"]],
                    "iDisplayLength": 50,
                    "sPaginationType": "full_numbers",
					"oColReorder": {
						"iFixedColumns": 1,
					}
                    
                    
					
				} );
				//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 2,
                                         "iLeftWidth": 350
				} );
                                
                                 var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
					]
		         });
                         $('#demo_1').before( oTableTools.dom.container );
			} ); 
        
    </script>
    
    <input type="hidden" id="CodigoPeriodo" value="<?PHP echo $CodigoPeriodo?>" />    
    <div id="demo_1">
         <table cellpadding="0" cellspacing="0" border="1" class="display" id="example" style="width: 100%;" >
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Carrera</th>
                    <?PHP 
                    $P_num = count($D_Periodo);
                   
                    $Index  = '';
                    
                    for($i=0;$i<$P_num;$i++){
                        
                            /***************************************/
                            $C_Periodo  = $D_Periodo[$i];
                            /***************************************/
                            if($C_Periodo){
                                /************************************/
                                
                               
                                
                                 /**********************************************/
                                $arrayP     = str_split($C_Periodo, strlen($C_Periodo)-1);
                                
                                
                
                                $P = $arrayP[0]-1;
                                      
                                                        
                                $PeriodoDesercionInicio = $P.$arrayP[1];
                                
                                
                                $X  = $arrayP[1]-1;                        
                                
                                if($X==0){
                                    
                                    $O = $arrayP[0]-2;
                                    
                                    $Periodobase = $O.'2';
                                    
                                }else{
                                    
                                   $O = $arrayP[0]-1; 
                                   $Periodobase = $O.'1'; 
                                }
                                
                                
                                $arrayP = str_split($PeriodoDesercionInicio, strlen($PeriodoDesercionInicio)-1);
                        
                                
                                
                                if($arrayP[1]==1){
                                    
                                    $Year2   = $arrayP[0].'2';
                                    
                                }else{
                                    
                                    $A  = $arrayP[0]+1;
                                    
                                    $Year2   = $A.'1';
                                } 
                                
                                $arrayP2 = str_split($Year2, strlen($Year2)-1);
                
                                 if($arrayP2[1]==1){
                                    
                                    $Year3   = $arrayP2[0].'2';
                                    
                                }else{
                                    
                                    $B  = $arrayP2[0]+1;
                                    
                                    $Year3   = $B.'1';
                                } 
                                
                                $Index  = $i;
                                /************************************/
                                
                                 $arrayB = str_split($Periodobase, strlen($Periodobase)-1);
                                 
                                 $Periodo_B = $arrayB[0].'-'.$arrayB[1];
                                 
                                 $arrayD = str_split($Year3, strlen($Year3)-1);
                                 
                                 $Periodo_D = $arrayD[0].'-'.$arrayD[1];
                                /**********************************************/
                                
                             ?>
                            <th>Poblaci&oacute;n total <?PHP echo $Periodo_B?></th>
                            <th>Poblaci&oacute;n Deserci&oacute;n <?PHP echo $Periodo_D?></th>
                            <th>Porcentaje Deserci&oacute;n (%) <?PHP echo $Periodo_D?></th>
                            <th>Valor <?PHP echo $Periodo_D?></th>
                            <th><a onclick="CostoDesercionGraficaPrograma(<?PHP echo $arrayP[0]?>)" title="Ver Grafica Costo Desercion Por Programa" style="cursor: pointer;">Valor Presente</a> <?PHP echo $Periodo_D?></th>
                            <?PHP    
                            }//if
                         
                    }//for
                    ?>
                </tr>
            </thead>
            <tbody>
            <?PHP 
            //$D_Anual    = $this->DesercionAnual($CodigoPeriodo);
            
            $C_Carrera  = $C_Desercion->Carreras();
            
                        
            for($j=0;$j<count($C_Carrera);$j++){//for
               
                /********************************************************************/
                ?>
                <tr>
                    <td><?PHP echo $j+1?></td>
                    <td><a onclick="CostoDesercionGraficaSemestrePrograma('<?PHP echo $C_Carrera[$j]['codigocarrera']?>')" title="Ver Grafica De Costo por Semestre Por Programa" style="cursor: pointer;"><?PHP echo $C_Carrera[$j]['nombrecarrera']?></a></td>
                    <?PHP 
                     for($i=0;$i<$P_num;$i++){//for
                        /*******************************************************************/
                        $Periodo = $D_Periodo[$i];
                        
                        $ValorCosto  = $this->CostoDesercion($C_Carrera[$j]['codigocarrera'],$Periodo);
                        
                        $Valor_Actual  = $this->CostoActual($C_Carrera[$j]['codigocarrera']);
                        
                        
                        /*******************************************************************/
                        
                            $D_Anual = $C_Desercion->ConsultaDesercionAnual($C_Carrera[$j]['codigocarrera'],$Periodo);
                            
                            //echo '<pre>';print_r($D_Anual);
                            
                            $CostoActual  = $D_Anual[$C_Carrera[$j]['codigocarrera']]['Desercion'][0]*$Valor_Actual;
                            /****************************************************************************/
                            ?>
                            <td><center><?PHP echo $D_Anual[$C_Carrera[$j]['codigocarrera']]['Matriculados'][0]?></center></td>
                            <td><center><?PHP echo $D_Anual[$C_Carrera[$j]['codigocarrera']]['Desercion'][0]?></center></td>
                            <td><center><?PHP echo number_format($D_Anual[$C_Carrera[$j]['codigocarrera']]['Porcentaje'][0],'2',',','.')?>%</center></td>
                            <td>$<?PHP echo number_format($ValorCosto,'0','.','.')?></td>
                            <td>$<?PHP echo number_format($CostoActual,'0','.','.')?></td>
                            <?PHP
                            /****************************************************************************/
                           
                        /*******************************************************************/
                    }//for
                    ?>
                </tr>
                <?PHP
                /********************************************************************/
            }//for
           
            ?>
             <tr>
                <td><?PHP echo $j+1?></td>
                <td><a onclick="CostoDesercionGrafica()" title="Costo de la Desercion" style="cursor:pointer;">Total</a></td>
                <?PHP 
                
                
                for($i=0;$i<$P_num;$i++){//for
                    
                    $S_CostoR  = 0;
                    $S_CostoA  = 0;
                    $Periodo = $D_Periodo[$i];
                    
                    for($j=0;$j<count($C_Carrera);$j++){//for
                    
                        $Carrera_id    = $C_Carrera[$j]['codigocarrera'];
                        
                        $ValorCosto  = $this->CostoDesercion($Carrera_id,$Periodo);
                        
                        $S_CostoR    = $S_CostoR+$ValorCosto;
                        
                        $Valor_Actual = $this->CostoActual($Carrera_id,$Periodo);
                        
                        $S_CostoA    = $S_CostoA+$Valor_Actual;
                        
                    }//for
                    
                    $R_Total  = $C_Desercion->SumaTotalAnual($Periodo);
                    
                    ?>
                    <td><center><?PHP echo $R_Total['TotalMatriculados']?></center></td>
                    <td><center><?PHP echo $R_Total['TotalDesercion']?></center></td>
                    <td><center><?PHP echo $R_Total['TotalPorcentaje']?>%</center></td>
                    <td><center>$<?PHP echo number_format($S_CostoR,'0','.','.')?></center></td>
                    <td><center><a onclick="CostoDesercionGraficaSemestre('<?PHP echo $Periodo?>')" title="Ver Grafica Costo Por Semestre" style="cursor: pointer;">$<?PHP echo number_format($S_CostoA,'0','.','.')?></a></center></td>
                    <?PHP
                }//for ,,
                ?>
             </tr> 
            </tbody>        
         </table>
         <input type="hidden" id="Index" value="<?PHP echo $j?>" />
    </div>
    <?PHP
       
    }//public function Display
  public function CostoDesercion($Carrera_id,$Periodo,$op=''){
    global $db;
    
    $C_Periodo  = explode('-',$Periodo);
    
    $Periodo_1  = $C_Periodo[0];
    $Periodo_2  = $C_Periodo[1];
    
      $SQL='SELECT 
            
            dc.id_cohortecosto,
            dc.id_desercion,
            dc.codigoestudiante,
            dc.periodoingreso,
            dc.semestre,
            dc.costo
            
            FROM 
            
            DesercionCosto dc INNER JOIN desercion d ON d.id_desercion=dc.id_desercion
            
            
            WHERE 
            
            d.codigocarrera="'.$Carrera_id.'"
            AND
            d.tipodesercion=2 
            AND 
            dc.periododesercion AND dc.periododesercion="'.$Periodo.'"';
            
            if($Costos=&$db->Execute($SQL)===false){
                echo 'Error en el SQL del costo...<br><br>'.$SQL;
                die;
            }
            
            $C_Costo  = $Costos->GetArray();
            
            $Periodos  = $Periodo_1.'-'.$Periodo_2;
            
     $SQL_1='SELECT 

            de.id_desercionestudiante,
            de.codigoestudiante
            
            
            FROM deserciondetalle  dd INNER JOIN desercion  d  ON d.id_desercion=dd.id_desercion
           	                          INNER JOIN desercionEstudiante de ON de.id_detalledesercion=dd.id_detalledesercion
            
            
            WHERE  
            
            d.codigocarrera="'.$Carrera_id.'"
            AND
            d.tipodesercion=1
            AND
            dd.desercionperiodo="'.$Periodo.'"
            AND
            d.codigoestado=100';
            
            if($Estudiante=&$db->Execute($SQL_1)===false){
                echo 'Error en el SQL de LOs Estudiantes....<br><br>'.$SQL_1;
                die;
            }     
            
            
                
            
                
            $C_Estudiante = $Estudiante->GetArray();
            
            $Costo  = 0;
            
            /*echo '<pre>';print_r($C_Costo);
            echo '<pre>';print_r($C_Estudiante); die;*/
              
            for($i=0;$i<count($C_Costo);$i++){
                
                for($j=0;$j<count($C_Estudiante);$j++){
                    
                    if($C_Costo[$i]['codigoestudiante']==$C_Estudiante[$j]['codigoestudiante']){ 
                        
                        //echo '<br>'.$C_Costo[$i]['codigoestudiante'].'=='.$C_Estudiante[$j]['codigoestudiante'];
                        
                         $Costo  = $Costo+$C_Costo[$i]['costo'];   
                    }
                    
                }//for $C_Estudiante
                
            }//for $C_Costo
            
           
         
        if($op==1){
            
            return count($C_Costo);
        }else{
        
            return $Costo;    
            
        } 
            
            
  }//public function CostoDesercion  
  public function CostoActual($Carrera_id,$C_Periodo=''){
    global $db;
    
     include_once ('Desercion_class.php');  $C_Desercion = new Desercion();
     
     $Periodo  = $C_Desercion->Periodo('Actual');
    
    
    
     $SQL='SELECT    

            d.valordetallecohorte
            
            FROM 
            
            cohorte c INNER JOIN detallecohorte d ON d.idcohorte=c.idcohorte
            
            WHERE 
            
            c.codigocarrera="'.$Carrera_id.'"
            AND
            c.codigoperiodo="'.$Periodo.'"   
            AND 
            d.semestredetallecohorte =1';
            
            if($ValorActual=&$db->Execute($SQL)===false){
                echo 'Error en el SQl de Valor Actual...<br><br>'.$SQL;
                die;
            }
        
        if($C_Periodo){ 
            
            $SQL_2='SELECT 
                   
                            dd.matriculados,
                            dd.desercion
                    
                    FROM 
                    
                            desercion d INNER JOIN deserciondetalle dd ON d.id_desercion=dd.id_desercion
                    
                    WHERE
                    
                            d.tipodesercion=1
                            AND
                            d.codigoestado=100
                            AND
                            dd.codigoestado=100
                            AND
                            dd.desercionperiodo="'.$C_Periodo.'"
                            AND
                            d.codigocarrera="'.$Carrera_id.'"
                    
                    GROUP BY  d.id_desercion';
                    
             if($Num_data=&$db->Execute($SQL_2)===false){
                echo 'Error en el SQl 2...<br>'.$SQL_2;
                die;
             }       
            
            $C_Num   = $Num_data->fields['desercion'];
            
            $ValorPresente  = $C_Num*$ValorActual->fields['valordetallecohorte'];
            
            return $ValorPresente;
            
        }else{
            
            return $ValorActual->fields['valordetallecohorte'];    
            
        }
            
        
  }//public function CostoActual
  public function DesercionSemestreInstitucional($Periodo,$C_Carrera){
    global $db;
    
      $C_Periodo  = explode('-',$Periodo);
      
      //echo '<pre>';print_r($C_Carrera);
      
      $Periodo_1    = $C_Periodo[0];
      $Periodo_2    = $C_Periodo[1];
    
       $SQL='SELECT 

            dc.codigoestudiante,
            dc.semestre,
            d.codigocarrera
            
            FROM
            
            desercion d INNER JOIN DesercionCosto dc ON dc.id_desercion=d.id_desercion
            
            WHERE
            
            d.tipodesercion=2
            AND
            d.codigoestado=100
            AND
            dc.periododesercion="'.$Periodo_1.'"';
            
         if($EstudiantesCosto=&$db->Execute($SQL)===false){
            echo 'Error en el SQl de CostoEstudianteSemestre....<br><br>'.$SQL;
            die;
         }   
         
         $SQL_2='SELECT


                d.codigocarrera,
                de.codigoestudiante
                
                FROM 
                
                desercion d INNER JOIN deserciondetalle dd ON d.id_desercion=dd.id_desercion
                						INNER JOIN desercionEstudiante de ON de.id_detalledesercion=dd.id_detalledesercion
                
                WHERE
                
                d.tipodesercion=1
                AND
                d.codigoestado=100
                AND
                dd.desercionperiodo="'.$Periodo_1.'"';
                
           if($DesercionEstudiante=&$db->Execute($SQL_2)===false){
                echo 'Error en el SQl de Desercion Estudiantes...<br><br>'.$SQL_2;
                die;
           }     
         
         /******************************************************************************/
         
         $E_Data  = array();
         
         $C_EstudianteCosto = $EstudiantesCosto->GetArray();
         
         $C_DesercionEstudiante  = $DesercionEstudiante->GetArray();
         
         for($i=0;$i<count($C_EstudianteCosto);$i++){
            
            $CodigoEstudiante  = $C_EstudianteCosto[$i]['codigoestudiante'];
            $Semestre          = $C_EstudianteCosto[$i]['semestre']-1;
            $CodigoCarrera     = $C_EstudianteCosto[$i]['codigocarrera'];
            
            for($j=0;$j<count($C_DesercionEstudiante);$j++){
                
                $CodigoEstudiante_2   = $C_DesercionEstudiante[$j]['codigoestudiante'];
                
                //echo '<br>'.$CodigoEstudiante.'=='.$CodigoEstudiante_2;
                
                if($CodigoEstudiante==$CodigoEstudiante_2){
                    
                    switch($Semestre){
                        case '1':{
                            $E_Data[1][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '2':{
                            $E_Data[2][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '3':{
                            $E_Data[3][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '4':{
                            $E_Data[4][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '5':{
                            $E_Data[5][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '6':{
                            $E_Data[6][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '7':{
                            $E_Data[7][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '8':{
                            $E_Data[8][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '9':{
                            $E_Data[9][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '10':{
                            $E_Data[10][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '11':{
                            $E_Data[11][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                        case '12':{
                            $E_Data[12][$CodigoCarrera][]    = $CodigoEstudiante;
                        }break;
                    }//switch
                    
                }//if
                
                
            }//For DesercionEstudiante
            
           
         }//for $EstudiantesCosto
         
         /******************************************************************************/  
         $S_Estudiante = array();
         
         for($s=1;$s<=12;$s++){
            
             for($x=0;$x<count($C_Carrera);$x++){
            
                $Carrera_id       = $C_Carrera[$x]['codigocarrera'];
                
                $ValorActual      = $this->CostoActual($Carrera_id);
                
                $N_EstudiantesSemestre = count($E_Data[$s][$Carrera_id]);
                
                $S_Estudiante[$s][$Carrera_id]['num']=$N_EstudiantesSemestre;
                $S_Estudiante[$s][$Carrera_id]['valor']=$ValorActual;
                
                $V_total   = $N_EstudiantesSemestre*$ValorActual;
                
                $S_Estudiante[$s][$Carrera_id]['Total']=$V_total;
                
             }//for Carreras
            
         }//For Semestre
        
        /******************************************************************************/
        $S_Costo  = array();
        
        for($s=1;$s<=12;$s++){
            
            $S_CostoSemestre  = 0;
            
            $S_Num            = 0;
            
             for($x=0;$x<count($C_Carrera);$x++){
                
                $Carrera_id       = $C_Carrera[$x]['codigocarrera'];
                
                //echo '<br><br>'.$S_Estudiante[$s][$Carrera_id]['num'];
                
                $S_CostoSemestre  = $S_CostoSemestre+$S_Estudiante[$s][$Carrera_id]['Total'];
                $S_Num            = $S_Num+$S_Estudiante[$s][$Carrera_id]['num'];
                
                $S_Costo[$s]['Valor'] = $S_CostoSemestre;
                $S_Costo[$s]['Num'] = $S_Num;
                
             }//for Carreras
            
         }//For Semestre
        
        /******************************************************************************/
    
        return $S_Costo;
        
  }//public function DesercionSemestreInstitucional
  public function DesercionSemestrePrograma($Periodo,$Carrera_id){
    global $db;
    
    $C_Periodo  = explode('-',$Periodo);
      
      //echo '<pre>';print_r($C_Carrera);
      
      $Periodo_1    = $C_Periodo[0];
      $Periodo_2    = $C_Periodo[1];
    
      $SQL='SELECT

            
            d.codigocarrera,
            de.codigoestudiante,
            MAX(e.semestre) as semestre

            
            FROM 
            
            desercion d INNER JOIN deserciondetalle dd ON d.id_desercion=dd.id_desercion
            						INNER JOIN desercionEstudiante de ON de.id_detalledesercion=dd.id_detalledesercion
            						INNER JOIN estudiante e ON e.codigoestudiante=de.codigoestudiante
            						
            WHERE
            
            d.tipodesercion=1
            AND
            d.codigoestado=100
            AND
            dd.desercionperiodo="'.$Periodo.'"
            AND
            d.codigocarrera="'.$Carrera_id.'"
            
            GROUP BY e.codigoestudiante';
            
            if($Data=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de la Data...<br><br>'.$SQL;
                die;
            }
                        
         $S_Cadena  = array();
            
         while(!$Data->EOF){
            
            $CodigoEstudiante    = $Data->fields['codigoestudiante'];
            
            $Semestre            = $Data->fields['semestre'];
            
            
                    switch($Semestre){
                        case '1':{
                            $S_Cadena[1][]    = $CodigoEstudiante;
                        }break;
                        case '2':{
                            $S_Cadena[2][]    = $CodigoEstudiante;
                        }break;
                        case '3':{
                            $S_Cadena[3][]    = $CodigoEstudiante;
                        }break;
                        case '4':{
                            $S_Cadena[4][]    = $CodigoEstudiante;
                        }break;
                        case '5':{
                            $S_Cadena[5][]    = $CodigoEstudiante;
                        }break;
                        case '6':{
                            $S_Cadena[6][]    = $CodigoEstudiante;
                        }break;
                        case '7':{
                            $S_Cadena[7][]    = $CodigoEstudiante;
                        }break;
                        case '8':{
                            $S_Cadena[8][]    = $CodigoEstudiante;
                        }break;
                        case '9':{
                            $S_Cadena[9][]    = $CodigoEstudiante;
                        }break;
                        case '10':{
                            $S_Cadena[10][]    = $CodigoEstudiante;
                        }break;
                        case '11':{
                            $S_Cadena[11][]    = $CodigoEstudiante;
                        }break;
                        case '12':{
                            $S_Cadena[12][]    = $CodigoEstudiante;
                        }break;
                    }//switch
            
            
            $Data->MoveNext();
         }//
         
         $S_Estudiante  = array();
         
         for($s=1;$s<=12;$s++){
            
             
                $ValorActual      = $this->CostoActual($Carrera_id);
                
                $N_EstudiantesSemestre = count($S_Cadena[$s]);
                
                $S_Estudiante[$s]['num']=$N_EstudiantesSemestre;
                $S_Estudiante[$s]['valor']=$ValorActual;
                
                $V_total   = $N_EstudiantesSemestre*$ValorActual;
                
                $S_Estudiante[$s]['Total']=$V_total;
                
            
         }//For Semestre
        
         return $S_Estudiante;  
    
  }//public function DesercionSemestrePrograma
  public function Reporte(){
    global $db;
    
    include ('Desercion_class.php');  $C_Desercion = new Desercion();
    
    $Periodo_Uno = $C_Desercion->Periodo('Todos');
    $C_Carrera   = $C_Desercion->Carreras();
     ?>
    <div id="container"> 
        <fieldset> 
        <legend>Reporte Demogr&aacute;fico</legend>
            <table>
                <thead>
                    <tr>
                        <th>Tipo Estudiantes</th>
                        <th>Periodo</th>
                        <th>Modalidad Acad&eacute;mica</th>
                        <th>Programa Acad&eacute;mico</th>
                    </tr>
                    <tr>
                        <th>
                            <select id="TypeEstudiante" name="TypeEstudiante" style="width: 100%;">
                                <option value="-1"></option>
                                <option value="0">Nuevos</option>
                                <option value="1">Antiguos</option>
                            </select>
                        </th>
                        <th>
                            <select id="PeriodoUno" name="PeriodoUno" style="width: 100%;">
                                <option value="-1"></option>
                                <?PHP 
                                for($i=0;$i<count($Periodo_Uno);$i++){
                                    ?>
                                    <option value="<?PHP echo $Periodo_Uno[$i]['codigoperiodo']?>"><?PHP echo $Periodo_Uno[$i]['codigoperiodo']?></option>
                                    <?PHP
                                }
                                ?>
                            </select>    
                        </th>
                        <th>
                            <select id="Modalida" name="Modalida" style="width: 100%;" onchange="BuscarProgramas()">
                                <option value="-1"></option>
                                <option value="200">Pregrado</option>
                                <option value="300">Posgrado</option>
                            </select>
                        </th>
                        <th>
                            <table border="0">
                                <tr>
                                    <td>
                                    <div id="Div_Modalidad">
                                        <select id="Carrera_id" name="Carrera_id" style="width:85%;">
                                             <option value="-1"></option>
                                        </select>
                                    </div>
                                    </td>
                                    <td><input type="checkbox" id="All_Carreras_id" onclick="Todas()" title="Todas las Carreras" /><strong>Todas</strong></td>
                                </tr>
                            </table>
                       </th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                    </tr>
                    <tr>
                        <th colspan="4">
                            <input type="button" value="Buscar" id="BuscarData" onclick="BuscarDataDemografica()" />
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">
                            <div id="Div_Carga" style="width: 100%;"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>
    <?PHP
  }//public function Reporte
  public function ReporteDemografico($Periodo,$Modalidad,$CodigoCarrera,$TypeEstudiante){
    global $db;
    
    include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
    include_once ('Desercion_class.php');  $C_Desercion = new Desercion();
    
    $datos_estadistica=new obtener_datos_matriculas($db,$Periodo);
    
    $Carrera   = $C_Desercion->Carreras('',$Modalidad);
    
    $C_Datos   = array();
    
    for($i=0;$i<count($Carrera);$i++){
        
        $Permiso = 0;
        
        if($CodigoCarrera==0){
           
            $Carrera_id     = $Carrera[$i]['codigocarrera'];
            
            if($TypeEstudiante==0){
            
            $Data  = $datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($Carrera_id,'arreglo');
                
            }else{
                
               $Data  = $datos_estadistica-> obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($Carrera_id,20,'arreglo');
                
            }
            
            
            $Permiso = 1;
            
        }else{
           
           $Carrera_id     = $Carrera[$i]['codigocarrera']; 
          
           if($CodigoCarrera==$Carrera_id){
           
           if($TypeEstudiante==0){
            
            $Data  = $datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($Carrera_id,'arreglo');
                
            }else{
                
                $Data  = $datos_estadistica-> obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($Carrera_id,20,'arreglo');
                
            }
            
            $Permiso = 1;
           } 
        }
        
       if($Permiso==1){
        
        for($j=0;$j<count($Data);$j++){
            
            $CodigoEstudiante  = $Data[$j]['codigoestudiante'];
            
              $SQL='SELECT 

                    eg.idestudiantegeneral,
                    DATE(eg.fechanacimientoestudiantegeneral) as Fecha,
                    eg.codigogenero,
                    eg.esextranjeroestudiantegeneral
                    
                    
                    FROM estudiantegeneral eg INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
                    
                    WHERE 
                    
                    e.codigoestudiante = "'.$CodigoEstudiante.'"';
                    
                if($DataEdad=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de la Edad....<br>'.$SQL;
                    die;
                }
                
                $arrayP = str_split($Periodo, strlen($Periodo)-1); 
                
                $YearActual  = $arrayP[0];
                
                $Fecha  = explode('-',$DataEdad->fields['Fecha']);   
                
                $Ano_Estuduiante = $Fecha[0];
                
                $Edad  = $YearActual-$Ano_Estuduiante;
                
                $idEstudiantegeneral   = $DataEdad->fields['idestudiantegeneral'];
                
                if($DataEdad->fields['codigogenero']==100){$Genero = 'F';}else{$Genero = 'M';}
                
                if($DataEdad->fields['esextranjeroestudiantegeneral']==0){//Nacional
                
                
                    $SQL_B='SELECT 
                                    idestudianteestudio,
                                    idestudiantegeneral 
                                    FROM 
                                    estudianteestudio 
                            WHERE 
                                    idniveleducacion = 2 
                                    AND 
                                    codigoestado = 100 
                                    AND 
                                    ciudadinstitucioneducativa LIKE "%BOGOTA%" 
                                    AND 
                                    idestudiantegeneral="'.$idEstudiantegeneral.'"';
                                    
                           if($Bogota=&$db->Execute($SQL_B)===false){
                                echo 'error en el SQL de Datos exitentyes para BOGOTA..<br><br>'.$SQL_B;
                                die;
                           }         
                    
                          if(!$Bogota->EOF){
                            
                              $Nacionalidad        = 'Bogota';
                              $CodigoNacionalidad  = '1';
                              
                          }else{
                            
                            $Nacionalidad        = 'Nacional';
                            $CodigoNacionalidad  = '2';
                            
                          }  
                    
                }else{// 1 Extranjero
                    
                    $Nacionalidad        = 'Extranjero';
                    $CodigoNacionalidad  = '3';
                    
                }
                /*********************************************************/
                
                $SQL_2='SELECT

                        DATE(h.fechaingresoestratohistorico) as fecha,
                        e.nombreestrato
                        
                        
                        FROM 
                        
                        estratohistorico h INNER JOIN estrato e ON e.idestrato=h.idestrato
                        
                        WHERE 
                        
                        h.idestudiantegeneral = "'.$idEstudiantegeneral.'"  AND h.codigoestado=100 AND e.codigoestado=100';
                        
                 if($DataEstrato=&$db->Execute($SQL_2)===false){
                    echo 'Error en el SQl De Estrato...<br><br>'.$SQL_2;
                    die;
                 }  
                 
                 $EstratoEstudiante  = $DataEstrato->fields['nombreestrato'];     
            
            $C_Datos[$Carrera_id][$j]['codigoestudiante']    = $CodigoEstudiante;
            $C_Datos[$Carrera_id][$j]['idEstudianteGeneral'] = $idEstudiantegeneral;
            $C_Datos[$Carrera_id][$j]['Edad']                = $Edad;
            $C_Datos[$Carrera_id][$j]['Estrato']             = $EstratoEstudiante;
            $C_Datos[$Carrera_id][$j]['Genero']              = $Genero;
            $C_Datos[$Carrera_id][$j]['Nacionalidad']        = $Nacionalidad;
            $C_Datos[$Carrera_id][$j]['CodigoNacionalidad']  = $CodigoNacionalidad;
            
        }//for data
        
       }//if
         //echo '<pre>';print_r($C_Datos);die;
    }//for Carrera
    //echo '<pre>';print_r($C_Datos);die;
    
    return $C_Datos;
  }//public function ReporteDemografico
  public function ModalidadDinamica($Modalidad){
    
    global $db;
    
    include_once ('Desercion_class.php');  $C_Desercion = new Desercion();
    
    $C_Carrera = $C_Desercion->Carreras('',$Modalidad);
    
    //echo '<pre>';print_r($C_Carrera);
    
    ?>
    <select id="Carrera_id" name="Carrera_id" style="width:85%;">
        <option value="-1"></option>
        <?PHP 
        for($i=0;$i<count($C_Carrera);$i++){
                ?>
                <option value="<?PHP echo $C_Carrera[$i]['codigocarrera']?>"><?PHP echo $C_Carrera[$i]['nombrecarrera']?></option>
                <?PHP 
            }//for
        ?>
    </select>
    <?PHP
  }//public function ModalidadDinamica
  public function TablaReporte($Periodo,$Modalidad,$CodigoCarrera,$TypeEstudiante){
    global $db;
    
    $Valores = $this->DemograficoDetalle($Periodo,$Modalidad,$CodigoCarrera,$TypeEstudiante);
    
    //echo '<pre>';print_r($Valores);die;
    
    $Porcentaje_Menor = (($Valores['Menor']*100)/$Valores['Total']);
    $Porcentaje_Media = (($Valores['Media']*100)/$Valores['Total']);
    $Porcentaje_Alta  = (($Valores['Alta']*100)/$Valores['Total']);
    $Porcentaje_Extra = (($Valores['Extra']*100)/$Valores['Total']);
    $Porcentaje_Extra_1 = (($Valores['Extra_1']*100)/$Valores['Total']);
    $Porcentaje_Extra_2 = (($Valores['Extra_2']*100)/$Valores['Total']);
    $Porcentaje_Extra_3 = (($Valores['Extra_3']*100)/$Valores['Total']);
    $Porcentaje_Extra_4 = (($Valores['Extra_4']*100)/$Valores['Total']);
    
    $Porcentaje_NoAplica = (($Valores['No_Aplica']*100)/$Valores['Total']);
    $Porcentaje_Uno      = (($Valores['Uno']*100)/$Valores['Total']);
    $Porcentaje_Dos      = (($Valores['Dos']*100)/$Valores['Total']);
    $Porcentaje_Tres     = (($Valores['Tres']*100)/$Valores['Total']);
    $Porcentaje_Cuatro   = (($Valores['Cuatro']*100)/$Valores['Total']);
    $Porcentaje_Cinco    = (($Valores['Cinco']*100)/$Valores['Total']);
    $Porcentaje_Seis     = (($Valores['Seis']*100)/$Valores['Total']);
    
    $Porcentaje_F     = (($Valores['F']*100)/$Valores['Total']);
    $Porcentaje_M     = (($Valores['M']*100)/$Valores['Total']);
    
    $Porcentaje_Bogota     = (($Valores['Bogota']*100)/$Valores['Total']);
    $Porcentaje_Nacional   = (($Valores['Nacional']*100)/$Valores['Total']);
    $Porcentaje_Extranjero = (($Valores['Extranjero']*100)/$Valores['Total']);
    ?>
    <legend>Edad</legend>
    <table border="1">
        <thead>
            <tr>
                <th>Periodo</th>
                <th> <=16 </th>
                <th>17 - 20</th>
                <th>21 - 25</th>
                <th>26 - 30</th>
                <th>31 - 35</th>
                <th>36 - 40</th>
                <th>41 - 45</th>
                <th> >=45  </th>
                <th rowspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><center><?PHP echo $Periodo?></center></td>
                <td><center><?PHP echo number_format($Porcentaje_Menor,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Media,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Alta,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Extra,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Extra_1,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Extra_2,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Extra_3,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Extra_4,'2','.','.')?>%</center></td>
                <td><img src="../img/column_chart.png" width="40" title="Ver Grafica Edad" style="cursor: pointer;" onclick="GraficaDemografica('0')" /></td>
            </tr>
        </tbody>
    </table>
    
    <br />
    <legend>Nivel SocioEcon&oacute;mico</legend>
    <table border="1">
        <thead>
            <tr>
                <th>Periodo</th>
                <th>1</a></th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>No Aplica</th>
                <th rowspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><center><?PHP echo $Periodo?></center></td>
                <td><center><?PHP echo number_format($Porcentaje_Uno,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Dos,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Tres,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Cuatro,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Cinco,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Seis,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_NoAplica,'2','.','.')?>%</center></td>
                <td><img src="../img/column_chart.png" width="40" title="Ver Grafica Nivel SocioEconomico" style="cursor: pointer;" onclick="GraficaDemografica('1')" /></td>
            </tr>
        </tbody>
    </table>
    <br />
    <legend>G&eacute;nero</legend>
    <table border="1">
        <thead>
            <tr>
                <th>Periodo</th>
                <th>Femenino</a></th>
                <th>Masculino</th>
                <th rowspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><center><?PHP echo $Periodo?></center></td>
                <td><center><?PHP echo number_format($Porcentaje_F,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_M,'2','.','.')?>%</center></td>
                <td><img src="../img/column_chart.png" width="40" title="Ver Grafica Genero" style="cursor: pointer;" onclick="GraficaDemografica('2')" /></td>
            </tr>
        </tbody>
    </table>
    <br />
    <legend>Procedencia</legend>
    <table border="1">
        <thead>
            <tr>
                <th>Periodo</th>
                <th>Bogot&aacute;</a></th>
                <th>Nacional</th>
                <th>Extranjero</th>
                <th rowspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><center><?PHP echo $Periodo?></center></td>
                <td><center><?PHP echo number_format($Porcentaje_Bogota,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Nacional,'2','.','.')?>%</center></td>
                <td><center><?PHP echo number_format($Porcentaje_Extranjero,'2','.','.')?>%</center></td>
                <td><img src="../img/column_chart.png" width="40" title="Ver Grafica Procedencia" style="cursor: pointer;" onclick="GraficaDemografica('3')" /></td>
            </tr>
        </tbody>
    </table>
    <?PHP
  }//public function TablaReporte
  public function DemograficoDetalle($Periodo,$Modalidad,$CodigoCarrera,$TypeEstudiante){
    global $db;
    
    
    include_once ('Desercion_class.php');  $C_Desercion = new Desercion();
    
    $C_Data  = $this->ReporteDemografico($Periodo,$Modalidad,$CodigoCarrera,$TypeEstudiante);
    
    //echo '<pre>';print_r($C_Data);
    
    $C_Carrera = $C_Desercion->Carreras('',$Modalidad);
    
    $C_Edad = array();
    
    $Valores = array();
    
    $S_Total   = 0;
    $S_Menor   = 0;
    $S_Media   = 0;
    $S_Alta    = 0;
    $S_Extra   = 0;
    $S_Extra_1   = 0;
    $S_Extra_2   = 0;
    $S_Extra_3   = 0;
    $S_Extra_4   = 0;
    
    $S_NoAplica  = 0;
    $S_Uno       = 0;
    $S_Dos       = 0;
    $S_Tres      = 0;
    $S_Cuatro    = 0;
    $S_Cinco     = 0;
    $S_Seis      = 0;
    
    $S_F    = 0;
    $S_M    = 0;
    
    $S_Bogota      = 0;
    $S_Nacional    = 0;
    $S_Extranjero  = 0;
    
    for($i=0;$i<count($C_Carrera);$i++){
        
        $Permiso = 0;
        
        if($CodigoCarrera==0){
            
            $Carrera_id  = $C_Carrera[$i]['codigocarrera'];
            
            $Permiso = 1;
        }else{
            
            $Carrera_id  = $C_Carrera[$i]['codigocarrera'];
            
            $Permiso = 1;
        }
        
        if($Permiso==1){
            
            $Menor = 0;
            $Media = 0;
            $Alta  = 0;
            $Extra = 0;
            $Extra_1   = 0;
            $Extra_2   = 0;
            $Extra_3   = 0;
            $Extra_4   = 0;
            /**********/
            $No_Aplica = 0;
            $Uno       = 0;
            $Dos       = 0;
            $Tres      = 0;
            $Cuatro    = 0;
            $Cinco     = 0;
            $Seis      = 0;
            /**************/
            $F  = 0;
            $M  = 0;
            /**********/
            $Nacional    = 0;
            $Extranjero  = 0;
            $Bogota      = 0;
            /***************/            
            
            for($j=0;$j<count($C_Data[$Carrera_id]);$j++){
                /*******************************************************Edad***************************************************************/
                if($C_Data[$Carrera_id][$j]['Edad']<=16){
                    
                    $Menor++;
                    
                    $C_Edad['Menor'][$Carrera_id][$Menor]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                    $C_Edad['Menor'][$Carrera_id][$Menor]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                    $C_Edad['Menor'][$Carrera_id][$Menor]['Edad']=$C_Data[$Carrera_id][$j]['Edad'];
                    
                }//if
                
                if($C_Data[$Carrera_id][$j]['Edad']>=17 && $C_Data[$Carrera_id][$j]['Edad']<=20){
                   
                    $Media++;
                                           
                    $C_Edad['Media'][$Carrera_id][$Media]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                    $C_Edad['Media'][$Carrera_id][$Media]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                    $C_Edad['Media'][$Carrera_id][$Media]['Edad']=$C_Data[$Carrera_id][$j]['Edad'];
                    
                }//if
                
                if($C_Data[$Carrera_id][$j]['Edad']>=21 && $C_Data[$Carrera_id][$j]['Edad']<=25){
                   
                    $Alta++;
                                           
                    $C_Edad['Alta'][$Carrera_id][$Alta]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                    $C_Edad['Alta'][$Carrera_id][$Alta]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                    $C_Edad['Alta'][$Carrera_id][$Alta]['Edad']=$C_Data[$Carrera_id][$j]['Edad'];
                    
                }//if
                
                if($C_Data[$Carrera_id][$j]['Edad']>=26 && $C_Data[$Carrera_id][$j]['Edad']<=30){
                   
                    $Extra++;
                                           
                    $C_Edad['Extra'][$Carrera_id][$Extra]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                    $C_Edad['Extra'][$Carrera_id][$Extra]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                    $C_Edad['Extra'][$Carrera_id][$Extra]['Edad']=$C_Data[$Carrera_id][$j]['Edad'];
                    
                }//if
                
                if($C_Data[$Carrera_id][$j]['Edad']>=21 && $C_Data[$Carrera_id][$j]['Edad']<=35){
                   
                    $Extra_1++;
                                           
                    $C_Edad['Extra_1'][$Carrera_id][$Extra_1]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                    $C_Edad['Extra_1'][$Carrera_id][$Extra_1]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                    $C_Edad['Extra_1'][$Carrera_id][$Extra_1]['Edad']=$C_Data[$Carrera_id][$j]['Edad'];
                    
                }//if
                
                if($C_Data[$Carrera_id][$j]['Edad']>=36 && $C_Data[$Carrera_id][$j]['Edad']<=40){
                   
                    $Extra_2++;
                                           
                    $C_Edad['Extra_2'][$Carrera_id][$Extra_2]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                    $C_Edad['Extra_2'][$Carrera_id][$Extra_2]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                    $C_Edad['Extra_2'][$Carrera_id][$Extra_2]['Edad']=$C_Data[$Carrera_id][$j]['Edad'];
                    
                }//if
                
                if($C_Data[$Carrera_id][$j]['Edad']>=41 && $C_Data[$Carrera_id][$j]['Edad']<=45){
                   
                    $Extra_3++;
                                           
                    $C_Edad['Extra_3'][$Carrera_id][$Extra_3]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                    $C_Edad['Extra_3'][$Carrera_id][$Extra_3]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                    $C_Edad['Extra_3'][$Carrera_id][$Extra_3]['Edad']=$C_Data[$Carrera_id][$j]['Edad'];
                    
                }//if
                
                if($C_Data[$Carrera_id][$j]['Edad']>=45){
                   
                    $Extra_4++;
                                           
                    $C_Edad['Extra_4'][$Carrera_id][$Extra_4]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                    $C_Edad['Extra_4'][$Carrera_id][$Extra_4]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                    $C_Edad['Extra_4'][$Carrera_id][$Extra_4]['Edad']=$C_Data[$Carrera_id][$j]['Edad'];
                    
                }//if
                /**************************************************************************************************************************/
                /**********************************************Nivel Socio Economico*******************************************************/
                switch($C_Data[$Carrera_id][$j]['Estrato']){
                    case 'No Aplica':{
                        
                        $No_Aplica++;
                        
                        $C_Edad['NO_Aplica'][$Carrera_id][$No_Aplica]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['NO_Aplica'][$Carrera_id][$No_Aplica]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['NO_Aplica'][$Carrera_id][$No_Aplica]['Estrato']=$C_Data[$Carrera_id][$j]['Estrato'];
                        
                    }break;
                    case '1':{
                        
                        $Uno++;
                        
                        $C_Edad['Uno'][$Carrera_id][$Uno]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['Uno'][$Carrera_id][$Uno]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['Uno'][$Carrera_id][$Uno]['Estrato']=$C_Data[$Carrera_id][$j]['Estrato'];
                        
                    }break;
                    case '2':{
                        
                        $Dos++;
                        
                        $C_Edad['Dos'][$Carrera_id][$Dos]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['Dos'][$Carrera_id][$Dos]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['Dos'][$Carrera_id][$Dos]['Estrato']=$C_Data[$Carrera_id][$j]['Estrato'];
                        
                    }break;
                    case '3':{
                        
                        $Tres++;
                        
                        $C_Edad['Tres'][$Carrera_id][$Tres]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['Tres'][$Carrera_id][$Tres]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['Tres'][$Carrera_id][$Tres]['Estrato']=$C_Data[$Carrera_id][$j]['Estrato'];
                        
                    }break;
                    case '4':{
                        
                        $Cuatro++;
                        
                        $C_Edad['Cuatro'][$Carrera_id][$Cuatro]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['Cuatro'][$Carrera_id][$Cuatro]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['Cuatro'][$Carrera_id][$Cuatro]['Estrato']=$C_Data[$Carrera_id][$j]['Estrato'];
                        
                    }break;
                    case '5':{
                        
                        $Cinco++;
                        
                        $C_Edad['Cinco'][$Carrera_id][$Cinco]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['Cinco'][$Carrera_id][$Cinco]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['Cinco'][$Carrera_id][$Cinco]['Estrato']=$C_Data[$Carrera_id][$j]['Estrato'];
                        
                    }break;
                    case '6':{
                        
                        $Seis++;
                        
                        $C_Edad['Seis'][$Carrera_id][$Seis]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['Seis'][$Carrera_id][$Seis]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['Seis'][$Carrera_id][$Seis]['Estrato']=$C_Data[$Carrera_id][$j]['Estrato'];
                        
                    }break;
                }
                /**************************************************************************************************************************/
                /*****************************************************Genro****************************************************************/
                switch($C_Data[$Carrera_id][$j]['Genero']){
                    case 'F':{
                        
                        $F++;
                        
                        $C_Edad['F'][$Carrera_id][$F]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['F'][$Carrera_id][$F]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['F'][$Carrera_id][$F]['Genero']=$C_Data[$Carrera_id][$j]['Genero'];
                        
                    }break;
                    case 'M':{
                        
                        $M++;
                        
                        $C_Edad['M'][$Carrera_id][$M]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['M'][$Carrera_id][$M]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['M'][$Carrera_id][$M]['Genero']=$C_Data[$Carrera_id][$j]['Genero'];
                        
                    }break;
                }
                /**************************************************************************************************************************/
                /************************************************Procedencia***************************************************************/
                switch($C_Data[$Carrera_id][$j]['CodigoNacionalidad']){
                    case '1':{
                        
                        $Bogota++;
                        
                        $C_Edad['Bogota'][$Carrera_id][$Bogota]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['Bogota'][$Carrera_id][$Bogota]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['Bogota'][$Carrera_id][$Bogota]['CodigoNacionalidad']=$C_Data[$Carrera_id][$j]['CodigoNacionalidad'];
                        
                    }break;
                    case '2':{
                        
                        $Nacional++;
                        
                        $C_Edad['Nacional'][$Carrera_id][$Nacional]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['Nacional'][$Carrera_id][$Nacional]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['Nacional'][$Carrera_id][$Nacional]['CodigoNacionalidad']=$C_Data[$Carrera_id][$j]['CodigoNacionalidad'];
                        
                    }break;
                    case '3':{
                        
                        $Extranjero++;
                        
                        $C_Edad['Extranjero'][$Carrera_id][$Extranjero]['codigoestudiante']=$C_Data[$Carrera_id][$j]['codigoestudiante'];
                        $C_Edad['Extranjero'][$Carrera_id][$Extranjero]['idEstudianteGeneral']=$C_Data[$Carrera_id][$j]['idEstudianteGeneral'];
                        $C_Edad['Extranjero'][$Carrera_id][$Extranjero]['CodigoNacionalidad']=$C_Data[$Carrera_id][$j]['CodigoNacionalidad'];
                        
                    }break;
                }
                /**************************************************************************************************************************/
                
                
                
                
            }//for C_Data
            
            
             $S_Total  = $S_Total+count($C_Data[$Carrera_id]);
            
             $S_Menor  = $S_Menor+count($C_Edad['Menor'][$Carrera_id]);
             $S_Media  = $S_Media+count($C_Edad['Media'][$Carrera_id]);
             $S_Alta   = $S_Alta+count($C_Edad['Alta'][$Carrera_id]);
             $S_Extra  = $S_Extra+count($C_Edad['Extra'][$Carrera_id]);
             $S_Extra_1  = $S_Extra_1+count($C_Edad['Extra_1'][$Carrera_id]);
             $S_Extra_2  = $S_Extra_2+count($C_Edad['Extra_2'][$Carrera_id]);
             $S_Extra_3  = $S_Extra_3+count($C_Edad['Extra_3'][$Carrera_id]);
             $S_Extra_4  = $S_Extra_4+count($C_Edad['Extra_4'][$Carrera_id]);
             
             $S_NoAplica = $S_NoAplica+count($C_Edad['NO_Aplica'][$Carrera_id]);
             $S_Uno      = $S_Uno+count($C_Edad['Uno'][$Carrera_id]);
             $S_Dos      = $S_Dos+count($C_Edad['Dos'][$Carrera_id]);
             $S_Tres     = $S_Tres+count($C_Edad['Tres'][$Carrera_id]);
             $S_Cuatro   = $S_Cuatro+count($C_Edad['Cuatro'][$Carrera_id]);
             $S_Cinco    = $S_Cinco+count($C_Edad['Cinco'][$Carrera_id]);
             $S_Seis     = $S_Seis+count($C_Edad['Seis'][$Carrera_id]);
             
             $S_F   = $S_F+count($C_Edad['F'][$Carrera_id]);
             $S_M   = $S_M+count($C_Edad['M'][$Carrera_id]);
             
             $S_Bogota     = $S_Bogota+count($C_Edad['Bogota'][$Carrera_id]);
             $S_Nacional   = $S_Nacional+count($C_Edad['Nacional'][$Carrera_id]);
             $S_Extranjero = $S_Extranjero+count($C_Edad['Extranjero'][$Carrera_id]);
             
        }//if $Permiso
        
    }//for Carrera
    
    $Valores['Total']     = $S_Total;
    $Valores['Menor']     = $S_Menor;
    $Valores['Media']     = $S_Media;
    $Valores['Alta']      = $S_Alta;
    $Valores['Extra']     = $S_Extra;
    $Valores['Extra_1']     = $S_Extra_1;
    $Valores['Extra_2']     = $S_Extra_2;
    $Valores['Extra_3']     = $S_Extra_3;
    $Valores['Extra_4']     = $S_Extra_4;
    
    $Valores['No_Aplica'] = $S_NoAplica;
    $Valores['Uno']       = $S_Uno;
    $Valores['Dos']       = $S_Dos;
    $Valores['Tres']      = $S_Tres;
    $Valores['Cuatro']    = $S_Cuatro;
    $Valores['Cinco']     = $S_Cinco; 
    $Valores['Seis']      = $S_Seis;
    $Valores['F']         = $S_F;
    $Valores['M']         = $S_M;
    $Valores['Bogota']    = $S_Bogota;
    $Valores['Nacional']  = $S_Nacional;
    $Valores['Extranjero']= $S_Extranjero;
    
    return $Valores;
  }//public function DemograficoDetalle
public function Consola(){
    global $db;
    
    include_once ('Desercion_class.php');  $C_Desercion = new Desercion();
    
    $C_Carrera = $C_Desercion->Carreras('','');
    
    ?>
    <div id="container">
            <fieldset >
                <legend>Costos de Deserci&oacute;n </legend>
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center">
                    <thead>
                        <tr>
                            <th class="titulo_label">Tipo de Gr&aacute;fica</th>
                            <th>
                                <select id="TypeGrafica" name="TypeGrafica" style="width: auto;" onchange="VerText();Condicon()">
                                    <option value="-1"></option>
                                    <option value="0">Costo de deserci&oacute;n Institucional  por periodo</option>
                                    <option value="1">Costo de deserci&oacute;n por periodo  y participaci&oacute;n costo de deserci&oacute;n por semestre</option>
                                    <option value="2">Costo de deserci&oacute;n por programa</option>
                                    <option value="3">Costo de deserci&oacute;n Programa espec&iacute;fico</option>
                                    <option value="4">Detallado Costo de deserci&oacute;n Universidad El Bosque </option>
                                </select>
                            </th>
                            <th>&nbsp;</th>
                            <th class="titulo_label">Periodo</th>
                            <th>
                                <select id="Periodo" name="Periodo" style="width: 100%;text-align: center;" >
                                    <option value="-1"></option>
                                    <?PHP 
                                    $C_Periodo=$C_Desercion->Periodo('Todos','','');
                                    
                                    for($i=0;$i<count($C_Periodo);$i++){
                                        ?>
                                        <option value="<?PHP echo $C_Periodo[$i]['codigoperiodo']?>"><?PHP echo $C_Periodo[$i]['codigoperiodo']?></option>
                                        <?PHP
                                    }//for
                                    ?>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center">&nbsp;</th>
                        </tr>
                        <tr>
                            <th aling="center">Programa Acad&eacute;mico</th>
                            <th colspan="2">
                                <select id="Programa_id" name="Programa_id" style="width: 100%;">
                                    <option value="-1"></option>
                                    <?PHP 
                                    for($c=0;$c<count($C_Carrera);$c++){
                                        ?>
                                        <option value="<?PHP echo $C_Carrera[$c]['codigocarrera']?>"><?PHP echo $C_Carrera[$c]['nombrecarrera']?></option>
                                        <?PHP
                                    }
                                    ?>
                                </select>
                            </th>
                            <th colspan="2">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center">&nbsp;</th>
                        </tr>
                        <tr id="Tr_Text" style="visibility: collapse;">
                            <th colspan="5" aling="center" id="Th_Text"></th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center"><button class="submit" type="button" tabindex="3" onclick="CargarGraficCosto()">Buscar</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" aling="center">
                                <hr style="width:95%;margin-left: 2.5%;" aling="center" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <!--<a onclick="VerTabla()" title="Ver Tabla Informativa" style="cursor: pointer;" >Ver Tabla</a>-->
                            </td>
                            <td>&nbsp;</td>
                            <td aling="right">
                                <a onclick="VerGlosario()" title="Ver Glosario" style="cursor: pointer;" >Glosario</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" aling="center">
                                  
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <div id="Rerporte" style="width: 100%;margin-left: 2.5%;height:auto; text-align: center;"  ></div>
                <input type="hidden" id="Cadena" />
            </fieldset>
            
                
    </div>
     <?PHP
}//public function Consola
  public function Glosario(){
    global $db;
    
    ?>
    <fieldset>
        <legend>Glosario</legend>
        <br />
        <ul>
            <li>Deserci&oacute;n por periodo: Cantidad de estudiantes que estando matriculados en el periodo T, se convirtieron en desertores en T+2.</li>
            <li>Valor Real: Es el costo de la deserci&oacute;n calculado en un periodo t ( con los valores asignados para el periodo t).</li>
            <li>Valor Presente: Es el costo de la deserci&oacute;n calculado  a los valores actuales.</li>
        </ul>
    </fieldset>
    <?PHP
  }/*Glosario*/
}//class DesercionCostos

?>