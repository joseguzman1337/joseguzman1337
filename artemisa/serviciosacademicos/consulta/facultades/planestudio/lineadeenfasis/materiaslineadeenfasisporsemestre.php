<?php

is_file(dirname(__FILE__) . "/../../../../../sala/includes/adaptador.php")
? require_once(dirname(__FILE__) . "/../../../../../sala/includes/adaptador.php")
: require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

if(!isset($_SESSION['MM_Username'])){
    session_start();
}
is_file(dirname(__FILE__) ."/../../../../utilidades/ValidarSesion.php")
? include_once(dirname(__FILE__) .'/../../../../utilidades/ValidarSesion.php')
: include_once(realpath(dirname(__FILE__) .'/../../../../utilidades/ValidarSesion.php'));
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once('../../../../Connections/sala2.php');
require_once("../../../../funciones/validacion.php");
require_once("../../../../funciones/errores_plandeestudio.php");
require("../funcionesequivalencias.php");

if (isset($_GET['planestudio']) && !empty($_GET['planestudio'])) {
    $idplanestudio = $_GET['planestudio'];
    $idlineaenfasis = rtrim($_GET['lineaenfasis'], ".");
    $estaEnenfasis = "si";
    if(isset($_GET['lineamodificar']) && !empty($_GET['lineamodificar'])){
        $idlineamodificar = $_GET['lineamodificar'];
    }
}
$formulariovalido = 1;
?>
<html>
    <head>
        <title>Materias con línea de enfasis por semestre</title>
    </head>
    <style type="text/css">
        <!--
        .Estilo1 {
            font-family: Tahoma;
            font-size: x-small;
        }
        .Estilo2 {
            font-family: sans-serif;
            font-size: 9px;
            text-align: center;
        }
        .Estilo3 {
            font-family: sans-serif;
            font-size: 9px;
            width: 9px;
        }
        -->
    </style>
    <?php
    echo'<script language="javascript">
        function recargar2(dir){
            window.location.href="../../materiasgrupos/detallesmateria.php"+dir+"&planestudio=' .
        $idplanestudio . '&lineaenfasis=' . $idlineaenfasis . '&visualizado";
        }
    </script>';
    ?>
    <script language="javascript">
        function recargar(dir){
            window.location.href = "materiaslineadeenfasisporsemestre.php?" + dir;
        }
    </script>
    <body>
        <div align="center">
            <form name="f1" method="post" action="materiaslineadeenfasisporsemestre.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis&lineamodificar=$idlineamodificar"; ?>">
                <?php
                // Selecciona toda la informacion del plan de estudio
                $query_planestudio = "select p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio, ".
                " p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio, ".
                " c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre, ".
                " p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio, l.nombrelineaenfasisplanestudio ".
                " from planestudio p, carrera c, tipocantidadelectivalibre t, lineaenfasisplanestudio l ".
                " where p.codigocarrera = c.codigocarrera ".
                " and p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre ".
                " and l.idplanestudio = p.idplanestudio ".
                " and p.idplanestudio = '$idplanestudio' ".
                " and l.idlineaenfasisplanestudio = '$idlineaenfasis'";
                $row_planestudio = $db->GetRow($query_planestudio);

                if (!isset($_REQUEST['tipodereferencia']) && empty($_REQUEST['tipodereferencia'])) {
                    require_once("pensumseleccionreferenciaconlineaenfasis.php");
                }
                if (isset($_REQUEST['tipodereferencia']) && !empty($_REQUEST['tipodereferencia'])) {
                    $Vartipodereferencia = $_REQUEST['tipodereferencia'];
                    $Varcodigodemateria = $_REQUEST['codigodemateria'];
                    $query_referenciasmateria = "select m.nombremateria from materia m ".
                    " where m.codigomateria = '$Varcodigodemateria'";
                    $row_referenciasmateria = $db->GetRow($query_referenciasmateria);

                    if ($Vartipodereferencia == 100) {
                        $query_selprerequisitos = "select codigomateriareferenciaplanestudio, ".
                        " fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio ".
                        " from referenciaplanestudio where idplanestudio = '$idplanestudio' ".
                        " and codigomateria = '$Varcodigodemateria' ".
                        " and idlineaenfasisplanestudio = '$idlineamodificar' ".
                        " and codigotiporeferenciaplanestudio = '100'";
                        $selprerequisitos = $db->GetAll($query_selprerequisitos);
                        $totalRows_selprerequisitos = count($selprerequisitos);
                        if ($totalRows_selprerequisitos != "") {
                            foreach($selprerequisitos as $row_selprerequisitos) {
                                $Arregloprerequisitos[] = $row_selprerequisitos;
                                $fechainicio = $row_selprerequisitos['fechainicioreferenciaplanestudio'];
                                $fechavencimiento = $row_selprerequisitos['fechavencimientoreferenciaplanestudio'];
                            }
                        }
                        if (isset($_REQUEST['editar']) && !empty($_REQUEST['editar'])) {
                            $limite = $_REQUEST['editar'];
                            require_once("../pensumprerequisitoseditar.php");
                        }
                        if (isset($_REQUEST['visualizar']) && !empty($_REQUEST['visualizar'])) {
                            $limite = $_REQUEST['visualizar'];
                            require_once("../pensumprerequisitosvisualizar.php");
                        }
                    }
                    if ($Vartipodereferencia == 200) {
                        $query_selcorequisitos = "select codigomateriareferenciaplanestudio, ".
                        " fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio ".
                        " from referenciaplanestudio ".
                        " where idplanestudio = '$idplanestudio' and codigomateria = '$Varcodigodemateria' ".
                        " and idlineaenfasisplanestudio = '$idlineamodificar' ".
                        " and codigotiporeferenciaplanestudio = '200'";
                        $selcorequisitos = $db->GetAll($query_selcorequisitos);
                        $totalRows_selcorequisitos = count($selcorequisitos);
                        if ($totalRows_selcorequisitos != "") {
                            foreach($selcorequisitos as $row_selcorequisitos) {
                                $Arreglocorequisitos[] = $row_selcorequisitos;
                                $fechainicio = $row_selcorequisitos['fechainicioreferenciaplanestudio'];
                                $fechavencimiento = $row_selcorequisitos['fechavencimientoreferenciaplanestudio'];
                            }
                        }
                        if (isset($_REQUEST['editar']) && !empty($_REQUEST['editar'])) {
                            $limite = $_REQUEST['editar'];
                            require_once("../pensumcorequisitoseditar.php");
                        }
                        if (isset($_REQUEST['visualizar']) && !empty($_REQUEST['visualizar'])) {
                            $limite = $_REQUEST['visualizar'];
                            require_once("../pensumcorequisitosvisualizar.php");
                        }
                    }
                    if ($Vartipodereferencia == 201) {
                        $query_selcorequisitosencillo = "select codigomateriareferenciaplanestudio, ".
                        " fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio ".
                        " from referenciaplanestudio where idplanestudio = '$idplanestudio' ".
                        " and codigomateria = '$Varcodigodemateria' ".
                        " and idlineaenfasisplanestudio = '$idlineamodificar' ".
                        " and codigotiporeferenciaplanestudio = '201'";
                        $row_selcorequisitosencillo = $db->GetAll($query_selcorequisitosencillo);

                        if(count($row_selcorequisitosencillo) >0){
                            foreach($row_selcorequisitosencillo as $row) {
                                $Arreglocorequisitosencillo[] = $row;
                                $fechainicio = $row['fechainicioreferenciaplanestudio'];
                                $fechavencimiento = $row['fechavencimientoreferenciaplanestudio'];
                            }
                        }
                        if (isset($_REQUEST['editar']) && !empty($_REQUEST['editar'])) {
                            $limite = $_REQUEST['editar'];
                            require_once("../pensumcorequisitosencilloeditar.php");
                        }
                        if (isset($_REQUEST['visualizar']) && !empty($_REQUEST['visualizar'])) {
                            $limite = $_REQUEST['visualizar'];
                            require_once("../pensumcorequisitosencillovisualizar.php");
                        }
                    }
                    if ($Vartipodereferencia == 300) {
                        $query_selequivalencias = "select codigomateriareferenciaplanestudio, ".
                        " fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio ".
                        " from referenciaplanestudio where idplanestudio = '$idplanestudio' ".
                        " and codigomateria = '$Varcodigodemateria' ".
                        " and idlineaenfasisplanestudio = '$idlineamodificar' ".
                        " and codigotiporeferenciaplanestudio = '300'";
                        $selequivalencias = $db->GetAll($query_selequivalencias);
                        $totalRows_selequivalencias = count($selequivalencias);
                        if ($totalRows_selequivalencias != "") {
                            foreach ($selequivalencias as $row_selequivalencias) {
                                $Arregloequivalencias[] = $row_selequivalencias['codigomateriareferenciaplanestudio'];
                                $fechainicio = $row_selequivalencias['fechainicioreferenciaplanestudio'];
                                $fechavencimiento = $row_selequivalencias['fechavencimientoreferenciaplanestudio'];
                            }
                        } else {
                            $fechainicio = "";
                            $fechavencimiento = "";
                        }
                        if (isset($_GET['editar']) || isset($_POST['editar'])) {
                            if (isset($_GET['editar'])) {
                                $limite = $_GET['editar'];
                            }
                            if (isset($_POST['editar'])) {
                                $limite = $_POST['editar'];
                            }
                            require_once("../pensumequivalenciaseditar.php");
                        }
                        if (isset($_GET['visualizar']) || isset($_POST['visualizar'])) {
                            if (isset($_GET['visualizar'])) {
                                $limite = $_GET['visualizar'];
                            }
                            if (isset($_POST['visualizar'])) {
                                $limite = $_POST['visualizar'];
                            }
                            require_once("../pensumequivalenciasvisualizar.php");
                        }
                    }
                }

                if (isset($_POST['aceptarprerequisitos']) && !empty($_POST['aceptarprerequisitos'])
                    && $formulariovalido == 1) {
                    $tieneprerequisitos = false;

                    // Lee las materias que vienen por el post
                    foreach ($_POST as $key => $materiareferencia) {
                        if (preg_match("/^prerequisito/", $key)) {
                            $prerequisitosescogidos[] = $materiareferencia;
                            $tieneprerequisitos = true;
                        }

                        if (preg_match("/^bprerequisito/", $key)) {
                            $bprerequisitosescogidos[] = $materiareferencia;
                            $tieneprerequisitos = true;
                        }
                    }

                    if (!$tieneprerequisitos) {
                        ?>
                        <script language="javascript">
                            if (!confirm("¿Desea dejar sin prerequisitos a la materia?")){
                                history.go(-1);
                            }
                        </script>
                        <?php
                    }
                    //elimina las materias activas de la materia prerequisito
                    $query_delreferenciaplanestudio = "DELETE FROM referenciaplanestudio ".
                    " WHERE idplanestudio = '$idplanestudio' ".
                    " and idlineaenfasisplanestudio = '$idlineamodificar' ".
                    " and codigomateria = '" . $_POST['codigodemateria'] . "' ".
                    " and codigotiporeferenciaplanestudio = '100' ";

                    if ((isset($bprerequisitosescogidos) && $bprerequisitosescogidos != null)
                        || (isset($bprerequisitosescogidos) && !empty($bprerequisitosescogidos))) {
                        $materias = "";
                        foreach ($bprerequisitosescogidos as $key => $materiareferencia2) {
                            $materias .= $materiareferencia2 . ',';
                        }
                        $tmaterias = substr($materias, 0, -1);
                        $query_delreferenciaplanestudio .= "and codigomateriareferenciaplanestudio IN (".$tmaterias.")";
                    }
                    $delreferenciaplanestudio = $db->Execute($query_delreferenciaplanestudio);

                    //Inserta las materias que vienen por el post que son prerequisitos de $_POST['codigodemateria']
                    if ($tieneprerequisitos) {
                        foreach ($prerequisitosescogidos as $key => $materiareferencia2) {
                            $query_insreferenciaplanestudio = "INSERT INTO referenciaplanestudio(idplanestudio, ".
                            " idlineaenfasisplanestudio, codigomateria, codigomateriareferenciaplanestudio, ".
                            " codigotiporeferenciaplanestudio, fechacreacionreferenciaplanestudio, ".
                            " fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio, ".
                            " codigoestadoreferenciaplanestudio) ".
                            " VALUES('$idplanestudio', '$idlineamodificar', '" . $_POST['codigodemateria'] .
                            "', '$materiareferencia2', '100', '" . date("Y-m-d") . "', '" .
                            $_POST['finicioprerequisito'] . "', '" . $_POST['fvencimientoprerequisito'] . "', '101')";
                            $insreferenciaplanestudio = $db->Execute($query_insreferenciaplanestudio);
                        }
                    }
                    echo '<script language="javascript">
                    window.location.href="materiaslineadeenfasisporsemestre.php?planestudio=' .
                        $idplanestudio . '&codigodemateria=' . $Varcodigodemateria . '&tipodereferencia=' .
                        $Vartipodereferencia . '&visualizar=' . $limite . '&lineaenfasis=' . $idlineaenfasis
                        . '&lineamodificar=' . $idlineamodificar . '";
                    </script>';
                }
                if (isset($_POST['aceptarcorequisitos']) && !empty($_POST['aceptarcorequisitos'])
                    && $formulariovalido == 1) {
                    $tienecorequisitos = false;

                    // Lee las materias que vienen por el post
                    foreach ($_POST as $key => $materiareferencia) {
                        if (preg_match("/^corequisito/", $key)) {
                            $corequisitosescogidos[] = $materiareferencia;
                            $tienecorequisitos = true;
                        }
                    }
                    if (!$tienecorequisitos) {
                        ?>
                        <script language="javascript">
                            if (!confirm("¿Desea dejar sin corequisitos a la materia?")){
                                history.go(-1);
                            }
                        </script>
                        <?php
                    }
                    // Elimina todas las materias corequisitos de $_POST['codigodemateria'].
                    $query_delreferenciaplanestudio = "DELETE FROM referenciaplanestudio ".
                    " WHERE idplanestudio = '$idplanestudio' ".
                    " and idlineaenfasisplanestudio = '$idlineamodificar' ".
                    " and codigomateria = '" . $_POST['codigodemateria'] . "' ".
                    " and codigotiporeferenciaplanestudio = '200' ";
                    $delreferenciaplanestudio = $db->Execute($query_delreferenciaplanestudio);

                    //Inserta las materias que vienen por el post que son prerequisitos de $_POST['codigodemateria']
                    if ($tienecorequisitos) {
                        foreach ($corequisitosescogidos as $key => $materiareferencia2) {
                            $query_insreferenciaplanestudio = "INSERT INTO referenciaplanestudio(idplanestudio, ".
                            " idlineaenfasisplanestudio, codigomateria, codigomateriareferenciaplanestudio, ".
                            " codigotiporeferenciaplanestudio, fechacreacionreferenciaplanestudio, ".
                            " fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio, ".
                            " codigoestadoreferenciaplanestudio) ".
                            " VALUES('$idplanestudio', '$idlineamodificar', '" . $_POST['codigodemateria'] .
                            "', '$materiareferencia2', '200', '" . date("Y-m-d") . "', '" .
                            $_POST['finiciocorequisito'] . "', '" . $_POST['fvencimientocorequisito'] . "', '101')";
                            $insreferenciaplanestudio = $db->Execute($query_insreferenciaplanestudio);
                        }
                    }
                    echo '<script language="javascript">
                    window.location.href="materiaslineadeenfasisporsemestre.php?planestudio=' .
                        $idplanestudio . '&codigodemateria=' . $Varcodigodemateria . '&tipodereferencia=' .
                        $Vartipodereferencia . '&visualizar=' . $limite . '&lineaenfasis=' . $idlineaenfasis .
                        '&lineamodificar=' . $idlineamodificar . '";
                    </script>';
                }
                if (isset($_POST['aceptarcorequisitosencillo']) && !empty($_POST['aceptarcorequisitosencillo'])
                    && $formulariovalido == 1) {
                    $tienecorequisitos = false;

                    // Lee las materias que vienen por el post
                    foreach ($_POST as $key => $materiareferencia) {
                        if (preg_match("/^cosencillo/", $key)) {
                            $corequisitosescogidos[] = $materiareferencia;
                            $tienecorequisitos = true;
                        }
                    }
                    if (!$tienecorequisitos) {
                        ?>
                        <script language="javascript">
                            if (!confirm("¿Desea dejar sin corequisitos a la materia?")){
                                history.go(-1);
                            }
                        </script>
                        <?php
                    }
                    // Elimina todas las materias corequisitos de $_POST['codigodemateria'].
                    $query_delreferenciaplanestudio = "DELETE FROM referenciaplanestudio ".
                        " WHERE idplanestudio = '$idplanestudio' ".
                        " and idlineaenfasisplanestudio = '$idlineamodificar' ".
                        " and codigomateria = '" . $_POST['codigodemateria'] . "' ".
                        " and codigotiporeferenciaplanestudio = '201' ";
                    $delreferenciaplanestudio = $db->Execute($query_delreferenciaplanestudio);

                    //Inserta las materias que vienen por el post que son prerequisitos de $_POST['codigodemateria']
                    if ($tienecorequisitos) {
                        foreach ($corequisitosescogidos as $key => $materiareferencia2) {
                            $query_insreferenciaplanestudio = "INSERT INTO referenciaplanestudio(idplanestudio, ".
                                " idlineaenfasisplanestudio, codigomateria, codigomateriareferenciaplanestudio, ".
                                " codigotiporeferenciaplanestudio, fechacreacionreferenciaplanestudio, ".
                                " fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio, ".
                                " codigoestadoreferenciaplanestudio) ".
                                " VALUES('$idplanestudio', '$idlineamodificar', '" . $_POST['codigodemateria'] .
                                "', '$materiareferencia2', '201', '" . date("Y-m-d") . "', '" .
                                $_POST['finiciocorequisito'] . "', '" . $_POST['fvencimientocorequisito'] . "', '101')";
                            $insreferenciaplanestudio = $db->Execute($query_insreferenciaplanestudio);
                        }
                    }
                    echo '<script language="javascript">
                    window.location.href="materiaslineadeenfasisporsemestre.php?planestudio=' .
                        $idplanestudio . '&codigodemateria=' . $Varcodigodemateria . '&tipodereferencia=' .
                        $Vartipodereferencia . '&visualizar=' . $limite . '&lineaenfasis=' . $idlineaenfasis .
                        '&lineamodificar=' . $idlineamodificar . '";
                    </script>';
                }
                if (isset($_POST['aceptarequivalencias']) && !empty($_POST['aceptarequivalencias'])
                    && $formulariovalido == 1) {
                    $tieneequivalencias = false;

                    // Lee las materias que vienen por el post
                    if (isset($_POST['equivalencia'])) {
                        foreach ($_POST['equivalencia'] as $key => $materiareferencia) {
                            $equivalenciasescogidas[] = $materiareferencia;
                            $tieneequivalencias = true;
                        }
                    }
                    if (!$tieneequivalencias) {
                        ?>
                        <script language="javascript">
                            if (!confirm("¿Desea dejar sin equivalencias a la materia?")){
                                history.go(-1);
                            }
                        </script>
                        <?php
                    }
                    // Elimina todas las materias equivalentes
                    $query_delreferenciaplanestudio = "DELETE FROM referenciaplanestudio ".
                    " WHERE idplanestudio = '$idplanestudio' ".
                    " and idlineaenfasisplanestudio = '$idlineamodificar' ".
                    " and codigomateria = '" . $_POST['codigodemateria'] . "' ".
                    " and codigotiporeferenciaplanestudio = '300'";
                    $delreferenciaplanestudio = $db->Execute($query_delreferenciaplanestudio);

                    //Inserta las materias que vienen por el post que son equivalentes de $_POST['codigodemateria']
                    if ($tieneequivalencias) {
                        foreach ($equivalenciasescogidas as $key => $materiareferencia2) {
                            $query_insreferenciaplanestudio = "INSERT INTO referenciaplanestudio(idplanestudio, ".
                            " idlineaenfasisplanestudio, codigomateria, codigomateriareferenciaplanestudio, ".
                            " codigotiporeferenciaplanestudio, fechacreacionreferenciaplanestudio, ".
                            " fechainicioreferenciaplanestudio, fechavencimientoreferenciaplanestudio, ".
                            " codigoestadoreferenciaplanestudio) ".
			                " VALUES('$idplanestudio', '$idlineamodificar', '" . $_POST['codigodemateria'] .
                            "', '$materiareferencia2', '300', '" . date("Y-m-d") . "', '" .
                            $_POST['finiciocorequisito'] . "', '" . $_POST['fvencimientocorequisito'] . "', '101')";
                            $insreferenciaplanestudio = $db->Execute($query_insreferenciaplanestudio);
                        }
                    }
                    echo '<script language="javascript">
                    window.location.href="materiaslineadeenfasisporsemestre.php?planestudio=' . $idplanestudio .
                    '&codigodemateria='.$Varcodigodemateria.'&tipodereferencia='.$Vartipodereferencia.
                    '&visualizar='.$limite.'&lineaenfasis='.$idlineaenfasis.'&lineamodificar='.$idlineamodificar . '";
                    </script>';
                }
                ?>
            </form>
        </div>
    </body>
    <script language="javascript">
    //Mueve las opciones seleccionadas en listaFuente a listaDestino
        function regresarinicio(){
            window.location.href = "plandeestudioinicial.php"
        }

        function limpiarinicio(texto){
            if (texto.value == "aaaa-mm-dd")
                texto.value = "";
        }

        function limpiarvencimiento(texto){
            if (texto.value == "2999-12-31")
                texto.value = "";
        }

        function iniciarinicio(texto){
            if (texto.value == "")
                texto.value = "aaaa-mm-dd";
        }

        function iniciarvencimiento(texto){
            if (texto.value == "")
                texto.value = "2999-12-31";
        }
    </script>
</html>
