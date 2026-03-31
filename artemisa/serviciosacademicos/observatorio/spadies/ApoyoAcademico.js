function BuscarPrograma(){
    
    var Modalidad_id        = $('#Modalidad_id').val();
    
    if(Modalidad_id=='-1' || Modalidad_id==-1){
        /**************************************************/
        alert('Selecione un Tipo Modalidad.');
        $('#Modalidad_id').effect("pulsate", {times:3}, 500);
        $('#Modalidad_id').css('border-color','#F00');
        $('#Programa_id').val('-1');
        return false; 
        /**************************************************/
    }//if
    
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'ApoyoAcademico_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID: 'BuscarProgram',Modalidad_id:Modalidad_id}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	  success: function(data){
    			$('#DivPrograma').html(data);
    		}//data 
      }); //AJAX
    
}//function BuscarPrograma
function AutocompletarEstudiante(){
    
    var Periodo_id      = $('#Periodo_id').val();
    var Programa_id     = $('#Programa_id').val();
    
    
    if(Programa_id=='-1' || Programa_id==-1){
        /**************************************************/
        alert('Selecione un Programa.');
        $('#Programa_id').effect("pulsate", {times:3}, 500);
        $('#Programa_id').css('border-color','#F00');
        return false; 
        /**************************************************/
    }
    
    
    $('#Estudiante').autocomplete({
					
			source: "ApoyoAcademico_html.php?actionID=AutocompletarEstudiante&Periodo_id="+Periodo_id+"&Programa_id="+Programa_id,
			minLength: 3,
			select: function( event, ui ) {
				
				$('#NumDocumento').val(ui.item.NumeroDocumento);
                $('#id_estudiantegeneral').val(ui.item.idEstudianteGeneral);
                $('#codigoestudiante').val(ui.item.CodigoEstudiante);
                
				}
			
		});
    
}//function AutocompletarEstudiante
function Format(){
    $('#Estudiante').val('');
    $('#NumDocumento').val('');
    $('#id_estudiantegeneral').val('');
    $('#codigoestudiante').val('');
}//function Format
function AutocompleteDocumento(){
    
    var Programa_id     = $('#Programa_id').val();
    
    
    if(Programa_id=='-1' || Programa_id==-1){
        /**************************************************/
        alert('Selecione un Programa.');
        $('#Programa_id').effect("pulsate", {times:3}, 500);
        $('#Programa_id').css('border-color','#F00');
        return false; 
        /**************************************************/
    }
    
    
    $('#NumDocumento').autocomplete({
					
			source: "ApoyoAcademico_html.php?actionID=AutocompleteDocumento&Programa_id="+Programa_id,
			minLength: 3,
			select: function( event, ui ) {
				
				$('#Estudiante').val(ui.item.NombreEstudiante);
                $('#id_estudiantegeneral').val(ui.item.idEstudianteGeneral);
                $('#codigoestudiante').val(ui.item.CodigoEstudiante);
                
				}
			
		});
        
}//function AutocompleteDocumento
function Save(){
    /*************************************************/
    
    var Modalidad_id        = $('#Modalidad_id').val();
    var Periodo_id          = $('#Periodo_id').val();
    var Programa_id         = $('#Programa_id').val();
    var codigoestudiante    = $('#codigoestudiante').val();
    var TipoApoyo           = $('#TipoApoyo').val();
    var Descripcion         = $('#Descripcion').val();
    
    /*************************************************/
    if(Modalidad_id=='-1'  || Modalidad_id==-1){
       /**************************************************/
        alert('Selecione un Tipo Modalidad.');
        $('#Modalidad_id').effect("pulsate", {times:3}, 500);
        $('#Modalidad_id').css('border-color','#F00');
        $('#Programa_id').val('-1');
        return false; 
        /**************************************************/  
    }
    
    if(Programa_id==-1 || Programa_id=='-1'){
        /**************************************************/
        alert('Selecione una Carrera o Programa.');
        $('#Programa_id').effect("pulsate", {times:3}, 500);
        $('#Programa_id').css('border-color','#F00');
        $('#Programa_id').val('-1');
        return false; 
        /**************************************************/ 
    }
    
    if(!$.trim(codigoestudiante)){
        /**************************************************/
        alert('Busque o Digite el nombre o Numero de documento del estudiante');
        $('#Estudiante').effect("pulsate", {times:3}, 500);
        $('#Estudiante').css('border-color','#F00');
        $('#Estudiante').val('');
        $('#NumDocumento').effect("pulsate", {times:3}, 500);
        $('#NumDocumento').css('border-color','#F00');
        $('#NumDocumento').val('');
        $('#id_estudiantegeneral').val('');
        $('#codigoestudiante').val('');
        return false; 
        /**************************************************/ 
    }
    if(TipoApoyo==-1 || TipoApoyo=='-1'){
        /**************************************************/
        alert('Selecione un Tipo de Apoyo Academico.');
        $('#TipoApoyo').effect("pulsate", {times:3}, 500);
        $('#TipoApoyo').css('border-color','#F00');
        $('#TipoApoyo').val('-1');
        return false; 
        /**************************************************/ 
    }
    /*************************************************/
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'ApoyoAcademico_html.php',
    	  async: false,
    	  dataType: 'json',
    	  data:({actionID: 'Save',Modalidad_id:Modalidad_id,
                                  Periodo_id:Periodo_id,
                                  Programa_id:Programa_id,
                                  codigoestudiante:codigoestudiante,
                                  TipoApoyo:TipoApoyo,
                                  Descripcion:Descripcion}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	  success: function(data){
    			if(data.val=='FALSE'){
    			     alert(data.descrip);
                     return false;
    			}else{
    			     alert('Se ha Guardado Correctamente...');
                     location.href='ApoyoAcademico_html.php';
    			}
    		}//data 
      }); //AJAX
    /*************************************************/
}//function Save