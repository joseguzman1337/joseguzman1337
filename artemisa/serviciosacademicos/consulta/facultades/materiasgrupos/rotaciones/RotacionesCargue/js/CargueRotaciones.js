$(document).ready(function(){
    $("#fechaegreso").change(function(){ 
    	var fechaInicial = $('#fechaingreso').val();
    	var fechaFinal = $('#fechaegreso').val();
    
    	if(!validate_fechaMayorQue(fechaInicial,fechaFinal))
    	{
    		alert("La fecha de Egreso no debe ser infrerior a la fecha Ingreso");
    		$('#Totaldias').html('');
            $('#fechaingreso').val('');
    	    $('#fechaegreso').val('');
    		return false;
    	}
    	
    	$.ajax({//Ajax
    		 type: 'POST',
    		 url: '../../../../../../convenio/classSolicitudProrroga.php',
    		 async: false,
    		 dataType: 'json',
    		 data:{Action_id:'calculafecha',fechaingreso: fechaInicial,fechaegreso:fechaFinal},
    		 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		 success: function(data)
    		{
    			var html = "<input id='Totaldias' name='Totaldias' value='"+data+"' style='text-align: center;' onkeydown='return validarNumeros(event)' maxlength='3' size='3' />" 
    			$('#Totaldias').html(html);
                $("#Semanadias1").prop("checked", "checked");
                $("#Semanadias2").prop("checked", "checked");
                $("#Semanadias3").prop("checked", "checked");
                $("#Semanadias4").prop("checked", "checked");
                $("#Semanadias5").prop("checked", "checked");
    		}//data
    	});// AJAX
    });
    
    $("#materias").change(function(){
        var materia = $("#materias").val();
        var periodo = $("#periodo").val();
        
        $.ajax({//Ajax
            type: 'POST',
            url: '../Controller/CargueRotaciones.php',
            async: false,
            dataType: 'html',
            data:{Action_id:'listagrupos',materia:materia, periodo:periodo},
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data)
            {
                //alert(data);
                $('#gruposdata').html(data);
            }
        });
    });
    
});

function validate_fechaMayorQue(fechaInicial,fechaFinal){
    valuesStart=fechaInicial.split("-");
    valuesEnd=fechaFinal.split("-");
    // Verificamos que la fecha no sea posterior a la actual
    var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
    var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
    if(dateStart>=dateEnd)
    {
        return 0;
    }
    return 1;
}//function validate_fechaMayorQue

function CargarDatosRotaciones()
{
    if(!$.trim($('#fechaingreso').val())){
        alert('Por favor Idique la fecha de Ingreso');
        $('#fechaingreso').effect("pulsate", {times:3}, 500);
        $('#fechaingreso').css('border-color','#F00');
        return false;
    }
    
    if(!$.trim($('#fechaegreso').val())){
        alert('Por favor Idique la fecha de Egreso');
        $('#fechaegreso').effect("pulsate", {times:3}, 500);
        $('#fechaegreso').css('border-color','#F00');
        return false;
    }
    
    if($('#instituciones').val()==-1 || $('#Convenio').val()=='-1'){
        alert('Por favor Idique la instituciones');
        $('#instituciones').effect("pulsate", {times:3}, 500);
        $('#instituciones').css('border-color','#F00');
        return false;
    }
    var FormData = new FormData($("#rotacionesmasivas"));
    /********************************************************/
    $.ajax({//Ajax   
        type: 'POST',
        url: '../Controller/CargueRotaciones.php',
        dataType: 'html',
        data:Formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data)
        {
            alert(data);
        }        
    });//AJAX*/
}

function CambioDiasSemana()       
{
    var estado1 = $("#Semanadias1").prop("checked");
    var estado2 = $("#Semanadias2").prop("checked");
    var estado3 = $("#Semanadias3").prop("checked");
    var estado4 = $("#Semanadias4").prop("checked");
    var estado5 = $("#Semanadias5").prop("checked");
    var estado6 = $("#Semanadias6").prop("checked");
    var estado7 = $("#Semanadias7").prop("checked");
    var dia = [estado1, estado2, estado3, estado4, estado5, estado6, estado7];
   
   	var fechaInicial = $('#fechaingreso').val();
	var fechaFinal = $('#fechaegreso').val();
    
    $.ajax({//Ajax
		 type: 'POST',
		 url: '../../../rotaciones/classSolicitudRotacion.php',
		 async: false,
		 dataType: 'json',
		 data:{Action_id:'calculardias',fechaingreso:fechaInicial,fechaegreso:fechaFinal,dias:dia},
		 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		 success: function(data)
		{				   
			var html = "<input id='Totaldias' name='Totaldias' value='"+data+"' />" 
			$('#Totaldias').html(html);                    
		}//data
	});// AJAX
}


function  CalcularHoras()
{
    var joranda = $("#Jornada").val();
    var dias = $("input#Totaldias").val();
    
    $.ajax({//Ajax
          type: 'POST',
          url: '../../../rotaciones/classSolicitudRotacion.php',
          async: false,
          dataType: 'html',
          data:({Action_id:'CalcularHoras',jornada:joranda, dias: dias}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
          success: function(data)
          {
            $('#TotalHoras').val(data); 
          }//AJAX
    });   
}