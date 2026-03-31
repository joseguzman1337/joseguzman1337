<?php
class controladorCarrera{
    public function ctrCarreraSnies(){
        $carreras = modeloCarrera::mdlCarreraSnies();
        $arregloSimple = array();
        $n=1;$i=0;
        foreach ($carreras as $key => $value) {
            $idCarreraRegistro = $value["idcarreraregistro"];
            $codigoSniesCarreraRegistro = $value["codigosniescarreraregistro"];
            $numeroRegistroCarreraRegistro = $value["numeroregistrocarreraregistro"];
            $codigoCarrera = $value["codigocarrera"];
            $fechaInicioCarreraRegistro = $value["fechainiciocarreraregistro"];
            $fechaFinalCarreraRegistro = $value["fechafinalcarreraregistro"];
            $nombreCarrera = $value["nombrecarrera"];
            $arregloSimple[$i]["contador"] = $n;
            $arregloSimple[$i]["nombreCarrera"] = $nombreCarrera;
            $arregloSimple[$i]["idCarreraRegistro"] = $idCarreraRegistro;
            $arregloSimple[$i]["codigoCarrera"] = $codigoCarrera;
            $arregloSimple[$i]["fechaInicioCarreraRegistro"] = $fechaInicioCarreraRegistro;
            $arregloSimple[$i]["fechaFinalCarreraRegistro"] = $fechaFinalCarreraRegistro;
            $arregloSimple[$i]["codigoSniesCarreraRegistro"] = $codigoSniesCarreraRegistro;

            $n++;
            $i++;
        }
        return $arregloSimple;
    }
    public function ctrProgramaUbosque(){
        $programas = modeloCarrera::mdlProgramasUB();
        $arregloSimple = array();
        $n=1;$i=0;
        foreach ($programas as $key => $value) {
            $codigoCarrera = $value["codigocarrera"];
            $nombreCarrera = $value["nombrecortocarrera"];
            $arregloSimple[$i]["contador"] = $n;
            $arregloSimple[$i]["nombreCarrera"] = $nombreCarrera;
            $arregloSimple[$i]["codigoCarrera"] = $codigoCarrera;

            $n++;
            $i++;
        }
        return $arregloSimple;
    }
}