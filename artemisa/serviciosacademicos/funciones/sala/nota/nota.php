<?php
class detallenota
{
    // Variables
    var $idgrupo;
    var $idcorte;
    var $codigoestudiante;
    //var $codigomateria;
    var $nota;
    var $numerofallasteoria;
    var $numerofallaspractica;
    var $fallasteoricacorte;
    var $fallaspracticacorte;
    var $codigotiponota;

    var $notaminimaaprobatoria;
    var $numerocreditos;

    var $grupo;
    var $porcentajecreditosperdidos = 0;

    var $mensaje = "Riesgos encontrados:";

    var $mensajepierdeMasdel50 = "";

    var $mensajeppaMenor33 = "";

    var $mensajepierdeAsignaturaOtraVez = "";

    var $mensajeestaEnPrueba = "";

    var $mensajeperdioPorFallas = "";

    var $mensajepierdeMasde25yMenosde50 = "";

    var $materiasperdidas = "";

    var $materiasperdidasfallas = "";

    var $mensajepierdeMasde0yMenosde25 = "";

        var $porcentajecorte;
        
        var $acumuladoCertificado;

    // This is the constructor for this class
    // Initialize all your default variables here
    function detallenota($codigoestudiante, $codigoperiodo, $condatos = true)
    {
        $this->codigoestudiante = $codigoestudiante;
        $this->acumuladoCertificado=0;
        global $db;
        if($condatos)
        {
	       $query_detallenota = "select dn.nota, dn.idcorte, dn.codigomateria, m.numerocreditos, dp.idgrupo,
	        m.notaminimaaprobatoria, c.numerocorte, c.porcentajecorte, dn.numerofallasteoria, dn.numerofallaspractica
			from detallenota dn, detalleprematricula dp, prematricula p, materia m, corte c
	        where p.idprematricula = dp.idprematricula
	        and p.codigoestadoprematricula like '4%'
	        and dp.idgrupo = dn.idgrupo
	        and m.codigomateria = dn.codigomateria
	        and dn.codigoestudiante = p.codigoestudiante
	        and dp.codigomateria = m.codigomateria
	        and c.idcorte = dn.idcorte
	        and dp.codigoestadodetalleprematricula like '3%'
	        and p.codigoestudiante = '$codigoestudiante'
	        and p.codigoperiodo = '$codigoperiodo'
	        order by dn.idcorte, dn.codigomateria";
	        $detallenota = $db->Execute($query_detallenota);
	        $totalRows_detallenota = $detallenota->RecordCount();
	        while($row_detallenota = $detallenota->FetchRow())
	        {
	            //$this->nota[$row_detallenota['idcorte']][$row_detallenota['codigomateria']] = $row_detallenota['nota'];
	            //$this->idcorte[] = $row_detallenota['idcorte'];
	            //$this->codigomateria[] = $row_detallenota['codigomateria'];
	            $this->numerocreditos[$row_detallenota['codigomateria']] = $row_detallenota['numerocreditos'];
	            //$this->notaminimaaprobatoria[$row_detallenota['codigomateria']] = $row_detallenota['notaminimaaprobatoria'];
	            //$this->porcentajecorte[$row_detallenota['idcorte']]= $row_detallenota['porcentajecorte'];

	            // Calculamos la nota promedio acumulada (npa) por materia, junto con el calculo de la npa para la notaminimaaprobatoria de cada materia
	            //$this->nota[$row_detallenota['idcorte']][$row_detallenota['codigomateria']] += $row_detallenota['nota'] * $row_detallenota['porcentajecorte'] / 100;

	            // Para hallar la nota original para cada materia debo guardar las notas y luego mu
		$this->porcentajecorte[$row_detallenota['codigomateria']]+=$row_detallenota['porcentajecorte'];
	            $this->nota[$row_detallenota['codigomateria']] += $row_detallenota['nota'] * $row_detallenota['porcentajecorte'] / 100;
	            $this->notaminimaaprobatoria[$row_detallenota['codigomateria']] += $row_detallenota['notaminimaaprobatoria'] * $row_detallenota['porcentajecorte'] / 100;
	            $this->notaminimappa[$row_detallenota['codigomateria']] += 3.3 * $row_detallenota['porcentajecorte'] / 100;
	            $this->grupo[$row_detallenota['codigomateria']] = $row_detallenota['idgrupo'];
                    $this->fallasteoricacorte[$row_detallenota['codigomateria']][$row_detallenota['numerocorte']]=$row_detallenota['numerofallasteoria'];
                    $this->fallaspracticacorte[$row_detallenota['codigomateria']][$row_detallenota['numerocorte']]=$row_detallenota['numerofallaspractica'];
	            /*$query_corte = "select c.porcentajecorte, c.numerocorte
	             from corte c
	             where c.idcorte = 5109";
	             $detallenota = $db->Execute($query_detallenota);
	             $totalRows_detallenota = $detallenota->RecordCount();
	             while($row_detallenota = $detallenota->FetchRow())
	             {
	             $this->notapromedioacumulada[] = $row_detallenota['notaminimaaprobatoria'];}*/
	        }
        }
    }

    /**
     * @return retorna si el estudiante tiene notas
     * @desc esAltoRiesgo : Getting value for variable $idgrupo
     */
    function tieneNotas()
    {
        if(count($this->nota) != 0)
        {
            return true;
        }
        return false;
    }

	/**
     * @return retorna si el estudiante tiene notas
     * @desc esAltoRiesgo : Getting value for variable $idgrupo
     */
    function tieneNotasXMateria($codigomateria)
    {
        if(isset($this->nota[$codigomateria]))
        {
            return true;
        }
        return false;
    }

    /**
     * @return returns true si el estudiante está en prueba academica
     * @desc getIdgrupo : Getting value for variable $idgrupo
     */
    function estaEnPrueba()
    {
        global $db;
        //$db->debug = true;
        $query_situacion = "select e.codigoestudiante
        from estudiante e
        where e.codigosituacioncarreraestudiante in (200)
        and e.codigoestudiante = '$this->codigoestudiante'";
        $situacion = $db->Execute($query_situacion);
        $totalRows_situacion = $situacion->RecordCount();
        if($totalRows_situacion != 0)
        {
            $this->mensaje = $this->mensaje."\\nEstá en prueba académica";
            $this->mensajeestaEnPrueba = "SI";
            return true;
        }
        return false;
    }

    /**
     * @return retorna si el estudiante es de alto riego
     * @desc esAltoRiesgo : Getting value for variable $idgrupo
     */
    function esAltoRiesgo($sala='')
    {
		
        $retorno = false;
        if($this->tieneNotas())
        {
            if($this->pierdeMasdel50())
            {
                $retorno = true;
            }
            if($this->pierdeAsignaturaOtraVez())
            {
                $retorno = true;
            }
        }

        if($this->ppaMenor33($sala))
        {
            $retorno = true;
        }
        if($this->estaEnPrueba())
        {
            $retorno = true;
        }
        /*if($this->perdioPorFallas())
        {
            $retorno = true;
        }*/

        /*if($this->pierdeMasdel50() || $this->ppaMenor33() || $this->pierdeAsignaturaOtraVez() || $this->estaEnPrueba() || $this->perdioPorFallas())
        {
            return true;
        }*/
        return $retorno;
    }

	/**
     * @return retorna si el estudiante es de alto riego
     * @desc esAltoRiesgo : Getting value for variable $idgrupo
     */
    function esAltoRiesgoXMateria($codigomateria, $idgrupo)
    {
        $retorno = false;
        /*// Para saber si el estudiante pierde el 50% o mas de los creditos cursados
        // 1. Se cuenta el total de creditos
        $totalcreditos = array_sum($this->numerocreditos);
        $creditosperdidos = 0;
        //echo "";

        // 2. Se mira en cuanto lleva el promedio

        foreach($this->nota as $codigomateria => $nota)
        {
            //$this->notaminimaaprobatoria[$codigomateria];
            if($this->notaminimaaprobatoria[$codigomateria] > $nota)
            {
                $creditosperdidos = $creditosperdidos + $this->numerocreditos[$codigomateria];
            }
        }
        $porcentajecreditosperdidos = $creditosperdidos * 100 / $totalcreditos;

        //echo "<h1>$porcentajecreditosperdidos = $creditosperdidos * 100 / $totalcreditos;</h1>";
        $this->porcentajecreditosperdidos = round($porcentajecreditosperdidos,2);

        /*if($this->pierdeMasdel50XMateria($codigomateria))
        {
            $retorno = true;
        }*/
        if($this->tieneNotasXMateria($codigomateria))
        {
            if($this->pierdeMasdel50())
            {
                $retorno = true;
            }
            /*if($this->perdioPorFallasXMateria($idgrupo, $codigomateria))
            {
                $retorno = true;
            }*/
            if($this->pierdeAsignaturaOtraVez())
            {
                $retorno = true;
            }
        }
        if($this->ppaMenor33())
        {
            $retorno = true;
        }
        /*if($this->pierdeAsignaturaOtraVezXMateria($codigomateria))
        {
            $retorno = true;
        }*/
        if($this->estaEnPrueba())
        {
            $retorno = true;
        }
        /*if($this->perdioPorFallasXMateria($idgrupo, $codigomateria))
        {
            $retorno = true;
        }*/
    	/*if($this->perdioPorFallas())
        {
            $retorno = true;
        }*/

        /*if($this->pierdeMasdel50() || $this->ppaMenor33() || $this->pierdeAsignaturaOtraVez() || $this->estaEnPrueba() || $this->perdioPorFallas())
        {
            return true;
        }*/
        return $retorno;
    }

	/**
     * @return retorna si el estudiante es de mediano riesgo
     * @desc esAltoRiesgo : Getting value for variable $idgrupo
     */
    function esMedianoRiesgo()
    {
        if($this->tieneNotas())
        {
            if($this->porcentajecreditosperdidos >= 25 && $this->porcentajecreditosperdidos < 50)
            {
                $this->mensaje = $this->mensaje."\\nEstá perdiendo el $this->porcentajecreditosperdidos% de los créditos en los que tiene nota";
                $this->mensajepierdeMasde25yMenosde50 = "$this->porcentajecreditosperdidos%";
                return true;
            }
        }
        return false;
    }

	/**
     * @return retorna si el estudiante es de mediano riesgo en una materia
     * @desc esAltoRiesgo : Getting value for variable $idgrupo
     */
    function esMedianoRiesgoXMateria($codigomateria)
    {
        if($this->tieneNotasXMateria($codigomateria))
        {
            if($this->porcentajecreditosperdidos >= 25 && $this->porcentajecreditosperdidos < 50)
            {
                $this->mensaje = $this->mensaje."\\nEstá perdiendo el $this->porcentajecreditosperdidos% de los créditos en los que tiene nota";
                return true;
            }
        }
        return false;
    }

    /**
     * @return retorna si el estudiante es de mediano riesgo
     * @desc esAltoRiesgo : Getting value for variable $idgrupo
     */
    function esBajoRiesgo()
    {
        if($this->tieneNotas())
        {
            if($this->porcentajecreditosperdidos < 25 && $this->porcentajecreditosperdidos > 0)
            {
                $this->mensaje = $this->mensaje."\\nEstá perdiendo el $this->porcentajecreditosperdidos% de los créditos en los que tiene nota";
                $this->mensajepierdeMasde0yMenosde25 = "$this->porcentajecreditosperdidos%";
                return true;
            }
        }
        return false;
    }

     /**
     * @return retorna si el estudiante es de mediano riesgo
     * @desc esAltoRiesgo : Getting value for variable $idgrupo
     */
    function esBajoRiesgoXMateria($codigomateria)
    {
        if($this->tieneNotasXMateria($codigomateria))
        {
            if($this->porcentajecreditosperdidos < 25 && $this->porcentajecreditosperdidos > 0)
            {
                $this->mensaje = $this->mensaje."\\nEstá perdiendo el $this->porcentajecreditosperdidos% de los créditos en los que tiene nota";
                return true;
            }
        }
        return false;
    }

    /**
     * @return retorna si el estudiante es de alto riesgo, mediano riesgo o bajo riesgo en todas las materias en las que tiene notas
     * @desc esAltoRiesgo : Getting value for variable $idgrupo
     */
    function riesgoEstudiante($imagen = true)
    {
        if($this->esAltoRiesgo())
        {
            //return "ALTO";
            if($imagen)
            {
?>
            <img src="rojo.png" align="middle" onClick="<?php $this->mensajeJS(); ?>">
<?php
			}
            return $this->mensaje;
        }
        if($this->esMedianoRiesgo())
        {
            //return "MEDIANO";
        	if($imagen)
            {
?>
            <img src="amarillo.png" align="middle" onClick="<?php $this->mensajeJS(); ?>">
<?php
			}
            return $this->mensaje;
        }
        if($this->esBajoRiesgo())
        {
            //return "BAJO";
        	if($imagen)
            {
?>
            <img src="azul.png" align="middle" onClick="<?php $this->mensajeJS(); ?>">
<?php
			}
            return $this->mensaje;
        }
        return "&nbsp;";
    }

    /**
     * @return retorna si el estudiante es de alto riesgo, mediano riesgo o bajo riesgo en una materia
     * @desc riesgoEstudianteXMateria : Getting value for variable $idgrupo
     */
    function riesgoEstudianteXMateria($codigomateria, $idgrupo,$app=false)
    {  
     
        if($this->esAltoRiesgoXMateria($codigomateria, $idgrupo))
        {
            if($app){
                return 1;
            }else{
            //return "ALTO";
?>
            <img src="rojo.png" align="middle" onClick="<?php $this->mensajeJS(); ?>">
<?php
            return;
            }
        }
    
        if($this->esMedianoRiesgoXMateria($codigomateria))
        {
            //return "MEDIANO";
            if($app){
                return 2;
            }else{
?>
            <img src="amarillo.png" align="middle" onClick="<?php $this->mensajeJS(); ?>">
<?php
            return;
            }
        }
     
        if($this->esBajoRiesgoXMateria($codigomateria))
        {
            //return "BAJO";
            if($app){
                return 3;
            }else{
?>  
            <img src="azul.png" align="middle" onClick="<?php $this->mensajeJS(); ?>">
<?php
            return;
            }
        }
        return "&nbsp;";
    }

    function mensajeJS()
    {
        echo "alert('".$this->mensaje."')";
    }

	/**
     * @return retorna si el estudiante perdió mas del 50
     * @desc pierdeMasdel50 : Getting value for variable $idgrupo
     */
    function pierdeMasdel50()
    {
        // Para saber si el estudiante pierde el 50% o mas de los creditos cursados
        // 1. Se cuenta el total de creditos
        $totalcreditos = array_sum($this->numerocreditos);
        $creditosperdidos = 0;
        //echo "";

        // 2. Se mira en cuanto lleva el promedio

        foreach($this->nota as $codigomateria => $nota)
        {
            //$this->notaminimaaprobatoria[$codigomateria];
            if($this->notaminimaaprobatoria[$codigomateria] > $nota)
            {
            	$this->materiasperdidas .= "$codigomateria,";
                $creditosperdidos = $creditosperdidos + $this->numerocreditos[$codigomateria];
            }
            else if($this->perdioPorFallasXMateria($this->grupo[$codigomateria],$codigomateria))
            {
            	$this->materiasperdidasfallas .= "$codigomateria,";
                $creditosperdidos = $creditosperdidos + $this->numerocreditos[$codigomateria];
            }
        }
        $porcentajecreditosperdidos = $creditosperdidos * 100 / $totalcreditos;

        //echo "<h1>$porcentajecreditosperdidos = $creditosperdidos * 100 / $totalcreditos;</h1>";
        $this->porcentajecreditosperdidos = round($porcentajecreditosperdidos,2);
        if($porcentajecreditosperdidos >= 50)
        {
            $this->mensaje = $this->mensaje."\\nEstá perdiendo el $this->porcentajecreditosperdidos% de los créditos en los que tiene nota";
            $this->mensajepierdeMasdel50 = "$this->porcentajecreditosperdidos%";
            return true;
        }
        return false;
    }

/**
     * @return retorna si el estudiante perdió una materia
     * @desc pierdeMasdel50XMateria : Getting value for variable $idgrupo
     */
    function pierdeMasdel50XMateria($codigomateria)
    {
        if($this->tieneNotasXMateria($codigomateria))
        {
            //echo "<br>".$this->notaminimaaprobatoria[$codigomateria]." > ".$this->nota[$codigomateria];
            if($this->notaminimaaprobatoria[$codigomateria] > $this->nota[$codigomateria])
            {
                $this->mensaje = $this->mensaje."\\nEstá perdiendo la materia";
                return true;
            }
        }
        return false;
    }

function setAcumuladoCertificado($acumuladocertificado){
    $this->acumuladoCertificado=$acumuladocertificado;
}
    /**
     * @return retorna si el estudiante lleva el promedio ponderado acumulado menos de 3.3
     * @desc ppaMenor33 : Getting value for variable $idgrupo
     */
    function ppaMenor33($sala='')
    {
		
		#echo '<pre>';print_r($sala);
        global $sala;
        global $salatmp;
        if(isset($salatmp)){
            unset($sala);
            $sala=$salatmp;
       // echo $sala;
        }
		##echo '<pre>';print_r($sala);
        // Para saber si el estudiante pierde el 50% o mas de los creditos cursados
        // 1. Se cuenta el total de creditos
        $ppa = 0;
        $ppaminimo = 0;

        // 2. Se mira en cuanto lleva el promedio
        if($this->tieneNotas())
        {
            foreach($this->nota as $codigomateria => $nota)
            {
                //$this->notaminimaaprobatoria[$codigomateria];
                $ppa += $nota * $this->numerocreditos[$codigomateria];
                $ppaminimo += $this->notaminimappa[$codigomateria] * $this->numerocreditos[$codigomateria];
            }
            //$ppaini = $ppa;
            //$ppaminimoini = $ppaminimo;
            $ppa = $ppa / array_sum($this->numerocreditos);

            $ppaminimo = $ppaminimo / array_sum($this->numerocreditos);
        }

        //echo "<h1>$ppa < $ppaminimo</h1>";
        // Ahora con el ponderado acumulado del estudiante se calcula si está `por debajo de 3.3

        /*if($ppa < $ppaminimo)
        {
        	$ppareal = 3.3*$ppa/$ppaminimo;
            $this->mensaje = $this->mensaje."\\nPromedio ponderado acumulado del semestre menor a 3.3";
            $this->mensajeppaMenor33 = "$ppareal < 3.3";
            return true;
        }*/
           
            if($this->acumuladoCertificado){
          		
                       $promedioacumulado = AcumuladoReglamento($this->codigoestudiante,"todo",$sala);
					   
                                if($promedioacumulado > 5) {
									
                                    $promedioacumulado =  number_format(($promedioacumulado / 100),1);
                                }
                                //echo $promedioacumulado. " AQUI";
                                $ppa=$promedioacumulado;
            }
            else{

    	$ppa = $this->tienePPAenBD();
            }
		if($ppa == false)
		{
			$ppa = $this->calculaPPA();
			if($ppa != 0 && $ppa != "FALSO")
			{
				$this->insertarPPAenBD($ppa);
			}
			if($ppa < 3.3 && $ppa != "FALSO")
        	{
        		$this->mensaje = $this->mensaje."\\nPromedio ponderado acumulado menor a 3.3 ";
            	$this->mensajeppaMenor33 = "$ppa < 3.3";
            	return true;
        	}
		}
		else if($ppa != 0 && $ppa != "FALSO")
		{
			if($ppa < 3.3 && $ppa != "FALSO")
        	{
        		$this->mensaje = $this->mensaje."\\nPromedio ponderado acumulado menor a 3.3 ";
            	$this->mensajeppaMenor33 = "$ppa < 3.3";
            	return true;
        	}
		}
        /*$ppa = $this->calculaPPA();
        if($ppa < 3.3 && $ppa != "FALSO")
        {
        	$this->mensaje = $this->mensaje."\\nPromedio ponderado acumulado menor a 3.3";
            $this->mensajeppaMenor33 = "$ppa < 3.3";
            return true;
        }*/
        return false;
    }

    function calculaPPA()
    {
    	global $db;
    	$notatotal = 0;
		$creditos = 0;
		$conplandeestudio = true;
		$promedioacumulado = "FALSO";

		$query_promedioacumulado = "SELECT 	n.codigoperiodo,n.codigomateria,n.notadefinitiva,m.numerocreditos,m.ulasa,m.ulasb,m.ulasc,m.codigoindicadorcredito,p.idplanestudio
		FROM notahistorico n,materia m,planestudioestudiante p
		WHERE n.codigoestudiante = '".$this->codigoestudiante."'
		AND n.codigomateria = m.codigomateria
		and p.codigoestudiante = n.codigoestudiante
		AND n.codigoestadonotahistorico LIKE '1%'
		and n.codigotiponotahistorico not like '11%'
	    and m.codigotipocalificacionmateria not like '2%'
		ORDER BY n.codigoperiodo";
		$res_promedioacumulado = $db->Execute($query_promedioacumulado);
		$totalRows_promedioacumulado = $res_promedioacumulado->RecordCount();
		$solicitud_promedioacumulado = $res_promedioacumulado->FetchRow();
		if($totalRows_promedioacumulado == 0)
		{
			$conplandeestudio = false;
			$query_promedioacumulado = "SELECT n.codigoperiodo,n.codigomateria,n.notadefinitiva,m.numerocreditos,m.ulasa,m.ulasb,m.ulasc,m.codigoindicadorcredito
			FROM notahistorico n,materia m
			WHERE n.codigoestudiante = '".$this->codigoestudiante."'
			AND n.codigomateria = m.codigomateria
			AND n.codigoestadonotahistorico LIKE '1%'
			and n.codigotiponotahistorico not like '11%'
			and m.codigotipocalificacionmateria not like '2%'
			ORDER BY n.codigoperiodo";
			$res_promedioacumulado = $db->Execute($query_promedioacumulado);
			$totalRows_promedioacumulado = $res_promedioacumulado->RecordCount();
			$solicitud_promedioacumulado = $res_promedioacumulado->FetchRow();
		}
		do
		{
			if($conplandeestudio)
			{
				$equivalencia = $this->seleccionarequivalencias1($solicitud_promedioacumulado['codigomateria'],$solicitud_promedioacumulado['idplanestudio']);
				//echo $equivalencia,"<br>";
				$Arregloequivalencias = $this->seleccionarequivalencias($equivalencia, $solicitud_promedioacumulado['idplanestudio']);
				// este if es provicional para materias que no esten dentro del plan de estudios como equivalencias.
				if ($equivalencia == "")
				{
					$Arregloequivalencias[] =$solicitud_promedioacumulado['codigomateria'];
				}
				$Arregloequivalencias[] = $equivalencia;
				////////////////////////////////////
				/*echo "Arregloequivalencias<br>";
				print_r($Arregloequivalencias); //"<h2>",$equivalencia,"</h2><br>";
				echo "<br>";*/
				foreach($Arregloequivalencias as $key3 => $selEquivalencias)
				{
					$notamayor = 0;
					//echo "$key3 => $selEquivalencias<br>";
					$query_promedioacumulado1 = "SELECT n.notadefinitiva
					FROM notahistorico n
					WHERE n.codigoestudiante = '".$this->codigoestudiante."'
					AND n.codigomateria = '$selEquivalencias'
					AND n.codigoestadonotahistorico LIKE '1%'
					ORDER BY 1 desc";
					$res_promedioacumulado1 = $db->Execute($query_promedioacumulado1);
					$totalRows_promedioacumulado1 = $res_promedioacumulado1->RecordCount();
					$solicitud_promedioacumulado1 = $res_promedioacumulado1->FetchRow();
					//echo "<h1>$totalRows_promedioacumulado1 ".$query_promedioacumulado1,"</h1>";
					if($totalRows_promedioacumulado1 <> 0)
					{
						if($solicitud_promedioacumulado1['notadefinitiva'] > 5)
						{
							$notamayor =  number_format(($solicitud_promedioacumulado1['notadefinitiva'] / 100),1);
						}
						else
						{
							$notamayor = $solicitud_promedioacumulado1['notadefinitiva'];
						}
						//echo $notamayor,"<br>";
						$notamateria[$selEquivalencias] = $notamayor;
						$codigomateria = $selEquivalencias;
					}
				}
				@$maxnota = max($notamateria);
				//print_r($notamateria);
				//echo "<br>";

				@$res_nota = array_keys ($notamateria, $maxnota);

				//print_r($res_nota);
				//echo "<br>";

				$notadefinitiva[$res_nota[0]]=$maxnota;
				//print_r($notadefinitiva);
				//echo "<br>";
				unset($Arregloequivalencias);
				unset($notamateria);
			}
			else
			{
				if($solicitud_promedioacumulado['notadefinitiva'] > 5)
				{
					$notamayor =  number_format(($solicitud_promedioacumulado['notadefinitiva'] / 100),1);
				}
				else
				{
					$notamayor = $solicitud_promedioacumulado['notadefinitiva'];
				}
				$notadefinitiva[$solicitud_promedioacumulado['codigomateria']] = $notamayor;
			}
		}
		while($solicitud_promedioacumulado = $res_promedioacumulado->FetchRow());

		//$db->debug = true;
		//print_r($notadefinitiva);
		foreach($notadefinitiva as $key3 => $selEquivalencias)
		{
			$query_promedioacumulado = "SELECT *
			FROM notahistorico n,materia m
			WHERE n.codigoestudiante = '".$this->codigoestudiante."'
			AND n.codigomateria = '$key3'
			AND n.codigoestadonotahistorico LIKE '1%'
			and n.codigomateria = m.codigomateria
			ORDER BY 1";
			$res_promedioacumulado = $db->Execute($query_promedioacumulado);

			$solicitud_promedioacumulado = $res_promedioacumulado->FetchRow();
			do
			{
				if($solicitud_promedioacumulado['codigoindicadorcredito'] == 200)
				{
					$indicadorulas = 1;
				}
			}
			while($solicitud_promedioacumulado = $res_promedioacumulado->FetchRow());

			$query_promedioacumulado2 = "SELECT n.codigomateria,n.notadefinitiva,
			m.numerocreditos,ulasa,ulasb,ulasc,codigoindicadorcredito
			FROM notahistorico n,materia m
			WHERE n.codigoestudiante = '".$this->codigoestudiante."'
			AND n.codigomateria = '$key3'
			AND n.codigoestadonotahistorico LIKE '1%'
			and n.codigomateria = m.codigomateria
			ORDER BY 1";
			$res_promedioacumulado2 = $db->Execute($query_promedioacumulado2);
			$totalRows_promedioacumulado2 = $res_promedioacumulado2->RecordCount();
			$solicitud_promedioacumulado2 = $res_promedioacumulado2->FetchRow();

			if($totalRows_promedioacumulado2 <> 0)
			{
				if($indicadorulas == 1)
				{
					if($solicitud_promedioacumulado2['codigoindicadorcredito'] == 100)
					{
						$notatotal = $notatotal + ($selEquivalencias * ($solicitud_promedioacumulado2['numerocreditos'] * 48)) ;
						$creditos = $creditos + ($solicitud_promedioacumulado2['numerocreditos'] * 48);
					}
					else
					{
						$notatotal = $notatotal + ($selEquivalencias * ($solicitud_promedioacumulado2['ulasa'] + $solicitud_promedioacumulado2['ulasb'] + $solicitud_promedioacumulado2['ulasc'])) ;
						$creditos = $creditos + ($solicitud_promedioacumulado2['ulasa'] + $solicitud_promedioacumulado2['ulasb'] + $solicitud_promedioacumulado2['ulasc']);
					}
				}
				else
				{
					$notatotal = $notatotal + ($selEquivalencias * $solicitud_promedioacumulado2['numerocreditos']) ;
					$creditos = $creditos + $solicitud_promedioacumulado2['numerocreditos'];
				}
			}
		}
	    if($creditos != "")
		{
			//$promedioacumulado = (number_format($notatotal/$creditos,1));
			$promedioacumulado = $notatotal/$creditos;
			$promedioacumulado = $this->redondeo($promedioacumulado);
		}
		//echo "<br>dsdas $promedioacumulado";
		//@$promedioacumulado = (number_format($notatotal/$creditos,1));
		unset($Arregloequivalencias);
		unset($notamateria);
		unset($notadefinitiva);
		unset($maxnota);
		unset($res_nota);
		//$db->debug = false;
		//$this->ppa = $promedioacumulado;
		//echo "<h3>$promedioacumulado</h3>";
		//exit();
		return $promedioacumulado;
    }

	function tienePPAenBD()
    {
    	global $db;
    	$query_estudiantes = "select b.valorbasesalario, b.porcentajeincrementobasesalario
		from basesalario b
		where b.valorbasesalario = '$this->codigoestudiante'";
		
		
		
		$estudiantes = $db->Execute($query_estudiantes);
		$totalRows_estudiantes = $estudiantes->RecordCount();
		if($totalRows_estudiantes != 0)
		{
			$row_estudiantes = $estudiantes->FetchRow();
			return $row_estudiantes['porcentajeincrementobasesalario'];
		}
		return false;
    }

	function insertarPPAenBD($ppa)
    {
    	global $db;
    	$query_estudiantes = "INSERT INTO basesalario(idbasesalario, nombrebasesalario, fechainiciobasesalario, fechafinalbasesalario, valorbasesalario, porcentajeincrementobasesalario)
		VALUES(0, 'SALA', now(), now(), '$this->codigoestudiante', '$ppa')";
		$estudiantes = $db->Execute($query_estudiantes);
    }

    function seleccionarequivalencias1($codigomateria, $idplanestudio)
	{
		global $db;

		$query_selequivalencias = "select r.codigomateria, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
		from referenciaplanestudio r
		where r.idplanestudio = '$idplanestudio'
		and r.codigomateriareferenciaplanestudio = '$codigomateria'
		and r.codigotiporeferenciaplanestudio like '3%'";
	    //echo "$query_selequivalencias<br>";//and r.idlineaenfasisplanestudio = '$idlineaenfasis'
	    $selequivalencias = $db->Execute($query_selequivalencias);
		$totalRows_selequivalencias = $selequivalencias->RecordCount();
		$row_selequivalencias = $selequivalencias->FetchRow();

		if($totalRows_selequivalencias != 0)
		{
	     	//echo $row_selequivalencias['codigomateria'],"hola<br>";
			$codigomateriaequivalentes = $row_selequivalencias['codigomateria'];
			//echo $codigomateriaequivalente;
			return $codigomateriaequivalentes;
		}
		else
		{
		///echo "hola3<br>";
		   	$query_selequivalencias = "select r.codigomateria, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
	      	from referenciaplanestudio r
	       	where r.idplanestudio = '$idplanestudio'
	      	and r.codigomateria = '$codigomateria'
	   	   	and r.codigotiporeferenciaplanestudio = '300'";
		   	//echo "$query_selequivalencias<br>";
	  		$selequivalencias = $db->Execute($query_selequivalencias);
			$totalRows_selequivalencias = $selequivalencias->RecordCount();
			$row_selequivalencias = $selequivalencias->FetchRow();
		  	return $row_selequivalencias['codigomateria'];
		}
	}

	function seleccionarequivalencias($codigomateria, $idplanestudio)
	{
		global $db;

		//echo "$codigomateria<br>";
		// La correspondencia siempre va a ser uno a uno
		$query_selequivalencias = "select r.codigomateriareferenciaplanestudio, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
		from referenciaplanestudio r
		where r.idplanestudio = '$idplanestudio'
		and r.codigomateria = '$codigomateria'
		and r.codigotiporeferenciaplanestudio like '3%'";
		//echo "$query_selequivalencias<br>";
		$selequivalencias = $db->Execute($query_selequivalencias);
		$totalRows_selequivalencias = $selequivalencias->RecordCount();
		if($totalRows_selequivalencias != 0)
		{
			while($row_selequivalencias = $selequivalencias->FetchRow())
			{
				$codigomateriaequivalente = $row_selequivalencias['codigomateriareferenciaplanestudio'];
				//echo "$codigomateriaequivalente<br>";
				$Arregloequivalencias[] = $codigomateriaequivalente;
			}
			return $Arregloequivalencias;
		}
		else
		{
			return;
		}
	}

	function redondeo ($notafinal)
	{
	   $notafinal = number_format($notafinal,1);
	   $notafinal = round($notafinal * 10)/10;
	   $notafinal = number_format($notafinal,1);
	   return $notafinal;
	}

	/**
     * @return retorna si el estudiante está perdiendo una asignatura por segunda vez
     * @desc ppaMenor33 : Getting value for variable $idgrupo
     */
    function pierdeAsignaturaOtraVez()
    {
        // Para saber si el estudiante pierde el 50% o mas de los creditos cursados
        // 1. Se cuenta el total de creditos
        $totalcreditos = array_sum($this->numerocreditos);
        $creditosperdidos = 0;
        //echo "";

        // 2. Se mira en cuanto lleva el promedio

        foreach($this->nota as $codigomateria => $nota)
        {
            //$this->notaminimaaprobatoria[$codigomateria];
            if($this->notaminimaaprobatoria[$codigomateria] > $nota)
            {
                if($this->esMateriaPerdida($codigomateria))
                {
                    $this->mensaje = $this->mensaje."\\nEstá perdiendo una asignatura por segunda vez";
                    $this->mensajepierdeAsignaturaOtraVez .= "$codigomateria,";
                    return true;
                }
            }
        }
        return false;
    }

	/**
     * @return retorna si el estudiante está perdiendo una materia específica por segunda vez
     * @desc pierdeAsignaturaOtraVezXMateria : Getting value for variable $idgrupo
     */
    function pierdeAsignaturaOtraVezXMateria($codigomateria)
    {
        if($this->tieneNotasXMateria($codigomateria))
        {
            if($this->notaminimaaprobatoria[$codigomateria] > $this->nota[$codigomateria])
            {
                if($this->esMateriaPerdida($codigomateria))
                {
                    $this->mensaje = $this->mensaje."\\nEstá perdiendo esta asignatura por segunda vez";
                    return true;
                }
            }
        }
        return false;
    }

    function perdioPorFallas()
    {
        global $db;
        foreach($this->grupo as $codigomateria => $idgrupo)
        {
            // Query que trae la cantidad de actividades digitadas por el docente.
            $query_actividades ="select sum(actividadesacademicasteoricanota) as teoria, sum(actividadesacademicaspracticanota) as practica
    	   	from nota n,grupo g
    	   	where n.idgrupo = g.idgrupo
    	   	and g.idgrupo = '$idgrupo'";

            $actividades = $db->Execute($query_actividades);
            $totalRows_actividades = $actividades->RecordCount();
            $row_actividades = $actividades->FetchRow();
            // Query que trae las fallas totales del estudiante

            $query_fallas = "select sum(numerofallasteoria) as fallasteoria, sum(numerofallaspractica) as fallaspractica
        	from detallenota n
        	where idgrupo = '$idgrupo'
        	and codigoestudiante = '$this->codigoestudiante'";
            $fallas = $db->Execute($query_fallas);
            $totalRows_fallas = $fallas->RecordCount();
            $row_fallas = $fallas->FetchRow();

            // Query que trae el los porcentajes de las fallas de la materia

            $query_porcent ="select porcentajefallasteoriamodalidadmateria, porcentajefallaspracticamodalidadmateria
    	   	from materia
    	   	where codigomateria = '$codigomateria'";
            $porcent = $db->Execute($query_porcent);
            $totalRows_porcent = $porcent->RecordCount();
            $row_porcent = $porcent->FetchRow();

            $calculofallasteoria   = 0;
            $calculofallaspractica = 0;
            $calculofallasteoria   = ($row_porcent['porcentajefallasteoriamodalidadmateria']   * $row_actividades['teoria'])  / 100;
            $calculofallaspractica = ($row_porcent['porcentajefallaspracticamodalidadmateria'] * $row_actividades['practica'])/ 100;
            //unset($arreglo_perdieron);
            //echo "<br>ACA $idgrupo $codigomateria $totalRows_actividades == 0 || $totalRows_fallas == 0";

        	/*if (($row_fallas['fallasteoria'] >= $calculofallasteoria or $row_fallas['fallaspractica'] >= $calculofallaspractica))
            {
                if(($row_actividades['teoria'] == 0) || $row_actividades['practica'] == 0)
                {
                    //echo "ACA ".$row_fallas['fallasteoria']." >= $calculofallasteoria or ".$row_fallas['fallaspractica']." >= $calculofallaspractica";
                    //$arreglo_perdieron = array($codigomateria,$codigoestudiante,$row_fallas['fallasteoria'],$row_fallas['fallaspractica'],$row_actividades['teoria'],$row_actividades['practica']);
                    //return $arreglo_perdieron;

                    $this->mensaje = $this->mensaje."\\nEstá perdiendo una asignatura por fallas";
                    $this->mensajeperdioPorFallas .= "$codigomateria <br>";
                    return true;
                }
            }*/
        	if ($row_fallas['fallasteoria'] >= $calculofallasteoria)
            {
                if($row_fallas['fallasteoria'] > 0)
                {
                    //echo "ACA ".$row_fallas['fallasteoria']." >= $calculofallasteoria or ".$row_fallas['fallaspractica']." >= $calculofallaspractica";
                    //$arreglo_perdieron = array($codigomateria,$codigoestudiante,$row_fallas['fallasteoria'],$row_fallas['fallaspractica'],$row_actividades['teoria'],$row_actividades['practica']);
                    //return $arreglo_perdieron;

                    $this->mensaje = $this->mensaje."\\nEstá perdiendo una asignatura por fallas";
                    $this->mensajeperdioPorFallas .= "$codigomateria <br>";
                    return true;
                }
            }
        	if ($row_fallas['fallaspractica'] >= $calculofallaspractica)
            {
                if($row_fallas['fallaspractica'] > 0)
                {
                    //echo "ACA ".$row_fallas['fallasteoria']." >= $calculofallasteoria or ".$row_fallas['fallaspractica']." >= $calculofallaspractica";
                    //$arreglo_perdieron = array($codigomateria,$codigoestudiante,$row_fallas['fallasteoria'],$row_fallas['fallaspractica'],$row_actividades['teoria'],$row_actividades['practica']);
                    //return $arreglo_perdieron;

                    $this->mensaje = $this->mensaje."\\nEstá perdiendo una asignatura por fallas";
                    $this->mensajeperdioPorFallas .= "$codigomateria <br>";
                    return true;
                }
            }
        }
        return false;
    }

    function perdioPorFallasXMateria($idgrupo, $codigomateria)
    {
        global $db;
        /*if($codigomateria == 686)
        {
        	$db->debug = true;
        }*/
        // Query que trae la cantidad de actividades digitadas por el docente.

        $query_actividades ="select sum(actividadesacademicasteoricanota) as teoria, sum(actividadesacademicaspracticanota) as practica
	   	from nota n,grupo g
	   	where n.idgrupo = g.idgrupo
	   	and g.idgrupo = '$idgrupo'";

        $actividades = $db->Execute($query_actividades);
        $totalRows_actividades = $actividades->RecordCount();
        $row_actividades = $actividades->FetchRow();
        // Query que trae las fallas totales del estudiante

        $query_fallas = "select sum(numerofallasteoria) as fallasteoria, sum(numerofallaspractica) as fallaspractica
    	from detallenota n
    	where idgrupo = '$idgrupo'
    	and codigoestudiante = '$this->codigoestudiante'";
        $fallas = $db->Execute($query_fallas);
        $totalRows_fallas = $fallas->RecordCount();
        $row_fallas = $fallas->FetchRow();

        // Query que trae el los porcentajes de las fallas de la materia

        $query_porcent ="select nombremateria, porcentajefallasteoriamodalidadmateria, porcentajefallaspracticamodalidadmateria
	   	from materia
	   	where codigomateria = '$codigomateria'";
        $porcent = $db->Execute($query_porcent);
        $totalRows_porcent = $porcent->RecordCount();
        $row_porcent = $porcent->FetchRow();
        /*if($codigomateria == 686)
        {
        	$db->debug = false;
        }*/

        $calculofallasteoria   = 0;
        $calculofallaspractica = 0;
        $calculofallasteoria   = ($row_porcent['porcentajefallasteoriamodalidadmateria']   * $row_actividades['teoria'])  / 100;
        $calculofallaspractica = ($row_porcent['porcentajefallaspracticamodalidadmateria'] * $row_actividades['practica'])/ 100;
        //unset($arreglo_perdieron);
   		if ($row_fallas['fallasteoria'] >= $calculofallasteoria)
        {
        	if($row_fallas['fallasteoria'] > 0)
            {
            	//echo "$idgrupo %fallas ".$row_porcent['porcentajefallasteoriamodalidadmateria']." N Activ Digitadas ".$row_actividades['teoria']." Fallas Real ".$row_fallas['fallasteoria']." >= $calculofallasteoria";
                //$arreglo_perdieron = array($codigomateria,$codigoestudiante,$row_fallas['fallasteoria'],$row_fallas['fallaspractica'],$row_actividades['teoria'],$row_actividades['practica']);
                //return $arreglo_perdieron;

                $this->mensaje = $this->mensaje."\\nEstá perdiendo la asignatura ".$row_porcent['nombremateria']."  por fallas";
                $this->mensajeperdioPorFallas .= "$codigomateria <br>";
                return true;
            }
       	}
        if ($row_fallas['fallaspractica'] >= $calculofallaspractica)
        {
        	if($row_fallas['fallaspractica'] > 0)
            {
            	//echo "ACA ".$row_fallas['fallasteoria']." >= $calculofallasteoria or ".$row_fallas['fallaspractica']." >= $calculofallaspractica";
                //$arreglo_perdieron = array($codigomateria,$codigoestudiante,$row_fallas['fallasteoria'],$row_fallas['fallaspractica'],$row_actividades['teoria'],$row_actividades['practica']);
                //return $arreglo_perdieron;

                $this->mensaje = $this->mensaje."\\nEstá perdiendo la asignatura ".$row_porcent['nombremateria']."  por fallas";
                $this->mensajeperdioPorFallas .= "$codigomateria <br>";
                return true;
            }
      	}
        return false;

    }

    /**
     * @return returns true si la materia se perdio en el pasado
     * @desc getIdgrupo : Getting value for variable $idgrupo
     */
    function esMateriaPerdida($codigomateria)
    {
        global $db;
        //$db->debug = true;
        $query_notahistorico = "select nh.notadefinitiva, m.notaminimaaprobatoria
        from notahistorico nh, materia m
        where nh.codigomateria = m.codigomateria
        and m.notaminimaaprobatoria > nh.notadefinitiva
        and nh.codigoestadonotahistorico like '1%'
        and nh.codigoestudiante = '$this->codigoestudiante'
        and nh.codigomateria = '$codigomateria'";
        $notahistorico = $db->Execute($query_notahistorico);
        $totalRows_notahistorico = $notahistorico->RecordCount();
        if($totalRows_notahistorico != 0)
        {
            return true;
        }
        return false;
    }

    /**
     * @return returns value of variable $idgrupo
     * @desc getIdgrupo : Getting value for variable $idgrupo
     */
    function getIdgrupo()
    {
        return $this->idgrupo;
    }

    /**
     * @param param : value to be saved in variable $idgrupo
     * @desc setIdgrupo : Setting value for $idgrupo
     */
    function setIdgrupo($value)
    {
        $this->idgrupo = $value;
    }

    /**
     * @return returns value of variable $idcorte
     * @desc getIdcorte : Getting value for variable $idcorte
     */
    function getIdcorte()
    {
        return $this->idcorte;
    }

    /**
     * @param param : value to be saved in variable $idcorte
     * @desc setIdcorte : Setting value for $idcorte
     */
    function setIdcorte($value)
    {
        $this->idcorte = $value;
    }

    /**
     * @return returns value of variable $codigoestudiante
     * @desc getCodigoestudiante : Getting value for variable $codigoestudiante
     */
    function getCodigoestudiante()
    {
        return $this->codigoestudiante;
    }

    /**
     * @param param : value to be saved in variable $codigoestudiante
     * @desc setCodigoestudiante : Setting value for $codigoestudiante
     */
    function setCodigoestudiante($value)
    {
        $this->codigoestudiante = $value;
    }

    /**
     * @return returns value of variable $codigomateria
     * @desc getCodigomateria : Getting value for variable $codigomateria
     */
    function getCodigomateria()
    {
        return $this->codigomateria;
    }

    /**
     * @param param : value to be saved in variable $codigomateria
     * @desc setCodigomateria : Setting value for $codigomateria
     */
    function setCodigomateria($value)
    {
        $this->codigomateria = $value;
    }

    /**
     * @return returns value of variable $nota
     * @desc getNota : Getting value for variable $nota
     */
    function getNota()
    {
        return $this->nota;
    }

    /**
     * @param param : value to be saved in variable $nota
     * @desc setNota : Setting value for $nota
     */
    function setNota($value)
    {
        $this->nota = $value;
    }

    /**
     * @return returns value of variable $numerofallasteoria
     * @desc getNumerofallasteoria : Getting value for variable $numerofallasteoria
     */
    function getNumerofallasteoria()
    {
        return $this->numerofallasteoria;
    }

    /**
     * @param param : value to be saved in variable $numerofallasteoria
     * @desc setNumerofallasteoria : Setting value for $numerofallasteoria
     */
    function setNumerofallasteoria($value)
    {
        $this->numerofallasteoria = $value;
    }

    /**
     * @return returns value of variable $numerofallaspractica
     * @desc getNumerofallaspractica : Getting value for variable $numerofallaspractica
     */
    function getNumerofallaspractica()
    {
        return $this->numerofallaspractica;
    }

    /**
     * @param param : value to be saved in variable $numerofallaspractica
     * @desc setNumerofallaspractica : Setting value for $numerofallaspractica
     */
    function setNumerofallaspractica($value)
    {
        $this->numerofallaspractica = $value;
    }

    /**
     * @return returns value of variable $codigotiponota
     * @desc getCodigotiponota : Getting value for variable $codigotiponota
     */
    function getCodigotiponota()
    {
        return $this->codigotiponota;
    }

    /**
     * @param param : value to be saved in variable $codigotiponota
     * @desc setCodigotiponota : Setting value for $codigotiponota
     */
    function setCodigotiponota($value)
    {
        $this->codigotiponota = $value;
    }
}

function tomarCantidadesRiesgosXMateria($idgrupo, $codigomateria)
{
    global $db;
global $salatmp;

//echo $sala;
    $query_estudiantes = "select e.codigoestudiante, p.codigoperiodo
    from estudiante e, detalleprematricula dp, prematricula p
    where e.codigoestudiante = p.codigoestudiante
    and dp.idprematricula = p.idprematricula
    and dp.codigoestadodetalleprematricula like '3%'
    and dp.idgrupo = '$idgrupo'";
    $estudiantes = $db->Execute($query_estudiantes);
    $totalRows_estudiantes = $estudiantes->RecordCount();

    $row_totales['Estudiantes_Matriculados'] = $totalRows_estudiantes;
    $row_totales['Riesgo_Alto'] = 0;
    $row_totales['Riesgo_Medio'] = 0;
    $row_totales['Riesgo_Bajo'] = 0;
    $row_totales['Sin_Riesgo'] = 0;
    while($row_estudiantes = $estudiantes->FetchRow())
    {
        unset($detallenota);
        $detallenota = new detallenota($row_estudiantes['codigoestudiante'], $row_estudiantes['codigoperiodo']);
        $detallenota->setAcumuladoCertificado("1");
        //echo "<br>".$row_estudiantes['codigoestudiante'];
        /*if(22545 == $row_estudiantes['codigoestudiante'])
        	echo "<pre>"; print_r($detallenota); echo "</pre>";*/
        //if ($detallenota->tieneNotasXMateria($codigomateria))
        {
        	if($detallenota->esAltoRiesgoXMateria($codigomateria, $idgrupo))
	        {
	            $row_totales['Riesgo_Alto']++;
	            /*if(22545 == $row_estudiantes['codigoestudiante'])
					echo "<br>ACA 2 ".$riesgo;*/

	        }
	        elseif($detallenota->esMedianoRiesgoXMateria($codigomateria))
	        {
	        	/*if(22545 == $row_estudiantes['codigoestudiante'])
					echo "<br>ACA 3 ".$riesgo;*/

	            $row_totales['Riesgo_Medio']++;
	        }
	        elseif($detallenota->esBajoRiesgoXMateria($codigomateria))
	        {
	        	/*if(22545 == $row_estudiantes['codigoestudiante'])
					echo "ACA 4".$riesgo;*/

	            $row_totales['Riesgo_Bajo']++;
	        }
	        else
	        {
	        	/*if(22545 == $row_estudiantes['codigoestudiante'])
					echo "ACA 5 ".$riesgo;*/

	            $row_totales['Sin_Riesgo']++;
	        }
        }
        /*else
    	{
    		/*if(22545 == $row_estudiantes['codigoestudiante'])
				echo "ACA 6".$riesgo;*/

	    	/*$row_totales['Sin_Riesgo']++;
	    }*/
    }
    return $row_totales;
}
?>