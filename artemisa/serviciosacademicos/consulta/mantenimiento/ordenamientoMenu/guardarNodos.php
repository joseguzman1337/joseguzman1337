<?php

$rutaado = "../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');

$posInicial = explode(",", $_GET['posActualArray']);
$posInicialElementos = array_merge(array_unique($posInicial));
$items = explode(",", $_GET['saveString']);
$compArray = array();
$i = 0;
$z = 0;
for ($no = 0; $no < count($items); $no++) {
    $tokens = explode("-", $items[$no]);
    foreach ($tokens as $compare) {
        $compArray[$i] = $compare;
        $i = $i + 1;
    }
    if ($posInicialElementos[$no] === $tokens[0]) {
        $query_buscaposicionNue = "SELECT posicionmenuopcion,idpadremenuopcion FROM menuopcion WHERE  idmenuopcion = '$tokens[0]'; ";
        $queryResult = $sala->query($query_buscaposicionNue);
        $pos = $queryResult->fetchRow($operacion);
        $posicion = $pos['posicionmenuopcion'];
        $idpadre = $pos['idpadremenuopcion'];
        if ($tokens[1] == 2) {
            $idpadre = 0;
        } else {
            $idpadre = $tokens[1];
        }
        $query_actualiza = "UPDATE 
                    menuopcion set idpadremenuopcion = '" . $idpadre . "', posicionmenuopcion='" . $z . "', codigotipomenuopcion=2
                WHERE idmenuopcion='" . $tokens[0] . "'
                ";
        $operacion = $sala->query($query_actualiza);
    } else {
        $query_buscaposicionNue = "SELECT posicionmenuopcion,idpadremenuopcion FROM menuopcion WHERE  idmenuopcion = '$posInicialElementos[$no]'; ";
        $queryResultNue = $sala->query($query_buscaposicionNue);
        $posicionNue = $queryResultNue->fetchRow($queryResultNue);
        $posicionNuev = $posicionNue['posicionmenuopcion'];
        $idpadre = $posicionNuev['idpadremenuopcion'];
        if ($tokens[1] == 2) {
            $idpadre = 0;
        } else {
            $idpadre = $tokens[1];
        }
        $query_actualizaAnt = "UPDATE 
            menuopcion set idpadremenuopcion = '" . $idpadre . "', posicionmenuopcion='" . $z . "', codigotipomenuopcion=2
	WHERE idmenuopcion='" . $tokens[0] . "'
	";
        $operacion = $sala->query($query_actualizaAnt);
    }
    $z = $z + 1;
}

$repetidosArray = repeatedElements($compArray);
foreach ($repetidosArray as $item => $value) {
    if ($value['value'] <> 2) {
        $queryActualizaPadre = "UPDATE 
	menuopcion set codigotipomenuopcion = 1
	WHERE idmenuopcion='" . $value['value'] . "'
	";
        $operacion = $sala->query($queryActualizaPadre);
    }
}

//Función para sacar valores repetidos 
function repeatedElements($array, $returnWithNonRepeatedItems = false) {
    $repeated = array();
    foreach ((array) $array as $value) {
        $inArray = false;

        foreach ($repeated as $i => $rItem) {
            if ($rItem['value'] === $value) {
                $inArray = true;
                ++$repeated[$i]['count'];
            }
        }

        if (false === $inArray) {
            $i = count($repeated);
            $repeated[$i] = array();
            $repeated[$i]['value'] = $value;
            $repeated[$i]['count'] = 1;
        }
    }

    if (!$returnWithNonRepeatedItems) {
        foreach ($repeated as $i => $rItem) {
            if ($rItem['count'] === 1) {
                unset($repeated[$i]);
            }
        }
    }

    sort($repeated);

    return $repeated;
}

?>