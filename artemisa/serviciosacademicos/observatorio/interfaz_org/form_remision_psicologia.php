<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Remisi&oacute;n<br>Psicol&oacute;gica",true,"PAE",1);
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
    //echo $idrol.'-->';
    
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
  
  if (!empty($_REQUEST['id'])){
    $entity5 = new ManagerEntity("remision_psicologica");
    $entity5->sql_where = "idobs_remision_psicologica = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity5->debug = true;
    $data5 = $entity5->getData();
    $data5 =$data5[0];
  }
  
?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#buttons').akordeon();
        });
        
    
	$(document).ready(function(){
 		$('#tabs').smartTab({
                    selected: 0,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'});
                
        
                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                var estudiante=$("#codigoestudiante").val();
                var entity=$("#entity").val();
                jQuery("#historial")
                    .html(ajaxLoader)
                    .load('generahistorial.php', {codigoestudiante: estudiante, entity:entity, direc:"form_remision_psicologia.php" }, function(response){					
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
    
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_remision_psicologica" id="idobs_remision_psicologica" value="<?php echo $data5['idobs_remision_psicologica'] ?>">
        <input type="hidden" name="idobs_registro_riesgo" id="idobs_registro_riesgo" value="<?php echo $data['idobs_registro_riesgo'] ?>">
         <input type="hidden" name="entity" id="entity" value="remision_psicologica">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" />
        
        <div id="container" style="margin-left: 70px;">
        <div class="titulo">Registro Psicologico</div>
        <br>
        <div id="tabs">
                <ul>
                <li ><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Datos del<br />Remitente</span></a></li>
                <li ><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Datos<br />del Remitido</span></a></li>
                <li ><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Causas de<br />Ingreso al PAE</span></a></li>
                <li ><div class="stepNumber">4</div><a href="#tabs-4"><span class="stepDesc">Registro<br />Primera Instancia </span></a></li>
                <li ><div class="stepNumber">5</div><a href="#tabs-5"><span class="stepDesc">Registro <br />Psicologica</span></a></li>
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
                   <table border="0" width="100%" class="CSSTableGenerator">
                   <tr>
                       <td><b>Presenta Avances en los objetivos terapeuticos</b></td>
                     <td>Nada 
                         <input type="radio" name="calificacion" id="calificacion"  <?php if($data5['calificacion']==0) echo "checked"?> value="0" />
                         <input type="radio" name="calificacion" id="calificacion"  <?php if($data5['calificacion']==1) echo "checked"?> value="1" />
                         <input type="radio" name="calificacion" id="calificacion"  <?php if($data5['calificacion']==2) echo "checked"?> value="2" />
                         <input type="radio" name="calificacion" id="calificacion"  <?php if($data5['calificacion']==3) echo "checked"?> value="3" />
                         <input type="radio" name="calificacion" id="calificacion"  <?php if($data5['calificacion']==4) echo "checked"?> value="4" />
                         Mucho</td>
                   </tr>
                    </table>    

            </div>
         </div>
         <div class="derecha">
                        <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="listar_primera_instancia.php" class="submit" tabindex="4">Regreso al menú</a>
                    </div><!-- End demo -->
        <h1 class="titulo2" style="width: 1030px"><a href="#" onclick="ver('remision_psicologica','form_remision_psicologia.php')">  Historial Psicologica </a> | <a href="#"  onclick="ver('remision_financiera','')"> Historial Financiera </a> | <a href="#" onclick="ver('tutorias','')"> Historial Tutorias </a> </h1>
         
          <div id="historial">
             
         </div>
             
   </div>
   
  </form>
<script type="text/javascript">
      
     
                $(':submit').click(function(event) {
                    event.preventDefault();
                    //document.getElementById("descripcion").innerHTML = $.trim(nicEditors.findEditor('descripcion').getContent());
                     if(validar()){  
                        sendForm()
                     } 
                });
                
                function validar(){
                        if ($("input[id='calificacion']:radio").is(':checked')==false ){
                            alert("Debe escoger los avances");
                             $('#calificacion').css('outline','1px solid #F00');
			     $('#calificacion').effect("pulsate", {times:3}, 500);
                             $('#calificacion').focus();
                             return false;
                       }else{
                           return true;
                       }
                             
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
                                //$(location).attr('href','listar_primera_instancia.php');
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

