/**
 * @author suarezcarlos
 */




$(function() {
	
	
	var codigoPeriodo = $("#Periodo").val( );
	$("#periodoNuevo").val(codigoPeriodo);
	var codigoPeriodoAntiguo = $("#Periodo").val( );
	
	var estadoPeriodo = $("#estadoPeriodo").val();
	
	if( estadoPeriodo == 2 ){
		$("#tabs_2").css("display","none");
		$("#tabs_resumen_boton").css("display","none");
	}else{
		fechaActual();
	}
	
	$("#periodoNuevo").change(function( ){
		var codigoPeriodo = $("#periodoNuevo").val( );
		var id_Docente = $("#DocenteId").val( );
		var Periodo = $("#Periodo").val( );
		var link = 'index.php?id_Docente='+id_Docente+'&codigoPeriodo='+codigoPeriodo;
		$.ajax({
		   type: 'POST',
		   url: 'index.php?id_Docente='+id_Docente+'&codigoPeriodo='+codigoPeriodo,
		   data: { codigoPeriodo : codigoPeriodo },
		   success: function(data){
		   	
		   	$("#estadoPeriodo").val(estadoPeriodo);
		   
		   $.ajax ({  
      		type: 'POST',
      		url: 'validarMigrar.php',
      		data: { codigoPeriodo : codigoPeriodo, id_Docente : id_Docente, codigoPeriodoAntiguo : codigoPeriodoAntiguo },
      		success: function(data){
      			//alert(data);
      		if( codigoPeriodo > codigoPeriodoAntiguo ){ 
      			//alert( data );
	      		if( data == 0 ){
	      		$( "#migracionDatos" ).dialog( "option", "buttons", {
						"Sí": function() {
							
							$.ajax({
								type: "POST",
						  		url: "migrarDatos.php",
						  		data: { codigoPeriodoAntiguo : codigoPeriodoAntiguo, codigoPeriodo : codigoPeriodo, id_Docente : id_Docente },
								success: function( data ){
									//if( data == 0 ){
										alert(data);
										combo(link);
									/*}else{
										alert(data);
										combo(link);
									}*/
									
								}
							});
						},
						"No":function(){
							
							combo(link);
						     //$(".wrapper-general").html(data);
						     $("#periodoNuevo").val( codigoPeriodo );
							$( "#migracionDatos" ).dialog( "close" );
						}
					});
					$( "#migracionDatos" ).dialog( "open" );
					}else{
						combo(link);
					}
				}else{
					combo(link);
				}	
      		}
      		
    	});	
		   
	   		 /*combo(link);
		     //$(".wrapper-general").html(data);
		     $("#periodoNuevo").val( codigoPeriodo );*/
		    // $("#Periodo").val($(this).val());
		   }
		   
	 	});
		/*if( codigoPeriodo > codigoPeriodoAntiguo ){
	 			$( "#migracionDatos" ).dialog( "open" );
 		}else{
	 			combo(link);
 		}*/
	});
	
});

function combo(link){
	location.href = link;
	/*$("#migrar").change(function(){
		alert($('#migrar').val());
	});*/
	
}

function fechaActual(){
	var d = new Date();
	
	var month = d.getMonth()+1;
	var day = d.getDate();
	var output = d.getFullYear() + '/' +
    	((''+month).length<2 ? '0' : '') + month + '/' +
    	((''+day).length<2 ? '0' : '') + day;
    	
    var rango = [5,6,11,12];
   
	if( rango.indexOf(month) == -1 ){
		$("#btnAutoevaluacion").prop("disabled", true);
		$("#btnAutoevaluacion").css({'background':'grey'});
		$("#btnPlanMejora").prop("disabled", true);
		$("#btnPlanMejora").css({'background':'grey'});
	}/*else{
		$("#btnAutoevaluacion").prop("disabled", true);
		$("#btnAutoevaluacion").css({'background':'grey'});
		$("#btnPlanMejora").prop("disabled", true);
		$("#btnPlanMejora").css({'background':'grey'});
	}*/
	
	/*if( ( month != '6' && month != '11' ) ){
		if( ( month <= '5' && day <= '31' ) || ( month <= '10' && day <= '31' ) ){
			
			$("#btnAutoevaluacion").prop("disabled", true);
			$("#btnAutoevaluacion").css({'background':'grey'});
			$("#btnPlanMejora").prop("disabled", true);
			$("#btnPlanMejora").css({'background':'grey'});
		}
	}*/
}





