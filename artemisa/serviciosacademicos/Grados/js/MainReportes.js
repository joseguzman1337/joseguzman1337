/**
 * @author suarezcarlos
 */

$('dl dd').not('dt.activo + dd').hide();
   	$('dl dt').click(function(e ){
                e.stopImmediatePropagation();
  		if ($(this).hasClass('activo')) {
   			$(this).removeClass('activo');
      		 $(this).next().slideUp();
  		} else {
       		$('dl dt').removeClass('activo');
			$(this).addClass('activo');
   			$('dl dd').slideUp();
           	$(this).next().slideDown();
      	}
   });
   

/*$(".btnTipoReporte").click(function( key, value ) {
	var txtCodigoReferencia = $(".txtCodigoReferencia").val( );
	alert( txtCodigoReferencia );
});*/

$(".btnTipoReporte").button( ).on("click", function( ) {
	var txtCodigoReferencia = $(this).val();
	
	//evita la recargar de paginas
	$(".btnTipoReporte").off('click');
	
	$.ajax({
			url: "../interfaz/reportes.php",
			type: "POST",
			data: { txtCodigoReferencia : txtCodigoReferencia },
			success: function( data ){
				$("#dvReporte").css("display", "none");
				$("#dvResultado").html( data );
			}
		});
	return false;
});

$("#btnVolver").on("click",function( e ){
         e.stopImmediatePropagation();
        $('#diplomasduplicados').hide(); 
	$("#dvReporte").css("display", "block");
	$("#dvTipoReporte").css("display", "none");
	$("#dvBotonVolver").css("display", "none");
	$("#cmbFacultadTReporte").off('change');
	$("#btnVolver").trigger("click")
	
});



