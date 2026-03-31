function BuscarData(name,Div,op=''){
    /***********************************/
    
    var CodigoPeriodo = $('#CodigoPeriodo').val();
    var Carrera_id    = $('#Carrera_id').val();
    
    if(Carrera_id==-1 || Carrera_id=='-1'){
        alert('Selecione un Programa Academico');
        /*******************************************/
        $('#Carrera_id').effect("pulsate", {times:3}, 500);
        $('#Carrera_id').css('border-color','#F00');
        return false;
        /*******************************************/
    }
    if(op==1){
        if(CodigoPeriodo==-1 || CodigoPeriodo=='-1'){
            alert('Selecione un Periodo');
            /*******************************************/
            $('#CodigoPeriodo').effect("pulsate", {times:3}, 500);
            $('#CodigoPeriodo').css('border-color','#F00');
            return false;
            /*******************************************/
        }    
    }//if
    
    
    $('#'+Div).html('<blink><span style="color:green;">Cargando...</span></blink>');
    
    	$.ajax({//Ajax
			  type: 'POST',
			  url: 'ReportesEntrevistas_html.php',
			  async: false,
			  dataType: 'html',
			  data:({actionID:name,CodigoPeriodo:CodigoPeriodo,Carrera_id:Carrera_id}),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#'+Div).html(data);
				}//data 
		  }); //AJAX
    /***********************************/
}//function BuscarData
function VerDetalle(){
    /***********************************/
    var CodigoPeriodo = $('#CodigoPeriodo').val();
    var Carrera_id    = $('#Carrera_id').val();
    
    if(Carrera_id==-1 || Carrera_id=='-1'){
        alert('Selecione un Programa Academico');
        /*******************************************/
        $('#Carrera_id').effect("pulsate", {times:3}, 500);
        $('#Carrera_id').css('border-color','#F00');
        return false;
        /*******************************************/
    }
    
    if(CodigoPeriodo==-1 || CodigoPeriodo=='-1'){
        alert('Selecione un Periodo');
        /*******************************************/
        $('#CodigoPeriodo').effect("pulsate", {times:3}, 500);
        $('#CodigoPeriodo').css('border-color','#F00');
        return false;
        /*******************************************/
    }
    
    
        var url  = 'ReportesEntrevistas_html.php?actionID=VerDetalle&CodigoPeriodo='+CodigoPeriodo+'&Carrera_id='+Carrera_id;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    
  
    /***********************************/
}//function VerDetalle