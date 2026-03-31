<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Resultados<br>SaberPro",true,"Saber Pro",1,'Saber Pro Gestion de resultados');
     $fun = new Observatorio();
   $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Saber Pro Gestion de resultados');
   
  if (!empty($_REQUEST['idestudiante'])){
    $entity = new ManagerEntity("estudiante_competencia");
    $entity->sql_where = "codigoestudiante= ".$_REQUEST['idestudiante']."";
    //$entity->debug = true;
    $data = $entity->getData();
    //print_r($data);
  }
  
  $id_estu=$_REQUEST['idestudiante'];
  
?>
<script type="text/javascript">
    $(document).ready(function () {
        jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera();});
        
         $('#buttons').akordeon();
    });
        
   
    $(document).ready(function(){
    	// Smart Tab
  		$('#tabs').smartTab({
                    selected: 0,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
	});
     
    
</script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_estudiante_competencia" id="idobs_estudiante_competencia" value="<?php echo $data['idobs_estudiante_competencia'] ?>">
        <input type="hidden" name="entity" id="entity" value="estudiante_competencia">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" /> 
        <div id="container" style="margin-left: 70px">
        <div id="tabs">
            <ul>
            <li><div class="stepNumber">1</div><a href="#tabs-2"><span class="stepDesc">Seleccionar<br />Estudiante</span></a></li>
            <li><div class="stepNumber">2</div><a href="#tabs-3"><span class="stepDesc">Competencias</span></a></li>
            </ul>
            <div id="tabs-2" style=' height:300px'>
              
                <?php 
                    
                 $idestu=$fun->estudiantesimple($db, $id_estu, $pro); 
                // echo $idestu.'-->>';
                ?>
                
            </div>
            <div id="tabs-3" >
                <?php 
                    $sql="SELECT * FROM obs_competencias WHERE codigoestado=100 ";
                    $reg_com =$db->Execute($sql);
                    $i=0;
                    ?>
                    <table border="0" width="100%" class="CSSTableGenerator">
                        <tr>
                            <td><center><b>Competencia Gen&eacute;rica</b></center></td>
                            <td><center><b>Puntaje</b></center></td>
                            <td><center><b>Nivel</b></center></td>
                            <td><center><b>Quintil</b></center></td>
                        </tr>
                        <?php
                        foreach($reg_com as $dt){
                            ?>
                        <tr>
                            <td><?php echo $dt['nombrecompetencia'] ?>
                                <input type="hidden" name="idobs_competencia[]" id="idobs_competencia" value='<?php echo $dt['idobs_competencias'] ?>' />
                                <input type="hidden" name="idobs_estudiante_competencia[]" id="idobs_estudiante_competencia" value='<?php echo $data[$i]['idobs_estudiante_competencia'] ?>' />
                            </td>
                            <td><input type="text" name="puntaje[]" id="puntaje" value='<?php echo $data[$i]['puntaje'] ?>' /></td>
                            <td><input type="text" name="nivel[]" id="nivel" value='<?php echo $data[$i]['nivel'] ?>' /></td>
                            <td><input type="text" name="quintil[]" id="quintil" value='<?php echo $data[$i]['quintil'] ?>' /></td>
                        </tr>
                            <?php
                            $i++;
                        }
                    ?>
                    </table>
             </div>
        </div>

                   <div class="derecha">
                       <?php if ($roles['editar']==1){?>
                        <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                       <?php } ?>
                        <a href="listar_estudiantes_saberpro.php" class="submit" tabindex="4">Regreso al menú</a>
                    </div><!-- End demo -->
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
                        i=0;
                      $('input[name="puntaje[]"]').each(function() {                     
                        if($.trim($(this).val())==''){
                             alert("Debe digitar el puntaje")
                               $(this).css('outline','1px solid #F00');
			       $(this).effect("pulsate", {times:3}, 500);
                               $(this).focus();
                               i++;
                        }
                    });
                       j=0;
                      $('input[name="nivel[]"]').each(function() {                     
                        if($.trim($(this).val())==''){
                             alert("Debe digitar el nivel")
                               $(this).css('outline','1px solid #F00');
			       $(this).effect("pulsate", {times:3}, 500);
                               $(this).focus();
                               j++;
                        }
                    });
                       z=0;
                      $('input[name="quintil[]"]').each(function() {                     
                        if($.trim($(this).val())==''){
                             alert("Debe digitar el quintil")
                               $(this).css('outline','1px solid #F00');
			       $(this).effect("pulsate", {times:3}, 500);
                               $(this).focus();
                               z++;
                        }
                    });
                    
                    if(i>0){
                        return false
                    }else if(j>0){
                        return false
                    }else if(z>0){
                        return false
                    }else{
                        return true
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
                                $(location).attr('href','listar_estudiantes_saberpro.php');
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

