<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
// echo "<pre>"; print_r($_REQUEST);
   include("../templates/templateObservatorio.php");
   include("funciones.php");
   include_once("../../utilidades/funcionesFechas.php");
   $fun = new Observatorio();
    $db=writeHeaderBD();
   //$db =writeHeader("Observatorio",true,"PAE");
   
   $tipo=$_REQUEST['tipo'];
   $Utipo=$_REQUEST['Utipo'];
   ////////////INFORMACION DEL ESTUDIANTE///////////////
   $codigoestudiante=$_REQUEST['codigoestudiante'];
   $cod_carrera=$_REQUEST['cod_carrera'];
   
   $entity = new ManagerEntity("admitidos_cab_entrevista");
   $entity->sql_where = "codigoestudiante= ".$codigoestudiante." and codigoestado=100";
   //$entity->debug = true;
   $data = $entity->getData();
   $data =$data[0];
   $Eadm=$data['admitido'];
   $pasaronHoras = true;
   
    if(!empty($data['idobs_admitidos_cab_entrevista'])){
        $entity = new ManagerEntity("admitidos_user");
         $entity->sql_where = "idobs_admitidos_cab_entrevista= ".$data['idobs_admitidos_cab_entrevista']."";
        //$entity->debug = true;
        $data2 = $entity->getData();
        
        if(!empty($data['admitido'])){$tipo='Adm';}
		$horas = obtenerDiferenciaHorasFechas($data['fechacreacion']);
		if($horas<24){
			$pasaronHoras = false;
		}
    }
	
   
   $query_carrera = " SELECT codigoperiodo FROM estudianteestadistica ee WHERE ee.codigoestudiante=". $codigoestudiante;
   $dataPeriodo= $db->GetRow($query_carrera);
   $codigoperiodo = $_SESSION['codigoperiodosesion'];
   if(!empty($dataPeriodo)){
		$codigoperiodo = $dataPeriodo["codigoperiodo"];
   }

   
?>
<form action="" method="post" id="form_test3">
      <input type="hidden" name="idobs_admitidos_cab_entrevista" id="idobs_admitidos_cab_entrevista" value="<?php echo $data['idobs_admitidos_cab_entrevista'] ?>">
      <input type="hidden" name="entity1" id="entity1" value="admitidos_cab_entrevista">
      <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
      <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo $codigoestudiante ?>" />
      <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $codigoperiodo ?>" />
      <input type="hidden" name="Utipo" id="Utipo" value="<?php echo $_REQUEST['Utipo'] ?>" />
          <table border="0" class="CSSTableGenerator">
                <tr>
                    <td width="193px"> Observaciones</td>
                    <td width="200px">
                        <textarea style="height:20px;" name="observaciones_segunda_ent" id="observaciones_segunda_ent" cols="40"><?php echo $_REQUEST['observaciones_segunda_ent'] ?></textarea>
                    </td>
                    
                    <td width="150px">Documento entrevistador</td>
                    <td><input type="hidden" id="documento_segunda_ent_oc" name="numerodocumento[]" onblur="buscardocente(1)" value="<?php echo $data2[0]['idusuario']?>" >
					<input type="text" id="documento_segunda_ent" name="documento_segunda_ent" value="<?php echo $_REQUEST['documento_segunda_ent'] ?>" ></td>
					<td width="193px"> Recomienda Admision</td>
                    <td width="200px">
                        <?php
                            $query_tipo= "SELECT nombreestadoadmision, idobs_estadoadmision
                                          FROM obs_estadoadmision
                                          WHERE codigoestado=100 AND idobs_estadoadmision <> 3";
                            //echo $query_tipo;
                            $reg_tipo = $db->Execute($query_tipo);
                            echo $reg_tipo->GetMenu2('idobs_estadoadmision',$data['idobs_estadoadmision'],true,false,1,' id="idobs_estadoadmision" tabindex="15"  ');
                        ?>
                    </td>
                </tr>
            </table>
                    <div class="derecha" style=" width: 1350px;" >
                    <?php if(($Utipo=='entrevistador' && empty($data['idobs_estadoadmision'])) || ($Utipo=='entrevistador' && !$pasaronHoras)){ ?>
                                <button class="submit" type="button" name="guardar5" id="guardar5" tabindex="3">Guardar entrevista</button>
                           <?php }
						   if($Utipo=='entrevistador' && !empty($data['idobs_estadoadmision'])){
                            ?>                             
                                <a href="../tablero/index.php" class="submit" type="button" name="salir" id="salir" tabindex="3">Salir</a>
                               
                                <?php
                           } ?>    
                           <?php if(($Utipo=='coordinador' && empty($Eadm)) || ($Utipo=='coordinador' && !$pasaronHoras)){ ?>
                                <button class="submit" type="button" name="guardar4" id="guardar4" tabindex="3">Guardar entrevista</button>                          
                            
                            <?php }
							if($Utipo=='coordinador' && !empty($data['idobs_estadoadmision'])){
                            ?>  
                                    <a href="../tablero/index.php" class="submit" type="button" name="salir" id="salir" tabindex="3">Salir</a>
                               
                           <?php } ?> 
                 </div>
</form>
<script type="text/javascript">

              $('#guardar5').click(function(){             
                        
                        if(validar5()){ 
                            sendForm5();                            
                        }
                });
                
                 function validar5(){
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
               function ocultar(){
                document.getElementById('guardar4').style.display="none";
               }
               function mostrar(){
                document.getElementById('nuevoregistro').style.display="inline";
                document.getElementById('salir').style.display="inline-block";
               }
               function sendForm5(){
                    var codigoperiodo=$("#codigoperiodo").val()
                    var entity=$("#entity1").val()
                    var codigoestudiante=$("#codigoestudiante").val()
                    var codigoestado=$("#codigoestado").val()
                    var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val()
                    var idobs_estadoadmision=$("#idobs_estadoadmision").val();
                    var observaciones_segunda_ent=$("#observaciones_segunda_ent").val();
					var documento_segunda_ent = $('#documento_segunda_ent').val();
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
                                observaciones_segunda_ent:observaciones_segunda_ent, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista,
                                user:user, iduser:iduser, documento_segunda_ent:documento_segunda_ent,
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
                                jQuery("#tabs-5")
                                    .html(ajaxLoader)
                                    .load('generaentrevista_paso5.php', {codigoestudiante: estudiante, entity:entity, Utipo:Utipo1, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista, documento_segunda_ent:documento_segunda_ent, observaciones_segunda_ent:observaciones_segunda_ent}, function(response){					
                                    if(response) {
                                        jQuery("#tabs-5").css('display', ''); 
                                    }
                            // ocultar();
                            // mostrar(); 
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