<?php
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Respuestas",true,"Autoevaluacion");
  $id_pregunta=$_REQUEST['id_pregunta'];
  $tipo_pregunta=$_REQUEST['tipo_pregunta'];
   if (!empty($id_pregunta)){
    $entity = new ManagerEntity("Apregunta");
    $entity->sql_where = "idsiq_Apregunta =".$id_pregunta." ";
    // $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
   }
   
  
?>

<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script>
      
      function popup_carga(pregunta,indicador,estado,documento){
         // alert('hola');
          var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=si, resizable=si, width=850, height=700, top=400, left=500";
          if (estado=='crear'){
            window.open('../../SQI_Documento/Carga_Documento.html.php?actionID=Percepcion&pregunta_id='+pregunta+'&indicador_id='+indicador,"",opciones);
          }else{
              window.open('../../SQI_Documento/Documento_Ver.html.php?Docuemto_id='+documento,"",opciones);
          }
      }
      
bkLib.onDomLoaded(function() {
        //new nicEditor({contenteditable : false}).panelInstance('titulo');
        jQuery('.nicEdit-main').attr('contenteditable','false');
        jQuery('.nicEdit-panel').hide();
    });
    
    $(function() {
        var fastLiveFilterNumDisplayed = $('#fastLiveFilter .list_to_filter');
			$("#fastLiveFilter .filter_input").fastLiveFilter("#fastLiveFilter .list_to_filter");
    });
    
    
      $(function() {
        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable"
        })
    });
    
 </script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Apregunta" id="idsiq_Apregunta" value="<?php echo $data['idsiq_Apregunta'] ?>">
        <input type="hidden" name="entity" id="entity" value="Apregunta">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
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
        <br>
                <table>
                    <tr>
                       <td  valign="top">
                                 <fieldset>
                                     <legend>Indicadores con anexos</legend>
                                        <table border="1" width="500px">
                                            <?php
                                            if (!empty($id_pregunta)){
                                                    $query_indicador_sec= "SELECT i.idsiq_indicador, i.ubicacion, i.fecha_ultima_actualizacion, 
                                                                            i.fecha_proximo_vencimiento, i.idEstado, i.es_objeto_analisis, i.tiene_anexo, 
                                                                            i.inexistente, i.discriminacion, ig.idsiq_indicadorGenerico, ig.idAspecto, 
                                                                            ig.nombre, ig.descripcion, ig.idTipo, ig.area, c.codigocarrera, c.codigocortocarrera, 
                                                                            c.nombrecortocarrera, c.nombrecarrera, c.codigofacultad, pi.idsiq_Apreguntaindicador, 
                                                                            pi.disiq_indicador, pd.idsiq_Apregunta, d.idsiq_documento, d.codigoestado as estadodoc, pi.idsiq_Apregunta as idpregunta
                                                                            FROM siq_indicadorGenerico as ig 
                                                                            inner join siq_indicador as i on (ig.idsiq_indicadorGenerico=i.idindicadorGenerico) 
                                                                            inner join siq_Apreguntaindicador as pi on (pi.disiq_indicador=i.idsiq_indicador) 
                                                                            left join siq_Apreguntadocumental as  pd on (pd.idsiq_Apregunta=pi.idsiq_Apregunta)
                                                                           left join siq_documento as d on (d.idsiq_documento=pd.disiq_documento and d.siqindicador_id=pi.disiq_indicador)
                                                                            left join carrera as c on (c.codigocarrera=i.idCarrera) 
                                                                            WHERE idTipo ='2' 
                                                                            and ig.codigoestado=100 
                                                                            and i.codigoestado=100 and pi.codigoestado=100 and pi.idsiq_Apregunta='".$id_pregunta."' "; 
                                                   // echo $query_indicador_sec;
                                                    $data_in_sec= $db->Execute($query_indicador_sec);
                                                // print_r($data_in);
                                                    $i=0;
                                                    
                                                    foreach($data_in_sec as $dt_sec){
                                                    // print_r($dt);
                                                            $nombre=$dt_sec['nombre'];
                                                            $dis=$dt_sec['discriminacion'];
                                                            $carrera=$dt_sec['nombrecortocarrera'];
                                                            $anexo=$dt_sec['tiene_anexo'];
                                                            $indicador=$dt_sec['idsiq_indicador'];
                                                            $estado=$dt_sec['estadodoc'];
                                                            $documento=$dt_sec['idsiq_documento'];
                                                            $id_pregunta=$dt_sec['idpregunta'];
                                                            
                                                            if ($dis==3){
                                                                $nombre=$nombre.'('.$carrera.')';
                                                            }else{
                                                                $nombre=$nombre.'(Institucional)';
                                                            }
                                                            if ($anexo==1 and $estado!=200){
                                                                echo '<tr><td>'.$nombre.'</td>
                                                                          <td>';
                                                                if (empty($documento)){
                                                                    echo 'Cargar <br><img src="../../images/cargar.jpg" alt="Smiley face" height="42" width="42" id="cargar" name="carga" onclick=\'popup_carga("'.$id_pregunta.'","'.$indicador.'","crear","");\' > </td>';
                                                                }else{
                                                                    if (empty($id_pregunta)){
                                                                        echo 'Cargar <br><img src="../../images/cargar.jpg" alt="Smiley face" height="42" width="42" id="cargar" name="carga" onclick=\'popup_carga("'.$id_pregunta.'","'.$indicador.'","crear","");\' > </td>';
                                                                    }else{
                                                                        echo 'Ver/Editar <br><img src="../../images/cargar.jpg" alt="Smiley face" height="42" width="42" id="cargar" name="carga" onclick=\'popup_carga("'.$id_pregunta.'","'.$indicador.'","editar","'.$documento.'");\' > </td>';
                                                                    }
                                                                }
                                                                echo'</tr>';
                                                              /* echo ' <iframe src="../../SQI_Documento/Carga_Documento.html.php" style="margin-top: -25px" width="995" height="350" frameborder="0" id="frameDemo">                
                                                                      </iframe>';*/
                                                            }
                                                    
                                                        $id=$dt_sec['idsiq_indicador'];
                                                        $i++;
                                                    }
                                            }
                                            ?>
                                          </table>
                                    <br>
                                    <input type="hidden" name="totalindicadores" id="totalindicadores" value="" />
                                </fieldset>
                        </td>
                    </tr>
                </table>
            <br>
        </div>
            <div class="derecha">
                <?php
                    if ($data['verificada']==2){
                ?>
                    <button class="submit" id="guardar" type="submit">Verificar y Guardar</button>
                 <?php
                    }else{
                ?>    
                    <button class="submit" id="duplicar" type="submit">Duplicar Pregunta</button>
                           <?php
                              $query_dupli="SHOW TABLES where Tables_in_sala like '%Apregunta%' and Tables_in_sala like '%siq%' ";
                             // echo $query_dupli;
                              $data_dupli=$db->Execute($query_dupli);
                              $i=0;
                              foreach($data_dupli as $dt_dp){
                                echo '<input type="hidden" name="duplicar['.$i.']" id="duplicar_'.$i.'" value="'.$dt_dp['Tables_in_sala'].'" />';
                                $i++; 
                              }
                            ?>
                    
                  <?php
                    }
                ?>   
                    
                &nbsp;&nbsp; 
                <a href="preguntaslistar.php" class="submit" >Regreso al menú</a>
              <!--  <a href="respuesta.php?id_pregunta=<?php echo $id_pregunta ?>&tipo_pregunta=<?php echo $data['idsiq_Atipopregunta'] ?>" class="submit" >Atras</a>-->
            </div><!-- End demo -->
    </div>  
  </form>
<script type="text/javascript">
     $("#titulo").attr("disabled",true);
     $("#obligatoria").attr("disabled",true);
     $("#categoriapregunta").attr("disabled",true);
     $("#idsiq_Atipopregunta").attr("disabled",true);
              

            
            $('#close').click(function(){
        $('#popup').fadeOut('slow');
    });

                $('#duplicar').click(function(event) {
                    nicEditors.findEditor('titulo').saveContent();
                    nicEditors.findEditor('ayuda').saveContent();
                    nicEditors.findEditor('descripcion').saveContent();
                     var id=$("#id_id").val();
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                      sendForm();
                   }
                });
                
                $('#guardar').click(function(event) {
                    nicEditors.findEditor('titulo').saveContent();
                    nicEditors.findEditor('ayuda').saveContent();
                    nicEditors.findEditor('descripcion').saveContent();
 
                     $("#verificada").val('1');
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                      sendForm();
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
                                $(location).attr('href','pregunta_documental.php?id_pregunta='+data.id+'&tipo_pregunta='+tipoPreg);
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

