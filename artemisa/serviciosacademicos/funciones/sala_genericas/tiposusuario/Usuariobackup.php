<?php
class Usuario {

    var $objetobase;
    var $tipousuario;
    var $objestadisticas;
    var $codigoperiodo;
    var $cacheusuarioestudiante;
    var $cacheusuariodocente;

    function Usuario($objetobase, $objldap) {
        $this->objetobase = $objetobase;
        $this->objldap = $objldap;
    }

    function setTipoUsuario($tipousuario) {
        $this->tipousuario = $tipousuario;
    }

    function setObjEstadisticas($objestadisticas) {
        $this->objestadisticas = $objestadisticas;
    }

    function setCodigoPeriodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    function setCacheUsuarioEstudiante($codigocarrera, $usuarioestudiante) {
        $this->cacheusuarioestudiante[$codigocarrera] = $usuarioestudiante;
    }

    function setCacheUsuarioDocente($codigocarrera, $usuariodocente) {
        $this->cacheusuariodocente[$codigocarrera] = $usuariodocente;
    }

    function listaUsuario() {
        $condicion = "codigotipousuario in (" . $this->tipousuario . ")";
        $reslistausuarios = $this->objetobase->recuperar_resultado_tabla("usuario", "1", "1", $condicion, "");
        while ($rowusuario = $reslistausuarios->fetchRow()) {
            $listaUsuarios[] = $rowusuario;
        }
        return $listaUsuarios;
    }

    function listaUsuarioActivo($numeromeses=6) {
        $fechaactual = vector_fecha(date("d/m/Y"));
        for ($i = 0; $i < $numeromeses; $i++) {
            if ($i == 0) {
                $nuevafecha = $fechaactual;
            } else {
                $nuevafecha = vector_fecha($fechaanterior);
            }
            $fechaanterior = mes_anterior($nuevafecha["mes"], $nuevafecha["anio"]);
        }
        $fechaanterior = formato_fecha_mysql($fechaanterior);
        $tablas = "logactividadusuario l, usuario u";
        $condicion = " and fechalogactividadusuario between '" . $fechaanterior . "' and now()
and u.idusuario=l.idusuario
and u.codigotipousuario in (" . $this->tipousuario . ")
group by u.idusuario";
        $reslistausuarios = $this->objetobase->recuperar_resultado_tabla($tablas, "1", "1", $condicion, "");
        while ($rowusuario = $reslistausuarios->fetchRow()) {
            $listaUsuarios[] = $rowusuario;
        }
        return $listaUsuarios;
    }

    function listaUsuarioEstudianteMatriculado($codigocarrera) {
        /* echo "cacheusuarioestudiantematriculado<pre>";
          print_r($this->cacheusuarioestudiante[$codigocarrera]);
          echo "</pre>"; */
        if (isset($this->cacheusuarioestudiante[$codigocarrera]) &&
                is_array($this->cacheusuarioestudiante[$codigocarrera])) {
            //echo "<b>Entro</b><br>";
            $usuarioestudiante = $this->cacheusuarioestudiante[$codigocarrera];
        } else {
           // echo "<b>Entro 2</b><br>";
          $arregloestudiantesmatriculados = $this->objestadisticas->obtener_total_matriculados_real($codigocarrera, "arreglo");
            $i = 0;


          //  foreach ($arregloestudiantesmatriculados as $idarreglo => $estudiantematriculado) {


                $datosestudiante = $this->objestadisticas->obtener_datos_estudiante($estudiantematriculado['codigoestudiante']);
                $usuarioestudiante[$i]["Nombre"] = $datosestudiante['nombre'];
                $usuarioestudiante[$i]["Documento"] = $datosestudiante['numerodocumento'];
                $usuarioestudiante[$i]["Correo_Institucional"] = $datosestudiante['usuario'] . "@unbosque.edu.co";
                $usuarioestudiante[$i]["Correo_Personal"] = $datosestudiante['email'];
                $i++;
            //}
        }
        //$this->cacheusuarioestudiante[$codigocarrera] = $usuarioestudiante;
        return $usuarioestudiante;
    }

    function listaUsuarioDocenteActivo($codigocarrera) {
        $query = "select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,if(ca.nombrecarrera='TODAS LAS CARRERAS','POSTGRADOS',ca.nombrecarrera) Nombre_Carrera,dc3.codigocarrera from  docente d,detallecontratodocente dc,contratodocente c
        left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
        dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente)
        left join carrera ca on ca.codigocarrera =dc3.codigocarrera
         where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente and dc.codigocarrera = '" . $codigocarrera . "'
        and d.codigoestado like '1%'
        group by d.iddocente
        union
        select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,ca.nombrecarrera Nombre_Carrera,ca.codigocarrera
        from  docente d,grupo g,carrera ca,materia m
        where
        d.numerodocumento =g.numerodocumento and
        g.codigoperiodo in ('" . $this->codigoperiodo . "') and
        g.codigomateria = m.codigomateria and
        m.codigocarrera=ca.codigocarrera
        and ca.codigocarrera = '" . $codigocarrera . "'
        and d.numerodocumento <> '1'
        and d.iddocente not in(
        select distinct d.iddocente
        from  docente d,detallecontratodocente dc,contratodocente c
        left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
        dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente)
        left join carrera ca on ca.codigocarrera =dc3.codigocarrera
         where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente
        )
        and d.codigoestado like '1%'
        group by d.iddocente
        union
        select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,ca2.nombrecarrera Nombre_Carrera,ca2.codigocarrera
        from  docente d,grupo g,carrera ca,carrera ca2,materia m,contratodocente cp, detallecontratodocente dcp
        where
        d.numerodocumento =g.numerodocumento and
        g.codigoperiodo in ('" . $this->codigoperiodo . "') and
        g.codigomateria = m.codigomateria and
        m.codigocarrera=ca.codigocarrera
        and ca.codigocarrera = '" . $codigocarrera . "'
        and d.numerodocumento <> '1'
        and cp.iddocente=d.iddocente
        and dcp.idcontratodocente=cp.idcontratodocente
        and dcp.codigocarrera <> '" . $codigocarrera . "'
        and d.iddocente not in(
        select distinct d.iddocente
        from  docente d,detallecontratodocente dc,contratodocente c
        left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
        dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente)
        left join carrera ca on ca.codigocarrera =dc3.codigocarrera
         where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente and  dc.codigocarrera = '" . $codigocarrera . "'
        )
        and dcp.codigocarrera=ca2.codigocarrera
        and d.codigoestado like '1%'
        group by d.iddocente

         ";
        @ob_flush();
        flush();
        if (isset($this->cacheusuariodocente[$codigocarrera]) &&
                is_array($this->cacheusuariodocente[$codigocarrera])) {
            $usuariodocente = $this->cacheusuariodocente[$codigocarrera];
        } else {
            $resultado = $this->objetobase->conexion->query($query);
            $i = 0;
            while ($rowdocente = $resultado->fetchRow()) {
                $usuariodocente[$i]["Nombre"] = $rowdocente["apellidodocente"] . " " . $rowdocente["nombredocente"];
                $usuariodocente[$i]["Documento"] = $rowdocente["numerodocumento"];
                $datosusuariodocente = $this->objetobase->recuperar_datos_tabla("usuario u", "numerodocumento", $rowdocente["numerodocumento"], " and codigotipousuario='500'", "", 0);
                if (isset($datosusuariodocente['usuario']) &&
                        $datosusuariodocente['usuario'] != '') {
                    $finalcorreo = "@unbosque.edu.co";
                } else {
                    $finalcorreo = "";
                }
                $usuariodocente[$i]["Correo_Institucional"] = $datosusuariodocente['usuario'] . $finalcorreo;
                $infoldapusuario = $this->objldap->BusquedaUsuarios("uid=" . $datosusuariodocente['usuario']);
                /*echo "infoldapusuario<pre>";
                  print_r($infoldapusuario);
                  echo "</pre>"; */
                $usuariodocente[$i]["Correo_Personal"] = $infoldapusuario[0]['gacctmail'][0];
                $i++;
            }
        }
        //$_SESSION['cacheusuariodocente'][$codigocarrera] = $usuariodocente;
        return $usuariodocente;
    }

    function listaUsuarioAdministrativo($codigocarrera) {
        $this->objldap->raizdirectorio = "ou=Administrativos,dc=unbosque,dc=edu,dc=co";
        $infoldapusuario = $this->objldap->BusquedaUsuarios("uid=*");
        for ($i = 0; $i < count($infoldapusuario); $i++) {

            if (isset($infoldapusuario[$i]["uid"][0]) &&
                    $infoldapusuario[$i]["uid"][0] != '') {
                $finalcorreo = "@unbosque.edu.co";
            } else {
                $finalcorreo = "";
            }
            $usuarioadministrativo[$i]["Nombre"] = $infoldapusuario[$i]["sn"][0];
            $usuarioadministrativo[$i]["Documento"] = "";
            $usuarioadministrativo[$i]["Correo_Institucional"] = $infoldapusuario[$i]["uid"][0] . $finalcorreo;
            $usuarioadministrativo[$i]["Correo_Personal"] = $infoldapusuario[$i]["gacctmail"][0];

        }
        return $usuarioadministrativo;
    }

}
?>