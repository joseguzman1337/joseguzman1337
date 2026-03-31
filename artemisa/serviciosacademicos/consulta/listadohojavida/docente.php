<?php

class docente {

    var $iddocente;
    var $codigocarrera=0;
    var $cuentaformulariosiniciados=0;
    var $nombredocente;
    var $apellidodocente;

    function atributos($iddocente,$codigocarrera,$nombredocente,$apellidodocente) {
        $this->iddocente = $iddocente;
        $this->codigocarrera= $codigocarrera;
        $this->nombredocente= $nombredocente ;
        $this->apellidodocente= $apellidodocente ;
        $this->setTotalFormulariosIniciados();
    }

    function imprimir () {
        echo $this->iddocente;
        echo "&nbsp;-&nbsp;";
        echo $this->codigocarrera;
        echo "&nbsp;-&nbsp;";
        echo $this->apellidodocente;
        echo "&nbsp;-&nbsp;";
        echo $this->nombredocente;
        echo "</br>";
    }

    function setTotalFormulariosIniciados() {
        global $db;
        $query_formularios = "SELECT count(f.`idformulario`) as cuenta
        FROM formulariodocente f
        where f.iddocente = '".$this->iddocente."'
        and f.codigoestadodiligenciamiento in(200)
        and f.fechafinalformulariodocente > now()
        and f.codigoestado = '100'";
        //, 300
        $formularios = $db->Execute($query_formularios);
        $totalRows_formularios = $formularios->RecordCount();
        $row_formularios=$formularios->fetchRow();
        $this->cuentaformulariosiniciados = $row_formularios['cuenta'];
    }
}
?>