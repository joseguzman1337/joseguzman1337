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
    var mod    = $('#ModalidadDesercion').val();
    
    if(periodo==-1 || periodo=='-1'){
       /**********************************/
            alert('Selecione un Periodo');
            $('#Periodo').effect("pulsate", {times:3}, 500);
            $('#Periodo').css('border-color','#F00');
			$('#definicionesDesercion').css('display','block');
			$('#Rerporte').html('');
			return false; 
       /**********************************/   
    }//if
    if(tipo==-1 || tipo=='-1'){
        /**********************************/
            alert('Selecione un Tipo de Desercion');
            $('#TypeDesercion').effect("pulsate", {times:3}, 500);
            $('#TypeDesercion').css('border-color','#F00');
			$('#definicionesDesercion').css('display','block');
			$('#Rerporte').html('');
			return false; 
        /**********************************/
    }//if
    if((tipo==3 || tipo=='3') && (mod=="-1" || mod==-1)){
        /**********************************/
            alert('Selecione una Modalidad Académica');
            $('#ModalidadDesercion').effect("pulsate", {times:3}, 500);
            $('#ModalidadDesercion').css('border-color','#F00');
			$('#definicionesDesercion').css('display','block');
			$('#Rerporte').html('');
			return false; 
        /**********************************/
    }//if
    
    var Periodo         = $('#Periodo').val();
    var TypeDesercion   = $('#TypeDesercion').val();
    var TypeModalidad   = $('#ModalidadDesercion').val();
    var TypePrograma   = $('#ProgramaDesercion').val();
	
    $('#definicionesDesercion').css('display','none');
    $('#Rerporte').html('<blink><span style="color:green;">Cargando...</span></blink>');
    $('#ModalidadDesercion').css('border-color','#FFE');
    $('#TypeDesercion').css('border-color','#FFE');
    $('#Periodo').css('border-color','#FFE');
    
    	$.ajax({//Ajax
			  type: 'POST',
			  url: 'Desercion_html.php',
			  async: false,
			  dataType: 'html',
			  data:({actionID: 'BuscarInfo',Periodo:Periodo,
                                            TypeDesercion:TypeDesercion, TypeModalidad:TypeModalidad, TypePrograma:TypePrograma}),
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
function CargarInfo2(){
     /********************************/
    var periodo = $('#Periodo').val();
    var tipo    = $('#TypeDesercion').val();
    
    if(periodo==-1 || periodo=='-1'){
       /**********************************/
            alert('Selecione un Periodo');
            $('#Periodo').effect("pulsate", {times:3}, 500);
            $('#Periodo').css('border-color','#F00');
			$('#definicionesDesercion').css('display','block');
			$('#Rerporte').html('');
			return false; 
       /**********************************/   
    }//if
    if(tipo==-1 || tipo=='-1'){
        /**********************************/
            alert('Selecione un Tipo de Desercion');
            $('#TypeDesercion').effect("pulsate", {times:3}, 500);
            $('#TypeDesercion').css('border-color','#F00');
			$('#definicionesDesercion').css('display','block');
			$('#Rerporte').html('');
			return false; 
        /**********************************/
    }//if
    
    var Periodo         = $('#Periodo').val();
    var TypeDesercion   = $('#TypeDesercion').val();
    
    $('#definicionesDesercion').css('display','none');
    $('#Rerporte').html('<blink><span style="color:green;">Cargando...</span></blink>');
    
    	$.ajax({//Ajax
			  type: 'POST',
			  url: 'Desercion_html.php',
			  async: false,
			  dataType: 'html',
			  data:({actionID: 'BuscarInfo2',Periodo:Periodo,
                                            TypeDesercion:TypeDesercion}),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#Rerporte').html(data);
				}//data 
		  }); //AJAX
    /********************************/
}//function CargarInfo2
function GraficarRetencion(CodigoCarrera){
        var CodigoPeriodo   = $('#CodigoPeriodo').val();
        var url  = 'GraficasRetencion.php?CodigoPeriodo='+CodigoPeriodo+'&CodigoCarrera='+CodigoCarrera;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}//function Graficar
function Validar(){
     /********************************/
    var periodo = $('#Periodo').val();
    var tipo    = $('#TypeFormulario').val();
    
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
            $('#TypeFormulario').effect("pulsate", {times:3}, 500);
            $('#TypeFormulario').css('border-color','#F00');
			return false; 
        /**********************************/
    }//if
    
        var url  = 'Carga.php?periodo='+periodo+'&tipo='+tipo;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    
    
    /********************************/
}//function Validar
function VerSituacion(CodigoCarrera,CodigoPeriodo){
   
        var url  = 'GraficasSituacionSemestral.php?CodigoPeriodo='+CodigoPeriodo+'&CodigoCarrera='+CodigoCarrera;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    
}//function VerSituacion
function SituacionTotal(T_Desercion,CodigoPeriodo){
    
        var url  = 'GraficaSituacionTotalSemestral.php?CodigoPeriodo='+CodigoPeriodo+'&T_Desercion='+T_Desercion;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    
}//function SituacionTotal
function VerSituacionAnual(CodigoCarrera,CodigoPeriodo){
   
        var url  = 'GraficasSituacionSemestralAnual.php?CodigoPeriodo='+CodigoPeriodo+'&CodigoCarrera='+CodigoCarrera;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    
}//function VerSituacionAnual
function CostoDesercionGrafica(){
        //var CodigoPeriodo   = $('#CodigoPeriodo').val();
        var url  = 'DesercionGraficCosto.php';
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}//function CostoDesercionGrafica
function CostoDesercionGraficaPrograma(CodigoPeriodo){
        //var CodigoPeriodo   = $('#CodigoPeriodo').val();
        var url  = 'DesercionGraficCostoPrograma.php?CodigoPeriodo='+CodigoPeriodo;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}//function CostoDesercionGraficaPrograma
function CostoDesercionGraficaSemestre(CodigoPeriodo){
        //var CodigoPeriodo   = $('#CodigoPeriodo').val();
        var url  = 'DesercionGraficCostoSemestre.php?CodigoPeriodo='+CodigoPeriodo;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}//function CostoDesercionGraficaSemestre

function CostoDesercionGraficaSemestrePrograma(Carrera_id,Periodo){
        //var CodigoPeriodo   = $('#CodigoPeriodo').val();
        var url  = 'DesercionGraficCostoSemestrePrograma.php?codigocarrera='+Carrera_id+'&Periodo='+Periodo;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}//function CostoDesercionGraficaSemestrePrograma
function SaveData(){
    
    var Typo    = $('#Typo').val();
    var Valor   = $('#Valor').val();
    var Periodo = $('#Periodo').val();
    
    if(Typo=='-1' || Typo==-1){
       /**********************************/
        alert('Selecione un Tipo Dato');
        $('#Typo').effect("pulsate", {times:3}, 500);
        $('#Typo').css('border-color','#F00');
		return false; 
        /**********************************/ 
    }//if
    
    if(!$.trim(Valor)){
       /**********************************/
        alert('Digite el valor.');
        $('#Valor').effect("pulsate", {times:3}, 500);
        $('#Valor').css('border-color','#F00');
		return false; 
        /**********************************/ 
    }//if
    
    if(Periodo=='-1' || Periodo==-1){
       /**********************************/
        alert('Selecione un Periodo');
        $('#Periodo').effect("pulsate", {times:3}, 500);
        $('#Periodo').css('border-color','#F00');
		return false; 
        /**********************************/ 
    }//if
    
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'Desercion_html.php',
    	  async: false,
    	  dataType: 'json',
    	  data:({actionID: 'SaveData',Periodo:Periodo,
                                      Valor:Valor,
                                      Typo:Typo}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	  success: function(data){
    			//
                if(data.val=='FALSE'){
                    alert(data.descrip);
                    return false;
                }else if(data.val=='EXISTE'){
                    alert(data.descrip);
                    $('#Typo').effect("pulsate", {times:3}, 500);
                    $('#Typo').css('border-color','#F00');
                    
                    $('#Periodo').effect("pulsate", {times:3}, 500);
                    $('#Periodo').css('border-color','#F00');
                    return false;
                }else{
                    alert(data.descrip);
                    $('#Typo').val('');
                    $('#Periodo').val('');
                    $('#Valor').val('');
                    
                    /*****************************************/
                    $.ajax({//Ajax
            			  type: 'POST',
            			  url: 'Desercion_html.php',
            			  async: false,
            			  dataType: 'html',
            			  data:({actionID: 'InfoTabla'}),
            			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            			  success: function(data){
            					$('#DivTablaInfo').html(data);
            				}//data 
            		  }); //AJAX
                    /*****************************************/
                    
                }
    		}//data 
      }); //AJAX
    
}//function SaveData
function BuscarDataDemografica(){
    
    var Periodo        = $('#PeriodoUno').val();
    var Modalida       = $('#Modalida').val();
    var Carrera_id     = $('#Carrera_id').val();
    var TypeEstudiante = $('#TypeEstudiante').val();
    
    if(TypeEstudiante==-1 || TypeEstudiante=='-1'){
        /********************************/
        alert('Selecione un Tipo Estudiante.');
        $('#TypeEstudiante').effect("pulsate", {times:3}, 500);
        $('#TypeEstudiante').css('border-color','#F00');
        return false;
        /********************************/
    } 
    
    if(Periodo==-1 || Periodo=='-1'){
        /********************************/
        alert('Selecione un Periodo.');
        $('#PeriodoUno').effect("pulsate", {times:3}, 500);
        $('#PeriodoUno').css('border-color','#F00');
        return false;
        /********************************/
    }
    
    if(Modalida==-1 || Modalida=='-1'){
        /********************************/
        alert('Selecione una Modalidad.');
        $('#Modalida').effect("pulsate", {times:3}, 500);
        $('#Modalida').css('border-color','#F00');
        return false;
        /********************************/
    }
    
    if(!$('#All_Carreras_id').is(':checked')){
        if(Carrera_id==-1 || Carrera_id=='-1'){
            /********************************/
            alert('Selecione un Programa Academico.');
            $('#Carrera_id').effect("pulsate", {times:3}, 500);
            $('#Carrera_id').css('border-color','#F00');
            return false;
            /********************************/
        }
    }else{
        
        var Carrera_id = 0;
        
    }
   
    $('#Div_Carga').html('<blinnk>Generando Reporte...</blinnk>');
    
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'DesercionCosto_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID: 'BuscarDemografica',Periodo:Periodo,
                                               Modalida:Modalida,
                                               Carrera_id:Carrera_id,
                                               TypeEstudiante:TypeEstudiante}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	  success: function(data){
    		      $('#Div_Carga').html(data);
    		}//data 
      }); //AJAX
       
}//BuscarDataDemografica

function NumberKey(evt){
	var e = evt; 
	var charCode = (e.which) ? e.which : e.keyCode
		console.log(charCode);
		
     	//el comentado me acepta negativos
	//if ( (charCode > 31 && (charCode < 48 || charCode > 57)) ||  charCode == 109 || charCode == 173 )
		if( charCode > 31 && (charCode < 48 || charCode > 57) ){
			//si no es - ni borrar
			if((charCode!=8 && charCode!=45 && charCode!=46)){
				return false;
			}
		}

	return true;
}
function Todas(){
    /*****************************************/
    if($('#All_Carreras_id').is(':checked')){
        /*********************************/   
        $('#Carrera_id').val('-1');
        $('#Carrera_id').attr('disabled',true);   
        /*********************************/
    }else{
        /**********************************/
        $('#Carrera_id').attr('disabled',false);
        /**********************************/
    }
    /*****************************************/
}/*function Todas*/
function BuscarProgramas(){
    
    if(!$('#All_Carreras_id').is(':checked')){
    
        var Modalida  = $('#Modalida').val();
        
        if(Modalida==-1 || Modalida=='-1'){
            /********************************/
            alert('Selecione una Modalidad.');
            $('#Modalida').effect("pulsate", {times:3}, 500);
            $('#Modalida').css('border-color','#F00');
            return false;
            /********************************/
        }
        
        $('#Div_Modalidad').html('');
        
        $.ajax({//Ajax
        	  type: 'POST',
        	  url: 'DesercionCosto_html.php',
        	  async: false,
        	  dataType: 'html',
        	  data:({actionID: 'BuscarPrograma',Modalida:Modalida}),
        	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        	  success: function(data){
        		      $('#Div_Modalidad').html(data);
        		}//data 
          }); //AJAX
    }
}/*BuscarProgramas()*/  
function GenerarGraficAnualRetencion(id){
   /*****************************************************/
   var CodigoPeriodo    = $('#CodigoPeriodo').val();
   
   
        var url  = 'RetencionGraficAnual.php?CodigoPeriodo='+CodigoPeriodo+'&CodigoCarrera='+id;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
   /*****************************************************/ 
}
function GraficaDemografica(Reporte){
    
    var Periodo     = $('#PeriodoUno').val();
    var Modalida    = $('#Modalida').val();
    var Carrera_id  = $('#Carrera_id').val();
    
    if(Periodo==-1 || Periodo=='-1'){
        /********************************/
        alert('Selecione un Periodo.');
        $('#PeriodoUno').effect("pulsate", {times:3}, 500);
        $('#PeriodoUno').css('border-color','#F00');
        return false;
        /********************************/
    }
    
    if(Modalida==-1 || Modalida=='-1'){
        /********************************/
        alert('Selecione una Modalidad.');
        $('#Modalida').effect("pulsate", {times:3}, 500);
        $('#Modalida').css('border-color','#F00');
        return false;
        /********************************/
    }
    
    if(!$('#All_Carreras_id').is(':checked')){
        if(Carrera_id==-1 || Carrera_id=='-1'){
            /********************************/
            alert('Selecione un Programa Academico.');
            $('#Carrera_id').effect("pulsate", {times:3}, 500);
            $('#Carrera_id').css('border-color','#F00');
            return false;
            /********************************/
        }
    }else{
        
        var Carrera_id = 0;
        
    }
    
        var url  = 'GraficaDemografica.php?Periodo='+Periodo+'&Modalida='+Modalida+'&Carrera_id='+Carrera_id+'&Reporte='+Reporte;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    
}/*function GraficaDemografica*/  
function VerText(){
    
    var TypeGrafica = $('#TypeGrafica').val();
    
     $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'DesercionCosto_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID: 'Text',TypeGrafica:TypeGrafica}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	  success: function(data){
                  $('#Tr_Text').css('visibility','visible');
    		      $('#Th_Text').html(data);
    		}//data 
      }); //AJAX
    
}/*function VerText*/
function Condicon(){
    
    var TypeGrafica = $('#TypeGrafica').val();
    
    switch(TypeGrafica){
        case '-1':{
            
            $('#Periodo').val('-1');
            $('#Periodo').attr('disabled',false);
            $('#Periodo').css('display','none');
            /**************************************/
            $('#Programa_id').val('-1');
            $('#Programa_id').attr('disabled',false);
            $('#Programa_id').css('display','none');
            /****************************************/
            
        }break;
        case '0':{
            
            $('#Periodo').val('-1');
            $('#Periodo').attr('disabled',true);
            $('#Periodo').css('display','none');
            /**************************************/
            $('#Programa_id').val('-1');
            $('#Programa_id').attr('disabled',true);
            $('#Programa_id').css('display','none');
            /****************************************/
            
        }break;
        case '1':{
            
            $('#Periodo').val('-1');
            $('#Periodo').attr('disabled',false);
            $('#Periodo').css('display','inline');
            /**************************************/
            $('#Programa_id').val('-1');
            $('#Programa_id').attr('disabled',true);
            $('#Programa_id').css('display','none');
            /****************************************/
            
        }break;
        case '2':{
            
            $('#Periodo').val('-1');
            $('#Periodo').attr('disabled',false);
            $('#Periodo').css('display','inline');
            /**************************************/
            $('#Programa_id').val('-1');
            $('#Programa_id').attr('disabled',true);
            $('#Programa_id').css('display','none');
            /****************************************/
            
        }break;
        case '3':{
            
            $('#Periodo').val('-1');
            $('#Periodo').attr('disabled',false);
            $('#Periodo').css('display','inline');
            /**************************************/
            $('#Programa_id').val('-1');
            $('#Programa_id').attr('disabled',false);
            $('#Programa_id').css('display','inline');
            /****************************************/
            
        }break;
        case '4':{
            
            $('#Periodo').val('-1');
            $('#Periodo').attr('disabled',true);
            $('#Periodo').css('display','none');
            /**************************************/
            $('#Programa_id').val('-1');
            $('#Programa_id').attr('disabled',true);
            $('#Programa_id').css('display','none');
            /****************************************/
            
            VerTabla();
            
        }break;
    }//switch
    
}/*function Condicon*/
function VerTabla(){
    
   $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'DesercionCosto_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID: ''}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	  success: function(data){
                  $('#Rerporte').html(data);
    		}//data 
      }); //AJAX
    
}/*function VerTabla*/
function CargarGraficCosto(){
    
    var TypeGrafica = $('#TypeGrafica').val();
    
    switch(TypeGrafica){
       case '0':{
            
           CostoDesercionGrafica();
            
        }break;
        case '1':{
           
          /*2008 enviar 20081-20082*/ 
          
          var Periodo = $('#Periodo').val();
          
          if(Periodo==-1 || Periodo=='-1'){
                /********************************/
                alert('Selecione un Periodo.');
                $('#Periodo').effect("pulsate", {times:3}, 500);
                $('#Periodo').css('border-color','#F00');
                return false;
                /********************************/
            }
          
          $.ajax({//Ajax
        	  type: 'POST',
        	  url: 'DesercionCosto_html.php',
        	  async: false,
        	  dataType: 'json',
        	  data:({actionID: 'BuscarPeriodo',Periodo:Periodo,Op:'1'}),
        	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        	  success: function(data){
                     
                     CostoDesercionGraficaSemestre(data.Periodos)
                     
        		}//data 
          }); //AJAX
          
          
            
        }break;
        case '2':{
           
           /*Periodo ejempleo 20081 enviar el 2008*/ 
           
          var Periodo = $('#Periodo').val();
          
          if(Periodo==-1 || Periodo=='-1'){
                /********************************/
                alert('Selecione un Periodo.');
                $('#Periodo').effect("pulsate", {times:3}, 500);
                $('#Periodo').css('border-color','#F00');
                return false;
                /********************************/
            }
          
          $.ajax({//Ajax
        	  type: 'POST',
        	  url: 'DesercionCosto_html.php',
        	  async: false,
        	  dataType: 'json',
        	  data:({actionID: 'BuscarPeriodo',Periodo:Periodo,Op:'2'}),
        	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        	  success: function(data){
                     
                     CostoDesercionGraficaPrograma(Periodo)
                     
        		}//data 
          }); //AJAX
            
          
            
        }break;
        case '3':{
            
            /*Carrera_id*/ 
           var Periodo = $('#Periodo').val();
          
          if(Periodo==-1 || Periodo=='-1'){
                /********************************/
                alert('Selecione un Periodo.');
                $('#Periodo').effect("pulsate", {times:3}, 500);
                $('#Periodo').css('border-color','#F00');
                return false;
                /********************************/
            } 
           var Programa_id  = $('#Programa_id').val(); 
           
           if(Programa_id==-1 || Programa_id=='-1'){
                /********************************/
                alert('Selecione un Programa Academico.');
                $('#Programa_id').effect("pulsate", {times:3}, 500);
                $('#Programa_id').css('border-color','#F00');
                return false;
                /********************************/
            }
            
           CostoDesercionGraficaSemestrePrograma(Programa_id,Periodo); 
            
        }break;
        case '4':{
            
           
            
        }break;
    }//switch
    
}/*function CargarGraficCosto*/
function VerGlosario(){
    
       var url  = 'DesercionCosto_html.php?actionID=Glosario';
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    
}/*function VerGlosario*/
function VerDetallePoblacion(codigocarrera,periodo,op=''){
    /*********************************************/
    
        var url  = 'Desercion_html.php?actionID=DetallePoblacion&codigocarrera='+codigocarrera+'&periodo='+periodo+'&tipo='+0+'&op='+op;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    /*********************************************/
}/*function VerDetallePoblacion*/
function VerDetallePoblacionAnual(codigocarrera,periodo){
    /*********************************************/
        var url  = 'Desercion_html.php?actionID=DetallePoblacion&codigocarrera='+codigocarrera+'&periodo='+periodo+'&tipo='+1;
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
    /*********************************************/
}/*function VerDetallePoblacion*/