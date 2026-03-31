<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../sala.css">
<link rel="stylesheet" type="text/css" href="ajaxgrid.css">
<script type="text/javascript" src="../../../pruebas/prototype.js"></script>
<script type="text/javascript" src="../../../pruebas/FuncionesCadenas.js"></script>
<script type="text/javascript" src="../../../pruebas/funcionesGridAjax.js"></script>

<script LANGUAGE="JavaScript">
//Event.observe(window, 'onkeydown', flechas, false);
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
}
function movieronflecha() {
	var opciones = {
		// función a llamar cuando reciba la respuesta
		onSuccess: function(t) {
		eval("datos = "+t.responseText+";");
		procesar(datos);
		}
	}

	new Ajax.Request('datoscargo.php', opciones);
	
<?PHP
if(!isset($_GET['Filtrar']))
echo "setTimeout(movieronflecha,1000);";
?>

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
  eval("f_"+(final)+"_"+(totalcolumna-1)+".innerHTML='100'");
  
}
function nuevazona(totalzona,filademas){
//alert("entro");
<?PHP
if(!isset($_GET['Filtrar']))
echo "movieronflecha();";
?>
//alert("Entro nueva zona="+totalzona+"\n nuevosLimites(1,0,3,"+totalzona+",0);");

if(filademas==true)
masfila(4,'tablamotorv2',totalzona);
nuevosLimites(1,0,3,totalzona,0);
var columnasparametrocambio=new Array();
columnasparametrocambio[0]=0;
columnasparametrocambio[1]=1;
columnasparametrocambio[2]=2;
columnasparametrocambio[3]=3;
parametrosgenerales="";
envioParametros(2,'crearcargo.php',columnasparametrocambio,parametrosgenerales);
}
//Titulo de columnas en tabla
var columnas=new Array();
columnas[0]="idcargo";
columnas[1]="nombrecargo";
columnas[2]="prioridadcargo";
columnas[3]="codigoestado";
asignarcolumnas(columnas);

</script>
<?php
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/motorv2/motor.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}
if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']!=''))
$_SESSION['sesion_codigoestudiante']=$_GET['codigoestudiante'];

$query="select idcargo,nombrecargo,prioridadcargo,codigoestado from cargo 
where codigoestado like '1%'
order by idcargo";

$objetobase=new BaseDeDatosGeneral($sala);

$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{

	//$row_operacion["codigoestado"]="<input name='check_$i' type='checkbox' value='1' checked onclick=celdaCheckbox(this,'?parametrotrue=verdad','?parametrofalse=falso')>";

	$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
while ($row_operacion=$operacion->fetchRow());
$row_operacion[""]="<input name='Nuevo' type='button' onClick='nuevazona((total++),true);' value='Nuevo'>";
$array_interno[]=$row_operacion;
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($array_interno,"Listado Plantilla Votacion");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
if(count($motor->matriz_filtrada)>0)
$total=count($motor->matriz_filtrada)-1;
else
$total=count($motor->matriz)-1;

?>
<script LANGUAGE="JavaScript">
var total=<?php echo $total ?>;
nuevazona(total,false);
</script>
<?php
$motor->asignarJavascripttabla("id='tablamotorv2'");
$motor->agregarllave_drilldown('resumenplantillavotacion','listadoplantillavotacion.php','plantillas.php','','idplantillavotacion',"",'','','','','onclick= "return ventanaprincipal(this)"');

$motor->mostrar();
?>
