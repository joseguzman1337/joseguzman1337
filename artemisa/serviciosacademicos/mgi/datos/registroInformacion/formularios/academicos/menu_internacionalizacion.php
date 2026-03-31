<?PHP 
session_start();
require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
	
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

?>
<form action="" method="post" id="form_est">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Internacionalización Estudiantes</legend>
		<div class="formModalidad">
                     <?php 
                     $rutaModalidad = "./_elegirProgramaAcademico.php";
                                        if(!is_file($rutaModalidad)){
                                               $rutaModalidad = './formularios/academicos/_elegirProgramaAcademico.php';
                                        }
                                       include($rutaModalidad);
                                       
                     //include("./formularios/academicos/_elegirProgramaAcademico.php"); ?>                     
                </div>
                
		<input type="hidden" name="alias" value="<?PHP echo $_REQUEST['alias']?>" />
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form_est");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: '<?php echo $url; ?>formularios/academicos/viewFortalecimientoAcademico2.php',
				async: false,
				data: $('#form_est').serialize(),                
				success:function(data){
					$('#respuesta_form').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
	
	$(document).on('change', "#form_est #modalidad", function(){
                    getCarreras("#form_est");
                    changeFormModalidad("#form_est");
                });
                
                $(document).on('change', "#form_est #unidadAcademica", function(){                    
                    changeFormModalidad("#form_est");
                });
                
                
          function changeFormModalidad(formName){
                    var mod = $(formName + ' #modalidad').val();
                    var carrera = $(formName + ' #unidadAcademica').val();
                    $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: './_elegirProgramaAcademico.php',
                                data: { modalidad: mod, carrera: carrera, action: "setSession" },     
                                success:function(data){
                                     $(".formModalidad").load('./_elegirProgramaAcademico.php'); 
                                     //cuando acabe todos los load por ajax
                                     $(document).bind("ajaxStop", function() {
                                        $(this).unbind("ajaxStop"); //esto es porque sino queda en ciclo infinito por lo que vuelvo a llamar un ajax
                                        actualizarDataPrograma();
                                    });                         
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                     });  
                }
                
                
                function getCarreras(formName){
                    $(formName + " #unidadAcademica").html("");
                    $(formName + " #unidadAcademica").css("width","auto");   
                        
                    if($(formName + ' #modalidad').val()!=""){
                        var mod = $(formName + ' #modalidad').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForCareersByModalidadSIC.php',
                                data: { modalidad: mod },     
                                success:function(data){
                                     var html = '<option value="" selected></option>';
                                     var i = 0;
                                        while(data.length>i){
                                            html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
                                            i = i + 1;
                                        }                                    
                            
                                        $(formName + " #unidadAcademica").html(html);
                                        $(formName + " #unidadAcademica").css("width","500px");     
                                        //$(".formProgramaAcademico").html($(formName + " .formProgramaAcademico").html());                                   
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
                    }
                }
                
               
</script>
