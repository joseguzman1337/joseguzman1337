<?php
    include("../../templates/templateAutoevaluacion.php");
    $db =writeHeader("Preguntas",true,"Autoevaluacion");
 
    class funciones{
        public function ver_preguntas($id_pregunta){
            if (!empty($id_pregunta)){
                $entity = new ManagerEntity("Apregunta");
                $entity->sql_where = "idsiq_Apregunta = $id_pregunta";
            // $entity->debug = true;
                $data = $entity->getData();
                $data =$data[0];
            // print_r($data);
            }
            $tipo=$data['idsiq_Atipopregunta'];
            echo $data['titulo'];
            echo "<br>";

                $entity2 = new ManagerEntity("Apreguntarespuesta");
                $entity2->sql_where = "idsiq_Apregunta ='".$id_pregunta."' and codigoestado=100 ";
                // $entity2->debug = true;
                $data2 = $entity2->getData();
                //print_r($data2);
                if ($tipo==1){
                    $i=0;
                    echo "<table border=0>";
                    echo "<tr>";
                        foreach($data2 as $c => $v){
                            
                            $re=trim($v['respuesta']);
                             echo '<td width="80px"  valign="top"><center>'.$re.'</center><br></td>';
                            $i++;
                            
                        }
                        echo "</tr>";
                         echo "<tr>";
                        $i=0;
                        foreach($data2 as $c => $v){
                            $ur=$v['unica_respuesta'];
                            $mr=$v['multiple_respuesta'];
                            $re=trim($v['respuesta']);
                            if ($ur==1){
                                echo '<td width="80px"  valign="top"><center><input type="radio" name="valor" id="valor_'.$i.'" /></center></td>';
                            }
                            if ($mr==1){
                                echo '<td width="80px"  valign="top"><center><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" /></center></td>';
                            }

                            $i++;
                        }
                         echo "</tr>";
                    echo "</table>";
                }
                if ($tipo==2){
                    $i=0;
                    echo "<table border=0>";
                        echo "<tr>";
                        foreach($data2 as $c => $v){
                            $ur=$v['unica_respuesta'];
                            $mr=$v['multiple_respuesta'];
                            $ti=$v['texto_inicio'];
                            $tf=$v['texto_final'];
                            if ($i==0) echo "<td>".$ti."</td>";
                            $re=trim($v['respuesta']);
                            if ($ur==1){
                                echo '<td width="15px"><center><input type="radio" name="valor" id="valor_'.$i.'" /></center></td>';
                            }
                            if ($mr==1){
                                echo '<td width="15px"><center><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" /></center></td>';
                            }

                            $i++;
                        }
                        echo "<td>".$tf."</td>";
                        echo "</tr>";
                    echo "</table>";
                }
                if ($tipo==3){
                    $i=0;
                    echo "<table border=0>";
                    foreach($data2 as $c => $v){
                        echo "<tr>";
                        $ur=$v['unica_respuesta'];
                        $mr=$v['multiple_respuesta'];
                        $re=trim($v['respuesta']);
                        if ($ur==1){
                                echo '<td><input type="radio" name="valor" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                            if ($mr==1){
                                echo '<td><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                        echo "</tr>";
                    }
                    echo "</table>";

                }
                if ($tipo==4){
                    $i=0;
                    echo "<table border=0>";
                    foreach($data2 as $c => $v){
                        echo "<tr>";
                        $ur=$v['unica_respuesta'];
                        $mr=$v['multiple_respuesta'];
                        $re=trim($v['respuesta']);
                        if ($ur==1){
                                echo '<td><input type="radio" name="valor" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                            if ($mr==1){
                                echo '<td><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                if ($tipo==5){
                    foreach($data2 as $c => $v){
                            $mc=$v['maximo_caracteres'];
                            echo '<td><input type="textbox" name="valor" id="valor" value="" maxlength="'.$mc.'" /></td>';
                    }
                }
                if ($tipo==6){
                    $i=0;
                    echo "<table border=0>";
                    foreach($data2 as $c => $v){
                        echo "<tr>";
                        $ur=$v['unica_respuesta'];
                        $mr=$v['multiple_respuesta'];
                        $re=trim($v['respuesta']);
                        if ($ur==1){
                                echo '<td><input type="radio" name="valor" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                            if ($mr==1){
                                echo '<td><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                if ($tipo==8){
                    $i=0;
                    echo "<table border=0>";
                    foreach($data2 as $c => $v){
                        echo "<tr>";
                        $ur=$v['unica_respuesta'];
                        $mr=$v['multiple_respuesta'];
                        $an=$v['analisis'];
                        $re=trim($v['respuesta']);
                            if ($i==0){
                                echo "<td>".$an."</td></tr><tr>";
                            }
                        if ($ur==1){
                                echo '<td><input type="radio" name="valor" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                            if ($mr==1){
                                echo '<td><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                        echo "</tr>";
                        $i++;
                    }
                    echo "</table>";
                }

        }
        
    }
?>
