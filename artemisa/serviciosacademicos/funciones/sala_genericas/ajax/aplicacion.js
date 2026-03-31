
function HicieronClick() {
	var opciones = {
		// funciÃ³n a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		datos = eval(t.responseText);
		procesar(datos);
		}
	}

	new Ajax.Request('datos2.php', opciones);
}

function procesar(datos) {
	// guardo el div donde voy a escribir los datos en una variable
	contenedor = document.getElementById("lista"); 
	
	texto = "";
	//Itero sobre los datos que me pasaron como parÃ¡metro
	for (var i=0; i < datos.length; i++) {
		dato = datos[i];
		texto += "Dato "+i+"  -   campo1:"+dato.nombrecarrera+" campo2:"+dato.codigocarrera+"<br>";   
	}
	//Escribo el texto que formÃ© en el div que corresponde
	contenedor.innerHTML = texto;
}

