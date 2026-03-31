<?php
require_once($rutaPHP."itemSicCarreraAdjunto.php");
require_once($rutaPHP."itemSicCarrera.php");
require_once($rutaPHP."itemSic.php");
class adjunto extends itemsiccarreraadjunto
{
    var $error = 2;
    var $estatus;
    var $cantidadadjuntados;
    var $cantidadadjuntospermitidos;

    function adjuntarArchivo($iditemsiccarrera)
    {
        global $iditemsic, $codigocarrera;
        $this->error = 0;
        $itemsiccarrera = new itemsiccarrera($iditemsiccarrera);
        $tamano = $_FILES["archivo"]['size'];
        $tipo = $_FILES["archivo"]['type'];
        $archivo = $_FILES["archivo"]['name'];
        $nombrearchivoorigen = $archivo;
        $prefijo = substr(md5(uniqid(rand())),0,6);
        $nombrearchivonuevo = $prefijo."_".$archivo;
        if($archivo != "")
        {
            $destino = "../../../../adjuntos/".$nombrearchivonuevo;
            if((ereg("gif|GIF",$archivo) || ereg("jpg|JPG",$archivo) || ereg("png|PNG",$archivo)
             || ereg("pdf|PDF",$archivo) || ereg("doc|DOC",$archivo)|| ereg("xls|XLS",$archivo)) && ($tamano_archivo < 200000))
            {
                if (copy($_FILES['archivo']['tmp_name'],$destino))
                {
                    $this->estatus = "$nombrearchivoorigen";
                    // Almacena en la base de datos
                    if(!$itemsiccarrera->existeItemsiccarrera())
                    {
                        // Inserta en itemsic carrera
                        $itemsiccarrera->iditemsic = $iditemsic;
                        $itemsiccarrera->codigocarrera = $codigocarrera;
                        if(!$itemsiccarrera->insertarItemsiccarrera($valoritemsiccarrera, '00000'))
                        {
                            $this->estatus = "Error: No se pudo almacenar en la base de datos<br> ".mysql_error();
                            //print_r($itemsiccarrera);
                            //exit();
                            $this->error = 1;
                        }
                    }
                    if(!$this->insertarItemsiccarreraadjunto($itemsiccarrera->iditemsiccarrera, $nombrearchivonuevo))
                    {
                        $this->estatus = "Error: No se pudo almacenar en la base de datos<br> ".mysql_error();
                        $this->error = 1;
                    }
                }
                else
                {
                    $this->estatus = "ERROR: No se pudo subir el archivo, revisar permisos de escritura";
                    $this->error = 1;
                }
            }
            else
            {
                $this->estatus = "ERROR: No se pudo subir archivo, revisar que la extensión del archivo sea jpg, png o gif";
                $this->error = 1;
            }
        }
        else
        {
            $this->status = "Error al subir archivo";
            $this->error = 1;
        }
        $iditemsiccarrera = $itemsiccarrera->iditemsiccarrera;
    }

    function eliminarArchivo()
    {
        $retornar = false;
        $archivo = "../../../../adjuntos/".$this->nombreitemsiccarreraadjunto;
        exec("rm $archivo");
        if($this->eliminarItemsiccarreraadjunto())
        {
            $retornar = true;
        }
        return $retornar;
    }

    function setCantidadadjuntados($iditemsiccarrera)
    {
        global $db;
        $query_adjuntos = "select i.iditemsiccarrera
        from itemsiccarreraadjunto i
        where i.iditemsiccarrera = '$iditemsiccarrera'
        and i.codigoestado like '100'";
        //echo "$query_itemsiccarrera<br>";
        $rta_adjuntos = $db->Execute($query_adjuntos);
        $this->cantidadadjuntados = $rta_adjuntos->RecordCount();
    }

    function setCantidadadjuntospermitidos($iditemsic)
    {
        //global $db;
        //$db->debug = true;
        $itemsic = new itemsic($iditemsic);
        $this->cantidadadjuntospermitidos = $itemsic->cantidadadjuntositemsic;
    }

    function puedeAdjuntar($iditemsic, $iditemsiccarrera)
    {
        global $db, $codigocarrera;
        $retorno = false;

        $this->setCantidadadjuntospermitidos($iditemsic);
        $this->setCantidadadjuntados($iditemsiccarrera);

        if($this->cantidadadjuntospermitidos > $this->cantidadadjuntados)
            $retorno = true;
        return $retorno;
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
        and ica.codigoestado";
        if(isset($_SESSION['sesion_carreraitemsic'])) {
            $query_itemsiccarrera = "SELECT ica.iditemsiccarreraadjunto, ica.iditemsiccarrera, ica.nombreitemsiccarreraadjunto, ica.fechacreacionitemsiccarreraadjunto, ica.fechaeliminacionitemsiccarreraadjunto, ica.codigoestado
            FROM itemsiccarreraadjunto ica, itemsiccarrera ic
            WHERE ic.iditemsic = '$this->iditemsic'
            and ic.codigocarrera = '".$_SESSION['sesion_carreraitemsic']."'
            and ic.iditemsiccarrera = ica.iditemsiccarrera
            and ic.codigoestado like '100'
            and ica.codigoestado";
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
        global $db;
        $query_itemsiccarrera = "select ic.iditemsiccarrera
        from itemsiccarrera ic
        where ic.iditemsic = '$this->iditemsic'
        and ic.codigoestado like '100'";
        //echo "$query_hijos<br>";
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
            set valoritemsiccarrera = '$valoritemsiccarrera', fechamodificacionitemsiccarrera = now()
            where iditemsic = '$this->iditemsic'
            and codigocarrera = '$codigocarrera'
            and codigoestado like '100'";
            if(isset($_SESSION['sesion_carreraitemsic'])) {
                $query_upditemsiccarrera = "update itemsiccarrera
                set valoritemsiccarrera = '$valoritemsiccarrera', fechamodificacionitemsiccarrera = now()
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