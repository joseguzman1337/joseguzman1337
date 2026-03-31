<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//error_reporting(E_ALL);
// ini_set("display_errors", 1);
 
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   $id_instrumento=$_REQUEST['id_instrumento'];
   $cat_ins=$_REQUEST['cat_ins'];
   
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
        var fastLiveFilterNumDisplayed = $('#fastLiveFilter .connectedSortable');
			$("#fastLiveFilter .filter_input").fastLiveFilter("#fastLiveFilter .connectedSortable");
    });
    
    
      $(function() {
        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable"
        })
        
    });
    
 </script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Ainstrumentoconfiguracion'] ?>">
        <input type="hidden" name="entity" id="entity" value="Ainstrumentoseccion">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="cat_ins" id="cat_ins" value="<?php echo $cat_ins ?>" />
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
                             <?php if(isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]==="EGRESADOS") { ?>
                            
                            <?php } else { ?>
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
                            <?php } ?>
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
                               <!-- <fieldset slyle="width: 50px;">-->
                                    <legend>Secciones</legend>
                                    <div id="fastLiveFilter" style="width:473px; height:515px; overflow: scroll;" >
                                      <input class="filter_input" placeholder="Buscar..">
                                      <br><br>
                                      <ul id="sortable1" class="connectedSortable">
                                            <?php
                                               $wh="";
                                               if (empty($secc)){
                                                   $wh=" and sin_seccion=1 ";
                                               }
                                               
                                                $query_indicador= "SELECT
                                                                    i.idsiq_Aseccion,
                                                                    i.nombre
                                                                   FROM 
                                                                    siq_Aseccion as i
                                                                   WHERE i.codigoestado=100 
                                                                   and cat_ins='".$cat_ins."' ";
                                               // echo $query_indicador;
                                                $data_in= $db->Execute($query_indicador);
                                            // print_r($data_in);
                                                $i=0;
                                                foreach($data_in as $dt){
                                                // print_r($dt);
                                                    $nombre=$dt['nombre'];
                                                    $id=$dt['idsiq_Aseccion'];
                                                    echo '<li class="ui-state-default" style="width:400px;" id="'.$id.' " >'.$nombre;
                                                  //  echo '<input type="text" name="idsiq_Apreguntaindicador1['.$i.']" id="idsiq_Apreguntaindicador1_'.$i.'" style="width: 50px" value="" >';
                                                    echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$id.'" />';
                                                    echo'</li>';
                                                    $i++;
                                                }
                                            ?>
                                    </ul>
                                   </div>
                              <!-- </fieldset>-->
                        </td>
                        <td  valign="top">
                                <!-- <fieldset>-->
                                     <legend>Secciones Asignados</legend>
                                     <div id="22" style="width:473px; height:500px; overflow: scroll;">
                                         
                                        <ul id="sortable2" class="connectedSortable">
                                            <li class="ui-state-highlight" style="width:400px;" id="0">Arrastrar Aqui
                                            </li>
                                            <?php
                                            if (!empty($id_instrumento)){
                                                    $query_indicador_sec= "SELECT
                                                                     i.idsiq_Aseccion,
                                                                     i.nombre,
                                                                     ig.idsiq_Ainstrumentoseccion
                                                                    FROM 
                                                                    siq_Aseccion as i
                                                                    inner join siq_Ainstrumentoseccion as ig on (ig.idsiq_Aseccion=i.idsiq_Aseccion)
								    WHERE ig.codigoestado=100 and i.codigoestado=100 and cat_ins='".$cat_ins."'
                                                                    and ig.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' ";
                                                   // echo $query_indicador_sec;
                                                    $data_in_sec= $db->Execute($query_indicador_sec);
                                                // print_r($data_in);
                                                    $i=0;
                                                    foreach($data_in_sec as $dt_sec){
                                                    // print_r($dt);
                                                           $nombre=$dt_sec['nombre'];
                                                           $idins=$dt_sec['idsiq_Ainstrumentoseccion'];
                                                           $id=$dt_sec['idsiq_Aseccion'];
                                                        echo '<li class="ui-state-default" style="width:400px;" id="'.$id.' ">'.$nombre;
                                                        echo '<input type="hidden" name="idsiq_Ainstrumentoseccion1['.$i.']" id="idsiq_Ainstrumentoseccion1_'.$i.'" style="width: 50px" value="'.$idins.'" >';
                                                        echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$id.'" />';
                                                        echo'</li>';
                                                        $i++;
                                                    }
                                            }
                                            ?>
                                        </ul>
                                     </div>
                                    <br>
                                    <input type="hidden" name="totalsecciones" id="totalsecciones" value="" />
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
                <a href="configuracion.php?id=<?php echo $id_instrumento ?>&cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" class="submit" >Atras</a>
                &nbsp;&nbsp; 
                <a href="configuracioninstrumentolistar.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>" class="submit" >Regreso al men&uacute;</a>
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
     $("#codigoperiodo").attr("disabled",true)         

       
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
                          sendForm();
                           //var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
                           //$(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1');
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
                                if (cat=='MGI'){
                                    $(location).attr('href','instrumento_usuarios.php?id_instrumento='+id_instrumento+'&secc=1'+'&cat_ins='+cat);
                                }else{
                                     $(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1'+'&cat_ins='+cat);
                                }
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

