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
require_once('../../../funciones/clases/autenticacion/redirect.php' );

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');
/*@modified Diego Rivera<riveradiego@unbosque.edu.co>
 *Se id tabla en tabla con el fin de poder ocultarla mientras carga el reporte
 *@since november 27,2018 
 */
echo "<form name=\"form1\" action=\"listadomateriasnotascorteconglomerado.php\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\" id='tabla'>";

 	$formulario->dibujar_fila_titulo('ESTADISTICAS  CORTES DE NOTAS','labelresaltado',"2","align='center'");


	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica f","codigomodalidadacademica","nombremodalidadacademica","");
	$formulario->filatmp["todos"]="*Todos*";
	$formulario->filatmp[""]="Seleccionar";
	$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_POST['codigomodalidadacademica']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','');

	//$codigofacultad="05";
	$condicion="c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
				order by c.nombrecarrera";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion,'',0);
	$formulario->filatmp["todos"]="*Todos*";
	$formulario->filatmp[""]="Seleccionar";
	$campo='menu_fila'; $parametros="'codigocarrera','".$_POST['codigocarrera']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','');



	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo","codigoperiodo=codigoperiodo order by codigoperiodo desc");
	$codigoperiodo=$_SESSION['codigoperiodosesion'];
	if(isset($_POST['codigoperiodo']))
	$codigoperiodo=$_POST['codigoperiodo'];
	if(isset($_GET['codigoperiodo']))
	$codigoperiodo=$_GET['codigoperiodo'];
	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');



	for($i=1;$i<16;$i++){
		$formulario->filatmp["$i"]="$i";
	}
		$formulario->filatmp["todos"]="*Todos*";

	$numerocorte=$_POST['semestreestudiante'];
	$campo='menu_fila'; $parametros="'semestreestudiante','".$semestreestudiante."',''";
	$formulario->dibujar_campo($campo,$parametros,"Semestre del estudiante","tdtitulogris",'semestreestudiante','');
	unset($formulario->filatmp);

	$formulario->filatmp["1"]="1";
	$formulario->filatmp["2"]="2";
	$formulario->filatmp["3"]="3";
	$formulario->filatmp["4"]="4";
	$formulario->filatmp["5"]="5";
	$numerocorte=$_POST['numerocorte'];
	$campo='menu_fila'; $parametros="'numerocorte','".$numerocorte."',''";
	$formulario->dibujar_campo($campo,$parametros,"Corte","tdtitulogris",'numerocorte','');



	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar',''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

?>
<?php
/*@modified Diego Rivera<riveradiego@unbosque.edu.co>
 *Se creaan funsiones javascript con el fin de ocultar formulario mientras carga reporte
 *@since november 27,2018 
 */
?>
<script type="text/javascript">
    function changeClass( )
    {
     document.getElementById("tabla").style.display='none';
     document.getElementById("loader").style.display='block';

    }
     window.onload = function( )
    {
        document.getElementById("Enviar").addEventListener( 'click' , changeClass );
    }
</script>
<div id="loader" style="text-align:center;display:none">
    <img src="../../../../assets/ejemplos/img/Procesando.gif">
</div>