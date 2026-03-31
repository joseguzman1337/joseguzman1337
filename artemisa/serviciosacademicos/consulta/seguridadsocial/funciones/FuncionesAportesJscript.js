// JavaScript Document

 var indice_i;
var indice_j;
var textocelda;
var i=0;
var j=0;
var objetocelda;
var idempresa;
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

function enviardatos(codigoempresa,idempresasalud) {
	var opciones = {
		// función a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		datos = eval(t.responseText);
		procesar(datos);
		}
	}

	new Ajax.Request("modificarcodigosepsarp.php?codigoempresasalud="+codigoempresa+"&idempresasalud="+idempresasalud+"&Enviar=1", opciones);
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


function getCellInfo(oObject,columnas,filas,limitecolumna,limitefila)
{
  	if ( oObject == null )
      	   return;

   	var objCell = document.elementFromPoint( window.event.x, window.event.y );

       if ( objCell.tagName != "TD" )
	   return;
	  
	if(j>0){  
	objetocelda.style.background='';
	enviardatos(objetocelda.innerHTML,idempresa);
	//alert("idempresa="+idempresa);
	}
	j++;
	
		
  	intCellIndex = objCell.cellIndex;
   	intRowIndex = objCell.parentElement.rowIndex;
	//text1.value = intRowIndex + ", " + intCellIndex;
	//text2.value = objCell.innerHTML;
	//objetocelda=objCell;
	indice_i = intRowIndex-1;
	indice_j = intCellIndex+1;
	if(indice_j<=columnas&&indice_j>=limitecolumna)
			if(indice_i<=filas&&indice_i>=limitefila){
				eval("objetocelda=celda_"+indice_i+"_"+indice_j+";");
				objetocelda.style.background='2684BF';
			}




//alert("i="+indice_i+"j="+indice_j);
	
	//textocelda = objCell.innerHTML;

 }
function cambietexto(event,columnas,filas,limitecolumna,limitefila){


		var char;
		char=window.event.keychar;
		var cadena="<select name='select'><option value='1'>Opcion1</option><option value='2'>Opcion2</option><option value='3'>Opcion3</option></select>";
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
		if((key<=40)&&(key>=37)){

			eval("idempresa=celda_"+tmp2_indice_i+"_"+(tmp2_indice_j+1)+".innerHTML;")
			if(i>0){
			objetocelda.style.background='';
			//objetocelda.innerHTML="";
			

			//objetocelda.focus()=false;
			//if(IsNumeric(objetocelda.innerHTML)){
			enviardatos(objetocelda.innerHTML,idempresa);
			eval("celda_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".style.background='';")
			//}
			//else{
			//alert("Valor no numerico "+objetocelda.innerHTML);
			//eval("celda_"+tmp2_indice_i+"_"+(tmp2_indice_j)+".style.background='#993333';")
			//objetocelda.style.background="#993333";

			//objetocelda.innerHTML="";
			//}
			
			//procesar(datos);
			}
			
			
			eval("celda_"+indice_i+"_"+indice_j+".style.background='2684BF';")
			
			eval("objetocelda=celda_"+indice_i+"_"+indice_j+";");
			
			//return true;
			i=0;
		}
		//text1.value=objetocelda.innerHTML;
		
		return false;
		
}


