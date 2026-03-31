<?php
//error_reporting(E_ALL);
// ini_set("display_errors", 1);
 
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   $id_in=str_replace('row_','',$_REQUEST['id']);
   //echo $id_in.'-->id';
   if (!empty($id_in)){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion = ".$id_in."";
   //  $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    
    
    $entity1 = new ManagerEntity("Apublicacion");
    $entity1->sql_where = "idsiq_Ainstrumentoconfiguracion = ".$id_in."";
   //  $entity->debug = true;
    $data1 = $entity1->getData();
    $data1 =$data1[0];
   // print_r($data1);
    
   }
   
  
?>
  
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script>
bkLib.onDomLoaded(function() {
        //new nicEditor({contenteditable : false}).panelInstance('titulo');
        jQuery('.nicEdit-main').attr('contenteditable','false');
        jQuery('.nicEdit-panel').hide();
    });
    
    $(function() {
        var fastLiveFilterNumDisplayed = $('#fastLiveFilter .connectedSortable');
			$("#fastLiveFilter .filter_input").fastLiveFilter("#fastLiveFilter .connectedSortable");
    });
    
    
      $(function() {
        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable"
        })
        
    });
    
    $(function() {
         //$('#codigocarrera').attr('disabled',true);
        
        $('#fechahorainicio').datetimepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd',
                        minDate:"<?php echo $data['fecha_inicio']?>",
                        maxDate: "<?php echo $data['fecha_fin']?>"
        });
        
        $('#fechahorafin').datetimepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd',
                        minDate:"<?php echo $data['fecha_inicio']?>",
                        maxDate: "<?php echo $data['fecha_fin']?>"
        });
    });
    
 </script>

  
    <form action="save.php" method="post" id="form_test" enctype="multipart/form-data">
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Ainstrumentoconfiguracion'] ?>">
        <input type="hidden" name="entity" id="entity" value="Apublicacion">
        <input type="hidden" name="idsiq_Apublicacion" id="idsiq_Apublicacion" value="<?php echo $data1['idsiq_Apublicacion'] ?>">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="aprobada" id="aprobada" value="<?php echo $data['aprobada']; ?>">
        <div id="container">
        <div class="full_width big">Instrumento</div>
        <fieldset>
            <legend>Instrumento</legend>
        <div>
            <table border="0">
                        <tbody>
                            <tr>
                                <td><label for="titulo"><span style="color:red; font-size:9px">(*)</span>Nombre:</label></td>
                                <td colspan="4">
                                    <div id="nombre1">
                                        <textarea style="height: 50px;" cols="90" id="nombre" name="nombre"><?php echo $data['nombre']; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="obligatoria"><span style="color:red; font-size:9px">(*)</span>Fecha Inicio:</label></td>
                                <td>
                                    <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $data['fecha_inicio']; ?>" />
                                </td>
                                <td><label for="fecharenovacion"><span style="color:red; font-size:9px">(*)</span>Fecha Fin:</label></td>
                                <td><input type="text" name="fecha_fin" id="fecha_fin" value="<?php echo $data['fecha_fin']; ?>" />
                                </td>
                                
                             <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Estado:</label></td>
                                <td>
                                    <select id="estado" name="estado">
                                    <option value=""  >-Seleccione-</option>
                                        <option value="1" <?php if($data['estado']==1) echo "selected"; ?>>Activa</option>
                                        <option value="2" <?php if($data['estado']==2) echo "selected"; ?>>Inactiva</option>
                                    </select>
                                </td>
                                <td><label for="obligatoria"><span></span>Utiliza Secciones:</label></td>
                                <td>
                                    <input type="checkbox" name="secciones" id="secciones" tabindex="6" title="Secciones" value="1" <?php if($data['secciones']==1) echo "checked"; ?>  />
                                </td>
                                    
                            </tr>
                            <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Tipo:</label></td>
                                <td>
                                    <?php
                                        $query_tipo= "SELECT ' ' AS nombre, ' ' AS idsiq_discriminacionIndicador union 
                                                      SELECT nombre, idsiq_discriminacionIndicador
                                                      FROM siq_discriminacionIndicador where codigoestado=100 order by idsiq_discriminacionIndicador";
                                        $reg_tipo = $db->Execute($query_tipo);
                                        echo $reg_tipo->GetMenu2('idsiq_discriminacionIndicador',$data['idsiq_discriminacionIndicador'],false,false,1,' id="idsiq_discriminacionIndicador" tabindex="15"  ');
                                    ?>
                                </td>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Modalidad Academica:</label></td>
                                <td>
                                    <?php
                                        $query_programa = "SELECT '' as nombremodalidadacademica, '' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="obligatoria"><span></span>Programa:</label></td>
                                <td>
                                    <?php
                                        $query_carrera= "SELECT ' ' AS nombrecarrera, ' ' AS codigocarrera union SELECT nombrecarrera, codigocarrera FROM carrera ";
                                        $reg_carrera = $db->Execute($query_carrera);
                                        echo $reg_carrera->GetMenu2('codigocarrera',$data['codigocarrera'],false,false,1,' id="codigocarrera" tabindex="15" style="width:250px;" ');
                                    ?>
                                </td>
                                <td></td>
                                <td>
                                    
                                </td>  
                            </tr>
                             <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Periodicidad:</label></td>
                                <td>
                                    <?php
                                        $query_tipo= "SELECT ' ' AS periodicidad, ' ' AS idsiq_periodicidad union 
                                                      SELECT periodicidad, idsiq_periodicidad
                                                      FROM siq_periodicidad where codigoestado=100 order by idsiq_periodicidad";
                                        $reg_tipo = $db->Execute($query_tipo);
                                        echo $reg_tipo->GetMenu2('idsiq_periodicidad',$data['idsiq_periodicidad'],false,false,1,' id="idsiq_periodicidad" tabindex="15"  ');
                                    ?>
                                </td>
                                <td><label>Visualizar Instrumento:</label></td>
                                <td>
                                    <div class="derecha">
                                        <a href="instrumento_visualizar.php?aprobar=1&id_instrumento=<?php echo $id_in ?>&cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" target="_blank" onClick="window.open(this.href, this.target, 'width=500,height=800,scrollbars=yes'); return false;">Visualizar Instrumento</a>
                                           <!-- <a href="instrumento_visualizar.php?id_instrumento=<?php //echo $id ?>" target="_blank" class="submit" >Visualizar Instrumento</a>-->
                        
                                    </div><!-- End demo -->
                                </td>
                                    
                            </tr>
                          <!--  <tr>
                            <td valign="top"><label for="descripcion">Bienvenida:</label></td>
                                <td>
                                    <div id="mostrar_bienvenida1">
                                    <textarea style="height: 100px;" cols="50" id="mostrar_bienvenida" name="mostrar_bienvenida">
                                                <?php
                                                echo $data['mostrar_bienvenida'];
                                            ?>
                                        </textarea>
                                        </div>

                                </td>
                                <td valign="top"><label for="ayuda">Despedida:</label></td>
                                <td>
                                    <div id="mostrar_despedida1">
                                        <textarea style="height: 100px;" cols="50" id="mostrar_despedida" name="mostrar_despedida">
                                            <?php
                                                echo $data['mostrar_despedida'];
                                            ?>
                                        </textarea>
                                    </div>
                                </td>
                            </tr>-->

                        </tbody>
                    </table>
            </fieldset>
        <br>
            <fieldset>
                <legend>Publicación</legend>
                <table>
                    <tr>
                        <td>Fecha Inicio</td>
                        <td><input type="text" name="fechahorainicio" id="fechahorainicio" value="<?php echo $data1['fechahorainicio']; ?>" /></td>
                        <td width="30%" ></td>
                        <td>Fecha Fin</td>
                        <td><input type="text" name="fechahorafin" id="fechahorafin" value="<?php echo $data1['fechahorafin']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Publicar</td>
                        <td><input type="checkbox" onclick="dato('publicar')"  name="publicar1" id="publicar1" tabindex="6" title="publicar"  <?php if($data1['publicar']==1) echo "checked"; ?>  />
                            <input type="hidden" name="publicar" id="publicar" value="<?php echo $data1['publicar']; ?>">
                            <div <?php if(empty($data1['publicar']) || $data1['publicar']==0){ ?>style="display:none;"<?php } ?> id="urlPublicacion">
                                <?php $url = "http://".$_SERVER['HTTP_HOST']."/serviciosacademicos/mgi/autoevaluacion/interfaz/phpcaptcha/Captcha_html.php?instrumento=".$id_in; ?>
                                La encuesta se encuentra en <a href="<?php echo $url; ?>" /><?php echo $url; ?></a>
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
        </div>
            <div class="derecha">
                <button class="submit" type="submit">Guardar</button>
                &nbsp;&nbsp; 
                <a href="configuracioninstrumentolistar.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" class="submit" >Regreso al menú</a>
            </div><!-- End demo -->
    </div>  
</form>
<script type="text/javascript">
     $("#titulo").attr("disabled",true);
     $("#fecha_inicio").attr("disabled",true);
     $("#fecha_fin").attr("disabled",true);
     $("#estado").attr("disabled",true);
     $("#secciones").attr("disabled",true);
     $("#idsiq_discriminacionIndicador").attr("disabled",true);
     $("#codigocarrera").attr("disabled",true);
     $("#codigomodalidadacademica").attr("disabled",true);
     $("#idsiq_periodicidad").attr("disabled",true);
        
         function dato(chec){
            //alert('hola')
            if($("#"+chec+"1").is(':checked')) {  
                $("#"+chec).val('1');
                $("#urlPublicacion").css("display", "block");
            }else{
                //$("#"+chec).val('NULL');
                $("#"+chec).val('0');
                $("#urlPublicacion").css("display", "none");
            }
            //alert($("#"+chec).val())
        }

               $(':submit').click(function(event) {
                    nicEditors.findEditor('nombre').saveContent();
                     var id=$("#id_id").val();
                     var order = $("#sortable2").sortable('toArray');
                     $("#totalsecciones").val(order);
                     var veri=$("#aprobada").val();
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                   // alert(valido+'->ok')
                    if(valido){
                      if (veri==2){
                          sendForm();
                      } else{
                          // var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
                          // $(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1');
                      }
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
                                //var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
                              //  $(location).attr('href','instrumento_usuarios.php?id_instrumento='+id_instrumento+'&secc=1');
                                //$(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1');
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

