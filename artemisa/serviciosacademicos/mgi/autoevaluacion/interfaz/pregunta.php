<?php
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Preguntas",true,"Autoevaluacion");
   $cat_ins=$_REQUEST['cat_ins'];
		$carrera = 1;
		$nombrecarrera="";
       if($_REQUEST["cat_ins"]=="EDOCENTES"&&$_SESSION["codigofacultad"]!=1&&$_SESSION["codigofacultad"]!=156 ){
			$carrera = $_SESSION["codigofacultad"];
			$nombrecarrera = " - ".$_SESSION["nombrefacultad"];
	   } 
   
  if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("Apregunta");
    $entity->sql_where = "idsiq_Apregunta = ".str_replace('row_','',$_REQUEST['id'])."";
   // $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    //print_r($data);
  }
?>
<script type="text/javascript">
   
    bkLib.onDomLoaded(function() {
            if ( $("#verificada").val()==1 ){
                    jQuery('.nicEdit-main').attr('contenteditable','false');
                    jQuery('.nicEdit-panel').hide();
              }else{
                   bkLib.onDomLoaded(nicEditors.allTextAreas);
                   /*var myNicEditor = new nicEditor({fullPanel : true,iconsPath : '../../images/nicEditorIcons.gif'});
                    myNicEditor.setPanel('titulo1');
                    myNicEditor.addInstance('titulo');  */
              }
        
    });


</script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Apregunta" id="idsiq_Apregunta" value="<?php echo $data['idsiq_Apregunta'] ?>">
        <input type="hidden" name="entity" id="entity" value="Apregunta">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="cat_ins" id="cat_ins" value="<?php echo $cat_ins ?>" />
        <input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $carrera ?>" />
        <input type="hidden" name="verificada" id="verificada" value="<?php  if (empty($data['verificada'])){ echo "2"; }else{ echo $data['verificada']; } ?>">
        <div id="container">
        <div class="full_width big">Preguntas</div>
        <fieldset>
            <legend>Creaci&oacute;n de Pregunta<?php echo $nombrecarrera; ?></legend>
                <div class="demo_jui">
                    <table border="0">
                        <tbody>
                            <tr>
                                <td><label for="titulo"><span style="color:red; font-size:9px">(*)</span>Pregunta:</label></td>
                                <td colspan="4">
                                    <div id="titulo1">
                                        <textarea style="height: 50px;" cols="90" id="titulo" name="titulo"><?php echo $data['titulo']; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="obligatoria"><span style="color:red; font-size:9px">(*)</span>Obligatoria:</label></td>
                                <td><input type="checkbox" name="obligatoria" id="obligatoria" tabindex="6" title="Obligatoria" value="1" <?php if($data['obligatoria']==1) echo "checked"; ?>  />
                                <td></td>
                                <td></td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="fecharenovacion"><span style="color:red; font-size:9px">(*)</span>Categoria:</label></td>
                                <td><select id="categoriapregunta" name="categoriapregunta">
                                    <option value=""  >-Seleccione-</option>
                                    <option value="1" <?php if($data['categoriapregunta']==1) echo "selected"; ?>>Percepci&oacute;n</option>
                                        <option value="2" <?php if($data['categoriapregunta']==2) echo "selected"; ?>>Conocimiento</option>
                                    </select>
                                </td>
                                <td></td>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Tipo:</label></td>
                                <td>
                                    <?php
                                        $query_tipopregunta= "SELECT '' AS nombre, NULL AS idsiq_Atipopregunta union SELECT nombre, idsiq_Atipopregunta FROM siq_Atipopregunta where codigoestado=100";
                                        $reg_tipopregunta = $db->Execute($query_tipopregunta);
                                        echo $reg_tipopregunta->GetMenu2('idsiq_Atipopregunta',$data['idsiq_Atipopregunta'],false,false,1,' id="idsiq_Atipopregunta" tabindex="15"  ');
                                    ?>
                           </tr>

                            <tr>
                                <td valign="top"><label for="descripcion">Descripci&oacute;n:</label></td>
                                <td>
                                    <div id="descrip1">
                                    <textarea style="height: 100px;" cols="50" id="descripcion" name="descripcion">
                                                <?php
                                                echo $data['descripcion'];
                                            ?>
                                        </textarea>
                                        </div>

                                </td>
                                <td></td>
                                <td valign="top"><label for="ayuda">Ayuda:</label></td>
                                <td>
                                    <div id="ayuda1">
                                        <textarea style="height: 100px;" cols="50" id="ayuda" name="ayuda">
                                            <?php
                                                echo $data['ayuda'];
                                            ?>
                                        </textarea>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
            </fieldset>
                        </div>
                   <div class="derecha">
                        <button class="submit" type="submit">Siguiente</button>
                        &nbsp;&nbsp;
                        <a href="preguntaslistar.php?cat_ins=<?php echo $cat_ins ?>" class="submit" >Regreso al men&uacute;</a>
                    </div><!-- End demo -->
    </div>  
  </form>
<script type="text/javascript">
         if ( $("#verificada").val()==1 ){
                    $("#obligatoria").attr("disabled",true);
                    $("#categoriapregunta").attr("disabled",true);
                    $("#idsiq_Atipopregunta").attr("disabled",true);
                    $('#titulo').attr("disabled",true);
                    $('#descripcion').attr("disabled",true);
                    $('#ayuda').attr("disabled",true);
              }
              
    $(document).ready(function(){            
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
      
         function trim(str) {
                return str.replace(/^\s+|\s+$/g,"");
        }
     
                $(':submit').click(function(event) {
                   // $.trim(nicEditors.findEditor('titulo').saveContent());
                  //  nicEditors.findEditor('ayuda').saveContent();
                  //  nicEditors.findEditor('descripcion').saveContent();
                    event.preventDefault();
                        //alert($.trim(nicEditors.findEditor('titulo').getContent()));
                        if ( $("#verificada").val()==2 ){
                            document.getElementById("titulo").innerHTML = $.trim(nicEditors.findEditor('titulo').getContent());
                            document.getElementById("ayuda").innerHTML = $.trim(nicEditors.findEditor('ayuda').getContent());
                            document.getElementById("descripcion").innerHTML = $.trim(nicEditors.findEditor('descripcion').getContent());

                        }
                    //verifico que el mensaje no sea puro espacio en blanco y saltos de linea
                    var content = $.trim(document.getElementById("titulo").innerHTML); 
                    content = $("<div/>").html(content).text();
                    var find = '<br>';
                    var re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '<br/>';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '<br />';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    content = $.trim(content);
                    if(content==""){                        
                              valido = false;
                    } else {       
                            valido = true;
                    }
                        if($("#titulo").val()=='<br>') {
                                alert("La pregunta no debe estar vacio");
                                $("#titulo").focus();
                                return false;
                        }else if(valido==false) {
                                alert("La pregunta no debe estar vacio");
                                $("#titulo").focus();
                                return false;
                        }else if($("#categoriapregunta").val()==''){
                                alert("La categoria no debe estar vacio");
                                $("#categoriapregunta").focus();
                            return false;
                        }else if($("#idsiq_Atipopregunta").val()==''){
                                alert("El tipo de pregunta no debe estar vacio");
                                $("#idsiq_Atipopregunta").focus();
                            return false;
                        }else{
                            sendForm()
                        } 

                });
                
                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                
                                var tipoPreg = jQuery("select[name='idsiq_Atipopregunta'] option:selected").index();
                                var cat=$("#cat_ins").val();
                               // alert(data.id);
                                $(location).attr('href','respuesta.php?id_pregunta='+data.id+'&tipo_pregunta='+tipoPreg+'&cat_ins='+cat);
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
    
<?php    writeFooter();
        ?>  

