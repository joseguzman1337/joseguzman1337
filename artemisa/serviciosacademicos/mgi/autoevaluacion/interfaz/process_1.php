<?php
//error_reporting(E_ALL);
// ini_set("display_errors", 1);

   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   $id_instrumento=$_REQUEST['id_instrumento'];
   $secc=$_REQUEST['secc'];
   
  if (!empty($id_instrumento)){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
    $entity->debug = true;
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
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Aconfiguracioninstrumento'] ?>">
        <input type="hidden" name="entity" id="entity" value="Ainstrumentoconfiguracion">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="verificada" id="verificada" value="<?php  if (empty($data['verificada'])){ echo "2"; }else{ echo $data['verificada']; } ?>">
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
                            <legend>Preguntas</legend>
                            <div id="fastLiveFilter" style="width:473px; height:515px; overflow: scroll;" >
                            <input class="filter_input" placeholder="Buscar..">
                            <br><br>
                            <ul id="sortable1" class="connectedSortable">
                                <?php
                                     $wh="";
                                    if ($tipo==3){
                                        $wh=" and discriminacion=3 and iq.idCarrera='".$tipoProg."' ";
                                    }else{
                                        $wh=" and discriminacion=1 ";
                                    }
                                    $query_tipo= "SELECT p.titulo, p.idsiq_Apregunta, i.idsiq_Apreguntaindicador, i.disiq_indicador,
                                                iq.discriminacion, iq.idCarrera, c.nombrecarrera
                                                FROM sala.siq_Apregunta as p
                                                inner join siq_Apreguntaindicador as i on (p.idsiq_Apregunta=i.idsiq_Apregunta)
                                                inner join siq_indicador as iq on (i.disiq_indicador=iq.idsiq_indicador)
                                                left  join carrera as c on (iq.idCarrera=c.codigocarrera)
                                                where p.codigoestado=100 and i.codigoestado=100 ".$wh." ";
                                    // echo $query_tipo;
                                    $data_in = $db->Execute($query_tipo);
                                    $i=0;
                                    foreach($data_in as $dt){
                                    // print_r($dt);
                                        $nombre=$dt['titulo'];
                                        $idsiq_Apregunta=$dt['idsiq_Apregunta'];
                                        $dis=$dt['discriminacion'];
                                        $carrera=$dt['nombrecarrera'];
                                        if ($dis==3){
                                            $nombre=$nombre.'('.$carrera.')';
                                        }else{
                                            $nombre=$nombre.'(Institucional)';
                                        }

                                        $id=$dt['disiq_indicador'];
                                        echo '<li class="ui-state-default" style="width:400px;" idsiq_Apregunta="'.$idsiq_Apregunta.' " >'.$nombre;
                                        echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$id.'" />';
                                        echo '&nbsp;';
                                        echo '<img src="../../images/eye.png" width="30px" height="30px" onClick=\'OPen("dialog_Document","'.$i.'","'.$idsiq_Apregunta.'")\'  />';
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
                                        echo "<select id='idsiq_Aseccion' name='idsiq_Aseccion'> ";
                                        echo "<option value=''>-Seleccione-</option>";
                                        foreach($data_sec as $ds){
                                                echo "<option value='".$ds['idsiq_Aseccion']."'>".$ds['nombre']."</option>";
                                        }
                                        echo "</select>";
                                        echo'</li>';
                                        echo '<div id="dialog_Document_'.$i.'" style="display:none">';
					echo '</div>';
                                        $i++;
                                    }
                               ?>
                            </ul>
                            </div>
                        </td>
                        <td valign="top">
                            <legend>Secciones</legend>
                            
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
                                        echo '<div id="fast'.$i.'" class="ul-state-sess">'.$ds['nombre'].'';
                                        echo '<ul id="sortable2" class="connectedSortable"> ';
                                        echo '<li class="ui-state-highlight" style="width:400px;">Aqui</li>';
                                        
                                        echo '</ul>';
                                        echo '</div>';
                                            
                                        $i++;
                                    }
                                ?>
                                
                            </div>
                        </td>
                     </tr>   
                </table>
             </fieldset>
                        </div>
                   <div class="derecha">
                        <button class="submit" type="submit">Siguiente</button>
                        &nbsp;&nbsp;
                        <a href="configuracioninstrumentolistar.php" class="submit" >Regreso al menú</a>
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
     
             
        function OPen(id,i,idpregunta){
            $panel = $( "#"+id+'_'+i );
            $.ajax({
                url: "preguntaver.php?id_pregunta="+idpregunta,
                type: "GET",
                dataType: "html",
                async: false,
                data: { "id": id},
                success: function (obj) {
                    $panel.html(obj);
                    $.fx.speeds._default = 1000;
                    $panel.dialog({
                        height: 300,
			width: 400,
			modal: true,
                        title: "Pregunta",
                        buttons: {
                            Cancelar: function() {
                            $panel.dialog('close');
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

