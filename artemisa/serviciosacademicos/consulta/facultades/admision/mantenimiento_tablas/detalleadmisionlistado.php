<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
session_start();
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
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
	parent.location.href="<?php echo 'menuinicialaportes.php';?>";
}
function enviarchg(){
	var obj=document.getElementById("iddetalleadmision");
	var idadmision=document.getElementById("idadmision").value;
	form1.action="detalleadmisionlistado.php?iddetalleadmision="+obj.value+"&idadmision="+idadmision;
	//alert(obj.value);
	selected=obj.options[obj.selectedIndex].value;
	//alert(selected);
	obj.value=selected;
	form1.submit();
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
<form name="form1" action="detalleadmisionlistado.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		$formulario->dibujar_fila_titulo('Configuración listado de prueba','labelresaltado');
		
		if(isset($_GET['iddetalleadmisionlistado']))
		{
		$datosdetalleadmisionlistado=$objetobase->recuperar_datos_tabla("detalleadmisionlistado","iddetalleadmisionlistado",$_GET['iddetalleadmisionlistado'],'','',0);
		$iddetalleadmision=$datosdetalleadmisionlistado['iddetalleadmision'];
		$codigoestadoestudianteadmision=$datosdetalleadmisionlistado['codigoestadoestudianteadmision'];
		$titulo=$datosdetalleadmisionlistado['titulodetalleadmisionlistado'];
		$fechainicio=formato_fecha_defecto($datosdetalleadmisionlistado['fechainiciodetalleadmisionlistado']);
		$fechafinal=formato_fecha_defecto($datosdetalleadmisionlistado['fechavencimientodetalleadmisionlistado']);
		$iddetalleadmisionlistado=$datosdetalleadmisionlistado['iddetalleadmisionlistado'];
		$horainiciov=explode(" ",$datosdetalleadmisionlistado['fechainiciodetalleadmisionlistado']);
		$horafinalv=explode(" ",$datosdetalleadmisionlistado['fechavencimientodetalleadmisionlistado']);
		$horainicio=$horainiciov[1];
		$horafinal=$horafinalv[1];
		$datosdetalleadmision=$objetobase->recuperar_datos_tabla("detalleadmision","iddetalleadmision",$iddetalleadmision,'','',0);
		$idadmision=$datosdetalleadmision['idadmision'];
		$deshabilitar="disabled"; 
		//alerta_javascript("detalle_admision escogido=".$iddetalleadmision);
		}		
		else{
		$fechainicio=date("d/m/Y");
		$horainicio='00:00:00';
		$horafinal='00:00:00';
		$idadmision=$_GET['idadmision'];
		//$iddetalleadmision=$_GET['idadmision'];
			/*if(isset($_POST['idadmision'])&&trim($_POST['idadmision'])!=''){
				$idadmision=$_POST['idadmision'];				
			}*/

		}
		if(isset($_POST['iddetalleadmision'])&&trim($_POST['iddetalleadmision'])!='')
		{
			$iddetalleadmision=$_POST['iddetalleadmision'];
		}
		if(isset($_GET['iddetalleadmision'])&&trim($_GET['iddetalleadmision'])!='')
		{
			$iddetalleadmision=$_GET['iddetalleadmision'];
		}
		
		$condicion="da.codigotipodetalleadmision=ctda.codigotipodetalleadmision
		AND da.codigorequierepreselecciondetalleadmision=rqps.codigorequierepreselecciondetalleadmision
		AND da.idadmision='".$idadmision."'
		AND da.codigoestado=100";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("detalleadmision da, tipodetalleadmision ctda, requierepreselecciondetalleadmision rqps","da.iddetalleadmision","da.nombredetalleadmision",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$menu="menu_fila"; $parametrosmenu="'iddetalleadmision','".$iddetalleadmision."','$deshabilitar onchange=enviarchg();'";
		$formulario->dibujar_campo($menu,$parametrosmenu,"Prueba del listado","tdtitulogris","codigoestadoestudianteadmision");
		$formulario->boton_tipo('hidden','idadmision',$idadmision);


		if(isset($iddetalleadmision)&&trim($iddetalleadmision)!=''){

		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estadoestudianteadmision","codigoestadoestudianteadmision","nombreestadoestudianteadmision","");
		$formulario->filatmp[""]="Seleccionar";
		$menu="menu_fila"; $parametrosmenu="'codigoestadoestudianteadmision','".$codigoestadoestudianteadmision."',''";
		$formulario->dibujar_campo($menu,$parametrosmenu,"Para los estudiantes con el estado","tdtitulogris","codigoestadoestudianteadmision");


		//$parametroboton="'text','titulo','".$titulo."'";
		//$boton='boton_tipo';
        $campo="memo"; $parametros="'titulo','detalleadmisionlistado',50,8,'','','',''";
		$formulario->dibujar_campo($campo,$parametros,"Titulo Prueba","tdtitulogris",'titulo','requerido');
		$titulo=quitarsaltolinea($titulo);
		$formulario->cambiar_valor_campo('titulo',$titulo);

		
		$campo1[0] = "campo_fecha"; $parametros1[0] ="'text','fechainicio','".$fechainicio."','onKeyUp = \"this.value=formateafecha(this.value);\"'";
		$campo1[1] = "boton_tipo"; $parametros1[1] ="'text','horainicio','".$horainicio."'";
		
		$formulario->dibujar_campos($campo1,$parametros1,"Fecha de inicio","tdtitulogris",'fechainicio','requerido');
		$campo2[0] = "campo_fecha"; $parametros2[0] ="'text','fechafinal','".$fechafinal."','onKeyUp = \"this.value=formateafecha(this.value);\"'";
		$campo2[1] = "boton_tipo"; $parametros2[1] ="'text','horafinal','".$horafinal."'";
		$formulario->dibujar_campos($campo2,$parametros2,"Fecha de final","tdtitulogris",'fechafinal','requerido');
		
		$formulario->boton_tipo('hidden','iddetalleadmision',$iddetalleadmision);


				  $fechaingreso=date("d/m/Y");
				  $formulario->boton_tipo('hidden','fechaingreso',$fechaingreso);
		$conboton=0;
		
		if(isset($_GET['iddetalleadmisionlistado'])){
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$botones[$conboton]='boton_tipo';
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					$botones[$conboton]='boton_tipo';
					$conboton++;
					$formulario->boton_tipo('hidden','iddetalleadmisionlistado',$_GET['iddetalleadmisionlistado']);

					}
		else{
							$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
							$botones[$conboton]='boton_tipo';
				$conboton++;					
		}

						$parametrobotonenviar[$conboton]="'Listado','listadocentrotrabajo.php','',700,300,300,150,'yes','yes','yes','yes','yes'";
						$botones[$conboton]='boton_ventana_emergente';
						//$conboton++;
				//	}
						//$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
						//$botones[$conboton]='boton_tipo';
						$formulario->dibujar_campos($botones,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);
	}

	if(isset($_REQUEST['Enviar'])){
		if($formulario->valida_formulario()){
			if(validar_diferencia_fechas($_POST['fechainicio'],$_POST['fechafinal'])){
					$tabla="detalleadmisionlistado";
					$fila["iddetalleadmision"]=$_POST['iddetalleadmision'];
					$fila["codigoestadoestudianteadmision"]=$_POST['codigoestadoestudianteadmision'];
					$fila["titulodetalleadmisionlistado"]=$_POST['titulo'];
					$fila["fechainiciodetalleadmisionlistado"]=formato_fecha_mysql($_POST['fechainicio'])." ".$_POST['horainicio'];
					$fila["fechavencimientodetalleadmisionlistado"]=formato_fecha_mysql($_POST['fechafinal'])." ".$_POST['horafinal'];
					$fila["codigoestado"]=100;
					$condicionactualiza="iddetalleadmision=".$fila["iddetalleadmision"].
										" and codigoestadoestudianteadmision='".$fila["codigoestadoestudianteadmision"]."'";
					$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
					echo "<script language='javascript'>window.opener.recargar();</script><script language='javascript'>window.close();</script>";
			}
			else
			{
				alerta_javascript("fecha de inicio <".$_POST['fechainicio']."> no puede ser \\n mayor o igual a la fecha final <".$_POST['fechafinal'].">"); 
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
			}
		}
		
	}
	if(isset($_REQUEST['Modificar'])){
		if($formulario->valida_formulario()){
			if(validar_diferencia_fechas($_POST['fechainicio'],$_POST['fechafinal'])){
					$tabla="detalleadmisionlistado";
					$idtabla=$_POST['iddetalleadmisionlistado'];
					$fila["codigoestadoestudianteadmision"]=$_POST['codigoestadoestudianteadmision'];
					$fila["titulodetalleadmisionlistado"]=$_POST['titulo'];
					$fila["fechainiciodetalleadmisionlistado"]=formato_fecha_mysql($_POST['fechainicio'])." ".$_POST['horainicio'];
					$fila["fechavencimientodetalleadmisionlistado"]=formato_fecha_mysql($_POST['fechafinal'])." ".$_POST['horafinal'];
					$fila["codigoestado"]=100;
					$objetobase->actualizar_fila_bd($tabla,$fila,'iddetalleadmisionlistado',$idtabla);
					echo "<script language='javascript'>window.opener.recargar();</script><script language='javascript'>window.close();</script>";

			
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
				$tabla="detalleadmisionlistado";
				$fila["codigoestado"]=200;
				$idtabla=$_POST['iddetalleadmisionlistado'];
				$objetobase->actualizar_fila_bd($tabla,$fila,'iddetalleadmisionlistado',$idtabla);
		}
	}
	

?>

	
  </table>
</form>