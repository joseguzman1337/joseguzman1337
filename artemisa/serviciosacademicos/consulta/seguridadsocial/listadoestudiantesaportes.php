<?php
session_start();
?>
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
</script>
<script type="text/javascript" src="../../funciones/sala_genericas/ajax/prototype.js"></script>
<script type="text/javascript" src="../../funciones/sala_genericas/funcionesGridAjax.js"></script>
<!--<script type="text/javascript" src="../../funciones/sala_genericas/FuncionesCadenas.js"></script>
<script type="text/javascript" src="funciones/FuncionesListadoJscript.js"></script>-->
<!--<script type="text/javascript" src="../../../pruebas/FuncionesCadenas.js"></script>
<script type="text/javascript" src="../../../pruebas/funcionesGridAjax.js"></script>-->
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>

<?php
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/motorv2/motor.php");
//require_once("../../funciones/clases/motor/motor.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/FuncionesMatriz.php");
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
//require_once("../../funciones/sala_genericas/FuncionesMatriz.php");
//require_once("../../funciones/clases/motor/motor.php");
require_once("funciones/FuncionesAportes.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/DatosGenerales.php");

function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}
if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']!=''))
$_SESSION['sesion_codigoestudiante']=$_GET['codigoestudiante'];
$datos_bd=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','get','','true');
?>
<script LANGUAGE="JavaScript">

//var menu=new Array();
//var nombremenu=new Array();
var menu=new Array();
var nombremenu=new Array();


menu[0]="<?php	
			$condicion="em.codigotipoempresasalud = t.codigotipoempresasalud and (t.nombretipoempresasalud like 'EPS%' or t.nombretipoempresasalud like 'No%')
						order by t.nombretipoempresasalud desc, em.nombreempresasalud ";
			$formulario->filatmp=$datos_bd->recuperar_datos_tabla_fila("empresasalud em, tipoempresasalud t","em.idempresasalud","em.nombreempresasalud",$condicion);
			$campo='menu_fila'; $parametros="'epsnueva','".$epsnueva."',' onChange=\"enviardatos();\"'";
			$formulario->menu_fila('epsnueva',$epsnueva,'id=\"epsnueva\" onChange=\"cambiamenu();\" onClick=cambieestadoclickmenu();');

			?>";
nombremenu[0]="epsnueva";

function regresarGET()
{
	document.location.href="<?php echo 'menuinicialaportes.php';?>";
}
function reCarga(){
	document.location.href="<?php echo 'menuinicialaportes.php';?>";
}

</script>


<?php
//print_r($_SESSION);

echo "<form name=\"form2\" action=\"listadoestudiantesaportes.php?Filtrar=Filtrar\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
 	
	if(isset($_POST['fechacierre'])){
	$_SESSION['sesion_arrayinterno']=NULL;
	$_SESSION['sesion_mescierre']=NULL;
	$_SESSION['sesion_fechacierre']=$_POST['fechacierre'];
	}

	$formulario->dibujar_fila_titulo('ASIGNACION MASIVA DE INGRESO DE COTIZANTE-EPS POSTGRADO','labelresaltado',"2","align='center'");

	$formulario->dibujar_fila_titulo('Datos Generales','labelresaltado');
	$mesinicial["mes"]=(date("m")-1); $mesinicial["anio"]=date("Y");
	$mesfinal["mes"]=date("m");  $mesfinal["anio"]=date("Y");
	//$meshoy=date("m")."/".date("Y");
        $meshoy="01/".date("m")."/".date("Y");
	//$formulario->filatmp=meses_anios($mesinicial,$mesfinal);
/*	$formulario->filatmp=listadomesesproceso($datos_bd,date("d/m/Y"),4,0);
	$formulario->filatmp[""]="Seleccionar";
	if(isset($_POST['mescierre']))
	$meshoy=$_POST['mescierre'];
	$campo='menu_fila'; $parametros="'mescierre','".$meshoy."',''";
	$formulario->dibujar_campo($campo,$parametros,"Mes de cierre","tdtitulogris",'mescierre','');*/
        	if(isset($_POST['fechacierre']))
	$meshoy=$_POST['fechacierre'];

        	$campo="campo_fecha"; $parametros="'text','fechacierre','".$meshoy."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
	$formulario->dibujar_campo($campo,$parametros,"Fecha de novedad","tdtitulogris",'fechacierre','requerido');

        
	$formulario->filatmp=$datos_bd->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo");
	$codigoperiodo=$_SESSION['codigoperiodosesion'];
	if(isset($_SESSION['sesion_codigoperiodo']))
	$codigoperiodo=$_SESSION['sesion_codigoperiodo'];
	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');
	
	unset($formulario->filatmp);
	$formulario->filatmp=$datos_bd->recuperar_datos_tabla_fila("modalidadacademica","codigomodalidadacademica","nombremodalidadacademica");
	$formulario->filatmp[""]="Seleccionar";
	if(!isset($_POST['codigomodalidadacademica']))
	$codigomodalidadacademica=300;
	else
	$codigomodalidadacademica=$_POST['codigomodalidadacademica'];
	$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$codigomodalidadacademica."','onChange=\"\"enviarmenu(\'codigomodalidadacademica\');\"'";
	$formulario->dibujar_campo($campo,$parametros,"Modalidad","tdtitulogris",'codigomodalidadacademica','');

	//$parametros="'checkbox','pagoeps','1','$checked'";
	unset($formulario->filatmp);
	$formulario->filatmp["1"]="Si";$formulario->filatmp["2"]="No";$formulario->filatmp["0"]="NA";
 	$defecto="NA";
	if($_POST['pagoeps']) $pagoeps=$_POST['pagoeps']; else $pagoeps=$defecto;
	$parametros="'pagoeps','".$pagoeps."',''";
	$campo='menu_fila';
	$formulario->dibujar_campo($campo,$parametros,"Pago de EPS","tdtitulogris",'pagoeps');
	
	unset($formulario->filatmp);
	$formulario->filatmp["1"]="Si";$formulario->filatmp["2"]="No";$formulario->filatmp["0"]="NA";
 	$defecto="NA";
	if($_POST['pagoarp']) $pagoarp=$_POST['pagoarp']; else $pagoarp=$defecto;
	$parametros="'pagoarp','".$pagoarp."',''";
	$campo='menu_fila';
	$formulario->dibujar_campo($campo,$parametros,"Pago de ARP","tdtitulogris",'pagoarp');

	unset($formulario->filatmp);
	$formulario->filatmp["1"]="Normal";$formulario->filatmp["2"]="Extemporaneo";
 	$defecto="NA";
	if($_POST['ingresado']) $ingresado=$_POST['ingresado']; else $ingresado=$defecto;
	$parametros="'ingresado','".$ingresado."',''";
	$campo='menu_fila';
	$formulario->dibujar_campo($campo,$parametros,"Tipo de Ingreso","tdtitulogris",'ingresado');

	
	/*if($_POST['ingresado']) $checked="checked"; else $checked="";
	$parametros="'checkbox','ingresado','1','$checked'";
	$campo='boton_tipo';
	$formulario->dibujar_campo($campo,$parametros,"Solo Ingresados","tdtitulogris",'ingresado');
*/

	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Informe','Informe',''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	//ventana_emergente_submit('archivoplano.php','archivoplano','Archivo Plano','600','400','form2')
	
	//$parametrobotonenviar[$conboton]="'archivoplano.php','archivoplano','Archivo Plano','600','400','form2','yes'";
	//$boton[$conboton]='ventana_emergente_submit';
	//$conboton++;
	$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
	$boton[$conboton]='boton_tipo';

	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
	
	//$formulario->boton_tipo('hidden','codigoperiodosesion',$_POST['codigoperiodo']);

echo "</table>
</form>";

	if($_POST['ingresado']==3){
	$filtroarp=6;
	$archivoarp="crearretiroaportes.php";
	}
	else{
	$filtroarp=5;
	$archivoarp="crearingresoaportes.php";
	}
//echo "<table>";
//echo "</table>";

if(isset($_POST['codigoperiodo']))
$_SESSION['sesion_codigoperiodo']=$_POST['codigoperiodo'];

if(isset($_REQUEST['Informe'])||isset($_REQUEST['Exportar'])||isset($_REQUEST['Filtrar'])){
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);

/*$adjunto=adjuntoquery($_POST['pagoeps'],$_POST['pagoarp'],$_POST['codigoperiodo']);
$query="SELECT distinct 
e.idestudiantegeneral,
e.codigoestudiante ,
d.nombrecortodocumento Tipo,
eg.numerodocumento,
eg.apellidosestudiantegeneral apellidos,
eg.nombresestudiantegeneral nombres,
c.nombrecortocarrera,
c.codigocarrera
FROM estudiante e, estudiantegeneral eg, 
carrera c, modalidadacademica ma, documento d,  ordenpago op 
WHERE e.idestudiantegeneral=eg.idestudiantegeneral
AND e.codigocarrera = c.codigocarrera
AND c.codigomodalidadacademica=ma.codigomodalidadacademica
AND eg.tipodocumento=d.tipodocumento
AND ma.codigomodalidadacademica='$codigomodalidadacademica'
AND e.codigoestudiante=op.codigoestudiante
AND op.codigoperiodo='$codigoperiodo'
AND op.codigoestadoordenpago like '4%'
 ".$adjunto["query"]."
order by apellidosestudiantegeneral,nombresestudiantegeneral
";*/
if(isset($_SESSION['sesion_fechacierre'])&&trim($_SESSION['sesion_fechacierre'])!=''){
echo "Mes de cierre=".$_SESSION['sesion_mescierre'];
$objetobase=new BaseDeDatosGeneral($sala);
$condicion="and es.idestudiantegeneral=eg.idestudiantegeneral
			and eg.tipodocumento=do.tipodocumento";
$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante es, estudiantegeneral eg, documento do","es.codigoestudiante",$_SESSION['sesion_codigoestudiante'],$condicion);

$query=querylistadocierre($_POST['pagoeps'],$_POST['pagoarp'],$_POST['codigoperiodo'],$codigomodalidadacademica,0);
//echo $query;
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
$row_operacion['codigoestudiante']="";
$row_operacion['nombrecarrera']="";
$i=0;
do
{
	$condicion=" and c.codigocarrera=e.codigocarrera
	and eg.idestudiantegeneral=e.idestudiantegeneral
	and td.tipodocumento=eg.tipodocumento
	group by e.idestudiantegeneral";
	$datos_estudiante=$datos_bd->recuperar_datos_tabla("documento td,estudiantegeneral eg,estudiante e, carreracentrotrabajoarp c","e.idestudiantegeneral",$row_operacion['idestudiantegeneral'],$condicion,', max(codigoestudiante) numeroestudiante');


	//if($row_operacion['codigoempresasalud']=='')
	//$espacio="0";
	//$row_temp['idestudiantegeneral']="<div id='idestudiante_".$i."_7' >".$row_operacion['idestudiantegeneral']."$espacio</div>";
	$row_temp['codigoempresasalud']="<div id='celda_".$i."_6' >".$row_operacion['codigoempresasalud']."$espacio</div>";

	$row_operacion['codigoestudiante']=$datos_estudiante['codigoestudiante'];
	$row_operacion['numerodocumento']=$datos_estudiante['numerodocumento'];
	$row_operacion['Tipo']=$datos_estudiante['nombrecortodocumento'];

if(!isset($datos_estudiante['numerodocumento'])||trim($datos_estudiante['numerodocumento'])==''){

$condicion=" and c.codigocarrera=e.codigocarrera";
	$datosestudiantecarrera=$datos_bd->recuperar_datos_tabla("estudiante e,carrera c","e.idestudiantegeneral",$row_operacion['idestudiantegeneral'],$condicion,', max(codigoestudiante) numeroestudiante',0);
$row_operacion['nombrecarrera']=$datosestudiantecarrera['nombrecarrera'];
}

	if(!validar_estudiante_arp($mescierre,$row_operacion['codigoestudiante'],$datos_bd,$_POST['pagoeps'],$_POST['pagoarp'],3)){
	
		
		if(!($datosnovedad=eps_mes($_SESSION['sesion_mescierre'],$row_operacion['idestudiantegeneral'],$objetobase))){
			$row_temp2['Numero']=$i+1;
			$row_operacion=InsertarColumnaFila($row_operacion,$row_temp2,0);

			$nombreeps=$datosnovedad['nombreempresasalud']."";
		
			//$row_temp['Empresasalud']="";
			$formulario->boton_tipo('hidden',"idestudiante_".$i."_6",$row_operacion['idestudiantegeneral']);
		
			//$row_operacion=QuitarColumnaFila($row_operacion,0);
			//$row_operacion=QuitarColumnaFila($row_operacion,1);
			//$row_operacion=QuitarColumnaFila($row_operacion,2);
			//$row_operacion=QuitarColumnaFila($row_operacion,1);
			$row_operacion=QuitarColumnaFila($row_operacion,0);

			//$row_operacion=QuitarColumnaFila($row_operacion,3);
			$row_operacion=InsertarColumnaFila($row_operacion,$row_temp,4);
			$array_interno[]=$row_operacion;
			$i++;
		}

	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
}
while ($row_operacion=$operacion->fetchRow());




//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//echo "<table width='200' border='1'  onKeyDown='return cambietexto(event);'>";
if(!isset($_SESSION['sesion_arrayinterno'])){
$_SESSION['sesion_arrayinterno']=$array_interno;
}

$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));

$motor = new matriz($_SESSION['sesion_arrayinterno'],"Listado de Ingresos de Estudiantes en el mes ".$_SESSION['sesion_mescierre'],$_SERVER['PHP_SELF']."?total=".$total,"si","si",$_SERVER['PHP_SELF']."?total=".$total,"",false,"","../../");

if(count($motor->matriz_filtrada)>0)
$total=count($motor->matriz_filtrada);
else
$total=count($motor->matriz);

//print_r($motor->matriz_filtrada);
//echo "<br>".$total;
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
if($_POST['ingresado']==1)
$tipoingreso="ING";
else
$tipoingreso="INX";

$parametrogeneral="&fechainicio=".$_POST['fechacierre']."&ingresado=".$_POST['ingresado']."&tipoingreso=".$tipoingreso;

?>
<script LANGUAGE="JavaScript">

//var menu=new Array();
//var nombremenu=new Array();
//Titulo de columnas en tabla

var columnas=new Array();
//columnas[0]="No";
columnas[0]="idestudiantegeneral";
columnas[1]="codigoestudiante";
columnas[2]="tipo";
columnas[3]="numerodocumento";
columnas[4]="idempresasalud";

asignarcolumnas(columnas);

//ZONA0
var columnasparametrocambio=new Array();
nuevosLimites(4,0,4,<?php echo $total ?>,1);
//alert("nuevosLimites(0,0,2,30,0)");
columnasparametrocambio[0]=0;
//columnasparametrocambio[1]=2;
//columnasparametrocambio[2]=3;
parametrosgenerales="<?php echo $parametrogeneral ?>";
//alert("Va a entrar parametros");
envioParametros(2,'<?php echo $archivoarp ?>',columnasparametrocambio,parametrosgenerales);
//alert("Entro parametros");
</script>
<?php
$motor->asignarJavascripttabla("onclick='getCellInfo(this,6,".($i-1).",6,0,\"$parametrogeneral\")' onKeyDown='return cambietexto(event,6,".($i-1).",6,0,\"$parametrogeneral\")'");
//$motor->agregarllave_drilldown('codigoestudiante','listadoestudiantesaportes.php','ingresoaportes.php','','codigoestudiante',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('numerodocumento','listadoestudiantesaportes.php','ingresoaportes.php','','codigoestudiante',"",'','','','','onclick= "return ventanaprincipal(this)"');

$motor->mostrar();
}
}

?>
</table>