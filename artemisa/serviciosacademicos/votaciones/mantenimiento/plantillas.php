<?php
session_start();
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
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>

<script LANGUAGE="JavaScript">
function regresarGET()
{
	//history.back();
	document.location.href="<?php echo 'menumantenimientovotaciones.php';?>";
}

</script>

<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();


?>
<form name="form1" action="plantillas.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">

	<?php 
		if(isset($_GET['idplantillavotacion'])){
		$datosplantillavotacion=$objetobase->recuperar_datos_tabla("plantillavotacion","idplantillavotacion",$_GET['idplantillavotacion'],'','',0);
		$idvotacion=$datosplantillavotacion['idvotacion'];
		$idtipoplantillavotacion=$datosplantillavotacion['idtipoplantillavotacion'];

		$datoscarrera=$objetobase->recuperar_datos_tabla("carrera c","c.codigocarrera",$datosplantillavotacion['codigocarrera'],$condicion,'',0);
		$codigomodalidadacademica=$datoscarrera["codigomodalidadacademica"];
		$codigocarrera=$datosplantillavotacion['codigocarrera'];
		$iddestinoplantillavotacion=$datosplantillavotacion['iddestinoplantillavotacion'];
		$nombreplantillavotacion=$datosplantillavotacion['nombreplantillavotacion'];
		$resumenplantillavotacion=$datosplantillavotacion['resumenplantillavotacion'];
 		}
		else{
		$idvotacion=$_POST['idvotacion'];
		$idtipoplantillavotacion=$_POST['idtipoplantillavotacion'];
		$codigomodalidadacademica=$_POST['codigomodalidadacademica'];
		}		

		$conboton=0;
			$formulario->dibujar_fila_titulo('Plantillas De votación','labelresaltado');
			$condicion=" codigoestado like '1%'";
			//'$fechahoy' < fechainiciovotacion	and
		if($formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("votacion","idvotacion","nombrevotacion",$condicion,"",0)){
			$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idvotacion','".$idvotacion."',''";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Votacion","tdtitulogris","idvotacion",'requerido');

			$condicion="";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoplantillavotacion","idtipoplantillavotacion","nombretipoplantillavotacion",$condicion,"",0);
			$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idtipoplantillavotacion','".$idtipoplantillavotacion."',''";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Tipos de plantilla","tdtitulogris","idtipoplantillavotacion",'requerido');

			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica","codigomodalidadacademica","nombremodalidadacademica");
			$formulario->filatmp[""]="Seleccionar";
			$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$codigomodalidadacademica."','onChange=\"form1.submit();\"'";
			$formulario->dibujar_campo($campo,$parametros,"Modalidad","tdtitulogris",'codigomodalidadacademica','requerido',0);

			if(isset($codigomodalidadacademica)&&$codigomodalidadacademica!=''){
			//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$REQUEST_URI.">";
			$condicion=" c.codigomodalidadacademica=".$codigomodalidadacademica.
						" ". 
					   " order by nombrecarrera2";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","c.codigocarrera","c.nombrecarrera",$condicion,', replace(c.nombrecarrera,\' \',\'\') nombrecarrera2');
			//$formulario->filatmp[""]="Seleccionar";
			$campo='menu_fila'; $parametros="'codigocarrera','".$codigocarrera."','onChange=\"enviarmenu(\'codigocarrera\');\"'";
			$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido','',1);


			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("destinoplantillavotacion","iddestinoplantillavotacion","nombredestinoplantillavotacion");
			//$formulario->filatmp[""]="Seleccionar";
			$campo='menu_fila'; $parametros="'iddestinoplantillavotacion','".$iddestinoplantillavotacion."',''";
			$formulario->dibujar_campo($campo,$parametros,"Modalidad","tdtitulogris",'codigomodalidadacademica','requerido',0);

			$campo="boton_tipo"; $parametros="'text','nombreplantillavotacion','".$nombreplantillavotacion."',''";
		  	$formulario->dibujar_campo($campo,$parametros,"Nombre de la plantilla","tdtitulogris",'nombreplantillavotacion','requerido');

			$campo="memo"; $parametros="'resumenplantillavotacion','estudiantenovedadarp',70,8,'','','',''";
		    $formulario->dibujar_campo($campo,$parametros,"Observacion","tdtitulogris",'resumenplantillavotacion');
			$formulario->cambiar_valor_campo('resumenplantillavotacion',$resumenplantillavotacion);

				if(isset($_GET['idplantillavotacion'])){
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$boton[$conboton]='boton_tipo';
					$formulario->boton_tipo('hidden','idplantillavotacion',$_GET['idplantillavotacion']);
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					$boton[$conboton]='boton_tipo';
					$conboton++;


				}
				else{
					$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
				}
				

			}
		}
		else{
			$formulario->dibujar_fila_titulo('No Hay Votaciones Vigentes','labelresaltado');
		}
					

		$parametrobotonenviar[$conboton]="'Listado','listadoplantillavotacion.php','codigoperiodo=".$codigoperiodo."&link_origen= ".$_GET['link_origen']."',700,600,5,50,'yes','yes','no','yes','yes'";
		$boton[$conboton]='boton_ventana_emergente';
		$conboton++;
		$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);


if(isset($_REQUEST['Enviar'])){
			if($formulario->valida_formulario()){
			$tabla="plantillavotacion";
			$fila['idtipoplantillavotacion']=$_POST['idtipoplantillavotacion'];
			$fila['idvotacion']=$_POST['idvotacion'];
			$fila['codigoestado']=100;
			$fila['resumenplantillavotacion']=$_POST['resumenplantillavotacion'];
			$fila['codigocarrera']=$_POST['codigocarrera'];
			$fila['nombreplantillavotacion']=$_POST['nombreplantillavotacion'];
			$fila['iddestinoplantillavotacion']=$_POST['iddestinoplantillavotacion'];
			$condicionactualiza=" idtipoplantillavotacion=".$fila['idtipoplantillavotacion'].
								" and idvotacion=".$fila['idvotacion'].
								" and codigocarrera=".$fila['codigocarrera'].
								" and nombreplantillavotacion='".$fila['nombreplantillavotacion']."'";
			$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";

			}
}		
if(isset($_REQUEST['Modificar'])){
	if($formulario->valida_formulario()){
	$tabla="plantillavotacion";
	$nombreidtabla="idplantillavotacion";
	$idtabla=$_POST['idplantillavotacion'];
			$fila['idtipoplantillavotacion']=$_POST['idtipoplantillavotacion'];
			$fila['idvotacion']=$_POST['idvotacion'];
			//$fila['codigoestado']=100;
			$fila['resumenplantillavotacion']=$_POST['resumenplantillavotacion'];
			$fila['codigocarrera']=$_POST['codigocarrera'];
			$fila['nombreplantillavotacion']=$_POST['nombreplantillavotacion'];
			$fila['iddestinoplantillavotacion']=$_POST['iddestinoplantillavotacion'];
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";

	}
}
if(isset($_REQUEST['Anular'])){
	$tabla="plantillavotacion";
	$fila['codigoestado']=200;
	$nombreidtabla="idplantillavotacion";
	$idtabla=$_POST['idplantillavotacion'];
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";

}		


	?>

  </table>
</form>
