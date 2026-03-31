/**** JAVASCRIPT ****/

/* FUNCIONES GLOBALES */
$(document).ready(function(){
	$('#bloque').change(function(){
		var bloque = $(this).val();
		$.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'cargar_aula',
                bloque:bloque
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
				var imprimir = '<option value="0">Seleccione...</option>';
				var id_aula = data.id_aula;
				var nombre_aula = data.nombre_aula;
				$.each(id_aula, function(index, value){
					imprimir = imprimir + '<option value="'+id_aula[index]+'">'+nombre_aula[index]+'</option>';
				});				
				$('#aula').html(imprimir);
				$('#aula').removeAttr('disabled');
			}
		});
	});
	
	$('#aula').change(function(){
		var aula = $(this).val();
		$.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'cargar_datos',
                aula:aula
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
				if(data.AsignacionEspaciosId != null){
					var obs = '';
					if(!typeof value === "undefined"){
						obs = data.Observacion;
					}
					$('#content').html('<fieldset id="cuadro1">\
						<div class="fieldset-left"><input type="hidden" name="AsignacionEspaciosId" id="AsignacionEspaciosId" value="'+data.AsignacionEspaciosId+'">\
						<input type="hidden" name="LogMonitoreoEspacioFisicoId" id="LogMonitoreoEspacioFisicoId" value="'+data.LogMonitoreoEspacioFisicoId+'">\
						<input type="hidden" name="nuevo" id="nuevo" value="'+data.nuevo+'">\
						<input type="hidden" name="AsignacionEspaciosNoAsignadosId" id="AsignacionEspaciosNoAsignadosId" value="'+data.AsignacionEspaciosNoAsignadosId+'">\
						<b>Docente:</b> '+data.Responsable+' <br />\
						<b>Materia:</b> '+data.nombremateria+' <br />\
						<b>Grupo:</b> '+data.nombregrupo+' <br />\
						<b>Hora Inicial:</b> '+data.HoraInicio+' <br />\
						<b>Hora Final:</b> '+data.HoraFin+' <br />\
						<b>Ultima modificacion:</b> '+data.UltimaModificacion+'<br /></div>\
						<div class="fieldset-right"><b>Aula ocupada:</b> <input type="radio" name="ocupado" value="1">Si<input type="radio" name="ocupado" value="0">No<br />\
						<b>Observaciones:</b><br>\
						<textarea cols="45" class="observacion" name="observacion">'+obs+'</textarea></div>\
						<div align="center" class="boton-guardar"><input type="button" value="Guardar" id="guardar" class="boton" /></div>\
					</fieldset>');
				}else{
					var obs = '';
					if(!typeof value === "undefined"){
						obs = data.Observacion;						
					}
					$('#content').html('<fieldset id="cuadro1">\
						<div class="fieldset-left"><input type="hidden" name="AsignacionEspaciosId" id="AsignacionEspaciosId" value="'+data.AsignacionEspaciosId+'">\
						<input type="hidden" name="LogMonitoreoEspacioFisicoId" id="LogMonitoreoEspacioFisicoId" value="'+data.LogMonitoreoEspacioFisicoId+'">\
						<input type="hidden" name="nuevo" id="nuevo" value="'+data.nuevo+'">\
						<input type="hidden" name="AsignacionEspaciosNoAsignadosId" id="AsignacionEspaciosNoAsignadosId" value="'+data.AsignacionEspaciosNoAsignadosId+'">\
						<b>Docente:</b> No asignado <br />\
						<b>Materia:</b> No asignada <br />\
						<b>Grupo:</b> No asignado <br />\
						<b>Hora Inicial:</b> N/A <br />\
						<b>Hora Final:</b> N/A <br />\
						<b>Ultima modificacion:</b> N/A <br /></div>\
						<div class="fieldset-right"><b>Aula ocupada:</b> <input type="radio" name="ocupado" value="1">Si<input type="radio" name="ocupado" value="0">No<br />\
						<b>Observaciones:</b><br>\
						<textarea cols="45" class="observacion" name="observacion">'+obs+'</textarea></div>\
						<div align="center" class="boton-guardar"><input type="button" value="Guardar" id="guardar" class="boton" /></div>\
					</fieldset>');
				}
			}
		});
	});
	/*@modified Diego Rivera <riveradiego@unbosque.edu.co>
         *Se cambia evento live por on debido a que evento live ya se encuentra deprecate
         *@since November 29,2018 
         */
	$( "input#guardar" ).on( "click", function() {
		var AsignacionEspaciosId = $('#AsignacionEspaciosId').val();
		var nuevo = $('#nuevo').val();
		var ocupado = $('input:radio[name=ocupado]:checked').val();
		var observacion = $('#observacion').val();
		var LogMonitoreoEspacioFisicoId = $('#LogMonitoreoEspacioFisicoId').val();
		var aula = $('#aula').val();
		var AsignacionEspaciosNoAsignadosId = $('#AsignacionEspaciosNoAsignadosId').val();
		var usuario = $('#usuario').val();
		$.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'guardar_datos',
                aula:aula,
				AsignacionEspaciosId:AsignacionEspaciosId,
				nuevo:nuevo,
				ocupado:ocupado,
				observacion:observacion,
				LogMonitoreoEspacioFisicoId:LogMonitoreoEspacioFisicoId,
				AsignacionEspaciosNoAsignadosId:AsignacionEspaciosNoAsignadosId,
				usuario:usuario
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
				alert(data.mensaje);
			}
		});
	});
	
	/*$("#content").on("click", "input#guardar", function (){
		var AsignacionEspaciosId = $('#AsignacionEspaciosId').val();
		var nuevo = $('#nuevo').val();
		var ocupado = $('#ocupado').val();
		var observacion = $('#observacion').val();
		var LogMonitoreoEspacioFisicoId = $('#LogMonitoreoEspacioFisicoId').val();
		var aula = $('#aula').val();
		var AsignacionEspaciosNoAsignadosId = $('#AsignacionEspaciosNoAsignadosId').val();
		$.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'guardar_datos',
                aula:aula,
				AsignacionEspaciosId:AsignacionEspaciosId,
				nuevo:nuevo,
				ocupado:ocupado,
				observacion:observacion,
				LogMonitoreoEspacioFisicoId:LogMonitoreoEspacioFisicoId,
				AsignacionEspaciosNoAsignadosId:AsignacionEspaciosNoAsignadosId
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
				alert(data.mensaje);
			}
		});
	});*/
});