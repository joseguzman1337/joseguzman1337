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
function recuperarregistrogradoantiguo($tabla,$nombreidtabla,$idtabla,$objetobase,$formulario){
			unset($fila);
			$condicion="and rg.idciudadregistrograduadoantiguo=c.idciudad
						and ca.codigocarrera=rg.codigocarrera";
			$datosregistrogrado=$objetobase->recuperar_datos_tabla("$tabla rg,ciudad c,carrera ca",$nombreidtabla,$idtabla,$condicion,'',0);
			$formulario->dibujar_fila_titulo('Registro de Grado Antiguo','labelresaltado',4);
			$fila["Nombre_del_Egresado"]=$datosregistrogrado["nombreregistrograduadoantiguo"];
			$fila["Documento_del_Egresado"]=$datosregistrogrado["documentoegresadoregistrograduadoantiguo"];
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=2','colspan=2');
			unset($fila);
			$fila["Codigo_de_Estudiante"]=$datosregistrogrado["codigoestudiante"];
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=4','colspan=4');

			unset($fila);
			$fila["Ciudad_del_Registro"]=$datosregistrogrado["nombrecortociudad"];
			$fila["Area_de_Conocimiento"]=$datosregistrogrado["areaconocimientoregistrograduadoantiguo"];
			$fila["Fecha_del_Grado"]=formato_fecha_defecto($datosregistrogrado["fechagradoregistrograduadoantiguo"]);
			$fila["Fecha_del_Acta"]=formato_fecha_defecto($datosregistrogrado["fechaactaregistrograduadoantiguo"]);

			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
			unset($fila);
			$fila["Numero_de_Folio"]=$datosregistrogrado["numerofolioregistrograduadoantiguo"];
			$fila["Numero_del_Libro"]=$datosregistrogrado["numerolibroregistrograduadoantiguo"];
			$fila["Numero_del_Registro"]=$datosregistrogrado["numerodiplomaregistrograduadoantiguo"];
			$fila["Numero_del_Acta"]=$datosregistrogrado["numeroactaregistrograduadoantiguo"];
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
			unset($fila);
			$fila["Metodologia"]=$datosregistrogrado["metodologiaregistrograduadoantiguo"];
			$fila["Titulo"]=$datosregistrogrado["tituloregistrograduadoantiguo"];
			$fila["Carrera"]=$datosregistrogrado["nombrecortocarrera"];
			$fila["Modalidad"]=$datosregistrogrado["modalidadregistrograduadoantiguo"];
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);

}
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
	location.href="<?php echo '../../../prematricula/matriculaautomaticaordenmatricula.php';?>";
}
function enviarregistro(numerolog){
	form1.action="consulta.php?codigoestudiante=<?php echo $_GET['codigoestudiante'] ?>&numerolog="+numerolog+"#"+numerolog;
	form1.submit();
}

//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
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
$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
?>

<form name="form1" action="consulta.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		if(isset($_GET["numerolog"]))
			if($_SESSION["logssesion"][$_GET["numerolog"]])
				$_SESSION["logssesion"][$_GET["numerolog"]]=0;
			else
				$_SESSION["logssesion"][$_GET["numerolog"]]=1;

		
		$condicion="and e.idestudiantegeneral=eg.idestudiantegeneral";

		$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e, estudiantegeneral eg","e.codigoestudiante",$_GET['codigoestudiante'],$condicion,'',0);
		$condicion="and rg.idciudadregistrograduadoantiguo=c.idciudad
					and ca.codigocarrera=rg.codigocarrera
					order by idregistrograduadoantiguo";

		$formulario->dibujar_fila_titulo("Registro Graduado Antiguo de ".$datosestudiante['apellidosestudiantegeneral']." ".$datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['numerodocumento']."",'labelresaltado',"4","align='center'");

		$operacion=$objetobase->recuperar_resultado_tabla("registrograduadoantiguo rg,ciudad c,carrera ca","documentoegresadoregistrograduadoantiguo",$datosestudiante['numerodocumento'],$condicion,'',0);
		//echo $operacion->_numOfRows;
		//print_r($operacion);
		if($operacion->_numOfRows>0){
		while($row_operacion=$operacion->fetchRow()){
						$i++;
						$mensaje="Mostrar >>>";
						if($_SESSION["logssesion"][$row_operacion["idregistrograduadoantiguo"]])
						$mensaje="Ocultar <<<";
						$campo="boton_tipo"; $parametros="'button','logregistro$i','".$mensaje."','onclick=enviarregistro(".$row_operacion["idregistrograduadoantiguo"].")'";
						$formulario->dibujar_campo($campo,$parametros,"<a name='".$row_operacion["idregistrograduadoantiguo"]."'>Registro de grado $i</a>","tdtitulogris",'fechafinal','',0,'colspan=2');
				if($_SESSION["logssesion"][$row_operacion["idregistrograduadoantiguo"]])
				recuperarregistrogradoantiguo("registrograduadoantiguo","idregistrograduadoantiguo",$row_operacion['idregistrograduadoantiguo'],$objetobase,$formulario);
			}
		}
		else{
		alerta_javascript("Este estudiante No tiene Registro de Graduado Antiguo");
		//header("location: matriculaautomaticaordenmatricula.php");
		echo "<script LANGUAGE='JavaScript'>
		regresarGET();
		</script>";

		}
		echo "<tr><td colspan=4>";
		$formulario->boton_tipo('button','Regresar','Regresar','onclick=\'regresarGET();\'');
		echo "</tr></td>";
?>
  </table>
</form>