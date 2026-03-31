<?php
    /*
    * @Ivan quintero <quinteroivan@unbosque.edu.co>
    * Ajustes de linea y limpieza de echos
    * 29 de Septiembre 2017
    */

    session_start();
    ini_set('display_errors', 'Off');
    $rutaado=("../../../funciones/adodb/");

    require_once("../../../Connections/salaado-pear.php");
    require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
    require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
    require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
    require_once("../../../funciones/clases/formulario/clase_formulario.php");
    require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
    require_once("../../../funciones/sala_genericas/encuesta/ValidaEncuesta.php");

    unset($_SESSION['tmptipovotante']);
    $fechahoy=date("Y-m-d H:i:s");
    $formulario=new formulariobaseestudiante($sala,'form1','post','','true');
    $objetobase=new BaseDeDatosGeneral($sala);
    $query = "SELECT codigoperiodo from periodo where codigoestadoperiodo in (3,1) ORDER BY codigoestadoperiodo DESC";
    $resultado= $objetobase->conexion->query($query);
    $rowperiodo=$resultado->fetchRow();

    $query_valcarrera = "select * from estudiante e, estudiantegeneral eg where eg.idestudiantegeneral='".$_GET['idusuario']."' and e.idestudiantegeneral=eg.idestudiantegeneral and e.codigocarrera in(133,134)";   
    $valcarrera = $objetobase->conexion->query($query_valcarrera);
    $totalRows_valcarrera = $valcarrera->numRows();

    if($totalRows_valcarrera!=0)
    {
        $_GET["codigotipousuario"]=600;
	$_GET["idencuesta"]=50;
	$url_encuesta="encuestaautofacultad/encuestaautofacultad.php";
	$condicion_aux="'200'";
	$condicion_aux2="";
    }
    else
    { 
        $_GET["codigotipousuario"]=600;
	$_GET["idencuesta"]=50;
	$url_encuesta="encuestaautofacultad/encuestaautofacultad.php";
	$condicion_aux="'200'";
	$condicion_aux2="";
    }

    /*
    * @Ivan quintero <quinteroivan@unbosque.edu.co>
    * Actualizacion de fechas para las evaluaciones docentes
    * 24 de marzo 2017
    * NO SE DEBE CONFIGURAR DIFERENTES IFS EN LOS MISMOS RANGOS DE FECHAS 
    */

    $carreras="-1";
    //actualizado 20172
    $fechaInicio="2017-10-02 00:00:00";
    $fechaFin="2017-10-08 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
        //FILOSOFIA,ADMINISTRACION DE EMPRESAS,NEGOCIOS INTERNACIONALES,CURSO BASICO (GENERAL), INSTRUMENTACION QUIRIRGICA	
	$carreras= "427,5,748,13,560,554,380";
    }

    $fechaInicio="2017-10-17 00:00:00";
    $fechaFin="2017-10-22 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
        //bioingenieria, diseño industrial, diseño de comunicacion
	$carreras= "564,129,788";
    }

    $fechaInicio="2017-10-23 00:00:00";
    $fechaFin="2017-10-29 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
    //INGENIERIA AMBIENTAL, CIENCIA POLITICA,DERECHO
	$carreras= "125, 735, 595";
    }

    /*
    * Ivan Dario quintero
    * 31 de octubre
    * se adiciona los programas de diseño
    */
    $fechaInicio="2017-10-30 00:00:00";
    $fechaFin="2017-11-06 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
    //INGENIERIA ELECTRONICA ,INGENIERIA INDUSTRIAL,MATEMATICAS,ESTADISTICA, --- diseño industrial, diseño de comunicacion
	$carreras= "118,119,126,790,857, 129,788";
    }

    $fechaInicio="2017-11-07 00:00:00";
    $fechaFin="2017-11-13 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
    //INGENIERIA DE SISTEMAS,LICENCIATURA EN EDUCACION BILINGUE CON ENFASIS EN LA ENSEÑANZA DEL INGLES,LICENCIATURA EN PEDAGOGIA INFANTIL, LICENCIATURA EN BILINGUISMO CON ENFASIS EN LA ENSEÑANZA DEL INGLES, LICENCIATURA EN EDUCACION INFANTIL --- diseño industrial, diseño de comunicacion
	$carreras= "123,124,93,90,1112,1113,129,788";
    }

    /*
    * END
    */


    $fechaInicio="2017-11-14 00:00:00";
    $fechaFin="2017-11-19 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
    //MEDICINA, ARTE DRAMATICO, ARTES PLASTICAS, FORMACION MUSICAL, OPTOMETRIA, Biologia
	$carreras= "10, 500, 132, 130, 375, 122,1112";
    }
  
    /*$fechaInicio="2017-11-20 00:00:00";
    $fechaFin="2017-11-26 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
        //PSICOLOGIA
        $carreras= "133,134";
    }*/

    /*
     * habilitar fechas de evaluacion docente
     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Universidad el Bosque - Direccion de Tecnologia.
     * Modificado 16 noviembre de 2017. 
     */
    $fechaInicio="2017-11-20 00:00:00";
    $fechaFin="2017-11-21 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
        //Odontologia, ENFERMERIA,   Licenciatura en Educación Bilingüe, Licenciatura en Bilingüismo
	$carreras= "8,11,93,1112";
    }
    /*
     * end
     */
    /*
     * habilitar fechas de evaluacion docente
     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Universidad el Bosque - Direccion de Tecnologia.
     * Modificado 21 noviembre de 2017. 
     */
    $fechaInicio="2017-11-22 00:00:00";
    $fechaFin="2017-11-22 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
        //Odontologia, ENFERMERIA, Licenciatura en Educación Bilingüe
	$carreras= "8,11,93";
    }
    /*
     * end
     */


    $fechaInicio="2017-11-23 00:00:00";
    $fechaFin="2017-11-26 23:59:59";
    if( strtotime($fechaInicio) <= strtotime($fechahoy) && strtotime($fechaFin) >= strtotime($fechahoy))
    {
        //Odontologia, ENFERMERIA 
	$carreras= "8,11";
    }
   
    $condicion =" and o.numeroordenpago=d.numeroordenpago 
                and eg.idestudiantegeneral=e.idestudiantegeneral
                AND e.codigoestudiante=pr.codigoestudiante
                AND pr.codigoperiodo='".$rowperiodo["codigoperiodo"]."'
                AND e.codigoestudiante=o.codigoestudiante
                AND c.codigocarrera=e.codigocarrera
                AND d.codigoconcepto=co.codigoconcepto
                AND co.cuentaoperacionprincipal=151
                AND o.codigoperiodo='".$rowperiodo["codigoperiodo"]."'
                AND o.codigoestadoordenpago LIKE '4%'
                $condicion_aux2
                and c.codigomodalidadacademica in ($condicion_aux)
                and c.codigocarrera in(".$carreras.")
                and codigomodalidadacademica=200";
    if($datosnombresegresado=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg","eg.idestudiantegeneral",$_GET['idusuario'],$condicion,'',0)) 
    {
        $siga=1;
    	$codigocarrera=$datosnombresegresado['codigocarrera'];
	$codigoestudiante=$datosnombresegresado['codigoestudiante'];
    } 
    else 
    {
       $siga=0;
    }

    if($siga) 
    {
        $codigoperiodo="".$rowperiodo["codigoperiodo"];
	$codigoestudiante=$datosnombresegresado['codigoestudiante'];
	$objvalidaautoevaluacion=new ValidaEncuesta($objetobase,$codigoperiodo,$codigoestudiante);
	if($objvalidaautoevaluacion->validaEncuestaCompleta())
        {
            alerta_javascript('Ha finalizado la evaluacion docente,\n Gracias por su colaboracion');

            $query_actualizaestado = "insert into actualizacionusuario (usuarioid, tipoactualizacion, id_instrumento, codigoperiodo, estadoactualizacion,userid,entrydate)
			values ('".$_SESSION['idusuariofinalentradaentrada']."',3,0,'$codigoperiodo',1,'".$_SESSION['idusuariofinalentradaentrada']."',now())";   
            $actualizaestado = $objetobase->conexion->query($query_actualizaestado);
            /*if(isset($_GET['redir'])){
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../prematricula/matriculaautomaticaordenmatricula.php'>";
            }*/	
            echo "<script type='text/javascript'> window.parent.continuar();</script>";
	}

	$query_selencuesta = "SELECT idencuesta FROM encuesta where now() between fechainicioencuesta and fechafinalencuesta and idencuesta = '".$_GET["idencuesta"]."'";
	$selencuesta = $objetobase->conexion->query($query_selencuesta);
	$totalRows_selencuesta = $selencuesta->numRows();    

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../$url_encuesta?idencuesta=".$_GET["idencuesta"]."&idusuario=".$_GET["idusuario"]."&codigoestudiante=".$codigoestudiante."&codigotipousuario=".$_GET["codigotipousuario"]."&codigocarrera=$codigocarrera'>";
    }
    else 
    {
        // SI PASA TODAS LAS VALIDACIONES LO REDIRECCIONA A LA ENCUESTA DE ING INDUSTRIAL
	// echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestaacreditacioningindustrialestudiantes20131/validaingresoestudiante.php?idusuario=".$_GET["idusuario"]."'>";
	// SI PARA TODAS LAS VALIDACIONES LO REDIRECCIONA AL INDEX NORMAL DESPUÃ‰S DEL LOGUEO
	echo "<script type='text/javascript'> window.parent.continuar();</script>";
    }
    /*
    * end
    */
?>