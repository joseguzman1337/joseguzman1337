//  Vamos a presuponer que el usuario es una persona inteligente...
var isIE = false;
//  Creamos una variable para el objeto XMLHttpRequest
var req;
//  Creamos una funcion para cargar los datos en nuestro objeto.
//  Logicamente, antes tenemos que crear el objeto.
//  Vease que la sintaxis varia dependiendo de si usamos un navegador decente
//  o Internet Explorer
function nuevoAjax(){ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e){
		try{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E){
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}

function nuevoAjax_2()
{ 

	 /*Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}
function cargaXML(url) {
    //  Primero vamos a ver si la URL es una URL :)
    if(url==''){
        return;
    }
    //  Usuario inteligente...
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processReqChange;
        req.open("GET", url, true);
        req.send(null);
    //  ...y usuario de Internet Explorer Windows
    } else if (window.ActiveXObject) {
        isIE = true;
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processReqChange;
            req.open("GET", url, true);
            req.send();
        }
    }
}
//open('GET','index.html',TRUE,'','');


function processReqChange(){
    //    Referencia a nuestro DIV con ID unica:
    var detalles = document.getElementById("detalles");
    //    Si se ha completado la carga de datos, los mostramos en el DIV...
    if(req.readyState == 4){
        detalles.innerHTML = req.responseText;
    } else {
        //    ...en caso contrario, le diremos al usuario que los estamos cargando:
        detalles.innerHTML = '<div align="center"><img src="images/load_ajax.gif"><br><span style="font-family:Verdana, Arial, Helvetica, sans-serif">JVMCompany</span></div> ';
    }
}


/**********************************************************************************************/
/**********************************************************************************************/
/**********************************************************************************************/
/**********************************************************************************************/
/*******************************OTRA FUNCION****************************************************/

var isIE_2 = false;
//  Creamos una variable para el objeto XMLHttpRequest
var req_2;
//  Creamos una funcion para cargar los datos en nuestro objeto.
//  Logicamente, antes tenemos que crear el objeto.
//  Vease que la sintaxis varia dependiendo de si usamos un navegador decente
//  o Internet Explorer
function cargaXML_2(url) {
    //  Primero vamos a ver si la URL es una URL :)
    if(url==''){
        return;
    }
    //  Usuario inteligente...
    if (window.XMLHttpRequest) {
        req_2 = new XMLHttpRequest();
        req_2.onreadystatechange = processReqChange_2;
        req_2.open("GET", url, true);
        req_2.send(null);
    //  ...y usuario de Internet Explorer Windows
    } else if (window.ActiveXObject) {
        isIE_2 = true;
        req_2 = new ActiveXObject("Microsoft.XMLHTTP");
        if (req_2) {
            req_2.onreadystatechange = processReqChange_2;
            req_2.open("GET", url, true);
            req_2.send();
        }
    }
}
//open('GET','index.html',TRUE,'','');


function processReqChange_2(){
    //    Referencia a nuestro DIV con ID unica:
    var detalles_2 = document.getElementById("detalles_2");
    //    Si se ha completado la carga de datos, los mostramos en el DIV...
    if(req_2.readyState == 4){
        detalles_2.innerHTML = req_2.responseText;
    } else {
        //    ...en caso contrario, le diremos al usuario que los estamos cargando:
        detalles_2.innerHTML = '<div align="center"><img src="images/load_ajax.gif"><br><span style="font-family:Verdana, Arial, Helvetica, sans-serif">JVMCompany</span></div> ';
    }
}

/******************************************************************/

function ajaxpage_2(url, containerid,containerid_2){
var page_request = false
if (window.XMLHttpRequest) // if Mozilla, Safari etc
page_request = new XMLHttpRequest()
else if (window.ActiveXObject){ // if IE

try {
page_request = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){
try{
page_request = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false
var capaContenedora = document.getElementById(containerid_2);

//funcion para el efecto onreanchange


page_request.onreadystatechange=function(){
			if(page_request.readyState == 4){	
				capaContenedora.innerHTML = '';
				ArboLoadpage_2(page_request, containerid);
				}else
					{
							capaContenedora.innerHTML = '<img src="images_design/3.gif" border=0 height=12 width=12 >';	
							//capaContenedora.innerHTML = '<div id="carga_sobre"></div><img src="class/images/load_min.gif" border=0 height=10 width=10 >';	
					}
}



page_request.open('GET', url, true)
page_request.send(null)
}

//NUEVA FUNCION DE AJAX DONNDE EN EL ULTIMO CAMPO SE LE COLOCA LA IMAGEN DE PRECARGA
function ajaxpage_3(url, containerid,containerid_2,containerid_3){
	//alert('asd as dk');
var page_request = false
if (window.XMLHttpRequest) // if Mozilla, Safari etc
page_request = new XMLHttpRequest()
else if (window.ActiveXObject){ // if IE
try {
page_request = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){
try{
page_request = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false
var capaContenedora = document.getElementById(containerid_2);
//var containerid_3 = document.getElementById(containerid_3);
//funcion para el efecto onreanchange


page_request.onreadystatechange=function(){
			if(page_request.readyState == 4){	
				capaContenedora.innerHTML = '';
				ArboLoadpage_2(page_request, containerid);
				}else
					{
							capaContenedora.innerHTML = containerid_3;	
							//capaContenedora.innerHTML = '<img src="class/images/load_min.gif" border=0 height=10 width=10 >';	
							//capaContenedora.innerHTML = '<div id="carga_sobre"></div>';	
					}
}



page_request.open('POST', url, true)
page_request.send(null)
}



function ArboLoadpage_2(page_request, containerid){
if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
document.getElementById(containerid).innerHTML=page_request.responseText;
//containerid.innerHTML="SoLoska.net Cargando.............";
}







//FUNCION PARA VENTANA EMERGENTES

function WinEmergente(URL,ANCHO,ALTO) {
day = new Date();
id = day.getTime();
	if(!ANCHO)ANCHO='1000';
	if(!ALTO)ALTO='600';
	
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=1,scrollbars=1,location=1,statusbar=0,menubar=1,resizable=0,width="+ANCHO+",height="+ALTO+",left = 140,top = 162');");
}
											//FUNCION PARA VENTANA EMERGENTES
											//FUNCION PARA VENTANA EMERGENTES
											//FUNCION PARA VENTANA EMERGENTES
											//FUNCION PARA VENTANA EMERGENTES
											//FUNCION PARA VENTANA EMERGENTES
											//FUNCION PARA VENTANA EMERGENTES
											//FUNCION PARA VENTANA EMERGENTES
											//FUNCION PARA VENTANA EMERGENTES

function  popUp_3(URL,ANCHO,ALTO,LEFT) {
day = new Date();
id = day.getTime();
	if(!ANCHO)ANCHO='1000';
	if(!ALTO)ALTO='600';
	if(!LEFT)LEFT='140';
	
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=1,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width="+ANCHO+",height="+ALTO+",left = "+LEFT+",top = 162');");
}
		//->FUNCION PARA SELECCIONAR EL TEXTO DENTRO DE UN ACAMPO
		//->FUNCION PARA SELECCIONAR EL TEXTO DENTRO DE UN ACAMPO
		//->FUNCION PARA SELECCIONAR EL TEXTO DENTRO DE UN ACAMPO
		//->FUNCION PARA SELECCIONAR EL TEXTO DENTRO DE UN ACAMPO
		//->FUNCION PARA SELECCIONAR EL TEXTO DENTRO DE UN ACAMPO
function SelectTextCampo(ID)
{
	document.getElementById(ID).focus(); 
	document.getElementById(ID).select();
	//document.getElementById(NEWFOLDERC).focus(); 
	//document.getElementById(NEWFOLDERC).select();

}
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
								/////////////////ing luis SANCHEZ CREADAS DEL 19 DE MAYO DE 2009
function DivVentana(id_menu,action){
var my_menu = document.getElementById(id_menu);
		
		if(action=='cerrar'){
			if(my_menu.style.display=="none"){return false;}
		  DesvanecerTOTAL(id_menu,'10');//->PARA DESVANECER
		 // my_menu.style.display="none";
		  return false;
			}
if(my_menu.style.display=="none" || my_menu.style.display==""){
	AumentarTOTAL(id_menu,'9');
	return false;
	//my_menu.style.display="block";
	} else { 
	DesvanecerTOTAL(id_menu,'1');//->PARA DESVANECER
	//my_menu.style.display="none";
	}
 
}
function DesvanecerTOTAL(ID,OPCM){
	var PO=parseInt(OPCM);
	if(PO>0){
	  PO=PO-1;	if(OPCM=='10'){var PIX='1';}else{var PIX='0.'+OPCM;}
			document.getElementById(ID).style.opacity=PIX;
			setTimeout("DesvanecerTOTAL('"+ID+"',"+PO+")",40);
 			}else{
					document.getElementById(ID).style.opacity='1';//LE QUITO ALGUNA CLASE SI LA TIENE
					document.getElementById(ID).style.display="none";
				}
 }
function AumentarTOTAL(ID,OPCM){
	var PO=parseInt(OPCM);
	if(PO<10){
	  PO=PO+1;	if(OPCM=='10'){var PIX='1';}else{var PIX='0.'+OPCM;if(OPCM==1){document.getElementById(ID).style.display="block";}}
			document.getElementById(ID).style.opacity=PIX;
			setTimeout("AumentarTOTAL('"+ID+"',"+PO+")",40);
			return false;
 			}else{
					document.getElementById(ID).style.opacity='10';//LE QUITO ALGUNA CLASE SI LA TIENE
					document.getElementById(ID).style.display="block";
				}
 }
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
								/////////////////////////////////7FUNCIONES PARA NUEVAS VENTANAS
function AcBoton(IDFG,typeo){
	
	switch(typeo){
		case 'a':{document.getElementById(IDFG).className='botonpeque_2';}break;
		case 'd':{document.getElementById(IDFG).className='botonpeque';}break;
		
		}
	}
function SOBREENVIARGe(str){
	
	document.getElementById(str).className='MssMenu_3 OPCIONMeSObre_3';
	
}
function SOBREENVIARGe_2(str){	document.getElementById(str).className='MssMenu_3 OPCIONMe_3';	
}
function validarentero(field) {
		var valid = "0123456789";
		var temp;
		for (var i=0; i<field.value.length; i++) {
			temp = "" + field.value.substring(i, i+1);
			if (valid.indexOf(temp) == "-1") {
				field.value=(field.value.substring(0,i)+(field.value.substring(i+1,field.value.length)));
				i--
			}
		}
	}

function validar_entero(idf) {
		var campo	= document.getElementById(idf);
		var valid = "0123456789";
		var temp;
		for (var i=0; i<campo.length; i++) {
			temp = "" + campo.value.substring(i, i+1);
			if (valid.indexOf(temp) == "-1") {
				campo.value=(campo.value.substring(0,i)+(campo.value.substring(i+1,campo.value.length)));
				i--
			}
		}
	}

function validarfloat(field) {
		var valid = "0123456789.";
		var temp;
		for (var i=0; i<field.value.length; i++) {
			temp = "" + field.value.substring(i, i+1);
			if (valid.indexOf(temp) == "-1") {
				field.value=(field.value.substring(0,i)+(field.value.substring(i+1,field.value.length)));
				i--
			}
		}
	}

