<?php
session_start();
ini_set('max_execution_time','6000');
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
	function  ventanaprincipal(pagina)
	{
		opener.focus();
		opener.location.href=pagina.href;
		window.close();
		return false;
	}
	function reCarga()
	{
		document.location.href="<?php echo 'listadotablagraduadosacuerdo.php';?>";	
	}
	function regresarGET()
	{
		document.location.href="<?php echo 'listadotablagraduadosacuerdo.php';?>";
	}
</script>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/motorv2/motor.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../registro_graduados/carta_egresados/funciones/validaciones.php");

//require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 

function encuentra_array_materias($sala,$codigoacuerdograduado,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$columna,$objetobase,$imprimir=0){
 
 
if($codigocarrera!="todos")
$carreradestino="AND e.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($codigomateria!="todos")
	$materiadestino="AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino="";

if($columna){
$numerocorte="and co.numerocorte='".$columna."' ";
$condicionnotaaprobada="and ROUND(d.nota,1) < m.notaminimaaprobatoria";
}
else{
$condicionnotaaprobada="";
$numerocorte="";
}

if($columna==5){
$condicionnotaaprobada="and ROUND(h.notadefinitiva,1) < m.notaminimaaprobatoria";
$numerocorte="";
}

$query="select da.iddetalleacuerdograduado,c.nombrecarrera,da.codigoestudiante,
sc.nombresituacioncarreraestudiante Situacion_Actual,
e.semestre,eg.numerodocumento,eg.apellidosestudiantegeneral,
eg.nombresestudiantegeneral, tp.nombretipodetallepazysalvoegresado,tp.idtipodetallepazysalvoegresado 
from detalleacuerdograduado da,estudiantegeneral eg, detalleacuerdograduadopazysalvoegresado dap,
tipodetallepazysalvoegresado tp,estudiante e,situacioncarreraestudiante sc,carrera c
 where 
 da.codigoestudiante=e.codigoestudiante and
 e.idestudiantegeneral=eg.idestudiantegeneral and 
 sc.codigosituacioncarreraestudiante=e.codigosituacioncarreraestudiante and 
 c.codigocarrera=e.codigocarrera and
 da.codigoacuerdograduado=".$codigoacuerdograduado." and
 tp.idtipodetallepazysalvoegresado=dap.idtipodetallepazysalvoegresado and
 dap.iddetalleacuerdograduado=da.iddetalleacuerdograduado and
 dap.codigoestado like '1%' and
 tp.codigoestado like '1%' and
 da.codigoestado like '1%'
 and tp.codigotiporegistro like '1%'
 order by da.numeroorden
 ";
		 
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
$i=0;
$columnas['estado']=1;
$columnas['nombrecarrera']=1;
$columnas['codigoestudiante']=1;
$columnas['Situacion_Actual']=1;
//$columnas['Orden_Vigente']=1;
//$columnassiparametrizar=array("Orden_Vigente");
$columnas['semestre']=1;
$columnas['numerodocumento']=1;
$columnas['apellidosestudiantegeneral']=1;
$columnas['nombresestudiantegeneral']=1;
$operaciontipopaz=$objetobase->recuperar_resultado_tabla("tipodetallepazysalvoegresado","codigoestado","100","  and codigotiporegistro like '1%' order by idtipodetallepazysalvoegresado"," ",0);
	while ($rowtipopaz=$operaciontipopaz->fetchRow()){
	$columnas[cambiarespacio($rowtipopaz['nombretipodetallepazysalvoegresado'])]=1;
	}


	while ($row_operacion=$operacion->fetchRow())
	{
		$i++;
		//echo "$i) ESTUDIANTE=".$row_operacion['codigoestudiante']."<br>";
		$arraydetalleacuerdograduado[$row_operacion['iddetalleacuerdograduado']]['nombrecarrera']=$row_operacion['nombrecarrera'];
		$arraydetalleacuerdograduado[$row_operacion['iddetalleacuerdograduado']]['codigoestudiante']=$row_operacion['codigoestudiante'];
		$arraydetalleacuerdograduado[$row_operacion['iddetalleacuerdograduado']]['Situacion_Actual']=$row_operacion['Situacion_Actual'];
		$arraydetalleacuerdograduado[$row_operacion['iddetalleacuerdograduado']]['semestre']=$row_operacion['semestre'];
		$arraydetalleacuerdograduado[$row_operacion['iddetalleacuerdograduado']]['numerodocumento']=$row_operacion['numerodocumento'];
		$arraydetalleacuerdograduado[$row_operacion['iddetalleacuerdograduado']]['apellidosestudiantegeneral']=$row_operacion['apellidosestudiantegeneral'];
		$arraydetalleacuerdograduado[$row_operacion['iddetalleacuerdograduado']]['nombresestudiantegeneral']=$row_operacion['nombresestudiantegeneral'];
		
		$arraydetalleacuerdograduado[$row_operacion['iddetalleacuerdograduado']][cambiarespacio($row_operacion['nombretipodetallepazysalvoegresado'])]="si";

		$columnas[cambiarespacio($row_operacion['nombretipodetallepazysalvoegresado'])]=1;
		//if($valido)
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
	//print_r()
	foreach($arraydetalleacuerdograduado as $llaveacuerdo => $valoresacuerdo){
		
		$validaciones=new validaciones_requeridas($sala,$valoresacuerdo['codigoestudiante'],"20072",$debug);
		$valido=$validaciones->verifica_validaciones();
		$array_documentos_pendientes=$validaciones->retorna_array_documentos_pendientes();
		$array_materias_pendientes=$validaciones->retorna_array_materias_pendientes();

		/*if(!is_array($array_validaciones[0]))
		{
				echo " NO SE HAN PARAMETRIZADO LAS TABLAS DE VALIDACION<BR>";
				//exit();
		}*/
		
		if(is_array($array_documentos_pendientes))
			foreach($array_documentos_pendientes as $llave => $valores)
				$valoresacuerdo["Documentos_Pendientes"].=" '".$valores["documentacion"]."',";
		else
			$valoresacuerdo["Documentos_Pendientes"]="&nbsp;";
		
		if(is_array($array_materias_pendientes)){
			$array_materias_pendientes_tmp=$array_materias_pendientes;
			foreach($array_materias_pendientes as $llave => $valores)
				$valoresacuerdo["Materias_Pendientes"].=$valores["nombremateria"]."-S:".$valores["semestredetalleplanestudio"]."";
		}
		else{
			$valoresacuerdo["Materias_Pendientes"]="&nbsp;";
		}
		$array_interno[]=$valoresacuerdo;

	}
	

		$columnas["Documentos_Pendientes"]=1;	
		$columnas["Materias_Pendientes"]=1;

		for($i=0;$i<count($array_interno);$i++){
			$conestadosi=0;$codigoestados=0;
			 foreach($columnas as $llave => $valor){
					$codigoestados++;
	
					if(!isset($array_interno[$i][$llave])||(trim($array_interno[$i][$llave])=='')){
						if($llave=="estado"){
							$conestadosi++;
						}
						else{
						$array_nuevo[$i][$llave]="no";
						}
						//if($array_interno[$i]['PLAN_DE_ESTUDIOS']=="no"){
						$array_nuevo[$i]["estado"]="<img src='../../imagesAlt2/rojo.gif' alt='estado' name='imagen' width='40' height='12'> ";
						//}

					}
					else{
						$conestadosi++;
						$array_nuevo[$i][$llave]=$array_interno[$i][$llave];
						if($array_interno[$i]['PLAN_DE_ESTUDIOS']=="si"){
						$array_nuevo[$i]["estado"]="<img src='../../imagesAlt2/amarillo.gif' alt='estado' name='imagen' width='40' height='12'> ";
					    }
	
					}


			}
					//echo "if($conestadosi==$codigoestados)<br>";
			if($conestadosi==$codigoestados)
			$array_nuevo[$i]["estado"]="<img src='../../imagesAlt2/verde.gif' alt='estado' name='imagen' width='40' height='12'> ";


		}
	

	
/* 	echo "<pre>";
	print_r($array_materias_pendientes_tmp);
	echo "</pre>";
 */
 return $array_nuevo;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


if(isset($_POST['codigocarrera'])&&($_POST['codigocarrera']!=''))
$codigofacultad="05";



unset($filacarreras);




/* if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicagraduadosacuerdo']&&trim($_REQUEST['codigomodalidadacademica'])!='')
$_SESSION['codigomodalidadacademicagraduadosacuerdo']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomateriagraduadosacuerdo]=".$_SESSION['codigomateriagraduadosacuerdo'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreragraduadosacuerdo']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreragraduadosacuerdo']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododgraduadosacuerdo']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododgraduadosacuerdo']=$_REQUEST['codigoperiodo'];
 */
if($_REQUEST['codigoacuerdograduado']!=$_SESSION['codigoacuerdotablagraduadosacuerdo']&&(trim($_REQUEST['codigoacuerdograduado'])!=''))
$_SESSION['codigoacuerdotablagraduadosacuerdo']=$_REQUEST['codigoacuerdograduado'];

if(isset($_REQUEST['Enviar'])){
$cantidadestmparray=encuentra_array_materias($sala,$_SESSION['codigoacuerdotablagraduadosacuerdo'],$_SESSION['codigocarreragraduadosacuerdo'],$_SESSION['codigomodalidadacademicagraduadosacuerdo'],$_SESSION['codigoperiododgraduadosacuerdo'],$_SESSION['columnagraduadosacuerdo'],$objetobase,0);
$_SESSION['cantidadestmparraytablagraduadosacuerdo']=$cantidadestmparray;
}
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";
 

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($_SESSION['cantidadestmparraytablagraduadosacuerdo'],"HISTORIAL LINEA ENFASIS ","listadodetalletablagraduadosacuerdo.php",'si','si','listadodetalletablagraduadosacuerdo.php','listadogeneral.php',true,"si","../../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
// echo "<pre>";
//print_r($motor->matriz_filtrada);
//echo "</pre>";
/* 
$motor->agregarllave_drilldown('idcentrotrabajoarp','centrostrabajo.php','centrostrabajo.php','','idcentrotrabajoarp',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregar_llaves_totales('Total_Alumnos',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);
*/
$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
