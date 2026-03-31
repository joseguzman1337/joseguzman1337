<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Resultados Nac<br>SaberPro",true,"Saber Pro",1,'Saber Pro Gestion de resultados nacionales');
    $fun = new Observatorio();
   $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Saber Pro Gestion de resultados nacionales');
  if (!empty($_REQUEST['periodo'])){
    $entity = new ManagerEntity("competencias_nacional");
    $entity->sql_where = "codigoperiodo= ".$_REQUEST['periodo']."";
    //$entity->debug = true;
    $data = $entity->getData();
    //print_r($data);
  }
  
  $anioI=  date('Y')-10;
?>
<script type="text/javascript">
    $(document).ready(function () {
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
        <input type="hidden" name="idobs_competencias_nacional" id="idobs_competencias_nacional" value="<?php echo $data['idobs_competencias_nacional'] ?>">
        <input type="hidden" name="entity" id="entity" value="competencias_nacional">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <div id="container" style="margin-left: 70px">
        <div id="tabs">
            <ul>
            <li><div class="stepNumber">2</div><a href="#tabs-3"><span class="stepDesc">Competencias</span></a></li>
            </ul>
            <div id="tabs-3" >
                <?php 
                    $sql="SELECT * FROM obs_competencias WHERE codigoestado=100 ";
                    $reg_com =$db->Execute($sql);
                    $i=0;
                    ?>
                    <table border="0" width="100%" class="CSSTableGenerator">
                        <tr>
                        <td><label class="titulo_label"><b>Periodo:</b></label></td>
                        <td> 
                        <select name="codigoperiodo" id="codigoperiodo">
                            <option value=''>-Seleccione-</option>
				<?php
				for($anio=(date("Y")); $anioI<=$anio; $anio--) {
                                        echo "<option value=".$anio." ";
                                        if ($data[0]['codigoperiodo']==$anio) echo "selected";
                                        echo " >".$anio."</option>";
				}
				?>
			</select> 
                        </td>
                     
                    </tr>
                        <tr>
                            <td><center><b>Competencia Gen&eacute;rica</b></center></td>
                            <td><center><b>Puntaje</b></center></td>
                        </tr>
                        <?php
                        foreach($reg_com as $dt){
                            ?>
                        <tr>
                            <td><?php echo $dt['nombrecompetencia'] ?>
                                <input type="hidden" name="idobs_competencia[]" id="idobs_competencia" value='<?php echo $dt['idobs_competencias'] ?>' />
                                <input type="hidden" name="idobs_competencias_nacional[]" id="idobs_competencias_nacional" value='<?php echo $data[$i]['idobs_competencias_nacional'] ?>' />
                            </td>
                            <td><input type="text" name="puntaje[]" id="puntaje" value='<?php echo $data[$i]['puntaje'] ?>' /></td>
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
                        <a href="listar_nacionales_saberpro.php" class="submit" tabindex="4">Regreso al menú</a>
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

                    
                    if(i>0){
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
                                //$(location).attr('href','listar_nacionales_saberpro.php');
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

