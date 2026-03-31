<?php
    function pintarSecciones($data_cp,$id_instrumento,$db,$esDinamica=false,$esArreglo=false){
        $z = 0;
        $html = "";
        //echo '<pre>';print_r($data_cp);
        //toca echarle cabez porque si contesta la última antes entonces ya no lo deja guardar
        // y ademas poner que solo sea para egresados
        /*if($esArreglo){
            shuffle($data_cp);
        }*/
        //echo '<pre>';print_r($data_cp);
        foreach($data_cp as $dt_cp){//lee las secciones

                    $html .= "<div id='secc_".$z."'  >";
                     $html .= "<fieldset>";//abre un fieldset por seccion

                     $id_secc=$dt_cp['idsiq_Aseccion'];
                     $html .= "<legend>".trim($dt_cp['secce'])."</legend>";//coloca el nombre de la seccion
                     ///*******Busca la pregunta por seccion*/////////
                     $sql_preg="SELECT ins.idsiq_Ainstrumentoconfiguracion,
                                            ins.idsiq_Apregunta, pr.titulo, pr.obligatoria, pr.RequiereJustificacion,
                                            pr.idsiq_Atipopregunta, tp.nombre as tipo, ins.idsiq_Aseccion,
                                            ins.codigoestado, sec.nombre as secce, SUM(depend.idDependencia) as dependiente,
                                            SUM(dependR.idRespuesta) as preguntasOcultas
                                            FROM siq_Ainstrumento as ins
                                            inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                                            inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=ins.idsiq_Apregunta)
                                            inner join siq_Atipopregunta tp on (pr.idsiq_Atipopregunta=tp.idsiq_Atipopregunta)
                                            left join (
                                                    SELECT 

                                                    insecc.idsiq_Apregunta,dep.idDependencia 

                                                    FROM 

                                                    siq_ApreguntaRespuestaDependencia dep                            
                                                    INNER JOIN siq_Ainstrumento insecc on insecc.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' 
                                                    AND insecc.idsiq_Ainstrumento=dep.idDependencia 
                                                    and insecc.idsiq_Aseccion='".$id_secc."' 
                                                    AND insecc.codigoestado=100  
                                                    WHERE dep.idInstrumento='".$id_instrumento."' AND dep.codigoestado = 100 
                                                        AND dep.tipo=1 
                                                    GROUP BY insecc.idsiq_Apregunta 
                                                ) depend ON depend.idsiq_Apregunta=ins.idsiq_Apregunta
                                            INNER JOIN siq_Apreguntarespuesta presp ON presp.idsiq_Apregunta=ins.idsiq_Apregunta AND presp.codigoestado=100
                                             left join (
                                                    SELECT 

                                                    dep.idRespuesta as idRespuesta

                                                    FROM 

                                                    siq_ApreguntaRespuestaDependencia dep                            
                                                    INNER JOIN siq_Ainstrumento insecc on insecc.idsiq_Ainstrumento=dep.idDependencia 
                                                    AND insecc.codigoestado=100  
                                                    WHERE  dep.codigoestado = 100 AND dep.tipo=1 
                                                    GROUP BY dep.idRespuesta 
                                                ) dependR ON dependR.idRespuesta=presp.idsiq_Apreguntarespuesta

                                            where ins.codigoestado=100
                                            and sec.codigoestado=100
                                            and pr.codigoestado=100 and ins.idsiq_Aseccion='".$id_secc."' and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' 
                                            GROUP BY ins.idsiq_Apregunta ORDER BY ins.orden,ins.idsiq_Apregunta
                                            ";
                               // echo $sql_preg;
                       $data_preg = $db->Execute($sql_preg);
                       $j=1;
                       $contadorVisible=0;
                        foreach($data_preg as $dt_preg){//lee las preguntas por seccion
                             $id_preg=$dt_preg['idsiq_Apregunta'];
                             $titulo=$dt_preg['titulo'];
                             $obl=$dt_preg['obligatoria'];
                             $t_preg=$dt_preg['idsiq_Atipopregunta'];
                             $clasesDep = "divPreguntas divPregunta_".$id_preg;
                             $styleDep = "";
                             $contadorVisible++;
                             $Disabled = "";
                             $valorC = $contadorVisible.".";
                             if($dt_preg['dependiente']!==NULL){
                                 //falta a ver que se conteste una respuesta para abrirse
                                 //$clasesDep .= ' divPregunta_'.$id_preg;
                                 $styleDep = "style='display:none;'";
                                    $Disabled = 'disabled="disabled"';
                                    $contadorVisible--;
                                    $valorC = "";
                             }
                             if($dt_preg['preguntasOcultas']!==NULL){
                                 $clasesDep .= ' preguntasOcultas';
                             }
                             $html .= "<div class='".$clasesDep."' ".$styleDep.">";
                             if ($j>1) $html .= "<br>";
                             $html .= '<input type="hidden" name="preg['.$k.']" id="preg_'.$k.'" value="'.$id_preg.'">';
                             $html .= '<input type="hidden" name="tpreg['.$k.']" id="tpreg_'.$k.'" value="'.$t_preg.'">';
                             $html .= '<input type="hidden" name="obl['.$k.']" id="obl_'.$k.'" value="'.$obl.'_'.$k.'">';
                             $class="";
                             $obligatoria = false;
                             if (!empty($obl)){
                                 $html .= '<b><label style="color:red; font-size:9px;margin-right:3px">(*)</label>'.$valorC.' '.$titulo.'</b>';
                                 $class="required";
                             }else{
                                 $html .= '<b>'.$j.'.'.$titulo.'</b>';//pinta el titulo de la pregunta
                             }
                             $html .= "<br>";
                            if($t_preg==5){
                              $style="style='width:100%'";
                            }else{
                              $style="";
                            }
                            $html .= "<table border='0' ".$style." >";//crea tabla por pregunta
                                    ///****Busca las respuestas por preguntas**//////
                                   $sql_rep="SELECT pre.idsiq_Apreguntarespuesta, pre.respuesta, pre.valor, pre.texto_inicio, pre.texto_final,
                                                 pre.unica_respuesta, pre.multiple_respuesta, pr.idsiq_Atipopregunta,
                                                 pre.maximo_caracteres, pre.analisis, pre.idsiq_Apregunta 
                                              FROM siq_Apreguntarespuesta as pre
                                              inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=pre.idsiq_Apregunta) 
                                              
                                              where pr.idsiq_Apregunta='".$id_preg."'
                                              and pre.codigoestado=100
                                              and pr.codigoestado=100";
                                   //echo $sql_rep;
                                      $data_rep = $db->Execute($sql_rep);
                                      /////***Pregunat tipo Likert******///////
                                      if ($t_preg==1){
                                          $html .= "<tr>";
                                          foreach($data_rep as $dt_rep){
                                              $res=$dt_rep['respuesta'];
                                              $html .= '<td  valign="top"><center>&nbsp;'.$res.'&nbsp;</center>';
                                          }
                                          $html .= "</tr>";
                                          $html .= "<tr>";
                                          $i=0;
                                          foreach($data_rep as $dt_rep){  
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta'];
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              $html .= '<td valign="top"><center><input type="radio" '.$Disabled.'  class="contador_'.$j.' '.$class.'" name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              $i++;
                                          }
                                          $html .= "</tr>";
                                      }
                                  ///////////cierra pregunta tipo liket****///////
                                   ///////////abre tipo gutman******//////
                                      if ($t_preg==2){
                                          $x=0;
                                          $html .= "<tr>";
                                          $i=0;
                                          foreach($data_rep as $dt_rep){
                                               $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                               $ti=$dt_rep['texto_inicio']; $tf=$dt_rep['texto_final'];
                                               $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                               if ($x==0) $html .= '<td  valign="top">'.$ti.'</td>';
                                               $html .= '<td  valign="top">';
                                               $html .= '<center><input type="radio"  '.$Disabled.' name="valor_'.$id_preg.'" class="contador_'.$j.' '.$class.'"  id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                               $x++; $i++;
                                          }
                                          $html .= '<td  valign="top">'.$tf.'</td>';
                                          $html .= "</tr>";
                                      }
                                 ///////////cierra tipo gutman******//////
                                 /////abre tipo dicotomicas///////
                                      if ($t_preg==3){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             $html .= "<tr>";
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              $html .= '<td  valign="top"><center><input type="radio" '.$Disabled.' class="contador_'.$j.' '.$class.'"  name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              $html .= '<td  valign="top">&nbsp;'.$res.'&nbsp;';
                                              $i++;
                                          }
                                          $html .= "</tr>";
                                      }
                                 /////cierra tipo dicotomicas///////
                                  //////////abre tipo opcion de respuesta multiple ////////////
                                      if ($t_preg==4){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             $html .= "<tr>";
                                             $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              $html .= '<td  valign="top"><center><input type="checkbox"  '.$Disabled.'  class="contador_'.$j.' '.$class.'"  name="valor_'.$id_preg.'['.$i.']" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              $html .= '<td  valign="top">&nbsp;'.trim($res).'&nbsp;';
                                              $i++;
                                          }
                                          $html .= "</tr>";
                                      }

                                //////////cierra tipo opcion de respuesta multiple ////////////



                                 //////////abre tipo pregunta abierta////////////
                                      if ($t_preg==5){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             $html .= "<tr>";
                                              $mc=$dt_rep['maximo_caracteres'];
                                              $html .= '<td><textarea  '.$Disabled.' name="valor_'.$id_preg.'" class="contador_'.$j.' '.$class.'"  id="valor_'.$id_preg.'_'.$i.'" value="" maxlength="'.$mc.'" rows="10" style="width:100%" ></textarea></td>';
                                              $i++;
                                          }
                                          $html .= "</tr>";
                                      }
                               //////////cierra tipo de pregunta abierta////////////
                                /////////abre tipo pregunta opcion multiple////////////
                                      if ($t_preg==6){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             $html .= "<tr>";
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                              $html .= '<td  valign="top"><center><input type="radio"  '.$Disabled.'  class="contador_'.$j.' '.$class.'"  name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              $html .= '<td  valign="top">&nbsp;'.trim($res).'&nbsp;';
                                              $i++;
                                          }
                                          $html .= "</tr>";
                                      }
                              /////////cierra tipo pregunta opcion multiple////////////


                             /////////abre tipo pregunta analisis//////////
                                       if ($t_preg==8){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             $html .= "<tr>";
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta']; $ana=$dt_rep['analisis'];
                                               if ($i==0){
                                                        $html .= "<td colspan='2' ".$ana."<br></td></tr><tr>";
                                                    }
                                              $html .= '<td  valign="top" width="5%"><input type="radio"  '.$Disabled.'  class="contador_'.$j.' '.$class.'"  name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></td>';
                                              $html .= '<td  valign="top">&nbsp;'.trim($res).'&nbsp;';
                                              $i++;
                                         }
                                       }

                              /////////cierra tipo pregunta analisis//////////


                            $html .= "</table>";    //cierra tabla por pregunta
							
										if($dt_preg["RequiereJustificacion"]){
							//print_r($dt_preg);
											//toca poner el campo de justificación											
											$html .= '<label style="margin:15px 0 5px;clear:both;display:block">Justificación:</label>';
											$html .= '<textarea name="justificacion_'.$id_preg.'" class="contador_'.$j.' '.$class.'"  id="justificacion_'.$id_preg.'_'.$i.'" maxlength="500" rows="5" style="margin:0px 0 10px;width:90%;"></textarea>';
										}
										 
                            $j++; $k++;
                            //cierra div por pregunta
                            $html .= "</div>";
                        }//cierra las preguntas por seccion
                        
                     $html .= "</fieldset>";//cierra el fieldset por seccion
                     
                     $html .= '<br><button id="numButton" class="submit">Siguiente</button>';
                     
                     $html .= "</div>";
                     
        if($esDinamica){
            $z = 1;
            break;
        }
                $z++;
                
                 }//cierra leer las secciones
                 return array($z,$html);
    }
?>
