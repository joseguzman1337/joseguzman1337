<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//error_reporting(E_ALL);
// ini_set("display_errors", 1);
 
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   $id_instrumento=str_replace('row_','',$_REQUEST['id']);
   $secc=$_REQUEST['secc'];
  // echo  $id_instrumento."-><ok";
  // $preg=funciones();
   
   
  if (!empty($id_instrumento)){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $tipo=$data['idsiq_discriminacionIndicador'];
    $tipoProg=$data['codigocarrera'];
    
    $entity1 = new ManagerEntity("Ainstrumento");
    $entity1->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
   // $entity->debug = true;
    $data1 = $entity1->getData();
    $data1 =$data1[0];
   
    /*    $entity2 = new ManagerEntity("Ainstrumentovaloracion");
        $entity2->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
        $entity2->debug = true;
        $data2 = $entity2->getData();
        $data2 =$data2[0];*/
        //var_dump($data2);
   }
 
?>
<script type="text/javascript">
    bkLib.onDomLoaded(function() {
        if ($("#aprobada").val()==2){
          comentario1 = new nicEditor({fullPanel : true}).panelInstance('comentario');
        }
          
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
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Ainstrumentoconfiguracion'] ?>">
        <input type="hidden" name="entity" id="entity" value="Ainstrumentovaloracion">
        <input type="hidden" name="idsiq_Ainstrumentovaloracion" id="idsiq_Ainstrumentovaloracion" value="<?php echo $data2['idsiq_Ainstrumentovaloracion'] ?>">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="aprobada" id="aprobada" value="<?php echo $data['aprobada'] ?>">
        <div id="container">
        <div class="full_width big">Instrumento</div>
        <fieldset>
            <legend>Valoración del Instrumento</legend>
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
                        </tbody>
                    </table>
            </fieldset>
        <br>
         <fieldset>
             <legend>Instrumento</legend>
             <?php
                 echo $data['mostrar_bienvenida'];
                 echo "<br>";
                 $sql_secc="SELECT ins.idsiq_Ainstrumentoconfiguracion, ins.idsiq_Apregunta,
                                ins.idsiq_Aseccion, ins.codigoestado, sec.nombre as secce
                            FROM  siq_Ainstrumento as ins
                                inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                            where ins.codigoestado=100 and sec.codigoestado=100 and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'
                                group by idsiq_Aseccion";
                 //echo $sql_secc;
                 $data_secc = $db->Execute($sql_secc);
                 $i=1;
 
                 foreach($data_secc as $dt_secc){
                          $id_secc=$dt_secc['idsiq_Aseccion'];
                          echo "<fieldset>";
                                echo "<legend>".trim($dt_secc['secce'])."</legend>";
                                $sql_preg="SELECT ins.idsiq_Ainstrumentoconfiguracion, ins.idsiq_Apregunta,
                                        ins.idsiq_Aseccion, ins.codigoestado, sec.nombre as secce
                                    FROM  siq_Ainstrumento as ins
                                        inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                                    where ins.codigoestado=100 and sec.codigoestado=100 and ins.idsiq_Aseccion='".$id_secc."' and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' ";
                                //echo $sql_preg;
                                $data_preg = $db->Execute($sql_preg);
                                $j=1;
                                foreach($data_preg as $dt_preg){
                                    $id_preg=$dt_preg['idsiq_Apregunta'];
                                    echo $j.'. ';
                                    $preg=ver_preguntas($id_preg);
                                    echo "<br>";
                                    $j++;
                                }
                          echo "</fieldset>";
                          $i++;
                 }
                 
                 echo "<br>";
                 echo $data['mostrar_despedida'];
             ?>
         </fieldset>
    
        <fieldset> 
            <legend>Comentarios</legend>
         <table border="0">
                        <tbody>
                            <tr>
                                <td><label for="titulo"><span style="color:red; font-size:9px">(*)</span>Comentario:</label></td>
                                <td colspan="4">
                                    <div id="comentario1">
                                        <textarea style="height: 50px;" cols="90" id="comentario" name="comentario"><?php echo $data2['comentario']; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="titulo">Aprobado:</label></td>
                                <td colspan="4">
                                    <input type="checkbox" name="valoracion" value="1" <?php if($data['valoracion']==1) echo "checked"; ?>>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input class="box"  type="button" onclick="resetElement()" value="Ver todos Comentarios" />
                                </td>
                                <td>
                                    <input class="box"  type="button" onclick="changeVisibility()" value="Ocultar Comentarios" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="imgbox1">
                                        <?php
                                            $sql_preg="SELECT * FROM siq_Ainstrumentovaloracion 
                                                WHERE idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' 
                                                and codigoestado=100 ";
                                        // echo $sql_preg;
                                        $data_preg = $db->Execute($sql_preg);
                                        $j=1;
                                        foreach($data_preg as $dt_preg){
                                            $com=$dt_preg['comentario'];
                                            $val=$dt_preg['valoracion'];
                                            echo $j.'. '.$com;
                                            echo "<br>";
                                            $j++;
                                        }
                                            
                                        ?>
                                    </div>
                                </td>
                            </tr>
                         <tbody>
       </table>
     </fieldset>
            </div>
                    <div class="derecha">
                        <?php if ($data['aprobada']==2){ ?>
                            <button class="submit" id="guardar" type="submit">Guardar</button>
                       <?php } ?>
                        &nbsp;&nbsp;
                        <a href="configuracioninstrumentolistar.php" class="submit" >Regreso al menú</a>
                    </div><!-- End demo -->
  </form>
<script type="text/javascript">
document.getElementById("imgbox1").style.visibility="hidden";

        function changeVisibility()
        {
        document.getElementById("imgbox1").style.visibility="hidden";
        }
        function resetElement()
        {
        document.getElementById("imgbox1").style.visibility="visible";
        }


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
     
    
     
                $(':submit').click(function(event) {
                   // $.trim(nicEditors.findEditor('titulo').saveContent());
                  //  nicEditors.findEditor('ayuda').saveContent();
                  //  nicEditors.findEditor('descripcion').saveContent();
                    event.preventDefault();
                        //alert($.trim(nicEditors.findEditor('titulo').getContent()));
                        if ( $("#aprobada").val()==2 ){
                            document.getElementById("comentario").innerHTML = $.trim(nicEditors.findEditor('comentario').getContent());
                        }
                        if($("#comentario").val()=='<br>') {
                                alert("El Comentario no debe estar vacio");
                                $("#comentario").focus();
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
                              /*  var tipo = jQuery("select[name='idsiq_discriminacionIndicador'] option:selected").index();
                                var tipoProg = jQuery("select[name='codigocarrera'] option:selected").index();
                                var sess=$('input[name=secciones]').is(':checked');
                               // alert(sess);
                                if (sess==true){
                                 var se=1    
                               }*/
                              // $(location).attr('href','instrumento.php?id_instrumento='+data.id+'&tipo='+tipo+'&prog='+tipoProg+'&secc='+se);
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

