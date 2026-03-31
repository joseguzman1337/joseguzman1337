<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $fun = new Observatorio();
   $db =writeHeader("Observatorio",true,"PAE");
   
   //echo '<pre>';print_r($db);die;
  $tipo=$_REQUEST['tipo'];
  $Utipo=$_REQUEST['Utipo'];
  $Eadm=$data['admitido'];
  
  //echo $Utipo.'--->';
  
  //echo '-->>'.$Eadm;
   ////////////INFORMACION DEL ESTUDIANTE///////////////
   $codigoestudiante=$_REQUEST['codigoestudiante'];
   $cod_carrera=$_REQUEST['cod_carrera'];
   
   $entity = new ManagerEntity("admitidos_cab_entrevista");
   $entity->sql_where = "codigoestudiante= ".$codigoestudiante."";
   //$entity->debug = true;
   $data = $entity->getData();  
   //print_r($data);
   $data =$data[0];
   $Eadm=$data['admitido'];
   
   if(!empty($data['idobs_admitidos_cab_entrevista'])){
    $entity = new ManagerEntity("documentos_pendientes");
    $entity->sql_where = "idobs_admitidos_cab_entrevista= ".$data['idobs_admitidos_cab_entrevista']."";
    //$entity->debug = true;
    $dataD = $entity->getData();
    
    if(!empty($data['admitido'])){$tipo='Adm';}
    
   }
?>
<form action="" method="post" id="form_test1">
      <input type="hidden" name="idobs_admitidos_cab_entrevista" id="idobs_admitidos_cab_entrevista" value="<?php echo $data['idobs_admitidos_cab_entrevista'] ?>">
      <input type="hidden" name="entity1" id="entity1" value="admitidos_cab_entrevista">
      <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
      <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo   $_REQUEST['codigoestudiante']  ?>" />
      <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" />
        <table border="0" class="CSSTableGenerator">
                    <tr>
                        <td>Instituci&oacute;n educativa:</td>
                        <td colspan="3"><?php 
                            $query_edu = "SELECT i.nombreinstitucioneducativa, i.idinstitucioneducativa  
                                            FROM institucioneducativa as i
                                            INNER JOIN estudianteestudio as e on (i.idinstitucioneducativa=e.idinstitucioneducativa)
                                            INNER JOIN estudiantegeneral AS eg on (e.idestudiantegeneral=eg.idestudiantegeneral)
                                            INNER JOIN estudiante AS es on (eg.idestudiantegeneral=es.idestudiantegeneral)
                                            WHERE es.codigoestudiante='".$codigoestudiante."' ";
                            $reg_edu =$db->Execute($query_edu);
                            echo $reg_edu->GetMenu2('idinstitucionacademica','',false,false,1,' id="idinstitucionacademica"  ');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Documentaci&oacute;n requerida completa:</td>
                        <td>Si <input type="radio" name="documentacion_requerida" id="documentacion_requerida" <?php if($data['documentacion_requerida']=='Si') echo "checked" ?> value="Si"> 
                            No <input type="radio" name="documentacion_requerida" id="documentacion_requerida" <?php if($data['documentacion_requerida']=='No') echo "checked" ?>   value="No"></td>
                        <td>Pendiente</td>
                        <td><div style="overflow-x: hidden; overflow-y: scroll; width: 100%; height: 100px;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
                            <?php
                            $query_doc="SELECT d.nombredocumentacion, d.iddocumentacion 
                                        FROM documentacionfacultad as df
                                        INNER JOIN documentacion as d on (d.iddocumentacion=df.iddocumentacion)
                                        inner join carrera as c on (df.codigocarrera=c.codigocarrera)
                                        where c.codigocarrera='".$cod_carrera."' order by nombredocumentacion asc;";
                            //echo $query_doc;
                            $reg_cau =$db->Execute($query_doc);
                            foreach($reg_cau as $ca){
                                $che=""; $ch1='';
                                foreach ($dataD as $da){
                                    if ($ca['iddocumentacion']==$da['iddocumentos']){
                                        $ch1='1';
                                        $valdd=$da['idobs_documentos_pendientes'];
                                        if($da['codigoestado']==100){
                                            $che="checked";
                                        }
                                       break;
                                   }
                                }
                                ?>
                                 <tr>
                                         <td><?php echo $ca['nombredocumentacion'];?></td>
                                         <td>
                                             <?php
                                                if(!empty($ch1)){
                                                    $vali=$valdd;
                                                }else{
                                                    $vali=0;
                                                }
                                                
                                             ?>
                                             <input type="hidden" name="docIdP[]" id="docIdP" value="<?php echo $vali  ?>" />
                                             <input type="checkbox" class="ries_<?php echo $dt['iddocumentacion'] ?>" <?php echo $che?> id="iddocumentacion" name="iddocumentacion[]"  value="<?php echo  $ca['iddocumentacion'] ?>"   /></td>
                                 </tr>
                                 <?php
                                     $j++; $z++;
                                 }                                    
                            ?>
                            </table>
                            </div>
                        </td>
                    </tr>
            </table>
      <?php 
                           if($Utipo=='entrevistador' && empty($data['idobs_admitidos_cab_entrevista'] )){ ?>
                            <div class="derecha" style=" width: 1350px;" >
                                <button class="submit" type="button" name="guardar1" id="guardar1" tabindex="3">Siguiente</button>
                            </div>
                           <?php } ?>    
                            <?php if($Utipo=='coordinador' && empty($Eadm)){ ?>
                                <div class="derecha" style=" width: 1350px;" >
                                   <button class="submit" type="button" name="guardar1" id="guardar1" tabindex="3">Siguiente</button>
                                </div>
                           <?php } ?>     
</form>
<script type="text/javascript">
      
                   $('#guardar1').click(function(){             
                        if(validar1()){ 
                            sendForm1();
                        }
                });
                
                 function validar1(){
                   if($.trim($("#idinstitucionacademica").val())==''){
                       alert("Debe escoger una institucion");
                        $('#idinstitucionacademica').css('border-color','#F00');
                        $('#idinstitucionacademica').effect("pulsate", {times:3}, 500);
                        $("#idinstitucionacademica").focus();
                        return false;
                   }else if ($("input[name='documentacion_requerida']:radio").is(':checked')==false ){
                             alert("Debe escoger si Documentacion requerida completa");
                             $('#documentacion_requerida').css('border-color','#F00');
			     $('#documentacion_requerida').effect("pulsate", {times:3}, 500);
                             $("#documentacion_requerida").focus();
                         return false;
                   }else if ($("input[name='documentacion_requerida']:checked").val()=='No'){
                            var i=0;
                            $('input[name="iddocumentacion[]"]:checked').each(function() {
                                  i++;
                            });
                            if (i==0){
                               alert("Debe escoger que documentacion requerida");
                               return false;
                            }else{
                                return true;
                            }
                         
                   }else{
                       return true;
                   }
               }
               
                
                function sendForm1(){
                    var codigoperiodo=$("#codigoperiodo").val();
                    var entity=$("#entity1").val();
                    var codigoestudiante=$("#codigoestudiante").val();
                    var codigoestado=$("#codigoestado").val();
                    var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val();
                    var documentacion_requerida=$('input[name=documentacion_requerida]:checked').val();
                    var conP=''
                    $('input[name="docIdP[]"]').each(function() { 
                            conP += $(this).val() + ","; 
                      });
                     conP = conP.substring(0, conP.length-1) 
                    var iddocu='';
                    $('input[name="iddocumentacion[]"]').each(function() { 
                        if($(this).is(':checked')) { 
                            iddocu += ""+$(this).val() + ",";
                        }else{
                            iddocu+='0,'; 
                        }
                     });
                     iddocu = iddocu.substring(0, iddocu.length-1)
                    
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_entrevista.php', 
                         data: { codigoperiodo: codigoperiodo, action: "getData", entity:entity, codigoestudiante:codigoestudiante,
                                documentacion_requerida:documentacion_requerida, iddocu:iddocu, codigoestado:codigoestado,
                                idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista, docP:conP
                                },   
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                if(idobs_admitidos_cab_entrevista==''){
                                    $("#idobs_admitidos_cab_entrevista").val(data.id);
                                }
                                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                                var estudiante=$("#codigoestudiante").val();
                                var entity=$("#entity1").val();
                                var codcarrera=$("#cod_carrera").val();
                                var Utipo1=$("#Utipo").val();
                                jQuery("#tabs-1")
                                    .html(ajaxLoader)
                                    .load('generaentrevista_paso1.php', {codigoestudiante: estudiante, Utipo:Utipo1, entity:entity, cod_carrera:codcarrera }, function(response){					
                                    if(response) {
                                        jQuery("#tabs-1").css('display', ''); 
                                    } 
                                });
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