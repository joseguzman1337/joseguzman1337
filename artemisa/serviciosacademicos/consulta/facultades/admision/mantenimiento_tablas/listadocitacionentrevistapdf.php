<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("funciones/ObtenerDatos.php");
require_once("funciones/cargarresultados.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
//define('RELATIVE_PATH','../../../../funciones/clases/html2fpdf/');
//require_once(RELATIVE_PATH.'html2fpdf.php');
define('FPDF_FONTPATH','../../../../funciones/clases/fpdf/font/');
require('../../../../funciones/clases/fpdf/fpdf.php');
require_once("../../../../funciones/sala_genericas/clasedocumentopdf.php");
function RecuperarResultadosEstudiante($objetobase,$objetotablaadmisiones,$idadmision,$codigoestudiante){



$condicion=" and dea.codigotipodetalleadmision=ta.codigotipodetalleadmision";

$tablas=" detalleadmision dea, tipodetalleadmision ta";
$resultado=$objetobase->recuperar_resultado_tabla($tablas,"dea.idadmision",$idadmision,$condicion,"",0);
$i=0;

while($row=$resultado->fetchRow()){

$arrayresultadoestudiante[$i]=$objetotablaadmisiones->ObtenerResultadoExamen($codigoestudiante,$idadmision,$row["codigotipodetalleadmision"]);
$arrayresultadoestudiante[$i]["nombreprueba"]=$row["nombredetalleadmision"];
$arrayresultadoestudiante[$i]["tipodetalleadmision"]=$row["codigotipodetalleadmision"];
$arrayresultadoestudiante[$i]["porcentaje"]=$row["porcentajedetalleadmision"];
if($row["codigotipodetalleadmision"]=="4")
$arrayresultadoestudiante[$i]["total_preguntas"]=100;
$i++;



}



return $arrayresultadoestudiante;
}

function encuentra_array_materias($objetobase,$objetotablaadmisiones){
 
 
if($codigocarrera!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

$query=" SELECT idadmision,codigoestudiante,concat(apellidosestudiantegeneral,' ',nombresestudiantegeneral) nombre,
numerodocumento documento,nombreestadoestudianteadmision estado, nombregenero genero,
	LugarRotacionCarreraID
FROM (
(select a.idadmision,e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
eg.numerodocumento,
round(SUM(dr.notadetalleresultadopruebaestado) / count(dr.notadetalleresultadopruebaestado),2) resultado,

(select da2.iddetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4) codigotipoprueba,
(select da2.nombredetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4) tipoprueba,
(select da2.porcentajedetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4) porcentaje,
truncate((SUM(dr.notadetalleresultadopruebaestado) / count(dr.notadetalleresultadopruebaestado)*((select da2.porcentajedetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4)/100))+0.006,2) ponderado,  
ge.nombregenero,
ie.nombreinstitucioneducativa, 
eea.nombreestadoestudianteadmision,
eg.fechanacimientoestudiantegeneral fechanacimiento,
eea.codigoestadoestudianteadmision,
lre.LugarRotacionCarreraID

from carrera c 
INNER JOIN admision a ON c.codigocarrera = a.codigocarrera
			INNER JOIN subperiodo sp ON sp.idsubperiodo = a.idsubperiodo 
			INNER JOIN estudianteadmision ea ON a.idadmision = ea.idadmision
			INNER JOIN estudiante e ON ea.codigoestudiante = e.codigoestudiante
			INNER JOIN detallesitioadmision dsa ON dsa.idadmision = a.idadmision 
			INNER JOIN detalleadmision da ON da.iddetalleadmision = dsa.iddetalleadmision
			INNER JOIN horariodetallesitioadmision hdsa ON hdsa.iddetallesitioadmision = dsa.iddetallesitioadmision
			INNER JOIN detalleestudianteadmision dea ON dea.idestudianteadmision = ea.idestudianteadmision 
				and dea.idhorariodetallesitioadmision = hdsa.idhorariodetallesitioadmision
			INNER JOIN carreraperiodo cp ON cp.codigocarrera = c.codigocarrera AND cp.idcarreraperiodo = sp.idcarreraperiodo
			INNER JOIN estadoestudianteadmision eea ON ea.codigoestadoestudianteadmision = eea.codigoestadoestudianteadmision
			INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral
left join resultadopruebaestado rp on rp.idestudiantegeneral=eg.idestudiantegeneral
left join detalleresultadopruebaestado dr on dr.idresultadopruebaestado = rp.idresultadopruebaestado
left join asignaturaestado ae on dr.idasignaturaestado = ae.idasignaturaestado AND ae.codigoestado like '1%'
left join genero ge on ge.codigogenero=eg.codigogenero
left join estudianteestudio ee on ee.idestudiantegeneral=eg.idestudiantegeneral
left join institucioneducativa ie on ee.idinstitucioneducativa=ie.idinstitucioneducativa and ie.codigomodalidadacademica='".($_SESSION['admisiones_codigomodalidadacademica']-100)."' 
			LEFT JOIN LugarRotacionCarreraEstudiante lre on lre.codigoestudiante=e.codigoestudiante
where 
cp.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
cp.codigocarrera=".$_SESSION['admisiones_codigocarrera']." and
dea.codigoestado like '1%' and
da.codigoestado like '1%' and
dsa.codigoestado like '1%' and 
hdsa.codigoestado like '1%' 
group by e.codigoestudiante)

UNION ALL

(select a.idadmision,e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
eg.numerodocumento,
(max(dea.resultadodetalleestudianteadmision)/da.totalpreguntasdetalleadmision * 100) resultado,
da.iddetalleadmision codigotipoprueba,
da.nombredetalleadmision tipoprueba,
da.porcentajedetalleadmision porcentaje,
round((max(dea.resultadodetalleestudianteadmision)/da.totalpreguntasdetalleadmision * 100)*(porcentajedetalleadmision/100),2) ponderado,
ge.nombregenero ,
(select nombreinstitucioneducativa from institucioneducativa ie where  ee.idinstitucioneducativa=ie.idinstitucioneducativa and ie.codigomodalidadacademica='200' ) nombreinstitucioneducativa,
eea.nombreestadoestudianteadmision,
eg.fechanacimientoestudiantegeneral fechanacimiento,
eea.codigoestadoestudianteadmision,
lre.LugarRotacionCarreraID 

from carrera c
				INNER JOIN admision a ON c.codigocarrera = a.codigocarrera
				INNER JOIN subperiodo sp ON sp.idsubperiodo = a.idsubperiodo
				INNER JOIN estudianteadmision ea ON a.idadmision = ea.idadmision
				INNER JOIN estudiante e ON ea.codigoestudiante = e.codigoestudiante
				INNER JOIN carreraperiodo cp ON cp.codigocarrera = c.codigocarrera AND cp.idcarreraperiodo = sp.idcarreraperiodo
				INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral
				INNER JOIN genero ge ON ge.codigogenero = eg.codigogenero
				INNER JOIN estudianteestudio ee ON ee.idestudiantegeneral = eg.idestudiantegeneral
				INNER JOIN estadoestudianteadmision eea ON ea.codigoestadoestudianteadmision = eea.codigoestadoestudianteadmision
				INNER JOIN detallesitioadmision dsa ON dsa.idadmision = a.idadmision
				INNER JOIN horariodetallesitioadmision hdsa ON hdsa.iddetallesitioadmision = dsa.iddetallesitioadmision
				INNER JOIN detalleestudianteadmision dea ON dea.idestudianteadmision = ea.idestudianteadmision 
					AND dea.idhorariodetallesitioadmision = hdsa.idhorariodetallesitioadmision 
left join detalleadmision da on da.idadmision=dsa.idadmision and da.iddetalleadmision=dsa.iddetalleadmision
			LEFT JOIN LugarRotacionCarreraEstudiante lre on lre.codigoestudiante=e.codigoestudiante
where 
cp.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
cp.codigocarrera=".$_SESSION['admisiones_codigocarrera']." and
dea.codigoestado like '1%' and
da.codigoestado like '1%' and
dsa.codigoestado like '1%' and 
hdsa.codigoestado like '1%' 
group by  ea.idestudianteadmision,da.iddetalleadmision
) 

) tabla1
where
codigoestadoestudianteadmision = 101
group by codigoestudiante
order by 3";

	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
	$cuentaregistros=$operacion->RecordCount();
//$row_operacion=$operacion->fetchRow();

	$conarray=0;
	$tanda=0;
	$entrofaltantes=0;	
	$cambiohorainicial=0;
	$ch=0;	
	$brinca=0;

	$confilas=0;
	while ($row_operacion=$operacion->fetchRow())
	{
	$arrayinternotmp[]=$row_operacion;
	}
	//while($conarray<=$cuentaregistros){
	//echo "<br>$conarray<=$cuentaregistros";
	$contador = 1;
	foreach($arrayinternotmp as $estudiante){
		//var_dump($estudiante);
	if($confilas==0){
		$condicion=" and codigotipodetalleadmision = 3
			and codigoestado like '1%'";
		$datosdetalleadmision=$objetobase->recuperar_datos_tabla("detalleadmision","idadmision",$estudiante["idadmision"],$condicion,"",0);
		$array_horario=$objetotablaadmisiones->ObtenerDetalleHorario($estudiante["idadmision"],$datosdetalleadmision['iddetalleadmision']);
		/*echo "array_horario ".$contador."<pre>";
		print_r($array_horario);
		echo "</pre>";*/
		if(count($array_horario)==1){
			$array_horario=$array_horario[0];
		} else {
			$temporal = array();
			foreach($array_horario as $salon){
				foreach($salon as $final){
					$temporal[] = $final;
				}
			}
			$array_horario = $temporal;
		}

	}
		$j=0;
		$asignado = false;
		
		foreach($array_horario as $salon){
			if(!$asignado){
				//var_dump($salon); echo "<br/><br/>";
				if($cupomaximo[$j]==null){
					$cupomaximo[$j]=$salon['cupomaximosalon'];
				}
				//var_dump($cupomaximo[$j]);echo "<br/><br/>";
				if($tandas[$j]==null){
					$tandas[$j]=0;
				}
				
				$faltantes[$j]=$cuentaregistros-$conarray[$j];
				$array_internotmp2 = null;
				$intervalo=horaaminutos($salon['intervalotiempohorariodetallesitioadmision']);
				$intervalotanda=$intervalo*$tandas[$j];
							//var_dump($tanda);
							//var_dump($tandas[$j]); echo "<br/><br/>";
							$horainicialminutos=horaaminutos($salon['horainicialhorariodetallesitioadmision']);
							
							$horaintervalotandaminutos=$intervalotanda+$horainicialminutos;
							$horaintervalotanda=minutosahora($horaintervalotandaminutos);
							$horafinalminutos=horaaminutos($salon['horafinalhorariodetallesitioadmision']);
				
							if($horaintervalotandaminutos>=$horafinalminutos){
								$cupomaximo[$j] = 0;
							}
							//var_dump($salon['LugarRotacionCarreraID']); echo " - ";
							//var_dump($estudiante["LugarRotacionCarreraID"]); echo " - ";
							//var_dump($cupomaximo[$j]); echo " - ";
							//var_dump($salon); echo "<br/><br/>";
							
							if($cupomaximo[$j]>0){
									if(trim($salon['nombresalon'])=='Sin Asignar')
										$salon['nombresalon']=$salon['codigosalon'];
									if($salon['LugarRotacionCarreraID']=="" || $salon['LugarRotacionCarreraID']==null){
											$array_internotmp2[0]=array(/*'cont'=>$contador,*/'hora'=>$horaintervalotanda,'salon'=>$salon['nombresalon'],
										'edificio'=>$salon['nombresede'],'fecha'=>substr($salon['fechainiciohorariodetallesitioadmision'],0,10));	
									} else if($salon['LugarRotacionCarreraID']==$estudiante["LugarRotacionCarreraID"]){
										$array_internotmp2[0]=array(/*'cont'=>$contador,*/'hora'=>$horaintervalotanda,'salon'=>$salon['nombresalon'],
										'edificio'=>$salon['nombresede'],'fecha'=>substr($salon['fechainiciohorariodetallesitioadmision'],0,10));												
									}
									$arreglo_temporal = $estudiante;
								unset($arreglo_temporal["idadmision"]);
								unset($arreglo_temporal["codigoestudiante"]);
								unset($arreglo_temporal["genero"]);
								unset($arreglo_temporal["LugarRotacionCarreraID"]);	
								if(is_array($estudiante)){
										if(is_array($array_internotmp2[$conarray])) {
											$array_interno[]=InsertarColumnaFila($array_internotmp2[0],$arreglo_temporal,0);
											$cupomaximo[$j]--;
											$asignado = true;
											$contador++;
											if($cupomaximo[$j]==0){
												$tandas[$j]=$tandas[$j]+1;
												$cupomaximo[$j]=$salon['cupomaximosalon'];
											}
										}
									}
							}
				$j++;
			}
		} //foreach
		$tanda++;
		if($tanda>1000){
			echo "<h1>Bucle Infinito</h1>";
			break;
		}

		$confilas++;
	}
/*
asort($arrayponderado);
//echo "Ponderado<pre>";
//print_r($arrayponderado);
//echo "</pre>";
for($i=0;$i<count($array_interno);$i++){
	$j=count($arrayponderado)+1;
	foreach($arrayponderado as $orden=>$valor){
	$j--;
	if($i==$orden)
		$array_interno[$i]["Puesto"]=$j;
	}
}*/
/*echo "<pre>";
print_r($array_interno);
echo "</pre>";
exit();*/
return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$objetotablaadmisiones=new TablasAdmisiones($sala);
$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['admisiones_codigocarrera'],"","",0);


$vigilada = utf8_decode("Vigilada Mineducación");

$tituloprincipal="UNIVERSIDAD EL BOSQUE\n".$datoscarrera["nombrecarrera"]." \n CITACION A ENTREVISTA PROCESO DE ADMISIONES PERIODO ".$_SESSION['admisiones_codigoperiodo']." \n ".$vigilada."  ";


$objetopdfhtml=new DocumentoPDF($tituloprincipal,'P');
    $objetopdfhtml->anchofuente=3;
    $objetopdfhtml->tamanofuente=5;
    $objetopdfhtml->saltolinea=4;
    $objetopdfhtml->lineasxpagina=57;
    $objetopdfhtml->mostrarpiefecha=0;
    $objetopdfhtml->mostrarpiepagina=1;
    $objetopdfhtml->mostrarenumeracion=0;
//$objetopdfhtml=new HTML2FPDF('P','mm','A4',7);

$cantidadestmparray=encuentra_array_materias($objetobase,$objetotablaadmisiones);
/*echo "cantidadestmparray<pre>";
print_r($cantidadestmparray);
echo "</pre>";*/
if($_POST['ingresadefinitivo']=="Si")
{
	cargarresultados($cantidadestmparray,$_SESSION['admisiones_codigocarrera'],$_SESSION['admisiones_codigoperiodo'],'2',$objetobase);
}
//cargarresultados($cantidadestmparray),$_SESSION['admisiones_codigocarrera'];
$objetopdfhtml->CargarArray($cantidadestmparray);




//$objetopdfhtml->DibujarTitulo($tituloprifile:///home/javeeto/public_html/serviciosacademicos/consulta/facultades/admision/mantenimiento_tablas/listadocitacionentrevistasalonpdf.phpncipal);
$objetopdfhtml->DibujarFilas($tituloprincipal);

$objetopdfhtml->CerrarDocumento();

?>
