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
	document.location.href="<?php echo 'menuadministracionresultados.php';?>";
}
function enviarpagina(){

var pagina;
var formulario=document.getElementById("form1");
var menu=document.getElementById("menu");
//alert(formulario.action);
pagina=menu[menu.selectedIndex].value;
//alert(pagina);
formulario.action=pagina;
//return false;
}
function enviarmenulistado(){
//alert(pagina);

var formulario=document.getElementById("form1");
formulario.action="menulistadoresultados.php";
//alert(formulario.action);
formulario.submit();
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
<form name="form1" id="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="" onChange="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
	$formulario->dibujar_fila_titulo('PROCESO ADMISIONES','labelresaltado',"2","align='center'");
	$formulario->dibujar_fila_titulo('3. LISTADOS DE RESULTADOS PDF','labelresaltado',"2","align='center'");

	//$formulario->dibujar_fila_titulo('Datos Generales','labelresaltado');?>
	<tr>
	<td colspan="2">
	<?php 	
		//$formulario->dibujar_fila_titulo('Asignacion de codigos EPS y ARP','labelresaltado');
		$codigoperiodo=$_SESSION['codigoperiodo_seleccionado'];
		//$array_carreras=$datos->LeerCarreras($_SESSION['codigomodalidadacademica'],$_SESSION['codigocarrera']);
	
		/*$opcionparametrizacion="detalleadmisionlistado_listado.php";
  		$formulario->filatmp[$opcionparametrizacion]="Configuración de muestra de resultados";*/
		$opcionparametrizacion="";
		$formulario->filatmp[$opcionparametrizacion]="Seleccionar";

		$opcionparametrizacion="listadoalfabeticopdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Total Alfabetico";

		$opcionparametrizacion="listadopuntajepdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Total  Puntaje";

		$opcionparametrizacion="listadopuntajeentrevistapdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Entrevista  Puntaje";

		$opcionparametrizacion="listadoalfabeticoentrevistapdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Entrevista  Alfabetico";

		$opcionparametrizacion="listadocitacionentrevistapdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Citacion  Entrevista";

		$opcionparametrizacion="listadocitacionentrevistasalonpdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Citacion  Entrevista Salon";

		$opcionparametrizacion="listadocursobasicopdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Curso Basico";

		$opcionparametrizacion="listadosegundaopcionpdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Segunda Opcion";


		$opcionparametrizacion="listadopostgradocitacionentrevistapdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Postgrados Citacion  Entrevista";

		$opcionparametrizacion="listadopuntajeceropdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado Puntajes En Cero";

		$opcionparametrizacion="listadofichatecnicapdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Ficha Tecnica";

		$opcionparametrizacion="listadoenprocesopdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado inscritos que no aprobaron";

		$opcionparametrizacion="listadopostgradoenproceso.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado inscritos de postgrado que no aprobaron";

		$opcionparametrizacion="listadoadmitidos.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado de admitidos";

                $opcionparametrizacion="listadopostgradoadmitidopdf.php";
		$formulario->filatmp[$opcionparametrizacion]="Listado de admitidos postgrado";
		
		$opcionparametrizacion="listadoasignacionsalonpdf.php";
                $formulario->filatmp[$opcionparametrizacion]="Listado Asignacion Salones";

                $opcionparametrizacion="listadoasignacionsalonfirmapdf.php";
                $formulario->filatmp[$opcionparametrizacion]="Listado Salones Firma";	

		$menu='menu_fila'; $parametros="'menu','".$_POST["menu"]."','onchange= enviarmenulistado();'";
		$formulario->dibujar_campo($menu,$parametros,"Opciones","tdtitulogris","escogertipoarp",'requerido');
		$conboton=0;

		if($_POST["menu"]=="listadopostgradocitacionentrevistapdf.php"||$_POST["menu"]=="listadopostgradoenproceso.php"||$_POST["menu"]=="listadopostgradoadmitidopdf.php"){
			$campo = "campo_fecha"; $parametros ="'text','fechaexamen','".$fechainicio."',''";
			$formulario->dibujar_campo($campo,$parametros,"Fecha de examen","tdtitulogris",'fechaexamen','requerido');
		}
$listadosdefinitivos[]="listadocursobasicopdf.php";
$listadosdefinitivos[]="listadocitacionentrevistapdf.php";
$listadosdefinitivos[]="listadocitacionentrevistasalonpdf.php";
$listadosdefinitivos[]="listadopostgradocitacionentrevistapdf.php";
$listadosdefinitivos[]="listadosegundaopcionpdf.php";
$listadosdefinitivos[]="listadoenprocesopdf.php";
$listadosdefinitivos[]="listadopostgradoenproceso.php";
$listadosdefinitivos[]="listadoadmitidos.php";
$listadosdefinitivos[]="listadopostgradoadmitidopdf.php";


		if(in_array($_POST["menu"],$listadosdefinitivos)){
			$opcionparametrizacion=" ";
			$formulario->filatmp[$opcionparametrizacion]="Seleccionar";
			$formulario->filatmp["Si"]="Si";
			$formulario->filatmp["No"]="No";

	
	
			$menu='menu_fila'; $parametros="'ingresadefinitivo','".$_POST["ingresadefinitivo"]."','onchange= enviarmenulistado();'";
			$formulario->dibujar_campo($menu,$parametros,"Generar listado definitivo? ","tdtitulogris","ingresadefinitivo",'requerido');

		}


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
