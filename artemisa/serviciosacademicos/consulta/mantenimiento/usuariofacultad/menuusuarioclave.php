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
require_once('../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once('../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
//require_once('../../../funciones/clases/autenticacion/redirect.php');
//unset($_SESSION);
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$usuario=$formulario->datos_usuario();



echo "<form name='form1' action='listadousuarioclave.php' method='POST' >
<input type='hidden' name='AnularOK' value=''>
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>
	"; 

$datoscarrera=$objetobase->recuperar_datos_tabla('carrera','codigocarrera',$_SESSION['codigofacultad'],"","",0);
	
			$formulario->dibujar_fila_titulo('CONSULTE USUARIO  DEL PROGRAMA   '.$datoscarrera['nombrecarrera'],'labelresaltado');

			$condicion="";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica m","m.codigomodalidadacademica","m.nombremodalidadacademica",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		//$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_POST['codigomodalidadacademica']."','onchange=enviarmodalidad();'";
		//$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','requerido');		


			if($_SESSION["MM_Username"]=="admintecnologia"){
				$condicion=" codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
							and now()  between fechainiciocarrera and fechavencimientocarrera
							order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
				
				$condicion="";

			}
			else{
				$condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
					and now()  between fechainiciocarrera and fechavencimientocarrera
					and uf.codigofacultad='".$_SESSION["codigofacultad"]."'
					order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";

				$condicion=" and idusuario in (select u.idusuario from estudiante e, estudiantegeneral eg, usuario u where e.idestudiantegeneral=eg.idestudiantegeneral and u.numerodocumento=eg.numerodocumento and 
				u.codigotipousuario=600
				and e.codigocarrera =".$_SESSION["codigofacultad"].")";
			}



			//$campo='menu_fila'; $parametros="'codigocarrera','".$_POST['codigocarrera']."','onchange=enviar();'";
			//$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido');		

		$tablas="usuario";
		$campollave="numerodocumento";
		$camponombre="numerodocumento";
		$funcionlink="";
		$nombrecampo="numerodocumento";
		$direccionsuggest="../../../funciones/sala_genericas/ajax/suggest/suggest.php?keyword=";
	//	$condicion=" and idusuario in (select u.idusuario from estudiante e, estudiantegeneral eg, usuario u where e.idestudiantegeneral=eg.idestudiantegeneral and u.numerodocumento=eg.numerodocumento and u.codigotipousuario='600' and e.codigocarrera ='".$_SESSION["codigofacultad"]."')";
		//$condicion='';
		$imprimir=0;

		$parametrobotonenviar2="'".$tablas."','".$campollave."','".$camponombre."','".$condicion."','".$valorcampo."','".$valorcamponombre."','".$nombrecampo."','".$direccionsuggest."','".$imprimir."'";
									//($tablas,    $campollave,     $camponombre,       $condicion,      $valorcampo,$valorcamponombre,$nombrecampo,$direccionsuggest,$imprimir=0){
		
		$boton2='campo_sugerido';
                $boton2='boton_tipo';
                $parametrobotonenviar2="'text','numerodocumento','',''";
		$formulario->dibujar_campo($boton2,$parametrobotonenviar2,"Numero Documento","tdtitulogris",'Enviar','numerodocumento',0);

	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar',' onclick=\'enviartarget();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
	
echo "</table></form>";
?>