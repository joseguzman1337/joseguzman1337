<?php

    include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   $id_instrumento=$_REQUEST['id_instrumento'];
   $id_seccion=$_REQUEST['idsecc'];
   $cat_ins=$_REQUEST['cat_ins'];
   
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
  
  //no aplican las preguntas abiertas para asociar porque pues WTF!? si la persona puede responder lo que sea
  $query_tipo= "SELECT p.titulo, p.idsiq_Apregunta, p.cat_ins,
                                                        ins.idsiq_Ainstrumento, p.idsiq_Atipopregunta,  
                                                        ins.idsiq_Apregunta as preg_asig, ins.idsiq_Ainstrumentoconfiguracion, 
                                                        ins.idsiq_Aseccion, ins.codigoestado, sec.nombre as secce
                                                        FROM siq_Apregunta as p
                                                        left join siq_Ainstrumento as ins on (ins.idsiq_Apregunta=p.idsiq_Apregunta 
                                                                                              and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."')
                                                        left join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                                                        where p.codigoestado=100 and p.cat_ins='".$cat_ins."' AND sec.idsiq_Aseccion='".$id_seccion."' 
                                                        AND p.idsiq_Atipopregunta!=5 group by p.idsiq_Apregunta;";
  $preguntas = $db->GetArray($query_tipo);
  //echo "<pre>"; print_r($preguntas);
?>

<h4>Preguntas disponibles para asociar otra pregunta o sección</h4>

<div id="listaPreguntas">
    <?php foreach($preguntas as $pregunta) { 
            $query = "SELECT * FROM siq_Apreguntarespuesta WHERE idsiq_Apregunta='".$pregunta["idsiq_Apregunta"]."' 
                                                        AND codigoestado=100";
            $respuestas = $db->GetArray($query);
            //echo "<pre>"; print_r($respuestas);
        ?>
        <div class="pregunta">
            <h6 style="margin-bottom: 10px;font-size:13px;font-weight:normal;"><?php echo $pregunta["titulo"]; ?></h6>
            <ul class="respuestas" style="color:#000;font-size:10px;">
                 <?php foreach($respuestas as $resp) { ?>
                    <li><?php echo $resp["respuesta"] ?>&nbsp;&nbsp;
                        <a href="javascript:void(0)" onClick="OPen_PreguntaAsociacion('asociar_pregunta','<?php echo $resp["idsiq_Apreguntarespuesta"]; ?>','<?php echo $pregunta["idsiq_Ainstrumentoconfiguracion"]; ?>','<?php echo $pregunta["idsiq_Apregunta"]; ?>','<?php echo $pregunta["idsiq_Aseccion"]; ?>','<?php echo $pregunta["idsiq_Ainstrumento"]; ?>')">Asociar Preguntas</a>
                        | <a href="javascript:void(0)" onClick="OPen_SeccionAsociacion('asociar_seccion','<?php echo $resp["idsiq_Apreguntarespuesta"]; ?>','<?php echo $pregunta["idsiq_Ainstrumentoconfiguracion"]; ?>','<?php echo $pregunta["idsiq_Apregunta"]; ?>','<?php echo $pregunta["idsiq_Aseccion"]; ?>','<?php echo $pregunta["idsiq_Ainstrumento"]; ?>')">Asociar Secciones</a>
                    </li>
                    <div id="asociar_pregunta_<?php echo $resp["idsiq_Apreguntarespuesta"]; ?>" style="display:none"></div>
                    <div id="asociar_seccion_<?php echo $resp["idsiq_Apreguntarespuesta"]; ?>" style="display:none"></div>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">
    function OPen_PreguntaAsociacion(id,i,idinstr,idpre,idsecc,idinstpreg){
           $panelPreg = $( "#"+id+'_'+i );
            $.ajax({
                url: "asociar_pregunta.php?idrespuesta="+i+"&id_instrumento="+idinstr+"&idpregunta="+idpre+"&idsecc="+idsecc+"&idinstpreg="+idinstpreg,
                type: "GET",
                dataType: "html",
                async: false,
                data: { "id": id},
                success: function (obj) {
                    $panelPreg.html(obj);
                    $.fx.speeds._default = 1000;
                    $panelPreg.dialog({
                        height: 700,
			width: 500,
			modal: true,
                        title: "Asociar preguntas a respuesta",
                        buttons: {
                            "Guardar": function() {
                                j=0;
                                 var check = $("input[type='checkbox']:checked").length;
                                 sendForm_asocP(i)
                            },
                            Cancelar: function() {
                                $panelPreg.dialog('close');
                            }
                        },
                        close: function(event, ui) { 
                            $(this).dialog( "destroy" );   
                            $( "#"+id+'_'+i ).html("");
                        }
                    }                    
                );
                }
            });
       }
       
       function sendForm_asocP(idsecc){
                   // alert('aca..'+idsecc);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test'+idsecc).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
                }
           
           function OPen_SeccionAsociacion(id,i,idinstr,idpre,idsecc,idinstpreg){
           $panelSeccA = $( "#"+id+'_'+i );
            $.ajax({
                url: "asociar_seccion.php?idrespuesta="+i+"&id_instrumento="+idinstr+"&idpregunta="+idpre+"&idsecc="+idsecc+"&idinstpreg="+idinstpreg,
                type: "GET",
                dataType: "html",
                async: false,
                data: { "id": id},
                success: function (obj) {
                    $panelSeccA.html(obj);
                    $.fx.speeds._default = 1000;
                    $panelSeccA.dialog({
                        height: 700,
			width: 500,
			modal: true,
                        title: "Asociar secciones a respuesta",
                        buttons: {
                            "Guardar": function() {
                                j=0;
                                 //var check = $("input[type='checkbox']:checked").length;
                                 sendForm_asocSec(i)
                            },
                            Cancelar: function() {
                                $panelSeccA.dialog('close');
                            }
                        },
                        close: function(event, ui) { 
                            $(this).dialog( "destroy" );   
                            $( "#"+id+'_'+i ).html("");
                        }
                    }                    
                );
                }
            });
       }
       
       function sendForm_asocSec(idsecc){
                    //alert('aca..'+idsecc);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_secc'+idsecc).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
                }
           
</script>