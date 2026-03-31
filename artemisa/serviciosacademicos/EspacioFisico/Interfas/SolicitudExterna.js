function SaveExterno(OP=''){
   
    var Modalidad       = $('#SolicitudExterna #Modalidad').val(); 
    var Unidad          = $('#Unidad').val();
    var Evento          = $('#Evento').val();
    var NumAsistentes   = $('#NumAsistentes').val(); 
    var Persona         = $('#Persona').val();
    var Telefono        = $('#Telefono').val();
    var Email           = $('#Email').val();
    var FechaIni        = $('#FechaIni').val();
    var FechaFin        = $('#FechaFin').val();
    var Programa        = $('#SolicitudExterna #Programa').val();
    
    if(!$.trim(Modalidad)){
        $('#SolicitudExterna #Modalidad').effect("pulsate", {times:3}, 500);
        $('#SolicitudExterna #Modalidad').css('border-color','#F00');
        return false;
    }
    
    if(!$.trim(Programa)){
        $('#SolicitudExterna #Programa').effect("pulsate", {times:3}, 500);
        $('#SolicitudExterna #Programa').css('border-color','#F00');
        return false;
    }
      
    if(!$.trim(Unidad)){
        /***************************************/
        $('#Unidad').effect("pulsate", {times:3}, 500);
        $('#Unidad').css('border-color','#F00');
        return false;
        /***************************************/
    }
    if(!$.trim(Evento)){
        /***************************************/
        $('#Evento').effect("pulsate", {times:3}, 500);
        $('#Evento').css('border-color','#F00');
        return false;
        /***************************************/
    } 
    if(!$.trim(NumAsistentes)){
       /***************************************/
        $('#NumAsistentes').effect("pulsate", {times:3}, 500);
        $('#NumAsistentes').css('border-color','#F00');
        return false;
        /***************************************/ 
    }
    
    if(!$.trim(Persona)){
       /***************************************/
        $('#Persona').effect("pulsate", {times:3}, 500);
        $('#Persona').css('border-color','#F00');
        return false;
        /***************************************/ 
    }
    
    if(!$.trim(Telefono)){
       /***************************************/
        $('#Telefono').effect("pulsate", {times:3}, 500);
        $('#Telefono').css('border-color','#F00');
        return false;
        /***************************************/ 
    }
    
    if(!$.trim(Email)){
       /***************************************/
        $('#Email').effect("pulsate", {times:3}, 500);
        $('#Email').css('border-color','#F00');
        return false;
        /***************************************/ 
    }
    
   var validaTipoAula = ValidaAdicional('#SolicitudExterna');
   if(validaTipoAula==false){
        alert('Por favor Selecionar Una de las Opciones de Aula');
        return false;
   }
    
    if(!$.trim(FechaIni)){
       /***************************************/
        $('#FechaIni').effect("pulsate", {times:3}, 500);
        $('#FechaIni').css('border-color','#F00');
        return false;
        /***************************************/ 
    }
    
    if(!$.trim(FechaFin)){
       /***************************************/
        $('#FechaFin').effect("pulsate", {times:3}, 500);
        $('#FechaFin').css('border-color','#F00');
        return false;
        /***************************************/ 
    }
    
    
    var ClaseTow   = 'HoraMulti';
    var DiasCheckd = CheckSemana('#SolicitudExterna',ClaseTow);
                 
     if(DiasCheckd==false){
        alert('Por Favor Selecionar o Inidcar los Dias del Evento');
        return false;
     }
     if(DiasCheckd){
        
        if($('#Dia_1').is(':checked')){ 
            var DiaUno     = MultiBox('#SolicitudExterna',ClaseTow+'_1'); 
        } 
        if($('#Dia_2').is(':checked')){ 
            var DiaDos     = MultiBox('#SolicitudExterna',ClaseTow+'_2'); 
        }
        if($('#Dia_3').is(':checked')){
            var DiaTres     = MultiBox('#SolicitudExterna',ClaseTow+'_3'); 
        }
        if($('#Dia_4').is(':checked')){ 
            var DiaCuatro     = MultiBox('#SolicitudExterna',ClaseTow+'_4'); 
        }
        if($('#Dia_5').is(':checked')){ 
            var DiaCinco     = MultiBox('#SolicitudExterna',ClaseTow+'_5'); 
        }
        if($('#Dia_6').is(':checked')){ 
            var DiaSeis     = MultiBox('#SolicitudExterna',ClaseTow+'_6'); 
        }
        if($('#Dia_7').is(':checked')){ 
            var DiaSiete     = MultiBox('#SolicitudExterna',ClaseTow+'_7'); 
        }
        if(DiaUno==false ||DiaDos==false || DiaTres==false || DiaCuatro==false || DiaCinco==false || DiaSeis==false || DiaSiete==false){
            alert('Por Favor Indicar las Horas del Evento segun el Dia Inidcado.\ Hora Inicial y Hora Final');
            return false;
        }
     }  
     
     if(OP==2){
        $('#actionID').val('UpdateSolicitudExterna');
         var text = 'Tenga en cuenta que los datos Modificados pueden Modificar los siguientes aspectos:\n Fechas \n Espacios Asignados \n \n Seguro desea Guardar la Modificaciones Realizadas...?';
     }else{
        $('#actionID').val('SaveSolicitudExterna');
     }
     /*****************************************************/
     
     if(OP==2){
        if(confirm(text)){
            $.ajax({//Ajax
                  type: 'POST',
                  url: 'SolicitudExterna_html.php',
                  async: false,
                  dataType: 'json',
                  data:$('#SolicitudExterna').serialize(),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                  success: function(data){
                       if(data.val===false){
                            alert(data.descrip);
                            return false;
                       }else if(data.val===true){
                            alert(data.descrip);
                            location.href='InterfazSolicitud_html.php';
                       }
                  }  
            });//Ajax
        }
     }else{
     
        $.ajax({//Ajax
              type: 'POST',
              url: 'SolicitudExterna_html.php',
              async: false,
              dataType: 'json',
              data:$('#SolicitudExterna').serialize(),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                   if(data.val===false){
                        alert(data.descrip);
                        return false;
                   }else if(data.val===true){
                        
                        alert(data.descrip+'\n \n Solicitud Num '+data.Soli_id);
                        location.href='InterfazSolicitud_html.php';
                   }
              }  
        });//Ajax
     }
     /*****************************************************/
    
}//function SolicitudExterna
function CheckSemana(name,clase){ 
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
function MultiBox(name,clase){
    $(name + ' input[type=text]').removeClass('error').removeClass('valid');
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
function validarNumeros(e) { // 1
		tecla = (document.all) ? e.keyCode : e.which; // 2
		if (tecla==8) return true; // backspace
		if (tecla==109) return true; // menos
    if (tecla==110) return true; // punto
		if (tecla==189) return true; // guion
		if (e.ctrlKey && tecla==86) { return true}; //Ctrl v
		if (e.ctrlKey && tecla==67) { return true}; //Ctrl c
		if (e.ctrlKey && tecla==88) { return true}; //Ctrl x
		if (tecla>=96 && tecla<=105) { return true;} //numpad
 
		patron = /[0-9]/; // patron
 
		te = String.fromCharCode(tecla); 
		return patron.test(te); // prueba
}//function validarNumeros	
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
function AutocompleGrupoMateria(){
    /****************************************************************************/
     var Programa = $('#Programa').val();
     var GruposAdd = $('#GruposAdd').val();
    
     $('#GrupoMateria').autocomplete({
					
            source: "SolicitudExterna_html.php?actionID=AutoGrupoMateria&Programa="+Programa+"&GruposAdd="+GruposAdd,
            minLength: 2,
            select: function( event, ui ) {
                
                    $('#GrupoMateria_id').val(ui.item.id);
                    ViewGrupoMateria();
                    
            }                
        });
        
        
    /****************************************************************************/
}//function AutocompleGrupoMateria
function ViewGrupoMateria(Op=''){
   
    if(!Op){
        var GrupoMateria_id = $('#GrupoMateria_id').val();
        
        $('#GruposAdd').val($('#GruposAdd').val()+'::'+GrupoMateria_id);
        
        
    }
    
    var GruposAdd = $('#GruposAdd').val();
    
       $.ajax({//Ajax
			   type: 'POST',
			   url: 'SolicitudExterna_html.php',
			   async: false,
			   dataType: 'html',
			   data:({actionID: 'ViewGruposMateria',GruposAdd:GruposAdd}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			   success: function(data){
				    $('#DivGruposMateria').html(data);
                                        							
			   } 
		}); //AJAX
       
}//function ViewGrupoMateria
function DeleteGrupoMateria(idGrupo){
    
    if(!$('#Grupo_'+idGrupo).is(':checked')){
        
            var Id_Eliminar = $('#GruposAdd').val();
            
            var Dato = '::'+idGrupo;
            
            var Result = Id_Eliminar.replace(Dato,"");
            
            $('#GruposAdd').val(Result);
    }
    
    ViewGrupoMateria(1);
}//function RerstGrupoMateria

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
    		   url: 'SolicitudExterna_html.php',
    		   async: false,
    		   dataType: 'json',
    		   data:$('#SolicitudExterna').serialize(),
    		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
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
                            		   url: 'SolicitudExterna_html.php',
                            		   async: false,
                            		   dataType: 'html',
                            		   data:({actionID: 'PintarError',Data:Datos}),
                            		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
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