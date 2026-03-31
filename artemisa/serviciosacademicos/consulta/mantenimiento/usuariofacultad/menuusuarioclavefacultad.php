<?php
session_start();
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

</script>

<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once('../../../funciones/sala_genericas/FuncionesFecha.php');
require_once('../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once('../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
//require_once('../../../funciones/clases/autenticacion/redirect.php');

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$usuario=$formulario->datos_usuario();



echo "<form name='form1' action='listadousuarioclavefacultad.php' method='POST' >
<input type='hidden' name='AnularOK' value=''>
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>
	"; 
	
			$formulario->dibujar_fila_titulo('LISTADO USUARIO CLAVE','labelresaltado');

			$condicion="";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica m","m.codigomodalidadacademica","m.nombremodalidadacademica",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_POST['codigomodalidadacademica']."','onchange=enviarmodalidad();'";
		$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','requerido');		
		$usuariosadministradores=array("admintecnologia","seguraedgar","campuzanosandra");

			if(in_array($_SESSION["MM_Username"],$usuariosadministradores)){
				$condicion=" codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
							and now()  between fechainiciocarrera and fechavencimientocarrera
							order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
			}
			else{
				$condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
			}

			$campo='menu_fila'; $parametros="'codigocarrera','".$_POST['codigocarrera']."','onchange=enviar();'";
			$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido');		

	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo","codigoperiodo=codigoperiodo order by codigoperiodo desc");
	$codigoperiodo=$_SESSION['codigoperiodosesion'];
	if(isset($_POST['codigoperiodo']))
	$codigoperiodo=$_POST['codigoperiodo'];
	if(isset($_GET['codigoperiodo']))
	$codigoperiodo=$_GET['codigoperiodo'];	
	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
	$formulario->dibujar_campo($campo,$parametros,"Periodo de Ingreso  de los estudiantes","tdtitulogris",'codigoperiodo','');

	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar',' onclick=\'enviartarget();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
	
echo "</table></form>";
?>