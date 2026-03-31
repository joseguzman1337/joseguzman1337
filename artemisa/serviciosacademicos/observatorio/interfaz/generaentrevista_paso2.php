<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   include_once("../../utilidades/funcionesFechas.php");
   $fun = new Observatorio();
    $db=writeHeaderBD();
   //$db =writeHeader("Observatorio",true,"PAE");
   
   $tipo=$_REQUEST['tipo'];
   $Utipo=$_REQUEST['Utipo'];
 //  echo '-->>'.$tipo;
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
   
   
   
//////obtener idestudiantil////
   
    $query_idestu = "SELECT idestudiantegeneral FROM estudiante WHERE codigoestudiante= ".$codigoestudiante."";
    
    //echo $query_idestu;
    $idestudiantegeneral = $db->Execute($query_idestu);
    $data_idestu=$idestudiantegeneral->GetArray();
    $data_idestu=$data_idestu[0]["idestudiantegeneral"];
    //echo $data_idestu;
    
   /////fin obteneridstudiantil
   
    if(!empty($data['idobs_admitidos_cab_entrevista'])){
        /*$entity = new ManagerEntity("admitidos_entrevista_conte");
        $entity->sql_where = "idobs_admitidos_cab_entrevista= ".$data['idobs_admitidos_cab_entrevista']."";
       // $entity->debug = true;
        $dataC = $entity->getData();
        //print_r($dataC);
        $tval=count($dataC);*/
        
        
        /*
        Modificacion para cambio de consulta de datos de estudiante
        ME
        */
        
        $query_encuesta = "  SELECT
                            	EstudianteDetallesPersonales.idobs_admitidos_contexto,
                            	EstudianteDetallesPersonales.IdItemRespuesta,
                            	obs_admitidos_contexto.nombre,
                            	obs_admitidos_entrevista_conte.descripcion,
                            	obs_admitidos_entrevista_conte.idobs_admitidos_entrevista_conte
                            FROM
                            	obs_admitidos_entrevista_conte
                            INNER JOIN EstudianteDetallesPersonales ON EstudianteDetallesPersonales.idobs_admitidos_contexto = obs_admitidos_entrevista_conte.idobs_admitidos_contextoP
                            INNER JOIN obs_admitidos_contexto ON EstudianteDetallesPersonales.IdItemRespuesta = obs_admitidos_contexto.idobs_admitidos_contexto
                            INNER JOIN estudiante ON EstudianteDetallesPersonales.idestudiantegeneral LIKE estudiante.idestudiantegeneral
                            WHERE
                            	EstudianteDetallesPersonales.idestudiantegeneral = '".$data_idestu."'
                            AND obs_admitidos_entrevista_conte.codigoestudiante = '".$codigoestudiante."'
                            GROUP BY
                            	EstudianteDetallesPersonales.idobs_admitidos_contexto";
        
        //echo $query_encuesta;
        $encuesta = $db->Execute($query_encuesta);
        $totalRows_encuesta = $encuesta->RecordCount();
        $dataC = $encuesta->GetArray();
        
        //fin ME
        if(!empty($data['admitido'])){$tipo='Adm';}
		$horas = obtenerDiferenciaHorasFechas($data['fechacreacion']);
		if($horas<24){
			$pasaronHoras = false;
		}
    }
   
?>
<form action="" method="post" id="form_test2">
      <input type="hidden" name="idobs_admitidos_cab_entrevista" id="idobs_admitidos_cab_entrevista" value="<?php echo $data['idobs_admitidos_cab_entrevista'] ?>">
      <input type="hidden" name="entity2" id="entity2" value="admitidos_entrevista_conte">
      <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
      <input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?php echo   $_REQUEST['codigoestudiante']  ?>" />
      <input type="hidden" name="Utipo" id="Utipo" value="<?php echo $_REQUEST['Utipo'] ?>" />
        <table border="0" class="CSSTableGenerator">
                                <tr>
                                    <td colspan="4"><b><center>PREGUNTAS DE LA FAMILIA  Y DEL CONTEXTO EN GENERAL</center></b></td>
                                 <tr>
                                    <td><b><center>Pregunta</center></b></td>
                                    <td><b><center>Opciones</center></b></td>
                                    <td><b><center>Nivel</center></b></td>
                                    <td><b><center>Descripci&oacute;n</center></b></td>
                                 </tr>
                                 <?php
                                     $sql_con="select * from obs_admitidos_contexto where idpadre=0";
                                    
                                     //echo $sql_con;
                                     $data_in=$db->Execute($sql_con);
                                     $i=0; $j=0;$k=0;
                                     foreach($data_in as $dt){
                                         ?>
                                            <tr>
                                                <td><?php echo $dt['nombre'] ?>
                                                    <input type="hidden" name="idobs_admitidos_contextoP[]" id="idobs_admitidos_contextoP"  value="<?php echo $dt['idobs_admitidos_contexto'] ?>" >
                                                    <input type="hidden" name="idobs_admitidos[]" id="idobs_admitidos"  value="<?php echo $dataC[$i]['idobs_admitidos_entrevista_conte'] ?>" >
                                                     
                                                    
                                                    
                                                </td>
                                                <td><?php 
                                                        
                                                        
                                                        $id=$dt['idobs_admitidos_contexto'];
                                                        $query_op= "select * from obs_admitidos_contexto where idpadre='".$id."' and codigoestado='100'";
                                                        //echo $query_op;
                                                        $reg_op =$db->Execute($query_op);
                                                        $z=0;
                                                        ?>
                                                    <select id="idobs_admitidos_contexto_<?php echo $i ?>" name="idobs_admitidos_contexto[]" onchange="displayRiesgo(<?php echo $i ?>)" >
                                                        <option value="">-Seleccione-</option>
                                                        <?php
                                                        $id2=$dataC[$k]['IdItemRespuesta'];
                                                        foreach($reg_op as $dt1){
                                                                
																
														
                                                          ?>
                                                            <option value="<?php echo $dt1['idobs_admitidos_contexto'] ?>"
                                                                    <?php
                                                               if($id2==$dt1['idobs_admitidos_contexto']) echo "selected"     
                                                                    ?>><?php echo $dt1['nombre']; ?></option>
                                                          <?php
                                                          
                                                        }
                                                        ?> 
                                                     </select>
                                                     
                                                     
                                                     
                                                    
                   
                                              </td>
                                              <td>
                                                  <div id="nivel_<?php echo $i ?>">
                                                      <?php
                                                      
                                                            
                                                      if (!empty($dataC[$i]['IdItemRespuesta'])){
                                                      $query_carrera = "SELECT idobs_admitidos_contexto, nombre, nombretiporiesgo, t.idobs_tiporiesgo
                                                                            FROM obs_admitidos_contexto as c 
                                                                            LEFT JOIN obs_tiporiesgo as t on (t.idobs_tiporiesgo=c.idobs_tiporiesgo and t.codigoestado=100)
                                                                            WHERE c.idobs_admitidos_contexto='".$dataC[$k]['IdItemRespuesta']."' and c.codigoestado=100; ";
                                                           //echo $query_carrera;
                                                           $data_in= $db->Execute($query_carrera);
                                                           $data_user=$data_in->GetArray();
                                                           $data_user=$data_user[0];
                                                           if (!empty($data_user['nombretiporiesgo'])){
                                                               $nom=$data_user['nombretiporiesgo'];
                                                               $valo=$data_user['idobs_tiporiesgo'];
                                                           }else{
                                                               $nom="Sin Riesgo";
                                                               $valo=0;
                                                           }

                                                         ?>
                                                         <b><?php echo $nom?></b>
                                                         <input type="hidden" name="idobs_tiporiesgo[]" id="idobs_tiporiesgo" value="<?php echo $valo ?>" />
                                                         <?php
                                                             }
                                                         ?>
                                                  </div>
                                               </td>
                                               <td><textarea style="height:20px;" cols="40" id="descripcion" name="descripcion[]" ><?php if(empty($dataC[$i]['descripcion'])){ echo '-'; }else{ echo $dataC[$i]['descripcion']; } ?></textarea></td>
                                            </tr>      
                                        <?php
                                         if($dataC[$k]['idobs_admitidos_contexto']==$dt['idobs_admitidos_contexto'] ){
                                            $k++;
                                         }
                                                            
                                       
                                       
                                        $i++; $j++;
                                     }
                                     $iT=$i-1;
                                 ?>
                            </table>
                            <input type="hidden" name="cant_con" id="cant_con" value="<?php echo $iT?>" />
                        <?php 
                           if(($Utipo=='entrevistador' && empty($dataC[0]['idobs_admitidos_entrevista_conte'])) || ($Utipo=='entrevistador' && !$pasaronHoras)){ ?>
                            <div class="derecha" style=" width: 1350px;" >
                                <button class="submit" type="button" name="guardar2" id="guardar2" tabindex="3">Siguiente</button>
                            </div>
                           <?php } ?>    
                           <?php if(($Utipo=='coordinador' && empty($Eadm)) || ($Utipo=='coordinador' && !$pasaronHoras)){ ?>
                                <div class="derecha" style=" width: 1350px;" >
                                   <button class="submit" type="button" name="guardar2" id="guardar2" tabindex="3">Siguiente</button>
                                </div>
                           <?php } ?>     
                          
</form>
<script type="text/javascript">
      
               $('#guardar2').click(function(){
                        if(validar2()){ 
                            sendForm2();
                        }
                });
                
               function validar2(){
                     var i=0;
                     jQuery("select[name='idobs_admitidos_contexto[]']").each(function() {
                         //alert($(this).val()+'-->');
                         if($(this).val()==''){
                              alert("Debe escoger una de las opciones");
                                $(this).css('border-color','#F00');
                                $(this).focus();
                                 i++;
                         }
                     });
                     if ($("#idobs_admitidos_cab_entrevista").val()==''){
                         alert("Debe Guardar el paso 1");
                         return false;
                         i++
                     }
                     
                     if (i>0){
                         return false;
                     }else{
                         return true;
                     }
               }
               
               function sendForm2(){
                   // alert('aca entra')
               
                    var codigoperiodo=$("#codigoperiodo").val()
                    var entity=$("#entity2").val()
                    var codigoestado=$("#codigoestado").val()
                    var codigoestudiante=$("#codigoestudiante").val()
                    var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val()
                    var con=''
                    $("select[name='idobs_admitidos_contexto[]']").each(function(){ con += "'"+$(this).val() + "',"; });
                    con = con.substring(0, con.length-1)
                    var conP=''
                    
                    
                    
                    $('input[name="idobs_admitidos_contextoP[]"]').each(function() { conP += "'"+$(this).val() + "',"; });
                     conP = conP.substring(0, conP.length-1)
                     var ries=''
                     $('input[name="idobs_tiporiesgo[]"]').each(function() {ries += "'"+$(this).val() + "',"; });
                     ries = ries.substring(0, ries.length-1)
                     var desc=''
                     $('textarea[name="descripcion[]"]').each(function() { desc += "'"+$(this).val() + "'|"; });
                     desc = desc.substring(0, desc.length-1)
                      var idadmP=''
                    $('input[name="idobs_admitidos[]"]').each(function() { idadmP += "'"+$(this).val() + "',"; });
                     idadmP = idadmP.substring(0, idadmP.length-1)
                     
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_entrevista.php', 
                        data: { action: "getData", entity:entity, codigoestudiante:codigoestudiante,
                                idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista, idconP:conP,
                                idcon:con, ries:ries, desc:desc, codigoestado:codigoestado, idadmP:idadmP
                              },  
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";  
                                var estudiante=$("#codigoestudiante").val();
                                var entity=$("#entity2").val();
                                var idobs_admitidos_cab_entrevista=$("#idobs_admitidos_cab_entrevista").val();
                                var Utipo1=$("#Utipo").val();
                                jQuery("#tabs-2")
                                    .html(ajaxLoader)
                                    .load('generaentrevista_paso2.php', {codigoestudiante: estudiante, Utipo:Utipo1, entity:entity, idobs_admitidos_cab_entrevista:idobs_admitidos_cab_entrevista }, function(response){					
                                    if(response) {
                                        jQuery("#tabs-2").css('display', ''); 
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
//                    
               }

</script>