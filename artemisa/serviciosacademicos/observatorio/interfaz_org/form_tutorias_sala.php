<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Seg. <br>S. Apendizaje",true,"PAE",1);
   $fun = new Observatorio();
   
    if (!empty($_REQUEST['id_grupos'])){
    $entity = new ManagerEntity("estudiantes_grupos_riesgo");
    $entity->sql_where = "id_estudiantes_grupos_riesgo = ".$_REQUEST['id_grupos']."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $id_gr=$data['idobs_grupos'];
    $id_estu=$data['idestudiantegeneral'];

    $entity3 = new ManagerEntity("grupos");
    $entity3->sql_where = "codigoestado=100 and idobs_grupos='".$data['idobs_grupos']."'  ";
   // $entity3->debug = true;
    $data3 = $entity3->getData();
    $ca=count($data3);
    $dataG =$data3[0];
    $id_doc=$dataG['iddocente'];
    
    $entity2 = new ManagerEntity("docente");
    $entity2->prefix = "";
    $entity2->sql_where = "iddocente = '".$id_doc."'";
    //$entity2->debug = true;
    $dataDo = $entity2->getData();
    $num_doc=$dataDo[0]['numerodocumento'];
    
    $entity1 = new ManagerEntity("usuario");
    $entity1->prefix = "";
    $entity1->sql_where = "numerodocumento = '".$num_doc."'";
    //$entity1->debug = true;
    $dataU = $entity1->getData();
    $idrol=$dataU[0]['codigorol'];
    $id_doc=$dataU[0]['idusuario']; 
   
    
  }
  

    $entity5 = new ManagerEntity("tutorias");
    $entity5->sql_where = "codigoestudiante = ".$id_estu." and idobs_tipotutoria=2";
    //$entity5->debug = true;
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
                    .load('generahistorial.php', {codigoestudiante: estudiante, entity:entity, direc:"form_tutorias_sala.php", tipoT:'2' }, function(response){					
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
                    .load('generahistorial.php', {codigoestudiante: estudiante, entity:tabla, direc:direc, tipoT:'2' }, function(response){					
                    if(response) {
                        jQuery("#historial").css('display', '');                        
                    } else {                    
                        jQuery("#historial").css('display', 'none');                    
                    }
                });
    }
    
    </script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_tutorias" id="idobs_tutorias" value="<?php echo $data5['idobs_tutorias'] ?>">
        <input type="hidden" name="idobs_registro_riesgo" id="idobs_registro_riesgo" value="<?php echo $_REQUEST['id_res'] ?>">
         <input type="hidden" name="entity" id="entity" value="tutorias">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" />
        <input type="hidden" name="idroltutoria" id="idroltutoria" value="<?php echo $_SESSION['rol'] ?>" />
        <input type="hidden" name="idobs_tipotutoria" id="idobs_tipotutoria" value="<?php echo $tipotuto ?>" />
        
        <div id="container" style="margin-left: 70px;">
        <div class="titulo">Registro de Seguimiento Salas de Aprendizaje</div>
        <br>
        <div id="tabs">
                <ul>
                <li style="width: 165px"><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Datos del<br />Dcoente</span></a></li>
                <li style="width: 165px"><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Datos<br />del Estudiante</span></a></li>
                <li style="width: 164px"><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Seguimiento</span></a></li>
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
                <!--<legend class="titulo">Registro Psicologico</legend>-->
                   <table class="CSSTableGenerator">
                       <tr>
                            <td><label class="titulo_label">Sala de Apredizaje:</td>
                            <td><?php 
                                   $query_dec = "SELECT nombregrupos, idobs_grupos FROM obs_grupos  where codigoestado='100' and idobs_grupos='".$data['idobs_grupos']."' ";
                                   
                                   $reg_dec =$db->Execute($query_dec);
                                   echo $reg_dec->GetMenu2('idobs_grupos', $data['idobs_grupos'], false,false,1,' id="idobs_grupos"  style="width:150px;"');
                            ?></td>
                        </tr>
                        <tr>
                            <td><label class="titulo_label"><b>Tutoria No</b></label></td>
                            <td><input type='text' id='n_tutoria' name='n_tutoria' value="<?php echo $tTuro; ?>" readonly ></td>
                        </tr>
                        <tr>
                            <td><label class="titulo_label"><b>Logros Obtenidos </b></label></td>
                            <td><textarea style="height: 50px;" cols="73" id="logrostutoria" name="logrostutoria"><?php echo $data5['logrostutoria']; ?></textarea></td>
                        </tr><tr>
                            <td><label class="titulo_label"><b>Objetivos</b></label></td>
                            <td><textarea style="height: 50px;" cols="73" id="objetivotutoria" name="objetivotutoria"><?php echo $data5['objetivotutoria']; ?></textarea></td>
                        </tr>
                       
                    </table>
            </div>
            
         </div>
         <div class="derecha">
                        <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="listar_tutorias.php" class="submit" tabindex="4">Regreso al menú</a>
                    </div><!-- End demo -->
         <h1 class="titulo2" style="width: 1030px"><a href="#" onclick="ver('tutorias','form_tutorias_sala.php')"> Historial Sala de Aprendizajes </a> </h1>
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
                                alert("Debe digitar los objetivos");
                                $('#objetivotutoria').css('border-color','#F00');
				$('#objetivotutoria').effect("pulsate", {times:3}, 500);
                                $("#objetivotutoria").focus();
                                return false;
                        }else if($.trim($("#logrostutoria").val())=='') {
                                alert("Debe digitar los logros");
                                $('#logrostutoria').css('border-color','#F00');
				$('#logrostutoria').effect("pulsate", {times:3}, 500);
                                $("#logrostutoria").focus();
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
                                     $(location).attr('href','listar_riesgo_salas.php');
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

