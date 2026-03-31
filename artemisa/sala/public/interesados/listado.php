<?php
function ListadoPaices(){
    require_once(realpath(dirname(__FILE__)."/../../entidad/Pais.php"));
    $pais = new Pais();
    $orderpais = "nombrepais asc";
    $datosPais = $pais::getList('', $orderpais);
    $selectCiudad = '<select id="Pais" type="text" name="Pais" class="chosen-select form-control" onchange="ValidarExtranjero()" >'
        .'<option value="0" selected hidden>Seleccione Pais</option>';
    foreach($datosPais as $listaPais){
        $selectCiudad .= "<option value ='{$listaPais->getIdPais()}'>" .
            " {$listaPais->getNombrePais()}</option>";
    }
    $selectCiudad.= '</select>';
    return $selectCiudad;
}

function nombreDepartamento($idpepartamento){
    require_once(realpath(dirname(__FILE__)."/../../entidad/Departamento.php"));
    $departamento = new Departamento();
    //asignacion de id departamento
    $where = " idpais=1 ";
    $departamento->setDb();
    $departamento->setIdDepartamento($idpepartamento);
    //consulta de detalles de departamento
    $departamento->getById($where);
    return $departamento->getNombreDepartamento();
}

function listaCiudades($idpais = null){
    require_once(realpath(dirname(__FILE__)."/../../entidad/Ciudad.php"));
    $ciudad = new Ciudad();
    //consulta de ciudades
    if(!empty($idpais)) {
        $wherepais = "and idpais= $idpais";
    } else{
        $wherepais ="";
    }
    $whereciudad = "codigoestado = '100' and iddepartamento <> 216 $wherepais";
    $orderciudad = "iddepartamento, nombreciudad";
    $datosCiudad = $ciudad::getList($whereciudad,$orderciudad);
    $selectCiudad = '<select id="Ciudad" type="text" name="Ciudad" class="chosen-select form-control-lg" required="true">'
        .'<option value="" selected hidden>Seleccione Ciudad</option>';
    foreach($datosCiudad as $listaCiudad){
        $departamentonombre = nombreDepartamento($listaCiudad->getIdDepartamento());
        if(!empty($departamentonombre)) {
            $selectCiudad .= "<option value ='{$listaCiudad->getCodigoSapCiudad()}'>" .
                " $departamentonombre - {$listaCiudad->getNombreCiudad()}</option>";
        }
    }
    $selectCiudad.= '</select>';
    return $selectCiudad;
}

function listaCarreras($sqlcarrera, $likecarrera){
    require_once(realpath(dirname(__FILE__)."/../../entidad/Carrera.php"));
    $carrera = new Carrera();
    $wherecarrera = " codigomodalidadacademica = '400' AND fechavencimientocarrera > now() "
        ." AND codigocarrera <> '1343' AND codigofacultad <> '110' $sqlcarrera "
        ." AND nombrecarrera like '%$likecarrera%'";
    $ordercarrera = "nombrecarrera";
    $groupcarrera = "codigofacultad, fechavencimientocarrera";
    $datoscarrera = $carrera::getList($wherecarrera, $ordercarrera, $groupcarrera);
    $contadorCarerras = count($datoscarrera);
    $selectCarrera = "";
    if($contadorCarerras >1){
        $selectCarrera = '<select id="Programa" type="text" id="Programa" name="Programa" '.
            'class="chosen-select form-control-lg" required="true">'.
            '<option value="" selected hidden>Seleccione Programa</option>';

        foreach ($datoscarrera as $listaCarrera) {
            $selectCarrera.= "<option value = '{$listaCarrera->getCodigoCarrera()}'> {$listaCarrera->getNombreCarrera()}</option>";
        }
        $selectCarrera.='</select>';
    }else{

        if(isset($_GET['carrera'])){
            $selectCarrera = '<input type="hidden" name="Programa" value ="'.$_GET['carrera'].'">'.
                '<input type="text" class="seleccionado form-control" value ="'.$datoscarrera[0]->getNombreCarrera().'" readonly="true">';
        }

    }
    return $selectCarrera;
}

