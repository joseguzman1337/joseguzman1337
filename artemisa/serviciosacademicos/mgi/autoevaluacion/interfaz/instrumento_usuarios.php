<?php
//error_reporting(E_ALL);
// ini_set("display_errors", 1);
 
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
  $id_instrumento=$_REQUEST['id_instrumento'];
  $secc=$_REQUEST['secc'];
   if (!empty($id_instrumento)){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion =".$id_instrumento." ";
   //  $entity->debug = true;
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
    
 $(function() {
        $( "#sortable2,#sortable1" ).sortable({
            connectWith: ".connectedSortable"
        })
 });
    
 
  
  
     function displayUsuarios(){
       // alert('hola');
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='idrol']").val();
        jQuery("#fastLiveFilter")
            .html(ajaxLoader)
            .load('generarusuarios.php', {id: optionValue,status: 1}, function(response){					
            if(response) {
                jQuery("#fastLiveFilter").css('display', '');                    
            } else {                    
                jQuery("#fastLiveFilter").css('display', 'none');               
            }
        });   
    }
    
    
    
 </script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Ainstrumentoconfiguracion'] ?>">
	<input type="hidden" name="cat_ins" id="cat_ins" value="<?php echo $cat_ins ?>" />
        <input type="hidden" name="entity" id="entity" value="Ainstrumentousuario">
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
                        <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Tipo Usuario:</label></td>
                                <td>
                                    <?php
                                        $query_tipo= "SELECT ' ' AS nombretipousuario, ' ' AS codigotipousuario union 
                                                      SELECT nombretipousuario, codigotipousuario
                                                      FROM tipousuario
                                                      WHERE codigotipousuario in (400,500,600)
                                                      order by nombretipousuario";
                                        //echo $query_tipo;
                                        $reg_tipo = $db->Execute($query_tipo);
                                        echo $reg_tipo->GetMenu2('codigotipousuario',$data['codigotipousuario'],false,false,1,' id="codigotipousuario" tabindex="15"  ');
                                    ?>
                                </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="divrespo">
                            <label for="usuarioResponsable" class="grid-2-12">Responsable: <span class="mandatory">(*)</span></label>
                            <input type="text"  class="grid-5-12 required" minlength="2" name="usuarioResponsable" id="usuarioResponsable" title="Nombre del Responsable" maxlength="200" tabindex="1" autocomplete="off" value=""  />
                            <input type="hidden" name="idUsuarioResponsable" id="idUsuarioResponsable" value="" />  
                            <input type="hidden" name="ndocumentoResponsable" id="ndocumentoResponsable" value="" />  
                            <input type="button" id="agregar" value="Agregar" class="button medium clsAgregarFilaL">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td  valign="top">
                                <!-- <fieldset>-->
                                     <legend>Usuarios Responsables</legend>
                                     <div id="22" >
                                         
                                        <ul id="sortable2" class="connectedSortable">
                                            <li class="ui-state-highlight" style="width:400px;" id="0">Asignar Aqui
                                            </li>
                                            <?php
                                            if (!empty($id_instrumento)){
                                                    $query_indicador_sec= "SELECT *
                                                                     FROM siq_Ainstrumentousuario iu
                                                                     inner join usuario as u on (u.idusuario=iu.idusuario)
                                                                     WHERE iu.codigoestado=100 
                                                                     and iu.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' ";
                                                   //echo $query_indicador_sec;
                                                    $data_in_sec= $db->Execute($query_indicador_sec);
                                                // print_r($data_in);
                                                    $i=1;
                                                    foreach($data_in_sec as $dt_sec){
                                                    // print_r($dt);
                                                        $ndoc=$dt_sec['numerodocumento'];
                                                        $app=$dt_sec['apellidos'];
                                                        $nom=$dt_sec['nombres'];
                                                        $id=$dt_sec['idusuario'];
                                                        $idins=$dt_sec['idsiq_Ainstrumentousuario'];
                                                        echo '<li class="ui-state-default" style="width:400px;" id="'.$id.' ">'.$ndoc.'-'.$nom.' '.$app;
                                                        echo '<input type="hidden" name="idsiq_Ainstrumentousuario1['.$i.']" id="idsiq_Ainstrumentousuario1_'.$i.'" style="width: 50px" value="'.$idins.'" >';
                                                        echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$id.'" />';
                                                        echo'</li>';
                                                        $i++;
                                                    }
                                            }
                                            ?>
                                        </ul>
                                     </div>
                                    <br>
                                    <?php
                                        $val='';
                                       // if ($i>0) $val='0,';
                                    ?>
                                    <input type="hidden" name="totalusuarios" id="totalusuarios" value="" />
                                    <input type="hidden" name="totalusu" id="totalusu" value="<?php echo $i ?>" />
                               <!-- </fieldset>-->
                        </td>
                        <td  valign="top">
                                <!-- <fieldset>-->
                                     <legend>Borrar Usuarios</legend>
                                     <div id="22" >
                                         
                                        <ul id="sortable1" class="connectedSortable">
                                            <li class="ui-state-highlight" style="width:400px;" id="0">Arrastrar Aqui
                                            </li>
                                        </ul>
                                     </div>
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
                <a href="configuracion.php?id=<?php echo $id_instrumento ?>" class="submit" >Atras</a>
                &nbsp;&nbsp; 
                <a href="configuracioninstrumentolistar.php" class="submit" >Regreso al menú</a>
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
     $("#agregar").attr("disabled",true);
     
     
        
         $(document).ready(function() {
             
             jQuery("select[name='codigotipousuario']").change(function(){
                 //alert('hola')
                 var optionValue = jQuery("select[name='codigotipousuario']").val();
                    if (optionValue==''){
                        jQuery("#divrespo").css('display', 'none');
                    }else{
                        jQuery("#divrespo").css('display', '');
                        $('#usuarioResponsable').autocomplete({
                        source: "generarusuarios2.php?tipousuario="+optionValue,
                        minLength: 2,
                        selectFirst: false,
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            $('#idUsuarioResponsable').val(ui.item.id);
                            $('#ndocumentoResponsable').val(ui.item.ndoc);
                            $("#agregar").attr("disabled",false);
                        }                
                        });
                    }
                });    
                    
                    
                  //alert($("#total").val());
                    $(document).on('click','.clsAgregarFilaL',function(){
                       // var i=parseInt($("#totalusu").val());
                       var i=$("#sortable2 li").size();
                       var val=$.trim($("#usuarioResponsable").val())
                        if (val==''){
                          alert('Debe Agresar un usuario responsable')   
                        }else{
                         $("#sortable2").append("<li class='ui-state-default' style='width:400px;' id='"+$('#idUsuarioResponsable').val()+"' >"+
                                                "<input type='hidden' name='ids["+i+"]' id='ids_"+i+"' value='"+$('#idUsuarioResponsable').val()+"' />"+$('#ndocumentoResponsable').val()+"-"+$('#usuarioResponsable').val()+""+
                                                "</li>")
                        }
                    });
                
                 
             });
             
             
                   
  
       
                $(':submit').click(function(event) {
                    nicEditors.findEditor('nombre').saveContent();
                     var id=$("#id_id").val();
                     var order = $("#sortable2").sortable('toArray');
                     //alert(order);
                     $("#totalusuarios").val(order);
                     var veri=$("#aprobada").val();
                    event.preventDefault();
                    if (!$.trim($("#totalusuarios").val())){
                       alert("Debe haber un responsable");
                       $("#codigotipousuario").focus();
                       return false;
                   }else{
                       //alert(veri)
                       if (veri==2){
                         sendForm();
                      } else{
                           var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
                           var cat=$("#cat_ins").val();
                           $(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1&cat_ins='+cat);
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
                                var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
                                var cat=$("#cat_ins").val();
	                        $(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1&cat_ins='+cat);

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

