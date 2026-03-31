<?php
/*//$sala = $_SESSION['sala'];
@session_start();
header('Content-Type: text/html; charset=utf-8');
$rutaPRINCIPAL = "";
if(isset($_REQUEST['funcion']))
{
    $rutaPRINCIPAL = "../../";
}
require_once($rutaPRINCIPAL.'../../Connections/sala2.php');
$rutaado = $rutaPRINCIPAL."../../funciones/adodb/";
require_once($rutaPRINCIPAL.'../../Connections/salaado.php');
$codigocarrera = $_SESSION['codigofacultad'];
*/
//$db->debug = true;
function getHijos($iditemsic, $iditemsicsel) {
    global $db, $cuentaitem;
    $filtrar = "";
    if($cuentaitem == 1)
        $filtrar = " and iditemsic in($iditemsicsel)";
    $cuentaitem++;
    $query_hijos = "select i.iditemsic, i.nombreitemsic, i.descripcionitemsic, i.longituddescripcionitemsic, i.iditemsicpadre, i.codigotipoitemsic, i.pesoitemsic, i.enlaceitemsic, i.enlaceconsultaitemsic, i.cantidadadjuntositemsic, i.codigoestadoitemsic, i.codigoestado
    from itemsic i
    where i.iditemsicpadre = '$iditemsic'
    and i.codigoestado like '100'
        $filtrar
    order by i.pesoitemsic";
    //echo "$query_hijos == $cuentaitem<br>";

    $hijos = $db->Execute($query_hijos);
    $totalRows_hijos = $hijos->RecordCount();
    if($totalRows_hijos != 0) {
        while($row_hijos = $hijos->FetchRow()) {
            $estaIniciado = false;
            $estaAprobado = false;
            $rutaImagen = '';
            //$estaTerminado = false;
            if(existeItemsic($row_hijos['iditemsic'])) {
                $row_itemsicCarrera = obtenerItemSicCarrera($row_hijos['iditemsic']);
                if($row_itemsicCarrera['codigoestadoitemsiccarrera'] != '' || ($row_hijos['longituddescripcionitemsic'] == 0 && tieneAdjuntos($row_hijos['iditemsic']))) {
                //echo $row_itemsicCarrera['codigoestadoitemsiccarrera'];
                    if($row_itemsicCarrera['codigoestadoitemsiccarrera'] == 100) {
                        $estaIniciado = true;
                    }
                    elseif($row_itemsicCarrera['codigoestadoitemsiccarrera'] == 200) {
                        $estaAprobado = true;
                    }
                }
            }
            if($estaAprobado) {
                $rutaImagen = "imagenes/aprobado.gif";
            }
            elseif($estaIniciado) {
                $rutaImagen = "imagenes/poraprobar.gif";
            }
            else {
                $rutaImagen = "imagenes/noiniciado.gif";
            }

            $tieneHijos = tieneHijos($row_hijos['iditemsic']);
            ?>
<li>
                <?php
                if($row_hijos['codigoestadoitemsic'] == 100 && $row_hijos['enlaceitemsic'] != ''):
                    if($rutaImagen != ''):
                        ?>
    <img id="img<?php echo $row_hijos['iditemsic']; ?>" src="<?php echo $rutaImagen; ?>" width="14" height="14">
                    <?php
                    endif;

                    //if($row_hijos['codigotipoitemsic'] == 200):
                    ?>
    <input type="hidden" id="enlaceitemsic<?php echo $row_hijos['iditemsic'];?>" value="<?php echo $row_hijos['enlaceitemsic'];?>">
    <input type="hidden" id="cantidadadjuntositemsic<?php echo $row_hijos['iditemsic'];?>" value="<?php echo $row_hijos['cantidadadjuntositemsic'];?>">
                    <?php
                    if($row_hijos['codigotipoitemsic'] != 300):
                        ?>
    <label name='<?php echo $row_hijos['iditemsic'];?>' title="<?php echo $row_hijos['descripcionitemsic'];?>" lang="<?php echo $row_hijos['longituddescripcionitemsic'];?>">
                    <?php
                    endif;
                    endif;
                    if($tieneHijos) {
                        ?>
        <b>
                        <?php
                        }
                        //"$cuentaitem ".
                        echo $row_hijos['nombreitemsic'];

                        if($tieneHijos) {
                            ?>
        </b>
                    <?php
                    }
                    if($row_hijos['codigotipoitemsic'] != 300):
                        ?>
    </label>
                <?php
                endif;
                if($tieneHijos) {
                    ?>
    <ul>
                    <?php
                    }
                    getHijos($row_hijos['iditemsic'], $iditemsicsel, $cuentaitem++);
                    if($tieneHijos) {
                        ?>
    </ul>
                <?php
                }
                ?>
</li>
        <?php
        }
    }
    return true;
}

function tieneHijos($iditemsic) {
    global $db;
    $query_hijos = "select i.iditemsic, i.nombreitemsic, i.descripcionitemsic, i.iditemsicpadre, i.codigotipoitemsic, i.pesoitemsic, i.enlaceitemsic, i.codigoestadoitemsic, i.codigoestado
    from itemsic i
    where i.iditemsicpadre = '$iditemsic'
    and i.codigoestado like '100'
    order by i.pesoitemsic";
    //echo "$query_hijos<br>";
    $hijos = $db->Execute($query_hijos);
    $totalRows_hijos = $hijos->RecordCount();
    if($totalRows_hijos != 0) {
        return true;
    }
    return false;
}

function tieneAdjuntos($iditemsic) {
    global $db, $codigocarrera;
    //$db->debug = true;
    $query_adjuntos = "select iditemsic
    from itemsiccarreraadjunto ica, itemsiccarrera ic
    where ic.iditemsic = '$iditemsic'
    and ic.codigocarrera = '$codigocarrera'
    and ica.iditemsiccarrera = ic.iditemsiccarrera
    and ic.codigoestado like '100'
    and ica.codigoestado like '100'";
    if(isset($_SESSION['sesion_carreraitemsic'])) {
        $query_adjuntos = "select iditemsic
        from itemsiccarreraadjunto ica, itemsiccarrera ic
        where ic.iditemsic = '$iditemsic'
        and ic.codigocarrera = '".$_SESSION['sesion_carreraitemsic']."'
        and ica.iditemsiccarrera = ic.iditemsiccarrera
        and ic.codigoestado like '100'
        and ica.codigoestado like '100'";
    }
    //echo "$query_hijos<br>";
    $adjuntos = $db->Execute($query_adjuntos);
    $totalRows_adjuntos = $adjuntos->RecordCount();
    if($totalRows_adjuntos != 0) {
        return true;
    }
    return false;
}

function obtenerItemSicCarrera($iditemsic) {
    global $db, $codigocarrera;
    $query_itemsiccarrera = "select ic.iditemsiccarrera, ic.iditemsic, ic.codigocarrera, ic.valoritemsiccarrera, ic.codigoestadoitemsiccarrera, ic.fechacreacionitemsiccarrera, ic.fechamodificacionitemsiccarrera, ic.fechahastaitemsiccarrera, ic.codigoestado
    from itemsiccarrera ic
    where ic.iditemsic = '$iditemsic'
    and ic.codigocarrera = '$codigocarrera'
    and ic.codigoestado like '100'";
    if(isset($_SESSION['sesion_carreraitemsic'])) {
        $query_itemsiccarrera = "select ic.iditemsiccarrera, ic.iditemsic, ic.codigocarrera, ic.valoritemsiccarrera, ic.codigoestadoitemsiccarrera, ic.fechacreacionitemsiccarrera, ic.fechamodificacionitemsiccarrera, ic.fechahastaitemsiccarrera, ic.codigoestado
        from itemsiccarrera ic
        where ic.iditemsic = '$iditemsic'
        and ic.codigocarrera = '".$_SESSION['sesion_carreraitemsic']."'
        and ic.codigoestado like '100'";
    }
    //echo "$query_itemsiccarrera<br>";
    $itemsiccarrera = $db->Execute($query_itemsiccarrera);
    $totalRows_itemsiccarrera = $itemsiccarrera->RecordCount();
    if($totalRows_itemsiccarrera != 0) {
        $row_itemsiccarrera = $itemsiccarrera->FetchRow();
    }
    return $row_itemsiccarrera;
}

function obtenerValoritemsiccarrera($iditemsic) {
    $row = obtenerItemSicCarrera($iditemsic);
    return $row['valoritemsiccarrera'];
}

function existeItemsic($iditemsic) {
    global $db;
    $query_itemsiccarrera = "select ic.iditemsiccarrera
    from itemsiccarrera ic
    where ic.iditemsic = '$iditemsic'
    and ic.codigoestado like '100'";
    //echo "$query_hijos<br>";
    $itemsiccarrera = $db->Execute($query_itemsiccarrera);
    $totalRows_itemsiccarrera = $itemsiccarrera->RecordCount();
    if($totalRows_itemsiccarrera != 0) {
        return true;
    }
    return false;
}

function insertarItemsiccarrera($iditemsic) {
    global $db, $codigocarrera;
    $valoritemsiccarrera = utf8_decode($_REQUEST['valoritemsiccarrera']);
    //$valoritemsiccarrera = $_REQUEST['valoritemsiccarrera'];
    //echo "Valor $valoritemsiccarrera = ".$_REQUEST['valoritemsiccarrera'];
    //exit();
    $retornar = "No se ejecuto ninguna operacion";
    if(!existeItemsic($iditemsic)) {
    // Insertar el item
        $query_insitemsiccarrera = "insert into itemsiccarrera (iditemsiccarrera, iditemsic, codigocarrera, valoritemsiccarrera, codigoestadoitemsiccarrera, fechacreacionitemsiccarrera, fechamodificacionitemsiccarrera, fechahastaitemsiccarrera, codigoestado)
        values (0, $iditemsic, '$codigocarrera', '$valoritemsiccarrera', 100, now(), now(), '2999-12-31', 100)";
        if(isset($_SESSION['sesion_carreraitemsic'])) {
            $query_insitemsiccarrera = "insert into itemsiccarrera (iditemsiccarrera, iditemsic, codigocarrera, valoritemsiccarrera, codigoestadoitemsiccarrera, fechacreacionitemsiccarrera, fechamodificacionitemsiccarrera, fechahastaitemsiccarrera, codigoestado)
            values (0, $iditemsic, '".$_SESSION['sesion_carreraitemsic']."', '$valoritemsiccarrera', 100, now(), now(), '2999-12-31', 100)";
        }
        //echo "$query_hijos<br>";
        if($insitemsiccarrera = $db->Execute($query_insitemsiccarrera)) {
            $retornar = "insertado";
        }
        else {
            $retornar = "$query_insitemsiccarrera ".mysql_error();
        }
    }
    else {
    // Modificar el item
        $query_upditemsiccarrera = "update itemsiccarrera
        set valoritemsiccarrera = '$valoritemsiccarrera', fechamodificacionitemsiccarrera = now()
        where iditemsic = '$iditemsic'
        and codigocarrera = '$codigocarrera'
        and codigoestado like '100'";
        if(isset($_SESSION['sesion_carreraitemsic'])) {
            $query_upditemsiccarrera = "update itemsiccarrera
            set valoritemsiccarrera = '$valoritemsiccarrera', fechamodificacionitemsiccarrera = now()
            where iditemsic = '$iditemsic'
            and codigocarrera = '".$_SESSION['sesion_carreraitemsic']."'
            and codigoestado like '100'";
        }
        //echo "$query_hijos<br>";
        if($upditemsiccarrera = $db->Execute($query_upditemsiccarrera)) {
            $retornar = "actualizado";
        }
        else {
            $retornar = "$query_insitemsiccarrera ".mysql_error();
        }
    }
    return $retornar;
}

function obtenerCodigoDependencia($usuario) {
    global $db;
    $query_dependencia = "SELECT u.codigodependencia,c.nombrecarrera,u.codigodependencia,c.codigocarrera
    FROM usuariodependencia u,carrera c, usuario us
    WHERE us.usuario=u.usuario
    and us.usuario = '$usuario'
    and u.codigodependencia = c.codigocarrera";
    //echo "$query_hijos<br>";
    $dependencia = $db->Execute($query_dependencia);
    $totalRows_dependencia = $dependencia->RecordCount();
    if($totalRows_dependencia != 0) {
        $row_dependencia = $dependencia->FetchRow();
        return $row_dependencia['codigocarrera'];
    }
    else {
        $query_dependencia = "SELECT u.codigofacultad,c.nombrecarrera,u.codigofacultad,c.codigocarrera
        FROM usuariofacultad u,carrera c, usuario us
        WHERE us.usuario=u.usuario
        and us.usuario = '$usuario'
        and u.codigofacultad = c.codigocarrera";
        //echo "$query_hijos<br>";
        $dependencia = $db->Execute($query_dependencia);
        $totalRows_dependencia = $dependencia->RecordCount();
        if($totalRows_dependencia != 0) {
            $row_dependencia = $dependencia->FetchRow();
            return $row_dependencia['codigocarrera'];
        }
    }
    return false;
}

function obtenerNombreDependencia($codigodependencia) {
    global $db;
    $query_dependencia = "SELECT nombrecarrera
    from carrera c
    WHERE c.codigocarrera='$codigodependencia'";
    //echo "$query_hijos<br>";
    $dependencia = $db->Execute($query_dependencia);
    $totalRows_dependencia = $dependencia->RecordCount();
    if($totalRows_dependencia != 0) {
        $row_dependencia = $dependencia->FetchRow();
        return $row_dependencia['nombrecarrera'];
    }
    return false;
}
//print_r($_SESSION);
/*if(isset($_REQUEST['funcion']))
{
    switch($_REQUEST['funcion'])
    {
        case 'obtenerValoritemsiccarrera' :
            echo obtenerValoritemsiccarrera($_REQUEST['iditemsic']);
        break;
        case 'insertarItemsiccarrera' :
            echo insertarItemsiccarrera($_REQUEST['iditemsic']);
        break;
    }
}*/

function filtroDependencia() {
    global $db;
    $query_dependencia = "SELECT codigomodalidadacademica, nombremodalidadacademica
    FROM modalidadacademica m ";
    //echo "$query_hijos<br>";
    $dependencia = $db->Execute($query_dependencia);
    $totalRows_dependencia = $dependencia->RecordCount();
    //if($totalRows_dependencia != 0) {
    $row_dependencia = $dependencia->FetchRow();
    ?>
<form method="post" action="" name="fsel">
    <table border="0" align="center">
        <tr>
            <td>Dependencia:</td>
            <td><select name="codigodependencia" onchange="document.fsel.submit()">
                    <option value="" selected>Seleccionar</option>
                        <?php
                        do {
                            $selected = "";
                            if($row_dependencia['codigomodalidadacademica'] == $_REQUEST['codigodependencia'])
                                $selected = "selected";
                            ?>
                    <option value="<?php echo $row_dependencia['codigomodalidadacademica']; ?>" <?php echo $selected; ?>>
                                <?php echo substr($row_dependencia['nombremodalidadacademica'], 0, 30); ?>
                    </option>
                        <?php
                        }
                        while($row_dependencia = $dependencia->FetchRow());
                        ?>
                </select>
            </td>
        </tr>
            <?php
            if(isset($_REQUEST['codigodependencia'])) {
                $filtro = "";
                if(!preg_match('/^5.+$/',$_REQUEST['codigodependencia'])) {
                    $filtro = "and date(now()) between c.fechainiciocarrera and c.fechavencimientocarrera";
                }
                $query_carrera = "SELECT c.codigocarrera, c.nombrecarrera
    FROM carrera c
    where c.codigomodalidadacademica = '".$_REQUEST['codigodependencia']."'
                    $filtro
    order by 2";
                //echo "$query_hijos<br>";
                $carrera = $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
                if($totalRows_carrera != 0) {
                    $row_carrera = $carrera->FetchRow();
                    ?>
        <tr>
            <td colspan="2"><select name="nacodigocarrera" onchange="document.fsel.submit()">
                    <option value="" selected>Seleccionar</option>
                                <?php
                                do {
                                    $selected = "";
                                    if($row_carrera['codigocarrera'] == $_REQUEST['nacodigocarrera'])
                                        $selected = "selected";
                                    ?>
                    <option value="<?php echo $row_carrera['codigocarrera']; ?>" <?php echo $selected; ?>>
                                        <?php echo substr($row_carrera['nombrecarrera'], 0, 30); ?>
                    </option>
                                <?php
                                }
                                while($row_carrera = $carrera->FetchRow());
                                ?>
                </select>
            </td>
        </tr>
                <?php
                }
                else {
                    ?>
        <tr><td colspan="2">No hay información</td></tr>
                <?php
                }
            }
            ?>
    </table>
</form>
<?php
}

function obtenerPermisoItem($codigocarrera) {
    global $db;
    $query = "select iditemsic
    from permisoitemsicdependencia
    where codigocarrera = '$codigocarrera'
    and codigoestado like '1%'";
    //echo "$query_hijos<br>";
    $rta = $db->Execute($query);
    $totalRows_rta = $rta->RecordCount();
    //if($totalRows_dependencia != 0) {
    $iditemsic = "";
    while($row_rta = $rta->FetchRow()) {
        $iditemsic .= $row_rta['iditemsic'].",";
    }
    return preg_replace('/,$/','',$iditemsic);
}
?>
