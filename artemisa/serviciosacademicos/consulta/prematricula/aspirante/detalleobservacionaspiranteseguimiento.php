<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/debug/SADebug.php");
require_once(realpath(dirname(__FILE__))."/../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/funciones/claseformularioaspirante.php");
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php' ); 

?>
<script LANGUAGE="JavaScript">
function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	document.location.href="<?php echo $_GET['link_origen']?>";
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<?php
$fechahoy=date("Y-m-d H:i:s");
$formularioseguimiento=new formulario_aspirante($sala,'form1','post','','true');

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
$codigoperiodo=$formularioseguimiento->carga_periodo(4);
$formularioseguimiento->agregar_tablas('estudianteseguimiento','idestudianteseguimiento');

$usuario=$formularioseguimiento->datos_usuario();
$ip=$formularioseguimiento->GetIP();

if(isset($_GET['idestudianteseguimiento']) and $_GET['idestudianteseguimiento']!="")
{
//$datosestudiante=$formularioseguimiento->recuperar_datos_tabla('estudiante','codigoestudiante',$_GET['codigoestudiante']);
//$datosestudiantegeneral=$formularioseguimiento->recuperar_datos_tabla('estudiante','codigoestudiante',$_GET['codigoestudiante']);

//$datoscarreraperiodo=$formularioseguimiento->recuperar_datos_tabla('carreraperiodo','codigocarrera',$datosestudiante['codigocarrera'],"and codigoperiodo=".$datosestudiante['codigoperiodo']);
//carga el formulario

		$row_estudiante=$formularioseguimiento->datos_estudiante_noprematricula($_GET['codigoestudiante']);
		$formularioseguimiento->cargar('estudianteseguimiento',$_GET['idestudianteseguimiento']);
		
	//$formularioseguimiento->cargar('codigoestudiante', $_GET['codigoestudiante']);
	$formularioseguimiento->limites_flechas_tabla_padre_hijo('estudiante','estudianteseguimiento','codigoestudiante','idestudianteseguimiento',$_GET['codigoestudiante'],'codigoestado=100');
	//solo carga un id de la tabla hijo, porque no hay varios seguimientos
	//muestra flechas si aplica
/* 	$maximo=count($_SESSION['array_flechas_tabla_padre_hijo']);
	if($maximo == 1)
	{
		$formularioseguimiento->iterar_flechas_tabla_padre_hijo();
		$formularioseguimiento->cargar_distintivo_condicional('estudiante','codigoestudiante',$_GET['codigoestudiante'],'codigotipoestudiante=10');
		$formularioseguimiento->cargar_distintivo_condicional_true('estudianteseguimiento','idestudianteseguimiento',$_SESSION['contador_flechas'],'codigoestado=100','codigoestudiante',$_GET['codigoestudiante']);
	}
	//carga las tablas de manera distintiva, porque hay varios seguimientos
	elseif($maximo >1)
	{
		$formularioseguimiento->iterar_flechas_tabla_padre_hijo();
		$formularioseguimiento->cargar_distintivo_condicional('estudiante','codigoestudiante',$_GET['codigoestudiante'],'codigotipoestudiante=10');
		$formularioseguimiento->cargar_distintivo_condicional('estudianteseguimiento','idestudianteseguimiento',$_SESSION['contador_flechas'],'codigoestado=100','codigoestudiante',$_GET['codigoestudiante']);
	}
	$formulario->cambiar_estado('estudiante','codigotipoestudiante',200,"<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>");
 */

}

?>
<form name="form1" action="" method="POST">
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
    <?php 
	if(isset($_GET['codigoestudiante'])){
	}
	$formularioseguimiento->dibujar_fila_titulo('Observacion','labelresaltado');

		if($_POST['emailestudiante']!="")
		{
			$mailvalido=validaciongenerica($_POST['emailestudiante'],'email','',true);
			if($mailvalido['valido']==0)
			{
				$formulario->agregar_validaciones_extra('emailestudiantegeneral','email',false,'El mail se encuentra mal digitado');
			}
		}
		$parametrocombotiposeguimiento="'codigotipoestudianteseguimiento','estudianteseguimiento','post','tipoestudianteseguimiento','codigotipoestudianteseguimiento','nombretipoestudianteseguimiento','','','nombretipoestudianteseguimiento'";
		$formularioseguimiento->dibujar_campo('combo',$parametrocombotiposeguimiento,"Tipo Observacion","tdtitulogris",'codigotipoestudianteseguimiento','requerido');

		$formularioseguimiento->dibujar_campo('memo',"'observacionestudianteseguimiento','estudianteseguimiento',70,8,'','','',''","Observacion","tdtitulogris",'observacionestudianteseguimiento','requerido');
	
		if(isset($_GET['codigoestudiante']) and $_GET['codigoestudiante']!="")
		{
			if($maximo >1)
			{
			
				$formularioseguimiento->dibujar_campo('mostrar_flechas_tabla_padre_hijo','',"","tdtitulogris",'flechaspadrehijo');

			}
			
		}
		
		$parametrobotonventanaemergente="'Listado','listadoaspiranteseguimiento.php','codigoestudiante=".$_GET['codigoestudiante']."',700,300,300,150,'yes','yes','no','yes','no'";
		$formularioseguimiento->dibujar_campo('boton_ventana_emergente',$parametrobotonventanaemergente,"","tdtitulogris",'observacionaspiranteseguimiento');
		
	

	
	?>
	
  </table>
</form>
	

