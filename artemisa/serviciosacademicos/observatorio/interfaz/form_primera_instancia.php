<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
    include("funciones.php");
   $db =writeHeader("Identificaci&oacute;n <br> Riesgo",true,"PAE",1,'Identificacion del riesgo');
   $fun = new Observatorio();
   $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Identificacion del riesgo');
   $id_user=$_SESSION['MM_Username'];
   
   $id_doc=''; $id_estu='';
   
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
   // echo $riesgo;
    //print_r($data2);
  }
  
  /*if (!empty($_REQUEST['id'])){
    $entity4 = new ManagerEntity("tutorias");
    $entity4->sql_where = "idobs_registro_riesgo = ".$_REQUEST['id_res']."";
   // $entity4->debug = true;
    $data4 = $entity4->getData();
    $data4 =$data4[0];
    //print_r($data4);
  }
  
  if (!empty($_REQUEST['id'])){
    $entity5 = new ManagerEntity("remision");
    $entity5->sql_where = "idobs_registro_riesgo = ".$_REQUEST['id_res']."";
   // $entity4->debug = true;
    $data5 = $entity5->getData();
    $data5 =$data5[0];
    //print_r($data4);
  }
  //print_r($_SESSION);
*/
  
  if (!empty($_REQUEST['id'])){
    $entity3 = new ManagerEntity("primera_instancia");
    $entity3->sql_where = "idobs_primera_instancia = ".str_replace('row_','',$_REQUEST['id'])."";
   // $entity3->debug = true;
    $data2 = $entity3->getData();
    $data2 =$data2[0];
    //print_r($data2);
  }
  
  
?>
    <script type="text/javascript">
	$(document).ready(function(){
            $('#tabs').smartTab({
                        selected: 0,
                        autoHeight:true,
                        autoProgress: false,
                        stopOnFocus:true,
                        transitionEffect:'vSlide'})             
        });
    
    </script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_primera_instancia" id="idobs_primera_instancia" value="<?php echo $data2['idobs_primera_instancia'] ?>">
        <input type="hidden" name="idobs_registro_riesgo" id="idobs_registro_riesgo" value="<?php echo $data['idobs_registro_riesgo'] ?>">
        <input type="hidden" name="entity" id="entity" value="primera_instancia">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion']  ?>" />
        
        <div id="container" style="margin-left: 70px;">
        <div id="tabs">
            <ul>
                
            <li style="width: 160px"><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Datos del<br />Remitente</span></a></li>
            <li style="width: 160px"><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Datos<br />del Remitido</span></a></li>
            <li style="width: 160px"><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Causas de<br />Ingreso al PAE</span></a></li>
            <li style="width: 160px"><div class="stepNumber">4</div><a href="#tabs-4"><span class="stepDesc">Registro<br />Primera Instancia </span></a></li>
            <!--<li style="width: 160px"><div class="stepNumber">5</div><a href="#tabs-5"><span class="stepDesc">Primera<br />Tutoria</span></a></li>
            <li style="width: 160px"><div class="stepNumber">6</div><a href="#tabs-6"><span class="stepDesc">Remisi&oacute;n</span></a></li>-->
            </ul>
            <div id="tabs-1">
                 <?php 
                       
                       if (!empty($id_doc) and $tipo=='PAE'){
                            $fun->docente($db, $id_doc,$idrol);
                        }else if ($tipo=='Notas'){
                            echo "Remite por Bajo Rendimiento";
                        }else if ($tipo=='Prueba'){
                            echo "Remite por Entrevista de Admisiones";
                        }else{
                            echo "El estudiante viene por su cuenta <br>";
                        }
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
            <table class="CSSTableGenerator">
                    <tr>
                      <td colspan="2"><center><label class="titulo_label"><b>TIPO DE NECESIDAD</b></label></td>
                    </tr>
                         <?php
                            $query_tipo="SELECT * FROM obs_tipocausas WHERE codigoestado=100 ".$wh."  ";
                            //echo $query_tipo;
                            $reg_tipo =$db->Execute($query_tipo);
                            $i=0;
                            foreach($reg_tipo as $dt){
                                ?>
                                <tr>
                                    <td><label class="titulo_label"><b><?php echo $dt['nombretipocausas']; ?></b></label></td>
                                    <td><?php $fun->riesgos2($db,$dt['idobs_tipocausas'], $riesgo, $i,$_REQUEST['Th']);?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                            
                         ?>
                <tr>
                    <td colspan="2"><label class="titulo_label"><b>Aspectos esp&eacute;cificos Identificados</b></label></td>
                </tr>
                <tr>
                    <td colspan="2"><textarea style="height: 50px;" cols="115" id="aspectosprimera_instancia" tabindex="2" name="aspectosprimera_instancia" ><?php echo $data2['aspectosprimera_instancia']; ?></textarea></td>
                </tr>
            </table>
        
        </div>
        </div>
                   <div class="derecha" >
                        <?php if ($roles['editar']==1){?>
                        <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                        <?php } ?>
                        <a href="listar_registro_riesgo.php?tipo=P" class="submit" tabindex="4">Regreso al menú</a>
                        <!--&nbsp;&nbsp;
                        <a href="listar_primera_instancia.php?tipo=R" class="submit" tabindex="4">Listar Todo</a>-->
                    </div><!-- End demo -->
       <br>
    
    </div>
  </form>
<script type="text/javascript">
      
     
                $(':submit').click(function(event) {
                    event.preventDefault();
                    //document.getElementById("descripcion").innerHTML = $.trim(nicEditors.findEditor('descripcion').getContent());
                     if(validar()){  
                         //sendForm();
                         sendForm2();
                     } 
                });
                
                function validar(){
                    var ca=$("#cant_tipo").val();
                       var j=0; var i=0; var z=0;
                       
                       $('input[name="idobs_causas[]"]').each(function() {
                           z=$(this).val()
                            if($("input[id='idobs_tiporiesgo_"+z+"']:radio").is(':checked')==false){
                               alert("Debe escoger el riesgo")
                               $('#idobs_tiporiesgo_'+z+'').css('outline','1px solid #F00');
			       $('#idobs_tiporiesgo_'+z+'').effect("pulsate", {times:3}, 500);
                               $('#idobs_tiporiesgo_'+z+'').focus();
                               i++;
                           }
                       });
                     if($.trim($("#aspectosprimera_instancia").val())=='') {
                                alert("No ha digitado los aspectosprimera_instancia");
                                 $('#aspectosprimera_instancia').css('border-color','#F00');
				$('#aspectosprimera_instancia').effect("pulsate", {times:3}, 500);
                                $("#aspectosprimera_instancia").focus();
                                return false;
                        }else if (i>0){
                            return false;
                        }else{
                            return true;
                        }
                            
                }
                
                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_arr.php', 
                         data: $('#form_test').serialize(),  
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                $(location).attr('href','form_tutorias.php?id_res=<?php echo $_REQUEST['id_res'] ?>&tipotutoria=1');
                                //$(location).attr('href','listar_primera_instancia.php');
                                //sendForm2();
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
             }
                
              function sendForm2(){
                    var codigoperiodo=$("#codigoperiodo").val();
                    var codigoestado=$("#codigoestado").val();
                    var entity=$("#entity").val();
                    var idobs_registro_riesgo=$("#idobs_registro_riesgo").val();
                    var aspectosprimera_instancia=$("#aspectosprimera_instancia").val();
                    var idobs_primera_instancia=$("#idobs_primera_instancia").val();
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php', 
                        data: { codigoperiodo: codigoperiodo, action: "getData", entity:entity, aspectosprimera_instancia:aspectosprimera_instancia, 
                                idobs_primera_instancia:idobs_primera_instancia, codigoestado:codigoestado, idobs_registro_riesgo:idobs_registro_riesgo
                        },  
                        success:function(data){
                            if (data.success == true){
                               // alert(data.message);
                                $("#idobs_primera_instancia").val(data.id)
                                sendForm();
                                
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
             }  
             
              function sendForm3(){
                    var codigoperiodo=$("#codigoperiodo").val()
                    var entity=$("#entity3").val()
                    var remite=$("#remite").val()
                    var iddocente=$("#iddocente").val()
                    var idobs_registro_riesgo=$("#idobs_registro_riesgo").val()
                    var codigoestudiante=$("#codigoestudiante").val()
                    var remision_financiera=$("input[name='remision_financiera']:checked").val(); 
                    var remision_tutorias=$("input[name='remision_tutorias']:checked").val();
                    var remision_psicologica=$("input[name='remision_psicologica']:checked").val();
                   var codigoestado=$("#codigoestado").val()
                   var idobs_remision=$("#idobs_remision").val()
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_instacia.php', 
                        data: { codigoperiodo: codigoperiodo, action: "getData", entity:entity, remite:remite, 
                                iddocente:iddocente,  idobs_registro_riesgo:idobs_registro_riesgo,
                                codigoestudiante:codigoestudiante, remision_financiera:remision_financiera,
                                remision_financiera:remision_financiera, remision_tutorias:remision_tutorias,
                                remision_psicologica:remision_psicologica, codigoestado:codigoestado, idobs_remision:idobs_remision
                        },  
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

