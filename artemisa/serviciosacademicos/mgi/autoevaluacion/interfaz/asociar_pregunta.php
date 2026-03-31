<?php

    include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   $id_respuesta=$_REQUEST['idrespuesta'];
   $id_pregunta=$_REQUEST['idpregunta'];
   $id_instrumento=$_REQUEST['id_instrumento'];
   $id_seccion=$_REQUEST['idsecc'];
   //siq_Ainstrumento para preguntas y siq_Ainstrumentoseccion para secciones
   $idinstpreg=$_REQUEST['idinstpreg'];
   
  
  $query_tipo= "SELECT p.titulo, p.idsiq_Apregunta, p.cat_ins, dep.idsiq_ApreguntaRespuestaDependencia as dependencia, 
                                                        ins.idsiq_Ainstrumento, p.idsiq_Atipopregunta,  
                                                        ins.idsiq_Apregunta as preg_asig, ins.idsiq_Ainstrumentoconfiguracion, 
                                                        ins.idsiq_Aseccion, ins.codigoestado, sec.nombre as secce
                                                        FROM siq_Apregunta as p
                                                        inner join siq_Ainstrumento as ins on (ins.idsiq_Apregunta=p.idsiq_Apregunta 
                                                                                              and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."')
                                                        left join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                                                        left join siq_ApreguntaRespuestaDependencia dep on dep.tipo=1 
                                                        AND dep.idInstrumento='".$id_instrumento."' AND dep.idRespuesta='".$id_respuesta."' 
                                                            AND dep.idDependencia=ins.idsiq_Ainstrumento  
                                                            AND dep.codigoestado=100 
                                                        where p.codigoestado=100 AND p.idsiq_Apregunta!='".$id_pregunta."' 
                                                            AND sec.idsiq_Aseccion='".$id_seccion."' 
                                                        group by p.idsiq_Apregunta;";
  $data_in = $db->Execute($query_tipo);
   //echo $query_tipo;
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
<script type="text/javascript">
    
     $(function() {
                      $('#filter_input2').fastLiveFilter('#sortable1');
                       });

  $(function() {
        $( "#sortable1" ).sortable({
            connectWith: ".connectedSortable"
        })
        
    });

</script>

    <form action="save.php" method="post" id="form_test<?PHP echo $id_respuesta?>">
        <input type="hidden" name="idInstrumento" id="idInstrumento" value="<?php echo $id_instrumento; ?>">
        <input type="hidden" name="entity" id="entity" value="ApreguntaRespuestaDependencia">
        <input type="hidden" name="action" id="action" value="asociarPreguntas">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="idsiq_Aseccion" id="idsiq_Aseccion" value="<?php echo $id_seccion; ?>">
        <input type="hidden" name="idRespuesta" id="idRespuesta" value="<?php echo $id_respuesta; ?>">
        <!--<input type="hidden" name="idDependencia" id="idDependencia" value="<?php //echo $idinstpreg; ?>">-->
        <input type="hidden" name="tipo" id="tipo" value="1">
        <div id="container">
                    <table>
                    <tr>
                        <td valign="top">
                            <legend>Preguntas</legend>
                            <div id="fastLiveFilter" >
                            <input id="filter_input2" placeholder="Buscar Pregunta...">
                            <br><br>
                            <ul id="sortable1" class="connectedSortable">
                                <?php
                                    $data= $data_in->GetArray();
                                    //print_r($data);
                                    $i=0;
                                    foreach($data_in as $dt){
                                     //print_r($dt);
                                        $nombre=$dt['titulo'];
                                        $idsiq_Apregunta=$dt['idsiq_Apregunta'];
                                        //echo "<br/><br/>";var_dump($nombre);echo "<br/>";
                                        //var_dump(strpos($nombre, '<w:WordDocument>'));
                                        if (strpos($nombre, '<w:WordDocument>') !== FALSE){
                                            //no se agrega o se revienta
                                            //echo "<br/><br/>reventada-->"; print_r($idsiq_Apregunta);
                                        }
                                        else{
                                            $dis=$dt['discriminacion'];
                                            $carrera=$dt['nombrecarrera'];
                                            $id_ins=$dt['idsiq_Ainstrumento'];
                                            $id_dependencia=$dt['dependencia'];                                            
                                            $idsiq_Ainstrumento=$dt['idsiq_Ainstrumento'];
                                            $id_secc=$dt['idsiq_Aseccion'];
                                            $estado=$dt['codigoestado'];
                                            $nom_secc=$dt['secce'];
                                            $ins=$dt['cat_ins'];
                                            $che=""; $di="";
                                            //if ($ins==$cat_ins){
                                                if (!empty($id_ins) && !empty($id_secc)){
                                                // echo $id_ins.'->'.$id_secc.'>'.$id_seccion;
                                                    if ($id_seccion!=$id_secc && $estado==100){
                                                        $di="readonly='readonly' onclick='javascript: return false;' " ;
                                                    }

                                                }
                                                if (!empty($id_dependencia) && $estado==100){
                                                    $che="checked";
                                                }
                                                if ($dis==3){
                                                    $nombre=$nombre.'('.$carrera.')';
                                                }else{
                                                    $nombre=$nombre.'(Institucional)';
                                                }
                                                if ($estado=='200'){
                                                    $id_secc='';
                                                }
                                                    //echo "<br/><br/>"; print_r($idsiq_Apregunta);
                                                $id=$dt['disiq_indicador'];
                                                echo '<li class="ui-state-default" style="width:400px;" idsiq_Apregunta="'.$idsiq_Apregunta.' " >';
                                                if (!empty($nom_secc) and $estado=='100') echo '<label><b>'.$nom_secc.'</b></label>';
                                                echo '<input type="checkbox" '.$che.' '.$di.' name="Apregunta1['.$i.']" id="Apregunta1_'.$i.'" value="'.$idsiq_Apregunta.'" >'.$nombre;
                                                echo '<input type="hidden" name="Apregunta2['.$i.']" id="Apregunta2_'.$i.'" value="'.$idsiq_Apregunta.'" />';
                                                echo '<input type="hidden" name="idsiq_Ainstrumento1['.$i.']" id="idsiq_Ainstrumento1_'.$i.'" value="'.$idsiq_Ainstrumento.'" />';
                                                echo '<input type="hidden" name="idsiq_Aseccion2['.$i.']" id="idsiq_Aseccion2_'.$i.'" value="'.$id_seccion.'" />';
                                                echo '<input type="hidden" name="id_secc1['.$i.']" id="id_secc1_'.$i.'" value="'.$id_secc.'" />';
                                                echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$idsiq_Apregunta.'" />';
                                                echo '<input type="hidden" name="idPreguntaRespuestaDep['.$i.']" id="ids_'.$i.'" value="'.$id_dependencia.'" />';
                                                echo '&nbsp;';
                                                echo '<img src="../../images/eye.png" width="30px" height="30px" onClick=\'OPen("dialog_Document","'.$i.'","'.$idsiq_Apregunta.'")\'  />';
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
<script type="text/javascript">
     
             
        function OPen(id,i,idpregunta){
            $panel = $( "#"+id+'_'+i );
            $.ajax({
                url: "preguntaver.php?id_pregunta="+idpregunta,
                type: "GET",
                dataType: "html",
                async: false,
                data: { "id": id},
                success: function (obj) {
                    $panel.html(obj);
                    $.fx.speeds._default = 1000;
                    $panel.dialog({
                        height: 300,
			width: 400,
			modal: true,
                        title: "Pregunta",
                        buttons: {
                            Cancelar: function() {
                            $panel.dialog('close');
                            }
                        }
                    }                    
                );
                }
            });
        }
        
</script>
    
<?php    writeFooter();
        ?>  


