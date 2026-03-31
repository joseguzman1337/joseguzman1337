<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Lista de Asistencia",TRUE);

    $utils = Utils::getInstance();
?>

    <div id="contenido">
        <h4>Listas de Asistencia</h4>
        <div id="form"> 
         <form action="asistencia.php" method="post" id="form_test" name="myform">
             <input type="hidden" name="action" value="getParticipantes" />
                <div class="campo">
                    <label for="nombre" class="grid-2-12">Fecha: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-2-12 required dateInput" id="fechaLista" minlength="1" name="fechaLista" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                          
				
                    <label for="nombre" class="grid-2-12">Curso: <span class="mandatory">(*)</span></label>
                    <input type="text"  class="grid-6-12" minlength="2" name="carrera" id="carrera" title="Nombre de la Carrera" maxlength="120" tabindex="1" autocomplete="off" value="<?php echo $data["nombrecarrera"]; ?>"  />
			<input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $data["codigocarrera"]; ?>" /> 
					
		<label for="nombre" class="grid-2-12">Grupo: <span class="mandatory">(*)</span></label>
		<select name="idgrupo" id="grupos" class="required"><option value=""></option></select>
					
		<label for="nombre" class="grid-2-12">Horas de la sesión: </label>
                <input type="text" class="grid-2-12 number" id="horasSesion" minlength="1" name="horasSesion" maxlength="4" tabindex="1" autocomplete="off" value="" />
                    
                </div>
				<div class="vacio"></div>
             
             <input type="button" id="generarLista" value="Generar lista de asistencia" class="first" />
             <input type="button" id="hacerAsistencia" value="Guardar asistencia en el sistema" />
         </form>
        </div>
    </div>  


<script type="text/javascript">
                $('#generarLista').click(function(event) {
                    event.preventDefault();
                    $("#horasSesion").removeClass("required");
                    var valido= validateForm("#form_test");
                    if(valido){   
							var grupo = $('#grupos').val();
							var fecha = $("#fechaLista").val();
							popup_carga("./generarLista.php?id="+grupo+"&fecha="+fecha);
						
                    }
                });
                $('#hacerAsistencia').click(function(event) {
                    event.preventDefault();
                    $("#horasSesion").addClass("required");
                    var valido= validateForm("#form_test");
                    if(valido){
                        //sendForm();
						var horas = parseFloat($("#horasSesion").val());
						if(horas>0 && horas<=24){
							var promise = verificarLista();
							promise.success(function (data) {
								if(data.registrado==true){
									alert("Ya se registró la lista de asistencia para esta fecha.");
								} else {
									document.myform.submit();
								}
							});
						} else{
							$("#horasSesion").addClass('error');
							$("#horasSesion").effect("pulsate", { times:3 }, 500);
						}
                    }
                });
                
                $(function() {
                    $( "#fechaLista" ).datepicker({
                            defaultDate: "0d",
                            changeMonth: true,
                            dateFormat: "yy-mm-dd"//,
                            //minDate: "-1M",
                            //maxDate: "+15D"
                        }
                    );
                    $( "#ui-datepicker-div" ).show();
                });
                
                $(document).ready(function() {
                    $('#ui-datepicker-div').hide();
                });
               

              
$(document).ready(function(){
    $('#carrera').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "../searches/lookForCursos.php",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.label,
                            value: item.value,
                            id: item.id
                        }
                    }));
                }
            });
        },
        minLength: 2,
        selectFirst: false,
        open: function(event, ui) {
            var maxWidth = $('#form_test').width()-400;  
            var width = $(this).autocomplete("widget").width();
            if(width>maxWidth){
                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
            }
            
        },
        select: function( event, ui ) {
            //alert(ui.item.id);
            $('#codigocarrera').val(ui.item.id);
            if($("#fechaLista").val()==""){ alert("Debe elegir una fecha");
                    $("#grupos").html("<option value=''></option>"); } else{
			//Traer grupos para esa fecha
			getGrupos();
            }
            
        }                
    });
	

});

$('#fechaLista').change(function(){
    if(document.getElementById('codigocarrera').value==''){
         //no ha elegido la carrera    
         $("#grupos").html("<option value=''></option>");
    } else {
        getGrupos();
    }
});

$('#carrera').change(function(){
    if(document.getElementById('carrera').value==''){
        document.getElementById('codigocarrera').value='';
        
    }
});	

function getGrupos(){
    var carrera = $('#codigocarrera').val();
    var fecha = $("#fechaLista").val();
    $.ajax({
	dataType: 'json',
	type: 'POST',
	async: false,
	url: '../searches/lookForGrupos.php',
	data: {carrera: carrera,fecha:fecha},                
	success:function(data){
		if (data.success == true){
                        var opciones = "";
			for (var i=0;i<data.total;i++)
                        {              
                            opciones = opciones + "<option value='"+data.data[i].value+"'>"+data.data[i].label+"</option>";                                      
                        }
                        $("#grupos").html(opciones);
		} else {                    
                        $("#grupos").html("<option value=''></option>");
			alert("No hay grupos activos para esta fecha del curso elegido.");
		}
	},
	error: function(data,error,errorThrown){alert(error + errorThrown);}
   }); 
}

function popup_carga(url){        
        
            var centerWidth = (window.screen.width - 850) / 2;
            var centerHeight = (window.screen.height - 700) / 2;
    
          var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
          var mypopup = window.open(url,"",opciones);
          //Para que me refresque la página apenas se cierre el popup
          //mypopup.onunload = windowClose;​
          
          //para poner la ventana en frente
          window.focus();
          mypopup.focus();
          
      }
	  
	function verificarLista(){
			var grupo = $("#grupos").val();
			var fecha = $("#fechaLista").val();
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: '../searches/validarLista.php',
                            data: { grupo: grupo, fecha: fecha },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
	}
  </script>
<?php  writeFooter(); ?>