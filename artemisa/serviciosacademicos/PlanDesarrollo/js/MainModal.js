
/* 
* @author Ivan quintero 
 * Febrero 22, 2017
 */

function verPlanModal( txtIdMetaSecundaria, tipoOperacion ){
	$.ajax({
		type: "POST",
	    url: "../interfaz/detallePlan.php",
		data: { txtIdMetaSecundaria : txtIdMetaSecundaria , tipoOperacion : tipoOperacion },
		success: function( data ){

	  	$( "#detallePlan" ).html( data );
	  	$( "#detallePlan" ).modal( "show" );
		  	
	    }
	});
	
}
