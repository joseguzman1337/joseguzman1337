<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $fun = new Observatorio();
   $db =writeHeader("Observatorio",true,"PAE");
   
   $tipo=$_REQUEST['tipo'];
   ////////////INFORMACION DEL ESTUDIANTE///////////////
   $codigoestudiante=$_REQUEST['codigoestudiante'];
   $cod_carrera=$_REQUEST['cod_carrera'];
   
   $entity = new ManagerEntity("admitidos_cab_entrevista");
   $entity->sql_where = "codigoestudiante= ".$codigoestudiante."";
   //$entity->debug = true;
   $data = $entity->getData();
   $data =$data[0];
   $Eadm=$data['admitido'];
   
   if(!empty($data['admitido'])){$tipo='Adm';}
   
?>
<form action="" method="post" id="form_test3">
      <input type="hidden" name="idobs_admitidos_cab_entrevista" id="idobs_admitidos_cab_entrevista" value="<?php echo $data['idobs_admitidos_cab_entrevista'] ?>">
      <input type="hidden" name="entity1" id="entity1" value="admitidos_cab_entrevista">
      <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
      <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo   $_REQUEST['codigoestudiante']  ?>" />
      <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" />
          <table border="0" class="CSSTableGenerator">
                <tr>
                    <td>Fecha</td>
                    <td><?php echo date('Y-m-d') ?><input type="hidden" name="fecha_admision" id="fecha_admision" value="<?php echo date('Y-m-d H:i:s') ?>"></td>
                    <td>Admitido</td>
                    <td><select id="admitido" name="admitido">
                            <option value=''>-Seleccione-</option>
                            <option value='Si' <?php if($data['admitido']=='Si') echo " selected" ?>>Si</option>
                            <option value='No' <?php if($data['admitido']=='No') echo " selected" ?>>No</option>
                        </select>
                    </td>
                </tr>
            </table>
             <?php 
             if( empty($Eadm)){ ?>
                                <div class="derecha" style=" width: 1350px;" >
                                   <button class="submit" type="button" name="guardar5" id="guardar5" tabindex="3">Siguiente</button>
                                </div>
              <?php } ?> 
<script type="text/javascript">

              $('#guardar5').click(function(){             
                        if(validar5()){ 
                            sendForm5();
                        }
                });
                
                 function validar5(){
                   
               if($.trim($("#admitido").val())==''){
                       alert("Debe escoger el estado de la admision");
                        $('#admitido').css('border-color','#F00');
                        $('#admitido').effect("pulsate", {times:3}, 500);
                        $("#admitido").focus();
                        return false;
                   }else{
                       return true;
                   }
               }
               
               function sendForm5(){
                    var codigoperiodo=$("#codigoperiodo").val()
                    var entity=$("#entity1").val()
                    var codigoestudiante=$("#codigoestudiante").val()
                    var codigoestado=$("#codigoestado").val()
                    var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val()
                    var admitido=$("#admitido").val();
                    var fecha_admision=$("#fecha_admision").val();
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_entrevista.php', 
                        data: { codigoperiodo: codigoperiodo, action: "getData", entity:entity, codigoestudiante:codigoestudiante,
                                fecha_admision:fecha_admision, 
                                admitido:admitido, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista,
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
                                    .load('generaentrevista_paso5.php', {codigoestudiante: estudiante, entity:entity,  Utipo:Utipo1, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista }, function(response){					
                                    if(response) {
                                        jQuery("#tabs-5").css('display', ''); 
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