<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Registro <br> Riesgo",true,"PAE",1);
   
   $fun = new Observatorio();
   
   $id_user=$_SESSION['MM_Username'];
   $idR=str_replace('row_','',$_REQUEST['id']);
   $id_doc=''; $id_estu='';
   
   $tipo=$_REQUEST['tipo'];
    if ($tipo=='Notas'){
        $miarray = $_REQUEST['datos'];
        $array_para_recibir_via_url = stripslashes($miarray);
        $array_para_recibir_via_url = urldecode($array_para_recibir_via_url );
        $matriz_completa = unserialize($array_para_recibir_via_url);
        
        $entity1 = new ManagerEntity("estudiantegeneral");
        $entity1->prefix = "";
        $entity1->sql_where = "numerodocumento = '".$matriz_completa['numerodocumento']."'";
        //$entity1->debug = true;
        $dataD = $entity1->getData();
        $id_estu= $dataD[0]['idestudiantegeneral'];
        $Th=4;
       //print_r($matriz_completa);
    } if ($tipo=='Prueba'){
     $entity1 = new ManagerEntity("estudiante");
        $entity1->prefix = "";
        $entity1->sql_where = "codigoestudiante = '".$_REQUEST['codigoestudiante']."'";
       // $entity1->debug = true;
        $dataD = $entity1->getData();
        $id_estu= $dataD[0]['idestudiantegeneral'];   
         $Th=3;
   }if (empty($tipo)){
       $Th=2;
   }
   
  if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("registro_riesgo");
    $entity->sql_where = "idobs_registro_riesgo = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $id_doc1=$data['usuariocreacion'];
    $id_estu=$data['codigoestudiante'];
    $Th=2;
    
     $entity1 = new ManagerEntity("usuario");
     $entity1->prefix = "";
     $entity1->sql_where = "idusuario = '".$id_doc1."'";
     //$entity1->debug = true;
     $dataD = $entity1->getData();
     $id_doc=$dataD[0]['idusuario'];
     $idrol=$dataD[0]['codigorol'];
      
    $entity3 = new ManagerEntity("causas");
    $entity3->sql_where = "codigoestado=100 ";
    $data3 = $entity3->getData();
    $ca=count($data3);
    
    $entity2 = new ManagerEntity("registro_riesgo_causas");
    $entity2->sql_where = "idobs_registro_riesgo = ".str_replace('row_','',$_REQUEST['id'])." order by idobs_registro_riesgo_causas asc ";
    //$entity2->debug = true;
    $data2 = $entity2->getData();
    $riesgo=''; $j=0;
    for ($i=0; $i<$ca; $i++){
        if($i==$data2[$j]['idobs_causas']){
            $riesgo[]=$data2[$j]['idobs_causas'];
            $j++;
        }else{
           $riesgo[]=0; 
        }
    }
     //print_r($riesgo);
  }else{
      $idrol=$_SESSION['rol'];
      $entity1 = new ManagerEntity("usuario");
      $entity1->prefix = "";
      $entity1->sql_where = "usuario = '".$_SESSION['MM_Username']."'";
      //$entity1->debug = true;
      $dataD = $entity1->getData();
      $id_doc=$dataD[0]['idusuario'];
  }

?>
    <script type="text/javascript">
  
      $(document).ready(function(){
        jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera();});
      
    	$('#tabs').smartTab({
                    selected: 0,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
	});


    
    
    </script>
    
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_registro_riesgo" id="idobs_registro_riesgo" value="<?php echo $data['idobs_registro_riesgo'] ?>">
        <input type="hidden" name="entity" id="entity" value="registro_riesgo" />
        <input type="hidden" name="entity2" id="entity2" value="registro_riesgo_causas" />
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" /> 
         <input type="hidden" name="idobs_herramientas_deteccion" id="idobs_herramientas_deteccion" value="<?php echo $Th ?>" /> 
         
        <div id="container" style="margin-left: 70px">
        <div class="titulo">Registro Riesgo</div>
        <br>
        <div id="tabs">
            <ul>
                
            <li><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Datos del<br />remitente</span></a></li>
            <li><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Datos del<br />Remitido</span></a></li>
            <?php if ($tipo=='Notas' or $tipo=='Prueba' ){ ?> <li><div class="stepNumber">3</div><a href="#tabs-4"><span class="stepDesc">Causas de<br />Remisi&oacute;n</span></a></li><?php } ?>
            <li><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Registro de<br />Riesgo</span></a></li>
            </ul>
            <div id="tabs-1">
                <?php  if ($idrol==2){
                         //   echo $id_doc.'-->>';
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
                <?php  $fun->estudiante($db, $id_estu);
                //echo $id_estu.'-->>';
                ?>
              <br>
              <br>
              <br>
             </div>
                <div id="tabs-3">
                     <?php $fun->riesgos($db, '', $riesgo,'idobs_registro_riesgo_causas',$idR); ?>
                       <table border="0" class="CSSTableGenerator">
                           <tr>
                               <td><label class="titulo_label"><b>Nivel:</b></label></td>
                               <td>
                                <?php
                                  $query_riesgo = "SELECT nombretiporiesgo, idobs_tiporiesgo FROM obs_tiporiesgo where codigoestado='100'";
                                  $reg_riesgo =$db->Execute($query_riesgo);
                                  echo $reg_riesgo->GetMenu2('idobs_tiporiesgo',$data['idobs_tiporiesgo'],true,false,1,' id=idobs_tiporiesgo  style="width:150px;"');
                                  ?>
                               </td>
                           </tr>
                                        <tr>
                                            <td><label class="titulo_label"><b>Descripci&oacute;n:</b></label></td>
                                        <td colspan="5" >&nbsp;
                                         <div id="Descripcion">
                                                  <textarea style="height: 50px;" cols="76" id="observacionesregistro_riesgo" tabindex="3" name="observacionesregistro_riesgo"><?php echo $data['observacionesregistro_riesgo']; ?></textarea>
                                         </div>
                                         </td>
                                      </tr>
                                      <tr>
                                          <td><label class="titulo_label"><b>Intervenci&oacute;n Primera Instancia:</b></label></td>
                                        <td colspan="5" >&nbsp;
                                         <div id="Intervencion">
                                                  <textarea style="height: 50px;" cols="76" id="intervencionregistro_riesgo" tabindex="3" name="intervencionregistro_riesgo"><?php echo $data['intervencionregistro_riesgo']; ?></textarea>
                                         </div>
                                         </td>
                                      </tr>
                              </table>
              
                        </div>
            <?php if ($tipo=='Notas'  or $tipo=='Prueba'){ ?>
                    <div id="tabs-4">
                        <?php 
                        if ($tipo=='Notas' ){
                            $fun->registro_academico($db, $matriz_completa);
                            
                        }
                        if ($tipo=='Prueba' ){
                            $fun->registro_prueba($db, $id_estu);
                            
                        }
                        
                        ?>
                    </div>    
            <?php } ?>
        </div>
                   <div class="derecha" >
                        <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                        <button class="submit" type="reset" tabindex="3">Limipar</button>
                        &nbsp;&nbsp;
                        <a href="listar_registro_riesgo.php?tipo=R" class="submit" tabindex="4">Regreso al menú</a>
                        
                    </div><!-- End demo -->
        </div>
  </form>
<script type="text/javascript">
      
     
                $(':submit').click(function(event) {
                    event.preventDefault();
                     if(validar()){  
                        sendFormdata();
                        //sendForminfo()
                    } 
                });
                
                function validar(){
                    j=0
                    var nriesgo=$("#nriesgo").val();
                    var riesgo='';
                    for (i=0; i<nriesgo; i++){
                        if($("#idobs_causas_"+i).is(':checked')) { 
                           j++
                        }
                    }   
                   //alert(j+'<<-->>')
                    if($.trim($("#codigoestudiante").val())=='') {
                                alert("Debe escoger un Estudiante");
                                return false;
                        }else if($.trim($("#idobs_tiporiesgo").val())=='') {
                                alert("No ha escogido el nivel de riesgo");
                                 $('#idobs_tiporiesgo').css('border-color','#F00');
				$('#idobs_tiporiesgo').effect("pulsate", {times:3}, 500);
                                $("#idobs_tiporiesgo").focus();
                                return false;
                        }else if($.trim($("#observacionesregistro_riesgo").val())=='') {
                                alert("Debe Digitar la Descripcion");
                                 $('#observacionesregistro_riesgo').css('border-color','#F00');
				$('#observacionesregistro_riesgo').effect("pulsate", {times:3}, 500);
                                $("#observacionesregistro_riesgo").focus();
                                return false;
                        }else if($.trim($("#intervencionregistro_riesgo").val())=='') {
                                alert("Debe Digitar la Intervension Primera Instacia");
                                 $('#intervencionregistro_riesgo').css('border-color','#F00');
				$('#intervencionregistro_riesgo').effect("pulsate", {times:3}, 500);
                                $("#intervencionregistro_riesgo").focus();
                                return false;
                        }else if (j==0){
                            alert("Debe escoger minimo un riesgo");
                            return false;
                        }else{
                            return true;
                        }     
                }
                
                     
                function sendFormdata(){
                    var entity=$("#entity").val();
                    var iddocente=$("#iddocente").val();
                    var idobs_registro_riesgo=$("#idobs_registro_riesgo").val()
                    var codigoestudiante=$("#codigoestudiante").val();
                    var observacionesregistro_riesgo=$("#observacionesregistro_riesgo").val();
                    var intervencionregistro_riesgo=$("#intervencionregistro_riesgo").val();
                    var codigoperiodo=$("#codigoperiodo").val();
                    var idobs_tiporiesgo=$("#idobs_tiporiesgo").val();
                    var codigoestado=$("#codigoestado").val();
                    var idobs_herramientas_deteccion=$("#idobs_herramientas_deteccion").val();
                    var matriz=$("#matriz").val();
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: { codigoperiodo: codigoperiodo, action: "getData", entity:entity, iddocente:iddocente, codigoestudiante:codigoestudiante,
                                observacionesregistro_riesgo:observacionesregistro_riesgo, intervencionregistro_riesgo:intervencionregistro_riesgo, 
                                idobs_tiporiesgo:idobs_tiporiesgo, codigoestado:codigoestado, idobs_herramientas_deteccion:idobs_herramientas_deteccion,
                                idobs_registro_riesgo:idobs_registro_riesgo, matriz:matriz
                        },            
                        success:function(data){
                            if (data.success == true){
                                //alert(data.message);
                                $("#idobs_registro_riesgo").val(data.id);
                                sendForminfo();
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
             }
             
             function sendForminfo(){
                    var entity=$("#entity2").val();
                    var idobs_registro_riesgo=$("#idobs_registro_riesgo").val();
                    var codigoestado=$("#codigoestado").val();
                    var nriesgo=$("#nriesgo").val();
                    var riesgo='';
                    for (i=0; i<nriesgo; i++){
                        if($("#idobs_causas_"+i).is(':checked')) { 
                           riesgo+=$("#idobs_causas_"+i).val()+','; 
                        }else{
                           riesgo+='0,'; 
                        }
                    }
                    riesgo = riesgo.substring(0, riesgo.length-1)
                     var conP=''
                     i=0
                    $('input[name="idobs_registro_riesgo_causas[]"]').each(function() { 
                        if ($(this).val()!=''){
                            conP += $(this).val() + ","; 
                        }else{
                            conP +='0,';
                        }
                        i++
                    });
                     conP = conP.substring(0, conP.length-1) 
                     var herr=$("#idobs_herramientas_deteccion").val();
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_arr.php',
                        data: { action: "getData", entity:entity, codigoestado:codigoestado, idobs_registro_riesgo:idobs_registro_riesgo,
                                riesgo:riesgo, conP:conP
                         },            
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                if(herr==4){
                                    $(location).attr('href','../../consulta/estadisticas/riesgos/menuriesgossemestre.php?tipo=R'); 
                                }else if(herr==3){
                                     $(location).attr('href','listar_estudiantes_riesgo_admin.php?tipo2=R'); 
                                }else{
                                    $(location).attr('href','listar_registro_riesgo.php?tipo=R');
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
                
                
</script>
    
<?php    writeFooter();
        ?>  

