<?php
class DesercionSemestre{
    
    public function DesercionSemestreArreglo($Carrera_id){
        global $db;
        
        include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
        
        $datos_estadistica=new obtener_datos_matriculas($db,'20131');
        
        //echo '<br>Carrera->'.$Carrera_id;
        
        $DesercionDato=$datos_estadistica->obtener_datos_estudiantes_desercion($Carrera_id,'arreglo');
        
        //echo '<pre>';print_r($DesercionDato);
        
        for($j=0;$j<count($DesercionDato);$j++){
            
           $CodigoEstudiante     = $DesercionDato[$j]['codigoestudiante']; 
           $Semestre             = $DesercionDato[$j]['semestre'];  
            
            
           switch($Semestre){
                case '1':{
                    $E_Data[$Carrera_id][1][]    = $CodigoEstudiante;
                }break;
                case '2':{
                    $E_Data[$Carrera_id][2][]    = $CodigoEstudiante;
                }break;
                case '3':{
                    $E_Data[$Carrera_id][3][]    = $CodigoEstudiante;
                }break;
                case '4':{
                    $E_Data[$Carrera_id][4][]    = $CodigoEstudiante;
                }break;
                case '5':{
                    $E_Data[$Carrera_id][5][]    = $CodigoEstudiante;
                }break;
                case '6':{
                    $E_Data[$Carrera_id][6][]    = $CodigoEstudiante;
                }break;
                case '7':{
                    $E_Data[$Carrera_id][7][]    = $CodigoEstudiante;
                }break;
                case '8':{
                    $E_Data[$Carrera_id][8][]    = $CodigoEstudiante;
                }break;
                case '9':{
                    $E_Data[$Carrera_id][9][]    = $CodigoEstudiante;
                }break;
                case '10':{
                    $E_Data[$Carrera_id][10][]    = $CodigoEstudiante;
                }break;
                case '11':{
                    $E_Data[$Carrera_id][11][]    = $CodigoEstudiante;
                }break;
                case '12':{
                    $E_Data[$Carrera_id][12][]    = $CodigoEstudiante;
                }break;
            }//switch 
            
        }//Arreglo
        
        //echo '<pre>';print_r($E_Data); 
        
        return $E_Data;
        
    }/*public function DesercionSemestre*/
    public function Rerporte(){
        global $db;
        
        include_once ('Desercion_class.php');  $C_Desercion = new Desercion();
        
        $Lita_C = $C_Desercion->Carreras();
        
        //echo '<pre>';print_r($Lita_C);  die; 
             ?>
            <table border="1" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Programa Academico</th>
                        <th>I</th>
                        <th>II</th>
                        <th>III</th>
                        <th>IV</th>
                        <th>V</th>
                        <th>VI</th>
                        <th>VII</th>
                        <th>VIII</th>
                        <th>IX</th>
                        <th>X</th>
                        <th>XI</th>
                        <th>XII</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                <?PHP 
                for($i=0;$i<count($Lita_C);$i++){
            
                    $Data = $this->DesercionSemestreArreglo($Lita_C[$i]['codigocarrera']); 
                    
                    for($j=1;$j<=12;$j++){
                        
                         
                        
                         switch($j){
                            case '1':{
                                $Semestre_1    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '2':{
                                $Semestre_2    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '3':{
                                $Semestre_3    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '4':{
                                $Semestre_4    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '5':{
                                $Semestre_5    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '6':{
                                $Semestre_6    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '7':{
                                $Semestre_7    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '8':{
                                $Semestre_8    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '9':{
                                $Semestre_9    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '10':{
                                $Semestre_10    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '11':{
                                $Semestre_11    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                            case '12':{
                                $Semestre_12    = count($Data[$Lita_C[$i]['codigocarrera']][$j]); 
                            }break;
                        }//switch 
                        
                    }//Data
                    
                    $Total = $Semestre_1+$Semestre_2+$Semestre_3+$Semestre_4+$Semestre_5+$Semestre_6+$Semestre_7+$Semestre_8+$Semestre_9+$Semestre_10+$Semestre_11+$Semestre_12;
                    
                    ?>
                    <tr>
                        <td><?PHP echo $Lita_C[$i]['nombrecarrera']?></td>
                        <td><center><?PHP echo $Semestre_1?></center></td>
                        <td><center><?PHP echo $Semestre_2?></td>
                        <td><center><?PHP echo $Semestre_3?></td>
                        <td><center><?PHP echo $Semestre_4?></td>
                        <td><center><?PHP echo $Semestre_5?></td>
                        <td><center><?PHP echo $Semestre_6?></td>
                        <td><center><?PHP echo $Semestre_7?></td>
                        <td><center><?PHP echo $Semestre_8?></td>
                        <td><center><?PHP echo $Semestre_9?></td>
                        <td><center><?PHP echo $Semestre_10?></td>
                        <td><center><?PHP echo $Semestre_11?></td>
                        <td><center><?PHP echo $Semestre_12?></td>
                        <td><center><?PHP echo $Total?></center></td>
                    </tr>
                    <?PHP
                }//Carreraas
                ?> 
                <tr>
                    <td colspan="14"><input type="button" value="Excel" onclick="GenerarExcel()" /></td>
                </tr>   
                </tbody>
            </table>
            <?PHP
    }/*public function Rerporte*/
    
}//Class DesercionSemestre

?>