<?php
require_once($rutaPHP."itemSic.php");
require_once($rutaPHP."itemSicCarrera.php");
class textogeneral extends itemsic
{
    function obtenerItemSicCarrera()
    {
        global $db, $codigocarrera;
        $query_itemsiccarrera = "select ic.iditemsiccarrera, ic.iditemsic, ic.codigocarrera, ic.valoritemsiccarrera, ic.codigoestadoitemsiccarrera, ic.fechacreacionitemsiccarrera, ic.fechamodificacionitemsiccarrera, ic.fechahastaitemsiccarrera, ic.codigoestado
        from itemsiccarrera ic
        where ic.iditemsic = '$this->iditemsic'
        and ic.codigocarrera = '$codigocarrera'
        and ic.codigoestado like '100'";
        if(isset($_SESSION['sesion_carreraitemsic'])) {
            $query_itemsiccarrera = "select ic.iditemsiccarrera, ic.iditemsic, ic.codigocarrera, ic.valoritemsiccarrera, ic.codigoestadoitemsiccarrera, ic.fechacreacionitemsiccarrera, ic.fechamodificacionitemsiccarrera, ic.fechahastaitemsiccarrera, ic.codigoestado
            from itemsiccarrera ic
            where ic.iditemsic = '$this->iditemsic'
            and ic.codigocarrera = '".$_SESSION['sesion_carreraitemsic']."'
            and ic.codigoestado like '100'";
        }
        //echo "$query_itemsiccarrera<br>";
        $itemsiccarrera = $db->Execute($query_itemsiccarrera);
        $totalRows_itemsiccarrera = $itemsiccarrera->RecordCount();
        if($totalRows_itemsiccarrera != 0)
        {
            $row_itemsiccarrera = $itemsiccarrera->FetchRow();
        }
        return $row_itemsiccarrera;
    }

    function obtenerItemSicCarreraAdjuntos()
    {
        global $db, $codigocarrera;
        $query_itemsiccarrera = "SELECT ica.iditemsiccarreraadjunto, ica.iditemsiccarrera, ica.nombreitemsiccarreraadjunto, ica.fechacreacionitemsiccarreraadjunto, ica.fechaeliminacionitemsiccarreraadjunto, ica.codigoestado
        FROM itemsiccarreraadjunto ica, itemsiccarrera ic
        WHERE ic.iditemsic = '$this->iditemsic'
        and ic.codigocarrera = '$codigocarrera'
        and ic.iditemsiccarrera = ica.iditemsiccarrera
        and ic.codigoestado like '100'
        and ica.codigoestado like '100'";
        if(isset($_SESSION['sesion_carreraitemsic'])) {
            $query_itemsiccarrera = "SELECT ica.iditemsiccarreraadjunto, ica.iditemsiccarrera, ica.nombreitemsiccarreraadjunto, ica.fechacreacionitemsiccarreraadjunto, ica.fechaeliminacionitemsiccarreraadjunto, ica.codigoestado
            FROM itemsiccarreraadjunto ica, itemsiccarrera ic
            WHERE ic.iditemsic = '$this->iditemsic'
            and ic.codigocarrera = '".$_SESSION['sesion_carreraitemsic']."'
            and ic.iditemsiccarrera = ica.iditemsiccarrera
            and ic.codigoestado like '100'
            and ica.codigoestado like '100'";
        }
        //echo "$query_itemsiccarrera<br>";
        $itemsiccarrera = $db->Execute($query_itemsiccarrera);
        $totalRows_itemsiccarrera = $itemsiccarrera->RecordCount();
        if($totalRows_itemsiccarrera != 0)
        {
            while($row_itemsiccarrera = $itemsiccarrera->FetchRow())
            {
                $adjuntos[] = $row_itemsiccarrera;
            }
        }
        return $adjuntos;
    }

    function existeItemsiccarrera()
    {
        global $db, $codigocarrera;
        $query_itemsiccarrera = "select ic.iditemsiccarrera
        from itemsiccarrera ic
        where ic.iditemsic = '$this->iditemsic'
        and ic.codigoestado like '100'
        and ic.codigocarrera = '$codigocarrera'";
        //echo "$query_hijos<br>";
	//exit();
       if(isset($_SESSION['sesion_carreraitemsic'])) {
            $query_itemsiccarrera = "select ic.iditemsiccarrera
            from itemsiccarrera ic
            where ic.iditemsic = '$this->iditemsic'
            and ic.codigoestado like '100'
            and ic.codigocarrera = '".$_SESSION['sesion_carreraitemsic']."'";
        }
       $itemsiccarrera = $db->Execute($query_itemsiccarrera);
        $totalRows_itemsiccarrera = $itemsiccarrera->RecordCount();
        if($totalRows_itemsiccarrera != 0)
        {
            return true;
        }
        return false;
    }


    function insertarItemsiccarrera()
    {
        global $db, $codigocarrera;
        //$valoritemsiccarrera = utf8_decode($_REQUEST['valoritemsiccarrera']);
        $valoritemsiccarrera = $_REQUEST['valoritemsiccarrera'];
        //$valoritemsiccarrera = $_REQUEST['valoritemsiccarrera'];
        //echo "Valor $valoritemsiccarrera = ".$_REQUEST['valoritemsiccarrera'];
        //exit();
        $retornar = "No se ejecuto ninguna operacion";
        if(!$this->existeItemsiccarrera())
        {
            // Insertar el item
            $query_insitemsiccarrera = "insert into itemsiccarrera (iditemsiccarrera, iditemsic, codigocarrera, valoritemsiccarrera, codigoestadoitemsiccarrera, fechacreacionitemsiccarrera, fechamodificacionitemsiccarrera, fechahastaitemsiccarrera, codigoperiodoitemsic, codigoestado)
            values (0, $this->iditemsic, '$codigocarrera', '$valoritemsiccarrera', 100, now(), now(), '2999-12-31', '00000', 100)";
            if(isset($_SESSION['sesion_carreraitemsic'])) {
                $query_insitemsiccarrera = "insert into itemsiccarrera (iditemsiccarrera, iditemsic, codigocarrera, valoritemsiccarrera, codigoestadoitemsiccarrera, fechacreacionitemsiccarrera, fechamodificacionitemsiccarrera, fechahastaitemsiccarrera, codigoperiodoitemsic, codigoestado)
                values (0, $this->iditemsic, '".$_SESSION['sesion_carreraitemsic']."', '$valoritemsiccarrera', 100, now(), now(), '2999-12-31', '00000', 100)";
            }
            //echo "$query_hijos<br>";
            if($insitemsiccarrera = $db->Execute($query_insitemsiccarrera))
            {
                $retornar = "insertado";
            }
            else
            {
                $retornar = "$query_insitemsiccarrera ".mysql_error();
            }
        }
        else
        {
            // Modificar el item
            $query_upditemsiccarrera = "update itemsiccarrera
            set valoritemsiccarrera = '$valoritemsiccarrera', fechamodificacionitemsiccarrera = now(), codigoestadoitemsiccarrera = 100
            where iditemsic = '$this->iditemsic'
            and codigocarrera = '$codigocarrera'
            and codigoestado like '100'";
            if(isset($_SESSION['sesion_carreraitemsic'])) {
                $query_upditemsiccarrera = "update itemsiccarrera
                set valoritemsiccarrera = '$valoritemsiccarrera', fechamodificacionitemsiccarrera = now(), codigoestadoitemsiccarrera = 100
                where iditemsic = '$this->iditemsic'
                and codigocarrera = '".$_SESSION['sesion_carreraitemsic']."'
                and codigoestado like '100'";
            }
            //echo "$query_hijos<br>";
            if($upditemsiccarrera = $db->Execute($query_upditemsiccarrera))
            {
                $retornar = "actualizado";
            }
            else
            {
                $retornar = "$query_insitemsiccarrera ".mysql_error();
            }
        }
        return $retornar;
    }
}
?>