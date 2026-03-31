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
var tmpobjetocelda;
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

//Toma el evento onkeydown
function switchKey(obj)
{
	document.onkeydown = (obj!=null) ? register : null;
	//document.onkeypress = (obj!=null) ? register : null;
	//document.onkeyup = (obj!=null) ? register : null;
}
//Se ejecuta cuando hay un evento onkeydown y llama a la funcion del
//tipo de cambio
function register(e)
{
	if (!e) e = window.event;
	resultado=tablaformulario(e);
	return resultado;
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
Event.observe(window, 'load', init, false);
//alert("despues del event");
//Inicia eventos para cada celda en juego
function init(){
	for(k=0;k<contadorlimite;k++){
		for(i=vectorlimite[0][k];i<=vectorlimite[2][k];i++){
			for(j=vectorlimite[1][k];j<=vectorlimite[3][k];j++){
				eval("var idName=\"f_"+j+"_"+i+"\"");
				//alert(idName);
				makeEditable(idName);
				//alert(idName);
			}
			//alert("i="+i);
		}
	}
	//alert(k);
}
//Ejecuta la funcion correspondiente al evento
function makeEditable(id){
	//alert("entro mucharejo 1");
	Event.observe(id, 'click', function(){obtenerCelda($(id))}, false);
	//alert("entro mucharejo");
	//Event.observe(id, 'keydown', function(){prueba()}, false);
	//Event.observe(id, 'mouseover', function(){showAsEditable($(id))}, false);
	//Event.observe(id, 'mouseout', function(){showAsEditable($(id), true)}, false);
}
//Inicia los parametros de columnas a enviar por zona
function envioParametros(columnacambio,archivocambio,columnasparametrocambio,parametrosgenerales){
	//columnasparametrocambio es un array de que puede conteber varios numeros de columna
	archivo=archivocambio;
	columnascambio[zona]=columnacambio;
	columnasparametro[zona]=new Array();
	columnasparametro[zona]=columnasparametrocambio;
	parametrosadicionales[zona]=parametrosgenerales;
	//alert("Columnas="+columnasparametro[zona]+"zona="+zona);
	zona++;
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
	//alert("entro mucharejo");

	switchKey(celda);
	if(puntero>0){  
	tmpobjetocelda.bgColor='';
	
	}
	puntero++;
	flecha=0;
	numeros=celda.id.replace("f_","");
	elementos=celda.id.split("_");
	indice_i=elementos[1];
	indice_j=elementos[2];
	for(i=0;i<contadorlimite;i++){
	if(indice_i>=vectorlimite[1][i]&&indice_i<=vectorlimite[3][i])
			if(indice_j>=vectorlimite[0][i]&&indice_j<=vectorlimite[2][i]){
				objetocelda=celda;
				objetocelda.bgColor='2684BF';
				tipocampo=vectorlimite[4][i];
				limite=i;
				puntero++;
				tmpobjetocelda=objetocelda;
			}
	}
	//estadoclickmenu=false;
//tmpinnerhtml=objetocelda.innerHTML;

registro=tablaformulario(window.event);
tmpobjetocelda=objetocelda;
//alert("Entro mucharejo");	
}
//Ejecuta función correspondiente a la zona
function tablaformulario(event){
	eval("resultado="+funcionCelda[tipocampo]+"(event,"+limite+");");
	//alert("resultado="+funcionCelda[tipocampo]+"(event,"+limite+");");
	return resultado;
}
//Inicia zona con sus respectivos limites
function nuevosLimites(inicialcolumna,inicialfila,limitecolumna,limitefila,tipocambio){
	vectorlimite[0][contadorlimite]=inicialcolumna;
	vectorlimite[1][contadorlimite]=inicialfila;
	vectorlimite[2][contadorlimite]=limitecolumna;
	vectorlimite[3][contadorlimite]=limitefila;
	vectorlimite[4][contadorlimite]=tipocambio;
	contadorlimite++;
	//alert(inicialcolumna+","+inicialfila+","+limitecolumna+","+limitefila+","+tipocambio);
	init();	

}
//Inicia nombre de archivo a enviar datos
function archivo(nombrearchivo){
	archivo=nombrearchivo;
	}
//Ejecuta cadena get y la envia a un archivo de forma asincrona
function submitajax(cadenaget) {
	//alert("antes del request");
	var opciones = 
	{
		// función a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		//datos = eval(t.responseText);
		//procesar(datos);
		}
	}
	new Ajax.Request(cadenaget, opciones);
	//alert("despues del request");
}
//Retorna el nombre de la columna de una celda i,j
function retornanombrecolumna(i,j){
nombrecolumna=nombrescolumnas[j];
return nombrecolumna;
}
//Retorna el valor de la celda i,j
function retornavalorcolumna(i,j){
	eval("valorcolumna=f_"+i+"_"+(j)+".innerHTML;");
return valorcolumna;	
}
//Retorna el numero de la zona a la que pertenece la celda i,j
function retornanumerozona(i,j){
	for(i=0;i<contadorlimite;i++)
		if(indice_i>=vectorlimite[1][i]&&indice_i<=vectorlimite[3][i])
			if(indice_j>=vectorlimite[0][i]&&indice_j<=vectorlimite[2][i])
				numerozona=i;
return numerozona;
}
//retorna la cadena get que corresponde a la columna y zona 
function retornacadenaget(numerozona,i){
var cadena="";
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
valorcolumna=parametroingreso
cadenaget=""+archivo+"?"+nombrecolumna+"="+valorcolumna+cadena+parametrosadicionales[numerozona];
//alert(cadenaget);
submitajax(cadenaget);
}
//Funcion para activar tipo de cambio campo de texto en celda 
function celdaCampo(event,limiteceldas){

columnas		=vectorlimite[0][limiteceldas];
filas			=vectorlimite[1][limiteceldas];
limitecolumna	=vectorlimite[2][limiteceldas];
limitefila		=vectorlimite[3][limiteceldas];
		key=null;
		//if(window.event)
			//key=window.event.keyCode;
		if (event)
			key = event.keyCode;
			
			//alert(key);
		if(key!=0&&key!=null)
		{
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
		}
			
			if((key<=40)&&(key>=37)){
				enviardatos(tmp2_indice_i,tmp2_indice_j,"");
				if(flecha>0){
					objetocelda.bgColor='';
						eval("f_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".bgColor='';");
						
				}
				eval("f_"+indice_i+"_"+indice_j+".bgColor='2684BF';")
				eval("objetocelda=f_"+indice_i+"_"+indice_j+";");
				flecha=0;
				tmpobjetocelda=objetocelda;
	
			}
	
		return false;
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
			//alert(x.selectedIndex);

			seleccionadomenu=x.selectedIndex;
			p =  x.options[x.selectedIndex].value;
    		t =  x.options[x.selectedIndex].text;
			textoseleccionadomenu=""+p;
			codigoseleccionadomenu=p;
			//alert(""+codigoseleccionadomenu+"-"+textoseleccionadomenu);
			estadoclickmenu=true;	
			estadochangemenu=true;
			//alert("Entro a cambiamenu();="+nombremenuzona);

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
			//alert("estadoclickmenu="+estadoclickmenu);
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
		//alert("Entro hasta el final");
		return false;
		
}
