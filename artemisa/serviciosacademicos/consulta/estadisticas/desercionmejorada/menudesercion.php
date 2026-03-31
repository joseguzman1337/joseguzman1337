<?php 
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo '../matriculas/menu.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo '../matriculas/menu.php';?>";
}
function enviarmenu()
{
form1.action="";
form1.submit();
}
</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');

echo "<form name=\"form1\" action=\"listadodetalledesercion.php\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

 	$formulario->dibujar_fila_titulo('LISTADO DESERCIÓN ESTUDIANTIL PERMANENTE','labelresaltado',"2","align='center'");
	
	
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica f","codigomodalidadacademica","nombremodalidadacademica","");
	$formulario->filatmp["todos"]="*Todos*";
	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_POST['codigomodalidadacademica']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','');

	//$codigofacultad="05";
	$condicion="c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
				and c.codigocarrera <> 13
				and now() between fechainiciocarrera and fechavencimientocarrera
				order by c.nombrecarrera";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion,'',0);
	$formulario->filatmp["todos"]="*Todos*";
	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigocarrera','".$_POST['codigocarrera']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','');

	$condicion="codigoperiodo=codigoperiodo having periodoant  < (select codigoperiodo from periodo where codigoestadoperiodo = 1 ) order by codigoperiodo desc";
	$valorescondicion="if((codigoperiodo mod 2)=0,(codigoperiodo -1),(codigoperiodo-9)) periodoant";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo",$valorescondicion,"codigoperiodo",$condicion,"",0,0);
	$codigoperiodo=$_SESSION['codigoperiodosesion'];
	if(isset($_POST['codigoperiodo']))
	$codigoperiodo=$_POST['codigoperiodo'];
	if(isset($_GET['codigoperiodo']))
	$codigoperiodo=$_GET['codigoperiodo'];	
	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');

	$formulario->filatmp["1"]="Misma carrera";
	$formulario->filatmp["2"]="Todas las carreras";
	$campo='menu_fila'; $parametros="'tipodesercion','".$tipodesercion."',''";
	$formulario->dibujar_campo($campo,$parametros,"Tipo de desercion","tdtitulogris",'tipodesercion','');
	
	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar',''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
	
?>