<?php
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Preguntas",true,"Autoevaluacion");
  
   /* $entity = new ManagerEntity("indicador");
    $entity->sql_where = "idTipo ='2' ";
    //$entity->debug = true;
    $data = $entity->getData();
  //  $data =$data[0];
    //print_r($data);*/
?>
 <style>
    #sortable1, #sortable2 { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: left; margin-right: 10px; }
    #sortable1 li, #sortable2 li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 220px; }
    .fieldset1 {
       border-color: #ABC3D7;

    }
    .legend1 {
        border-color: #ABC3D7;
        border:  #ABC3D7;
        padding: 6px;
        font-weight: bold;
    }
    </style>
<script type="text/javascript">
       $(document).ready(function(){            
              jQuery("select[name='idsiq_Atipopregunta']").change(function(){displayrespuesta();});
              jQuery("select[name='categoriapregunta']").change(function(){displaypreguntas();});
        });
        
      function displaypreguntas(){
           var optionCateg = jQuery("select[name='categoriapregunta'] option:selected").index();
           if (optionCateg=='1'){
               $("#idsiq_Atipopregunta option[value='1']").attr("disabled",false);
               $("#idsiq_Atipopregunta option[value='2']").attr("disabled",false);
               $("#idsiq_Atipopregunta option[value='3']").attr("disabled",false);
               $("#idsiq_Atipopregunta option[value='4']").attr("disabled",false);
               $("#idsiq_Atipopregunta option[value='5']").attr("disabled",false);
               $("#idsiq_Atipopregunta option[value='6']").attr("disabled",true);
               $("#idsiq_Atipopregunta option[value='7']").attr("disabled",true);
               $("#idsiq_Atipopregunta option[value='8']").attr("disabled",true);
           }else{
               $("#idsiq_Atipopregunta option[value='1']").attr("disabled",true);
               $("#idsiq_Atipopregunta option[value='2']").attr("disabled",true);
               $("#idsiq_Atipopregunta option[value='3']").attr("disabled",false);
               $("#idsiq_Atipopregunta option[value='4']").attr("disabled",true);
               $("#idsiq_Atipopregunta option[value='5']").attr("disabled",false);
               $("#idsiq_Atipopregunta option[value='6']").attr("disabled",false);
               $("#idsiq_Atipopregunta option[value='7']").attr("disabled",false);
               $("#idsiq_Atipopregunta option[value='8']").attr("disabled",false);
           }
          
      }
       function displayrespuesta(){
           // $("#codigocarrera").load('generacarrera_facultad.php?id=0');
           jQuery("#respuestas1").css('display', '');
             var ajaxLoader = "<img src='../../images/ajax-loader.gif' alt='loading...' />";           
           var optionValue = jQuery("select[name='idsiq_Atipopregunta']").val();
                if (optionValue=='1'){
                    jQuery("#respuestas1")
                    .html(ajaxLoader)
                    .load('likert.php?idtipo='+optionValue); 
                }else if(optionValue=='2'){
                    jQuery("#respuestas1")
                    .html(ajaxLoader)
                    .load('gutman.php?idtipo='+optionValue); 
                }else if(optionValue=='3'){
                    jQuery("#respuestas1")
                    .html(ajaxLoader)
                    .load('dicotomicas.php?idtipo='+optionValue);  
                }else if(optionValue=='4'){
                    jQuery("#respuestas1")
                    .html(ajaxLoader)
                    .load('mulResp.php?idtipo='+optionValue);  
                }else if(optionValue=='5'){
                    jQuery("#respuestas1")
                    .html(ajaxLoader)
                    .load('abiertas.php?idtipo='+optionValue); 
                }else if(optionValue=='6'){
                    jQuery("#respuestas1")
                    .html(ajaxLoader)
                    .load('uniResp.php?idtipo='+optionValue); 
                }else if(optionValue=='7'){
                    jQuery("#respuestas1")
                    .html(ajaxLoader)
                    .load('apareamiento.php?idtipo='+optionValue); 
                }else if(optionValue=='8'){
                    jQuery("#respuestas1")
                    .html(ajaxLoader)
                    .load('analisis.php?idtipo='+optionValue); 
                }
                
                jQuery("#respuestas").css('display', 'none');
       }
        
    $(function() {
        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable"
        })
    });
    
        function enviar(){
        var id=$("#id_id").val();
        var order = $("#sortable2").sortable('toArray');
         $("#totaluser").val(order);
       
      /*  $.ajax({
            url:"llamadas.php",
            type:"post",
            dataType:"json",
            data:({Action_id:'nuevo',order:order,id:id}),
            success: function(data){
                if(data.val=='FALSE'){
                    alert(data.descrip);
                    return false;
                }else{
                    alert(data.descrip);
                }
                            }
        });*/
    }
    
bkLib.onDomLoaded(function() {
	new nicEditor({iconsPath : '../../images/nicEditorIcons.gif', maxHeight : 100}).panelInstance('descripcion');
        new nicEditor({iconsPath : '../../images/nicEditorIcons.gif', maxHeight : 100}).panelInstance('ayuda');
});
</script>
    <form action="save.php" method="post" id="form_test">
        <?php
        if($data['idsiq_Apregunta']!="")
            echo '<input type="hidden" name="idsiq_Apregunta" value="'.$data['idsiq_Apregunta'].'">';
        ?>
        <input type="hidden" name="entity" value="Apregnta">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <div id="container">
        <div class="full_width big">Preguntas</div>
        <h1>Creación de Preguntas</h1>
        <div class="demo_jui">
            <table border="0">
                <tbody>
                    <tr>
                        <td><label for="titulo"><span style="color:red; font-size:9px">(*)</span>Pregunta:</label></td>
                        <td><input type="text" name="numeroconvenio" id="numeroconvenio" style="width:420px;" title="Formule una pregunta" maxlength="200" tabindex="1" placeholder="Formule una pregunta" autocomplete="off" value="<?php echo $data['numeroconvenio']?>" /></td>
                        <td width="5%"></td>
                        <td><label for="obligatoria"><span style="color:red; font-size:9px">(*)</span>Obligatoria:</label></td>
                        <td><input type="checkbox" name="obligatoria" id="obligatoria" tabindex="6" title="Obligatoria" value="1" <?php if($data['renovacionautomatica']==1) echo "checked"; ?>  />
                        <td>
                    </tr>
                    <tr>
                        <td><label for="fecharenovacion"><span style="color:red; font-size:9px">(*)</span>Categoria:</label></td>
                        <td><select id="categoriapregunta" name="categoriapregunta">
                                <option id="">-Seleccione-</option>
                                <option id="1">Percepción</option>
                                <option id="2">Conocimiento</option>
                            </select>
                        </td>
                        <td></td>
                        <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Tipo:</label></td>
                        <td>
                            <?php
                                $query_tipopregunta= "SELECT '-Seleccione- ' AS nombre, NULL AS idsiq_Atipopregunta union SELECT nombre, idsiq_Atipopregunta FROM siq_Atipopregunta where codigoestado=100";
                                $reg_tipopregunta = $db->Execute($query_tipopregunta);
                                echo $reg_tipopregunta->GetMenu2('idsiq_Atipopregunta',$data['idsiq_Atipopregunta'],false,false,1,' id="idsiq_Atipopregunta" tabindex="15"  ');
                            ?>
                    </tr>
                    <tr>
                        <td colspan="5" >
                            <div  id="respuestas" style="display: none;"> 
                                
                            </div>
                            <div  id="respuestas1"> 
                                <fieldset>
                                        <legend>Respuestas</legend>
                                </fieldset>    
                            </div>    
                        </td>
                    </tr>
                    
                    <tr>
                    <td valign="top"><label for="descripcion">Descripción:</label></td>
                        <td>
                            <div id="sample">
                                <textarea style="height: 100px;" cols="50" id="descripcion">

                                </textarea>
                            </div>
                        </td>
                        <td></td>
                        <td valign="top"><label for="ayuda">Ayuda:</label></td>
                        <td>
                            <div id="sample">
                                <textarea style="height: 100px;" cols="50" id="ayuda">

                                </textarea>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4"  valign="top">
                                <fieldset>
                                    <legend>Indicadores de Percepción</legend>
                                    <ul id="sortable1" class="connectedSortable">
                                        <?php
                                            foreach($data as $dt){
                                                //print_r($dt);
                                                $id=$dt['idsiq_indicador'];
                                                echo '<li class="ui-state-default" id="'.$id.' ">'.$dt['nombre'];
                                                echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$id.'" />';
                                                echo'</li>';
                                                $i++;
                                            }
                                            
                                        ?>
                                        <li class="ui-state-default" id="1">xxxx</li>
                                   </ul>
                               </fieldset>
                        </td>
                        <td  valign="top">
                                 <fieldset>
                                     <legend>Indicadores Asignados</legend>
                                    <ul id="sortable2" class="connectedSortable">
                                         <li class="ui-state-highlight" id="0">Arrastrar Aqui
                                         </li>
                                    </ul>
                                    <br>
                                    <input type="text" name="totaluser" id="totaluser" value="" />
                                </fieldset>
                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="demo">
                <input type="submit" value="Guardar"/>
                <input type="submit" value="Cancelar"/>
            </div><!-- End demo -->
        </div>
    </div>  
  </form>
    
<?php    writeFooter();
        ?>  

