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
require_once("funciones/FuncionesAportes.php");

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
	document.location.href="<?php echo 'menuinicialaportes.php';?>";
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
<form name="form1" action="detalleproceso.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		if(isset($_GET['iddetalleproceso'])){
		$datosdetalleproceso=$objetobase->recuperar_datos_tabla("detalleproceso","iddetalleproceso",$_GET['iddetalleproceso'],'','',0);
		$_POST['mescierre']=$datosdetalleproceso['nombredetalleproceso'];
 		}		

		$formulario->dibujar_fila_titulo('Activar-Desactivar nuevo mes de cotizacion','labelresaltado');
		
		$mesinicial["mes"]="01"; $mesinicial["anio"]=date("Y")-2;
			$mesfinal["mes"]="12";  $mesfinal["anio"]=date("Y")+1;
			$meshoy=date("m")."/".date("Y");
			$formulario->filatmp=meses_anios($mesinicial,$mesfinal);
			if(isset($_POST['mescierre']))
			$meshoy=$_POST['mescierre'];
			$campo='menu_fila'; $parametros="'mescierre','".$meshoy."','onchange=\'form1.submit();\''";
			$formulario->dibujar_campo($campo,$parametros,"Mes de cierre","tdtitulogris",'mescierre','');
		
		if(isset($_POST['mescierre']))
		$datosdetalleproceso=$objetobase->recuperar_datos_tabla("detalleproceso","nombredetalleproceso",$_POST['mescierre'],'','',0);
		else
		$datosdetalleproceso=$objetobase->recuperar_datos_tabla("detalleproceso","nombredetalleproceso",$meshoy,'','',0);
		

		if($datosdetalleproceso['codigoestado']=='100') $checked="checked"; else $checked="";
		$parametros="'checkbox','Estado','1','$checked'";
		$campo='boton_tipo';
		$formulario->dibujar_campo($campo,$parametros,"Pago de EPS","tdtitulogris",'pagoeps');
	
		
		$conboton=0;
		if(isset($_GET['iddetalleproceso'])){
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$formulario->boton_tipo('hidden','iddetalleproceso',$_GET['iddetalleproceso']);
		}
		else{
							$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
							$boton[$conboton]='boton_tipo';
		$conboton++;
		}					
		$parametrobotonenviar[$conboton]="'Listado','listadodetalleproceso.php','',700,300,300,150,'yes','yes','yes','yes','yes'";
		$boton[$conboton]='boton_ventana_emergente';
		$conboton++;
		$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';

		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

			


	if(isset($_REQUEST['Enviar'])){
		$tabla="detalleproceso";
		$fila["fechainiciodetalleproceso"]=formato_fecha_mysql("01/".$_POST['mescierre']);
		$fila["fechafinaldetalleproceso"]=formato_fecha_mysql(final_mes_fecha("01/".$_POST['mescierre']));
		$fila["nombredetalleproceso"]=$_POST['mescierre'];
		$fila["fechadetalleproceso"]=formato_fecha_mysql(date("d/m/Y"));
		$fila["idproceso"]=4;
		$fila["idtiposubperiodo"]=5;
		if($_POST["Estado"])
		$fila["codigoestado"]=100;
		else
		$fila["codigoestado"]=200;
		if(isset($usuario["idusuario"])&&$usuario["idusuario"]!="")
		$fila["idusuario"]=$usuario["idusuario"];
		else
		$fila["idusuario"]=1;
		$condicionactualiza="fechainiciodetalleproceso='".$fila["fechainiciodetalleproceso"].
							"' and fechafinaldetalleproceso='".$fila["fechafinaldetalleproceso"].
							"' and idproceso=".$fila["idproceso"].
							" and nombredetalleproceso='".$fila["nombredetalleproceso"]."'";
		$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";

	}
	if(isset($_REQUEST['Modificar'])){
		$tabla="detalleproceso";
		$nombreidtabla="iddetalleproceso";
		$idtabla=$_POST['iddetalleproceso'];
		if($_POST["Estado"])
		$fila["codigoestado"]=100;
		else
		$fila["codigoestado"]=200;
		$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=detalleproceso.php'>";


	}	
?>

	
  </table>
</form>