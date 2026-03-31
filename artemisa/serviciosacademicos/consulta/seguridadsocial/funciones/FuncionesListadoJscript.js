// JavaScript Document

 var indice_i;
var indice_j;
var textocelda;
var i=0;
var j=0;
var objetocelda;
var idempresa;
var textoseleccionado;
var estadoclick;
var estadoflecha=false;
var seleccionado=0;
var codigoseleccionado;
var idestudiante;
var parametroadicional;
//var estadoclick=false;
//var datos;
function IsNumeric(valor) 
{ 
var log=valor.length; var sw="S"; 
for (x=0; x<log; x++) 
{ v1=valor.substr(x,1); 
v2 = parseInt(v1); 
//Compruebo si es un valor numérico 
if (isNaN(v2)) { sw= "N";} 
} 
if (sw=="S") {return true;} else {return false; } 
} 

function submitajax(cadenaget) {
	var opciones = {
		// función a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		//datos = eval(t.responseText);
		//procesar(datos);
		}
	}

	new Ajax.Request(cadenaget, opciones);
	//alert("Entro para cambiar y hacer el query");
	
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


function getCellInfo(oObject,columnas,filas,limitecolumna,limitefila,parametro)
{
	parametroadicional=parametro;
	//alert("entro");
	//alert(columnas+","+filas+","+limitecolumna+","+limitefila+","+parametro);
  	if ( oObject == null )
      	   return;

   	var objCell = document.elementFromPoint( window.event.x, window.event.y );

       if ( objCell.tagName != "TD" )
	   return;
	  
	  if(estadoclick==true){
	  //tmpestadoclick=estadoclick;
	  estadoclick=false;
	  return;
	  }
	  
	if(j>0&&objetocelda!=null){  
	objetocelda.style.background='';
	//objetocelda.innerHTML=textoseleccionado;			
	objetocelda.innerHTML='';			

//cadenaget="crearingresoaportes.php?idestudiantegeneral="+idestudiante+"&idempresasalud="+codigoseleccionado+parametroadicional;
	//+"&idempresasalud="codigoseleccionado
	//alert(cadenaget);
	//submitajax(cadenaget);
	
	//enviardatos(objetocelda.innerHTML,idempresa);
	//alert("idempresa="+idempresa);
	}
	j++;

		
  	intCellIndex = objCell.cellIndex;
   	intRowIndex = objCell.parentElement.rowIndex;
	//text1.value = intRowIndex + ", " + intCellIndex;
	//text2.value = objCell.innerHTML;
	//objetocelda=objCell;
	indice_i = intRowIndex-2;
	indice_j = intCellIndex+1;
	//alert(indice_j+"<="+columnas+"&&"+indice_j+">="+limitecolumna)
	if(indice_j<=columnas&&indice_j>=limitecolumna)
			if(indice_i<=filas&&indice_i>=limitefila){
				eval("objetocelda=celda_"+indice_i+"_"+indice_j+";");
				//alert("objetocelda=celda_"+indice_i+"_"+indice_j+";");
				eval("idestudiante=idestudiante_"+indice_i+"_"+indice_j+".value;");

				objetocelda.style.background='2684BF';
			objetocelda.innerHTML=menu;
			form1.epsnueva.focus();
			}

	
	if (form1.epsnueva != null ){
	
	//p = form1.epsnueva[form1.epsnueva.selectedIndex].value;
    //t = form1.epsnueva[form1.epsnueva.selectedIndex].text;
	//textoseleccionado=objetocelda.innerHTML;
	form1.epsnueva.options[seleccionado].selected=true
	}
//alert("i="+indice_i+"j="+indice_j);

	//textocelda = objCell.innerHTML;

 }
function enviardatos(){

			seleccionado=form1.epsnueva.selectedIndex;
			p = form1.epsnueva[form1.epsnueva.selectedIndex].value;
    		t = form1.epsnueva[form1.epsnueva.selectedIndex].text;
			textoseleccionado=""+p+"-"+t;
			codigoseleccionado=p;

			//alert(""+p+"-"+t);
			estadoclick=true;		
}
function cambieestadoclick(){
	estadoclick=true;		
}

function cambietexto(event,columnas,filas,limitecolumna,limitefila,parametro){

			parametroadicional=parametro;
			form1.epsnueva.options[seleccionado].selected=true
			p = form1.epsnueva[form1.epsnueva.selectedIndex].value;
    		t = form1.epsnueva[form1.epsnueva.selectedIndex].text;
			textoseleccionado=""+p+"-"+t;
			codigoseleccionado=p;
			

		var char;
		char=window.event.keychar;
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
		i++;

		if(((key<=40)&&(key>=37))||(key==13)){

			//eval("idempresa=celda_"+tmp2_indice_i+"_"+(tmp2_indice_j+1)+".innerHTML;")
			if(i>0){
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
			eval("celda_"+indice_i+"_"+indice_j+".style.background='2684BF';")
			
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


