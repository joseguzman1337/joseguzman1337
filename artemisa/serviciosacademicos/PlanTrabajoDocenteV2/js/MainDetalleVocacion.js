/**
 * @author suarezcarlos
 */

$(function() {
	
	
	var codigoPeriodo = $("#Periodo").val( );
	
	$("#periodoVocacion").val(codigoPeriodo);
	
	
	$("#periodoVocacion").change(function( ){
		var codigoPeriodo = $("#periodoVocacion").val( );
		var Periodo = $("#Periodo").val( );
		var link = 'verDetalleVocaciones.php?codigoPeriodo='+codigoPeriodo;
		$.ajax({
		   type: 'POST',
		   url: 'verDetalleVocaciones.php?codigoPeriodo='+codigoPeriodo,
		   data: { codigoPeriodo : codigoPeriodo },
		   success: function(data){
	   		 comboDecano(link);
		     //$(".wrapper-general").html(data);
		     $("#periodoVocacion").val( codigoPeriodo );
		    // $("#Periodo").val($(this).val());
		   }
		   
	 	});
	});
	
});

function comboDecano(link){
	location.href = link;
}