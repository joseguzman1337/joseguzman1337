<?php
require_once('CalculoSemestreEstudiante.php');
#instancia de clase que se encarga de calcular semestres y creditos del estudiante.
$calculoSemestre = new CalculoSemestreEstudiante($materiascongrupo, $codigoestudiante);
#esta variable obtiene datos de la orden activa si existiera
$estadoOrdenActualActiva = $calculoSemestre->validarOrdenActualActiva(isset($numeroordenpagoinicial)?
    $numeroordenpagoinicial : null);
#numero de semestre que va a cursar el estudiante de acuerdo a las materias inscritas
$semestre = $calculoSemestre->calculoSemestreEstudiantes();
#creditos correspondientes a la carrea que está cursando el estudiante.
$creditosSemestre = $calculoSemestre->totalCreditosSemestre();
$creditosCarrera = $calculoSemestre->getCreditosCarrera();
$semestreCarrera = $calculoSemestre->getSemetresCarrera();
$creditoscalculados = $calculoSemestre->totalCreditosCalculados();
$valorBaseMatricula = $calculoSemestre->getValorBaseMatricula($valordetallecohorte);

// Esta variable vendría vacia si no existe plan de estudios para el estudiante
// Es decir a los que se les genere orden sin plan de estudios les toma el 100% del valor de matricula
// Si tiene plan de estudios y no les selecciona materias le genera el 100% del valor de la matricula colocandolo en un semestre
// y cobrándole al 100% de esa cohorte: La variable $creditoscalculados queda igual a 0.
// Funcion que calcula el valor de cada credito
function  calcular_valorcredito($sala, $valordetallecohorte, $codigoestudiante, $creditosSemestre){
    $valor = 0;

    #se divide el valor del semestre por creditostotales del semestre del estudiante.
    if($creditosSemestre == 0 || is_null($creditosSemestre))
    {
        $valor = 0;
    }else{
        $valor = $valordetallecohorte/$creditosSemestre;
    }
    return $valor;
}
#valida si los creditos calculados son menores al valor base o al 50%
if($creditosSemestre == 0 || $creditoscalculados == 0){
    $porcentajecreditos = 100;
}else if($creditoscalculados <= $valorBaseMatricula['creditosBase']){
    $porcentajecreditos = 50;
}else
{
    # calcula los creditos seleccionados sobre los creditos del semestre
    $porcentajecreditos = $creditoscalculados * 100 / $creditosSemestre;
}
$porcentajecreditos = round($porcentajecreditos, 1);

#verifica si es un estudiante de convenio  retoU o iman
if($calculoSemestre->estudianteConvenioInscripcion()){
    $valorcredito = calcular_valorcredito($sala, $valordetallecohorte, $codigoestudiante,$creditosSemestre);
    $valormatricula = $valorcredito * $creditoscalculados;
}else{
    if($porcentajecreditos <= 50){// 1% y 50% del valor de la matricula
        #corresponde a la mitad del valor del semestre
        $valormatricula =  $valorBaseMatricula['valorBase'];
    }else if($porcentajecreditos > 50){// 51 y 100% del valor de la matricula
        $valorcredito = calcular_valorcredito($sala, $valordetallecohorte, $codigoestudiante,$creditosSemestre);
        $valormatricula = $valorcredito * $creditoscalculados;

        #si es educacion continuada el asigna el valor de detalle cohorte como valor de matricula
        if($calculoSemestre->esEducacionContinuada())
        {
            $valormatricula = $valordetallecohorte;
        }
    }
}


$valormatricula = round($valormatricula,0);
// Hay que hacer dos validaciones para el calculo del valor adicional:
// 1. Cuando el estudiante no tiene materias prematriculadas se le debe generar la nueva orden tomando el valor
// adicional con el menor semestre que tenga en las materias
// 2. Cuando tenga prematriculadas mirar que materia de las que vienen de más tiene el menor semestre
// Se selecciona el valor a pagar por el estudiante para la fecha de esntrega y el idfechafinancierava
#se obtiene el valor de credito para otra jorna0da solo se tiene encuenta cuando sobre pasa la media carga

if ($porcentajecreditos > 50) {
    $valorcreditootrajornada = calcular_valormatriculaotrajornada($sala, $codigocarrera, $codigoperiodo, $codigojornada, $codigoestudiante);
    $valordescontarcredito = calcular_valorcredito($sala, $valordetallecohorte, $codigoestudiante, $creditosSemestre);
}
$valorcreditos = $valorcreditootrajornada*$creditosotrajornada;
$valorcreditos = $valorcreditos - ($valordescontarcredito*$creditosotrajornada);

$valormatricula = $valormatricula + $valorcreditos;
$totalvalormatricula = round($valormatricula,0);
//Dato necesario para la comparacion del valor de la nueva matricula con la anterior
$valormatriculanueva = $totalvalormatricula;

if(isset($_SESSION['cursosvacacionalessesion'])){
    // Debe calcular el valor de los creditos seleccionados * credito
    $valormatriculainicial = 0;
    if($creditoscursosvacacionales != 0){
        $valormatriculainicial = 0;
        $valorcredito = calcular_valorcredito($sala, $valordetallecohorte, $codigoestudiante,$creditosSemestre);
        $valorcreditoscurso = $valorcredito*$creditoscursosvacacionales;
        $valormatriculanueva = $valorcreditoscurso;
    }
    $codigoconcepto = $conceptocobroxcreditos;
}
if($valormatriculainicial < $valormatriculanueva){// si la nueva matricula es de mayor valor
    $query_indicador = "SELECT codigotipocosto FROM carrera ".
                       "WHERE  codigocarrera = '$codigocarrera'";
    $indicador = mysql_db_query($database_sala,$query_indicador) or die("$query_indicador");
    $totalRows_indicador = mysql_num_rows($indicador);
    $row_indicador = mysql_fetch_array($indicador);

    if($codigomodalidadacademica == '400' && $row_indicador['codigotipocosto'] == '100' && $valormatriculainicial > 0){
        $generarnuevaorden = false;
    }else{
        $generarnuevaorden = true;
    }

    if($estadoOrdenActualActiva != false && isset($estadoOrdenActualActiva['codigoestadoordenpago'])
        && in_array($estadoOrdenActualActiva['codigoestadoordenpago'],array(40,41)))
    {

        $nuevovalormatricula = $valormatriculanueva - $valormatriculainicial;
        $totalvalormatricula = $nuevovalormatricula;
    }
    elseif (isset($_SESSION['cursosvacacionalessesion'])) {
        $nuevovalormatricula = $valormatriculanueva - $valormatriculainicial;
        $totalvalormatricula = $nuevovalormatricula;
    }
    else
    {
        #si existe orden anterior y esta activa no manipula el valor y anula la orden activa para
        #generar nueva orden con nuevo valor
        if(isset($estadoOrdenActualActiva['codigoestadoordenpago'])
            && in_array($estadoOrdenActualActiva['codigoestadoordenpago'],array(10,11)))
            $calculoSemestre->anulaOrdenPagoActual($estadoOrdenActualActiva['numeroordenpago']);
        $calculoSemestre->actualizarOrdenDetallePrematricula($numeroordenpago,$estadoOrdenActualActiva['numeroordenpago']);
        $totalvalormatricula = $valormatriculanueva;
    }
    // Se realiza comparacion para que no se generen ordenes con valor negativo.
    if ($totalvalormatricula > 0){
        $generarnuevaorden = true;
    }else{
        $generarnuevaorden = false;
    }
}else if($valormatriculainicial == $valormatriculanueva){
    $generarnuevaorden = false;
}else{
    $generarnuevaorden = false;
    if(isset($estadoOrdenActualActiva['codigoestadoordenpago']) && in_array($estadoOrdenActualActiva['codigoestadoordenpago'],array(10,11))){
        $calculoSemestre->anulaOrdenPagoActual($estadoOrdenActualActiva['numeroordenpago']);
        $calculoSemestre->actualizarOrdenDetallePrematricula($numeroordenpago,$estadoOrdenActualActiva['numeroordenpago']);
        $totalvalormatricula = $valormatriculanueva;
        $generarnuevaorden = true;
    }
}

$query_selordenpago = "select o.numeroordenpago from ordenpago o ".
    " where o.codigoperiodo = '".$codigoperiodo."' and o.codigoestudiante = '".$codigoestudiante."' ".
    " and o.codigoestadoordenpago like '14%'";
$selordenpago = mysql_db_query($database_sala,$query_selordenpago) or die("$query_selordenpago");
$totalRows_selordenpago = mysql_num_rows($selordenpago);

if($totalRows_selordenpago != ""){
    $row_selordenpago = mysql_fetch_array($selordenpago);

    $numerorodenpagoplandepagosap = $row_selordenpago['numeroordenpago'];
    // Mirar si el plan de pagos ya tiene una orden diferente de 1
    $query_selordenpagopp = "select op.idordenpagoplandepago from ordenpagoplandepago op ".
        " where op.numerorodenpagoplandepagosap = '".$numerorodenpagoplandepagosap."' ".
        " and op.numerorodencoutaplandepagosap = '1' and op.codigoestado like '1%'";
    $selordenpagopp = mysql_db_query($database_sala,$query_selordenpagopp) or die("$query_selordenpagopp");
    $totalRows_selordenpagopp = mysql_num_rows($selordenpagopp);
    if($totalRows_selordenpagopp != ""){
        $generarordenprimeracuota = true;
        $generarnuevaorden = true;
    }
}
