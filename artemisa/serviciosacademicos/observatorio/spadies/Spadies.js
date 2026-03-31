/*Spadies*/
function CargarInfo(){
    /************************************/
    var TypeRepote      = $('#TypeRepote').val();
    var Carrera_id      = $('#Carrera_id').val();
    var Periodo         = $('#Periodo').val();
    var TypeSemestre    = $('#TypeSemestre').val();
    var Modalidad       = $('#Modalidad').val();
    
    if(TypeRepote==-1 || TypeRepote=='-1'){
        /**********************************/
            alert('Selecione un Tipo de Reporte.');
            $('#TypeRepote').effect("pulsate", {times:3}, 500);
            $('#TypeRepote').css('border-color','#F00');
			return false; 
        /**********************************/
    }//if
    
    if(!$('#All_Carreras').is(':checked')){
        
        if($('#Modalidad').val()==0 || $('#Modalidad').val()=='0'){
        /**********************************/
            alert('Selecione una Modalidad Academica.');
            $('#Modalidad').effect("pulsate", {times:3}, 500);
            $('#Modalidad').css('border-color','#F00');
			return false; 
        /**********************************/    
        }/*if*/
        
        if(Carrera_id==-1 || Carrera_id=='-1'){
        /**********************************/
            alert('Selecione un Programa Academico.');
            $('#Carrera_id').effect("pulsate", {times:3}, 500);
            $('#Carrera_id').css('border-color','#F00');
			return false; 
        /**********************************/
        }//if
        
    }
    
    
    if(TypeRepote<2 || TypeRepote<'2'){
        if(!$('#All_Carreras').is(':checked')){
         //if(TypeSemestre==-1 || TypeSemestre=='-1'){
                /**********************************/
                    /*alert('Selecione un Semestre.');
                    $('#TypeSemestre').effect("pulsate", {times:3}, 500);
                    $('#TypeSemestre').css('border-color','#F00');
        			return false; */
                /**********************************/
           // }//if
        }
    }//if
    
    if($('#All_Carreras').is(':checked')){
        
        var Carrera_id = 0; 
        
        var Modalidad = $('#Modalidad').val();
            
    
    }   
    
    
    
    $('#Rerporte').html('<blink><span style="color:green;">Cargando...</span></blink>');
    
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'Spadies_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID: 'BuscarInfo',TypeRepote:TypeRepote,
                                        Carrera_id:Carrera_id,
                                        Periodo:Periodo,
                                        TypeSemestre:TypeSemestre,
                                        Modalidad:Modalidad}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
    	  success: function(data){
    			$('#Rerporte').html(data);
    		}//data 
      }); //AJAX
    
    /************************************/
}//function CargarInfo
function GeneraExcel(){
    /************************************/
    
    var Carrera_id   = $('#Carrera_id').val();
    var Reporte      = $('#Reporte').val();
    var Periodo_id   = $('#Periodo_id').val();
    var Semestre     = $('#Semestre').val();
    var Modalidad    = $('#Modalidad').val();
    
    if($('#All_Carreras').is(':checked')){
        
        var Carrera_id = 0; 
    } 
    
    alert('Recuerde Renombrar el Archivo Generado.');
    
    location.href='Spadies_html.php?actionID=Ecxel&TypeRepote='+Reporte+'&Carrera_id='+Carrera_id+'&Periodo='+Periodo_id+'&TypeSemestre='+Semestre+'&Modalidad='+Modalidad;
    
    /************************************/
}/*function GeneraExcel*/
function GeneraCSV(){
    /************************************/
    
    var Carrera_id   = $('#Carrera_id').val();
    var Reporte      = $('#Reporte').val();
    var Periodo_id   = $('#Periodo_id').val();
    var Semestre     = $('#Semestre').val();
    
    if($('#All_Carreras').is(':checked')){
        
        var Carrera_id = 0; 
    } 
    var tabledata = $("#Rerporte table").html();
    $('#csvdata').val(tabledata);
    
    alert('Recuerde Renombrar el Archivo Generado.');
    
    var url = 'Spadies_html.php?actionID=CSV&TypeRepote='+Reporte+'&Carrera_id='+Carrera_id+'&Periodo='+Periodo_id+'&TypeSemestre='+Semestre;
    $('#formcsv').get(0).setAttribute('action', url); //this works
    $( "#formcsv" ).submit();
    //location.href=csvData;
    //location.href='Spadies_html.php?actionID=CSV&TypeRepote='+Reporte+'&Carrera_id='+Carrera_id+'&Periodo='+Periodo_id+'&TypeSemestre='+Semestre+'&csv='+csv;
    
    /************************************/
}/*function GeneraCSV*/
function Todas(){
    /*****************************************/
    if($('#All_Carreras').is(':checked')){
        /*********************************/
        $('#Carrera_id').val('-1');
        $('#TypeSemestre').val('-1');   
        $('#Carrera_id').attr('disabled',true);   
        $('#TypeSemestre').attr('disabled',true);
        /*********************************/
    }else{
        /**********************************/
        $('#Carrera_id').attr('disabled',false);
        $('#TypeSemestre').attr('disabled',false);
        /**********************************/
    }
    /*****************************************/
}/*function Todas*/
function BuscarText(){
    /***********************************************/
    var TypeRepote  = $('#TypeRepote').val();
    
    if(TypeRepote!=-1 || TypeRepote!='-1'){
        
       $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'Spadies_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID: 'BuscarText',TypeRepote:TypeRepote}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
    	  success: function(data){
    	        $('#Tr_info').css('visibility','visible');
    			$('#Th_Info').html(data);
    		}//data 
      }); //AJAX 
        
    }//if
    /***********************************************/
}/*function BuscarText*/
function Externo(){
    window.open('http://www.mineducacion.gov.co/sistemasdeinformacion/1735/w3-propertyname-2895.html', 'spadies', 'width=800, height=500');
}/*function Externo()*/
function InformeMGI(){
    
    var url  = '../../mgi/datos/registroInformacion/viewData.php?id=row_12';
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open(url,"",opciones);
        //para poner la ventana en frente
        window.focus();
        mypopup.focus();
}/*InformeMGI*/
function Auditoria(){
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'Spadies_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID: 'Auditoria'}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
    	  success: function(data){
    	        $('#Auditoria_Div').css('display','inline');
    			$('#Auditoria_Div').html(data);
    		}//data 
      }); //AJAX 
}/*function Auditoria*/
function CloseTable(){
    $('#Auditoria_Div').css('display','none');
}/*function CloseTable*/

function BuscarCarreras(){
    
    var Modalidad   = $('#Modalidad').val();
    
    $.ajax({//Ajax
    	  type: 'POST',
    	  url: 'Spadies_html.php',
    	  async: false,
    	  dataType: 'html',
    	  data:({actionID: 'BuscarCarreras',Modalidad:Modalidad}),
    	  error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
    	  success: function(data){
    	        
    			$('#DivCarreras').html(data);
    		}//data 
      }); //AJAX 
    
}/*BuscarCarreras*/