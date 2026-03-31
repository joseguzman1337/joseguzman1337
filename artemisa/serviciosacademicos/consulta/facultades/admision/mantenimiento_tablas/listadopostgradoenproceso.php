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

function encuentra_array_materias($objetobase,$objetotablaadmisiones,$codigocarreraencuentra,$codigomodalidadencuentra){
 
 
if($codigocarrera!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

//echo "<br><br>";
$query=" SELECT idadmision,codigoestudiante,concat(apellidosestudiantegeneral,' ',nombresestudiantegeneral) nombre,numerodocumento documento,nombreestadoestudianteadmision estado, nombregenero genero
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
eea.codigoestadoestudianteadmision 

from carrera c, subperiodo sp, admision a, estudianteadmision ea,  estudiante e,detalleadmision da, detallesitioadmision dsa,horariodetallesitioadmision hdsa,detalleestudianteadmision dea,carreraperiodo cp,estadoestudianteadmision eea,estudiantegeneral eg
left join resultadopruebaestado rp on rp.idestudiantegeneral=eg.idestudiantegeneral
left join detalleresultadopruebaestado dr on dr.idresultadopruebaestado = rp.idresultadopruebaestado
left join asignaturaestado ae on dr.idasignaturaestado = ae.idasignaturaestado AND ae.codigoestado like '1%'
left join genero ge on ge.codigogenero=eg.codigogenero
left join estudianteestudio ee on ee.idestudiantegeneral=eg.idestudiantegeneral
left join institucioneducativa ie on ee.idinstitucioneducativa=ie.idinstitucioneducativa and ie.codigomodalidadacademica='".($codigomodalidadencuentra-100)."'
where 
ea.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision and
c.codigocarrera=a.codigocarrera and
sp.idsubperiodo=a.idsubperiodo and
cp.codigocarrera=c.codigocarrera and
cp.idcarreraperiodo=sp.idcarreraperiodo and
a.idadmision=ea.idadmision and
ea.codigoestudiante=e.codigoestudiante and
e.idestudiantegeneral=eg.idestudiantegeneral and

da.iddetalleadmision=dsa.iddetalleadmision and
dsa.idadmision=a.idadmision and
hdsa.iddetallesitioadmision=dsa.iddetallesitioadmision and
dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision and
dea.idestudianteadmision=ea.idestudianteadmision and
cp.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
cp.codigocarrera=".$codigocarreraencuentra." and
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
eea.codigoestadoestudianteadmision 

from carrera c, subperiodo sp,  estudianteadmision ea,  estudiante e, horariodetallesitioadmision hdsa,detalleestudianteadmision dea,carreraperiodo cp,estudiantegeneral eg,genero ge,
admision a,estudianteestudio ee,estadoestudianteadmision eea,detallesitioadmision dsa
left join detalleadmision da on da.idadmision=dsa.idadmision and da.iddetalleadmision=dsa.iddetalleadmision
where 
ea.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision and
ee.idestudiantegeneral=eg.idestudiantegeneral and
 ge.codigogenero=eg.codigogenero and
c.codigocarrera=a.codigocarrera and
sp.idsubperiodo=a.idsubperiodo and
cp.codigocarrera=c.codigocarrera and
cp.idcarreraperiodo=sp.idcarreraperiodo and
a.idadmision=ea.idadmision and
ea.codigoestudiante=e.codigoestudiante and
e.idestudiantegeneral=eg.idestudiantegeneral and

dsa.idadmision=a.idadmision and
hdsa.iddetallesitioadmision=dsa.iddetallesitioadmision and
dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision and
dea.idestudianteadmision=ea.idestudianteadmision and
cp.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
cp.codigocarrera=".$codigocarreraencuentra." and
dea.codigoestado like '1%' and
da.codigoestado like '1%' and
dsa.codigoestado like '1%' and 
hdsa.codigoestado like '1%' 
group by  ea.idestudianteadmision,da.iddetalleadmision
) 

) tabla1
where
codigoestadoestudianteadmision = 100
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
            unset($row_operacion["idadmision"]);
            unset($row_operacion["codigoestudiante"]);

	$arrayinternotmp[]=$row_operacion;
	}
	while($conarray<=$cuentaregistros){
	//echo "<br>$conarray<=$cuentaregistros";

	if($confilas==0){
		$condicion=" and codigotipodetalleadmision = 3
			and codigoestado like '1%'";

		$datosdetalleadmision=$objetobase->recuperar_datos_tabla("detalleadmision","idadmision",$arrayinternotmp[$conarray]["idadmision"],$condicion,"",0);
		$array_horario=$objetotablaadmisiones->ObtenerDetalleHorario($arrayinternotmp[$conarray]["idadmision"],$datosdetalleadmision['iddetalleadmision']);
		/*echo "array_horario<pre>";
		print_r($array_horario);
		echo "</pre>";*/

	}

		
		for($j=0;($j<count($array_horario[$ch]))&&($conarray<=$cuentaregistros);$j++){
		
		//echo "<br>$conarray)array_horario[$ch][$j]";

			$cupomaximo=$array_horario[$ch][$j]['cupomaximosalon'];

				$faltantes=$cuentaregistros-$conarray;
				
				if($faltantes<$array_horario[$ch][$j]['cupomaximosalon']&&$faltantes>0){
				$j=0; $tanda=0; $entrofaltantes=1;
				//echo "if(".$faltantes."<".$array_horario[$j]['cupomaximosalon'].")<br>";
				}

				for($i=1;($i<=$array_horario[$ch][$j]['cupomaximosalon'])&&($conarray<=$cuentaregistros);$i++){


					
				unset($arrayinternotmp[$conarray]["idadmision"]);
				unset($arrayinternotmp[$conarray]["codigoestudiante"]);
						
						$intervalo=horaaminutos($array_horario[$ch][$j]['intervalotiempohorariodetallesitioadmision']);
						$intervalotanda=$intervalo*$tanda;
						
						$horainicialminutos=horaaminutos($array_horario[$ch][$j]['horainicialhorariodetallesitioadmision']);
						
						$horaintervalotandaminutos=$intervalotanda+$horainicialminutos;
						$horaintervalotanda=minutosahora($horaintervalotandaminutos);
						$horafinalminutos=horaaminutos($array_horario[$ch][$j]['horafinalhorariodetallesitioadmision']);

						if($horaintervalotandaminutos>$horafinalminutos){
						
						$cambiohorainicial=1;
						$ch++; $j=-1; $tanda=0;  $brinca=1;

						break;
						}
						if(trim($array_horario[$ch][$j]['nombresalon'])=='Sin Asignar')
							$array_horario[$ch][$j]['nombresalon']=$array_horario[$ch][$j]['codigosalon'];
						
						$array_internotmp2[$conarray]=array('hora'=>$horaintervalotanda,'salon'=>$array_horario[$ch][$j]['nombresalon'],'edificio'=>$array_horario[$ch][$j]['nombresede'],'fecha'=>substr($array_horario[$ch][$j]['fechainiciohorariodetallesitioadmision'],0,10));
						
						if(is_array($arrayinternotmp[$conarray]))
							if(is_array($array_internotmp2[$conarray]))
								$array_interno[$conarray]=InsertarColumnaFila($array_internotmp2[$conarray],$arrayinternotmp[$conarray],0);
						if($entrofaltantes){
						$j++;
						
						}

					

					
					$conarray++;
			
				}

		}
		$tanda++;
		if($tanda>1000){
			//echo "<h1>Bucle Infinito</h1>";
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
return $arrayinternotmp;
}

$objetobase=new BaseDeDatosGeneral($sala);
$objetotablaadmisiones=new TablasAdmisiones($sala);
$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['admisiones_codigocarrera'],"","",0);





$objetopdfhtml=new DocumentoPDF($tituloprincipal,'P');
    $objetopdfhtml->anchofuente=10;
    $objetopdfhtml->tamanofuente=6;
    $objetopdfhtml->saltolinea=5;
    $objetopdfhtml->lineasxpagina=44;
    $objetopdfhtml->mostrarpiefecha=0;
    $objetopdfhtml->mostrarpiepagina=1;
    $objetopdfhtml->mostrarenumeracion=0;
//$objetopdfhtml=new HTML2FPDF('P','mm','A4',7);

$tablas="admision a, subperiodo s,carreraperiodo cp,carrera c,detalleadmision da,detallesitioadmision dsa, horariodetallesitioadmision hd";
$condicion=" and cp.idcarreraperiodo=s.idcarreraperiodo
		and cp.codigocarrera=c.codigocarrera
		and a.idsubperiodo=s.idsubperiodo
		and  cp.codigocarrera=a.codigocarrera
		and da.idadmision=a.idadmision
		and dsa.iddetalleadmision=da.iddetalleadmision
		and hd.iddetallesitioadmision=dsa.iddetallesitioadmision
		and da.codigotipodetalleadmision = 1
		and hd.fechainiciohorariodetallesitioadmision like '".formato_fecha_mysql($_POST["fechaexamen"])."%'
		group by cp.codigocarrera
		order by c.nombrecarrera";
$resultadocarreraspost=$objetobase->recuperar_resultado_tabla($tablas,"cp.codigoperiodo",$_SESSION['admisiones_codigoperiodo'],$condicion,"",0);


while($rowcarreraspost=$resultadocarreraspost->fetchRow()){


$cantidadestmparray=encuentra_array_materias($objetobase,$objetotablaadmisiones,$rowcarreraspost["codigocarrera"],"300");

/*echo "cantidadestmparray<pre>";
print_r($cantidadestmparray);
echo "</pre>";*/

	if(is_array($cantidadestmparray)){
		$objetopdfhtml->CargarArray($cantidadestmparray);
		if($_POST['ingresadefinitivo']=="Si")
		{
			cargarresultados($cantidadestmparray,$rowcarreraspost['codigocarrera'],$_SESSION['admisiones_codigoperiodo'],'5',$objetobase);
		}
		/*echo "matrizcampos<pre>";
		print_r($objetopdfhtml->matrizcampos);
		echo "</pre>";*/
		$vigilada = utf8_decode("Vigilada Mineducación");
		$objetopdfhtml->tituloprincipal="UNIVERSIDAD EL BOSQUE\n".$rowcarreraspost["nombrecarrera"]." \n CITACION A ENTREVISTA PROCESO DE ADMISIONES PERIODO ".$_SESSION['admisiones_codigoperiodo']." \n ".$vigilada."  ";
		
//$objetopdfhtml->DibujarTitulo($tituloprincipal);
		$objetopdfhtml->DibujarFilas($tituloprincipal);

		//$objetopdfhtml->iniciarpagina=0;
		unset($objetopdfhtml->matrizcampos);
	}
}


$objetopdfhtml->CerrarDocumento();

?>
