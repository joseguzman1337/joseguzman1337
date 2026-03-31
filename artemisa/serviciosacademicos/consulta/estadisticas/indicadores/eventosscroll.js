function ajaxTooltip_getTopPos(inputObj)
{		
  var returnValue = inputObj.offsetTop;
  while((inputObj = inputObj.offsetParent) != null){
  	if(inputObj.tagName!='HTML')returnValue += inputObj.offsetTop;
  }
  return returnValue;
}
function ajaxTooltip_getLeftPos(inputObj)
{
  var returnValue = inputObj.offsetLeft;
  while((inputObj = inputObj.offsetParent) != null){
  	if(inputObj.tagName!='HTML')returnValue += inputObj.offsetLeft;
  }
  return returnValue;
}
//Toma el evento onkeydown
function switchKey(obj)
{
	document.onkeydown = (obj!=null) ? keycodedown : true;
	document.onkeypress = (obj!=null) ? register : null;
	//document.onkeyup = (obj!=null) ? shiftLockup : null;
	document.onclick = (obj!=null) ? deshabilita : true;
	
}
//Se ejecuta cuando hay un evento onkeydown y llama a la funcion del
//tipo de cambio
function register(e)
{
	if (!e) e = window.event;
	var keycodedown=e.keyCode;
	resultado=true;
	//alert("keypress"+keycodedown);
	if(!(keycodedown<41&&keycodedown>36||keycodedown==8))
		resultado=tablaformulario(e);
	//shiftLockdown();
	return resultado;
}
//
var keypressshift=false;
function shiftLockdown(e){

kc=e.keyCode?e.keyCode:e.which;
//alert("Down= "+kc);
	if(kc==16){
		if(keypressshift!=true){
			keypressshift=true;
		}
	}
	

}
function shiftLockup(e){

kc=e.keyCode?e.keyCode:e.which;
//alert("Up= "+kc);
	if(kc==16){
		if(keypressshift!=false){
			keypressshift=false;
		}
	}
}
//
var charkeycodedown;
function keycodedown(e){
	if (!e) e = window.event;
	//key = e.keyCode;
	charkeycodedown=e.keyCode;
	resultado=true;
	//alert("keydown="+charkeycodedown);
	if(charkeycodedown<41&&charkeycodedown>36||charkeycodedown==8)
	 resultado=tablaformulario(e);
	//shiftLockdown();
	//alert(charkeycodedown);

return resultado;


}
//
function capLock(e){
var char;
kc=e.keyCode?e.keyCode:e.which;
sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);

if(((kc>=65&&kc<=90)&&!sk)||((kc>=97&&kc<=122)&&sk)){
	//alert("Entro a mayusculas");
	var caracter = kc + 32;
	charreturn = String.fromCharCode(kc);
}
else{
	//alert("Entro a minusculas");
	//var caracter = kc - 32;
	charreturn = String.fromCharCode(kc);
}
return charreturn;
}
//

//Cambio de clase de estilo
function showAsEditable(obj, clear){
	if (!clear){
		Element.addClassName(obj, 'editable');
	}else{
		Element.removeClassName(obj, 'editable');
	}
}
//Toma los eventos que se esten presentando
//alert("antes del event");
Event.observe(window, 'load', initTempGridAjax, false);
//alert("despues del event");
//Inicia 10 segundos despues de la carga
function initTempGridAjax(){
	//alert("Entro papa a temp");
	initGridAjax();
	setTimeout('initGridAjax();',1000);
}
//Inicia eventos para cada celda en juego
function initGridAjax(){

	makeEditable("areaprincipal");
				//alert(idName);

}

var ytablaIni=0;
var xtablaIni=0;
var ytablaHIni=0;
var xtablaHIni=0;
//Ejecuta la funcion correspondiente al evento
function makeEditable(id){
	//alert("entro mucharejo");

	//ytablaIni=document.getElementById("areaprincipal").scrollTop;
	//xtablaIni=document.getElementById("areaprincipal").scrollLeft;
	Event.observe(id, 'scroll', function(){eventoScroll($(id))}, false);
	Event.observe(id, 'mousewheel', function(){eventoMouseWheel($(id))}, false);
	Event.observe(id, 'DOMMouseScroll', function(){eventoDOMMouseScroll($(id))}, false);
	//alert("entro mucharejo");
	//Event.observe(id, 'keydown', function(){prueba()}, false);
	//Event.observe(id, 'mouseover', function(){showAsEditable($(id))}, false);
	//Event.observe(id, 'mouseout', function(){showAsEditable($(id), true)}, false);
}
function eventoScroll(id)
{

//var ytabla=ajaxTooltip_getTopPos(document.getElementById("tablaprincipal"));
var ytabla=document.getElementById("areaprincipal").scrollTop;
//var xtabla=ajaxTooltip_getLeftPos(document.getElementById("tablaprincipal"));
var xtabla=document.getElementById("areaprincipal").scrollLeft;

document.getElementById("titulohorizontal").scrollLeft+=(xtabla-xtablaIni);
document.getElementById("titulovertical").scrollTop+=(ytabla-ytablaIni);

//document.getElementById("pruebaeventos").innerHTML+="id:"+id+" eventoScroll ("+xtabla+","+ytabla+") <br>";

ytablaIni=document.getElementById("areaprincipal").scrollTop;
xtablaIni=document.getElementById("areaprincipal").scrollLeft;
ytablaHIni=document.getElementById("titulohorizontal").scrollTop;
xtablaHIni=document.getElementById("titulohorizontal").scrollLeft;
}
function eventoMouseWheel(id)
{
//var ytabla=ajaxTooltip_getTopPos(document.getElementById("tablaprincipal"));
var ytabla=document.getElementById("areaprincipal").scrollTop;
//var xtabla=ajaxTooltip_getLeftPos(document.getElementById("tablaprincipal"));
var xtabla=document.getElementById("areaprincipal").scrollLeft;

document.getElementById("titulohorizontal").scrollLeft+=(xtabla-xtablaIni);
document.getElementById("titulovertical").scrollTop+=(ytabla-ytablaIni);

//document.getElementById("pruebaeventos").innerHTML+="id:"+id+" eventoScroll ("+xtabla+","+ytabla+") <br>";

ytablaIni=document.getElementById("areaprincipal").scrollTop;
xtablaIni=document.getElementById("areaprincipal").scrollLeft;
ytablaHIni=document.getElementById("titulohorizontal").scrollTop;
xtablaHIni=document.getElementById("titulohorizontal").scrollLeft;

}
function eventoDOMMouseScroll(id)
{
//var ytabla=ajaxTooltip_getTopPos(document.getElementById("tablaprincipal"));
var ytabla=document.getElementById("areaprincipal").scrollTop;
//var xtabla=ajaxTooltip_getLeftPos(document.getElementById("tablaprincipal"));
var xtabla=document.getElementById("areaprincipal").scrollLeft;

document.getElementById("titulohorizontal").scrollLeft+=(xtabla-xtablaIni);
document.getElementById("titulovertical").scrollTop+=(ytabla-ytablaIni);

//document.getElementById("pruebaeventos").innerHTML+="id:"+id+" eventoScroll ("+xtabla+","+ytabla+") <br>";
ytablaIni=document.getElementById("areaprincipal").scrollTop;
xtablaIni=document.getElementById("areaprincipal").scrollLeft;
ytablaHIni=document.getElementById("titulohorizontal").scrollTop;
xtablaHIni=document.getElementById("titulohorizontal").scrollLeft;

}