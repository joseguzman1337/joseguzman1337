/*
*@ivan quintero <quinteroivan@unbosque.edu.co>
*@copyright Universidad el Bosque - Dirección de Tecnología
*@since Febrero 13,  2017
*/
/*
*@david perez <perezdavid@unbosque.edu.co>
*@copyright Universidad el Bosque - Dirección de Tecnología
*@Ultima modificación: Agosto 09, 2017
*/
/*
* @modified David Perez <perezdavid@unbosque.edu.co>
* @since  Noviembre 07, 2017
* Se adiciona recarga en el panel central luego del logueo para segunda clave docente
*/
////////////////////////////////////////////////
// Obfuscated by Javascript Obfuscator v.2.53 //
//        http://javascript-source.com        //
////////////////////////////////////////////////
var theDocument;
var http;
var browser=navigator.appName;
var estiloXLST;
var msxml2DOM;
var rta;

if(browser=='Microsoft Internet Explorer')
{
	http=new ActiveXObject("Microsoft.XMLHTTP");
}
else
{
	http=new XMLHttpRequest();
}

function derecha(e)
{
	if(navigator.appName=='Netscape'&&(e.which==3||e.which==2))
	{
		alert('Botón derecho inhabilitado');
		return false;
	}else if(navigator.appName=='Microsoft Internet Explorer'&&(event.button==02))
	{
		alert('Botón derecho inhabilitado');
	}
}

document.onmousedown=derecha;

function noVisible()
{
	document.getElementById('arbol').style.visibility='hidden';
	document.getElementById('busqueda').style.visibility='hidden';
	document.getElementById('trans').style.visibility='hidden';
	document.getElementById('usuario').style.visibility='hidden';
	document.getElementById('carrera').style.visibility='hidden';
	
	document.getElementById('divlogin').style.visibility='visible';
}

function Visible()
{
	document.getElementById('infoSala').style.visibility='hidden';
	
	document.getElementById('arbol').style.visibility='visible';
	document.getElementById('busqueda').style.visibility='visible';
	document.getElementById('trans').style.visibility='visible';
	document.getElementById('usuario').style.visibility='visible';
	document.getElementById('carrera').style.visibility='visible';
}

function cerrar()
{
	http.open('get','cerrar.php',true);
	http.onreadystatechange=function cerrarRespuesta()
	{
		if(http.readyState==4&&http.status==200)
		{
			noVisible();
                        /*
                         * Comentar este alert
                         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                         * Universidad el Bosque - Direccion de Tecnologia.
                         * Modificado 15 de junio de 2017.
                         */
//			alert('Sesión cerrada correctamente');
                        //end
			hRefIzq('facultadeslv2.php');
			hRefCentral('central.php');
		}
	};
	http.send(null);
}

function seleccionarCarreraCompat(respuesta)
{	
	var url=xmlToArray(respuesta.documentElement.getElementsByTagName("url"));
	var codigorol=xmlToArray(respuesta.documentElement.getElementsByTagName("rol"));
	var codigotipousuario=xmlToArray(respuesta.documentElement.getElementsByTagName("codigotipousuario"));
	var idusuario=xmlToArray(respuesta.documentElement.getElementsByTagName("idusuario"));
	if(codigotipousuario!=='')
	{
		codigotipousuario=codigotipousuario*1;
		switch(codigotipousuario)
		{
			case 600:
				hRefCentral(url[0]);
				break;
			case 500:
				hRefCentral(url[0]);
				hRefIzq('facultadeslv2.php');
				break;
			case 400:
				if(url[0]!==0)
				{
					hRefCentral(url[0]);
					hRefIzq('facultadeslv2.php');
				}else
				{
					var divCarrera=parent.contenidocentral.document.getElementById('bienvenidaIMG');
					var divCarrera2=parent.contenidocentral.document.getElementById('bienvenidaTEXTO');
					http.open('post','seleccionaCarreraAjax.php?idusuario='+idusuario);
					http.onreadystatechange=function manejadorRtaSeleccionaCarrera()
					{
						if(http.readyState==4&&http.status==200)
						{
							divCarrera.innerHTML="";
							divCarrera2.innerHTML="";
							divCarrera.innerHTML=http.responseText;
						}
					};
					http.send(null);
				}
				break;
		}
	}
}

function trasearclave(clave)
{
	var nuevacadena="";
	for(i=0;i<=(clave.length-1);i++)
	{
		switch(clave.charAt(i))
		{
			case "&":nuevacadena+="%26";
				break;
			case "%":nuevacadena+="%25";
				break;
			case "°":nuevacadena+="%b0";
				break;
			case "\"":
				{return false;}
				break;
			case "'":
				{return false;}
				break;
			case ";":
				{return false;}
				break;
			case "¡":nuevacadena+="%a1";
				break;
			case "¿":nuevacadena+="%bf";
				break;
			case "Á":nuevacadena+="%c1";
				break;
			case "á":nuevacadena+="%e1";
				break;
			case "É":nuevacadena+="%c9";
				break;
			case "é":nuevacadena+="%e9";
				break;
			case "Í":nuevacadena+="%cd";
				break;
			case "í":nuevacadena+="%ed";
				break;
			case "Ó":nuevacadena+="%d3";
				break;
			case "ó":nuevacadena+="%f3";
				break;
			case "Ú":nuevacadena+="%da";
				break;
			case "ú":nuevacadena+="%fa";
				break;
			case "Ö":nuevacadena+="%f6";
				break;
			case "ö":nuevacadena+="%d6";
				break;
			case "Ü":nuevacadena+="%dc";
				break;
			case "ü":nuevacadena+="%fc";
				break;
			case "+":nuevacadena+="%2b";
				break;
			case "\\":nuevacadena+="%5c";
				break;
			case "ñ":nuevacadena+="%f1";
				break;
			case "Ñ":nuevacadena+="%d1";
				break;
			case "\$":nuevacadena+="%24";
				break;
			default :nuevacadena+=clave.charAt(i);
				break;
		}
	}
	return nuevacadena;
}

function login()
{
	var passwdtraseado=trasearclave(document.getElementById('clave').value);
	if(passwdtraseado==false)
	{
		alert("Hay caracteres invalidos en la clave del usuario: \n ; ' \"");
		return false;
	}
	var cadena="login="+document.getElementById('login').value+"&password="+passwdtraseado;document.getElementById('clave').value="";passwdtraseado="";	
	http.open('post','../loginv2.php',true);
	http.onreadystatechange=function loginRespuesta()
	{
		if(http.readyState!==4)
		{
			document.getElementById('cargando').innerHTML='<img src="imagesAlt2/cargando.gif">';
			document.getElementById('cargandoTexto').innerHTML='Por favor espere<br>este proceso puede durar varios segundos...';
		}else if(http.readyState==4)
		{
			if(http.status==200)
			{
				document.getElementById('cargando').innerHTML='';
				document.getElementById('cargandoTexto').innerHTML='';
				var respuesta=http.responseXML;
				var respuesta2=http.responseText;
				try
				{
					var autenticacion=xmlToArray(respuesta.documentElement.getElementsByTagName("autenticacion"));
					var url=xmlToArray(respuesta.documentElement.getElementsByTagName("url"));
					var rol=xmlToArray(respuesta.documentElement.getElementsByTagName("rol"));
					var codigotipousuario=xmlToArray(respuesta.documentElement.getElementsByTagName("codigotipousuario"));
					var idusuario=xmlToArray(respuesta.documentElement.getElementsByTagName("idusuario"));
					var mensaje=xmlToArray(respuesta.documentElement.getElementsByTagName("mensaje"));
					var claveViva=xmlToArray(respuesta.documentElement.getElementsByTagName("claveviva"));
					var contadorIntentosFallidos=xmlToArray(respuesta.documentElement.getElementsByTagName("contadorintentosfallidos"));
					var cantidadintentosaccesopermitidos=xmlToArray(respuesta.documentElement.getElementsByTagName("cantidadintentosaccesopermitidos"));
				}catch(e)
				{
					mensaje="ERROR:\nRESPUESTA DE ENTRADA DEFECTUOSA"+respuesta2;
				}if(autenticacion!=='OK')
				{
					alert(mensaje);
				}
				codigotipousuario = codigotipousuario*1;					
				if(codigotipousuario!=0)
				{
					switch(codigotipousuario)
					{
						case 600://1
							if(autenticacion=='OK')
							{
								if(url!='0')
								{
									hRefCentral(''+url+'');
								}
							}else
							{ 
								if(url!='0')
								{
									hRefCentral(''+url+'');
								}
							}
							break;
						case 900://1							
							if(autenticacion=='OK')
							{
								if(url!='0')
								{
									hRefCentral(''+url+'');
								}
							}else
							{ 
								if(url!='0')
								{
									hRefCentral(''+url+'');
								}
							}
						break;
						case 500://2					
							if(autenticacion=='OK')
							{								
								hRefIzq('facultadeslv2.php');
								if(url!='0')
								{
									
									hRefCentral(''+url+'');
								}
							}else if(autenticacion=='SEGCLAVEREQ')
							{
								if(url!='0')
								{
									hRefCentral(''+url+'');
								}
							}else if(autenticacion=='SEGCLAVE')
							{	
								hRefIzq('facultadeslv2.php?segClave');
								if(url!='0')
								{
									hRefCentral(''+url+'');
								}
							}
							else
							{
								if(url!='0')
								{
									hRefCentral(''+url+'');
								}
							}
							break;
						case 400://3							
							if(autenticacion=='OK')
							{
								hRefIzq('facultadeslv2.php');
								if(url!='0')
								{
									hRefCentral(''+url+'');
								}
							}else
							{
								if(url!='0')
								{
									hRefCentral(''+url+'');
								}
							}
							break;
					}
				}
				else
				{
					if(autenticacion=='ERROR')
					{
						if(url!=='0')
						{
							hRefCentral(''+url+'');
						}
					}
				}
			}
		}
	}
	;
	http.setRequestHeader("Connection","Keep-Alive");
	http.setRequestHeader("KeepAliveTimeout","timeout=120, max=993");
	http.setRequestHeader("KeepAliveTimeout","timeout=120, max=993");
	http.setRequestHeader("Cache-Control","no-cache, must-revalidate");
	http.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=LATIN1");
	http.setRequestHeader('Content-Length',cadena.length);
	http.send(cadena);cadena="";
}//login

function hRefCentral(urlc)
{
	if(urlc.length>0)
	{		
		if(browser=='Microsoft Internet Explorer')
		{
			parent.contenidocentral.location.href(urlc);
		}
		else
		{
			parent.contenidocentral.location=urlc;
			return false;
		}
	}
	return true;
}

function hRefIzq(urli)
{
	if(browser=='Microsoft Internet Explorer')
	{
		parent.leftFrame.location.href(urli);
	}else
	{
		parent.leftFrame.location=urli;
	}
	return true;
}

function destruirFrames(urlt)
{
	parent.document.location.href=urlt;
}

function xmlToArray(resultsXml)
{// initiate the resultsArray
	//var resultsArray=new Array();// loop through all the xml nodes retrieving the content
	var resultsArray=[];// loop through all the xml nodes retrieving the content
	for(i=0;i<resultsXml.length;i++)
	{
		resultsArray[i]=resultsXml.item(i).firstChild.data;//alert(resultsArray[i]);
	}// return the node's content as an array
	return resultsArray;
}

function listaAutoCompletadoMenu(campo)
{
	ajax_showOptions(campo,'leeMenus',campo.value);
}

function cargaPrograma(campo)
{
	http.open('post','transacMenu.php?codigotransaccion='+campo.value+'&caso=trans');
	http.onreadystatechange=function manejador()
	{
		if(http.readyState==4)
		{
			var vector=http.responseText.split('-');
			if(vector[0].length>0)
			{
				if(browser=='Microsoft Internet Explorer')
				{
					parent.contenidocentral.location.href(vector[0]);
				}
				else
				{
					parent.contenidocentral.location=vector[0];
				}
			}
		}
	};http.send(null);
}

function peticionAjaxRespuestaBusquedaMenu(idmenu)
{
	http.open('post','transacMenu.php?idmenuopcion='+idmenu+'&caso=id');
	http.onreadystatechange=function manejador()
	{
		if(http.readyState==4)
		{
			var vector=http.responseText.split('-');
			if(vector[0].length>0)
			{
				if(browser=='Microsoft Internet Explorer')
				{
					parent.contenidocentral.location.href(vector[0]);
				}
				else
				{
					parent.contenidocentral.location=vector[0];
				}
			}
		}
	};http.send(null);
}

function recuerdaPasswd()
{
	hRefCentral('../formClaveBDCambiar.php');
}

function cargaPreguntas()
{
	hRefCentral('centralPreguntasFrecuentes.htm');
}
