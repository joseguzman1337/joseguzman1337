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
<form name="form1" action="asignacioncentrotrabajo.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		$formulario->dibujar_fila_titulo('Asignacion Centros de Trabajo','labelresaltado');
		
		
		if(isset($_GET['idcarreracentrotrabajo'])){
		$datoscarreracentrotrabajo=$objetobase->recuperar_datos_tabla("carreracentrotrabajoarp","idcarreracentrotrabajo",$_GET['idcarreracentrotrabajo'],' and codigoestado like \'1%\'','',0);
		$idcarreracentrotrabajoarp=$datoscarreracentrotrabajo['idcarreracentrotrabajoarp'];
		$idcentrotrabajoarp=$datoscarreracentrotrabajo['idcentrotrabajoarp'];
		$codigocarrera=$datoscarreracentrotrabajo['codigocarrera'];
	  	$fechainicio=date("d/m/Y");
 		}		
		else{
		$idnovedadarp=$_POST['idnovedadarp'];
		$fechaingreso=date("d/m/Y");
		$fechafinal="01/01/2099";
		$fechaingreso=date("d/m/Y");
		$codigocarrera=$_POST["codigocarrera"];
		if(isset($_POST['fechainicio']))
		$fechainicio=$_POST['fechainicio'];
		else
		$fechainicio=date("d/m/Y");
		}

		$campo = "campo_fecha"; $parametros ="'text','fechainicio','".$fechainicio."','onKeyUp = \"this.value=formateafecha(this.value);\"'";
		$formulario->dibujar_campo($campo,$parametros,"Fecha de inicio","tdtitulogris",'fechainicio','requerido');

		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo");
		$codigoperiodo=$_SESSION['codigoperiodosesion'];
		if(isset($_POST['codigoperiodo']))
		$codigoperiodo=$_POST['codigoperiodo'];
		$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
		$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','requerido');

		$condicion="c.codigomodalidadacademica=300";
		if(!isset($_GET['idcarreracentrotrabajo']))
		$condicion.=" and c.codigocarrera not in (select c.codigocarrera from carrera c, carreracentrotrabajoarp cc, centrotrabajoarp ct where
					 c.codigocarrera=cc.codigocarrera and
					 cc.codigoestado like '1%' and 
					 cc.idcentrotrabajoarp=ct.idcentrotrabajoarp and
					 (NOW() between ct.fechainiciocentrotrabajoarp and fechafinalcentrotrabajoarp))
					 order by nombrecarrera2";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","c.codigocarrera","c.nombrecarrera",$condicion,', replace(c.nombrecarrera,\' \',\'\') nombrecarrera2');
		$formulario->filatmp[""]="Seleccionar";
		$menu="menu_fila"; $parametros="'codigocarrera','".$codigocarrera."','onchange=\'enviar();\''";
		$formulario->dibujar_campo($menu,$parametros,"Carrera","tdtitulogris","codigocarrera",'requerido');
		
		if(isset($fechainicio)&&($fechainicio!='')){
		$condicion="codigoestado like '1%' and
					'".formato_fecha_mysql($fechainicio)."' between fechainiciocentrotrabajoarp and fechafinalcentrotrabajoarp";
  		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("centrotrabajoarp","idcentrotrabajoarp","CONCAT(nombrecentrotrabajoarp,'  ',porcentajecotizacionarp)",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$menu='menu_fila'; $parametros="'idcentrotrabajoarp','".$idcentrotrabajoarp."',''";
		}
		$formulario->dibujar_campo($menu,$parametros,"Centro de trabajo","tdtitulogris","idcentrotrabajoarp",'requerido');

				  $formulario->boton_tipo('hidden','fechaingreso',$fechaingreso);
	
				  $formulario->boton_tipo('hidden','fechafinal',$fechafinal);
		
		$conboton=0;
		if(isset($_GET['idcarreracentrotrabajo'])){
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$formulario->boton_tipo('hidden','idcarreracentrotrabajo',$_GET['idcarreracentrotrabajo']);

					}
		else{
				if(isset($_POST['codigocarrera'])&&$_POST['codigocarrera']!=''){
							$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
							$boton[$conboton]='boton_tipo';
						
		
				$conboton++;					
				}
		}

						$parametrobotonenviar[$conboton]="'Listado','listadocarreracentrotrabajo.php','',700,300,300,150,'yes','yes','yes','yes','yes'";
						$boton[$conboton]='boton_ventana_emergente';
						$conboton++;
						//$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
						//$boton[$conboton]='boton_tipo';
						$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');


	if(isset($_REQUEST['Enviar'])){
	$tabla="carreracentrotrabajoarp";
	$fila['idcentrotrabajoarp']=$_POST['idcentrotrabajoarp'];
	$fila['codigocarrera']=$_POST['codigocarrera'];
	$fila['codigoestado']=100;
	$condicionactualiza="idcentrotrabajoarp=".$fila['idcentrotrabajoarp'].
						" and codigocarrera='".$fila['codigocarrera'].
						"' and codigoestado='".$fila['codigoestado'].
	$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";

	}
	if(isset($_REQUEST['Modificar'])){
	$tabla="carreracentrotrabajoarp";
	$nombreidtabla="idcarreracentrotrabajo";
	$idtabla=$_POST['idcarreracentrotrabajo'];
	$fila['idcentrotrabajoarp']=$_POST['idcentrotrabajoarp'];
	$fila['codigocarrera']=$_POST['codigocarrera'];
	$fila['codigoestado']=100;
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0' target='_parent'>";
	}
	if(isset($_REQUEST['Anular'])){
	$tabla="carreracentrotrabajoarp";
	$nombreidtabla="idcarreracentrotrabajo";
	$idtabla=$_POST['idcarreracentrotrabajo'];
	$fila['codigoestado']=200;
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
	}

	?>

	
  </table>
</form>