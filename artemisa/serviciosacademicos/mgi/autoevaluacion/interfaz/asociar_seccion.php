<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   $id_respuesta=$_REQUEST['idrespuesta'];
   $id_pregunta=$_REQUEST['idpregunta'];
   $id_instrumento=$_REQUEST['id_instrumento'];
   $id_seccion=$_REQUEST['idsecc'];
   //siq_Ainstrumento para preguntas y siq_Ainstrumentoseccion para secciones
   $idinstpreg=$_REQUEST['idinstpreg'];
   
  $query_secc= "SELECT i.idsiq_Aseccion, i.nombre, ig.idsiq_Ainstrumentoseccion, dep.idsiq_ApreguntaRespuestaDependencia as dependencia
                       FROM siq_Aseccion as i
                        inner join siq_Ainstrumentoseccion as ig on (ig.idsiq_Aseccion=i.idsiq_Aseccion)
                        left join siq_ApreguntaRespuestaDependencia dep on dep.tipo=2 
                        AND dep.idInstrumento='".$id_instrumento."' AND dep.idRespuesta='".$id_respuesta."' 
                           AND dep.codigoestado=100  AND dep.idDependencia=ig.idsiq_Ainstrumentoseccion  
			 WHERE ig.codigoestado=100 and i.codigoestado=100 AND i.idsiq_Aseccion!='".$id_seccion."' 
                       and ig.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'  ";
  $data_in = $db->Execute($query_secc);
   //echo $query_secc;
  if (!empty($id_instrumento)){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $tipo=$data['idsiq_discriminacionIndicador'];
    $tipoProg=$data['codigocarrera'];
    //print_r($data);
  }
?>

    <form action="save.php" method="post" id="form_secc<?PHP echo $id_respuesta?>">
        <input type="hidden" name="idInstrumento" id="idInstrumento" value="<?php echo $id_instrumento; ?>">
        <input type="hidden" name="entity" id="entity" value="ApreguntaRespuestaDependencia">
        <input type="hidden" name="action" id="action" value="asociarSecciones">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="idRespuesta" id="idRespuesta" value="<?php echo $id_respuesta; ?>">
        <!--<input type="hidden" name="idDependencia" id="idDependencia" value="<?php //echo $idinstpreg; ?>">-->
        <input type="hidden" name="tipo" id="tipo" value="2">
        <div id="container" style="margin: 0 auto;width:100%;">
                    <table>
                    <tr>
                        <td valign="top">
                            <legend>Secciones</legend>
                            <div id="fastLiveFilter" >
                            <ul id="sortable1" class="connectedSortable">
                                <?php
                                    $data= $data_in->GetArray();
                                    //print_r($data);
                                    $i=0;
                                    foreach($data_in as $dt){
                                     //print_r($dt);
                                        $nombre=$dt['nombre'];
                                        $idsiq_Apregunta=$dt['idsiq_Aseccion'];
                                        //echo "<br/><br/>";var_dump($nombre);echo "<br/>";
                                        //var_dump(strpos($nombre, '<w:WordDocument>'));
                                        if (strpos($nombre, '<w:WordDocument>') !== FALSE){
                                            //no se agrega o se revienta
                                            //echo "<br/><br/>reventada-->"; print_r($idsiq_Apregunta);
                                        }
                                        else{
                                            $id_ins=$dt['idsiq_Ainstrumentoseccion'];
                                            $id_dependencia=$dt['dependencia'];                                            
                                            $idsiq_Ainstrumento=$dt['idsiq_Ainstrumentoseccion'];
                                            $id_secc=$dt['idsiq_Aseccion'];
                                            $che=""; $di="";
                                                if (!empty($id_dependencia)){
                                                    $che="checked";
                                                }
                                                echo '<li class="ui-state-default" style="width:400px;" idsiq_Apregunta="'.$idsiq_Apregunta.' " >';
                                                echo '<input type="checkbox" '.$che.' '.$di.' name="Apregunta1['.$i.']" id="Apregunta1_'.$i.'" value="'.$idsiq_Apregunta.'" >'.$nombre;
                                                echo '<input type="hidden" name="Apregunta2['.$i.']" id="Apregunta2_'.$i.'" value="'.$idsiq_Apregunta.'" />';
                                                echo '<input type="hidden" name="idsiq_Ainstrumento1['.$i.']" id="idsiq_Ainstrumento1_'.$i.'" value="'.$idsiq_Ainstrumento.'" />';
                                                echo '<input type="hidden" name="idsiq_Aseccion2['.$i.']" id="idsiq_Aseccion2_'.$i.'" value="'.$id_seccion.'" />';
                                                echo '<input type="hidden" name="id_secc1['.$i.']" id="id_secc1_'.$i.'" value="'.$id_secc.'" />';
                                                echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$idsiq_Apregunta.'" />';
                                                echo '<input type="hidden" name="idPreguntaRespuestaDep['.$i.']" id="ids_'.$i.'" value="'.$id_dependencia.'" />';
                                                echo'</li>';
                                                echo '<div id="dialog_Document_'.$i.'" style="display:none">';
                                                echo '</div>';
                                                $i++;
                                        }
                                    }
                                        
                                    //}
                               ?>
                            </ul>
                            </div>
                        </td>
                     </tr> 
                </table>
    </div>  
  </form>
    
<?php    writeFooter();
        ?>  


