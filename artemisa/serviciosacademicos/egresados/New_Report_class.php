<?php
class New_Report{
    public function DataReport($id,$Modalidad='',$Carrera='',$op=''){
        global $db;
        
        
          $SQL='SELECT 
                
                idlabel_type,
                idPregunta,
                cat_ins
                
                FROM 
                
                label
                
                WHERE
                
                cat_ins="EGRESADOS"
                AND
                status=1';
                
           if($ExisteLabel=&$db->Execute($SQL)===false){
            echo 'Error en el SQl de Label´s.....<br><br>'.$SQL;
            die;
           }
            /////Mofificacion Ing.Milton Chacon  11/09/2014
            ///// multiples modalidades y carreras
            /////
            /////
            //
            
            ///modalidaddes
            if(isset($Carrera)&&(count($Carrera)>0)&&(($Carrera[0]!="-1")||($Carrera[0]!=-1))){
                $contador_sql=count($Carrera);
                $array_id=$Carrera;
                $t_union="c";
            }else{
                if(isset($Modalidad)&&(count($Modalidad))){
                    $contador_sql=count($Modalidad);
                    $array_id=$Modalidad;  
                    $t_union="m";
                }
                
            }
                
                        
             
        //fin codigo
            
          
            
            
            
          // $Label  = $ExisteLabel->GetArray(); 
               
           $C_Data = array();
           $C_Preguntas = array();
           
           if(!$ExisteLabel->EOF){
                while(!$ExisteLabel->EOF){
                    /**************************************/
                    $Pregunta  = $ExisteLabel->fields['idPregunta'];
                    $C_Preguntas[$id][]=$Pregunta;
                    /**************************************/
                    
                    
                    ////modificacion para busqueda general y especifica
                    /*
                        Ing.Milton Chacon 
                        modificacion 12092014
                    
                    */
                    if($t_union=="c"){
                        $i=0;
                        foreach ($array_id as $item_union){
                            $FROM = ' INNER JOIN estudiantegeneral eg ON eg.numerodocumento=r.cedula
					              INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
						          INNER JOIN carrera c  ON c.codigocarrera=e.codigocarrera';
                        
                        
                            $WHERE = ' AND  c.codigocarrera IN ('.$item_union.')';
                            
                            if($i>0){
                                $SQL_interno=$SQL_interno."UNION(SELECT

                                x.idsiq_Apreguntarespuesta,
                                COUNT(x.respuesta) AS num,
                                x.respuesta
                                
                                FROM(   SELECT 
                                
                                        r.idsiq_Apreguntarespuesta,
                                        rr.respuesta,
                                        rr.valor,
                                        rr.unica_respuesta,
                                        rr.multiple_respuesta,
                                        r.idsiq_Ainstrumentoconfiguracion
                                        
                                        FROM siq_Arespuestainstrumento r  INNER JOIN siq_Apreguntarespuesta rr ON rr.idsiq_Apreguntarespuesta=r.idsiq_Apreguntarespuesta 
																		  ".$FROM."
                                        
                                        WHERE 
                                        r.idsiq_Ainstrumentoconfiguracion IN (".$id.")
                                        AND 
                                        r.idsiq_Apregunta =".$Pregunta." 
                                        AND
                                        r.codigoestado=100
                                        AND
                                        rr.codigoestado=100
                                        ".$WHERE."
                                        
                                        GROUP BY r.cedula
                                        
                                        ORDER BY rr.respuesta  ASC) x 
                                
                                GROUP BY x.respuesta)";
                            }else{
                                
                                $SQL_interno="(SELECT

                                x.idsiq_Apreguntarespuesta,
                                COUNT(x.respuesta) AS num,
                                x.respuesta
                                
                                FROM(   SELECT 
                                
                                        r.idsiq_Apreguntarespuesta,
                                        rr.respuesta,
                                        rr.valor,
                                        rr.unica_respuesta,
                                        rr.multiple_respuesta,
                                        r.idsiq_Ainstrumentoconfiguracion
                                        
                                        FROM siq_Arespuestainstrumento r  INNER JOIN siq_Apreguntarespuesta rr ON rr.idsiq_Apreguntarespuesta=r.idsiq_Apreguntarespuesta 
																		  ".$FROM."
                                        
                                        WHERE 
                                        r.idsiq_Ainstrumentoconfiguracion IN (".$id.")
                                        AND 
                                        r.idsiq_Apregunta =".$Pregunta." 
                                        AND
                                        r.codigoestado=100
                                        AND
                                        rr.codigoestado=100
                                        ".$WHERE."
                                        
                                        GROUP BY r.cedula
                                        
                                        ORDER BY rr.respuesta  ASC) x 
                                
                                GROUP BY x.respuesta)";
                                
                            }///end if
                            
                            $i++;
                                    
                        }/////end for
                        
                    }else{////fin if de "c"
                        if($t_union=="m"){
                                $i=0;
                                foreach ($array_id as $item_union){
                                    $FROM = ' INNER JOIN estudiantegeneral eg ON eg.numerodocumento=r.cedula
					              INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
						          INNER JOIN carrera c  ON c.codigocarrera=e.codigocarrera';       
                                    $WHERE = ' AND c.codigomodalidadacademica IN ('.$item_union.')'; 
                                    
                                    if($i>0){
                                        $SQL_interno=$SQL_interno."UNION(SELECT
        
                                        x.idsiq_Apreguntarespuesta,
                                        COUNT(x.respuesta) AS num,
                                        x.respuesta
                                        
                                        FROM(   SELECT 
                                        
                                                r.idsiq_Apreguntarespuesta,
                                                rr.respuesta,
                                                rr.valor,
                                                rr.unica_respuesta,
                                                rr.multiple_respuesta,
                                                r.idsiq_Ainstrumentoconfiguracion
                                                
                                                FROM siq_Arespuestainstrumento r  INNER JOIN siq_Apreguntarespuesta rr ON rr.idsiq_Apreguntarespuesta=r.idsiq_Apreguntarespuesta 
        																		  ".$FROM."
                                                
                                                WHERE 
                                                r.idsiq_Ainstrumentoconfiguracion IN (".$id.")
                                                AND 
                                                r.idsiq_Apregunta =".$Pregunta." 
                                                AND
                                                r.codigoestado=100
                                                AND
                                                rr.codigoestado=100
                                                ".$WHERE."
                                                
                                                GROUP BY r.cedula
                                                
                                                ORDER BY rr.respuesta  ASC) x 
                                        
                                        GROUP BY x.respuesta)";
                                    }else{
                                        
                                        $SQL_interno="(SELECT
        
                                        x.idsiq_Apreguntarespuesta,
                                        COUNT(x.respuesta) AS num,
                                        x.respuesta
                                        
                                        FROM(   SELECT 
                                        
                                                r.idsiq_Apreguntarespuesta,
                                                rr.respuesta,
                                                rr.valor,
                                                rr.unica_respuesta,
                                                rr.multiple_respuesta,
                                                r.idsiq_Ainstrumentoconfiguracion
                                                
                                                FROM siq_Arespuestainstrumento r  INNER JOIN siq_Apreguntarespuesta rr ON rr.idsiq_Apreguntarespuesta=r.idsiq_Apreguntarespuesta 
        																		  ".$FROM."
                                                
                                                WHERE 
                                                r.idsiq_Ainstrumentoconfiguracion IN (".$id.")
                                                AND 
                                                r.idsiq_Apregunta =".$Pregunta." 
                                                AND
                                                r.codigoestado=100
                                                AND
                                                rr.codigoestado=100
                                                ".$WHERE."
                                                
                                                GROUP BY r.cedula
                                                
                                                ORDER BY rr.respuesta  ASC) x 
                                        
                                        GROUP BY x.respuesta)";
                                        
                                    }///end if
                                    
                                    $i++;
                                            
                                }/////end for
                                
                            
                        }else{////condicion final para $SQL_interno
                            $FROM = '';       
                            $WHERE = ''; 
                            $SQL_interno="(SELECT
        
                                        x.idsiq_Apreguntarespuesta,
                                        COUNT(x.respuesta) AS num,
                                        x.respuesta
                                        
                                        FROM(   SELECT 
                                        
                                                r.idsiq_Apreguntarespuesta,
                                                rr.respuesta,
                                                rr.valor,
                                                rr.unica_respuesta,
                                                rr.multiple_respuesta,
                                                r.idsiq_Ainstrumentoconfiguracion
                                                
                                                FROM siq_Arespuestainstrumento r  INNER JOIN siq_Apreguntarespuesta rr ON rr.idsiq_Apreguntarespuesta=r.idsiq_Apreguntarespuesta 
        																		  ".$FROM."
                                                
                                                WHERE 
                                                r.idsiq_Ainstrumentoconfiguracion IN (".$id.")
                                                AND 
                                                r.idsiq_Apregunta =".$Pregunta." 
                                                AND
                                                r.codigoestado=100
                                                AND
                                                rr.codigoestado=100
                                                ".$WHERE."
                                                
                                                GROUP BY r.cedula
                                                
                                                ORDER BY rr.respuesta  ASC) x 
                                        
                                        GROUP BY x.respuesta)";
                        }
                    }
                    
                    
                    
                    
                    
                    
                    /////////---------------fin mofificacion 12092014---------/////////////////////
                    /*if(($Modalidad[0]!='-1' || $Modalidad[0]!=-1) && ($Carrera[0]!='-1' || $Carrera[0]!=-1)){
                        $FROM = ' INNER JOIN estudiantegeneral eg ON eg.numerodocumento=r.cedula
					              INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
						          INNER JOIN carrera c  ON c.codigocarrera=e.codigocarrera';
                        
                        
                        $WHERE = ' AND  c.codigocarrera IN ('.$cadCra.')';  
                           
                        
                          
                    }else if(($Modalidad[0]=='-1' || $Modalidad[0]==-1) && ($Carrera[0]=='-1' || $Carrera[0]==-1)){
                        $FROM = '';
                        $WHERE = '';
                    }else if(($Modalidad[0]!='-1' || $Modalidad[0]!=-1) && ($Carrera[0]=='-1' || $Carrera[0]==-1)){
                        $FROM = ' INNER JOIN estudiantegeneral eg ON eg.numerodocumento=r.cedula
					              INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
						          INNER JOIN carrera c  ON c.codigocarrera=e.codigocarrera';       
                        $WHERE = ' AND c.codigomodalidadacademica IN ('.$cadMod.')'; 
                    }*/
                              
                               
                    /**************************************/
                     /*$SQL_Data='SELECT

                                x.idsiq_Apreguntarespuesta,
                                COUNT(x.respuesta) AS num,
                                x.respuesta
                                
                                FROM(   SELECT 
                                
                                        r.idsiq_Apreguntarespuesta,
                                        rr.respuesta,
                                        rr.valor,
                                        rr.unica_respuesta,
                                        rr.multiple_respuesta,
                                        r.idsiq_Ainstrumentoconfiguracion
                                        
                                        FROM siq_Arespuestainstrumento r  INNER JOIN siq_Apreguntarespuesta rr ON rr.idsiq_Apreguntarespuesta=r.idsiq_Apreguntarespuesta 
																		  '.$FROM.'
                                        
                                        WHERE 
                                        r.idsiq_Ainstrumentoconfiguracion IN ('.$id.')
                                        AND 
                                        r.idsiq_Apregunta ="'.$Pregunta.'" 
                                        AND
                                        r.codigoestado=100
                                        AND
                                        rr.codigoestado=100
                                        '.$WHERE.'
                                        
                                        GROUP BY r.cedula
                                        
                                        ORDER BY rr.respuesta  ASC) x 
                                
                                GROUP BY x.respuesta';*/
                                
                                $SQL_Data='SELECT

                                y.idsiq_Apreguntarespuesta,
                                SUM(y.num) AS num,
                                y.respuesta
                                
                                FROM('.$SQL_interno.') y 
                                
                                GROUP BY y.respuesta';
                                
                              //echo $SQL_Data."<br>";die;  
                                
                         if($Data=&$db->Execute($SQL_Data)===false){
                            echo 'Error en el SQl Data ....<br><br>'.$SQL_Data;
                            die;
                         }
                         
                         $D_Result = $Data->GetArray();
                         
                         $C_Data[$id][$Pregunta]['Data'] =$D_Result;
                                
                    /**************************************/
                    $ExisteLabel->MoveNext();
                }//while
           }else{
                echo 'No Exiten Preguntas....';
           } 
         
         $C_Suma = array();
         
         for($i=0;$i<count($C_Preguntas[$id]);$i++){
        /*******************************************************/
           $C_Info = $C_Data[$id][$C_Preguntas[$id][$i]]['Data'];
           
           $Suma = 0;
           
          for($j=0;$j<count($C_Info);$j++){
            
            $Suma = $Suma+$C_Info[$j]['num'];     
            
           }//for 
           
           $C_Suma[] = $Suma;
        /*******************************************************/
        }//for       
         
         //echo '<pre>';print_r($C_Suma);
         
         $D_Info = array();
         
         for($i=0;$i<count($C_Preguntas[$id]);$i++){
            
             $C_Info = $C_Data[$id][$C_Preguntas[$id][$i]]['Data'];
             
             for($j=0;$j<count($C_Info);$j++){
                
                $Pocentaje = (($C_Info[$j]['num']*100)/$C_Suma[$i]);
                
                $D_Info[$id][$C_Preguntas[$id][$i]][$j]['idsiq_Apreguntarespuesta'] = $C_Info[$j]['idsiq_Apreguntarespuesta']; 
                $D_Info[$id][$C_Preguntas[$id][$i]][$j]['num']                      = $C_Info[$j]['num']; 
                $D_Info[$id][$C_Preguntas[$id][$i]][$j]['respuesta']                = utf8_decode($C_Info[$j]['respuesta']); 
                $D_Info[$id][$C_Preguntas[$id][$i]][$j]['porcentaje']               = number_format($Pocentaje,'2','.',',');
                
             }//for
             
            
         }//for
         
         $P = '';
         $L = '';
         for($i=0;$i<count($C_Preguntas[$id]);$i++){
             $C_Info = $D_Info[$id][$C_Preguntas[$id][$i]];
             
              for($x=0;$x<count($C_Info);$x++){
                    
                    if($x>0){
                        $P = $P.','.$C_Info[$x]['porcentaje'];
                        $L = $L.'|'.$C_Info[$x]['respuesta'];
                    }else{
                        $P = $C_Info[$x]['porcentaje'];
                        $L = $C_Info[$x]['respuesta'];
                    }
                    
              }//for
            $Porcentaje[$i] = $P;
            $Labels[$i]      = $L;
         }//for
        
        $DataFormulaio = array();
        
        $DataFormulaio['Preguntas'] = $C_Preguntas;
        $DataFormulaio['Data']      = $D_Info;
        
        $DataFinal = array();
        
        $DataFinal['Valores']  = $Porcentaje;
        $DataFinal['Labels']   = $Labels;
        
        if($op=='Formulaio'){
            return $DataFormulaio;
        }else{
           return $DataFinal;    
        }
        
        
        
    }//public function Report
    public function DataPreguntas($id){
        global $db;
        
        $SQL='SELECT titulo FROM siq_Apregunta WHERE idsiq_Apregunta ="'.$id.'"  AND codigoestado=100';
        
        if($Pregunta=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Data Pregunta...<br><br>'.$SQL;
            die;
        }
        
        return $Pregunta->fields['titulo'];
    }//public function DataPreguntas
    public function ViewReport($id,$Modalidad='',$Carrera='',$ExcelReporte=''){
        
        $Reslutado = $this->DataReport($id,$Modalidad,$Carrera);
        $Data      = $this->DataReport($id,$Modalidad,$Carrera,'Formulaio');
        
        //echo '<pre>';print_r($Data);
        ?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        </head>
        <body>
        <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
        <?PHP
        
        for($i=0;$i<count($Reslutado['Valores']);$i++){
            $Name = $this->DataPreguntas($Data['Preguntas'][$id][$i]);
            $t = $Reslutado['Valores'][$i];
            $x = $Reslutado['Labels'][$i];
            ?>
            <tr>
                <td style="color: #FF9E08;"><strong><?PHP echo $Name?></strong></td>
            </tr>
            <tr>
                <td>
                <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
                <?PHP 
                $Info = $Data['Data'][$id][$Data['Preguntas'][$id][$i]];
                $Suma = 0;
                for($j=0;$j<count($Info);$j++){
                    $Suma = $Suma+$Info[$j]['num'];
                    ?>
                    <tr>
                        <td>
                            <?PHP echo utf8_encode($Info[$j]['respuesta'])?>
                        </td>
                        <td>
                            <?PHP echo $Info[$j]['num']?>
                        </td>
                        <td align="right">
                            <?PHP echo $Info[$j]['porcentaje']?>
                        </td>
                    </tr>
                    <?PHP
                    
                }//for 
               
                ?>
                <tr>
                    <td style="color: #FF9E08;">Total</td>
                    <td style="color: #FF9E08;"><?PHP echo $Suma?></td>
                    <td>&nbsp;</td>
                </tr>
                </table>
                </td>
            </tr>   
            <tr>                                                                                                                                                                                                              
                <td>
                <img src="http://chart.apis.google.com/chart?chs=650x150&chd=t:<?PHP echo $t?>&cht=p3&chl=<?PHP echo utf8_encode($x)?>&chco=<?PHP echo $_REQUEST['color']?>&chdlp=r" alt="Primer ejemplo con Google Chart API" />
                </td>
            </tr>
            <?php
        }//for
               
        ?>        
        
        </table>
        </body>
              
        </html>
       <?PHP
       }    //public function ViewReport
    
    //////////functionreportExcel
    
    public function ViewReportExcel($id,$Modalidad='',$Carrera=''){
        
        $Reslutado = $this->DataReport($id,$Modalidad,$Carrera);
        $Data      = $this->DataReport($id,$Modalidad,$Carrera,'Formulaio');
        
        //echo '<pre>';print_r($Data);
        
            $Hora = date('Y-m-d');
		 
		 				header('Content-type: application/vnd.ms-excel');
						header("Content-Disposition: attachment; filename=reporte-".$Hora.".xls");
						header("Pragma: no-cache");
						header("Expires: 0");
         ?>
            <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
        <?PHP
        
        for($i=0;$i<count($Reslutado['Valores']);$i++){
            $Name = $this->DataPreguntas($Data['Preguntas'][$id][$i]);
            $t = $Reslutado['Valores'][$i];
            $x = $Reslutado['Labels'][$i];
            ?>
            <tr>
                <td style="color: #FF9E08;"><strong><?PHP echo utf8_decode($Name);?></strong></td>
            </tr>
            <tr>
                <td>
                <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
                <?PHP 
                $Info = $Data['Data'][$id][$Data['Preguntas'][$id][$i]];
                $Suma = 0;
                for($j=0;$j<count($Info);$j++){
                    $Suma = $Suma+$Info[$j]['num'];
                    ?>
                    <tr>
                        <td>
                            <?PHP echo utf8_encode($Info[$j]['respuesta'])?>
                        </td>
                        <td>
                            <?PHP echo $Info[$j]['num']?>
                        </td>
                        <td align="right">
                            <?PHP echo $Info[$j]['porcentaje']?>
                        </td>
                    </tr>
                    <?PHP
                    
                }//for 
               
                ?>
                <tr>
                    <td style="color: #FF9E08;">Total</td>
                    <td style="color: #FF9E08;"><?PHP echo $Suma?></td>
                    <td>&nbsp;</td>
                </tr>
                </table>
                </td>
            </tr> 
            <tr>
            <td>&nbsp;</td> 
            </tr>
                
                                                                                                                                                                                                                         
                <td>
                <img src="http://chart.apis.google.com/chart?chs=650x150&chd=t:<?PHP echo $t?>&cht=p3&chl=<?PHP echo utf8_encode($x)?>&chco=<?PHP echo $_REQUEST['color']?>&chdlp=r" alt="Primer ejemplo con Google Chart API" />
                </td>
            </tr>
            <tr>
            <td>&nbsp;</td> 
            </tr>  
            <tr>
            <td>&nbsp;</td> 
            </tr>  
            <tr>
            <td>&nbsp;</td> 
            </tr>  
            <tr>
            <td>&nbsp;</td> 
            </tr>  
            <tr>
            <td>&nbsp;</td> 
            </tr>  
            <tr>
            <td>&nbsp;</td> 
            </tr>  
            <tr>
            <td>&nbsp;</td> 
            </tr>  
            <?php
        }//for
               
        ?>        
        
        </table>
        
       <?php
       
    }//public function ViewReportExcel
    
    
    
    ////////////fin reportExecel
    
    
    public function Consola($id){
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            </head>
            <body >
            <form id="NewReport">
                <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="50%" align="center">
                    <thead>
                        <tr>
                            <th colspan="2" style="color: #FF9E08;">
                                <strong>RESULTADO DE GESTION EGRESADOS</strong><input type="hidden" id="actionID" name="actionID" value="Reporte" />
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <hr colspan="2" style="color:#FF9E08; width: 95%;" /><input type="hidden" id="id" name="id" value="<?PHP echo $id?>" />
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" style="color: #FF9E08;">
                                <strong>REPORTE</strong>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" style="color: #FF9E08;">Filtrar por:</td>
                        </tr>
                        <tr>
                            <td><strong>Modalidad Acad&eacute;mica</strong></td>
                            <td><?PHP $this->Select();?></td>
                        </tr>
                        <tr>
                            <td><strong>Carrera</strong></td>
                            <td id="Td_Carrera"><select><option></option></select></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Para seleccion Multiple usar TECLAS ("SHIFT") O ("CONTROL") sobre los items a seleccionar</strong></td>
                            
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                               <div><input type="button" id="Reporte" name="Reporte" onclick="GenerarNewReporte();" value="Generar Reporte" />
                                
                                    <input  type="button" id="ExportaExcel" name="ExportaExcel" onclick="ExportarReporteExcel();" value="Exportar Excel" style="visibility:  hidden; "  /><input type="hidden" id="reportexcel" name="reportexcel" value="" /></div>                            
                                
                              
                                
                            </td>
                        </tr>
                        <tr>
                            <td>Color</td>
                            <td>
                                <table border="0">
                                    <tr>
                                        <td bgcolor="9DA242">
                                            <input type="radio" id="Color" value="9DA242" name="color">
                                        </td>
                                        <td bgcolor="FF9E08">
                                            <input type="radio" id="Color" value="FF740000" name="color">
                                        </td>
                                        <td bgcolor="4D89D9">
                                            <input type="radio" id="Color" value="4D89D9" name="color">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <br />
                <table width="50%" align="center" border="0">
                    <tr  style="background-color: white;">
                        <td colspan="2">
                            <div id="Div_Carga"></div>
                        </td>
                    </tr>
                </table>
             </form>   
            </body>
        </html>
        <?PHP
    }//public function Consola
    public function Select(){
        global $db;
        
          $SQL='SELECT 

                codigomodalidadacademica AS id,
                nombremodalidadacademica AS Nombre
                
                FROM 
                
                modalidadacademica
                
                WHERE
                
                codigoestado=100';
                
         if($Consulta=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de LAs Modalidad Acdemica...<br><br>'.$SQL;
            die;
         }      
         ?>
         <select id="Modalidad" name="Modalidad[]" style="width:90%;" onchange="BuscarData();" multiple=""  size="5">
         <option value="-1"></option>
         <?PHP
         while(!$Consulta->EOF){
            ?>
            <option value="<?PHP echo $Consulta->fields['id']?>"><?PHP echo $Consulta->fields['Nombre']?></option>
            <?PHP
            $Consulta->MoveNext();
         }//while
         ?>
         </select>
         <?PHP 
    }//public function Select
    public function Carrera($id){
        global $db;
        
        //para envio de arreglos en combo
            $i==0;
            foreach ($id as $item){
                    
                    if($i>0)
                        $cad=$cad.",".$item;
                    else
                        $cad=$item;
                        
                    $i++;
            }
        //fin codigo
        
          $SQL='SELECT 

                codigocarrera,
                nombrecarrera
                
                FROM carrera
                
                WHERE
                
                codigomodalidadacademica in ('.$cad.')
                AND
                codigocarrera NOT IN (1,2) AND

                fechavencimientocarrera>=NOW()
                                
                ORDER BY nombrecarrera ASC';
                
                
          if($Carrera=&$db->Execute($SQL)===false){
            echo 'Error en el SQL Carrera.....<br><br>'.$SQL;
            die;
          }      
          ?>
          <select id="Carrera" name="Carrera[]" style="width: 90%;" multiple="" size="5">
            <option value="-1"></option>
            <?PHP 
            while(!$Carrera->EOF){
                ?>
                <option value="<?PHP echo $Carrera->fields['codigocarrera']?>"><?PHP echo $Carrera->fields['nombrecarrera']?></option>
                <?PHP
                $Carrera->MoveNext();
            }//while
            ?>
          </select>
          <?PHP
    }//public function Carrera
}//class
?>