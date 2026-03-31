<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
//$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
//require_once("../../../../funciones/phpmailer/class.phpmailer.php");
//require_once("../../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('../../../../funciones/sala_genericas/FuncionesSeguridad.php');

require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

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
	document.location.href="<?php echo 'menu.php';?>";
}
function enviarpagina(){
var pagina;
pagina=form1.menu[document.form1.menu.selectedIndex].value;
//alert(pagina);
form1.action=pagina;
//return false;
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
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
//$formulario2=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$idmenuopcion=116;
if(!validaUsuarioMenuOpcion($idmenuopcion,$formulario,$objetobase))
{
	 echo "<script language='javascript'>
		 	alert('Usted no tiene permiso para entrar a esta opcion');
	   		parent.location.href='https://www.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm';
	 	  </script>";
}

//echo "Entro aqui";
?>
<form name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="" onChange="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
	$formulario->dibujar_fila_titulo('PROCESO ADMISIONES','labelresaltado',"2","align='center'");
	$formulario->dibujar_fila_titulo('3. ADMINISTRACION RESULTADOS','labelresaltado',"2","align='center'");

	//$formulario->dibujar_fila_titulo('Datos Generales','labelresaltado');?>
	<tr>
	<td colspan="2">
	<?php 	
		//$formulario->dibujar_fila_titulo('Asignacion de codigos EPS y ARP','labelresaltado');
		$codigoperiodo=$_SESSION['codigoperiodo_seleccionado'];
		//$array_carreras=$datos->LeerCarreras($_SESSION['codigomodalidadacademica'],$_SESSION['codigocarrera']);
	
		
		$opcionparametrizacion="menu_subirexamen.php?asignaestado&codigomodalidadacademica=".$_SESSION['admisiones_codigomodalidadacademica']."&codigocarrera=".$_SESSION['admisiones_codigocarrera']."&codigoperiodo=".$_SESSION['admisiones_codigoperiodo']."&link_origen=menu.php";
  		$formulario->filatmp[$opcionparametrizacion]="Subir Archivo Plano de Ex&aacute;menes";
		$opcionparametrizacion="menu_subirsegundoexamen.php?asignaestado&codigomodalidadacademica=".$_SESSION['admisiones_codigomodalidadacademica']."&codigocarrera=".$_SESSION['admisiones_codigocarrera']."&codigoperiodo=".$_SESSION['admisiones_codigoperiodo']."&link_origen=menu.php";
  		$formulario->filatmp[$opcionparametrizacion]="Subir Archivo Plano de Segundo Examen";
		$opcionparametrizacion="calcula_listado_resultados.php?cambioestado&codigomodalidadacademica=".$_SESSION['admisiones_codigomodalidadacademica']."&codigocarrera=".$_SESSION['admisiones_codigocarrera']."&codigoperiodo=".$_SESSION['admisiones_codigoperiodo']."&link_origen=menu.php";
  		$formulario->filatmp[$opcionparametrizacion]="Clasificacion resultados";
		$opcionparametrizacion="calcula_listado_resultados.php?asignaestado&codigomodalidadacademica=".$_SESSION['admisiones_codigomodalidadacademica']."&codigocarrera=".$_SESSION['admisiones_codigocarrera']."&codigoperiodo=".$_SESSION['admisiones_codigoperiodo']."&link_origen=menu.php";
  		$formulario->filatmp[$opcionparametrizacion]="Asignacion de horario a estado";
		$opcionparametrizacion="menu_subirarchivosegundaopcion.php?asignaestado&codigomodalidadacademica=".$_SESSION['admisiones_codigomodalidadacademica']."&codigocarrera=".$_SESSION['admisiones_codigocarrera']."&codigoperiodo=".$_SESSION['admisiones_codigoperiodo']."&link_origen=menu.php";
  		$formulario->filatmp[$opcionparametrizacion]="Subir archivo horarios segunda opcion";
		$opcionparametrizacion="menu_subirarchivoadmitidos.php?asignaestado&codigomodalidadacademica=".$_SESSION['admisiones_codigomodalidadacademica']."&codigocarrera=".$_SESSION['admisiones_codigocarrera']."&codigoperiodo=".$_SESSION['admisiones_codigoperiodo']."&link_origen=menu.php";
  		$formulario->filatmp[$opcionparametrizacion]="Subir archivo de admitidos";
		$opcionparametrizacion="calcula_listado_resultados.php?admitir&codigomodalidadacademica=".$_SESSION['admisiones_codigomodalidadacademica']."&codigocarrera=".$_SESSION['admisiones_codigocarrera']."&codigoperiodo=".$_SESSION['admisiones_codigoperiodo']."&link_origen=menu.php";
		$formulario->filatmp[$opcionparametrizacion]="Admision Estudiantes";
		
		/*$opcionparametrizacion="detalleadmisionlistado_listado.php";
  		$formulario->filatmp[$opcionparametrizacion]="Configuración de muestra de resultados";*/

		$opcionparametrizacion="menulistadoresultados.php";
		$formulario->filatmp[$opcionparametrizacion]="Listados PDF";


		$menu='menu_fila'; $parametros="'menu','".$menu."',''";
		$formulario->dibujar_campo($menu,$parametros,"Opciones","tdtitulogris","escogertipoarp",'requerido');
		$conboton=0;
		$parametrobotonenviar[$conboton]="'submit','Seguir','Seguir','onClick=\"return enviarpagina();\"'";
		$boton[$conboton]='boton_tipo';
		$conboton++;				
		$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','');
	?>	
	</td>
	</tr>
  </table>
</form>