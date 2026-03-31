// JavaScript Document

 var indice_i;
var indice_j;
var textocelda;
var i=0;
var j=0;
var objetocelda;
var idempresa;
//var datos;

function enviardatos(mescierre,idestudiantegeneral,estado,fechaingreso) {
	var opciones = {
		// función a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		datos = eval(t.responseText);
		procesar(datos);
		}
	}

	new Ajax.Request("modificarvariacionsalario.php?mescierre="+mescierre+"&idestudiantegeneral="+idestudiantegeneral+"&estado="+estado+"&fechaingreso="+fechaingreso, opciones);
	//alert("Entro para cambiar y hacer el query modificarvariacionsalario.php?mescierre="+mescierre+"&idestudiantegeneral="+idestudiantegeneral+"&estado="+estado+"&fechaingreso="+fechaingreso);
	
}
function procesar(datos) {
	// guardo el div donde voy a escribir los datos en una variable
	//contenedor = document.getElementById("lista"); 
	
	texto = "";
	//Itero sobre los datos que me pasaron como parámetro
	for (var i=0; i < datos.length; i++) {
		dato = datos[i];
		//alert(dato.entro);
		texto += "Dato "+i+"  -   campo1:"+dato.idempresasalud+" campo2:"+dato.codigoempresasalud+"<br>";   
		alert(texto);
	}
	
	//Escribo el texto que formé en el div que corresponde
	//contenedor.innerHTML = texto;
}
function cambia_estado(obj,mescierre,idestudiantegeneral,fechaingreso){

 
		if(!obj.checked){
			enviardatos(mescierre,idestudiantegeneral,'200',fechaingreso);
			//alert("entro 200");
		}
		else
		{
			enviardatos(mescierre,idestudiantegeneral,'100',fechaingreso);
			//alert("entro 100"+mescierre+","+idestudiantegeneral+",100,"+fechaingreso);
		}


}

