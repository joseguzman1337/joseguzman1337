<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hace el formateo de codigo. 
 * @since Abril 25, 2019
 */
include '../../EspacioFisico/templates/template.php';
$db = getBD();

if ($_POST['action'] == 'consultaFacultades') {
    $valida = new validarFacultad();
    $valida->consultaFacultad($db, $_POST['facultades']);
}

class validarFacultad {

    public function consultaFacultad($db, $arrayFacultades) {

        $SQL = 'SELECT codigofacultad,
            nombrefacultad
            FROM facultad 
            WHERE codigoestado=100  ';

        if ($Consulta = &$db->Execute($SQL) === false) {
            $a_vectt['val'] = false;
            $a_vectt['descrip'] = 'Error al Buscar..';
            echo json_encode($a_vectt);
            exit;
        }

        $Result = $Consulta->GetArray();

        $arraySinCandi = array();
        foreach ($Result as $facultades) {
            $encontrado = false;
            foreach ($arrayFacultades as $arrFac) {
                if ($facultades['codigofacultad'] == $arrFac) {
                    $encontrado = true;
                }
            }
            if ($encontrado == false) {
                $arraySinCandi[] = $facultades['nombrefacultad'];
            }
        }

        echo "<b>Las siguientes facultades faltan por inscribir candidatos: </b><ul>";
        foreach ($arraySinCandi as $sinCandidatos) {
            if ($sinCandidatos !== 'DEPARTAMENTO DE BIOÉTICA')
                echo "<li>" . $sinCandidatos . "</li>";
        }
        echo "</ul>";
    }

}
?>