

$(function(){
	$( "#btnActualizar" ).click(function( ){
		$( "#errordocumentoAnterior" ).html("");
		$( "#errordocumentoNuevo" ).html("");
		$( "#errorTipoDocumentoNuevo" ).html("");
		$("#errorTipoDocumentoAntiguo").html("");
		
		var url="../servicio/validacion.php";	
		$.ajax({
			type:"POST",
			url:url,
			data:$( "#formulario" ).serialize( ),
			success:function( data ){
			$( "#msn" ).html( data );
				}			
			});
			return false;
		});	
		
	$( "#txtDocumentoAnterior" ).keyup(function( ){
		this.value = (this.value + '').replace(/[^0-9]/g, '');
		var url="../sevicio/estudiante.php";
		var tipoDocumento=$( "#cbmTipoDocumentoAnterior" ).val();
		var numeroDocumento=$( "#txtDocumentoAnterior" ).val();
		var accion="anterior";
		
		if( numeroDocumento!="" ){
			$( "#errordocumentoAnterior" ).html("");
		}
		if(tipoDocumento!=-1){
			$.ajax({
		  		url: "../servicio/estudiante.php",
		  		type: "POST",
		  		data: { tipoDocumento : tipoDocumento , numeroDocumento : numeroDocumento , accion : accion },
				success: function( data ){
					$( "#nombreestudiante").html( data );
				}
			});
		}
	 });
	
	$( "#txtDocumentoNuevo" ).keyup(function(){
		this.value = (this.value + '').replace(/[^0-9]/g, '');
		var url="../sevicio/estudiante.php";
		var tipoDocumento=$("#cbmTipoDocumentoNuevo").val();
		var numeroDocumento=$("#txtDocumentoNuevo").val();
		var accion="nuevo";
		
		if( numeroDocumento!="" ){
			$( "#errordocumentoNuevo" ).html("");
		}
	
			if( tipoDocumento!=-1 ){
			$.ajax({
		  		url: "../servicio/estudiante.php",
		  		type: "POST",
		  		data: { tipoDocumento : tipoDocumento , numeroDocumento : numeroDocumento , accion : accion },
				success: function( data ){
					$( "#nombreestudiantenuevo" ).html( data );
				}
			});
		
		}
	});	
	
	$( "#cbmTipoDocumentoAnterior" ).change(function(){
		$("#errorTipoDocumentoAntiguo").html("");
		var numeroDocumento=$( "#txtDocumentoAnterior" ).val("");
		$( "#txtDocumentoAnterior" ).focus( );
		$("#nombreestudiante").html("");
			
	});	
	
	$( "#cbmTipoDocumentoNuevo" ).change(function(){
		$( "#errorTipoDocumentoNuevo" ).html("");
		var numeroDocumento=$( "#txtDocumentoNuevo" ).val("");
		$( "#txtDocumentoNuevo" ).focus( );
		$("#nombreestudiantenuevo").html("");
					
	});	
	
});
	