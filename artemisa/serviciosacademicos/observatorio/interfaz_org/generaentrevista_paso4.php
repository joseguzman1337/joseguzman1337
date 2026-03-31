<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $fun = new Observatorio();
   $db =writeHeader("Observatorio",true,"PAE");
   
   $tipo=$_REQUEST['tipo'];
   $Utipo=$_REQUEST['Utipo'];
    
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
        $entity = new ManagerEntity("admitidos_user");
         $entity->sql_where = "idobs_admitidos_cab_entrevista= ".$data['idobs_admitidos_cab_entrevista']."";
        //$entity->debug = true;
        $data2 = $entity->getData();
        
        if(!empty($data['admitido'])){$tipo='Adm';}
    }

   
?>
<form action="" method="post" id="form_test3">
      <input type="hidden" name="idobs_admitidos_cab_entrevista" id="idobs_admitidos_cab_entrevista" value="<?php echo $data['idobs_admitidos_cab_entrevista'] ?>">
      <input type="hidden" name="entity1" id="entity1" value="admitidos_cab_entrevista">
      <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
      <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo   $_REQUEST['codigoestudiante']  ?>" />
      <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" />
      <input type="hidden" name="Utipo" id="Utipo" value="<?php echo $_REQUEST['Utipo'] ?>" />
          <table border="0" class="CSSTableGenerator">
                <tr>
                    <td width="193px"> Recomienda Admision</td>
                    <td width="200px">
                        <?php
                            $query_tipo= "SELECT nombreestadoadmision, idobs_estadoadmision
                                          FROM obs_estadoadmision
                                          WHERE codigoestado=100";
                            //echo $query_tipo;
                            $reg_tipo = $db->Execute($query_tipo);
                            echo $reg_tipo->GetMenu2('idobs_estadoadmision',$data['idobs_estadoadmision'],true,false,1,' id="idobs_estadoadmision" tabindex="15"  ');
                        ?>
                    </td>
                    
                    <td width="150px">Por qu&eacute;?</td>
                    <td><textarea style="height:20px;" name="recomienda_admision_porque" id="recomienda_admision_porque" cols="40"><?php echo $data['recomienda_admision_porque'] ?></textarea> </td>
                </tr>
                <tr>
                    <td width="193px">Seguimiento por el PAE</td>
                    <td width="200px"><input type="checkbox" name="seguimiento" value="" <?php if($data['seguimiento']==1) echo "checked"; ?> id="seguimiento"></td>
                    <td width="150px">Por qu&eacute;?</td>
                    <td><textarea style="height:20px;" name="recomienda_seguimiento" id="recomienda_seguimiento" cols="40"><?php echo $data['recomienda_seguimiento'] ?></textarea> </td>
                </tr>
            </table>
            <table border="0" class="CSSTableGenerator">
                    <tr>
                          <td width="150px">Responsable 1:</td>
                          <td>
                              <input type='hidden' id='idobs_admitidos_user' name='idobs_admitidos_user[]' value='<?php echo $data2[0]['idobs_admitidos_user']?>' /> 
                              <input type="text" id="numerodocumento_1" name="numerodocumento[]" onblur="buscardocente(1)" value="<?php echo $data2[0]['idusuario']?>" >
                               
                        </td>
                        <td>
                            <div id="docente_1"> </div>
                        </td>
                        <td><input type="button" value="Otro Docente" onclick="masdoc(2)" /></td>
                    </tr>
                    <?php if(!empty($data2[1]['idobs_admitidos_user'])){
                                $style='';
                            }else{
                                $style='none';
                            }
                    ?>
                    <tr style=" display:<?php echo $style?>" id="tr2">
                            <td width="150px">Responsable 2:</td>
                          <td>
                              <input type='hidden' id='idobs_admitidos_user' name='idobs_admitidos_user[]' value='<?php echo $data2[1]['idobs_admitidos_user']?>' /> 
                               <input type="text" id="numerodocumento_2" name="numerodocumento[]" onblur="buscardocente(2)" value="<?php echo $data2[1]['idusuario']?>" >
                               
                        </td>
                        <td>
                            <div id="docente_2"> </div>
                        </td>
                        <td><input type="button" value="Otro Docente" onclick="masdoc(3)" /></td>
                    </tr>
                    <?php if(!empty($data2[2]['idobs_admitidos_user'])){
                                $style='';
                            }else{
                                $style='none';
                            }
                    ?>
                    <tr style=" display:<?php echo $style?>" id="tr3">
                             <td width="150px">Responsable 3:</td>
                          <td>
                              <input type='hidden' id='idobs_admitidos_user' name='idobs_admitidos_user[]' value='<?php echo $data2[2]['idobs_admitidos_user']?>' /> 
                               <input type="text" id="numerodocumento_3" name="numerodocumento[]" onblur="buscardocente(3)" value="<?php echo $data2[2]['idusuario']?>" >
                               
                        </td>
                        <td>
                            <div id="docente_3"> </div>
                        </td>
                        <td><input type="button" value="Otro Docente" onclick="masdoc(4)" /></td>
                    </tr>
                    <?php if(!empty($data2[3]['idobs_admitidos_user'])){
                                $style='';
                            }else{
                                $style='none';
                            }
                    ?>
                    <tr style=" display:<?php echo $style?>" id="tr4">
                          <td width="150px">Responsable 4:</td>
                          <td>
                              <input type='hidden' id='idobs_admitidos_user' name='idobs_admitidos_user[]' value='<?php echo $data2[3]['idobs_admitidos_user']?>' /> 
                              <input type="text" id="numerodocumento_4" name="numerodocumento[]" onblur="buscardocente(4)" value="<?php echo $data2[3]['idusuario']?>" >
                               
                        </td>
                        <td>
                            <div id="docente_4"> </div>
                        </td>
                        <td><!--<input type="button" value="Otro Docente" onclick="masdoc(5)" />--></td>
                    </tr>
              </table>
                    <?php if($Utipo=='entrevistador' && empty($data['idobs_estadoadmision'])){ ?>
                            <div class="derecha" style=" width: 1350px;" >
                                <button class="submit" type="button" name="guardar4" id="guardar4" tabindex="3">Siguiente</button>
                            </div>
                           <?php } ?>    
                           <?php if($Utipo=='coordinador' && empty($Eadm)){ ?>
                                <div class="derecha" style=" width: 1350px;" >
                                   <button class="submit" type="button" name="guardar4" id="guardar4" tabindex="3">Siguiente</button>
                                </div>
                           <?php } ?> 
</form>
<script type="text/javascript">

              $('#guardar4').click(function(){             
                        if(validar4()){ 
                            sendForm4();
                        }
                });
                
                 function validar4(){
                   if($.trim($("#idobs_estadoadmision").val())==''){
                       alert("Debe escoger el estado de la admision");
                        $('#idobs_estadoadmision').css('border-color','#F00');
                        $('#idobs_estadoadmision').effect("pulsate", {times:3}, 500);
                        $("#idobs_estadoadmision").focus();
                        return false;
                   }else{
                       return true;
                   }
               }
               
               function sendForm4(){
                    var codigoperiodo=$("#codigoperiodo").val()
                    var entity=$("#entity1").val()
                    var codigoestudiante=$("#codigoestudiante").val()
                    var codigoestado=$("#codigoestado").val()
                    var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val()
                    var idobs_estadoadmision=$("#idobs_estadoadmision").val();
                    var recomienda_admision_porque=$("#recomienda_admision_porque").val();
                    var seguimiento=0
                    if ($("input[name='seguimiento']:checked").is(':checked')==true ){
                        seguimiento=1
                    }
                    var recomienda_seguimiento=$("#recomienda_seguimiento").val()
                    var tipous=''
                    jQuery("select[name='codigotipousuario[]']").each(function(){ tipous += "'"+$(this).val() + "',"; });
                       tipous = tipous.substring(0, tipous.length-1)
                    
                     var user='';
                     $('input[name="numerodocumento[]"]').each(function() { user += "'"+$(this).val() + "',"; });
                     user = user.substring(0, user.length-1)
                     
                      var iduser='';
                     $('input[name="idobs_admitidos_user[]"]').each(function() { iduser += "'"+$(this).val() + "',"; });
                     iduser = iduser.substring(0, iduser.length-1)
                     
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_entrevista.php', 
                        data: { codigoperiodo: codigoperiodo, action: "getData", entity:entity, codigoestudiante:codigoestudiante,
                                idobs_estadoadmision:idobs_estadoadmision, 
                                recomienda_admision_porque:recomienda_admision_porque, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista,
                                seguimiento:seguimiento, tipous:tipous, user:user, iduser:iduser, recomienda_seguimiento:recomienda_seguimiento, 
                                codigoestado:codigoestado
                              },  
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                                var estudiante=$("#codigoestudiante").val();
                                var entity=$("#entity1").val();
                                var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val();
                                var Utipo1=$("#Utipo").val();
                                jQuery("#tabs-4")
                                    .html(ajaxLoader)
                                    .load('generaentrevista_paso4.php', {codigoestudiante: estudiante, entity:entity, Utipo:Utipo1, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista }, function(response){					
                                    if(response) {
                                        jQuery("#tabs-4").css('display', ''); 
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

</script>