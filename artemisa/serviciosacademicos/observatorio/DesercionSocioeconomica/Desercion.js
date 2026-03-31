
function Graficar(CodigoCarrera){
        var CodigoPeriodo   = $('#CodigoPeriodo').val();
        var url  = 'GraficasDesercion.php?CodigoPeriodo='+CodigoPeriodo+'&CodigoCarrera='+CodigoCarrera;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}//function Graficar
function VerBarras(ruta,CodigoPeriodo){
        /*************************************************************/
        var Index    = $('#Index').val();
        $('#Cadena').val('');
        for(j=0;j<Index;j++){
           /*************************************/
           var Valor    = $('#CodigoCarrera_'+j).val();
           $('#Cadena').val($('#Cadena').val()+'-'+Valor);
           /*************************************/ 
        }
        
        var Cadena  = $('#Cadena').val();    
        /*************************************************************/
        //var CodigoPeriodo   = $('#CodigoPeriodo').val();   
        //GraficaProgramaTotal.php
        var url  = ruta+'.php?CodigoPeriodo='+CodigoPeriodo+'&Cadena='+Cadena;
        //alert(url);
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}
function CargarInfo(){
    /********************************/
    var periodo = $('#Periodo').val();
    var tipo    = $('#TypeDesercion').val();
    
    if(periodo==-1 || periodo=='-1'){
       /**********************************/
            alert('Selecione un Periodo');
            $('#Periodo').effect("pulsate", {times:3}, 500);
            $('#Periodo').css('border-color','#F00');
			return false; 
       /**********************************/   
    }//if
    if(tipo==-1 || tipo=='-1'){
        /**********************************/
            alert('Selecione un Tipo de Desercion');
            $('#TypeDesercion').effect("pulsate", {times:3}, 500);
            $('#TypeDesercion').css('border-color','#F00');
			return false; 
        /**********************************/
    }//if
    
    var Periodo         = $('#Periodo').val();
    var TypeDesercion   = $('#TypeDesercion').val();
    
    $('#Rerporte').html('<blink><span style="color:green;">Cargando...</span></blink>');
    
    	$.ajax({//Ajax
			  type: 'POST',
			  url: 'Desercion_html.php',
			  async: false,
			  dataType: 'html',
			  data:({actionID: 'BuscarInfo',Periodo:Periodo,
                                            TypeDesercion:TypeDesercion}),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#Rerporte').html(data);
				}//data 
		  }); //AJAX
    /********************************/
}
function GenerarGraficAnual(id){
   /*****************************************************/
   var CodigoPeriodo    = $('#CodigoPeriodo').val();
   
   
        var url  = 'DesercionGraficAnual.php?CodigoPeriodo='+CodigoPeriodo+'&CodigoCarrera='+id;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
   /*****************************************************/ 
}
function Reporte(id){
     var CodigoPeriodo    = $('#CodigoPeriodo').val();
     
        var url  = 'PoblacionCarreraSemestre.php?CodigoPeriodo='+CodigoPeriodo+'&CodigoCarrera='+id;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}
function VerEstudiantes(CodigoPeriodo,CodigoCarrera,Semestre){   
    
        var url  = 'PoblacionCarreraSemestre.php?CodigoPeriodo='+CodigoPeriodo+'&CodigoCarrera='+CodigoCarrera+'&VerEstudiantes=1&Semestre='+Semestre;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}