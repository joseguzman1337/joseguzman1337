<?php
/**
 * Description of IndicadoresInstitucional

 *
 * @author javeeto
 */
class IndicadoresInstitucional {

	var $codigoperiodo;
	var $objetobase;
	var $db;
	var $arraycarreras;
	var $totalesdocente;


function IndicadoresInstitucional($codigoperiodo,$objetobase)
{
	$this->codigoperiodo=$codigoperiodo;
	$this->objetobase=$objetobase;
	$conexion=$this->objetobase->conexion;
	$this->objmatriculas=new obtener_datos_matriculas($conexion,$codigoperiodo);
}

/*
Encuentra lista de carreras según los parametros ingresados
*/
function carreraOpciones($codigomodalidadacademicasic,$codigocarrera="",$codigofacultad = "",$codigoareadisciplinar="",$validaperiodocarrera=0){
				
		$tablasagregadas="";
		$condicionagregada="";
		if($validaperiodocarrera){
		$tablasagregadas=",periodo p";
		$condicionagregada=" and p.codigoperiodo='".$this->codigoperiodo."'
				and (c.fechainiciocarrera between p.fechainicioperiodo and  p.fechavencimientoperiodo
				or c.fechavencimientocarrera between p.fechainicioperiodo and  p.fechavencimientoperiodo
				or p.fechainicioperiodo between c.fechainiciocarrera and  c.fechavencimientocarrera
				or p.fechavencimientoperiodo between c.fechainiciocarrera and  c.fechavencimientocarrera)";
		}
		if($codigocarrera!=""){
			$condicionagregada.=" and c.codigocarrera='".$codigocarrera."'";
			
		}
		if($codigofacultad!=""){
			$condicionagregada.=" and c.codigofacultad='".$codigofacultad."'";
			$tablasagregadas.=",modalidadacademica m";
		}
		if($codigomodalidadacademicasic!=""){
			$condicionagregada.=" and c.codigomodalidadacademicasic ='".$codigomodalidadacademicasic."'";
		}
		if($codigoareadisciplinar!=""){
			$tablasagregadas=",facultad fd";	
			$condicionagregada.="  and c.codigofacultad=fd.codigofacultad and fd.codigoareadisciplinar  = '".$codigoareadisciplinar."'";
		}

		 $query="select c.codigocarrera from carrera c ".$tablasagregadas." where  1=1  ".$condicionagregada." group by c.codigocarrera";
	

		if($imprimir)
		echo $query;
		$operacion=$this->objetobase->conexion->execute($query);
	
		//$operacion=$objetobase->conexion->query($query);
		//$row_operacion=$operacion->fetchRow();
		while ($row_operacion=$operacion->fetchRow())
		{
			$this->arraycarreras[]=$row_operacion["codigocarrera"];		
			
		}
		
		
}
/*
Encuentra indicador de estudiantes nuevos por estrato
*/
function estudianteEstrato($titulo){
	foreach($this->arraycarreras as $i => $codigocarrera ){
		 $query="SELECT concat('Estrato ',es.nombreestrato) estrato, count(distinct eg.idestudiantegeneral) cuenta
				FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co,estudiantegeneral eg,usuario u,estratohistorico eh,estrato es
				WHERE o.numeroordenpago=d.numeroordenpago
				and eg.idestudiantegeneral=e.idestudiantegeneral
				and o.codigoperiodo=e.codigoperiodo
				AND e.codigoestudiante=o.codigoestudiante
				AND c.codigocarrera=e.codigocarrera
				AND d.codigoconcepto=co.codigoconcepto
				AND co.cuentaoperacionprincipal=151
				AND o.codigoestadoordenpago LIKE '4%'
				AND e.codigoperiodo='".$this->codigoperiodo."'
				and eh.idestratohistorico = (select max(eh2.idestratohistorico) from estratohistorico eh2 where eh2.idestudiantegeneral=eg.idestudiantegeneral and eh2.codigoestado like '1%' )
				and eh.idestudiantegeneral=eg.idestudiantegeneral
				and es.idestrato=eh.idestrato
				and u.numerodocumento=eg.numerodocumento
				and c.codigocarrera='".$codigocarrera."'
				group by eh.idestrato";
		$resultado=$this->objetobase->conexion->query($query);
		
		while($fila=$resultado->fetchRow())
		{
			$arrayinterno[$codigocarrera][$titulo][$fila["estrato"]]=$fila["cuenta"];
			$arrayinterno["total"][$titulo][$fila["estrato"]]+=$fila["cuenta"];

		}
	}
	return $arrayinterno;
}
/*
Encuentra desercion en el primer año con respecto a dos periodos anteriores al consultado . El periodo de referencia ghace alusión al periodo en que ingresan todos los estudiantes nuevos
*/
function desercionPrimerAnio($titulo){
$tipodesercion="1";
	foreach($this->arraycarreras as $i => $codigocarrera ){


		$codigoperiodo=$this->encontrarPeriodoAnterior($this->codigoperiodo);
		$codigoperiodoestudiante=$this->encontrarPeriodoAnterior($codigoperiodo);

		$arrayestudiantedesercion1=$this->desercionCarrera($tipodesercion,$codigocarrera,$codigoperiodoestudiante,$codigoperiodo,0);
		
	


		//echo "<br>codigocarrera=".$codigocarrera." codigoperiodoestudiante= ".$codigoperiodoestudiante." codigoperiodo=".$codigoperiodo;

		$codigoperiodo=$codigoperiodoestudiante;
		//$codigoperiodoestudiante=$codigoperiodo;

		$arrayestudiantedesercion2=$this->desercionCarrera($tipodesercion,$codigocarrera,$codigoperiodoestudiante,$codigoperiodo,0);

		$this->objmatriculas->codigoperiodo=$codigoperiodoestudiante;
		$totalmatriculadosnuevos=$this->objmatriculas->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,"conteo");


		//echo "<br>codigocarrera=".$codigocarrera." codigoperiodoestudiante= ".$codigoperiodoestudiante." codigoperiodo=".$codigoperiodo;

		if(is_array($arrayestudiantedesercion1))
			if(is_array($arrayestudiantedesercion2))
				$arrayinterno[$codigocarrera][$titulo]["detalle"]=array_merge($arrayestudiantedesercion1,$arrayestudiantedesercion2);
		if($totalmatriculadosnuevos>0)
		$arrayinterno[$codigocarrera][$titulo]["cuenta"]=((count($arrayestudiantedesercion1)+count($arrayestudiantedesercion2))/$totalmatriculadosnuevos)*100;
		
		$arrayinterno[$codigocarrera][$titulo]["Total Matriculados Nuevos"]=$totalmatriculadosnuevos;
		$arrayinterno[$codigocarrera][$titulo]["Total Desercion"]=count($arrayestudiantedesercion1)+count($arrayestudiantedesercion2);

		$arrayinterno["total"][$titulo]["Total Matriculados Nuevos"]+=$totalmatriculadosnuevos;		
		$arrayinterno["total"][$titulo]["Total Desercion"]+=count($arrayestudiantedesercion1)+count($arrayestudiantedesercion2);		

		

	}
	if($arrayinterno["total"][$titulo]["Total Matriculados Nuevos"]>0)
	$arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Total Desercion"]/$arrayinterno["total"][$titulo]["Total Matriculados Nuevos"])*100,2)."%";
	return $arrayinterno;
}
function desercionEstudiante($titulo){
$tipodesercion="1";
	foreach($this->arraycarreras as $i => $codigocarrera ){


		$codigoperiodo=$this->encontrarPeriodoAnterior($this->codigoperiodo);
		$codigoperiodoestudiante="";
		$arrayestudiantedesercion=$this->desercionCarrera($tipodesercion,$codigocarrera,$codigoperiodoestudiante,$codigoperiodo,0);
		$this->objmatriculas->codigoperiodo=$codigoperiodo;
		$totalmatriculados=$this->objmatriculas->obtener_total_matriculados_real($codigocarrera,"conteo");
		$arrayinterno[$codigocarrera][$titulo]["Total Matriculados"]=$totalmatriculados;
		$arrayinterno[$codigocarrera][$titulo]["Total Desercion"]=count($arrayestudiantedesercion);
		if($totalmatriculados>0)
		$arrayinterno[$codigocarrera][$titulo]["Indicador"]=round((count($arrayestudiantedesercion)/$totalmatriculados)*100,2);
		$arrayinterno["total"][$titulo]["Total Matriculados"]+=$totalmatriculados;
		$arrayinterno["total"][$titulo]["Total Desercion"]+=count($arrayestudiantedesercion);

	}
	if($arrayinterno["total"][$titulo]["Total Matriculados"]>0)
	$arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Total Desercion"]/$arrayinterno["total"][$titulo]["Total Matriculados"])*100,2)."%";
	return $arrayinterno;
}
function encontrarPeriodoAnterior($codigoperiodoinicial)
{
$anioinicial=$codigoperiodoinicial[0].$codigoperiodoinicial[1].$codigoperiodoinicial[2].$codigoperiodoinicial[3];
	if($codigoperiodoinicial[4]=="2"){
		$indiceperiodo="1";
		$aniofinal=$anioinicial;
	}
	else
	{
		$indiceperiodo="2";
		$aniofinal=$anioinicial - 1;
	}
	return $aniofinal.$indiceperiodo;
}
/*
Encuentra listado de desercion por carrera
*/
function desercionCarrera($tipodesercion,$codigocarrera,$codigoperiodoestudiante,$codigoperiodo,$imprimir=0){


if($codigocarrera!="todos")
$carreradestino="AND e.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($tipodesercion==1){
$carreradestinodos=$carreradestino;
$modalidadacademicados="and c.codigomodalidadacademica=".$codigomodalidadacademica;
}
else{
$carreradestinodos="";
$modalidadacademicados="";
}
if(trim($codigoperiodoestudiante)!=""){
$validaestudiante="AND e.codigoperiodo='".$codigoperiodoestudiante."'";
}
else{
$validaestudiante="";

}
$query="SELECT e.semestre,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
eg.numerodocumento,c.nombrecarrera,e.codigoperiodo periodoingreso,pr.codigoperiodo periodo_salida,
sce.nombresituacioncarreraestudiante Situacion_Periodo_Salida,sce2.nombresituacioncarreraestudiante Situacion_Actual
                               FROM ordenpago o, detalleordenpago d, carrera c,
                               concepto co, prematricula pr, estudiantegeneral eg, estudiante e
                               left join historicosituacionestudiante h on
                                                    h.idhistoricosituacionestudiante =

(
select max(hh.idhistoricosituacionestudiante) from historicosituacionestudiante hh where
hh.codigoestudiante=e.codigoestudiante and
hh.codigoperiodo='".$codigoperiodo."'
group by hh.codigoestudiante
)
                             left join situacioncarreraestudiante sce on
                               h.codigosituacioncarreraestudiante =sce.codigosituacioncarreraestudiante
                              left join situacioncarreraestudiante sce2 on
                              e.codigosituacioncarreraestudiante =sce2.codigosituacioncarreraestudiante
							   WHERE o.numeroordenpago=d.numeroordenpago
                               AND pr.codigoperiodo='".$codigoperiodo."'
                               AND e.codigoestudiante=pr.codigoestudiante
                               AND e.codigoestudiante=o.codigoestudiante
			       ".$validaestudiante."
                               AND d.codigoconcepto=co.codigoconcepto
                               AND co.cuentaoperacionprincipal=151
                               AND o.codigoperiodo='".$codigoperiodo."'
                               AND o.codigoestadoordenpago LIKE '4%'
                               and c.codigocarrera=e.codigocarrera
                               and eg.idestudiantegeneral=e.idestudiantegeneral
							   and c.codigocarrera <> 13
                               and e.codigosituacioncarreraestudiante not in (400,104,107,105,106,111,109,112)
							   ".$carreradestino."
                               and h.idhistoricosituacionestudiante  not in (
                                               select h.idhistoricosituacionestudiante from historicosituacionestudiante h
                                               where h.codigosituacioncarreraestudiante in (400,104,107,105,106,111,109,112)
                                               and   h.codigoperiodo='".$codigoperiodo."'
                               )
                               and e.idestudiantegeneral not in (
                                               SELECT e.idestudiantegeneral
                                               FROM ordenpago o, detalleordenpago d, estudiante e, carrera c,
                                               concepto co, prematricula pr, estudiantegeneral eg
                                               WHERE o.numeroordenpago=d.numeroordenpago
                                               AND pr.codigoperiodo>'".$codigoperiodo."'
                                               AND e.codigoestudiante=pr.codigoestudiante
                                               AND e.codigoestudiante=o.codigoestudiante
                                               AND d.codigoconcepto=co.codigoconcepto
                                               AND co.cuentaoperacionprincipal=151
                                               AND o.codigoperiodo=pr.codigoperiodo
                                               AND o.codigoestadoordenpago LIKE '4%'
                                               and c.codigocarrera=e.codigocarrera
                                               and eg.idestudiantegeneral=e.idestudiantegeneral
						".$carreradestinodos."

                               )
                               GROUP by e.codigoestudiante
                               order by eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral";




	if($imprimir)
	echo $query;

	$operacion=$this->objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
return $array_interno;
}
/*
Encuentra estudiantes graduados en el periodo por carrera y total
*/
function graduadosPeriodo($titulo){
	foreach($this->arraycarreras as $i => $codigocarrera ){
		$query="select c.nombrecarrera,count(distinct e.codigoestudiante) cuenta from periodo p,estudiante e,carrera c,registrograduado rg,estudiantegeneral eg where
			rg.fechaactaregistrograduado between p.fechainicioperiodo and p.fechavencimientoperiodo
			and e.codigocarrera=c.codigocarrera
			and rg.codigoestudiante=e.codigoestudiante
			and eg.idestudiantegeneral=e.idestudiantegeneral
			and c.codigocarrera='".$codigocarrera."'
			and p.codigoperiodo='".$this->codigoperiodo."'
			group by c.codigocarrera";
		$resultado=$this->objetobase->conexion->query($query);

		$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
		$totalmatriculadosnuevos=$this->objmatriculas->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,"conteo");

		while($fila=$resultado->fetchRow())
		{
			$arrayinterno[$codigocarrera][$titulo]["Graduados"]=$fila["cuenta"];

			$arrayinterno["total"][$titulo]["Graduados"]+=$fila["cuenta"];
			$arrayinterno[$codigocarrera][$titulo]["Matriculados Nuevos"]=$totalmatriculadosnuevos;
			if($totalmatriculadosnuevos>0)
			$arrayinterno[$codigocarrera][$titulo]["Indicador"]=round(($fila["cuenta"]/$totalmatriculadosnuevos)*100,2);
			$arrayinterno["total"][$titulo]["Matriculados Nuevos"]+=$totalmatriculadosnuevos;

		}

	}
	if($arrayinterno["total"][$titulo]["Matriculados Nuevos"]>0)
	$arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Graduados"]/$arrayinterno["total"][$titulo]["Matriculados Nuevos"])*100,2);
	return $arrayinterno;

}
/*
Encuentra numero de años promedio que necesitan estudiantes graduados en el periodo dado y carreras escogidas
*/
function aniosGradoEstudiante($titulo){
	foreach($this->arraycarreras as $i => $codigocarrera ){
		$query="select concat(substring(e.codigoperiodo,1,4),'-01-01') fechainicioperiodo,rg.fechaactaregistrograduado,c.nombrecarrera,eg.numerodocumento from periodo p,estudiante e,carrera c,registrograduado rg,estudiantegeneral eg where
		rg.fechaactaregistrograduado between p.fechainicioperiodo and p.fechavencimientoperiodo
		and e.codigocarrera=c.codigocarrera
		and rg.codigoestudiante=e.codigoestudiante
		and eg.idestudiantegeneral=e.idestudiantegeneral
		and c.codigocarrera='".$codigocarrera."'
		and p.codigoperiodo='".$this->codigoperiodo."'";
		$resultado=$this->objetobase->conexion->query($query);

		$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
		$totalmatriculadosnuevos=$this->objmatriculas->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,"conteo");

		while($fila=$resultado->fetchRow())
		{

			$anios=(int)(diferencia_fechas(formato_fecha_defecto($fila["fechainicioperiodo"]),formato_fecha_defecto($fila["fechaactaregistrograduado"]),"meses",0)/12);

			$fila["anios"]=$anios;
			$arrayinterno[$codigocarrera][$titulo]["Sumatoria Años"]+=$anios;
			$arrayinterno[$codigocarrera][$titulo]["Numero de Estudiantes"]++;
			if($arrayinterno[$codigocarrera][$titulo]["sumaestudiante"]>0)
			$arrayinterno[$codigocarrera][$titulo]["Indicador"]=round(($arrayinterno[$codigocarrera][$titulo]["sumaanios"]/$arrayinterno[$codigocarrera][$titulo]["sumaestudiante"]),2);
			$arrayinterno[$codigocarrera][$titulo]["estudiantes"][]=$fila;
			$arrayinterno["total"][$titulo]["Sumatoria Años"]+=$anios;
			$arrayinterno["total"][$titulo]["Numero de Estudiantes"]++;

		}

	}
	if($arrayinterno["total"][$titulo]["Numero de Estudiantes"]>0)
		$arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Sumatoria Años"]/$arrayinterno["total"][$titulo]["Numero de Estudiantes"]),2);
	return $arrayinterno;

}
/*
Encuentra docentes con contrato de division de investigaciones dentro del conjunto de carreras escogido
*/
function docenteInvestigadorCarrera($titulo)
{
	foreach($this->arraycarreras as $i => $codigocarrera ){
		 $query="select d.* 
			from docente d, contratodocente cd , detallecontratodocente dcd, detallecontratodocente dcd2,periodo p
			where d.iddocente=cd.iddocente
			and cd.idcontratodocente = dcd.idcontratodocente and dcd.codigocarrera='469'
			and cd.idcontratodocente = dcd2.idcontratodocente 
			and dcd2.codigocarrera='".$codigocarrera."'
			and dcd.codigocarrera='469'

		and (cd.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  cd.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		or p.fechavencimientoperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		)
		and p.codigoperiodo ='".$this->codigoperiodo."'
";
		$resultado=$this->objetobase->conexion->query($query);



		while($fila=$resultado->fetchRow())
		{
			$arrayinterno[$codigocarrera][$titulo]["docente"][]=$fila;
			$arrayinterno[$codigocarrera][$titulo]["sumadocente"]++;
			$arrayinterno["total"][$titulo]["Indicador"]++;


		}

	}

	return $arrayinterno;
}
/*
Encuentra el total de docentes de un solo contrato en la division de investigaciones
*/

function docenteInvestigador($titulo)
{
	//foreach($this->arraycarreras as $i => $codigocarrera ){
		 $query="select d.* 
			from docente d, contratodocente cd , detallecontratodocente dcd,periodo p
			where d.iddocente=cd.iddocente
			and cd.idcontratodocente = dcd.idcontratodocente 
			and dcd.codigocarrera='469'

		and (cd.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  cd.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		or p.fechavencimientoperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		)
		and d.iddocente not in (select cd2.iddocente from contratodocente cd2 , detallecontratodocente dcd2
where cd2.idcontratodocente=dcd2.idcontratodocente 
and dcd2.codigocarrera <> '469'
and cd2.iddocente=d.iddocente)
		and p.codigoperiodo ='".$this->codigoperiodo."'
group by d.iddocente
";
		$resultado=$this->objetobase->conexion->query($query);



		while($fila=$resultado->fetchRow())
		{
			$arrayinterno[$codigocarrera][$titulo]["docente"][]=$fila;
			$arrayinterno[$codigocarrera][$titulo]["sumadocente"]++;
			$arrayinterno["total"][$titulo]["Indicador"]++;


		}


	return $arrayinterno;
}
/*
Encuentra docentes activos en el periodo dentro de una carrera recibida como parametro de la funcion
*/
function docenteCarrera($codigocarrera){
		/* $query="select d.* 
			from docente d, contratodocente cd , detallecontratodocente dcd, periodo p
			where d.iddocente=cd.iddocente
			and cd.idcontratodocente = dcd.idcontratodocente 
			and dcd.codigocarrera='".$codigocarrera."'
			and cd.codigoestado like '1%'
			and dcd.codigoestado like '1%'
			and d.codigoestado like '1%'
		and (cd.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  cd.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		or p.fechavencimientoperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		)
		and p.codigoperiodo ='".$this->codigoperiodo."'
		group by d.iddocente";*/
		
		$query="select d.*,dc3.codigocarrera,c.* from  docente d,detallecontratodocente dc,contratodocente c,periodo p
		left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
		dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente
		and c2.codigoestado like '1%'
		and dc2.codigoestado like '1%' 	
		)
		left join carrera ca on ca.codigocarrera =dc3.codigocarrera 
		where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente and dc.codigocarrera = '".$codigocarrera."'
		and d.codigoestado like '1%'
		and c.codigoestado like '1%'
		and dc.codigoestado like '1%' 	
		and (c.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  c.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between c.fechainiciocontratodocente and c.fechafinalcontratodocente
		or p.fechavencimientoperiodo between c.fechainiciocontratodocente and c.fechafinalcontratodocente
		)
		and p.codigoperiodo ='".$this->codigoperiodo."'
		and d.codigoestado like '1%'
		and c.codigotipocontrato in(100, 200, 400)
			group by d.iddocente
			having codigocarrera='".$codigocarrera."'";
		$resultado=$this->objetobase->conexion->query($query);
		while($fila=$resultado->fetchRow())
		{
			$arraydocente[]=$fila;
		}
		return $arraydocente;
}
/*
Encuentra docentes con doctorado dentro de un conjunto de carreras
*/
function docenteDoctoradoEstudiante($titulo)
{
	foreach($this->arraycarreras as $i => $codigocarrera ){
		 $query="select d.* 
			from docente d, contratodocente cd , detallecontratodocente dcd, periodo p,nivelacademicodocente nad
			where d.iddocente=cd.iddocente
			and cd.idcontratodocente = dcd.idcontratodocente 
			and dcd.codigocarrera='".$codigocarrera."'
			and nad.iddocente=d.iddocente
			and nad.codigotiponivelacademico='102'
			and cd.codigoestado like '1%'
			and dcd.codigoestado like '1%'
			and d.codigoestado like '1%'
		and (cd.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  cd.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		or p.fechavencimientoperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		)
		and p.codigoperiodo ='".$this->codigoperiodo."'
		group by d.iddocente";
		$resultado=$this->objetobase->conexion->query($query);

			$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
			$totalmatriculados=$this->objmatriculas->obtener_total_matriculados_real($codigocarrera,"conteo");
			$arrayinterno["total"][$titulo]["Estudiantes Matriculados"]+=$totalmatriculados;
			$arrayinterno[$codigocarrera][$titulo]["Estudiantes Matriculados"]=$totalmatriculados;

		while($fila=$resultado->fetchRow())
		{


			$arrayinterno[$codigocarrera][$titulo]["docente"][]=$fila;
			$arrayinterno[$codigocarrera][$titulo]["Docentes con Doctorado"]++;
			$arrayinterno["total"][$titulo]["Docentes con Doctorado"]++;

		}


	}
	if($arrayinterno["total"][$titulo]["Estudiantes Matriculados"]>0)
	$arrayinterno["total"][$titulo]["Indicador"]=round((($arrayinterno["total"][$titulo]["Docentes con Doctorado"]/$arrayinterno["total"][$titulo]["Estudiantes Matriculados"])*100),2);

	return $arrayinterno;
}
/*
Cuenta el numero de contratos con division de investigaciones dentro un conjunto de carreras
*/
function contratoInvestigacionDocente($titulo)
{
	foreach($this->arraycarreras as $i => $codigocarrera ){
		 $query="select cd.*  
			from docente d, contratodocente cd , detallecontratodocente dcd, detallecontratodocente dcd2,periodo p
			where d.iddocente=cd.iddocente
			and cd.idcontratodocente = dcd.idcontratodocente and dcd.codigocarrera='469'
			and cd.idcontratodocente = dcd2.idcontratodocente 
			and dcd2.codigocarrera='".$codigocarrera."'
			and dcd.codigocarrera='469'
			and cd.codigoestado like '1%'
			and dcd2.codigoestado like '1%'
			and d.codigoestado like '1%'
		and (cd.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  cd.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		or p.fechavencimientoperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		)
		and p.codigoperiodo ='".$this->codigoperiodo."'
		group by cd.idcontratodocente";
		$resultado=$this->objetobase->conexion->query($query);

		$arrayinterno[$codigocarrera][$titulo]["docente"] = $this->docenteCarrera($codigocarrera);

		while($fila=$resultado->fetchRow())
		{
			$arrayinterno[$codigocarrera][$titulo]["contratodocente"][]=$fila;
			
		}
		if(count($arrayinterno[$codigocarrera][$titulo]["docente"]) >0)
		$arrayinterno[$codigocarrera][$titulo]["indicador"]=round((count($arrayinterno[$codigocarrera][$titulo]["contratodocente"])/count($arrayinterno[$codigocarrera][$titulo]["docente"]))*100,2);
		$arrayinterno["total"][$titulo]["Docentes"]+=count($arrayinterno[$codigocarrera][$titulo]["docente"]);
		$arrayinterno["total"][$titulo]["Contratos Investigacion"]+=count($arrayinterno[$codigocarrera][$titulo]["contratodocente"]);

	}
		if($arrayinterno["total"][$titulo]["Docentes"]>0)
			$arrayinterno["total"][$titulo]["Indicador"]=($arrayinterno["total"][$titulo]["Contratos Investigacion"]/$arrayinterno["total"][$titulo]["Docentes"])*100;

		$arrayinterno["total"][$titulo]["Indicador"]=round($arrayinterno["total"][$titulo]["Indicador"],2);

	
	return $arrayinterno;
}
function publicacionDocente($titulo)
{

	foreach($this->arraycarreras as $i => $codigocarrera ){
		//echo $codigocarrera.",";
		 $query="select pd.* 
			from docente d, contratodocente cd , detallecontratodocente dcd, periodo p, produccionintelectualdocente pd
			where d.iddocente=cd.iddocente
			and pd.iddocente=d.iddocente
			and pd.codigotipoproduccionintelectual in (100,101,200,201,300)
			and pd.codigoestado like '1%'
			and cd.idcontratodocente = dcd.idcontratodocente 
			and dcd.codigocarrera='".$codigocarrera."'
			and cd.codigoestado like '1%'
			and dcd.codigoestado like '1%'
			and d.codigoestado like '1%'
		and (cd.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  cd.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		or p.fechavencimientoperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		)
		and p.codigoperiodo ='".$this->codigoperiodo."'
		group by pd.idproduccionintelectualdocente";
		$resultado=$this->objetobase->conexion->query($query);

		//$arrayinterno[$codigocarrera][$titulo]["docente"]=0;
		$arrayinterno[$codigocarrera][$titulo]["docente"] = $this->docenteCarrera($codigocarrera);
		$llavesdocente=$this->idDocenteCarrera($arrayinterno[$codigocarrera][$titulo]["docente"]);

		if($i==0)
		$docentesfinal=$arrayinterno[$codigocarrera][$titulo]["docente"];
		if(is_array($docentestmp))
			if(is_array($docentesfinal))
		$docentesfinal=array_merge($docentesfinal,$docentestmp);
		$docentestmp=$arrayinterno[$codigocarrera][$titulo]["docente"];


		while($fila=$resultado->fetchRow())
		{
			if(is_array($llavesdocente))
			if(in_array($fila["iddocente"],$llavesdocente))
			{
				$arrayinterno[$titulo]["publicacion"][$fila["idproduccionintelectualdocente"]]=$fila;
				$arrayinterno[$codigocarrera][$titulo]["Publicaciones"]++;
			}
			//$arrayinterno["total"][$titulo]["Publicaciones"]++;

		}

	//$arrayinterno["total"][$titulo]["Docentes"]+=count($arrayinterno[$codigocarrera][$titulo]["docente"]);
	//echo "<br>".count($arrayinterno[$codigocarrera][$titulo]["publicacion"]);
	}
	$llavesdocente=$this->idDocenteCarrera($docentesfinal);
	$arrayinterno["total"][$titulo]["Docentes"]=count($llavesdocente);
	
	$arrayinterno["total"][$titulo]["Publicaciones"]=count($arrayinterno[$titulo]["publicacion"]);

	if($arrayinterno["total"][$titulo]["Docentes"]>0)
		$arrayinterno["total"][$titulo]["Indicador"]=round((($arrayinterno["total"][$titulo]["Publicaciones"]/$arrayinterno["total"][$titulo]["Docentes"])*100),2);


	return $arrayinterno;
}
function idDocenteCarrera($arraydocente){
	if(is_array($arraydocente))
	foreach($arraydocente as $llave => $valor){
		$llavesdocente[$valor["iddocente"]]=$valor["iddocente"];
	}
	if(is_array($llavesdocente))
		foreach($llavesdocente as $iddocente=>$valor2){
				$llaves[] = $iddocente;
		}
	return $llaves;
}
function publicacionIndexadaDocente($titulo)
{

	foreach($this->arraycarreras as $i => $codigocarrera ){
		//echo $codigocarrera.",";
		$query="select pd.* 
			from docente d, contratodocente cd , detallecontratodocente dcd, periodo p, produccionintelectualdocente pd
			where d.iddocente=cd.iddocente
			and pd.iddocente=d.iddocente
			and pd.codigotipoproduccionintelectual in (100,101,200,201,300)
			and pd.codigoestado like '1%'
			and pd.esindexadaproduccionintelectualdocente='1'
			and cd.idcontratodocente = dcd.idcontratodocente 
			and dcd.codigocarrera='".$codigocarrera."'
			and cd.codigoestado like '1%'
			and dcd.codigoestado like '1%'
			and d.codigoestado like '1%'
		and (cd.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  cd.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		or p.fechavencimientoperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		)
		and p.codigoperiodo ='".$this->codigoperiodo."'
		group by pd.idproduccionintelectualdocente";
		$resultado=$this->objetobase->conexion->query($query);

		//$arrayinterno[$codigocarrera][$titulo]["docente"]=0;
		$arrayinterno[$codigocarrera][$titulo]["docente"] = $this->docenteCarrera($codigocarrera);
		$llavesdocente=$this->idDocenteCarrera($arrayinterno[$codigocarrera][$titulo]["docente"]);
		while($fila=$resultado->fetchRow())
		{
			if(is_array($llavesdocente))
			if(in_array($fila["iddocente"],$llavesdocente))
			{
				$arrayinterno[$titulo]["publicacion"][$fila["idproduccionintelectualdocente"]]=$fila;
				$arrayinterno[$codigocarrera][$titulo]["Publicaciones"]++;
			}
			//$arrayinterno["total"][$titulo]["Publicaciones"]++;

		}

	//$arrayinterno["total"][$titulo]["Docentes"]+=count($arrayinterno[$codigocarrera][$titulo]["docente"]);
	//echo "<br>".count($arrayinterno[$codigocarrera][$titulo]["publicacion"]);
	}
	$arrayinterno["total"][$titulo]["Indicador"]=count($arrayinterno[$titulo]["publicacion"]);

	//$arrayinterno["total"][$titulo]["Indicador"]=round((($arrayinterno["total"][$titulo]["Publicaciones"]/$arrayinterno["total"][$titulo]["Docentes"])*100),2);

	return $arrayinterno;
}



function numeroInscritos($titulo)
{
	/*echo "arraycarreras<pre>";
	print_r($this->arraycarreras);
	echo "</pre>";*/
	foreach($this->arraycarreras as $i => $codigocarrera ){
		$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
		$arrayinterno[$codigocarrera][$titulo]["Inscritos"]=$this->objmatriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($this->codigoperiodo,$codigocarrera,153,'conteo');
		$arrayinterno["total"][$titulo]["Indicador"]+=$arrayinterno[$codigocarrera][$titulo]["Inscritos"];
	}
	return $arrayinterno;
}
function numeroMatriculadosNuevos($titulo)
{	
	foreach($this->arraycarreras as $i => $codigocarrera )
	{
		$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
		$arrayinterno[$codigocarrera][$titulo]["Matriculados_Nuevos"]=$this->objmatriculas->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,"conteo");
		$arrayinterno["total"][$titulo]["Indicador"]+=$arrayinterno[$codigocarrera][$titulo]["Matriculados_Nuevos"];

	}
	return $arrayinterno;
}
function numeroMatriculadosInscritos($titulo)
{
	foreach($this->arraycarreras as $i => $codigocarrera ){
		$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
		$arrayinterno["total"][$titulo]["Inscritos"]+=$this->objmatriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($this->codigoperiodo,$codigocarrera,153,'conteo');	$arrayinterno["total"][$titulo]["Matriculados Nuevos"]+=$this->objmatriculas->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,"conteo");



	}
	if($arrayinterno["total"][$titulo]["Inscritos"]>0)
		$arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Matriculados Nuevos"]/$arrayinterno["total"][$titulo]["Inscritos"])*100,2)."%";
	return $arrayinterno;
}

function totalEstudiantes($titulo)
{
	foreach($this->arraycarreras as $i => $codigocarrera )
	{
		$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
		$arrayinterno["total"][$titulo]["Indicador"]+=$this->objmatriculas->obtener_total_matriculados_real($codigocarrera,"conteo");
	}
	return $arrayinterno;
}
function estudiantesColegio($titulo)
{
	foreach($this->arraycarreras as $i => $codigocarrera )
	{
		$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
		$estudiantesColegio=$this->objmatriculas->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,"arreglo");
/*echo "estudiantesColegio<pre>";
print_r($estudiantesColegio);
echo "</pre>";*/
		if(is_array($estudiantesColegio))
		foreach($estudiantesColegio as $i => $estudiante)
		{
			$query="select * from estudiante e,estudianteestudio ee,institucioneducativa ie where ee.idinstitucioneducativa=ie.idinstitucioneducativa and
			ie.codigomodalidadacademica='100' and ee.codigoestado like '1%' and
			ee.idestudiantegeneral=e.idestudiantegeneral and
			e.codigoestudiante='".$estudiante["codigoestudiante"]."'
			 group by e.idestudiantegeneral";
			$resultado=$this->objetobase->conexion->query($query);
			$fila=$resultado->fetchRow();	
			switch($fila["codigonaturaleza"])
			{
				case "001":
					$arrayinterno["total"][$titulo]["Publico"]++;
				break;
				case "002":
					$arrayinterno["total"][$titulo]["Privado"]++;
				break;
				default:
					$arrayinterno["total"][$titulo]["No definido"]++;
				break;
			}
		}
		if($arrayinterno["total"][$titulo]["Publico"]>0)
		$arrayinterno["total"][$titulo]["Indicador"]=round($arrayinterno["total"][$titulo]["Privado"]/$arrayinterno["total"][$titulo]["Publico"],2);		

	}
	return $arrayinterno;
}
function estudiantesRegion($titulo)
{
	foreach($this->arraycarreras as $i => $codigocarrera )
	{
		$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
		$estudiantesRegion=$this->objmatriculas->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,"arreglo");
		if(is_array($estudiantesRegion))
		foreach($estudiantesRegion as $i => $estudiante)
		{
			$query="select * from estudiante e,estudiantegeneral eg, ciudad c, departamento d, regionnatural r where 
			e.idestudiantegeneral=eg.idestudiantegeneral and
			c.idciudad=eg.idciudadnacimiento and
			d.iddepartamento=c.iddepartamento and 
			d.idregionnatural=r.idregionnatural and
			
			e.codigoestudiante='".$estudiante["codigoestudiante"]."'
			 group by e.idestudiantegeneral";
			$resultado=$this->objetobase->conexion->query($query);
			$fila=$resultado->fetchRow();
			$arrayinterno["total"][$titulo][$fila["nombreregionnatural"]]++;
			
		}
	}
	return $arrayinterno;
}

function totalGraduados($titulo){
if($this->codigoperiodo=="TOTAL"){
	foreach($this->arraycarreras as $i => $codigocarrera ){
		$query="	select c.nombrecarrera,count(distinct rg.codigoestudiante) cuenta,
			count(distinct rga.codigoestudiante) cuentaantiguos,
			count(distinct e.codigoestudiante) cuentaestudiante
			from carrera c,estudiantegeneral eg,estudiante e
			left join registrograduadoantiguo rga on rga.codigoestudiante=e.codigoestudiante
			left join registrograduado rg on rg.codigoestudiante=e.codigoestudiante
			where
			e.codigocarrera=c.codigocarrera
			and eg.idestudiantegeneral=e.idestudiantegeneral
			and (e.codigoestudiante=rg.codigoestudiante or e.codigoestudiante=rga.codigoestudiante)
			and c.codigocarrera='".$codigocarrera."'
			group by c.codigocarrera";

		$resultado=$this->objetobase->conexion->query($query);
		while($fila=$resultado->fetchRow())
		{
			//$arrayinterno[$codigocarrera][$titulo]["Graduados"]=$fila["cuenta"];
			$arrayinterno["total"][$titulo]["Graduados"]+=$fila["cuentaestudiante"];
		/*	$arrayinterno[$codigocarrera][$titulo]["Matriculados Nuevos"]=$totalmatriculadosnuevos;
			if($totalmatriculadosnuevos>0)
			$arrayinterno[$codigocarrera][$titulo]["Indicador"]=round(($fila["cuenta"]/$totalmatriculadosnuevos)*100,2);
			$arrayinterno["total"][$titulo]["Matriculados Nuevos"]+=$totalmatriculadosnuevos;*/
		}

	}
	/*if($arrayinterno["total"][$titulo]["Matriculados Nuevos"]>0)
		$arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Graduados"]/$arrayinterno["total"][$titulo]["Matriculados Nuevos"])*100,2);*/
	
}
return $arrayinterno;

}

//Indicadores egresados
function numeroEgresados($titulo)
{


	foreach($this->arraycarreras as $i => $codigocarrera ){
		$query="select count(distinct e.codigoestudiante) cuentaestudiante,he.codigoperiodo from estudiante e, historicosituacionestudiante he where he.codigoestudiante=e.codigoestudiante
 		and e.codigocarrera='".$codigocarrera."' and he.codigosituacioncarreraestudiante='104' and he.codigoperiodo='".$this->codigoperiodo."'";

		$resultado=$this->objetobase->conexion->query($query);
		while($fila=$resultado->fetchRow())
		{

			$arrayinterno["total"][$titulo]["Indicador"]+=$fila["cuentaestudiante"];
		}

	}
	/*if($arrayinterno["total"][$titulo]["Matriculados Nuevos"]>0)
		$arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Graduados"]/$arrayinterno["total"][$titulo]["Matriculados Nuevos"])*100,2);*/
	return $arrayinterno;
}
function diferenciaEgresadosGraduados($titulo)
{

	foreach($this->arraycarreras as $i => $codigocarrera ){
		$query="select c.nombrecarrera,count(distinct e.codigoestudiante) cuenta from periodo p,estudiante e,carrera c,registrograduado rg,estudiantegeneral eg where
			rg.fechaactaregistrograduado between p.fechainicioperiodo and p.fechavencimientoperiodo
			and e.codigocarrera=c.codigocarrera
			and rg.codigoestudiante=e.codigoestudiante
			and eg.idestudiantegeneral=e.idestudiantegeneral
			and c.codigocarrera='".$codigocarrera."'
			and p.codigoperiodo='".$this->codigoperiodo."'
			group by c.codigocarrera";
		$resultado=$this->objetobase->conexion->query($query);
		while($fila=$resultado->fetchRow())
		{

			$tmpgraduados+=$fila["cuenta"];
		}
	}
	foreach($this->arraycarreras as $i => $codigocarrera ){
		$query="select count(distinct e.codigoestudiante) cuentaestudiante,he.codigoperiodo from estudiante e, historicosituacionestudiante he where he.codigoestudiante=e.codigoestudiante
 		and e.codigocarrera='".$codigocarrera."' and he.codigosituacioncarreraestudiante='104' and he.codigoperiodo='".$this->codigoperiodo."'";

		$resultado=$this->objetobase->conexion->query($query);
		while($fila=$resultado->fetchRow())
		{

			$tmpegresados+=$fila["cuentaestudiante"];
		}

	}
	$arrayinterno["total"][$titulo]["Indicador"]=$tmpegresados-$tmpgraduados;

return $arrayinterno;
}

function graduadosSemestre($titulo){
	foreach($this->arraycarreras as $i => $codigocarrera ){
		$query="select c.nombrecarrera,count(distinct e.codigoestudiante) cuenta from periodo p,estudiante e,carrera c,registrograduado rg,estudiantegeneral eg where
			rg.fechaactaregistrograduado between p.fechainicioperiodo and p.fechavencimientoperiodo
			and e.codigocarrera=c.codigocarrera
			and rg.codigoestudiante=e.codigoestudiante
			and eg.idestudiantegeneral=e.idestudiantegeneral
			and c.codigocarrera='".$codigocarrera."'
			and p.codigoperiodo='".$this->codigoperiodo."'
			group by c.codigocarrera";
		$resultado=$this->objetobase->conexion->query($query);

		$this->objmatriculas->codigoperiodo=$this->codigoperiodo;
		$totalmatriculadosnuevos=$this->objmatriculas->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,"conteo");

		while($fila=$resultado->fetchRow())
		{

			$arrayinterno["total"][$titulo]["Indicador"]+=$fila["cuenta"];

		}

	}
	/*if($arrayinterno["total"][$titulo]["Matriculados Nuevos"]>0)
	$arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Graduados"]/$arrayinterno["total"][$titulo]["Matriculados Nuevos"])*100,2);*/
	return $arrayinterno;

}

   function docenteEscalafon($titulo) {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $arraydocentes = $this->docenteCarrera($codigocarrera);
            if($i==0)
                $docentesfinal=$arraydocentes;
            if(is_array($docentestmp))
                if(is_array($docentesfinal))
                    $docentesfinal=array_merge($docentesfinal,$docentestmp);
            $docentestmp=$arraydocentes;

            if(is_array($arraydocentes))
                foreach($arraydocentes as $i => $valores ) {
                    $query="SELECT ce.nombreescalafon FROM contratodocente c , escalafon ce where ce.codigoescalafon=c.codigoescalafon and
			 c.idcontratodocente='".$valores["idcontratodocente"]."'";
                    $resultado=$this->objetobase->conexion->query($query);
                    $fila=$resultado->fetchRow();
                    $arraydocenteescalafon[$valores["iddocente"]]=$fila["nombreescalafon"];
                }

        }
        $llavesdocente=$this->idDocenteCarrera($docentesfinal);
	/*echo count($llavesdocente)."<pre>";
		print_r($llavesdocente);
	echo "</pre>";*/

        if(is_array($llavesdocente))
            foreach($llavesdocente as $i=>$iddocente)
                $arrayinterno["total"][$titulo][$arraydocenteescalafon[$iddocente]]++;

        //$arrayinterno["total"][$titulo]["Indicador"]=count($llavesdocente);

        return $arrayinterno;
    }

    function docenteEscalafonHoras($titulo) {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $arraydocentes = $this->docenteCarrera($codigocarrera);
            if($i==0)
                $docentesfinal=$arraydocentes;
            if(is_array($docentestmp))
                if(is_array($docentesfinal))
                    $docentesfinal=array_merge($docentesfinal,$docentestmp);
            $docentestmp=$arraydocentes;

            if(is_array($arraydocentes))
                foreach($arraydocentes as $i => $valores ) {
                    $query="SELECT ce.nombreescalafon, (select sum(horasxsemanadetallecontratodocente) horas
                    from detallecontratodocente
                    where idcontratodocente = '".$valores["idcontratodocente"]."'
                    and codigocarrera = '$codigocarrera'
                    group by idcontratodocente) as horas
                    FROM contratodocente c , escalafon ce
                    where ce.codigoescalafon = c.codigoescalafon
                    and c.idcontratodocente = '".$valores["idcontratodocente"]."'";
                    $resultado=$this->objetobase->conexion->query($query);
                    $fila=$resultado->fetchRow();
                    $arraydocenteescalafon[$valores["iddocente"]]=$fila["nombreescalafon"];
                    $arraydocentehorasescalafon[$valores["iddocente"]]=$fila["horas"];
                }

        }
        $llavesdocente=$this->idDocenteCarrera($docentesfinal);
	/*echo count($llavesdocente)."<pre>";
		print_r($llavesdocente);
	echo "</pre>";*/

        if(is_array($llavesdocente))
            foreach($llavesdocente as $i=>$iddocente)
                $arrayinterno["total"][$titulo][$arraydocenteescalafon[$iddocente]]+=$arraydocentehorasescalafon[$iddocente];

        //$arrayinterno["total"][$titulo]["Indicador"]=count($llavesdocente);

        return $arrayinterno;
    }
    function docenteHoras($titulo) {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $arraydocentes = $this->docenteCarrera($codigocarrera);
            //print_r($arraydocentes);
            if($i==0)
                $docentesfinal=$arraydocentes;
            if(is_array($docentestmp))
                if(is_array($docentesfinal))
                    $docentesfinal=array_merge($docentesfinal,$docentestmp);
            $docentestmp=$arraydocentes;

            if(is_array($arraydocentes))
                foreach($arraydocentes as $i => $valores ) {
                    $query="SELECT sum(horasxsemanadetallecontratodocente) horas
                    from detallecontratodocente
                    where idcontratodocente = '".$valores["idcontratodocente"]."'
                    and codigocarrera = '$codigocarrera'
                    group by idcontratodocente";
                    $resultado=$this->objetobase->conexion->query($query);
                    $fila=$resultado->fetchRow();
                    $arrayinterno["total"][$titulo]["Indicador"] += $fila["horas"];
                //$arraydocenteescalafon[$valores["iddocente"]]=$fila["nombreescalafon"];
                //$arraydocentehorasescalafon[$valores["iddocente"]]=$fila["horas"];
                }
        }

        //$llavesdocente=$this->idDocenteCarrera($docentesfinal);
	/*echo count($llavesdocente)."<pre>";
		print_r($llavesdocente);
	echo "</pre>";*/

        /*if(is_array($llavesdocente))
            foreach($llavesdocente as $i=>$iddocente)
                $arrayinterno["total"][$titulo][$arraydocenteescalafon[$iddocente]]+=$arraydocentehorasescalafon[$iddocente];

        //$arrayinterno["total"][$titulo]["Indicador"]=count($llavesdocente);
        */
        return $arrayinterno;
    }

    function docente($titulo) {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $arrayinterno[$codigocarrera][$titulo]["Docentes"] = $this->docenteCarrera($codigocarrera);
            if($i==0)
                $docentesfinal=$arrayinterno[$codigocarrera][$titulo]["Docentes"];
            if(is_array($docentestmp))
                if(is_array($docentesfinal))
                    $docentesfinal=array_merge($docentesfinal,$docentestmp);
            $docentestmp=$arrayinterno[$codigocarrera][$titulo]["Docentes"];

        }
        $llavesdocente=$this->idDocenteCarrera($docentesfinal);
        $arrayinterno["total"][$titulo]["Indicador"]=count($llavesdocente);
	$this->totalesdocente[$this->codigoperiodo]=count($llavesdocente);
	if($this->codigoperiodo=="TOTAL"){
		foreach($this->totalesdocente as $codigoperiodotmp=>$valor)
			$arrayinterno["total"][$titulo]["Indicador"]+=$valor;
	
	}

        return $arrayinterno;
    }
    function docenteEstudiante($titulo) {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $arrayinterno[$codigocarrera][$titulo]["Docentes"] = $this->docenteCarrera($codigocarrera);
            if($i==0)
                $docentesfinal=$arrayinterno[$codigocarrera][$titulo]["Docentes"];
            if(is_array($docentestmp))
                if(is_array($docentesfinal))
                    $docentesfinal=array_merge($docentesfinal,$docentestmp);
            $docentestmp=$arrayinterno[$codigocarrera][$titulo]["Docentes"];


            $this->objmatriculas->codigoperiodo=$this->codigoperiodo;
            $totalmatriculados=$this->objmatriculas->obtener_total_matriculados_real($codigocarrera,"conteo");
            $arrayinterno[$codigocarrera][$titulo]["Estudiantes"]=$totalmatriculados;

            $arrayinterno["total"][$titulo]["Estudiantes"]+=$arrayinterno[$codigocarrera][$titulo]["Estudiantes"];

        }
        $llavesdocente=$this->idDocenteCarrera($docentesfinal);
		/*echo "llavesdocente<pre>";
			print_r($this->arraycarreras);
		echo "</pre>";*/
        $arrayinterno["total"][$titulo]["Docentes"]=count($llavesdocente);

        if($arrayinterno["total"][$titulo]["Estudiantes"] != 0)
            $arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Docentes"]/$arrayinterno["total"][$titulo]["Estudiantes"])*100,2);
        return $arrayinterno;
    }

    function estudianteDocente($titulo) {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $arrayinterno[$codigocarrera][$titulo]["Docentes"] = $this->docenteCarrera($codigocarrera);
            if($i==0)
                $docentesfinal=$arrayinterno[$codigocarrera][$titulo]["Docentes"];
            if(is_array($docentestmp))
                if(is_array($docentesfinal))
                    $docentesfinal=array_merge($docentesfinal,$docentestmp);
            $docentestmp=$arrayinterno[$codigocarrera][$titulo]["Docentes"];


            $this->objmatriculas->codigoperiodo=$this->codigoperiodo;
            $totalmatriculados=$this->objmatriculas->obtener_total_matriculados_real($codigocarrera,"conteo");
            $arrayinterno[$codigocarrera][$titulo]["Estudiantes"]=$totalmatriculados;

            $arrayinterno["total"][$titulo]["Estudiantes"]+=$arrayinterno[$codigocarrera][$titulo]["Estudiantes"];

        }
        $llavesdocente=$this->idDocenteCarrera($docentesfinal);
		/*echo "llavesdocente<pre>";
			print_r($this->arraycarreras);
		echo "</pre>";*/
        $arrayinterno["total"][$titulo]["Docentes"]=count($llavesdocente);

        if($arrayinterno["total"][$titulo]["Estudiantes"] != 0)
            $arrayinterno["total"][$titulo]["Indicador"]=round(($arrayinterno["total"][$titulo]["Estudiantes"]/$arrayinterno["total"][$titulo]["Docentes"]),2);
        return $arrayinterno;
    }
    function docentePromedioHoras($titulo) {

        $arrayHoras = $this->docenteHoras($titulo);
        $arrayinterno["total"][$titulo]["Horas"] = $arrayHoras["total"][$titulo]["Indicador"]+0;
        $arrayDocente = $this->docente($titulo);
        $arrayinterno["total"][$titulo]["Docentes"] = $arrayDocente["total"][$titulo]["Indicador"];
        if($arrayinterno["total"][$titulo]["Docentes"] != 0)
            $arrayinterno["total"][$titulo]["Indicador"] = round($arrayinterno["total"][$titulo]["Horas"] /  $arrayinterno["total"][$titulo]["Docentes"], 2);

        return $arrayinterno;
    }
    function docenteFormacionProfesional($titulo) {

        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $docentesFinal = $this->docenteCarrera($codigocarrera);
            if(is_array($docentesFinal))
                foreach($docentesFinal as $key => $docenteFila ) {
                    $query="select d.*, tn.nombretiponivelacademico, max(tn.codigosniestiponivelacademico*1)
			from docente d, contratodocente cd , detallecontratodocente dcd, periodo p,nivelacademicodocente nad, tiponivelacademico tn
			where d.iddocente=cd.iddocente
			and cd.idcontratodocente = dcd.idcontratodocente
			and dcd.codigocarrera='$codigocarrera'
			and nad.iddocente=d.iddocente
			and cd.codigoestado like '1%'
			and dcd.codigoestado like '1%'
			and d.codigoestado like '1%'
		and (cd.fechainiciocontratodocente between p.fechainicioperiodo and  p.fechavencimientoperiodo
		or  cd.fechafinalcontratodocente between p.fechainicioperiodo and p.fechavencimientoperiodo
		or p.fechainicioperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		or p.fechavencimientoperiodo between cd.fechainiciocontratodocente and cd.fechafinalcontratodocente
		)
		and p.codigoperiodo ='$this->codigoperiodo'
		and tn.codigotiponivelacademico = nad.codigotiponivelacademico
                and d.iddocente = '".$docenteFila['iddocente']."'
		group by d.iddocente";
                    $resultado=$this->objetobase->conexion->query($query);

                    $this->objmatriculas->codigoperiodo=$this->codigoperiodo;
               while($fila=$resultado->fetchRow()) {

                    $arraydocenteformacion[$fila["iddocente"]]=$fila["nombretiponivelacademico"];
                        $arrayinterno["total"][$titulo][$fila["nombretiponivelacademico"]]++;
                    }
                }

        }

      return $arrayinterno;
    }
    function encontrarPlanEstudios($codigocarrera)
    {
	$query="select p.idplanestudio planestudiovigente,sp.idplanestudio planestudioescogido from planestudio p
left join sicplanestudioactivo sp on sp.idplanestudio in (select idplanestudio from planestudio p2   where p2.codigocarrera='".$codigocarrera."' and p2.codigoestadoplanestudio = '100' and codigoperiodo = '".$this->codigoperiodo."')
 where p.codigocarrera='".$codigocarrera."' and p.codigoestadoplanestudio = '100' 
		and p.idplanestudio=(select max(p3.idplanestudio) from planestudio p3 where p3.codigocarrera='".$codigocarrera."' and p3.codigoestadoplanestudio like '100')";

	$query="select p.idplanestudio planestudiovigente,sp.idplanestudio planestudioescogido from planestudio p, periodo pe
left join sicplanestudioactivo sp on sp.idplanestudio in (select idplanestudio from planestudio p2   where p2.codigocarrera='".$codigocarrera."' and p2.codigoestadoplanestudio = '100') and sp.codigoperiodo='".$this->codigoperiodo."'
 where p.codigocarrera='".$codigocarrera."' and p.codigoestadoplanestudio = '100' 
and pe.fechainicioperiodo >= p.fechacreacionplanestudio 
and pe.codigoperiodo='".$this->codigoperiodo."'
		and p.idplanestudio=(select max(p3.idplanestudio) from planestudio p3 where p3.codigocarrera='".$codigocarrera."' and p3.codigoestadoplanestudio like '100' and pe.fechainicioperiodo >= p3.fechacreacionplanestudio )";

		$resultado=$this->objetobase->conexion->query($query);
		//echo $query;
		$fila=$resultado->fetchRow();
		if(isset($fila['planestudioescogido'])&&trim($fila['planestudioescogido'])!='')
			return $fila['planestudioescogido'];
		return $fila['planestudiovigente'];
    }
    function numeroSemestres($titulo){
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $idplanestudio=$this->encontrarPlanEstudios($codigocarrera);
                      $query="select * from planestudio p where idplanestudio='".$idplanestudio."'";
                    $resultado=$this->objetobase->conexion->query($query);

                    $this->objmatriculas->codigoperiodo=$this->codigoperiodo;
               while($fila=$resultado->fetchRow()) {
                        $arrayinterno["total"][$titulo]["indicador"]+=$fila["cantidadsemestresplanestudio"];
                    }
 		$arrayinterno["total"][$titulo]["planestudios"]=$idplanestudio+0;
       }

         return $arrayinterno;

   }
    function numeroAsignaturas($titulo)
    {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $idplanestudio=$this->encontrarPlanEstudios($codigocarrera);
                      $query="select count(distinct codigomateria) cuentamaterias from planestudio p,detalleplanestudio dp where p.idplanestudio='".$idplanestudio."' and dp.idplanestudio=p.idplanestudio and dp.codigoestadodetalleplanestudio like '1%'";
                    $resultado=$this->objetobase->conexion->query($query);

                    $this->objmatriculas->codigoperiodo=$this->codigoperiodo;
               while($fila=$resultado->fetchRow()) {
                        $arrayinterno["total"][$titulo]["indicador"]+=$fila["cuentamaterias"];
                    }
       }

         return $arrayinterno;

   }

    function numeroCreditos($titulo)
    {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $idplanestudio=$this->encontrarPlanEstudios($codigocarrera);
                      $query="SELECT  sum(dp.numerocreditosdetalleplanestudio) as creditos
	FROM planestudio p, carrera c, tipocantidadelectivalibre t, detalleplanestudio dp
	WHERE p.codigocarrera = c.codigocarrera
	AND p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
	AND p.idplanestudio = '$idplanestudio'
	and p.idplanestudio = dp.idplanestudio
	and dp.codigotipomateria not like '4%'
	group by p.idplanestudio";
                    $resultado=$this->objetobase->conexion->query($query);

                    $this->objmatriculas->codigoperiodo=$this->codigoperiodo;
               while($fila=$resultado->fetchRow()) {
                        $arrayinterno["total"][$titulo]["indicador"]+=$fila["creditos"];
                    }
       }

         return $arrayinterno;

   }   
    function numeroHorasPractica($titulo)
    {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $idplanestudio=$this->encontrarPlanEstudios($codigocarrera);
                      $query="SELECT  sum(m.numerohorassemanales*(m.porcentajepracticamateria/100)) as horapractica
				FROM planestudio p, carrera c, tipocantidadelectivalibre t, detalleplanestudio dp, materia m
				WHERE p.codigocarrera = c.codigocarrera
				AND p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
				AND p.idplanestudio = '".$idplanestudio."'
				and p.idplanestudio = dp.idplanestudio
				and dp.codigotipomateria not like '4%'
				and m.codigomateria=dp.codigomateria
				group by p.idplanestudio";
                    $resultado=$this->objetobase->conexion->query($query);

                    $this->objmatriculas->codigoperiodo=$this->codigoperiodo;
               while($fila=$resultado->fetchRow()) {
                        $arrayinterno["total"][$titulo]["indicador"]+=$fila["horapractica"];
                    }
       }

         return $arrayinterno;

   }   
    function numeroHorasTeorica($titulo)
    {
        foreach($this->arraycarreras as $i => $codigocarrera ) {
            $idplanestudio=$this->encontrarPlanEstudios($codigocarrera);
                      $query="SELECT  sum(m.numerohorassemanales*(if(m.porcentajeteoricamateria='0','100',m.porcentajeteoricamateria)/100))  as horateorica
				FROM planestudio p, carrera c, tipocantidadelectivalibre t, detalleplanestudio dp, materia m
				WHERE p.codigocarrera = c.codigocarrera
				AND p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
				AND p.idplanestudio = '".$idplanestudio."'
				and p.idplanestudio = dp.idplanestudio
				and dp.codigotipomateria not like '4%'
				and m.codigomateria=dp.codigomateria
				group by p.idplanestudio";
                    $resultado=$this->objetobase->conexion->query($query);

                    $this->objmatriculas->codigoperiodo=$this->codigoperiodo;
               while($fila=$resultado->fetchRow()) {
                        $arrayinterno["total"][$titulo]["indicador"]+=$fila["horateorica"];
                    }
       }

         return $arrayinterno;

   }

}
?>