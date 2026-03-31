function PorcentajeSave(){
    /********************************************/
    var NumPorcentaje = $('#PorcentajeAdd #NumPorcentaje').val();
    var Periodo       = $('#PorcentajeAdd #Periodo').val();
     if(!$.trim(NumPorcentaje)){
        $('#PorcentajeAdd #NumPorcentaje').effect("pulsate", {times:3}, 500);
        $('#PorcentajeAdd #NumPorcentaje').css('border-color','#F00');
        return false; 
    }
    /********************************************/
     $.ajax({//Ajax
		   type: 'POST',
		   url: 'SobrecupoPorcentaje_html.php',
		   async: false,
		   dataType: 'json',
		   data:({actionID: 'SavePorcentaje',Num:NumPorcentaje,Periodo:Periodo}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
				if(data.val===false){
				    alert(data.descrip);
                    return false;
				}else{
				    alert(data.descrip);
                    $('#SavePorcentaje').css('display','none');
				}		
		   } 
	}); //AJAX
    /********************************************/
}//function PorcentajeSave
function HoraSave(){
    /********************************************/    
    var Periodo       = $('#HorasAdmin #Periodo').val();
    var Sede          = $('#HorasAdmin #Sede').val();
    var Hora_ini      = $('#HorasAdmin #Hora_ini').val();
    var Hora_fin      = $('#HorasAdmin #Hora_fin').val();
    
     if(Sede=='-1' || Sede==-1){
        $('#HorasAdmin #Sede').effect("pulsate", {times:3}, 500);
        $('#HorasAdmin #Sede').css('border-color','#F00');
        return false;
    }
    if(!$.trim(Hora_ini) || !$.trim(Hora_fin)){
        if(!$.trim(Hora_ini)){
            $('#HorasAdmin #Hora_ini').effect("pulsate", {times:3}, 500);
            $('#HorasAdmin #Hora_ini').css('border-color','#F00');
        }
        if(!$.trim(Hora_fin)){
            $('#HorasAdmin #Hora_fin').effect("pulsate", {times:3}, 500);
            $('#HorasAdmin #Hora_fin').css('border-color','#F00');
        }
        return false;
    }
    /********************************************/
     $.ajax({//Ajax
		   type: 'POST',
		   url: 'SobrecupoPorcentaje_html.php',
		   async: false,
		   dataType: 'json',
		   data:({actionID: 'SaveHora',Periodo:Periodo,Sede:Sede,Hora_ini:Hora_ini,Hora_fin:Hora_fin}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
				if(data.val===false){
				    alert(data.descrip);
                    return false;
				}else{
				    alert(data.descrip);
                    $('#SaveHora').css('display','none');
				}		
		   } 
	}); //AJAX
    /********************************************/
}//function HoraSave
function VerSobrecupoolicitud(id){
    /**********************************************/
     
   $('#VentanaNew').css('z-index','9999');
   $('#VentanaNew').css('display','block');
   $('#VentanaNew').css('left','350px');
   $('#VentanaNew').css('opacity','1');
   $('#VentanaNew').css('position','absolute');
   $('#VentanaNew').css('top','2328.5px');
   $('#VentanaNew').css('height','650px');
   $('#VentanaNew').css('width','650px');
   
   $('#VentanaNew').bPopup({
        content:'iframe', //'ajax', 'iframe' or 'image' xlink
        //contentContainer:'.content',
        iframeAttr:['scrolling="no" style="width:95%;height:95%" frameborder="54"'],
        //escClose:[true],
        loadUrl:'SobrecupoPorcentaje_html.php?actionID=ConsolaSobrecupo&id='+id,
  });    
    /**********************************************/
}//function VerSobrecupoolicitud
function SobreCupoAprobado(id){
    /********************************************/
    $.ajax({//Ajax
		   type: 'POST',
		   url: 'SobrecupoPorcentaje_html.php',
		   async: false,
		   dataType: 'json',
		   data:({actionID: 'AprobarSobrecupo',id:id}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		   success: function(data){
				if(data.val===false){
				    alert(data.descrip);
                    return false;
				}else{
				    alert(data.descrip);
                    $('#AprobarSobrecupo').css('display','none');
				}		
		   } 
	}); //AJAX
    /********************************************/
}//function SobreCupoAprobado