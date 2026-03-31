<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
</div>
</form>
</body>
<script language="javascript">
//Mueve las opciones seleccionadas en listaFuente a listaDestino
function moverOpciones(listaFuente, listaDestino) 
{
	var i;
	var d = listaDestino.options.length;
	//Recorre la lista fuente buscando elementos seleccionados
	for (i = 0; i < listaFuente.options.length; i++) 
	{
		if(listaFuente.options[i].value != 0)
		{
			if (listaFuente.options[i].selected && listaFuente.options[i].value != "") 
			{
				//Mueve el elemento seleccionado de la lista fuente a la lista destino
				var opciont = new Option();
				opciont.value = listaFuente.options[i].value;
				
				opciont.text  = listaFuente.options[i].text;
				listaDestino[d] = opciont;
				d++;
				listaFuente[i] = null;
				i--;
			}
		}
	}
}

function activarLista(lista)
{
	for (i = 0; i < lista.options.length; i++) 
	{
		lista.options[i].selected = true;
	}
}

function verLista(lista) 
{
	var listado = "";
	var longLista = lista.options.length;
	var contador;
	var mensaje = "Lista de opciones (valor,texto)";
	for (contador = 0;contador <longLista;contador++) 
	{
		listado = listado + "  (" + lista.options[contador].value + ","
		listado = listado + lista.options[contador].text + ")";
	}
	mensaje = mensaje + "\n" + listado
	alert(mensaje);
}
</script>
</html>
