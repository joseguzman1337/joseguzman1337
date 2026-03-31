<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script language="javascript">
function enviar()
{
	form1.action="";
	document.form1.submit();
	
}
function enviarmodalidad(){

var codigocarrera=document.getElementById("codigocarrera");
//document.getElementById("tr0")
	form1.action="";
if(codigocarrera!=null)
codigocarrera.value="";
form1.submit();
}
function enviarcarrera(){

var codigoperiodo=document.getElementById("codigoperiodo");
//document.getElementById("tr0")
//alert("Entro numerodocumento="+numerodocumento);
	form1.action="";
if(codigoperiodo!=null)
codigoperiodo.value="";
form1.submit();
}
function enviarperiodo(){

var numerodocumento=document.getElementById("numerodocumento");
//document.getElementById("tr0")
//alert("Entro numerodocumento="+numerodocumento);
	form1.action="";
if(numerodocumento!=null)
numerodocumento.value="";
form1.submit();
}

</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<link rel="stylesheet" type="text/css" href="../../../funciones/sala_genericas/ajax/suggest/suggest.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/suggest/suggest.js"></script>

<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once('../../../funciones/sala_genericas/FuncionesFecha.php');
require_once('../../../funciones/sala_genericas/FuncionesCadena.php');

require_once('../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once('../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
//require_once('../../../funciones/clases/autenticacion/redirect.php');
//unset($_SESSION);
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$usuario=$formulario->datos_usuario();

if(isset($_REQUEST['idregistroprocesofacultad'])&&$_REQUEST['idregistroprocesofacultad']!=''){
	$condicion=" and eg.idestudiantegeneral=e.idestudiantegeneral and
				e.codigoestudiante=rf.codigoestudiante and
				rf.codigoestado like '1%'";
	$datosregistroproceso=$objetobase->recuperar_datos_tabla("registroprocesofacultad rf,estudiante e,estudiantegeneral eg","rf.idregistroprocesofacultad",$_REQUEST['idregistroprocesofacultad'],$condicion,"",0);
	$_REQUEST['numerodocumento']=$datosregistroproceso["numerodocumento"];
	$_REQUEST['numeroordenpago']=$datosregistroproceso["numeroordenpago"];
	$_REQUEST['observacionregistroprocesofacultad']=$datosregistroproceso["observacionregistroprocesofacultad"];
	$conboton=0;
	$parametrobotonenviar[$conboton]="'hidden','idregistroprocesofacultad','".$_REQUEST['idregistroprocesofacultad']."'";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar',' onclick=\'enviartarget();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$parametrobotonenviar[$conboton]="'submit','Anular','Anular',' onclick=\'enviartarget();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;

}
else{
	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar',' onclick=\'enviartarget();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;

}


echo "<form name='form1' action='' method='POST' >
<input type='hidden' name='AnularOK' value=''>
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>
	"; 
	
			$formulario->dibujar_fila_titulo('REGISTRO DE PROCESO DE FACULTAD','labelresaltado');

			$condicion="";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tiporegistroprocesofacultad t","t.codigotiporegistroprocesofacultad","t.nombretiporegistroprocesofacultad",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigotiporegistroprocesofacultad','".$_REQUEST['codigotiporegistroprocesofacultad']."','onchange=enviar();'";
		$formulario->dibujar_campo($campo,$parametros,"Tipo de registro","tdtitulogris",'codigotiporegistroprocesofacultad','requerido');		

if(isset($_REQUEST['codigotiporegistroprocesofacultad'])&&($_REQUEST['codigotiporegistroprocesofacultad']!='')){

			$condicion="";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica m","m.codigomodalidadacademica","m.nombremodalidadacademica",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_REQUEST['codigomodalidadacademica']."','onchange=enviarmodalidad();'";
		$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','requerido');		




			if($_SESSION["MM_Username"]=="admintecnologia"){
				$condicion=" codigomodalidadacademica='".$_REQUEST['codigomodalidadacademica']."'
							and now()  between fechainiciocarrera and fechavencimientocarrera
							order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
			}
			else{
				$condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and c.codigomodalidadacademica='".$_REQUEST['codigomodalidadacademica']."'
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
			}



			$campo='menu_fila'; $parametros="'codigocarrera','".$_REQUEST['codigocarrera']."','onchange=enviarcarrera();'";
			$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido');		
if(isset($_REQUEST['codigocarrera'])&&($_REQUEST['codigocarrera']!='')){

	$condicion=" 1=1 order by codigoperiodo asc";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo",$condicion,"",0,0);
	$formulario->filatmp[""]="Seleccionar";

	$codigoperiodo=$_SESSION['codigoperiodosesion'];
	if(!isset($_REQUEST['codigoperiodo']))
	$codigoperiodo="";
	else
	$codigoperiodo=$_REQUEST['codigoperiodo'];
	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."','onchange=enviarperiodo();'";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');


if(isset($_REQUEST['codigoperiodo'])&&($_REQUEST['codigoperiodo']!='')){

		$tablas="estudiantegeneral";
		$campollave="numerodocumento";
		$camponombre="numerodocumento";
		$funcionlink="";
		$nombrecampo="numerodocumento";
		$direccionsuggest="../../../funciones/sala_genericas/ajax/suggest/suggest.php?keyword=";
		$condicion=" and idestudiantegeneral in (select idestudiantegeneral from estudiante where codigocarrera=".$_REQUEST['codigocarrera'].")";
		$imprimir=1;
		$valorcampo=$_REQUEST['numerodocumento'];
		$valorcamponombre=$_REQUEST['numerodocumento'];
		
		$parametrobotonenviar2="'".$tablas."','".$campollave."','".$camponombre."','".$condicion."','".$valorcampo."','".$valorcamponombre."','".$nombrecampo."','".$direccionsuggest."','".$imprimir."','enviar()'";;
									//($tablas,    $campollave,     $camponombre,       $condicion,      $valorcampo,$valorcamponombre,$nombrecampo,$direccionsuggest,$imprimir=0){
		
		$boton2='campo_sugerido';
		$formulario->dibujar_campo($boton2,$parametrobotonenviar2,"Numero Documento","tdtitulogris",'numerodocumento','requerido',0);


		//$conboton++;
		$parametrobotonenviar[$conboton]="'Listado','listadoregistroprocesofacultad.php','codigoperiodo=".$_REQUEST['codigoperiodo']."&codigocarrera= ".$_REQUEST['codigocarrera']."&codigotiporegistroprocesofacultad=".$_REQUEST['codigotiporegistroprocesofacultad']."&codigomodalidad=".$_REQUEST['codigomodalidadacademica']."',900,300,5,5,'yes','yes','no','yes','yes'";
		$boton[$conboton]='boton_ventana_emergente';
		

if(isset($_REQUEST['numerodocumento'])&&($_REQUEST['numerodocumento']!='')){

		/*$tablas="ordenpago";
		$campollave="numeroordenpago";
		$camponombre="numeroordenpago";
		$funcionlink="";
		$nombrecampo="numeroordenpago";
		$condicion=" and numeroordenpago in (select distinct numeroordenpago from ordenpago o,
					estudiantegeneral eg, estudiante e
					where e.idestudiantegeneral=eg.idestudiantegeneral and
					 o.codigoestudiante=e.codigoestudiante and
					 eg.numerodocumento=".$_REQUEST['numerodocumento'].")";
		
		$direccionsuggest="../../../funciones/sala_genericas/ajax/suggest/suggest.php?keyword=";
		//$condicion="numeroordenpago in (select idestudiantegeneral from estudiante where codigoperiodo=20072 and codigocarrera=10)";
		//$condicion="";
		$imprimir=1;

		$valorcampo=$_REQUEST['numeroordenpago'];
		$valorcamponombre=$_REQUEST['numeroordenpago'];
		$parametrobotonenviar2="'".$tablas."','".$campollave."','".$camponombre."','".$condicion."','".$valorcampo."','".$valorcamponombre."','".$nombrecampo."','".$direccionsuggest."','".$imprimir."'";
									//($tablas,    $campollave,     $camponombre,       $condicion,      $valorcampo,$valorcamponombre,$nombrecampo,$direccionsuggest,$imprimir=0){

		$boton2='campo_sugerido';

		$formulario->dibujar_campo($boton2,$parametrobotonenviar2,"Orden Pago","tdtitulogris",'Enviar','requerido',0);
*/

switch($_REQUEST['codigotiporegistroprocesofacultad']){
case '100':
$codigoconcepto="153";
break;
case '200':
$codigoconcepto="151";
break;
}
				$condicion="
					 e.idestudiantegeneral=eg.idestudiantegeneral and
					 o.codigoestudiante=e.codigoestudiante and
					 eg.numerodocumento=".$_REQUEST['numerodocumento']." and 
					 o.codigoperiodo=".$_REQUEST['codigoperiodo']." and
					 d.numeroordenpago=o.numeroordenpago and
					 c.cuentaoperacionprincipal in (".$codigoconcepto.")and
					 d.codigoconcepto=c.codigoconcepto					 
					 order by numeroordenpago desc
					 ";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("concepto c,ordenpago o,estudiantegeneral eg, estudiante e,detalleordenpago d","o.numeroordenpago","o.numeroordenpago",$condicion,"",0);
				$formulario->filatmp[""]="Seleccionar";


			$campo='menu_fila'; $parametros="'numeroordenpago','".$_REQUEST['numeroordenpago']."','onchange=enviar();'";
			$formulario->dibujar_campo($campo,$parametros,"Numero Orden Pago","tdtitulogris",'numeroordenpago','requerido');		

	
	  $campo="memo"; $parametros="'observacionregistroprocesofacultad','registroprocesofacultad',70,8,'','','',''";
      $formulario->dibujar_campo($campo,$parametros,"Observacion","tdtitulogris",'observacionregistroprocesofacultad');
	  $formulario->cambiar_valor_campo('observacionregistroprocesofacultad',$_REQUEST["observacionregistroprocesofacultad"]);



}



	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

}
}
}
echo "</table></form>";

if(isset($_REQUEST['Enviar'])){
	//

	if($formulario->valida_formulario()){
	$condicion=" and eg.idestudiantegeneral=e.idestudiantegeneral and
				e.codigocarrera=".$_REQUEST['codigocarrera'];
		$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e,estudiantegeneral eg","eg.numerodocumento",$_REQUEST['numerodocumento'],$condicion,"",0);
		$fila["codigoestudiante"]=$datosestudiante["codigoestudiante"];
		$fila["fecharegistroprocesofacultad"]=date("Y-m-d");
		$fila["codigoestado"]="100";
		$fila["codigotiporegistroprocesofacultad"]=$_REQUEST['codigotiporegistroprocesofacultad'];
		$fila["codigoperiodo"]=$_REQUEST['codigoperiodo'];
		$fila["numeroordenpago"]=$_REQUEST['numeroordenpago'];
		$fila["observacionregistroprocesofacultad"]=$_REQUEST["observacionregistroprocesofacultad"];
		$condicionactualiza=" codigoestudiante=".$fila["codigoestudiante"]." and".
							" codigoestado=100 and ".
							" codigotiporegistroprocesofacultad=".$_REQUEST['codigotiporegistroprocesofacultad']." and ".
							" codigoperiodo=".$fila["codigoperiodo"];
		$objetobase->insertar_fila_bd("registroprocesofacultad",$fila,0,$condicionactualiza);
	alerta_javascript("Registro realizado satisfactoriamente");
	}
	else{
	//alerta_javascript("Los campos con * deben ser diligenciados");
	}
}

if(isset($_REQUEST['Modificar'])){
	//alerta_javascript("Entro a Modificar".$_REQUEST["numerodocumento"]);
	//$_POST["numerodocumento"]=$_REQUEST["numerodocumento"];
	if($formulario->valida_formulario()){

	$condicion=" and eg.idestudiantegeneral=e.idestudiantegeneral and
				e.codigocarrera=".$_REQUEST['codigocarrera'];
		$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e,estudiantegeneral eg","eg.numerodocumento",$_REQUEST['numerodocumento'],$condicion,"",0);
		$fila["codigoestudiante"]=$datosestudiante["codigoestudiante"];
		//$fila["fecharegistroprocesofacultad"]=date("Y-m-d");
		$fila["codigoestado"]="100";
		$fila["codigotiporegistroprocesofacultad"]=$_REQUEST['codigotiporegistroprocesofacultad'];
		$fila["codigoperiodo"]=$_REQUEST['codigoperiodo'];
		$fila["numeroordenpago"]=$_REQUEST['numeroordenpago'];
		$fila["observacionregistroprocesofacultad"]=$_REQUEST["observacionregistroprocesofacultad"];
		$objetobase->actualizar_fila_bd("registroprocesofacultad",$fila,"idregistroprocesofacultad",$_REQUEST["idregistroprocesofacultad"]);
		alerta_javascript("Registro realizado satisfactoriamente");

	}

}
if(isset($_REQUEST['Anular'])){
	//alerta_javascript("Entro a Modificar".$_REQUEST["numerodocumento"]);
	//$_POST["numerodocumento"]=$_REQUEST["numerodocumento"];
	//if($formulario->valida_formulario()){
		$fila["codigoestado"]="200";
		$objetobase->actualizar_fila_bd("registroprocesofacultad",$fila,"idregistroprocesofacultad",$_REQUEST["idregistroprocesofacultad"]);
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=menuregistroprocesofacultad.php'>";
	//}
}

?>