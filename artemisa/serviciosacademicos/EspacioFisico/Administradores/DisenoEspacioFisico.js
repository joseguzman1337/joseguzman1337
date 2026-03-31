function VentanaExepciones(id){
    /*********************************************/
        var url  = '../Administradores/DisenoEspacioFisico_html.php?actionID=VentanaExepcion&registro='+id;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    /*********************************************/
}//function VentanaExepciones
function Programa(){
    /*********************************************/
    var Modalidad = $('#Modalidad').val();
    
        $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/DisenoEspacioFisico_html.php',
              async: false,
              dataType: 'html',
              data:({actionID: 'Programa',Modalidad:Modalidad}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    $('#Th_Programa').css('align','left')
            		$('#Th_Programa').html(data);
            	}//data 
        }); //AJAX
    /*********************************************/
}//function Programa
function AddExepcionView(status){
    /*********************************************/
    var Modalidad      = $('#Modalidad').val();
    var codigocarrera  = $('#Programa').val();
    var id             = $('#Registro').val();
    
    if(Modalidad==-1 || Modalidad=='-1'){
        /******************************************************/
        $('#Modalidad').effect("pulsate", {times:3}, 500);
        $('#Modalidad').css('border-color','#F00');
        return false;
        /******************************************************/ 
    }
    if(!$('#AllPrograma').is(':checked')){
        if(codigocarrera==-1 || codigocarrera=='-1'){
            /******************************************************/
            $('#Programa').effect("pulsate", {times:3}, 500);
            $('#Programa').css('border-color','#F00');
            return false;
            /******************************************************/ 
        }
    }else{
        var codigocarrera  = 1;
    }
    /*********************************************/
    
    $.ajax({//Ajax
          type: 'POST',
          url: '../Administradores/DisenoEspacioFisico_html.php',
          async: false,
          dataType: 'json',
          data:({actionID: 'Exepciones',codigocarrera:codigocarrera,id:id,status:status,Modalidad:Modalidad}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
                 
                if(data.val===false){
                    $("#msg-success").addClass('msg-error');
                    $("#msg-success").css('display','block');
                    $("#msg-success").html('<p>' + data.descrip + '</p>');
                }else{
                    $("#msg-success").removeClass('msg-error');
                    $("#msg-success").css('display','');
                    $("#msg-success").html('<p>' + data.descrip + '</p>');
                    $("#msg-success").delay(900).fadeOut(800);
                    ViewPreferenciaRestricion(id);
                }
        	}//data 
    }); //AJAX
    /*********************************************/
}//function AddExepcionView
function Activar(){
    /*********************************************/
    var Espacio = $('#Espacio').val();
    
    if(Espacio>=4 || Espacio>='4'){
        $('#Tr_Jerarquia').css('visibility','visible');
        if(Espacio==4){
            $('.Th_Jerarquia').css('visibility','collapse');
            $('.Tr_Detalle').css('visibility','collapse');
            $('#v_descrip').css('visibility','collapse');
            $('#v_Dir').css('visibility','collapse');
            /**********************************************/
            $('#Edificio').val('-1');
            $('#T_salon').val('-1');
            $('#Capacidad').val('');
            /**********************************************/
        }else{
            $('.Th_Jerarquia').css('visibility','visible');
            $('.Tr_Detalle').css('visibility','visible');
            $('#v_descrip').css('visibility','collapse');
            $('#v_Dir').css('visibility','collapse');
        }
    }else{
        $('#Tr_Jerarquia').css('visibility','collapse');
        $('.Tr_Detalle').css('visibility','collapse');
        $('#v_descrip').css('visibility','visible');
        $('#v_Dir').css('visibility','visible');
        $('#Campus').val('-1'); 
        $('#Edificio').val('-1');
        $('#T_salon').val('-1');
        $('#Capacidad').val('');
    }
    /*********************************************/
}//function Activar
function GuardarEspacio(){ 
    if(Validar()){
        /**********************************************/
        $.ajax({//Ajax
                  type: 'POST',
                  url: '../Administradores/DisenoEspacioFisico_html.php',
                  async: false,
                  dataType: 'json',
                  data:$('#DisenoEspacio').serialize(),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                  success: function(data){
                   // console.log(data);
                        if(data.val===false){
                            $("#msg-success").addClass('msg-error');
                            $("#msg-success").css('display','block');
                            $("#msg-success").html('<p>' + data.descrip + '</p>');
                        }else{
                            $("#msg-success").removeClass('msg-error');
                            $("#msg-success").css('display','');
                            $("#msg-success").html('<p>' + data.descrip + '</p>');
                            $("#msg-success").delay(900).fadeOut(800);
                            if(confirm('Desea Adicionar Alguna Exepcion o Restriccion')){
                                VentanaExepciones(data.id);
                            }else{
                                //consola direcionar
                            }
                        }
                	}//data 
            }); //AJAX
        /**********************************************/
    }
}//function SaveEspacio
function BuscarEdificio(){
   /**************************************************/ 
   var Campus = $('#Campus').val(); 
   
       $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/DisenoEspacioFisico_html.php',
              async: false,
              dataType: 'html',
              data:({actionID: 'Edificio',Campus:Campus}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    $('#Th_Edificio').html(data);
               }
        }); //AJAX
   /**************************************************/     
}//function Edificio
function DetalleDiseno(){
    /*****************************************************/
    if(aSelected.length==1){
		alert(aSelected[0]);
          var id = aSelected[0];
            
          }else{
             return false;
          }
		  
		  $.ajax({//Ajax
			   type: 'POST',
			   url: '../Administradores/DisenoEspacioFisico_html.php',
			   async: false,
			   dataType: 'html',
			   data:({actionID: 'Editar',id:id}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			   success: function(data){
						
				    $('#container').html(data);
								
			   } 
		}); //AJAX
    /*****************************************************/           
}//function DetalleDiseno
function UpdateEspacio(){
    if(confirm('Desea Modificar los Datos...?')){
        if(Validar()){
            /**********************************************/
            $.ajax({//Ajax
                      type: 'POST',
                      url: '../Administradores/DisenoEspacioFisico_html.php',
                      async: false,
                      dataType: 'json',
                      data:$('#DisenoEspacio').serialize(),
                      error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                      success: function(data){
                       // console.log(data);
                            if(data.val===false){
                                $("#msg-success").addClass('msg-error');
                                $("#msg-success").css('display','block');
                                $("#msg-success").html('<p>' + data.descrip + '</p>');
                            }else{
                                $("#msg-success").removeClass('msg-error');
                                $("#msg-success").css('display','');
                                $("#msg-success").html('<p>' + data.descrip + '</p>');
                                $("#msg-success").delay(900).fadeOut(800);
                                //Direcionar a consola
                            }
                    	}//data 
                }); //AJAX
            /**********************************************/
        }
    }
}//function UpdateEspacio
function Validar(){
     /**********************************************/
    var Espacio = $('#Espacio').val();
    
    if(Espacio==-1 || Espacio=='-1'){
        /******************************************************/
        $('#Espacio').effect("pulsate", {times:3}, 500);
        $('#Espacio').css('border-color','#F00');
        return false;
        /******************************************************/ 
    }
    
    var newEspacio = $('#newEspacio').val();
    
    if(!$.trim(newEspacio)){
        /******************************************************/
        $('#newEspacio').effect("pulsate", {times:3}, 500);
        $('#newEspacio').css('border-color','#F00');
        return false;
        /******************************************************/ 
    }
    var Espacio = $('#Espacio').val();
    var newEspacio = $('#newEspacio').val();
    var Descrip    = $('#Descrip').val();
    var Dirrecion  = $('#Dirrecion').val();
    var Acceso     = $('#Acceso').is(':checked');
    var FechaIni   = $('#FechaIni').val();
    var FechaFin   = $('#FechaFin').val();
    /************************************/
    var Campus    = '';
    var T_salon   = '';
    var Capacidad = '';
    
    if(Espacio>=4 || Espacio>='4'){
       
        if(Espacio==4){//edificio
            var Campus = $('#Campus').val(); 
            
            if(Campus==-1 || Campus=='-1'){
                /******************************************************/
                $('#Campus').effect("pulsate", {times:3}, 500);
                $('#Campus').css('border-color','#F00');
                return false;
                /******************************************************/ 
            }            
        }else{//aulas y demas
            var T_salon   = $('#T_salon').val();
            
            if(T_salon==-1 || T_salon=='-1'){
                /******************************************************/
                $('#T_salon').effect("pulsate", {times:3}, 500);
                $('#T_salon').css('border-color','#F00');
                return false;
                /******************************************************/ 
            } 
            var Capacidad = $('#Capacidad').val();
            
            if(!$.trim(Capacidad)){
                /******************************************************/
                $('#Capacidad').effect("pulsate", {times:3}, 500);
                $('#Capacidad').css('border-color','#F00');
                return false;
                /******************************************************/ 
             } 
        }
    }else{
       if(!$.trim(Descrip)){
        /******************************************************/
        $('#Descrip').effect("pulsate", {times:3}, 500);
        $('#Descrip').css('border-color','#F00');
        return false;
        /******************************************************/ 
       } 
       if(!$.trim(Dirrecion)){
        /******************************************************/
        $('#Dirrecion').effect("pulsate", {times:3}, 500);
        $('#Dirrecion').css('border-color','#F00');
        return false;
        /******************************************************/ 
       } 
    }
    
    if(!$.trim(FechaIni)){
        /******************************************************/
        $('#FechaIni').effect("pulsate", {times:3}, 500);
        $('#FechaIni').css('border-color','#F00');
        return false;
        /******************************************************/ 
       } 
       
     if(!$.trim(FechaFin)){
        /******************************************************/
        $('#FechaFin').effect("pulsate", {times:3}, 500);
        $('#FechaFin').css('border-color','#F00');
        return false;
        /******************************************************/ 
       }  
      
     return true;  
}//function Validar
function CambiarRestricion(status,id,Buscar_id){
    /*********************************************************/
     if(status==1){
        var text = 'Desea Cambiar a Preferencia...?';
    }else{
        var text = 'Desea Cambiar a Restriccion...?';
    }
    if(confirm(text)){
        $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/DisenoEspacioFisico_html.php',
              async: false,
              dataType: 'json',
              data:({actionID: 'CambiarStatus',id:id,status:status}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
               // console.log(data);
                    if(data.val===false){
                        $("#msg-success").addClass('msg-error');
                        $("#msg-success").css('display','block');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                    }else{
                        $("#msg-success").removeClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                        $("#msg-success").delay(900).fadeOut(800);
                         ViewPreferenciaRestricion(Buscar_id);
                    }
            	}//data 
        }); //AJAX
    }
    /*********************************************************/
}//function CambiarRestricion
function CambiarEstado(id,stado,Buscar_id){
    /*********************************************************/
    if(stado==100){
        var text = 'Desea Activar...?';
    }else{
        var text = 'Desea Inactivar...?';
    }
    
    if(confirm(text)){
       $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/DisenoEspacioFisico_html.php',
              async: false,
              dataType: 'json',
              data:({actionID: 'CambiarStado',id:id,stado:stado}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
               // console.log(data);
                    if(data.val===false){
                        $("#msg-success").addClass('msg-error');
                        $("#msg-success").css('display','block');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                    }else{
                        $("#msg-success").removeClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                        $("#msg-success").delay(900).fadeOut(800);
                        ViewPreferenciaRestricion(Buscar_id);
                    }
            	}//data 
        }); //AJAX 
    }
     /*********************************************************/
}//function CambiarEstado
function ViewPreferenciaRestricion(id){
   /*********************************************************/
         $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/DisenoEspacioFisico_html.php',
              async: false,
              dataType: 'html',
              data:({actionID: 'ViewPrerenciasRestricion',id:id}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
               // console.log(data);
                    $('#ViewExepcion').html(data)
            	}//data 
        }); //AJAX 
   /*********************************************************/
}//function ViewPreferenciaRestricion
function EditarEspacio(){
    /********************************************************/
   var id = $('#id_Carga').val();
   
   if(!$.trim(id)){
        alert('Selecione un item de la tabla.');
        return false;
   }
		  
		  $.ajax({//Ajax
					   type: 'POST',
					   url: '../Administradores/DisenoEspacioFisico_html.php',
					   async: false,
					   dataType: 'html',
					   data:({actionID: 'Editar',id:id}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
								
								$('#container').html(data);
										
					   } 
				}); //AJAX
    /********************************************************/
}//function EditarEspacio
function ExepcioneConsola(){
    /********************************************************/
    var id = $('#id_Carga').val();
    
     if(!$.trim(id)){
        alert('Selecione un item de la tabla.');
        return false;
   }
		  //DisenoEspacioFisico_html.php?actionID=VentanaExepcion&registro='+id
		  $.ajax({//Ajax
					   type: 'POST',
					   url: '../Administradores/DisenoEspacioFisico_html.php',
					   async: false,
					   dataType: 'html',
					   data:({actionID: 'VentanaExepcion',registro:id,Op:1}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
								
								$('#container').html(data);
										
					   } 
				}); //AJAX
    /********************************************************/
}//function ExepcioneConsola
function NuevoDiseno(){
    $.ajax({//Ajax
		   type: 'POST',
		   url: '../Administradores/DisenoEspacioFisico_html.php',
		   async: false,
		   dataType: 'html',
		   data:({actionID:''}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
					
					$('#container').html(data);
							
		   } 
	}); //AJAX
}//function NuevoDiseno
function CargarNum(i,id){
   $('#id_Carga').val('');
   $('#Tr_File_'+i).removeClass('even'); 
   $('#Tr_File_'+i).removeClass('odd');
   $('#Tr_File_'+i).addClass('ClasOnclikColor');
   $('#id_Carga').val(id);
}//function CargarNum
function CambioClass(i){
   $.ajax({//Ajax   
          type:'POST',
          url: '../Interfas/InterfazSolicitud_html.php',
          async: false,
          dataType: 'json',
          data:({actionID:'TipoNumber',Numero:i}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.num==1){
                    $('#Tr_File_'+i).addClass('odd'); 
               }else{
                    $('#Tr_File_'+i).addClass('even');
               }
        	}//data 
            
       });//AJAX 
  $('#Tr_File_'+i).removeClass('ClasOnclikColor');
  
}//function CambioClass
function InavilitaPrograma(){
    if($('#AllPrograma').is(':checked')){
        $('#Programa').attr('disabled',true);
    }else{
         $('#Programa').attr('disabled',false);
    }
}//function InavilitaPrograma