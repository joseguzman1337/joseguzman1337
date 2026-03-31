function SeleccionVer(Estudiante_id){
    
    var url  = 'Reporte_Bienestar_html.php?actionID=Detalle&Estudiante_id='+Estudiante_id+'&Op=1';
    
    var centerWidth = (window.screen.width - 850) / 2;
    var centerHeight = (window.screen.height - 700) / 2;
    
    var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
    var mypopup = window.open(url,"",opciones);
    //para poner la ventana en frente
    window.focus();
    mypopup.focus();
    
}/*function SeleccionVer*/
function TalleresVer(Estudiante_id){
    
    var url  = 'Reporte_Bienestar_html.php?actionID=Detalle&Estudiante_id='+Estudiante_id+'&Op=2';
    
    var centerWidth = (window.screen.width - 850) / 2;
    var centerHeight = (window.screen.height - 700) / 2;
    
    var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
    var mypopup = window.open(url,"",opciones);
    //para poner la ventana en frente
    window.focus();
    mypopup.focus();
    
}/*function TalleresVer*/
function SaludVer(Estudiante_id){
    
    var url  = 'Reporte_Bienestar_html.php?actionID=Detalle&Estudiante_id='+Estudiante_id+'&Op=3';
    
    var centerWidth = (window.screen.width - 850) / 2;
    var centerHeight = (window.screen.height - 700) / 2;
    
    var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
    var mypopup = window.open(url,"",opciones);
    //para poner la ventana en frente
    window.focus();
    mypopup.focus();
    
}/*function SaludVer*/
function GrupoVer(Estudiante_id){
    
    var url  = 'Reporte_Bienestar_html.php?actionID=Detalle&Estudiante_id='+Estudiante_id+'&Op=4';
    
    var centerWidth = (window.screen.width - 850) / 2;
    var centerHeight = (window.screen.height - 700) / 2;
    
    var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
    var mypopup = window.open(url,"",opciones);
    //para poner la ventana en frente
    window.focus();
    mypopup.focus();
    
}/*function GrupoVer*/
function IrDisplay(Op){
   
    $('#Carga').html('<img src="../../images/engranaje-09.gif" />');//engranaje-09.gif
    
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'Reporte_Bienestar_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID: 'IrDisplay',Op:Op}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	  success: function(data){
    			$('#Carga').html(data);
    		}//data 
      }); //AJAX
    
}/*function IrDisplay*/
function CambiarPerido(id,Est,op,Tipo='',idBienestar){
    
    var periodo = $('#Periodo_'+id).val();
   
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'Reporte_Bienestar_html.php',
    	  async: false,
    	  dataType: 'json',
    	  data:({actionID: 'CambiarPeriodo',periodo:periodo,
                                            Est:Est,
                                            op:op,
                                            Tipo:Tipo,
                                            idBienestar:idBienestar}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	  success: function(data){
    			if(data.val==false){
    			  alert(data.descrip);
                  return false;
    			}else{
    			     alert(data.descrip);
    			}
    		}//data 
      }); //AJAX
}//function CambiarPerido
function FechaSave(id,Est,idBienestar){
    
    var fecha = $('#'+id).val();
    
    if($.trim(fecha)){
        /********************************************/
        $.ajax({//Ajax
        	  type: 'POST',
        	  url: 'Reporte_Bienestar_html.php',
        	  async: false,
        	  dataType: 'json',
        	  data:({actionID: 'CambiarPeriodo',periodo:fecha,
                                                Est:Est,
                                                op:4,
                                                Tipo:1,
                                                idBienestar:idBienestar}),
        	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        	  success: function(data){
        			if(data.val==false){
        			  alert(data.descrip);
                      return false;
        			}else{
        			     alert(data.descrip);
        			}
        		}//data 
          }); //AJAX
        /********************************************/
    }
    
}/*function FechaSave*/
function ExportarExel(){
    	location.href='Reporte_Bienestar_html.php?actionID=Excel';
}/*function ExportarExel*/