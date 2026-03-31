<?php

/**
*Redondeo seguridad social a mil
*/
function roundmilss($variable) {
    $resultado = ($variable + 499) / 1000;
    $resultado = (int) $resultado;
    $resultado = $resultado * 1000;
    return $resultado;
}

function roundmilss2($variable) {
    $variable = round($variable);
    $entero = (int) ($variable / 1000);
    $residuo = ($variable / 1000) - $entero;
    if ($residuo * 1000 > 500) {
        $resultado = round($variable, -3);
    } else {
        $resultado = $variable;
    }
    return $resultado;
}

/**
 * Redondeo seguridad social a cien
 */
function roundcienss($variable) {
    $variable = round($variable);
    $entero = (int) ($variable / 100);
    $residuo = ($variable / 100) - $entero;
    if ($residuo * 100 > 50) {
        $resultado = round($variable, -2);
    } else {
        $resultado = $variable;
    }
    return $resultado;
}

/**
 * Recupera empresa de salud sin importar si hay un TAE vigente
 */
function recuperar_empresasalud($objetobase, $idestudiantegeneral, $mesdecierre) {
    $fechainicialmes = formato_fecha_mysql("01/" . $mesdecierre);
    $fechafinalmes = formato_fecha_mysql(final_mes_fecha("01/$mesdecierre"));
//echo "<br>01/$mesdecierre <---> ".final_mes_fecha("01/$mesdecierre")."<br>";
    $condicion = "and es.idestudiantegeneral=en.idestudiantegeneral and
					en.idnovedadarp=no.idnovedadarp and
					en.codigoestado like '1%' and
					no.codigoestado like '1%' and
					no.codigotiponovedadarp like '1%' and
					em.idempresasalud=en.idempresasalud and
					no.codigotipoaplicacionnovedadarp like '1%' and
					('$fechainicialmes' between no.fechainicionovedadarp and no.fechafinalnovedadarp) and
					(('$fechainicialmes' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp) or
					('$fechafinalmes' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp) or
					(en.fechainicioestudiantenovedadarp between '$fechainicialmes' and '$fechafinalmes') or
					(en.fechafinalestudiantenovedadarp between '$fechainicialmes' and '$fechafinalmes') )";
    $datosnovedad = $objetobase->recuperar_datos_tabla("estudiantegeneral es, estudiantenovedadarp en, novedadarp no, empresasalud em", "es.idestudiantegeneral", $idestudiantegeneral, $condicion, '', 0);
    return $datosnovedad;
}
/**
 * Funcion para consultar empresa ARP
 */
function recuperar_empresaarp($objetobase, $idestudiantegeneral, $mesdecierre, $imprimir=0) {
    $fechainicialmes = formato_fecha_mysql("01/" . $mesdecierre);
    $fechafinalmes = formato_fecha_mysql(final_mes_fecha("01/$mesdecierre"));
//echo "<br>01/$mesdecierre <---> ".final_mes_fecha("01/$mesdecierre")."<br>";
    $condicion = "and es.idestudiantegeneral=en.idestudiantegeneral and
					en.idnovedadarp=no.idnovedadarp and
					en.codigoestado like '1%' and
					no.codigoestado like '1%' and
					no.codigotiponovedadarp like '1%' and
					em.idempresasalud=en.idempresasalud and
					no.codigotipoaplicacionnovedadarp like '2%' and
					('$fechainicialmes' between no.fechainicionovedadarp and no.fechafinalnovedadarp) and
					(('$fechainicialmes' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp) or
					('$fechafinalmes' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp) or
					(en.fechainicioestudiantenovedadarp between '$fechainicialmes' and '$fechafinalmes') or
					(en.fechafinalestudiantenovedadarp between '$fechainicialmes' and '$fechafinalmes') )";
    $datosnovedad = $objetobase->recuperar_datos_tabla("estudiantegeneral es, estudiantenovedadarp en, novedadarp no, empresasalud em", "es.idestudiantegeneral", $idestudiantegeneral, $condicion, '', $imprimir);
    return $datosnovedad;
}

/**
 * Valida si hay un TAE,TDE vigente desde el inicio ahasta el final del mes siguiente al inicial
 */
function validar_novedad_tae($objetobase, $clave, $fechahoy, $idestudiantegeneral, $mensaje=0) {
//El intervalo en el que no debe aparecer esta novedad es dentro  de los dos meses a partir de la
//fecha de inicio de la novedad
    //Encuentra una fecha de inicio si hay una TAE vigente
    $condicion = " and idestudiantegeneral=" . $idestudiantegeneral .
            " and ('$fechahoy' between es.fechainicioestudiantenovedadarp and es.fechafinalestudiantenovedadarp)";
    $datosnovedad = $objetobase->recuperar_datos_tabla("estudiantenovedadarp es", "es.idestudiantenovedadarp", $clave, $condicion, '', $mensaje);
    $fechainicionovedad = $datosnovedad['fechainicioestudiantenovedadarp'];
    //$fechainicionovedad="2006-12-27";
    //alerta_javascript($fechainicionovedad);
    $fechanovedad = vector_fecha(formato_fecha_defecto($fechainicionovedad));
    $fechasiguiente = mes_siguiente($fechanovedad['mes'], $fechanovedad['anio']);
    //alerta_javascript($fechasiguiente["anio"]."<---->".$fechasiguiente["mes"]);
    $no_dias = final_mes(agregarceros($fechasiguiente["mes"], 2), $fechasiguiente["anio"]);
    $fechafinal = $no_dias . "/" . agregarceros($fechasiguiente["mes"], 2) . "/" . $fechasiguiente["anio"];
    $fechaactual = formato_fecha_defecto($fechahoy);
    //$fechaactual="01/03/2007";
    //if($mensaje)
    //alerta_javascript($fechaactual."<-->".$fechafinal);
    $diferencia = diferencia_fechas($fechaactual, $fechafinal, "dias");
    //alerta_javascript($diferencia);
    if ($diferencia >= 1)
        $siga = 1;
    else
        $siga=0;
    return $siga;
}

/**
 * hace un listado de meses con sus respectivos años tomando de base
 * un mes inicial y un mes final
 */

function meses_anios($mesinicial, $mesfinal) {

    $siga = 1;
    $mm_fin = $mesfinal["mes"];
    $yyyy_fin = $mesfinal["anio"];
    $mes = $mesinicial["mes"];
    $anio = $mesinicial["anio"];
    $cadenames = agregarceros($mes, 2) . "/" . $anio;
    $fila[$cadenames] = $cadenames;
    while ($siga) {
        if (($mes == ($mm_fin + 0)) && ($anio == ($yyyy_fin + 0))) {
            $siga = 0;
        }

        $fechasiguiente = mes_siguiente($mes, $anio);
        $mes = $fechasiguiente["mes"];
        $anio = $fechasiguiente["anio"];
        $cadenames = agregarceros($mes, 2) . "/" . $anio;
        $fila[$cadenames] = $cadenames;

        $diferencia++;
    }

    return $fila;
}

/**
 * Verifica si envia un una novedad TAE vigente desde la fecha  de inicio
 * hasta el final del mismo mes
 */

function existe_tae_vigente($mes, $idestudiantegeneral, $objetobase) {

    $fechainiciomes = formato_fecha_mysql("01/" . $mes);
    $fechafinalmes = formato_fecha_mysql(final_mes_fecha("01/" . $mes));

    $condicion = "no.nombrecortonovedadarp='TAE' and
					es.idestudiantegeneral=en.idestudiantegeneral and
					en.idnovedadarp=no.idnovedadarp and
					en.codigoestado like '1%' and
					no.codigoestado like '1%' and
				    ('$fechainiciomes' between no.fechainicionovedadarp and no.fechafinalnovedadarp) and
					(en.fechainicioestudiantenovedadarp between '$fechainiciomes' and '$fechafinalmes')
					and es.idestudiantegeneral=" . $idestudiantegeneral;
    $datosvalidarnovedad = $objetobase->recuperar_datos_tabla_fila("estudiantegeneral es, estudiantenovedadarp en, novedadarp no", "no.idnovedadarp", "no.nombrecortonovedadarp", $condicion, '', 0);

    if ((isset($datosvalidarnovedad)) && ($datosvalidarnovedad != ""))
        return 1;
    else
        return 0;
}

/**
 * Encuentra la EPS anterior a la que fue asignado el cotizante teniendo
 * por sentado que existe una novedad TAE vigente
 */

function eps_anterior_tae($mes, $idestudiantegeneral, $objetobase) {

    $fechainiciomes = formato_fecha_mysql("01/" . $mes);
    $fechafinalmes = formato_fecha_mysql(final_mes_fecha("01/" . $mes));

    $condicion = "and no.nombrecortonovedadarp='TAE' and
					es.idestudiantegeneral=en.idestudiantegeneral and
					en.idnovedadarp=no.idnovedadarp and
					en.codigoestado like '1%' and
					(en.fechainicioestudiantenovedadarp between '$fechainiciomes' and '$fechafinalmes')";
    $datosvalidarnovedad = $objetobase->recuperar_datos_tabla("estudiantegeneral es, estudiantenovedadarp en, novedadarp no", "es.idestudiantegeneral", $idestudiantegeneral, $condicion, '', 0);
    $condicion = "and en.idempresasalud=em.idempresasalud";
    $datosnovedadanterior = $objetobase->recuperar_datos_tabla("estudiantenovedadarp en, empresasalud em", "en.idestudiantenovedadarp", $datosvalidarnovedad['idestudiantenovedadarporigen'], $condicion);
    //$datosempresasaludanterior=$objetobase->recuperar_datos_tabla("empresasalud em","em.idempresasalud",$datosnovedadanterior['idempresasalud']);
    return $datosnovedadanterior;
}

/**
 * Encuentra la EPS de la novedad TAE vigente
 */
function eps_tae($mes, $idestudiantegeneral, $objetobase) {

    $fechainiciomes = formato_fecha_mysql("01/" . $mes);
    $fechafinalmes = formato_fecha_mysql(final_mes_fecha("01/" . $mes));

    $condicion = "and no.nombrecortonovedadarp='TAE' and
					es.idestudiantegeneral=en.idestudiantegeneral and
					en.idnovedadarp=no.idnovedadarp and
					en.codigoestado like '1%' and
					(en.fechainicioestudiantenovedadarp between '$fechainiciomes' and '$fechafinalmes')";
    $datosvalidarnovedad = $objetobase->recuperar_datos_tabla("estudiantegeneral es, estudiantenovedadarp en, novedadarp no", "es.idestudiantegeneral", $idestudiantegeneral, $condicion, '', 0);
    $condicion = "and en.idempresasalud=em.idempresasalud";
    $datosnovedadanterior = $objetobase->recuperar_datos_tabla("estudiantenovedadarp en, empresasalud em", "en.idestudiantenovedadarp", $datosvalidarnovedad['idestudiantenovedadarp'], $condicion);
    //$datosempresasaludanterior=$objetobase->recuperar_datos_tabla("empresasalud em","em.idempresasalud",$datosnovedadanterior['idempresasalud']);
    return $datosnovedadanterior;
}

/**
 * Encuentra y retorna si una novedad esta vigente
 */
function existe_novedad_vigente_eps($mes, $idestudiantegeneral, $objetobase, $nombrecorto) {

    $fechainiciomes = formato_fecha_mysql("01/" . $mes);
    $fechafinalmes = formato_fecha_mysql(final_mes_fecha("01/" . $mes));

    $condicion = "no.nombrecortonovedadarp='$nombrecorto' and
					es.idestudiantegeneral=en.idestudiantegeneral and
					en.idnovedadarp=no.idnovedadarp and
					en.codigoestado like '1%' and
					no.codigoestado like '1%' and
					('$fechainiciomes' between no.fechainicionovedadarp and no.fechafinalnovedadarp) and
					(en.fechainicioestudiantenovedadarp between '$fechainiciomes' and '$fechafinalmes')
					and es.idestudiantegeneral=" . $idestudiantegeneral;
    $datosvalidarnovedad = $objetobase->recuperar_datos_tabla_fila("estudiantegeneral es, estudiantenovedadarp en, novedadarp no", "no.idnovedadarp", "no.nombrecortonovedadarp", $condicion, '', 0);

    if ((isset($datosvalidarnovedad)) && ($datosvalidarnovedad != ""))
        return 1;
    else
        return 0;
}

/**
 * Encuentra y retorna los datos de una novedad vigente que sea tipo eps
 */
function eps_novedad($mes, $idestudiantegeneral, $objetobase, $nombrecorto) {

    $fechainiciomes = formato_fecha_mysql("01/" . $mes);
    $fechafinalmes = formato_fecha_mysql(final_mes_fecha("01/" . $mes));

    $condicion = "and no.nombrecortonovedadarp='$nombrecorto' and
					es.idestudiantegeneral=en.idestudiantegeneral and
					en.idnovedadarp=no.idnovedadarp and
					en.codigoestado like '1%' and
					no.codigoestado like '1%' and
					('$fechainiciomes' between no.fechainicionovedadarp and no.fechafinalnovedadarp) and
					(en.fechainicioestudiantenovedadarp between '$fechainiciomes' and '$fechafinalmes')";
    $datosvalidarnovedad = $objetobase->recuperar_datos_tabla("estudiantegeneral es, estudiantenovedadarp en, novedadarp no", "es.idestudiantegeneral", $idestudiantegeneral, $condicion, '', 0);
    $condicion = "and en.idempresasalud=em.idempresasalud";
    $datosnovedadanterior = $objetobase->recuperar_datos_tabla("estudiantenovedadarp en, empresasalud em", "en.idestudiantenovedadarp", $datosvalidarnovedad['idestudiantenovedadarp'], $condicion);
    //$datosempresasaludanterior=$objetobase->recuperar_datos_tabla("empresasalud em","em.idempresasalud",$datosnovedadanterior['idempresasalud']);
    return $datosnovedadanterior;
}

/**
 * Calcula el numero de dias cotizados para EPS
 */
function dias_eps($mes, $idestudiantegeneral, $objetobase) {
    $fechainiciomes = "01/" . $mes;
    $fechafinalmes = final_mes_fecha("01/" . $mes);
    $dias_eps = 30;

    for ($i = 1; $i <= 30; $i++)
        $vector_mes_resta[$i] = 1;

    for ($i = 1; $i <= 30; $i++)
        $vector_mes_suma[$i] = 0;

    $novedades = novedades_vigentes_mes($mes, $idestudiantegeneral, $objetobase);
    $novedadesrevisar = array("RET");
    for ($i = 0; $i < count($novedades["nombrecorto"]); $i++)
        if (encontro_novedad($novedadesrevisar, $novedades["nombrecorto"][$i])) {
            $lapso = lapso_mes_novedad($mes, $idestudiantegeneral, $objetobase, $novedades["nombrecorto"][$i], $novedades['fechainicio'][$i], $novedades['fechafinal'][$i]);
            //echo $novedades["nombrecorto"][$i]."-".$lapso['inicio']."-".$lapso['final']."<br>";
            $vector_mes_resta = quitar_lapso($vector_mes_resta, $lapso);
        }

    $novedadesrevisar = array("ING", "TAE", "INX");
    for ($i = 0; $i < count($novedades["nombrecorto"]); $i++)
        if (encontro_novedad($novedadesrevisar, $novedades["nombrecorto"][$i])) {
            $lapso = lapso_mes_novedad($mes, $idestudiantegeneral, $objetobase, $novedades["nombrecorto"][$i], $novedades['fechainicio'][$i], $novedades['fechafinal'][$i]);
            //echo $novedades["nombrecorto"][$i]."-".$lapso['inicio']."-".$lapso['final']."<br>";
            $vector_mes_suma = sumar_lapso($vector_mes_suma, $lapso);
        }
    for ($i = 1; $i <= 30; $i++)
        if ($vector_mes_suma[$i] && $vector_mes_resta[$i])
            $vector_mes[$i] = 1;
        else
            $vector_mes[$i] = 0;

    $con_dias = 0;
    for ($i = 1; $i <= 30; $i++)
        if (!$vector_mes[$i])
            $con_dias++;
    if ($con_dias > 30) {
        $con_dias = 30;
    }
    $dias_eps = 30 - $con_dias;

    return $dias_eps;
}

/**
 * Encuentra los datos de novedad y EPS de acuerdo a un mes
 */
function eps_mes($mes, $idestudiantegeneral, $objetobase) {
    if (existe_tae_vigente($mes, $idestudiantegeneral, $objetobase)) {
        //alerta_javascript("Existe tae");
        $eps_mes = eps_anterior_tae($mes, $idestudiantegeneral, $objetobase);
    } else {
        $eps_mes = recuperar_empresasalud($objetobase, $idestudiantegeneral, $mes);
        //$eps_mes=$datos_empresa_salud['nombreempresasalud'];
    }
    return $eps_mes;
}

/**
 * Encuentra todos los datos y total relativo a la IBC de los aportes EPS
 */
function ibc_eps($mes, $codigoestudiante, $objetobase) {


    $datos_estudiante = $objetobase->recuperar_datos_tabla("estudiante", "codigoestudiante", $codigoestudiante, '');
    $dias_eps = dias_eps($mes, $datos_estudiante['idestudiantegeneral'], $objetobase);

//print_r($datos_estudiante);
    $datoscentrotrabajo = centrotrabajo($mes, $codigoestudiante, $objetobase);
    if ($datos_novedad_ige = datos_novedad_vigente($mes, $datos_estudiante['idestudiantegeneral'], $objetobase, 'IGE')) {
        for ($i = 1; $i <= 30; $i++)
            $vector_mes[$i] = 1;
        $lapso_sln = lapso_resultado_novedad($mes, $datos_estudiante['idestudiantegeneral'], $objetobase, 'IGE');
        $vector_mes = quitar_lapso($vector_mes, $lapso_sln);
        for ($i = 1; $i < count($vector_mes); $i++)
            if (!$vector_mes[$i])
                $dias_ige++;
        if ($dias_ige > 30) {
            $dias_ige = 30;
        }
        //echo "entro pero no sale el IGE con los dias=".$dias_ige."<br>";
        //echo "((2*".$datoscentrotrabajo['salariobasecotizacioncentrotrabajoarp']."/30)*($dias_ige))*".$datos_novedad_ige['porcentajebaseapliacionnovedadarp']."<br>";
    }
    $dias_eps_no_ige = $dias_eps - $dias_ige;

    $ibc_eps = (2 * $datoscentrotrabajo['salariobasecotizacioncentrotrabajoarp'] / 30) * ($dias_eps_no_ige);
    $ibc_eps_ige = ((2 * $datoscentrotrabajo['salariobasecotizacioncentrotrabajoarp'] / 30) * ($dias_ige)) * $datos_novedad_ige['porcentajebaseapliacionnovedadarp'];
//$ibc_1=($ibc_eps+$ibc_eps_ige);
//round()*1000;
//$datos_ibc['ibc_eps']=round(($ibc_eps+$ibc_eps_ige),-3);
//$datos_ibc['ibc_eps']=round($ibc_eps,-3);
    $datos_ibc['ibc_eps'] = roundmilss2($ibc_eps);
    $datos_ibc['dias_eps'] = $dias_eps;
    $datos_ibc['datoscentrotrabajo'] = $datoscentrotrabajo;
    return $datos_ibc;
}

/**
 * Retorna tarifa de aportes de acuerdo a la novedad que la afecta
 */
function tarifa_aportes_eps($mes, $idestudiantegeneral, $objetobase) {
    $tarifa_eps = 0.125;
    $tarifa_eps_sln = 0.085;
    if ($datos_novedad1 = datos_novedad_vigente($mes, $idestudiantegeneral, $objetobase, 'ING', 0))
        $tarifa = $datos_novedad1["porcentajebaseapliacionnovedadarp"];
//echo "<br>$tarifa<br>";

    if ($datos_novedad2 = datos_novedad_vigente($mes, $idestudiantegeneral, $objetobase, 'TAE', 0))
        $tarifa = $datos_novedad2["porcentajebaseapliacionnovedadarp"];
//echo "<br>$tarifa<br>";
    if ($datos_novedad3 = datos_novedad_vigente($mes, $idestudiantegeneral, $objetobase, 'INX', 0))
        $tarifa = $datos_novedad3["porcentajebaseapliacionnovedadarp"];

//$tarifa=$tarifa_eps;
    if ($datos_novedad_sln = datos_novedad_vigente($mes, $idestudiantegeneral, $objetobase, 'SLN'))
        $tarifa = $datos_novedad_sln["porcentajebaseapliacionnovedadarp"];

    return $tarifa;
}

/**
 *Funciones para calculo AR
 * Devuelve los datos de una novedad vigente con respecto al nombre corto
*/
function datos_novedad_vigente($mes, $idestudiantegeneral, $objetobase, $nombrecorto, $imprimir=0) {

    $fechainicialmes = formato_fecha_mysql("01/" . $mes);
    $fechafinalmes = formato_fecha_mysql(final_mes_fecha("01/" . $mes));

    $condicion = "and no.nombrecortonovedadarp='$nombrecorto' and
					es.idestudiantegeneral=en.idestudiantegeneral and
					en.idnovedadarp=no.idnovedadarp and
					no.codigoestado like '1%' and
					('$fechainicialmes' between no.fechainicionovedadarp and no.fechafinalnovedadarp) and
					en.codigoestado like '1%' and (
					('$fechainicialmes' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp) or
					('$fechafinalmes' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp) or
					(en.fechainicioestudiantenovedadarp between '$fechainicialmes' and '$fechafinalmes') or
					(en.fechafinalestudiantenovedadarp between '$fechainicialmes' and '$fechafinalmes') )
					";
    $datosvalidarnovedad = $objetobase->recuperar_datos_tabla("estudiantegeneral es, estudiantenovedadarp en, novedadarp no", "es.idestudiantegeneral", $idestudiantegeneral, $condicion, ',en.fechainicioestudiantenovedadarp fechainicio,en.fechafinalestudiantenovedadarp fechafinal', $imprimir);

    return $datosvalidarnovedad;
}

/**
 * Devuelve el lapso de tiempo en un mes de una novedad una fecha inicial y una fecha final
 */
function lapso_resultado_novedad($mes, $idestudiantegeneral, $objetobase, $nombrecorto) {
    $fechainiciomes = "01/" . $mes;
    $fechafinalmes = final_mes_fecha("01/" . $mes);
    if ($datos_novedad = datos_novedad_vigente($mes, $idestudiantegeneral, $objetobase, $nombrecorto)) {
        $fechainicionovedad = formato_fecha_defecto($datos_novedad['fechainicio']);
        $fechafinalnovedad = formato_fecha_defecto($datos_novedad['fechafinal']);
        $dias_diferencia_inicio = diferencia_fechas($fechainiciomes, $fechainicionovedad, "dias", 0);
        if ($dias_diferencia_inicio <= 0) {
            $lapso['inicio'] = $fechainiciomes;
        } else {
            $lapso['inicio'] = $fechainicionovedad;
        }

        $dias_diferencia_final = diferencia_fechas($fechafinalnovedad, $fechafinalmes, "dias", 0);
        if ($dias_diferencia_final <= 0) {
            $lapso['final'] = $fechafinalmes;
        } else {
            $lapso['final'] = $fechafinalnovedad;
        }
        //echo $nombrecorto."--";
    }
    return $lapso;
}

/**
 * Devuelve el lapso de tiempo en un mes de una novedad una fecha inicial y una fecha final
 */
function lapso_mes_novedad($mes, $idestudiantegeneral, $objetobase, $nombrecorto, $fechainicio, $fechafinal) {
    $fechainiciomes = "01/" . $mes;
    $fechafinalmes = final_mes_fecha("01/" . $mes);
    //if($datos_novedad=datos_novedad_vigente($mes,$idestudiantegeneral,$objetobase,$nombrecorto)){
    $fechainicionovedad = formato_fecha_defecto($fechainicio);
    $fechafinalnovedad = formato_fecha_defecto($fechafinal);

    if ($nombrecorto == 'REA' || $nombrecorto == 'RET')
        if ($fechainicionovedad == $fechafinalmes) {
            $diafinal = (($fechainicionovedad[0] . $fechainicionovedad[1]) + 1);
            $vectorfechafinal = vector_fecha($fechainicionovedad);
            //echo "ENTRO PAPA:";
            $fechainicionovedad = $diafinal . "/" . $vectorfechafinal["mes"] . "/" . $vectorfechafinal["anio"];
            //echo "<br>";
        }
//echo "diferencia_fechas($fechainiciomes, $fechainicionovedad, 'dias', 0);<br>";
    $dias_diferencia_inicio = diferencia_fechas($fechainiciomes, $fechainicionovedad, "dias", 0);
    if ($dias_diferencia_inicio <= 0) {
        $lapso['inicio'] = $fechainiciomes;
    } else {
        $lapso['inicio'] = $fechainicionovedad;
    }

    $aniofinalnovedad=$fechafinalnovedad[6].$fechafinalnovedad[7].$fechafinalnovedad[8].$fechafinalnovedad[9];
  //  echo "diferencia_fechas($fechafinalnovedad, $fechafinalmes, 'dias', 0); $aniofinalnovedad<br>";
    
    $dias_diferencia_final = diferencia_fechas($fechafinalnovedad, $fechafinalmes, "dias", 0);
    //echo "---".$dias_diferencia_final."----";
    
    if (($dias_diferencia_final <= 0) || ($aniofinalnovedad == '2099')) {
        $lapso['final'] = $fechafinalmes;
    } else {
        $lapso['final'] = $fechafinalnovedad;
    }
    //echo $nombrecorto."--";
    //}
    return $lapso;
}

/**
 * marca como cero en un vector de iteracion de un mes para casillas
 */
function quitar_lapso($vector_mes, $lapso) {
    $lapso_inicio_vector = vector_fecha($lapso['inicio']);
    $lapso_final_vector = vector_fecha($lapso['final']);

    if ($lapso['final'] == final_mes_fecha($lapso['final']))
        $lapso_final_vector["dia"] = 30;
    //echo "--for(i=".($lapso_inicio_vector["dia"]-0).".;i<=".($lapso_final_vector["dia"]-0).";i++){--";
    for ($i = ($lapso_inicio_vector["dia"] - 0); $i <= ($lapso_final_vector["dia"] - 0); $i++) {
        $vector_mes[($i - 0)] = 0;
    }
    return $vector_mes;
}

/**
 * marca como cero en un vector de iteracion de un mes para casillas
 */
function sumar_lapso($vector_mes, $lapso) {
    $lapso_inicio_vector = vector_fecha($lapso['inicio']);
    $lapso_final_vector = vector_fecha($lapso['final']);

    if ($lapso['final'] == final_mes_fecha($lapso['final']))
        $lapso_final_vector["dia"] = 30;
    //echo "--for(i=".($lapso_inicio_vector["dia"]-0).".;i<=".($lapso_final_vector["dia"]-0).";i++){--";
    for ($i = ($lapso_inicio_vector["dia"] - 0); $i <= ($lapso_final_vector["dia"] - 0); $i++) {
        $vector_mes[($i - 0)] = 1;
    }

    return $vector_mes;
}

/**
 * Encuentra un listado de novedades vigentes en el mes
 */
function novedades_vigentes_mes($mes, $idestudiantegeneral, $objetobase) {
    $fechainicialmes = formato_fecha_mysql("01/" . $mes);
    $fechafinalmes = formato_fecha_mysql(final_mes_fecha("01/" . $mes));

    $condicion = "and es.idestudiantegeneral=en.idestudiantegeneral and
					en.idnovedadarp=no.idnovedadarp and
					no.codigoestado like '1%' and
					('$fechainicialmes' between no.fechainicionovedadarp and no.fechafinalnovedadarp) and
					en.codigoestado like '1%' and (
					('$fechainicialmes' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp) or
					('$fechafinalmes' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp) or
					(en.fechainicioestudiantenovedadarp between '$fechainicialmes' and '$fechafinalmes') or
					(en.fechafinalestudiantenovedadarp between '$fechainicialmes' and '$fechafinalmes') )
					";
    $operacionvalidarnovedad = $objetobase->recuperar_resultado_tabla("estudiantegeneral es, estudiantenovedadarp en, novedadarp no", "es.idestudiantegeneral", $idestudiantegeneral, $condicion, ',en.fechainicioestudiantenovedadarp fechainicio,en.fechafinalestudiantenovedadarp fechafinal', 0);
    while ($row_operacion = $operacionvalidarnovedad->fetchRow()) {
        $novedades['nombrecorto'][] = $row_operacion['nombrecortonovedadarp'];
        $novedades['fechainicio'][] = $row_operacion['fechainicio'];
        $novedades['fechafinal'][] = $row_operacion['fechafinal'];
    }
    return $novedades;
}

/**
 * Se encuentra novedad dentro el listado
 */
function encontro_novedad($vector, $novedad) {
    $siga = 0;
    for ($i = 0; $i < count($vector); $i++)
        if ($vector[$i] == $novedad)
            $siga = 1;
    return $siga;
}

/**
 * Devuelve el numero de dias ARP cotizados
 */
function dias_arp($mes, $idestudiantegeneral, $objetobase) {

    $fechainiciomes = "01/" . $mes;
    $fechafinalmes = final_mes_fecha("01/" . $mes);
    $fechainiciovector = vector_fecha($fechainiciomes);
    $dias_mes = final_mes($fechainiciovector["mes"]);

    $vector = 0;
    for ($i = 1; $i <= 30; $i++)
        $vector_mes_resta[$i] = 1;

    for ($i = 1; $i <= 30; $i++)
        $vector_mes_suma[$i] = 0;
//echo "<br>";


    $novedades = novedades_vigentes_mes($mes, $idestudiantegeneral, $objetobase);
    $novedadesrevisar = array("SLN", "IGE", "LMA", "IRP", "VAC", "REA");
    for ($i = 0; $i < count($novedades["nombrecorto"]); $i++)
        if (encontro_novedad($novedadesrevisar, $novedades["nombrecorto"][$i])) {
            $lapso = lapso_mes_novedad($mes, $idestudiantegeneral, $objetobase, $novedades["nombrecorto"][$i], $novedades['fechainicio'][$i], $novedades['fechafinal'][$i]);
            echo $novedades["nombrecorto"][$i]."-".$lapso['inicio']."-".$lapso['final']."<br>";
            $vector_mes_resta = quitar_lapso($vector_mes_resta, $lapso);
        }
    /** $lapso_sln=lapso_resultado_novedad($mes,$idestudiantegeneral,$objetobase,'SLN');
      $vector_mes=quitar_lapso($vector_mes,$lapso_sln);

      $lapso_ige=lapso_resultado_novedad($mes,$idestudiantegeneral,$objetobase,'IGE');
      $vector_mes=quitar_lapso($vector_mes,$lapso_ige);

      $lapso_lma=lapso_resultado_novedad($mes,$idestudiantegeneral,$objetobase,'LMA');
      $vector_mes=quitar_lapso($vector_mes,$lapso_lma);

      $lapso_irp=lapso_resultado_novedad($mes,$idestudiantegeneral,$objetobase,'IRP');
      $vector_mes=quitar_lapso($vector_mes,$lapso_irp);

      $lapso_irp=lapso_resultado_novedad($mes,$idestudiantegeneral,$objetobase,'VAC');
      $vector_mes=quitar_lapso($vector_mes,$lapso_irp); */
//echo "<br>";
//$novedadesrevisar=array("ING","TAE","INX");
    $novedadesrevisar = array("INA", "TAE", "IXA");
    for ($i = 0; $i < count($novedades["nombrecorto"]); $i++)
        if (encontro_novedad($novedadesrevisar, $novedades["nombrecorto"][$i])) {
            $lapso = lapso_mes_novedad($mes, $idestudiantegeneral, $objetobase, $novedades["nombrecorto"][$i], $novedades['fechainicio'][$i], $novedades['fechafinal'][$i]);
         // echo $novedades["nombrecorto"][$i]."-".$lapso['inicio']."-".$lapso['final']."<br>";
            $vector_mes_suma = sumar_lapso($vector_mes_suma, $lapso);
        }


    /** if(existe_novedad_vigente_eps($mes,$idestudiantegeneral,$objetobase,'ING')){
      $datosnovedading=eps_novedad($mes,$idestudiantegeneral,$objetobase,'ING');
      $fechainicioing=formato_fecha_defecto($datosnovedading['fechainicioestudiantenovedadarp']);
      $lapso_ing['inicio']=$fechainiciomes;
      $fechavectorinicioing=vector_fecha($fechainicioing);
      $lapso_ing['final']=($fechavectorinicioing["dia"]-1)."/".$fechavectorinicioing["mes"]."/".$fechavectorinicioing["anio"];
      $vector_mes=quitar_lapso($vector_mes,$lapso_ing);
      }
     */
//echo "<br>";
    /**
      echo "<br>vector_mes_suma ";
      for($i=1;$i<count($vector_mes_suma);$i++)
      echo $vector_mes_suma[$i]." ";
      echo "<br>vector_mes_resta ";
      for($i=1;$i<=count($vector_mes_resta);$i++)
      echo $vector_mes_resta[$i]." ";
     */
    for ($i = 1; $i <= 30; $i++)
        if ($vector_mes_suma[$i] && $vector_mes_resta[$i])
            $vector_mes[$i] = 1;
        else
            $vector_mes[$i] = 0;

   /*  echo "<br>vector_mes ";
      for($i=1;$i<=30;$i++)
      echo $vector_mes[$i]." <BR>"; */
      /*  echo "<pre>";
        print_r($vector_mes);
echo "</pre>";
        echo "<pre>";
        print_r($vector_mes_suma);
echo "</pre>";
        echo "<pre>";
        print_r($vector_mes_resta);
echo "</pre>";*/
    $con_dias = 0;

    for ($i = 1; $i <= 30; $i++)
        if (!$vector_mes[$i])
            $con_dias++;
    if ($con_dias > 30) {
        $con_dias = 30;
    }

    //echo "<H1>CONDIAS=".$con_dias."</H1>";
    $dias_totales = 30 - $con_dias;


    return $dias_totales;
}

/**
 * Encuentra los datos del centrotrabajo segun el mes y el id del estudiante
 */
function centrotrabajo($mes, $codigoestudiante, $objetobase) {

    $fechainiciomes = formato_fecha_mysql("01/" . $mes);
    $condicion = "and cc.idcentrotrabajoarp=ct.idcentrotrabajoarp
				and cc.codigocarrera=e.codigocarrera
				and ct.codigoestado like '1%'
				and ('$fechainiciomes' between ct.fechainiciocentrotrabajoarp and ct.fechafinalcentrotrabajoarp)";
    $datoscentrotrabajo = $objetobase->recuperar_datos_tabla("carreracentrotrabajoarp cc, centrotrabajoarp ct, estudiante e", "e.codigoestudiante", $codigoestudiante, $condicion, '', 0);
    //echo "<br>";
    return $datoscentrotrabajo;
}
//Consulta de una tabla de cotizacion de los 30 dias dependiendo del periodo de sesion , dias y tipo cotizacion (EPS,ARP)
function tablaCotizacionValor($dias,$tipocotizacion,$objetobase){
    $condicion = " and codigotipocotizacionseguridadsocial='" . $tipocotizacion."'".
    " and diascotizacionseguridadsocial='".$dias."'";
    $datoscotizacion = $objetobase->recuperar_datos_tabla("cotizacionseguridadsocial", "codigoperiodo", $_SESSION['codigoperiodosesion'], $condicion,"",0);
    return  $datoscotizacion;
}
//Encuentra todos los datos y total relativo a la IBC de los aportes ARP
function ibc_arp($mes, $codigoestudiante, $objetobase, $idestudiantegeneral="") {

    $fechainiciomes = "01/" . $mes;
    $vector_fecha_mes = vector_fecha($fechainiciomes);
    if (isset($idestudiantegeneral) && $idestudiantegeneral != '') {
        $condicion = " and c.codigocarrera=e.codigocarrera
group by idestudiantegeneral";
        $datos_estudiante = $objetobase->recuperar_datos_tabla("estudiante e, carreracentrotrabajoarp c", "idestudiantegeneral", $idestudiantegeneral, $condicion, ', max(codigoestudiante) numeroestudiante');
        $codigoestudiante = $datos_estudiante['numeroestudiante'];
    }
    else
        $datos_estudiante=$objetobase->recuperar_datos_tabla("estudiante", "codigoestudiante", $codigoestudiante, '');


    $datoscentrotrabajo = centrotrabajo($mes, $codigoestudiante, $objetobase);
    $diasarp = dias_arp($mes, $datos_estudiante['idestudiantegeneral'], $objetobase);
    $ibc_arp = (2 * $datoscentrotrabajo['salariobasecotizacioncentrotrabajoarp'] / 30) * ($diasarp);
//$ibc_arp=round($ibc_arp,-3);
    $ibc_arp = roundmilss2($ibc_arp);
    $datos_ibc['ibc_arp'] = $ibc_arp;
    $datos_ibc['dias_arp'] = $diasarp;
    $datos_ibc['datoscentrotrabajo'] = $datoscentrotrabajo;

    $suma_ibc = 0;
    $dias_irp = 0;
    if ($datos_novedad = datos_novedad_vigente($mes, $datos_estudiante['idestudiantegeneral'], $objetobase, 'IRP')) {
        $lapso_irp = lapso_resultado_novedad($mes, $datos_estudiante['idestudiantegeneral'], $objetobase, 'IRP');

        for ($i = 1; $i <= 30; $i++)
            $vector_mes[$i] = 1;

        $vector_mes = quitar_lapso($vector_mes, $lapso_irp);

        for ($i = 1; $i <= 30; $i++)
            if (!$vector_mes[$i])
                $dias_irp++;

        $diferencia = 0;
        $conmesesanteriores = 0;
        $anio_siguiente = $vector_fecha_mes["anio"];
        $mes_siguiente = $vector_fecha_mes["mes"];
        while ($diferencia < 6) {
            $fechasiguiente = mes_anterior($mes_siguiente, $anio_siguiente);
            $mes_siguiente = agregarceros($fechasiguiente["mes"], 2);
            $mes_anio_siguiente = $mes_siguiente . "/" . $fechasiguiente["anio"];
            $datos = ibc_arp($mes_anio_siguiente, $codigoestudiante, $objetobase);
            //echo "mes_anterior($mes_siguiente,$anio_siguiente);-ibc_arp($mes_anio_siguiente,$codigoestudiante,$objetobase);<br>";
            $anio_siguiente = $fechasiguiente["anio"];
            if (isset($datos['ibc_arp']) && ($datos['ibc_arp'] != ''))
                $conmesesanteriores++;
            $suma_ibc+=$datos['ibc_arp'];
            $diferencia++;
        }

        //echo "round(($ibc_arp+((($suma_ibc/$conmesesanteriores)/30)*$dias_irp)),-3)<br>";
    }
    if ($suma_ibc == 0)
        $conmesesanteriores = 6;
//$datos_ibc['ibc_arp']=round(($ibc_arp+((($suma_ibc/$conmesesanteriores)/30)*$dias_irp)),-3);
    $datos_ibc['ibc_arp'] = roundmilss2(($ibc_arp + ((($suma_ibc / $conmesesanteriores) / 30) * $dias_irp)));

    $datos_ibc['dias_irp'] = $dias_irp;
//echo "$ibc_arp+((($suma_ibc/6)/30)*$dias_irp)<br>";
    return $datos_ibc;
}

/**
 * Valida si el estudiante tiene un centro de trabajo relacionado y si no se encuentra en estudiantearp
 */
function validar_estudiante_arp($mes, $codigoestudiante, $objetobase, $pagoeps=1, $pagoarp=1, $soloingresados=0) {
    if ($codigoestudiante == "32115") {
//echo "ENTRO ESTE MAN";
    }

    $fechainiciomes = formato_fecha_mysql("01/" . $mes);
    $datosestudiante = $objetobase->recuperar_datos_tabla("estudiante", "codigoestudiante", $codigoestudiante, '');
    $condicion = "and cc.idcentrotrabajoarp=ct.idcentrotrabajoarp
				and cc.codigocarrera=e.codigocarrera
				and cc.codigoestado like '1%'
				and ('$fechainiciomes' between ct.fechainiciocentrotrabajoarp and ct.fechafinalcentrotrabajoarp)";
    $datoscentrotrabajo = $objetobase->recuperar_datos_tabla("carreracentrotrabajoarp cc, centrotrabajoarp ct, estudiante e", "e.codigoestudiante", $codigoestudiante, $condicion, '', 0);
    $condicion = "and e.codigocarrera=c.codigocarrera";
    $datoscarreraestudiante = $objetobase->recuperar_datos_tabla("carrera c,estudiante e", "e.codigoestudiante", $codigoestudiante, $condicion, '', 0);

    //echo "<br>";
    $siga = 1;
    /** if($datoscentrotrabajo['nombrecentrotrabajoarp']==''){
      $siga=0;
      else{
      //if($codigoestudiante==32115)
      //echo $coni.")OTRO SIGA HABER ".$datoscarreraestudiante['nombrecarrera']." Case=".$soloingresados."<BR>";
      }
     */
    $condicion = " and ( NOW() between fechainicioestudiantearp and fechafinalestudiantearp)";

    $datosarp = $objetobase->recuperar_datos_tabla("estudiantearp e", "e.idestudiantegeneral", $datosestudiante['idestudiantegeneral'], $condicion);
    if (!($datosarp['idestudiantearp'] == ''))
        $siga = 0;

    /** if($pagoarp){
      $condicion="and o.codigoestadoordenpago like '4%'Devuelve los datos de una novedad vigente con respecto al nombre corto
      and o.numeroordenpago = do.numeroordenpago
      and do.codigoconcepto = '165'";
      $datospagosorden=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago do","o.codigoestudiante",$codigoestudiante,$condicion,'',0);
      if($datospagosorden['codigoconcepto']!='165')
      $siga=0;
      //echo "<br>";
      }
      if($pagoeps){
      $condicion="and o.codigoestadoordenpago like '4%'
      and o.numeroordenpago = do.numeroordenpago
      and do.codigoconcepto = 'C9056'";
      $datospagosorden=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago do","o.codigoestudiante",$codigoestudiante,$condicion,'',0);
      if($datospagosorden['codigoconcepto']!='C9056')
      $siga=0;

      } */
    $taevigente = 0;
    $ingvigente = 0;
    $ingextvigente = 0;
    $ingarpvigente = 0;
    $ingarpextvigente = 0;
    switch ($soloingresados) {
        case 1:
            if ($datosnovedad1 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "TAE", 0)) {
                $taevigente = 1;
                //echo "<br>TAE ".$datosestudiante['idestudiantegeneral'];
            }
            //echo "<br>";
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "ING", 0)) {
                $ingvigente = 1;
                //echo "<br>ING ".$datosestudiante['idestudiantegeneral'];
            }
            //echo "<br>";
            //echo "<br>ING ".$datosestudiante['idestudiantegeneral']."<BR>";

            if (!($taevigente || $ingvigente))
                $siga = 0;

            break;
        case 2:
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "INX")) {
                $ingextvigente = 1;
                //echo "<br>ING ".$datosestudiante['idestudiantegeneral'];
            }
            if (!($ingextvigente))
                $siga = 0;
            break;
        case 3:
            if ($datosnovedad1 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "TAE")) {
                $taevigente = 1;
                //echo "<br>TAE ".$datosestudiante['idestudiantegeneral'];
            }
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "ING")) {
                $ingvigente = 1;
                //echo "<br>ING ".$datosestudiante['idestudiantegeneral'];
            }
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "INX")) {
                $ingextvigente = 1;
                //echo "<br>ING ".$datosestudiante['idestudiantegeneral'];
            }
            if (!($taevigente || $ingvigente || $ingextvigente))
                $siga = 0;
            break;
        case 4:
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "ING")) {
                $ingvigente = 1;
                //echo "<br>ING ".$datosestudiante['idestudiantegeneral'];
            }
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "INX")) {
                $ingextvigente = 1;
                //echo "<br>ING ".$datosestudiante['idestudiantegeneral'];
            }
            if ($datosnovedad1 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "TAE")) {
                $taevigente = 1;
                //echo "<br>TAE ".$datosestudiante['idestudiantegeneral'];
            }

            if ($ingvigente || $ingextvigente || $taevigente)
                $siga = 0;
            break;
        case 5:
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "INA")) {
                $ingarpvigente = 1;
                //echo "<br>ING ".$datosestudiante['idestudiantegeneral'];
            }
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "IXA")) {
                $ingarpextvigente = 1;
                //echo "<br>ING ".$datosestudiante['idestudiantegeneral'];
            }

            if ($ingarpvigente || $ingarpextvigente)
                $siga = 0;
            break;
        case 6:
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "INA")) {
                $ingarpvigente = 1;
                //echo "<br>INA ".$datosestudiante['idestudiantegeneral'];
            }
            if ($datosnovedad2 = datos_novedad_vigente($mes, $datosestudiante['idestudiantegeneral'], $objetobase, "IXA")) {
                $ingarpextvigente = 1;
                //echo "<br>ING ".$datosestudiante['idestudiantegeneral'];
            }
            if (!($ingarpvigente || $ingarpextvigente)) {
                $siga = 0;
                //echo "<br>Sin INA ".$datosestudiante['idestudiantegeneral'];
            }
            break;

        case 0:
            $siga = 1;
            break;
    }
    //if($codigoestudiante==32115)
    //echo "SIGA HABER =".$siga."<br>";
    return $siga;
}
/**
 * Consulta validacion estudiante activo
 */
function adjuntoquery($pagoeps=1, $pagoarp=1, $codigoperiodo, $idvalidador="e.codigoestudiante") {

    $con_1 = " and $idvalidador ";
    $con_3 = " (SELECT $idvalidador
FROM ordenpago o, detalleordenpago d, estudiante e
WHERE o.numeroordenpago=d.numeroordenpago";
    $con_5 = "AND o.codigoestadoordenpago LIKE '4%'
AND o.codigoperiodo='$codigoperiodo'
AND e.codigoestudiante=o.codigoestudiante)";

    if ($pagoeps) {
        if ($pagoeps == 1) {
            $coneps_4 = " d.codigoconcepto = 'C9056' ";
            $coneps_2 = "in";
        } else {
            $coneps_4 = " d.codigoconcepto = 'C9056' ";
            $coneps_2 = " not in ";
        }
    }

    if ($pagoarp) {

        if ($pagoarp == 1) {
            if (!isset($conin_2)) {
                $conarp_2 = "in";
                $conarp_4 = " d.codigoconcepto = '165' ";
            } else {
                $orin = " and d.codigoconcepto = '165'";
            }
        } else {
            if (!isset($connot_2)) {
                $conarp_4 = " d.codigoconcepto = '165' ";
                $conarp_2 = " not in ";
            }
            else
                $ornot=" or d.codigoconcepto = '165'";
        }
    }
    $adjunto["query"] = "";
    if (isset($coneps_2))
        $adjunto["query"] .= $con_1 . $coneps_2 . $con_3 . " and (" . $coneps_4 . ") " . $con_5;
    if (isset($conarp_2))
        $adjunto["query"] .= $con_1 . $conarp_2 . $con_3 . " and (" . $conarp_4 . ") " . $con_5;


//$adjunto["tabla"]=$tabla;
//$adjunto["query"]=$condicion;
//$adjunto["relacion"]=$relacion;

    return $adjunto;
}
/**
 * Retorna nombre corto de la novedad
 */
function vector_nombres_cortos_novedad($tipoaplicacion, $conexion) {
    $query = "select nombrecortonovedadarp from novedadarp where codigotipoaplicacionnovedadarp='$tipoaplicacion'
			and idnovedadarp not in (1,24)
			order by ordennovedadarp";

    $operacion = $conexion->query($query);
    $i = 0;
    while ($row_operacion = $operacion->fetchRow()) {
        $fila[$i] = $row_operacion['nombrecortonovedadarp'];
        $i++;
    }
    return $fila;
}

/**
 * Retorna la consulta SQL del listado de estudiantes con seguridad, filtrado segun parametros
 */
function querylistadocierre($pagoeps, $pagoarp, $codigoperiodo, $codigomodalidadacademica, $imprimir=0, $mescierre="") {
    $adjunto = adjuntoquery($pagoeps, $pagoarp, $codigoperiodo, "e.codigoestudiante");
    $adjunto2 = adjuntoquery($pagoeps, $pagoarp, $codigoperiodo, "e.idestudiantegeneral");
    $mescierresql = formato_fecha_mysql($mescierre);
    $mescierresqlfinal = formato_fecha_mysql(final_mes_fecha($mescierre));
    $mescierresqlinicio = formato_fecha_mysql(inicio_mes_fecha($mescierre));

    $query = "SELECT distinct
e.idestudiantegeneral,
d.nombrecortodocumento Tipo,
ed.numerodocumento,
eg.apellidosestudiantegeneral apellidos,
eg.nombresestudiantegeneral nombres
FROM estudiante e,
carrera c,
modalidadacademica ma,

ordenpago op,
estudiantegeneral eg
left join estudiantenovedadarp en on 
eg.idestudiantegeneral=en.idestudiantegeneral and
'" . date('Y-m-d') . "' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp
and en.codigoestado like '1%' 
left join estudiantedocumento ed on 
en.idestudiantedocumento=ed.idestudiantedocumento 
left join documento d on ed.tipodocumento=d.tipodocumento
WHERE 
e.idestudiantegeneral=eg.idestudiantegeneral


AND e.codigocarrera = c.codigocarrera
AND c.codigomodalidadacademica=ma.codigomodalidadacademica

AND ma.codigomodalidadacademica='$codigomodalidadacademica'
AND e.codigoestudiante=op.codigoestudiante
AND op.codigoperiodo='$codigoperiodo'
AND op.codigoestadoordenpago like '4%'
 " . $adjunto["query"] . "
 " . $adjunto2["query"] . "
group by eg.idestudiantegeneral
UNION
Select distinct 
eg.idestudiantegeneral, 
d.nombrecortodocumento Tipo,
ed.numerodocumento,
eg.apellidosestudiantegeneral apellidos,
eg.nombresestudiantegeneral nombres
from estudiantegeneral eg,
 estudiantenovedadarpextemporaneo ene, documento d,
estudiantenovedadarp en, estudiantedocumento ed
 where 
eg.idestudiantegeneral=en.idestudiantegeneral
 and ene.idestudiantenovedadarp=en.idestudiantenovedadarp
 and en.idestudiantedocumento=ed.idestudiantedocumento
 and ( '$mescierresqlfinal' between fechainicioestudiantenovedadarpextemporaneo and fechafinalestudiantenovedadarpextemporaneo)
 and ene.codigoestado like '1%' and en.codigoestado like '1%' 
and ed.tipodocumento=d.tipodocumento
group by eg.idestudiantegeneral
order by apellidos,nombres

";

//eg.numerodocumento,

    if ($imprimir)
        echo $query;

    return $query;
}

/**
 * Retorna boleano true  si el proceso esta activo
 */
function validacionprocesoactivo($fechadeingreso, $objetobase, $idproceso, $imprimir=0) {
    $condicion = " and d.codigoestado like '1%'
			and '" . formato_fecha_mysql($fechadeingreso) . "' between d.fechainiciodetalleproceso and d.fechafinaldetalleproceso ";
    if ($datos = $objetobase->recuperar_datos_tabla("detalleproceso d", "d.idproceso", $idproceso, $condicion, '', $imprimir))
        return true;
    return false;
}

function listadomesesproceso($objetobase, $fechadeingreso, $idproceso, $imprimir=0) {
    $condicion = " and d.codigoestado like '1%'";
    $operacion = $objetobase->recuperar_resultado_tabla('detalleproceso d', "idproceso", $idproceso, $condicion, '', $imprimir);
    while ($row_operacion = $operacion->fetchRow()) {
        $fila[$row_operacion["nombredetalleproceso"]] = $row_operacion["nombredetalleproceso"];
    }
    return $fila;
}

/**
 * Retorna la consulta SQL del listado de estudiantes con seguridad, filtrado segun parametros
 */
function querylistadocierrearp($pagoeps, $pagoarp, $codigoperiodo, $codigomodalidadacademica, $imprimir=0, $estadoorden='40', $validaperiodo=1) {
    $adjunto = adjuntoquery($pagoeps, $pagoarp, $codigoperiodo, "e.codigoestudiante");
    $adjunto2 = adjuntoquery($pagoeps, $pagoarp, $codigoperiodo, "e.idestudiantegeneral");
//echo "ESTADO ORDEN=".$estadoorden."<br>";
    if ($estadoorden != "NA") {
//$tablaorden = ", ordenpago op";
        $validaorden = " AND op.codigoperiodo='$codigoperiodo'
				";
    } else {
        $tablaorden = "";
        $validaorden = "";
    }

    if ($estadoorden == "NA")
        $orden = "";
    else
        $orden="AND op.codigoestadoordenpago like '" . $estadoorden[0] . "%'";

    $query = "SELECT distinct
e.idestudiantegeneral,
d.nombrecortodocumento Tipo,
eg.numerodocumento,
eg.apellidosestudiantegeneral apellidos,
eg.nombresestudiantegeneral nombres
FROM estudiante e, estudiantegeneral eg,
carrera c, modalidadacademica ma, documento d , ordenpago op
WHERE e.idestudiantegeneral=eg.idestudiantegeneral
AND e.codigocarrera = c.codigocarrera
AND c.codigomodalidadacademica=ma.codigomodalidadacademica
AND eg.tipodocumento=d.tipodocumento
AND ma.codigomodalidadacademica='$codigomodalidadacademica'
AND e.codigoestudiante=op.codigoestudiante
$validaorden
 " . $orden . "
 " . $adjunto["query"] . "
 " . $adjunto2["query"] . "
order by apellidosestudiantegeneral,nombresestudiantegeneral
";

    if ($imprimir)
        echo $query;

    return $query;
}
?>