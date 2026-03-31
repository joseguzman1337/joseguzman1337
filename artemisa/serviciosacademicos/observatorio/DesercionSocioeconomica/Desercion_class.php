<?php

class Desercion{
    public function DesercionSemestral($CodigoPeriodo,$Opcion,$Separador='',$CodigoCarrera=''){
        global $db;

        //$CodigoPeriodo	='20081';
       
        include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
       	
        $Periodo_Actual=$this->Periodo('Actual','','');
        
        $C_Periodo  = $this->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
       // echo '<pre>';print_r($C_Periodo);
        $Num_P  = count($C_Periodo);
              
         $Datos = array();
         $Total = array();
       
         for($j=0;$j<$Num_P;$j++){
                //echo '<br>->J->'.$j;
               /*****************************************************************************/ 
                //echo '<br>�periodo->'.$C_Periodo[$j]['codigoperiodo'];
                
                //$Datos[$j]['Periodo']=$C_Periodo[$j]['codigoperiodo'];
                
                $datos_estadistica=new obtener_datos_matriculas($db,$C_Periodo[$j]['codigoperiodo']);
                /************************************************************************/
                $Lita_C = $this->Carreras();
                if($CodigoCarrera){
                    $Num_Lista = 1;
                }else{
                
                //echo '<pre>';print_r($Lita_C);
                $Num_Lista  = count($Lita_C);
                }
                $Suma_Matriculados=0;
                $Suma_Desercion=0;
                
                
                
                for($i=0;$i<$Num_Lista;$i++){//fin
                    /**********************************/
                   
                       
                    //if($TotalMatriculados!=0){
                       /********************************************************************************/
                        if($CodigoCarrera){
                            
                        $D_Carrera  = $CodigoCarrera;
                            
                        $DesercionDato=$datos_estadistica->obtener_datos_estudiantes_desercion($D_Carrera,'conteo');
                        
                        
                        }else{
                       
                        $D_Carrera    = $Lita_C[$i]['codigocarrera'];
                    
                        $DesercionDato=$datos_estadistica->obtener_datos_estudiantes_desercion($D_Carrera,'conteo');
                        
                        }
                        
                        
                        
                        $TotalMatriculados = $datos_estadistica->obtener_total_matriculados($D_Carrera,'conteo');
                        
                        $PorcentajeDesercion = (($DesercionDato/$TotalMatriculados)*100);
                        
                        $Suma_Matriculados  = $Suma_Matriculados+$TotalMatriculados;
                        
                        $Suma_Desercion     = $Suma_Desercion+$DesercionDato;
                                      
                        $Datos[$i][$D_Carrera][$j]['Periodo']=$C_Periodo[$j]['codigoperiodo'];
                        $Datos[$i][$D_Carrera][$j]['Carrera']=$Lita_C[$i]['nombrecarrera'];
                        $Datos[$i][$D_Carrera][$j]['TotalMatriculados']=$TotalMatriculados;
                        $Datos[$i][$D_Carrera][$j]['Desercion']=$DesercionDato;
                        if($Separador==1){
                            $Datos[$i][$D_Carrera][$j]['PorcentajeDesercion']=number_format($PorcentajeDesercion,'2',',','.');
                        }else{
                        $Datos[$i][$D_Carrera][$j]['PorcentajeDesercion']=number_format($PorcentajeDesercion,'2','.',',');
                        }
                       /********************************************************************************/ 
                   // }
                    
                }//for
                /************************************************************************/
               /*****************************************************************************/ 
               $Total[$j]['Periodo']=$C_Periodo[$j]['codigoperiodo'];
               $Total[$j]['Total_M']=$Suma_Matriculados;
               $Total[$j]['Total_D']=$Suma_Desercion;
               //$Total[$j]['Nom_Carrera']=$Lita_C[$i]['nombrecarrera'];
            }//for
        
        //echo '<pre>';print_r($Total);
        
        //$DesercionDato=$datos_estadistica->obtener_datos_estudiantes_desercion('5','conteo');
        
        //echo '<pre>';print_r($DesercionDato); 
        
        //$DesercionArray=$datos_estadistica->obtener_datos_estudiantes_desercion('5','arreglo');
        
        //echo '<pre>';print_r($Datos);
        
        if($Opcion=='Programas'){
            return $Datos;    
        }else if($Opcion=='Institucional'){
            return $Total;
        }
        
    }//public function DesercionSemestral
 public function DesercionAnual($CodigoPeriodo){
    /********************************************************/
    global $db;
    
    //$CodigoPeriodo  = '20082';
    
    include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
    
    $Periodo_Actual = $this->Periodo('Actual','','');

    $C_Periodos     = $this->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
    
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
    
    //echo '<pre>',print_r($P_Anual);
    //echo '<br>xxx->'.count($P_Anual['Anual']);
    
    $C_Datos    = array();
    $R_Datos    = array();
    /********************************************************************/
    $L_Carrera = $this->Carreras(); //echo '<pre>';print_r($L_Carrera);
    
    for($Q=0;$Q<count($L_Carrera);$Q++){
        /****************************************************************/
        for($l=0;$l<count($P_Anual['Anual']);$l++){//for
            /************************************************************/
             $C_Anual    = explode('-',$P_Anual['Anual'][$l]);
             
             if($C_Anual[0] && $C_Anual[1]){//if
                /*********************************************************/
                  $datos_estadistica_Uno = new obtener_datos_matriculas($db,$C_Anual[0]);
          
                  $datos_estadistica_Dos = new obtener_datos_matriculas($db,$C_Anual[1]);
                
                  $U_DesercionDato       = $datos_estadistica_Uno->obtener_datos_estudiantes_desercion($L_Carrera[$Q]['codigocarrera'],'arreglo');
                  
                  $T_DesercionDato       = $datos_estadistica_Dos->obtener_datos_estudiantes_desercion($L_Carrera[$Q]['codigocarrera'],'arreglo');
          
                  $U_Matriculados        = $datos_estadistica_Uno->obtener_total_matriculados($L_Carrera[$Q]['codigocarrera'],'arreglo');
                  
                  $T_Matriculados        = $datos_estadistica_Dos->obtener_total_matriculados($L_Carrera[$Q]['codigocarrera'],'arreglo');
                    
                  /*******************************************/
                  $D_PeriodoUno=count($U_DesercionDato);
                  $D_PeriodoDos=count($T_DesercionDato);
                  //echo '<pre>';print_r($U_DesercionDato);
                  $Matriculados_uno=count($U_Matriculados);
                  $Matriculados_Dos=count($T_Matriculados);
                  
                  $C_Existe = array();
                  
                  for($D=0;$D<count($T_Matriculados);$D++){//for
                    /*****************************************************/
                     for($U=0;$U<count($U_DesercionDato);$U++){
                        /*************************************/
                            //echo '<br>'.$U_DesercionDato[$U]['codigoestudiante'].'=='.$T_Matriculados[$D]['codigoestudiante'];
                            if($U_DesercionDato[$U]['codigoestudiante']==$T_Matriculados[$D]['codigoestudiante']){
                                /*******************************************/
                                    $C_Existe['Retomaron'][]=$T_Matriculados[$D]['codigoestudiante'];
                                /*******************************************/
                            }//if   
                        /*************************************/
                     }//for $U_DesercionDato
                    /*****************************************************/
                  }//for $T_Matriculados
                /*********************************************************/
                $R_Matriculados  = count($C_Existe['Retomaron']);
                   
                $Valor_final     = (($D_PeriodoUno-$R_Matriculados)/($Matriculados_uno+$Matriculados_Dos));
                
                $R_Datos['periodos']           = $P_Anual['Anual'][$l];
                $R_Datos['Total_Matriculados'] = $Matriculados_uno+$Matriculados_Dos;
                $R_Datos['Desercion_Anual']    = (($D_PeriodoUno+$D_PeriodoDos)-$R_Matriculados);
                $R_Datos['Porcentaje_Anual']   = number_format($Valor_final,'2',',','.');
                /*********************************************************/
                $C_Datos[$L_Carrera[$Q]['codigocarrera']][] = $R_Datos;
                /*********************************************************/
             }//if
            /************************************************************/
        }//for
       /*****************************************************************/ 
    }//for
    /********************************************************************/
    
    /*echo '<pre>';print_r($C_Datos);
    echo 'num->'.count($C_Datos);*/
    
    return $C_Datos;
 }//public function DesercionAnual   
 public function Carreras($codigoCarrera=''){
    global $db;
    
    if($codigoCarrera){
        $Condicion=' AND codigocarrera="'.$codigoCarrera.'"';
    }else{
        $Condicion='';
    }
    
      $SQL='SELECT 

            codigocarrera,
            nombrecarrera
            
            FROM 
            
            carrera
            
            WHERE
            
            codigomodalidadacademicasic=200
            AND
            codigocarrera NOT IN (354,6,428,7,120,600,605)
            '.$Condicion.'            
            
            ORDER BY nombrecarrera ASC;';
            
       if($Carreras=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de las Carreras...<br><br>'.$SQL;
            die;
        }     
            
        $C_Carrera  = $Carreras->GetArray();    
        
       return $C_Carrera;
    
 }// Public function Carreras   
 public function Periodo($Opcion,$Periodo_ini='',$Periodo_fin=''){
    global  $db;
    
    if($Opcion=='Actual'){
        $Condicion ='WHERE  codigoestadoperiodo=1';
    }else if($Opcion=='Cadena'){
        
        $Condicion ='WHERE  codigoperiodo BETWEEN "'.$Periodo_ini.'" AND "'.$Periodo_fin.'"';
    }else if($Opcion=='Todos'){
        
        $Condicion ='ORDER BY codigoperiodo DESC';//codigoestadoperiodo, 
    }
    
      $SQL='SELECT 

            codigoperiodo,
            codigoestadoperiodo
            
            FROM 
            
            periodo
            
            '.$Condicion;
            
        if($Periodo=&$db->Execute($SQL)===false){
            echo 'Error en Calcular el Periodo...<br><br>'.$SQL;
            die;
        } 
        
       if($Opcion=='Actual'){
            return $Periodo->fields['codigoperiodo'];
       }else if($Opcion=='Cadena' || $Opcion=='Todos'){
        
            $C_Periodo  = $Periodo->GetArray();
            
            return $C_Periodo;
       }    
 }//public function Periodo
 public function Display($CodigoPeriodo){ 
    global $db;
    
    //$CodigoPeriodo	='20081';
    
    $Periodo_Actual=$this->Periodo('Actual','','');
        
    $C_Periodo  = $this->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
    
    $P_num= count($C_Periodo);
    
    $P_num  = $P_num-1;
    
    
    
    //echo '<pre>';print_r($C_Periodo);echo 'num->'.$P_num;die;
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
    <!--<style type="text/css" title="currentStyle">
                @import "../../../observatorio/data/media/css/demo_page.css";
                @import "../../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../../observatorio/data/media/css/ColVis.css";
                @import "../../../observatorio/data/media/css/TableTools.css";
                @import "../../../observatorio/data/media/css/ColReorder.css";
                @import "../../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
    </style>-->
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
				var oTable = $('#example_1').dataTable( {
				    
  					"sScrollX": "100%",
					"sScrollXInner": "100,1%",
					"bScrollCollapse": true,
                    "bPaginate": true,
                    "aLengthMenu": [[50], [50,  "All"]],
                     "iDisplayLength": 50,
                    "sPaginationType": "full_numbers",
					"oColReorder": {
						"iFixedColumns": 1
					},
                    "oColVis": {
                            "buttonText": "Ver/Ocultar Columns",
                             "aiExclude": [ 0 ]
                      }
                    
                    
					
				} );
				//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 2,
                                         "iLeftWidth": 550
				} );
                                
                                 var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
					]
		         });
                         $('#demo').before( oTableTools.dom.container );
			} ); 
    </script>
    
    <input type="hidden" id="CodigoPeriodo" value="<?PHP echo $CodigoPeriodo?>" />    
    <div id="demo">
         <table cellpadding="0" cellspacing="0" border="1" class="display" id="example_1">
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Carrera</th>
                    <?PHP 
                    for($i=0;$i<$P_num;$i++){
                        
                            /***************************************/
                            $arrayP = str_split($C_Periodo[$i]['codigoperiodo'], strlen($C_Periodo[$i]['codigoperiodo'])-1);
                            
                            $P_Periodo=$arrayP[0]."-".$arrayP[1];
                            
                            /***************************************/
  
                        ?>
                        <th>Poblaci&oacute;n total <?PHP echo $P_Periodo?></th>
                        <th>Poblaci&oacute;n Deserci&oacute;n <?PHP echo $P_Periodo?></th>
                        <th>Porcentaje Deserci&oacute;n (%) <?PHP echo $P_Periodo?></th>
                        <?PHP
                    }//for
                    ?>
                </tr>
            </thead>
            <tbody>
            <?PHP 
            
            $C_Carrera = $this->Carreras();
            
            $C_Matricula    = array();
            $C_Desertores   = array();
            
            for($j=0;$j<count($C_Carrera);$j++){
                /************************************************************/
                ?>
                <tr>
                <?PHP
                for($i=0;$i<$P_num;$i++){
                    /********************************************************/
                    $R_Consulta  = $this->ConsultaDesercionSemestral($C_Carrera[$j]['codigocarrera'],$CodigoPeriodo);
                    if($i==0){
                        ?>
                        <td><?PHP echo $j+1?></td>
                        <td>
                            <input type="hidden" id="CodigoCarrera_<?PHP echo $j?>" value="<?PHP echo $C_Carrera[$j]['codigocarrera']?>" />
                        <a onclick="Graficar('<?PHP echo $C_Carrera[$j]['codigocarrera']?>');" title="Click para ver Grafica" style="cursor: pointer;">    
                        <?PHP echo $C_Carrera[$j]['nombrecarrera'];?>
                        </a>
                        </td>
                        <?PHP
                    }
                    $C_Matricula [$C_Periodo[$i]['codigoperiodo']][]    = $R_Consulta[$C_Carrera[$j]['codigocarrera']]['Matriculados'][$i];
                    
                    $C_Desertores [$C_Periodo[$i]['codigoperiodo']][]    = $R_Consulta[$C_Carrera[$j]['codigocarrera']]['Desercion'][$i];
                    ?>
                    <td><?PHP echo $R_Consulta[$C_Carrera[$j]['codigocarrera']]['Matriculados'][$i]?></td>
                    <td><a style="cursor: pointer;" title="Ver Situaciones Desercion" onclick="VerSituacion('<?PHP echo $C_Carrera[$j]['codigocarrera']?>','<?PHP echo $C_Periodo[$i]['codigoperiodo']?>')" ><?PHP echo $R_Consulta[$C_Carrera[$j]['codigocarrera']]['Desercion'][$i]?></a></td>
                    <td><?PHP echo number_format($R_Consulta[$C_Carrera[$j]['codigocarrera']]['Porcentaje'][$i],'2',',','.')?>%</td>
                    <?PHP                   
                    /********************************************************/
                }//for
                ?>
                </tr>
                <?PHP
                /************************************************************/
            }//for
  
              ?>
              <tr>
                <td><?PHP echo $j+1?></td>
                <td><a onclick="VerBarras('GraficaProgramaTotal','<?PHP echo $CodigoPeriodo?>')" title="Ver Grafica Total Programas">Total</a></td>
                <?PHP 
                
                
                for($i=0;$i<$P_num;$i++){
                    $S_matriculado = 0;
                    $S_Desercion   = 0;
                    /********************************************************/
                    for($Q=0;$Q<count($C_Matricula[$C_Periodo[$i]['codigoperiodo']]);$Q++){
                        /****************************************************/
                        
                        $S_matriculado = $S_matriculado+$C_Matricula[$C_Periodo[$i]['codigoperiodo']][$Q];
                        $S_Desercion   = $S_Desercion+$C_Desertores[$C_Periodo[$i]['codigoperiodo']][$Q];
                        
                        /****************************************************/
                    }//for
                    ?>
                    <td><?PHP echo $S_matriculado?></td>
                    <td><a onclick="SituacionTotal('<?PHP echo $S_Desercion?>','<?PHP echo $C_Periodo[$i]['codigoperiodo']?>')" title="grafica Situacion Total" style="cursor: pointer;"><?PHP echo $S_Desercion?></a></td>
                    <?PHP 
                    $S_Porcentaje   = (($S_Desercion/$S_matriculado)*100);
                    ?>
                    <td>
                    <a  onclick="VerBarras('GraficaPrograma','<?PHP echo $C_Periodo[$i]['codigoperiodo']?>')" title="Ver Grafica Programas periodo <?PHP echo $C_Periodo[$i]['codigoperiodo']?>" style="cursor: pointer;"><?PHP echo number_format($S_Porcentaje,'2',',','.')?>%</a>
                    </td>
                    <?PHP
                    /********************************************************/
                }//for    
                ?>
              </tr>
              <input type="hidden" id="Index" value="<?PHP echo $j?>" />
            </tbody>        
         </table>
         <input type="hidden" id="Index" value="<?PHP echo $j?>" />
    </div>
    <?PHP
   // echo '<pre>';print_r($C_Matricula);
 }//public function Display
public function DisplayAnual($CodigoPeriodo){
    /*************************************************/
    global $db;
    
    $PeriodoAnual   = $this->PeriodosAnuales($CodigoPeriodo);
    
    //echo '<pre>';print_r($PeriodoAnual);
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
    <!--<style type="text/css" title="currentStyle">
                @import "../../../observatorio/data/media/css/demo_page.css";
                @import "../../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../../observatorio/data/media/css/ColVis.css";
                @import "../../../observatorio/data/media/css/TableTools.css";
                @import "../../../observatorio/data/media/css/ColReorder.css";
                @import "../../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
    </style>-->
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
						"iFixedColumns": 1
					},
                    "oColVis": {
                            "buttonText": "Ver/Ocultar Columns",
                             "aiExclude": [ 0 ]
                      }
                    
                    
					
				} );
				//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 2,
                                         "iLeftWidth": 550
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
         <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Carrera</th>
                    <?PHP 
                    $P_num = count($PeriodoAnual['Anual']);
                   
                    $Index  = '';
                    
                    for($i=0;$i<$P_num;$i++){
                        
                            /***************************************/
                            $C_Periodo  = explode('-',$PeriodoAnual['Anual'][$i]);
                            /***************************************/
                            if($C_Periodo[0] && $C_Periodo[1]){
                                /************************************/
                                
                                $arrayP     = str_split($C_Periodo[0], strlen($C_Periodo[0])-1);
                                
                                $P_Periodo  = $arrayP[0]."-".$arrayP[1];
                                
                                $arrayF     = str_split($C_Periodo[1], strlen($C_Periodo[1])-1);
                                
                                $F_Periodo  = $arrayF[0]."-".$arrayF[1];
                                
                                $Index  = $i;
                                /************************************/
                             ?>
                            <th>Poblaci&oacute;n total <?PHP echo $P_Periodo.'-'.$F_Periodo?></th>
                            <th>Poblaci&oacute;n Deserci&oacute;n <?PHP echo $P_Periodo.'-'.$F_Periodo?></th>
                            <th>Porcentaje Deserci&oacute;n (%) <?PHP echo $P_Periodo.'-'.$F_Periodo?></th>
                            <?PHP    
                            }//if
                         
                    }//for
                    ?>
                </tr>
            </thead>
            <tbody>
            <?PHP 
            //$D_Anual    = $this->DesercionAnual($CodigoPeriodo);
            
            $C_Carrera  = $this->Carreras();
            
                        
            for($j=0;$j<count($C_Carrera);$j++){//for
               
                /********************************************************************/
                ?>
                <tr>
                    <td align="center"><?PHP echo $j+1?></td>
                    <td><a onclick="GenerarGraficAnual('<?PHP echo $C_Carrera[$j]['codigocarrera']?>')" title="Ver Grafica"><?PHP echo $C_Carrera[$j]['nombrecarrera']?></a></td>
                    <?PHP 
                     for($i=0;$i<$P_num;$i++){//for
                        /*******************************************************************/
                        
                            $Periodo = $PeriodoAnual['Anual'][$i];
                            
                            $D_Anual = $this->ConsultaDesercionAnual($C_Carrera[$j]['codigocarrera'],$Periodo);
                            /****************************************************************************/
                            ?>
                            <td><center><?PHP echo $D_Anual[$C_Carrera[$j]['codigocarrera']]['Matriculados'][0]?></center></td>
                            <td><center><a style="cursor: pointer;" title="Ver Situaciones Desercion" onclick="VerSituacionAnual('<?PHP echo $C_Carrera[$j]['codigocarrera']?>','<?PHP echo $Periodo?>')" ><?PHP echo $D_Anual[$C_Carrera[$j]['codigocarrera']]['Desercion'][0]?></a></center></td>
                            <td><center><?PHP echo number_format($D_Anual[$C_Carrera[$j]['codigocarrera']]['Porcentaje'][0],'2',',','.')?>%</center></td>
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
                <td align="center"><?PHP echo $j+1?></td>
                <td>Total</td>
                <?PHP 
                for($i=0;$i<$P_num;$i++){//for
                    
                    $Periodo = $PeriodoAnual['Anual'][$i];
                    
                    $R_Total  = $this->SumaTotalAnual($Periodo);
                    
                    ?>
                    <td><center><?PHP echo $R_Total['TotalMatriculados']?></center></td>
                    <td><center><?PHP echo $R_Total['TotalDesercion']?></center></td>
                    <td><center><?PHP echo $R_Total['TotalPorcentaje']?>%</center></td>
                    <?PHP
                }//for ,,
                ?>
             </tr> 
            </tbody>        
         </table>
         <input type="hidden" id="Index" value="<?PHP echo $j?>" />
    </div>
    <?PHP
   
    
    /*************************************************/
}//public function DisplayAnual
public function Consola(){
    global $db;
    
    ?>
    
    <div id="container">
        <div class="titulo">Deserci&oacute;n</div>
            <fieldset >
                <legend>Deserci&oacute;n</legend>
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center">
                    <thead>
                        <tr>
                            <th class="titulo_label">Periodo</th>
                            <th>
                                <select id="Periodo" name="Periodo" style="width: 50%;text-align: center;">
                                    <option value="-1"></option>
                                    <?PHP 
                                    $C_Periodo=$this->Periodo('Todos','','');
                                    
                                    for($i=0;$i<count($C_Periodo);$i++){
                                        ?>
                                        <option value="<?PHP echo $C_Periodo[$i]['codigoperiodo']?>"><?PHP echo $C_Periodo[$i]['codigoperiodo']?></option>
                                        <?PHP
                                    }//for
                                    ?>
                                </select>
                            </th>
                            <th>&nbsp;</th>
                            <th class="titulo_label">Tipo Deserci&oacute;n</th>
                            <th>
                                <select id="TypeDesercion" name="TypeDesercion" style="width: auto;">
                                    <option value="-1"></option>
                                    <option value="0">Semestral</option>
                                    <option value="1">Anual</option>
                                    <option value="2">Cohorte</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center"><button class="submit" type="button" tabindex="3" onclick="CargarInfo()">Buscar</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" aling="center">
                                <hr style="width:95%;margin-left: 2.5%;" aling="center" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" aling="center">
                                <div id="Rerporte" style="width: 95%;margin-left: 2.5%;height:auto;" aling="center">
                                    <?PHP 
                                   //$this->Display();
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" id="Cadena" />
            </fieldset>
    </div> 
    <?PHP
  }//public function Consola
  public function CadenaInstitucional($CodigoPeriodo){
    global $db;
    
    /******************************************************************/
    $Periodo_Actual     = $this->Periodo('Actual','','');
        
    $C_Periodo          = $this->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
    
    $P_num= count($C_Periodo);
    
    $P_num = $P_num-1;
    
    $C_Total=$this->DesercionSemestral($CodigoPeriodo,'Institucional');
    
    $D_Total    = array();
    
    for($Q=0;$Q<$P_num;$Q++){//for
        /**************************************************************/
        if($C_Periodo[$Q]['codigoperiodo']==$C_Total[$Q]['Periodo']){
            /**********************************************************/
            $T = (($C_Total[$Q]['Total_D']/$C_Total[$Q]['Total_M'])*100);
            $D_Total['Total_D'][]=number_format($T,'2','.','');
            $D_Total['Periodo'][]=$C_Periodo[$Q]['codigoperiodo'];
            /**********************************************************/
        }//if
        /**************************************************************/
    }//for
    /******************************************************************/
    
    return $D_Total;
  }//public function CadenaInstitucional
  public function CadenaPrograma($CodigoPeriodo,$codigoCarrera,$P=''){
    global $db;
    /*******************************************************************/
        $Periodo_Actual = $this->Periodo('Actual','','');
        
        $C_Periodo      = $this->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
        
        $P_num= count($C_Periodo);
        
        $P_num = $P_num-1;
        
        $P_Datos=$this->DesercionSemestral($CodigoPeriodo,'Programas','1',$codigoCarrera);
        
       /************************************************************/ 
        for($i=0;$i<$P_num;$i++){
           /*******************************************/
            $arrayP = str_split($C_Periodo[$i]['codigoperiodo'], strlen($C_Periodo[$i]['codigoperiodo'])-1);
            $C_Datos['Periodo'][] = $arrayP[0]."-".$arrayP[1];
            //$C_Datos['Periodo'][]=$C_Periodo[$i]['codigoperiodo'];
           /*******************************************/ 
        }//for
        /**********************************************************/
        for($j=0;$j<1;$j++){//for count($C_Carrera)
        /********************************************************/
            for($x=0;$x<1;$x++){//for count($P_Datos)
            /*****************************************************/
                for($Q=0;$Q<$P_num;$Q++){//for
                    /*********************************************/
                    if($P_Datos['0'][$codigoCarrera][$Q]['Periodo']==$C_Periodo[$Q]['codigoperiodo']){//if
                       /******************************************/
                            $C_Datos['Desercion'][]=str_replace (',','.',$P_Datos[$x][$codigoCarrera][$Q]['PorcentajeDesercion']);
                            
                       /******************************************/ 
                    }//if
                    /*********************************************/
                }//for
            /*****************************************************/
            }//for
        /********************************************************/
        }//for
      if($P==1){
        return $C_Datos['Periodo'];
      }else{
      return $C_Datos;
      }  
    /*******************************************************************/
  }//public function CadenaPrograma
public function PeriodosAnuales($CodigoPeriodo){
    /*******************************/
    global $db;
    
        
        $Periodo_Actual = $this->Periodo('Actual','','');
        
        $C_Periodos     = $this->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
        
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
        
     return $P_Anual;   
    /*******************************/
}//public function PeriodosAnuales 
public function CadenaAnualPrograma($CodigoPeriodo,$CodigoCarrera,$opcion){
    global $db;
    
    $PeriodoAnual   = $this->PeriodosAnuales($CodigoPeriodo);
    
    $D_Grafica  = array();
    $T_Grafica  = array();
    
    for($x=0;$x<count($PeriodoAnual['Anual']);$x++){
        
        $Periodos   = $PeriodoAnual['Anual'][$x];
        
        $C_Anual  = $this->ConsultaDesercionAnual($CodigoCarrera,$Periodos);
        
        
        
        $D_Grafica['Periodo'][]         = $C_Anual[$CodigoCarrera]['Periodo'][0];
        $D_Grafica['Matriculados'][]    = $C_Anual[$CodigoCarrera]['Matriculados'][0];
        $D_Grafica['Desercion'][]       = $C_Anual[$CodigoCarrera]['Desercion'][0];
        $D_Grafica['Porcentaje'][]      = number_format($C_Anual[$CodigoCarrera]['Porcentaje'][0],'2','.','.');
        
        
        $C_Total    = $this->SumaTotalAnual($Periodos);
        
        $T_Grafica['Periodo'][]         = $Periodos;
        $T_Grafica['Matriculados'][]    = $C_Total['TotalMatriculados'];
        $T_Grafica['Desercion'][]       = $C_Total['TotalPorcentaje'];
        $T_Grafica['Porcentaje'][]      = number_format($C_Total['TotalPorcentaje'],'2','.','.');
        
    }//for Anual
    
   
     
     if($opcion=='programa'){
        return $D_Grafica;
     }else if($opcion=='Total'){
        return $T_Grafica;
     }   
}//public function CadenaAnualPrograma 
public function ConsultaDesercionSemestral($CodigoCarrera,$Periodo){
   global $db;
   
   /*$CodigoCarrera  = 5;
   $Periodo        = 20092;*/
   
    $SQL_ConsultaDesercion='SELECT 

                            d.id_desercion,
                            d.codigocarrera,
                            dt.codigoperiodo,
                            dt.matriculados,
                            dt.desercion,
                            ((dt.desercion/dt.matriculados)*100) AS Porcentaje 
                            
                            FROM 
                            
                            desercion d INNER JOIN deserciondetalle dt ON d.id_desercion=dt.id_desercion
                            
                            WHERE
                            
                            d.codigocarrera="'.$CodigoCarrera.'"
                            AND
                            dt.codigoperiodo>="'.$Periodo.'"
                            AND
                            d.codigoestado=100
                            AND
                            dt.codigoestado=100
                            AND
                            d.tipodesercion=0';
                            
                   if($R_Consulta=&$db->Execute($SQL_ConsultaDesercion)===false){
                     echo 'Error en el SQL de la Desercion Semestral ....<br><br>'.$SQL_ConsultaDesercion;
                     die;
                   }         
                    
           $C_Resultado = array();
           while(!$R_Consulta->EOF){
            /**********************************************************/
              $C_Resultado[$CodigoCarrera]['Periodo'][]         = $R_Consulta->fields['codigoperiodo'];
              $C_Resultado[$CodigoCarrera]['Matriculados'][]    = $R_Consulta->fields['matriculados'];
              $C_Resultado[$CodigoCarrera]['Desercion'][]       = $R_Consulta->fields['desercion'];
              $C_Resultado[$CodigoCarrera]['Porcentaje'][]      = $R_Consulta->fields['Porcentaje'];
            /**********************************************************/
            $R_Consulta->MoveNext();
           }         
        
        return $C_Resultado;           
   }//public function ConsultaDesercionSemestral
  public function ConsultaDesercionAnual($CodigoCarrera,$Periodo){
    global $db;
    
    $SQL_ConsultaDesercion='SELECT 

                            d.id_desercion,
                            d.codigocarrera,
                            dt.periodos,
                            dt.matriculados,
                            dt.desercion,
                            ((dt.desercion/dt.matriculados)*100) AS Porcentaje 
                            
                            FROM 
                            
                            desercion d INNER JOIN deserciondetalle dt ON d.id_desercion=dt.id_desercion
                            
                            WHERE
                            
                            d.codigocarrera="'.$CodigoCarrera.'"
                            AND
                            dt.periodos="'.$Periodo.'"
                            AND
                            d.codigoestado=100
                            AND
                            dt.codigoestado=100
                            AND
                            d.tipodesercion=1
                            
                            GROUP BY  d.id_desercion';
                            
                   if($R_Consulta=&$db->Execute($SQL_ConsultaDesercion)===false){
                     echo 'Error en el SQL de la Desercion Semestral ....<br><br>'.$SQL_ConsultaDesercion;
                     die;
                   }         
                    
           $C_Resultado = array();
           while(!$R_Consulta->EOF){
            /**********************************************************/
              $C_Resultado[$CodigoCarrera]['Periodo'][]         = $R_Consulta->fields['periodos'];
              $C_Resultado[$CodigoCarrera]['Matriculados'][]    = $R_Consulta->fields['matriculados'];
              $C_Resultado[$CodigoCarrera]['Desercion'][]       = $R_Consulta->fields['desercion'];
              $C_Resultado[$CodigoCarrera]['Porcentaje'][]      = $R_Consulta->fields['Porcentaje'];
            /**********************************************************/
            $R_Consulta->MoveNext();
           }         
        
        return $C_Resultado;       
    
  }//public function ConsultaDesercionAnual 
   public function RetencionSemestral($CodigoPeriodo){
    global $db;
    
    $Periodo_Actual=$this->Periodo('Actual','','');
        
    $C_Periodo  = $this->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
    
    $P_num= count($C_Periodo);
    
    $P_num  = $P_num-1;
    
    
    
    //echo '<pre>';print_r($C_Periodo);echo 'num->'.$P_num;die;
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
    <!--<style type="text/css" title="currentStyle">
                @import "../../../observatorio/data/media/css/demo_page.css";
                @import "../../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../../observatorio/data/media/css/ColVis.css";
                @import "../../../observatorio/data/media/css/TableTools.css";
                @import "../../../observatorio/data/media/css/ColReorder.css";
                @import "../../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
    </style>-->
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
				var oTable = $('#example_1').dataTable( {
				    
  					"sScrollX": "100%",
					"sScrollXInner": "100,1%",
					"bScrollCollapse": true,
                    "bPaginate": true,
                    "aLengthMenu": [[50], [50,  "All"]],
                     "iDisplayLength": 50,
                    "sPaginationType": "full_numbers",
					"oColReorder": {
						"iFixedColumns": 1
					},
                    "oColVis": {
                            "buttonText": "Ver/Ocultar Columns",
                             "aiExclude": [ 0 ]
                      }
                    
                    
					
				} );
				//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 2,
                                         "iLeftWidth": 550
				} );
                                
                                 var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
					]
		         });
                         $('#demo').before( oTableTools.dom.container );
			} ); 
    </script>
    
    <input type="hidden" id="CodigoPeriodo" value="<?PHP echo $CodigoPeriodo?>" />    
    <div id="demo">
         <table cellpadding="0" cellspacing="0" border="1" class="display" id="example_1">
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Carrera</th>
                    <?PHP 
                    for($i=0;$i<$P_num;$i++){
                        
                            /***************************************/
                            $arrayP = str_split($C_Periodo[$i]['codigoperiodo'], strlen($C_Periodo[$i]['codigoperiodo'])-1);
                            
                            $P_Periodo=$arrayP[0]."-".$arrayP[1];
                            
                            /***************************************/
  
                        ?>
                        <th>Poblaci&oacute;n total <?PHP echo $P_Periodo?></th>
                        <th>Poblaci&oacute;n Retenci&oacute;n <?PHP echo $P_Periodo?></th>
                        <th>Porcentaje Retenci&oacute;n (%) <?PHP echo $P_Periodo?></th>
                        <?PHP
                    }//for
                    ?>
                </tr>
            </thead>
            <tbody>
            <?PHP 
            
            $C_Carrera = $this->Carreras();
            
            $C_Matricula    = array();
            $C_Retencion   = array();
            
            for($j=0;$j<count($C_Carrera);$j++){
                /************************************************************/
                ?>
                <tr>
                <?PHP
                for($i=0;$i<$P_num;$i++){
                    /********************************************************/
                    $R_Consulta  = $this->ConsultaDesercionSemestral($C_Carrera[$j]['codigocarrera'],$CodigoPeriodo);
                    if($i==0){
                        ?>
                        <td><?PHP echo $j+1?></td>
                        <td>
                            <input type="hidden" id="CodigoCarrera_<?PHP echo $j?>" value="<?PHP echo $C_Carrera[$j]['codigocarrera']?>" />
                        <a onclick="GraficarRetencion('<?PHP echo $C_Carrera[$j]['codigocarrera']?>');" title="Click para ver Grafica" style="cursor: pointer;">    
                        <?PHP echo $C_Carrera[$j]['nombrecarrera'];?>
                        </a>
                        </td>
                        <?PHP
                    }
                    $C_Matricula [$C_Periodo[$i]['codigoperiodo']][]    = $R_Consulta[$C_Carrera[$j]['codigocarrera']]['Matriculados'][$i];
                    
                    /******************************************************/
                    $Retencion = $R_Consulta[$C_Carrera[$j]['codigocarrera']]['Matriculados'][$i]-$R_Consulta[$C_Carrera[$j]['codigocarrera']]['Desercion'][$i];
                    /******************************************************/
                    
                    $C_Retencion [$C_Periodo[$i]['codigoperiodo']][]    = $Retencion;
                    ?>
                    <td><?PHP echo $R_Consulta[$C_Carrera[$j]['codigocarrera']]['Matriculados'][$i]?></td>
                    <td><?PHP echo $Retencion?></td>
                    <?PHP 
                    $Por_Retencion = (($Retencion/$R_Consulta[$C_Carrera[$j]['codigocarrera']]['Matriculados'][$i])*100);
                    ?>
                    <td><?PHP echo number_format($Por_Retencion,'2',',','.')?>%</td>
                    <?PHP                   
                    /********************************************************/
                }//for
                ?>
                </tr>
                <?PHP
                /************************************************************/
            }//for
  
              ?>
              <tr>
                <td><?PHP echo $j+1?></td>
                <td><a onclick="VerBarras('GraficaProgramaTotalRetencion','<?PHP echo $CodigoPeriodo?>')" title="Ver Grafica Total Programas">Total</a></td>
                <?PHP 
                
                
                for($i=0;$i<$P_num;$i++){
                    $S_matriculado = 0;
                    $S_Retencion   = 0;
                    /********************************************************/
                    for($Q=0;$Q<count($C_Matricula[$C_Periodo[$i]['codigoperiodo']]);$Q++){
                        /****************************************************/
                        
                        $S_matriculado = $S_matriculado+$C_Matricula[$C_Periodo[$i]['codigoperiodo']][$Q];
                        $S_Retencion   = $S_Retencion+$C_Retencion[$C_Periodo[$i]['codigoperiodo']][$Q];
                        
                        /****************************************************/
                    }//for
                    ?>
                    <td><?PHP echo $S_matriculado?></td>
                    <td><?PHP echo $S_Retencion?></td>
                    <?PHP 
                    $S_Porcentaje   = (($S_Retencion/$S_matriculado)*100);
                    ?>
                    <td>
                    <a  onclick="VerBarras('GraficaProgramaRetecion','<?PHP echo $C_Periodo[$i]['codigoperiodo']?>')" title="Ver Grafica Programas periodo <?PHP echo $C_Periodo[$i]['codigoperiodo']?>"><?PHP echo number_format($S_Porcentaje,'2',',','.')?>%</a>
                    </td>
                    <?PHP
                    /********************************************************/
                }//for    
                ?>
              </tr>
              <input type="hidden" id="Index" value="<?PHP echo $j?>" />
            </tbody>        
         </table>
         <input type="hidden" id="Index" value="<?PHP echo $j?>" />
    </div>
    <?PHP
    
   }//public function RetencionSemestral
   public function Retencion(){
        global $db;
    
    ?>
    
    <div id="container">
        <div class="titulo">Retenci&oacute;n</div>
            <fieldset >
                <legend>Retenci&oacute;n</legend>
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center">
                    <thead>
                        <tr>
                            <th class="titulo_label">Periodo</th>
                            <th>
                                <select id="Periodo" name="Periodo" style="width: 50%;text-align: center;">
                                    <option value="-1"></option>
                                    <?PHP 
                                    $C_Periodo=$this->Periodo('Todos','','');
                                    
                                    for($i=0;$i<count($C_Periodo);$i++){
                                        ?>
                                        <option value="<?PHP echo $C_Periodo[$i]['codigoperiodo']?>"><?PHP echo $C_Periodo[$i]['codigoperiodo']?></option>
                                        <?PHP
                                    }//for
                                    ?>
                                </select>
                            </th>
                            <th>&nbsp;</th>
                            <th class="titulo_label">Tipo Retenci&oacute;n</th>
                            <th>
                                <select id="TypeDesercion" name="TypeDesercion" style="width: auto;">
                                    <option value="-1"></option>
                                    <option value="0">Semestral</option>
                                    <option value="1">Anual</option>
                                    <option value="2">Cohorte</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center"><button class="submit" type="button" tabindex="3" onclick="CargarInfo2()">Buscar</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" aling="center">
                                <hr style="width:95%;margin-left: 2.5%;" aling="center" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" aling="center">
                                <div id="Rerporte" style="width: 95%;margin-left: 2.5%;height:auto;" aling="center">
                                    <?PHP 
                                   //$this->Display();
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" id="Cadena" />
            </fieldset>
    </div> 
    <?PHP
   }//public function Retencion
   public function CadenaProRetencion($CodigoPeriodo,$codigoCarrera,$P=''){
    global $db;
    /*******************************************************************/
        $Periodo_Actual = $this->Periodo('Actual','','');
        
        $C_Periodo      = $this->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
        
        $P_num= count($C_Periodo);
        
        $P_num = $P_num-1;
        
        $P_Datos=$this->DesercionSemestral($CodigoPeriodo,'Programas','1',$codigoCarrera);
        
        //echo '<pre>';print_r($P_Datos);die;
        
       /************************************************************/ 
        for($i=0;$i<$P_num;$i++){
           /*******************************************/
            $arrayP = str_split($C_Periodo[$i]['codigoperiodo'], strlen($C_Periodo[$i]['codigoperiodo'])-1);
            $C_Datos['Periodo'][] = $arrayP[0]."-".$arrayP[1];
            //$C_Datos['Periodo'][]=$C_Periodo[$i]['codigoperiodo'];
           /*******************************************/ 
        }//for
        /**********************************************************/
        for($j=0;$j<1;$j++){//for count($C_Carrera)
        /********************************************************/
            for($x=0;$x<1;$x++){//for count($P_Datos)
            /*****************************************************/
                for($Q=0;$Q<$P_num;$Q++){//for
                    /*********************************************/
                    if($P_Datos['0'][$codigoCarrera][$Q]['Periodo']==$C_Periodo[$Q]['codigoperiodo']){//if
                       /******************************************/
                       $Retencion  = $P_Datos[$x][$codigoCarrera][$Q]['TotalMatriculados']-$P_Datos[$x][$codigoCarrera][$Q]['Desercion'];
                       
                       $Porcentaje   = (($Retencion/$P_Datos[$x][$codigoCarrera][$Q]['TotalMatriculados'])*100);
                       
                            $C_Datos['Desercion'][]=number_format($Porcentaje,'2','.','');
                            
                       /******************************************/ 
                    }//if
                    /*********************************************/
                }//for
            /*****************************************************/
            }//for
        /********************************************************/
        }//for
      if($P==1){
        return $C_Datos['Periodo'];
      }else{
      return $C_Datos;
      }  
    /*******************************************************************/
  }//public function CadenaProRetencion
  public function CadenaRetenInstitucional($CodigoPeriodo){
    global $db;
    
    /******************************************************************/
    $Periodo_Actual     = $this->Periodo('Actual','','');
        
    $C_Periodo          = $this->Periodo('Cadena',$CodigoPeriodo,$Periodo_Actual);
    
    $P_num= count($C_Periodo);
    
    $P_num = $P_num-1;
    
    $C_Total=$this->DesercionSemestral($CodigoPeriodo,'Institucional');
    
    //echo '<pre>';print_r($C_Total);die;
    
    $D_Total    = array();
    
    for($Q=0;$Q<$P_num;$Q++){//for
        /**************************************************************/
        if($C_Periodo[$Q]['codigoperiodo']==$C_Total[$Q]['Periodo']){
            /**********************************************************/
            
            
            $R = ($C_Total[$Q]['Total_M']-$C_Total[$Q]['Total_D']);
            
            $T  = (($R/$C_Total[$Q]['Total_M'])*100);
            
            
            $D_Total['Total_R'][]=number_format($T,'2','.','');
            /**********************************************************/
        }//if
        /**************************************************************/
    }//for
    /******************************************************************/
    
    return $D_Total;
  }//public function CadenaRetenInstitucional
   public function Formularios(){
        global $db;
    
    ?>
    
    <div id="container">
        <div class="titulo">Formularios</div>
            <fieldset >
                <legend>Formularios</legend>
                <form action="Carga.php" method="post" enctype="multipart/form-data" name="Principal">
                
                <table border="0" cellpadding="0" cellspacing="0" class="display" aling="center">
                    <thead>
                        <tr>
                            <th class="titulo_label">Periodo</th>
                            <th>
                                <select id="Periodo" name="Periodo" style="width: 50%;text-align: center;">
                                    <option value="-1"></option>
                                    <?PHP 
                                    $C_Periodo=$this->Periodo('Todos','','');
                                    
                                    for($i=0;$i<count($C_Periodo);$i++){
                                        ?>
                                        <option value="<?PHP echo $C_Periodo[$i]['codigoperiodo']?>"><?PHP echo $C_Periodo[$i]['codigoperiodo']?></option>
                                        <?PHP
                                    }//for
                                    ?>
                                </select>
                            </th>
                            <th>&nbsp;</th>
                            <th class="titulo_label">Tipo Formulario</th>
                            <th>
                                <select id="TypeFormulario" name="TypeFormulario" style="width: auto;">
                                    <option value="-1"></option>
                                    <option value="0">Desrcion</option>
                                    <option value="1">Retencion</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="5">&nbsp;</th>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <th colspan="3">Archivo<input type="file" id="file" name="file" height="80px"  size="50"/></th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5" aling="center"><button class="submit" type="submit" tabindex="3" onclick="return Validar();">Buscar</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" aling="center">
                                <hr style="width:95%;margin-left: 2.5%;" aling="center" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" aling="center">
                                <div id="Rerporte" style="width: 95%;margin-left: 2.5%;height:auto;" aling="center">
                                    <?PHP 
                                   //$this->Display();
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
             </form>   
                <input type="hidden" id="Cadena" />
            </fieldset>
    </div> 
    <?PHP
   }//public function Formularios
  public function CausasDesercion($Periodo,$Carrera,$Op){
    global $db;
    
    include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
    
    
    $datos_estadistica=new obtener_datos_matriculas($db,$Periodo);
    
    
    $DesercionDato2=$datos_estadistica->obtener_datos_estudiantes_desercion($Carrera,'arreglo');
    
    
    //echo '<pre>';print_r($DesercionDato2); 
    
    /*
    100	Perdida de la Calidad de Estudiante Academica
    101	Perdida de la Calidad de Estudiante Disciplinaria
    102	Perdida de la Calidad de Estudiante Administrativa
    103	Perdida de la Calidad de Estudiante Voluntaria
    104	Egresado
    105	Admitido que no Ingreso
    106	Preinscrito
    107	Inscrito
    108	Reserva de cupo
    109	Registro Anulado
    110	Pendiente Decision Consejo Facultad
    111	Inscrito sin pago
    112	Terminacion de curso o educacion no formal
    113	No Admitido
    114	En proceso de financiaci�n
    115	Lista en Espera
    200	Prueba Academica
    300	Admitido
    301	Normal
    302	Solicitud reserva de cupo
    400	Graduado
    500	En proceso de Grado

    */
    
    $C_Situacion  = array();
    
    for($i=0;$i<count($DesercionDato2);$i++){
        /*********************************************************/
        switch($DesercionDato2[$i]['CodigoSalidad']){
            case '100':{
                $C_Situacion['P_Academica']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['P_Academica']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['P_Academica']['Count'] =  count($C_Situacion['P_Academica']['Codigo']);
                
            }break;
            case '101':{
                $C_Situacion['P_Disciplinaria']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['P_Disciplinaria']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['P_Disciplinaria']['Count'] =  count($C_Situacion['P_Disciplinaria']['Codigo']);
                
                
            }break;
            case '102':{
                $C_Situacion['P_Administrativa']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['P_Administrativa']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['P_Administrativa']['Count'] =  count($C_Situacion['P_Administrativa']['Codigo']);
                
                
            }break;
            case '103':{
                $C_Situacion['P_Voluntaria']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['P_Voluntaria']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['P_Voluntaria']['Count'] =  count($C_Situacion['P_Voluntaria']['Codigo']);
                
            }break;
               
            case '104':{
                $C_Situacion['Egresado']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Egresado']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Egresado']['Count'] =  count($C_Situacion['Egresado']['Codigo']);
                
            }break;
            case '105':{
                $C_Situacion['Admitido_no']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Admitido_no']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Admitido_no']['Count'] =  count($C_Situacion['Admitido_no']['Codigo']);
                
            }break;
            case '106':{
                $C_Situacion['Preinscrito']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Preinscrito']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Preinscrito']['Count'] =  count($C_Situacion['Preinscrito']['Codigo']);
                
            }break;
            case '107':{
                $C_Situacion['Inscrito']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Inscrito']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Inscrito']['Count'] =  count($C_Situacion['Inscrito']['Codigo']);
                
            }break;
            case '108':{
                $C_Situacion['Reserva_Cupo']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Reserva_Cupo']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Reserva_Cupo']['Count'] =  count($C_Situacion['Reserva_Cupo']['Codigo']);
                
            }break;
            case '109':{
                $C_Situacion['Registro_Anulado']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Registro_Anulado']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Registro_Anulado']['Count'] =  count($C_Situacion['Registro_Anulado']['Codigo']);
                
            }break;
            case '110':{
                $C_Situacion['PendienteConsejo']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['PendienteConsejo']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['PendienteConsejo']['Count'] =  count($C_Situacion['PendienteConsejo']['Codigo']);
                
            }break;
            case '111':{
                $C_Situacion['InsSinPago']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['InsSinPago']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['InsSinPago']['Count'] =  count($C_Situacion['InsSinPago']['Codigo']);
                
            }break;
            case '112':{
                $C_Situacion['CursoEduNoFormal']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['CursoEduNoFormal']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['CursoEduNoFormal']['Count'] =  count($C_Situacion['CursoEduNoFormal']['Codigo']);
                
            }break;
            case '113':{
                $C_Situacion['No_Admitido']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['No_Admitido']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['No_Admitido']['Count'] =  count($C_Situacion['No_Admitido']['Codigo']);
                
            }break;
            case '114':{
                $C_Situacion['EnProcesoFinanciacion']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['EnProcesoFinanciacion']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['EnProcesoFinanciacion']['Count'] =  count($C_Situacion['EnProcesoFinanciacion']['Codigo']);
                
            }break;
            case '115':{
                $C_Situacion['Lista_Espera']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Lista_Espera']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Lista_Espera']['Count'] =  count($C_Situacion['Lista_Espera']['Codigo']);
                
            }break;
            case '200':{
                $C_Situacion['Prueba_Academica']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Prueba_Academica']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Prueba_Academica']['Count'] =  count($C_Situacion['Prueba_Academica']['Codigo']);
                
            }break;
            case '300':{
                $C_Situacion['Admitido']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Admitido']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Admitido']['Count'] =  count($C_Situacion['Admitido']['Codigo']);
            }break;
            case '301':{
                $C_Situacion['Normal']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Normal']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Normal']['Count'] =  count($C_Situacion['Normal']['Codigo']);
                
            }break;
            case '302':{
                $C_Situacion['SolicitudReservaCupo']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['SolicitudReservaCupo']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['SolicitudReservaCupo']['Count'] =  count($C_Situacion['SolicitudReservaCupo']['Codigo']);
            }break;
            case '400':{
                $C_Situacion['Graduado']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['Graduado']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['Graduado']['Count'] =  count($C_Situacion['Graduado']['Codigo']);
            }break;
            case '500':{
                $C_Situacion['EnProceso_Grado']['Codigo'][]=$DesercionDato2[$i]['CodigoSalidad'];
                $C_Situacion['EnProceso_Grado']['CodigoEstudiante'][]=$DesercionDato2[$i]['codigoestudiante'];
                $C_Situacion['EnProceso_Grado']['Count'] =  count($C_Situacion['EnProceso_Grado']['Codigo']);
            }break;
        }
        /*********************************************************/
    }//for
         
    
    $Num_P_Academica  = number_format(((count($C_Situacion['P_Academica']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    if($Op==1){
        
        if($Num_P_Academica>0){
        
            $C_Situacion['Porcentaje'][] = $Num_P_Academica;
            $C_Situacion['Nombre'][] = 'Perdida Academica';
            $C_Situacion['Codigo'][] = '100';
            
        }
        
    }else{
        
            $C_Situacion['Porcentaje'][] = $Num_P_Academica;
            $C_Situacion['Nombre'][] = 'Perdida Academica';
            $C_Situacion['Codigo'][] = '100';
        
    }
    
    
    $Num_P_Disciplinaria = number_format(((count($C_Situacion['P_Disciplinaria']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
     
    if($Op==1){    
        if($Num_P_Disciplinaria>0){
            
            $C_Situacion['Porcentaje'][] = $Num_P_Disciplinaria;
            $C_Situacion['Nombre'][] = 'Perdida Disiplinaria';
            $C_Situacion['Codigo'][] = '101';
            
        }
    }else{
        
            $C_Situacion['Porcentaje'][] = $Num_P_Disciplinaria;
            $C_Situacion['Nombre'][] = 'Perdida Disiplinaria';
            $C_Situacion['Codigo'][] = '101';
    } 
    
    $Num_P_Administrativa = number_format(((count($C_Situacion['P_Administrativa']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_P_Administrativa>0){
            
            $C_Situacion['Porcentaje'][] = $Num_P_Administrativa;
            $C_Situacion['Nombre'][] = 'Perdida Administrativa';
            $C_Situacion['Codigo'][] = '102';
            
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_P_Administrativa;
            $C_Situacion['Nombre'][] = 'Perdida Administrativa';
            $C_Situacion['Codigo'][] = '102';
        
    }
    
    $Num_P_Voluntaria = number_format(((count($C_Situacion['P_Voluntaria']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_P_Voluntaria>0){
            
            $C_Situacion['Porcentaje'][] = $Num_P_Voluntaria;
            $C_Situacion['Nombre'][] = 'Perdida Voluntaria';
            $C_Situacion['Codigo'][] = '103';
        }
    }else{
        
            $C_Situacion['Porcentaje'][] = $Num_P_Voluntaria;
            $C_Situacion['Nombre'][] = 'Perdida Voluntaria';
            $C_Situacion['Codigo'][] = '103';
    }
    
    $Num_Egresado = number_format(((count($C_Situacion['Egresado']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Egresado>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Egresado;
            $C_Situacion['Nombre'][] = 'Egresado';
            $C_Situacion['Codigo'][] = '104';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Egresado;
            $C_Situacion['Nombre'][] = 'Egresado';
            $C_Situacion['Codigo'][] = '104';
    }
    
    $Num_Admitido_no = number_format(((count($C_Situacion['Admitido_no']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    
    if($Op==1){
        if($Num_Admitido_no>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Admitido_no;
            $C_Situacion['Nombre'][] = 'Admitido que no Ingreso';
            $C_Situacion['Codigo'][] = '105';
        }
    }
    
    $Num_Preinscrito = number_format(((count($C_Situacion['Preinscrito']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Preinscrito>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Preinscrito;
            $C_Situacion['Nombre'][] = 'Preinscrito';
            $C_Situacion['Codigo'][] = '106';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Preinscrito;
            $C_Situacion['Nombre'][] = 'Preinscrito';
            $C_Situacion['Codigo'][] = '106';
    }
    
    $Num_Inscrito = number_format(((count($C_Situacion['Inscrito']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Inscrito>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Inscrito;
            $C_Situacion['Nombre'][] = 'Inscrito';
            $C_Situacion['Codigo'][] = '107';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Inscrito;
            $C_Situacion['Nombre'][] = 'Inscrito';
            $C_Situacion['Codigo'][] = '107';
    }
   
    $Num_Reserva_Cupo = number_format(((count($C_Situacion['Reserva_Cupo']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Reserva_Cupo>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Reserva_Cupo;
            $C_Situacion['Nombre'][] = 'Reserva de cupo';
            $C_Situacion['Codigo'][] = '108';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Reserva_Cupo;
            $C_Situacion['Nombre'][] = 'Reserva de cupo';
            $C_Situacion['Codigo'][] = '108';
    }
    
    $Num_Registro_Anulado = number_format(((count($C_Situacion['Registro_Anulado']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Registro_Anulado>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Registro_Anulado;
            $C_Situacion['Nombre'][] = 'Registro Anulado';
            $C_Situacion['Codigo'][] = '109';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Registro_Anulado;
            $C_Situacion['Nombre'][] = 'Registro Anulado';
            $C_Situacion['Codigo'][] = '109';
    }
    
    $Num_PendienteConsejo = number_format(((count($C_Situacion['PendienteConsejo']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_PendienteConsejo>0){
            
            $C_Situacion['Porcentaje'][] = $Num_PendienteConsejo;
            $C_Situacion['Nombre'][] = 'Pendiente Decision Consejo Facultad';
            $C_Situacion['Codigo'][] = '110';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_PendienteConsejo;
            $C_Situacion['Nombre'][] = 'Pendiente Decision Consejo Facultad';
            $C_Situacion['Codigo'][] = '110'; 
        
    }
    $Num_InsSinPago = number_format(((count($C_Situacion['InsSinPago']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_InsSinPago>0){
            
            $C_Situacion['Porcentaje'][] = $Num_InsSinPago;
            $C_Situacion['Nombre'][] = 'Inscrito sin pago';
            $C_Situacion['Codigo'][] = '111';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_InsSinPago;
            $C_Situacion['Nombre'][] = 'Inscrito sin pago';
            $C_Situacion['Codigo'][] = '111';
    }
   
    $Num_CursoEduNoFormal = number_format(((count($C_Situacion['CursoEduNoFormal']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_CursoEduNoFormal>0){
            
            $C_Situacion['Porcentaje'][] = $Num_CursoEduNoFormal;
            $C_Situacion['Nombre'][] = 'Terminacion de curso o educacion no formal';
            $C_Situacion['Codigo'][] = '112';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_CursoEduNoFormal;
            $C_Situacion['Nombre'][] = 'Terminacion de curso o educacion no formal';
            $C_Situacion['Codigo'][] = '112';
    }
    
    $Num_No_Admitido = number_format(((count($C_Situacion['No_Admitido']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_No_Admitido>0){
            
            $C_Situacion['Porcentaje'][] = $Num_No_Admitido;
            $C_Situacion['Nombre'][] = 'No Admitido';
            $C_Situacion['Codigo'][] = '113';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_No_Admitido;
            $C_Situacion['Nombre'][] = 'No Admitido';
            $C_Situacion['Codigo'][] = '113';
    }
     
    $Num_EnProcesoFinanciacion = number_format(((count($C_Situacion['EnProcesoFinanciacion']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_EnProcesoFinanciacion>0){
            
            $C_Situacion['Porcentaje'][] = $Num_EnProcesoFinanciacion;
            $C_Situacion['Nombre'][] = 'En proceso de financiacion';
            $C_Situacion['Codigo'][] = '114';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_EnProcesoFinanciacion;
            $C_Situacion['Nombre'][] = 'En proceso de financiacion';
            $C_Situacion['Codigo'][] = '114';
    }
    
    $Num_Lista_Espera = number_format(((count($C_Situacion['Lista_Espera']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Lista_Espera>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Lista_Espera;
            $C_Situacion['Nombre'][] = 'Lista en Espera';
            $C_Situacion['Codigo'][] = '115';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Lista_Espera;
            $C_Situacion['Nombre'][] = 'Lista en Espera';
            $C_Situacion['Codigo'][] = '115';
    }
    
    $Num_Prueba_Academica = number_format(((count($C_Situacion['Prueba_Academica']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Prueba_Academica>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Prueba_Academica;
            $C_Situacion['Nombre'][] = 'Prueba Academica';
            $C_Situacion['Codigo'][] = '200';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Prueba_Academica;
            $C_Situacion['Nombre'][] = 'Prueba Academica';
            $C_Situacion['Codigo'][] = '200';
    }
    
    $Num_Admitido = number_format(((count($C_Situacion['Admitido']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Admitido>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Admitido;
            $C_Situacion['Nombre'][] = 'Admitido';
            $C_Situacion['Codigo'][] = '300';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Admitido;
            $C_Situacion['Nombre'][] = 'Admitido';
            $C_Situacion['Codigo'][] = '300';
    }
     
    $Num_Normal = number_format(((count($C_Situacion['Normal']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Normal>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Normal;
            $C_Situacion['Nombre'][] = 'Normal';
            $C_Situacion['Codigo'][] = '301';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Normal;
            $C_Situacion['Nombre'][] = 'Normal';
            $C_Situacion['Codigo'][] = '301';
    }
    
    $Num_SolicitudReservaCupo = number_format(((count($C_Situacion['SolicitudReservaCupo']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_SolicitudReservaCupo>0){
            
            $C_Situacion['Porcentaje'][] = $Num_SolicitudReservaCupo;
            $C_Situacion['Nombre'][] = 'Solicitud reserva de cupo';
            $C_Situacion['Codigo'][] = '302';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_SolicitudReservaCupo;
            $C_Situacion['Nombre'][] = 'Solicitud reserva de cupo';
            $C_Situacion['Codigo'][] = '302';
    }
   
    $Num_Graduado = number_format(((count($C_Situacion['Graduado']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_Graduado>0){
            
            $C_Situacion['Porcentaje'][] = $Num_Graduado;
            $C_Situacion['Nombre'][] = 'Graduado';
            $C_Situacion['Codigo'][] = '400';
        }
    }else{
            $C_Situacion['Porcentaje'][] = $Num_Graduado;
            $C_Situacion['Nombre'][] = 'Graduado';
            $C_Situacion['Codigo'][] = '400';
    }
   
    $Num_EnProceso_Grado = number_format(((count($C_Situacion['EnProceso_Grado']['Codigo'])*100)/count($DesercionDato2)),'2','.','.');
    
    if($Op==1){
        if($Num_EnProceso_Grado>0){
            
            $C_Situacion['Porcentaje'][] = $Num_EnProceso_Grado;
            $C_Situacion['Nombre'][] = 'En proceso de Grado';
            $C_Situacion['Codigo'][] = '500';
        }
    }else{
        
            $C_Situacion['Porcentaje'][] = $Num_EnProceso_Grado;
            $C_Situacion['Nombre'][] = 'En proceso de Grado';
            $C_Situacion['Codigo'][] = '500';
    }
    /**********************************************************************************************************************************************/  
   
      //echo '<pre>';print_r($C_Situacion);
      
      return $C_Situacion;
                       
  } 
  public function CausasDesercionTotalSemestral($Periodo,$T_Desercion){
    
    global $db;
    
    $C_Carrera  = $this->Carreras();
        
        $D_Porcentaje  = array();
           
        for($i=0;$i<count($C_Carrera);$i++){
            
            $CodigoCarrera  = $C_Carrera[$i]['codigocarrera'];
            
            $C_Datos        = $this->CausasDesercion($Periodo,$CodigoCarrera,'0');
            
            //echo '<pre>';print_r($C_Datos);
            
            /**************************************************************************/
            for($j=0;$j<count($C_Datos['Codigo']);$j++){
                /************************************************************************************/
                switch($C_Datos['Codigo'][$j]){
                        case '100':{
                                    $D_Porcentaje ['P_Academica']['Porcentajeee'][] = $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['P_Academica']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['P_Academica']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['P_Academica']['Count'][] = $C_Datos['P_Academica']['Count'];
                                    $D_Porcentaje ['P_Academica']['SumaCount'] += $C_Datos['P_Academica']['Count'];
                        }break;
                        case '101':{
                                    
                                    $D_Porcentaje ['P_Disciplinaria']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['P_Disciplinaria']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['P_Disciplinaria']['Count'][] = $C_Datos['P_Disciplinaria']['Count'];
                                    $D_Porcentaje ['P_Disciplinaria']['SumaCount'] += $C_Datos['P_Disciplinaria']['Count'];
                        }break;
                        case '102':{
                                    $D_Porcentaje ['P_Administrativa']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['P_Administrativa']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['P_Administrativa']['Count'][] = $C_Datos['P_Administrativa']['Count'];
                                    $D_Porcentaje ['P_Administrativa']['SumaCount'] += $C_Datos['P_Administrativa']['Count'];
                        }break;
                        case '103':{
                                    $D_Porcentaje ['P_Voluntaria']['Porcentajeee'][] = $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['P_Voluntaria']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['P_Voluntaria']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['P_Voluntaria']['Count'][] = $C_Datos['P_Voluntaria']['Count'];
                                    $D_Porcentaje ['P_Voluntaria']['SumaCount'] += $C_Datos['P_Voluntaria']['Count'];
                        }break;
                         case '104':{
                                    $D_Porcentaje ['Egresado']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Egresado']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Egresado']['Count'][] = $C_Datos['Egresado']['Count'];
                                    $D_Porcentaje ['Egresado']['SumaCount'] += $C_Datos['Egresado']['Count'];
                        }break;
                        case '105':{
                                    $D_Porcentaje ['Admitido_no']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Admitido_no']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Admitido_no']['Count'][] = $C_Datos['Admitido_no']['Count'];
                                    $D_Porcentaje ['Admitido_no']['SumaCount'] += $C_Datos['Admitido_no']['Count'];
                        }break;
                        case '106':{
                                    $D_Porcentaje ['Preinscrito']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Preinscrito']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Preinscrito']['Count'][] = $C_Datos['Preinscrito']['Count'];
                                    $D_Porcentaje ['Preinscrito']['SumaCount'] += $C_Datos['Preinscrito']['Count'];
                        }break;
                        case '107':{
                                    $D_Porcentaje ['Inscrito']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Inscrito']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Inscrito']['Count'][] = $C_Datos['Inscrito']['Count'];
                                    $D_Porcentaje ['Inscrito']['SumaCount'] += $C_Datos['Inscrito']['Count'];
                        }break;
                        case '108':{
                                    $D_Porcentaje ['Reserva_Cupo']['Porcentajeee'][] = $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Reserva_Cupo']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Reserva_Cupo']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Reserva_Cupo']['Count'][] = $C_Datos['Reserva_Cupo']['Count'];
                                    $D_Porcentaje ['Reserva_Cupo']['SumaCount'] += $C_Datos['Reserva_Cupo']['Count'];
                        }break;
                        case '109':{
                                    $D_Porcentaje ['Registro_Anulado']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Registro_Anulado']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Registro_Anulado']['Count'][] = $C_Datos['Registro_Anulado']['Count'];
                                    $D_Porcentaje ['Registro_Anulado']['SumaCount'] += $C_Datos['Registro_Anulado']['Count'];
                        }break;
                        case '110':{
                                    $D_Porcentaje ['PendienteConsejo']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['PendienteConsejo']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['PendienteConsejo']['Count'][] = $C_Datos['PendienteConsejo']['Count'];
                                    $D_Porcentaje ['PendienteConsejo']['SumaCount'] += $C_Datos['PendienteConsejo']['Count'];
                        }break;
                        case '111':{
                                    $D_Porcentaje ['InsSinPago']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['InsSinPago']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['InsSinPago']['Count'][] = $C_Datos['InsSinPago']['Count'];
                                    $D_Porcentaje ['InsSinPago']['SumaCount'] += $C_Datos['InsSinPago']['Count'];
                        }break;
                        case '112':{
                                    $D_Porcentaje ['CursoEduNoFormal']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['CursoEduNoFormal']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['CursoEduNoFormal']['Count'][] = $C_Datos['CursoEduNoFormal']['Count'];
                                    $D_Porcentaje ['CursoEduNoFormal']['SumaCount'] += $C_Datos['CursoEduNoFormal']['Count'];
                        }break;
                        case '113':{
                                    $D_Porcentaje ['No_Admitido']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['No_Admitido']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['No_Admitido']['Count'][] = $C_Datos['No_Admitido']['Count'];
                                    $D_Porcentaje ['No_Admitido']['SumaCount'] += $C_Datos['No_Admitido']['Count'];
                        }break;
                        case '114':{
                                    $D_Porcentaje ['EnProcesoFinanciacion']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['EnProcesoFinanciacion']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['EnProcesoFinanciacion']['Count'][] = $C_Datos['EnProcesoFinanciacion']['Count'];
                                    $D_Porcentaje ['EnProcesoFinanciacion']['SumaCount'] += $C_Datos['EnProcesoFinanciacion']['Count'];
                        }break;
                        case '115':{
                                    $D_Porcentaje ['Lista_Espera']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Lista_Espera']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Lista_Espera']['Count'][] = $C_Datos['Lista_Espera']['Count'];
                                    $D_Porcentaje ['Lista_Espera']['SumaCount'] += $C_Datos['Lista_Espera']['Count'];
                        }break;
                        case '200':{
                                    $D_Porcentaje ['Prueba_Academica']['Porcentajeee'][] = $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Prueba_Academica']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Prueba_Academica']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Prueba_Academica']['Count'][] = $C_Datos['Prueba_Academica']['Count'];
                                    $D_Porcentaje ['Prueba_Academica']['SumaCount'] += $C_Datos['Prueba_Academica']['Count'];
                        }break;
                        case '300':{
                                    $D_Porcentaje ['Admitido']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Admitido']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Admitido']['Count'][] = $C_Datos['Admitido']['Count'];
                                    $D_Porcentaje ['Admitido']['SumaCount'] += $C_Datos['Admitido']['Count'];
                        }break;
                        case '301':{
                                    $D_Porcentaje ['Normal']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Normal']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Normal']['Count'][] = $C_Datos['Normal']['Count'];
                                    $D_Porcentaje ['Normal']['SumaCount'] += $C_Datos['Normal']['Count'];
                        }break;
                        case '302':{
                                    $D_Porcentaje ['SolicitudReservaCupo']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['SolicitudReservaCupo']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['SolicitudReservaCupo']['Count'][] = $C_Datos['SolicitudReservaCupo']['Count'];
                                    $D_Porcentaje ['SolicitudReservaCupo']['SumaCount'] += $C_Datos['SolicitudReservaCupo']['Count'];
                        }break;
                        case '400':{
                                    $D_Porcentaje ['Graduado']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['Graduado']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['Graduado']['Count'][] = $C_Datos['Graduado']['Count'];
                                    $D_Porcentaje ['Graduado']['SumaCount'] += $C_Datos['Graduado']['Count'];
                        }break;
                        case '500':{
                                    $D_Porcentaje ['EnProceso_Grado']['Porcentaje'] += $C_Datos['Porcentaje'][$j];
                                    $D_Porcentaje ['EnProceso_Grado']['Nombre'][] = $C_Datos['Nombre'][$j];
                                    $D_Porcentaje ['EnProceso_Grado']['Count'][] = $C_Datos['EnProceso_Grado']['Count'];
                                    $D_Porcentaje ['EnProceso_Grado']['SumaCount'] += $C_Datos['EnProceso_Grado']['Count'];
                        }break;
                    }//switch
                /************************************************************************************/
            }//for
            /**************************************************************************/

        }//for
        
    //echo '<pre>';print_r($D_Porcentaje);   
        
    $C_Situacion  = array();    
    
    //echo '<br>'.$D_Porcentaje['P_Academica']['Porcentaje'].'/'.count($D_Porcentaje['P_Academica']['Nombre']);
        
    $Num_P_Academica  = number_format((($D_Porcentaje['P_Academica']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_P_Academica>0){
        
        $C_Situacion['Porcentaje'][] = $Num_P_Academica;
        $C_Situacion['Nombre'][] = 'Perdida Academica '.$Num_P_Academica.'%';
        $C_Situacion['Codigo'][] = '100';
        
    }
    
    $Num_P_Disciplinaria = number_format((($D_Porcentaje['P_Disciplinaria']['SumaCount']*100)/$T_Desercion),'2','.','.');
        
    if($Num_P_Disciplinaria>0){
        
        $C_Situacion['Porcentaje'][] = $Num_P_Disciplinaria;
        $C_Situacion['Nombre'][] = 'Perdida Disiplinaria '.$Num_P_Disciplinaria.'%';
        $C_Situacion['Codigo'][] = '101';
        
    }
    
    $Num_P_Administrativa = number_format((($D_Porcentaje['P_Administrativa']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_P_Administrativa>0){
        
        $C_Situacion['Porcentaje'][] = $Num_P_Administrativa;
        $C_Situacion['Nombre'][] = 'Perdida Administrativa '.$Num_P_Administrativa.'%';
        $C_Situacion['Codigo'][] = '102';
        
    }
    
    $Num_P_Voluntaria = number_format((($D_Porcentaje['P_Voluntaria']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_P_Voluntaria>0){
        
        $C_Situacion['Porcentaje'][] = $Num_P_Voluntaria;
        $C_Situacion['Nombre'][] = 'Perdida Voluntaria '.$Num_P_Voluntaria.'%';
        $C_Situacion['Codigo'][] = '103';
    }
    
    $Num_Egresado = number_format((($D_Porcentaje['Egresado']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Egresado>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Egresado;
        $C_Situacion['Nombre'][] = 'Egresado '.$Num_Egresado.'%';
        $C_Situacion['Codigo'][] = '104';
    }
    
    $Num_Admitido_no = number_format((($D_Porcentaje['Admitido_no']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Admitido_no>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Admitido_no;
        $C_Situacion['Nombre'][] = 'Admitido que no Ingreso '.$Num_Admitido_no.'%';
        $C_Situacion['Codigo'][] = '105';
    }
    
    $Num_Preinscrito = number_format((($D_Porcentaje['Preinscrito']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Preinscrito>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Preinscrito;
        $C_Situacion['Nombre'][] = 'Preinscrito '.$Num_Preinscrito.'%';
        $C_Situacion['Codigo'][] = '106';
    }
    $Num_Inscrito = number_format((($D_Porcentaje['Inscrito']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Inscrito>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Inscrito;
        $C_Situacion['Nombre'][] = 'Inscrito '.$Num_Inscrito.'%';
        $C_Situacion['Codigo'][] = '107';
    }
    
    $Num_Reserva_Cupo = number_format((($D_Porcentaje['Reserva_Cupo']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Reserva_Cupo>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Reserva_Cupo;
        $C_Situacion['Nombre'][] = 'Reserva de cupo '.$Num_Reserva_Cupo.'%';
        $C_Situacion['Codigo'][] = '108';
    }
    
    $Num_Registro_Anulado = number_format((($D_Porcentaje['Registro_Anulado']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Registro_Anulado>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Registro_Anulado;
        $C_Situacion['Nombre'][] = 'Registro Anulado '.$Num_Registro_Anulado.'%';
        $C_Situacion['Codigo'][] = '109';
    }
    
    $Num_PendienteConsejo = number_format((($D_Porcentaje['PendienteConsejo']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_PendienteConsejo>0){
        
        $C_Situacion['Porcentaje'][] = $Num_PendienteConsejo;
        $C_Situacion['Nombre'][] = 'Pendiente Decision Consejo Facultad '.$Num_PendienteConsejo.'%';
        $C_Situacion['Codigo'][] = '110';
    }
    
    $Num_InsSinPago = number_format((($D_Porcentaje['InsSinPago']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_InsSinPago>0){
        
        $C_Situacion['Porcentaje'][] = $Num_InsSinPago;
        $C_Situacion['Nombre'][] = 'Inscrito sin pago '.$Num_InsSinPago.'%';
        $C_Situacion['Codigo'][] = '111';
    }
   
    $Num_CursoEduNoFormal = number_format((($D_Porcentaje['CursoEduNoFormal']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_CursoEduNoFormal>0){
        
        $C_Situacion['Porcentaje'][] = $Num_CursoEduNoFormal;
        $C_Situacion['Nombre'][] = 'Terminacion de curso o educacion no formal '.$Num_CursoEduNoFormal.'%';
        $C_Situacion['Codigo'][] = '112';
    }
    
    $Num_No_Admitido = number_format((($D_Porcentaje['No_Admitido']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_No_Admitido>0){
        
        $C_Situacion['Porcentaje'][] = $Num_No_Admitido;
        $C_Situacion['Nombre'][] = 'No Admitido '.$Num_No_Admitido.'%';
        $C_Situacion['Codigo'][] = '113';
    }
     
    $Num_EnProcesoFinanciacion = number_format((($D_Porcentaje['EnProcesoFinanciacion']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_EnProcesoFinanciacion>0){
        
        $C_Situacion['Porcentaje'][] = $Num_EnProcesoFinanciacion;
        $C_Situacion['Nombre'][] = 'En proceso de financiacion '.$Num_EnProcesoFinanciacion.'%';
        $C_Situacion['Codigo'][] = '114';
    }
    
    $Num_Lista_Espera = number_format((($D_Porcentaje['Lista_Espera']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Lista_Espera>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Lista_Espera;
        $C_Situacion['Nombre'][] = 'Lista en Espera '.$Num_Lista_Espera.'%';
        $C_Situacion['Codigo'][] = '115';
    }
    
    $Num_Prueba_Academica = number_format((($D_Porcentaje['Prueba_Academica']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Prueba_Academica>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Prueba_Academica;
        $C_Situacion['Nombre'][] = 'Prueba Academica '.$Num_Prueba_Academica.'%';
        $C_Situacion['Codigo'][] = '200';
    }
    
    $Num_Admitido = number_format((($D_Porcentaje['Admitido']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Admitido>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Admitido;
        $C_Situacion['Nombre'][] = 'Admitido '.$Num_Admitido.'%';
        $C_Situacion['Codigo'][] = '300';
    }
     
    $Num_Normal = number_format((($D_Porcentaje['Normal']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Normal>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Normal;
        $C_Situacion['Nombre'][] = 'Normal '.$Num_Normal.'%';
        $C_Situacion['Codigo'][] = '301';
    }
    
    $Num_SolicitudReservaCupo = number_format((($D_Porcentaje['SolicitudReservaCupo']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_SolicitudReservaCupo>0){
        
        $C_Situacion['Porcentaje'][] = $Num_SolicitudReservaCupo;
        $C_Situacion['Nombre'][] = 'Solicitud reserva de cupo '.$Num_SolicitudReservaCupo.'%';
        $C_Situacion['Codigo'][] = '302';
    }
   
    $Num_Graduado = number_format((($D_Porcentaje['Graduado']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_Graduado>0){
        
        $C_Situacion['Porcentaje'][] = $Num_Graduado;
        $C_Situacion['Nombre'][] = 'Graduado '.$Num_Graduado.'%';
        $C_Situacion['Codigo'][] = '400';
    }
   
    $Num_EnProceso_Grado = number_format((($D_Porcentaje['EnProceso_Grado']['SumaCount']*100)/$T_Desercion),'2','.','.');
    
    if($Num_EnProceso_Grado>0){
        
        $C_Situacion['Porcentaje'][] = $Num_EnProceso_Grado;
        $C_Situacion['Nombre'][] = 'En proceso de Grado '.$Num_EnProceso_Grado.'%';
        $C_Situacion['Codigo'][] = '500';
    }
        
       // echo '<pre>';print_r($C_Situacion);die;
       
       return $C_Situacion;
    
  }//public function CausasDesercionTotalSemestral
 public function SumaTotalAnual($Periodos){
    global $db;
    
    
     $SQL='SELECT

            SUM(x.matriculados) as T_Matriculados,
            SUM(x.desercion) AS T_Desercion
            
            FROM(
            
                    SELECT 
                   
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
                            dd.periodos="'.$Periodos.'"
                    
                    GROUP BY  d.id_desercion
            
            ) x';
            
        if($TotalesAnual=&$db->Execute($SQL)===false){
            echo 'error en el SQl de los Totales anuales...<br><br>'.$SQL;
            die;
        }
        
        
      $R_TotalAnual = array();
      
      $R_TotalAnual['TotalMatriculados']  = $TotalesAnual->fields['T_Matriculados'];      
      $R_TotalAnual['TotalDesercion']  = $TotalesAnual->fields['T_Desercion'];
      
      $PocentajeAnual  = (($TotalesAnual->fields['T_Desercion']/$TotalesAnual->fields['T_Matriculados'])*100);
      
      $R_TotalAnual['TotalPorcentaje']  = number_format($PocentajeAnual,'2','.','.');
      
      return $R_TotalAnual;

 }//public function SumaTotalAnual  
 public function Cohorte($Periodo,$Carrera_id,$Periodo_2){
    global $db;
    
    
    $D_Cohorte  = array();
    
    /*********************************************************************************************/
    
    
        /*****************************************************************************************/
        if($Periodo_2==$Periodo){
            /*************************************************************************************/
            $SQL_InicioCohorte='SELECT

                                COUNT(dc.id_DesercionChohorte)  AS Num,
                                d.id_desercion,
                                dc.id_desercion
                                
                                FROM
                                
                                desercion d INNER JOIN DesercionChohorte dc ON d.id_desercion=dc.id_desercion
                                
                                
                                WHERE
                                
                                d.tipodesercion=3
                                AND
                                d.codigocarrera="'.$Carrera_id.'"
                                AND
                                dc.codigoperiodo="'.$Periodo.'"
                                AND
                                dc.nuevo=1';
                                
                if($InicioCohorte=&$db->Execute($SQL_InicioCohorte)===false){
                    echo 'error en el SQl de Incio de Cohorte ...<br><br>'.$SQL_InicioCohorte;
                    die;
                }       
                
                $D_Cohorte[$Periodo][$Carrera_id][$Periodo_2]['Matriculados'] =  $InicioCohorte->fields['Num']; 
                $D_Cohorte[$Periodo][$Carrera_id][$Periodo_2]['Desercion']    =  0; 
                $D_Cohorte[$Periodo][$Carrera_id][$Periodo_2]['Porcentaje_Matriculados']   =  100;                      
                $D_Cohorte[$Periodo][$Carrera_id][$Periodo_2]['Porcentaje_Desercion']   =  0;          
            /*************************************************************************************/
        }else if($Periodo_2!=$Periodo){
            /*************************************************************************************/
            $SQL_InicioCohorte='SELECT

                                COUNT(dc.id_DesercionChohorte)  AS Num,
                                d.id_desercion,
                                dc.id_desercion
                                
                                
                                
                                FROM
                                
                                desercion d INNER JOIN DesercionChohorte dc ON d.id_desercion=dc.id_desercion
                                
                                
                                WHERE
                                
                                d.tipodesercion=3
                                AND
                                d.codigocarrera="'.$Carrera_id.'"
                                AND
                                dc.codigoperiodo="'.$Periodo.'"
                                AND
                                dc.nuevo=1';
                                
                if($InicioCohorte=&$db->Execute($SQL_InicioCohorte)===false){
                    echo 'error en el SQl de Incio de Cohorte ...<br><br>'.$SQL_InicioCohorte;
                    die;
                }
                
                $MatriculadosInicio   = $InicioCohorte->fields['Num'];
            /*************************************************************************************/
               $SQL_SigCohorte='SELECT

                                COUNT(dc.id_DesercionChohorte) AS Num
                                
                                FROM
                                
                                DesercionChohorte dc,
                                
                                (
                                
                                SELECT
                                
                                dc.codigoestudiante
                                
                                 
                                
                                FROM
                                
                                desercion d,
                                
                                DesercionChohorte dc
                                
                                 
                                
                                WHERE
                                
                                d.id_desercion=dc.id_desercion and
                                
                                d.tipodesercion=3 AND
                                
                                d.codigocarrera="'.$Carrera_id.'" AND
                                
                                dc.codigoperiodo="'.$Periodo.'" AND
                                
                                dc.nuevo=1
                                
                                ) ini
                                
                                
                                WHERE
                                
                                ini.codigoestudiante = dc.codigoestudiante and
                                
                                dc.codigoperiodo="'.$Periodo_2.'" AND
                                
                                dc.nuevo=0';
              
              
              if($SigCohorte=&$db->Execute($SQL_SigCohorte)===false){
                    echo 'error en el SQl de Sig de Cohorte ...<br><br>'.$SQL_SigCohorte;
                    die;
                }
                
                
              $SQL_DesCohorte='SELECT

                                COUNT(dc.id_DesercionChohorte) AS Num
                                
                                FROM
                                
                                DesercionChohorte dc,
                                
                                (
                                
                                SELECT
                                
                                dc.codigoestudiante
                                
                                 
                                
                                FROM
                                
                                desercion d,
                                
                                DesercionChohorte dc
                                
                                 
                                
                                WHERE
                                
                                d.id_desercion=dc.id_desercion and
                                
                                d.tipodesercion=3 AND
                                
                                d.codigocarrera="'.$Carrera_id.'" AND
                                
                                dc.codigoperiodo="'.$Periodo.'" AND
                                
                                dc.nuevo=1
                                
                                ) ini
                                
                                
                                WHERE
                                
                                ini.codigoestudiante = dc.codigoestudiante and
                                
                                dc.codigoperiododesercion="'.$Periodo_2.'" AND
                                
                                dc.nuevo=0'; 
                                   
                    if($DesercionCohorte=&$db->Execute($SQL_DesCohorte)===false){
                        echo 'Error en el SQl de Desercion Cohorte...<br><br>'.$SQL_DesCohorte;
                        die;
                    }             
                
             $D_Cohorte[$Periodo][$Carrera_id][$Periodo_2]['Matriculados'] =  $SigCohorte->fields['Num']; 
             $D_Cohorte[$Periodo][$Carrera_id][$Periodo_2]['Desercion']    =  $DesercionCohorte->fields['Num']; 
             /**************************************************************************************************************/
             
             if($SigCohorte->fields['Num']==0 && $DesercionCohorte->fields['Num']==0){
                $Porcentaje  = 0;
                $Porcentaje_D  = 0;
             }else{
                
                $Porcentaje  = (($SigCohorte->fields['Num']*100)/$MatriculadosInicio);
                $Porcentaje_D = (100-$Porcentaje);
                
             }
             
             /**************************************************************************************************************/
             $D_Cohorte[$Periodo][$Carrera_id][$Periodo_2]['Porcentaje_Matriculados']   =  number_format($Porcentaje,'2','.','.');                      
             $D_Cohorte[$Periodo][$Carrera_id][$Periodo_2]['Porcentaje_Desercion']   =  number_format($Porcentaje_D,'2','.','.');  
            /*************************************************************************************/
        }
        /*****************************************************************************************/
     
    /*********************************************************************************************/
  
  //echo '<pre>';print_r($D_Cohorte); die; 
  
  return $D_Cohorte;
}//public function Cohorte
public function DisplayCohorte($CodigoPeriodo){
    global $db;
    
    //$CodigoPeriodo  = '20082';
 
    $_D_Periodos   = $this->CortesDinamicas($CodigoPeriodo);
    
    $C_Carrera   = $this->Carreras();
   
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
						"iFixedColumns": 1
					},
                    "oColVis": {
                            "buttonText": "Ver/Ocultar Columns",
                             "aiExclude": [ 0 ]
                      }
                    
                    
					
				} );
				//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 2,
                                         "iLeftWidth": 550
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
    <div id="demo_1">
    <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
        <thead>
            <tr>
                <th rowspan="2" class="bl bt">N&deg;</th>
                <th rowspan="2" class="bl bt">Carrera</th>
            <?PHP 
            for($P=0;$P<count($_D_Periodos['ViewPeriodo']);$P++){
            ?>
            <th colspan="4" class="bl br bt"><?PHP echo $_D_Periodos['ViewPeriodo'][$P]?></th>
            <?PHP
            }//For Periodos
            ?>
            </tr>
            <tr>
            <?PHP 
            for($P=0;$P<count($_D_Periodos['ViewPeriodo']);$P++){
            ?>
                <th>Matriculados</th>
                <th>Desercion</th>
                <th>Porcentaje Matriculados (%)</th>
                <th>Porcentaje Desercion (%)</th>
            <?PHP
            }//For Periodos
            ?>    
            </tr>
        </thead>
        <tbody>
        <?PHP
        for($C=0;$C<count($C_Carrera);$C++){
           /**********************************************************/
           $Carrera_id    = $C_Carrera[$C]['codigocarrera'];
           
            //
           ?>
           <tr>
               <td><?PHP echo $C+1?></td> 
               <td><?PHP echo $C_Carrera[$C]['nombrecarrera']?></td>
           <?PHP 
            for($J=0;$J<count($_D_Periodos['CodigoPeriodo']);$J++){
            
                  $C_Cohorte  = $this->Cohorte($CodigoPeriodo,$Carrera_id,$_D_Periodos['CodigoPeriodo'][$J]);  
                 ?>
                <td><?PHP echo $C_Cohorte[$CodigoPeriodo][$Carrera_id][$_D_Periodos['CodigoPeriodo'][$J]]['Matriculados']?></td>
                <td><?PHP echo $C_Cohorte[$CodigoPeriodo][$Carrera_id][$_D_Periodos['CodigoPeriodo'][$J]]['Desercion']?></td>
                <td><?PHP echo $C_Cohorte[$CodigoPeriodo][$Carrera_id][$_D_Periodos['CodigoPeriodo'][$J]]['Porcentaje_Matriculados']?>%</td>
                <td><?PHP echo $C_Cohorte[$CodigoPeriodo][$Carrera_id][$_D_Periodos['CodigoPeriodo'][$J]]['Porcentaje_Desercion']?>%</td>
                 <?PHP
             }    
           ?>
           </tr>
           <?PHP 
           /**********************************************************/ 
        }//for
        ?>
        </tbody>
    </table>
    </div>
    <?PHP
    
}//public function DisplayCohorte
public function CortesDinamicas($Periodo){
    
   
    
    $arrayP = str_split($Periodo, strlen($Periodo)-1);

    $year = $arrayP[0];
    $P_Ini = $arrayP[1];
    
    $C_Periodos   = array();
    
    for($i=1;$i<=20;$i++){
                /***********************************************************************/
                if($i==1){//if..1
                    $PeriodoView  = $year.'-'.$P_Ini;
                    $CodigoPeriodo = $Periodo;
                }else{
                    if($P_Ini==2){////if..2
                        $year  = $year+1;
                        $P_Ini = 1;
                        $PeriodoView  = $year.'-'.$P_Ini;
                        $CodigoPeriodo = $year.$P_Ini;
                    }else{
                        if($P_Ini==1){
                           $P_Ini = 2; 
                        }
                        $PeriodoView  = $year.'-'.$P_Ini;
                        $CodigoPeriodo = $year.$P_Ini;
                    }//if..2
                }//if..1
                
         $C_Periodos['CodigoPeriodo'][]=   $CodigoPeriodo;
         $C_Periodos['ViewPeriodo'][]=   $PeriodoView;    
     }     
    
    //echo '<pre>';print_r($C_Periodos);
    return $C_Periodos;
    
}
}/*Class*/

?>