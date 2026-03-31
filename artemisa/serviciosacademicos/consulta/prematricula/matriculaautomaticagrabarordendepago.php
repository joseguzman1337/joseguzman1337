<?php
    require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
    /**
     * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
     * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
     */
    Factory::validateSession($variables);

    /**
     * Si la aplicacion se corre en un entorno local o de pruebas se activa la visualizacion
     * de todos los errores de php
     */
    $pos = strpos($Configuration->getEntorno(), "local");
    if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas" || $pos !== false) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_WARNING);
        require_once(PATH_ROOT . '/kint/Kint.class.php');
    }
    $valormatriculainicial = 0;
    /* Los valores iniciales de las anteriores orden de pago, con el fin de efectuar la comparacion con la nueva orden si esta va a ser generada*/
    if ($codigomodalidadacademica != 100) {
        $query_ordenpago = "SELECT DISTINCT o.numeroordenpago, d.valorconcepto, d.codigoconcepto ".
        " FROM ordenpago o, detalleordenpago d, fechaordenpago f ".
        " where o.codigoestudiante = '".$codigoestudiante."' ".
        " and (o.codigoestadoordenpago like '4%' or o.codigoestadoordenpago like '1%') ".
        " and o.codigoperiodo = '".$codigoperiodo."' and f.numeroordenpago = o.numeroordenpago ".
        " and d.numeroordenpago = o.numeroordenpago and o.idsubperiodo = '".$idsubperiodo."' ".
        " and d.codigoconcepto = 151";
    } else {
        $query_ordenpago = "SELECT DISTINCT o.numeroordenpago, d.valorconcepto, d.codigoconcepto ".
        " FROM ordenpago o, detalleordenpago d, fechaordenpago f, prematricula p ".
        " where o.codigoestudiante = '".$codigoestudiante."' ".
        " and (o.codigoestadoordenpago like '4%' or o.codigoestadoordenpago like '1%') ".
        " and o.codigoperiodo = '".$codigoperiodo."' and f.numeroordenpago = o.numeroordenpago ".
        " and d.numeroordenpago = o.numeroordenpago and o.idsubperiodo = '".$idsubperiodo."' ".
        " and p.idprematricula = o.idprematricula ".
        " and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%' ".
        " and p.codigoperiodo = o.codigoperiodo)";
    }
    // Para el colegio se puede dejar asi mientras tanto, ya que la pensión se esta generando por este lado
    $ordenpagosel = mysql_query($query_ordenpago, $sala) or die(mysql_error());
    $totalRows_ordenpago = mysql_num_rows($ordenpagosel);

    // Si tiene una orden de pago activa entra a comparar los datos de la nueva con las anteriores
    // Si no la tiene activa debe generar una nueva orden
    while ($row_ordenpago = mysql_fetch_assoc($ordenpagosel)) {
        $numeroordenpagoinicial = $row_ordenpago['numeroordenpago'];
        $valorordenpagoinicial = $row_ordenpago['valorfechaordenpago'];
        $totaldevoluciones = 0;
        $query_conceptoinicial = "SELECT d.valorconcepto FROM detalleordenpago d ".
        " where d.numeroordenpago = '".$numeroordenpagoinicial."' ".
        " and d.codigoconcepto = '151'";

        $conceptoinicial = mysql_query($query_conceptoinicial, $sala) or die(mysql_error());
        $row_conceptoinicial = mysql_fetch_assoc($conceptoinicial);
        $totalRows_conceptoinicial = mysql_num_rows($conceptoinicial);
        // Suma el valor de todos los conceptos de matricula, si el valor nuevo supera esta suma se genera nueva orden
        $valormatriculainicial = $valormatriculainicial + $row_conceptoinicial['valorconcepto'];

        //anular ordenes con consepto 151 sin carga academica
        $SQL = "SELECT d.numeroordenpago FROM detalleordenpago d  ".
        " INNER JOIN detalleprematricula dp ON dp.numeroordenpago=d.numeroordenpago ".
        " WHERE d.numeroordenpago='".$numeroordenpagoinicial."' ";
        $OrdenCargaAcdemica = mysql_query($SQL, $sala) or die(mysql_error());
        $totalRows = mysql_num_rows($OrdenCargaAcdemica);

        if ($totalRows < 1 || $totalRows == '') {
            $SQL = "UPDATE ordenpago SET codigoestadoordenpago=20 ".
            " WHERE  numeroordenpago='".$numeroordenpagoinicial."' ";
            $OrdenCargaAcdemica = mysql_query($SQL, $sala) or die(mysql_error());
            exit();
        }
    }//while

    // Al valor de la matricula inicial le resto el valor de las devoluciones si las hay
    if ($codigomodalidadacademica != 100) {
        $query_devoluciones = "select od.valordevolucionsap from ordenpagodevolucion od, estudiante e, ordenpago o ".
        " where o.codigoestudiante = e.codigoestudiante and o.numeroordenpago = od.numeroordenpago ".
        " and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%') ".
        " and o.codigoperiodo = '".$codigoperiodo."' and o.codigoestudiante = '".$codigoestudiante."'";
    } else {
        $query_devoluciones = "select od.valordevolucionsap from ordenpagodevolucion od, estudiante e, ordenpago o ".
        " where o.codigoestudiante = e.codigoestudiante and o.numeroordenpago = od.numeroordenpago ".
        " and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%') ".
        " and o.codigoperiodo = '".$codigoperiodo."' and o.codigoestudiante = '".$codigoestudiante."'";
    }

    $devoluciones = mysql_query($query_devoluciones, $sala) or die("$query_devoluciones " . mysql_error());
    $totalRows_devoluciones = mysql_num_rows($devoluciones);
    if ($totalRows_devoluciones != "") {
        while ($row_devoluciones = mysql_fetch_assoc($devoluciones)) {
            $totaldevolver = $totaldevolver + $row_devoluciones['valordevolucionsap'];
        }
        $valormatriculainicial = $valormatriculainicial - $totaldevolver;
    }

    $generarnuevaorden = false;
    if ($codigomodalidadacademica != 100) {
        if ($procesoautomatico) {
            require("../comparacionordenpago.php");
        } else {
            require("comparacionordenpago.php");
        }

        //Generarnuevaorden
        if ($generarnuevaorden) {
            if (!$procesoautomatico && !$procesoautomaticotodos) {
                require("generarygrabarnuevaorden.php");

                $generacionOrdenSucess = true;

                $orden->enviarsap_orden($idgrupofinal);
                ?>

                <?php if($generacionOrdenSucess): ?>       
           
                <script language="javascript"> 
                    alert("Se le ha generado una nueva orden de pago, por favor reclamela en CREDITO Y CARTERA");
                </script>           
          
                   <?php
                   if ($_GET['documentoingreso'] == "") {
                       echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=solicitudcredito.php?ordenpago=$numeroordenpago'>";
                   } else {
                       echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=" . $_GET['documentoingreso'] . "&logincorrecto'>";
                   }
                   ?>

                <?php else: echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomaticaordenmatricula.php'>"; ?>

                <?php endif; ?>

            <?php    

            } else {
                require("../generarygrabarnuevaorden.php");
                require("../../../funciones/open.php");
                $orden->enviarsap_orden();
                $orden->enviarsap_orden($idgrupofinal);
                if (!$procesoautomaticotodos) {
                    ?>
                    <script language="javascript">
                        alert("Se le ha generado una nueva orden de pago, por favor reclamela en CREDITO Y CARTERA");
                    </script>
                    <?php

                    echo '<script language="javascript">
				    window.location.href="../matriculaautomaticaordenmatricula.php";
				    </script>';
                }
            }
        } else {
            $query_estadoordenpago = "SELECT codigoestadoordenpago FROM ordenpago ".
		    " where codigoestudiante = '".$codigoestudiante."' and numeroordenpago = '".$numeroordenpagoinicial."'";
            $estadoordenpago = mysql_query($query_estadoordenpago, $sala) or die("$query_estadoordenpago");
            $totalRows_estadoordenpago = mysql_num_rows($estadoordenpago);
            $row_estadoordenpago = mysql_fetch_assoc($estadoordenpago);
            $estadoorden1 = $row_estadoordenpago['codigoestadoordenpago'];

            if ($estadoorden1 == 10 || $estadoorden1 == 11) {
                $query_upddetalleprem1 = "UPDATE detalleprematricula set codigoestadodetalleprematricula = '10' ".
                " where numeroordenpago = '".$numeroordenpago."'";
                $upddetalleprem = mysql_query($query_upddetalleprem1, $sala) or die("$query_upddetalleprem1");

                $query_dellogdetalleprematricula = "UPDATE logdetalleprematricula set codigoestadodetalleprematricula = '10' ".
                " where numeroordenpago = '".$numeroordenpagoinicial."'";
                $dellogdetalleprematricula = mysql_query($query_dellogdetalleprematricula, $sala) or die("$query_dellogdetalleprematricula");
            } else if ($estadoorden1 == 40 || $estadoorden1 == 41) {
                $query_upddetalleprem2 = "UPDATE detalleprematricula set codigoestadodetalleprematricula = '30' ".
                " where numeroordenpago = '".$numeroordenpago."'";
                $upddetalleprem = mysql_query($query_upddetalleprem2, $sala) or die("$query_upddetalleprem2");

                $query_dellogdetalleprematricula = "UPDATE logdetalleprematricula set codigoestadodetalleprematricula = '30' ".
                " where numeroordenpago = '".$numeroordenpago."'";
                $dellogdetalleprematricula = mysql_query($query_dellogdetalleprematricula, $sala) or die("$query_dellogdetalleprematricula");
            }
            $query_detallepre = "UPDATE detalleprematricula set numeroordenpago = '".$numeroordenpagoinicial."' ".
		    " where numeroordenpago = '".$numeroordenpago."'";
            $upddeta = mysql_query($query_detallepre, $sala) or die("$query_detallepre");

            $query_updlogdetalleprematricula = "UPDATE logdetalleprematricula set numeroordenpago = '".$numeroordenpagoinicial."' ".
		    " where numeroordenpago = '".$numeroordenpago."'";
            $updlogdetalleprematricula = mysql_query($query_updlogdetalleprematricula, $sala) or die("$query_updlogdetalleprematricula");

            $query_delordenpago = "update ordenpago set codigoestadoordenpago = 20 where numeroordenpago = '".$numeroordenpago."'";
            $delordenpago = mysql_query($query_delordenpago, $sala) or die(mysql_error() . " $query_delordenpago");
            $numeroordenpagoget = $numeroordenpagoinicial;

            if (!$procesoautomatico) {
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomaticaordenmatricula.php'>";
            } else {
                if (!$procesoautomaticotodos) {
                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../matriculaautomaticaordenmatricula.php'>";
                }
            }
        }
    } else {
        require('matriculaautomaticaguardarcolegio.php');
    }
