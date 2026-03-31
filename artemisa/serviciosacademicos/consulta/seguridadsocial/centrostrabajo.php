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
<form name="form1" action="centrostrabajo.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		$formulario->dibujar_fila_titulo('Administracion centros de trabajo','labelresaltado');
		
		if(isset($_GET['idcentrotrabajoarp'])){
		$datoscentrotrabajo=$objetobase->recuperar_datos_tabla("centrotrabajoarp","idcentrotrabajoarp",$_GET['idcentrotrabajoarp'],'','',0);
		$nombrecentrotrabajo=$datoscentrotrabajo['nombrecentrotrabajoarp'];
		$porcentajecotizacion=$datoscentrotrabajo['porcentajecotizacionarp'];
		$salario=$datoscentrotrabajo['salariobasecotizacioncentrotrabajoarp'];
		$fechainicio=formato_fecha_defecto($datoscentrotrabajo['fechainiciocentrotrabajoarp']);
		$fechafinal=formato_fecha_defecto($datoscentrotrabajo['fechafinalcentrotrabajoarp']);
		$codigocentrotrabajoarp=$datoscentrotrabajo['codigocentrotrabajoarp'];
 		}		
		else{
		$fechainicio=date("d/m/Y");
		}

		$parametroboton="'text','nombrecentrotrabajo','".$nombrecentrotrabajo."'";
		$boton='boton_tipo';
		$formulario->dibujar_campo($boton,$parametroboton,"Nombre Centro de trabajo","tdtitulogris",'nombrecentrotrabajo','requerido');
		
		$parametroboton="'text','porcentajecotizacion','".$porcentajecotizacion."'";
		$boton='boton_tipo';
		$formulario->dibujar_campo($boton,$parametroboton,"Porcentaje de cotizacion","tdtitulogris",'porcentajecotizacion','requerido');

		$parametroboton="'text','salario','".$salario."'";
		$boton='boton_tipo';
		$formulario->dibujar_campo($boton,$parametroboton,"Salario","tdtitulogris",'salario','requerido');
		
		$campo = "campo_fecha"; $parametros ="'text','fechainicio','".$fechainicio."','onKeyUp = \"this.value=formateafecha(this.value);\"'";
		$formulario->dibujar_campo($campo,$parametros,"Fecha de inicio","tdtitulogris",'fechainicio','requerido');
		$campo = "campo_fecha"; $parametros ="'text','fechafinal','".$fechafinal."','onKeyUp = \"this.value=formateafecha(this.value);\"'";
		$formulario->dibujar_campo($campo,$parametros,"Fecha de final","tdtitulogris",'fechafinal','requerido');
		
		$parametroboton="'text','codigocentrotrabajoarp','".$codigocentrotrabajoarp."','maxlength=\"2\" size=\"2\"'";
		$boton='boton_tipo';
		$formulario->dibujar_campo($boton,$parametroboton,"Codigo centrotrabajo","tdtitulogris",'codigocentrotrabajoarp','requerido');


				  $fechaingreso=date("d/m/Y");
				  $formulario->boton_tipo('hidden','fechaingreso',$fechaingreso);
		$conboton=0;
		
		if(isset($_GET['idcentrotrabajoarp'])){
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$botones[$conboton]='boton_tipo';
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					$botones[$conboton]='boton_tipo';
					$conboton++;
					$formulario->boton_tipo('hidden','idcentrotrabajoarp',$_GET['idcentrotrabajoarp']);

					}
		else{
							$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
							$botones[$conboton]='boton_tipo';
				$conboton++;					
		}

						$parametrobotonenviar[$conboton]="'Listado','listadocentrotrabajo.php','',700,300,300,150,'yes','yes','yes','yes','yes'";
						$botones[$conboton]='boton_ventana_emergente';
						$conboton++;
				//	}
						$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
						$botones[$conboton]='boton_tipo';
						$formulario->dibujar_campos($botones,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);


	if(isset($_REQUEST['Enviar'])){
		if($formulario->valida_formulario()){
			if(validar_diferencia_fechas($_POST['fechainicio'],$_POST['fechafinal'])){
			//$formulario->valida_formulario();
				$tabla="centrotrabajoarp";
				$fila['codigocentrotrabajoarp']=$_POST['codigocentrotrabajoarp'];
				$fila['nombrecentrotrabajoarp']=$_POST['nombrecentrotrabajo'];
				$fila['fechacentrotrabajoarp']=formato_fecha_mysql($_POST['fechaingreso']);
				$fila['porcentajecotizacionarp']=$_POST['porcentajecotizacion'];	
				$fila['salariobasecotizacioncentrotrabajoarp']=$_POST['salario'];	
				$fila['fechainiciocentrotrabajoarp']=formato_fecha_mysql($_POST['fechainicio']);
				$fila['fechafinalcentrotrabajoarp']=formato_fecha_mysql($_POST['fechafinal']);
				$fila['codigoestado']=100;
				$objetobase->insertar_fila_bd($tabla,$fila);
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
			}
			else
			{
				alerta_javascript("fecha de inicio <".$_POST['fechainicio']."> no puede ser \\n mayor o igual a la fecha final <".$_POST['fechafinal'].">"); 
			}
		}
		
	}
	if(isset($_REQUEST['Modificar'])){
		if($formulario->valida_formulario()){
			if(validar_diferencia_fechas($_POST['fechainicio'],$_POST['fechafinal'])){
				$tabla="centrotrabajoarp";
				$idtabla=$_POST['idcentrotrabajoarp'];
				$nombreidtabla="idcentrotrabajoarp";
				$fila['codigocentrotrabajoarp']=$_POST['codigocentrotrabajoarp'];
				$fila['nombrecentrotrabajoarp']=$_POST['nombrecentrotrabajo'];
				//$fila['fechacentrotrabajoarp']=$_POST['fechaingreso'];
				$fila['porcentajecotizacionarp']=$_POST['porcentajecotizacion'];	
				$fila['salariobasecotizacioncentrotrabajoarp']=$_POST['salario'];	
				$fila['fechainiciocentrotrabajoarp']=formato_fecha_mysql($_POST['fechainicio']);
				$fila['fechafinalcentrotrabajoarp']=formato_fecha_mysql($_POST['fechafinal']);
				$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
			}
			else
			{
				alerta_javascript("fecha de inicio <".$_POST['fechainicio']."> no puede ser \\n mayor o igual a la fecha final <".$_POST['fechafinal'].">"); 
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
			}
		}
	}
	if(isset($_REQUEST['Anular'])){
		if($formulario->valida_formulario()){
			$formulario->valida_formulario();
			$tabla="centrotrabajoarp";
			$nombreidtabla="idcentrotrabajoarp";
			$idtabla=$_POST['idcentrotrabajoarp'];
			$fila['codigoestado']=200;
			$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
		}
	}
	

?>

	
  </table>
</form>