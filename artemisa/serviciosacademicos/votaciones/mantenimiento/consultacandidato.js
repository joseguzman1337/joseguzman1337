function busquedaXmlFormulario()
{
var documento=document.getElementById("numerodocumentocandidatovotacion").value;
var tipocandidato=document.getElementById("idtipocandidatodetalleplantillavotacion").value;
var file="consultacandidatos.php";
var params="documento="+documento+"&tipocandidato="+tipocandidato;
//alert(file+"?"+params);
process(file,params);
setTimeout('asignarCambiosFormulario();',1000);
}
function asignarCambiosFormulario()
{
	var arrayverificacion=ArregloXMLObj("verificacion");
	//alert(xmlHttp2.responseText);
	if(arrayverificacion[0] == "OK")
	{
		var arraynombre=ArregloXMLObj("nombre");	
		var arrayapellido=ArregloXMLObj("apellido");
		var arraytelefono=ArregloXMLObj("telefono");
		var arraycelular=ArregloXMLObj("celular");
		var arraydireccion=ArregloXMLObj("direccion");
		var arrayimagen=ArregloXMLObj("imagen");
		document.getElementById("imagencandidato").src=arrayimagen[0];
		document.getElementById("imagencandidatotxt").value=arrayimagen[0];
		document.getElementById("nombrescandidatovotacion").value=arraynombre[0];
		document.getElementById("apellidoscandidatovotacion").value=arrayapellido[0];
		document.getElementById("telefonocandidatovotacion").value=arraytelefono[0];
		document.getElementById("celularcandidatovotacion").value=arraycelular[0];
		document.getElementById("direccioncandidatovotacion").value=arraydireccion[0];
	}
	else{
		alert("Datos no encontrados  \narrayverificacion="+arrayverificacion[0]);
	}
}