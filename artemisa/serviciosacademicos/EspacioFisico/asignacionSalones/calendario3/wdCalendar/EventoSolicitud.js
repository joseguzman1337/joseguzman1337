function AvilitarFormulario(num){
     /*************************************************/
    if($('#AvilitarUnico').is(':checked')){ 
        if(num==1){
            $('#BuscarUnico').css('display','inline');
            $('#BuscarMultiple').css('display','none');
            $('#AvilitarMultiple').attr('disabled',true);
            $('#AvilitarUnico').attr('disabled',false);
            $('#FechaIni').val('');
            $('#FechaFin').val('');
            $('.Hora_1').val('');
            $('.Hora_2').val(''); 
            $('.DiaChekck').attr('checked',false);
            $('#DivDisponibilidadMultiple').html('');
          }
    }else if($('#AvilitarMultiple').is(':checked')){
        if(num==2){
            $('#BuscarMultiple').css('display','inline');
            $('#BuscarUnico').css('display','none');
            $('#AvilitarMultiple').attr('disabled',false);
            $('#AvilitarUnico').attr('disabled',true);
            $('#FechaUnica').val('');
            $('#HoraInicial_unica').val('');
            $('#HoraFin_unica').val(''); 
            $('#DivDisponibilidad').html('');
          }
    }else{
        $('#AvilitarMultiple').attr('disabled',false);
        $('#AvilitarUnico').attr('disabled',false);
        $('#BuscarUnico').css('display','none');
        $('#BuscarMultiple').css('display','none');
    }
    /*************************************************/
}

function BuscarMateria(){
    /***********************************************/
    var Programa = $('#Programa').val();
    
    if(Programa==-1 || Programa=='-1'){
        /******************************************************/
        $('#Programa').effect("pulsate", {times:3}, 500);
        $('#Programa').css('border-color','#F00');
        return false;
        /******************************************************/ 
     }
    
       $('#MateriaText').autocomplete({
					
            source: "../asignacionSalones/calendario3/wdCalendar/EventoSolicitud.php?actionID=AutoMateria&Programa="+Programa,
            minLength: 2,
            select: function( event, ui ) {
                    $('#Materia').val(ui.item.id);
                    BuscarGrupo();
                    
            }                
        });
    /***********************************************/
}//function BuscarMateria
function BuscarGrupo(){
    /***********************************************/
    var Programa = $('#Programa').val();
    var Materia = $('#Materia').val();
    
    
     if(Programa==-1 || Programa=='-1'){
        /******************************************************/
        $('#Programa').effect("pulsate", {times:3}, 500);
        $('#Programa').css('border-color','#F00');
        $('#Materia').val('-1');
        $('#Grupo').val('-1'); 
        return false;
        /******************************************************/ 
     }
     
      if(Materia==-1 || Materia=='-1'){
        /******************************************************/
        $('#Materia').effect("pulsate", {times:3}, 500);
        $('#Materia').css('border-color','#F00');
        $('#Grupo').val('-1'); 
        return false;
        /******************************************************/ 
     }
       /*$('#GrupoText').autocomplete({
					
            source: "../asignacionSalones/calendario3/wdCalendar/EventoSolicitud.php?actionID=AutoGrupo&Programa="+Programa+"&Materia="+Materia,
            minLength: 2,
            select: function( event, ui ) {
                    $('#GrupoText').val(ui.item.value);
                    $('#Grupo').val(ui.item.id);
                    $('#NumEstudiantes').val(ui.item.Max);
                    HorarioGrupo(ui.item.id);
            }                
        });*/
        
         $.ajax({//Ajax
    		   type: 'POST',
    		   url: '../asignacionSalones/calendario3/wdCalendar/EventoSolicitud.php',
    		   async: false,
    		   dataType: 'html',
    		   data:({actionID: 'AutoGrupo',Programa:Programa,Materia:Materia,OP:'Multiple'}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		   success: function(data){
    					
    					$('#Th_Grupo').html(data);
                       
    							
    		   } 
    	}); //AJAX
    /***********************************************/
}//function BuscarGrupo
function NumGroup(){
    var Data = $('#GrupoText').val();
    var C_Data = Data.split('::');
    $('#Grupo').val(C_Data[0]);
    $('#NumEstudiantes').val(C_Data[1]);
     HorarioGrupo(C_Data[0]);
}//function NumGroup

function AddNumGrupo(id,cupo,name,Op=''){
    
    var Num = $('#NumEstudiantes').val();
    
    if(Num==undefined || Num==''){
            var Num = 0;
        }
    
    if($('#GrupoText_'+id).is(':checked')){
        var Total = parseInt(Num)+parseInt(cupo);
        var fullname = name+id;
        if(Op==1){
            var Id_Eliminar = $('#GruposEliminar').val();
            
            var Dato = '::'+id;
            
            var Result = Id_Eliminar.replace(Dato,"");
            
            $('#GruposEliminar').val(Result);
        }
        
       var MultiGrupoMateria = $('#MultiGrupoMateria').val();
    
        $.ajax({//Ajax
    		   type: 'POST',
    		   url: '../Interfas/InterfazSolicitud_html.php',
    		   async: false,
    		   dataType: 'json',
    		   data:({actionID: 'ValidaGrupoAdd',MultiGrupoMateria:MultiGrupoMateria,id:id}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		   success: function(data){
    			    if(data.val==false){
    			     alert(data.descrip);
                     return false;
    			    }else{
    			     /*****************************************************/
                        $('#MultiGrupoMateria').val($('#MultiGrupoMateria').val()+'::'+id);
                    /*****************************************************/
    			    }		
    		   } 
    	}); //AJAX
        
         VerHorario(id,fullname);
         
         HorarioGrupo(id);  
         
    }else{
        var Total = parseInt(Num)-parseInt(cupo);
        
        var Id_Eliminar = $('#GruposEliminar').val();
        
        var Dato = Id_Eliminar+'::'+id;
        
        $('#GruposEliminar').val(Dato);
    }
    
     $('#NumEstudiantes').val(Total);
   
   VerMultiGrupoMateriaView();
   
     
}//function AddNumGrupo
function VerMultiGrupoMateriaView(){
    
    var MultiGrupoMateria = $('#MultiGrupoMateria').val();
    
    $.ajax({//Ajax
		   type: 'POST',
		   url: '../Interfas/InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'ViewMultiGrupoMateria',MultiGrupoMateria:MultiGrupoMateria}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
			     $('#GrupoMateria_Div').html(data);				
		   } 
	}); //AJAX
}//function VerMultiGrupoMateriaView
function RerstGrupoMateria(idGrupo){
    if(!$('#Grupo_'+idGrupo).is(':checked')){
        
             var Id_Eliminar = $('#MultiGrupoMateria').val();
            
            var Dato = '::'+idGrupo;
            
            var Result = Id_Eliminar.replace(Dato,"");
            
            $('#MultiGrupoMateria').val(Result);
    }
    
    VerMultiGrupoMateriaView();
}//function RerstGrupoMateria
function VerHorario(id,name){ 
    
   $.ajax({//Ajax
		   type: 'POST',
		   url: '../Interfas/InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'VerHorario',id:id}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#'+name).html(data);
                    $('#'+name).dialog();
							
		   } 
	}); //AJAX
}//function VerHorario


function HorarioGrupo(Grupo_id){
    
     $.ajax({//Ajax
		   type: 'POST',
		   url: '../Interfas/InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'HorarioGrupo',Grupo_id:Grupo_id}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#Div_Horario').html(data)
							
		   } 
	}); //AJAX
}//
function AddTr(){
    /*********************************************************/
    	var TblMain    =  document.getElementById("TablaHorario");
    	var NumFiles   =  parseFloat($('#numIndices').val()) + 1;
    	var NewTr      =  document.createElement("tr");
    	NewTr.id       =  'trNewDetalle'+NumFiles;
    	
    	TblMain.appendChild(NewTr);
        
        $('#numIndices').val(NumFiles);  
        
        $.ajax({//Ajax
          type: 'POST',
          url: '../Interfas/InterfazSolicitud_html.php',
          async: false,
          dataType: 'html',
          data:({actionID: 'AddTr',NumFiles:NumFiles}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
                $('#trNewDetalle'+NumFiles).html(data);
        	}//data 
        }); //AJAX
    /*********************************************************/
}//function AddTr
function DeleteTr(){
    /***********************************************************/
    var NumFiles   =  parseFloat($('#numIndices').val());
    
    if(NumFiles>0){
    
        $('#trNewDetalle'+NumFiles).remove();
        
        $('#numIndices').val(NumFiles-1);
        
    }
    /***********************************************************/
}//function DeleteTr

function BuscarDisponibilidadMultiple(){
    /****************************************************/
    
   
    
    
   // $('#DivDisponibilidadMultiple').html('<img src="../../../../mgi/images/engranaje-09.gif" width="90" />');
   // 
//    $.ajax({//Ajax
//      type: 'POST',
//      url: 'EventoSolicitud.php',
//      async: false,
//      dataType: 'html',
//      data:$('#SolicitudEspacio').serialize(),
//      error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
//      success: function(data){
//           if(data.IsSuccess==false){
//                    alert(data.Msg)
//                }else{
//                    $('#DivDisponibilidadMultiple').html('');
//                    $('#DivDisponibilidadMultiple').html(data);
//                }
//    	}//data 
//            
//    });
    /****************************************************/
}//function BuscarDisponibilidadMultiple
function Inavilita(clase,id,oculto,valor){
    /*******************************************************/
    if($('#AulaSelecionada_'+id).is(':checked')){
         $('.'+clase).attr('disabled',true);
         $('#AulaSelecionada_'+id).attr('disabled',false);
         $('#EspacioCheck_'+oculto).val(valor);
    }else{
        $('.'+clase).attr('disabled',false);
        $('#EspacioCheck_'+oculto).val('');
    }
    /*******************************************************/
}//function Inavilita
function AutocomplePrograma(){
    /***********************************************************/
    
    var Modalidad = $('#Modalidad').val();
    
    if(Modalidad=='-1' || Modalidad==-1){
        /*******************************************/
            $('#Modalidad').effect("pulsate", {times:3}, 500);
            $('#Modalidad').css('border-color','#F00');
            return false;
        /*******************************************/
    }
    
    	$('#ProgramaText').autocomplete({
					
            source: "../asignacionSalones/calendario3/wdCalendar/EventoSolicitud.php?actionID=AutoPrograma&Modalidad="+Modalidad,
            minLength: 2,
            select: function( event, ui ) {
                    $('#Programa').val(ui.item.id);
                    
            }                
        });
			 
    /***********************************************************/
}//function AutocomplePrograma
function formReset(Texto,Oculto){
     $('#'+Texto).val('');
     $('#'+Oculto).val('');
}//function formReset
function SaveEventoNew(){ 
    /*****************************************************************/
    //validar();
    /*****************************************************************/
}//function SaveEventoNew
function validar(){
	var error = 0;
		$('.requerido').each(function(i, elem){
			if($(elem).val() == ''){
				$(elem).css({'border':'1px solid red'});
                $(elem).effect("pulsate", {times:3}, 500);
				error++;
			}
            
                
		});
		if(error > 0){
			
			$('#aviso').html('Debe rellenar los campos requeridos <br />');
            return false;
		}
            
    return true;        
}

    /****************************************************/

