<?php
session_start();
$rol=$_SESSION['rol'];

//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");


?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>

<script LANGUAGE="JavaScript">
function regresarGET()
{
	//history.back();
	parent.document.location.href="<?php echo 'menumantenimientovotaciones.php';?>";
}
function enviarForm(){
	var formulario=document.getElementById("form1");
	formulario.action="../datosVotacion.php";
	formulario.target="mainvotacion";
	formulario.submit();
	formulario.action="";
	formulario.target="";
	return false;
}
</script>

<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();


?>
<form name="form1"  id="form1" method="get"  action="" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">

	<?php 
if(isset($_GET['idvotacion'])&&$_GET['idvotacion']!=''){
$_SESSION['datosvotante']['idvotacion']=$_GET['idvotacion'];
$_SESSION['datosvotante']['codigocarrera']=$_GET['codigocarrera'];
$_SESSION['datosvotante']['tipovotante']=$_GET['tipovotante'];
unset($_SESSION['tmptipovotante']);
}
$idvotacion=$_SESSION['datosvotante']['idvotacion'];
$codigocarrera=$_SESSION['datosvotante']['codigocarrera'];
$tipovotante=$_SESSION['datosvotante']['tipovotante'];
//$_SESSION['datosvotante']['codigocarrera']

			$formulario->dibujar_fila_titulo('Verificacion De Votaciones','labelresaltado');

			$condicion=" codigoestado like '1%'";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("votacion","idvotacion","nombrevotacion",$condicion,"",0);
			$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idvotacion','".$idvotacion."','onChange=\"form1.submit();\"'";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Votacion","tdtitulogris","idvotacion",'requerido');

			if(isset($_GET['idvotacion'])&&$_GET['idvotacion']!=''){

			$condicion=" c.codigocarrera in (select codigocarrera from plantillavotacion where codigoestado like '1%' and  idvotacion='".$_GET['idvotacion']."')". 
					   " order by nombrecarrera2";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","c.codigocarrera","c.nombrecarrera",$condicion,', replace(c.nombrecarrera,\' \',\'\') nombrecarrera2');
			$campo='menu_fila'; $parametros="'codigocarrera','".$codigocarrera."','onChange=\"enviarmenu(\'codigocarrera\');\"'";
			$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido','',1);
				
			$formulario->filatmp["estudiante"]="Estudiante";
			$formulario->filatmp["docente"]="Docente";
			$formulario->filatmp["egresado"]="Egresado";
			$formulario->filatmp["directivo"]="Directivo";
			$campo='menu_fila'; $parametros="'tipovotante','".$tipovotante."','onChange=\"enviarmenu(\'codigocarrera\');\"'";
			$formulario->dibujar_campo($campo,$parametros,"Tipo Candidato","tdtitulogris",'tipovotante','requerido','',1);

			}
$conboton=0;
		$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar','onclick=\"return enviarForm();\"'";
		$boton[$conboton]='boton_tipo';
		$conboton++;
		$parametrobotonenviar[$conboton]="'Listado','listadocandidatoplantilla.php','codigoperiodo=".$codigoperiodo."&link_origen= ".$_GET['link_origen']."',700,600,5,50,'yes','yes','no','yes','yes'";
		$boton[$conboton]='boton_ventana_emergente';
		$conboton++;
		$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);




?>

  </table>
</form>