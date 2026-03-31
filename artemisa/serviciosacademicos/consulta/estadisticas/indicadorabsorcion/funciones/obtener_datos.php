<?php
class obtener_datos_matriculas {
    var $codigoperiodo;
    var $conexion;
    var $fechahoy;
    var $periodo_anterior;
    var $periodos;

    function obtener_datos_matriculas($conexion,$codigoperiodo) {
        $this->conexion=$conexion;
        $this->codigoperiodo=$codigoperiodo;
        $this->fechahoy=date("Y-m-d H:i:s");
        $this->obtener_periodo_anterior();
    }

    function obtener_periodo_anterior() {
        $query_obtener_periodo_anterior="
		SELECT p.codigoperiodo FROM periodo p
		WHERE
		p.codigoperiodo <= '".$this->codigoperiodo."'
		ORDER by 1 DESC
		";
        $operacion_periodo_anterior=$this->conexion->query($query_obtener_periodo_anterior);
        $row_operacion_periodo_anterior=$operacion_periodo_anterior->fetchRow();
        do {
            $array_periodo[]=$row_operacion_periodo_anterior;
        }
        while($row_operacion_periodo_anterior=$operacion_periodo_anterior->fetchRow());
        $this->periodo_anterior=$array_periodo[1]['codigoperiodo'];
        $this->periodos=$array_periodo;
        //echo "<h1>".$this->periodo_anterior."</h1>";
    }

    function obtener_carreras($codigomodalidadacademica="",$codigocarrera="") {
        if($codigocarrera!="") {
            $query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica,c.codigocentrobeneficio as centrobeneficio
		FROM

carrera c
WHERE
c.codigocarrera='".$codigocarrera."'
AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
        }
        elseif($codigomodalidadacademica!="") {
            $query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica,c.codigocentrobeneficio as centrobeneficio
FROM
carrera c
WHERE
c.codigomodalidadacademica='".$codigomodalidadacademica."'
AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
        }
        else {
            $query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica,c.codigocentrobeneficio as centrobeneficio
FROM
carrera c
WHERE
c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
ORDER BY c.codigocarrera
			";
        }
        //echo $query_obtener_carreras;
        $obtener_carreras=$this->conexion->query($query_obtener_carreras);
        $row_obtener_carreras=$obtener_carreras->fetchRow();
        do {
            $array_obtener_carreras[]=$row_obtener_carreras;
        }
        while($row_obtener_carreras=$obtener_carreras->fetchRow());
        $this->array_obtener_carreras=$array_obtener_carreras;
        return $array_obtener_carreras;
    }

    function obtenerCarrerasSnies($codigocarrera=null) {
        if($codigocarrera<>null) {
           echo $query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica,cr.*
			FROM
			carrera c
			LEFT JOIN carreraregistro cr ON cr.codigocarrera=c.codigocarrera
			WHERE
			c.codigomodalidadacademica in(200,300)
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			AND c.codigocarrera not in(1,12,79,96,117,262,264,355,434,468,2,3,6,7,13,30,39,74,92,94,97,120,138,204,417,554,560)
			AND c.codigocarrera='$codigocarrera'
			ORDER BY c.codigocarrera";

        }
        else {
            $query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica,cr.*
			FROM
			carrera c
			LEFT JOIN carreraregistro cr ON cr.codigocarrera=c.codigocarrera
			WHERE
			(c.codigomodalidadacademica=200 or c.codigomodalidadacademica=300)
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			AND c.codigocarrera <> 13
			ORDER BY c.codigocarrera";
        }
        $obtener_carreras=$this->conexion->query($query_obtener_carreras);
        $row_obtener_carreras=$obtener_carreras->fetchRow();
        do {
            $array_obtener_carreras[$row_obtener_carreras['codigocarrera']]=$row_obtener_carreras;
        }
        while($row_obtener_carreras=$obtener_carreras->fetchRow());
        $this->array_obtener_carreras=$array_obtener_carreras;
        return $array_obtener_carreras;
    }

    function obtenerInfoSNIES($codigoestudiante) {
        $query="SELECT
		1729 AS IES_CODE,
		SUBSTRING_INDEX(eg.apellidosestudiantegeneral,' ',1) AS 'PRIMER_APELLIDO',
		SUBSTRING_INDEX(eg.apellidosestudiantegeneral,' ',-1) AS 'SEGUNDO_APELLIDO',
		SUBSTRING_INDEX(eg.nombresestudiantegeneral,' ',1) AS 'PRIMER_NOMBRE',
		SUBSTRING_INDEX(eg.nombresestudiantegeneral,' ',-1) AS 'SEGUNDO_NOMBRE',
		DATE_FORMAT(p.fechainicioperiodo,'%Y-%m-%d') AS 'FECHA_INGR',
		DATE_FORMAT(eg.fechanacimientoestudiantegeneral,'%Y-%m-%d') AS 'FECHA_NACIM',
		IF(eg.codigogenero='100','02','01') AS 'GENERO_CODE',
		eg.emailestudiantegeneral AS 'EMAIL',
		'01' AS 'EST_CIVIL_CODE',
		(CASE
		WHEN eg.tipodocumento=01 THEN 'CC'
		WHEN eg.tipodocumento=02 THEN 'TI'
		WHEN eg.tipodocumento=03 THEN 'CE'
		WHEN eg.tipodocumento=04 THEN 'RC'
		WHEN eg.tipodocumento=05 THEN 'PS'
		WHEN eg.tipodocumento=06 THEN 'NI'
		WHEN eg.tipodocumento=07 THEN 'NI'
		WHEN eg.tipodocumento=08 THEN 'NI'
		WHEN eg.tipodocumento=09 THEN 'NI'
		WHEN eg.tipodocumento=10 THEN 'NI'
                WHEN eg.tipodocumento=11 THEN 'CC'
		END) AS TIPO_DOC_UNICO,
		eg.numerodocumento as CODIGO_UNICO,
		'' as TIPO_ID_ANT,
		'' as CODIGO_ID_ANT,
		eg.idciudadnacimiento,
		eg.ciudadresidenciaestudiantegeneral,
		eg.telefonoresidenciaestudiantegeneral,
		e.codigocarrera
		FROM estudiante e, estudiantegeneral eg, periodo p
		WHERE
		e.codigoperiodo=p.codigoperiodo
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND e.codigoestudiante='$codigoestudiante'
                ";
        $operacion=$this->conexion->query($query);
        $rowOperacion=$operacion->fetchRow();
        return $rowOperacion;
    }


    function obtener_datos_codigosituacioncarreraestudiante($codigocarrera,$codigosituacioncarreraestudiante,$retorno) {
        $query="
		SELECT e.codigoestudiante,e.codigocarrera
		FROM
		estudiante e
		WHERE
		e.codigocarrera = '$codigocarrera'
		AND e.codigosituacioncarreraestudiante='".$codigosituacioncarreraestudiante."'
		AND e.codigoperiodo='".$this->codigoperiodo."'
		";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                $array_interno[]=$row_operacion;
            }
        }
        while($row_operacion=$operacion->fetchRow());
        //$this->listar($array_interno);
        $conteo=count($array_interno);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $array_interno;
        }
    }

    function ObtenerDatosodigosituacioncarreraestudianteConPreinscripcion($codigocarrera,$codigosituacioncarreraestudiante,$retorno) {
        $query="
		SELECT e.codigoestudiante,e.codigocarrera
		FROM
		estudiante e,
		estudiantegeneral eg,
		preinscripcion pi
		WHERE
		e.codigocarrera = '$codigocarrera'
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND eg.numerodocumento=pi.numerodocumento
		AND e.codigosituacioncarreraestudiante='".$codigosituacioncarreraestudiante."'
		AND e.codigoperiodo='".$this->codigoperiodo."'
		";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                $array_interno[]=$row_operacion;
            }
        }
        while($row_operacion=$operacion->fetchRow());
        //$this->listar($array_interno);
        $conteo=count($array_interno);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $array_interno;
        }
    }

    function ObtenerAspirantes($codigocarrera,$codigoperiodo,$retorno) {
        $query="SELECT e.codigoestudiante,e.codigoperiodo
		FROM estudiante e
		WHERE e.codigocarrera = '$codigocarrera'
		AND e.codigoperiodo='$codigoperiodo'
        and e.codigosituacioncarreraestudiante not in(109, 111)
		UNION
		SELECT e.codigoestudiante,e.codigoperiodo
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=153
		AND (o.codigoestadoordenpago LIKE '1%' OR o.codigoestadoordenpago LIKE '4%')
		AND o.codigoperiodo='$codigoperiodo'
		AND c.codigocarrera='$codigocarrera'
		ORDER BY 1
                ";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                $array_interno[]=$row_operacion;
            }
        }
        while($row_operacion=$operacion->fetchRow());
        //$this->listar($array_interno);
        $conteo=count($array_interno);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $array_interno;
        }
    }

    function ObtenerAspirantesSinmatriculaSinPago($codigocarrera,$codigoperiodo,$retorno) {
        /*$query="
        SELECT e.codigoestudiante,e.codigoperiodo,e.codigosituacioncarreraestudiante
        FROM estudiante e
        WHERE e.codigocarrera = '$codigocarrera'
        AND e.codigoperiodo='$codigoperiodo'
        and e.codigoestudiante not in(
            SELECT e2.codigoestudiante
            FROM ordenpago o2, detalleordenpago d2, estudiante e2, carrera c2, concepto co2
            WHERE o2.numeroordenpago=d2.numeroordenpago
            AND e2.codigoestudiante=o2.codigoestudiante
            AND c2.codigocarrera=e2.codigocarrera
            AND d2.codigoconcepto=co2.codigoconcepto
            AND co2.cuentaoperacionprincipal=153
            AND (o2.codigoestadoordenpago LIKE '4%')
            AND o2.codigoperiodo='$codigoperiodo'
            AND c2.codigocarrera='$codigocarrera'
            and e2.codigoestudiante = e.codigoestudiante
        )
        ORDER BY 1";*/
        $query="SELECT distinct ee.codigoestudiante, ee.codigoperiodo,  e.codigosituacioncarreraestudiante
                FROM estudianteestadistica ee, carrera c, estudiante e
                where e.codigocarrera = '$codigocarrera'
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo = '$codigoperiodo'
                and ee.codigoprocesovidaestudiante= 101
                and ee.codigoestado like '1%'
                and ee.estudianteestadisticafechafinal > now()";
        //and e.codigosituacioncarreraestudiante=106
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                //if($row_operacion['codigosituacioncarreraestudiante']=='106') {
                    $array_interno[]=$row_operacion;
                //}
            }
        }
        while($row_operacion=$operacion->fetchRow());
        //$this->listar($array_interno);
        $conteo=count($array_interno);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $array_interno;
        }
    }

    function seguimiento_formulariovsinscripcion($codigocarrera,$retorno) {
        $arreglo_formularios=$this->obtener_datos_cuentaoperacionprincipal($this->codigoperiodo,$codigocarrera,152,'arreglo');
        $arreglo_inscripciones=$this->obtener_datos_cuentaoperacionprincipal($this->codigoperiodo,$codigocarrera,153,'arreglo');
        if(is_array($arreglo_formularios) and is_array($arreglo_inscripciones)) {

            foreach ($arreglo_formularios as $llave => $valor) {
                $bandera=false;
                foreach ($arreglo_inscripciones as $llave_int => $valor_int) {
                    if($valor['codigoestudiante']==$valor_int['codigoestudiante']) {
                        $bandera=true;
                    }
                }
                if($bandera==false) {
                    $array_diferencia[]['codigoestudiante']=$valor['codigoestudiante'];
                }
            }
        }
        $conteo=count($array_diferencia);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $array_diferencia;
        }
    }

    // Admitidos no matriculados
    function seguimiento_inscripcionvsmatriculadosnuevos_bk($codigocarrera,$retorno) {
        $array_inscripcion=$this->obtener_datos_cuentaoperacionprincipal($this->codigoperiodo,$codigocarrera,153,'arreglo');
        $array_matriculados_nuevos=$this->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,'arreglo');

        if(is_array($array_matriculados_nuevos) and is_array($array_inscripcion)) {
            foreach ($array_inscripcion as $llave => $valor) {
                $bandera=false;
                foreach ($array_matriculados_nuevos as $llave_int => $valor_int) {
                    if($valor['codigoestudiante']==$valor_int['codigoestudiante']) {
                        $bandera=true;
                    }
                }
                if($bandera==false) {
                    $array_diferencia[]['codigoestudiante']=$valor['codigoestudiante'];
                }
            }
        }
        $conteo=count($array_diferencia);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $array_diferencia;
        }
    }


    function seguimiento_inscripcionvsmatriculadosnuevos($codigocarrera,$retorno) {
        $array_inscripcion=$this->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago_admitidos($this->codigoperiodo,$codigocarrera,153,'arreglo');
        $array_matriculados_nuevos=$this->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,'arreglo');

        $array_diferencia=$this->RestarDosArraysBidimensionalesFilas($array_inscripcion,$array_matriculados_nuevos,'codigoestudiante');
        $conteo=count($array_diferencia);

        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $array_diferencia;
        }
    }

    function RestarDosArraysBidimensionalesFilas($array1,$array2,$llavecomun) {
        //if(is_array($array1) and is_array($array2))
        {
            foreach ($array1 as $llave => $valor) {
                $bandera=false;
                foreach (@$array2 as $llave_int => $valor_int) {
                    if($valor[$llavecomun]==$valor_int[$llavecomun]) {
                        $bandera=true;
                    }
                }
                if($bandera==false) {
                    $array_diferencia[][$llavecomun]=$valor[$llavecomun];
                }
            }
        }
        //echo "<h1>".count($array_diferencia)."</h1>";
        return $array_diferencia;
    }

    function obtener_datos_aspirantes_vs_inscritos($codigoperiodo,$codigocarrera,$retorno) {
        //$arreglo_aspirantes=$this->obtener_datos_codigosituacioncarreraestudiante($codigocarrera,106,'arreglo');
        $arreglo_aspirantes=$this->ObtenerAspirantes($codigocarrera,$codigoperiodo,'arreglo');
        $arreglo_inscritos=$this->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$codigocarrera,153,'arreglo');
        $array_diferencia=$this->RestarDosArraysBidimensionalesFilas($arreglo_aspirantes,$arreglo_inscritos,'codigoestudiante');
        $conteo=count($array_diferencia);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $array_diferencia;
        }
    }

    function obtener_datos_cuentaoperacionprincipal($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        $query="SELECT e.codigoestudiante,e.codigoperiodo
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo='$codigoperiodo'
		AND c.codigocarrera='$codigocarrera'
		GROUP BY e.codigoestudiante
                ";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    // Obtiene los estudiantes que sacaron credito
    function obtener_datos_estudiantes_financiados($codigocarrera,$retorno) {
        $query="select e.codigoestudiante, h.codigoperiodo
        from situacioncarreraestudiante s, historicosituacionestudiante h, estudiante e
        where s.codigosituacioncarreraestudiante = h.codigosituacioncarreraestudiante
        and h.codigoperiodo = '$this->codigoperiodo'
        and h.codigosituacioncarreraestudiante = 114
        and now() between h.fechainiciohistoricosituacionestudiante and h.fechafinalhistoricosituacionestudiante
        and e.codigocarrera = '$codigocarrera'
        and e.codigoestudiante = h.codigoestudiante
        GROUP BY e.codigoestudiante";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    // Obtiene los estudiantes en desercion
    function obtener_datos_estudiantes_desercion($codigocarrera,$retorno) {

        /*$codigoperiodoinicial=$this->periodos[2]["codigoperiodo"];
        $anioinicial=$codigoperiodoinicial[0].$codigoperiodoinicial[1].$codigoperiodoinicial[2].$codigoperiodoinicial[3];
        if($codigoperiodoinicial[4]=="1") {
            $indiceperiodo="2";
            $aniofinal=$anioinicial;
        }
        else {
            $indiceperiodo="1";
            $aniofinal=$anioinicial + 1;
        }
        $periodoposterior=$aniofinal.$indiceperiodo;


        $periodoanterior=$this->periodos[2]["codigoperiodo"];

        $query1="SELECT e.codigoestudiante,e.codigoperiodo
        FROM ordenpago o, detalleordenpago d, carrera c, concepto co, prematricula pr, estudiantegeneral eg, estudiante e
        left join historicosituacionestudiante h on h.idhistoricosituacionestudiante =
        (
            select max(hh.idhistoricosituacionestudiante)
            from historicosituacionestudiante hh
            where hh.codigoestudiante=e.codigoestudiante
            and hh.codigoperiodo='$this->periodo_anterior'
            group by hh.codigoestudiante
        )
        left join situacioncarreraestudiante sce on h.codigosituacioncarreraestudiante =sce.codigosituacioncarreraestudiante
        left join situacioncarreraestudiante sce2 on e.codigosituacioncarreraestudiante =sce2.codigosituacioncarreraestudiante
        WHERE o.numeroordenpago=d.numeroordenpago
        AND pr.codigoperiodo='$this->periodo_anterior'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND o.codigoperiodo='$this->periodo_anterior'
        AND o.codigoestadoordenpago LIKE '4%'
        and c.codigocarrera=e.codigocarrera
        and eg.idestudiantegeneral=e.idestudiantegeneral
        and c.codigocarrera <> 13
        and e.codigosituacioncarreraestudiante not in (400,104,107,105,106,111,109,112)
        AND e.codigocarrera='$codigocarrera'
        and h.idhistoricosituacionestudiante not in
        (
            select h.idhistoricosituacionestudiante
            from historicosituacionestudiante h
            where h.codigosituacioncarreraestudiante in (400,104,107,105,106,111,109,112)
            and h.codigoperiodo='$this->periodo_anterior'
        )

         and ( e.codigoestudiante not in (
                select h.codigoestudiante from historicosituacionestudiante h
                where h.codigosituacioncarreraestudiante in (108)
                and   h.codigoperiodo in ('".$periodoposterior."')
		and h.codigoestudiante=e.codigoestudiante
                )
        )


        and e.idestudiantegeneral not in
        (
            SELECT e.idestudiantegeneral
            FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr, estudiantegeneral eg
            WHERE o.numeroordenpago=d.numeroordenpago
            AND pr.codigoperiodo>'$this->periodo_anterior'
            AND e.codigoestudiante=pr.codigoestudiante
            AND e.codigoestudiante=o.codigoestudiante
            AND d.codigoconcepto=co.codigoconcepto
            AND co.cuentaoperacionprincipal=151
            AND o.codigoperiodo=pr.codigoperiodo
            AND o.codigoestadoordenpago LIKE '4%'
            and c.codigocarrera=e.codigocarrera
            and eg.idestudiantegeneral=e.idestudiantegeneral
            AND e.codigocarrera='$codigocarrera'
        )
        GROUP by e.codigoestudiante";

        $query2="SELECT e.codigoestudiante,e.codigoperiodo
                               FROM ordenpago o, detalleordenpago d, carrera c,
                               concepto co, prematricula pr, estudiantegeneral eg, estudiante e
                               left join historicosituacionestudiante h on
                                                    h.idhistoricosituacionestudiante =

(
select max(hh.idhistoricosituacionestudiante) from historicosituacionestudiante hh where
hh.codigoestudiante=e.codigoestudiante and
hh.codigoperiodo='".$periodoanterior."'
group by hh.codigoestudiante
)
                             left join situacioncarreraestudiante sce on
                               h.codigosituacioncarreraestudiante =sce.codigosituacioncarreraestudiante
                              left join situacioncarreraestudiante sce2 on
                              e.codigosituacioncarreraestudiante =sce2.codigosituacioncarreraestudiante
							   WHERE o.numeroordenpago=d.numeroordenpago
                               AND pr.codigoperiodo='".$periodoanterior."'
                               AND e.codigoestudiante=pr.codigoestudiante
                               AND e.codigoestudiante=o.codigoestudiante
                               AND d.codigoconcepto=co.codigoconcepto
                               AND co.cuentaoperacionprincipal=151
                               AND o.codigoperiodo='".$periodoanterior."'
                               AND o.codigoestadoordenpago LIKE '4%'
                               and c.codigocarrera=e.codigocarrera
                               and eg.idestudiantegeneral=e.idestudiantegeneral
							   and c.codigocarrera <> 13
                               and e.codigosituacioncarreraestudiante not in (400,104,107,105,106,111,109,112)
           			 AND e.codigocarrera='$codigocarrera'

				and( h.idhistoricosituacionestudiante in (
                                               select h.idhistoricosituacionestudiante from historicosituacionestudiante h
                                               where h.codigosituacioncarreraestudiante in (108)
                                               and   h.codigoperiodo='".$periodoanterior."'
	                               )
				or (h.idhistoricosituacionestudiante is null and e.codigosituacioncarreraestudiante = '108'))

                               and e.idestudiantegeneral not in (
                                               SELECT e.idestudiantegeneral
                                               FROM ordenpago o, detalleordenpago d, estudiante e, carrera c,
                                               concepto co, prematricula pr, estudiantegeneral eg
                                               WHERE o.numeroordenpago=d.numeroordenpago
                                               AND pr.codigoperiodo>'".$periodoanterior."'
                                               AND e.codigoestudiante=pr.codigoestudiante
                                               AND e.codigoestudiante=o.codigoestudiante
                                               AND d.codigoconcepto=co.codigoconcepto
                                               AND co.cuentaoperacionprincipal=151
                                               AND o.codigoperiodo=pr.codigoperiodo
                                               AND o.codigoestadoordenpago LIKE '4%'
                                               and c.codigocarrera=e.codigocarrera

                                               and eg.idestudiantegeneral=e.idestudiantegeneral
					 	AND e.codigocarrera='$codigocarrera'
                               )
                               GROUP by e.codigoestudiante ";*/

        /* Se comento el codigo de arriba con el fin de que la estadistica quede con los datos reales como en el
         * LISTADO DESERCION  A PARTIR DE 2010
         * se deja comentado en caso de que halla que dejarlo como antes
         */
        $codigoperiodoinicial=$this->codigoperiodo;
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

                        $query1="SELECT e.codigoestudiante,e.codigoperiodo,e.semestre,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
                        eg.numerodocumento,c.nombrecarrera,e.codigoperiodo periodoingreso,pr.codigoperiodo periodo_salida,
                        sce.nombresituacioncarreraestudiante Situacion_Periodo_Salida,sce2.nombresituacioncarreraestudiante Situacion_Actual
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

                        $query2="SELECT e.codigoestudiante,e.codigoperiodo,e.semestre,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
                        eg.numerodocumento,c.nombrecarrera,e.codigoperiodo periodoingreso,pr.codigoperiodo periodo_salida,
                        sce.nombresituacioncarreraestudiante Situacion_Periodo_Salida,sce2.nombresituacioncarreraestudiante Situacion_Actual
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
                               GROUP by e.codigoestudiante
                               order by apellidosestudiantegeneral,nombresestudiantegeneral";

        $query = $query1 ." UNION ". $query2;
       // exit();
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_cuentaoperacionprincipal_ordenesnopagas($codigoperiodo,$codigocarrera,$cuentaoperacionprinicipal,$retorno) {
        $query="SELECT e.codigoestudiante
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND e.codigocarrera='$codigocarrera'
		AND co.cuentaoperacionprincipal='$cuentaoperacionprinicipal'
		AND o.codigoperiodo='".$codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '1%'
		GROUP by e.codigoestudiante
		";
        //exit();

        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                $arreglo_interno[]=$row_operacion;
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_cuentaoperacionprincipal_estudiantes_no_aplica($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno)//excluyendo situacioncarreraestudiante like 4% y like 1%
    {
        $query="SELECT e.codigoestudiante,e.codigoperiodo
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo='$codigoperiodo'
		AND c.codigocarrera='$codigocarrera'
		AND e.codigosituacioncarreraestudiante not like '4%'
		AND e.codigosituacioncarreraestudiante not like '1%'
		GROUP BY e.codigoestudiante
                ";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                $arreglo_interno[]=$row_operacion;
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    // INSCRITOS
    function ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        if(trim($codigocarrera)!='')
            $carrera = " AND e.codigocarrera='".$codigocarrera."'";
        //AND e.codigosituacioncarreraestudiante <> '106'


        /*$query="SELECT e.codigoestudiante,e.codigoperiodo
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo='$codigoperiodo'
		AND c.codigocarrera=e.codigocarrera
                $carrera
        UNION
		SELECT e.codigoestudiante,
		i.codigoperiodo
		FROM
		estudiante e, inscripcion i, estudiantecarrerainscripcion eci
		WHERE
		e.idestudiantegeneral = i.idestudiantegeneral
		AND i.codigosituacioncarreraestudiante = '111'
        AND e.codigosituacioncarreraestudiante not in(106, 109)
		AND i.idinscripcion=eci.idinscripcion
		AND eci.codigocarrera= e.codigocarrera
		AND i.codigoperiodo = '$codigoperiodo'
        and eci.idnumeroopcion = '1'
                $carrera
                ";*/
        //echo "$query";
        //exit();
        $query="SELECT ee.codigoestudiante, ee.codigoperiodo FROM estudianteestadistica ee, carrera c, estudiante e
                  where e.codigocarrera=c.codigocarrera
                  $carrera
                  and ee.codigoestudiante=e.codigoestudiante
                  and ee.codigoperiodo = '$codigoperiodo'
                  and ee.codigoprocesovidaestudiante= 200
                  and ee.codigoestado like '1%'
                  order by 1";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }


    function ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago_admitidos($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        if(trim($codigocarrera)!='')
            $carrera = " AND e.codigocarrera='".$codigocarrera."'";
        //AND e.codigosituacioncarreraestudiante <> '106'


        $query="SELECT e.codigoestudiante,e.codigoperiodo
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
        AND o.codigoestadoordenpago LIKE '4%'
        AND o.codigoperiodo='$codigoperiodo'
        AND c.codigocarrera=e.codigocarrera
        AND e.codigosituacioncarreraestudiante in(300,301,302)
                $carrera
        UNION
        SELECT e.codigoestudiante,
        i.codigoperiodo
        FROM
        estudiante e, inscripcion i, estudiantecarrerainscripcion eci
        WHERE
        e.idestudiantegeneral = i.idestudiantegeneral
        AND i.codigosituacioncarreraestudiante = '111'
        AND i.idinscripcion=eci.idinscripcion
        AND eci.codigocarrera= e.codigocarrera
        AND i.codigoperiodo = '$codigoperiodo'
        AND e.codigosituacioncarreraestudiante like '300'
        and eci.idnumeroopcion = '1'
                $carrera
                ";
        //echo "$query";
        //exit();
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function ObtenerDatosCuentaOperacionPrincipalInscritosEvaluado($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        if(trim($codigocarrera)!='')
            $carrera = " AND cp.codigocarrera='".$codigocarrera."'";


        $query="select distinct ea.codigoestudiante,cp.codigoperiodo from
				estudianteadmision ea,admision a,carreraperiodo cp,subperiodo sp,
				estudiante e,estudiantegeneral eg
				where
				ea.idadmision=a.idadmision and
				cp.codigocarrera=cp.codigocarrera and
				sp.idcarreraperiodo=cp.idcarreraperiodo and
				a.idsubperiodo=sp.idsubperiodo and
				e.codigoestudiante=ea.codigoestudiante and
				eg.idestudiantegeneral=e.idestudiantegeneral and
				cp.codigoperiodo='".$codigoperiodo."'
				".$carrera."
				and	ea.codigoestadoestudianteadmision like '1%'
				order by ea.codigoestudiante
		";
        //exit();
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    // INSCRITOS NO EVALUADOS
    function ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        if(trim($codigocarrera)!='')
            $carrera = " AND e.codigocarrera='".$codigocarrera."'";


        /*$query="select distinct ea.codigoestudiante,cp.codigoperiodo from
                estudianteadmision ea,admision a,carreraperiodo cp,subperiodo sp,
                estudiante e,estudiantegeneral eg
                where
                ea.idadmision=a.idadmision and
                cp.codigocarrera=cp.codigocarrera and
                sp.idcarreraperiodo=cp.idcarreraperiodo and
                a.idsubperiodo=sp.idsubperiodo and
                e.codigoestudiante=ea.codigoestudiante and
                eg.idestudiantegeneral=e.idestudiantegeneral and
                cp.codigoperiodo='".$codigoperiodo."'
                ".$carrera."
                and ea.codigoestadoestudianteadmision like '1%'
                and e.codigosituacioncarreraestudiante in(107, 111)
                order by ea.codigoestudiante
        ";*/
        $query="SELECT e.codigoestudiante,e.codigoperiodo
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
        AND o.codigoestadoordenpago LIKE '4%'
        AND o.codigoperiodo='$codigoperiodo'
        AND c.codigocarrera=e.codigocarrera
        and e.codigosituacioncarreraestudiante in(107)
                $carrera
        UNION
        SELECT e.codigoestudiante,
        i.codigoperiodo
        FROM
        estudiante e, inscripcion i, estudiantecarrerainscripcion eci
        WHERE
        e.idestudiantegeneral = i.idestudiantegeneral
        AND i.codigosituacioncarreraestudiante = '111'
        AND e.codigosituacioncarreraestudiante in (110, 111, 107)
        AND i.idinscripcion=eci.idinscripcion
        AND eci.codigocarrera= e.codigocarrera
        AND i.codigoperiodo = '$codigoperiodo'
        and eci.idnumeroopcion = '1'
                $carrera
                ";        
        //echo $query;
        $operacion=$this->conexion->query($query);
        //mysql_error();
        //exit();

        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    //LISTA EN ESPERA

    function ObtenerDatosListaEnEspera($codigoperiodo,$codigocarrera,$retorno) {
        if(trim($codigocarrera)!='')
            $carrera = " AND e.codigocarrera='".$codigocarrera."'";

        $query="SELECT e.codigoestudiante, p.codigoperiodo
                FROM estudiante e, periodo p, historicosituacionestudiante h
                where h.codigosituacioncarreraestudiante= 115
                and  p.codigoperiodo = '".$this->codigoperiodo."'
                and h.codigoestudiante=e.codigoestudiante
                and (p.fechainicioperiodo between h.fechainiciohistoricosituacionestudiante and h.fechafinalhistoricosituacionestudiante
                or p.fechavencimientoperiodo between h.fechainiciohistoricosituacionestudiante and h.fechafinalhistoricosituacionestudiante
                or h.fechainiciohistoricosituacionestudiante between p.fechainicioperiodo and p.fechavencimientoperiodo
                or h.fechafinalhistoricosituacionestudiante between p.fechainicioperiodo and p.fechavencimientoperiodo)
                and e.codigoperiodo <= p.codigoperiodo
                $carrera
                order by 1";
        //echo $query,"<br><br>";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                /*$queryRevisaNotaHistorico="SELECT COUNT(nh.codigoestudiante) as cant FROM notahistorico nh
				WHERE nh.codigotiponotahistorico='400'
				AND nh.codigoestudiante='".$row_operacion['codigoestudiante']."'
					and nh.codigoperiodo<'".$this->codigoperiodo."'
				";

				$operacionRevisaNotaHistorico=$this->conexion->query($queryRevisaNotaHistorico);
				$rowRevisaNh=$operacionRevisaNotaHistorico->fetchRow();
				if($rowRevisaNh['cant']<1){*/
                $arreglo_interno[]=$row_operacion;
                //}

            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }
    
    // EVALUADOS NO ADMITIDOS
    function ObtenerDatosCuentaOperacionPrincipalEvaluadosNoAdmitidos($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        if(trim($codigocarrera)!='')
            $carrera = " AND e.codigocarrera='".$codigocarrera."'";


        /*$query="select distinct ea.codigoestudiante,cp.codigoperiodo from
                estudianteadmision ea,admision a,carreraperiodo cp,subperiodo sp,
                estudiante e,estudiantegeneral eg
                where
                ea.idadmision=a.idadmision and
                cp.codigocarrera=cp.codigocarrera and
                sp.idcarreraperiodo=cp.idcarreraperiodo and
                a.idsubperiodo=sp.idsubperiodo and
                e.codigoestudiante=ea.codigoestudiante and
                eg.idestudiantegeneral=e.idestudiantegeneral and
                cp.codigoperiodo='".$codigoperiodo."'
                ".$carrera."
                and ea.codigoestadoestudianteadmision like '1%'
                and e.codigosituacioncarreraestudiante in(107, 111)
                order by ea.codigoestudiante
        ";
          * 105 fue eliminado de este listado para indicar que es un admitido evaluado que no ingres?
        */

        $query="SELECT e.codigoestudiante,e.codigoperiodo
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
        AND o.codigoestadoordenpago LIKE '4%'
        AND o.codigoperiodo='$codigoperiodo'
        AND c.codigocarrera=e.codigocarrera
        and e.codigosituacioncarreraestudiante in(113)
                $carrera
        UNION
        SELECT e.codigoestudiante,
        i.codigoperiodo
        FROM
        estudiante e, inscripcion i, estudiantecarrerainscripcion eci
        WHERE
        e.idestudiantegeneral = i.idestudiantegeneral
        AND i.codigosituacioncarreraestudiante = '111'
        AND e.codigosituacioncarreraestudiante in (113)
        AND i.idinscripcion=eci.idinscripcion
        AND eci.codigocarrera= e.codigocarrera
        AND i.codigoperiodo = '$codigoperiodo'
        and eci.idnumeroopcion = '1'
                $carrera
                ";
        //echo $query;
        $operacion=$this->conexion->query($query);
        //mysql_error();
        //exit();

        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    // ADMITIDOS QUE NO INGRESARON
    function ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        if(trim($codigocarrera)!='')
            $carrera = " AND e.codigocarrera='".$codigocarrera."'";


        /*$query="select distinct ea.codigoestudiante,cp.codigoperiodo from
                estudianteadmision ea,admision a,carreraperiodo cp,subperiodo sp,
                estudiante e,estudiantegeneral eg
                where
                ea.idadmision=a.idadmision and
                cp.codigocarrera=cp.codigocarrera and
                sp.idcarreraperiodo=cp.idcarreraperiodo and
                a.idsubperiodo=sp.idsubperiodo and
                e.codigoestudiante=ea.codigoestudiante and
                eg.idestudiantegeneral=e.idestudiantegeneral and
                cp.codigoperiodo='".$codigoperiodo."'
                ".$carrera."
                and ea.codigoestadoestudianteadmision like '1%'
                and e.codigosituacioncarreraestudiante in(107, 111)
                order by ea.codigoestudiante
        ";
          * 105 fue eliminado de este listado para indicar que es un admitido evaluado que no ingres?
        */

        $query="SELECT e.codigoestudiante,e.codigoperiodo
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
        WHERE o.numeroordenpago=d.numeroordenpago
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
        AND o.codigoestadoordenpago LIKE '4%'
        AND o.codigoperiodo='$codigoperiodo'
        AND c.codigocarrera=e.codigocarrera
        and e.codigosituacioncarreraestudiante in(105)
                $carrera
        UNION
        SELECT e.codigoestudiante,
        i.codigoperiodo
        FROM
        estudiante e, inscripcion i, estudiantecarrerainscripcion eci
        WHERE
        e.idestudiantegeneral = i.idestudiantegeneral
        AND i.codigosituacioncarreraestudiante = '111'
        AND e.codigosituacioncarreraestudiante in (105)
        AND i.idinscripcion=eci.idinscripcion
        AND eci.codigocarrera= e.codigocarrera
        AND i.codigoperiodo = '$codigoperiodo'
        and eci.idnumeroopcion = '1'
                $carrera
                ";
        //echo $query;
        $operacion=$this->conexion->query($query);
        //mysql_error();
        //exit();

        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function ObtenerDatosCuentaOperacionPrincipalEvaluadoNoAdmitido($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        if(trim($codigocarrera)!='')
            $carrera = " AND cp.codigocarrera='".$codigocarrera."'";

        $query="select distinct ea.codigoestudiante,cp.codigoperiodo from
				estudianteadmision ea,admision a,carreraperiodo cp,subperiodo sp,
				estudiante e,estudiantegeneral eg
				where
				ea.idadmision=a.idadmision and
				cp.codigocarrera=cp.codigocarrera and
				sp.idcarreraperiodo=cp.idcarreraperiodo and
				a.idsubperiodo=sp.idsubperiodo and
				e.codigoestudiante=ea.codigoestudiante and
				eg.idestudiantegeneral=e.idestudiantegeneral and
				cp.codigoperiodo='".$codigoperiodo."'
				".$carrera."
				and	ea.codigoestadoestudianteadmision like '2%'
				and ea.codigoestado like '1%'
				order by ea.codigoestudiante
		";
        //exit();
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function ObtenerDatosCuentaOperacionPrincipalAdmitido($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        if(trim($codigocarrera)!='')
            $carrera = " and codigocarrera='".$codigocarrera."'";


        $query="select distinct codigoestudiante,codigoperiodo from estudiante where codigosituacioncarreraestudiante = '300'
				and codigoperiodo =".$codigoperiodo."  ".
                $carrera."";
        //exit();
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                if($row_operacion['codigoestudiante']<>"") {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }

    }
    function obtener_datos_cuentaoperacionprincipal_ordenespagasynopagas($codigoperiodo,$codigocarrera,$cuentaoperacionprinicipal,$retorno) {
        $query="SELECT e.codigoestudiante
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND e.codigocarrera='$codigocarrera'
		AND co.cuentaoperacionprincipal='$cuentaoperacionprinicipal'
		AND o.codigoperiodo='".$codigoperiodo."'
		AND (o.codigoestadoordenpago LIKE '1%' or o.codigoestadoordenpago LIKE '4%')
		GROUP by e.codigoestudiante
		";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                $arreglo_interno[]=$row_operacion;
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_estudiantes_noprematriculados($codigocarrera,$retorno) {
        $contador=0;
        $estudiantes_matriculados_periodo_actual=$this->obtener_datos_cuentaoperacionprincipal_ordenespagasynopagas($this->codigoperiodo,$codigocarrera,151,'arreglo');
        $estudiantes_matriculados_periodo_anterior=$this->obtener_datos_cuentaoperacionprincipal_estudiantes_no_aplica($this->periodo_anterior,$codigocarrera,151,'arreglo');

        if(is_array($estudiantes_matriculados_periodo_actual) and is_array($estudiantes_matriculados_periodo_anterior)) {
            //echo count($estudiantes_matriculados_periodo_anterior)," ",count($estudiantes_matriculados_periodo_actual),"<br>";
            foreach ($estudiantes_matriculados_periodo_anterior as $llave => $valor) {
                $bandera=false;
                foreach ($estudiantes_matriculados_periodo_actual as $llave_int => $valor_int) {
                    if($valor['codigoestudiante']==$valor_int['codigoestudiante']) {
                        $bandera=true;
                    }
                }
                if($bandera==false) {
                    $array_diferencia[]['codigoestudiante']=$valor['codigoestudiante'];
                }
            }
        }
        $conteo=count($array_diferencia);
        //$this->listar($estudiantes_matriculados_periodo_anterior,"periodo anterior");
        //$this->listar($estudiantes_matriculados_periodo_actual,"periodo actual");
        //echo "<h1>".$conteo."</h1>";
        if($retorno=='arreglo') {
            return $array_diferencia;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,$retorno) {
        /*$query="SELECT e.codigoestudiante, pr.semestreprematricula as semestre
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND e.codigoestudiante=pr.codigoestudiante
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND e.codigocarrera='$codigocarrera'
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigoperiodo='".$this->codigoperiodo."'
		GROUP by e.codigoestudiante";*/
        $query="SELECT ee.codigoestudiante, ee.codigoperiodo
                FROM estudianteestadistica ee, carrera c, estudiante e
                where e.codigocarrera = '$codigocarrera'
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo = '".$this->codigoperiodo."'
                and ee.codigoprocesovidaestudiante= 400
                and ee.codigoestado like '1%'
                order by 1";
        //echo $query,"<br><br>";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                /*$queryRevisaNotaHistorico="SELECT COUNT(nh.codigoestudiante) as cant FROM notahistorico nh
				WHERE nh.codigotiponotahistorico='400'
				AND nh.codigoestudiante='".$row_operacion['codigoestudiante']."'
					and nh.codigoperiodo<'".$this->codigoperiodo."'
				";

				$operacionRevisaNotaHistorico=$this->conexion->query($queryRevisaNotaHistorico);
				$rowRevisaNh=$operacionRevisaNotaHistorico->fetchRow();
				if($rowRevisaNh['cant']<1){*/
                $arreglo_interno[]=$row_operacion;
                //}

            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_estudiantes_matriculados_transferencia_1_semestre($codigocarrera, $retorno) {

        $query="SELECT e.codigoestudiante, pr.semestreprematricula as semestre
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND e.codigoestudiante=pr.codigoestudiante
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND e.codigocarrera='$codigocarrera'
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigoperiodo='".$this->codigoperiodo."'
		GROUP by e.codigoestudiante";
        //echo $query,"<br><br>";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                if($row_operacion['semestre']=='1') {
                    $queryRevisaNotaHistorico="SELECT COUNT(nh.codigoestudiante) as cant FROM notahistorico nh
					WHERE nh.codigotiponotahistorico='400'
					AND nh.codigoestudiante='".$row_operacion['codigoestudiante']."'";
                    $operacionRevisaNotaHistorico=$this->conexion->query($queryRevisaNotaHistorico);
                    $rowRevisaNh=$operacionRevisaNotaHistorico->fetchRow();
                    if($rowRevisaNh['cant']>0) {
                        $arreglo_interno[]=$row_operacion;
                    }
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_estudiantes_matriculados_transferencia($codigocarrera, $retorno) {
        $query="SELECT e.codigoestudiante, pr.semestreprematricula as semestre
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND e.codigoestudiante=pr.codigoestudiante
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND e.codigocarrera='$codigocarrera'
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigoperiodo='".$this->codigoperiodo."'
		GROUP by e.codigoestudiante";
        //echo $query,"<br><br>";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();

        do {
            if(is_array($row_operacion)) {
                $queryRevisaNotaHistorico="SELECT COUNT(nh.codigoestudiante) as cant FROM notahistorico nh
				WHERE nh.codigotiponotahistorico='400'
				AND nh.codigoestudiante='".$row_operacion['codigoestudiante']."'";
                $operacionRevisaNotaHistorico=$this->conexion->query($queryRevisaNotaHistorico);
                $rowRevisaNh=$operacionRevisaNotaHistorico->fetchRow();
                if($rowRevisaNh['cant']>0) {
                    $arreglo_interno[]=$row_operacion;
                }
            }
        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($codigocarrera,$codigotipoestudiante,$retorno) {
        /*$query="SELECT e.codigoestudiante, pr.semestreprematricula as semestre
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigocarrera='$codigocarrera'
		AND e.codigoperiodo<>'".$this->codigoperiodo."'
		GROUP by e.codigoestudiante
		";*/
        $query="SELECT ee.codigoestudiante, ee.codigoperiodo
                FROM estudianteestadistica ee, carrera c, estudiante e
                where e.codigocarrera = '$codigocarrera'
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo = '".$this->codigoperiodo."'
                and ee.codigoprocesovidaestudiante= 401
                and ee.codigoestado like '1%'
                order by 1";
        //echo $query,"<br><br>";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            //verificar si no tienen orden de pago para el periodo anterior, si no la tiene, entonces si es reintegro el estudiante
            if(is_array($row_operacion)) {
                //AND op.codigoperiodo = '".$this->periodo_anterior."'

/*                $queryVerifOrdenPagoPeriodoAnt="SELECT COUNT(op.codigoestudiante) as cant
				FROM ordenpago op, detalleordenpago dop, concepto co
				WHERE
				op.numeroordenpago=dop.numeroordenpago
				AND dop.codigoconcepto=co.codigoconcepto
				AND co.cuentaoperacionprincipal=151
				AND op.codigoperiodo < '".$this->codigoperiodo."'
				AND op.codigoestudiante='".$row_operacion['codigoestudiante']."'
				AND op.codigoestadoordenpago LIKE '4%'
				GROUP BY op.codigoestudiante
				";
                //echo $queryVerifOrdenPagoPeriodoAnt;
                $op=$this->conexion->query($queryVerifOrdenPagoPeriodoAnt);
                $rowOp=$op->fetchRow();
                if($rowOp['cant'] > 0) {*/
                    $arreglo_interno[]=$row_operacion;
                //}
            }

        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_estudiantes_reintegro($codigocarrera, $retorno) {
        $query="SELECT e.codigoestudiante, pr.semestreprematricula as semestre
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigocarrera='$codigocarrera'
		AND e.codigoperiodo<>'".$this->codigoperiodo."'
		GROUP by e.codigoestudiante
		";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            //verificar si no tienen orden de pago para el periodo anterior, si no la tiene, entonces si es reintegro el estudiante
            if(is_array($row_operacion)) {
                $queryVerifOrdenPagoPeriodoAnt="SELECT COUNT(op.codigoestudiante) as cant
				FROM ordenpago op, detalleordenpago dop, concepto co
				WHERE
				op.numeroordenpago=dop.numeroordenpago
				AND dop.codigoconcepto=co.codigoconcepto
				AND co.cuentaoperacionprincipal=151
				AND op.codigoperiodo='".$this->periodo_anterior."'
				AND op.codigoestudiante='".$row_operacion['codigoestudiante']."'
				AND op.codigoestadoordenpago LIKE '4%'
				GROUP BY op.codigoestudiante
				";
                //echo $queryVerifOrdenPagoPeriodoAnt;
                $op=$this->conexion->query($queryVerifOrdenPagoPeriodoAnt);
                $rowOp=$op->fetchRow();
                if($rowOp['cant'] < 1) {
                    $arreglo_interno[]=$row_operacion;
                }
            }

        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_estudiantes_reintegro_1_semestre($codigocarrera, $retorno) {
        $query="SELECT e.codigoestudiante, pr.semestreprematricula as semestre
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigocarrera='$codigocarrera'
		AND e.codigoperiodo<>'".$this->codigoperiodo."'
		GROUP by e.codigoestudiante
		";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            //verificar si no tienen orden de pago para el periodo anterior, si no la tiene, entonces si es reintegro el estudiante
            if(is_array($row_operacion)) {
                $queryVerifOrdenPagoPeriodoAnt="SELECT COUNT(op.codigoestudiante) as cant
				FROM ordenpago op, detalleordenpago dop, concepto co
				WHERE
				op.numeroordenpago=dop.numeroordenpago
				AND dop.codigoconcepto=co.codigoconcepto
				AND co.cuentaoperacionprincipal=151
				AND op.codigoperiodo='".$this->periodo_anterior."'
				AND op.codigoestudiante='".$row_operacion['codigoestudiante']."'
				AND op.codigoestadoordenpago LIKE '4%'
				GROUP BY op.codigoestudiante
				";
                //echo $queryVerifOrdenPagoPeriodoAnt;
                $op=$this->conexion->query($queryVerifOrdenPagoPeriodoAnt);
                $rowOp=$op->fetchRow();
                if($rowOp['cant'] < 1) {
                    if($row_operacion['semestre']=='1') {
                        $arreglo_interno[]=$row_operacion;
                    }
                }
            }

        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_estudiantes_matriculados_repitentes($codigocarrera,$codigotipoestudiante,$retorno) {
        $query_periodo_actual="SELECT e.codigoestudiante, pr.semestreprematricula as semestre
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND pr.semestreprematricula=1
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigocarrera='$codigocarrera'
		AND e.codigoperiodo<>'".$this->codigoperiodo."'
		AND e.codigotipoestudiante='$codigotipoestudiante'
		GROUP by e.codigoestudiante
                ";

        $query_periodo_anterior="SELECT e.codigoestudiante, pr.semestreprematricula as semestre
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=pr.codigoestudiante
		AND pr.semestreprematricula=1
		AND pr.codigoperiodo='$this->periodo_anterior'
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		AND e.codigocarrera='$codigocarrera'
		AND e.codigoperiodo<>'".$this->codigoperiodo."'
		AND e.codigotipoestudiante='$codigotipoestudiante'
		GROUP by e.codigoestudiante
                ";

        $operacion_periodo_actual=$this->conexion->query($query_periodo_actual);
        $row_operacion_periodo_actual=$operacion_periodo_actual->fetchRow();
        $operacion_periodo_anterior=$this->conexion->query($query_periodo_anterior);
        $row_operacion_periodo_anterior=$operacion_periodo_anterior->fetchRow();
        do {
            if(is_array($row_operacion_periodo_actual)) {
                $arreglo_periodo_actual[]=$row_operacion_periodo_actual;
            }
        }
        while($row_operacion_periodo_actual=$operacion_periodo_actual->fetchRow());

        do {
            if(is_array($row_operacion_periodo_anterior)) {
                $arreglo_periodo_anterior[]=$row_operacion_periodo_anterior;
            }
        }
        while($row_operacion_periodo_anterior=$operacion_periodo_anterior->fetchRow());
        if(is_array($arreglo_periodo_actual)) {
            foreach ($arreglo_periodo_actual as $llave_actual => $valor_acual) {
                if(is_array($arreglo_periodo_anterior)) {
                    foreach ($arreglo_periodo_anterior as $llave_anterior => $valor_anterior) {
                        if($valor_acual['codigoestudiante']==$valor_anterior['codigoestudiante']) {
                            if($valor_acual['semestre']==$valor_anterior['semestre']) {
                                $arreglo_interno[]=$valor_acual;
                            }
                        }
                    }
                }
            }
        }
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }

    }



    function obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante_1_semestre($codigocarrera,$codigotipoestudiante,$retorno) {
        $matriculados_reintegro=$this->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($codigocarrera,$codigotipoestudiante,$retorno);
        if(is_array($matriculados_reintegro)) {
            foreach ($matriculados_reintegro as $llave => $valor) {
                if($valor['semestre']=='1') {
                    $resultado[]=$valor;
                }
            }
        }
        if($retorno=='conteo') {
            return count($resultado);
        }
        elseif ($retorno=='arreglo') {
            return $resultado;
        }
    }

    function obtener_total_matriculados_1_semestre($codigocarrera,$retorno) {
        $matriculados_nuevos=$this->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,'arreglo');
        $matriculados_antiguos=$this->obtener_datos_estudiantes_matriculados_repitentes($codigocarrera,20,'arreglo');
        //$matriculados_transferencia=$this->obtener_datos_estudiantes_matriculados_transferencia_1_semestre($codigocarrera,'arreglo');
        $matriculados_reintegro=$this->obtener_datos_estudiantes_reintegro_1_semestre($codigocarrera,'arreglo');
        /*$matriculados_antiguos=$this->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($codigocarrera,20,'arreglo');
		$matriculados_transferencia=$this->obtener_datos_estudiantes_matriculados_transferencia($codigocarrera,'arreglo');
		$matriculados_reintegro=$this->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($codigocarrera,21,'arreglo');
        */
        if (is_array($matriculados_antiguos)) {
            foreach ($matriculados_antiguos as $llave => $valor) {
                if($valor['codigoestudiante']!="") {
                    if($valor['semestre']=='1') {
                        $resultado[]=$valor;
                    }
                }
            }
        }
        if(is_array($matriculados_nuevos)) {
            foreach ($matriculados_nuevos as $llave => $valor) {
                if($valor['codigoestudiante']!="") {
                    if($valor['semestre']=='1') {
                        $resultado[]['codigoestudiante']=$valor['codigoestudiante'];
                    }
                }
            }
        }
        if(is_array($matriculados_reintegro)) {
            foreach ($matriculados_reintegro as $llave => $valor) {
                if($valor['codigoestudiante']!="") {
                    if($valor['semestre']=='1') {
                        $resultado[]['codigoestudiante']=$valor['codigoestudiante'];
                    }
                }
            }
        }
        if(is_array($matriculados_transferencia)) {
            foreach ($matriculados_transferencia as $llave => $valor) {
                if($valor['codigoestudiante']!="") {
                    if($valor['semestre']=='1') {
                        $resultado[]['codigoestudiante']=$valor['codigoestudiante'];
                    }
                }
            }
        }
        if($retorno=='conteo') {
            return count($resultado);
        }
        elseif ($retorno=='arreglo') {
            return $resultado;
        }
    }

    function obtener_total_matriculados($codigocarrera,$retorno) {
        $matriculados_nuevos=$this->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,'arreglo');
        $matriculados_antiguos=$this->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($codigocarrera,20,'arreglo');
        //$matriculados_transferencia=$this->obtener_datos_estudiantes_matriculados_transferencia($codigocarrera,'arreglo');
        //$matriculados_reintegro=$this->obtener_datos_estudiantes_reintegro($codigocarrera,'arreglo');
        if (is_array($matriculados_antiguos)) {
            foreach ($matriculados_antiguos as $llave => $valor) {
                if($valor['codigoestudiante']!="") {
                    $resultado[]['codigoestudiante']=$valor['codigoestudiante'];
                }
            }
        }
        if(is_array($matriculados_nuevos)) {
            foreach ($matriculados_nuevos as $llave => $valor) {
                if($valor['codigoestudiante']!="") {
                    $resultado[]['codigoestudiante']=$valor['codigoestudiante'];
                }
            }
        }
        /*if(is_array($matriculados_reintegro))
		{
			foreach ($matriculados_reintegro as $llave => $valor)
			{
				if($valor['codigoestudiante']!="")
				{
					$resultado[]['codigoestudiante']=$valor['codigoestudiante'];
				}
			}
		}
		if(is_array($matriculados_transferencia))
		{
			foreach ($matriculados_transferencia as $llave => $valor)
			{
				if($valor['codigoestudiante']!="")
				{
					$resultado[]['codigoestudiante']=$valor['codigoestudiante'];
				}
			}
		}*/



        if($retorno=='conteo') {
            return count($resultado);
        }
        elseif ($retorno=='arreglo') {
            return $resultado;
        }

    }
/*Arreglar el codigo periodo por ".$this->codigoperiodo."*/
    function obtener_total_matriculados_real($codigocarrera,$retorno) {
       $query="SELECT e.codigoestudiante, pr.semestreprematricula as semestre
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
        WHERE o.numeroordenpago=d.numeroordenpago
        AND pr.codigoperiodo='20112'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND e.codigocarrera='$codigocarrera'
        AND o.codigoperiodo='20112'
        AND o.codigoestadoordenpago LIKE '4%'
        GROUP by e.codigoestudiante";

        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            //verificar si no tienen orden de pago para el periodo anterior, si no la tiene, entonces si es reintegro el estudiante
            if(is_array($row_operacion)) {
                /*$queryVerifOrdenPagoPeriodoAnt="SELECT COUNT(op.codigoestudiante) as cant
                FROM ordenpago op, detalleordenpago dop, concepto co
                WHERE
                op.numeroordenpago=dop.numeroordenpago
                AND dop.codigoconcepto=co.codigoconcepto
                AND co.cuentaoperacionprincipal=151
                AND op.codigoperiodo='".$this->periodo_anterior."'
                AND op.codigoestudiante='".$row_operacion['codigoestudiante']."'
                AND op.codigoestadoordenpago LIKE '4%'
                GROUP BY op.codigoestudiante
                ";
                //echo $queryVerifOrdenPagoPeriodoAnt;
                $op=$this->conexion->query($queryVerifOrdenPagoPeriodoAnt);
                $rowOp=$op->fetchRow();
                if($rowOp['cant'] < 1){*/
                $arreglo_interno[]=$row_operacion;
                //}
            }

        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }

        /*$matriculados_nuevos=$this->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,'arreglo');
        $matriculados_antiguos=$this->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($codigocarrera,20,'arreglo');
        $matriculados_transferencia=$this->obtener_datos_estudiantes_matriculados_transferencia($codigocarrera,'arreglo');
        $matriculados_reintegro=$this->obtener_datos_estudiantes_reintegro($codigocarrera,'arreglo');
        if (is_array($matriculados_antiguos))
        {
            foreach ($matriculados_antiguos as $llave => $valor)
            {
                if($valor['codigoestudiante']!="")
                {
                    $resultado[]['codigoestudiante']=$valor['codigoestudiante'];
                }
            }
        }
        if(is_array($matriculados_nuevos))
        {
            foreach ($matriculados_nuevos as $llave => $valor)
            {
                if($valor['codigoestudiante']!="")
                {
                    $resultado[]['codigoestudiante']=$valor['codigoestudiante'];
                }
            }
        }
        if(is_array($matriculados_reintegro))
        {
            foreach ($matriculados_reintegro as $llave => $valor)
            {
                if($valor['codigoestudiante']!="")
                {
                    $resultado[]['codigoestudiante']=$valor['codigoestudiante'];
                }
            }
        }
        if(is_array($matriculados_transferencia))
        {
            foreach ($matriculados_transferencia as $llave => $valor)
            {
                if($valor['codigoestudiante']!="")
                {
                    $resultado[]['codigoestudiante']=$valor['codigoestudiante'];
                }
            }
        }



        if($retorno=='conteo')
        {
            return count($resultado);
        }
        elseif ($retorno=='arreglo')
        {
            return $resultado;
        }*/

    }


    function obtener_semestre_estudiante($codigoestudiante) {
        $query="
		SELECT
		pr.semestreprematricula as semestre
		FROM
		estudiante e,  prematricula pr
		WHERE
		e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND e.codigoestudiante='$codigoestudiante'
                ";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        return $row_operacion['semestre'];
    }

    function obtener_colegio_estudiante($codigoestudiante,$codigomodalidadacademica) {
        $query="
		SELECT
		       if(i.idinstitucioneducativa=1,ie.otrainstitucioneducativaestudianteestudio,i.nombreinstitucioneducativa) nombreinstitucion, ie.anogradoestudianteestudio
		FROM
		estudiante e, estudianteestudio ie, institucioneducativa i,carrera c
		WHERE
		e.codigoestudiante='$codigoestudiante'
		and e.codigocarrera=c.codigocarrera
		AND ie.idestudiantegeneral=e.idestudiantegeneral
		AND ie.idinstitucioneducativa=i.idinstitucioneducativa
                and ie.codigoestado like '1%'
		and ie.idniveleducacion=if(".($codigomodalidadacademica-100)."=100,2,3)
		";
        	//echo "<br>";
//echo "<BR><H1>MODALIDAD ACADEMICA =</H1>".$codigomodalidadacademica."<BR>";
       //echo $query;
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
if(trim($row_operacion['nombreinstitucion'])!=''&&isset($row_operacion['nombreinstitucion'])){
        $row_operacion['nombreinstitucioneducativa']=strtoupper($row_operacion['nombreinstitucion']);
}
else{
$row_operacion['nombreinstitucioneducativa']="NO DEFINIDA";
$row_operacion['anogradoestudianteestudio']="NO DEFINIDA";
}
        return $row_operacion;
/*

        $query="
		SELECT
		i.nombreinstitucioneducativa
		FROM
		estudiante e, estudianteestudio ie, institucioneducativa i,carrera c
		WHERE
		e.codigoestudiante='$codigoestudiante'
		and e.codigocarrera=c.codigocarrera
		AND ie.idestudiantegeneral=e.idestudiantegeneral
		AND ie.idinstitucioneducativa=i.idinstitucioneducativa
                and ie.codigoestado like '1%'
		and i.codigomodalidadacademica=".($codigomodalidadacademica-100)."
		";
        //	echo "<br>";
//echo "<BR><H1>MODALIDAD ACADEMICA =</H1>".$codigomodalidadacademica."<BR>";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        return $row_operacion['nombreinstitucioneducativa'];*/

    }

    function obtener_datos_estudiante($codigoestudiante) {
        $query="
		SELECT e.codigoestudiante,
		c.nombrecarrera,
		pr.semestreprematricula as semestre,
		eg.numerodocumento,
		tp.nombredocumento,
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		eg.direccionresidenciaestudiantegeneral as direccion,
		eg.direccioncorrespondenciaestudiantegeneral as direccion_correspondencia,
		eg.telefonoresidenciaestudiantegeneral as telefono,
		eg.celularestudiantegeneral as celular,
		eg.emailestudiantegeneral as email,
		eg.email2estudiantegeneral as email2,
		ec.nombreestadocivil as estado_civil,
		eg.fechanacimientoestudiantegeneral as fecha_nacimiento,
		TIMESTAMPDIFF(YEAR,eg.fechanacimientoestudiantegeneral,CURDATE()) AS edad,
		g.nombregenero as genero,
		ciu.nombreciudad as ciudad_nacimiento,
		e.codigoperiodo as periodo_ingreso,
		j.nombrejornada as jornada,
		te.nombretipoestudiante as tipo_estudiante,
		sce.nombresituacioncarreraestudiante as situacion_carrera_estudiante,
		u.usuario as usuario
		FROM
		 estudiantegeneral eg
		left join usuario u on u.numerodocumento=eg.numerodocumento and u.codigotipousuario='600',
		carrera c, estadocivil ec, ciudad ciu,
		jornada j, tipoestudiante te, situacioncarreraestudiante sce,
		genero g,
		documento tp, estudiante e
		left join prematricula pr on e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='$this->codigoperiodo'
		WHERE
		e.idestudiantegeneral=eg.idestudiantegeneral

		AND eg.codigogenero=g.codigogenero
		AND e.codigocarrera=c.codigocarrera
		AND eg.idestadocivil=ec.idestadocivil
		AND eg.idciudadnacimiento=ciu.idciudad
		AND e.codigojornada=j.codigojornada
		AND e.codigotipoestudiante=te.codigotipoestudiante
		AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
		AND e.codigoestudiante='$codigoestudiante'
		AND eg.tipodocumento=tp.tipodocumento
                ";
        //echo $query."<br>";
        //exit();
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        return $row_operacion;
    }

    function obtenerSemestreEstudiante($codigoestudiante) {

        $query="SELECT pr.semestreprematricula FROM estudiante e, prematricula pr
		WHERE
		e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND e.codigoestudiante='$codigoestudiante'
                ";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        return $row_operacion['semestreprematricula'];
    }

    function obtener_datos_estudiante_noprematricula($codigoestudiante) {
        if(isset($_SESSION['ciclocontacto']))
            $codigoprocesovidaestudiante = "and es.codigoprocesovidaestudiante = '".$_SESSION['sesioncodigoprocesovidaestudiante']."'";
        $query="
		SELECT e.codigoestudiante,
		c.nombrecarrera,
		c.codigomodalidadacademica,
		eg.numerodocumento,
		tp.nombredocumento,
        if(es.observacionestudianteseguimiento is null,'Sin Seguimiento',substring(es.observacionestudianteseguimiento,1,30))
        as Ultimo_Seguimiento,
        concat(tes.nombretipoestudianteseguimiento,'/',tdes.nombretipodetalleestudianteseguimiento) Tipo_Seguimiento,
        es.fechahastaestudianteseguimiento as Fecha_Proximo_Contacto,
        es.fechaestudianteseguimiento as Fecha_Contacto,
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		eg.direccionresidenciaestudiantegeneral as direccion,
		eg.direccioncorrespondenciaestudiantegeneral as direccion_correspondencia,
		eg.telefonoresidenciaestudiantegeneral as telefono,
		eg.celularestudiantegeneral as celular,
		eg.emailestudiantegeneral as email,
		eg.email2estudiantegeneral as email2,
		ec.nombreestadocivil as estado_civil,
		eg.fechanacimientoestudiantegeneral as fecha_nacimiento,
		TIMESTAMPDIFF(YEAR,eg.fechanacimientoestudiantegeneral,CURDATE()) AS edad,
		g.nombregenero as genero,
		ciu.nombreciudad as ciudad_nacimiento,
		e.codigoperiodo as periodo_ingreso,
		j.nombrejornada as jornada,
		te.nombretipoestudiante as tipo_estudiante,
		sce.nombresituacioncarreraestudiante as situacion_carrera_estudiante,
                esh.idestrato as estrato,
                e.semestre
		FROM
		estudiantegeneral eg, carrera c, estadocivil ec,
		 ciudad ciu, jornada j, tipoestudiante te, situacioncarreraestudiante sce,
		  genero g, documento tp, estudiante e
        left join estudianteseguimiento es on es.idestudianteseguimiento = (select max(ess.idestudianteseguimiento)  idestudianteseguimiento
        from estudianteseguimiento ess where  ess.codigoestudiante=e.codigoestudiante
        and ess.codigoestado like '1%')
        $codigoprocesovidaestudiante
        left join tipoestudianteseguimiento tes on tes.codigotipoestudianteseguimiento=es.codigotipoestudianteseguimiento
	left join tipodetalleestudianteseguimiento tdes on tdes.idtipodetalleestudianteseguimiento=es.idtipodetalleestudianteseguimiento
        left join estratohistorico esh on esh.idestudiantegeneral = e.idestudiantegeneral and esh.codigoestado like '1%'
		WHERE
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND eg.codigogenero=g.codigogenero
		AND e.codigocarrera=c.codigocarrera
		AND eg.idestadocivil=ec.idestadocivil
		AND eg.idciudadnacimiento=ciu.idciudad
		AND e.codigojornada=j.codigojornada
		AND e.codigotipoestudiante=te.codigotipoestudiante
		AND e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
		AND e.codigoestudiante='$codigoestudiante'
		AND eg.tipodocumento=tp.tipodocumento";
        //exit();
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        return $row_operacion;
    }

    function obtener_preinscripcion_estadopreinscripcionestudiante($codigocarrera,$codigoestadopreinscripcionestudiante,$retorno) {
        $query="SELECT distinct
		p.idpreinscripcion,pc.codigocarrera
		FROM
		preinscripcion p,preinscripcioncarrera pc
		WHERE
		p.idpreinscripcion=pc.idpreinscripcion
		AND p.codigoestado=100
		AND p.codigoestadopreinscripcionestudiante='$codigoestadopreinscripcionestudiante'
		AND p.codigoperiodo='".$this->codigoperiodo."'
		AND pc.codigocarrera='$codigocarrera'
		GROUP BY p.idpreinscripcion
                ";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                $arreglo_interno[]=$row_operacion;
            }

        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }


    function obtener_preinscripcion_estadopreinscripcionestudiante_general($codigocarrera,$retorno) {
        $query="SELECT distinct
		p.idpreinscripcion,pc.codigocarrera
		FROM
		preinscripcion p,preinscripcioncarrera pc
		WHERE
		p.idpreinscripcion=pc.idpreinscripcion
		AND p.codigoestado=100
		AND p.codigoestadopreinscripcionestudiante not like '2%'
		AND p.codigoperiodo='".$this->codigoperiodo."'
		AND pc.codigocarrera='$codigocarrera'
		GROUP BY p.idpreinscripcion
                ";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if(is_array($row_operacion)) {
                $arreglo_interno[]=$row_operacion;
            }

        }
        while($row_operacion=$operacion->fetchRow());
        $conteo=count($arreglo_interno);
        if($retorno=='arreglo') {
            return $arreglo_interno;
        }
        elseif ($retorno=='conteo') {
            return $conteo;
        }
    }

    function obtener_datos_estudiante_preinscripcion($idpreinscripcion,$codigocarrera) {
        $query="SELECT
		p.idpreinscripcion,
		if(max(ps.idpreinscripcionseguimiento) is NULL,
		'Sin Seguimiento',
        if(tes.codigotipoestudianteseguimiento='999',
            if(epc.nombreestadopreinscripcionestudiante='Sin seguimiento',
            if(ps.idusuario=1,'Observacion estudiante',concat('Seguimiento',' / ',substring(ps.observacionpreinscripcionseguimiento,1,30),'...')),
            concat(epc.nombreestadopreinscripcionestudiante,' / ',substring(ps.observacionpreinscripcionseguimiento,1,30),'...')),
            concat(tes.nombretipoestudianteseguimiento,' / ',substring(ps.observacionpreinscripcionseguimiento,1,30),'...'))
        ) Ultimo_Seguimiento,
        concat(tes.nombretipoestudianteseguimiento,'/',tdes.nombretipodetalleestudianteseguimiento) Tipo_Seguimiento,
        ps.fechahastapreinscripcionseguimiento as Fecha_Proximo_Contacto,
		count(distinct ps2.idpreinscripcionseguimiento) Seguimientos,
		c.nombrecarrera,
		p.numerodocumento,
		concat(p.apellidosestudiante,' ',p.nombresestudiante) as nombre,
		p.direccionestudiante,
        if(p.ciudadestudiante REGEXP '^[0-9]+$',(select nombreciudad
from ciudad c
where c.idciudad = p.ciudadestudiante
), '') as ciudadestudiante,
        p.telefonoestudiante,
		p.celularestudiante,
		p.emailestudiante,
        t.nombretipoorigenpreinscripcion
		FROM
		 preinscripcioncarrera pc, carrera c,estadopreinscripcionestudiante epc, tipoorigenpreinscripcion t, preinscripcion p
		left join preinscripcionseguimiento ps on ps.idpreinscripcionseguimiento = (select max(pss.idpreinscripcionseguimiento) idpreinscripcionseguimiento
		 from preinscripcionseguimiento pss where  pss.idpreinscripcion=p.idpreinscripcion  )

		left join preinscripcionseguimiento ps2 on ps2.idpreinscripcion = p.idpreinscripcion

		left join tipoestudianteseguimiento tes on tes.codigotipoestudianteseguimiento=ps.codigotipoestudianteseguimiento
		left join tipodetalleestudianteseguimiento tdes on tdes.idtipodetalleestudianteseguimiento=ps.idtipodetalleestudianteseguimiento
		WHERE
		p.idpreinscripcion=pc.idpreinscripcion
		AND p.idpreinscripcion='$idpreinscripcion'
		AND pc.codigocarrera=c.codigocarrera
		AND p.codigoestadopreinscripcionestudiante=epc.codigoestadopreinscripcionestudiante
		AND pc.codigocarrera='$codigocarrera'
        and pc.codigoestado like '1%'
        and t.idtipoorigenpreinscripcion = p.idtipoorigenpreinscripcion
        group by p.idpreinscripcion";
//		having
//		ps.idpreinscripcionseguimiento = (select max(pss.idpreinscripcionseguimiento) idpreinscripcionseguimiento from preinscripcionseguimiento pss where p.idpreinscripcion =pss.idpreinscripcion ) 		";
        //exit();
//		having
        //maxpreinscripcionseguimiento in ((select max(idpreinscripcionseguimiento) idpreinscripcionseguimiento from preinscripcionseguimiento pss where p.idpreinscripcion =pss.idpreinscripcion ))

        //having max(ps.idpreinscripcionseguimiento) = (select max(idpreinscripcionseguimiento) idpreinscripcionseguimiento from preinscripcionseguimiento pss where p.idpreinscripcion =pss.idpreinscripcion )


        //exit();
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        return $row_operacion;
    }


    function calcular_edad_estudiante($codigoestudiante) {
        $query="
		SELECT
		eg.fechanacimientoestudiantegeneral
		FROM
		estudiante e,  estudiantegeneral eg
		WHERE
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND e.codigoestudiante='$codigoestudiante'
                ";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        $edad=$this->edad($row_operacion['fechanacimientoestudiantegeneral']);
        return $edad;
    }

    function edad($fecha) {
        list ($ano,$dia, $mes) = explode ('-', $fecha);
        $fecha = mktime (0,0,0,$mes,$dia,$ano);
        $fecha = time() - $fecha;
        $anos =  round($fecha/ (365*24*60*60));
        $meses = $fecha - $anos * (365*24*60*60);
        $meses = round($meses/ (30*24*60*60));
        return $anos;
    }

    function barra() {
        echo "<div style='float:left;margin:10px 0px 0px 1px;width:5px;height:12px;background:white;color:white;'></div>";
        //echo "<div id='progress' style='position:relative;padding:0px;width:2048px;height:60px;left:25px;'>";
        flush();
        ob_flush();
    }

    function escribir_cabeceras($matriz) {
        echo "<tr>\n";
        while($elemento = each($matriz)) {
            echo "<td>$elemento[0]</a></td>\n";
        }
        echo "</tr>\n";
    }

    function tabla($matriz,$texto="") {
        if(is_array($matriz)) {
            echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
            echo "<caption align=TOP>$texto</caption>";
            $this->escribir_cabeceras($matriz[0],$link);
            for($i=0; $i < count($matriz); $i++) {
                echo "<tr>\n";
                while($elemento=each($matriz[$i])) {
                    echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
                }
                echo "</tr>\n";
            }
            echo "</table>\n";
        }
        else {
            echo $texto." Matriz no valida<br>";
        }
    }

    function obtenerDatosOrdenMatricula($codigoestudiante,$retorno="") {

        $query="SELECT o.*, d.valorconcepto
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		and e.codigoestudiante='".$codigoestudiante."'
		GROUP by e.codigoestudiante";
        /*Query original se modifica por q no salen los q pagaron pero no tienen prematricula
         * $query="SELECT o.*, d.valorconcepto
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='$this->codigoperiodo'
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='".$this->codigoperiodo."'
		AND o.codigoestadoordenpago LIKE '4%'
		and e.codigoestudiante='".$codigoestudiante."'
		GROUP by e.codigoestudiante";
        */


        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        return $row_operacion;
    }


    function obtenerUltimoSeguimientoEstudiante($codigoestudiante,$retorno="") {
        $query="SELECT
		es.idestudianteseguimiento,
		es.fechaestudianteseguimiento,
		es.observacionestudianteseguimiento,
		TIMESTAMPDIFF(DAY,es.fechaestudianteseguimiento,CURDATE()) AS dias
		FROM estudianteseguimiento es
		WHERE es.codigoestudiante='$codigoestudiante'
                ";

        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        do {
            if($row_operacion['idestudianteseguimiento']<>"") {
                $array_interno[]=$row_operacion;
            }
        }
        while ($row_operacion=$operacion->fetchRow());
        if($retorno=='fecha') {
            return $array_interno[count($array_interno)-1]['fechaestudianteseguimiento'];
        }
        elseif($retorno=='observacion') {
            return $array_interno[count($array_interno)-1]['observacionestudianteseguimiento'];
        }
        else {
            return $array_interno[count($array_interno)-1]['dias'];
        }
    }

    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede a?adir una condicion $condicion y una operacion (max(),min(),sum()...) basica
    function recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion="",$operacion="",$imprimir=0) {
        $query="select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        if($imprimir)
            echo $query;
        return $row_operacion;
    }
    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede a?adir una condicion $condicion y una operacion (max(),min(),sum()...) basica
    function recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion="",$operacion="",$imprimir=0) {
        $query="select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
        $operacion=$this->conexion->query($query);
        if($imprimir)
            echo $query;
        return $operacion;
    }

    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede a?adir una condicion $condicion y una operacion (max(),min(),sum()...) basica
    function recuperar_datos_tabla_fila($tabla,$clave,$valor,$condicion="",$operacion="",$imprimir=0) {
        $condicion==""?$where="":$where="where";
        $query="select $clave, $valor $operacion from $tabla $where  $condicion";
        $operacion=$this->conexion->query($query);

        $explodeclave=explode(".",$clave);
        $explodevalor=explode(".",$valor);
        if($explodeclave[1]!="")  $clave=$explodeclave[1];
        if($explodevalor[1]!="")  $valor=$explodevalor[1];


        while($row_operacion=$operacion->fetchRow()) {
            $fila[$row_operacion[$clave]]=$row_operacion[$valor];

        }

        if($imprimir)
            echo $query;

        return $fila;
    }

    //Inserta una fila de datos del tipo $fila['clave']=valor en la tabla $tabla donde
    //las claves son los nombres de los campos y los valores son los valores de campo a insertar
    function insertar_fila_bd($conexion,$tabla,$fila) {

        $claves="(";
        $valores="(";
        $i=0;
        while (list ($clave, $val) = each ($fila)) {

            if($i>0) {
                $claves .= ",".$clave."";
                $valores .= ",'".$val."'";
            }
            else {
                $claves .= "".$clave."";
                $valores .= "'".$val."'";
            }
            $i++;
        }
        $claves .= ")";
        $valores .= ")";

        $sql="insert into $tabla $claves values $valores";
        $conexion->debug=true;
        $operacion=$conexion->query($sql);
        $conexion->debug=false;
        $this->contador_inserta++;
    }

    //Actualiza de una fila de datos del tipo $fila['clave']=valor en la tabla $tabla donde
    //las claves son los nombres de los campos y los valores son los valores de campo a actualizar
    //dependiendo del id de la tabla ingresado $idtabla
    function actualizar_fila_bd($conexion,$tabla,$fila,$nombreidtabla,$idtabla) {
        $i=0;
        while (list ($clave, $val) = each ($fila)) {
            if($i>0) {
                $claves .= ",".$clave."";
                $valores .= ",'".$val."'";
                $condiciones .= ",".$clave."='".$val."'";
            }
            else {
                @$claves .= "".$clave."";
                @$valores .= "'".$val."'";
                @$condiciones .= $clave."='".$val."'";
            }
            $i++;
        }

        $sql="update $tabla set $condiciones where $nombreidtabla=$idtabla";
        $conexion->debug=true;
        $operacion=$conexion->query($sql);
        $conexion->debug=false;
        $this->contador_actualiza++;
    }

    //Ingresa o actualiza un registro dependiendo de si se encuentran registros con el mismo id
    //o la misma condicion.
    function ingresar_actualizar_fila_bd($conexion,$tabla,$fila,$nombreidtabla,$idtabla,$condicion="") {
        $sql="select * from $tabla where $nombreidtabla='$idtabla' $condicion";
        $operacion=$conexion->query($sql);
        $numrows=$operacion->numRows();
        if($numrows>0)
            $this->actualizar_fila_bd($conexion,$tabla,$fila,$nombreidtabla,$idtabla,$condicion);
        else
            $this->insertar_fila_bd($conexion,$tabla,$fila);
    }
    //Ingresa o anula un registro dependiendo de si se encuentran registros con el mismo id
    //o la misma condicion.
    function ingresar_vencer_fila_bd($conexion,$tabla,$fila,$nombreidtabla,$idtabla,$condicion="") {
        $sql="select * from $tabla where $nombreidtabla=$idtabla $condicion";
        $operacion=$this->conexion->query($sql);
        $numrows=$operacion->numRows();
        if($numrows>0)
            insertar_fila_bd($tabla,$fila);
        else
            actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion);
    }
    function ObtenerInscritos($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
        $arreglo1=$this->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$codigocarrera,153,'arreglo');
        $arreglo2=$this->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($codigoperiodo,$codigocarrera,153,'arreglo');
//	print_r($arreglo1);
//	print_r($arreglo2);
//	print_r($arreglo1+$arreglo2);
	$arreglo3=$arreglo1+$arreglo2;
        $conteo=count($arreglo3);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $arreglo3;
        }
    }
    function ObtenerAdmitidos($codigoperiodo,$codigocarrera,$cuentaoperacionprincipal,$retorno) {
    	$arreglo1=$this->seguimiento_inscripcionvsmatriculadosnuevos($codigocarrera,'arreglo');
    	$arreglo2=$this->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$codigocarrera,153,'arreglo');
//	print_r($arreglo1);
//	print_r($arreglo2);
	$arreglo3=$arreglo1+$arreglo2;
        $conteo=count($arreglo3);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $arreglo3;
        }
    }
    function ObtenerMatriculados($codigocarrera,$retorno) {
    	$arreglo1=$this->obtener_datos_estudiantes_matriculados_nuevos($codigocarrera,'arreglo');
        $conteo=count($arreglo1);
        if($retorno=='conteo') {
            return $conteo;
        }
        elseif ($retorno=='arreglo') {
            return $arreglo1;
        }
    }
}
?>
