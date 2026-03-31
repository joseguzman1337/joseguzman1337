<?php

// VALORES INICIALES PARA EL REPORTE
//$periodo_inicial='20102';
//$periodo_final='20122';
$periodo_inicial=$dates["periodo_inicial"];
$periodo_final=$dates["periodo_final"];
$arrIndicadores = array( "NÚMERO DE GRADUADOS DE LA COHORTE HASTA UN AÑO LUEGO DE LA FINALIZACIÓN"
			,"NÚMERO DE MATRICULADOS PRIMERA VEZ EN EL PRIMER SEMESTRE"
			,"ÍNDICE DE ESFUERZO DE FORMACIÓN"
			,"DURACIÓN DE ESTUDIOS: NÚMERO DE SEMESTRES QUE DURÓ EL ESTUDIANTE PARA GRADUARSE"
			,"ESTUDIANTES QUE SIGUEN SIENDO ESTUDIANTES TRES SEMESTRES DESPUES"
			,"ESTUDIANTES QUE DESERTAN"
			,"INDICADOR DE RETENCIÓN ESTUDIANTIL");

function graduados ($codigoperiodo,$codigocarrera,$db) {
	$query="SELECT * 
		FROM (
			Select	 fechainicioperiodo
				,fechavencimientoperiodo As fechafinalcondicion 
			From periodo 
			Where codigoperiodo=$codigoperiodo
		) sub1 
		CROSS JOIN (
			Select fechainicioperiodo As fechainicialcondicion 
			From (
				select * 
				from periodo 
				where codigoperiodo<=$codigoperiodo 
				order by codigoperiodo desc 
				limit 2
			) sub 
			Order By codigoperiodo
			Limit 1
		) sub2 ";
	$exec= $db->Execute($query);
	$row = $exec->FetchRow();

	$query2="SELECT cantidadsemestresplanestudio+2 AS semestres
		FROM estudianteestadistica ee
		,carrera c
		,estudiante e
		,planestudioestudiante pee
		,planestudio pe
		WHERE e.codigocarrera = '$codigocarrera'
			AND e.codigocarrera=c.codigocarrera
			AND ee.codigoestudiante=e.codigoestudiante
			AND ee.codigoestudiante=pee.codigoestudiante
			AND pee.idplanestudio=pe.idplanestudio
			AND ee.codigoperiodo = '$codigoperiodo'
			AND ee.codigoprocesovidaestudiante= 400
			AND ee.codigoestado LIKE '1%'
		LIMIT 1";
	$exec2= $db->Execute($query2);

	if($exec2->RecordCount()>0) {
		$row2 = $exec2->FetchRow();
		
		$query3="SELECT codigoperiodo 
			FROM (
				Select codigoperiodo 
				From periodo 
				Where codigoperiodo<=$codigoperiodo 
				Order By codigoperiodo desc 
				Limit ".$row2['semestres']."
			) sub 
			ORDER BY codigoperiodo 
			LIMIT 1";
		$exec3= $db->Execute($query3);
		$row3 = $exec3->FetchRow();
		$codigoperiodo_cohorte=$row3['codigoperiodo'];
		$query4="SELECT codigoestudiante
			FROM (
				Select Distinct ee.codigoestudiante
				From estudianteestadistica ee
				, carrera c
				, estudiante e
				, estudiantegeneral eg
				Where e.codigocarrera = $codigocarrera
					And e.codigocarrera=c.codigocarrera
					And ee.codigoestudiante=e.codigoestudiante
					And eg.idestudiantegeneral=e.idestudiantegeneral
					And ee.codigoperiodo = '$codigoperiodo_cohorte'
					And ee.codigoprocesovidaestudiante= 400
					And ee.codigoestado Like '1%'
					And eg.idestudiantegeneral not in (	select idestudiantegeneral 
										from estudiante e 
										join estudiantegeneral eg using(idestudiantegeneral) 
										where codigoperiodo < '$codigoperiodo_cohorte'
									)
			) sub1
			JOIN (
				Select Distinct rg.codigoestudiante
				From registrograduado rg
				Where fechagradoregistrograduado Between '".$row['fechainicialcondicion']."' And '".$row['fechafinalcondicion']."'
			) sub2 using(codigoestudiante)";
		$exec4= $db->Execute($query4);
		return $exec4->RecordCount();
	} else
		return 0;
}

function matriculados ($codigoperiodo,$codigocarrera,$db) {
	$query="SELECT fechainicioperiodo
		FROM periodo 
		WHERE codigoperiodo=$codigoperiodo ";
	$exec= $db->Execute($query);
	$row = $exec->FetchRow();

	$query2="SELECT cantidadsemestresplanestudio+2 AS semestres
		FROM estudianteestadistica ee
		,carrera c
		,estudiante e
		,planestudioestudiante pee
		,planestudio pe
		WHERE e.codigocarrera = '$codigocarrera'
			AND e.codigocarrera=c.codigocarrera
			AND ee.codigoestudiante=e.codigoestudiante
			AND ee.codigoestudiante=pee.codigoestudiante
			AND pee.idplanestudio=pe.idplanestudio
			AND ee.codigoperiodo = '$codigoperiodo'
			AND ee.codigoprocesovidaestudiante= 400
			AND ee.codigoestado LIKE '1%'
		LIMIT 1";
	$exec2= $db->Execute($query2);
	if($exec2->RecordCount()>0) {
		$row2 = $exec2->FetchRow();
		
		$query3="SELECT codigoperiodo 
			FROM (
				Select codigoperiodo 
				From periodo 
				Where codigoperiodo<=$codigoperiodo 
				Order By codigoperiodo desc 
				Limit ".$row2['semestres']."
			) sub 
			ORDER BY codigoperiodo 
			LIMIT 1";
		$exec3= $db->Execute($query3);
		$row3 = $exec3->FetchRow();
		$codigoperiodo_cohorte=$row3['codigoperiodo'];
		
		$query4="SELECT DISTINCT ee.codigoestudiante
			FROM estudianteestadistica ee
			, carrera c
			, estudiante e
			, estudiantegeneral eg
			WHERE e.codigocarrera = $codigocarrera
				AND e.codigocarrera=c.codigocarrera
				AND ee.codigoestudiante=e.codigoestudiante
				AND eg.idestudiantegeneral=e.idestudiantegeneral
				AND ee.codigoperiodo = '$codigoperiodo_cohorte'
				AND ee.codigoprocesovidaestudiante= 400
				AND ee.codigoestado LIKE '1%'
				AND eg.idestudiantegeneral NOT IN (	Select idestudiantegeneral 
									From estudiante e 
									Join estudiantegeneral eg Using(idestudiantegeneral) 
									Where codigoperiodo < '$codigoperiodo_cohorte'
									)";
		$exec4= $db->Execute($query4);
		return $exec4->RecordCount();
	} else
		return 0;
}

function esfuerzo ($codigoperiodo,$codigocarrera,$db) {
	$graduados=graduados($codigoperiodo,$codigocarrera,$db);
	$matriculados=matriculados($codigoperiodo,$codigocarrera,$db);
        return round(($graduados*100)/$matriculados);
}

function duracion ($codigoperiodo,$codigocarrera,$db) {
	$query="SELECT	 fechainicioperiodo
			,fechavencimientoperiodo 
		FROM periodo 
		WHERE codigoperiodo=$codigoperiodo";
	$exec= $db->Execute($query);
	$row = $exec->FetchRow();
  
	$query="SELECT DISTINCT codigoestudiante
                FROM registrograduado
		JOIN estudiante USING(codigoestudiante)
                WHERE fechagradoregistrograduado BETWEEN '".$row['fechainicioperiodo']."' AND '".$row['fechavencimientoperiodo']."'
	                AND codigocarrera=$codigocarrera";
	$exec= $db->Execute($query);
        $conteoestudiante = $exec->RecordCount();

	$query2="SELECT	 distinct 
			 codigoperiodo
			,codigoestudiante
		FROM ($query) AS sub
		JOIN notahistorico nh USING(codigoestudiante)";
	$exec2= $db->Execute($query2);
        $conteoperiodos = $exec2->RecordCount();

	return round($conteoperiodos/$conteoestudiante);
}

function estudiantes_siguen ($codigoperiodo,$codigocarrera,$db) {
	$query="SELECT codigoperiodo 
		FROM (
			Select codigoperiodo 
			From periodo 
			Where codigoperiodo<$codigoperiodo 
			Order By codigoperiodo Desc 
			Limit 3
		) sub 
		ORDER BY codigoperiodo 
		LIMIT 1";
	$exec= $db->Execute($query);
	$row = $exec->FetchRow();
	$codigoperiodo_cohorte=$row['codigoperiodo'];

	$query="SELECT codigoestudiante
		FROM (
			Select Distinct ee.codigoestudiante
	                From estudianteestadistica ee
			, carrera c
			, estudiante e
			, estudiantegeneral eg
	                Where e.codigocarrera = $codigocarrera
		                And e.codigocarrera=c.codigocarrera
	        	        And ee.codigoestudiante=e.codigoestudiante
	                	And eg.idestudiantegeneral=e.idestudiantegeneral
		                And ee.codigoperiodo = '$codigoperiodo_cohorte'
	        	        And ee.codigoprocesovidaestudiante= 400
		                And ee.codigoestado Like '1%'
				And eg.idestudiantegeneral Not In (	select idestudiantegeneral 
									from estudiante e 
									join estudiantegeneral eg using(idestudiantegeneral) 
									where codigoperiodo < '$codigoperiodo_cohorte'
								)
		) sub1
		JOIN (
			Select Distinct ee.codigoestudiante
			From estudianteestadistica ee
			, carrera c
			, estudiante e
			Where e.codigocarrera = $codigocarrera
				And e.codigocarrera=c.codigocarrera
				And ee.codigoestudiante=e.codigoestudiante
				And ee.codigoperiodo = '$codigoperiodo'
				And ee.codigoprocesovidaestudiante= 401
				And ee.codigoestado Like '1%'
		) sub2 USING(codigoestudiante)";
	$exec= $db->Execute($query);
        return $exec->RecordCount();
}

function desercion ($codigoperiodo,$codigocarrera,$db) {
	$query="SELECT codigoperiodo 
		FROM (
			Select codigoperiodo 
			From periodo 
			Where codigoperiodo<$codigoperiodo 
			Order By codigoperiodo Desc 
			Limit 3
		) sub 
		ORDER BY codigoperiodo 
		LIMIT 1";
	$exec= $db->Execute($query);
	$row = $exec->FetchRow();
	$codigoperiodo_cohorte=$row['codigoperiodo'];

	$query="SELECT codigoestudiante
		FROM (
			Select Distinct ee.codigoestudiante
	                From estudianteestadistica ee
			, carrera c
			, estudiante e
			, estudiantegeneral eg
	                Where e.codigocarrera = $codigocarrera
		                And e.codigocarrera=c.codigocarrera
	        	        And ee.codigoestudiante=e.codigoestudiante
	                	And eg.idestudiantegeneral=e.idestudiantegeneral
		                And ee.codigoperiodo = '$codigoperiodo_cohorte'
	        	        And ee.codigoprocesovidaestudiante= 400
		                And ee.codigoestado Like '1%'
				And eg.idestudiantegeneral Not In (	select idestudiantegeneral 
									from estudiante e 
									join estudiantegeneral eg using(idestudiantegeneral) 
									where codigoperiodo < '$codigoperiodo_cohorte'
								)
		) sub1
		LEFT JOIN (
			Select distinct ee.codigoestudiante
			From estudianteestadistica ee
			, carrera c
			, estudiante e
			Where e.codigocarrera = $codigocarrera
				And e.codigocarrera=c.codigocarrera
				And ee.codigoestudiante=e.codigoestudiante
				And ee.codigoperiodo = '$codigoperiodo'
				And ee.codigoprocesovidaestudiante= 401
				And ee.codigoestado Like '1%'
		) sub2 USING(codigoestudiante)
		WHERE sub2.codigoestudiante IS NULL";
	$exec= $db->Execute($query);
        return $exec->RecordCount();
}
 
function retencion ($codigoperiodo,$codigocarrera,$db) {
	$estudiantes_siguen=estudiantes_siguen($codigoperiodo,$codigocarrera,$db);
	$estudiantes_desertan=desercion($codigoperiodo,$codigocarrera,$db);
	$total_estudiantes=$estudiantes_siguen+$estudiantes_desertan;
        return round(($estudiantes_siguen*100)/$total_estudiantes);
}



?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <thead>           
		<tr class="dataColumns"> 
			<th class="column" colspan="2">&nbsp;</th>
<?PHP
		$query="SELECT codigoperiodo FROM periodo WHERE codigoperiodo BETWEEN ".$periodo_inicial." AND ".$periodo_final." ORDER BY codigoperiodo";
		$exec= $db->Execute($query);
		$arrPeriodos=array();
		while($row = $exec->FetchRow()) {  
			$arrPeriodos[]=$row['codigoperiodo'];
?>
			<th class="column" colspan='<?PHP echo count($arrIndicadores)?>'><span>A&Ntilde;O <?PHP echo $row['codigoperiodo']?></span></th>
<?PHP 		} 
?>
		</tr>
		<tr class="dataColumns"> 
			<th class="column" colspan="2">&nbsp;</th>
<?PHP
			foreach ($arrPeriodos as $per) {
				foreach($arrIndicadores as $key => $value) {
?>
					<th class="column"><span><?PHP echo $value?></span></th>
<?PHP
				}
			}
?>
		</tr>
        </thead>
        <tbody>
<?PHP
		$query="SELECT	 DISTINCT
				 codigomodalidadacademicasic
				,nombremodalidadacademicasic
				,codigocarrera
				,nombrecarrera
			FROM carrera 
			JOIN modalidadacademicasic USING (codigomodalidadacademicasic) 
			WHERE codigomodalidadacademicasic IN (200,300,301,302)
				AND fechavencimientocarrera >=curdate() 
			ORDER BY codigomodalidadacademicasic
				,nombrecarrera";
		$exec= $db->Execute($query);
		$aux="";
		$aux2="";
		$cont2=0;
		$aux3=false;
		while($row = $exec->FetchRow()) { 
			if($aux!=$row['codigomodalidadacademicasic'])  {
				$cont2=0;
				$cols=(count($arrIndicadores)*count($arrPeriodos))+2;
				if($aux3) {
?>				
					<tr class="totalColumns">
						<td colspan="2" style="font-size:25px;font-weight:bold">TOTAL <?PHP echo $aux2?></td>
<?PHP
						foreach ($arrPeriodos as $per_process) {
							foreach($arrIndicadores as $key => $value) {
								switch($key) {
									case 0: $vlr=$sum_graduados[$per_process];break;
									case 1: $vlr=$sum_matriculados[$per_process];break;
									case 2: $vlr="&nbsp;";break;
									case 3: $vlr=$sum_duracion[$per_process];break;
									case 4: $vlr=$sum_estudiantes_siguen[$per_process];break;
									case 5: $vlr=$sum_desercion[$per_process];break;
									case 6: $vlr="&nbsp;";break;
								}
?>	
								<td class="column" style="font-size:25px;font-weight:bold" align="center"><?PHP echo $vlr?></td>
<?PHP
							}
						}
?>
					</tr>
<?PHP				
				}
				$aux3=true;
?>
				<tr class="totalColumns"><td colspan="<?PHP echo $cols?>" style="font-size:25px;font-weight:bold"><?PHP echo $row['nombremodalidadacademicasic']?></td></tr>
<?PHP		
				$sum_graduados=array();
				$sum_matriculados=array();
				$sum_duracion=array();
				$sum_estudiantes_siguen=array();
				$sum_desercion=array();
			}
			$cont2++;
?>
	                <tr class="contentColumns" class="row">
				<td class="column"><?PHP echo $cont2?></td>
				<td class="column"><?PHP echo $row['nombrecarrera']?></td>
<?PHP
				foreach ($arrPeriodos as $per_process) {
					foreach($arrIndicadores as $key => $value) {
						switch($key) {
							case 0: 
								$vlr=graduados($per_process,$row['codigocarrera'],$db);
								$sum_graduados[$per_process]+=$vlr;
								break;
							case 1: 
								$vlr=matriculados($per_process,$row['codigocarrera'],$db);
								$sum_matriculados[$per_process]+=$vlr;
								break;
							case 2: 
								$vlr=esfuerzo($per_process,$row['codigocarrera'],$db)." %";break;
							case 3: 
								$vlr=duracion($per_process,$row['codigocarrera'],$db);
								$sum_duracion[$per_process]+=$vlr;
								break;
							case 4: 
								$vlr=estudiantes_siguen($per_process,$row['codigocarrera'],$db);
								$sum_estudiantes_siguen[$per_process]+=$vlr;
								break;
							case 5: 
								$vlr=desercion($per_process,$row['codigocarrera'],$db);
								$sum_desercion[$per_process]+=$vlr;
								break;
							case 6: 
								$vlr=retencion($per_process,$row['codigocarrera'],$db)." %";break;
						}
?>
						<td class="column" align="center"><?PHP echo $vlr?></td>
<?PHP
					}
				}
?>
			</tr>
<?PHP
			$aux=$row['codigomodalidadacademicasic'];
			$aux2=$row['nombremodalidadacademicasic'];
		}
?>
		<tr id="totalColumns">
			<td colspan="2" style="font-size:25px;font-weight:bold">TOTAL <?PHP echo $aux2?></td>
<?PHP
			foreach ($arrPeriodos as $per_process) {
				foreach($arrIndicadores as $key => $value) {
					switch($key) {
						case 0: $vlr=$sum_graduados[$per_process];break;
						case 1: $vlr=$sum_matriculados[$per_process];break;
						case 2: $vlr="&nbsp;";break;
						case 3: $vlr=$sum_duracion[$per_process];break;
						case 4: $vlr=$sum_estudiantes_siguen[$per_process];break;
						case 5: $vlr=$sum_desercion[$per_process];break;
						case 6: $vlr="&nbsp;";break;
					}
?>	
					<td class="column" style="font-size:25px;font-weight:bold" align="center"><?PHP echo $vlr?></td>
<?PHP
				}
			}
?>
		</tr>
        </tbody>        
</table>
