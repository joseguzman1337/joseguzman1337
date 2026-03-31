function BuscarPrograma(form){
 
    var Modalidad = $('#'+form+' #Modalidad').val();
    
    if(form=='Materia'){
        var Op = 1;
    }else{
        var Op = '';
    }
    
    $.ajax({//Ajax
          type: 'POST',
          url: 'Motor_Asignacion_html.php',
          async: false,
          dataType: 'html',
          data:({actionID: 'Programas',id:Modalidad,Op:Op}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               $('#'+form+' #Th_Programa').html(data);
          }  
    });//Ajax
}//function BuscarPrograma
function BuscarMateria(){
    var Carrera = $('#Materia #ProgramaAcade').val();
    
    $.ajax({//Ajax
          type: 'POST',
          url: 'Motor_Asignacion_html.php',
          async: false,
          dataType: 'html',
          data:({actionID: 'Materias',id:Carrera}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               $('#Materia #Th_Materia').html(data);
          }  
    });//Ajax
}//function BuscarMateria
function SolicitudDatta(i){
    $('#DataView').html('');
    switch(i){
        case 1:{
              var Cupo =0;
            if($('#NumEstudiante #Cupo').is(':checked')){
              var Cupo = 1;  
            }else if($('#NumEstudiante #matriculados').is(':checked')){
              var Cupo = 2;  
            }else if($('#NumEstudiante #prematriculados').is(':checked')){
              var Cupo = 3;
            }else if($('#NumEstudiante #MatriPrema').is(':checked')){
              var Cupo = 4;
            }
            
            if(Cupo==0 || Cupo=='0'){
                alert('Indique El Tipo de dato a buscar...');
                return false;
            }
            
            var Num_1 = $('#NumEstudiante #Num_1').val();
            var Num_2 = $('#NumEstudiante #Num_2').val();
            
            if(!$.trim(Num_1) || !$.trim(Num_2)){
                alert('Indique Numero de Estudiantes...');
                return false;
            }
            
            if(parseInt(Num_1) > parseInt(Num_2)){
                alert('El Valor '+Num_1+' es Mayor al Valor '+Num_2+'\n Los Valores No Son Correctos...');
                return false;
            }
            
            $('#NumEstudiante #actionID').val('BusacrXNummeros');
            
            AjaxDinamico('NumEstudiante');
        }break;
        case 2:{
            $('#Programa #actionID').val('BusacrXPrograma');
            AjaxDinamico('Programa');
        }break;
        case 3:{
             $('#Materia #actionID').val('BusacrXMateria');
            AjaxDinamico('Materia');
        }break;
        case 4:{
             $('#All #actionID').val('BusacrXTodo');
            AjaxDinamico('All');
        }break;
    }
}//function SolicitudDatta
function AjaxDinamico(name){ //console.log('Aca...');
   $('#DataView').html('<img src="../imagenes/engranaje-13.gif" />Este Proceso Puede Tardar Unos Minutos...');
    $.ajax({//Ajax
          type: 'POST',
          url: 'Motor_Asignacion_html.php',
          async: false,
          dataType: 'html',
          data:$('#'+name).serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               $('#DataView').html(data);
          }  
    });//Ajax
}//function AjaxDinamico
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
function AllCheckInOut(){
    if($('#All').is(':checked')){
        $('.MotorCheck').attr('checked',true);
    }else{
        $('.MotorCheck').attr('checked',false);
    }    
}//function AllCheckInOut
function AlmacenarMotor(){
    
    if($('#DataMotor #Cupo').is(':checked')){
        var Cupo  = 1;
    }else if($('#DataMotor #matriculados').is(':checked')){
        var Cupo  = 2;
    }else if($('#DataMotor #prematriculados').is(':checked')){
        var Cupo  = 3;
    }else if($('#DataMotor #MatriPrema').is(':checked')){
        var Cupo  = 4;
    }
    
    if(!$.trim(Cupo)){
        alert('Por Favor Indicar por que Item de Cupo Buscar Espacio Fisico');
        return false;        
    }
    
    if(confirm('Seguro de Enviar las Solicitudes al Motor Automatico de Asignacion...?')){
    
     $.ajax({//Ajax
              type: 'POST',
              url: 'Motor_Asignacion_html.php',
              async: false,
              dataType: 'json',
              data:$('#DataMotor').serialize(),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                   if(data.val===false){
                        alert(data.descrip);
                        return false;
                   }else if(data.val==='Existen'){
                        alert(data.descrip+'\n'+data.descrip1+'\n'+data.descrip2);
                        ViewLista(data.DataExite);
                   }else{
                        alert(data.descrip);
                        $('#DataView').html('');
                   }
              }  
        });//Ajax
    }
}//function AlmacenarMotor
function ViewLista(Datos){
   // console.log(Datos)
    $.ajax({//Ajax
          type: 'POST',
          url: 'Motor_Asignacion_html.php',
          async: false,
          dataType: 'html',
          data:({actionID: 'Lista',Datos:Datos}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               $('#DataView').html(data);
          }  
    });//Ajax
}//function ViewLista