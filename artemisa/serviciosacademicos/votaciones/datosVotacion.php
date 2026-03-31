<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hacen los ajustes correspondientes a la variable de sesion idvotacion
 * @since Mayo 27, 2019
 */ 
session_start();
unset($array_plantillas_ampliado);
unset($_SESSION['array_plantillas_ampliado']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" type="text/css" href="../estilos/sala.css">
        <script language="javascript">
            function abrir(pagina, ventana, parametros)
            {
                window.open(pagina, ventana, parametros);
            }

            function enviarmenu(obj)
            {
                var formulario = document.getElementById("formfacultad");
                var carrera = document.getElementById("codigocarrera");
                carrera.value = obj.value;
                formulario.action = "datosVotacion.php#facultad";
                formulario.submit();
            }

            function cambiarimagen(objDiv, tipo)
            {
                objimagen = document.getElementById('imagenboton');
                if (tipo == 1)
                    objimagen.src = "../../imagenes/botonvotacion2.png";
                else
                    objimagen.src = "../../imagenes/botonvotacion.png";
            }
        </script>
        <style type="text/css">
            <!--
            .Estilo1 {
                font-size: 15px;
                font-weight: bold;
            }
            -->
        </style>
    </head>
    <body>
        <?php
        unset($_SESSION['array_plantillas']);
        unset($_SESSION['array_detalle_plantillas']);

        if ($_SESSION["MM_Username"] == 'admintecnologia') {
            if (isset($_GET['tipovotante']) && trim($_GET['tipovotante']) != '') {
                $_SESSION['datosvotante']['codigoestudiante'] = $_GET['codigoestudiante'];
                $_SESSION['datosvotante']['numerodocumento'] = $_GET['numerodocumento'];
                if (trim($_GET['tipovotante']) != "docente")
                    $_SESSION['datosvotante']['codigocarrera'] = $_GET['codigocarrera'];
                $_SESSION['datosvotante']['tipovotante'] = $_GET['tipovotante'];
                $_SESSION['datosvotante']['idvotacion'] = $_GET['idvotacion'];
                $_SESSION['datosvotante']['vigencia'] = 0;
            }
        } else
            $_SESSION['datosvotante']['vigencia'] = 1;
        if ($_SESSION['datosvotante']['tipovotante'] == 'directivo') {
            $tipocandidato = 3;
            $_SESSION['tmptipovotante'] = $_SESSION['datosvotante']['tipovotante'];
            $_SESSION['datosvotante']['tipovotante'] = 'docente';
        }
        


        $fechahoy = date("Y-m-d H:i:s");
        $rutaado = ("../funciones/adodb/");
        require_once('../Connections/salaado-pear.php');
        require_once("../funciones/clases/motorv2/motor.php");
        require_once("../funciones/clases/formulariov2/clase_formulario.php");
        require_once("../funciones/sala_genericas/FuncionesCadena.php");
        require_once("../funciones/sala_genericas/FuncionesFecha.php");
        require_once("../funciones/sala_genericas/formulariobaseestudiante.php");
        require_once("../funciones/sala_genericas/clasebasesdedatosgeneral.php");
        require_once("funciones/obtenerDatos.php");
        if($_SESSION['rol']==1 && $_SESSION['MM_Username']!='padre'){
		
		$query_sitestudiante="select * from estudiante where codigoestudiante=".$_SESSION['datosvotante']['codigoestudiante']." and codigosituacioncarreraestudiante=400";
                $sitestudiante=$sala->query($query_sitestudiante);
                $totalRows_sitestudiante = $sitestudiante->RecordCount();
                $row_sitestudiante=$sitestudiante->fetchRow();

                if($totalRows_sitestudiante==0){	
		$query_modalidad="select * from estudiante e, carrera c where e.codigoestudiante=".$_SESSION['datosvotante']['codigoestudiante']." and e.codigocarrera=c.codigocarrera";
                        $modalidad=$sala->query($query_modalidad);
                        $totalRows_modalidad = $modalidad->RecordCount();
                        $row_modalidad=$modalidad->fetchRow();

                        if($row_modalidad['codigomodalidadacademica']=='200'){
                        $query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
                        votacion v, plantillavotacion pv,estudiante e
                        WHERE
                        v.codigoestado=100
                        and e.codigoestudiante=".$_SESSION['datosvotante']['codigoestudiante']."
                        and pv.idvotacion=v.idvotacion
                        and pv.codigocarrera=".$_SESSION['datosvotante']['codigocarrera']."
                        and (pv.codigocarrera = e.codigocarrera OR pv.codigocarrera=1) 
                        and v.idtipocandidatodetalleplantillavotacion=2
                        AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
                        group by v.idvotacion
                        ";
                        }
                        elseif($row_modalidad['codigomodalidadacademica']=='300'){
                        $query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion 
                        FROM
                        votacion v
                        WHERE
                        v.codigoestado=100
                        and v.idtipocandidatodetalleplantillavotacion=2
                        AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
                         ";
                        }
	
		}
		else{

		$query_modalidad="select * from estudiante e, carrera c where e.codigoestudiante=".$_SESSION['datosvotante']['codigoestudiante']." and e.codigocarrera=c.codigocarrera";
                        $modalidad=$sala->query($query_modalidad);
                        $totalRows_modalidad = $modalidad->RecordCount();
                        $row_modalidad=$modalidad->fetchRow();
                $query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion 
                FROM
                votacion v
                WHERE
                v.codigoestado=100
                and v.idtipocandidatodetalleplantillavotacion=3
                AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
                 ";
                }
                
                $operacion_votacion=$sala->query($query_votacion);
                $row_operacion_votacion=$operacion_votacion->fetchRow();
                $_SESSION['datosvotante']['idvotacion']=$row_operacion_votacion['idvotacion'];
	}
        /**
         * Si la aplicacion se corre en un entorno local o de pruebas se activa la visualizacion 
         * de todos los errores de php
         */
        $Configuration = Configuration::getInstance();
        if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas") {
            @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
            @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
            /**
             * Se incluye la libreria Kint para hacer debug controlado de variables y objetos
             */
            require (PATH_ROOT . '/kint/Kint.class.php');
        }
        
        $fechahoy = date("Y-m-d H:i:s");
        $formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
        $objetobase = new BaseDeDatosGeneral($sala);
        $ip = $formulario->GetIP();

        /**
         * @param $sala
         * @param $codigocarrera
         * @return mixed
         * busca equivalencias de carreras para visualizacion de votaciones
         */
        function buscarCarreraEgresado($sala, $codigocarrera) {
            $carrera = $codigocarrera;
            $sql = "select * from votacioncarreraequivalencia where codigocarrera =" . $codigocarrera;
            $votos = $sala->query($sql);
            $row = $votos->fetchRow();
            if ($row !== false) {
                $carrera = $row["codigocarreraequivalencia"];
            }
            return $carrera;
        }

        function buscarCarreraDocente($sala, $numerodocumento) {
            $carrera = 1;
            $sql = "SELECT MAX(x.numgrupos), x.* FROM (
                        select COUNT(g.idgrupo) as numgrupos,g.idgrupo,g.codigomateria,m.codigocarrera
                         from grupo g 
                        inner join materia m on m.codigomateria=g.codigomateria
                        inner join periodo p on p.codigoperiodo=g.codigoperiodo 
                        inner join carrera c on c.codigocarrera=m.codigocarrera and c.codigomodalidadacademica in (200,300)
                        where numerodocumento=" . $numerodocumento . " and p.fechainicioperiodo<NOW() and p.fechavencimientoperiodo>NOW() 					
                        GROUP BY m.codigocarrera
                        ) x";
            $votos = $sala->query($sql);
            $row = $votos->fetchRow();
            if ($row !== false && $row["codigocarrera"] != null) {
                $sql = "SELECT nombreplantillavotacion FROM votacion v  INNER JOIN plantillavotacion pv ON pv.idvotacion=v.idvotacion and pv.codigoestado=100  				WHERE v.fechafinalvotacion>NOW() AND pv.codigocarrera=" . $row["codigocarrera"];
                $votos = $sala->query($sql);
                $rowC = $votos->fetchRow();

                #si no trae ninguna plantilla valida equivalencias usadas para egresados.
                if($rowC == false && $rowC["nombreplantillavotacion"] == null)
                {
                   $equivalencia =  buscarCarreraEgresado($sala,$row["codigocarrera"]);
                   if(!is_null($equivalencia))
                   {
                       $carrera = $equivalencia;
                   }
                }

                if ($rowC !== false && $rowC["nombreplantillavotacion"] != null) {
                    $carrera = $row["codigocarrera"];
                } else {
                    $sql = "SELECT pv.codigocarrera FROM votacion v 
                            INNER JOIN plantillavotacion pv ON pv.idvotacion=v.idvotacion and pv.codigoestado=100 
                            INNER JOIN carrera c on c.codigocarrera=pv.codigocarrera
                            WHERE v.fechafinalvotacion>NOW() AND c.codigomodalidadacademica in (200,300) 
                            AND c.codigofacultad='" . $row["codigofacultad"] . "'";
                    $votos = $sala->query($sql);
                    $rowC = $votos->fetchRow();
                    if ($rowC !== false && $rowC["codigocarrera"] != null) {
                        $carrera = $rowC["codigocarrera"];
                    } else {
                        $sql = "select * from docentesvoto where numerodocumento =" . $numerodocumento;
                        $votos = $sala->query($sql);
                        $row = $votos->fetchRow();
                        if ($row !== false) {
                            $carrera = $row["codigocarrera"];
                        }
                    }
                }
            } else {
                $sql = "select * from docentesvoto where numerodocumento =" . $numerodocumento;
                $votos = $sala->query($sql);
                $row = $votos->fetchRow();
                if ($row !== false) {
                    $carrera = $row["codigocarrera"];
                    /**
                     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                     * @since Abril 25, 2019
                     * Se añade una validadcion adicional para encontrar la carrera asociada al area del usuario
                     */
                    $sql = "SELECT codigocarreraequivalencia FROM votacioncarreraequivalencia " .
                            " where codigocarrera = '" . $carrera . "'";
                    $votos = $sala->query($sql);
                    $row = $votos->fetchRow();
                    if ($row !== false) {
                        $carrera = $row["codigocarreraequivalencia"];
                    }
                }
            }
            return $carrera;
        }

        function validarCarreraDocente($sala, $numerodocumento, $carrera) {
            $sql = "SELECT * FROM carrera WHERE codigocarrera=" . $carrera;
            $votos = $sala->query($sql);
            $row = $votos->fetchRow();
            if ($row !== false && $row["codigocarrera"] != null) {
                $sql = "SELECT nombreplantillavotacion FROM votacion v 
                            INNER JOIN plantillavotacion pv ON pv.idvotacion=v.idvotacion and pv.codigoestado=100 
                            WHERE v.fechafinalvotacion>NOW() AND pv.codigocarrera=" . $row["codigocarrera"];
                $votos = $sala->query($sql);
                $rowC = $votos->fetchRow();
                if ($rowC !== false && $rowC["nombreplantillavotacion"] != null) {
                    $carrera = $row["codigocarrera"];
                } else {
                    $sql = "SELECT pv.codigocarrera FROM votacion v 
                                INNER JOIN plantillavotacion pv ON pv.idvotacion=v.idvotacion and pv.codigoestado=100 
                                INNER JOIN carrera c on c.codigocarrera=pv.codigocarrera
                                WHERE v.fechafinalvotacion>NOW() AND c.codigomodalidadacademica in (200,300) 
                                AND c.codigofacultad='" . $row["codigofacultad"] . "'";
                    $votos = $sala->query($sql);
                    $rowC = $votos->fetchRow();
                    if ($rowC !== false && $rowC["codigocarrera"] != null) {
                        $carrera = $rowC["codigocarrera"];
                    } else {
                        $sql = "select * from docentesvoto where numerodocumento =" . $numerodocumento;
                        $votos = $sala->query($sql);
                        $row = $votos->fetchRow();
                        if ($row !== false) {
                            $carrera = $row["codigocarrera"];
                        }
                    }
                }
            } else {
                $sql = "select * from docentesvoto where numerodocumento =" . $numerodocumento;
                $votos = $sala->query($sql);
                $row = $votos->fetchRow();
                if ($row !== false) {
                    $carrera = $row["codigocarrera"];
                }
            }
            return $carrera;
        }

        if (isset($_SESSION['datosvotante']) and is_array($_SESSION['datosvotante'])) {
            
        } else {
            echo "<h1>No hay rol, o se ha pérdido la sesion. No se puede continuar.</h1>";
            exit();
        }
        if (isset($_GET['depurar']) and $_GET['depurar'] == 'si') {
            $depurar = true;
            $sala->debug = true;
        }

        if (isset($_POST['codigocarrera'])) {
            $_SESSION['datosvotante']['codigocarrera'] = $_POST['codigocarrera'];
        } else if (!empty($_SESSION["MM_Username"]) && ($_SESSION["MM_Username"] == 'admintecnologia' || $_SESSION["MM_Username"] == 'equipomgi') && isset($_GET['codigocarrera'])) {
            $_SESSION['datosvotante']['codigocarrera'] = $_GET['codigocarrera'];
        } else
        if (!isset($_SESSION['datosvotante']['codigocarrera']) || trim($_SESSION['datosvotante']['codigocarrera']) == '') {
            $_SESSION['datosvotante']['codigocarrera'] = 1;
        }

        $votacion = new Votaciones($sala, @$depurar);


        if ($_SESSION['datosvotante']['tipovotante'] == "egresado") {
            //para los egresados cuya carrera no tenga candidatos entonces votan en su facultad
            $_SESSION['datosvotante']['codigocarrera'] = buscarCarreraEgresado($sala, $_SESSION['datosvotante']['codigocarrera']);
        } else if ($_SESSION['datosvotante']['tipovotante'] == "docente" && $_SESSION['datosvotante']['estadovotante'] == 'porfuera' && $_SESSION['datosvotante']['codigocarrera'] == 1) {
            //para los docentes que entraron por fuera y no le especifico la carrera
            $_SESSION['datosvotante']['codigocarrera'] = buscarCarreraDocente($sala, $_SESSION['datosvotante']['numerodocumento']);
        } else if ($_SESSION['datosvotante']['tipovotante'] == "docente" && $_SESSION['datosvotante']['estadovotante'] == 'porfuera') {
            //para los docentes que entraron por fuera
            $_SESSION['datosvotante']['codigocarrera'] = validarCarreraDocente($sala, $_SESSION['datosvotante']['numerodocumento'], $_SESSION['datosvotante']['codigocarrera']);
        }

        $votacion->asignarVotaciones($_SESSION['datosvotante']['codigocarrera'], $_SESSION['datosvotante']['numerodocumento'], $_SESSION['datosvotante']['tipovotante'], $_SESSION['datosvotante']['idvotacion'], $_SESSION['datosvotante']['vigencia']);

        $array_carreras = $votacion->LeerCarreras();

        $array_datos_votacion = $votacion->retornaArrayDatosVotacion();

        if ($_SESSION['datosvotante']['tipovotante'] == 'docente')
            $tipocandidato = 1;
        if ($_SESSION['datosvotante']['tipovotante'] == 'estudiante')
            $tipocandidato = 2;

        if ($_SESSION['datosvotante']['tipovotante'] == 'egresado')
            $tipocandidato = 3;
        if ($_SESSION['datosvotante']['tipovotante'] == 'directivo')
            $tipocandidato = 3;


        if ($_SESSION['datosvotante']['tipovotante'] == 'administrativo') {
            $tipocandidato = 4;
        }

        foreach ($array_datos_votacion as $iterador => $arrayvotacion) {
            if ($tipocandidato == $array_datos_votacion[$iterador]["idtipocandidatodetalleplantillavotacion"]) {
                $votacion->asignarVotaciones($_SESSION['datosvotante']['codigocarrera'], $_SESSION['datosvotante']['numerodocumento'], $_SESSION['datosvotante']['tipovotante'], $array_datos_votacion[$iterador]["idvotacion"]);
            }
        }

        $array_tipos_plantillas_votacion = $votacion->retornaArrayTiposPlantillasVotacion();

        if (@$_SESSION['tmptipovotante'] == 'directivo') {
            unset($array_tipos_plantillas_votacion[2]);
        }


        $condatoscanvot = 0;
        foreach ($array_datos_votacion as $iterador => $arrayvotacion) {
            if ($tipocandidato == $array_datos_votacion[$iterador]["idtipocandidatodetalleplantillavotacion"]) {
                $array_datos_votacion_votante[] = $array_datos_votacion[$iterador];
                $votacion->leerTiposPlantillasVotacion($array_datos_votacion[$iterador]["idvotacion"]);
                if ($condatoscanvot == 0)
                    $array_tipos_plantillas_votacion = $votacion->retornaArrayTiposPlantillasVotacion();
                else
                    $array_tipos_plantillas_votacion = array_merge($array_tipos_plantillas_votacion, $votacion->retornaArrayTiposPlantillasVotacion());
                $condatoscanvot++;
            }
        }

        $votacion->leerPlantillasVotacionGenerales();
        $array_plantillas_votacion = $votacion->retornaArrayPlantillasVotacion();



        $array_detalle_plantillas_votaciontmp = $votacion->retornaArrayDetallePlantillasVotacion();

        foreach ($array_detalle_plantillas_votaciontmp as $llave_plantillas => $tmpvalor_plantillas)
            foreach ($tmpvalor_plantillas as $llave_plantillas2 => $tmp2valor_plantillas) {
                $array_detalle_plantillas_votacion[$tmp2valor_plantillas["iddetalleplantillavotacion"]] = $tmp2valor_plantillas;
            }

        foreach ($array_plantillas_votacion as $idtipoplantillavotacion => $arrayplantillas1) {
            if (is_array($arrayplantillas1))
                foreach ($arrayplantillas1 as $iteradorplantilla => $arrayplantillas2) {

                    $conidplantillavotacion[$arrayplantillas2["idplantillavotacion"]] = 0;
                    foreach ($array_detalle_plantillas_votacion as $llave_detalle => $tmpvalor_plantillas) {


                        if ($tmpvalor_plantillas["idplantillavotacion"] == $arrayplantillas2["idplantillavotacion"]) {
                            if ($conidplantillavotacion[$tmpvalor_plantillas["idplantillavotacion"]] < 1) {
                                $numeroidplantillacargo = $tmpvalor_plantillas["idcargo"] . $tmpvalor_plantillas["numerotarjetoncandidatovotacion"] . $tmpvalor_plantillas["idplantillavotacion"];

                                $array_plantillas_ampliado[$idtipoplantillavotacion][$numeroidplantillacargo] = $array_plantillas_votacion[$idtipoplantillavotacion][$iteradorplantilla];
                            }

                            $array_plantillas_ampliado[$idtipoplantillavotacion][$numeroidplantillacargo]["detalle"][] = $tmpvalor_plantillas;
                            $conidplantillavotacion[$tmpvalor_plantillas["idplantillavotacion"]] ++;
                        }
                    }
                    ksort($array_plantillas_ampliado[$idtipoplantillavotacion]);
                }
        }


        $idtipocandidatodetalleplantillavotacion = $votacion->array_datos_votacion[0]['idtipocandidatodetalleplantillavotacion'];
        $arraycarrerasvotacion = $votacion->LeerCarrerasVotacion($idtipocandidatodetalleplantillavotacion);

        if (is_array($arraycarrerasvotacion))
            foreach ($arraycarrerasvotacion as $llave => $arraycarrerai) {
                if ($arraycarrerai["codigocarrera"] != "1")
                    $arrayfacultad[$arraycarrerai["codigocarrera"]] = $arraycarrerai["nombrecarrera"];
            }

        ksort($array_plantillas_ampliado);

        $_SESSION['array_plantillas_ampliado'] = $array_plantillas_ampliado;


        foreach ($array_datos_votacion_votante as $llave_datos_votacion => $valor_datos_votacion) {
            ?>
            <script language="javascript">
                function Confirmacion_<?php echo $valor_datos_votacion['idvotacion'] ?>(link_si, link_no)
                {
                    if (confirm('¿Está usted seguro de su elección?'))
                    {
                        document.form_<?php echo $valor_datos_votacion['idvotacion'] ?>.submit();
                    }
                    return false;
                }
            </script>
            Tenga en cuenta:
            <ul>
                <?php
                if ($_SESSION['datosvotante']['tipovotante'] == 'docente')
                    if ($_SESSION['datosvotante']['tipovotante'] == 'egresado')
                        echo "<li>Seleccione la carrera de la cual egreso</li>";
                if ($_SESSION['datosvotante']['tipovotante'] == 'directivo')
                    
                    ?>

                <li>Seleccione el candidato de su preferencia o haga clic en voto en blanco</li>
                <?php
                if (date("Y-m-d") != "2014-09-29") {
                    ?><li>Para conocer el/los suplente(s) clic en la foto del candidato</li><?php }
                ?>
                <li>Para registrar su voto clic en el boton "VOTE AQUI" </li>    						
            </ul>
            <form name='formfacultad' id='formfacultad' method='post' ><input type="hidden" name="codigocarrera" id="codigocarrera" value=""></form>
            <form name="form_<?php echo $valor_datos_votacion['idvotacion'] ?>" method="POST" action="">
                <input type="hidden" name="submitido" value="submitido">
                <br>
                <?php
                $contadortipoplantilla = 0;
                $contadortipoplantillab = 1;

                if (is_array($array_tipos_plantillas_votacion)) {

                    foreach ($array_plantillas_ampliado as $llave_tipo_plantillas => $valor_tipo_plantillas) {
                        ?>	<div class="Estilo1"><?php
                        $pintar = true;

                        if ($array_tipos_plantillas_votacion[$contadortipoplantilla]["idtipoplantillavotacion"] == $llave_tipo_plantillas) {
                            echo $array_tipos_plantillas_votacion[$contadortipoplantilla]["nombretipoplantillavotacion"];
                        } else {
                            echo $array_tipos_plantillas_votacion[$contadortipoplantillab]["nombretipoplantillavotacion"];
                        }

                        if ($llave_tipo_plantillas == 3 || $llave_tipo_plantillas == 5) {
                            echo $votacion->retornaFacultadVotante($_SESSION['datosvotante']['codigocarrera']);
                        }

                        //si es consejo de facultad y/o Comité de Currículo hay que verificar que tenga candidatos
                        if ($llave_tipo_plantillas == 3 || $llave_tipo_plantillas == 5 && count($array_plantillas_ampliado[$llave_tipo_plantillas]) <= 1) {
                            $votoblanco = true;
                            foreach ($array_plantillas_ampliado[$llave_tipo_plantillas] as $llave_plantillas => $valor_plantillas) {
                                if ($array_plantillas_ampliado[$llave_tipo_plantillas][$llave_plantillas]["detalle"][0]["idcargo"] != 1) {
                                    $votoblanco = false;
                                }
                            }
                            if ($votoblanco) {
                                $pintar = false;
                            }
                        }

                        if ($pintar || $_SESSION['datosvotante']['codigocarrera'] == 1000) {
                            echo "<input type='hidden' name='tipoplantilla_" . $llave_tipo_plantillas . "' value='1'>";

                            $contadortipoplantilla++;
                            $contadortipoplantillab++;

                            if (is_array($array_plantillas_ampliado[$llave_tipo_plantillas])) {
                                foreach ($array_plantillas_ampliado[$llave_tipo_plantillas] as $llave_plantillas => $valor_plantillas) {
                                    $nombretipoplantillavotacion = $array_plantillas_ampliado[$llave_tipo_plantillas][$llave_plantillas]["nombretipoplantillavotacion"];
                                }

                                if ((($tipocandidato == 1 && $_SESSION['datosvotante']['codigocarrera'] == 1000)) && ($llave_tipo_plantillas == 3)) {
                                    $formulario->filatmp = $arrayfacultad;
                                    $formulario->filatmp["1"] = "Seleccionar";
                                    echo "<a name='facultad'/>
										<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='300'>";
                                    $campo = 'menu_fila';
                                    $parametros = "'codigocarreramenu','" . $_SESSION['datosvotante']['codigocarrera'] . "','onchange=enviarmenu(this);'";
                                    $formulario->dibujar_campo($campo, $parametros, "ESCOJA LA CARRERA CORRESPONDIENTE", "labelresaltado", 'codigocarrera', '');
                                    echo "</table>";
                                }
                            } else {
                                if ((($tipocandidato == 1 && $_SESSION['datosvotante']['codigocarrera'] == 1000)) && ($llave_tipo_plantillas == 3)) {
                                    $formulario->filatmp = $arrayfacultad;
                                    $formulario->filatmp["1"] = "Seleccionar";

                                    echo " <a name='facultad'/>
										<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='300'>";
                                    $campo = 'menu_fila';
                                    $parametros = "'codigocarreramenu','" . $_SESSION['datosvotante']['codigocarrera'] . "','onchange=enviarmenu(this);'";
                                    $formulario->dibujar_campo($campo, $parametros, "ESCOJA LA CARRERA CORRESPONDIENTE", "labelresaltado", 'codigocarreramenu', '');
                                    echo "</table>
										";
                                }
                            }
                        }
                        ?>
                        </div>
                        <?php
                        if (!$pintar && $_SESSION['datosvotante']['codigocarrera'] != 1000) {
                            echo "No hay candidatos.";
                        } else {
                            ?>
                            <table cellpadding="1" cellspacing="1"  border="1">
                                <tr>
                                    <?php
                                    if (is_array($array_plantillas_ampliado[$llave_tipo_plantillas])) {
                                        foreach ($array_plantillas_ampliado[$llave_tipo_plantillas] as $llave_plantillas => $valor_plantillas) {
                                            ?>
                                            <td width="100px" align="center">
                                                <?php
                                                echo $array_plantillas_ampliado[$llave_tipo_plantillas][$llave_plantillas]["detalle"][0]['numerotarjetoncandidatovotacion'];
                                                ?>
                                            </td>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <?php
                                    if (isset($array_plantillas_ampliado[$llave_tipo_plantillas]))
                                        foreach ($array_plantillas_ampliado[$llave_tipo_plantillas] as $llave_plantillas => $valor_plantillas) {
                                            $idplantillavotacion = $array_plantillas_ampliado[$llave_tipo_plantillas][$llave_plantillas]["idplantillavotacion"];
                                            $imgReal = $array_plantillas_ampliado[$llave_tipo_plantillas][$llave_plantillas]["detalle"][0]['rutaarchivofotocandidatovotacion'];
                                            ?>
                                            <td width="100px" align="center">
                                                <img onClick="abrir('datosVotacionEmergente.php?idplantillavotacion=<?php echo $llave_plantillas ?>', 'detalle_plantilla_votacion', 'width=500,height=300,resizable=yes,menu=no,toolbar=no,scrollbars=yes,status=no');" src="<?php echo $imgReal; ?>" width="80" height="120" alt="<?php echo $array_plantillas_ampliado[$llave_tipo_plantillas][$llave_plantillas]["detalle"][0]['nombrecandidato'] ?>">
                                            </td>
                                            <?php
                                        }
                                    ?>
                                </tr>
                                <?php
                                unset($imgReal);
                                unset($imagenjpg);
                                unset($imagenJPG);
                                ?>
                                <tr>
                                    <?php
                                    if (is_array($array_plantillas_ampliado[$llave_tipo_plantillas])) {
                                        foreach ($array_plantillas_ampliado[$llave_tipo_plantillas] as $llave_plantillas => $valor_plantillas) {
                                            ?>
                                            <td width="100px" align="center"><?php echo $array_plantillas_ampliado[$llave_tipo_plantillas][$llave_plantillas]["detalle"][0]['nombrecandidato'] ?></td>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <?php
                                    if (is_array($array_plantillas_ampliado[$llave_tipo_plantillas])) {
                                        foreach ($array_plantillas_ampliado[$llave_tipo_plantillas] as $llave_plantillas => $valor_plantillas) {
                                            ?>
                                            <td width="100px" align="center"><?php echo $array_plantillas_ampliado[$llave_tipo_plantillas][$llave_plantillas]['nombreplantillavotacion'] ?></td>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <?php
                                    if (is_array($array_plantillas_ampliado[$llave_tipo_plantillas])) {
                                        foreach ($array_plantillas_ampliado[$llave_tipo_plantillas] as $llave_plantillas => $valor_plantillas) {
                                            ?>
                                            <td width="100px" align="center"><input type="radio" id="<?php echo $llave_tipo_plantillas ?>"  name="<?php echo $llave_tipo_plantillas ?>" value="<?php echo $valor_plantillas['idplantillavotacion'] ?>" <?php
                                                if (@$_POST[$valor_tipo_plantillas['idtipoplantillavotacion']] == $valor_plantillas['idplantillavotacion']) {
                                                    echo "checked";
                                                }
                                                ?>></td>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                            </tr>
                        </table>
                        <br><br>
                        <?php
                    }
                }
                ?>
            </form>
            <table border="0" height="10" width="10">
                <TR>
                    <TD>
                        <br>
                        <div  id="botonvotar" onclick="return Confirmacion_<?php echo $valor_datos_votacion['idvotacion'] ?>()" onmouseover="cambiarimagen(this, 1);"   style="height:100px; width:100px; cursor:pointer;" onmouseout="cambiarimagen(this, 2);"><img src="../../imagenes/botonvotacion.png" id="imagenboton"></div>
                    </TD>
                </TR>
            </table>
            <?php
        }

        $valido = true;
        $cadena_faltantes = "";

        if (isset($_POST['submitido'])) {
            //Adicion de isset para validacion de variable
            if (isset($_SESSION['tmptipovotante']) && ($_SESSION['tmptipovotante'] == 'directivo')) {
                unset($array_tipos_plantillas_votacion[2]);
            }

            echo "<br>";
            $contadortipoplantilla = 0;
            foreach ($array_tipos_plantillas_votacion as $llave_t => $valor_t) {
                if (isset($_POST["tipoplantilla_" . $array_tipos_plantillas_votacion[$contadortipoplantilla]["idtipoplantillavotacion"]])) {

                    if (is_array($array_plantillas_ampliado[$array_tipos_plantillas_votacion[$llave_t]["idtipoplantillavotacion"]]) || ($tipocandidato == 1) || ($tipocandidato == 3)) {
                        if ((!isset($_POST[$valor_t["idtipoplantillavotacion"]]))) {
                            if (is_array($array_tipos_plantillas_votacion[$contadortipoplantilla])) {
                                $nombretipoplantillavotacion = $array_tipos_plantillas_votacion[$contadortipoplantilla]["nombretipoplantillavotacion"];
                                $cadena_faltantes = $cadena_faltantes . '\n' . $nombretipoplantillavotacion;
                            }
                            $valido = false;
                        } else {
                            if ($_POST[$valor_t["idtipoplantillavotacion"]] <> '') {
                                $array_plantillas_seleccionadas[] = $_POST[$valor_t["idtipoplantillavotacion"]];
                            }
                        }
                        $contadortipoplantilla++;
                    }
                }
            }
            if ($valido == true) {
                $votacion->ingresaVotacion($_SESSION['datosvotante']['codigocarrera'], $_SESSION['datosvotante']['numerodocumento'], $array_datos_votacion[0]['idvotacion'], $array_plantillas_seleccionadas);
            } else {
                ?>
                <script language="javascript">alert('Falta votar en las siguientes plantillas:\n<?php echo $cadena_faltantes; ?>')</script>
                <?php
            }
        }
        ?>
    </body>
</html>
