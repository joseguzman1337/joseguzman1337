<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

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
bkLib.onDomLoaded(function() {
        //new nicEditor({contenteditable : false}).panelInstance('titulo');
        jQuery('.nicEdit-main').attr('contenteditable','false');
        jQuery('.nicEdit-panel').hide();
    });
    
    /*  $(function() {
        var fastLiveFilterNumDisplayed = $('#fastLiveFilter .connectedSortable');
			$("#fastLiveFilter .filter_input").fastLiveFilter("#fastLiveFilter .connectedSortable");
    });*/
    
   /*   $(function() {
                      $('#filter_input').fastLiveFilter('#sortable1');
                       });
     */                  
      $(function() {
        $( "#sortable2" ).sortable({
            connectWith: ".connectedSortable"
        })
        
    });
    
    
    $(document).ready(function(){    
              $('#codigocarrera').attr('disabled',true);
             jQuery("select[name='idsiq_discriminacionIndicador']").change(function(){displayCarrera();});
             jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera2();});
           //  jQuery("select[name='codigocarrera']").change(function(){displayIndicadores(3);});
    });
    
    function displayIndicadores(tipo){
       // alert('hola');
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue1 = jQuery("select[name='idsiq_discriminacionIndicador']").val();
           if (optionValue1==3){
               optionValue = jQuery("select[name='codigocarrera']").val();
               option=1;
           }else{
               optionValue = jQuery("select[name='idsiq_discriminacionIndicador']").val();
               option=3
           }
        jQuery("#fastLiveFilter")
            .html(ajaxLoader)
            .load('generaindicadores.php', {id: optionValue, opt: option, status: 1}, function(response){					
            if(response) {
                jQuery("#fastLiveFilter").css('display', '');                    
            } else {                    
                jQuery("#fastLiveFilter").css('display', 'none');               
            }
        });     
    }
    
    function displayCarrera(){
           // $("#codigocarrera").load('generacarrera_facultad.php?id=0');
       
           var optionValue = jQuery("select[name='idsiq_discriminacionIndicador']").val();
           if (optionValue==3){
               $('#codigomodalidadacademica').attr('disabled',false);
           }else{
               $('#codigomodalidadacademica').attr('disabled',true);
               displayIndicadores(1);
           }

       }
       
      
      function displayCarrera2(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        jQuery("#carreraAjax")
            .html(ajaxLoader)
            .load('generacarrera.php', {id: optionValue, status: 1}, function(response){					
            if(response) {
                jQuery("#carreraAjax").css('display', '');                    
            } else {                    
                jQuery("#carreraAjax").css('display', 'none');               
            }
        });     
    }
    
 </script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Apregunta" id="idsiq_Apregunta" value="<?php echo $data['idsiq_Apregunta'] ?>">
        <input type="hidden" name="entity" id="entity" value="Apreguntaindicador">
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
       <!-- <div id="fastLiveFilter">
					<h2>jquery.fastLiveFilter 1.0.3</h2>
					<input class="filter_input" placeholder="Type to filter">
					<div>
						Time: <span class="delay">0</span>ms<br>
						Showing: <span class="num_displayed">?</span>
					</div>
					<ul class="list_to_filter">
                                            <li>1</li>
                                            <li >27</li>
                                            <li>3</li>
                                        </ul>
				</div>-->
            <fieldset>
                <table>
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
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data2[0]['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                                </td>
                    </tr>
                    <tr>
                                <td><label for="obligatoria"><span></span>Programa:</label></td>
                                <td>
                                    <div  id="carreraAjax" style="display: none;"> 
                                    
                                    </div>
                                </td>
                                    
                            </tr>
                    <tr>
                        <td valign="top" colspan="2">
                               <!-- <fieldset slyle="width: 50px;">-->
                                    <legend>Indicadores de Percepción</legend>
                                    <div id="fastLiveFilter" style="width:473px; height:515px; overflow: scroll;" >
                                      
                                   </div>
                              <!-- </fieldset>-->
                        </td>
                        <td  valign="top" colspan="2">
                                <!-- <fieldset>-->
                                     <legend>Indicadores Asignados</legend>
                                     <div id="22" style="width:473px; height:500px; overflow: scroll;">
                                         
                                        <ul id="sortable2" class="connectedSortable">
                                            <li class="ui-state-highlight" style="width:400px;" id="0">Arrastrar Aqui
                                            </li>
                                            <?php
                                            if (!empty($id_pregunta)){
                                                    $query_indicador_sec= "SELECT
                                                                    i.idsiq_indicador,
                                                                    i.ubicacion,
                                                                    i.fecha_ultima_actualizacion,
                                                                    i.fecha_proximo_vencimiento,
                                                                    i.idEstado,
                                                                    i.es_objeto_analisis,
                                                                    i.tiene_anexo,
                                                                    i.inexistente,
                                                                    i.discriminacion,
                                                                    ig.idsiq_indicadorGenerico,
                                                                    ig.idAspecto,
                                                                    ig.nombre,
                                                                    ig.descripcion,
                                                                    ig.idTipo,
                                                                    ig.area,
                                                                    ig.codigo,
                                                                    c.codigocarrera,
                                                                    c.codigocortocarrera,
                                                                    c.nombrecortocarrera,
                                                                    c.nombrecarrera,
                                                                    c.codigofacultad, 
                                                                    pi.idsiq_Apreguntaindicador, 
                                                                    pi.disiq_indicador
                                                                    FROM 
                                                                    siq_indicadorGenerico as ig
                                                                    inner join siq_indicador as i on (ig.idsiq_indicadorGenerico=i.idindicadorGenerico)
								    inner join siq_Apreguntaindicador as pi on (pi.disiq_indicador=i.idsiq_indicador)
                                                                    left join carrera as c on (c.codigocarrera=i.idCarrera)
                                                                    WHERE idTipo ='2' and ig.codigoestado=100 and i.codigoestado=100 and pi.codigoestado=100
                                                                    and pi.idsiq_Apregunta='".$id_pregunta."' ";
                                                   // echo $query_indicador_sec;
                                                    $data_in_sec= $db->Execute($query_indicador_sec);
                                                // print_r($data_in);
                                                    $i=0;
                                                    foreach($data_in_sec as $dt_sec){
                                                    // print_r($dt);
                                                           $nombre=$dt_sec['nombre'];
                                                            $dis=$dt_sec['discriminacion'];
                                                            $carrera=$dt_sec['nombrecortocarrera'];
                                                            $idpreg=$dt_sec['idsiq_Apreguntaindicador'];
                                                            $codigo=$dt_sec['codigo'];
                                                            if ($dis==3){
                                                                $nombre=$codigo.' - '.$nombre.'('.$carrera.')';
                                                            }else{
                                                                $nombre=$codigo.' - '.$nombre.'(Institucional)';
                                                            }
                                                    
                                                        $id=$dt_sec['idsiq_indicador'];
                                                        echo '<li class="ui-state-default" style="width:400px;" id="'.$id.' ">'.$nombre;
                                                        echo '<input type="hidden" name="idsiq_Apreguntaindicador1['.$i.']" id="idsiq_Apreguntaindicador1_'.$i.'" style="width: 50px" value="'.$idpreg.'" >';
                                                        echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$id.'" />';
                                                        echo'</li>';
                                                        $i++;
                                                    }
                                            }
                                            ?>
                                        </ul>
                                     </div>
                                    <br>
                                    <input type="hidden" name="totalindicadores" id="totalindicadores" value="" />
                               <!-- </fieldset>-->
                        </td>
                    </tr>
                </table>
                    
            </fieldset>
            <br>
        </div>
            <div class="derecha">
                <button class="submit" type="submit">Siguiente</button>
                &nbsp;&nbsp; 
                <a href="respuesta.php?id_pregunta=<?php echo $id_pregunta ?>&tipo_pregunta=<?php echo $data['idsiq_Atipopregunta'] ?>" class="submit" >Atras</a>
                &nbsp;&nbsp; 
                <a href="preguntaslistar.php" class="submit" >Regreso al menú</a>
            </div><!-- End demo -->
    </div>  
  </form>
<script type="text/javascript">
     $("#titulo").attr("disabled",true);
     $("#obligatoria").attr("disabled",true);
     $("#categoriapregunta").attr("disabled",true);
     $("#idsiq_Atipopregunta").attr("disabled",true);
              

       
                $(':submit').click(function(event) {
                    nicEditors.findEditor('titulo').saveContent();
                    nicEditors.findEditor('ayuda').saveContent();
                    nicEditors.findEditor('descripcion').saveContent();
                     var id=$("#id_id").val();
                     var order = $("#sortable2").sortable('toArray');
                     $("#totalindicadores").val(order);
                     var veri=$("#verificada").val();
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                      if (veri==2){
                          sendForm();
                      } else{
                           var idPreg = $("#idsiq_Apregunta").val();
                           var tipoPreg = jQuery("select[name='idsiq_Atipopregunta'] option:selected").index();
                           $(location).attr('href','pregunta_documental.php?id_pregunta='+idPreg+'&tipo_pregunta='+tipoPreg);
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

