// JavaScript Document
var vectorlimite=new Array();
	vectorlimite[0]=new Array();
	vectorlimite[1]=new Array();
	vectorlimite[2]=new Array();
	vectorlimite[3]=new Array();
	vectorlimite[4]=new Array();
	
var nombrescolumnas=new Array();
var columnasparametro=new Array();
var columnascambio=new Array();
var parametrosadicionales=new Array();

var archivo="insertar.php";
var indice_i;
var indice_j;
var textocelda;
//var i=0;
var zona=0;
var flecha=0;
var puntero=0;
var objetocelda;
//var tmpobjetocelda;
var tmpobjetoceldamenu=null;
var tmp_indice_i_menu;
var tmp_indice_j_menu;

var idempresa;
var archivo;
var contadorlimite=0;
var limite;
var tipocampo;
var funcionCelda= new Array("celdaCampo","celdaMenu","celdaCheckbox");
var idName;
var textoseleccionadomenu;
var codigoseleccionadomenu;
var seleccionadomenu;
var estadoclickmenu=false;
var estadochangemenu=false;
var tmpinnerhtml;
var tmpCeldaInnerHTML="";
var tmpCeldaBgColor="";

var tmpObjetoCelda;
var tmpobjetocelda;
var anulaCelda=false;
var editaCelda=true;

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
function deshabilita()
{
	//alert("Entra");

	if(tmpCeldaInnerHTML!=""&&anulaCelda==true){
	tmpObjetoCelda.innerHTML=tmpCeldaInnerHTML;
	tmpObjetoCelda.style.background=tmpCeldaBgColor;
	editaCelda=false;
	}
	else
	anulaCelda=true;


}
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
	//alert("Entro papa a init");
	for(k=0;k<=contadorlimite;k++){
		for(i=vectorlimite[0][k];i<=vectorlimite[2][k];i++){
			for(j=vectorlimite[1][k];j<=vectorlimite[3][k];j++){
				var idName="f_"+j+"_"+i;
				//alert(idName.innerHTML);
				//if(document.getElementById(idName)!=null)
				//alert("entro mucharejo "+idName);
				nombreid=document.getElementById(idName);
				//alert(nombreid.innerHTML);
				
				makeEditable(nombreid);
				//alert(idName);
			}
			//alert("i="+i);
		}
	}
	//alert(k);
}
//Ejecuta la funcion correspondiente al evento
function makeEditable(id){
	//alert("entro mucharejo");


	Event.observe(id, 'click', function(){obtenerCelda($(id))}, false);
	//alert("entro mucharejo");
	//Event.observe(id, 'keydown', function(){prueba()}, false);
	//Event.observe(id, 'mouseover', function(){showAsEditable($(id))}, false);
	//Event.observe(id, 'mouseout', function(){showAsEditable($(id), true)}, false);
}
//Inicia los parametros de columnas a enviar por zona
function envioParametros(columnacambio,archivocambio,columnasparametrocambio,parametrosgenerales,conzona){
	//columnasparametrocambio es un array de que puede conteber varios numeros de columna
	archivo=archivocambio;
	columnascambio[zona]=columnacambio;
	columnasparametro[zona]=new Array();
	columnasparametro[zona]=columnasparametrocambio;
	parametrosadicionales[zona]=parametrosgenerales;
	//alert("Columnas="+columnasparametro[zona]+"zona="+zona);
	estadoclickmenu=false;
	estadochangemenu=false;
	zona=conzona;
}
//Toma como parametro un array con nombres de columnas
function asignarcolumnas(columnas){
	for(i=0;i<columnas.length;i++)
		nombrescolumnas[i]=columnas[i];
}
//Para el evento onclick sobre cualquier celda en juego toma los indices y 
//sobresalta ademas ejecuta la funcion correpondiente al tipo
//de cambio de la zona
function obtenerCelda(celda)
{  

	//alert(celda.innerHTML);
	anulaCelda=false;
	editaCelda=true;
	switchKey(celda);
			
	if(puntero>0){  
	tmpobjetocelda.style.background='';
	tmpobjetocelda.innerHTML=tmpCeldaInnerHTML;
	}


	//if(tmpCeldaInnerHTML!="")
	tmpCeldaInnerHTML=celda.innerHTML;
	tmpCeldaBgColor=celda.style.background;
	tmpObjetoCelda=celda;
	//tmp2ObjetoCelda=celda;
	//else
		
	puntero++;
	flecha=0;
	numeros=celda.id.replace("f_","");
	elementos=celda.id.split("_");
	indice_i=elementos[1];
	indice_j=elementos[2];
	//alert("Celda="+tmpObjetoCelda.id+" I="+indice_i+" J="+indice_j);
	for(i=0;i<=contadorlimite;i++){
		if((indice_i>=vectorlimite[1][i])&&(indice_i<=vectorlimite[3][i]))
		{
			if(indice_j>=vectorlimite[0][i]&&indice_j<=vectorlimite[2][i])
			{
				objetocelda=celda;
				objetocelda.style.background='#2684BF';
				tipocampo=vectorlimite[4][i];
				limite=i;
				puntero++;
				tmpobjetocelda=objetocelda;
				//alert(" Otro -> indice_i="+indice_i+" indice_j="+indice_j);
			}
		}
	//alert("Entro="+vectorlimite[1][i]);
	}
	//estadoclickmenu=false;
//tmpinnerhtml=objetocelda.innerHTML;
charkeycodedown=0;
tablaformulario(window.event);
tmpobjetocelda=objetocelda;

}
//Ejecuta función correspondiente a la zona
function tablaformulario(event){
	//alert("resultado="+funcionCelda[tipocampo]+"(event,"+limite+");");
	eval("resultado="+funcionCelda[tipocampo]+"(event,"+limite+");");
	return resultado;
}
//Inicia zona con sus respectivos limites
function nuevosLimites(inicialcolumna,inicialfila,limitecolumna,limitefila,tipocambio,conlimite){
	vectorlimite[0][contadorlimite]=inicialcolumna*1;
	vectorlimite[1][contadorlimite]=inicialfila*1;
	vectorlimite[2][contadorlimite]=limitecolumna*1;
	vectorlimite[3][contadorlimite]=limitefila*1;
	vectorlimite[4][contadorlimite]=tipocambio*1;
	contadorlimite=conlimite;
	tipocampo=tipocambio;
	//alert(inicialcolumna+","+inicialfila+","+limitecolumna+","+limitefila+","+tipocambio);
	initGridAjax();	

}
//Inicia nombre de archivo a enviar datos
function archivo(nombrearchivo){
	archivo=nombrearchivo;
	}
//Ejecuta cadena get y la envia a un archivo de forma asincrona
function submitajax(cadenaget) {
/*	//alert("antes del request");
	var opciones = 
	{
		// función a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		//datos = eval(t.responseText);
		//procesar(datos);
		}
	}
	new Ajax.Request(cadenaget, opciones);
	//alert("despues del request");*/
	
		// only continue if xmlHttp isn't void
	if (xmlHttp)
	{
		// try to connect to the server
		try
		{
			//initiate the asynchronous HTTP request
			//alert(cadenaget);
			xmlHttp2.open("GET", cadenaget, true);
			xmlHttp2.onreadystatechange = handleRequestStateChange2;
			xmlHttp2.send(null);
		}
		// display the error in case of failure
		catch (e)
		{
			alert("Can't connect to server:\n" + e.toString());
		}
	}

}
//Retorna el nombre de la columna de una celda i,j
function retornanombrecolumna(i,j){
nombrecolumna=nombrescolumnas[j];
return nombrecolumna;
}
//Retorna el valor de la celda i,j
function retornavalorcolumna(i,j){
	//alert(" indice_i="+i+" indice_j="+j);
	var valorcolumna=document.getElementById("f_"+i+"_"+j).innerHTML;
return valorcolumna;	
}
//Retorna el numero de la zona a la que pertenece la celda i,j
function retornanumerozona(i,j){
	for(i=0;i<=contadorlimite;i++)
		if(indice_i>=vectorlimite[1][i]&&indice_i<=vectorlimite[3][i])
			if(indice_j>=vectorlimite[0][i]&&indice_j<=vectorlimite[2][i])
				numerozona=i;
return numerozona;
}
//retorna la cadena get que corresponde a la columna y zona 
function retornacadenaget(numerozona,i){
var cadena="";
//alert(numerozona);

for(k=0;k<columnasparametro[numerozona].length;k++){
tmpcolum=retornanombrecolumna(i,columnasparametro[numerozona][k]);
tmpvalor=retornavalorcolumna(i,columnasparametro[numerozona][k]);
cadena += "&"+tmpcolum+"="+tmpvalor;
//alert("zona="+numerozona+" k="+k+" columnasparametro="+columnasparametro[numerozona][k]);
}
return cadena;
}
//Envia los datos correspondientes de get tanto de fila como generales 
function enviardatos(i,j,parametroingreso){


numerozona=retornanumerozona(i,j);

cadena=retornacadenaget(numerozona,i);

nombrecolumna=retornanombrecolumna(i,j);
valorcolumna=retornavalorcolumna(i,j);


if(parametroingreso!="")
valorcolumna=parametroingreso;
valorcolumna=tmpCeldaInnerHTML;
cadenaget=""+archivo+"?TMP"+nombrecolumna+"="+valorcolumna+cadena+parametrosadicionales[numerozona];
//alert(cadenaget);
submitajax(cadenaget);
}
//Funcion para activar tipo de cambio campo de texto en celda 
function celdaCampo(event,limiteceldas){
	//alert("anulaCelda="+anulaCelda);
if(editaCelda==true){
columnas		=vectorlimite[0][limiteceldas];
filas			=vectorlimite[1][limiteceldas];
limitecolumna	=vectorlimite[2][limiteceldas];
limitefila		=vectorlimite[3][limiteceldas];
		key=null;
		//if(window.event)
			//key=window.event.keyCode;
		//if (event)
			//key = event.keyCode;
			//alert(key);
			//return false;
		
		key=charkeycodedown;
		//alert(key);
			//if(key==189)
		//tmpCeldaInnerHTML=objetocelda.innerHTML;
		//tmpObjetoCelda=objetocelda;
		//alert(indice_i)
		char=capLock(event);

		if(key!=0&&key!=null)
		{
			//if(key==189)
			//char="-";
			//else
			//char=String.fromCharCode(key);
			
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
			//char=capLock(event);
			//char=capLock(event);
			objetocelda.innerHTML+=char;
			break;
			}
		flecha++;
		}
			//alert(tmp2_indice_i+"="+indice_i);
			//alert(tmp2_indice_j+"="+indice_j);

			if((key<=40)&&(key>=37)){

				//alert(tmp2_indice_j);
				//alert(tmp2_indice_i);
				//alert("indice_i="+tmp2_indice_i+" indice_j="+tmp2_indice_j);
				enviardatos(tmp2_indice_i,tmp2_indice_j,"");
					

//cambioCelda=true;
				if(flecha>0){
					objetocelda.style.background='';
					document.getElementById("f_"+tmp2_indice_i+"_"+tmp2_indice_j).style.background='';
						//eval("f_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".style.background='';");
						
				}
				document.getElementById("f_"+indice_i+"_"+indice_j).style.background='#2684BF';
				//eval("f_"+indice_i+"_"+indice_j+".style.background='2684BF';");
				objetocelda=document.getElementById("f_"+indice_i+"_"+indice_j);
				//eval("objetocelda=f_"+indice_i+"_"+indice_j+";");
				//alert("objetocelda=f_"+indice_i+"_"+indice_j+";");
				flecha=0;
				tmpobjetocelda=objetocelda;
				tmpCeldaInnerHTML=objetocelda.innerHTML;
	
			}
			//anulaCelda=false;
			return false;
			
	}
	else
		return true;
		
}
//Funcion por celda debe utilizarse con un onclick sobre el input checkbox
function celdaCheckbox(obj,parametrostrue,parametrosfalse){
	if(obj.checked){
		//alert(archivo+parametrostrue);
		//submitajax(archivo+parametrostrue);
		enviardatos(indice_i,indice_j,parametrostrue);
		//enviardatos(i,j,parametrostrue);
	}
	else
	{
		//alert(archivo+parametrosfalse);
		//submitajax(archivo+parametrosfalse);
		enviardatos(indice_i,indice_j,parametrostrue);


	}
	
}
//Esta funcion debe ser utilizada por el menu que sea ejecutado
function cambiamenu(){
			var numerozona=retornanumerozona(indice_i,indice_i);
			var nombremenuzona=nombremenu[numerozona];

			x=document.getElementById(nombremenuzona);
			//alert(x);

			seleccionadomenu=x.selectedIndex;
			p =  x.options[x.selectedIndex].value;
    		t =  x.options[x.selectedIndex].text;
			textoseleccionadomenu=""+p;
			codigoseleccionadomenu=p;
			//alert(""+codigoseleccionadomenu+"-"+textoseleccionadomenu);
			estadoclickmenu=true;	
			estadochangemenu=true;
			//alert("Entro a cambiamenu();");
}
//Esta función debe ser añadida al menu que se quiera asignar 
function cambieestadoclickmenu(){
	//alert("Entro a cambieestadoclickmenu()");
	
	estadoclickmenu=true;
	}
//Tipo de cambio celda menu
function celdaMenu(event,limite){
			columnas		=vectorlimite[0][limite];
			filas			=vectorlimite[1][limite];
			limitecolumna	=vectorlimite[2][limite];
			limitefila		=vectorlimite[3][limite];
			var x;
			numerozona=retornanumerozona(indice_i,indice_i);
			nombremenuzona=nombremenu[numerozona];
			//alert("menu="+nombremenuzona);
			if(estadoclickmenu==false){

					
					if(tmpobjetoceldamenu!=null){
						tmpobjetoceldamenu.innerHTML=tmpinnerhtml;
						tmpobjetoceldamenu.bgColor='';
					}
					tmpinnerhtml=objetocelda.innerHTML;
					objetocelda.innerHTML=menu[numerozona];
					//alert(nombremenuzona);
					x=document.getElementById(nombremenuzona);
					x.selectedIndex=seleccionadomenu;
					
					//if(x!=null){document.getElementById(nombremenuzona).focus();};
					tmpobjetoceldamenu=objetocelda;

					//tmpobjetocelda=objetocelda;
					//if(tmptextoseleccionadomenu!=null)
					//textoseleccionadomenu=tmptextoseleccionadomenu;
			}
			if(estadochangemenu==false){
			estadoclickmenu=true;
			}
			else{
			estadoclickmenu=false;
			//estadochangemenu=false;
			}
			estadochangemenu=true;
		key=null;
		if(event)
			key=event.keyCode;
		//else if (event)
			//key = event.which;
		//char=String.fromCharCode(key);
		//alert(key);
		tmp_indice_i_menu=indice_i;
		tmp_indice_j_menu=indice_j;
		//if(key!=null)
		//alert(key);
		if(key==13){
				estadoflecha=true;
				tmp_indice_i=indice_i;
					tmp_indice_i++;
				//if(indice_i>=vectorlimite[1][i]&&indice_i<=vectorlimite[3][i])
				if(tmp_indice_i>=limitefila)
					indice_i--;
					else
					if(tmp_indice_i<=limitefila&&tmp_indice_i>=filas)
						indice_i++;
				textoseleccionadomenu =  x.options[x.selectedIndex].text;
				valorseleccionadomenu =  x.options[x.selectedIndex].value;
				
				//form1."+nombremenuzona+"[form1."+nombremenuzona+".selectedIndex].text;;
				//eval("valorseleccionadomenu = form1."+nombremenuzona+"[form1."+nombremenuzona+".selectedIndex].value;");
				tmpobjetoceldamenu.innerHTML=textoseleccionadomenu;
				tmpobjetoceldamenu.bgColor='';
				enviardatos(tmp_indice_i_menu,tmp_indice_j_menu,valorseleccionadomenu);
				if(tmp_indice_i<=limitefila){
				eval("objetocelda=f_"+indice_i+"_"+indice_j+";");
				tmpinnerhtml=objetocelda.innerHTML;
				objetocelda.innerHTML=menu[numerozona];
				eval("form1."+nombremenuzona+".selectedIndex=seleccionadomenu;");
				eval("if(form1."+nombremenuzona+"!=null){form1."+nombremenuzona+".focus()}");
				objetocelda.bgColor='2684BF';
				tmpobjetoceldamenu=objetocelda;
				}
		}
		
		return false;
		
}
