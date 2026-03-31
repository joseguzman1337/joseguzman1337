<?php session_start();
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

<script LANGUAGE="JavaScript">
function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	//history.back();
//	parent.location.href="<?php echo '../prematricula/matriculaautomaticaordenmatricula.php';?>";
	parent.location.href="<?php echo 'menuinicialaportes.php';?>";

}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

if($_REQUEST['depurar']=="si")
{
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	if($_REQUEST['depurar_correo']=="si")
	{
		$depura_correo=true;
	}
	else
	{
		$depura_correo=false;
	}
}
$codigoperiodo=$formulario->carga_periodo(4);
//$formulario->agregar_tablas('estudiante','codigoestudiante');


$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
//echo "LINK_ORIGEN=".$_GET['link_origen'];

?>
<form name="form1" action="asignacioncodigosepsarp.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		//$formulario->dibujar_fila_titulo('Asignacion ARP','labelresaltado');
		
		//$campo = "campo_fecha"; $parametros ="'text','fechainicio','".$fechainicio."','onKeyUp = \"this.value=formateafecha(this.value);\"'";
	//	$formulario->dibujar_campo($campo,$parametros,"Fecha de inicio","tdtitulogris",'fechainicio','requerido');

		$formulario->dibujar_fila_titulo('Asignacion de codigos EPS y ARP','labelresaltado');

		$idempresasalud=$_POST['idempresasalud'];
		$condicion="";
  		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("empresasalud order by nombreempresasalud","idempresasalud","nombreempresasalud",$condicion);
		$menu='menu_fila'; $parametros="'idempresasalud','".$idempresasalud."','onchange=\'enviar();\''";
		$formulario->dibujar_campo($menu,$parametros,"Empresas EPS, ARP","tdtitulogris","escogertipoarp",'requerido');
		if(isset($_POST['idempresasalud'])){
		$datosempresasalud=$objetobase->recuperar_datos_tabla("empresasalud em","idempresasalud",$idempresasalud,$condicion);
	    $codigoempresasalud=$datosempresasalud['codigoempresasalud'];
		$campo="boton_tipo"; $parametros="'text','codigoempresasalud','".$codigoempresasalud."',''";
	    $formulario->dibujar_campo($campo,$parametros,"Codigo de la empresa de salud","tdtitulogris",'codigoempresalud','');
		}
				  $fechaingreso=date("d/m/Y");
				  $formulario->boton_tipo('hidden','fechaingreso',$fechaingreso);
	
				  $fechafinal="01/01/2099";
				  $formulario->boton_tipo('hidden','fechafinal',$fechafinal);
		
		$conboton=0;
		if(isset($_POST['idempresasalud'])&&$_POST['idempresasalud']!=''){
					$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
					$boton[$conboton]='boton_tipo';
		$conboton++;					
					}

						$parametrobotonenviar[$conboton]="'Listado','listadocodigosempresasalud.php','',700,600,5,50,'yes','yes','no','yes','yes'";
						$boton[$conboton]='boton_ventana_emergente';
						$conboton++;

						$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
						$boton[$conboton]='boton_tipo';
						$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');


	if(isset($_REQUEST['Enviar'])){
	$tabla="empresasalud";
	$idtabla=$_POST['idempresasalud'];
	$filaactualizar['codigoempresasalud']=$_POST['codigoempresasalud'];
	$objetobase->actualizar_fila_bd($tabla,$filaactualizar,'idempresasalud',$idtabla);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
	}

	?>

	
  </table>
</form>