<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

   include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Estudiante<br>Tutor",true,"PAE",1);
    $fun = new Observatorio();
   
  if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("estudiante_tutor");
    $entity->sql_where = "idobs_estudiante_tutor= ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    //print_r($data);
  }
  
  if (!empty($data['codigoestudiante'])){
    $entity2 = new ManagerEntity("estudiantegeneral");
    $entity2->prefix = "";
    $entity2->sql_where = "idestudiantegeneral = ".$data['codigoestudiante']."";
   // $entity->debug = true;
    $data_estudiante = $entity2->getData();
    //$data_estudiante =$data[0];
    //print_r($data);
  }
  $id_estu='';
  
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
        <input type="hidden" name="idobs_estudiante_tutor" id="idobs_estudiante_tutor" value="<?php echo $data['idobs_estudiante_tutor'] ?>">
        <input type="hidden" name="entity" id="entity" value="estudiante_tutor">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" /> 
        <div id="container" style="margin-left: 70px">
        <div class="titulo">B&uacute;scar Estudiante Tutor</div>
        <br>
        <div id="tabs">
            <ul>
            <li><div class="stepNumber">1</div><a href="#tabs-2"><span class="stepDesc">Seleccionar<br />Estudiante Tutor</span></a></li>
           <!-- <li><div class="stepNumber">3</div><a href="#tabs-3"><span class="stepDesc">Registro de<br />Riesgo</span></a></li>-->
            </ul>
           
            <div id="tabs-2" style=' height:300px'>
              
                <?php $fun->estudiante($db, $id_estu); ?>
                
            </div>
        </div>

                   <div class="derecha">
                        <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="listar_registro_riesgo.php" class="submit" tabindex="4">Regreso al menú</a>
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
                    if($.trim($("#codigoestudiante").val())=='') {
                                alert("Debe escoger un Criterio de Busqueda");
                                return false;
                        }else{
                            return true;
                        }     
                }
                
                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                //$(location).attr('href','listar_registro_riesgo.php');
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

