function tablalumnos(rango){
    var Modalidad = $('#Modalidad').val();
    
    $.ajax({//Ajax
        type: 'POST',
        url: 'Reporte_ComparativoSaber11.html.php',
        async: false,
        dataType: 'html',
        data:({actionID: 'listadoestudiantes',rango:rango}),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            $('#resultablas').html('');
            $('#resultablas').html(data);
        }//data 
    }); //AJAX
}//function Programa
function CargarInfo(){
    var Periodo = $('#Periodo').val();
    var Carrera = $('#Programa').val();
    
    if(Periodo==-1 || Periodo=='-1'){
        alert('Selecionar Periodo');
        $('#Periodo').effect("pulsate", {times:3}, 500);
        $('#Periodo').css('border-color','#F00');
        return false;  
    }
    
    if(Carrera==-1 || Carrera=='-1'){
        alert('Selecionar Programa Academico');
        $('#Programa').effect("pulsate", {times:3}, 500);
        $('#Programa').css('border-color','#F00');
        return false;  
    }
    
    $.ajax({//Ajax
        type: 'POST',
        url: 'Reporte_AdmitidoNoAdmitidos.html.php',
        async: false,
        dataType: 'html',
        data:({actionID: 'CargarInfo',Periodo:Periodo,Carrera:Carrera}),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            
            $('#Rerporte').html(data);
        }//data 
    }); //AJAX
}//function CargarInfo