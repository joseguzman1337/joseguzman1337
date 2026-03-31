<?php
class itemsiccarreraadjunto
{ 

        // Variables 
        var $iditemsiccarreraadjunto;
        var $iditemsiccarrera;
        var $nombreitemsiccarreraadjunto;
        var $fechacreacionitemsiccarreraadjunto;
        var $fechaeliminacionitemsiccarreraadjunto;
        var $codigoestado;


        /**
        * @return returns value of variable $iditemsiccarreraadjunto
        * @desc getIditemsiccarreraadjunto : Getting value for variable $iditemsiccarreraadjunto
        */
        function getIditemsiccarreraadjunto()
        {
                return $this->iditemsiccarreraadjunto;
        }

        /**
        * @param param : value to be saved in variable $iditemsiccarreraadjunto
        * @desc setIditemsiccarreraadjunto : Setting value for $iditemsiccarreraadjunto
        */
        function setIditemsiccarreraadjunto($value)
        {
                $this->iditemsiccarreraadjunto = $value;
        }

        /**
        * @return returns value of variable $iditemsiccarrera
        * @desc getIditemsiccarrera : Getting value for variable $iditemsiccarrera
        */
        function getIditemsiccarrera()
        {
                return $this->iditemsiccarrera;
        }

        /**
        * @param param : value to be saved in variable $iditemsiccarrera
        * @desc setIditemsiccarrera : Setting value for $iditemsiccarrera
        */
        function setIditemsiccarrera($value)
        {
                $this->iditemsiccarrera = $value;
        }

        /**
        * @return returns value of variable $nombreitemsiccarreraadjunto
        * @desc getNombreitemsiccarreraadjunto : Getting value for variable $nombreitemsiccarreraadjunto
        */
        function getNombreitemsiccarreraadjunto()
        {
                return $this->nombreitemsiccarreraadjunto;
        }

        /**
        * @param param : value to be saved in variable $nombreitemsiccarreraadjunto
        * @desc setNombreitemsiccarreraadjunto : Setting value for $nombreitemsiccarreraadjunto
        */
        function setNombreitemsiccarreraadjunto($value)
        {
                $this->nombreitemsiccarreraadjunto = $value;
        }

        /**
        * @return returns value of variable $fechacreacionitemsiccarreraadjunto
        * @desc getFechacreacionitemsiccarreraadjunto : Getting value for variable $fechacreacionitemsiccarreraadjunto
        */
        function getFechacreacionitemsiccarreraadjunto()
        {
                return $this->fechacreacionitemsiccarreraadjunto;
        }

        /**
        * @param param : value to be saved in variable $fechacreacionitemsiccarreraadjunto
        * @desc setFechacreacionitemsiccarreraadjunto : Setting value for $fechacreacionitemsiccarreraadjunto
        */
        function setFechacreacionitemsiccarreraadjunto($value)
        {
                $this->fechacreacionitemsiccarreraadjunto = $value;
        }

        /**
        * @return returns value of variable $fechaeliminacionitemsiccarreraadjunto
        * @desc getFechaeliminacionitemsiccarreraadjunto : Getting value for variable $fechaeliminacionitemsiccarreraadjunto
        */
        function getFechaeliminacionitemsiccarreraadjunto()
        {
                return $this->fechaeliminacionitemsiccarreraadjunto;
        }

        /**
        * @param param : value to be saved in variable $fechaeliminacionitemsiccarreraadjunto
        * @desc setFechaeliminacionitemsiccarreraadjunto : Setting value for $fechaeliminacionitemsiccarreraadjunto
        */
        function setFechaeliminacionitemsiccarreraadjunto($value)
        {
                $this->fechaeliminacionitemsiccarreraadjunto = $value;
        }

        /**
        * @return returns value of variable $codigoestado
        * @desc getCodigoestado : Getting value for variable $codigoestado
        */
        function getCodigoestado()
        {
                return $this->codigoestado;
        }

        /**
        * @param param : value to be saved in variable $codigoestado
        * @desc setCodigoestado : Setting value for $codigoestado
        */
        function setCodigoestado($value)
        {
                $this->codigoestado = $value;
        }

        // This is the constructor for this class
        // Initialize all your default variables here
        function itemsiccarreraadjunto($iditemsiccarreraadjunto)
        {
                global $db;
                $query = "SELECT iditemsiccarreraadjunto, iditemsiccarrera, nombreitemsiccarreraadjunto, fechacreacionitemsiccarreraadjunto, fechaeliminacionitemsiccarreraadjunto, codigoestado
                FROM itemsiccarreraadjunto
                WHERE iditemsiccarreraadjunto = '$iditemsiccarreraadjunto'
                and codigoestado like '100'";
                $rta = $db->Execute($query);
                $totalRows_rta = $rta->RecordCount();
                if($totalRows_rta != 0)
                {
                    $row = $rta->FetchRow();
                    $this->iditemsiccarreraadjunto = $row['iditemsiccarreraadjunto'];
                    $this->iditemsiccarrera = $row['iditemsiccarrera'];
                    $this->nombreitemsiccarreraadjunto = $row['nombreitemsiccarreraadjunto'];
                    $this->fechacreacionitemsiccarreraadjunto = $row['fechacreacionitemsiccarreraadjunto'];
                    $this->fechaeliminacionitemsiccarreraadjunto = $row['fechaeliminacionitemsiccarreraadjunto'];
                    $this->codigoestado = $row['codigoestado'];
                }
        }

        function existeItemsiccarreraadjunto()
        {
            if($this->iditemsiccarreraadjunto != "")
            {
                return true;
            }
            return false;
        }

        function insertarItemsiccarreraadjunto($iditemsiccarrera, $nombreitemsiccarreraadjunto)
        {
            global $db, $codigocarrera;
            $retornar = false;
            //$valoritemsiccarrera = utf8_decode($_REQUEST['valoritemsiccarrera']);
            // Insertar el item
            $query_ins = "INSERT INTO itemsiccarreraadjunto (iditemsiccarreraadjunto,iditemsiccarrera, nombreitemsiccarreraadjunto, fechacreacionitemsiccarreraadjunto, fechaeliminacionitemsiccarreraadjunto, codigoestado)
            VALUES (0, '$iditemsiccarrera', '$nombreitemsiccarreraadjunto', now(), '2999-12-31', '100')";
            //echo "$query_hijos<br>";
            if($ins = $db->Execute($query_ins))
            {
                $this->iditemsiccarreraadjunto = $db->Insert_ID();
                $this->itemsiccarreraadjunto($this->iditemsiccarreraadjunto);
                $retornar = true;
            }
            else
            {
                $retornar = false;
            }
            return $retornar;
        }

        function eliminarItemsiccarreraadjunto()
        {
            global $db, $codigocarrera;
            $retornar = false;
            $query_del = "update itemsiccarreraadjunto
            SET fechaeliminacionitemsiccarreraadjunto = now(), codigoestado = '200'
            WHERE iditemsiccarreraadjunto = '$this->iditemsiccarreraadjunto'";
            //echo "$query_hijos<br>";
            if($del = $db->Execute($query_del))
            {
                $retornar = true;
            }
            else
            {
                $retornar = false;
            }
            return $retornar;
        }
}
?>