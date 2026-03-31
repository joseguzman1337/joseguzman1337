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
   $secc=$_REQUEST['secc'];
   $cat_ins=$_REQUEST['cat_ins'];
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
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $data['idsiq_Ainstrumentoconfiguracion'] ?>">
        <input type="hidden" name="entity" id="entity" value="Ainstrumentoconfiguracion">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="aprobada" id="aprobada" value="1">
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
	                            <?php } if(!isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]!=="EC") { ?>
                                <td><label for="idsiq_Atipopregunta"><span style="color:red; font-size:9px">(*)</span>Modalidad Academica:</label></td>
                                <td>
                                    <?php
                                        $query_programa = "SELECT '' as nombremodalidadacademica, '' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                                </td>
                                 <?php } ?>
                            </tr>
                            <?php if(!isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]!=="EC") { ?>
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
                                /*$sql_preg="SELECT ins.idsiq_Ainstrumentoconfiguracion, ins.idsiq_Apregunta,
                                        ins.idsiq_Aseccion, ins.codigoestado, sec.nombre as secce
                                    FROM  siq_Ainstrumento as ins
                                        inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                                    where ins.codigoestado=100 and sec.codigoestado=100 and ins.idsiq_Aseccion='".$id_secc."' and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' ";
                                //echo $sql_preg;*/
                                $sql_preg="SELECT ins.idsiq_Ainstrumentoconfiguracion, 
                                            ins.idsiq_Apregunta, pr.titulo, pr.obligatoria, pr.RequiereJustificacion, 
                                            pr.idsiq_Atipopregunta, tp.nombre as tipo, ins.idsiq_Aseccion, 
                                            ins.codigoestado, sec.nombre as secce 
                                            FROM siq_Ainstrumento as ins 
                                            inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion) 
                                            inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=ins.idsiq_Apregunta)
                                            inner join siq_Atipopregunta tp on (pr.idsiq_Atipopregunta=tp.idsiq_Atipopregunta)
                                            where ins.codigoestado=100 
                                            and sec.codigoestado=100 
                                            and pr.codigoestado=100 and ins.idsiq_Aseccion='".$id_secc."' and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' 
                                            order by ins.orden";
                               // echo $sql_preg;
                                $data_preg = $db->Execute($sql_preg);
                                /*$j=1;
                                foreach($data_preg as $dt_preg){
                                    $id_preg=$dt_preg['idsiq_Apregunta'];
                                    echo $j.'. ';
                                    $preg=ver_preguntas($id_preg);
                                    echo "<br>";
                                    $j++;
                                }*/
                                $j=1;
                        foreach($data_preg as $dt_preg){//lee las preguntas por seccion
                             $id_preg=$dt_preg['idsiq_Apregunta'];
                             $titulo=$dt_preg['titulo'];
                             $obl=$dt_preg['obligatoria'];
                             $t_preg=$dt_preg['idsiq_Atipopregunta'];
                             if ($j>1) echo "<br>";
                             echo '<input type="hidden" name="preg['.$k.']" id="preg_'.$k.'" value="'.$id_preg.'">';
                             echo '<input type="hidden" name="tpreg['.$k.']" id="tpreg_'.$k.'" value="'.$t_preg.'">';
                             echo '<input type="hidden" name="obl['.$k.']" id="obl_'.$k.'" value="'.$obl.'_'.$k.'">';
                             $class="";
                             $obligatoria = false;
                             if (!empty($obl)){
                                 echo '<b><label style="color:red; font-size:9px;margin-right:3px">(*)</label>'.$j.'.'.$titulo.'</b>';
                                 $class=" class='required' ";
                             }else{
                                 echo '<b>'.$j.'.'.$titulo.'</b>';//pinta el titulo de la pregunta
                             }
                             echo "<br>";
                            echo "<table border='0'>";//crea tabla por pregunta
                                    ///****Busca las respuestas por preguntas**//////
                                   $sql_rep="SELECT pre.idsiq_Apreguntarespuesta, pre.respuesta, pre.valor, pre.texto_inicio, pre.texto_final,
                                                 pre.unica_respuesta, pre.multiple_respuesta, pr.idsiq_Atipopregunta,
                                                 pre.maximo_caracteres, pre.analisis, pre.idsiq_Apregunta
                                              FROM siq_Apreguntarespuesta as pre
                                              inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=pre.idsiq_Apregunta)
                                              where pr.idsiq_Apregunta='".$id_preg."'
                                              and pre.codigoestado=100
                                              and pr.codigoestado=100";
                                      $data_rep = $db->Execute($sql_rep);
                                      /////***Pregunat tipo Likert******///////
                                      if ($t_preg==1){
                                          echo "<tr>";
                                          foreach($data_rep as $dt_rep){
                                              $res=$dt_rep['respuesta'];
                                              echo '<td  valign="top"><center>&nbsp;'.$res.'&nbsp;</center>';
                                          }
                                          echo "</tr>";
                                          echo "<tr>";
                                          $i=0;
                                          foreach($data_rep as $dt_rep){
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; 
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              echo '<td  valign="top"><center><input type="radio" '.$class.' name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }
                                  ///////////cierra pregunta tipo liket****///////
                                   ///////////abre tipo gutman******//////
                                      if ($t_preg==2){
                                          $x=0;
                                          echo "<tr>";
                                          $i=0;
                                          foreach($data_rep as $dt_rep){
                                               $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                               $ti=$dt_rep['texto_inicio']; $tf=$dt_rep['texto_final'];
                                               $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                               if ($x==0) echo '<td  valign="top">'.$ti.'</td>';
                                               echo '<td  valign="top">';
                                               echo '<center><input type="radio" name="valor_'.$id_preg.'" '.$class.'  id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                               $x++; $i++;
                                          }
                                          echo '<td  valign="top">'.$tf.'</td>';
                                          echo "</tr>";
                                      }
                                 ///////////cierra tipo gutman******//////     
                                 /////abre tipo dicotomicas///////
                                      if ($t_preg==3){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              echo '<td  valign="top"><center><input type="radio" '.$class.'  name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              echo '<td  valign="top">&nbsp;'.$res.'&nbsp;';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }
                                 /////cierra tipo dicotomicas///////     
                                  //////////abre tipo opcion de respuesta multiple ////////////
                                      if ($t_preg==4){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                             $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              echo '<td  valign="top"><center><input type="checkbox" '.$class.'  name="valor_'.$id_preg.'['.$i.']" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              echo '<td  valign="top">&nbsp;'.trim($res).'&nbsp;';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }
                                      
                                //////////cierra tipo opcion de respuesta multiple ////////////
                                 
                                 
                                 
                                 //////////abre tipo pregunta abierta////////////
                                      if ($t_preg==5){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                              $mc=$dt_rep['maximo_caracteres']; 
                                              echo '<td><input type="textbox" name="valor_'.$id_preg.'" '.$class.'  id="valor_'.$id_preg.'_'.$i.'" value="" maxlength="'.$mc.'" /></td>';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }
                               //////////cierra tipo de pregunta abierta////////////     
                                /////////abre tipo pregunta opcion multiple////////////
                                      if ($t_preg==6){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                              echo '<td  valign="top"><center><input type="radio" '.$class.'  name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              echo '<td  valign="top">&nbsp;'.trim($res).'&nbsp;';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }
                              /////////cierra tipo pregunta opcion multiple////////////       
                                      
                              
                             /////////abre tipo pregunta analisis//////////        
                                       if ($t_preg==8){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta']; $ana=$dt_rep['analisis'];
                                               if ($i==0){
                                                        echo "<td colspan='2' ".$ana."<br></td></tr><tr>";
                                                    }
                                              echo '<td  valign="top" width="5%"><input type="radio" '.$class.'  name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></td>';
                                              echo '<td  valign="top">&nbsp;'.trim($res).'&nbsp;';
                                              $i++;
                                         }
                                       }
                                      
                              /////////cierra tipo pregunta analisis//////////   
                                      
                                      
                            echo "</table>";    //cierra tabla por pregunta
							
										  if($dt_preg["RequiereJustificacion"]){
											//toca poner el campo de justificación
											echo '<label style="margin:15px 0 5px;clear:both;display:block">Justificación:</label>';
											echo '<textarea name="justificacion_'.$id_preg.'" '.$class.'  id="justificacion_'.$id_preg.'_'.$i.'" maxlength="500" rows="5" style="margin:0px 0 10px;width:90%;"></textarea>';
										  }
                            $j++; $k++;
                        }//cierra las preguntas por seccion
                          echo "</fieldset>";
                          $i++;
                 }
                 
                 echo "<br>";
                 echo $data['mostrar_despedida'];
             ?>
         </fieldset>
        <?php
           // echo '$cat_ins->'.$cat_ins;
         if ($cat_ins=='MGI') { ?>
        <fieldset>
            <legend>Comentarios</legend>
            <table>
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
            </table>
        </fieldset>
        <?php } ?>     
               
                        </div>
                   <div class="derecha">
                       <?php if(!isset($_REQUEST["aprobar"]) || $_REQUEST["aprobar"]==1){ ?>
                        <button class="submit" id="guardar" type="submit">Aprobar</button>
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
     
     <?php
           // echo '$cat_ins->'.$cat_ins;
         if ($cat_ins==='MGI') { ?>
     document.getElementById("imgbox1").style.visibility="hidden";

        function changeVisibility()
        {
        document.getElementById("imgbox1").style.visibility="hidden";
        }
        function resetElement()
        {
        document.getElementById("imgbox1").style.visibility="visible";
        }
        <?php } ?>
          
        function OPen_Preg(id,i,idinstr,idsecc){
            $panel1 = $( "#"+id+'_'+i );
            $.ajax({
                url: "lista_preguntas.php?id_instrumento="+idinstr+"&idsecc="+idsecc,
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
                        title: "Selecciones las Preguntas",
                        buttons: {
                            "Guardar": function() {
                               sendForm_lp()
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
                    //console.log("entre");
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
                        }
                        <?php if(!(isset($_REQUEST["cat_ins"]) || $_REQUEST["cat_ins"]==="MGI")){ ?>
                            if($("#idsiq_discriminacionIndicador").val()==''){
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
                            }
                        <?php } ?>
                            //console.log("enviando form");
                            sendForm();

                });
                
                function sendForm_lp(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test2').serialize(),                
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
                                
								/***********************************/
								/*
								aca se hace json para que inserte en la tabla entradaredirecion inserta e id del instrumento y las fechas de publicacion 
								*/
								
								var id_instrumento	= $('#idsiq_Ainstrumentoconfiguracion').val();
								
								$.ajax({//Ajax
								  type: 'POST',
								  url: 'instrumento_publico_html.php',
								  async: false,
								  dataType: 'json',
								  data:({actionID: 'EntradaRedirecion',id_instrumento:id_instrumento}),
								  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
								  success: function(data){
										if(data.val=='FALSE'){
												alert(data.descrip);
												return false;
											}
									}//data 
							  }); //AJAX
								/***********************************/
								alert(data.message);
								/***********************************/
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

