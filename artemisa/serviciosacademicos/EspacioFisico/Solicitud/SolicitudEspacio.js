function BuscarPrograma(){ 
    /***********************************************/
     var Modalidad = $('#Modalidad').val();
    
    
     if(Modalidad==-1 || Modalidad=='-1'){
        /******************************************************/
        $('#Modalidad').effect("pulsate", {times:3}, 500);
        $('#Modalidad').css('border-color','#F00');
        $('#Grupo').val('-1');
        $('#Materia').val('-1');
        
        return false;
        /******************************************************/ 
     }
        $.ajax({//Ajax
              type: 'POST',
              url: 'SolicitudEspacio_html.php',
              async: false,
              dataType: 'html',
              data:({actionID: 'Programa',Modalidad:Modalidad}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    $('#Th_Progra').css('align','left')
            		$('#Th_Progra').html(data);
            	}//data 
        }); //AJAX
    /***********************************************/
}//function BuscarPrograma
function BuscarMateria(){
    /***********************************************/
    var Programa = $('#Programa').val();
    
    if(Programa==-1 || Programa=='-1'){
        /******************************************************/
        $('#Programa').effect("pulsate", {times:3}, 500);
        $('#Programa').css('border-color','#F00');
        $('#Materia').val('-1');
        $('#Grupo').val('-1'); 
        return false;
        /******************************************************/ 
     }
    
        $.ajax({//Ajax
              type: 'POST',
              url: 'SolicitudEspacio_html.php',
              async: false,
              dataType: 'html',
              data:({actionID: 'Materia',Programa:Programa}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    $('#Th_Materia').css('align','left')
            		$('#Th_Materia').html(data);
            	}//data 
        }); //AJAX
    /***********************************************/
}//function BuscarMateria
function BuscarGrupo(){
    /***********************************************/
    var Programa = $('#Programa').val();
    var Materia = $('#Materia').val();
    
    
     if(Programa==-1 || Programa=='-1'){
        /******************************************************/
        $('#Programa').effect("pulsate", {times:3}, 500);
        $('#Programa').css('border-color','#F00');
        $('#Materia').val('-1');
        $('#Grupo').val('-1'); 
        return false;
        /******************************************************/ 
     }
     
      if(Materia==-1 || Materia=='-1'){
        /******************************************************/
        $('#Materia').effect("pulsate", {times:3}, 500);
        $('#Materia').css('border-color','#F00');
        $('#Grupo').val('-1'); 
        return false;
        /******************************************************/ 
     }
        $.ajax({//Ajax
              type: 'POST',
              url: 'SolicitudEspacio_html.php',
              async: false,
              dataType: 'html',
              data:({actionID: 'Grupo',Programa:Programa,Materia:Materia}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    $('#Th_Grupo').css('align','left')
            		$('#Th_Grupo').html(data);
            	}//data 
        }); //AJAX
    /***********************************************/
}//function BuscarPrograma
function VentanaNew(){
   /*
    z-index: 9999; 
    display: block; 
    left: 350px; 
    opacity: 1; 
    position: absolute; 
    top: 2328.5px; 
    height:1200px;
    width: 1200px;
   */
   
   
  //  
//    var FechaIni = $('#FechaIni').val();
//    var FechaFin = $('#FechaFin').val();
//    var FrecuenciaOnline = $('#FrecuenciaOnline').val(); 
//    var DiasOnline = $('#DiasOnline').val();
//    var CadenaDia = DiasOnline.split('::');
//    
//    console.log(CadenaDia);
//    
//    /*
//    CadenaDia[1]
//    [DiaSemana] => Array
//        (
//            [0] => 1
//            [1] => 2
//        )
//
//    */
//    
//    /*
//    HoraInicial_
//    HoraFin_
//    Index
//    */
//    var DiaSemana = [];
//    var Num = CadenaDia.length;
//    
//    for(j=0;j<Num;j++){
//        x = parseInt(j)+1;
//        if(CadenaDia[x]){
//            DiaSemana[j] = CadenaDia[x];
//        }
//        
//    }//for
//    
//    console.log(DiaSemana);
//    
//    
//    var HorasIniciales = [];
//    var HorasFinales   = [];
//    
//    for(i=1;i<Num;i++){
//        var HoraInicial = $('#HoraInicial_'+CadenaDia[i]).val();
//        /************************************/
//        if(!$.trim(HoraInicial)){
//           /******************************************************/
//            $('#HoraInicial_'+CadenaDia[i]).effect("pulsate", {times:3}, 500);
//            $('#HoraInicial_'+CadenaDia[i]).css('border-color','#F00');
//            return false;
//            /******************************************************/ 
//        }
//        HorasIniciales[i] = HoraInicial;
//        /************************************/
//        var HoraFin = $('#HoraFin_'+CadenaDia[i]).val();
//        /************************************/
//        if(!$.trim(HoraFin)){
//           /******************************************************/
//            $('#HoraFin_'+CadenaDia[i]).effect("pulsate", {times:3}, 500);
//            $('#HoraFin_'+CadenaDia[i]).css('border-color','#F00');
//            return false;
//            /******************************************************/ 
//        }
//        HorasFinales[i] = HoraFin;
//
//    }
//    
//   console.log(Datos.Dato);
//   
//  
//   
//
//       
//   
//       
//       console.log(Result);

//console.log(Datos.Dato);
       
   $('#VentanaNew').css('z-index','9999');
   $('#VentanaNew').css('display','block');
   $('#VentanaNew').css('left','350px');
   $('#VentanaNew').css('opacity','1');
   $('#VentanaNew').css('position','absolute');
   $('#VentanaNew').css('top','2328.5px');
   $('#VentanaNew').css('height','1200px');
   $('#VentanaNew').css('width','1200px');
   
    
   $('#VentanaNew').bPopup({
        content:'iframe', //'ajax', 'iframe' or 'image' xlink
        //contentContainer:'.content',
        iframeAttr:['scrolling="no" style="width:95%;height:95%" frameborder="54"'],
        //loadUrl:'../wdCalendar/wdCalendar/sample.php?FechaIni='+FechaIni+'&FechaFin='+FechaFin+'&Frecuencia='+Frecuencia+'&DiaSemana='+DiaSemana+'&HorasIniciales='+HorasIniciales+'&HorasFinales='+HorasFinales,
        loadUrl:'../wdCalendar/wdCalendar/sample.php?data='+$('#SolicitudEspacio').serialize(),
  });    
}//function VentanaNew
function MaxCupo(){
    /*******************************************************************************/
    var Grupo = $('#Grupo').val();
    
    if(Grupo==-1 || Grupo=='-1'){
    /******************************************************/
    $('#Grupo').effect("pulsate", {times:3}, 500);
    $('#Grupo').css('border-color','#F00');
    $('#NumEstudiantes').val(''); 
    return false;
    /******************************************************/ 
     }
        $.ajax({//Ajax
              type: 'POST',
              url: 'SolicitudEspacio_html.php',
              async: false,
              dataType: 'json',
              data:({actionID: 'Cupo',Grupo:Grupo}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    if(data.val==false){
                        alert(data.descrip);
                        return false;
                    }else{
                        $('#NumEstudiantes').val(data.Cupo);
                    }
            	}//data 
        }); //AJAX
    /*******************************************************************************/
}//function MaxCupo
function CargarFrecuencia(id){
    /*****************************************************/
    $('#FrecuenciaOnline').val('');
    $('#FrecuenciaOnline').val(id);
    /*****************************************************/
}//function CargarFrecuencia
function DiasCargar(id){
    /*****************************************************/
    
    if($('#Dia_'+id).is(':checked')){
         $('#DiasOnline').val($('#DiasOnline').val()+'::'+id);
    }else{
            var xx = '::'+id;
            var Cadena = $('#DiasOnline').val();
            
            var Resultado = Cadena.replace(xx,'');
            
            $('#DiasOnline').val(Resultado);
    }
   
    /*****************************************************/
}//function DiasCargar
function VerCalendario(){ 
    /***********************************************************/
    
    var FechaIni = $('#FechaIni').val();
    var FechaFin = $('#FechaFin').val();
    var FrecuenciaOnline = $('#FrecuenciaOnline').val(); 
    var DiasOnline = $('#DiasOnline').val();
    var CadenaDia = DiasOnline.split('::');
    var Num = CadenaDia.length;
    var HorasIniciales = [];
    var HorasFinales   = [];
    
    for(i=1;i<Num;i++){
        var HoraInicial = $('#HoraInicial_'+CadenaDia[i]).val();
        /************************************/
        if($.trim(HoraInicial)){
           HorasIniciales[i] = HoraInicial;
        }
        
        /************************************/
        var HoraFin = $('#HoraFin_'+CadenaDia[i]).val();
        /************************************/
        if(!$.trim(HoraFin)){
           HorasFinales[i] = HoraFin;
        }
        
        /************************************/
    }//for
    
    //$('#actionID').val('VerCalenadario');
    
    /***********************************************************/
       VentanaNew();
    /***********************************************************/
}//function VerCalendario
function AddTr(){
    /*********************************************************/
    	var TblMain    =  document.getElementById("TablaHorario");
    	var NumFiles   =  parseFloat($('#numIndices').val()) + 1;
    	var NewTr      =  document.createElement("tr");
    	NewTr.id       =  'trNewDetalle'+NumFiles;
    	
    	TblMain.appendChild(NewTr);
        
        $('#numIndices').val(NumFiles);  
        
        $.ajax({//Ajax
          type: 'POST',
          url: 'SolicitudEspacio_html.php',
          async: false,
          dataType: 'html',
          data:({actionID: 'AddTr',NumFiles:NumFiles}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
                $('#trNewDetalle'+NumFiles).html(data);
        	}//data 
        }); //AJAX
    /*********************************************************/
}//function AddTr
function DeleteTr(){
    /***********************************************************/
    var NumFiles   =  parseFloat($('#numIndices').val());
    
    if(NumFiles>0){
    
        $('#trNewDetalle'+NumFiles).remove();
        
        $('#numIndices').val(NumFiles-1);
        
    }
    /***********************************************************/
}//function DeleteTr
//function EditEventoSolicitud(){
    /*****************************************************************/
    //$.ajax({//Ajax
//          type: 'POST',
//          url: 'SolicitudEspacio_html.php',
//          async: false,
//          dataType: 'json',
//          data:$('#EditarFormulario').serialize(),
//          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
//          success: function(data){
//               if(data.val==false){
//                        $("#msg-success").addClass('msg-error');
//                        $("#msg-success").css('display','');
//                        $("#msg-success").html('<p>' + data.descrip + '</p>');
//                    }else{
//                        alert(data.descrip);
//                        ventanaDos();
//                    }
//        	}data 
       // });// AJAX
    /*****************************************************************/
//}//function EditEventoSolicitud
function SolicitudSave(){
    /*********************************************************************/
    
    $('#actionID').val('SaveSolicitud');
    
    $.ajax({//Ajax
          type: 'POST',
          url: 'SolicitudEspacio_html.php',
          async: false,
          dataType: 'json',
          data:$('#SolicitudEspacio').serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val==false){
                        $("#msg-success").addClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                    }else{
                        $("#msg-success").removeClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                    }
        	}//data 
        });// AJAX
    /*********************************************************************/
}//function SolicitudSave