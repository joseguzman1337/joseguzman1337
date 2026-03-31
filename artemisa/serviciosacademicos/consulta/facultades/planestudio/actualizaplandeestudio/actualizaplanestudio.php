<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
require_once('../../../../Connections/sala2.php');
$salatmp=$sala;
unset($sala);
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");

require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require('../../../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../../../funciones/notas/redondeo.php');


require_once("funciones/funcionmateriaaprobada.php");
require_once("generarcargaestudiante.php");

?>
<script LANGUAGE="JavaScript">
function regresarGET()
{
	//history.back();
	location.href="<?php echo '../../../prematricula/matriculaautomaticaordenmatricula.php';?>";
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
//echo $fechahoy;

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

$codigocarrera = $_SESSION['codigofacultad'];
$codigoestudiante = $_SESSION['codigo'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];


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

$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
//echo "LINK_ORIGEN=".$_GET['link_origen'];
?>
<form name="form1" action="actualizaplanestudio.php?codigoestudiante=<?php echo $_GET['codigoestudiante'] ?>" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		$conboton=0;
		if(isset($_GET['codigoestudiante']))
		{
				$condicion="and e.codigoestudiante=pee.codigoestudiante
							and pee.codigoestadoplanestudioestudiante like '1%' and
							('$fechahoy' between pee.fechainicioplanestudioestudiante and pee.fechavencimientoplanestudioestudiante)";
				$datosplanestudios=$objetobase->recuperar_datos_tabla("estudiante e, planestudioestudiante pee","e.codigoestudiante",$_GET['codigoestudiante'],$condicion,'',0);
				//print_r($datosplanestudios);
				if(!ereg("^3+",$datosplanestudios['codigosituacioncarreraestudiante'])&&(!ereg("^2+",$datosplanestudios['codigosituacioncarreraestudiante'])))
				{
					alerta_javascript("A este  estudiante no se le puede cambiar plan de estudios estado=".$datosplanestudios['codigosituacioncarreraestudiante']);
					echo "<script LANGUAGE='JavaScript'>regresarGET();</script>";
				}

				
				
			if(!isset($_POST['idplanestudio']))
			{
				$idplanestudio=$datosplanestudios['idplanestudio'];
			}
			else{
				$idplanestudio=$_POST['idplanestudio'];
			}
			
			if(isset($idplanestudio)&&!empty($idplanestudio)){
				$condicion="and e.codigoestudiante=le.codigoestudiante
							and idplanestudio='".$idplanestudio."'
							and ('$fechahoy' between le.fechainiciolineaenfasisestudiante and le.fechavencimientolineaenfasisestudiante)";
				$datoslineaenfasis=$objetobase->recuperar_datos_tabla("estudiante e, lineaenfasisestudiante le","e.codigoestudiante",$_GET['codigoestudiante'],$condicion,'');
			}
			if(!isset($_POST['idlineaenfasisplanestudio']))
			{
				$idlineaenfasis=$datoslineaenfasis['idlineaenfasisplanestudio'];
			}
			else{
				$idlineaenfasis=$_POST['idlineaenfasisplanestudio'];
			}

		//if(isset($idplanestudio)&&!empty($idplanestudio)){						


		$condicion=" and e.idestudiantegeneral=eg.idestudiantegeneral
					and d.tipodocumento=eg.tipodocumento";
		$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e, estudiantegeneral eg, documento d","e.codigoestudiante",$_GET['codigoestudiante'],$condicion,'');
		$tituloestudiante=$datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']."  con ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento'];
		
		$formulario->dibujar_fila_titulo('Cambiar plan de estudios','labelresaltado');
		$formulario->dibujar_fila_titulo(strtoupper($tituloestudiante),'labelresaltado');
		if(isset($idplanestudio)&&!empty($idplanestudio)){

			$condicion = " e.codigocarrera=pe.codigocarrera 
						  and ('$fechahoy' between pe.fechainioplanestudio and pe.fechavencimientoplanestudio)
						  and  pe.codigoestadoplanestudio like '1%'
						  and codigoestudiante=".$_GET['codigoestudiante']."";			
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudiante e, planestudio pe","pe.idplanestudio","pe.nombreplanestudio",$condicion,'',0);
			$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametros="'idplanestudio','".$idplanestudio."','onchange=\'enviar();\''";
			$formulario->dibujar_campo($menu,$parametros,"Plan estudios","tdtitulogris","idplanestudio",'requerido');
			
				if(isset($idlineaenfasis)&&!empty($idlineaenfasis)){				
					$condicion = " ('$fechahoy' between lpe.fechainiciolineaenfasisplanestudio and lpe.fechavencimientolineaenfasisplanestudio)
								  and  lpe.codigoestadolineaenfasisplanestudio like '1%'
								  and idplanestudio=".$idplanestudio."";			
					if($formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("lineaenfasisplanestudio lpe","lpe.idlineaenfasisplanestudio","lpe.nombrelineaenfasisplanestudio",$condicion,'',0))
					{
						//$formulario->filatmp[""]="Seleccionar";
						$menu="menu_fila"; $parametros="'idlineaenfasisplanestudio','".$idlineaenfasis."',''";
						$formulario->dibujar_campo($menu,$parametros,"Linea de enfasis","tdtitulogris","idlineaenfasisplanestudio",'requerido');
					}
					
				}
						$parametrobotonenviar[$conboton]="'submit','Actualizar','Actualizar','onclick=\"return confirm(\'En realidad quiere guardar los cambios realizados\');\"'";
						$boton[$conboton]='boton_tipo';
						$conboton++;

			$parametrobotonenviar[$conboton]="'Historial_Plan_Estudio','listadohistorialplanestudio.php','codigoestudiante=".$_GET['codigoestudiante']."',900,300,5,5,'yes','yes','no','yes','yes'";
			$boton[$conboton]='boton_ventana_emergente';
			$conboton++;
			if(isset($idlineaenfasis)&&!empty($idlineaenfasis)){
					$parametrobotonenviar[$conboton]="'Historial_Linea_Enfasis','listadohistoriallineaenfasis.php','codigoestudiante=".$_GET['codigoestudiante']."',900,300,5,5,'yes','yes','no','yes','yes'";
					$boton[$conboton]='boton_ventana_emergente';
					$conboton++;
			}


		}
		else
		{
			alerta_javascript("El estudiante no tiene plan de estudios activo");
			echo "<script LANGUAGE='JavaScript'>regresarGET();</script>";
		}

	}
		
						$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
						$boton[$conboton]='boton_tipo';
						if(!($_REQUEST['Actualizar']))
						$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

if($_REQUEST['Actualizar']){
	if($formulario->valida_formulario()){
	
		if($datosplanestudios['idplanestudio']!=$_POST['idplanestudio'])
		{
			$tabla="planestudioestudiante";
			$nombreidtabla="idplanestudio";
			$idtabla=$datosplanestudios['idplanestudio'];
			$codigoestudiante=$_GET['codigoestudiante'];
			
			$materiasrestringidas=encuentramateriasrestringidas($_SESSION['codigoperiodosesion'],$_GET['codigoestudiante'],$_SESSION['cursosvacacionalessesion'],$_POST['idplanestudio'],$datosplanestudios,$objetobase);
			$materiashistoricorestringida=encuentramateriashistorico($_SESSION['codigoperiodosesion'],$_GET['codigoestudiante'],$_SESSION['cursosvacacionalessesion'],$_POST['idplanestudio'],$datosplanestudios,$objetobase,$salatmp);
			
			
			//echo "diferencia<pre>";
			//print_r($materiasrestringidas);
			//echo "</pre>";

			$continuar=0;
			if(is_array($materiasrestringidas)||is_array($materiashistoricorestringida)){
				if($_POST['Actualizar2']){
					$continuar=1;
				}
				else{
					$imprimebotonactualiza=1;				
					$imprimerestringidasplan=1;
					$imprimematerias=1;					
				}

			}
			else{
				$continuar=1;
			}
		
			
			if($continuar){
				$fila['codigoestadoplanestudioestudiante']="200";
				$condicion=" and codigoestudiante='$codigoestudiante'";
				$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,0);
					
				unset($fila);
				$fila['fechavencimientoplanestudioestudiante']=$fechahoy;
				$condicion=" and codigoestudiante='$codigoestudiante' and
							('$fechahoy' between fechainicioplanestudioestudiante and fechavencimientoplanestudioestudiante)";
				$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,0);
				
				$prematricula_inicial=encuentraprematricula($_SESSION['codigoperiodosesion'],$_GET['codigoestudiante'],$_SESSION['cursosvacacionalessesion'],$objetobase);
				$materiaspropuestas=generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase);
				
				unset($fila);
				$fila['codigoestudiante']=$codigoestudiante;
				$fila['idplanestudio']=$_POST['idplanestudio'];
				
				$fila['fechavencimientoplanestudioestudiante']="2999-12-31";
				$fila['fechainicioplanestudioestudiante']=$fechahoy;
				$fila['fechaasignacionplanestudioestudiante']=$fechahoy;
				$fila['codigoestadoplanestudioestudiante']="100";
				
				$objetobase->insertar_fila_bd($tabla,$fila,0,"");
				
				alerta_javascript("Plan de estudios cambiado exitosamente");


			}
		}
		unset($fila);

		if(isset($_POST['idlineaenfasisplanestudio'])&&!empty($_POST['idlineaenfasisplanestudio'])){						
			if(isset($datoslineaenfasis['idlineaenfasisplanestudio'])&&!empty($datoslineaenfasis['idlineaenfasisplanestudio'])){
				if($datoslineaenfasis['idlineaenfasisplanestudio']!=$_POST['idlineaenfasisplanestudio']){
				

				$materiasrestringidasenfasis=encuentramateriasrestringidasenfasis($_SESSION['codigoperiodosesion'],$_GET['codigoestudiante'],$_SESSION['cursosvacacionalessesion'],$_POST['idlineaenfasisplanestudio'],$datoslineaenfasis,$objetobase);
				$materiashistoricorestringidaenfasis=encuentramateriashistoricoenfasis($_SESSION['codigoperiodosesion'],$_GET['codigoestudiante'],$_SESSION['cursosvacacionalessesion'],$_POST['idlineaenfasisplanestudio'],$datoslineaenfasis,$objetobase,$salatmp);

				if(is_array($materiasrestringidasenfasis)){
					if($_POST['Actualizar2']){
						$continuar=1;
					}
					else{
						$imprimebotonactualiza=1;
						$imprimerestringidasenfasis=1;
						$imprimematerias=1;				
					}
				}
				else{
					$continuar=1;
				}

					if($continuar){

					$tabla="lineaenfasisestudiante";
					$nombreidtabla="idplanestudio";
					$idtabla=$datosplanestudios['idplanestudio'];
					$condicion=" and codigoestudiante='".$_GET['codigoestudiante']."'
					and ('$fechahoy' between fechainiciolineaenfasisestudiante and fechavencimientolineaenfasisestudiante)";
					$fila['fechavencimientolineaenfasisestudiante']=$fechahoy;	
					$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,0);
					
					$fila['idplanestudio']=$_POST['idplanestudio'];
					$fila['fechainiciolineaenfasisestudiante']=$fechahoy;
					$fila['fechavencimientolineaenfasisestudiante']="2999-12-31";
					$fila['fechaasignacionfechainiciolineaenfasisestudiante']=$fechahoy;
					$fila['idlineaenfasisplanestudio']=$_POST['idlineaenfasisplanestudio'];
					$fila['codigoestudiante']=$_GET['codigoestudiante'];
					$objetobase->insertar_fila_bd($tabla,$fila,0,"");
					alerta_javascript("Linea enfasis cambiada exitosamente");
					}
				}
			}

		}
	//alerta_javascript("Cambios realizados exitosamente");
	
		if($imprimematerias){
			echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>";
			if($imprimerestringidasplan){

				$formulario->dibujar_fila_titulo("CAMBIO DE PLAN DE ESTUDIOS",'labelresaltado',5);
				if(is_array($materiasrestringidas))
				{
					$imprimebotonactualiza=0;				
					alerta_javascript("Hay asignaturas  prematriculadas y que no se encuentran \\n en el plan de estudios seleccionado");
					imprimematerias($formulario,$materiasrestringidas,"Materias prematriculadas que no se encuentran en el nuevo plan de estudios");
				}
				$periodoshistorico=encontrarperiodoshistorico($_GET['codigoestudiante'],$objetobase);
				//mysql_select_db($database_sala, $salatmp);
				//echo $salatmp;
				if(is_array($materiashistoricorestringida)){
					alerta_javascript("Hay asignaturas en el historico y que no se encuentran \\n en el plan de estudios seleccionado");
					imprimematerias($formulario,$materiashistoricorestringida,"Materias vistas anteriormente que no se encuentran en el nuevo plan de estudios");
				}
				echo "<pre>";
				//print_r($materiashistoricorestringida);
				echo "</pre>";
			}
			if($imprimerestringidasenfasis){

				$formulario->dibujar_fila_titulo("CAMBIO DE ENFASIS",'labelresaltado',5);
				if(is_array($materiasrestringidasenfasis))
				{
					$imprimebotonactualiza=0;
					alerta_javascript("Hay asignaturas  prematriculadas y que no se encuentran \\n en la linea de enfasis seleccionada");
					imprimematerias($formulario,$materiasrestringidasenfasis,"Materias prematriculadas que no se encuentran en el nuevo plan de estudios");
				}	
				$periodoshistorico=encontrarperiodoshistorico($_GET['codigoestudiante'],$objetobase);
				//mysql_select_db($database_sala, $salatmp);
				//echo $salatmp;
				if(is_array($materiashistoricorestringidaenfasis)){
					alerta_javascript("Hay asignaturas en el historico y que no se encuentran \\n en la linea de enfasis seleccionada");
					imprimematerias($formulario,$materiashistoricorestringidaenfasis,"Materias vistas anteriormente que no se encuentran en el nuevo plan de estudios");
				}
				echo "<pre>";
				//print_r($materiashistoricorestringidaenfasis);
				echo "</pre>";				
			}
			imprimebotones($formulario,$_GET['codigoestudiante'],$imprimerestringidasenfasis,$imprimebotonactualiza);
			if(!$imprimebotonactualiza)
				$formulario->dibujar_fila_titulo("Para poder continuar es necesario suprimir  las asignaturas del listado anterior que se encuentran en la prematricula,  puede hacerlo por modificar carga academica en prematricula",'labelresaltado',5);

			echo "</table>";					

		}
		else{
			
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
		}
	
	}

}

	?>
</table>
</form>