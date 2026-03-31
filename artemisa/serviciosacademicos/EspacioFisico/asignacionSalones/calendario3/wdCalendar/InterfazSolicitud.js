/**********************************************/
function CreacionEditarEspacio(){
    /***************************************************/
      
    $.ajax({//Ajax
		   type: 'POST',
		   url: '../Administradores/Admin_Categorias_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID: ''}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
		   data:({actionID: 'Ver_EstadoSolicitud',id:id}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
   var validaTipoAula = ValidaAdicional('#SolicitudEspacio');
   if(validaTipoAula==false){
        alert('Por favor Selecionar Una de las Opciones');
        return false;
   }
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
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#container').html(data);
							
		   } 
	}); //AJAX
    /**************************************************/  
}//function AsignarEspacio
function BuscarDisponibilidad(i,j){
    /****************************************************/
    
   $('#VentanaNew').css('z-index','9999');
   $('#VentanaNew').css('display','block');
   $('#VentanaNew').css('left','350px');
   $('#VentanaNew').css('opacity','1');
   $('#VentanaNew').css('position','absolute');
   $('#VentanaNew').css('top','2328.5px');
   $('#VentanaNew').css('height','700px');
   $('#VentanaNew').css('width','1200px');
   $('#actionID').val('BuscarDisponibilidad');
   //$('#VentanaNew').html('<img src="../../mgi/images/engranaje-09.gif" width="90" />');
    
   $('#VentanaNew').bPopup({
        content:'iframe', //'ajax', 'iframe' or 'image' xlink
        //contentContainer:'.content',
        iframeAttr:['scrolling="no" style="width:95%;height:95%" frameborder="54"'],
        //escClose:[true],
        loadUrl:'InterfazSolicitud_html.php?'+$('#FromAsignacion').serialize()+'&i='+i+'&j='+j,
  });    

    /****************************************************/
}//function BuscarDisponibilidad
function EliminarSolicitud(){
    /******************************************************/
    var id =  $('#Id_Solicitud').val();
    
    if(!$.trim(id)){
        alert('Selecionar un Item de la Tabla');
        return false;
    }
    
    if(confirm('Desea Eliminar La Solicitud')){
       
        
        $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'InterfazSolicitud_html.php',
    		   async: false,
    		   dataType: 'json',
    		   data:({actionID: 'EliminarSolicitud',id:id}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
				if(data.val==false){
				    alert(data.descrip);
                    return false;
				}else{
				  
                      $.ajax({//Ajax
                    		   type: 'POST',
                    		   url: 'InterfazSolicitud_html.php',
                    		   async: false,
                    		   dataType: 'html',
                    		   data:({actionID: 'EditarSolicitud',id:id}),
                    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    		   success: function(data){
                    					
                					$('#container').html(data); 
                                }    
                      	}); //AJAX   
                      
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
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
    if(confirm('Seguro que desea Eliminar la Fecha Asignada...?')){
        
        $.ajax({//Ajax   
          type: 'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'EliminarAsigancion',id:id}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                    		   data:({actionID: 'Ver_EstadoSolicitud',id:data.id}),
                    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
function Otros(id,id_Soli){ 
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
        loadUrl:'InterfazSolicitud_html.php?actionID=OmitirFecha&id='+id+'&id_Soli='+id_Soli,
  }); 

    /****************************************************/
}//function Otros
function SaveOmitirFecha(id,id_Soli){
    /************************************************/
    
    var TexObs = $('#TexObs').val();
    $('#OmitirSave').css('display','none');
    
    $.ajax({//Ajax   
          type: 'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'SaveOmitir',id:id,TexObs:TexObs}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val==false){
                        alert(data.descrip);
                        $('#OmitirSave').css('display','inline');
                        return false;
                    }else{
                        alert(data.descrip);
                        VerDetalleContenido(id_Soli);
                       }
        	}//data 
                
        });
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
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
                $('#Div_ContenidoDetalle', window.parent.document).html(data);
            }//data 
                
        });
    /*****************************************************/
}//function VerDetalleContenido
function VerCambio(id,id_Soli){ 
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
        loadUrl:'InterfazSolicitud_html.php?actionID=VerCambio&id='+id+'&id_Soli='+id_Soli,
  }); 

    /****************************************************/
}//function VerCambio
function SaveCambioEstado(id,id_Soli){
    /************************************************/
    
    $('#CambioEstado').css('display','none');
    
    $.ajax({//Ajax   
          type: 'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'SaveCambioEstado',id:id}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val==false){
                        alert(data.descrip);
                        $('#CambioEstado').css('display','inline');
                        return false;
                    }else{
                        alert(data.descrip);
                        VerDetalleContenido(id_Soli);
                       }
        	}//data 
                
        });
    /************************************************/
}//function SaveCambioEstado
function EspacioAutomatico(){
    /**************************************************/
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
function AutomaticoAsignacion(id_Soli){ 
    /**************************************************/
    $('#actionID').val('BuscarAutomatico');
    //alert($('#actionID').val());
    $('#DivDistrator').html('<img src="../imagenes/engranaje-13.gif" />Este Proceso Puede Tardar Unos Minutos...');
     $.ajax({//Ajax   
          type:'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:$('#FromAsignacion').serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                                  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
    $('#actionID').val('AsignacionManual');
    //alert($('#actionID').val());
    
     $.ajax({//Ajax   
          type:'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:$('#AsignacionManual').serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val==false){
                        alert(data.descrip);
                        return false;
                    }else{
                        alert(data.descrip);
                        VerDetalleContenido(data.id_Soli,1); 
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
function ColorNeutro(i,fecha){
  $('#Tr_File_'+i).css('background','white'); 
    
     $.ajax({//Ajax   
          type:'POST',
          url: 'InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'TipoNumber',Numero:fecha}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.num==1){
                    
                        $('#Tr_File_'+i).css('background','#e2e4ff'); 
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
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
    if(confirm('Seguro Desea Eliminar las Fecha(s) Indicadas..?')){
        var Num = $('#Num_'+i).val();
        var id = '';
       
        for(j=0;j<Num;j++){
            if($('#CheckEliminar_'+j).is(':checked')){
                var Dato = $('#CheckEliminarDato_'+j).val();
                
                $.ajax({//Ajax   
                  type: 'POST',
                  url: 'InterfazSolicitud_html.php',
                  async: false,
                  dataType: 'json',
                  data:({actionID:'EliminarAsigancion',id:Dato}),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                  success: function(data){
                       if(data.val==false){
                                alert(data.descrip);
                                return false;
                        }else{
                            id = data.id;
                             Msg = data.descrip;
                        }
                	}//data 
                        
                });//AJAX
            }
        }//for
        
        alert('Se Han Eliminado las Fecha(s) de Forma Correcta.');
        
         $.ajax({//Ajax
    		   type: 'POST',
    		   url: 'InterfazSolicitud_html.php',
    		   async: false,
    		   dataType: 'html',
    		   data:({actionID: 'Ver_EstadoSolicitud',id:id}),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		   success: function(data){
    					
    					$('#container').html(data);
    							
    		   } 
    	}); //AJAX 
    }
}//function EliminarAll
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
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		   success: function(data){
    					$('#Th_Grupo').html(data);
    		   } 
    	}); //AJAX
}//function VerMultiGroups
function ModificarRegistroUnico(Indix){
    
    if(confirm('Seguro Desea Modificar...?')){
    
            var idAsignacion        = $('#idAsignacion_'+Indix).val();
            var FechaAsignacion     = $('#FechaAsignacion_'+Indix).val();
            var HoraInicial         = $('#HoraInicial_'+Indix).val();
            var HoraFin             = $('#HoraFin_'+Indix).val();
            
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
            		   data:({actionID: 'ModificarUnicoLog',idAsignacion:idAsignacion,FechaAsignacion:FechaAsignacion,HoraInicial:HoraInicial,HoraFin:HoraFin}),
            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
                            		   data:({actionID: 'Ver_EstadoSolicitud',id:data.idSolicituid}),
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
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
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#container').html(data);
							
		   } 
	}); //AJAX
}//function SolicitudExterna(){}