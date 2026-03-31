<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $fun = new Observatorio();
   $db =writeHeader("Observatorio",true,"PAE");
   
   $tipo=$_REQUEST['tipo'];
   $Utipo=$_REQUEST['Utipo'];
   
 //  echo '-->>'.$tipo;
   ////////////INFORMACION DEL ESTUDIANTE///////////////
   $codigoestudiante=$_REQUEST['codigoestudiante'];
   $cod_carrera=$_REQUEST['cod_carrera'];
   
   $entity = new ManagerEntity("admitidos_cab_entrevista");
   $entity->sql_where = "codigoestudiante= ".$codigoestudiante."";
   //$entity->debug = true;
   $data = $entity->getData();
   $data =$data[0];
   $Eadm=$data['admitido'];
   
    if(!empty($data['idobs_admitidos_cab_entrevista'])){
        $entity1 = new ManagerEntity("admitidos_entrevista");
        $entity1->sql_where = "idobs_admitidos_cab_entrevista= ".$data['idobs_admitidos_cab_entrevista']."";
        //$entity1->debug = true;
        $dataE = $entity1->getData();

        $tval=count($dataE);
        if(!empty($data['admitido'])){$tipo='Adm';}
    }
   
?>
<form action="" method="post" id="form_test3">
      <input type="hidden" name="idobs_admitidos_cab_entrevista" id="idobs_admitidos_cab_entrevista" value="<?php echo $data['idobs_admitidos_cab_entrevista'] ?>">
      <input type="hidden" name="entity3" id="entity3" value="admitidos_entrevista">
      <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
      <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo   $_REQUEST['codigoestudiante']  ?>" />
      <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" />
      <input type="hidden" name="Utipo" id="Utipo" value="<?php echo $_REQUEST['Utipo'] ?>" />
          <table border="0" class="CSSTableGenerator">
                    <tr>
                        <td rowspan="2"><b><center>Informaci&oacute;n</center></b></td>
                        <td rowspan="2"><b><center>CAMPOS A EVALUAR</td>
                        <td colspan="6"><b><center>PUNTAJE</td>
                    </tr>
                    <tr>

                        <td><b><center>0</center></b></td>
                        <td><b><center>1</center></b></td>
                        <td><b><center>2</center></b></td>
                        <td><b><center>3</center></b></td>
                        <td><b><center>Observaciones</center></b></td>
                        <td><b><center>Preguntas de Ayuda</center></b></td>
                    </tr>
                    <?php
                    $sql_con="select * from obs_admitidos_campos_evaluar";
                         //echo $sql_con;
                         $data_in2=$db->Execute($sql_con);
                         $i=0; $j=1; $t=110; $tpun=0;
                         foreach($data_in2 as $dt1){
                             ?>
                              <tr>
                                  <td style="vertical-align: top">
                                      <span class="formInfo"><a href="infor.php?width=375&id=<?php echo $dt1['idobs_admitidos_campos_evaluar'] ?>" class="jTip" id="<?php echo $i ?>" name="<?php echo strtoupper ($dt1['nombre']) ?>"><img src="../img/icono-informacion.png" height="20" width="20"  /></a></span>
                                  </td>
                                 <td>
                                     <input type="hidden" name="idobs_admitidos1[]" id="idobs_admitidos1"  value="<?php echo $dataE[$i]['idobs_admitidos_entrevista'] ?>" >
                                     <input type="hidden" name="idobs_admitidos_campos_evaluar[]" id="idobs_admitidos_campos_evaluar"  value="<?php echo $dt1['idobs_admitidos_campos_evaluar'] ?>" >
                                      <?php echo $dt1['nombre'] ?>
                                    
                                    <?php
                                    if ($dt1['idobs_admitidos_campos_evaluar']==10){
                                    ?>
                                    (<input type="checkbox" name="icfes" value="1" id="icfes"> ver resultados)
                                    <div id="saber" style=" display: none">
                                        <br>
                                         <?php $fun->saber11($db, $_REQUEST['codigoestudiante']); ?>
                                     </div>

                                    <?php
                                    }
                                    $dt=0; 
                                    if($dataE[$i]['puntaje']==''){
                                        $dt=1;
                                    }else{
                                        $tpun=$tpun+$dataE[$i]['puntaje'];
                                    }
                                   ?>
                                     <td><input type="radio" name="puntaje_<?php echo $i ?>[]" id="puntaje_<?php echo $i ?>" <?php if ($dataE[$i]['puntaje']==0 && $dt==0){ echo "checked"; }?> value="0"></td>
                                    <td><input type="radio"  name="puntaje_<?php echo $i ?>[]" id="puntaje_<?php echo $i ?>" <?php if ($dataE[$i]['puntaje']==1 && $dt==0){ echo "checked"; }?> value="1"></td>
                                    <td><input type="radio"  name="puntaje_<?php echo $i ?>[]" id="puntaje_<?php echo $i ?>" <?php if ($dataE[$i]['puntaje']==2 && $dt==0 ){ echo "checked"; }?> value="2"></td>
                                    <td><input type="radio"  name="puntaje_<?php echo $i ?>[]" id="puntaje_<?php echo $i ?>" <?php if ($dataE[$i]['puntaje']==3 && $dt==0){ echo "checked"; }?> value="3"></td>
                                    <td><textarea style="height:50px;" id="descripcion_c" name="descripcion_c[]" cols="40"><?php echo $dataE[$i]['descripcion'] ?></textarea></td>
                                    <td style="vertical-align: top"><a  href="javascript:void(0);" onclick="SINO('demo<?php echo $j ?>',<?php echo $j ?>)" ><img src="../img/pregunta_1.png" height="30" width="30"  /></a>
                                        <div id="demo<?php echo $j ?>" style="display:none; font-size: 10px; top:<?php echo $t ?>px; left:1000px"  >
                                            <div id="demotit<?php echo $j ?>"><div id="demotit1_<?php echo $j ?>"><?php echo strtoupper ($dt1['nombre']) ?></div></div>
                                            <br><br>
                                           <?php
                                           $id=$dt1['idobs_admitidos_campos_evaluar'];
                                            $sql_per="SELECT * FROM obs_admisiones_info WHERE idobs_admitidos_campos_evaluar='".$id."' ";
                                            //echo $sql_per;
                                            $data_in= $db->Execute($sql_per);
                                            $E_data = $data_in->GetArray();
                                            echo $E_data[0]['preguntas']; 
                                           ?>
                                       </div>  
                                    </td>         
                              </tr>
                         <?php
                            //if ($j==1){
                                //$t=$t+290;
                            //}else{
                                $t=$t+79;
                            //}
                            $i++; $j++;
                         }
                         $j--;
                   ?>
                              <tr>
                                  <td>&nbsp;</td>
                                  <td>Puntaje</td>
                                  <td colspan="4"><input type="button" value="Calcular Puntaje" onclick="puntajeF(<?php echo $j ?>)" />
                                                 <input type="text" id="puntajeT" name="puntajeT" readonly value="<?php echo $tpun ?>" style="width:50px"  /></td>
                                  <td>Descripci&oacute;n General:<br>
                                      <textarea style="height:50px;" id="descripcion_general" name="descripcion_general" cols="40"><?php echo $data['descripcion_general'] ?></textarea></td>
                                  <td>&nbsp;</td>
                              </tr>
                </table>
                    <input type="hidden" name="cant_con1" id="cant_con1" value="<?php echo $i?>" /> 
                     <?php 
                                     if($Utipo=='entrevistador' && empty($dataE[0]['idobs_admitidos_entrevista'])){ ?>
                            <div class="derecha" style=" width: 1350px;" >
                                <button class="submit" type="button" name="guardar3" id="guardar3" tabindex="3">Siguiente</button>
                            </div>
                           <?php } ?>    
                           <?php if($Utipo=='coordinador' && empty($Eadm)){ ?>
                                <div class="derecha" style=" width: 1350px;" >
                                   <button class="submit" type="button" name="guardar3" id="guardar3" tabindex="3">Siguiente</button>
                                </div>
                           <?php } ?>  
</form>
<script type="text/javascript">
      
       $(document).ready(function(){    
              suma();
               $("#icfes").click(function(){
                     if($("#icfes").is(':checked')) {  
                       jQuery("#saber").css('display', ''); 
                     }else{
                       jQuery("#saber").css('display', 'none');  
                     }
                      
                 });
        });
        
                 $('#guardar3').click(function(){             
                        if(validar3()){ 
                           sendForm3();
                        }
                });
                
                 function sendForm3(){
                    var codigoperiodo=$("#codigoperiodo").val()
                    var entity=$("#entity3").val()
                    var codigoestudiante=$("#codigoestudiante").val()
                    var codigoestado=$("#codigoestado").val()
                    var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val()
                    var can=$("#cant_con1").val();
                    var puntajeT=$("#puntajeT").val();
                    var descripcion_general=$("#descripcion_general").val();
                    var conP=''
                    $('input[name="idobs_admitidos_campos_evaluar[]"]').each(function() { conP += "'"+$(this).val() + "',"; });
                     conP = conP.substring(0, conP.length-1)
                    var ries=''
                    for(i=0;i<can;i++){
                        $("input[id='puntaje_"+i+"']:radio").each(function() {
                              if ($(this).is(':checked')==true ){
                                    ries += "'"+$(this).val() + "',";
                               }
                         });
                     }
                     ries = ries.substring(0, ries.length-1)
                     var desc=''
                     $('textarea[name="descripcion_c[]"]').each(function() { desc += "'"+$(this).val() + "',"; });
                     desc = desc.substring(0, desc.length-1)
                      var idadmP=''
                        $('input[name="idobs_admitidos1[]"]').each(function() { idadmP += "'"+$(this).val() + "',"; });
                         idadmP = idadmP.substring(0, idadmP.length-1);
                         
                         //alert(idadmP);
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_entrevista.php', 
                        data: { codigoperiodo: codigoperiodo, action: "getData", entity:entity, codigoestudiante:codigoestudiante,
                                idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista, idconP:conP, idadmP:idadmP, codigoestado:codigoestado,
                                ries:ries, desc:desc, puntajeT:puntajeT, descripcion_general:descripcion_general,
                              },  
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                 var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                                var estudiante=$("#codigoestudiante").val();
                                var entity=$("#entity3").val();
                                var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val();
                                var Utipo1=$("#Utipo").val();
                                
                                jQuery("#tabs-3")
                                    .html(ajaxLoader)
                                    .load('generaentrevista_paso3.php', {codigoestudiante: estudiante, Utipo:Utipo1, entity:entity, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista }, function(response){					
                                    if(response) {
                                        jQuery("#tabs-3").css('display', ''); 
                                    } 
                                });
                                
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
               
               function validar3(){
                   var can=$("#cant_con1").val()
                   var j=0;
                   for(i=0;i<can;i++){
                       if ($("input[id='puntaje_"+i+"']:radio").is(':checked')==false ){
                            alert("Debe escoger el puntaje del campo a evaluar");
                             $('#puntaje_'+i+'').css('outline','1px solid #F00');
			     $('#puntaje_'+i+'').effect("pulsate", {times:3}, 500);
                             $('#puntaje_'+i+'').focus();
                             j++;
                       }
                   }
                   if($.trim($("#descripcion_general").val())==''){
                       alert("Debe digitar la descripcion general");
                       $('#descripcion_general').css('outline','1px solid #F00');
		       $('#descripcion_general').effect("pulsate", {times:3}, 500);
                       $('#descripcion_general').focus();
                       return false
                   }else if($.trim($("#puntajeT").val())=='0'){
                       alert("Debe calcular el puntaje");
                       $('#puntajeT').css('outline','1px solid #F00');
		       $('#puntajeT').effect("pulsate", {times:3}, 500);
                       $('#puntajeT').focus();
                       return false
                   }else if ($("#idobs_admitidos_cab_entrevista").val()==''){
                         alert("Debe Guardar el paso 1");
                         return false;
                   }else{
                       if (j>0){
                         return false;
                        }else{
                          return true;
                        }
                      // return true;
                   }
                   
                     
               }
</script>