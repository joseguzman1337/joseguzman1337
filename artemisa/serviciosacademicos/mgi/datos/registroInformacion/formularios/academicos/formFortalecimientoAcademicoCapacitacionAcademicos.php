<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-7">
<form action="save.php" method="post" id="form_eventos">
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Capacitación a los académicos - Aprendizaje significativo</legend>
                
                <!--<label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php //$utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php //$utils->getYearsSelect("anio");  
                ?>-->
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Capacitación a los académicos - Aprendizaje significativo</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Evento</span></th> 
                            <th class="column" ><span>Fecha terminación</span></th> 
                            <th class="column" ><span>Conferencista</span></th> 
                            <th class="column" ><span>Número de asistentes</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column"> 
                                <input type="hidden" name="aux[]" />
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="evento[]" title="Evento" maxlength="250" tabindex="1" autocomplete="off" value="" size="30" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-6-12 required inputTable dateInput" minlength="1" name="fechaterminacion[]" title="Fecha terminación" maxlength="10" tabindex="1" autocomplete="off" value="" size="10" readonly />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-6-12 required inputTable" minlength="1" name="conferencista[]" title="Conferencista" maxlength="200" tabindex="1" autocomplete="off" value="" size="30" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-11-12 required number" minlength="1" name="numeroasistentes[]" title="Número de asistentes" maxlength="5" tabindex="1" autocomplete="off" value="" size="5" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            <input type="button" class="first small" id="addMoreEventos" value="Agregar otro" style="margin-top:10px">
            <input type="button" class="first small" id="removeEventos" value="Eliminar último" style="margin-top:10px">
                
                <div class="vacio"></div>
                <div id="respuesta_form_eventos" class="msg-success" style="display:none"></div>
            </fieldset>
	    <input type="hidden" name="alias" value="caas" />
            <input type="submit" id="submitEventos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    //getDataEventos("#form_eventos");
   
   $('#addMoreEventos').click(function(event) {
           addTableRow("#form_eventos");
   });
   
   $( "#form_eventos table" ).on("click", '.dateInput', function () {
       var inputDate = $(this);
         //alert("aja");
         //$.datepicker.setDefaults($.datepicker.regional['es']);
         inputDate.datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,
             changeYear: true, maxDate: "+0D"}).focus();
   });
   
   $('#removeEventos').click(function(event) {
       var formName = "#form_eventos";
       var inputName = "input[name='evento[]']";
        removeTableRow(formName,inputName);
   });
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form_eventos");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/academicos/saveFortalecimientoAcademico.php',
				data: $('#form_eventos').serialize(),                
				success:function(data){
				if (data.success == true){
					$('#respuesta_form_eventos').html('<p>' + data.message + '</p>');
					$('#respuesta_form_eventos').removeClass('msg-error');
					$('#respuesta_form_eventos').css('display','block');
                                        $('#respuesta_form_eventos').delay(5500).fadeOut(800);
				} else {
					$('#respuesta_form_eventos').html('<p>' + data.message + '</p>');
					$('#respuesta_form_eventos').addClass('msg-error');
					$('#respuesta_form_eventos').css('display','block');
                                        $('#respuesta_form_eventos').delay(5500).fadeOut(800);
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
                
</script>
