<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Respuestas",true,"Autoevaluacion");
    $id_pregunta=$_REQUEST['id_pregunta'];
    $tipo_pregunta=$_REQUEST['tipo_pregunta'];
  $cat_ins=$_REQUEST['cat_ins'];
  
 // echo $tipo_pregunta.'xxx';
   if (!empty($id_pregunta)){
    $entity = new ManagerEntity("Apregunta");
     $entity->sql_where = "idsiq_Apregunta =".$id_pregunta." ";
   // $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    //print_r($data);
       
   }
?>

<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script>
bkLib.onDomLoaded(function() {
        //new nicEditor({contenteditable : false}).panelInstance('titulo');
        jQuery('.nicEdit-main').attr('contenteditable','false');
        jQuery('.nicEdit-panel').hide();
    });

</script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Apregunta" id="idsiq_Apregunta" value="<?php echo $data['idsiq_Apregunta'] ?>">
        <input type="hidden" name="entity" id="entity" value="Apregunta">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="cat_ins" id="cat_ins" value="<?php echo $cat_ins ?>" />
        <input type="hidden" name="verificada" id="verificada" value="<?php echo $data['verificada']; ?>">
        <div id="container">
        <div class="full_width big">Respuesta</div>
        <fieldset>
            <legend>Pregunta</legend>
        <div>
            <table border="0">
                <tbody>
                    <tr>
                        <td><label for="titulo">Titulo:</label></td>
                        <td colspan="4">
                             <div id="titulo1">
                                <textarea style="height: 50px;" cols="90" id="titulo" name="titulo" >
                                    <?php 
                                        echo $data['titulo']
                                    ?>
                                </textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="obligatoria">Obligatoria:</label></td>
                        <td><input type="checkbox" name="obligatoria" id="obligatoria" tabindex="6" title="Obligatoria" value="1" <?php if($data['obligatoria']==1) echo "checked"; ?>  />
                        <td>
                    </tr>
                    <tr>
                        <td><label for="fecharenovacion">Categoria:</label></td>
                        <td><select id="categoriapregunta" name="categoriapregunta">
                                <option id=""  >-Seleccione-</option>
                                <option id="1" <?php if($data['categoriapregunta']==1) echo "selected"; ?>>Percepción</option>
                                <option id="2" <?php if($data['categoriapregunta']==2) echo "selected"; ?>>Conocimiento</option>
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
                    <td valign="top"><label for="descripcion">Descripción:</label></td>
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
            <fieldset>
                <legend>Respuestas</legend>
                <?php 
                  // echo $tipo_pregunta;
                    if ($tipo_pregunta==1){
                        $scr="likert.php";
                    }elseif($tipo_pregunta==2){
                        $scr="gutman.php";
                    }elseif($tipo_pregunta==3){
                        $scr="dicotomicas.php";
                    }elseif($tipo_pregunta==4){
                        $scr="mulResp.php";
                    }elseif($tipo_pregunta==5){
                        $scr="abiertas.php";
                    }elseif($tipo_pregunta==6){
                        $scr="uniResp.php";
                    }elseif($tipo_pregunta==7){
                        $scr="analisis.php";
                    }elseif($tipo_pregunta==8){
                        $scr="analisis.php";
                    }
                ?>
                <iframe src="<?php echo $scr ?>?idsiq_Apregunta=<?php echo $id_pregunta ?>&verificada=<?php echo $data['verificada']; ?>" style="margin-top: -25px" width="995" height="350" frameborder="0" id='frameDemo'>
                </iframe> 
            </fieldset>
            <br>
        </div>
            <div class="derecha">
                <?php if($cat_ins=='MGI' || $cat_ins=='EGRESADOS'){ ?>
                <a href="pregunta_indicadores.php?id_pregunta=<?php echo $id_pregunta ?>&cat_ins=<?php echo $cat_ins ?>" class="submit" >Siguiente</a>
                <?php } ?>
                &nbsp;&nbsp; 
                <a href="pregunta.php?id=row_<?php echo $id_pregunta ?>&cat_ins=<?php echo $cat_ins ?>" class="submit" >Atras</a>
                &nbsp;&nbsp;
                <a href="preguntaslistar.php?cat_ins=<?php echo $cat_ins ?>" class="submit" >Regreso al men&uacute;</a>
            </div><!-- End demo -->
    </div>  
  </form>
<script type="text/javascript">
     $("#titulo").attr("disabled",true);
     $("#obligatoria").attr("disabled",true);
     $("#categoriapregunta").attr("disabled",true);
     $("#idsiq_Atipopregunta").attr("disabled",true);
     $('#titulo').attr("disabled",true);
     $('#descripcion').attr("disabled",true);
     $('#ayuda').attr("disabled",true);
              
    
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
      
                $(':submit').click(function(event) {
                    nicEditors.findEditor('titulo').saveContent();
                    nicEditors.findEditor('ayuda').saveContent();
                    nicEditors.findEditor('descripcion').saveContent();
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                      sendForm();
                     // alert('Proceso realizado satisfactoriamente');
                   }
                   var idpreg = $("#idsiq_Apregunta").val();
                   
                   $(location).attr('href','respuesta.php?id=row_'+idpreg);
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
                                alert(data.id);
                                var tipoPreg = jQuery("select[name='idsiq_Atipopregunta'] option:selected").index();
                                var cat=$("#cat_ins").val();
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

