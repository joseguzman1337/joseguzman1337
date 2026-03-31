<?php
//error_reporting(E_ALL);
// ini_set("display_errors", 1);

   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   $id_instrumento=$_REQUEST['id_instrumento'];
   $secc=$_REQUEST['secc'];
   $cat_ins=$_REQUEST['cat_ins'];
   
  if (!empty($id_instrumento)){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
   // $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $tipo=$data['idsiq_discriminacionIndicador'];
   $tipoProg=$data['codigocarrera'];
    //print_r($data);
  }
?>
<script type="text/javascript">
    bkLib.onDomLoaded(function() {
          jQuery('.nicEdit-main').attr('contenteditable','false');
          jQuery('.nicEdit-panel').hide();
       
    });

    $(function() {
        var fastLiveFilterNumDisplayed = $('#fastLiveFilter1 .connectedSortable');
			$("#fastLiveFilter1 .filter_input").fastLiveFilter("#fastLiveFilter1 .connectedSortable");
    });
    
  $(function() {
        $( "#sortable1" ).sortable({
            connectWith: ".connectedSortable"
        })
        
    });

</script>

    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Aconfiguracioninstrumento'] ?>">
        <input type="hidden" name="entity" id="entity" value="Ainstrumentoconfiguracion">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="cat_ins" id="cat_ins" value="<?php echo $cat_ins ?>" />
        <input type="hidden" name="aprobada" id="aprobada" value="<?php  if (empty($data['aprobada'])){ echo "2"; }else{ echo $data['aprobada']; } ?>">
        <div id="container">
        <div class="full_width big">Instrumento</div>
        <fieldset>
            <legend>Creacion del Instrumento</legend>
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
	                            <?php } ?>
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
                                <td></td>
                                <td>
                                 
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
                <table>
                    <tr>
                        <td valign="top">
                            <legend>Secciones</legend>
                            <div id="fastLiveFilter1" >
                             <input class="filter_input" placeholder="Buscar..">
                            <br><br>
                            <ul id="sortable2" class="connectedSortable">
                                <?php
                                    $query_secc= "SELECT
                                                                     i.idsiq_Aseccion,
                                                                     i.nombre,
                                                                     ig.idsiq_Ainstrumentoseccion
                                                                    FROM 
                                                                    siq_Aseccion as i
                                                                    inner join siq_Ainstrumentoseccion as ig on (ig.idsiq_Aseccion=i.idsiq_Aseccion)
								    WHERE ig.codigoestado=100 and i.codigoestado=100 
                                                                    and ig.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'  ";
                                     $data_sec = $db->Execute($query_secc);
                                    $i=0;
                                    foreach($data_sec as $ds){
                                        $nom=trim($ds['nombre']);
                                        $id_secc=trim($ds['idsiq_Aseccion']);
                                        echo '<li class="ui-state-highlight" style="width:800px;">'.$nom.'<a href="javascript:void(0)" onClick=\'OPen_Preg("selec_pregun","'.$i.'","'.$id_instrumento.'","'.$id_secc.'" )\'>Preguntas<img src="../../images/eye.png" width="30px" height="30px" /></a>';
                                        echo '&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onClick=\'OPen_PregAsociacion("asociar_pregun","'.$i.'","'.$id_instrumento.'","'.$id_secc.'" )\'>Asociar Preguntas y/o secciones</a></li>';
                                        echo '<div id="selec_pregun_'.$i.'" style="display:none">';
					echo '</div>';
                                        echo '<div id="asociar_pregun_'.$i.'" style="display:none">';
					echo '</div>';
                                        $i++;
                                    }
                                ?>
                                </ul>
                            </div>
                            </div>
                        </td>
                     </tr>   
                </table>
             </fieldset>
                        </div>
                   <div class="derecha">
                       <a href="instrumento_orden.php?aprobar=0&id_instrumento=<?php echo $id_instrumento ?>&cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" class="submit" >Ordenar Preguntas</a>
                        &nbsp;&nbsp;
                       
                       <?php if(isset($_REQUEST["aprobar"])) { ?>
                       <a href="instrumento_visualizar.php?aprobar=<?php echo$_REQUEST["aprobar"]; ?>&id_instrumento=<?php echo $id_instrumento ?>&cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" class="submit" >Visualizar Instrumento</a>
                       <?php } else { ?>
                        <a href="instrumento_visualizar.php?aprobar=0&id_instrumento=<?php echo $id_instrumento ?>&cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" class="submit" >Visualizar Instrumento</a>
                        &nbsp;&nbsp;
                        <?php } ?>
                        <a href="configuracioninstrumentolistar.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" class="submit" >Regreso al men&uacute;</a>
                    </div><!-- End demo -->
    </div>  
  </form>
<script type="text/javascript">
    
     $("#nombre").attr("disabled",true);
     $("#mostrar_bienvenida").attr("disabled",true);
     $("#mostrar_despedida").attr("disabled",true);
     $("#fecha_inicio").attr("disabled",true);
     $("#fecha_fin").attr("disabled",true);
     $("#estado").attr("disabled",true);
     $("#secciones").attr("disabled",true);
     $("#idsiq_discriminacionIndicador").attr("disabled",true);
     $("#idsiq_periodicidad").attr("disabled",true);
     $("#codigocarrera").attr("disabled",true);
      $("#codigomodalidadacademica").attr("disabled",true);
      $("#codigoperiodo").attr("disabled",true) 
       
       function OPen_PregAsociacion(id,i,idinstr,idsecc){
           $panelAsoc = $( "#"+id+'_'+i );
            var cat=$("#cat_ins").val();
            $.ajax({
                url: "lista_preguntas_asociar.php?id_instrumento="+idinstr+"&idsecc="+idsecc+'&cat_ins='+cat,
                type: "GET",
                dataType: "html",
                async: false,
                data: { "id": id},
                success: function (obj) {
                    $panelAsoc.html(obj);
                    $.fx.speeds._default = 1000;
                    $panelAsoc.dialog({
                        height: 700,
			width: 500,
			modal: true,
                        title: "Asociar preguntas y/o secciones",
                        buttons: {
                            Finalizar: function() {
                                $panelAsoc.dialog('close');
                            }
                        }
                    }                    
                );
                }
            });
       }
       
        function OPen_Preg(id,i,idinstr,idsecc){
            $panel1 = $( "#"+id+'_'+i );
            var cat=$("#cat_ins").val();
            $.ajax({
                url: "lista_preguntas.php?id_instrumento="+idinstr+"&idsecc="+idsecc+'&cat_ins='+cat,
                type: "GET",
                dataType: "html",
                async: false,
                data: { "id": id},
                success: function (obj) {
                    $panel1.html(obj);
                    $.fx.speeds._default = 1000;
                    $panel1.dialog({
                        height: 700,
			width: 500,
			modal: true,
                        title: "Seleccione las Preguntas",
                        buttons: {
                            "Guardar": function() {
                                j=0;
                                 var check = $("input[type='checkbox']:checked").length;
                                 //alert (check)
                                  if (check >1) 
                                    { 
                                        sendForm_lp(idsecc)
                                    } 
                                    else 
                                    { 
                                       alert('No ha seleccionado ninguna pregunta')
                                    } 
                            },
                            Cancelar: function() {
                            $panel1.dialog('close');
                            }
                        }
                    }                    
                );
                }
            });
        }
   
     
                $(':submit').click(function(event) {
                   // $.trim(nicEditors.findEditor('titulo').saveContent());
                  //  nicEditors.findEditor('ayuda').saveContent();
                  //  nicEditors.findEditor('descripcion').saveContent();
                    event.preventDefault();
                        //alert($.trim(nicEditors.findEditor('titulo').getContent()));
                        if ( $("#aprobada").val()==2 ){
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
                        }else if($("#idsiq_discriminacionIndicador option:selected").val()=='3' && $("#codigocarrera").val()==''){
                                alert("El programa no debe estar vacio");
                                $("#codigocarrera").focus();
                            return false;
                        }else if($("#idsiq_periodicidad").val()==''){
                                alert("La periodicidad no debe estar vacia");
                                $("#idsiq_periodicidad").focus();
                            return false;
                        }else{
                            sendForm()
                        } 

                });
                
                function sendForm_lp(idsecc){
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
                
                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                var tipo = jQuery("select[name='idsiq_discriminacionIndicador'] option:selected").index();
                                var tipoProg = jQuery("select[name='codigocarrera'] option:selected").index();
                                var sess=$('input[name=secciones]').is(':checked');
                               // alert(sess);
                                if (sess==true){
                                 var se=1    
                               }
                               $(location).attr('href','instrumento.php?id_instrumento='+data.id+'&tipo='+tipo+'&prog='+tipoProg+'&secc='+se);
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

