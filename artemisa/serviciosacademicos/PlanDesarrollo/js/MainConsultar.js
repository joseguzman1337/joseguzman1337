/**
 * @author suarezcarlos
 */

$(document).ready(function(){
	/*$("#btnConsultar").click(function( ){
		var datosD = $("#formConsultar").serialize( );
		var camposVacios = validarFormulario( datosD );
		camposVacios = camposVacios.trim();
		if(camposVacios==""){
			var tipoOperacion = "consultarPlan";
			$( "#btnConsultar" ).button({ label: "Buscando <img width='16' height='16' src='../css/images/cargando.gif' />" });
			$( "#btnConsultar" ).button( "option" , "disabled" , true );
			$.ajax({
				url: "../interfaz/consultarPlanDesarrollo.php",
		  		type: "POST",
		  		data: $( "#formConsultar" ).serialize( ) + "&option="+tipoOperacion,
				success: function( data ){
					data = trim( data );
					$( "#dvTablaConsultarPlan" ).css( "display", "block" );
					$( "#btnConsultar" ).button({ label: "Consultar" });
					$( "#DivConsultarPlan" ).html( data );
					$( "#btnConsultar" ).button( "option", "disabled", false );
				}
			});
		}else{
			crearMensaje( camposVacios );
		}
	});
	
	
	$('#formConsultar').submit(function(){ 
		return false;
	});*/
	
	
	
	$( ".datos" ).click(function( ){
	
	var tipoOperacion = "consultarPlan";
	var idClaseDatos = $( this ).attr( "id" );//identifica el id de la clase que se le dio click en el acordeon
	var idCampos = idClaseDatos.split( "_" );
	var id = idCampos[1];//captura el numero que esta en el id
	var txtCodigoFacultad = $( "#facultad_"+id+"" ).val( );
	var cmbCarrera = $( "#programaacademico_"+id+"" ).val( );
	var cmbLineaConsulta = $( "#lineaestrategica_"+id+"" ).val( );
	var cmbProgramaConsultar = $( "#lineaestrategica_"+id+"" ).val( );
	var cmbProyectoConsultar = $( "#proyecto_"+id+"" ).val( );
	var nombreFacultad = $( "#facultades_"+id+"" ).val( );
	var nombreCarrera = $( "#carreras_"+id+"" ).val( );
	var	nombreLinea = $( "#lineas_"+id+"" ).val( );
	var	nombrePrograma = $( "#programas_"+id+"" ).val( );
	var	nombreProyecto = $( "#proyectos_"+id+"" ).val( );
   	
   		$.ajax({
				url: "../interfaz/consultarPlanDesarrollo.php",
		  		type: "POST",
		  		data: "option="+tipoOperacion+"&txtCodigoFacultad="+txtCodigoFacultad+"&cmbCarrera="+cmbCarrera+"&cmbLineaConsulta="+cmbLineaConsulta+"&cmbProgramaConsultar="+cmbProgramaConsultar+"&cmbProyectoConsultar="+cmbProyectoConsultar+"&facultades="+nombreFacultad+"&carreras="+nombreCarrera+"&lineas="+nombreLinea+"&programas="+nombrePrograma+"&proyectos="+nombreProyecto,
				success: function( data ){
					data = trim( data );
				
   					$( "#dvTablaConsultarPlan" ).css( "display", "block" );
					$( "#btnConsultar" ).button({ label: "Consultar" });
					$( "#DivConsultarPlan" ).html( data );
					$( "#btnConsultar" ).button( "option", "disabled", false );
	
					}
			});
   	
   	
	});
	
	
	$( ".restaurar" ).click(function( ){	
		$( "#dvTablaConsultarPlan" ).html();
		$( "#DivConsultarPlan" ).html("");
		$( "#detallePlan" ).html("");
		$( "#actualizaPlan" ).html("");
		
		
	});

		
	$('#btnRestaurar').click(function(){
		$(".chosen-select").val('-1').trigger("chosen:updated");
		$("#formConsultar").reset( );
		updateSelectLists( );
		$( "#dvTablaConsultarPlan" ).css( "display", "none" );
	}); 
	
	$("#btnRegresarConsultar").on("click",function( ){
		volver( );
	});
		
	$('#txtCodigoFacultad,#cmbCarrera,#cmbLineaConsulta,#cmbProgramaConsultar').change(function(){
		updateSelectLists();
	});
	$('#txtCodigoFacultad').change(function(){
		var emptyselect = '<option value="-1" >Seleccionar</option>';
		$("#cmbProgramaConsultar,#cmbProyectoConsultar,#cmbIndicadorConsultar").html(emptyselect);
		$("#cmbLineaConsulta,#cmbProgramaConsultar,#cmbProyectoConsultar").val('-1').trigger("chosen:updated");
	});

});

function updateSelectLists(){ 
	var cbmLineaConsulta = $('#cmbLineaConsulta').val();
	var cmbProgramaConsultar = $('#cmbProgramaConsultar').val();
	var cmbProyectoConsultar = $('#cmbProyectoConsultar').val();
	var txtCodigoFacultad = $('#txtCodigoFacultad').val();
	var cmbCarrera = $("#cmbCarrera").val();
	
	var url =  '../interfaz/seguimientoPlanDesarrollo.php'; 
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: url,
        data: {
        	option : 'updateSelectLists',
        	txtCodigoFacultad:txtCodigoFacultad,
        	cmbCarrera:cmbCarrera,
        	cbmLineaConsulta:cbmLineaConsulta, 
        	cmbProgramaConsulta:cmbProgramaConsultar, 
			cmbProyectoConsulta:cmbProyectoConsultar
        },
        success: function(data) {
        	if(data.success){
        		$('#cmbCarrera').html(data.values.carreras);
        		$('#cmbProgramaConsultar').html(data.values.programas);
        		$('#cmbProyectoConsultar').html(data.values.proyectos);
        		$(".chosen-select").trigger("chosen:updated");
        	}
        },
        error: function(xhr, status, error) {
        	alert("An error occured: " + status + "\nError: " + error);
        }
    });  
}
