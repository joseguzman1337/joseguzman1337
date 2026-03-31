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
<script type="text/javascript" src="../../funciones/sala_genericas/funciones_javascript.js"></script>
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
<form name="form1" action="detalleplantillavotacion.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="80%" align="center">
<?php

		$fechainscripcioncandidatodetalleplantillavotacion=date("d/m/Y");
		if(isset($_GET['iddetalleplantillavotacion'])){
		$datos=$objetobase->recuperar_datos_tabla("detalleplantillavotacion","iddetalleplantillavotacion",$_GET['iddetalleplantillavotacion'],'','',0);
		$condicion="and tp.idplantillavotacion=p.idplantillavotacion";
		$datostipoplantillavotacion=$objetobase->recuperar_datos_tabla("detalleplantillavotacion tp, plantillavotacion p","tp.iddetalleplantillavotacion",$_GET['iddetalleplantillavotacion'],$condicion,', p.idtipoplantillavotacion idtipo',0);
		$idtipoplantillavotacion=$datostipoplantillavotacion['idtipo'];
		$idplantillavotacion=$datos['idplantillavotacion'];
		$idcandidatovotacion=$datos['idcandidatovotacion'];
		$datoscandidatovotacion=$objetobase->recuperar_datos_tabla("candidatovotacion c","idcandidatovotacion",$idcandidatovotacion,'','',0);
		$idtipocandidatodetalleplantillavotacion=$datoscandidatovotacion['idtipocandidatodetalleplantillavotacion'];
		$fechainscripcioncandidatodetalleplantillavotacion=formato_fecha_defecto($datos['fechainscripcioncandidatodetalleplantillavotacion']);
		$resumenpropuestascandidatodetalleplantillavotacion=$datos['resumenpropuestascandidatodetalleplantillavotacion'];
		$datosplantillavotacion=$objetobase->recuperar_datos_tabla("plantillavotacion","iddetalleplantillavotacion",$idplantillavotacion,'','',0);
		$idvotacion=$datosplantillavotacion["idvotacion"];
		}
		else{
		$idtipoplantillavotacion=$_POST['idtipoplantillavotacion'];
		$idplantillavotacion=$_POST['idplantillavotacion'];
		$idtipocandidatodetalleplantillavotacion=$_POST['idtipocandidatodetalleplantillavotacion'];
		$idcandidatovotacion=$_POST['idcandidatovotacion'];
		//echo "idcandidatovotacion=".$idcandidatovotacion;

		if(isset($_POST['fechainscripcioncandidatodetalleplantillavotacion']))
		$fechainscripcioncandidatodetalleplantillavotacion=$_POST['fechainscripcioncandidatodetalleplantillavotacion'];
		$resumenpropuestascandidatodetalleplantillavotacion=$_POST['resumenpropuestascandidatodetalleplantillavotacion'];
		$idvotacion=$_POST["idvotacion"];

		}
			$conboton=0;
			$formulario->dibujar_fila_titulo('Inscripción de candidato','labelresaltado');

			$condicion="";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("votacion","idvotacion","nombrevotacion",$condicion,"",0);
			$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idvotacion','".$idvotacion."','onchange=form1.submit();'";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Tipos de plantilla","tdtitulogris","idvotacion",'requerido');


			$condicion="";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoplantillavotacion","idtipoplantillavotacion","nombretipoplantillavotacion",$condicion,"",0);
			$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idtipoplantillavotacion','".$idtipoplantillavotacion."','onchange=form1.submit();'";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Tipos de plantilla","tdtitulogris","idtipoplantillavotacion",'requerido');


			if(isset($idtipoplantillavotacion)&&$idtipoplantillavotacion!='')
			{
					$condicion="p.idtipoplantillavotacion=".$idtipoplantillavotacion."
								and p.idvotacion=v.idvotacion
								and v.codigoestado like '1%'
								and p.codigoestado like '1%'
								and v.idvotacion=".$idvotacion."";
//								and '$fechahoy' < v.fechainiciovotacion 

					if($formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("plantillavotacion p,votacion v","idplantillavotacion","nombreplantillavotacion",$condicion,"",0)){
						$formulario->filatmp[""]="Seleccionar";
						$menu="menu_fila"; $parametrosmenu="'idplantillavotacion','".$idplantillavotacion."','onchange=form1.submit();'";
						$formulario->dibujar_campo($menu,$parametrosmenu,"Plantillas","tdtitulogris","idplantillavotacion",'requerido');
	
	
						$condicion="";
						$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipocandidatodetalleplantillavotacion","idtipocandidatodetalleplantillavotacion","nombretipocandidatodetalleplantillavotacion",$condicion,"",0);
						$formulario->filatmp[""]="Seleccionar";
						$menu="menu_fila"; $parametrosmenu="'idtipocandidatodetalleplantillavotacion','".$idtipocandidatodetalleplantillavotacion."','onchange=form1.submit();'";
						$formulario->dibujar_campo($menu,$parametrosmenu,"Tipos de candidato","tdtitulogris","idtipocandidatodetalleplantillavotacion",'requerido');
			

						if(isset($idtipocandidatodetalleplantillavotacion)&&$idtipocandidatodetalleplantillavotacion!='')
						{
						
							$condicion="c.idtipocandidatodetalleplantillavotacion=".$idtipocandidatodetalleplantillavotacion.
										" and v.idvotacion = pv.idvotacion and
										pv.idvotacion=".$idvotacion." and 
										 dpv.idplantillavotacion=pv.idplantillavotacion and
										 dpv.idcandidatovotacion=c.idcandidatovotacion and
										 (NOW() between v.fechainiciovigenciacargoaspiracionvotacion and fechafinalvigenciacargoaspiracionvotacion)".
										" order by nombrecompleto";
							$tablas=" candidatovotacion c,detalleplantillavotacion dpv, plantillavotacion pv, votacion v";
							$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila($tablas,"c.idcandidatovotacion","CONCAT(apellidoscandidatovotacion,' ',nombrescandidatovotacion) nombrecompleto",$condicion,"",0,0);
							$formulario->filatmp[""]="Seleccionar";
							$menu="menu_fila"; $parametrosmenu="'idcandidatovotacion','".$idcandidatovotacion."','onchange=form1.submit();'";
							$formulario->dibujar_campo($menu,$parametrosmenu,"Candidato","tdtitulogris","idcandidatovotacion",'requerido');

							$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("cargo c","idcargo","nombrecargo",'codigoestado like \'1%\' order by prioridadcargo',"",0,1);
							//$formulario->filatmp[""]="Seleccionar";
							$menu="menu_fila"; $parametrosmenu="'idcargo','".$idcargo."',''";
							$formulario->dibujar_campo($menu,$parametrosmenu,"Cargo","tdtitulogris","idcargo",'requerido');
							
							$campo = "campo_fecha"; $parametros ="'text','fechainscripcioncandidatodetalleplantillavotacion','".$fechainscripcioncandidatodetalleplantillavotacion."','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
				  			$formulario->dibujar_campo($campo,$parametros,"Fecha de inscripcion","tdtitulogris",'fechainscripcioncandidatodetalleplantillavotacion','requerido');

							$campo="memo"; $parametros="'resumenpropuestascandidatodetalleplantillavotacion','estudiantenovedadarp',70,8,'','','',''";
							$formulario->dibujar_campo($campo,$parametros,"Observacion","tdtitulogris",'resumenpropuestascandidatodetalleplantillavotacion');
							$formulario->cambiar_valor_campo('resumenpropuestascandidatodetalleplantillavotacion',$resumenpropuestascandidatodetalleplantillavotacion);
							
							if(isset($_GET['iddetalleplantillavotacion'])){
								$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
								$boton[$conboton]='boton_tipo';
								$formulario->boton_tipo('hidden','iddetalleplantillavotacion',$_GET['iddetalleplantillavotacion']);
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
						$formulario->dibujar_fila_titulo('No Hay Plantillas en Votaciones Vigentes','labelresaltado');
					}
			}
			$parametrobotonenviar[$conboton]="'Listado','listadodetalleplantillavotacion.php','codigoperiodo=".$codigoperiodo."&link_origen= ".$_GET['link_origen']."',700,600,5,50,'yes','yes','no','yes','yes'";
			$boton[$conboton]='boton_ventana_emergente';
			$conboton++;
			$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
			$boton[$conboton]='boton_tipo';
			$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);

if(isset($_REQUEST['Enviar'])){
	if($formulario->valida_formulario()){
		$tabla="detalleplantillavotacion";
		$fila['idcandidatovotacion']=$_POST['idcandidatovotacion'];
		$fila['fechainscripcioncandidatodetalleplantillavotacion']=formato_fecha_mysql($_POST['fechainscripcioncandidatodetalleplantillavotacion']);
		$fila['resumenpropuestascandidatodetalleplantillavotacion']=$_POST['resumenpropuestascandidatodetalleplantillavotacion'];
		$fila['idplantillavotacion']=$_POST['idplantillavotacion'];
		$fila['idcargo']=$_POST['idcargo'];
		$fila['codigoestado']=100;
		$condicionactualiza=" idcandidatovotacion=".$fila['idcandidatovotacion'].
								" and idplantillavotacion=".$fila['idplantillavotacion'].
								" and idcargo=".$fila['idcargo'];
		//alerta_javascript($_POST['resumenpropuestascandidatodetalleplantillavotacion']);
		$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
		
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
		
	}
}
if(isset($_REQUEST['Modificar'])){
	if($formulario->valida_formulario()){
		$tabla="detalleplantillavotacion";
		$nombreidtabla="iddetalleplantillavotacion";
		$idtabla=$_POST['iddetalleplantillavotacion'];
		$fila['idcandidatovotacion']=$_POST['idcandidatovotacion'];
		$fila['fechainscripcioncandidatodetalleplantillavotacion']=formato_fecha_mysql($_POST['fechainscripcioncandidatodetalleplantillavotacion']);
		$fila['resumenpropuestascandidatodetalleplantillavotacion']=$_POST['resumenpropuestascandidatodetalleplantillavotacion'];
		$fila['idplantillavotacion']=$_POST['idplantillavotacion'];
		$fila['idcargo']=$_POST['idcargo'];
		//$fila['codigoestado']=100;
		$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
	
	}
}
if(isset($_REQUEST['Anular'])){
	$tabla="detalleplantillavotacion";
	$fila['codigoestado']=200;
	$nombreidtabla="iddetalleplantillavotacion";
	$idtabla=$_POST['iddetalleplantillavotacion'];
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
}		

?>

  </table>
</form>
