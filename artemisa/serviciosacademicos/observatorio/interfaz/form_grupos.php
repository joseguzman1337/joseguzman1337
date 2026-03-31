<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Grupos",true,"PAE",1);
   
   $fun = new Observatorio();
   
   $id_user=$_SESSION['MM_Username'];
   
   $id_doc=''; $id_estu='';
   
  if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("grupos");
    $entity->sql_where = "idobs_grupos = ".str_replace('row_','',$_REQUEST['id'])."";
   // $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $id_doc=$data['iddocente'];
    $id_estu=$data['codigoestudiante'];
  
  }
  
?>
    <script type="text/javascript">
  
      $(document).ready(function(){
        jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera();});
        jQuery("select[name='codigomodalidadacademica1']").change(function(){displayCarrera1();});
      
    	$('#tabs').smartTab({
                    selected: 0,
                    saveState:true,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
	});


    
    
    </script>
    
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_grupos" id="idobs_grupos" value="<?php echo $data['idobs_grupos'] ?>">
        <input type="hidden" name="entity" id="entity" value="grupos" />
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" /> 
        <div id="container" style="margin-left: 70px">
        <div id="tabs">
            <ul>
                
            <li><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Datos del<br />Docente</span></a></li>
            <li><div class="stepNumber">2</div><a href="#tabs-3"><span class="stepDesc">Registro<br />Salas de Aprendisaje</span></a></li>
            </ul>
            <div id="tabs-1">
                <?php 
                   if(!empty($_REQUEST['id']) && empty($id_doc)){
                       echo "Escogio un estudiante Tutor";
                   }else{
                        $fun->busc_docente($db, $id_doc);
                   }
                 ?>
              </div>
                <div id="tabs-3">
                       <table border="0" class="CSSTableGenerator">
                           <tr>
                               <td><label class="titulo_label"><b>Nombre:</b></label></td>
                               <td>
                                    <input type="text" name="nombregrupos" id="nombregrupos" title="Nombre" maxlength="120" placeholder="Nombre" tabindex="1" value="<?php echo $data['nombregrupos']?>" />

                               </td>
                           </tr>
                                        <tr>
                                            <td><label class="titulo_label"><b>Descripci&oacute;n:</b></label></td>
                                        <td colspan="5" >&nbsp;
                                         <div id="Descripcion">
                                                  <textarea style="height: 50px;" cols="76" id="descripciongrupos" tabindex="3" name="descripciongrupos"><?php echo $data['descripciongrupos']; ?></textarea>
                                         </div>
                                         </td>
                                      </tr>
                              </table>
              
                        </div>
        </div>
                   <div class="derecha" >
                        <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                        <button class="submit" type="reset" tabindex="3">Limipar</button>
                        &nbsp;&nbsp;
                        <a href="listar_grupos.php" class="submit" tabindex="4">Regreso al menú</a>
                        
                    </div><!-- End demo -->
        </div>
  </form>
<script type="text/javascript">
      
     
                $(':submit').click(function(event) {
                    event.preventDefault();
                     if(validar()){  
                        sendFormdata();
                        
                    } 
                });
                
                function validar(){
                    if( $.trim($("#iddocente").val())=='' ) {
                                alert("Debe escoger un Docente");
                                return false;
                        }else if($.trim($("#nombregrupos").val())=='') {
                                alert("Debe Digitar el Nombre");
                                 $('#nombregrupos').css('border-color','#F00');
				$('#nombregrupos').effect("pulsate", {times:3}, 500);
                                $("#nombregrupos").focus();
                                return false;
                        }else{
                            return true;
                        }     
                }
                
                     
                function sendFormdata(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),            
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                $(location).attr('href','listar_grupos.php');
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

