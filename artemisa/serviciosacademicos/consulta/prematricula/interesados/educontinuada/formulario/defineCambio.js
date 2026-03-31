//Event.observe(window, 'onkeydown', flechas, false);
var menu=new Array();
var nombremenu=new Array();
var conmenu=0;
menu[conmenu]="";
nombremenu[conmenu]="";
conmenu++;
//alert("conmenu="+conmenu);
menu[conmenu]="";
nombremenu[conmenu]="codigoestadomenu"+conmenu;

function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function movieronflecha() {
	var opciones = {
		// función a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		//document.write("datos = "+t.responseText+";");
		eval("datos = "+t.responseText+";");
		procesar(datos);
		}
	}

	new Ajax.Request('datoscargo.php', opciones);
	
//setTimeout(movieronflecha,1000);

}

function procesar(datos) {
	// guardo el div donde voy a escribir los datos en una variable
	//contenedor = document.getElementById("lista"); 
	texto = "";
	//Itero sobre los datos que me pasaron como parámetro
	for (var i=0; i < datos.length; i++) {
		dato = datos[i];
		eval("f_"+i+"_0.innerHTML=dato.idcargo");
		//texto += "Dato "+i+"  -   campo1:"+dato.nombrecarrera+" campo2:"+dato.codigocarrera+"<br>";   
	}
	//Escribo el texto que formé en el div que corresponde
	//contenedor.innerHTML = texto;
}

function masfila(totalcolumna,tabla,final){
//alert(tabla+" final="+final);
  var x=document.getElementById(tabla).insertRow(final+2);
  for(i=0;i<totalcolumna;i++){
  eval("var x"+i+"=x.insertCell("+i+")");
  eval("x"+i+".innerHTML='&nbsp;'");
  eval("x"+i+".id='f_"+(final)+"_"+i+"'");
  } //var z=x.insertCell(1)
 // eval("f_"+(final)+"_"+(totalcolumna-1)+".innerHTML='100'");
}
function nuevazona(totalzona,filademas){
//alert("entro");
//movieronflecha();
//alert("Entro nueva zona="+totalzona+"\n nuevosLimites(1,0,3,"+totalzona+",0);");

if(filademas==true)
masfila(4,'tablagrid',totalzona);
nuevosLimites(1,1,3,totalzona,0,1);

var columnasparametrocambio=new Array();
columnasparametrocambio[0]=1;
columnasparametrocambio[1]=2;
columnasparametrocambio[2]=3;
columnasparametrocambio[3]=4;
parametrosgenerales="";
envioParametros(2,'crearcargo.php',columnasparametrocambio,parametrosgenerales,1);
/*var columnasparametrocambio2=new Array();
nuevosLimites(3,0,3,totalzona,1,2);
columnasparametrocambio2[0]=0;
columnasparametrocambio2[1]=1;
columnasparametrocambio2[2]=2;
//columnasparametrocambio[3]=3;
parametrosgenerales="";
envioParametros(3,'crearcargo.php',columnasparametrocambio2,parametrosgenerales,2);
*/
conmenu++;
//alert("conmenu="+conmenu);
menu[conmenu]="";
nombremenu[conmenu]="codigoestadomenu"+conmenu;

}
//Titulo de columnas en tabla
/*columnas[0]="idcargo";
columnas[1]="nombrecargo";
columnas[2]="prioridadcargo";
columnas[3]="codigoestado";*/
//alert("Entro");
//response2 = xmlHttp.responseXML.documentElement;
//columnas=xmlToArray(response2.getElementsByTagName("data/tablas/tab"));
var yaentro=false;
function asignarCambiosFormulario(){
	
	var columnasparametrocambio2=new Array();
	tmp2columnas=columnas[0];
	if(columnas[0]!="")
	columnas[0]="";
	else
	yaentro=true;
	
	totalcolumnasformulario=columnas.length+1;
	colpar=0;
	var cadenacolumnas="";
	for(i=0;i<columnas.length;i++){
			//if(i!=(columnas.length-1))
				//columnasparametrocambio2[i]=i+1;
			if(i>0&&(yaentro==false)){

//alert(columnasparametrocambio2[colpar]);
			tmpcolumnas=columnas[i];
			columnas[i]=tmp2columnas;
			tmp2columnas=tmpcolumnas;
			colpar++;
		}
		cadenacolumnas = cadenacolumnas+"columna["+i+"]="+columnas[i]+"\n";
	}
	
	if(yaentro==false){
	columnas[i]=tmp2columnas;
	cadenacolumnas = cadenacolumnas+"columna["+i+"]="+columnas[i]+"\n";
	}
	for(i=0;i<(columnas.length-1);i++){
				columnasparametrocambio2[i]=i+1;
				//alert(columnasparametrocambio2[i]);
	}

	//alert(cadenacolumnas);
	if(selectTabla!='Interesados'){
		//alert("selectTabla="+selectTabla);
		asignarcolumnas(columnas);
		//alert("Total por pagina = "+rows_x_page);
		nuevosLimites(1,1,columnas.length,rows_x_page,0,0);
		parametrosgenerales="&action=UPDATE&tabla="+selectTabla;
		envioParametros(3,'grid.php',columnasparametrocambio2,parametrosgenerales,0);
	}
	//setTimeout('asignarCambiosFormulario();',1000);
}
function delayCambiosFormulario(){
	setTimeout('asignarCambiosFormulario();',1000);
}
function ventanaAutoFormulario(tabla){
	//alert("tabla="+tabla);
	if(selectTabla!='Interesados'){
		var pagina='formulario/tabla.php?tabla='+tabla;
		open(pagina,'autoformulario',"width=800,height=450,menubar=yes,scrollbars=yes,resizable=yes");
	}
	else{
		var pagina='interesados.php?tabla='+tabla;
		open(pagina,'autoformulario',"width=800,height=450,menubar=yes,scrollbars=yes,resizable=yes");
	}
	//alert(pagina);
	return false;
}
function modificarFila(id){
	if(selectTabla=="Interesados"){
		var pagina='interesados.php?tabla='+selectTabla+'&idtabla='+id;
		open(pagina,'autoformulario',"width=800,height=450,menubar=yes,scrollbars=yes,resizable=yes");

	}
	else{
		var pagina='formulario/tabla.php?tabla='+selectTabla+'&idtabla='+id;
		open(pagina,'autoformulario',"width=800,height=450,menubar=yes,scrollbars=yes,resizable=yes");
	}
	//alert(pagina);
	return false;

}
/*asignarcolumnas(columnas);
var total=6;
nuevazona(total,false);*/