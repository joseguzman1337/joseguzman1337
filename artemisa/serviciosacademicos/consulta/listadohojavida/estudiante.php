<?php

class estudiante {

    var $idestudiante;
    var $codigocarrera=0;
    var $cuentaformulariosiniciados=0;
    var $nombreestudiante;
    var $apellidoestudiante;

    function atributos($idestudiante,$codigocarrera,$nombreestudiante,$apellidoestudiante) {
        $this->idestudiante = $idestudiante;
        $this->codigocarrera= $codigocarrera;
        $this->nombreestudiante= $nombreestudiante;
        $this->apellidoestudiante= $apellidoestudiante ;
        $this->setTotalFormulariosIniciados();
    }

    function imprimir () {
        echo $this->idestudiante;
        echo "&nbsp;-&nbsp;";
        echo $this->codigocarrera;
        echo "&nbsp;-&nbsp;";
        echo $this->apellidoestudiante;
        echo "&nbsp;-&nbsp;";
        echo $this->nombreestudiante;
        echo "</br>";
    }

    function setTotalFormulariosIniciados() {
        global $db;
        $query_formularios = "SELECT count(f.`idformulario`) as cuenta
        FROM formularioestudiante f
        where f.idestudiantegeneral = '".$this->idestudiante."'
        and f.codigoestadodiligenciamiento in(200)
        and f.codigoestado = '100'";
        //, 300
        $formularios = $db->Execute($query_formularios);
        $totalRows_formularios = $formularios->RecordCount();
        $row_formularios=$formularios->fetchRow();
        $this->cuentaformulariosiniciados = $row_formularios['cuenta'];
    }
}
?>