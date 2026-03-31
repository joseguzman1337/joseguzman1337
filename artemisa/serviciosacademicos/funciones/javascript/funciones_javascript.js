function abrir(pagina,ventana,parametros)
{
	window.open(pagina,ventana,parametros);
}
function enviar()
{
	document.form1.submit()
}
function Confirmacion(link_si,link_no)
{
	if(confirm('La autorización de grado no es reversible. ¿Desea continuar?'))
	{
		document.form1.submit();
		window.location.reload('creacion_folios_automaticos.php?link_origen=menu.php');
	}
}
function reCarga(url)
{
	window.location.href = url
} 