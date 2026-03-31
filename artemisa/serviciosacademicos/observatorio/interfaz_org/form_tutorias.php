<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Tutor&iacute;as",true,"PAE",1);
   $fun = new Observatorio();
   
    if (!empty($_REQUEST['id_res'])){
     $entity = new ManagerEntity("registro_riesgo");
    $entity->sql_where = "idobs_registro_riesgo = ".$_REQUEST['id_res']."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $id_doc=$data['usuariocreacion'];
    $id_estu=$data['codigoestudiante'];

    $idobs_herramientas_deteccion=$data['idobs_herramientas_deteccion'];
    $_REQUEST['Th']=$idobs_herramientas_deteccion;
    if($idobs_herramientas_deteccion==2) $tipo='PAE';
    if($idobs_herramientas_deteccion==3) $tipo='Notas';
    if($idobs_herramientas_deteccion==2) $tipo='Pruebas';
    
    $entity1 = new ManagerEntity("usuario");
    $entity1->prefix = "";
    $entity1->sql_where = "idusuario = '".$id_doc."'";
    //$entity1->debug = true;
    $dataD = $entity1->getData();
    $idrol=$dataD[0]['codigorol'];
    
    $entity3 = new ManagerEntity("causas");
    $entity3->sql_where = "codigoestado=100 ";
    $data3 = $entity3->getData();
    $ca=count($data3);
    
    $entity2 = new ManagerEntity("registro_riesgo_causas");
    $entity2->sql_where = "idobs_registro_riesgo = ".$_REQUEST['id_res']." order by idobs_registro_riesgo_causas asc ";
    //$entity2->debug = true;
    $data2 = $entity2->getData();
    $riesgo='';
    foreach($data2 as $dt){
        $riesgo.=$dt['idobs_causas'].',';
    }
    $riesgo = substr($riesgo, 0, -1);
    
    $entity4 = new ManagerEntity("primera_instancia");
    $entity4->sql_where = "idobs_registro_riesgo = ".$_REQUEST['id_res']." ";
   // $entity3->debug = true;
    $data4 = $entity4->getData();
    $data4 =$data4[0];
  }
  

    $entity5 = new ManagerEntity("tutorias");
    $entity5->sql_where = "codigoestudiante = ".$id_estu."";
   // $entity5->debug = true;
    $data5 = $entity5->getData();
    $tTol=count($data5)-1;
   // echo $tTol.'-->'.$data5[$tTol]['n_tutoria'].'-->';
    $tTuro=$data5[$tTol]['n_tutoria']+1;
    

  
  if (!empty($_REQUEST['id'])){
    $entity5 = new ManagerEntity("tutorias");
    $entity5->sql_where = "idobs_tutorias = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity5->debug = true;
    $data5 = $entity5->getData();
    $data5 =$data5[0];
    
   
  }
  
   if(empty($data5['idobs_tipotutoria'])){
        $tipotuto=$_REQUEST['tipotutoria'];
    }else{
        $tipotuto=$data5['idobs_tipotutoria'];
    }
    echo $tipotuto.'-->>aca';
  
  //print_r($_SESSION);
  
?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#buttons').akordeon();
        });
        
    
	$(document).ready(function(){
 		$('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'vSlide'});
                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var entity=$("#entity").val();
                jQuery("#historial")
                    .html(ajaxLoader)
                    .load('generahistorial.php', {codigoestudiante: estudiante, entity:entity, direc:"form_tutorias.php" }, function(response){					
                    if(response) {
                        jQuery("#historial").css('display', '');                        
                    } else {                    
                        jQuery("#historial").css('display', 'none');                    
                    }
                });     
                
        });  
        
        function ver(tabla,direc) {
               var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var entity=$("#entity").val();
                jQuery("#historial")
                    .html(ajaxLoader)
                    .load('generahistorial.php', {codigoestudiante: estudiante, entity:tabla, direc:direc }, function(response){					
                    if(response) {
                        jQuery("#historial").css('display', '');                        
                    } else {                    
                        jQuery("#historial").css('display', 'none');                    
                    }
                });
    }
    
    </script>
    <style>
        
.roundedOne {
	width: 28px;
	height: 28px;
	background: #fcfff4;

	background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
	margin: 20px auto;

	-webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	border-radius: 50px;

	-webkit-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	-moz-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	position: relative;
}

.roundedOne label {
	cursor: pointer;
	position: absolute;
	width: 20px;
	height: 20px;

	-webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	border-radius: 50px;
	left: 4px;
	top: 4px;

	-webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
	-moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
	box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);

	background: -webkit-linear-gradient(top, #222 0%, #45484d 100%);
	background: -moz-linear-gradient(top, #222 0%, #45484d 100%);
	background: -o-linear-gradient(top, #222 0%, #45484d 100%);
	background: -ms-linear-gradient(top, #222 0%, #45484d 100%);
	background: linear-gradient(top, #222 0%, #45484d 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#222', endColorstr='#45484d',GradientType=0 );
}

.roundedOne label:after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
	filter: alpha(opacity=0);
	opacity: 0;
	content: '';
	position: absolute;
	width: 16px;
	height: 16px;
	background: #00bf00;

	background: -webkit-linear-gradient(top, #00bf00 0%, #009400 100%);
	background: -moz-linear-gradient(top, #00bf00 0%, #009400 100%);
	background: -o-linear-gradient(top, #00bf00 0%, #009400 100%);
	background: -ms-linear-gradient(top, #00bf00 0%, #009400 100%);
	background: linear-gradient(top, #00bf00 0%, #009400 100%);

	-webkit-border-radius: 50px;
	-moz-border-radius: 50px;
	border-radius: 50px;
	top: 2px;
	left: 2px;

	-webkit-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	-moz-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
	box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
}

.roundedOne label:hover::after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
	filter: alpha(opacity=30);
	opacity: 0.3;
}

.roundedOne input[type=checkbox]:checked + label:after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=100);
	opacity: 1;
}

input[type=checkbox] {
	visibility: hidden;
}

    </style>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_tutorias" id="idobs_tutorias" value="<?php echo $data5['idobs_tutorias'] ?>">
        <input type="hidden" name="idobs_registro_riesgo" id="idobs_registro_riesgo" value="<?php echo $_REQUEST['id_res'] ?>">
         <input type="hidden" name="entity" id="entity" value="tutorias">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" />
        <input type="hidden" name="idroltutoria" id="idroltutoria" value="<?php echo $_SESSION['rol'] ?>" />
        <input type="hidden" name="idobs_tipotutoria" id="idobs_tipotutoria" value="<?php echo $tipotuto ?>" />
        
        <div id="container" style="margin-left: 70px;">
            <div class="titulo">Registro de Tutorias</div>
        <br>
        <div id="tabs">
                <ul>
                <li style="width: 165px"><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Datos del<br />Remitente</span></a></li>
                <li style="width: 165px"><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Datos<br />del Remitido</span></a></li>
                <li style="width: 165px"><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Causas de<br />Ingreso al PAE</span></a></li>
                <li style="width: 164px"><div class="stepNumber">4</div><a href="#tabs-4"><span class="stepDesc">Registro<br />Identificaci&oacute;n </span></a></li>
                <li style="width: 164px"><div class="stepNumber">5</div><a href="#tabs-5"><span class="stepDesc">Registro <br />Tutoria</span></a></li>
                <li style="width: 164px"><div class="stepNumber">6</div><a href="#tabs-6"><span class="stepDesc">Remisi&oacute;n</span></a></li>
                </ul>
                <div id="tabs-1">
                 <?php 
                       $fun->docente($db, $id_doc,$idrol); 
                  ?>
          </div>
            <div id="tabs-2">
                <?php  $fun->estudiante($db, $id_estu); ?>
            </div>
            <div id="tabs-3">
                    <?php 
                       $fun->registro_riesgo($db, $_REQUEST['id_res']); 
                            echo "<br><br>";
                      // echo $idobs_herramientas_deteccion.'-->'; 
                       if($idobs_herramientas_deteccion==4){
                           $matriz_completa=$data['matriz'];
                           $fun->registro_academico($db, $matriz_completa);
                       }else if($idobs_herramientas_deteccion==3){
                            $fun->registro_prueba($db, $id_estu);
                            
                        }
                       
                    ?>
             </div>
               <div id="tabs-4">
                      <?php
                         $fun->primera_ins($db, $data4['idobs_primera_instancia'] ,$riesgo);
                      ?>
           </div>
            <div id="tabs-5">
                <!--<legend class="titulo">Registro Psicologico</legend>-->
                   <table class="CSSTableGenerator">
                       <!--<tr>
                            <td><label class="titulo_label">Sala de Apredizaje:</td>
                            <td><?php 
                                   $query_dec = "SELECT nombregrupos, idobs_grupos FROM obs_grupos  where codigoestado='100' ";
                                   $reg_dec =$db->Execute($query_dec);
                                   echo $reg_dec->GetMenu2('idobs_grupos', $data['idobs_grupos'], true,false,1,' id="idobs_grupos"  style="width:150px;"');
                            ?></td>
                        </tr>-->
                        <tr>
                            <td><label class="titulo_label"><b>Tutoria No</b></label></td>
                            <td><input type='text' id='n_tutoria' name='n_tutoria' value="<?php echo $tTuro; ?>" readonly ></td>
                        </tr>
                        <tr>
                            <td><label class="titulo_label"><b>Objetivos de la Tutoria</b></label></td>
                            <td><textarea style="height: 50px;" cols="73" id="objetivotutoria" name="objetivotutoria"><?php echo $data5['objetivotutoria']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label class="titulo_label"><b>Estrategia de Acompa&ntilde;amiento</b></label></td>
                            <td><textarea style="height: 50px;" cols="73" id="estrategiatutoria" name="estrategiatutoria"><?php echo $data5['estrategiatutoria']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label class="titulo_label"><b>Compromiso del Estudiante</b></label></td>
                            <td><textarea style="height: 50px;" cols="73" id="compromisoestudiantetutoria" name="compromisoestudiantetutoria"><?php echo $data5['compromisoestudiantetutoria']; ?></textarea></td>
                        </tr><tr>
                            <td><label class="titulo_label"><b>Compromiso del Docente</b></label></td>
                            <td><textarea style="height: 50px;" cols="73" id="compromisodocentetutoria" name="compromisodocentetutoria"><?php echo $data5['compromisodocentetutoria']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label class="titulo_label"><b>Logros Obtenidos en la Tutoria</b></label></td>
                            <td><textarea style="height: 50px;" cols="73" id="logrostutoria" name="logrostutoria"><?php echo $data5['logrostutoria']; ?></textarea></td>
                        </tr><tr>
                            <td><label class="titulo_label"><b>Objetivo en la proxima Tutoria</b></label></td>
                            <td><textarea style="height: 50px;" cols="73" id="objetivospropuestotutoria" name="objetivospropuestotutoria"><?php echo $data5['objetivospropuestotutoria']; ?></textarea></td>
                        </tr><tr>
                            <td><label class="titulo_label"><b>Recomendaciones</b></label></td>
                            <td><textarea style="height: 50px;" cols="73" id="recomendaciontutoria" name="recomendaciontutoria"><?php echo $data5['recomendaciontutoria']; ?></textarea></td>
                    </table>
            </div>
            <div id="tabs-6">
                   <?php
                         $fun->remision($db,$id_estu,$_REQUEST['id_res']);
                     
                      ?>
                <table class="CSSTableGenerator">
                    <tr>
                        <td colspan="2">Si su remisi&oacute;n es Psicol&oacute;gica porfavor diligencia la siguiente informaci&oacute;n</td>
                    </tr>
                    <tr>
                        <td><b>Comportamientos observados y reporte del estudiante (especifique que factores de riesgo y de protecci&oacute;n ha identificado en el estudiante):</b></td>
                       <td><textarea style="height: 150px;" cols="58" id="descripcion1remision_psicologica" tabindex="2" name="descripcion1remision_psicologica"><?php echo $data5['descripcion1remision_psicologica']; ?></textarea></td>
                    </tr>
                </table>
             </div>
         </div>
         <div class="derecha">
                        <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="listar_tutorias.php" class="submit" tabindex="4">Regreso al menú</a>
                    </div><!-- End demo -->
         <h1 class="titulo2" style="width: 1030px"><a href="#" onclick="ver('tutorias','form_tutorias.php')"> Historial Tutorias </a> | <a href="#"  onclick="ver('remision_financiera','')"> Historial Financiera </a> | <a href="#" onclick="ver('remision_psicologica','')">  Historial Psicologica </a> </h1>
         <div id="historial">
             
         </div>
             
   </div>
   
  </form>
<script type="text/javascript">
      
     
                $(':submit').click(function(event) {
                    event.preventDefault();
                    //document.getElementById("descripcion").innerHTML = $.trim(nicEditors.findEditor('descripcion').getContent());
                     if(validar()){  
                       sendForm2()
                       //sendForm()
                     } 
                });
                
                function validar(){
                    if($.trim($("#objetivotutoria").val())=='') {
                                alert("Debe digitar los objetivotutorias de la tutoria");
                                $('#objetivotutoria').css('border-color','#F00');
				$('#objetivotutoria').effect("pulsate", {times:3}, 500);
                                $("#objetivotutoria").focus();
                                return false;
                        }else if($.trim($("#estrategiatutoria").val())=='') {
                                alert("Debe digitar las estrategiatutorias a seguir en esta tutoria");
                                $('#estrategiatutoria').css('border-color','#F00');
								$('#estrategiatutoria').effect("pulsate", {times:3}, 500);
                                $("#estrategiatutoria").focus();
                                return false;
                        }else if($.trim($("#compromisoestudiantetutoria").val())=='') {
                                alert("Debe digitar el compromiso o compromisos del estudiante en esta tutoria");
                                $('#compromisoestudiantetutoria').css('border-color','#F00');
				$('#compromisoestudiantetutoria').effect("pulsate", {times:3}, 500);
                                $("#compromisoestudiantetutoria").focus();
                                return false;
                        }else if($.trim($("#compromisodocentetutoria").val())=='') {
                                alert("Debe digitar el compromiso o compromisos del docente en esta tutoria");
                                $('#compromisodocentetutoria').css('border-color','#F00');
				$('#compromisodocentetutoria').effect("pulsate", {times:3}, 500);
                                $("#compromisodocentetutoria").focus();
                                return false;        
                        }else if($.trim($("#logrostutoria").val())=='') {
                                alert("Debe digitar los logrostutoria obtenidos en esta tutoria");
                                $('#logrostutoria').css('border-color','#F00');
				$('#logrostutoria').effect("pulsate", {times:3}, 500);
                                $("#logrostutoria").focus();
                                return false;
                        }else if($.trim($("#objetivospropuestotutoria").val())=='') {
                                alert("Debe digitar los objetivotutorias trazados en esta tutoria");
                                $('#objetivospropuestotutoria').css('border-color','#F00');
				$('#objetivospropuestotutoria').effect("pulsate", {times:3}, 500);
                                $("#objetivospropuestotutoria").focus();
                                return false;
                         }else if($.trim($("#recomendaciontutoria").val())=='') {
                                alert("Debe digitar las recomendaciontutoriaes para futuras tutorias");
                                $('#recomendaciontutoria').css('border-color','#F00');
				$('#recomendaciontutoria').effect("pulsate", {times:3}, 500);
                                $("#recomendaciontutoria").focus();
                                return false;        
                          }else{
                            return true;
                        }       
                }
                
                function sendForm2(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php', 
                        data: $('#form_test').serialize(),  
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                $("#idobs_tutorias").val(data.id)
                                var i=0;
                                $('input[name="remision[]"]:checked').each(function() { 
                                    i++;
                                 });
                                 if(i>0){
                                     sendForm()
                                 }else{
                                     $(location).attr('href','listar_riesgo_academico.php?tipo=P');
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
             
              function sendForm(){
                    var codigoperiodo=$("#codigoperiodo").val()
                    var entity='remision';
                    var idobs_registro_riesgo=$("#idobs_registro_riesgo").val()
                    var remision=''; 
                    $('input[name="remision[]"]').each(function() {  
                        if($(this).is(':checked')){
                         remision += ""+$(this).val() + ","; 
                        }else{
                          remision +="0,";   
                        }
                    });
                    remision = remision.substring(0, remision.length-1)
                    var idremision='';
                     $('input[name="idobs_remision[]"]').each(function() { idremision += ""+$(this).val() + ","; });
                     idremision = idremision.substring(0, idremision.length-1)
                    var codigoestudiante=$("#codigoestudiante").val()
                    var codigoestado=$("#codigoestado").val()
                    var idobs_remision=$("#idobs_remision").val()
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_arr.php', 
                        data: { codigoperiodo: codigoperiodo, action: "getData", entity:entity, idobs_registro_riesgo:idobs_registro_riesgo,
                                remision:remision, codigoestudiante:codigoestudiante, codigoestado:codigoestado, idremision:idremision
                        },  
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
                
                
</script>
    
<?php    writeFooter();
        ?>  

