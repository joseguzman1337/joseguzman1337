<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/motorv2/motor.php');
require_once('../../../../funciones/clases/debug/SADebug.php');
require_once('../../../../funciones/sala_genericas/FuncionesFecha.php');
require_once('../../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once('../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');

require_once('funciones/ObtenerDatos.php');



$fechahoy=date("Y-m-d H:i:s");
$_SESSION['get']=$_GET;

$debug=false;
if($_GET['depurar']=='si')
{
	$debug=true;
	$sala->debug=true;
}

$codigocarrera=$_SESSION['codigocarrera'];
$codigoperiodo=$_SESSION['codigoperiodo_seleccionado'];

if($codigocarrera=="" or $codigoperiodo=="")
{
	echo "<h1>Error, se perdió la variable de sesion carrera o periodo</h1>";
}
$link_origen=$_GET['link_origen'];

$admisiones_consulta=new TablasAdmisiones($sala,$debug);
$array_subperiodo=$admisiones_consulta->LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera,$codigoperiodo);
$idsubperiodo=$array_subperiodo['idsubperiodo'];
$idadmision=$admisiones_consulta->LeerIdadmision($codigocarrera,$idsubperiodo);

if(isset($_POST['detalleadmision']))
$_SESSION['detalleadmision']=$_POST['detalleadmision'];

if(isset($_POST['estadoadmision']))
$_SESSION['estadoadmision']=$_POST['estadoadmision'];

if($_REQUEST['Nuevo_Estado'])
$_SESSION['Nuevo_Estado']=1;

if($_REQUEST['Restablecer'])
unset($_SESSION['Nuevo_Estado']);


if(isset($_GET['asignahorario']))
{
	unset($_SESSION['Nuevo_Estado']);
	unset($_SESSION['estadoadmision']);
	unset($_SESSION['detalleadmision']);
}


?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="javascript">
function reCarga(pagina){
	document.location.href=pagina;
}
function recargar(){
document.location.href= "<?php echo 'calcula_listado_resultados.php?asignaestado&codigomodalidadacademica='. $_GET['codigomodalidadacademica'].'&codigocarrera='. $_GET['codigocarrera'].'&codigoperiodo='. $_GET['codigoperiodo'].'&link_origen=menu.php' ?>"
}
</script>
<form name="admitir" method="post" action="">
<p align="left" class="Estilo3">MENU PARAMETRIZACION ADMISIONES</p>
  <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
  	<tr>
  		<td>Prueba para asignar horarios </td>
  		<td><?php $admisiones_consulta->DibujarMenuDetalleAdmision($idadmision,$_SESSION['detalleadmision']) ?>&nbsp;<input type="submit" name="Nuevo_Estado" value="Nuevo_Estado"></td>
  	</tr>
  	<tr>
  	  <td>Para inscritos con el estado</td>
  	  <td><?php $admisiones_consulta->DibujarMenuEstadoAdmision($_SESSION['estadoadmision']) ?></td>
    </tr>
  </table>
</form>
<?php
//echo print_r($_POST);

$array_parametrizacion_admisiones=$admisiones_consulta->LeerParametrizacionPruebasAdmision($idadmision);


$exportar=0;
if(isset($_REQUEST['Exportar'])){
$exportar=1;
unset($_REQUEST['Exportar']);
unset($_GET['Exportar']);
}
$exportar_recorte=0;
if(isset($_REQUEST['Exportar_recorte'])){
$exportar_recorte=1;
unset($_REQUEST['Exportar_recorte']);
unset($_POST['Exportar_recorte']);
}
$array_listado_asignacion_pruebas=$_SESSION['array_listado_asignacion_pruebas'];

$tabla = new matriz($array_listado_asignacion_pruebas,"Listado resultados de las pruebas $codigocarrera",'listado_asigna_horario.php','si','si','menuadministracionresultados.php',"calcula_listado_resultados.php?cambioestado",false,"si","../../../../");

		/*if(isset($_POST['Exportar_recorte']))
		{	
			//$tabla->recortar($_POST);
		}*/

		if($exportar_recorte)

		{

			$_SESSION['tipo_exportacion']=$_POST['tipo_exp'];
			$tabla->recortar=true;
			$tabla->recortar($_POST);
		//$tabla->CreaArrayRecortadoSesionParaExportar();
		}
			

$tabla->definir_llave_globo_general('nombre');
foreach ($array_parametrizacion_admisiones as $llave => $valor)
{
	if($valor['codigotipodetalleadmision']<>4)//no calcular icfes
	{
		$cadena_llave="PUNTAJE_".ereg_replace(" ","_",$valor['nombretipodetalleadmision']);
		//	$tabla->agregarllave_drilldown($cadena_llave,'listado_resultados.php','detalleestudianteadmision.php','test','codigoestudiante',"codigotipodetalleadmision=".$valor['codigotipodetalleadmision']."",'idestudianteadmision','idestudianteadmision');
		$tabla->agregarllave_emergente($cadena_llave,'listado_asigna_horario.php','detalleestudianteadmision.php','test','codigoestudiante',"codigotipodetalleadmision=".$valor['codigotipodetalleadmision']."",300,300,200,150,"yes","yes","no","no","no",'idadmision','idadmision','','');
	}
}
$tabla->agregarllave_emergente('nombreestadoestudianteadmision','listado_asigna_horario.php','estudianteadmision.php','test','codigoestudiante',"",300,300,200,150,"yes","yes","no","no","no",'idadmision','idadmision','','');
$tabla->botonRecargar=false;

if(!empty($_POST['corte'])){
	$i=0;
	foreach ($tabla->matriz_filtrada as $llave => $valor){
				if($i<$_POST['corte'])
					$nueva_matriz[]=$tabla->matriz_filtrada[$i];
				$i++;
	}
	$tabla->matriz_filtrada=$nueva_matriz;
	$i=0;
	foreach ($tabla->matriz_recortada as $llave => $valor){
				if($i<$_POST['corte'])
					$nueva_matriz2[]=$tabla->matriz_recortada[$i];
				$i++;
	}
}
//$tabla->matriz_recortada=$nueva_matriz2;

if($_SESSION['Nuevo_Estado']){
$i=0;
$array_horario=$admisiones_consulta->ObtenerDetalleHorario($idadmision,$_SESSION['detalleadmision']);
echo "<br><br>";
//print_r($array_horario);
	//foreach ($tabla->matriz_filtrada as $llave => $valor){



/*	$array_interno=NULL;
	$conarray=0;
	$tanda=0;
	while($conarray<=count($tabla->matriz_filtrada)){
	
			for($j=0;$j<count($array_horario);$j++){
				$cupomaximo=$array_horario[$j]['cupomaximosalon'];
				$faltantes=count($tabla->matriz_filtrada)-$conarray;
				if($faltantes<$array_horario[$j]['cupomaximosalon']&&$faltantes>0){
				$j=0; $tanda=0; $entrofaltantes=1;
				//echo "if(".$faltantes."<".$array_horario[$j]['cupomaximosalon'].")<br>";
				}
			

				for($i=1;$i<=$array_horario[$j]['cupomaximosalon'];$i++){
					//echo "if (".$tabla->matriz_filtrada[$conarray]['codigoestadoestudianteadmision']."==".$_POST['estadoadmision'].")";
					if ($tabla->matriz_filtrada[$conarray]['codigoestadoestudianteadmision']==$_SESSION['estadoadmision']){
						//print_r($tabla->matriz_filtrada[$conarray]);
						//echo "<br><br>";
						//echo '<meta http-equiv="REFRESH" content="0;URL=calcula_listado_resultados.php?cambioestado&codigomodalidadacademica='. $_GET['codigomodalidadacademica'].'&codigocarrera='. $_GET['codigocarrera'].'&codigoperiodo='. $_GET['codigoperiodo'].'&link_origen=menu.php"/>';
						$intervalo=horaaminutos($array_horario[$j]['intervalotiempohorariodetallesitioadmision']);
						$intervalotanda=$intervalo*$tanda;
						//echo "INTERVALO TANDA=".$intervalotanda."--";
						$horainicialminutos=horaaminutos($array_horario[$j]['horainicialhorariodetallesitioadmision']);
						//echo "horainicialminutos=".$horainicialminutos."--";
						$horaintervalotandaminutos=$intervalotanda+$horainicialminutos;
						$horaintervalotanda=minutosahora($horaintervalotandaminutos);
						$array_interno[]=array('idestudianteadmision'=>$tabla->matriz_filtrada[$conarray]['idestudianteadmision'],'iddetalleadmision'=>$_SESSION['detalleadmision'],'codigoestadoestudianteadmision'=>$_SESSION['estadoadmision'],'idhorariodetallesitioadmision'=>$array_horario[$j]['idhorariodetallesitioadmision'],'horaintervalotanda'=>$horaintervalotanda,'nombresalon'=>$array_horario[$j]['nombresalon'],'edificio'=>$array_horario[$j]['nombresede'],'fechainicio'=>$array_horario[$j]['fechainiciohorariodetallesitioadmision']);
						//echo "<br>";
						if($entrofaltantes){
						$j++;
						//echo "Entro faltantes";
						}
						
					}
					$conarray++;
			
			}
		}
		$tanda++;
		if($tanda>1000){
			echo "<h1>Bucle Infinito</h1>";
			break;
		}
	}*/

	$array_interno=NULL;
	$conarray=0;
	$tanda=0;
	$entrofaltantes=0;
	
	$cambiohorainicial=0;
	$ch=0;	
	$brinca=0;

	while($conarray<=count($tabla->matriz_filtrada)){
		for($j=0;$j<count($array_horario[$ch]);$j++){
		//echo "<br>array_horario[$ch][$j]";
			$cupomaximo=$array_horario[$ch][$j]['cupomaximosalon'];

				$faltantes=count($tabla->matriz_filtrada)-$conarray;
				

				if($faltantes<$array_horario[$ch][$j]['cupomaximosalon']&&$faltantes>0){
				$j=0; $tanda=0; $entrofaltantes=1;
				//echo "if(".$faltantes."<".$array_horario[$j]['cupomaximosalon'].")<br>";
				}

				for($i=1;$i<=$array_horario[$ch][$j]['cupomaximosalon'];$i++){


					if ($tabla->matriz_filtrada[$conarray]['codigoestadoestudianteadmision']==$_POST['estadoadmision']){

						//echo "if (".$tabla->matriz_filtrada[$conarray]['codigoestadoestudianteadmision']."==".$_POST['estadoadmision'].")";
						//print_r($tabla->matriz_filtrada[$conarray]);
						//echo "<br><br>";
						//echo '<meta http-equiv="REFRESH" content="0;URL=calcula_listado_resultados.php?cambioestado&codigomodalidadacademica='. $_GET['codigomodalidadacademica'].'&codigocarrera='. $_GET['codigocarrera'].'&codigoperiodo='. $_GET['codigoperiodo'].'&link_origen=menu.php"/>';
						$intervalo=horaaminutos($array_horario[$ch][$j]['intervalotiempohorariodetallesitioadmision']);
						$intervalotanda=$intervalo*$tanda;
						//echo "INTERVALO TANDA=".$intervalotanda."--";
						$horainicialminutos=horaaminutos($array_horario[$ch][$j]['horainicialhorariodetallesitioadmision']);
						//echo "horainicialminutos=".$horainicialminutos."--";
						$horaintervalotandaminutos=$intervalotanda+$horainicialminutos;
						$horaintervalotanda=minutosahora($horaintervalotandaminutos);
						$horafinalminutos=horaaminutos($array_horario[$ch][$j]['horafinalhorariodetallesitioadmision']);

						if($horaintervalotandaminutos>$horafinalminutos){
						//echo "entro muchacho if($horaintervalotandaminutos>$horafinalminutos)  ($horaintervalotanda>".$array_horario[$ch][$j]['horafinalhorariodetallesitioadmision'].") ";
						$cambiohorainicial=1;
						$ch++; $j=-1; $tanda=0;  $brinca=1;

						break;
						}
						$array_interno[]=array('idestudianteadmision'=>$tabla->matriz_filtrada[$conarray]['idestudianteadmision'],'iddetalleadmision'=>$_SESSION['detalleadmision'],'codigoestadoestudianteadmision'=>$_SESSION['estadoadmision'],'idhorariodetallesitioadmision'=>$array_horario[$ch][$j]['idhorariodetallesitioadmision'],'horaintervalotanda'=>$horaintervalotanda,'nombresalon'=>$array_horario[$ch][$j]['nombresalon'],'edificio'=>$array_horario[$ch][$j]['nombresede'],'fechainicio'=>$array_horario[$ch][$j]['fechainiciohorariodetallesitioadmision']);
						if($entrofaltantes){
						$j++;
						//echo "Entro faltantes";
						}

						//echo "<br>";

					}
					$conarray++;
			
			}

		}
		$tanda++;
		if($tanda>1000){
			echo "<h1>Bucle Infinito</h1>";
			break;
		}
	}


	
	
	
	//}*/
$objetobase=new BaseDeDatosGeneral($sala);
	$i=0;

for($j=0;$j<count($array_interno);$j++)	{

//echo "<br>";
	if($array_interno[$j]['idestudianteadmision']==$tabla->matriz_filtrada[$j]['idestudianteadmision'])
	{
		if($_REQUEST['Nuevo_Estado'])
			$admisiones_consulta->IngresaDetalleEstudianteAdmision($array_interno[$j],$objetobase);
		
		$horario['Hora']=$array_interno[$j]['horaintervalotanda'];
		$salon['Salon']=$array_interno[$j]['nombresalon'];
		$edificio['Edificio']=$array_interno[$j]['edificio'];
		$fechainicio=explode(" ",$array_interno[$j]['fechainicio']);
		$fecha['Fecha']=$fechainicio[0];
		
		$tabla->matriz_filtrada[$j]=InsertarColumnaFila($tabla->matriz_filtrada[$j],$horario,3);
		if(isset($_POST['selHora']))
		$tabla->matriz_recortada[$j]['Hora']=$array_interno[$j]['horaintervalotanda'];

		$tabla->matriz_filtrada[$j]=InsertarColumnaFila($tabla->matriz_filtrada[$j],$fecha,3);
		if(isset($_POST['selFecha']))
		$tabla->matriz_recortada[$j]['Fecha']=$fecha['Fecha'];

		
		$tabla->matriz_filtrada[$j]=InsertarColumnaFila($tabla->matriz_filtrada[$j],$edificio,3);
		if(isset($_POST['selSalon']))
		$tabla->matriz_recortada[$j]['Salon']=$array_interno[$j]['nombresalon'];
		
		$tabla->matriz_filtrada[$j]=InsertarColumnaFila($tabla->matriz_filtrada[$j],$salon,3);
		if(isset($_POST['selEdificio']))
		$tabla->matriz_recortada[$j]['Edificio']=$array_interno[$j]['edificio'];

	}
/*echo $i++.")";
	foreach ($array_interno[$j] as $llave => $valor){
		echo $llave."=".$valor."---";
	}*/
//echo "<br><br>";,4);
//$tabla->matriz_recortada=InsertarColumnaFila($tabla->matriz_recortada,$horario,4);
/*$tabla->dibujarTablaNormal($_SESSION['array_recortado']);*/
/* echo "<pre>";
print_r($tabla->matriz_recortada);*/
}
}
//$tabla->matriz_filtrada=InsertarColumnaFila($tabla->matriz_filtrada,$horario
/*echo "</pre>";*/
//echo "tabla->filtrayesno=".$tabla->filtrayesno;
//unset($tabla->matriz_filtrada);
//$tabla->llamarEmergenteParaExportar($arreglo,$formato,$nombrearchivo);
$llavehorario[4]='Hora';
$llavesalon[4]='Salon';
$llaveedificio[4]='Edificio';
$llavefecha[4]='Fecha';
$tabla->matriz_llaves=InsertarColumnaFila($tabla->matriz_llaves,$llavehorario,3);;
$tabla->matriz_llaves=InsertarColumnaFila($tabla->matriz_llaves,$llaveedificio,3);
$tabla->matriz_llaves=InsertarColumnaFila($tabla->matriz_llaves,$llavesalon,3);
$tabla->matriz_llaves=InsertarColumnaFila($tabla->matriz_llaves,$llavefecha,3);
if($exportar_recorte){
//$tabla->CreaArrayRecortadoSesionParaExportar();
$tabla->MatrizRecortada=true;
$_SESSION['array_recortado_exportar']=$tabla->matriz_recortada;
}
if($exportar||$exportar_recorte)
$tabla->llamarEmergenteParaExportar('arreglo_exportacion',$_SESSION['tipo_exportacion'],$tabla->titulo);
//print_r($_SESSION[$arreglo]);
$tabla->mostrar();
?>