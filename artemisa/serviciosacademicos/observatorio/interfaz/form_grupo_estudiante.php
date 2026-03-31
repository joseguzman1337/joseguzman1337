<?PHP 
error_reporting(E_ALL);
ini_set('display_errors', '1');

  include("../templates/templateObservatorio.php");
   include("funciones.php");
   $db =writeHeader("Asignar<br>S. Aprendizaje",true,"PAE",1,'Administracion de salas de aprendizaje');
   $fun = new Observatorio();
   $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Administracion de salas de aprendizaje'); 
    // print_r($_SESSION);die;
  
?>
    <script type="text/javascript">
         $(document).ready(function(){
        jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera();});
        jQuery("select[name='idobs_grupos']").change(function(){ jQuery("#EstudianteAjax").css('display', 'none');});
        
         
    	$('#tabs').smartTab({
                    selected: 0,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
            });
            
        
    function ver(){    
        var numero=$("#numero").val();
        var mod=jQuery("select[name='codigomodalidadacademica']").val();
        var prog=jQuery("select[name='codigocarrera']").val();
        var sala=jQuery("select[name='idobs_grupos']").val();
        var ajaxLoader = "<img src='../img/ajax-loader.gif' alt='loading...' />";           
        var esta=0;
       // alert (Periodo);

        if (mod!='' && prog==''){
            alert("Debe escoger la carrera");
                 $('#codigocarrera').css('border-color','#F00');
                 $('#codigocarrera').effect("pulsate", {times:3}, 500);
                 $("#codigocarrera").focus();
        }else{
            if (sala==''){
                alert("Debe escoger la sala de aprendizaje");
                 $('#idobs_grupos').css('border-color','#F00');
                 $('#idobs_grupos').effect("pulsate", {times:3}, 500);
                 $("#idobs_grupos").focus();
            }else{
                 jQuery("#EstudianteAjax")
                .html(ajaxLoader)
                .load('generaestudiante_grupos.php', {identificacion:numero, modalidad:mod, codigocarrera:prog, sala:sala}, function(response){					
                if(response) {
                            jQuery("#EstudianteAjax").css('display', '');   
                            jQuery("#EstudianteAjax2").css('display', 'none');                    
                    } else {                    
                        jQuery("#EstudianteAjax").css('display', 'none'); 
                        jQuery("#EstudianteAjax2").css('display', '');                    
                    }
                });
            }
        }
     }	     
        
    </script>
    <style>
	.selec{width:350px;margin:0 0 50px 0;border:1px solid #ccc;padding:10px;border-radius:10px 0 0 10px;}
	.sel{float:left;width:360px;text-align:center}
        .sel1{float:left;width:200px;text-align:center}
	.izq{border-radius:10px 0 0 10px;}
	.der{border-radius:0 10px 10px 0;}
	</style>
     <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_estudiantes_grupos_riesgo" id="idobs_estudiantes_grupos_riesgo" value="<?php echo $data5['idobs_estudiantes_grupos_riesgo'] ?>">
         <input type="hidden" name="entity" id="entity" value="estudiantes_grupos_riesgo">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $_SESSION['codigoperiodosesion'] ?>" />
           
        <div id="container" style="margin-left: 70px;">
        <div id="tabs">
                <ul>
                <li style="width: 165px"><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Grupos - Estudiante</span></a></li>
                 </ul>
                <div id="tabs-1">
                    <table class="CSSTableGenerator">
                        <tr>
                            <td><label class="titulo_label"><b>Modalidad Acad&eacute;mica:</b></label></td>
                            <td><?php
                                            $query_programa = "SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                            $reg_programa =$db->Execute($query_programa);
                                            echo $reg_programa->GetMenu2('codigomodalidadacademica','',true,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                     ?>
                            </td>
                            <td><label class="titulo_label"><b>Programa:</b></label></td>
                            <td colspan="3"><div  id="carreraAjax" style="display: none;"></div></td>
                       </tr>
                       <tr>
                            <td>Sala de Aprendizaje</td>
                            <td colspan="3"><?php
                                            $query_grupo = "SELECT nombregrupos, idobs_grupos FROM obs_grupos";
                                            $reg_grupo =$db->Execute($query_grupo);
                                            echo $reg_grupo->GetMenu2('idobs_grupos','',true,false,1,' id=idobs_grupos  style="width:150px;"');
                                  ?></td>
                        </tr>
                       <tr>
                            <td><label class="titulo_label"><b>Numero de Documento:</b></label></td>
                        <td><input type="texto" name="numero" id="numero" /></td> 
                        <td>Buscar Estudiantes</td>
                        <td><button type="button" id="buscar_estu" onclick="ver()"><img src="../img/lupa.png" height="25" width="25"  /></button></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4" style=" height:180px;" >
                                    <div id="EstudianteAjax" style=" height:auto;">
                            
                                   </div>
                                   <div id="EstudianteAjax2" style="display: none">
                            
                                   </div>
                            </td>
                        </tr>
                    </table>
                </div>
         </div>
          <div class="derecha">
              <?php if ($roles['editar']==1 ){?>
                       <button class="submit" type="submit" tabindex="3">Guardar</button>
                        &nbsp;&nbsp;
              <?PHP } ?>
                        <!--<a href="listar_registro_riesgo.php?tipo=S" class="submit" tabindex="4">Regreso al menú</a>-->
                        <a href="listar_grupos.php" class="submit" tabindex="4">Regreso al menú</a>
          </div>
            
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
                     var i=0;
                     jQuery("select[name='destino[]']").each(function() {
                         //alert($(this).val()+'-->');
                         if($(this).val()==''){
                                   i++;
                         }
                     });
                     
                     if($.trim($("#idobs_grupos").val())=='') {
                                alert("Debe Escoger el grupo");
                                 $('#idobs_grupos').css('border-color','#F00');
				 $('#idobs_grupos').effect("pulsate", {times:3}, 500);
                                 $("#idobs_grupos").focus();
                                return false;
                        }else if(i>0) {
                                  alert("Debe Escoger al menos un estudiante");
                                 $('#destino').css('border-color','#F00');
				 $('#destino').effect("pulsate", {times:3}, 500);
                                 $("#destino").focus();
                                 return false;
                        }else{
                            return true;
                        }     
                }
                
                     
                function sendFormdata(){
                       jQuery("select[name='destino[]']").each(function() {
                           $('#destino option').prop('selected', 'selected');
                        });
                
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_arr.php',
                        data: $('#form_test').serialize(),            
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                //$(location).attr('href','listar_grupos.php');
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

