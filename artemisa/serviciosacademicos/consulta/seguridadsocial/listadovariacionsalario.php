<?php
session_start();
?>

<link rel="stylesheet" type="text/css" href="../../sala.css">
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
}
</script>
<script type="text/javascript" src="funciones/FuncionesVariacionSalarioJscript.js"></script>
<script src="../../funciones/sala_genericas/ajax/javascripts/prototype.js" type="text/javascript"></script>


<?php
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/motor/motor.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("funciones/FuncionesAportes.php");

function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}

if(isset($_POST['mescierre'])){
$_SESSION['sesion_arrayinterno']=NULL;
$_SESSION['sesion_mescierre']=$_POST['mescierre'];
}
if(isset($_POST['codigoperiodo']))
$_SESSION['sesion_codigoperiodo']=$_POST['codigoperiodo'];

$datos_bd=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','get','','true');

echo "<form name=\"form2\" action=\"listadovariacionsalario.php?Filtrar=Filtrar\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
 	$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");

	$formulario->dibujar_fila_titulo('Datos Generales','labelresaltado');
	$mesinicial["mes"]=date("m"); $mesinicial["anio"]=date("Y");
	$mesfinal["mes"]="12";  $mesfinal["anio"]="2035";
	$meshoy=date("m")."/".date("Y");
	$formulario->filatmp=listadomesesproceso($datos_bd,date("d/m/Y"),4,0);
	if(isset($_SESSION['sesion_mescierre']))
	$meshoy=$_SESSION['sesion_mescierre'];
	$campo='menu_fila'; $parametros="'mescierre','".$meshoy."',''";
	$formulario->dibujar_campo($campo,$parametros,"Mes de cierre","tdtitulogris",'mescierre','');

	$formulario->filatmp=$datos_bd->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo");
	$codigoperiodo=$_SESSION['codigoperiodosesion'];
	if(isset($_SESSION['sesion_codigoperiodo']))
	$codigoperiodo=$_SESSION['sesion_codigoperiodo'];
	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');
	


	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Informe','Informe',''";
	$boton[$conboton]='boton_tipo';
	//$conboton++;
	//ventana_emergente_submit('archivoplano.php','archivoplano','Archivo Plano','600','400','form2')
	

	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
	
	//$formulario->boton_tipo('hidden','codigoperiodosesion',$_POST['codigoperiodo']);

echo "</table>
</form>";


if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']!=''))
$_SESSION['sesion_codigoestudiante']=$_GET['codigoestudiante'];


if(isset($_REQUEST['Informe'])||isset($_REQUEST['Filtrar'])||isset($_REQUEST['Exportar'])){
	$query="SELECT distinct 
	e.idestudiantegeneral,
	e.codigoestudiante Codigo_Estudiante,
	d.nombrecortodocumento Tipo,
	eg.numerodocumento,
	eg.apellidosestudiantegeneral apellidos,
	eg.nombresestudiantegeneral nombres,
	c.nombrecortocarrera,
	c.codigocarrera
	FROM estudiante e, estudiantegeneral eg, 
	carrera c, modalidadacademica ma, documento d, 
	situacioncarreraestudiante sce, ordenpago op, carreracentrotrabajoarp cc
	WHERE e.idestudiantegeneral=eg.idestudiantegeneral
	AND cc.codigocarrera=c.codigocarrera
	AND cc.codigoestado like '1%'
	AND e.codigocarrera = c.codigocarrera
	AND c.codigomodalidadacademica=ma.codigomodalidadacademica
	AND eg.tipodocumento=d.tipodocumento
	AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
	AND e.codigosituacioncarreraestudiante like '3%'
	AND ma.codigomodalidadacademica=300
	AND e.codigoestudiante=op.codigoestudiante
	AND op.codigoperiodo='".$_SESSION['sesion_codigoperiodo']."'
	AND op.codigoestadoordenpago=40
	order by apellidosestudiantegeneral,nombresestudiantegeneral
	";
$objetobase=new BaseDeDatosGeneral($sala);

$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();

	$condicion="and codigoestado like '1%' 
			and '".formato_fecha_mysql("01/".$_SESSION['sesion_mescierre'])."' between fechainicionovedadarp and fechafinalnovedadarp";

	$novedad=$objetobase->recuperar_datos_tabla("novedadarp","nombrecortonovedadarp","VSP",$condicion,"",0);

do
{
	$idestudiantegeneral=$row_operacion['idestudiantegeneral'];
	if(existe_novedad_vigente_eps($_SESSION['sesion_mescierre'],$idestudiantegeneral,$objetobase,"VSP"))
		$row_operacion['VSP']="<input type='checkbox' value='1' onclick=\"cambia_estado(this,'".$_SESSION['sesion_mescierre']."',".$row_operacion['idestudiantegeneral'].",'".date("d/m/Y")."')\" checked>";
	else
		$row_operacion['VSP']="<input type='checkbox' value='1'  onclick=\"cambia_estado(this,'".$_SESSION['sesion_mescierre']."',".$row_operacion['idestudiantegeneral'].",'".date("d/m/Y")."')\">";
	//echo "modificarvariacionsalario.php?mescierre=".$_SESSION['sesion_mescierre']."&idestudiantegeneral=".$row_operacion['idestudiantegeneral']."&estado=100&fechaingreso=".date("d/m/Y");
	$row_operacion=QuitarColumnaFila($row_operacion,1);
	$row_operacion=QuitarColumnaFila($row_operacion,1);
	$row_operacion=QuitarColumnaFila($row_operacion,5);
	
	$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
while ($row_operacion=$operacion->fetchRow());
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($array_interno,"Listado de Variacion Permanente de Salario en el Mes ".$_SESSION['sesion_mescierre'],$_SERVER['REQUEST_URI']."&mescierre=".$_SESSION['sesion_mescierre']."&codigoperiodo=".$_SESSION['sesion_codigoperiodo'],"no","","",$_SERVER['REQUEST_URI']."&mescierre=".$_SESSION['sesion_mescierre']."&codigoperiodo=".$_SESSION['sesion_codigoperiodo'],"","");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('idcentrotrabajoarp','centrostrabajo.php','centrostrabajo.php','','idcentrotrabajoarp',"",'','','','','onclick= "return ventanaprincipal(this)"');

$motor->mostrar();
}
?>
