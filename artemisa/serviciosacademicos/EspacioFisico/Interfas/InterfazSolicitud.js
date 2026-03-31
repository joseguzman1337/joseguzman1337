/**********************************************/
function CreacionEditarEspacio(){
    /***************************************************/
      
    $.ajax({//Ajax
		   type: 'POST',
		   url: '../Administradores/Admin_Categorias_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: ''}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#container').html(data);
							
		   } 
	}); //AJAX
    /**************************************************/
}//function CreacionEditarEspacio
function TipoSalon(){
    /***************************************************/
      
    $.ajax({//Ajax
		   type: 'POST',
		   url: '../Administradores/Admin_TipoSalon_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: ''}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#container').html(data);
							
		   } 
	}); //AJAX
    /**************************************************/
}//function TipoSalon
function DisenoEspacio(){
    /***************************************************/
      
    $.ajax({//Ajax
		   type: 'POST',
		   url: '../Administradores/DisenoEspacioFisico_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'Consola'}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#container').html(data);
							
		   } 
	}); //AJAX
    /**************************************************/
}//function DisenoEspacio
function Ver_EstadoSolicitud(id=''){
    /***************************************************/
    
    var id =  $('#Id_Solicitud').val();    
    
    if(!$.trim(id)){
        alert('Selecionar un Item de la Tabla.');
        return false;
    } 
     
    $.ajax({//Ajax
		   type: 'POST',
		   url: 'InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'Ver_EstadoSolicitud',id:id,Op:1}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#container').html(data);
							
		   } 
	}); //AJAX
    /**************************************************/   
}//function Ver_EstadoSolicitud
function CrearSolicitud(){
    /**************************************************/   

    $.ajax({//Ajax
		   type: 'POST',
		   url: 'InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'Crear'}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#container').html(data);
							
		   } 
	}); //AJAX
    
    /**************************************************/   
}//function CrearSolicitud
function saveSolicitud(){ 
    /**************************************************/
   $('#actionID').val('AddNewSolicitud');
  
   var ValidaCampos   = validateForm('#SolicitudEspacio');
   if(ValidaCampos==false){
        alert('Por favor diligenciar los Campos');
        return false;
   }
   var ValidaGrupos = ValidaAdicionalDos('#SolicitudEspacio');
  
    if(ValidaGrupos==false){
        alert('Selecione Uno o Varios Grupos');
        return false;
    }
   /*var validaTipoAula = ValidaAdicional('#SolicitudEspacio');
   //alert(validaTipoAula);
   if(validaTipoAula==false){
        alert('Por favor Selecionar Una de las Opciones de Aula');
        return false;
   }*/
   //var validaUniMulti = ValidaTabs('#SolicitudEspacio');
   /*if(validaUniMulti==false){
        alert('Por favor Selecionar Una de las Opciones \n Evento Unico o Evento Multiple');
        return false;
   }*/
   //if(validaUniMulti){
         /*if($('#AvilitarUnico').is(':checked')){
                var clase      = 'fecha';
                var ClaseTow   = 'Hora';
                var fechas     = ValidaMultiBox('#SolicitudEspacio',clase);  
                var Hora       = ValidaMultiBox('#SolicitudEspacio',ClaseTow);  
                if(fechas==false || Hora==false){
                    alert('Por Favor Dilegenciar \ Fecha Y Hora del Evento');
                    return false;
                } 
                
                var FechaUnica = $('#FechaUnica').val();
                /*var Dato = validarFechaMenorActual(FechaUnica);
                if(Dato==true){
                    alert('La Fecha No Puede Ser Menor a la Fecha Actual...');
                    $('#FechaUnica').effect("pulsate", {times:3}, 500);
                    $('#FechaUnica').css('border-color','#F00');
                    return false;
                }*/
                
           /*}else{*/
                 var clase      = 'fechaMulti';
                 var ClaseTow   = 'HoraMulti';
                 var fechas     = ValidaMultiBox('#SolicitudEspacio',clase);
                   
                 if(fechas==false){
                    alert('Por favor diligenciar las Fechas \ Fecha Inicial Y Fecha Final');
                    return false;
                 }
                 
                  /*var fechasMenor  = ValidaMultiBoxFecha('#SolicitudEspacio',clase);
                  
                  if(fechasMenor==true){
                    alert('Por Favor Verifiacr las Fechas No Sean Menores a la Fecha Actual...');
                    return false;
                  }*/
                 
                 var DiasCheckd = ValidaCheckSemana('#SolicitudEspacio',ClaseTow);
                 
                 if(DiasCheckd==false){
                    alert('Por Favor Selecionar o Inidcar los Dias del Evento');
                    return false;
                 }
                 if(DiasCheckd){
                    
                    if($('#Dia_1').is(':checked')){ 
                        var DiaUno     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_1'); 
                    } 
                    if($('#Dia_2').is(':checked')){ 
                        var DiaDos     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_2'); 
                    }
                    if($('#Dia_3').is(':checked')){
                        var DiaTres     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_3'); 
                    }
                    if($('#Dia_4').is(':checked')){ 
                        var DiaCuatro     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_4'); 
                    }
                    if($('#Dia_5').is(':checked')){ 
                        var DiaCinco     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_5'); 
                    }
                    if($('#Dia_6').is(':checked')){ 
                        var DiaSeis     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_6'); 
                    }
                    if($('#Dia_7').is(':checked')){ 
                        var DiaSiete     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_7'); 
                    }
                    if(DiaUno==false ||DiaDos==false || DiaTres==false || DiaCuatro==false || DiaCinco==false || DiaSeis==false || DiaSiete==false){
                        alert('Por Favor Indicar las Horas del Evento segun el Dia Inidcado.\ Hora Inicial y Hora Final');
                        return false;
                    }
                 }
          // }
           
       
      
   //}
  
   /*****************************************************************************************************/
        $.ajax({//Ajax
              type: 'POST',
              url: 'InterfazSolicitud_html.php',
              async: false,
              dataType: 'json',
              data:$('#SolicitudEspacio').serialize(),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
              success: function(data){
                   if(data.val===false){
                        alert(data.descrip);
                        return false;
                   }else if(data.val===true){
                        alert(data.descrip+'\n \n Solicitud Num '+data.Solid_id);
                        location.href='InterfazSolicitud_html.php';
                   }else if(data.val==='Error'){
                       // console.log(data.Data);
                        var Datos = data.Data;
                        $.ajax({//Ajax
                    		   type: 'POST',
                    		   url: 'InterfazSolicitud_html.php',
                    		   async: false,
                    		   dataType: 'html',
                    		   data:({actionID: 'PintarError',Data:Datos}),
                    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                    		   success: function(data){
                    					
                    					$('#FechasAsigandas').html(data);
                    							
                    		   } 
                    	}); //AJAX
                        
                   }else if(data.val==='ErrorHorario'){
                        jAlert(data.Mensaje+'\n'+data.Mensaje_1+'\n'+data.Mensaje_2+'\n'+data.Mensaje_3,'Error de Horario');
                        return false;
                   }
              }  
        });//Ajax
        
       
    /*****************************************************************************************************/
           
    /**************************************************/
}//function saveSolicitud
function ValidaAdicional(name){
    $(name + ' input[type=radio]').removeClass('error').removeClass('valid');
    var fields = $(name + ' input[type=radio]');
    var error = 0;
    var omitir = 0;
  
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
        
        if(omitir==0){
            if( $(this).hasClass('need')  && !$(this).is(':checked') && !$(this).attr('disabled') ) { 
                $(this).addClass('error');
                $(this).effect("pulsate", {times:3}, 500);
                error++;
            }else if($(this).hasClass('need')  && $(this).is(':checked') && !$(this).attr('disabled')){
                omitir++;      
            } 
        }
    });
    if(error>0 && omitir==0)
    {return false;}
    else {return true;}
}//function ValidaAdicional 
function ValidaAdicionalDos(name){
    $(name + ' input[type=checkbox]').removeClass('error').removeClass('valid');
    var fields = $(name + ' input[type=checkbox]');
    var error = 0;
    var omitir = 0;
  
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
        
        if(omitir==0){
            if( $(this).hasClass('Gropup')  && !$(this).is(':checked') && !$(this).attr('disabled') ) { 
                $(this).addClass('error');
                $(this).effect("pulsate", {times:3}, 500);
                error++;
            }else if($(this).hasClass('Gropup')  && $(this).is(':checked') && !$(this).attr('disabled')){
                omitir++;      
            } 
        }
    });
    if(error>0 && omitir==0)
    {return false;}
    else {return true;}
}//function ValidaAdicional 
 
function ValidaTabs(name){
    $(name + ' input[type=checkbox]').removeClass('error').removeClass('valid');
    var fields = $(name + ' input[type=checkbox]');
    var error = 0;
    var omitir = 0;
  
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
        
        if(omitir==0){
            if( $(this).hasClass('UnicoTab')  && !$(this).is(':checked') && !$(this).attr('disabled') ) { 
                $(this).addClass('error');
                $(this).effect("pulsate", {times:3}, 500);
                error++;
            }else if($(this).hasClass('UnicoTab')  && $(this).is(':checked') && !$(this).attr('disabled')){
                omitir++;      
            } 
        }
    });
    if(error>0 && omitir==0)
    {return false;}
    else {return true;}
}//function ValidaTabs
function ValidaMultiBox(name,clase){
    //$(name + ' input[type=text]').removeClass('error').removeClass('valid');
    var fields = $(name + ' input[type=text]');
    var error = 0;
    //var omitir = 0;
  
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
           
                if( $(this).hasClass(clase)  && ((value.length<1 || trimvalue=="")) && !$(this).attr('disabled') ) { //fechaMulti
                    $(this).addClass('error');
                    $(this).effect("pulsate", {times:3}, 500);
                    error++;
                }
        
    });
    if(error>0)
    {return false;}
    else {return true;}
}//function ValidaMultiBox
function ValidaMultiBoxFecha(name,clase,id){
    //$(name + ' input[type=text]').removeClass('error').removeClass('valid');
    var fields = $(name + ' #'+id);
    var error = 0;
    //var omitir = 0;
  
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
                
                   /* var Dato = validarFechaMenorActual(value);
                   
                    if(Dato==true){
                            $(this).addClass('error');
                            $(this).effect("pulsate", {times:3}, 500);
                            error++;
                    }*/
                    
                  
                      
                
    });
    if(error>0)
    {return false;}
    else {return true;}
}//function ValidaMultiBoxFecha
function ValidaCheckSemana(name,clase){
    $(name + ' input[type=checkbox]').removeClass('error').removeClass('valid');
    var fields = $(name + ' input[type=checkbox]');
    var error = 0;
    var omitir = 0;
  
    fields.each(function(){
        var value = $(this).val();
        trimvalue = $.trim(value);
        
        if(omitir==0){
            if( $(this).hasClass(clase)  && !$(this).is(':checked') && !$(this).attr('disabled') ) { 
                $(this).addClass('error');
                $(this).effect("pulsate", {times:3}, 500);
                error++;
            }else if($(this).hasClass(clase)  && $(this).is(':checked') && !$(this).attr('disabled')){
                omitir++; 
                $(name + ' input[type=checkbox]').removeClass('error').removeClass('valid'); 
                                    
            } 
        }
    });
    if(error>0 && omitir==0)
    {return false;}
    else {return true;}
}//function ValidaCheckSemana
function AsignarEspacio(){ 
    /***************************************************/
     var id =  $('#Id_Solicitud').val(); 
    
    if(!$.trim(id)){
        alert('Selecionar un Item de la Tabla');
        return false;
    }
      
    $.ajax({//Ajax
		   type: 'POST',
		   url: 'InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'Asignacion',id:id}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#container').html(data);
                    
							
		   } 
	}); //AJAX
    /**************************************************/  
}//function AsignarEspacio

function BuscarDisponibilidad(i,j,S_Hijo){
    /****************************************************/
    
   if($('#Max').is(':checked')){
     var  Cupo= $('#Max').val();
   }else if($('#matriculados').is(':checked')){
     var  Cupo = $('#matriculados').val();
   }else if($('#prematriculados').is(':checked')){
     var  Cupo = $('#prematriculados').val();
   }else if($('#Media').is(':checked')){
     var  Cupo = $('#Media').val();
   }else if($('#NumAsitentes').is(':checked')){
        var  Cupo = $('#NumAsitentes').val();
   }
   
   if(!$.trim(Cupo)){
    alert('Por Favor Indique el Cupo Solicitado...');
    return false;
   }
   //$('#actionID').val('BuscarDisponibilidad');
   //$('#VentanaNew').html('<img src="../imagenes/engranaje-13.gif" />Este Proceso Puede Tardar Unos Minutos...');
   $('#FromAsignacion #Index_i').val(i);
   $('#FromAsignacion #Index_j').val(j);
   $('#FromAsignacion #actionID').val('DataResumen');
   
   
    $.ajax({//Ajax
		   type: 'POST',
		   url: 'InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'json',
		   data:$('#FromAsignacion').serialize(),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){
		      
                      $('#VentanaNew').css('z-index','9999');
                       $('#VentanaNew').css('display','block');
                       $('#VentanaNew').css('left','350px');
                       $('#VentanaNew').css('opacity','1');
                       $('#VentanaNew').css('position','absolute');
                       $('#VentanaNew').css('top','2328.5px');
                       $('#VentanaNew').css('height','700px');
                       $('#VentanaNew').css('width','1200px');
                       
		            $('#DataNewCarga #actionID_2').val('BuscarDisponibilidad');
                    $('#DataNewCarga #TipoSalon').val(data.TipoSalon[0]);
                    $('#DataNewCarga #Acceso').val(data.Acceso);
                    $('#DataNewCarga #NumEstudiantes').val(data.NumEstudiantes);
                    $('#DataNewCarga #Campus').val(data.Campus);
                    $('#DataNewCarga #FechaAsignacion').val(data.FechaAsignacion);
                    $('#DataNewCarga #HoraInicial').val(data.HoraInicial);
                    $('#DataNewCarga #HoraFin').val(data.HoraFin);
                    $('#DataNewCarga #idAsignacion').val(data.idAsignacion);
                    $('#DataNewCarga #id_Soli').val(data.id_Soli);
                    $('#DataNewCarga #id_Soli_Hijo').val(S_Hijo);
                   
				    $('#VentanaNew').bPopup({
                            content:'ajax', //'ajax', 'iframe' or 'image' xlink
                            contentContainer:'#VentanaNew',
                            //iframeAttr:[' scrolling="no" style="width:95%;height:95%" frameborder="54"'],
                            //escClose:[true],
                            loadData:{actionID:'BuscarDisponibilidad',
                                      TipoSalon:data.TipoSalon[0],
                                      Acceso:data.Acceso,
                                      NumEstudiantes:data.NumEstudiantes,
                                      Campus:data.Campus,
                                      FechaAsignacion:data.FechaAsignacion,
                                      HoraInicial:data.HoraInicial,
                                      HoraFin:data.HoraFin,
                                      idAsignacion:data.idAsignacion,
                                      id_Soli:data.id_Soli,
                                      S_Hijo:S_Hijo},//$('#DataNewCarga').serialize(),
                            /*
                            
                            */
                            loadUrl:'InterfazSolicitud_html.php',
                      });   	
		   } 
	}); //AJAX
   
     /****************************************************/
}//function BuscarDisponibilidad

function EliminarSolicitud(){
    /******************************************************/
    var id =  $('#Id_Solicitud').val();
    
    if(!$.trim(id)){
        alert('Selecionar un Item de la Tabla');
        return false;
    }
    var Text = 'Se\xf1or Usuario sus cambios o modificaciones seran notificados a los estudiantes o personas asociadas a la solicitud... \n\n';
    if(confirm(Text+'Desea Eliminar La Solicitud')){
       
        
        $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'InterfazSolicitud_html.php',
    		   async: false,
    		   dataType: 'json',
    		   data:({actionID: 'EliminarSolicitud',id:id}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
    		   success: function(data){
    					if(data.val==false){
    					   alert(data.descrip);
                           return false
    					}else{
    					   alert(data.descrip);
                           location.href='InterfazSolicitud_html.php';
    					}		
    		   } 
    	}); //AJAX
        
    }
    /******************************************************/
}//function EliminarSolicitud
function EditarSolicitud(){
    /******************************************************/
     var id =  $('#Id_Solicitud').val();  
     
     if(!$.trim(id)){
        alert('Selecionar un Item de la Tabla');
        return false;
    }
    
    /**********************************************************/
    $.ajax({//Ajax
		   type: 'POST',
		   url: 'InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'json',
		   data:({actionID: 'ValidarEditar',id:id}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){
				if(data.val==false){
				    alert(data.descrip);
                    return false;
				}else{
                        
                      if(data.Estatus=='Externa'){
                        alert('Disponible para Solicitudes Internas...');
                        return false;
                      }else{  
                              $.ajax({//Ajax
                            		   type: 'POST',
                            		   url: 'InterfazSolicitud_html.php',
                            		   async: false,
                            		   dataType: 'html',
                            		   data:({actionID: 'EditarSolicitud',id:id}),
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                            		   success: function(data){
                        					$('#container').html(data); 
                                        }    
                              	}); //AJAX   
                        
                        }
                      
				   }
		   } 
	}); //AJAX
    /*********************************************************/
      
    
    /******************************************************/
}//function EditarSolicitud
function EditarAsignacion(){
    /*******************************************************/
    $.ajax({//Ajax
		   type: 'POST',
		   url: '../asignacionSalones/index.php',
		   async: false,
		   dataType: 'html',
           data:({url: '../asignacionSalones/'}),
		    error:function(objeto, quepaso, otroobj){
		       alert('Error de Conexión , Favor Vuelva a Intentar');
		       },
		   success: function(data){
					$('#container').html(data);
		   } 
	}); //AJAX
    /*******************************************************/
}//function EditarAsignacion
function ActivaMultiple(){
    /******************************************************/
    for(x=1;x<=7;x++){
    
        if($('#Dia_'+x).is(':checked')){
            /*********************************/
            $('#Campus_'+x).attr('disabled',false);
            /*********************************/
        }else{
            /*********************************/
            $('#Campus_'+x).attr('disabled',true);
            /*********************************/
        }    
        
    }//for
    
    /******************************************************/
}//function ActivaMultiple
function Ocultar(num){ 
     /*************************************************/
    if($('#AvilitarUnico').is(':checked')){ 
        if(num==1){
            $('#BuscarUnico').css('display','inline');
            $('#BuscarMultiple').css('display','none');
            $('#AvilitarMultiple').attr('disabled',true);
            $('#AvilitarMultiple').attr('checked',false);
            $('#AvilitarUnico').attr('disabled',false);
            $('#FechaIni').val('');
            $('#FechaFin').val('');
            $('.Hora_1').val('');
            $('.Hora_2').val(''); 
            $('.DiaChekck').removeAttr('checked');
            //$('#DivDisponibilidadMultiple').html('');
            $('#Th_Campus').css('display','block');
            //$('.DiaMulti').attr('checked',false);
            //$('.Sede').attr('disabled',false);
            
          }
    }else if($('#AvilitarMultiple').is(':checked')){
        if(num==2){
            $('#BuscarMultiple').css('display','inline');
            $('#BuscarUnico').css('display','none');
            $('#AvilitarMultiple').attr('disabled',false);
            $('#AvilitarUnico').attr('disabled',true);
            $('#AvilitarUnico').attr('checked',false);
            $('#FechaUnica').val('');
            $('#HoraInicial_unica').val('');
            $('#HoraFin_unica').val(''); 
            //$('#DivDisponibilidad').html('');
            $('#Th_Campus').css('display','none');
            $('.DiaChekck').removeAttr('checked');
            //$('.Sede').attr('disabled',true);
          }
    }else{
        $('#AvilitarMultiple').attr('disabled',false);
        $('#AvilitarUnico').attr('disabled',false);
        $('#BuscarUnico').css('display','none');
        $('#BuscarMultiple').css('display','none');
        $('#Th_Campus').css('display','block');
        $('.DiaChekck').removeAttr('checked');
        //$('.Sede').attr('disabled',true);
    }
    /*************************************************/
}//function Ocultar
function EliminarFechaAsignacion(id){
    
    /****************************************************/
    var Text = 'Se\xf1or Usuario sus cambios o modificaciones seran notificados a los estudiantes o personas asociadas a la solicitud... \n\n';
    if(confirm(Text+'Seguro que desea Eliminar la Fecha Asignada...?')){
        
        $.ajax({//Ajax   
          type: 'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'EliminarAsigancion',id:'::'+id}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val==false){
                        alert(data.descrip);
                        return false;
                    }else{
                        alert(data.descrip);
                        /*******************************************/
                         $.ajax({//Ajax
                    		   type: 'POST',
                    		   url: 'InterfazSolicitud_html.php',
                    		   async: false,
                    		   dataType: 'html',
                    		   data:({actionID: 'Ver_EstadoSolicitud',id:data.id,Op:1}),
                    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                    		   success: function(data){
                    					
                    					$('#container').html(data);
                    							
                    		   } 
                    	}); //AJAX
                        /*******************************************/
                    }
        	}//data 
                
        });
    }
    /****************************************************/
}//function EliminarFechaAsignacion
function OtrosEventos(id,id_Soli,Op){ 
    /****************************************************/
   $('#VentanaNew').css('z-index','9999');
   $('#VentanaNew').css('display','block');
   $('#VentanaNew').css('left','350px');
   $('#VentanaNew').css('opacity','1');
   $('#VentanaNew').css('position','absolute');
   $('#VentanaNew').css('top','2328.5px');
   $('#VentanaNew').css('height','450px');
   $('#VentanaNew').css('width','450px');
   $('#OmitirSave').css('display','inline');
   
    $('#VentanaNew').bPopup({
        content:'iframe',// 'ajax', 'iframe' or 'image' xlink
        //contentContainer:'.content',
        iframeAttr:['scrolling="no" style="width:90%;height:90%" frameborder="54"'],
        //escClose:[true],
        loadUrl:'InterfazSolicitud_html.php?actionID=OmitirFecha&id='+id+'&id_Soli='+id_Soli+'&Op='+Op,
  }); 

    /****************************************************/
}//function Otros
function SaveOmitirFecha(id,id_Soli,op){
    /************************************************/
    
    var TexObs = $('#TexObs').val();
    $('#OmitirSave').css('display','none');
    
    var Text = 'Se\xf1or Usuario sus cambios o modificaciones seran notificados a los estudiantes o personas asociadas a la solicitud... \n\n';
    if(confirm(Text+'Seguro que desea Guardar...?')){
    
    $.ajax({//Ajax   
          type: 'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'SaveOmitir',id:id,TexObs:TexObs}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val==false){
                        alert(data.descrip);
                        $('#OmitirSave').css('display','inline');
                        return false;
                    }else{
                        alert(data.descrip);
                         
                        $.ajax({//Ajax
                    		   type: 'POST',
                    		   url: 'InterfazSolicitud_html.php',
                    		   async: false,
                    		   dataType: 'html',
                    		   data:({actionID: 'Ver_EstadoSolicitud',id:data.id,Op:1}),
                    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                    		   success: function(data){
                    					
                    					$('#container', window.parent.document).html(data);
                    							
                    		   } 
                    	}); //AJAX
                       }
        	}//data 
                
        });
     }   
    /*************************************************/
}//function SaveOmitirFecha
function VerDetalleContenido(id,op=''){ 
    /*****************************************************/
   
    $.ajax({//Ajax   
          type: 'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'html',
          data:({actionID:'VerDetalleContenido',id:id,op:op}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
          success: function(data){
                $('#Div_ContenidoDetalle', window.parent.document).html(data);
                $( "#accordion" ).accordion('destroy');
                $( "#accordion" ).accordion({
                  heightStyle: "content",
                  collapsible: true
                });
            }//data 
                
        });
    /*****************************************************/
}//function VerDetalleContenido
function VerCambio(id,id_Soli,Op){ 
    /****************************************************/
   $('#VentanaNew').css('z-index','9999');
   $('#VentanaNew').css('display','block');
   $('#VentanaNew').css('left','350px');
   $('#VentanaNew').css('opacity','1');
   $('#VentanaNew').css('position','absolute');
   $('#VentanaNew').css('top','2328.5px');
   $('#VentanaNew').css('height','450px');
   $('#VentanaNew').css('width','450px');
   $('#CambioEstado').css('display','inline');
   
    $('#VentanaNew').bPopup({
        content:'iframe',// 'ajax', 'iframe' or 'image' xlink
        //contentContainer:'.content',
        iframeAttr:['scrolling="no" style="width:90%;height:90%" frameborder="54"'],
        //escClose:[true],
        loadUrl:'InterfazSolicitud_html.php?actionID=VerCambio&id='+id+'&id_Soli='+id_Soli+'&Op='+Op,
  }); 
 

    /****************************************************/
}//function VerCambio
function SaveCambioEstado(id,id_Soli,Op){
    /************************************************/
    
    $('#CambioEstado').css('display','none');
    
    var Text = 'Se\xf1or Usuario sus cambios o modificaciones seran notificados a los estudiantes o personas asociadas a la solicitud... \n\n';
    if(confirm(Text+'Seguro que desea Modificar...?')){
        
        
    $.ajax({//Ajax   
          type: 'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'SaveCambioEstado',id:id}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val==false){
                        alert(data.descrip);
                        $('#CambioEstado').css('display','inline');
                        return false;
                    }else{
                        alert(data.descrip);
                        $.ajax({//Ajax
                    		   type: 'POST',
                    		   url: 'InterfazSolicitud_html.php',
                    		   async: false,
                    		   dataType: 'html',
                    		   data:({actionID: 'Ver_EstadoSolicitud',id:data.id,Op:1}),
                    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                    		   success: function(data){
                    					
                    			  $('#container', window.parent.document).html(data);
                    							
                    		   } 
                    	}); //AJAX
                       }
        	}//data 
                
        });
      }  
    /************************************************/
}//function SaveCambioEstado
function EspacioAutomatico(){
    /**************************************************/
    
   if($('#Max').is(':checked')){
     var  Cupo= $('#Max').val();
   }else if($('#matriculados').is(':checked')){
     var  Cupo = $('#matriculados').val();
   }else if($('#prematriculados').is(':checked')){
     var  Cupo = $('#prematriculados').val();
   }else if($('#Media').is(':checked')){
     var  Cupo = $('#Media').val();
   }else if($('#NumAsitentes').is(':checked')){
        var  Cupo = $('#NumAsitentes').val();
   }
   
   if(!$.trim(Cupo)){
    alert('Por Favor Indique el Cupo Solicitado...');
    return false;
   }
    
    var FechaIni   = $('#FechaIni').val();
    var FechaFinal = $('#FechaFinal').val();
    
    if(confirm('Bienvenido usted va a utilizar la opcion de programacion automatica para la asignacion de aulas de la Univesidad El Bosque. \n Esta asignacion se realizara en el intervalo de las siguientes fechas. \n \n'+ FechaIni+' -- '+FechaFinal)){
        /*******************************************/
        var id = $('#id_Soli').val();
        AutomaticoAsignacion(id);
        /*******************************************/
    }
  
    /**************************************************/
}//function EspacioAutomatico
function AutomaticoAsignacion(id_Soli){ console.log(id_Soli);
    /**************************************************/
    $('#FromAsignacion #actionID').val('BuscarAutomatico');
    //alert($('#actionID').val());
    $('#DivDistrator').html('<img src="../imagenes/engranaje-13.gif" />Este Proceso Puede Tardar Unos Minutos...');
     $.ajax({//Ajax   
          type:'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:$('#FromAsignacion').serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val==false){
                        alert(data.descrip);
                         $('#DivDistrator').html('');
                        
                        return false;
                    }else{
                        if(data.Existe==true){
                            
                            var TextMsg = data.descrip+'\n'+data.Msg;
                            
                            alert(TextMsg);
                            $('#DivDistrator').html('');
                            $.ajax({//Ajax   
                              type: 'POST',
                              url: 'InterfazSolicitud_html.php',
                              async: false,
                              dataType: 'html',
                              data:({actionID:'VerDetalleContenido',id:id_Soli,op:2,DataMsg:data.Texto}),
                              error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                              success: function(data){
                                    $('#Div_ContenidoDetalle').html(data);
                                }//data 
                                    
                         });//AJAX  
                        }
                        if(data.NoHay==true){
                            alert(data.Msg);
                            $('#DivDistrator').html('');
                        }
                        if(data.Complet==true){
                            alert(data.descrip);
                            $('#DivDistrator').html('');
                             $.ajax({//Ajax   
                                  type: 'POST',
                                  url: 'InterfazSolicitud_html.php',
                                  async: false,
                                  dataType: 'html',
                                  data:({actionID:'VerDetalleContenido',id:id_Soli,op:1}),
                                  error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                                  success: function(data){
                                        $('#Div_ContenidoDetalle').html(data);
                                    }//data 
                                        
                             });//AJAX  
                        }    
                    }
        	}//data 
            
       });//AJAX
    /**************************************************/
}//function AutomaticoAsignacion
function ManualSave(){
    /************************************************/
    $('#AsignacionManual #actionID').val('AsignacionManual');
    //alert($('#actionID').val());
    
     $.ajax({//Ajax   
          type:'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:$('#AsignacionManual').serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val==false){
                        alert(data.descrip);
                        return false;
                    }else{
                        alert(data.descrip);
                        VerDetalleContenido(data.id_Soli,1,data.Userid); 
                    }
        	}//data 
            
       });//AJAX
    /************************************************/
}//function ManualSave

function SolicitarSobreCupo(id=''){
    if(typeof(aSelected) != "undefined"){
     if(aSelected.length==1){
            var id = aSelected[0];     
          } 
     }  
     
     if(!$.trim(id)){
        alert('Selecionar un Item de la tabla.');
        return false;
     } 
     /****************************************************/
   $('#VentanaNew').css('z-index','9999');
   $('#VentanaNew').css('display','block');
   $('#VentanaNew').css('left','350px');
   $('#VentanaNew').css('opacity','1');
   $('#VentanaNew').css('position','absolute');
   $('#VentanaNew').css('top','2328.5px');
   $('#VentanaNew').css('height','650px');
   $('#VentanaNew').css('width','650px');
   //$('#OmitirSave').css('display','inline');
   
    $('#VentanaNew').bPopup({
        content:'iframe',// 'ajax', 'iframe' or 'image' xlink
        //contentContainer:'.content',
        iframeAttr:['scrolling="no" style="width:90%;height:90%" frameborder="54"'],
        //escClose:[true],
        loadUrl:'InterfazSolicitud_html.php?actionID=HacerSolictuSobrecupo&id='+id,
  }); 
}//function SolicitarSobreCupo
 
//#e2e4ff
function CargarNum(i,id,num){
   $('#Id_Solicitud').val('');
   $('#Tr_File_'+i).css('background','white');
   $('#Id_Solicitud').val(id);
        
}//function CargarNum
function ColorNeutro(i,fecha,mod){
  $('#Tr_File_'+i).css('background','white'); 
    
     $.ajax({//Ajax   
          type:'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'TipoNumber',Numero:fecha,mod:mod}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.num==1){
                        $('#Tr_File_'+i).css('background','#e2e4ff'); 
               }else if(data.num==2){
                        $('#Tr_File_'+i).css('background','#FAFF6B');
               }else{
                        $('#Tr_File_'+i).css('background','#A8F7C5');
               }
        	}//data 
            
       });//AJAX 
}//function ColorNeutro
function VerSolicitarSobreCupo(){
    /*************************************************/
     $.ajax({//Ajax   
          type:'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'html',
          data:({actionID:'VerSobreCupo'}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
          success: function(data){
               $('#CargarData').html(data);
        	}//data 
            
       });//AJAX 
    /*************************************************/
}//function VerSolicitarSobreCupo
function validarFechaMenorActual(date){
    
  /*  var today = new Date();
        var date2= new Date(date);
        
        if (date2>today)
        {   
            return false;
        }
          else
          {
              return true;
          }  */ 
    
    /* $.ajax({//Ajax   
          type:'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'ValidarFechaMenor',fecha:date}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
          success: function(data){
                    if(data.val==true){ 
                         var dato = 1;
                         alert('dato-->'+dato);
                         return dato;
                    }else{
                        var dato = 0;
                        alert('dato-->'+dato);
                        return dato;
                    }
              
        	}//data 
            
       });//AJAX */
     
  }//function validarFechaMenorActual
function OcultarImagen(i){
    if($('#CheckEliminar_'+i).is(':checked')){
        $('#Elimnar_'+i).css('display','none');
    }else{
        $('#Elimnar_'+i).css('display','inline');
    }
}//function OcultarImagen
function EliminarAll(i){
    var Text = 'Se\xf1or Usuario sus cambios o modificaciones seran notificados a los estudiantes o personas asociadas a la solicitud... \n\n';
    if(confirm(Text+'Seguro Desea Eliminar las Fecha(s) Indicadas..?')){
        
        var Dato = $('#SoliGrupo_'+i).val();
         
                $.ajax({//Ajax   
                  type: 'POST',
                  url: 'InterfazSolicitud_html.php',
                  async: false,
                  dataType: 'json',
                  data:({actionID:'EliminarAsigancion',id:Dato}),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                  success: function(data){
                       if(data.val==false){
                                alert(data.descrip);
                                return false;
                        }else{
                             id = data.id;
                             Msg = data.descrip;
                             
                             alert('Se Han Eliminado las Fecha(s) de Forma Correcta.');
        
                             $.ajax({//Ajax
                        		   type: 'POST',
                        		   url: 'InterfazSolicitud_html.php',
                        		   async: false,
                        		   dataType: 'html',
                        		   data:({actionID: 'Ver_EstadoSolicitud',id:id}),
                        		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                        		   success: function(data){
                        					
                        					$('#container').html(data);
                        							
                        		   } 
                        	}); //AJAX 
                        }
                	}//data 
                        
                });//AJAX
          
        
    }
}//function EliminarAll
function RestaurarEspacios(i){
    var Text = 'Se\xf1or Usuario sus cambios o modificaciones seran notificados a los estudiantes o personas asociadas a la solicitud... \n\n';
    if(confirm(Text+'Seguro Desea Restaurar los Espacios Fisicos s el Estado Original..?')){
        
        var Dato = $('#SoliGrupo_'+i).val();
        
        $.ajax({//Ajax   
                  type: 'POST',
                  url: 'InterfazSolicitud_html.php',
                  async: false,
                  dataType: 'json',
                  data:({actionID:'RestaurarEspacios',id:Dato}),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                  success: function(data){
                       if(data.val==false){
                                alert(data.descrip);
                                return false;
                        }else{
                             id = data.id;
                             Msg = data.descrip;
                             
                             alert('Se Han Realizado la Restauracion Correctamente.');
        
                             $.ajax({//Ajax
                        		   type: 'POST',
                        		   url: 'InterfazSolicitud_html.php',
                        		   async: false,
                        		   dataType: 'html',
                        		   data:({actionID: 'Ver_EstadoSolicitud',id:id}),
                        		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                        		   success: function(data){
                        					
                        					$('#container').html(data);
                        							
                        		   } 
                        	}); //AJAX 
                        }
                	}//data 
                        
                });//AJAX
        
    }
    
}//function RestaurarEspacios
function AddValor(id,i,i_j){
    if($('#CheckEliminar_'+i_j).is(':checked')){
               
                var Dato = $('#CheckEliminarDato_'+i_j).val();
                
                $('#SoliGrupo_'+i).val($('#SoliGrupo_'+i).val()+'::'+Dato);
                 
       }else{
        
        var Contenido = $('#SoliGrupo_'+i).val();
        var N = $('#CheckEliminarDato_'+i_j).val();
        var dato      = '::'+N; 
        var NewData = Contenido.replace(dato,"");
        $('#SoliGrupo_'+i).val(NewData);
       }//if
}//function AddValor
function AllCheckTodo(i){ 
    if($('#AllChecko_'+i).is(':checked')){ 
        $('.AllCheckSeleciona_'+i).attr('checked',true);
        var Num = $('#Num_'+i).val();
        //console.log(Number);
        for(j=0;j<Num;j++){
            var N = i+'_'+j;
            var Dato = $('#CheckEliminarDato_'+N).val();
                
            $('#SoliGrupo_'+i).val($('#SoliGrupo_'+i).val()+'::'+Dato);
        }//for
    }else{
        $('.AllCheckSeleciona_'+i).attr('checked',false);
        $('#SoliGrupo_'+i).val('');
    }
    
}//function AllCheckTodo
function BuscarDisponibilidadMultiple2(i,S_Hijo,idSoli){
    
   if($('#Max').is(':checked')){
     var  Cupo= $('#Max').val();
   }else if($('#matriculados').is(':checked')){
     var  Cupo = $('#matriculados').val();
   }else if($('#prematriculados').is(':checked')){
     var  Cupo = $('#prematriculados').val();
   }else if($('#Media').is(':checked')){
     var  Cupo = $('#Media').val();
   }else if($('#NumAsitentes').is(':checked')){
        var  Cupo = $('#NumAsitentes').val();
   }
   
   if(!$.trim(Cupo)){
    alert('Por Favor Indique el Cupo Solicitado...');
    return false;
   }
   
  // alert('Aca...'); 
    
   $('#VentanaNew').css('z-index','9999');
   $('#VentanaNew').css('display','block');
   $('#VentanaNew').css('left','350px');
   $('#VentanaNew').css('opacity','1');
   $('#VentanaNew').css('position','absolute');
   $('#VentanaNew').css('top','2328.5px');
   $('#VentanaNew').css('height','700px');
   $('#VentanaNew').css('width','1200px');
  
   var  AsigGrupo = $('#SoliGrupo_'+i).val();
   var  Campus = $('#Campus_'+i).val();
   var  Userid = $('#Userid').val();
   
      $('#VentanaNew').bPopup({
            content:'ajax', //'ajax', 'iframe' or 'image' xlink
            contentContainer:'#VentanaNew',
            iframeAttr:['scrolling="no" style="width:90%;height:90%" frameborder="54"'],
            //iframeAttr:[' scrolling="no" style="width:95%;height:95%" frameborder="54"'],
            //escClose:[true],
            loadData:{actionID:'BuscarDisponibilidadMultiple',
                      AsigGrupo:AsigGrupo,
                      Cupo:Cupo,
                      Campus:Campus,
                      idSoli:idSoli,
                      S_Hijo:S_Hijo},
            loadUrl:'InterfazSolicitud_html.php',
      });   	
}//function BuscarDisponibilidadMultiple
function MultipleAsignarAula(id,Asig_id,idSoli,S_Hijo){
   
    var Text = 'Se\xf1or Usuario sus cambios o modificaciones seran notificados a los estudiantes o personas asociadas a la solicitud... \n\n';
    if(confirm(Text+'Desea Asignar El Espacio a todas las fechas Selecionadas...?')){
        $('.BotonMultiple').css('display','none');
        $('#DivDibujo').html('<img src="../imagenes/engranaje-13.gif" />Este Proceso Puede Tardar Unos Minutos...');
    
        $.ajax({//Ajax
        		   type: 'POST',
        		   url: 'InterfazSolicitud_html.php',
        		   async: false,
        		   dataType: 'json',
        		   data:({actionID: 'AsignarMultiple',id:id,Asig_id:Asig_id,S_Hijo:S_Hijo}),
        		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
        		   success: function(data){
        				if(data.val===false){
        				    alert(data.descrip);
                            $('.BotonMultiple').css('display','block');
                            return false;
        				}else{
        				    $('#DivDibujo').html('');
        				    alert(data.descrip);
                            VerDetalleContenido(idSoli,1); 
        				}
        							
        		   } 
        	}); //AJAX 
    }
}//function MultipleAsignarAula
function ModificarSolicitud(){
    var Solicitud_id = $('#Solicitud_id').val();
    
    if(!$.trim(Solicitud_id)){
        alert('No se puede Modificar \n Por favor comunicarse con tecnologia.');
        return false;
    }
    
   var ValidaCampos   = validateForm('#SolicitudEspacio');
   if(ValidaCampos==false){
        alert('Por favor diligenciar los Campos');
        return false;
   }
   var validaTipoAula = ValidaAdicional('#SolicitudEspacio');
   if(validaTipoAula==false){
        alert('Por favor Selecionar Una o Varias Opciones');
        return false;
   }
   /*var validaUniMulti = ValidaTabs('#SolicitudEspacio');
   if(validaUniMulti==false){
        alert('Por favor Selecionar Una de las Opciones \n Evento Unico o Evento Multiple');
        return false;
   }
   if(validaUniMulti){
         if($('#AvilitarUnico').is(':checked')){
                var clase      = 'fecha';
                var ClaseTow   = 'Hora';
                var fechas     = ValidaMultiBox('#SolicitudEspacio',clase);  
                var Hora       = ValidaMultiBox('#SolicitudEspacio',ClaseTow);  
                if(fechas==false || Hora==false){
                    alert('Por Favor Dilegenciar \ Fecha Y Hora del Evento');
                    return false;
                } 
                
                var FechaUnica = $('#FechaUnica').val();
               // var Dato = validarFechaMenorActual(FechaUnica);
                /*if(Dato==true){
                    alert('La Fecha No Puede Ser Menor a la Fecha Actual...');
                    $('#FechaUnica').effect("pulsate", {times:3}, 500);
                    $('#FechaUnica').css('border-color','#F00');
                    return false;
                }*/
                
          /* }else{*/
                 var clase      = 'fechaMulti';
                 var ClaseTow   = 'HoraMulti';
                 var fechas     = ValidaMultiBox('#SolicitudEspacio',clase);
                   
                 if(fechas==false){
                    alert('Por favor diligenciar las Fechas \ Fecha Inicial Y Fecha Final');
                    return false;
                 }
                 
                  var fechasMenor  = ValidaMultiBoxFecha('#SolicitudEspacio',clase,'FechaIni');
            
                  
                 /* if(fechasMenor==true){
                    alert('Por Favor Verificar la Fecha Inicial No Sean Menor a la Fecha Actual...');
                    return false;
                  }*/
                  
                  var fechasMenor_2  = ValidaMultiBoxFecha('#SolicitudEspacio',clase,'FechaFin');
                  
                 /* if(fechasMenor==true){
                    alert('Por Favor Verificar las Fecha Final No Sean Menor a la Fecha Actual...');
                    return false;
                  }*/
                 
                 var DiasCheckd = ValidaCheckSemana('#SolicitudEspacio',ClaseTow);
                 
                 if(DiasCheckd==false){
                    alert('Por Favor Selecionar o Inidcar los Dias del Evento');
                    return false;
                 }
                 if(DiasCheckd){
                    
                    if($('#Dia_1').is(':checked')){ 
                        var DiaUno     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_1'); 
                    } 
                    if($('#Dia_2').is(':checked')){ 
                        var DiaDos     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_2'); 
                    }
                    if($('#Dia_3').is(':checked')){
                        var DiaTres     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_3'); 
                    }
                    if($('#Dia_4').is(':checked')){ 
                        var DiaCuatro     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_4'); 
                    }
                    if($('#Dia_5').is(':checked')){ 
                        var DiaCinco     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_5'); 
                    }
                    if($('#Dia_6').is(':checked')){ 
                        var DiaSeis     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_6'); 
                    }
                    if($('#Dia_7').is(':checked')){ 
                        var DiaSiete     = ValidaMultiBox('#SolicitudEspacio',ClaseTow+'_7'); 
                    }
                    if(DiaUno==false ||DiaDos==false || DiaTres==false || DiaCuatro==false || DiaCinco==false || DiaSeis==false || DiaSiete==false){
                        alert('Por Favor Indicar las Horas del Evento segun el Dia Inidcado.\ Hora Inicial y Hora Final');
                        return false;
                    }
                 }
          // }
    //}
    
  
  if(confirm('Tenga en cuenta que los datos Modificados pueden Modificar los siguientes aspectos:\n Fechas \n Espacios Asignados \n \n Seguro desea Guardar la Modificaciones Realizadas...?')){
  
    
    $('#actionID').val('ModificarSolicitud');
    
        $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'InterfazSolicitud_html.php',
    		   async: false,
    		   dataType: 'json',
    		   data:$('#SolicitudEspacio').serialize(),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
    		   success: function(data){
    					if(data.val===false){
                                alert(data.descrip);
                                return false;
                           }else if(data.val===true){
                                alert(data.descrip);
                                location.href='InterfazSolicitud_html.php';
                           }else if(data.val==='Error'){
                               // console.log(data.Data);
                                var Datos = data.Data;
                                $.ajax({//Ajax
                            		   type: 'POST',
                            		   url: 'InterfazSolicitud_html.php',
                            		   async: false,
                            		   dataType: 'html',
                            		   data:({actionID: 'PintarError',Data:Datos}),
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                            		   success: function(data){
                            					
                            					$('#FechasAsigandas').html(data);
                            							
                            		   } 
                            	}); //AJAX
                                
                           }else if(data.val==='ErrorHorario'){
                                jAlert(data.Mensaje+'\n'+data.Mensaje_1+'\n'+data.Mensaje_2+'\n'+data.Mensaje_3,'Error de Horario');
                                return false;
                           }
    							
    		   } 
    	}); //AJAX 
      
    } 
}//function ModificarSolicitud
function VerMultiGroups(){
    
    var Programa = $('#Programa').val();
    var Materia = $('#Materia').val();
    
    
    $.ajax({//Ajax
    		   type: 'POST',
    		   url: '../asignacionSalones/calendario3/wdCalendar/EventoSolicitud.php',
    		   async: false,
    		   dataType: 'html',
    		   data:({actionID: 'AutoGrupo',Programa:Programa,Materia:Materia,OP:'Multiple'}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
    		   success: function(data){
    					$('#Th_Grupo').html(data);
    		   } 
    	}); //AJAX
}//function VerMultiGroups
function ModificarRegistroUnico(Indix){
    var Text = 'Se\xf1or Usuario sus cambios o modificaciones seran notificados a los estudiantes o personas asociadas a la solicitud... \n\n';
    if(confirm(Text+'Seguro Desea Modificar...?')){
    
            var idAsignacion        = $('#idAsignacion_'+Indix).val();
            var FechaAsignacion     = $('#FechaAsignacion_'+Indix).val();
            var HoraInicial         = $('#HoraInicial_'+Indix).val();
            var HoraFin             = $('#HoraFin_'+Indix).val();
            var FechaAsignacion_Old = $('#FechaAsignacion_Old_'+Indix).val();
            
            if(!$.trim(HoraInicial)){
                /******************************************************/
                $('#HoraInicial_'+Indix).effect("pulsate", {times:3}, 500);
                $('#HoraInicial_'+Indix).css('border-color','#F00');
                return false;
                /******************************************************/
            }
            if(!$.trim(HoraFin)){
                /******************************************************/
                $('#HoraFin_'+Indix).effect("pulsate", {times:3}, 500);
                $('#HoraFin_'+Indix).css('border-color','#F00');
                return false;
                /******************************************************/
            }
            
            $.ajax({//Ajax
            		   type: 'POST',
            		   url: 'InterfazSolicitud_html.php',
            		   async: false,
            		   dataType: 'json',
            		   data:({actionID: 'ModificarUnicoLog',idAsignacion:idAsignacion,FechaAsignacion:FechaAsignacion,HoraInicial:HoraInicial,HoraFin:HoraFin,FechaAsignacion_Old:FechaAsignacion_Old}),
            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
            		   success: function(data){
            				if(data.val=='ErrorFecha'){
            				    alert('La fecha es Menor a la fecha Actual');
                                    $('#FechaAsignacion_'+Indix).effect("pulsate", {times:3}, 500);
                                    $('#FechaAsignacion_'+Indix).css('border-color','#F00');
                                    return false;
            				}else if(data.val==false){
            				    alert(data.descrip);
                                return false;
            				}else{
            				    alert(data.descrip);
                                
                                /*******************************************/
                                 $.ajax({//Ajax
                            		   type: 'POST',
                            		   url: 'InterfazSolicitud_html.php',
                            		   async: false,
                            		   dataType: 'html',
                            		   data:({actionID: 'Ver_EstadoSolicitud',id:data.idSolicituid,Op:1}),
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                            		   success: function(data){
                            					
                            					$('#container').html(data);
                            							
                            		   } 
                            	}); //AJAX
                                /*******************************************/
            				}
            		   } 
            	}); //AJAX
    }
}//function ModificarRegistroUnico
function FormatBox(id){
    $('#'+id).val('');
}//function FormatBox
function SolicitudExterna(){
    $.ajax({//Ajax
		   type: 'POST',
		   url: 'SolicitudExterna_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'Crear'}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){
				$('#container').html(data);
			}
	}); //AJAX
}//function SolicitudExterna
function EditarExterna(){
    var id =  $('#Id_Solicitud').val();  
     
     if(!$.trim(id)){
        alert('Selecionar un Item de la Tabla');
        return false;
    }
    
     $.ajax({//Ajax
		   type: 'POST',
		   url: 'SolicitudExterna_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'Editar',id:id}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){					
					$('#container').html(data);							
		   } 
	}); //AJAX
}//function EditarExterna
function ExportarExcel(){
    location.href='SolicitudExcel.php';
}//function ExportarExcel
function ModificaNum(){
    var id_Soli = $('#id_Soli').val();
    var Num     = $('#Num').val();
    
    if(confirm('Desea Modificar el Numero de Asistentes...?')){
        /***********************************************************************/
         $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'InterfazSolicitud_html.php',
    		   async: false,
    		   dataType: 'json',
    		   data:({actionID: 'UpdateNumAsistentes',id_Soli:id_Soli,Num:Num}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
    		   success: function(data){
				    if(data.val===false){
				        alert(data.descrip);
                        return false;
				    }else{
				        alert('Se ha Modificado Numero de Asistentes.');
				    }			
		   } 
        }); //AJAX
        /***********************************************************************/
    }
}//function ModificaNum
function ModificaObs(){
    var Observaciones = $('#Observaciones').val();
    var id_Soli       = $('#id_Soli').val();
    
    if(confirm('Desea Modificar La informacion de la Observacion...?')){
        /***********************************************************************/
         $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'InterfazSolicitud_html.php',
    		   async: false,
    		   dataType: 'json',
    		   data:({actionID: 'UpdateObservacion',id_Soli:id_Soli,Observaciones:Observaciones}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
    		   success: function(data){
				    if(data.val===false){
				        alert(data.descrip);
                        return false;
				    }else{
				        alert('Se ha Modificado Numero de Asistentes.');
				    }			
		   } 
        }); //AJAX
        /***********************************************************************/
    }
}//function ModificaObs
function AvilitarDesavilitar(){
     if(aSelected.length==1){
	
        var id = aSelected[0];
            
          }else{
             return false;
          }
	  	  
      if(confirm('Desea Cambiar el Estado...?')){    
          
		  $.ajax({//Ajax
			   type: 'POST',
			   url: 'InterfazSolicitud_html.php',
			   async: false,
			   dataType: 'json',
			   data:({actionID: 'AvilitarODesactivar',id:id}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
			   success: function(data){
				    if(data.val===false){
				        alert('Error...');
                        return false;
				    }else{
				        alert(data.descrip);
                        location = 'InterfazSolicitud_html.php?actionID=Creacion';
				    }								
			   } 
		}); //AJAX
      }  
}//function AvilitarDesavilitar
function CargarNum_ID(i,id,num){
   $('#Id_Solicitud').val('');
   $('#Tr_File_2'+i).css('background','white');
   $('#Id_Solicitud').val(id);
}//functionCargarNum_ID

function DataPendienteAsignar(){
    /***************************************************/
    var fechaIni       = $('#FechaIni').val();
    var fechaFin       = $('#FechaFinal').val();
    
    if(fechaIni == ''){
        alert('Debe ingresar Fecha Inicial' );
        return false;
    }
    if(fechaFin == ''){
        alert('Debe ingresar Fecha Final' );
        return false;
    }
    $.ajax({//Ajax
		   type: 'POST',
		   url: 'InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: 'DataPendienteAsignar',fechaIni:fechaIni,fechaFin:fechaFin}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){					
					$('#CargaFaltaAsigancion').html(data);							
		   } 
	}); //AJAX
    /**************************************************/  
}//function DataPendienteAsignar
function ValidarFechasUnic(){
    var fecha_1 = $('#FechaIni').val();
    var fecha_2 = $('#FechaFin').val();
    
    $.ajax({//Ajax
		   type: 'POST',
		   url: 'InterfazSolicitud_html.php',
		   async: false,
		   dataType: 'json',
		   data:({actionID: 'ValidafechaActivaCheked',fechaIni:fecha_1,fechaFin:fecha_2}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success: function(data){					
			 if(data.val==true){
			     for(i=1;i<=7;i++){
			             $('#Dia_'+i).attr('checked',false);//
                         $('#Campus_'+i).attr('disabled',true);
                         $('#Dia_'+i).attr('disabled',false);//
			         if(i==data.dia){
			             $('#Dia_'+i).attr('checked',true);//
                         $('#Campus_'+i).attr('disabled',false);
                     }else{
                         $('#Dia_'+i).attr('disabled',true);//
                     }
			     }//for
			 }else{
			     for(i=1;i<=7;i++){
			        
			             $('#Dia_'+i).attr('checked',false);//
                         $('#Campus_'+i).attr('disabled',true);
                         $('#Dia_'+i).attr('disabled',false);//
                     
			     }//for
			 }								
		   } 
	}); //AJAX
}//function ValidarFechasUnic