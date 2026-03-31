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
require_once('../../../../funciones/sala_genericas/Excel/reader.php');
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('funciones/ObtenerDatos.php');
function matrizTablaHtml($matriz){
echo "<table border='1' bordercolor='#EBEBEB' align='center'><tr bgcolor='#EBEBEB'>";
foreach ($matriz[0] as $llave => $valor){
	echo "<td class=tdtitulo width='100' ><b>".strtoupper($llave)."</b></td>";
}
echo "<tr>";

for($i=0;$i<count($matriz);$i++){
	echo "<tr>";
		foreach ($matriz[0] as $llave => $valor){
			echo "<td>".$matriz[$i][$llave]."</td>";
		}
	echo "<tr>";
}

echo "</table>";
}


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

$link_origen=$_GET['link_origen'];





$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="javascript">
function reCarga(pagina){
	document.location.href=pagina;
}
function recargar(){
document.location.href= "<?php echo 'calcula_listado_resultados.php?asignaestado&codigomodalidadacademica='. $_GET['codigomodalidadacademica'].'&codigocarrera='. $_GET['codigocarrera'].'&codigoperiodo='. $_GET['codigoperiodo'].'&link_origen=menu.php' ?>"
}
function enviar(){
admitir.submit();

}
function enviar_carrera(){
admitir.action="calcula_listado_informe.php";
enviar();
}
</script>
<style type="text/css">
<!--
TD#tdtitulo{
	font-size: 10px;
	font-weight: bold;
	color: #333333;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	width: 160px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
}
.Estilo3 {color: #FC9014}
-->
</style>
<table width="750"  border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td><p><img src="../../../../../admitidosmedicina/banneradmitidos.gif" width="750" height="90"></p></td>
  </tr>
</table>
<table align="center" width="100%"><br>
<form name="admitir" method="post" action="">
  <table border="1" cellpadding="1" cellspacing="0"  bordercolor="#E9E9E9" align="center">
  	<tr>
<td align="left" class="Estilo3"  colspan="2"></td>
</tr>
	  	  <?php 
		  //echo "admisiones_consulta->DibujarMenuEstadoAdmision(".$_SESSION['estadoadmision'].",' and codigoestadoestudianteadmision > 100 and codigoestadoestudianteadmision < 200 ')";
		  $condicion="da.idadmision=a.idadmision and
		  			c.codigocarrera=a.codigocarrera and
					dal.iddetalleadmision=da.iddetalleadmision and
					('".$fechahoy."' between dal.fechainiciodetalleadmisionlistado and dal.fechavencimientodetalleadmisionlistado)";
		  $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("detalleadmision da, detalleadmisionlistado dal, admision a, carrera c","c.codigocarrera","c.nombrecarrera",$condicion);
		  $formulario->filatmp[""]="Seleccionar";
		  $menu="menu_fila"; $parametrosmenu="'codigocarrera','".$codigocarrera."','onchange=enviar_carrera();'";
		  $formulario->dibujar_campo($menu,$parametrosmenu,"Buscar Resultados En La Carrera","","codigocarrera");

if(isset($_SESSION['codigocarrera'])&&trim($_SESSION['codigocarrera'])!=''){

$admisiones_consulta=new TablasAdmisiones($sala,$debug);
$array_subperiodo=$admisiones_consulta->LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera,$codigoperiodo);
$idsubperiodo=$array_subperiodo['idsubperiodo'];
$idadmision=$admisiones_consulta->LeerIdadmision($codigocarrera,$idsubperiodo);


if($_REQUEST['Nuevo_Estado'])
$_SESSION['Nuevo_Estado']=1;

if($_REQUEST['Restablecer'])
unset($_SESSION['Nuevo_Estado']);


if(isset($_GET['asignahorario']))
{
	/*unset($_SESSION['Nuevo_Estado']);
	unset($_SESSION['estadoadmision']);
	unset($_SESSION['detalleadmision']);*/
	
if(!isset($_POST['estadoadmision'])||$_POST['estadoadmision']=="")
$_POST['estadoadmision']='';
$_POST['Nuevo_Estado']=1;
$_SESSION['Nuevo_Estado']=1;

//if(!isset($_POST['iddetalleadmision'])||$_POST['iddetalleadmision']=="")
//$_POST['iddetalleadmision']=$admisiones_consulta->idDetalleAdmisionNombre($idadmision,"ENTREVISTA");
}
if(isset($_POST['detalleadmision']))
$_SESSION['detalleadmision']=$_POST['detalleadmision'];

if(isset($_POST['estadoadmision']))
$_SESSION['estadoadmision']=$_POST['estadoadmision'];

//echo "<h1>".$_SESSION['estadoadmision']."</h1>";

$_GET['Filtrar']='Filtrar';
$_GET['codigoestadoestudianteadmision']=$_POST['estadoadmision'];
$_GET['f_codigoestadoestudianteadmision']='like';

$_GET['ordenamiento']='nombre';
$_GET['orden']='asc';

if($codigocarrera=="" or $codigoperiodo=="")
{
	echo "<h1>Error, se perdió la variable de sesion carrera o periodo</h1>";
}





  //echo "SESSION = ".$_SESSION['codigocarrera']."<BR>";
  		  $condicion="da.idadmision=a.idadmision and
					  dal.iddetalleadmision=da.iddetalleadmision and
  					  a.idadmision=".$idadmision." and
					  eea.codigoestadoestudianteadmision=dal.codigoestadoestudianteadmision and
					  ('".$fechahoy."' between dal.fechainiciodetalleadmisionlistado and dal.fechavencimientodetalleadmisionlistado)";
		  $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("detalleadmision da, detalleadmisionlistado dal, admision a, estadoestudianteadmision eea","da.iddetalleadmision","da.nombredetalleadmision",$condicion);
		  $formulario->filatmp[""]="Seleccionar";
		  $menu="menu_fila"; $parametrosmenu="'iddetalleadmision','".$_POST['iddetalleadmision']."','onchange=enviar();'";
		  $formulario->dibujar_campo($menu,$parametrosmenu,"Buscar para la prueba","","iddetalleadmision");


		  $condicion="da.idadmision=a.idadmision and
					  dal.iddetalleadmision=da.iddetalleadmision and
					  eea.codigoestadoestudianteadmision=dal.codigoestadoestudianteadmision and
					  a.idadmision=".$idadmision." and
					  da.iddetalleadmision='".$_POST['iddetalleadmision']."' and
					  ('".$fechahoy."' between dal.fechainiciodetalleadmisionlistado and dal.fechavencimientodetalleadmisionlistado)";
		  $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("detalleadmision da, detalleadmisionlistado dal, admision a, estadoestudianteadmision eea","eea.codigoestadoestudianteadmision","eea.nombreestadoestudianteadmision",$condicion);
		  $formulario->filatmp[""]="Seleccionar";
		  $menu="menu_fila"; $parametrosmenu="'estadoadmision','".$_POST['estadoadmision']."','onchange=enviar();'";
		  $formulario->dibujar_campo($menu,$parametrosmenu,"Tipo de listado","","estadoadmision");

		
		  //$admisiones_consulta->DibujarMenuEstadoAdmision($_SESSION['estadoadmision'],"","onchange=enviar();") 
?>
  </table>
 <!-- <input type="hidden" name="iddetalleadmision" value="<?php echo $admisiones_consulta->idDetalleAdmisionNombre($idadmision,"ENTREVISTA"); ?>" >-->
</form>
</table>
<?php
//echo print_r($_POST);

if(isset($_POST['estadoadmision'])&&trim($_POST['estadoadmision'])!=''){

//echo "ESTADOADMISION=".$_POST['estadoadmision'];
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

$tabla = new matriz($array_listado_asignacion_pruebas,"Listado resultados de las pruebas $codigocarrera",'listado_informe.php','no','si','menu.php',"calcula_listado_resultados.php",false,"no","../../../../");

if(empty($tabla->matriz_filtrada))
echo'<meta http-equiv="REFRESH" content="0;URL=calcula_listado_informe.php"/>';


for($j=0;$j<count($tabla->matriz_filtrada);$j++)	{
$matriz_mostrar[$j]['documento']=$tabla->matriz_filtrada[$j]['numerodocumento'];
$matriz_mostrar[$j]['nombres']=$tabla->matriz_filtrada[$j]['nombre'];
}
//print_r($matriz_mostrar);
//$_SERVER['REQUEST_URI']="calcula_listado_informe.php";
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
$tabla->agregarllave_emergente('nombreestadoestudianteadmision','listado_informe.php','estudianteadmision.php','test','codigoestudiante',"",300,300,200,150,"yes","yes","no","no","no",'idadmision','idadmision','','');
$tabla->botonRecargar=false;

//if(!empty($_POST['corte'])){
	//$tabla->matriz_filtrada=$nueva_matriz;
	$i=0;
	/*foreach ($tabla->matriz_recortada as $llave => $valor){
				if($i<$_POST['corte'])
					$nueva_matriz2[]=$tabla->matriz_recortada[$i];
				$i++;
	}
}*/
//$tabla->matriz_recortada=$nueva_matriz2;
echo "<div align=center class='tdtitulogris'><b>";
$condicion=" and iddetalleadmision=".$_POST['iddetalleadmision'];
$datosadmisionlistado=$objetobase->recuperar_datos_tabla("detalleadmisionlistado dal","codigoestadoestudianteadmision",$_POST['estadoadmision'],$condicion,'',0);
echo $datosadmisionlistado['titulodetalleadmisionlistado'];
echo "</b></div>";						


if($_POST['estadoadmision']==100){

	for($j=0;$j<count($tabla->matriz_filtrada);$j++){
		$idestudianteadmision=$tabla->matriz_filtrada[$j]['idestudianteadmision'];
		$condicion=" and d.iddetalleadmision='".$_POST['iddetalleadmision']."'
			and h.iddetallesitioadmision=d.iddetallesitioadmision
			and h.idhorariodetallesitioadmision=dea.idhorariodetallesitioadmision
			and s.codigosalon=d.codigosalon
			and se.codigosede=s.codigosede
			and h.codigoestado like '1%'
			and d.codigoestado like '1%'";
	
		$datossitioadmision=$objetobase->recuperar_datos_tabla("detalleestudianteadmision dea, horariodetallesitioadmision h, detallesitioadmision d, salon s, sede se","dea.idestudianteadmision",$idestudianteadmision,$condicion,'',0);
	
		if(trim($datossitioadmision['nombresalon'])=='Sin Asignar')
			$datossitioadmision['nombresalon']=$datossitioadmision['codigosalon'];
		$array_interno[]=array('idestudianteadmision'=>$tabla->matriz_filtrada[$j]['idestudianteadmision'],'iddetalleadmision'=>$_POST['iddetalleadmision'],'horaintervalotanda'=>$datossitioadmision['horainicialhorariodetallesitioadmision'],'codigoestadoestudianteadmision'=>$_SESSION['estadoadmision'],'idhorariodetallesitioadmision'=>$datossitioadmision['idhorariodetallesitioadmision'],'nombresalon'=>$datossitioadmision['nombresalon'],'edificio'=>$datossitioadmision['nombresede'],'fechainicio'=>$datossitioadmision['fechainiciohorariodetallesitioadmision']);


	}


for($j=0;$j<count($array_interno);$j++)	{
//echo "<br>";
	if($array_interno[$j]['idestudianteadmision']==$tabla->matriz_filtrada[$j]['idestudianteadmision'])
	{
		//if($_REQUEST['Nuevo_Estado'])
			//$admisiones_consulta->IngresaDetalleEstudianteAdmision($array_interno[$j],$objetobase);
		
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
		
		$matriz_mostrar[$j]['edificio']=$tabla->matriz_filtrada[$j]['Edificio'];
		$matriz_mostrar[$j]['salon']=$tabla->matriz_filtrada[$j]['Salon'];
		$matriz_mostrar[$j]['fecha']=$tabla->matriz_filtrada[$j]['Fecha'];
		$matriz_mostrar[$j]['hora']=$tabla->matriz_filtrada[$j]['Hora'];

	}
	else{
	echo "	<br>if(".$array_interno[$j]['idestudianteadmision']."==".$tabla->matriz_filtrada[$j]['idestudianteadmision'].")";
	}
}


}


if($_POST['estadoadmision']==101){


$i=0;
$array_horario=$admisiones_consulta->ObtenerDetalleHorario($idadmision,$_POST['iddetalleadmision']);
//echo "ObtenerDetalleHorario(".$idadmision.",".$_POST['iddetalleadmision'].");";
/*
*/
/*echo "<pre>";
print_r($array_horario[0]);
echo "</pre><br><br><br><pre>";
print_r($array_horario[1]);
echo "</pre>";
*/
	//foreach ($tabla->matriz_filtrada as $llave => $valor){
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
						if(trim($array_horario[$ch][$j]['nombresalon'])=='Sin Asignar')
							$array_horario[$ch][$j]['nombresalon']=$array_horario[$ch][$j]['codigosalon'];
						
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

	$i=0;



	
	//}*/
//if($_REQUEST['Nuevo_Estado']){
//$objetobase=new BaseDeDatosGeneral($sala);
	$i=0;

for($j=0;$j<count($array_interno);$j++)	{
//echo "<br>";
	if($array_interno[$j]['idestudianteadmision']==$tabla->matriz_filtrada[$j]['idestudianteadmision'])
	{
		//if($_REQUEST['Nuevo_Estado'])
			//$admisiones_consulta->IngresaDetalleEstudianteAdmision($array_interno[$j],$objetobase);
		
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
		
		$matriz_mostrar[$j]['edificio']=$tabla->matriz_filtrada[$j]['Edificio'];
		$matriz_mostrar[$j]['salon']=$tabla->matriz_filtrada[$j]['Salon'];
		$matriz_mostrar[$j]['fecha']=$tabla->matriz_filtrada[$j]['Fecha'];
		$matriz_mostrar[$j]['hora']=$tabla->matriz_filtrada[$j]['Hora'];

	}
	else{
	echo "	<br>if(".$array_interno[$j]['idestudianteadmision']."==".$tabla->matriz_filtrada[$j]['idestudianteadmision'].")";
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


//echo "<h1>tabla filtrada".count($tabla->matriz_filtrada)."</h1>";

if($_POST['estadoadmision']==103){


$dataexcel = new Spreadsheet_Excel_Reader();
$dataexcel->setOutputEncoding('CP1251');
$dataexcel->read('/var/tmp/segundaoopcionadmisiones.xls');
//echo "<h1>archivo=".$dataexcel->sheets[0]['numRows']."</h1>";

	for($i=0; $i<$dataexcel->sheets[0]['numRows']; $i++)
	{
		//$conarray=0;
		
		//while($conarray<=count($tabla->matriz_filtrada)){

		for($conarray=0;$conarray<count($tabla->matriz_filtrada);$conarray++)	{


				 if($dataexcel->sheets[0]['cells'][$i][1]==$tabla->matriz_filtrada[$conarray]['numerodocumento']){
					
					//echo "if(".$dataexcel->sheets[0]['cells'][$i][1]."==".$tabla->matriz_filtrada[$conarray]['numerodocumento']."){ <br>";

					$horario['Hora']=$dataexcel->sheets[0]['cells'][$i][5];
					$salon['Salon']=$dataexcel->sheets[0]['cells'][$i][2];
					$edificio['Edificio']=$dataexcel->sheets[0]['cells'][$i][3];
					$fecha['Fecha']=$dataexcel->sheets[0]['cells'][$i][4];

					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$horario,3);
					if(isset($_POST['selHora']))
					$tabla->matriz_recortada[$conarray]['Hora']=$horario['Hora'];
			
					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$fecha,3);
					if(isset($_POST['selFecha']))
					$tabla->matriz_recortada[$conarray]['Fecha']=$fecha['Fecha'];
			
					
					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$edificio,3);
					if(isset($_POST['selSalon']))
					$tabla->matriz_recortada[$conarray]['Salon']=$salon['Salon'];
					
					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$salon,3);
					if(isset($_POST['selEdificio']))
					$tabla->matriz_recortada[$conarray]['Edificio']=$edificio['Edificio'];

					$tabla->matriz_filtrada[$conarray]['nombrecarrera']=$tabla->matriz_filtrada[$conarray]['Carrera_Segunda_Opcion'];

					$matriz_mostrar[$conarray]['edificio']=$tabla->matriz_filtrada[$conarray]['Edificio'];
					$matriz_mostrar[$conarray]['salon']=$tabla->matriz_filtrada[$conarray]['Salon'];
					$matriz_mostrar[$conarray]['fecha']=$tabla->matriz_filtrada[$conarray]['Fecha'];
					$matriz_mostrar[$conarray]['hora']=$tabla->matriz_filtrada[$conarray]['Hora'];

				}
				//$conarray++;
				//$tanda++;
				
				/*if($tanda>1000){
				echo "<h1>Bucle Infinito</h1>";
				break;*/
				//}

		}
	}
}

if($_POST['estadoadmision']==102){

		for($conarray=0;$conarray<count($tabla->matriz_filtrada);$conarray++)	{
					//echo "if(".$dataexcel->sheets[0]['cells'][$i][1]."==".$tabla->matriz_filtrada[$conarray]['numerodocumento']."){ <br>";

					$horario['.']="&nbsp;";
					$salon['_']="&nbsp;";
					$edificio['__']="&nbsp;";
					$fecha['___']="&nbsp;";

					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$horario,3);
					if(isset($_POST['selHora']))
					$tabla->matriz_recortada[$conarray]['Hora']=$horario['Hora'];
			
					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$fecha,3);
					if(isset($_POST['selFecha']))
					$tabla->matriz_recortada[$conarray]['Fecha']=$fecha['Fecha'];
			
					
					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$edificio,3);
					if(isset($_POST['selSalon']))
					$tabla->matriz_recortada[$conarray]['Salon']=$salon['Salon'];
					
					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$salon,3);
					if(isset($_POST['selEdificio']))
					$tabla->matriz_recortada[$conarray]['Edificio']=$edificio['Edificio'];

					
					
				}
				//$conarray++;
				//$tanda++;
				
				/*if($tanda>1000){
				echo "<h1>Bucle Infinito</h1>";
				break;*/
				//}

				

}

if($_POST['estadoadmision']==300){

		for($conarray=0;$conarray<count($tabla->matriz_filtrada);$conarray++)	{


					
					//echo "if(".$dataexcel->sheets[0]['cells'][$i][1]."==".$tabla->matriz_filtrada[$conarray]['numerodocumento']."){ <br>";

					$horario['.']="&nbsp;";
					$salon['_']="&nbsp;";
					$edificio['__']="&nbsp;";
					$fecha['___']="&nbsp;";

					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$horario,3);
					if(isset($_POST['selHora']))
					$tabla->matriz_recortada[$conarray]['Hora']=$horario['Hora'];
			
					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$fecha,3);
					if(isset($_POST['selFecha']))
					$tabla->matriz_recortada[$conarray]['Fecha']=$fecha['Fecha'];
			
					
					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$edificio,3);
					if(isset($_POST['selSalon']))
					$tabla->matriz_recortada[$conarray]['Salon']=$salon['Salon'];
					
					$tabla->matriz_filtrada[$conarray]=InsertarColumnaFila($tabla->matriz_filtrada[$conarray],$salon,3);
					if(isset($_POST['selEdificio']))
					$tabla->matriz_recortada[$conarray]['Edificio']=$edificio['Edificio'];

					
					
				}
				//$conarray++;
				//$tanda++;
				
				/*if($tanda>1000){
				echo "<h1>Bucle Infinito</h1>";
				break;*/
				//}

				




}
//echo "<h1>tabla filtrada".count($tabla->matriz_filtrada)."</h1>";

$i=0;
foreach ($tabla->matriz_filtrada as $llave => $valor){
				//if($i<$_POST['corte']){
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],7);
					//$tabla->matriz_filtrada[$i]=QuitarColumnaFila($tabla->matriz_filtrada[$i],6);

					//}
			$i++;
	}




if($exportar||$exportar_recorte)
$tabla->llamarEmergenteParaExportar('arreglo_exportacion',$_SESSION['tipo_exportacion'],$tabla->titulo);
	$tabla->mostrar_tabla_arreglo_chulitos=false;
	$tabla->botonFiltrar=false;
	$tabla->botonRestablecer=false;
	$tabla->botonRegresar=false;
	$tabla->botonExportar=false;
	$tabla->botonRecargar=false;
//print_r($_SESSION[$arreglo]);
matrizTablaHtml($matriz_mostrar);
echo "<table  width=100%><tr><td align=center>";
//$tabla->mostrar();
echo "</td></tr></table>";

}

}

?> 
