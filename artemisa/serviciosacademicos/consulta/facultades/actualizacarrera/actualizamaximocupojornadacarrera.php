<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
//session_start();
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
?>
<script LANGUAGE="JavaScript">
function regresarGET()
{
	//history.back();
	location.href="<?php echo '../../../prematricula/matriculaautomaticaordenmatricula.php';?>";
}
function enviarmodalidad(){
var codigocarrera=document.getElementById("codigocarrera");
//document.getElementById("tr0")
if(codigocarrera!=null)
codigocarrera.value="";
form1.submit();
}
//quitarFrame();
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
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
//$codigoperiodo=$formulario->carga_periodo(4);
//$formulario->agregar_tablas('estudiante','codigoestudiante');
$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
//print_r($usuario);
//echo "LINK_ORIGEN=".$_GET['link_origen'];
?>
<form name="form1" action="actualizamaximocupojornadacarrera.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php 
		if(!empty($_POST['codigocarrera'])){
			$condicion=" and (NOW() between fechadesdejornadacarrera and fechahastajornadacarrera)";
			$datosjornadacarrera=$objetobase->recuperar_datos_tabla("jornadacarrera jc","jc.codigocarrera",$_POST['codigocarrera'],$condicion,"",0);
			//echo "numerominimocreditos=".$datosjornadacarrera['numeromaximocreditosjornadacarrera']."<br>";
			//print_r($datosjornadacarrera);
			$idjornadacarrera=$datosjornadacarrera["idjornadacarrera"];
		}
		else
		{
			$idjornadacarrera=$_GET["idjornadacarrera"];
		}
				
		$postcodigocarrera=$_POST["codigocarrera"];
		//$condicion=" codigomodalidadacademica=".$_GET['codigomodalidadacademica']."";
		$formulario->dibujar_fila_titulo('Cambio maximo de creditos','labelresaltado');
		$condicion="";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica m","m.codigomodalidadacademica","m.nombremodalidadacademica",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_POST['codigomodalidadacademica']."','onchange=enviarmodalidad();'";
		$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','requerido');		
		if(!empty($_POST['codigomodalidadacademica'])){
			if($usuario["idusuario"]==4186){
				$condicion=" codigomodalidadacademica=".$_POST['codigomodalidadacademica']."";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion,"",0);
				$formulario->filatmp[""]="Seleccionar";
			}
			else{
				$condicion=" jc.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and c.codigomodalidadacademica=".$_POST['codigomodalidadacademica']."
					and c.codigocarrera=jc.codigocarrera";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, jornadacarrera jc,usuariofacultad uf, usuario u","jc.codigocarrera","jc.nombrejornadacarrera",$condicion,"",0);
				$formulario->filatmp[""]="Seleccionar";

			}
			$campo='menu_fila'; $parametros="'codigocarrera','".$postcodigocarrera."','onchange=enviar();'";
			$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido');		
		}
		if(!empty($_POST['codigocarrera'])&&trim($_POST['codigocarrera'])!='')
		{
			$campo='boton_tipo'; $parametros="'text','numerominimocreditos','".$datosjornadacarrera['numerominimocreditosjornadacarrera']."',''";
			$formulario->dibujar_campo($campo,$parametros,"Minimo de creditos","tdtitulogris",'numerominimocreditos','requerido');		
			$campo='boton_tipo'; $parametros="'text','numeromaximocreditos','".$datosjornadacarrera['numeromaximocreditosjornadacarrera']."',''";
			$formulario->dibujar_campo($campo,$parametros,"Maximo de creditos","tdtitulogris",'numeromaximocreditos','requerido');		
		
		$conboton=0;
			if(!empty($idjornadacarrera)){
						$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
						$boton[$conboton]='boton_tipo';
						$conboton++;
						$formulario->boton_tipo('hidden','idjornadacarrera',$idjornadacarrera);
			}
			else{
				$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar','onclick=\"return confirm(\'En realidad quiere guardar los cambios realizados\');\"'";
				$boton[$conboton]='boton_tipo';
				$conboton++;
			}
		}
		
		
		if(!empty($_POST['codigocarrera'])&&trim($_POST['codigocarrera'])!=''){
			$parametrobotonenviar[$conboton]="'Listado','listadohistorialjornadacarrera.php','codigocarrera=".$postcodigocarrera."',900,300,5,5,'yes','yes','no','yes','yes'";
			$boton[$conboton]='boton_ventana_emergente';
			$conboton++;
		}
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

if($_REQUEST['Enviar'])
{
	$fechahoy=date("Y-m-d H:i:s");
	$tabla="jornadacarrera";
	$nombreidtabla="idjornadacarrera";
	$idtabla=$_POST['idjornadacarrera'];
	unset($fila);
		$fila["fechadesdejornadacarrera"]=$fechahoy;
		$fila["fechajornadacarrera"]=$fechahoy;
		$fila["fechahastajornadacarrera"]="2999-12-31";
		$fila["nombrejornadacarrera"]=$datosjornadacarrera["nombrejornadacarrera"];
		$fila["codigocarrera"]=$_POST["codigocarrera"];
		$fila["codigojornada"]=$_POST["codigojornada"];
		$fila["numeromaximocreditosjornadacarrera"]=$_POST['numeromaximocreditos'];
		$fila["numerominimocreditosjornadacarrera"]=$_POST['numerominimocreditos'];	
		$condicion="fechajornadacarrera='".$fila["fechajornadacarrera"]."'".
				   " and fechadesdejornadacarrera='".$fila["fechadesdejornadacarrera"]."'".
				   " and codigocarrera=".$fila["codigocarrera"].
				   " and codigojornada=".$fila["codigojornada"].
				   " and numeromaximocreditosjornadacarrera=".$fila["numeromaximocreditosjornadacarrera"].
				   " and numerominimocreditosjornadacarrera=".$fila["numerominimocreditosjornadacarrera"];				   
	$objetobase->insertar_fila_bd($tabla,$fila,0,$condicion);
}
if($_REQUEST['Modificar'])
{
	$fechahoy=date("Y-m-d");
	$tabla="jornadacarrera";
	$nombreidtabla="codigocarrera";
	$idtabla=$_POST['codigocarrera'];
	//$condicion=" and (NOW() between fechadesdejornadacarrera and fechahastajornadacarrera)";
	unset($fila);
	$condicion="and ('".$fechahoy."' between fechadesdejornadacarrera and fechahastajornadacarrera)";
	$fila["fechahastajornadacarrera"]=$fechahoy;	
	
	
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,0);

	unset($fila);
		$fila["fechadesdejornadacarrera"]=$fechahoy;
		$fila["fechajornadacarrera"]=$fechahoy;
		$fila["fechahastajornadacarrera"]="2999-12-31";
		$fila["nombrejornadacarrera"]=$datosjornadacarrera["nombrejornadacarrera"];
		$fila["codigocarrera"]=$_POST["codigocarrera"];
		$fila["codigojornada"]=$datosjornadacarrera["codigojornada"];
		$fila["numeromaximocreditosjornadacarrera"]=$_POST['numeromaximocreditos'];
		$fila["numerominimocreditosjornadacarrera"]=$_POST['numerominimocreditos'];	
		$condicion="fechajornadacarrera='".$fila["fechajornadacarrera"]."'".
				   " and fechadesdejornadacarrera='".$fila["fechadesdejornadacarrera"]."'".
				   " and codigocarrera=".$fila["codigocarrera"].
				   " and codigojornada=".$fila["codigojornada"].
				   " and numeromaximocreditosjornadacarrera=".$fila["numeromaximocreditosjornadacarrera"].
				   " and numerominimocreditosjornadacarrera=".$fila["numerominimocreditosjornadacarrera"];				   
	$objetobase->insertar_fila_bd($tabla,$fila,0,$condicion);
}
?>
</table>
</form>