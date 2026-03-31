function BuscarInstituciones(id){    
      $.ajax({//Ajax
              type: 'POST',
              url: 'RotacionSubGrupos_html.php',
              async: false,
              dataType: 'html',
              //data:$('#NuevaRotacionSubGrupo').serialize(),
               data:({action_ID:'Instituciones',id:id}),
              error:function(objeto, quepaso, otroobj){swal('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                $('#TD_Institucion').html(data);
              }//AJAX
       });
}//function BuscarInstituciones
$(document).ready(function(){
    $("#fechaegreso").change(function(){ 
    	var fechaInicial = $('#fechaingreso').val();
    	var fechaFinal = $('#fechaegreso').val();
      
      var fecha = fechaInicial.split("-");
      if(fecha['0'].length == '4')
      {
        fechaInicial = fecha['2']+"-"+fecha['1']+"-"+fecha['0'];  
        var update ='1';      
      }

    	if(!validate_fechaMayorQue(fechaInicial,fechaFinal))
    	{
    		swal("La fecha de Egreso no debe ser infrerior a la fecha Ingreso");
    		$('#Totaldias').html('');
            $('#fechaingreso').val('');
    	    $('#fechaegreso').val('');
    		return false;
    	}
    	
    	$.ajax({//Ajax
    		 type: 'POST',
    		 url: '../../../../../convenio/classSolicitudProrroga.php',
    		 async: false,
    		 dataType: 'json',
    		 data:{Action_id:'calculafecha',fechaingreso: fechaInicial,fechaegreso:fechaFinal},
    		 error:function(objeto, quepaso, otroobj){
    		     swal('Error de Conexi�n , Favor Vuelva a Intentar');
    		     },
    		 success: function(data)
    		{
    			var html = "<input id='Totaldias' name='Totaldias' value='"+data+"' style='text-align: center;' onkeydown='return validarNumeros(event)' maxlength='3' size='3' />" 
    			$('#Totaldias').html(html);
                $("#dia1").prop("checked", "checked");
                $("#dia2").prop("checked", "checked");
                $("#dia3").prop("checked", "checked");
                $("#dia4").prop("checked", "checked");
                $("#dia5").prop("checked", "checked");
          if(update == '1')
          {
            CalcularHoras();
          }
    		}//data
    	});// AJAX
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
function RotacionSubGrupo(){
    if(!$.trim($('#fechaingreso').val())){
        swal('Por favor Idique la fecha de Ingreso');
        $('#fechaingreso').effect("pulsate", {times:3}, 500);
        $('#fechaingreso').css('border-color','#F00');
        return false;
    }
    
    if(!$.trim($('#fechaegreso').val())){
        swal('Por favor Idique la fecha de Egreso');
        $('#fechaegreso').effect("pulsate", {times:3}, 500);
        $('#fechaegreso').css('border-color','#F00');
        return false;
    }
    
    if($('#LugarRotacio').val()==-1 || $('#LugarRotacio').val()=='-1'){
        swal('Por favor Idique el Lugar de Rotacion');
        $('#LugarRotacio').effect("pulsate", {times:3}, 500);
        $('#LugarRotacio').css('border-color','#F00');
        return false;
    }
    
    if($('#Convenio').val()==-1 || $('#Convenio').val()=='-1'){
        swal("Por favor Idique el Convenio");
        $('#Convenio').effect("pulsate", {times:3}, 500);
        $('#Convenio').css('border-color','#F00');
        return false;
    }

    if($('#TotalHoras').val() == '' || $('#TotalHoras').val() == 0)
    {
        swal("El campo total horas esta vacio o en valor 0, por favor vuelva a configurar la jornada para calcular las horas correspondientes");
        $('#TotalHoras').effect("pulsate", {times:3}, 500);
        $('#TotalHoras').css('border-color','#F00');
        return false;
    }
    /********************************************************/
    $('#action_ID').val('NewRotacionSubGrupo');
    $.ajax({//Ajax
              type: 'POST',
              url: 'RotacionSubGrupos_html.php',
              async: false,
              dataType: 'json',
              data:$('#NuevaRotacionSubGrupo').serialize(),
              //data:({action_ID:'Convenios',id:id}),
              error:function(objeto, quepaso, otroobj){swal('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
                    if(data.val===false){
                        swal(data.descrip);
                        return false;
                    }else if(data.val==='Error'){
                        swal(data.descrip+'\n A continuacion la lista de estudiantes');
                        VerListCruces(data.Estudiantes);
                    }else{
                        swal(data.descrip);
                         $('#Boton').css('display','none');
                         location.href='../controller/subgrupos.php?idgrupo='+data.grupo+'&materia='+data.materia;
                    }
              }//AJAX
       });
}//function RotacionSubGrupo

function ActualizarRotacionSubGrupo()
{

  if($('#Observacion').val()==''){
        swal('Por favor indique la Observacion');
        $('#Convenio').effect("pulsate", {times:3}, 500);
        $('#Convenio').css('border-color','#F00');
        return false;
    }
    $.ajax({//Ajax
      type: 'POST',
      url: 'RotacionSubGrupos_html.php',
      async: false,
      dataType: 'json',
      data:$('#RotacionSubGrupo').serialize(),
      //data:({action_ID:'Convenios',id:id}),
      error:function(objeto, quepaso, otroobj){swal('Error de Conexi?n , Favor Vuelva a Intentar');},
      success: function(data){
            if(data.val===false){
                swal(data.descrip);
                return false;
            }else if(data.val==='Error'){
                swal(data.descrip+'\n A continuacion la lista de estudiantes');
                VerListCruces(data.Estudiantes);
            }else{
                swal(data.descrip);
                 $('#Boton').css('display','none');
                 location.href='../controller/subgrupos.php?idgrupo='+data.grupo+'&materia='+data.materia;
            }
      }//AJAX
    });
        
}

function VerListCruces(Estudiantes){
    
    $.ajax({//Ajax
              type: 'POST',
              url: 'RotacionSubGrupos_html.php',
              async: false,
              dataType: 'html',
              //data:$('#NuevaRotacionSubGrupo').serialize(),
               data:({action_ID:'ListCrueces',Estudiantes:Estudiantes}),
              error:function(objeto, quepaso, otroobj){swal('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data){
               $('#List').html(data);
              }//AJAX
       });
    
}//function VerListCruces

function  CalcularHoras(update = null)
{
    var joranda = $("#Jornada").val();
    var dias = $("input#Totaldias").val();
    
    $.ajax({//Ajax
          type: 'POST',
          url: 'RotacionSubGrupos_html.php',
          async: false,
          dataType: 'html',
          data:({action_ID:'CalcularHoras',jornada:joranda, dias: dias}),
          error:function(objeto, quepaso, otroobj){swal('Error de Conexi?n , Favor Vuelva a Intentar');},
          success: function(data)
          {
              if(update == null)
              {
                  $('#TotalHoras').val(data);
              }
            if(joranda == 1)
            {
                $('#horario').attr('readonly','readonly');
                $('#horario').val('7:00 - 19:00');
            }
            if(joranda == 2)
            {
                $('#horario').attr('readonly','readonly');
                $('#horario').val('7:00 - 12:00');
            }
            if(joranda == 3)
            {
                $('#horario').attr('readonly','readonly');
                $('#horario').val('13:00 - 18:00');
            } 
            if(joranda == 4)
            {
                $('#horario').attr('readonly','readonly');
                $('#horario').val('18:00 - 23:00');
            }
            if(joranda == 5)
            {
                $('#horario').attr('readonly','readonly');
                $('#horario').val('18:00 - 6:00');
            }
            if(joranda == 6)
            {
                $('#horario').prop('readonly',false);
                $('#horario').val('00:00 - 00:00');
            }
            if(joranda == 7)
            {
                $('#horario').attr('readonly','readonly');
                $('#horario').val('08:00 - 12:00');
            }
            /* Caso 105713.
             * Modificado por Luis Dario Gualteros C <castroluid@unbosque.edu.co>
             * Se adicina la jornada de 7.00 a 17:00 de acuerdo a la solicitud de Medicina Familiar. 
             * @since Octubre 17, 2018
            */
            if(joranda == 8)
            {
                $('#horario').attr('readonly','readonly');
                $('#horario').val('07:00 - 17:00');
            }
            //End Caso 105713.
          }//AJAX
    });
}
function EliminarLaRotacion(from)
{ 
    var grupo = $('#idgrupo').val();
    var materia = $('#materia').val();
    var SubgrupoId = $('#SubgrupoId').val();
    $.ajax({
        type: 'POST',
        url: 'RotacionSubGrupos_html.php',
        async: false,
        dataType: 'json',
        data:$(from).serialize(),
        error:function(objeto, quepaso, otroobj){swal('Error de Conexi�n , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val==true){
                      alert('Se elimino la Rotacion correctamente');
                      location.href='../controller/subgrupos.php?SubgrupoId='+SubgrupoId+'&idgrupo='+grupo+'&lista=1&materia='+materia;                     
                   }
            }
    });  
}

function RegresarsubGrupo()
{
    var grupo = $('#idgrupo').val();
    var materia = $('#materia').val();
  location.href='../controller/subgrupos.php?idgrupo='+grupo+'&materia='+materia;  
}

function RegresarGrupos()
{   
  location.href='../../../../../../serviciosacademicos/convenio/MateriasRotacionCarrera.php';  
}

function DetallesRotacion(form)
{    
    var idgrupo = $("#idgrupo").val();
    var SubgrupoId = $("#SubgrupoId").val();
    var materia = $('#materia').val();
    var Institucion = $("#"+form).find("#Institucion").val();
    location.href= "../controller/subgrupos.php?SubgrupoId="+SubgrupoId+"&idgrupo="+idgrupo+"&updaterotacion=1&materia="+materia+"&institucion="+Institucion;
}