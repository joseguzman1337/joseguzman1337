<?php

// VALORES INICIALES PARA EL REPORTE
$periodo_inicial='20101';
$periodo_final='20101';
$arrIndicadores = array( "NÚMERO DE GRADUADOS DE LA COHORTE HASTA UN AÑO LUEGO DE LA FINALIZACIÓN"
			,"NÚMERO DE MATRICULADOS PRIMERA VEZ EN EL PRIMER SEMESTRE"
			,"ÍNDICE DE ESFUERZO DE FORMACIÓN"
			,"DURACIÓN DE ESTUDIOS: NÚMERO DE SEMESTRES QUE DURÓ EL ESTUDIANTE PARA GRADUARSE"
			,"ESTUDIANTES QUE SIGUEN SIENDO ESTUDIANTES TRES SEMESTRES DESPUES"
			,"ESTUDIANTES QUE DESERTAN"
			,"INDICADOR DE RETENCIÓN ESTUDIANTIL");
function graduados () {
	return 0;
}

function matriculados ($codigoperiodo,$codigocarrera,$db) {
	$query="SELECT distinct ee.codigoestudiante
                FROM estudianteestadistica ee
		, carrera c
		, estudiante e
		, estudiantegeneral eg
                where e.codigocarrera = $codigocarrera
	                and e.codigocarrera=c.codigocarrera
        	        and ee.codigoestudiante=e.codigoestudiante
                	and eg.idestudiantegeneral=e.idestudiantegeneral
	                and ee.codigoperiodo = '$codigoperiodo'
        	        and ee.codigoprocesovidaestudiante= 400
	                and ee.codigoestado like '1%'
			and eg.idestudiantegeneral not in (	select idestudiantegeneral 
								from estudiante e 
								join estudiantegeneral eg using(idestudiantegeneral) 
								where codigoperiodo < '$codigoperiodo'
							)";
	$exec= $db->Execute($query);
        return $exec->RecordCount();
}

function esfuerzo() {
	return 0;
}

function duracion ($codigoperiodo,$codigocarrera,$db) {
	$query="SELECT fechainicioperiodo,fechavencimientoperiodo from periodo where codigoperiodo=$codigoperiodo";
	$exec= $db->Execute($query);
	$row = $exec->FetchRow();
  
	$query="SELECT distinct codigoestudiante
                FROM registrograduado
		JOIN estudiante using(codigoestudiante)
                where fechagradoregistrograduado between '".$row['fechainicioperiodo']."' and '".$row['fechavencimientoperiodo']."'
	                and codigocarrera=$codigocarrera";
	$exec= $db->Execute($query);
        $conteoestudiante = $exec->RecordCount();

	$query2="select distinct 
			codigoperiodo
			,codigoestudiante
		from ($query) as sub
		join notahistorico nh using(codigoestudiante)";
	$exec2= $db->Execute($query2);
        $conteoperiodos = $exec2->RecordCount();

	return round($conteoperiodos/$conteoestudiante);
}

function estudiantes_siguen() {
	return 0;
}

function desercion ($codigoperiodoinicial,$codigocarrera,$db) {
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
                        $periodoinicial= $aniofinal.$indiceperiodo;

         $codigoperiodoinicial=$periodoinicial;
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
                        $periodofinal= $aniofinal.$indiceperiodo;

                        $query1="SELECT distinct e.codigoestudiante
                        FROM ordenpago o, detalleordenpago d, carrera c,
                        concepto co, prematricula pr, estudiantegeneral eg, estudiante e
                        left join historicosituacionestudiante h on
                        h.idhistoricosituacionestudiante =
                        (
                        select max(hh.idhistoricosituacionestudiante) from historicosituacionestudiante hh where
                        hh.codigoestudiante=e.codigoestudiante and
                        hh.codigoperiodo='$periodoinicial'
                        group by hh.codigoestudiante
                        )
                     left join situacioncarreraestudiante sce on
                       h.codigosituacioncarreraestudiante =sce.codigosituacioncarreraestudiante
                      left join situacioncarreraestudiante sce2 on
                      e.codigosituacioncarreraestudiante =sce2.codigosituacioncarreraestudiante
                                                   WHERE o.numeroordenpago=d.numeroordenpago
                       AND pr.codigoperiodo='$periodoinicial'
                       AND e.codigoestudiante=pr.codigoestudiante
                       AND e.codigoestudiante=o.codigoestudiante
                       AND d.codigoconcepto=co.codigoconcepto
                       AND co.cuentaoperacionprincipal=151
                       AND o.codigoperiodo='$periodoinicial'
                       AND o.codigoestadoordenpago LIKE '4%'
                       and c.codigocarrera=e.codigocarrera

                       and eg.idestudiantegeneral=e.idestudiantegeneral
                                                   and c.codigocarrera <> 13
                       and e.codigosituacioncarreraestudiante not in (400,104,107,105,106,111,109,112)
                        and e.codigocarrera='$codigocarrera'

                        and (h.idhistoricosituacionestudiante  not in (
                       select h.idhistoricosituacionestudiante from historicosituacionestudiante h
                       where h.codigosituacioncarreraestudiante in (400,104,107,105,106,111,109,112,108)
                       and   h.codigoperiodo='$periodoinicial'
                       )
                        or (h.idhistoricosituacionestudiante is null and e.codigosituacioncarreraestudiante not in (400,104,107,105,106,111,109,112,108))
                        )
                       and e.idestudiantegeneral not in (
                       SELECT e.idestudiantegeneral
                       FROM ordenpago o, detalleordenpago d, estudiante e, carrera c,
                       concepto co, prematricula pr, estudiantegeneral eg
                       WHERE o.numeroordenpago=d.numeroordenpago
                       AND pr.codigoperiodo>'$periodoinicial'
                       AND e.codigoestudiante=pr.codigoestudiante
                       AND e.codigoestudiante=o.codigoestudiante
                       AND d.codigoconcepto=co.codigoconcepto
                       AND co.cuentaoperacionprincipal=151
                       AND o.codigoperiodo=pr.codigoperiodo
                       AND o.codigoestadoordenpago LIKE '4%'
                       and c.codigocarrera=e.codigocarrera

                       and eg.idestudiantegeneral=e.idestudiantegeneral
                        and e.codigocarrera='$codigocarrera'
                       )
                       GROUP by e.codigoestudiante";

                        $query2="SELECT distinct e.codigoestudiante
                       FROM ordenpago o, detalleordenpago d, carrera c,
                       concepto co, prematricula pr, estudiantegeneral eg, estudiante e
                       left join historicosituacionestudiante h on
                        h.idhistoricosituacionestudiante =
                        (
                        select max(hh.idhistoricosituacionestudiante) from historicosituacionestudiante hh where
                        hh.codigoestudiante=e.codigoestudiante and
                        hh.codigoperiodo='$periodofinal'
                        group by hh.codigoestudiante
                        )
                         left join situacioncarreraestudiante sce on
                           h.codigosituacioncarreraestudiante =sce.codigosituacioncarreraestudiante
                          left join situacioncarreraestudiante sce2 on
                          e.codigosituacioncarreraestudiante =sce2.codigosituacioncarreraestudiante
                                                       WHERE o.numeroordenpago=d.numeroordenpago
                           AND pr.codigoperiodo='$periodofinal'
                           AND e.codigoestudiante=pr.codigoestudiante
                           AND e.codigoestudiante=o.codigoestudiante
                           AND d.codigoconcepto=co.codigoconcepto
                           AND co.cuentaoperacionprincipal=151
                           AND o.codigoperiodo='$periodofinal'
                           AND o.codigoestadoordenpago LIKE '4%'
                           and c.codigocarrera=e.codigocarrera

                           and eg.idestudiantegeneral=e.idestudiantegeneral
                                                       and c.codigocarrera <> 13
                           and e.codigosituacioncarreraestudiante not in (400,104,107,105,106,111,109,112)
                            and e.codigocarrera='$codigocarrera'

                            and( h.idhistoricosituacionestudiante in (
                           select h.idhistoricosituacionestudiante from historicosituacionestudiante h
                           where h.codigosituacioncarreraestudiante in (108)
                           and   h.codigoperiodo='$periodofinal'
                            )
                            or (h.idhistoricosituacionestudiante is null and e.codigosituacioncarreraestudiante = '108'))
                           and e.idestudiantegeneral not in (
                           SELECT e.idestudiantegeneral
                           FROM ordenpago o, detalleordenpago d, estudiante e, carrera c,
                           concepto co, prematricula pr, estudiantegeneral eg
                           WHERE o.numeroordenpago=d.numeroordenpago
                           AND pr.codigoperiodo>'$periodofinal'
                           AND e.codigoestudiante=pr.codigoestudiante
                           AND e.codigoestudiante=o.codigoestudiante
                           AND d.codigoconcepto=co.codigoconcepto
                           AND co.cuentaoperacionprincipal=151
                           AND o.codigoperiodo=pr.codigoperiodo
                           AND o.codigoestadoordenpago LIKE '4%'
                           and c.codigocarrera=e.codigocarrera

                           and eg.idestudiantegeneral=e.idestudiantegeneral
                            and e.codigocarrera='$codigocarrera'
                               )
                               GROUP by e.codigoestudiante";

        $query = "$query1 UNION $query2";
	$exec= $db->Execute($query);
        return $exec->RecordCount();
}
 
function retencion() {
	return 0;
}



?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <thead>           
		<tr id="dataColumns"> 
			<th class="column" colspan="2">&nbsp;</th>
<?PHP 
		$query="select codigoperiodo from periodo where codigoperiodo between ".$periodo_inicial." and ".$periodo_final." order by codigoperiodo";
		$exec= $db->Execute($query);
		$arrPeriodos=array();
		while($row = $exec->FetchRow()) {  
			$arrPeriodos[]=$row['codigoperiodo'];
?>
			<th class="column" colspan='<?PHP echo count($arrIndicadores)?>'><span>A&Ntilde;O <?PHP echo $row['codigoperiodo']?></span></th>
<?PHP  		} 
?>
		</tr>
		<tr id="dataColumns"> 
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
		$query="select	 codigomodalidadacademicasic
				,nombremodalidadacademicasic
				,codigocarrera
				,nombrecarrera
			from carrera 
			join modalidadacademicasic using (codigomodalidadacademicasic) 
			where codigomodalidadacademicasic in (200,300,301,302) 
				and fechavencimientocarrera >=curdate() 
			order by codigomodalidadacademicasic
				,nombrecarrera";
		$exec= $db->Execute($query);
		$aux="";
		$cont2=0;
		while($row = $exec->FetchRow()) { 
			if($aux!=$row['codigomodalidadacademicasic'])  {
				$cont2=0;
				$cols=(count($arrIndicadores)*count($arrPeriodos))+2;
?>
				<tr id="totalColumns"><td colspan="<?PHP echo $cols?>" style="font-size:25px;font-weight:bold"><?PHP echo $row['nombremodalidadacademicasic']?></td></tr>
<?PHP 			}
			$cont2++;
?>
	                <tr id="contentColumns" class="row">
				<td class="column"><?PHP echo $cont2?></td>
				<td class="column"><?PHP echo $row['nombrecarrera']?></td>
<?PHP 
				foreach ($arrPeriodos as $per_process) {
					foreach($arrIndicadores as $key => $value) {
						switch($key) {
							case 0: $vlr=graduados();break;
							case 1: $vlr=matriculados($per_process,$row['codigocarrera'],$db);break;
							case 2: $vlr=esfuerzo();break;
							case 3: $vlr=duracion($per_process,$row['codigocarrera'],$db);break;
							case 4: $vlr=estudiantes_siguen();break;
							case 5: $vlr=desercion($per_process,$row['codigocarrera'],$db);break;
							case 6: $vlr=retencion();break;
						}
?>
						<td class="column"><?PHP echo $vlr?></td>
<?PHP 
					}
				}
?>
			</tr>
<?PHP 
			$aux=$row['codigomodalidadacademicasic'];
		}
?>
        </tbody>        
<!--
           
                <tr id="contentColumns" class="row">
                    <td class="column">Prueba</td>                                
                    
                        <td style="text-align:center"> Prueba</td>
                </tr>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>                
                 
                    <td style="text-align:center"> 100</td>
            </tr>
        </tfoot>
-->
</table>
