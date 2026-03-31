// JavaScript Document
var vectorlimite=new Array();
	vectorlimite[0]=new Array();
	vectorlimite[1]=new Array();
	vectorlimite[2]=new Array();
	vectorlimite[3]=new Array();
	vectorlimite[4]=new Array();
var indice_i;
var indice_j;
var textocelda;
//var i=0;
var flecha=0;
var puntero=0;
var objetocelda;
var tmpobjetocelda;
var idempresa;
var archivo;
var contadorlimite=0;
var limite;
var tipocampo;
var funcionCelda= new Array("celdaCampo","celdaMenu","celdaCheckbox");
var idName;
function switchKey(obj)
{
	document.onkeydown = (obj!=null) ? register : null;
	//document.onkeypress = (obj!=null) ? register : null;
	//document.onkeyup = (obj!=null) ? register : null;
}

function register(e)
{
	if (!e) e = window.event;
	resultado=tablaformulario(e);
	return resultado;
}

function showAsEditable(obj, clear){
	if (!clear){
		Element.addClassName(obj, 'editable');
	}else{
		Element.removeClassName(obj, 'editable');
	}
}

Event.observe(window, 'load', init, false);

function init(){
	for(k=0;k<contadorlimite;k++){
		for(i=vectorlimite[0][k];i<=vectorlimite[2][k];i++)
			for(j=vectorlimite[1][k];j<=vectorlimite[3][k];j++){
				eval("var idName=\"f_"+j+"_"+i+"\"");
				makeEditable(idName);
			}
	}
}

function makeEditable(id){



	Event.observe(id, 'click', function(){obtenerCelda($(id))}, false);
	//Event.observe(id, 'keydown', function(){prueba()}, false);
	//Event.observe(id, 'mouseover', function(){showAsEditable($(id))}, false);
	//Event.observe(id, 'mouseout', function(){showAsEditable($(id), true)}, false);
}
function obtenerCelda(celda)
{  

	switchKey(celda);
	
	if(puntero>0){  
	tmpobjetocelda.bgColor='';
	}
	flecha=0;
	numeros=celda.id.replace("f_","");
	elementos=celda.id.split("_");
	indice_i=elementos[1];
	indice_j=elementos[2];
	for(i=0;i<contadorlimite;i++){
	if(indice_i>=vectorlimite[1][i]&&indice_i<=vectorlimite[3][i])
			if(indice_j>=vectorlimite[0][i]&&indice_j<=vectorlimite[2][i]){
				objetocelda=celda;
				objetocelda.bgColor='2684BF'
				tipocampo=vectorlimite[4][i];
				limite=i;
				puntero++;
			}
	}
tmpobjetocelda=objetocelda;
	
}
function tablaformulario(event){
	eval("resultado="+funcionCelda[tipocampo]+"(event,"+limite+");");
	return resultado;
}
function nuevosLimites(inicialcolumna,inicialfila,limitecolumna,limitefila,tipocambio){
	vectorlimite[0][contadorlimite]=inicialcolumna;
	vectorlimite[1][contadorlimite]=inicialfila;
	vectorlimite[2][contadorlimite]=limitecolumna;
	vectorlimite[3][contadorlimite]=limitefila;
	vectorlimite[4][contadorlimite]=tipocambio;
	contadorlimite++;
	init();	
}
function archivo(nombrearchivo){
	archivo=nombrearchivo;
	}
function submitajax(cadenaget) {
	var opciones = {
		// función a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		datos = eval(t.responseText);
		procesar(datos);
		}
	}
	new Ajax.Request(cadenaget, opciones);
}



function celdaCampo(event,limiteceldas){

columnas		=vectorlimite[0][limiteceldas];
filas			=vectorlimite[1][limiteceldas];
limitecolumna	=vectorlimite[2][limiteceldas];
limitefila		=vectorlimite[3][limiteceldas];
		if(window.event)
			key=window.event.keyCode;
		else if (event)
			key = event.which;
		
		char=String.fromCharCode(key);
		tmp2_indice_i=indice_i;
		tmp2_indice_j=indice_j;
		switch(key){
		case 40:
		tmp_indice_i=indice_i;
			tmp_indice_i++;
		if(tmp_indice_i<=limitefila&&tmp_indice_i>=filas)
			indice_i++;
			break;
		case 38:
		tmp_indice_i=indice_i;
			tmp_indice_i--;
		if(tmp_indice_i<=limitefila&&tmp_indice_i>=filas)
			indice_i--;
			break;
		case 39:
		tmp_indice_j=indice_j;
		tmp_indice_j++;
		if(tmp_indice_j<=limitecolumna&&tmp_indice_j>=columnas)
			indice_j++;
			break;
		case 37:
		tmp_indice_j=indice_j;
		tmp_indice_j--;
		if(tmp_indice_j<=limitecolumna&&tmp_indice_j>=columnas)
			indice_j--;
			break;
		case 8:
			objetocelda.innerHTML=" ";
			break;
		default:
		if(flecha==0)
		objetocelda.innerHTML="";
		objetocelda.innerHTML+=char;
		break;
		}
		flecha++;
		if((key<=40)&&(key>=37)){
			if(flecha>0){
				objetocelda.bgColor='';
					
					eval("f_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".bgColor='';")
					eval("valoranterior=f_"+tmp2_indice_i+"_"+(tmp2_indice_j)+";")
					//alert(valoranterior.innerHTML);/*****/
					//alert(arrayParametrosAjax);
					//alert(arrayParametrosAjax.length);
					var cadenaGet;
					for (i=0; i< arrayParametrosAjax.length; i++)
					{
						cadenaGet="tabla="+arrayParametrosAjax[i][0]+"&id="+arrayParametrosAjax[i][1]+"&campo="+arrayParametrosAjax[i][2]+"&valor="+valoranterior.innerHTML+"&tipooperacion="+arrayParametrosAjax[i][7]+"&validacion="+arrayParametrosAjax[i][8];
					}
					alert(cadenaGet);
					//new Ajax.Request(cadenaget, opciones);
					
					
						}
			eval("f_"+indice_i+"_"+indice_j+".bgColor='2684BF';")
			eval("objetocelda=f_"+indice_i+"_"+indice_j+";");
			flecha=0;
			
		}
				
		return false;
}

function ssubmitajax(cadenaget) {
	var opciones = {
		// función a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		datos = eval(t.responseText);
		procesar(datos);
		}
	}
	new Ajax.Request(cadenaget, opciones);
}



//Funcion por celda debe utilizarse con un onclick sobre el input checkbox
function celdaCheckbox(obj,parametrostrue,parametrosfalse){
	if(!obj.checked){
		submitajax(archivo+parametrostrue);
	}
	else
	{
		submitajax(archivo+parametrosfalse);
	}
	
}
//Esta funcion debe ser utilizada 
function cambiamenu(){

			seleccionado=form1.epsnueva.selectedIndex;
			p = form1.epsnueva[form1.epsnueva.selectedIndex].value;
    		t = form1.epsnueva[form1.epsnueva.selectedIndex].text;
			textoseleccionado=""+p+"-"+t;
			codigoseleccionado=p;

			//alert(""+p+"-"+t);
			estadoclick=true;		
}
//
function celdaMenu(event,limite){

			columnas		=vectorlimite[1][limite];
			filas			=vectorlimite[2][limite];
			limitecolumna	=vectorlimite[3][limite];
			limitefila		=vectorlimite[4][limite];
			parametroadicional=parametro;
			form1.epsnueva.options[seleccionado].selected=true
			p = form1.epsnueva[form1.epsnueva.selectedIndex].value;
    		t = form1.epsnueva[form1.epsnueva.selectedIndex].text;
			textoseleccionado=""+p+"-"+t;
			codigoseleccionado=p;
			

		//var char;
		//char=window.event.keychar;
		var cadena="<select name='select'><option value='1'>Opcion1</option><option value='2'>Opcion2</option><option value='3'>Opcion3</option></select>";
		if(window.event)
			key=window.event.keyCode;
		else if (event)
			key = event.which;
		char=String.fromCharCode(key);
		//alert(key);
		tmp2_indice_i=indice_i;
		tmp2_indice_j=indice_j;
		
		if(key==13){
		estadoflecha=true;
		tmp_indice_i=indice_i;
			tmp_indice_i++;
		if(tmp_indice_i<=filas&&tmp_indice_i>=limitefila)
			indice_i++;
		cadenaget="crearingresoaportes.php?idestudiantegeneral="+idestudiante+"&idempresasalud="+codigoseleccionado+parametroadicional;
		//+"&idempresasalud="codigoseleccionado+parametro;
		//alert(cadenaget);
		submitajax(cadenaget);
	
		}
		
	if(estadoflecha==true){
		switch(key){
		case 40:
		tmp_indice_i=indice_i;
			tmp_indice_i++;
		if(tmp_indice_i<=filas&&tmp_indice_i>=limitefila)
			indice_i++;
			break;
		case 38:
		tmp_indice_i=indice_i;
			tmp_indice_i--;
		if(tmp_indice_i<=filas&&tmp_indice_i>=limitefila)
			indice_i--;
			break;
		case 39:
		tmp_indice_j=indice_j;
		tmp_indice_j++;
		if(tmp_indice_j<=columnas&&tmp_indice_j>=limitecolumna)
			indice_j++;
			break;
		case 37:
		tmp_indice_j=indice_j;
		tmp_indice_j--;
		if(tmp_indice_j<=columnas&&tmp_indice_j>=limitecolumna)
			indice_j--;
			break;
		case 8:
			objetocelda.innerHTML=" ";
			break;
		default:
		if(i==0)
		objetocelda.innerHTML="";
		objetocelda.innerHTML+=char;
		//objetocelda.innerHTML=cadena;
		break;
		}
		//alert("celda_"+indice_i+"_"+indice_j+".bgColor='2684BF';"); 
		flecha++;

		if(((key<=40)&&(key>=37))||(key==13)){

			//eval("idempresa=celda_"+tmp2_indice_i+"_"+(tmp2_indice_j+1)+".innerHTML;")
			if(flecha>0){
			objetocelda.style.background='';
			//objetocelda.innerHTML="";
			

			//objetocelda.focus()=false;
			//if(IsNumeric(objetocelda.innerHTML)){
			//enviardatos(objetocelda.innerHTML,idempresa);
			eval("celda_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".style.background='';")
			eval("celda_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".innerHTML='';")

			//alert("celda_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".innerHTML='';");
//}
			//else{
			//alert("Valor no numerico "+objetocelda.innerHTML);
			//eval("celda_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".style.background='#993333';")
			//objetocelda.style.background="#993333";

			objetocelda.innerHTML="";
			idestudiante="";
			//}
			
			//procesar(datos);
			}
			


			eval("celda_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".innerHTML='"+textoseleccionado+"';")
			eval("objetocelda=celda_"+indice_i+"_"+indice_j+";");
			eval("idestudiante=idestudiante_"+indice_i+"_"+indice_j+".value;");

			objetocelda.innerHTML=menu;
			//eval("celda_"+indice_i+"_"+indice_j+"="+menu+";");
			
			
			form1.epsnueva.options[seleccionado].selected=true;
			form1.epsnueva.focus();
			estadoflecha=false;
			p = form1.epsnueva[form1.epsnueva.selectedIndex].value;
    		t = form1.epsnueva[form1.epsnueva.selectedIndex].text;
			seleccionado=form1.epsnueva.selectedIndex;
			textoseleccionado=""+p+"-"+t;
			codigoseleccionado=p;
			//alert(menu);
			eval("celda_"+indice_i+"_"+indice_j+".bgColor='2684BF';")
			//eval("objetocelda=celda_"+indice_i+"_"+indice_j+";");
			//return true;
			i=0;
		}
		}
		else
		{return true;}
		//text1.value=objetocelda.innerHTML;
		
		return false;
		
}
