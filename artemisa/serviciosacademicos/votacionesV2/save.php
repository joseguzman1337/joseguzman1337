<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hacen las modificaciones para que funcione correctamente y en los paranetros de los querys se le coloca el $db->qstr(). 
 * @since Abril 25, 2019
 */ 
session_start();
require_once(dirname(__FILE__) . '/../../sala/includes/adaptador.php');

$success = true;

switch ($_REQUEST["opc"]) {
    case 'v': {
            //votacion
            if ($_REQUEST["acc"] == "new") {
                $cadena = "insert into votacion (nombrevotacion, descripcionvotacion, fechainiciovotacion " .
                        " ,fechafinalvotacion ,fechainiciovigenciacargoaspiracionvotacion ,fechafinalvigenciacargoaspiracionvotacion " .
                        " ,codigoestado ,idtipocandidatodetalleplantillavotacion) " .
                        " values (" . $db->qstr($_REQUEST["nombrevotacion"]) . ", " . $db->qstr($_REQUEST["descripcionvotacion"]) . " ," . $db->qstr($_REQUEST["fechainiciovotacion"]) . " " .
                        " ," . $db->qstr($_REQUEST["fechafinalvotacion"]) . " ," . $db->qstr($_REQUEST["fechainiciovigenciacargoaspiracionvotacion"]) . " " .
                        " ," . $db->qstr($_REQUEST["fechafinalvigenciacargoaspiracionvotacion"]) . " ," . $db->qstr($_REQUEST["codigoestado"]) . " " .
                        " ," . $db->qstr($_REQUEST["idtipocandidatodetalleplantillavotacion"]) . ")";
                $db->Execute($cadena);
                echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=" . $_REQUEST["opc"] . "&acc=list';</script>";
            }
            if ($_REQUEST["acc"] == "edit") {
                $cadena = "update votacion set nombrevotacion=" . $db->qstr($_REQUEST["nombrevotacion"]) . " " .
                        ",descripcionvotacion=" . $db->qstr($_REQUEST["descripcionvotacion"]) . " ,fechainiciovotacion=" . $db->qstr($_REQUEST["fechainiciovotacion"]) . " " .
                        " ,fechafinalvotacion=" . $db->qstr($_REQUEST["fechafinalvotacion"]) . "  " .
                        " ,fechainiciovigenciacargoaspiracionvotacion=" . $db->qstr($_REQUEST["fechainiciovigenciacargoaspiracionvotacion"]) . " " .
                        " ,fechafinalvigenciacargoaspiracionvotacion=" . $db->qstr($_REQUEST["fechafinalvigenciacargoaspiracionvotacion"]) . " " .
                        " ,codigoestado=" . $db->qstr($_REQUEST["codigoestado"]) . " ,idtipocandidatodetalleplantillavotacion=" . $db->qstr($_REQUEST["idtipocandidatodetalleplantillavotacion"]) . " " .
                        " where idvotacion=" . $db->qstr($_REQUEST["idvot"]) . " ";
                $db->Execute($cadena);
                echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=" . $_REQUEST["opc"] . "&acc=list';</script>";
            }
        }break;
    case 'p': {
            //plantilla
            if ($_REQUEST["acc"] == "new") {
                $sqlconsulta = "select count(*) as 'total'  from plantillavotacion where idvotacion=" . $db->qstr($_REQUEST["idvot"]) . " " .
                        " and idtipoplantillavotacion=" . $db->qstr($_REQUEST["idtipoplantillavotacion"]) . " " .
                        " and nombreplantillavotacion like '%Voto En Blanco%' And codigoestado = 100";
                $query = $db->GetRow($sqlconsulta);

                if (!isset($query['total']) || empty($query['total'])) {
                    // SE INGRESA EL VOTO EN BLANCO EN LA PLANTILLA
                    $cadena = "insert into plantillavotacion (idtipoplantillavotacion " .
                            " ,idvotacion ,iddestinoplantillavotacion ,nombreplantillavotacion " .
                            " ,codigoestado ,codigocarrera) " .
                            " values (" . $db->qstr($_REQUEST["idtipoplantillavotacion"]) . " ," . $db->qstr($_REQUEST["idvot"]) . " " .
                            " ," . $db->qstr($_REQUEST["iddestinoplantillavotacion"]) . " ,'Voto En Blanco' ,'100' ,1)";
                    $db->Execute($cadena);
                    $cadena = "insert into detalleplantillavotacion (idcandidatovotacion " .
                            " ,fechainscripcioncandidatodetalleplantillavotacion ,idplantillavotacion " .
                            " ,codigoestado ,idcargo) values (223 ,current_timestamp," . mysql_insert_id() . " " .
                            " ,'100' ,1)";
                    $db->Execute($cadena);
                }
                $msj = "";
                if ($_REQUEST["idtipoplantillavotacion"] == 3 || $_REQUEST["idtipoplantillavotacion"] == 5) {
                    //SI LA VALIDACION ES PARA UN SOLO PROGRAMA
                    if ($_REQUEST['Programa'] == "1") {
                        $cadena = "insert into plantillavotacion (idtipoplantillavotacion " .
                                " ,idvotacion ,iddestinoplantillavotacion ,nombreplantillavotacion " .
                                " ,codigoestado ,codigocarrera) " .
                                " values (" . $db->qstr($_REQUEST["idtipoplantillavotacion"]) . " ," . $db->qstr($_REQUEST["idvot"]) . " " .
                                " ," . $db->qstr($_REQUEST["iddestinoplantillavotacion"]) . " ," . $db->qstr($_REQUEST["nombreplantillavotacion"]) . " " .
                                " ,'100' ," . $db->qstr($_REQUEST["codigocarrera"]) . ")";
                        $db->Execute($cadena);
                    } else {
                        //SI LA VALIDACION ES PARA TODOS LOS PROGRAMAS DE LA FACULTAD
                        if ($_REQUEST['Programa'] == "2") {
                            $sqlfacultad = "select codigofacultad, codigomodalidadacademica from carrera c " .
                                    " WHERE c.codigocarrera=" . $db->qstr($_REQUEST["codigocarrera"]) . "";
                            $row = $db->GetRow($sqlfacultad);

                            $sqlcarrera = "select codigocarrera, nombrecarrera from carrera c WHERE codigofacultad=" . $db->qstr($row["codigofacultad"]) . "
                        and codigomodalidadacademica=" . $db->qstr($row["codigomodalidadacademica"]) . " 
                        and current_timestamp < fechavencimientocarrera order by nombrecarrera";
                            $res = $db->GetAll($sqlcarrera);
                            $msj .= "\\n\\nCarreras ligadas a esta facultad : \\n\\n";

                            foreach ($res as $valores) {
                                $sqlplantilla = "select idplantillavotacion from plantillavotacion  " .
                                        " WHERE idvotacion=" . $db->qstr($_REQUEST["idvot"]) . " AND codigocarrera=" . $db->qstr($valores["codigocarrera"]) . " AND " .
                                        " idtipoplantillavotacion=" . $db->qstr($_REQUEST["idtipoplantillavotacion"]) . " " .
                                        " AND nombreplantillavotacion=" . $db->qstr($_REQUEST["nombreplantillavotacion"]) . "";
                                $rowsC = $db->GetRow($sqlplantilla);
                                if (!isset($rowsC['idplantillavotacion']) || empty($rowsC['idplantillavotacion'])) {
                                    $msj .= $valores["nombrecarrera"] . "\\n";
                                    $cadena = "insert into plantillavotacion
                                (idtipoplantillavotacion
                                ,idvotacion
                                ,iddestinoplantillavotacion
                                ,nombreplantillavotacion
                                ,codigoestado
                                ,codigocarrera)
                                values (" . $db->qstr($_REQUEST["idtipoplantillavotacion"]) . "
                                ," . $db->qstr($_REQUEST["idvot"]) . "			
                                ," . $db->qstr($_REQUEST["iddestinoplantillavotacion"]) . "
                                ," . $db->qstr($_REQUEST["nombreplantillavotacion"]) . "
                                ,'100'
                                ," . $db->qstr($valores["codigocarrera"]) . ")";
                                    $db->Execute($cadena);
                                }
                            }
                        }
                    }
                }
                 else {
			$cadena="insert into plantillavotacion
					(idtipoplantillavotacion
					,idvotacion
					,iddestinoplantillavotacion
					,nombreplantillavotacion
					,codigoestado
					,codigocarrera)
				values (".$_REQUEST["idtipoplantillavotacion"]."
					,".$_REQUEST["idvot"]."			
					,".$_REQUEST["iddestinoplantillavotacion"]."
					,'".$_REQUEST["nombreplantillavotacion"]."'
					,'100'
					,'1')";
			$db->Execute($cadena);
			
		}
                    echo "<script>alert('¡¡ La información se ha ingresado correctamente. !! ".$msj."');location.href='?opc=".$_REQUEST["opc"]."&acc=list&idvot=".$_REQUEST["idvot"]."&idtip=".$_REQUEST["idtip"]."';</script>";
              } else if ($_REQUEST["acc"] == "edit") {
                $msj = "";
                //SI LA VALIDACION ES PARA UN SOLO PROGRAMA
                if ($_REQUEST['Programa'] == "1") {
                    //consulta para saber la cantidad de registros si fue por facultad (>1) o por programa(==1)
                    $sqlfacultad = "select  count(codigocarrera) as ncarreras from plantillavotacion where idvotacion=" . $db->qstr($_REQUEST["idvot"]) . " AND nombreplantillavotacion=" . $db->qstr($_REQUEST["nombreplantillavotacion"]) . " ";
                    $rowPf = $db->GetRow($sqlfacultad);
                    if ($rowPf['ncarreras'] == 1) {
                        $cadena = "UPDATE `plantillavotacion` SET `idtipoplantillavotacion`=" . $db->qstr($_REQUEST["idtipoplantillavotacion"]) . ", `idvotacion`=" . $db->qstr($_REQUEST["idvot"]) . ", `iddestinoplantillavotacion`=" . $db->qstr($_REQUEST["iddestinoplantillavotacion"]) . ",
                            `nombreplantillavotacion`=" . $db->qstr($_REQUEST["nombreplantillavotacion"]) . ", `codigoestado`=" . $db->qstr($_REQUEST["codigoestado"]) . ", `codigocarrera`=" . $db->qstr($_REQUEST["codigocarrera"]) . "
                            WHERE (`idplantillavotacion`=" . $db->qstr($_REQUEST["idplvot"]) . ")";
                        $db->Execute($cadena);
                    } else {
                        $cadena = "DELETE FROM `plantillavotacion` WHERE (`nombreplantillavotacion`=" . $db->qstr($_REQUEST["nombreplantillavotacion"]) . " and `idvotacion`=" . $db->qstr($_REQUEST["idvot"]) . " and `codigocarrera`!=" . $db->qstr($_REQUEST["codigocarrera"]) . ")";
                        $db->Execute($cadena);
                    }
                } else if ($_REQUEST['Programa'] == "2") {
                    $sqlfacultad = "select codigofacultad, codigomodalidadacademica from carrera c " .
                            " WHERE c.codigocarrera=" . $db->qstr($_REQUEST["codigocarrera"]) . " ";
                    $row = $db->GetRow($sqlfacultad);

                    $sqlcarrera = "select codigocarrera, nombrecarrera from carrera c WHERE codigofacultad=" . $db->qstr($row["codigofacultad"]) . "
                        and codigomodalidadacademica=" . $db->qstr($row["codigomodalidadacademica"]) . " 
                        and current_timestamp < fechavencimientocarrera order by nombrecarrera";
                    $res = $db->GetAll($sqlcarrera);
                    $msj .= "\\n\\nCarreras ligadas a esta facultad : \\n\\n";

                    foreach ($res as $valores) {
                        $sqlplantilla = "select * from plantillavotacion  " .
                                " WHERE idvotacion=" . $db->qstr($_REQUEST["idvot"]) . " AND codigocarrera=" . $db->qstr($valores["codigocarrera"]) . " AND " .
                                " idtipoplantillavotacion=" . $db->qstr($_REQUEST["idtipoplantillavotacion"]) . " " .
                                " AND nombreplantillavotacion=" . $db->qstr($_REQUEST["nombreplantillavotacion"]) . " ";
                        $rowsC = $db->GetRow($sqlplantilla);
                        if (!isset($rowsC['idplantillavotacion']) || empty($rowsC['idplantillavotacion'])) {
                            $msj .= $valores["nombrecarrera"] . "\\n";
                            $cadena = "insert into plantillavotacion
                                (idtipoplantillavotacion
                                ,idvotacion
                                ,iddestinoplantillavotacion
                                ,nombreplantillavotacion
                                ,codigoestado
                                ,codigocarrera)
                                values (" . $db->qstr($_REQUEST["idtipoplantillavotacion"]) . "
                                ," . $db->qstr($_REQUEST["idvot"]) . "			
                                ," . $db->qstr($_REQUEST["iddestinoplantillavotacion"]) . "
                                ," . $db->qstr($_REQUEST["nombreplantillavotacion"]) . "
                                ,'100'
                                ," . $db->qstr($valores["codigocarrera"]) . ")";
                            $db->Execute($cadena);
                        } else {
                            $msj .= $valores["nombrecarrera"] . "\\n";
                            $cadena = "UPDATE `plantillavotacion` SET `idtipoplantillavotacion`=" . $db->qstr($_REQUEST["idtipoplantillavotacion"]) . ", `idvotacion`=" . $db->qstr($_REQUEST["idvot"]) . ", `iddestinoplantillavotacion`=" . $db->qstr($_REQUEST["iddestinoplantillavotacion"]) . ",
                                `nombreplantillavotacion`=" . $db->qstr($_REQUEST["nombreplantillavotacion"]) . ", `codigoestado`=" . $db->qstr($_REQUEST["codigoestado"]) . ", `codigocarrera`=" . $db->qstr($valores["codigocarrera"]) . "
                                WHERE (`idplantillavotacion`=" . $db->qstr($rowsC["idplantillavotacion"]) . ")";
                            $db->Execute($cadena);
                        }
                    }
                }
//                }
                echo "<script>alert('¡¡ La información se ha actualizado correctamente. !! " . $msj . "');location.href='?opc=" . $_REQUEST["opc"] . "&acc=list&idvot=" . $_REQUEST["idvot"] . "&idtip=" . $_REQUEST["idtip"] . "';</script>";
            }
        }break;
    case 'c': {
            //candidatos
            $tipoCandidato = $_REQUEST["idtip"];
            if ($_REQUEST["idtip"] == 1) {
                //egresados
                $tipoCandidato = 3;
            } else if ($_REQUEST["idtip"] == 3) {
                //docente
                $tipoCandidato = 1;
            }
            if ($_REQUEST["acc"] == "new") {
                // INGRESA CANDIDATO PRINCIPAL Y LOS ASOCIA A LAS CARRERAS CORRESPONDIENTE
                $_REQUEST["numerodocumentoP"] = trim($_REQUEST["numerodocumentoP"]);
                $_REQUEST["numerodocumentoS"] = trim($_REQUEST["numerodocumentoS"]);

                $cadena = "select idcandidatovotacion from candidatovotacion c WHERE  c.numerodocumentocandidatovotacion=" . $db->qstr($_REQUEST["numerodocumentoP"]);

                $rowDetalle = $db->GetRow($cadena);
                if (!isset($rowDetalle['idcandidatovotacion']) || empty($rowDetalle['idcandidatovotacion'])) {
                    $cadena = "insert into candidatovotacion 
                    (numerodocumentocandidatovotacion
                    ,nombrescandidatovotacion
                    ,apellidoscandidatovotacion
                    ,telefonocandidatovotacion
                    ,celularcandidatovotacion
                    ,direccioncandidatovotacion
                    ,rutaarchivofotocandidatovotacion
                    ,idtipocandidatodetalleplantillavotacion
                    ,numerotarjetoncandidatovotacion
                    ,codigoestado)
                    values(  " . $db->qstr($_REQUEST["numerodocumentoP"]) . "
                    ," . $db->qstr($_REQUEST["nombresP"]) . "
                    ," . $db->qstr($_REQUEST["apellidosP"]) . "
                    ," . $db->qstr($_REQUEST["telefonoP"]) . "
                    ," . $db->qstr($_REQUEST["celularP"]) . "
                    ," . $db->qstr($_REQUEST["direccionP"]) . "
                    ,'../../imagenes/estudiantes/'
                    ," . $db->qstr($tipoCandidato) . "
                    ," . $db->qstr("0" . $_REQUEST["idnompl"]) . "
                    ,'100')";
                    $db->Execute($cadena);
                    $idcandidatovotacion = mysql_insert_id();
                } else {
                    if ($_REQUEST["nombresP"] != "" && isset($_REQUEST["nombresP"])) {
                        $cadena = "UPDATE `candidatovotacion` SET `numerodocumentocandidatovotacion`=" . $db->qstr($_REQUEST["numerodocumentoP"]) . ", `nombrescandidatovotacion`=" . $db->qstr($_REQUEST["nombresP"]) . ", `apellidoscandidatovotacion`=" . $db->qstr($_REQUEST["apellidosP"]) . ",
                        `telefonocandidatovotacion`=" . $db->qstr($_REQUEST["telefonoP"]) . ", `celularcandidatovotacion`=" . $db->qstr($_REQUEST["celularP"]) . ", `direccioncandidatovotacion`=" . $db->qstr($_REQUEST["direccionP"]) . ", `codigoestado`='100', 
                        `numerotarjetoncandidatovotacion` = " . $db->qstr("0" . $_REQUEST["idnompl"]) . ", `idtipocandidatodetalleplantillavotacion`=" . $db->qstr($tipoCandidato) . "  
                        WHERE (`idcandidatovotacion`=" . $db->qstr($rowDetalle["idcandidatovotacion"]) . ")";
                        $db->Execute($cadena);
                    }
                    $idcandidatovotacion = $rowDetalle["idcandidatovotacion"];
                }
                foreach (explode(",", $_REQUEST["idspl"]) as $vlr) {
                    $cadena = "insert into detalleplantillavotacion
                    (idcandidatovotacion
                    ,fechainscripcioncandidatodetalleplantillavotacion
                    ,idplantillavotacion
                    ,codigoestado
                    ,idcargo)
                    values (" . $db->qstr($idcandidatovotacion) . "
                    ,current_timestamp
                    ," . $db->qstr($vlr) . "
                    ,'100'
                    ,2)";
                    $db->Execute($cadena);
                }
                if (trim($_REQUEST["numerodocumentoS"]) != "") {
                    // INGRESA CANDIDATO SUPLENTE Y LOS ASOCIA A LAS CARRERAS CORRESPONDIENTE
                    $cadena = "select c.idcandidatovotacion from candidatovotacion c WHERE  c.numerodocumentocandidatovotacion=" . $db->qstr($_REQUEST["numerodocumentoS"]);

                    $rowDetalle = $db->GetRow($cadena);
                    if (!isset($rowDetalle['idcandidatovotacion']) || empty($rowDetalle['idcandidatovotacion'])) {
                        $cadena = "insert into candidatovotacion 
                        (numerodocumentocandidatovotacion
                        ,nombrescandidatovotacion
                        ,apellidoscandidatovotacion
                        ,telefonocandidatovotacion
                        ,celularcandidatovotacion
                        ,direccioncandidatovotacion
                        ,rutaarchivofotocandidatovotacion
                        ,idtipocandidatodetalleplantillavotacion
                        ,numerotarjetoncandidatovotacion
                        ,codigoestado)
                        values(  " . $db->qstr($_REQUEST["numerodocumentoS"]) . "
                        ," . $db->qstr($_REQUEST["nombresS"]) . "
                        ," . $db->qstr($_REQUEST["apellidosS"]) . "
                        ," . $db->qstr($_REQUEST["telefonoS"]) . "
                        ," . $db->qstr($_REQUEST["celularS"]) . "
                        ," . $db->qstr($_REQUEST["direccionS"]) . "
                        ,'../../imagenes/estudiantes/'
                        ," . $db->qstr($tipoCandidato) . "
                        ," . $db->qstr("0" . $_REQUEST["idnompl"]) . "
                        ,'100')";
                        $db->Execute($cadena);
                        $idcandidatovotacion = mysql_insert_id();
                    } else {
                        if ($_REQUEST["nombresS"] != "" && isset($_REQUEST["nombresS"])) {
                            $cadena = "UPDATE `candidatovotacion` SET `numerodocumentocandidatovotacion`=" . $db->qstr($_REQUEST["numerodocumentoS"]) . ", `nombrescandidatovotacion`=" . $db->qstr($_REQUEST["nombresS"]) . ", `apellidoscandidatovotacion`=" . $db->qstr($_REQUEST["apellidosS"]) . ",
                            `telefonocandidatovotacion`=" . $db->qstr($_REQUEST["telefonoS"]) . ", `celularcandidatovotacion`=" . $db->qstr($_REQUEST["celularS"]) . ", `direccioncandidatovotacion`=" . $db->qstr($_REQUEST["direccionS"]) . ", `codigoestado`='100', 
                            numerotarjetoncandidatovotacion = " . $db->qstr("0" . $_REQUEST["idnompl"]) . ", `idtipocandidatodetalleplantillavotacion`=" . $db->qstr($tipoCandidato) . " 
                            WHERE (`idcandidatovotacion`=" . $db->qstr($rowDetalle["idcandidatovotacion"]) . ")";
                            $db->Execute($cadena);
                        }
                        $idcandidatovotacion = $rowDetalle["idcandidatovotacion"];
                    }
                    foreach (explode(",", $_REQUEST["idspl"]) as $vlr) {
                        $cadena = "insert into detalleplantillavotacion
                        (idcandidatovotacion
                        ,fechainscripcioncandidatodetalleplantillavotacion
                        ,idplantillavotacion
                        ,codigoestado
                        ,idcargo)
                        values (" . $db->qstr($idcandidatovotacion) . "
                        ,current_timestamp
                        ," . $db->qstr($vlr) . "
                        ,'100'
                        ,3)";
                        $db->Execute($cadena);
                    }
                }
                echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=" . $_REQUEST["opc"] . "&acc=list&idvot=" . $_REQUEST["idvot"] . "&idtip=" . $_REQUEST["idtip"] . "&idspl=" . $_REQUEST["idspl"] . "&idnompl=" . $_REQUEST["idnompl"] . "';</script>";
            } else {
                $_REQUEST["numerodocumentoP"] = trim($_REQUEST["numerodocumentoP"]);
                $_REQUEST["numerodocumentoS"] = trim($_REQUEST["numerodocumentoS"]);

                $tipoCandidato = $_REQUEST["idtip"];
                if ($_REQUEST["idtip"] == 1) {
                    //egresados
                    $tipoCandidato = 3;
                } else if ($_REQUEST["idtip"] == 3) {
                    //docente
                    $tipoCandidato = 1;
                }
                $cadena = "select c.idcandidatovotacion from candidatovotacion c WHERE c.numerodocumentocandidatovotacion=" . $db->qstr($_REQUEST["numerodocumentoP"]);

                $rowDetalle = $db->GetRow($cadena);
                $idcandidatovotacion = $rowDetalle["idcandidatovotacion"];
                if ($_REQUEST["numerodocumentoP"] != "" && $_REQUEST["nombresP"] != "" && isset($_REQUEST["nombresP"])) {
                    $cadena = "UPDATE `candidatovotacion` SET `numerodocumentocandidatovotacion`=" . $db->qstr($_REQUEST["numerodocumentoP"]) . ", `nombrescandidatovotacion`=" . $db->qstr($_REQUEST["nombresP"]) . ", `apellidoscandidatovotacion`=" . $db->qstr($_REQUEST["apellidosP"]) . ",
                    `telefonocandidatovotacion`=" . $db->qstr($_REQUEST["telefonoP"]) . ", `celularcandidatovotacion`=" . $db->qstr($_REQUEST["celularP"]) . ", `direccioncandidatovotacion`=" . $db->qstr($_REQUEST["direccionP"]) . ", `codigoestado`='100', 
                            `numerotarjetoncandidatovotacion` = " . $db->qstr("0" . $_REQUEST["idnompl"]) . ", `idtipocandidatodetalleplantillavotacion`=" . $db->qstr($tipoCandidato) . " 
                    WHERE (`idcandidatovotacion`=" . $db->qstr($_REQUEST["idcanP"]) . ")";
                    $db->Execute($cadena);
                }
                if ($_REQUEST["numerodocumentoP"] != "") {
                    foreach (explode(",", $_REQUEST["idspl"]) as $vlr) {
                        $cadena = "select c.idcandidatovotacion from candidatovotacion c 
                        inner join detalleplantillavotacion dv on dv.idcandidatovotacion=c.idcandidatovotacion 
                        WHERE idplantillavotacion=" . $db->qstr($vlr) . " AND dv.codigoestado=100 AND c.numerodocumentocandidatovotacion=" . $db->qstr($_REQUEST["numerodocumentoP"]);

                        $rowDetalle = $db->GetRow($cadena);
                        if (!isset($rowDetalle['idcandidatovotacion']) || empty($rowDetalle['idcandidatovotacion'])) {
                            $cadena = "insert into detalleplantillavotacion
                            (idcandidatovotacion
                            ,fechainscripcioncandidatodetalleplantillavotacion
                            ,idplantillavotacion
                            ,codigoestado
                            ,idcargo)
                            values (" . $db->qstr($idcandidatovotacion) . "
                            ,current_timestamp
                            ," . $db->qstr($vlr) . "
                            ,'100'
                            ,2)";
                            $db->Execute($cadena);
                        } else {
                            $cadena = "UPDATE `detalleplantillavotacion` SET `idcargo`='2', `codigoestado`='100'  
                            WHERE (`iddetalleplantillavotacion`=" . $db->qstr($rowDetalle["iddetalleplantillavotacion"]) . ")";
                            $db->Execute($cadena);
                        }
                    }
                }
                $cadena = "select idcandidatovotacion from candidatovotacion c WHERE c.numerodocumentocandidatovotacion=" . $db->qstr($_REQUEST["numerodocumentoS"]);

                $rowDetalle = $db->GetRow($cadena);
                if (!isset($rowDetalle['idcandidatovotacion']) || empty($rowDetalle['idcandidatovotacion'])) {
                    $cadena = "insert into candidatovotacion 
                    (numerodocumentocandidatovotacion
                    ,nombrescandidatovotacion
                    ,apellidoscandidatovotacion
                    ,telefonocandidatovotacion
                    ,celularcandidatovotacion
                    ,direccioncandidatovotacion
                    ,rutaarchivofotocandidatovotacion
                    ,idtipocandidatodetalleplantillavotacion
                    ,numerotarjetoncandidatovotacion
                    ,codigoestado)
                    values(  " . $db->qstr($_REQUEST["numerodocumentoS"]) . "
                    ," . $db->qstr($_REQUEST["nombresS"]) . "
                    ," . $db->qstr($_REQUEST["apellidosS"]) . "
                    ," . $db->qstr($_REQUEST["telefonoS"]) . "
                    ," . $db->qstr($_REQUEST["celularS"]) . "
                    ," . $db->qstr($_REQUEST["direccionS"]) . "
                    ,'../../imagenes/estudiantes/'
                    ," . $db->qstr($tipoCandidato) . "
                    ," . $db->qstr("0" . $_REQUEST["idnompl"]) . "
                    ,'100')";
                    $db->Execute($cadena);
                    $idcandidatovotacion = mysql_insert_id();
                } else if ($_REQUEST["numerodocumentoS"] != "" && $_REQUEST["nombresS"] != "" && isset($_REQUEST["nombresS"])) {
                    $cadena = "UPDATE `candidatovotacion` SET `numerodocumentocandidatovotacion`=" . $db->qstr($_REQUEST["numerodocumentoS"]) . ", `nombrescandidatovotacion`=" . $db->qstr($_REQUEST["nombresS"]) . ", `apellidoscandidatovotacion`=" . $db->qstr($_REQUEST["apellidosS"]) . ",
                    `telefonocandidatovotacion`=" . $db->qstr($_REQUEST["telefonoS"]) . ", `celularcandidatovotacion`=" . $db->qstr($_REQUEST["celularS"]) . ", `direccioncandidatovotacion`=" . $db->qstr($_REQUEST["direccionS"]) . ", `codigoestado`='100', 
                    `numerotarjetoncandidatovotacion` = " . $db->qstr("0" . $_REQUEST["idnompl"]) . ", `idtipocandidatodetalleplantillavotacion`=" . $db->qstr($tipoCandidato) . "
                    WHERE (`idcandidatovotacion`=" . $db->qstr($rowDetalle["idcandidatovotacion"]) . ")";
                    $idcandidatovotacion = $rowDetalle["idcandidatovotacion"];
                    $db->Execute($cadena);
                }
                if ($_REQUEST["numerodocumentoS"] != "") {
                    foreach (explode(",", $_REQUEST["idspl"]) as $vlr) {
                        $cadena = "select c.idcandidatovotacion from candidatovotacion c 
                        inner join detalleplantillavotacion dv on dv.idcandidatovotacion=c.idcandidatovotacion 
                        WHERE idplantillavotacion=" . $db->qstr($vlr) . " AND dv.codigoestado=100 AND c.numerodocumentocandidatovotacion=" . $db->qstr($_REQUEST["numerodocumentoS"]);

                        $rowDetalle = $db->GetRow($cadena);
                        if (!isset($rowDetalle['idcandidatovotacion']) || empty($rowDetalle['idcandidatovotacion'])) {
                            $cadena = "insert into detalleplantillavotacion
                            (idcandidatovotacion
                            ,fechainscripcioncandidatodetalleplantillavotacion
                            ,idplantillavotacion
                            ,codigoestado
                            ,idcargo)
                            values (" . $db->qstr($idcandidatovotacion) . "
                            ,current_timestamp
                            ," . $db->qstr($vlr) . "
                            ,'100'
                            ,3)";
                            $db->Execute($cadena);
                        } else {
                            $cadena = "UPDATE `detalleplantillavotacion` SET `idcargo`='3', `codigoestado`='100'  
                            WHERE (`iddetalleplantillavotacion`=" . $db->qstr($rowDetalle["iddetalleplantillavotacion"]) . ")";
                            $db->Execute($cadena);
                        }
                    }
                }
                echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=" . $_REQUEST["opc"] . "&acc=list&idvot=" . $_REQUEST["idvot"] . "&idtip=" . $_REQUEST["idtip"] . "&idspl=" . $_REQUEST["idspl"] . "&idnompl=" . $_REQUEST["idnompl"] . "';</script>";
            }
        }break;
}
?>