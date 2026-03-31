/**
 * @author suarezcarlos
 */



function trim ( dato ){
	dato = String( dato );
	return dato.replace(/^\s+/g,'').replace(/\s+$/g,'');
}

function llenarFormulario( data ){
	var datos = data.split('&');
	//alert(datos);
	for( var i = 0 ; i < datos.length ; i++ ){
		var campo = datos[i].split('=');
		$( "#"+campo[0] ).val( trim( campo[1] ) );
		//alert(campo[0] + ' ' + campo[1]);
	}
}

