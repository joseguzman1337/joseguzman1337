function BuscarInstituciones(id){
      $.ajax({//Ajax
              type: 'POST',
              url: 'classSolicitudRotacion.php',
              async: false,
              dataType: 'html',
              //data:$('#NuevaRotacionSubGrupo').serialize(),
               data:({Action_id:'VerInstituciones',id:id}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
              success: function(data)
              {
                $('#TD_LugarRotacion').html(data);
              }//AJAX
       });
}//function BuscarInstituciones
function MateriaPeriodo()
{
    var periodo = $('#periodo').val();
	var cestudiante = $('#cestudiante').val();
  var modalidad = $('#modalidad').val();
    $.ajax({//Ajax
         type: 'POST',
         url: '../../../../convenio/classSolicitudProrroga.php',
         async: false,
         dataType: 'json',
         data:{periodo: periodo,cestudiante:cestudiante,modalidad:modalidad},
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){

			    if (data.val === false)
                {
                    alert(data.descrip);
                    return false;
                } else
                {
                    if (data !== '1')
                    {
						var html = "<select id='materia' name='materia'>"
                        $.each(data, function (index, entry)
                        {
							html += "<option value=" + entry['codigomateria'] + ">"+ entry['nombremateria'] +"</option>";

                        });
                        html += "</select>";
                    }
                    else
                    {
                        html = "No existe información Disponible";
                    }
                    $('#materia').html(html);
                }
        }//data
    });// AJAX
}
function RegresarNuevaRotacion(){
    var id = $('#codigoestudiante').val();
    location.href="../rotaciones/RotacionEstudiante.php?codigoestudiante="+id;
}

function ValidaNuevaRotacionEstudiante(form)
{
	 var data = validateForm(form);
	 var id = $('#codigoestudiante').val();
	 var Totaldias = $('#fechaegreso').val();
	 if(Totaldias == '')
	 {
		 alert('Debe seleccionar una fecha de egreso') ;
		return false;
	 }
	 var ingreso = $('#fechaingreso').val();
	 if(ingreso == '')
	 {
		 alert('Debe seleccionar una fecha de ingreso') ;
		return false;
	 }
	 var Ubicacion = $('#institucionID').val();
	 if(Ubicacion == '')
	 {
		 alert('Debe seleccionar Ubicacion de la Rotación') ;
		return false;
	 }
	 var Ubicacion = $('#Ubicacion').val();
	 if(Ubicacion == '')
	 {
		 alert('Debe seleccionar Ubicacion de la Rotación') ;
		return false;
	 }
	 var convenio = $('#convenio').val();
	 if(convenio == '')
	 {
		 alert('Debe seleccionar Convenio de la Rotación') ;
		return false;
	 }
	 var materia = $('#materia').val();
	 if(materia == '')
	 {
		 alert('Debe seleccionar materia de la Rotación') ;
		return false;
	 }
   var TotalHoras = $('#TotalHoras').val();
   if(TotalHoras == '')
   {
     alert('Debe ingresar el total de horas.') ;
    return false;
   }
	 var estadorotacion = $('#estadorotacion').val();
	 if(estadorotacion == '')
	 {
		 alert('Debe seleccionar estado rotación de la Rotación') ;
		return false;
	 }
    var fechaInicial = $('#fechaingreso').val();
    var fechaFinal = $('#fechaegreso').val();

    if(!validate_fechaMayorQue(fechaInicial,fechaFinal))
    {
    	alert("La fecha de Egreso no debe ser infrerior a la fecha Ingreso");
    	$('#Totaldias').html('');
    	return false;
    }

    if(data==true){
        $.ajax({//Ajax
        type: 'POST',
        url: '../rotaciones/NuevaRotacionEstudiante.php',
        async: false,
        dataType: 'json',
        data:$(form).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==99){
                       alert("Ya exite una rotaci\u00F3n para este periodo de tiempo");
                       return false;
                   }else{
                       alert('Se agrego Exitosamente la solicitud');
                      location.href="../rotaciones/RotacionEstudiante.php?codigoestudiante="+id;
                   }
        }//data
       });// AJAX
    }

}
function RegresarRotacion(){
    location.href="../../../prematricula/matriculaautomaticaordenmatricula.php";
}

function RegresarReporteRotacion(){
    location.href="../../../../convenio/ReportesConveniosRotaciones.php";
}

function DetalleValidaRotacionEstudiante(form)
{
    var data = validateForm(form);
    var id = $('#codigoestudiante').val();
    var observacion = $('#Observacion').val();
    if(observacion == '')
    {
      alert('Debe ingresar una observacion.') ;
      return false;
    }
    var TotalHoras = $('#TotalHoras').val();
    if(TotalHoras == '')
   {
     alert('Debe ingresar el total de horas.') ;
    return false;
   }
   var Totaldias = $('#Totaldias').val();
   if(Totaldias == '')
   {
     alert('Debe ingresar el total de dias.') ;
    return false;
   }
    if(data==true){
        $.ajax({//Ajax
         type: 'POST',
         url: '../rotaciones/DetallesRotacionEstudiante.php',
         async: false,
         dataType: 'json',
       data:$(form).serialize(),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              if(data.val==false){
                       alert(data.descrip);
                       return false;
                   }else{
                       alert(data.descrip);
                       location.href="../rotaciones/RotacionEstudiante.php?codigoestudiante="+id;
                   }
        }//data
       });// AJAX
    }

}

function Ubicaciones()
{
   var ubicacion = $('#ubicacion').val();
    $.ajax({//Ajax
         type: 'POST',
         url: '../rotaciones/ReporteRotaciones.php',
         async: false,
         dataType:'html',
         data:({Action_id:'Servicio',ubicacion:ubicacion}),
         error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
         success: function(data){
              $('#Td_Servicio').html(data);
        }//data
    });// AJAX
}

function  CalcularHoras()
{
    var joranda = $("#jornada").val();
    var dias = $("input#Totaldias").val();

    $.ajax({//Ajax
          type: 'POST',
          url: '../rotaciones/classSolicitudRotacion.php',
          async: false,
          dataType: 'html',
          data:({Action_id:'CalcularHoras',jornada:joranda, dias: dias}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
          success: function(data)
          {
            $('#TotalHoras').val(data);
            if(joranda == 1)
            {
                $('#horario').val('7:00 - 19:00');
				$('#horario').prop("readonly", true);
            }
            if(joranda == 2)
            {
                $('#horario').val('7:00 - 12:00');
				$('#horario').prop("readonly", true);
            }
            if(joranda == 3)
            {
                $('#horario').val('13:00 - 18:00');
				$('#horario').prop("readonly", true);
            }
            if(joranda == 4)
            {
                $('#horario').val('18:00 - 23:00');
				$('#horario').prop("readonly", true);
            }
            if(joranda == 5)
            {
                $('#horario').val('18:00 - 6:00');
				$('#horario').prop("readonly", true);
            }
            if(joranda == 6)
            {
                $('#horario').val('00:00 - 00:00');
				$('#horario').prop("readonly", false);
            }
            if(joranda == 7)
            {
                $('#horario').val('08:00 - 12:00');
				$('#horario').prop("readonly", true);
            }
          }//AJAX
    });
}
function EliminarLaRotacion(from)
{
    var codigoestudiante = $('#codigoestudiante').val();
    $.ajax({
        type: 'POST',
        url: '../subgrupos/controller/RotacionSubGrupos_html.php',
        async: false,
        dataType: 'json',
        data:$(from).serialize(),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val==true){
                      alert('Se elimino la Rotacion correctamente');
                      location.href='../rotaciones/RotacionEstudiante.php?codigoestudiante='+codigoestudiante;
                   }
            }
    });
}