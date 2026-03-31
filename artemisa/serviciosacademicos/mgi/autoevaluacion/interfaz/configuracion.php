<?php
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Preguntas",true,"Autoevaluacion");
   $cat_ins=$_REQUEST['cat_ins'];
   
  if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion = ".str_replace('row_','',$_REQUEST['id'])."";
   // $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    //print_r($data);
  }
		$carrera = 0;
		$nombrecarrera="";
       if($_REQUEST["cat_ins"]=="EDOCENTES"&&$_SESSION["codigofacultad"]!=1&&$_SESSION["codigofacultad"]!=156 ){
			$carrera = $_SESSION["codigofacultad"];
			$nombrecarrera = " - ".$_SESSION["nombrefacultad"];
	   } else {
			$carrera = $data["codigocarrera"];
		}	   
?>
<script type="text/javascript">
  
   
   $(document).ready(function(){    
//             jQuery("select[name='idsiq_discriminacionIndicador']").change(function(){displayCarrera();});
               //$('#codigocarrera').attr('disabled',true);
               jQuery("select[name='idsiq_discriminacionIndicador']").change(function(){displayCarrera();});
               jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera2();});
             
    });
    
     function displayCarrera(){
           // $("#codigocarrera").load('generacarrera_facultad.php?id=0');
       
           var optionValue = jQuery("select[name='idsiq_discriminacionIndicador']").val();
           if (optionValue==3){
               //$('#codigomodalidadacademica').attr('disabled',false);
               
           }else{
               //$('#codigomodalidadacademica').attr('disabled',true);
               $("#codigocarrera").val(' ');
               $("#codigomodalidadacademica").val(' ');
               jQuery("#carreraAjax").css('display', 'none');  
           }

       }
    
    function displayCarrera2(){
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        jQuery("#carreraAjax")
            .html(ajaxLoader)
            .load('generacarrera.php', {id: optionValue, opt:'sin_ind', status: 1}, function(response){					
            if(response) {
                jQuery("#carreraAjax").css('display', '');     
                jQuery("#carreraAjax2").css('display', 'none');                    
            } else {                    
                jQuery("#carreraAjax").css('display', 'none'); 
                jQuery("#carreraAjax2").css('display', '');                    
            }
        });     
    }
   
   
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
    $(function() {
         //$('#codigocarrera').attr('disabled',true);
        
        $('#fecha_inicio').datetimepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd',
                        minDate: "<?php echo date('Y-m-d')?>"
        });
        
        $('#fecha_fin').datetimepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd',
                        minDate: "<?php echo date('Y-m-d')?>"
        });
    });


</script>

    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Ainstrumentoconfiguracion'] ?>">
        <input type="hidden" name="entity" id="entity" value="Ainstrumentoconfiguracion">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="cat_ins" id="cat_ins" value="<?php echo $cat_ins ?>" />
        <input type="hidden" name="secciones" id="secciones" value="1" />
        <input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $carrera ?>" />
        <input type="hidden" name="verificada" id="verificada" value="<?php  if (empty($data['verificada'])){ echo "2"; }else{ echo $data['verificada']; } ?>">
        <div id="container">
        <div class="full_width big">Instrumento</div>
        <fieldset>
            <legend>Configuración del Instrumento</legend>
                <div class="demo_jui">
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
                                    <?php if(isset($_REQUEST["cat_ins"]) && $_REQUEST["cat_ins"]==="EC") { ?>
                                    <input type="hidden" name="estado" id="estado" value=1" />
                                    <?php } ?>
                                </td>
                                <?php if(!isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]!=="EC") { ?>
                             <tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Estado:</label></td>
                                <td>
                                    <select id="estado" name="estado">
                                    <option value=""  >-Seleccione-</option>
                                        <option value="1" <?php if($data['estado']==1) echo "selected"; ?>>Activa</option>
                                        <option value="2" <?php if($data['estado']==2) echo "selected"; ?>>Inactiva</option>
                                    </select>
                                </td>
                                <td><label for="obligatoria"><span></span><!--Utiliza Secciones:--></label></td>
                                <td>
                                    <!--<input type="checkbox" name="secciones" id="secciones" tabindex="6" title="Secciones" value="1" <?php if($data['secciones']==1) echo "checked"; ?>  />-->
                                </td>
                                    
                            </tr>
                            <?php } ?>
                            <tr>
							<?php $colspan=""; if(!isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]==="MGI") { ?>
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
							<?php } else if(isset($_REQUEST["cat_ins"]) && $_REQUEST["cat_ins"]==="OBS") { ?>
								<td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Periodo:</label></td>
                                <td>
                                    <?php
                                        $query_tipo= "SELECT nombreperiodo, codigoperiodo
                                                      FROM periodo 
													  WHERE fechainicioperiodo!='0000-00-00 00:00:00' 
													  AND fechavencimientoperiodo!='0000-00-00 00:00:00' 
													  order by codigoperiodo DESC";
                                        $reg_tipo = $db->Execute($query_tipo);
                                        echo $reg_tipo->GetMenu2('codigoperiodo',$data['codigoperiodo'],true,false,1,' id="codigoperiodo" tabindex="15"  ');
                                    ?>
                                </td>
								<?php }	else { $colspan="colspan='3'"; }?>
                                <?php if(isset($_REQUEST["cat_ins"]) && $_REQUEST["cat_ins"]!=="OBS" 
                                        && $_REQUEST["cat_ins"]!=="MGI") { ?>
                                    <td></td><td <?php echo $colspan; ?>></td>
                                <?php } else { ?>
                                    <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Modalidad Académica:</label></td>
                                    <td <?php echo $colspan; ?>>
                                        <?php
                                            $query_programa = "SELECT ' ' as nombremodalidadacademica, '0' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                            $reg_programa =$db->Execute($query_programa);
                                            echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                    ?>
                                    </td>
                                <?php } ?>
                    </tr>
                    <?php if(isset($_REQUEST["cat_ins"]) && ($_REQUEST["cat_ins"]==="MGI" || 
                            $_REQUEST["cat_ins"]==="OBS")) { ?>
                    <tr>
                                <td><label for="obligatoria"><span></span>Programa:</label></td>
                                <td>
                                    <div  id="carreraAjax" style="display: none;"> 
                                    
                                    </div>
                                    <?php
                                        echo '<div  id="carreraAjax2" >';
                                        if (!empty($data['codigocarrera'])){
                                            $query_carrera= "SELECT ' ' AS nombrecarrera, '0' AS codigocarrera union SELECT nombrecarrera, codigocarrera FROM carrera ";
                                        $reg_carrera = $db->Execute($query_carrera);
                                        echo $reg_carrera->GetMenu2('codigocarrera',$data['codigocarrera'],false,false,1,' id="codigocarrera" tabindex="15" style="width:250px;" ');
                                        }
                                        echo '</div>';
                                    ?>
                                </td>
                                    
                            </tr>
                     <?php } ?>
                            <!--<tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Tipo:</label></td>
                                <td>
                                    <?php
                                        
                                    ?>
                                </td>
                                <td><label for="obligatoria"><span></span>Programa:</label></td>
                                <td>
                                    <?php
                                        $query_carrera= "SELECT ' ' AS nombrecarrera, ' ' AS codigocarrera union SELECT nombrecarrera, codigocarrera FROM carrera ";
                                        $reg_carrera = $db->Execute($query_carrera);
                                        echo $reg_carrera->GetMenu2('codigocarrera',$data['codigocarrera'],false,false,1,' id="codigocarrera" tabindex="15" style="width:250px;" ');
                                    ?>
                                </td>
                                    
                            </tr>-->
                             <!--<tr>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Periodicidad:</label></td>
                                <td>
                                    <?php
                                        /*$query_tipo= "SELECT ' ' AS periodicidad, ' ' AS idsiq_periodicidad union 
                                                      SELECT periodicidad, idsiq_periodicidad
                                                      FROM siq_periodicidad where codigoestado=100 order by idsiq_periodicidad";
                                        $reg_tipo = $db->Execute($query_tipo);
                                        echo $reg_tipo->GetMenu2('idsiq_periodicidad',$data['idsiq_periodicidad'],false,false,1,' id="idsiq_periodicidad" tabindex="15"  ');*/
                                    ?>
                                </td>
                                <td></td>
                                <td>
                                 
                                </td>
                                    
                            </tr>-->
                            <tr>
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
                            </tr>

                        </tbody>
                    </table>
            </fieldset>
                        </div>
                   <div class="derecha">
                        <button class="submit" type="submit">Siguiente</button>
                        &nbsp;&nbsp;
                        <a href="configuracioninstrumentolistar.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" class="submit" >Regreso al men&uacute;</a>
                    </div><!-- End demo -->
    </div>  
  </form>
<script type="text/javascript">
         if ( $("#verificada").val()==1 ){
                    $("#nombre").attr("disabled",true);
                    $("#mostrar_bienvenida").attr("disabled",true);
                    $("#mostrar_mostrar_despedida").attr("disabled",true);
                   }
              
        
   
     
                $(':submit').click(function(event) {
                   // $.trim(nicEditors.findEditor('titulo').saveContent());
                  //  nicEditors.findEditor('ayuda').saveContent();
                  //  nicEditors.findEditor('descripcion').saveContent();
                    event.preventDefault();
                        //alert($.trim(nicEditors.findEditor('titulo').getContent()));
                        if ( $("#verificada").val()==2 ){
                            document.getElementById("nombre").innerHTML = $.trim(nicEditors.findEditor('nombre').getContent());
                            document.getElementById("mostrar_bienvenida").innerHTML = $.trim(nicEditors.findEditor('mostrar_bienvenida').getContent());
                            document.getElementById("mostrar_despedida").innerHTML = $.trim(nicEditors.findEditor('mostrar_despedida').getContent());
                        }
                        if($("#nombre").val()=='<br>') {
                                alert("El nombre no debe estar vacio");
                                $("#titulo").focus();
                                return false;
                        }else if($("#fecha_inicio").val()==''){
                                alert("La fecha de inicio no debe estar vacio");
                                $("#fecha_inicio").focus();
                            return false;
                        }else if($("#fecha_fin").val()==''){
                                alert("La fecha fin no debe estar vacio");
                                $("#fecha_fin").focus();
                            return false;
                        }else if($("#estado").val()==''){
                                alert("El estado no debe estar vacio");
                                $("#estado").focus();
                            return false;
                        }else if($("#idsiq_discriminacionIndicador").val()==''){
                                alert("El tipo no debe estar vacio");
                                $("#idsiq_discriminacionIndicador").focus();
                            return false;
                        }
                        <?php if(isset($_REQUEST["cat_ins"]) && ($_REQUEST["cat_ins"]==="MGI" || 
                                $_REQUEST["cat_ins"]==="OBS")) { ?>
                            if($("#idsiq_discriminacionIndicador option:selected").val()==3 && $("#codigomodalidadacademica").val()==0){
                                        alert("La modalidad academica no debe estar vacio");
                                        $("#codigomodalidadacademica").focus();
                                        return false;
                            }else if($("#idsiq_discriminacionIndicador option:selected").val()==3 && $("#codigomodalidadacademica").val()!=0 && $("#codigocarrera").val()==''){
                                            alert("El programa no debe estar vacio");
                                            $("#codigocarrera").focus();
                                            return false;
                            }
                          <?php } ?>
                          
                          if($("#idsiq_periodicidad").val()==''){
                                alert("La periodicidad no debe estar vacia");
                                $("#idsiq_periodicidad").focus();
                            return false;
                        }else{
                            //return true;
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
                                var sess=$('input[name=secciones]').is(':checked');
                                 var cat=$("#cat_ins").val();
                               // alert(sess);
                                if (sess==true){
                                 var se=1    
                               }
                               if (se==1){
                                    $(location).attr('href','instrumento_secciones.php?id_instrumento='+data.id+'&secc='+se+'&cat_ins='+cat);
                               }else{
                                   $(location).attr('href','instrumento_secciones.php?id_instrumento='+data.id+'&secc=&cat_ins='+cat);
                               }
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

