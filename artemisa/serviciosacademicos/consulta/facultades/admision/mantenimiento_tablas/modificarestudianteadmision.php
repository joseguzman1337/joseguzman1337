<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
     
session_start();
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../../funciones/clases/autenticacion/redirect.php' );

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
	document.location.href="<?php echo '../prematricula/matriculaautomaticaordenmatricula.php';?>";
}
//quitarFrame()
</script>

<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>
<?php
function recuperaidestudianteadmision($codigocarrera,$idsubperiodo,$numerodocumento,$objetobase){

$condicion=" and a.idadmision=ea.idadmision and
			e.codigoestudiante=ea.codigoestudiante and
			e.idestudiantegeneral=eg.idestudiantegeneral and
			e.codigocarrera='".$codigocarrera."' and 
			a.idsubperiodo='".$idsubperiodo."' ";
$datosestudiante=$objetobase->recuperar_datos_tabla("admision a, estudianteadmision ea, estudiante e, estudiantegeneral eg ","eg.numerodocumento",$numerodocumento,$condicion,' , ea.codigoestudiante codigoestudianteestudianteadmision, ea.codigoestado estadoestudianteadmision',0);
return $datosestudiante['idestudianteadmision'];
}
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
//$codigoperiodo=$formulario->carga_periodo(4);
//$formulario->agregar_tablas('estudiante','codigoestudiante');
$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
//echo "LINK_ORIGEN=".$_GET['link_origen'];
?>

<form name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		if(!isset($_GET['idestudianteadmision'])||trim($_GET['idestudianteadmision'])=="")
			$_GET['idestudianteadmision']=recuperaidestudianteadmision($_GET['codigocarrera'],$_GET['idsubperiodo'],$_GET['numerodocumento'],$objetobase);
		
		$formulario->dibujar_fila_titulo('MODIFICACION DE ADMISION DE ESTUDIANTE','labelresaltado');
		$condicion=" and e.codigoestudiante=ea.codigoestudiante and 
					eg.idestudiantegeneral=e.idestudiantegeneral
					";
		$datosestudiantegeneral=$objetobase->recuperar_datos_tabla("estudianteadmision ea, estudiante e, estudiantegeneral eg","ea.idestudianteadmision",$_GET['idestudianteadmision'],$condicion,' , ea.codigoestudiante codigoestudianteestudianteadmision, ea.codigoestado estadoestudianteadmision',0);
		$nombre=strtoupper($datosestudiantegeneral['apellidosestudiantegeneral']." ".$datosestudiantegeneral['nombresestudiantegeneral']." CC ".$datosestudiantegeneral['numerodocumento']);
		$datosestudiantegeneral['codigoestudianteestudianteadmision'];
		$formulario->dibujar_fila_titulo($nombre,'labelresaltado');
		$condicion=" e.codigocarrera=c.codigocarrera
					and e.idestudiantegeneral='".$datosestudiantegeneral['idestudiantegeneral']."' ";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudiante e, carrera c","e.codigoestudiante"," CONCAT(e.codigoestudiante,' ',e.codigoperiodo,' ',c.nombrecarrera) codigoestudiantecarrera",$condicion,"",0,0);
		$campo='menu_fila'; $parametros="'codigoestudiantecarrera','".$datosestudiantegeneral['codigoestudianteestudianteadmision']."',''";
		$formulario->dibujar_campo($campo,$parametros,"Codigo estudiante","tdtitulogris",'codigoestudiantecarrera','requerido');
		
		$condicion="";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estado","codigoestado","nombreestado",$condicion,"",0,0);
		$campo='menu_fila'; $parametros="'codigoestado','".$datosestudiantegeneral['estadoestudianteadmision']."',''";
		$formulario->dibujar_campo($campo,$parametros,"Estado General","tdtitulogris",'codigoestado','requerido');

		$condicion=" codigoestadoestudianteadmision=codigoestadoestudianteadmision
					order by nombreestadoestudianteadmision";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estadoestudianteadmision","codigoestadoestudianteadmision","nombreestadoestudianteadmision",$condicion,"",0,0);
		$campo='menu_fila'; $parametros="'codigoestadoestudianteadmision','".$datosestudiantegeneral['codigoestadoestudianteadmision']."',''";
		$formulario->dibujar_campo($campo,$parametros,"Estado en el Proceso","tdtitulogris",'codigoestadoestudianteadmision','requerido');

		$conboton=0;
		$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
		$boton[$conboton]='boton_tipo';
		$conboton++;
		$parametrobotonenviar[$conboton]="'hidden','idestudianteadmision','".$datosestudiantegeneral['idestudianteadmision']."'";
		$boton[$conboton]='boton_tipo';

		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
					

		if(isset($_REQUEST['Enviar'])){
			$tabla='estudianteadmision';
			$idtabla=$_POST['idestudianteadmision'];
			$fila["codigoestado"]=$_POST['codigoestado'];
			$fila["codigoestadoestudianteadmision"]=$_POST['codigoestadoestudianteadmision'];
			$fila["codigoestudiante"]=$_POST["codigoestudiantecarrera"];
			$objetobase->actualizar_fila_bd($tabla,$fila,'idestudianteadmision',$idtabla);
			$tabladetalle='detalleestudianteadmision';
			$filadetalle["codigoestado"]=$_POST['codigoestado'];
			$objetobase->actualizar_fila_bd($tabladetalle,$filadetalle,'idestudianteadmision',$idtabla);
			
			echo "<script language='javascript'>window.close()</script><script language='javascript'>window.opener.recargar();</script>","<script language='javascript'>window.close()</script><script language='javascript'>window.opener.recargar();</script>";
		}

	?>
  </table>
</form>	